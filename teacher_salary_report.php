<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";


/* ============================================================
   TEACHER SALARY REPORT (v3)
   Format tabel MENGIKUTI PERSIS contoh_rate_PTT_CA.xlsx:
   1 baris = 1 kode kelas, dengan 3 blok kolom berdampingan
   (Offline / Online / STD House), sama seperti versi paling awal.
   Ini gabungan dari v1 (format Excel) + fitur-fitur yang ditambah
   belakangan (v2):

   1. RATE EFEKTIF DATE
      vip_mst_teacher_rate bisa punya BEBERAPA baris rate untuk
      kombinasi (id_teacher, nama_rate, jenis_rate) dengan
      tgl_efektif berbeda. Rate yang dipakai untuk sebuah SESI =
      rate dengan tgl_efektif <= tanggal sesi tsb, yang PALING BARU.
      tgl_efektif NULL dianggap berlaku dari awal (rate lama/legacy).
      Supaya ini tetap kompatibel dengan format "1 baris per kode
      kelas", proses agregasi dilakukan PER SESI dulu (ambil rate
      masing-masing sesi), baru sesi-sesi dengan kode kelas + tipe +
      rate yang SAMA digabung jadi satu baris seperti biasa. Kalau
      rate berubah di tengah bulan untuk kode kelas yang sama,
      otomatis akan muncul sebagai 2 baris terpisah (rate lama &
      rate baru), supaya kelas 1-14 vs 15 dst kehitung benar.

   2. JAM MULAI - SELESAI DI KOLOM CLASS DATE
      Class Date menampilkan tanggal + jam mulai-selesai (time saja
      dari selesai_tm) dari SESI TERAKHIR pada baris tsb.

   3. WARNA PER TYPE KELAS
      Header kolom Offline/Online/STD House diberi warna berbeda
      (oranye/biru/hijau) supaya gampang dibedakan sekilas.

   4. TAX BERDASARKAN NPWP
      vip_teacher_name.npwp TIDAK kosong -> tax 2.5%. Kosong -> 3%.

   5. JENIS RATE (CA / VIP / FA) + RATE "SESSION" UNTUK CA
      jenis_rate ditentukan dari POLA kolom "kelas" (lihat
      determine_jenis_rate()):
        - kelas LIKE 'CA%'   -> jenis_rate = 'CA'
        - kelas LIKE 'FA-%'  -> jenis_rate = 'FA'
        - selain itu         -> jenis_rate = 'VIP'
      KHUSUS jenis_rate = 'CA': rate yang dipakai untuk hitung
      salary SELALU dari nama_rate = 'Session' (rate per satuan x
      satuan, diisi di teacher_master_upd.php), BUKAN dari
      Offline/Online/Visit. type_kelas (Offline/Online/Visit) tetap
      dipakai untuk menentukan kolom mana yang diisi di tabel,
      supaya tampilannya tetap konsisten dengan format Excel (baris
      CA tetap masuk ke kolom Offline atau Online sesuai
      type_kelas), tapi ANGKA RATE-nya diambil dari 'Session'.
      Untuk jenis_rate VIP / FA, logic tetap seperti semula: rate
      diambil dari Offline/Online/Visit sesuai type_kelas.

   -> WAJIB dijalankan dulu di database (kalau kolom belum ada):
      ALTER TABLE ves_data.vip_mst_teacher_rate
        ADD COLUMN jenis_rate  VARCHAR(10) NOT NULL DEFAULT 'VIP' AFTER nama_rate,
        ADD COLUMN satuan      DECIMAL(6,2) NOT NULL DEFAULT 1 AFTER rate,
        ADD COLUMN tgl_efektif DATE NULL DEFAULT NULL AFTER satuan;

   Catatan lain yang masih sama seperti versi sebelumnya:
   - vip_teacher_schedule.nm_teacher menyimpan KODE teacher
     (vip_teacher_name.kd_teacher).
   - type_kelas: 'Online', 'Offline' (typo asli), 'Visit', 'Corporate'.
   - Kode kelas 'TUTORIAL' punya rate dibagi 1.5 (SPECIAL_CLASS_CODE_DIVISOR),
     berlaku untuk semua jenis_rate termasuk CA (lihat contoh Excel:
     baris TUTORIAL di branch CA juga dibagi 1.5).
   ============================================================ */

