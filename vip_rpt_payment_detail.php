<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
ob_start(); // tampung dulu semua output (termasuk dari atas.php) supaya header()
            // untuk export Excel di bawah tetap bisa dikirim tanpa error
            // "headers already sent" -- pola sama seperti device_invent.php v7.
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";

/* ============================================================
   MONTHLY PAYMENT DETAIL REPORT (payment_detail_report.php) — v1
   Format mengikuti sheet "Payment Detail" di file Monthly_VE_-
   -_[Bulan]_-_[Tahun].xls (satu tabel transaksi pembayaran siswa
   per cabang per bulan).

   SUMBER DATA:
     vip_billing_payment  -> transaksi pembayaran (banyak baris per
                              kd_billing): jns_payment, amount,
                              dt_payment, id_receipt, status.
     vip_billing          -> data billing/kelas per siswa: kd_biodata,
                              kd_branch, kd_program.
     vip_student_data     -> nama siswa (nama_lengkap) via kd_biodata.
     vip_mst_code_prg     -> nama program (nm_program) & type_program
                              via kd_program.

   KEPUTUSAN FORMAT (hasil diskusi dgn user):
     - Program Taken = nm_program (JOIN ke vip_mst_code_prg) -- nama
       kelas/programnya (mis. "IELTS", "NGTOEFL").
     - Payment For   = jns_payment APA ADANYA (Registration, Down
       Payment, Full Payment, Installment) -- TIDAK ada logika
       khusus utk Placement Test dkk, langsung baca jns_payment.
       (REV v2: tadinya kedua kolom ini kebalik, sudah diperbaiki.)
     - Amount       = vip_billing_payment.amount (per baris transaksi),
       BUKAN vip_billing.net_tf -- sudah dikonfirmasi user.
     - Kolom Discount % / Discount Details dari Excel asli SENGAJA
       TIDAK ditampilkan (user minta diabaikan).
     - Kolom "Student Name" terpisah DIHAPUS (REV v2) -- nama siswa
       sudah muncul di baris header (name-row) sebelum daftar
       transaksinya, jadi tidak perlu diulang per baris.
     - GROUP BY bp.no dipasang di query (REV v2) utk cegah 1 baris
       transaksi tampil berkali-kali kalau ada data ganda di
       vip_student_data/vip_mst_code_prg yg bikin JOIN fanout.
     - Tabel "Summary by Payment Type" (REV v2) ditambah setelah
       GRAND TOTAL: rekap jumlah transaksi & subtotal per jns_payment
       (Registration/Down Payment/Full Payment/Installment dst),
       harus balance dgn GRAND TOTAL di tabel utama.
     - Filter status = 'PAID' saja (exclude Pending/Cancel/dll).
     - Filter periode pakai dt_payment (tanggal transaksi), BUKAN
       dt_entry (tanggal input data).
     - REV v3: filter periode diganti dari dropdown Bulan/Tahun jadi
       date range bebas -- input "Start" & "To" (type="date"), default
       kalau kosong: awal bulan berjalan s/d hari ini. Validasi format
       YYYY-MM-DD sebelum masuk WHERE clause (fallback ke default kalau
       rusak/kosong, TIDAK langsung dipakai mentah2 di query).
     - Urutan tampil: per nama siswa (alphabetical, A-Z), lalu
       transaksi milik siswa yg sama diurutkan by dt_payment ASC
       (supaya Registration muncul duluan sebelum Full Payment,
       sesuai pola tampilan Excel aslinya).
     - Filter tambahan "Program": VIP English / Fellows Academy / CA
         Fellows Academy = vip_billing.kd_program LIKE 'FA-%'
         CA              = vip_billing.kd_program LIKE 'CA%'
                            OR vip_mst_code_prg.type_program = 'CA CoT'
         VIP English     = selain FA dan CA di atas.
     - Cabang (kd_branch) di-mapping manual ke nama cabang (TIDAK ada
       tabel referensi branch di database) -- lihat $BRANCH_LIST di
       bawah. TODO: tambahkan/cek kalau ada kode cabang baru (mis.
       kode 15 sempat muncul di contoh data tapi belum ada di daftar
       resmi dari user -- perlu dikonfirmasi manual kalau report ini
       jalan dan ada baris yang tampil sebagai "Branch #15").

   OUTPUT:
     - Layar: HTML print-friendly (AdminLTE wrapper spt report lain).
       Tombol "Print / Save as PDF" tinggal window.print() -- user
       pilih "Save as PDF" di dialog print browser, TIDAK pakai
       library PDF server-side (sesuai keputusan user).
     - Export Excel: trik header() application/vnd.ms-excel spt
       device_invent.php (BUKAN PhpSpreadsheet/Composer), satu loop
       yang sama dipakai baik utk tampil di layar maupun export,
       supaya data & struktur kolom PASTI sama persis (tidak ada 2
       versi yg bisa drift beda). Style inline dipakai supaya warna
       header tabel & baris subtotal tetap ikut ke file Excel.

   WAJIB SESUAIKAN include path (conndb.php/profiledata.php/atas.php)
   dan nama tabel di atas kalau berbeda dari project asli.
   ============================================================ */

