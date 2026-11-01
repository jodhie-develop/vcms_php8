<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
ob_start(); // tampung dulu semua output (termasuk dari atas.php) supaya header()
            // untuk export Excel di bawah tetap bisa dikirim tanpa error
            // "headers already sent" -- pola sama seperti vip_rpt_payment_detail.php.
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";

/* ============================================================
   MONTHLY OPEN CLASS PAYMENT DETAIL REPORT (vip_rpt_open_cl.php) — v1
   Format mengikuti sheet "Open Cls" di file Monthly_VE_-_[Bulan]_-
   -_[Tahun].xls (daftar kelas & siswa yg jalan bulan ybs, lengkap
   dgn fee & status pembayaran per siswa, dikelompokkan per kelas).

   SUMBER DATA:
     vip_billing          -> 1 baris per siswa per kelas: kd_biodata,
                              kd_branch, kd_program, kd_class, tf,
                              discount, net_tf, material_cost, sc,
                              dt_entry.
     vip_billing_payment   -> transaksi pembayaran per kd_billing:
                              jns_payment, amount, status.
     vip_student_data      -> nama siswa (nama_lengkap) via kd_biodata.
     vip_mst_code_prg      -> nama program (nm_program) & type_program
                              via kd_program.
     vip_teacher_schedule  -> jadwal kelas (kelas = vip_billing.kd_class):
                              mulai_tm (start) & selesai_tm (end),
                              dipakai utk Start Prog / End Prog / Day.

   KEPUTUSAN FORMAT (hasil diskusi dgn user, REV atas
   vip_rpt_payment_detail.php):
     - School / Institution & Grd (kelas sekolah siswa) -- TIDAK ada
       sumbernya di DB, dikosongkan ("-") sesuai instruksi user.
     - Start Prog. / End Prog diambil dari MIN/MAX
       vip_teacher_schedule.mulai_tm / selesai_tm per kd_class
       (vip_teacher_schedule.kelas = vip_billing.kd_class).
     - Day (hari kelas, mis. "Monday, Wednesday") diambil dari
       DAYNAME(vip_teacher_schedule.mulai_tm), DISTINCT per kd_class,
       digabung GROUP_CONCAT, diurutkan alfabetis (cocok dgn pola di
       contoh Excel asli).
     - Disc. Promo & Rmk -- TIDAK ada sumbernya, dikosongkan ("-").
     - Prog. Fee     = vip_billing.tf
     - Fix Tuition Fee = vip_billing.net_tf
     - Reg. Fee      = SUM vip_billing_payment.amount WHERE
                       jns_payment = 'Registration' AND status='PAID',
                       per kd_billing siswa ybs.
     - Student Paid  = SUM vip_billing_payment.amount WHERE
                       jns_payment IN ('Down Payment','Installment 1',
                       'Installment 2','Installment 3','Full Payment')
                       AND status='PAID', per kd_billing siswa ybs.
     - Student Outstd. = Fix Tuition Fee - Student Paid (dihitung di
                       PHP, bukan dari kolom DB).
     - Kategori kelas (dipakai di ringkasan bawah "Private / Semi-
       private / Reguler"):
         * vip_mst_code_prg.type_program diawali 'Pri'  -> kandidat
           Private / Semi-private.
         * Di antara kandidat itu, kalau nm_program mengandung kata
           "Semi" -> masuk "Semi-private", selain itu -> "Private".
         * type_program TIDAK diawali 'Pri' -> "Reguler".
         (CATATAN: aturan pemisah Private vs Semi-private ini adalah
         ASUMSI tambahan dari saya berdasar pola penamaan program di
         contoh data -- user cuma konfirmasi aturan Private/Reguler
         berdasar type_program. Kalau hasil hitung Semi-private di
         laporan meleset, ini bagian yg perlu dicek ulang / mungkin
         perlu kolom/aturan lain dari user.)
     - PERFORMA: Start/End/Day (vip_teacher_schedule) dan Reg. Fee /
       Student Paid (vip_billing_payment) dihitung lewat derived table
       + LEFT JOIN (dihitung sekali), BUKAN subquery yg diulang per
       baris siswa. Query sudah cukup baik (GROUP BY di derived table
       dipasang di kolom UNIK -- kelas & kd_billing -- jadi tidak ada
       risiko fanout kayak vip_rpt_payment_detail.php versi awal).
       REV (perbaikan lambat, dilaporkan user): dulu derived table
       `pay` & `cls` agregasi SELURUH isi vip_billing_payment /
       vip_teacher_schedule (tidak difilter periode) -- kalau tabel
       itu sudah berisi data bertahun-tahun, tiap buka report DB tetap
       proses semua histori lama meski cuma sebagian kecil (kelas di
       1 periode) yg kepakai.
       REV v2 (user lapor MASIH lambat stlh REV v1): perbaikan REV v1
       nulis subquery period-filter sbg TEKS SQL yg diulang 3x dlm 1
       query (WHERE utama + `cls` + `pay`) -- tanpa index yg pas, DB
       bisa jalanin subquery yg sama itu 3x TERPISAH, jadi malah lebih
       berat drpd sebelumnya. FIX: subquery period-filter SEKARANG
       dijalanin SEKALI SAJA lewat query kecil tersendiri di PHP
       ($query_kelas_periode), hasilnya (daftar kd_class) ditampung
       jadi literal list ($kelas_in_sql) & dipakai ulang di WHERE
       utama + `cls` + `pay` -- jadi cuma equality lookup IN(...) yg
       murah, agregasi MIN(mulai_tm)-nya sendiri cuma dihitung 1x.
       Index di bawah ini TETAP disarankan supaya query kecil
       $query_kelas_periode itu sendiri juga cepat (index-only scan):
         ALTER TABLE vip_teacher_schedule
           ADD INDEX idx_kelas_status_cover (kelas, status_kelas, mulai_tm, selesai_tm);
         ALTER TABLE vip_billing_payment
           ADD INDEX idx_kdbilling_cover (kd_billing, jns_payment, status, amount);
         ALTER TABLE vip_billing
           ADD INDEX idx_kdclass (kd_class),
           ADD INDEX idx_kdbiodata (kd_biodata),
           ADD INDEX idx_kdprogram (kd_program),
           ADD INDEX idx_kdbranch (kd_branch);
       (Jalankan lewat DBA/phpMyAdmin -- saya tidak punya akses DB dari
       sini. Cek "EXPLAIN <query>" sebelum & sesudah utk lihat bedanya,
       terutama kolom "Extra": kalau masih ada "Using temporary" atau
       "Using filesort" yg besar, index di atas belum kepakai optimal.)
     - Grouping tampilan: data diurutkan per kd_class (Std. Cls), lalu
       per nama siswa. Kolom yg sifatnya per-KELAS (Std. Cls, Start
       Prog., End Prog, Day) cuma ditampilkan sekali per kelas pakai
       rowspan; kolom yg sifatnya per-SISWA (Name, Prog., Prog. Fee,
       Disc.%, Fix Tuition Fee, Reg. Fee, Material Fee, Student Paid,
       Student Outstd., SC) tetap tampil tiap baris. Tiap kelas
       ditutup baris SUBTOTAL (jumlah Prog Fee/Fix Tuition/Reg Fee/
       Material Fee/Student Paid/Student Outstd. utk kelas itu), lalu
       di paling bawah tabel ada baris TOTAL utk semua kelas.
     - "Ttl. Std" = nomor urut siswa berjalan (1, 2, 3, ... utk semua
       baris siswa se-laporan, BUKAN nomor per kelas).
     - Section Summary bawah tabel (ikut dibuat sesuai instruksi):
         * Private / Semi-private / Reguler -> jumlah SISWA (baris
           vip_billing) per kategori (lihat catatan kategori di atas).
         * Total Program Fee / Total Fix Tuition Fee / Total
           Registration / Total Material Fee -> SUM dari kolom yg
           bersangkutan, seluruh laporan.
         * Grand Total INCOME by Open Class -> disamakan dgn Total
           Fix Tuition Fee (nilai "income" yg jadi komitmen billing,
           BUKAN uang yg sudah masuk / Student Paid) -- ini cocok dgn
           pola di contoh Excel asli (row "Grand Total INCOME" =
           sama dgn "Total Fix Tuition Fee").
         * Monthly Student Average, Total Additional Students, Total
           Added Programs (LC), Total Cancelation Students, Reguler/
           Private Class Average -- TIDAK ADA sumber datanya di ERD
           yg dikasih user, jadi ditampilkan "-" dulu (TODO: perlu
           konfirmasi tabel/kolom sumbernya kalau field2 ini mau
           diisi beneran).
     - Filter periode (REV): pakai tanggal MULAI kelas -- MIN
       vip_teacher_schedule.mulai_tm per kd_class, HANYA dari sesi yg
       status_kelas = 1 (aktif), BETWEEN Start & To. Kelas yg sesi
       pertama-aktifnya jatuh di luar periode TIDAK ikut tampil, tapi
       kalau kelasnya masuk, SEMUA siswa di kelas itu ikut tampil
       (filter dipasang di level kd_class, bukan per baris siswa).
       Subquery Start Prog/End Prog/Day juga ikut disaring
       status_kelas = 1 spy konsisten dgn kelas yg dianggap "aktif".
     - Filter Branch & Program (VIP English / Fellows Academy / CA)
       sama persis logikanya dgn vip_rpt_payment_detail.php.
     - Export Excel: pola sama dgn vip_rpt_payment_detail.php (header
       application/vnd.ms-excel, satu loop dipakai bareng utk layar &
       export). Kolom Amount pakai helper td_amount() yg SUDAH include
       fix "300.000 jadi 300" (mso-number-format), jadi tidak perlu
       diperbaiki lagi di sini.

   WAJIB SESUAIKAN include path (conndb.php/profiledata.php/atas.php),
   nama tabel & nama kolom (terutama mulai_tm/selesai_tm/status) kalau
   berbeda dari project asli.
   ============================================================ */