// ---- Konfigurasi yang mudah diubah tanpa menyentuh logic lain ----
$TAX_RATE_NPWP    = 0.025; // dengan NPWP
$TAX_RATE_NO_NPWP = 0.03;  // tanpa NPWP

// Mapping: nama kolom di Excel  =>  nilai type_kelas di vip_teacher_schedule
// (dipakai untuk mencocokkan baris jadwal kelas)
$TYPE_KELAS_MAP = array(
	'Offline'   => 'Offline',    // sesuai data asli di vip_teacher_schedule.type_kelas (TANPA typo)
	'Online'    => 'Online',
	'STD House' => 'Visit',
);

// Mapping: nama kolom di Excel  =>  nama_rate di vip_mst_teacher_rate
// (dipakai untuk mencari rate teacher). INI BEDA dengan $TYPE_KELAS_MAP di
// atas karena nama_rate di tabel rate masih pakai ejaan lama/typo
// ('Offline'), sesuai $RATE_TYPES di teacher_master_upd.php.
$RATE_NAME_MAP = array(
	'Offline'   => 'Offline',   // typo, ikut data yang sudah ada di vip_mst_teacher_rate
	'Online'    => 'Online',
	'STD House' => 'Visit',
);

// Urutan kolom di tabel (harus sama urutannya dengan header)
$TYPE_ORDER = array('Offline', 'Online', 'STD House');

// Class css warna per kolom type (dipakai di header kolom)
$TYPE_HEADER_CLASS = array(
	'Offline'   => 'hdr-offline',
	'Online'    => 'hdr-online',
	'STD House' => 'hdr-stdhouse',
);

// Nama rate khusus untuk jenis_rate = 'CA': salary dihitung dari rate
// 'Session' (rate x satuan), bukan dari Offline/Online/Visit.
$SESSION_RATE_NAME = 'Session';

// Kode kelas dengan rate khusus (dibagi 1.5), sesuai contoh Excel
$SPECIAL_CLASS_CODE_DIVISOR = array(
	'TUTORIAL' => 1.5,
);

$hari  = date("d");
$bulan = date("m");
$tahun = date("Y");
$hari_ini = "$tahun-$bulan-$hari";

// ---- Ambil parameter filter ----
$kd_center   = isset($_GET['kd_center']) ? in_val('kd_center', 'get') : '';
$id_filter   = isset($_GET['id']) ? in_val('id', 'get') : '';           // filter 1 teacher (a.no), kosong = All
$bulan_pilih = isset($_GET['bulan_pilih']) ? in_val('bulan_pilih', 'get') : $bulan;
$tahun_pilih = isset($_GET['tahun_pilih']) ? in_val('tahun_pilih', 'get') : $tahun;

$periode_awal  = "$tahun_pilih-$bulan_pilih-01";
$periode_akhir = date("Y-m-t", strtotime($periode_awal)); // tanggal akhir bulan

// ---- Mode export HARUS dicek & header() dikirim SEBELUM ada output apa pun ----
$export_mode = isset($_GET['export']) && in_val('export', 'get') == 'xls';
if ($export_mode) {
	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=Salary_Report_$tahun_pilih-$bulan_pilih.xls");
}

$center_list = array(
	'1' => 'East Sby', '2' => 'West Sby', '3' => 'Bali', '4' => 'South Jkt',
	'5' => 'North Jkt', '6' => 'West Jkt', '7' => 'Bandung', '8' => 'Malang',
);