$hari  = date("d");
$bulan = date("m");
$tahun = date("Y");
$hari_ini = "$tahun-$bulan-$hari";

// ---- Daftar bulan Indonesia (utk format tanggal & dropdown filter periode) ----
$BULAN_INDO = array(
	1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
	5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
	9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
);

function format_tgl_indo($tgl_mysql, $BULAN_INDO) {
	// $tgl_mysql format 'YYYY-MM-DD' -> "5 Juli 2026"
	if (!$tgl_mysql || $tgl_mysql == '0000-00-00') return '-';
	$ts = strtotime($tgl_mysql);
	$d = (int) date('j', $ts);
	$m = (int) date('n', $ts);
	$y = date('Y', $ts);
	return $d . ' ' . $BULAN_INDO[$m] . ' ' . $y;
}

function format_periode_label($tgl_start, $tgl_end, $BULAN_INDO) {
	// "1 Juli 2026 - 31 Juli 2026" -- dipakai di judul laporan
	return format_tgl_indo($tgl_start, $BULAN_INDO) . ' s/d ' . format_tgl_indo($tgl_end, $BULAN_INDO);
}

// ---- FIX: nominal jadi kepotong pas export Excel (300.000 -> 300) ----
// Sebab: waktu export_mode, cell angka ditulis sbg TEKS berformat titik ribuan
// spt "300.000". File .xls ini sebenarnya HTML (trik header application/vnd.ms-excel),
// jadi begitu Excel buka, dia otomatis coba baca teks yg "kelihatan kayak angka" itu
// sbg number pakai aturan lokalnya sendiri -- titik dianggap TANDA DESIMAL, bukan
// pemisah ribuan. Makanya "300.000" dibaca Excel jadi 300,000 -> tampil "300".
// FIX: waktu export_mode, taruh angka MENTAH (tanpa titik) di dalam cell, lalu kasih
// tau Excel cara format-nya lewat style "mso-number-format" (fitur khusus Excel utk
// file HTML/mso spt ini). Excel yg akan urus tampilan ribuan pakai number asli --
// tidak ada lagi tebak-tebakan parsing teks, dan angkanya tetap berupa NUMBER asli
// di Excel (bisa langsung di-SUM), bukan teks.
function td_amount($val, $st_style, $export_mode) {
	$val = (float) $val;
	if ($export_mode) {
		echo '<td style="' . e($st_style) . 'mso-number-format:\'#,##0\';">' . number_format(num($val), 0, '', '') . '</td>';
	} else {
		echo '<td style="' . e($st_style) . '">' . number_format(num($val), 0, ',', '.') . '</td>';
	}
}

