<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); ob_start(); // Wajib paling atas: atas.php sudah nge-print HTML duluan,
                  // jadi tanpa buffering ini header()/redirect di bawah bakal error
                  // "headers already sent". ob_start() nampung semua output dulu
                  // supaya header() masih bisa jalan kapan pun dipanggil. ?>
<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";


/* ============================================================
   TEACHER SALARY REPORT
   Dibuat berdasarkan teacher_master_upd.php, menghasilkan report
   sejenis "Salary Teacher Part Time" pada contoh_rate_PTT_CA.xlsx

   ASUMSI / TODO — mohon dicek & disesuaikan kalau ada yang beda:
   1. vip_teacher_schedule.nm_teacher menyimpan KODE teacher
      (vip_teacher_name.kd_teacher), bukan a.no. Ini mengikuti pola
      insert di teacher_master.php (values ('$kd_teacher', ...)).
   2. vip_teacher_schedule.type_kelas berisi salah satu dari:
      'Online', 'Offiline', 'Visit', 'Corporate'
      (mengikuti opsi dropdown "Type of Teaching" di teacher_master_upd.php)
      lalu di-map ke rate & kolom Excel lewat $TYPE_MAP di bawah.
      -> KALAU nilai type_kelas di DB beda (misal 'Offline' tanpa typo,
         atau ada value lain), tinggal ubah $TYPE_MAP saja.
   3. 1 baris report = 1 kode kelas (kolom "kelas"), di-GROUP BY, dengan
      jumlah "meet" = COUNT(*) baris jadwal berstatus 1 pada periode
      terpilih. Untuk type STD House / Visit, jumlah jam dihitung dari
      SUM(jam mulai s/d selesai).
   4. Tax / Tarif = 2.5% (TAX_RATE di bawah), sama seperti contoh Excel.
   5. Kode kelas 'TUTORIAL' pada contoh Excel punya rate dibagi 1.5.
      Ini ditangani sebagai SPECIAL_CLASS_CODE_DIVISOR di bawah — kalau
      aturan ini tidak selalu berlaku, hapus/ubah blok terkait.

   TAMBAHAN — Tombol "Approved":
   6. Tombol "Approved" ada di paling bawah, 1x klik akan approve SEMUA
      teacher yang tampil di report (untuk branch+bulan+tahun yang lagi
      difilter) sekaligus, insert 1 baris per teacher ke
      vip_teacher_salary.
   7. Status "sudah di-approve" dicek dari tabel vip_teacher_salary
      (kd_teacher + salary_period). Kalau sudah ada row utk kd_teacher+
      periode itu, link nama teacher itu otomatis jadi teks biasa
      (link ke popup edit rate di-disable), dan teacher itu tidak
      ikut ke-submit lagi kalau tombol Approved diklik ulang.
      -> ASUMSI: tabel vip_teacher_salary punya PK 'id' dan idealnya
         UNIQUE KEY (kd_teacher, salary_period) biar aman dari duplikat.
   8. approved_by diambil dari session ($_SESSION['nama'] / ['user'] /
      ['username'], fallback 'Unknown') — TOLONG DICEK, disesuaikan
      dengan variable session yang dipakai di profiledata.php.
   9. salary_period disimpan format '$tahun_pilih-$bulan_pilih' (mis.
      '2026-08'), rate_online/rate_offline/rate_other = rate teacher
      yang berlaku saat approve (dari vip_mst_teacher_rate).
   ============================================================ */

// ---- Konfigurasi yang mudah diubah tanpa menyentuh logic lain ----
$TAX_RATE = 0.025;

// Mapping: nama rate di Excel  =>  nama_rate di tabel vip_mst_teacher_rate
$TYPE_MAP = array(
	'Offline'   => 'Offiline',   // typo mengikuti data yang sudah ada
	'Online'    => 'Online',
	'STD House' => 'Visit',
);

// Kode kelas dengan rate khusus (dibagi 1.5), sesuai contoh Excel
$SPECIAL_CLASS_CODE_DIVISOR = array(
	'TUTORIAL' => 1.5,
);