// ---- Helper: tentukan jenis_rate (CA/VIP/FA) dari kode kelas ----
function determine_jenis_rate($kelas) {
	if (stripos($kelas, 'CA') === 0)   return 'CA';   // kelas LIKE 'CA%'
	if (stripos($kelas, 'FA-') === 0)  return 'FA';   // kelas LIKE 'FA-%'
	return 'VIP';
}

// ---- Helper: cari rate (+ satuan) yang berlaku untuk tanggal tertentu ----
// $rate_history[nama_rate][jenis_rate] = array of ['tgl_efektif'=>'YYYY-MM-DD'|null, 'rate'=>float, 'satuan'=>float],
// urut ASC by tgl_efektif (null dulu)
function get_applicable_rate_row($rate_history, $nama_rate, $jenis_rate, $tgl_sesi) {
	if (!isset($rate_history[$nama_rate][$jenis_rate])) return array('rate' => 0, 'satuan' => 1);
	$applicable = array('rate' => 0, 'satuan' => 1);
	foreach ($rate_history[$nama_rate][$jenis_rate] as $h) {
		if ($h['tgl_efektif'] === null || $h['tgl_efektif'] <= $tgl_sesi) {
			$applicable = $h; // list sudah urut ASC, jadi yang terakhir cocok = paling baru
		} else {
			break;
		}
	}
	return $applicable;
}