// ---- Daftar cabang -- TIDAK ada tabel referensi branch di DB, mapping manual ----
// TODO: cek kode 15 (sempat muncul di contoh data payment) -- belum ada di
// daftar resmi yg dikasih user, tambahkan di sini kalau sudah dikonfirmasi.
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
$FONT_BASE   = "font-family:Calibri,Arial,sans-serif;font-size:12px;";
$ST_TH       = "border:1px solid #999;padding:3px 6px;text-align:center;background:#4F81BD;color:#fff;$FONT_BASE";
$ST_TD       = "border:1px solid #999;padding:3px 6px;text-align:center;$FONT_BASE";
$ST_TD_LEFT  = "border:1px solid #999;padding:3px 6px;text-align:left;$FONT_BASE";
$ST_SUB      = "border:1px solid #999;padding:3px 6px;text-align:center;font-weight:bold;background:#eef3f8;$FONT_BASE";
$ST_SUB_LEFT = "border:1px solid #999;padding:3px 6px;text-align:left;font-weight:bold;background:#eef3f8;$FONT_BASE";
$ST_NAME_ROW = "border:1px solid #999;padding:3px 6px;text-align:left;font-weight:bold;background:#dce6f1;$FONT_BASE";

// ---- Ambil parameter filter ----
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
$where = q_set($__p_where, "bp.status = 'PAID'\r
\tAND bp.dt_payment BETWEEN ? AND ? ", [(string) ($periode_start), (string) ($periode_end)]);

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
	header("Content-Disposition: attachment; filename=Payment_Detail_Report_$hari_ini.xls");
}