$hari  = date("d");
$bulan = date("m");
$tahun = date("Y");
$hari_ini = "$tahun-$bulan-$hari";

// ---- Daftar bulan Indonesia (utk format tanggal & label periode) ----
$BULAN_INDO = array(
	1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
	5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
	9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
);

function format_tgl_indo($tgl_mysql, $BULAN_INDO) {
	// $tgl_mysql format 'YYYY-MM-DD' (atau datetime) -> "5 Juli 2026"
	if (!$tgl_mysql || $tgl_mysql == '0000-00-00' || $tgl_mysql == '0000-00-00 00:00:00') return '-';
	$ts = strtotime($tgl_mysql);
	if (!$ts) return '-';
	$d = (int) date('j', $ts);
	$m = (int) date('n', $ts);
	$y = date('Y', $ts);
	return $d . ' ' . $BULAN_INDO[$m] . ' ' . $y;
}

function format_periode_label($tgl_start, $tgl_end, $BULAN_INDO) {
	// "1 Juli 2026 - 31 Juli 2026" -- dipakai di judul laporan
	return format_tgl_indo($tgl_start, $BULAN_INDO) . ' s/d ' . format_tgl_indo($tgl_end, $BULAN_INDO);
}

// ---- FIX export Excel (dibawa dari vip_rpt_payment_detail.php) ----
// Cell angka di mode export ditulis MENTAH (tanpa titik ribuan) + style
// mso-number-format supaya Excel yg urus format tampilan, bukan text
// parsing Excel sendiri (yg bikin "300.000" salah kebaca jadi "300").
function td_amount($val, $st_style, $export_mode) {
	$val = (float) $val;
	if ($export_mode) {
		echo '<td style="' . e($st_style) . 'mso-number-format:\'#,##0\';">' . number_format(num($val), 0, '', '') . '</td>';
	} else {
		echo '<td style="' . e($st_style) . '">' . number_format(num($val), 0, ',', '.') . '</td>';
	}
}