// ---- Dropdown daftar teacher untuk filter (sesuai branch terpilih) ----
$where_teacher_dd = q_set($__p_where_teacher_dd, "usergroup = 'ACD' and a.aktif = 'Y' and posisi = 'PTT'");
if ($kd_center != '' && $kd_center != 'All') {
	$kd_center_sql = $kd_center;
	$where_teacher_dd .= q_add($__p_where_teacher_dd, " and a.branch = ? ", [(string) ($kd_center_sql)]);
}
$query_dd_teacher = q_set($__p_query_dd_teacher, "SELECT a.no, nama_detail FROM ves_data.tb_user a\r
\tLEFT JOIN ves_data.vip_teacher_name b ON a.no = b.kd_user\r
\tWHERE " . $where_teacher_dd . " ORDER BY nama_detail", [...($__p_where_teacher_dd ?? [])]);
$resource_dd_teacher = db_query_soft($query_dd_teacher, $__p_query_dd_teacher ?? []);

// ---- HEAD + <style> SELALU dikeluarkan (baik mode web maupun export),
//      supaya file Excel hasil export ikut membawa format & warna yang
//      sama persis dengan tampilan di web. Yang dibedakan hanya bagian
//      UI (link Bootstrap/AdminLTE, header halaman, form filter) yang
//      memang tidak relevan untuk file Excel.
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Teacher Salary Report</title>
<?php if (!$export_mode) { ?>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<?php } ?>
  <style>
	.salary-table { font-family: Calibri, Arial, sans-serif; font-size: 12px; border-collapse: collapse; }
	.salary-table th, .salary-table td { border: 1px solid #999; padding: 3px 6px; text-align: center; }
	.salary-table thead th { background: #4F81BD; color: #fff; }
	.teacher-block-title { background: #DCE6F1; font-weight: bold; text-align: left !important; }
	.subtotal-row { background: #F2F2F2; font-weight: bold; }
	.text-left { text-align: left !important; }
	.rate-ref-hint { font-size: 10px; color: #666; font-weight: normal; }

	/* Warna header per kolom type kelas */
	.hdr-offline  { background:#E67E22 !important; }
	.hdr-online   { background:#2E86C1 !important; }
	.hdr-stdhouse { background:#27AE60 !important; }

	.jenis-rate-badge { display:inline-block; padding:1px 6px; border-radius:3px; border:1px solid #999; font-size:10px; }
  </style>
</head>
<body<?php echo e($export_mode ? '' : ' class="hold-transition skin-blue sidebar-mini"'); ?>>
<?php if (!$export_mode) { ?>
<div class="content">
  <div class="box">
    <section class="content-header"><h1>Teacher Salary Report</h1></section>
    <section class="content">
      <form method="get" class="form-inline" style="margin-bottom:15px;">
        <div class="form-group" style="margin-right:10px;">
          <label>Branch</label>
          <select class="form-control" name="kd_center">
            <option value="All">All</option>
<?php foreach ($center_list as $kd => $nm) { ?>
            <option value="<?php echo e($kd); ?>" <?php echo e(($kd_center == $kd) ? 'selected' : ''); ?>><?php echo e($nm); ?></option>
<?php } ?>
          </select>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Teacher</label>
          <select class="form-control" name="id">
            <option value="">All</option>
<?php
if ($resource_dd_teacher && num(db_num_rows($resource_dd_teacher)) > 0) {
	while ($row_dd = db_fetch($resource_dd_teacher, PDO::FETCH_NUM)) {
		$sel = ($id_filter == $row_dd[0]) ? 'selected' : '';
		echo "<option value=\"" . e($row_dd[0]) . "\" " . e($sel) . ">" . e($row_dd[1]) . "</option>";
	}
}
?>
          </select>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Bulan</label>
          <select class="form-control" name="bulan_pilih">
<?php for ($m = 1; num($m) <= 12; $m++) { $mm = str_pad($m, 2, '0', STR_PAD_LEFT); ?>
            <option value="<?php echo e($mm); ?>" <?php echo e(($bulan_pilih == $mm) ? 'selected' : ''); ?>><?php echo date("F", mktime(0,0,0,$m,1)); ?></option>
<?php } ?>
          </select>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Tahun</label>
          <input type="number" class="form-control" name="tahun_pilih" value="<?php echo htmlspecialchars($tahun_pilih); ?>" style="width:90px;">
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
        <a class="btn btn-success" href="?<?php echo htmlspecialchars($_SERVER['QUERY_STRING']); ?>&export=xls" target="_blank">Export to Excel</a>
      </form>

<?php
} // end if (!$export_mode)
?>
<?php

// ---- Query daftar teacher yang akan ditampilkan pada report ----
$where_teacher = q_set($__p_where_teacher, "usergroup = 'ACD' and a.aktif = 'Y' and posisi = 'PTT'");
if ($kd_center != '' && $kd_center != 'All') {
	$kd_center_sql = $kd_center;
	$where_teacher .= q_add($__p_where_teacher, " and a.branch = ? ", [(string) ($kd_center_sql)]);
}
if ($id_filter != '') {
	$id_filter_sql = $id_filter;
	$where_teacher .= q_add($__p_where_teacher, " and a.no = ? ", [(string) ($id_filter_sql)]);
}

$query_teacher = q_set($__p_query_teacher, "SELECT a.no, nama_detail, kd_teacher, a.branch, posisi, b.npwp FROM ves_data.tb_user a\r
\tLEFT JOIN ves_data.vip_teacher_name b ON a.no = b.kd_user\r
\tWHERE " . $where_teacher . " ORDER BY nama_detail", [...($__p_where_teacher ?? [])]);
$resource_teacher = db_query_or_die("Query teacher gagal: " . '', $query_teacher, $__p_query_teacher ?? []);
?>

<table class="salary-table" width="100%" cellspacing="0" cellpadding="0">
<?php
if (num(db_num_rows($resource_teacher)) == 0) {
	echo "<tr><td colspan='13'>Tidak ada data teacher untuk filter ini.</td></tr>";
}

while ($row_teacher = db_fetch($resource_teacher, PDO::FETCH_NUM)) {

	$no_teacher   = $row_teacher[0];  // id_teacher, dipakai untuk join rate
	$nama_teacher = $row_teacher[1];
	$kd_teacher   = $row_teacher[2];  // dipakai untuk join jadwal (nm_teacher di vip_teacher_schedule)
	$branch_kode  = $row_teacher[3];
	$posisi       = $row_teacher[4];
	$npwp         = trim($row_teacher[5]);
	$branch_nama  = isset($center_list[$branch_kode]) ? $center_list[$branch_kode] : $branch_kode;

	$tax_rate = ($npwp != '') ? $TAX_RATE_NPWP : $TAX_RATE_NO_NPWP;

	// ---- Ambil histori rate teacher ini (semua tgl_efektif, semua jenis_rate) ----
	$query_rate = q_set($__p_query_rate, "SELECT nama_rate, jenis_rate, rate, satuan, tgl_efektif FROM ves_data.vip_mst_teacher_rate\r
\t\tWHERE id_teacher = ? \r
\t\tORDER BY nama_rate, jenis_rate, (tgl_efektif IS NULL) DESC, tgl_efektif ASC", [(string) (intval($no_teacher))]);
	$resource_rate = db_query_soft($query_rate, $__p_query_rate ?? []);
	$rate_history = array();
	if ($resource_rate) {
		while ($row_rate = db_fetch($resource_rate, PDO::FETCH_NUM)) {
			$rn = $row_rate[0]; $jr = $row_rate[1]; $rt = $row_rate[2];
			$satuan = ($row_rate[3] !== null && $row_rate[3] !== '') ? $row_rate[3] : 1;
			$tgl_ef = $row_rate[4];
			if (!isset($rate_history[$rn])) $rate_history[$rn] = array();
			if (!isset($rate_history[$rn][$jr])) $rate_history[$rn][$jr] = array();
			$rate_history[$rn][$jr][] = array('tgl_efektif' => $tgl_ef, 'rate' => $rt, 'satuan' => $satuan);
		}
	}

	// ---- Ambil realisasi kelas periode terpilih, PER SESI dulu (supaya rate
	//      efektif per tanggal bisa dihitung benar), baru digabung per
	//      (kode kelas + type + rate) jadi satu baris seperti format Excel ----
	$kd_teacher_sql = $kd_teacher;
	$query_kelas = q_set($__p_query_kelas, "SELECT kelas, type_kelas, mulai_tm, selesai_tm\r
\t\tFROM ves_data.vip_teacher_schedule\r
\t\tWHERE nm_teacher = ?\r
\t\tAND status_kelas = 1\r
\t\tAND mulai_tm BETWEEN ? AND ?\r
\t\tORDER BY kelas, mulai_tm", [(string) ($kd_teacher_sql), (string) ($periode_awal) . " 00:00:00", (string) ($periode_akhir) . " 23:59:59"]);
	$resource_kelas = db_query_soft($query_kelas, $__p_query_kelas ?? []);

	// Lewati teacher yang tidak punya realisasi kelas di periode ini
	if (!$resource_kelas || num(db_num_rows($resource_kelas)) == 0) {
		continue;
	}

	// ---- Bangun grup (kode kelas + type + rate efektif saat itu) ----
	$groups = array();       // key => data grup, urut sesuai kemunculan pertama
	$unknown_rows = array(); // baris dengan type_kelas tak dikenal, tampil apa adanya

	while ($row_kelas = db_fetch($resource_kelas, PDO::FETCH_NUM)) {
		$kode_kelas = $row_kelas[0];
		$type_kelas = $row_kelas[1];
		$mulai_tm   = $row_kelas[2];
		$selesai_tm = $row_kelas[3];
		$tgl_sesi   = substr($mulai_tm, 0, 10); // YYYY-MM-DD, buat cek rate efektif
		$jenis_rate = determine_jenis_rate($kode_kelas);

		$excel_label = array_search($type_kelas, $TYPE_KELAS_MAP);
		if ($excel_label === false) {
			$unknown_rows[] = array('kelas' => $kode_kelas, 'type_kelas' => $type_kelas, 'mulai_tm' => $mulai_tm, 'selesai_tm' => $selesai_tm);
			continue;
		}

		if ($jenis_rate == 'CA') {
			// Kelas CA: rate SELALU dari nama_rate 'Session' (rate / satuan)
			$rate_row = get_applicable_rate_row($rate_history, $SESSION_RATE_NAME, $jenis_rate, $tgl_sesi);
			$row_rate = (num($rate_row['satuan']) != 0) ? round(div($rate_row['rate'], $rate_row['satuan'])) : 0;
			$rate_note = (num($rate_row['satuan']) != 1) ? " (Session {$rate_row['rate']} / {$rate_row['satuan']})" : '';
		} else {
			$db_nama_rate = $RATE_NAME_MAP[$excel_label];
			$rate_row = get_applicable_rate_row($rate_history, $db_nama_rate, $jenis_rate, $tgl_sesi);
			$row_rate = $rate_row['rate'];
			$rate_note = '';
		}

		$divisor = isset($SPECIAL_CLASS_CODE_DIVISOR[$kode_kelas]) ? $SPECIAL_CLASS_CODE_DIVISOR[$kode_kelas] : 1;
		$rate_per_unit = num($divisor) != 0 ? div($row_rate, $divisor) : 0;

		// Kunci grup: kode kelas + kolom type + rate per unit yang berlaku saat itu
		// + TANGGAL SESI. Kalau rate berubah di tengah bulan (tgl_efektif baru),
		// rate_per_unit beda -> otomatis jadi grup/baris baru. Tanggal sesi
		// disertakan supaya kode kelas yang sama tapi beda tanggal TIDAK
		// digabung jadi satu baris -> tiap sesi (tanggal) tampil sebagai baris
		// terpisah dan dihitung per sesi masing-masing (1 kode kelas di tanggal
		// & jam yang sama dipastikan cuma 1 sesi, jadi ini aman).
		$group_key = $kode_kelas . '|' . $excel_label . '|' . $jenis_rate . '|' . sprintf('%.4f', $rate_per_unit) . '|' . $tgl_sesi;

		if (!isset($groups[$group_key])) {
			$groups[$group_key] = array(
				'kelas'        => $kode_kelas,
				'excel_label'  => $excel_label,
				'jenis_rate'   => $jenis_rate,
				'row_rate'     => $row_rate,
				'divisor'      => $divisor,
				'rate_note'    => $rate_note,
				'jml_meet'     => 0,
				'jml_jam'      => 0,
				'mulai_terakhir'   => $mulai_tm,
				'selesai_terakhir' => $selesai_tm,
			);
		}

		// Durasi sesi dalam jam (selesai_tm - mulai_tm), dipakai untuk SEMUA
		// tipe kolom (Offline/Online/STD House). Sebelumnya Offline & Online
		// hanya menghitung JUMLAH sesi (+=1), sehingga kolom "Meet" menampilkan
		// banyaknya sesi yang tergabung dalam 1 baris, bukan total jam-nya.
		$jam_sesi = round(num((num(strtotime($selesai_tm)) - num(strtotime($mulai_tm)))) / 3600, 2);

		if ($excel_label == 'STD House') {
			$groups[$group_key]['jml_jam'] = num($groups[$group_key]['jml_jam']) + num(($jam_sesi));
		} else {
			$groups[$group_key]['jml_meet'] = num($groups[$group_key]['jml_meet']) + num(($jam_sesi));
		}

		// simpan sesi paling akhir dalam grup ini untuk kolom Class Date
		if (strtotime($mulai_tm) >= strtotime($groups[$group_key]['mulai_terakhir'])) {
			$groups[$group_key]['mulai_terakhir']   = $mulai_tm;
			$groups[$group_key]['selesai_terakhir'] = $selesai_tm;
		}
	}

	echo "<tr><td colspan='13' class='teacher-block-title'>Salary Teacher Part Time &nbsp; | &nbsp; Periode: " . date("F Y", strtotime($periode_awal)) . " &nbsp; | &nbsp; Branch: " . e($branch_nama) . "</td></tr>";
	echo "<thead><tr>
			<th rowspan='2'>NAME</th>
			<th rowspan='2'>POSITION</th>
			<th rowspan='2'>Class Code</th>
			<th rowspan='2'>Class Date</th>
			<th colspan='3' class='" . e($TYPE_HEADER_CLASS['Offline']) . "'>Offline</th>
			<th colspan='3' class='" . e($TYPE_HEADER_CLASS['Online']) . "'>Online</th>
			<th colspan='3' class='" . e($TYPE_HEADER_CLASS['STD House']) . "'>STD House</th>
			<th rowspan='2'>Total</th>
			<th rowspan='2'>Amount</th>
			<th rowspan='2'>Tarif</th>
			<th rowspan='2'>Tax</th>
			<th rowspan='2'>Net Income</th>
			<th rowspan='2'>Ket</th>
		  </tr>
		  <tr>
			<th class='" . e($TYPE_HEADER_CLASS['Offline']) . "'>Rate</th><th class='" . e($TYPE_HEADER_CLASS['Offline']) . "'>Meet</th><th class='" . e($TYPE_HEADER_CLASS['Offline']) . "'>Salary</th>
			<th class='" . e($TYPE_HEADER_CLASS['Online']) . "'>Rate</th><th class='" . e($TYPE_HEADER_CLASS['Online']) . "'>Meet</th><th class='" . e($TYPE_HEADER_CLASS['Online']) . "'>Salary</th>
			<th class='" . e($TYPE_HEADER_CLASS['STD House']) . "'>Rate</th><th class='" . e($TYPE_HEADER_CLASS['STD House']) . "'>Hour</th><th class='" . e($TYPE_HEADER_CLASS['STD House']) . "'>Salary</th>
		  </tr></thead><tbody>";

	// Nama teacher di-link ke popup edit rate (teacher_master_upd.php).
	if ($export_mode) {
		$nama_cell = htmlspecialchars($nama_teacher);
	} else {
		$popup_url = "teacher_master_upd.php?id=" . urlencode($no_teacher);
		$nama_cell = "<a href=\"" . e($popup_url) . "\" target=\"popup_rate\" "
			. "onClick=\"window.open('" . e($popup_url) . "','popup_rate','width=650,height=550,left=250,top=100'); return false;\">"
			. htmlspecialchars($nama_teacher) . "</a>";
	}

	// baris pertama: nama, posisi, rate referensi VIP saat ini (informational),
	// + rate Session (CA) kalau ada, ditampilkan sebagai hint kecil.
	$ref_rate = array('Offline' => 0, 'Online' => 0, 'STD House' => 0);
	foreach ($RATE_NAME_MAP as $lbl => $db_nama_rate) {
		$rr = get_applicable_rate_row($rate_history, $db_nama_rate, 'VIP', $hari_ini);
		$ref_rate[$lbl] = $rr['rate'];
	}
	$session_ref = get_applicable_rate_row($rate_history, $SESSION_RATE_NAME, 'CA', $hari_ini);
	$session_hint = (num($session_ref['rate']) > 0)
		? "<div class='rate-ref-hint'>Session (CA): " . number_format(num($session_ref['rate'])) . " / {$session_ref['satuan']} = " . number_format(num(round(num($session_ref['satuan']) != 0 ? div($session_ref['rate'], $session_ref['satuan']) : 0))) . "</div>"
		: '';

	echo "<tr>
			<td class='text-left'>" . $nama_cell . $session_hint . "</td>
			<td>" . htmlspecialchars($posisi) . "</td>
			<td colspan='2'></td>
			<td>" . number_format(num($ref_rate['Offline'])) . "</td><td></td><td></td>
			<td>" . number_format(num($ref_rate['Online'])) . "</td><td></td><td></td>
			<td>" . number_format(num($ref_rate['STD House'])) . "</td><td></td><td></td>
			<td></td><td></td>
			<td>" . e((num($tax_rate) * 100)) . "%</td><td></td><td></td><td></td>
		  </tr>";

	$sum_meet = 0; $sum_amount = 0; $sum_tax = 0; $sum_net = 0;

	foreach ($groups as $g) {
		$kode_kelas  = $g['kelas'];
		$excel_label = $g['excel_label'];
		$row_rate    = $g['row_rate'];
		$divisor     = $g['divisor'];

		$tgl_display = date("d M Y", strtotime($g['mulai_terakhir']));
		$jam_mulai   = date("H:i", strtotime($g['mulai_terakhir']));
		$jam_selesai = date("H:i", strtotime($g['selesai_terakhir']));
		$class_date_display = "$tgl_display $jam_mulai-$jam_selesai";

		if ($excel_label == 'STD House') {
			$total_unit = $g['jml_jam'];
		} else {
			$total_unit = $g['jml_meet'];
		}
		$salary = round(num((div($row_rate, $divisor))) * num($total_unit));
		$tax = round(num($salary) * num($tax_rate));
		$net = num($salary) - num($tax);

		$sum_meet   = num($sum_meet) + num(($total_unit));
		$sum_amount = num($sum_amount) + num(($salary));
		$sum_tax    = num($sum_tax) + num(($tax));
		$sum_net    = num($sum_net) + num(($net));

		$ket_parts = array();
		if (num($divisor) != 1) $ket_parts[] = "rate/$divisor";
		if ($g['jenis_rate'] == 'CA') $ket_parts[] = "CA - Session" . $g['rate_note'];
		$ket = implode(' | ', $ket_parts);

		echo "<tr><td colspan='2'></td>
				<td class='text-left'>" . htmlspecialchars($kode_kelas) . " <span class='jenis-rate-badge'>" . htmlspecialchars($g['jenis_rate']) . "</span></td>
				<td>" . htmlspecialchars($class_date_display) . "</td>";

		foreach ($TYPE_ORDER as $grp) {
			if ($grp == $excel_label) {
				echo "<td></td><td>" . e($total_unit) . "</td><td>" . number_format(num($salary)) . "</td>";
			} else {
				echo "<td></td><td></td><td></td>";
			}
		}

		echo "<td>" . e($total_unit) . "</td>
				<td>" . number_format(num($salary)) . "</td>
				<td></td>
				<td>" . number_format(num($tax)) . "</td>
				<td>" . number_format(num($net)) . "</td>
				<td>" . htmlspecialchars($ket) . "</td>
			  </tr>";
	}

	foreach ($unknown_rows as $u) {
		$tgl_display = date("d M Y", strtotime($u['mulai_tm']));
		$jam_mulai   = date("H:i", strtotime($u['mulai_tm']));
		$jam_selesai = date("H:i", strtotime($u['selesai_tm']));
		echo "<tr><td colspan='2'></td>
				<td class='text-left'>" . htmlspecialchars($u['kelas']) . "</td>
				<td>" . e($tgl_display) . " " . e($jam_mulai) . "-" . e($jam_selesai) . "</td>
				<td colspan='9'></td><td>0</td><td>0</td><td></td><td>0</td><td>0</td>
				<td>Unknown type_kelas: " . htmlspecialchars($u['type_kelas']) . "</td></tr>";
	}

	echo "<tr class='subtotal-row'>
			<td colspan='4' class='text-left'>Subtotal</td>
			<td colspan='9'></td>
			<td>" . e($sum_meet) . "</td>
			<td>" . number_format(num($sum_amount)) . "</td>
			<td></td>
			<td>" . number_format(num($sum_tax)) . "</td>
			<td>" . number_format(num($sum_net)) . "</td>
			<td></td>
		  </tr>";
	echo "</tbody><tr><td colspan='13'>&nbsp;</td></tr>";
}
?>
</table>

<?php if (!$export_mode) { ?>
    </section>
  </div>
</div>
<?php } ?>
</body>
</html>