// ============================================================
// QUERY DATA -- PERBAIKAN PERFORMA (lihat catatan di bawah):
//
// 1) Dulu ada 2 query terpisah (data + summary) dgn JOIN yg SAMA
//    PERSIS -- artinya DB scan 2x utk data yg sama. Sekarang cuma
//    1 query; summary by jns_payment dihitung di PHP sambil loop
//    $result_data (lihat bagian render di bawah, var $summary_agg).
//
// 2) Dulu fanout dari vip_student_data / vip_mst_code_prg (ada
//    baris ganda per kd_biodata / kd_program) "ditutup" pakai
//    GROUP BY bp.no + MAX() di level TRANSAKSI -- artinya MySQL
//    bikin temp table & grouping utk SETIAP baris payment (bisa
//    ribuan baris tiap kali report dibuka), padahal yg beneran
//    duplikat cuma tabel referensi yg jauh lebih kecil.
//    FIX: dedup tabel referensi itu DULU (subquery kecil, murah),
//    baru di-JOIN ke transaksi. Hasilnya: tidak perlu GROUP BY
//    sama sekali di query transaksi -> tidak ada temp table besar,
//    ORDER BY nama_lengkap juga bisa lebih ringan krn bukan lagi
//    hasil MAX()/agregat.
//    NB: ini nutupin gejalanya (report jadi cepat & tetap benar).
//    Akar masalahnya (kenapa vip_student_data/vip_mst_code_prg ada
//    baris ganda per kode) sebaiknya tetap dicek terpisah -- kalau
//    memang harusnya unique, kasih UNIQUE KEY di kolom kd_biodata /
//    kd_program supaya data ganda tidak nambah lagi ke depannya.
//
// 3) INDEX YG DISARANKAN DICEK/DITAMBAH (lewat phpMyAdmin/DBA,
//    tidak bisa dijalankan otomatis dari sini):
//      ALTER TABLE vip_billing_payment ADD INDEX idx_status_dtpay (status, dt_payment);
//      ALTER TABLE vip_billing_payment ADD INDEX idx_kdbilling (kd_billing);
//      ALTER TABLE vip_billing ADD INDEX idx_kdbiodata (kd_biodata);
//      ALTER TABLE vip_billing ADD INDEX idx_kdprogram (kd_program);
//      ALTER TABLE vip_billing ADD INDEX idx_kdbranch (kd_branch);
//      ALTER TABLE vip_student_data ADD INDEX idx_kdbiodata (kd_biodata);
//      ALTER TABLE vip_mst_code_prg ADD INDEX idx_kdprogram (kd_program);
//    Jalankan "EXPLAIN <query>" di query di bawah utk cek index mana
//    yg kepakai / yg masih kurang (kalau ada "Using filesort" atau
//    "Using temporary" besar-besaran di EXPLAIN, itu tanda index
//    masih kurang).
// ============================================================
$query_data = q_set($__p_query_data, "SELECT\r
\t\tbp.no,\r
\t\tsd.nama_lengkap,\r
\t\tbp.jns_payment,\r
\t\tprg.nm_program,\r
\t\tbp.dt_payment,\r
\t\tbp.id_receipt,\r
\t\tbp.amount,\r
\t\tb.kd_branch,\r
\t\tb.kd_program\r
\tFROM vip_billing_payment bp\r
\tINNER JOIN vip_billing b ON bp.kd_billing = b.kd_billing\r
\tINNER JOIN (\r
\t\tSELECT kd_biodata, MIN(nama_lengkap) AS nama_lengkap\r
\t\tFROM vip_student_data\r
\t\tGROUP BY kd_biodata\r
\t) sd ON b.kd_biodata = sd.kd_biodata\r
\tLEFT JOIN (\r
\t\tSELECT kd_program, MIN(nm_program) AS nm_program, MIN(type_program) AS type_program\r
\t\tFROM vip_mst_code_prg\r
\t\tGROUP BY kd_program\r
\t) prg ON b.kd_program = prg.kd_program\r
\tWHERE " . $where . "\r
\tORDER BY sd.nama_lengkap ASC, bp.dt_payment ASC, bp.no ASC", [...($__p_where ?? [])]);
$result_data = db_query_or_die("Wah error nih query payment detail: " . '', $query_data, $__p_query_data ?? []);

if (!$export_mode) {
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Monthly Payment Detail Report</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <style>
	.pd-table { font-family: Calibri, Arial, sans-serif; font-size: 12px; }
	.pd-table th, .pd-table td { border: 1px solid #999; padding: 3px 6px; text-align: center; }
	.pd-table thead th { background: #4F81BD; color: #fff; }
	.pd-table td.text-left { text-align: left; }
	.section-title { font-size: 16px; font-weight: bold; margin: 20px 0 8px 0; }
	.name-row td { font-weight: bold; background: #dce6f1; text-align: left; }
	.subtotal-row td { font-weight: bold; background: #eef3f8; }
	.filter-bar { margin-bottom: 15px; }
	.report-header { text-align: center; margin-bottom: 15px; }
	.report-header h2 { margin: 0; font-size: 20px; }
	.report-header h4 { margin: 0; font-weight: normal; color: #555; }
	@media print {
		.filter-bar, .no-print { display: none !important; }
		body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
	}
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="content">
  <div class="box">
    <section class="content-header"><h1>Monthly Payment Detail Report</h1></section>
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
        <h2>MONTHLY PAYMENT DETAIL REPORT</h2>
        <h4><?php echo e(isset($BRANCH_LIST[$branch_filter]) ? htmlspecialchars($BRANCH_LIST[$branch_filter]) : 'All Branch'); ?> &mdash; Period: <?php echo e(format_periode_label($tgl_start_filter, $tgl_end_filter, $BULAN_INDO)); ?></h4>
      </div>


<?php } else { ?>
      <h3>MONTHLY PAYMENT DETAIL REPORT</h3>
      <h4><?php echo e(isset($BRANCH_LIST[$branch_filter]) ? htmlspecialchars($BRANCH_LIST[$branch_filter]) : 'All Branch'); ?> &mdash; Period: <?php echo e(format_periode_label($tgl_start_filter, $tgl_end_filter, $BULAN_INDO)); ?></h4>
      <br>
<?php } ?>

      <table class="table table-bordered pd-table" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th style="<?php echo e($ST_TH); ?>">No.</th>
            <th style="<?php echo e($ST_TH); ?>">Program Taken</th>
            <th style="<?php echo e($ST_TH); ?>">Payment For</th>
            <th style="<?php echo e($ST_TH); ?>">Date</th>
            <th style="<?php echo e($ST_TH); ?>">Receipt No.</th>
            <th style="<?php echo e($ST_TH); ?>">Amount</th>
          </tr>
        </thead>
        <tbody>
<?php
$no = 1;
$grand_total = 0;
$nama_sebelumnya = null;

// ---- Summary by Payment Type dihitung DI SINI (bukan query kedua) --
// dulu ada query terpisah dgn JOIN yg sama persis spt di atas cuma
// utk hitung summary -- sekarang cukup diakumulasi sambil loop
// $result_data yg sudah kita ambil, jadi DB cuma di-scan 1x. ----
$summary_agg = array(); // jns_payment => array('jml' => n, 'subtotal' => n)

while ($r = db_fetch($result_data, PDO::FETCH_ASSOC)) {

	// -- Baris header nama siswa: muncul cuma sekali tiap kali nama berganti
	//    (data sudah di-ORDER BY nama_lengkap, jadi baris yg sama nama-nya
	//    otomatis berurutan -- tidak perlu query terpisah per siswa). --
	if ($r['nama_lengkap'] !== $nama_sebelumnya) {
?>
          <tr class="name-row">
            <td colspan="6" style="<?php echo e($ST_NAME_ROW); ?>"><?php echo htmlspecialchars($r['nama_lengkap']); ?></td>
          </tr>
<?php
		$nama_sebelumnya = $r['nama_lengkap'];
	}

	$grand_total = num($grand_total) + num(((float) $r['amount']));

	if (!isset($summary_agg[$r['jns_payment']])) {
		$summary_agg[$r['jns_payment']] = array('jml' => 0, 'subtotal' => 0);
	}
	$summary_agg[$r['jns_payment']]['jml']++;
	$summary_agg[$r['jns_payment']]['subtotal'] = num($summary_agg[$r['jns_payment']]['subtotal']) + num(((float) $r['amount']));
?>
          <tr>
            <td style="<?php echo e($ST_TD); ?>"><?php echo e($no++); ?></td>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($r['nm_program']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($r['jns_payment']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo e(format_tgl_indo($r['dt_payment'], $BULAN_INDO)); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($r['id_receipt']); ?></td>
            <?php td_amount($r['amount'], $ST_TD, $export_mode); ?>
          </tr>
<?php } ?>
          <tr class="subtotal-row">
            <td colspan="5" class="text-left" style="<?php echo e($ST_SUB_LEFT); ?>">GRAND TOTAL</td>
            <?php td_amount($grand_total, $ST_SUB, $export_mode); ?>
          </tr>
        </tbody>
      </table>

<?php if (!$export_mode) { ?>
      <div class="section-title">Summary by Payment Type</div>
<?php } else { ?>
      <br>
      <h4>Summary by Payment Type</h4>
<?php } ?>
      <table class="table table-bordered pd-table" cellspacing="0" cellpadding="0" style="max-width:500px;">
        <thead>
          <tr>
            <th style="<?php echo e($ST_TH); ?>">Program Taken</th>
            <th style="<?php echo e($ST_TH); ?>">Jml. Transaksi</th>
            <th style="<?php echo e($ST_TH); ?>">Sub Total</th>
          </tr>
        </thead>
        <tbody>
<?php
$sum_jml_all = 0;
$sum_subtotal_all = 0;
ksort($summary_agg); // urut by jns_payment ASC, spt query summary yg lama
foreach ($summary_agg as $jns_payment => $agg) {
	$sum_jml_all = num($sum_jml_all) + num(($agg['jml']));
	$sum_subtotal_all = num($sum_subtotal_all) + num(($agg['subtotal']));
?>
          <tr>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($jns_payment); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo (int) $agg['jml']; ?></td>
            <?php td_amount($agg['subtotal'], $ST_TD, $export_mode); ?>
          </tr>
<?php } ?>
          <tr class="subtotal-row">
            <td class="text-left" style="<?php echo e($ST_SUB_LEFT); ?>">TOTAL</td>
            <td style="<?php echo e($ST_SUB); ?>"><?php echo e($sum_jml_all); ?></td>
            <?php td_amount($sum_subtotal_all, $ST_SUB, $export_mode); ?>
          </tr>
        </tbody>
      </table>

<?php if (!$export_mode) { ?>
    </section>
  </div>
</div>
</body>
</html>
<?php } ?>