// ---- Konfigurasi approval (baru) ----
$TABLE_SALARY_APPROVAL = q_set($__p_TABLE_SALARY_APPROVAL, "ves_data.vip_teacher_salary");

// TODO: sesuaikan dengan nama variable session yang benar dipakai di profiledata.php
$current_user = 'Unknown';
if (isset($_SESSION['nama'])) {
	$current_user = $_SESSION['nama'];
} elseif (isset($_SESSION['user'])) {
	$current_user = $_SESSION['user'];
} elseif (isset($_SESSION['username'])) {
	$current_user = $_SESSION['username'];
}

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
$salary_period = "$tahun_pilih-$bulan_pilih";

// ---- Proses klik tombol "Approved" (POST) — HARUS sebelum ada output apa pun ----
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && in_val('action', 'post') == 'approve') {

	$salary_period_sql = $salary_period;
	$current_user_sql  = $current_user;

	$list_kd           = isset($_POST['approve_kd_teacher']) ? in_val('approve_kd_teacher', 'post') : array();
	$list_brutto        = isset($_POST['approve_brutto']) ? in_val('approve_brutto', 'post') : array();
	$list_tax           = isset($_POST['approve_tax']) ? in_val('approve_tax', 'post') : array();
	$list_net           = isset($_POST['approve_net']) ? in_val('approve_net', 'post') : array();
	$list_rate_online   = isset($_POST['approve_rate_online']) ? in_val('approve_rate_online', 'post') : array();
	$list_rate_offline  = isset($_POST['approve_rate_offline']) ? in_val('approve_rate_offline', 'post') : array();
	$list_rate_other    = isset($_POST['approve_rate_other']) ? in_val('approve_rate_other', 'post') : array();

	for ($i = 0; $i < cnt($list_kd); $i++) {
		$kd_teacher_sql = $list_kd[$i];

		// Cegah double-insert kalau tombol ke-klik 2x / browser back lalu submit lagi
		$cek = db_query_or_die("Query cek approval gagal: " . '', "SELECT id FROM " . $TABLE_SALARY_APPROVAL . "\r
\t\t\tWHERE kd_teacher = ? AND salary_period = ? LIMIT 1", [...($__p_TABLE_SALARY_APPROVAL ?? []), (string) ($kd_teacher_sql), (string) ($salary_period_sql)]);
		if (num(db_num_rows($cek)) > 0) {
			continue;
		}

		$brutto       = isset($list_brutto[$i]) ? (float) $list_brutto[$i] : 0;
		$tax          = isset($list_tax[$i]) ? (float) $list_tax[$i] : 0;
		$net          = isset($list_net[$i]) ? (float) $list_net[$i] : 0;
		$rate_online  = isset($list_rate_online[$i]) ? (float) $list_rate_online[$i] : 0;
		$rate_offline = isset($list_rate_offline[$i]) ? (float) $list_rate_offline[$i] : 0;
		$rate_other   = isset($list_rate_other[$i]) ? (float) $list_rate_other[$i] : 0;

		$insert = q_set($__p_insert, "INSERT INTO " . $TABLE_SALARY_APPROVAL . "\r
\t\t\t(kd_teacher, salary_period, salary_brutto, salary_tax, salary_net, approved_by, approved_date, rate_online, rate_offline, rate_other)\r
\t\t\tVALUES (? , ? , ? , ? , ? , ? , NOW(), ? , ? , ? )", [...($__p_TABLE_SALARY_APPROVAL ?? []), (string) ($kd_teacher_sql), (string) ($salary_period_sql), (string) ($brutto), (string) ($tax), (string) ($net), (string) ($current_user_sql), (string) ($rate_online), (string) ($rate_offline), (string) ($rate_other)]);
		db_query_or_die("Insert approval gagal: " . '', $insert, $__p_insert ?? []);
	}

	// Redirect balik ke halaman yang sama (GET) supaya status locked langsung kebaca
	// dan tidak ke-resubmit kalau user refresh halaman
	ob_end_clean(); // buang HTML yg udah kebuffer (dari atas.php dll) biar response redirect bersih
	header("Location: ?" . $_SERVER['QUERY_STRING']);
	exit;
}

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

if (!$export_mode) {
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Teacher Salary Report</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <style>
	.salary-table { font-family: Calibri, Arial, sans-serif; font-size: 12px; }
	.salary-table th, .salary-table td { border: 1px solid #999; padding: 3px 6px; text-align: center; }
	.salary-table thead th { background: #4F81BD; color: #fff; }
	.teacher-block-title { background: #DCE6F1; font-weight: bold; text-align: left !important; }
	.subtotal-row { background: #F2F2F2; font-weight: bold; }
	.text-left { text-align: left !important; }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
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

$query_teacher = q_set($__p_query_teacher, "SELECT a.no, nama_detail, kd_teacher, a.branch, posisi FROM ves_data.tb_user a\r
\tLEFT JOIN ves_data.vip_teacher_name b ON a.no = b.kd_user\r
\tWHERE " . $where_teacher . " ORDER BY nama_detail", [...($__p_where_teacher ?? [])]);
$resource_teacher = db_query_or_die("Query teacher gagal: " . '', $query_teacher, $__p_query_teacher ?? []);

// ---- Daftar kd_teacher yang SUDAH di-approve utk periode ini (utk lock link nama) ----
$salary_period_sql = $salary_period;
$approved_kd_teacher = array();
$resource_approved = db_query_or_die("Query cek daftar approved gagal: " . '', "SELECT kd_teacher FROM " . $TABLE_SALARY_APPROVAL . " WHERE salary_period = ? ", [...($__p_TABLE_SALARY_APPROVAL ?? []), (string) ($salary_period_sql)]);
while ($row_approved = db_fetch($resource_approved, PDO::FETCH_NUM)) {
	$approved_kd_teacher[] = $row_approved[0];
}

$has_unlocked = false; // ada minimal 1 teacher yang belum di-approve -> tombol Approved ditampilkan
$hidden_fields = '';    // kumpulan hidden input utk data yang mau di-submit approve
?>

<?php if (!$export_mode) { ?>
<form method="post" action="?<?php echo htmlspecialchars($_SERVER['QUERY_STRING']); ?>" id="approveForm"
	onsubmit="return confirm('Yakin approve salary periode ini? Setelah di-approve, data tidak bisa diubah lagi.');"><?php echo csrf_field(); ?>

<input type="hidden" name="action" value="approve">
<?php } ?>
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
	$branch_nama  = isset($center_list[$branch_kode]) ? $center_list[$branch_kode] : $branch_kode;
	$is_approved  = in_array($kd_teacher, $approved_kd_teacher); // sudah di-approve utk periode ini?

	// ---- Ambil rate teacher ini ----
	$rate = array('Offline' => 0, 'Online' => 0, 'STD House' => 0);
	$query_rate = q_set($__p_query_rate, "SELECT nama_rate, rate FROM ves_data.vip_mst_teacher_rate WHERE id_teacher = ? ", [(string) (intval($no_teacher))]);
	$resource_rate = db_query_soft($query_rate, $__p_query_rate ?? []);
	$rate_by_name = array();
	if ($resource_rate) {
		while ($row_rate = db_fetch($resource_rate, PDO::FETCH_NUM)) {
			$rate_by_name[$row_rate[0]] = $row_rate[1];
		}
	}
	foreach ($TYPE_MAP as $excel_label => $db_nama_rate) {
		$rate[$excel_label] = isset($rate_by_name[$db_nama_rate]) ? $rate_by_name[$db_nama_rate] : 0;
	}

	// ---- Ambil realisasi kelas periode terpilih, group per kode kelas ----
	$kd_teacher_sql = $kd_teacher;
	$query_kelas = q_set($__p_query_kelas, "SELECT kelas, type_kelas, COUNT(*) as jml_meet,\r
\t\t\tSUM(TIMESTAMPDIFF(HOUR, mulai_tm, selesai_tm)) as jml_jam,\r
\t\t\tMIN(mulai_tm) as tgl_awal, MAX(mulai_tm) as tgl_akhir\r
\t\tFROM ves_data.vip_teacher_schedule\r
\t\tWHERE nm_teacher = ?\r
\t\tAND status_kelas = 1\r
\t\tAND mulai_tm BETWEEN ? AND ?\r
\t\tGROUP BY kelas, type_kelas\r
\t\tORDER BY MIN(mulai_tm)", [(string) ($kd_teacher_sql), (string) ($periode_awal) . " 00:00:00", (string) ($periode_akhir) . " 23:59:59"]);
	$resource_kelas = db_query_soft($query_kelas, $__p_query_kelas ?? []);

	// Lewati teacher yang tidak punya realisasi kelas di periode ini
	if (!$resource_kelas || num(db_num_rows($resource_kelas)) == 0) {
		continue;
	}

	echo "<tr><td colspan='13' class='teacher-block-title'>Salary Teacher Part Time &nbsp; | &nbsp; Periode: " . date("F Y", strtotime($periode_awal)) . " &nbsp; | &nbsp; Branch: " . e($branch_nama) . "</td></tr>";
	echo "<thead><tr>
			<th rowspan='2'>NAME</th>
			<th rowspan='2'>POSITION</th>
			<th rowspan='2'>Class Code</th>
			<th rowspan='2'>Class Date</th>
			<th colspan='3'>Offline</th>
			<th colspan='3'>Online</th>
			<th colspan='3'>STD House</th>
			<th rowspan='2'>Total</th>
			<th rowspan='2'>Amount</th>
			<th rowspan='2'>Tarif</th>
			<th rowspan='2'>Tax</th>
			<th rowspan='2'>Net Income</th>
			<th rowspan='2'>Ket</th>
		  </tr>
		  <tr>
			<th>Rate</th><th>Meet</th><th>Salary</th>
			<th>Rate</th><th>Meet</th><th>Salary</th>
			<th>Rate</th><th>Hour</th><th>Salary</th>
		  </tr></thead><tbody>";

	// Nama teacher di-link ke popup edit rate (teacher_master_upd.php).
	// Popup itu sudah punya window.opener.location.reload() setelah submit,
	// jadi begitu rate di-update, halaman report ini otomatis ke-refresh.
	// Di mode export Excel, ATAU kalau sudah di-approve utk periode ini,
	// link di-disable -> tampilkan teks biasa saja (locked).
	if ($export_mode) {
		$nama_cell = htmlspecialchars($nama_teacher);
	} elseif ($is_approved) {
		$nama_cell = htmlspecialchars($nama_teacher) . " <span style='color:#888;font-size:11px;'>&#128274; Approved</span>";
	} else {
		$popup_url = "teacher_master_upd.php?id=" . urlencode($no_teacher);
		$nama_cell = "<a href=\"" . e($popup_url) . "\" target=\"popup_rate\" "
			. "onClick=\"window.open('" . e($popup_url) . "','popup_rate','width=650,height=550,left=250,top=100'); return false;\">"
			. htmlspecialchars($nama_teacher) . "</a>";
	}

	// baris pertama: nama, posisi, rate (tanpa detail kelas)
	echo "<tr>
			<td class='text-left'>" . $nama_cell . "</td>
			<td>" . htmlspecialchars($posisi) . "</td>
			<td colspan='2'></td>
			<td>" . number_format(num($rate['Offline'])) . "</td><td></td><td></td>
			<td>" . number_format(num($rate['Online'])) . "</td><td></td><td></td>
			<td>" . number_format(num($rate['STD House'])) . "</td><td></td><td></td>
			<td></td><td></td>
			<td>" . e((num($TAX_RATE) * 100)) . "%</td><td></td><td></td><td></td>
		  </tr>";

	$sum_meet = 0; $sum_amount = 0; $sum_tax = 0; $sum_net = 0;

	while ($row_kelas = db_fetch($resource_kelas, PDO::FETCH_NUM)) {
		$kode_kelas   = $row_kelas[0];
		$type_kelas   = $row_kelas[1];
		$jml_meet     = (int) $row_kelas[2];
		$jml_jam      = (int) $row_kelas[3];
		$tgl_akhir    = $row_kelas[5];

		// Tentukan label Excel (Offline/Online/STD House) dari type_kelas DB
		$excel_label = array_search($type_kelas, $TYPE_MAP);
		if ($excel_label === false) {
			// type_kelas tidak dikenali -> tampilkan sebagai Ket, tidak dihitung salary
			echo "<tr><td colspan='3' class='text-left'>" . htmlspecialchars($kode_kelas) . "</td>
					<td>" . htmlspecialchars($tgl_akhir) . "</td>
					<td colspan='9'></td><td>0</td><td>0</td><td></td><td>0</td><td>0</td>
					<td>Unknown type_kelas: " . htmlspecialchars($type_kelas) . "</td></tr>";
			continue;
		}

		$row_rate = $rate[$excel_label];
		$divisor = isset($SPECIAL_CLASS_CODE_DIVISOR[$kode_kelas]) ? $SPECIAL_CLASS_CODE_DIVISOR[$kode_kelas] : 1;
		$ket = (num($divisor) != 1) ? "rate/$divisor" : '';

		if ($excel_label == 'STD House') {
			$salary = round(num((div($row_rate, $divisor))) * num($jml_jam));
			$meet_col = $jml_jam; // kolom "Hour"
			$total_unit = $jml_jam;
		} else {
			$salary = round(num((div($row_rate, $divisor))) * num($jml_meet));
			$meet_col = $jml_meet;
			$total_unit = $jml_meet;
		}

		$tax = round(num($salary) * num($TAX_RATE));
		$net = num($salary) - num($tax);

		$sum_meet   = num($sum_meet) + num(($total_unit));
		$sum_amount = num($sum_amount) + num(($salary));
		$sum_tax    = num($sum_tax) + num(($tax));
		$sum_net    = num($sum_net) + num(($net));

		echo "<tr><td colspan='2'></td>
				<td class='text-left'>" . htmlspecialchars($kode_kelas) . "</td>
				<td>" . htmlspecialchars($tgl_akhir) . "</td>";

		// isi 3 grup kolom (Offline/Online/STD House), kosongkan yang tidak relevan
		foreach (array('Offline', 'Online', 'STD House') as $grp) {
			if ($grp == $excel_label) {
				echo "<td></td><td>" . e($meet_col) . "</td><td>" . number_format(num($salary)) . "</td>";
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

	// ---- Siapkan data utk di-submit kalau tombol Approved diklik ----
	// (teacher yang sudah di-approve utk periode ini tidak perlu di-submit ulang)
	if (!$export_mode && !$is_approved) {
		$has_unlocked = true;
		$hidden_fields .= "<input type='hidden' name='approve_kd_teacher[]' value=\"" . htmlspecialchars($kd_teacher) . "\">\n";
		$hidden_fields .= "<input type='hidden' name='approve_brutto[]' value=\"" . e($sum_amount) . "\">\n";
		$hidden_fields .= "<input type='hidden' name='approve_tax[]' value=\"" . e($sum_tax) . "\">\n";
		$hidden_fields .= "<input type='hidden' name='approve_net[]' value=\"" . e($sum_net) . "\">\n";
		$hidden_fields .= "<input type='hidden' name='approve_rate_online[]' value=\"" . e($rate['Online']) . "\">\n";
		$hidden_fields .= "<input type='hidden' name='approve_rate_offline[]' value=\"" . e($rate['Offline']) . "\">\n";
		$hidden_fields .= "<input type='hidden' name='approve_rate_other[]' value=\"" . e($rate['STD House']) . "\">\n";
	}
}
?>
</table>

<?php if (!$export_mode) {
	echo $hidden_fields;
	if ($has_unlocked) {
		echo "<div style='margin-top:15px;'><button type='submit' class='btn btn-danger'>Approved</button></div>";
	} else {
		echo "<div style='margin-top:15px;'><button type='button' class='btn btn-danger' disabled style='opacity:0.6;cursor:not-allowed;'>Approved</button>
			<span style='margin-left:8px;color:#888;'><em>Semua data pada periode & filter ini sudah di-approve.</em></span></div>";
	}
?>
</form>
<?php } ?>

<?php if (!$export_mode) { ?>
    </section>
  </div>
</div>
</body>
</html>
<?php } ?>