// ---- Klasifikasi kategori kelas: Private / Semi-private / Reguler ----
// Lihat catatan "KEPUTUSAN FORMAT" di atas soal asumsi Semi-private.
function klasifikasi_kelas($type_program, $nm_program) {
	$is_pri = (stripos((string) $type_program, 'Pri') === 0);
	if (!$is_pri) return 'Reguler';
	if (stripos((string) $nm_program, 'Semi') !== false) return 'Semi-private';
	return 'Private';
}

// ---- Daftar cabang -- TIDAK ada tabel referensi branch di DB, mapping manual ----
// (sama persis dgn vip_rpt_payment_detail.php)
$BRANCH_LIST = array(
	1  => 'East Sby',
	2  => 'West Sby',
	3  => 'Denpasar',
	4  => 'South Jkt',
	5  => 'North Jkt',
	6  => 'West Jkt',
	7  => 'Bandung',
	8  => 'Malang',
	11 => 'PIK',
	16 => 'Tangerang',
);

$PROGRAM_CATEGORY_LIST = array('All', 'VIP English', 'Fellows Academy', 'CA');

// ---- Inline style (dipakai di layar MAUPUN export, spy warna konsisten) ----
$FONT_BASE   = "font-family:Calibri,Arial,sans-serif;font-size:11px;";
$ST_TH       = "border:1px solid #999;padding:3px 5px;text-align:center;background:#4F81BD;color:#fff;$FONT_BASE";
$ST_TD       = "border:1px solid #999;padding:3px 5px;text-align:center;$FONT_BASE";
$ST_TD_LEFT  = "border:1px solid #999;padding:3px 5px;text-align:left;$FONT_BASE";
$ST_SUB      = "border:1px solid #999;padding:3px 5px;text-align:center;font-weight:bold;background:#eef3f8;$FONT_BASE";
$ST_SUB_LEFT = "border:1px solid #999;padding:3px 5px;text-align:left;font-weight:bold;background:#eef3f8;$FONT_BASE";
$ST_TOTAL      = "border:1px solid #999;padding:3px 5px;text-align:center;font-weight:bold;background:#dce6f1;$FONT_BASE";
$ST_TOTAL_LEFT = "border:1px solid #999;padding:3px 5px;text-align:left;font-weight:bold;background:#dce6f1;$FONT_BASE";

// ---- Ambil parameter filter (sama persis dgn vip_rpt_payment_detail.php) ----
$branch_filter  = isset($_GET['branch_filter']) ? in_val('branch_filter', 'get') : 'All';
$program_filter = isset($_GET['program_filter']) ? in_val('program_filter', 'get') : 'All';

// Default range: awal bulan berjalan s/d hari ini (kalau belum ada filter di GET)
$default_start = sprintf('%04d-%02d-01', $tahun, $bulan);
$default_end   = $hari_ini;

$tgl_start_filter = isset($_GET['tgl_start']) && in_val('tgl_start', 'get') != '' ? in_val('tgl_start', 'get') : $default_start;
$tgl_end_filter   = isset($_GET['tgl_end']) && in_val('tgl_end', 'get') != '' ? in_val('tgl_end', 'get') : $default_end;

// Validasi format tanggal (harus YYYY-MM-DD) -- kalau input rusak/kosong, fallback ke default
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl_start_filter)) $tgl_start_filter = $default_start;
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl_end_filter))   $tgl_end_filter   = $default_end;

$periode_start = $tgl_start_filter;
$periode_end   = $tgl_end_filter;

// ---- WHERE clause utama (dipakai di query data) ----
// Filter periode = tanggal MULAI kelas (MIN mulai_tm) dari sesi jadwal
// yg statusnya aktif (status_kelas = 1), per kd_class. Jadi 1 kelas
// dianggap "masuk periode X" kalau sesi pertamanya (yg aktif) jatuh di
// antara Start & To. SEMUA siswa di kelas itu ikut tampil (bukan
// di-filter per siswa) -- makanya filternya di level kd_class.
//
// PERF FIX v2 (dilaporkan user masih lambat stlh v1): versi SEBELUMNYA
// nulis subquery period-filter ini sbg TEKS SQL yg diulang 3x di dalam
// 1 query besar (WHERE utama + derived table `cls` + derived table
// `pay`) -- MySQL (apalagi versi lama tanpa index yg pas) bisa jalanin
// subquery yg sama itu 3x TERPISAH, jadi malah 3x lebih berat drpd
// sebelum ada period-filter di `cls`/`pay` sama sekali.
// FIX: subquery ini dijalanin SEKALI SAJA lewat query kecil tersendiri
// di PHP, hasilnya (daftar kd_class yg masuk periode) ditampung di
// array lalu ditulis ULANG sbg LITERAL list ('KODE1','KODE2',...) di
// query utama -- jadi query utama tinggal cocokin IN(...) ke daftar
// yg SUDAH jadi (equality lookup, murah), bukan hitung ulang agregasi
// MIN(mulai_tm) tiap kali dipakai.
$query_kelas_periode = q_set($__p_query_kelas_periode, "SELECT ts.kelas FROM vip_teacher_schedule ts\r
\tWHERE ts.status_kelas = 1\r
\tGROUP BY ts.kelas\r
\tHAVING MIN(ts.mulai_tm) BETWEEN ? AND ? ", [(string) ($periode_start), (string) ($periode_end)]);
$result_kelas_periode = db_query_or_die("Wah error nih query kelas periode: " . '', $query_kelas_periode, $__p_query_kelas_periode ?? []);

$kelas_list = array();
while ($rk = db_fetch($result_kelas_periode, PDO::FETCH_ASSOC)) {
	$kelas_list[] = "'" . $rk['kelas'] . "'";
}
// Kalau tidak ada kelas yg masuk periode ini, pakai placeholder yg
// dijamin tidak pernah cocok dgn kd_class asli manapun -- supaya
// "IN (...)" tetap SQL valid (IN kosong "()" itu error) dan hasilnya
// tetap kosong sesuai harapan (bukan malah nampilin semua data).
$kelas_in_sql = !empty($kelas_list) ? q_set($__p_kelas_in_sql, implode(',', $kelas_list)) : q_set($__p_kelas_in_sql, "'__NO_MATCH__'");

$where = q_set($__p_where, "b.kd_class IN (" . $kelas_in_sql . ")", [...($__p_kelas_in_sql ?? [])]);


if ($branch_filter != '' && $branch_filter != 'All') {
	$branch_sql = $branch_filter;
	$where .= q_add($__p_where, " AND b.kd_branch = ? ", [(string) ($branch_sql)]);
}

if ($program_filter == 'Fellows Academy') {
	$where .= q_add($__p_where, " AND b.kd_program LIKE 'FA-%'");
} else if ($program_filter == 'CA') {
	$where .= q_add($__p_where, " AND (b.kd_program LIKE 'CA%' OR prg.type_program = 'CA CoT')");
} else if ($program_filter == 'VIP English') {
	$where .= q_add($__p_where, " AND b.kd_program NOT LIKE 'FA-%'\r
\t\tAND b.kd_program NOT LIKE 'CA%'\r
\t\tAND (prg.type_program IS NULL OR prg.type_program <> 'CA CoT')");
}
// 'All' -> tidak ada filter tambahan

// ---- Mode export HARUS dicek & header() dikirim SEBELUM ada output apa pun ----
$export_mode = isset($_GET['export']) && in_val('export', 'get') == 'xls';
if ($export_mode) {
	if (ob_get_level()) {
		ob_end_clean();
	}
	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=Open_Class_Report_$hari_ini.xls");
}

// ============================================================
// QUERY DATA -- 1 baris per siswa per kelas (vip_billing).
// PERF: Start/End/Day & Reg.Fee/Student Paid dihitung SEKALI lewat
// derived table (LEFT JOIN), BUKAN subquery per baris siswa spt versi
// sebelumnya (yg tiap baris jalanin 5 subquery -- kalau siswanya
// ratusan, jadi ribuan query kecil & berat). Dgn JOIN, MySQL cuma
// hitung agregat itu SEKALI lalu tinggal di-lookup, jauh lebih ringan.
// Diurutkan per kd_class dulu (utk grouping tampilan per kelas),
// baru per nama siswa di dalam kelas yg sama.
// ============================================================
$query_data = q_set($__p_query_data, "SELECT\r
\t\tb.no,\r
\t\tb.kd_billing,\r
\t\tb.kd_class,\r
\t\tsd.nama_lengkap,\r
\t\tprg.nm_program,\r
\t\tprg.type_program,\r
\t\tb.tf,\r
\t\tb.discount,\r
\t\tb.net_tf,\r
\t\tb.material_cost,\r
\t\tb.sc,\r
\t\tcls.start_prog,\r
\t\tcls.end_prog,\r
\t\tcls.class_days,\r
\t\tCOALESCE(pay.reg_fee, 0) AS reg_fee,\r
\t\tCOALESCE(pay.student_paid, 0) AS student_paid\r
\tFROM vip_billing b\r
\tINNER JOIN vip_student_data sd ON b.kd_biodata = sd.kd_biodata\r
\tLEFT JOIN vip_mst_code_prg prg ON b.kd_program = prg.kd_program\r
\tLEFT JOIN (\r
\t\tSELECT\r
\t\t\tkelas,\r
\t\t\tMIN(mulai_tm) AS start_prog,\r
\t\t\tMAX(selesai_tm) AS end_prog,\r
\t\t\tGROUP_CONCAT(DISTINCT DAYNAME(mulai_tm) ORDER BY DAYNAME(mulai_tm) ASC SEPARATOR ', ') AS class_days\r
\t\tFROM vip_teacher_schedule\r
\t\tWHERE status_kelas = 1\r
\t\t\tAND kelas IN (" . $kelas_in_sql . ")\r
\t\tGROUP BY kelas\r
\t) cls ON cls.kelas = b.kd_class\r
\tLEFT JOIN (\r
\t\tSELECT\r
\t\t\tkd_billing,\r
\t\t\tSUM(CASE WHEN jns_payment = 'Registration' AND status = 'PAID' THEN amount ELSE 0 END) AS reg_fee,\r
\t\t\tSUM(CASE WHEN jns_payment IN ('Down Payment','Installment 1','Installment 2','Installment 3','Full Payment') AND status = 'PAID' THEN amount ELSE 0 END) AS student_paid\r
\t\tFROM vip_billing_payment\r
\t\tWHERE kd_billing IN (\r
\t\t\tSELECT kd_billing FROM vip_billing WHERE kd_class IN (" . $kelas_in_sql . ")\r
\t\t)\r
\t\tGROUP BY kd_billing\r
\t) pay ON pay.kd_billing = b.kd_billing\r
\tWHERE " . $where . "\r
\tORDER BY b.kd_class ASC, sd.nama_lengkap ASC, b.no ASC", [...($__p_kelas_in_sql ?? []), ...($__p_kelas_in_sql ?? []), ...($__p_where ?? [])]);
$result_data = db_query_or_die("Wah error nih query open class: " . '', $query_data, $__p_query_data ?? []);

// Tampung semua baris dulu (bukan langsung while-loop cetak) supaya bisa
// dihitung dulu jumlah baris per kd_class (utk rowspan) & subtotal per
// kelas SEBELUM baris terakhir kelas itu dicetak.
$rows = array();
while ($r = db_fetch($result_data, PDO::FETCH_ASSOC)) {
	$rows[] = $r;
}

$class_row_count = array();
foreach ($rows as $r) {
	$k = $r['kd_class'];
	$class_row_count[$k] = isset($class_row_count[$k]) ? num($class_row_count[$k]) + 1 : 1;
}

// ---- Hitung ringkasan kategori Private / Semi-private / Reguler & total keuangan ----
$kategori_count = array('Private' => 0, 'Semi-private' => 0, 'Reguler' => 0);
$total_prog_fee = 0;
$total_fix_tuition = 0;
$total_reg_fee = 0;
$total_material_fee = 0;
$total_student_paid = 0;
$total_student_outstd = 0;

foreach ($rows as $r) {
	$kategori = klasifikasi_kelas($r['type_program'], $r['nm_program']);
	$kategori_count[$kategori]++;

	$fix_tuition = (float) $r['net_tf'];
	$paid        = (float) $r['student_paid'];

	$total_prog_fee       = num($total_prog_fee) + num(((float) $r['tf']));
	$total_fix_tuition    = num($total_fix_tuition) + num(($fix_tuition));
	$total_reg_fee        = num($total_reg_fee) + num(((float) $r['reg_fee']));
	$total_material_fee   = num($total_material_fee) + num(((float) $r['material_cost']));
	$total_student_paid   = num($total_student_paid) + num(($paid));
	$total_student_outstd = num($total_student_outstd) + num(((num($fix_tuition) - num($paid))));
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Monthly Open Class Report</title>
<?php if (!$export_mode) { ?>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <style>
	.oc-table { font-family: Calibri, Arial, sans-serif; font-size: 11px; }
	.oc-table th, .oc-table td { border: 1px solid #999; padding: 3px 5px; text-align: center; }
	.oc-table thead th { background: #4F81BD; color: #fff; }
	.oc-table td.text-left { text-align: left; }
	.section-title { font-size: 16px; font-weight: bold; margin: 20px 0 8px 0; }
	.subtotal-row td { font-weight: bold; background: #eef3f8; }
	.total-row td { font-weight: bold; background: #dce6f1; }
	.filter-bar { margin-bottom: 15px; }
	.report-header { text-align: center; margin-bottom: 15px; }
	.report-header h2 { margin: 0; font-size: 20px; }
	.report-header h4 { margin: 0; font-weight: normal; color: #555; }
	.summary-box { max-width: 480px; margin-top: 10px; }
	@media print {
		.filter-bar, .no-print { display: none !important; }
		body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
	}
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="content">
  <div class="box">
    <section class="content-header"><h1>Monthly Open Class Report</h1></section>
    <section class="content">

      <form method="get" class="filter-bar form-inline">
        <label>Branch:</label>
        <select name="branch_filter" class="form-control input-sm">
          <option value="All" <?php echo e(($branch_filter == 'All') ? 'selected' : ''); ?>>All</option>
<?php foreach ($BRANCH_LIST as $kode => $nama) { ?>
          <option value="<?php echo e($kode); ?>" <?php echo e(($branch_filter == $kode) ? 'selected' : ''); ?>><?php echo htmlspecialchars($nama); ?></option>
<?php } ?>
        </select>

        <label style="margin-left:10px;">Program:</label>
        <select name="program_filter" class="form-control input-sm">
<?php foreach ($PROGRAM_CATEGORY_LIST as $pc) { ?>
          <option value="<?php echo htmlspecialchars($pc); ?>" <?php echo e(($program_filter == $pc) ? 'selected' : ''); ?>><?php echo htmlspecialchars($pc); ?></option>
<?php } ?>
        </select>

        <label style="margin-left:10px;">Start:</label>
        <input type="date" name="tgl_start" class="form-control input-sm" value="<?php echo htmlspecialchars($tgl_start_filter); ?>">

        <label style="margin-left:10px;">To:</label>
        <input type="date" name="tgl_end" class="form-control input-sm" value="<?php echo htmlspecialchars($tgl_end_filter); ?>">

        <button type="submit" class="btn btn-primary btn-sm" style="margin-left:10px;">Filter</button>
        <a class="btn btn-default btn-sm" href="?<?php echo htmlspecialchars($_SERVER['QUERY_STRING']); ?>&export=xls" target="_blank">Export to Excel</a>
        <button type="button" class="btn btn-default btn-sm" onclick="window.print();">Print / Save as PDF</button>
      </form>

      <div class="report-header">
        <h2>MONTHLY OPEN CLASS PAYMENT DETAILS</h2>
        <h4><?php echo e(isset($BRANCH_LIST[$branch_filter]) ? htmlspecialchars($BRANCH_LIST[$branch_filter]) : 'All Branch'); ?> &mdash; Period: <?php echo e(format_periode_label($tgl_start_filter, $tgl_end_filter, $BULAN_INDO)); ?></h4>
      </div>

<?php } else { ?>
      <h3>MONTHLY OPEN CLASS PAYMENT DETAILS</h3>
      <h4><?php echo e(isset($BRANCH_LIST[$branch_filter]) ? htmlspecialchars($BRANCH_LIST[$branch_filter]) : 'All Branch'); ?> &mdash; Period: <?php echo e(format_periode_label($tgl_start_filter, $tgl_end_filter, $BULAN_INDO)); ?></h4>
      <br>
<?php } ?>

      <table class="table table-bordered oc-table" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th style="<?php echo e($ST_TH); ?>">Ttl. Std</th>
            <th style="<?php echo e($ST_TH); ?>">Std. Cls</th>
            <th style="<?php echo e($ST_TH); ?>">Name</th>
            <th style="<?php echo e($ST_TH); ?>">Prog.</th>
            <th style="<?php echo e($ST_TH); ?>">Start Prog.</th>
            <th style="<?php echo e($ST_TH); ?>">End Prog</th>
            <th style="<?php echo e($ST_TH); ?>">Day</th>
            <th style="<?php echo e($ST_TH); ?>">School / Institution</th>
            <th style="<?php echo e($ST_TH); ?>">Grd</th>
            <th style="<?php echo e($ST_TH); ?>">Prog. Fee</th>
            <th style="<?php echo e($ST_TH); ?>">Disc. %</th>
            <th style="<?php echo e($ST_TH); ?>">Disc. Promo</th>
            <th style="<?php echo e($ST_TH); ?>">Fix Tuition Fee</th>
            <th style="<?php echo e($ST_TH); ?>">Reg. Fee</th>
            <th style="<?php echo e($ST_TH); ?>">Material Fee</th>
            <th style="<?php echo e($ST_TH); ?>">Student Paid</th>
            <th style="<?php echo e($ST_TH); ?>">Student Outstd.</th>
            <th style="<?php echo e($ST_TH); ?>">Rmk</th>
            <th style="<?php echo e($ST_TH); ?>">SC</th>
          </tr>
        </thead>
        <tbody>
<?php
$ttl_std = 0;
$kelas_sebelumnya = null;

// Akumulator subtotal per kelas -- direset tiap kali ganti kd_class
$sub_prog_fee = 0;
$sub_fix_tuition = 0;
$sub_reg_fee = 0;
$sub_material_fee = 0;
$sub_student_paid = 0;
$sub_student_outstd = 0;

$n = cnt($rows);
for ($i = 0; $i < $n; $i++) {
	$r = $rows[$i];
	$ttl_std++;

	$kelas_baru = ($r['kd_class'] !== $kelas_sebelumnya);

	$fix_tuition = (float) $r['net_tf'];
	$paid        = (float) $r['student_paid'];
	$outstd      = num($fix_tuition) - num($paid);

	$sub_prog_fee       = num($sub_prog_fee) + num(((float) $r['tf']));
	$sub_fix_tuition    = num($sub_fix_tuition) + num(($fix_tuition));
	$sub_reg_fee        = num($sub_reg_fee) + num(((float) $r['reg_fee']));
	$sub_material_fee   = num($sub_material_fee) + num(((float) $r['material_cost']));
	$sub_student_paid   = num($sub_student_paid) + num(($paid));
	$sub_student_outstd = num($sub_student_outstd) + num(($outstd));
?>
          <tr>
            <td style="<?php echo e($ST_TD); ?>"><?php echo e($ttl_std); ?></td>
<?php if ($kelas_baru) {
	$rowspan = $class_row_count[$r['kd_class']];
?>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>" rowspan="<?php echo e($rowspan); ?>"><?php echo htmlspecialchars($r['kd_class']); ?></td>
<?php } ?>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($r['nama_lengkap']); ?></td>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($r['nm_program']); ?></td>
<?php if ($kelas_baru) { ?>
            <td style="<?php echo e($ST_TD); ?>" rowspan="<?php echo e($rowspan); ?>"><?php echo e(format_tgl_indo($r['start_prog'], $BULAN_INDO)); ?></td>
            <td style="<?php echo e($ST_TD); ?>" rowspan="<?php echo e($rowspan); ?>"><?php echo e(format_tgl_indo($r['end_prog'], $BULAN_INDO)); ?></td>
            <td style="<?php echo e($ST_TD); ?>" rowspan="<?php echo e($rowspan); ?>"><?php echo e($r['class_days'] ? htmlspecialchars($r['class_days']) : '-'); ?></td>
<?php } ?>
            <td style="<?php echo e($ST_TD); ?>">-</td>
            <td style="<?php echo e($ST_TD); ?>">-</td>
            <?php td_amount($r['tf'], $ST_TD, $export_mode); ?>
            <td style="<?php echo e($ST_TD); ?>"><?php echo e(($r['discount'] !== null && $r['discount'] !== '') ? round(num(((float) $r['discount'])) * 100) . '%' : '-'); ?></td>
            <td style="<?php echo e($ST_TD); ?>">-</td>
            <?php td_amount($r['net_tf'], $ST_TD, $export_mode); ?>
            <?php td_amount($r['reg_fee'], $ST_TD, $export_mode); ?>
            <?php td_amount($r['material_cost'], $ST_TD, $export_mode); ?>
            <?php td_amount($r['student_paid'], $ST_TD, $export_mode); ?>
            <?php td_amount($outstd, $ST_TD, $export_mode); ?>
            <td style="<?php echo e($ST_TD); ?>">-</td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo e(($r['sc'] !== null && $r['sc'] !== '') ? htmlspecialchars($r['sc']) : '-'); ?></td>
          </tr>
<?php
	$kelas_sebelumnya = $r['kd_class'];

	// Kelas ganti di baris berikutnya (atau ini baris terakhir) -> cetak SUBTOTAL kelas ini
	$kelas_berikutnya_beda = ($i == num($n) - 1) || ($rows[num($i) + 1]['kd_class'] !== $r['kd_class']);
	if ($kelas_berikutnya_beda) {
?>
          <tr class="subtotal-row">
            <td colspan="9" class="text-left" style="<?php echo e($ST_SUB_LEFT); ?>">Subtotal - <?php echo htmlspecialchars($r['kd_class']); ?></td>
            <?php td_amount($sub_prog_fee, $ST_SUB, $export_mode); ?>
            <td style="<?php echo e($ST_SUB); ?>"></td>
            <td style="<?php echo e($ST_SUB); ?>"></td>
            <?php td_amount($sub_fix_tuition, $ST_SUB, $export_mode); ?>
            <?php td_amount($sub_reg_fee, $ST_SUB, $export_mode); ?>
            <?php td_amount($sub_material_fee, $ST_SUB, $export_mode); ?>
            <?php td_amount($sub_student_paid, $ST_SUB, $export_mode); ?>
            <?php td_amount($sub_student_outstd, $ST_SUB, $export_mode); ?>
            <td style="<?php echo e($ST_SUB); ?>"></td>
            <td style="<?php echo e($ST_SUB); ?>"></td>
          </tr>
<?php
		// reset akumulator utk kelas berikutnya
		$sub_prog_fee = 0;
		$sub_fix_tuition = 0;
		$sub_reg_fee = 0;
		$sub_material_fee = 0;
		$sub_student_paid = 0;
		$sub_student_outstd = 0;
	}
} // end for rows
?>
          <tr class="total-row">
            <td colspan="9" class="text-left" style="<?php echo e($ST_TOTAL_LEFT); ?>">TOTAL</td>
            <?php td_amount($total_prog_fee, $ST_TOTAL, $export_mode); ?>
            <td style="<?php echo e($ST_TOTAL); ?>"></td>
            <td style="<?php echo e($ST_TOTAL); ?>"></td>
            <?php td_amount($total_fix_tuition, $ST_TOTAL, $export_mode); ?>
            <?php td_amount($total_reg_fee, $ST_TOTAL, $export_mode); ?>
            <?php td_amount($total_material_fee, $ST_TOTAL, $export_mode); ?>
            <?php td_amount($total_student_paid, $ST_TOTAL, $export_mode); ?>
            <?php td_amount($total_student_outstd, $ST_TOTAL, $export_mode); ?>
            <td style="<?php echo e($ST_TOTAL); ?>"></td>
            <td style="<?php echo e($ST_TOTAL); ?>"></td>
          </tr>
        </tbody>
      </table>

<?php if (!$export_mode) { ?>
      <div class="section-title">Summary</div>
<?php } else { ?>
      <br>
      <h4>Summary</h4>
<?php } ?>

      <table class="table table-bordered oc-table summary-box" cellspacing="0" cellpadding="0">
        <tbody>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Private</td><td style="<?php echo e($ST_TD); ?>"><?php echo e($kategori_count['Private']); ?></td></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Semi-private</td><td style="<?php echo e($ST_TD); ?>"><?php echo e($kategori_count['Semi-private']); ?></td></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Reguler</td><td style="<?php echo e($ST_TD); ?>"><?php echo e($kategori_count['Reguler']); ?></td></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Monthly Student Average</td><td style="<?php echo e($ST_TD); ?>">-</td></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Total Program Fee</td><?php td_amount($total_prog_fee, $ST_TD, $export_mode); ?></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Total Fix Tuition Fee</td><?php td_amount($total_fix_tuition, $ST_TD, $export_mode); ?></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Total Registration</td><?php td_amount($total_reg_fee, $ST_TD, $export_mode); ?></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Material Fee</td><?php td_amount($total_material_fee, $ST_TD, $export_mode); ?></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Total Additional Students</td><td style="<?php echo e($ST_TD); ?>">-</td></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Total Added Programs (LC)</td><td style="<?php echo e($ST_TD); ?>">-</td></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Total Cancelation Students</td><td style="<?php echo e($ST_TD); ?>">-</td></tr>
          <tr class="total-row"><td class="text-left" style="<?php echo e($ST_TOTAL_LEFT); ?>">Grand Total INCOME by Open Class</td><?php td_amount($total_fix_tuition, $ST_TOTAL, $export_mode); ?></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Reguler Class Average (std &amp; Payment)</td><td style="<?php echo e($ST_TD); ?>">-</td></tr>
          <tr><td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>">Private Class Average (std &amp; payment)</td><td style="<?php echo e($ST_TD); ?>">-</td></tr>
        </tbody>
      </table>

<?php if (!$export_mode) { ?>
      <br>
      <table style="border:none;<?php echo e($FONT_BASE); ?>">
        <tr>
          <td style="border:none;padding-right:60px;">Checked By: ________________<br><br>Date: ______________</td>
          <td style="border:none;">Approved By: ________________<br><br>Date: ______________</td>
        </tr>
      </table>
    </section>
  </div>
</div>
</body>
</html>
<?php } ?>