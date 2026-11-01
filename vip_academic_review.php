<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
/* ============================================================
   STUDENT - ACADEMIC REVIEW REQUIRED (FORM)
   Dibuat mengikuti pola & style vip_student_record.php yang dikirim:
   - include conndb.php / profiledata.php / atas.php / left.php
   - mysql_* (sesuai codebase existing)
   - filter Class Code pakai query yang SAMA PERSIS dengan
     vip_student_record.php ($query_cl_code), termasuk filter periode
     tanggal mulai kelas (f.min_mulai)
   - skor Placement/Mid/Final diambil dari vip_class_score_profile
     (kolom L, other, S, R, W, total, jns_test) -- diadopsi dari
     $query_cek_score / $query_score_mid / $query_score_final di
     vip_class_student_list.php. Placement Test (jns_test=1) TIDAK
     difilter class_code (sama seperti file asli), dan fallback ke
     ves_inc.tb_acd_history kalau belum ada baris di
     vip_class_score_profile. Mid (jns_test=2) & Final (jns_test=3)
     tetap difilter class_code, sama seperti file asli.
   - nama guru (Teacher(s)) diambil dari vip_teacher_schedule.nm_teacher
     -- sama seperti $query_teacher di file asli
   - Final Test Date diambil dari test_date pada jns_test = '3' (Final),
     sama seperti logic skor final di file asli

   ALUR:
   1) Pilih Class Code (dropdown, query sama dgn vip_student_record.php)
   2) Pilih Student di kelas itu (dropdown, muncul setelah Class Code
      dipilih)
   3) Section 1 & 2 otomatis terisi dari DB (read-only)
   4) Section 3-7 diisi manual oleh Teacher/Academic Supervisor,
      lalu disimpan (tombol "Save Review")

   CATATAN PENTING:
   - Tabel vip_student_data punya kd_biodata yang bisa dobel (sudah
     ditemukan sebelumnya di laporan lain) -- dropdown Student & query
     nama di sini SENGAJA di-GROUP BY / derived-table supaya tidak
     muncul nama dobel.
   - Penyimpanan review (Save Review) butuh tabel BARU yang belum ada
     di database, namanya vip_academic_review. Bikin dulu tabelnya
     pakai SQL ini sebelum tombol Save dipakai:

       CREATE TABLE ves_data.vip_academic_review (
         id INT AUTO_INCREMENT PRIMARY KEY,
         kd_biodata VARCHAR(50),
         kd_class VARCHAR(50),
         nama_lengkap VARCHAR(150),
         nm_program VARCHAR(150),
         level_program VARCHAR(100),
         teacher_name VARCHAR(255),
         final_test_date DATE NULL,
         placement_l VARCHAR(10),
         placement_st VARCHAR(10),
         placement_s VARCHAR(10),
         placement_r VARCHAR(10),
         placement_w VARCHAR(10),
         placement_total VARCHAR(10),
         mid_l VARCHAR(10),
         mid_st VARCHAR(10),
         mid_s VARCHAR(10),
         mid_r VARCHAR(10),
         mid_w VARCHAR(10),
         mid_total VARCHAR(10),
         final_l VARCHAR(10),
         final_st VARCHAR(10),
         final_s VARCHAR(10),
         final_r VARCHAR(10),
         final_w VARCHAR(10),
         final_total VARCHAR(10),
         reason_review TEXT,
         observations TEXT,
         support_provided TEXT,
         recommended_followup TEXT,
         vcms_status TEXT,
         pic VARCHAR(150),
         created_by VARCHAR(150),
         created_at DATETIME
       );

     Kalau tabel vip_academic_review SUDAH ada dari sebelumnya (versi
     tanpa kolom skor/pic, ATAU versi dgn kolom score_label/mf_* yang
     sempat dikirim sebelumnya), lihat create_vip_academic_review.sql
     untuk ALTER TABLE yang sesuai (ada opsi utk install baru & utk
     migrasi dari versi mf_ ke mid_ dan final_ yang terpisah).

   - Kolom "pic" diisi dari $_SESSION['nama_lengkap'] (user yang
     sedang login & menyimpan review). Kolom "created_by" juga diisi
     nilai yang sama (dipertahankan untuk konsistensi dgn file lain
     di codebase ini yang pakai nama created_by).

   - Kolom level_program diambil dari vip_teacher_schedule.level_program
     (ASUMSI nama kolom, sama seperti dipakai di report Open Class
     sebelumnya -- tolong dicek).
   ============================================================ */
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

$hari  = date("d");
$bulan = date("m");
$tahun = date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$date_start = isset($_GET['date_start']) ? in_val('date_start', 'get') : '';
$date_end   = isset($_GET['date_end'])   ? in_val('date_end', 'get')   : '';
$cd_cl      = isset($_GET['cd_cl'])      ? in_val('cd_cl', 'get')      : '';
$kd_biodata = isset($_GET['kd_biodata']) ? in_val('kd_biodata', 'get') : '';

if ($date_start == '') { $date_start = "$tahun-01-01"; }
if ($date_end   == '') { $date_end   = $hari_ini; }

$nama_lengkap_user = isset($_SESSION['nama_lengkap']) && trim($_SESSION['nama_lengkap']) != '' ? $_SESSION['nama_lengkap'] : 'Unknown';

// Filter periode kelas -- SAMA PERSIS dgn vip_student_record.php
$filter_tgl = q_set($__p_filter_tgl, " where f.min_mulai between ? and ? and a.status_kelas = 1 ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
$filter_kelas = ($cd_cl != '' and $cd_cl != 'ALL') ? " and a.kelas = '" . $cd_cl . "' " : " ";

// helper kecil: ambil field POST dengan default '' kalau tidak ada,
// supaya tidak PHP Notice dan supaya field kosong tetap aman disimpan
function pf($arr, $key) {
	return isset($arr[$key]) ? trim($arr[$key]) : '';
}

// ---- Simpan review (POST) ----
$saved = false;
if (isset($_POST['do_save'])) {
	$f = $_POST;

	$v_kd_biodata   = pf($f, 'kd_biodata');
	$v_kd_class     = pf($f, 'kd_class');
	$v_nama         = pf($f, 'nama_lengkap');
	$v_program      = pf($f, 'nm_program');
	$v_level        = pf($f, 'level_program');
	$v_teacher      = pf($f, 'teacher_name');
	$v_final_date   = pf($f, 'final_test_date');
	$v_reason       = pf($f, 'reason_review');
	$v_observ       = pf($f, 'observations');
	$v_support      = pf($f, 'support_provided');
	$v_followup     = pf($f, 'recommended_followup');
	$v_vcms         = pf($f, 'vcms_status');
	$v_date_start   = pf($f, 'date_start');
	$v_date_end     = pf($f, 'date_end');

	// skor Placement, Mid Test & Final Test (ikut hidden field yg sama dgn
	// yg ditampilkan di Section 2 / dipakai di halaman print)
	$v_plc_l     = pf($f, 'plc_L');
	$v_plc_st    = pf($f, 'plc_St');
	$v_plc_s     = pf($f, 'plc_S');
	$v_plc_r     = pf($f, 'plc_R');
	$v_plc_w     = pf($f, 'plc_W');
	$v_plc_total = pf($f, 'plc_Total');
	$v_mid_l     = pf($f, 'mid_L');
	$v_mid_st    = pf($f, 'mid_St');
	$v_mid_s     = pf($f, 'mid_S');
	$v_mid_r     = pf($f, 'mid_R');
	$v_mid_w     = pf($f, 'mid_W');
	$v_mid_total = pf($f, 'mid_Total');
	$v_fin_l     = pf($f, 'fin_L');
	$v_fin_st    = pf($f, 'fin_St');
	$v_fin_s     = pf($f, 'fin_S');
	$v_fin_r     = pf($f, 'fin_R');
	$v_fin_w     = pf($f, 'fin_W');
	$v_fin_total = pf($f, 'fin_Total');

	// PIC = yang menyimpan review, diambil dari session, sama seperti created_by
	$v_pic = $nama_lengkap_user;

	if ($v_kd_biodata == '' or $v_kd_class == '') {
		die("Gagal menyimpan: Class Code / Student belum dipilih. Silakan kembali dan pilih ulang.");
	}

	$ins = q_set($__p_ins, "INSERT INTO ves_data.vip_academic_review\r
\t\t(kd_biodata, kd_class, nama_lengkap, nm_program, level_program, teacher_name, final_test_date,\r
\t\t placement_l, placement_st, placement_s, placement_r, placement_w, placement_total,\r
\t\t mid_l, mid_st, mid_s, mid_r, mid_w, mid_total,\r
\t\t final_l, final_st, final_s, final_r, final_w, final_total,\r
\t\t reason_review, observations, support_provided, recommended_followup, vcms_status,\r
\t\t pic, created_by, created_at)\r
\t\tVALUES (\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t ? ,\r
\t\t NOW()\r
\t\t)", [(string) ($v_kd_biodata), (string) ($v_kd_class), (string) ($v_nama), (string) ($v_program), (string) ($v_level), (string) ($v_teacher), (string) (($v_final_date != '' ? "'" . $v_final_date . "'" : "NULL")), (string) ($v_plc_l), (string) ($v_plc_st), (string) ($v_plc_s), (string) ($v_plc_r), (string) ($v_plc_w), (string) ($v_plc_total), (string) ($v_mid_l), (string) ($v_mid_st), (string) ($v_mid_s), (string) ($v_mid_r), (string) ($v_mid_w), (string) ($v_mid_total), (string) ($v_fin_l), (string) ($v_fin_st), (string) ($v_fin_s), (string) ($v_fin_r), (string) ($v_fin_w), (string) ($v_fin_total), (string) ($v_reason), (string) ($v_observ), (string) ($v_support), (string) ($v_followup), (string) ($v_vcms), (string) ($v_pic), (string) ($nama_lengkap_user)]);
	// ---- Cek apakah review utk student + kelas ini SUDAH ada. Kalau ada,
	// Save berarti UPDATE (bukan insert baru) dan WAJIB sudah dikonfirmasi
	// user lewat dialog di form (confirm_update = 1). Dicek ulang di server
	// supaya tidak bergantung pada JavaScript. ----
	$existing_id = 0;
	$res_ex = db_query_soft("SELECT id FROM ves_data.vip_academic_review\r
\t\tWHERE kd_biodata = ?\r
\t\tAND kd_class = ?\r
\t\tORDER BY id DESC LIMIT 1", [(string) ($v_kd_biodata), (string) ($v_kd_class)]);
	if ($res_ex && num(db_num_rows($res_ex)) > 0) {
		$row_ex = db_fetch($res_ex, PDO::FETCH_NUM);
		$existing_id = (int) $row_ex[0];
	}

	$is_update = false;
	if (num($existing_id) > 0) {
		if (pf($f, 'confirm_update') != '1') {
			die("Review untuk student & kelas ini sudah ada. Simpan dibatalkan -- silakan kembali dan pilih Update jika ingin menimpa data yang ada.");
		}
		$is_update = true;
		// kolom tanggal ikut diperbarui supaya list menampilkan waktu terbaru;
		// pic = siapa yg terakhir menyimpan, created_by (pembuat awal) dibiarkan
		$upd = q_set($__p_upd, "UPDATE ves_data.vip_academic_review SET\r
\t\t\tnama_lengkap = ? ,\r
\t\t\tnm_program = ? ,\r
\t\t\tlevel_program = ? ,\r
\t\t\tteacher_name = ? ,\r
\t\t\tfinal_test_date = ? ,\r
\t\t\tplacement_l = ? ,\r
\t\t\tplacement_st = ? ,\r
\t\t\tplacement_s = ? ,\r
\t\t\tplacement_r = ? ,\r
\t\t\tplacement_w = ? ,\r
\t\t\tplacement_total = ? ,\r
\t\t\tmid_l = ? ,\r
\t\t\tmid_st = ? ,\r
\t\t\tmid_s = ? ,\r
\t\t\tmid_r = ? ,\r
\t\t\tmid_w = ? ,\r
\t\t\tmid_total = ? ,\r
\t\t\tfinal_l = ? ,\r
\t\t\tfinal_st = ? ,\r
\t\t\tfinal_s = ? ,\r
\t\t\tfinal_r = ? ,\r
\t\t\tfinal_w = ? ,\r
\t\t\tfinal_total = ? ,\r
\t\t\treason_review = ? ,\r
\t\t\tobservations = ? ,\r
\t\t\tsupport_provided = ? ,\r
\t\t\trecommended_followup = ? ,\r
\t\t\tvcms_status = ? ,\r
\t\t\tpic = ? ,\r
\t\t\tcreated_at = NOW()\r
\t\t\tWHERE id = ? ", [(string) ($v_nama), (string) ($v_program), (string) ($v_level), (string) ($v_teacher), (string) (($v_final_date != '' ? "'" . $v_final_date . "'" : "NULL")), (string) ($v_plc_l), (string) ($v_plc_st), (string) ($v_plc_s), (string) ($v_plc_r), (string) ($v_plc_w), (string) ($v_plc_total), (string) ($v_mid_l), (string) ($v_mid_st), (string) ($v_mid_s), (string) ($v_mid_r), (string) ($v_mid_w), (string) ($v_mid_total), (string) ($v_fin_l), (string) ($v_fin_st), (string) ($v_fin_s), (string) ($v_fin_r), (string) ($v_fin_w), (string) ($v_fin_total), (string) ($v_reason), (string) ($v_observ), (string) ($v_support), (string) ($v_followup), (string) ($v_vcms), (string) ($v_pic), (string) ($existing_id)]);
		db_query_or_die("Gagal update: " . '', $upd, $__p_upd ?? []);
		$new_review_id = $existing_id;
	} else {
		db_query_or_die("Gagal menyimpan (cek apakah tabel vip_academic_review sudah dibuat/di-update -- lihat create_vip_academic_review.sql): " . '', $ins, $__p_ins ?? []);
		$new_review_id = db_insert_id();
	}

	// ====== Notifikasi ke Academic Supervisor kalau ada input baru ======
	// Daftar penerima notifikasi -- hardcode sesuai permintaan. Kalau nanti
	// mau nambah/kurangi penerima, tinggal ubah array ini saja.
	$notif_recipients = array('Savita Rachma Indrayani', 'Arsyi Aisyah', 'Luqman Sakha Ghia');
	$notif_message = $v_pic . ($is_update ? ' memperbarui' : ' menginput') . ' Academic Review untuk ' . $v_nama . ' (Kelas ' . $v_kd_class . ')';
	$notif_message_sql = $notif_message;
	foreach ($notif_recipients as $target) {
		// tidak perlu notif ke diri sendiri kalau yang nyimpan kebetulan
		// salah satu dari daftar penerima
		if (strcasecmp(trim($target), trim($v_pic)) === 0) { continue; }
		$target_sql = $target;
		$ins_notif = q_set($__p_ins_notif, "INSERT INTO ves_data.vip_academic_review_notif\r
\t\t\t(review_id, kd_class, nama_lengkap, message, created_by, target_user, is_read, created_at)\r
\t\t\tVALUES (\r
\t\t\t ? ,\r
\t\t\t ? ,\r
\t\t\t ? ,\r
\t\t\t ? ,\r
\t\t\t ? ,\r
\t\t\t ? ,\r
\t\t\t 0,\r
\t\t\t NOW()\r
\t\t\t)", [(string) ($new_review_id), (string) ($v_kd_class), (string) ($v_nama), (string) ($notif_message_sql), (string) ($v_pic), (string) ($target_sql)]);
		// kegagalan insert notif TIDAK boleh menggagalkan proses Save utama,
		// makanya tidak pakai die() di sini
		db_query_soft($ins_notif, $__p_ins_notif ?? []);
	}

	// redirect supaya data tidak ke-submit dobel kalau halaman di-refresh,
	// dan supaya filter period / pilihan class & student tetap kebawa
	$redir_date_start = $v_date_start != '' ? $v_date_start : $date_start;
	$redir_date_end   = $v_date_end   != '' ? $v_date_end   : $date_end;
	// setelah Save, kembali ke halaman list (bukan tetap di form)
	$redir_url = "vip_academic_review_list.php?date_start=" . urlencode($redir_date_start)
		. "&date_end=" . urlencode($redir_date_end)
		. "&saved=" . ($is_update ? "2" : "1");
	if (!headers_sent()) {
		header("Location: $redir_url");
		exit;
	}
	// header() TIDAK bisa dipakai di file ini: include atas.php / left.php /
	// profiledata.php di atas sudah mengeluarkan HTML duluan, jadi
	// headers_sent() selalu true. Makanya redirect dilakukan lewat
	// JavaScript + meta refresh (dan link manual sbg cadangan terakhir).
	$redir_url_html = htmlspecialchars($redir_url);
	echo '<meta http-equiv="refresh" content="0;url=' . e($redir_url_html) . '">';
	echo '<script>window.location.replace(' . json_encode($redir_url) . ');</script>';
	echo '<p style="padding:20px;">Review tersimpan. Mengalihkan ke list... '
		. '<a href="' . e($redir_url_html) . '">klik di sini jika tidak otomatis</a>.</p>';
	exit;
}

$saved_updated = isset($_GET['saved']) && in_val('saved', 'get') == '2';
if (isset($_GET['saved']) && (in_val('saved', 'get') == '1' || in_val('saved', 'get') == '2')) {
	$saved = true;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Student - Academic Review Required</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <style>
    .review-box { border:1px solid #ddd; border-radius:6px; padding:15px 18px; margin-bottom:18px; background:#fff; }
    .review-box h4 { margin-top:0; border-bottom:2px solid #3f7fd1; padding-bottom:8px; color:#3f7fd1; }
    .review-box textarea { width:100%; min-height:90px; }
    .readonly-field { background:#f5f5f5; padding:6px 10px; border-radius:4px; border:1px solid #e3e3e3; min-height:32px; }
    table.score-table { width:100%; border-collapse:collapse; }
    table.score-table th, table.score-table td { border:1px solid #ccc; padding:6px 10px; text-align:center; }
    table.score-table th { background:#dce6f1; }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Student - Academic Review Required</h1>
    </section>
    <section class="content">

      <!-- ====== STEP 1: PILIH CLASS CODE & STUDENT ====== -->
      <form method="get" action="vip_academic_review.php" class="review-box">
        <table width="650" border="0">
          <tr>
            <td width="140"><small><label>Class Period :</label></small></td>
            <td>
              <input type="date" name="date_start" value="<?php echo e($date_start); ?>" onChange="this.form.submit()">
              To
              <input type="date" name="date_end" value="<?php echo e($date_end); ?>" onChange="this.form.submit()">
            </td>
          </tr>
          <tr>
            <td><small><label>Class Code :</label></small></td>
            <td>
              <select class="form-control" name="cd_cl" style="width:auto;display:inline-block;" onChange="this.form.submit()">
                <option value="">-- Pilih Class Code --</option>
<?php
// ---- Query Class Code -- SAMA PERSIS dgn vip_student_record.php ----
$query_cl_code = q_set($__p_query_cl_code, "SELECT a.kelas FROM ves_data.vip_teacher_schedule a\r
\tINNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1\r
\tGROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
\t" . $filter_tgl . " group by a.kelas order by a.kelas", [...($__p_filter_tgl ?? [])]);
$resource_cl_code = db_query_or_die('', $query_cl_code, $__p_query_cl_code ?? []);
while ($row_cl_code = db_fetch($resource_cl_code, PDO::FETCH_NUM)) {
	echo '<option value="' . e($row_cl_code[0]) . '" ' . e(($cd_cl == $row_cl_code[0] ? 'selected' : '')) . '>' . e($row_cl_code[0]) . '</option>';
}
?>
              </select>
            </td>
          </tr>
<?php if ($cd_cl != '') { ?>
          <tr>
            <td><small><label>Student Name :</label></small></td>
            <td>
              <select class="form-control" name="kd_biodata" style="width:auto;display:inline-block;" onChange="this.form.submit()">
                <option value="">-- Pilih Student --</option>
<?php
// ---- Daftar student di kelas ini. vip_student_data punya kd_biodata
// yang bisa dobel, jadi di-GROUP BY di level ini supaya nama tidak
// muncul berkali-kali. ----
$cd_cl_sql = $cd_cl;
$query_student = q_set($__p_query_student, "SELECT d.kd_biodata, MAX(c.nama_lengkap) AS nama_lengkap\r
\tFROM ves_data.vip_billing d\r
\tLEFT JOIN ves_data.vip_student_data c ON d.kd_biodata = c.kd_biodata\r
\tWHERE d.kd_class = ? AND d.kd_biodata IS NOT NULL AND d.kd_biodata <> ''\r
\tGROUP BY d.kd_biodata\r
\tORDER BY nama_lengkap", [(string) ($cd_cl_sql)]);
$resource_student = db_query_or_die('', $query_student, $__p_query_student ?? []);
while ($row_student = db_fetch($resource_student, PDO::FETCH_NUM)) {
	echo '<option value="' . e($row_student[0]) . '" ' . e(($kd_biodata == $row_student[0] ? 'selected' : '')) . '>' . htmlspecialchars($row_student[1]) . '</option>';
}
?>
              </select>
            </td>
          </tr>
<?php } ?>
        </table>
      </form>

<?php
if ($saved) {
	echo '<div class="alert alert-success">' . e(($saved_updated ? 'Review berhasil diperbarui (update).' : 'Review berhasil disimpan.')) . '</div>';
}

if ($cd_cl != '' and $kd_biodata != '') {

	$kd_biodata_sql = $kd_biodata;

	// ---- Nama Student (dedupe, sama alasannya spt dropdown di atas) ----
	$query_nama = q_set($__p_query_nama, "SELECT MAX(nama_lengkap) FROM ves_data.vip_student_data WHERE kd_biodata = ? ", [(string) ($kd_biodata_sql)]);
	$row_nama = db_fetch(db_query_soft($query_nama, $__p_query_nama ?? []), PDO::FETCH_NUM);
	$nama_lengkap_student = $row_nama[0];

	// ---- Program & Level -- dari vip_teacher_schedule + vip_mst_code_prg,
	// sama pola dgn report Open Class sebelumnya. Kolom level_program
	// masih ASUMSI, tolong dicek. ----
	$query_program = q_set($__p_query_program, "SELECT b.nm_program, a.level_program\r
\t\tFROM ves_data.vip_teacher_schedule a\r
\t\tLEFT JOIN ves_data.vip_mst_code_prg b ON a.kode_program = b.kd_program AND a.level_program = b.level_program\r
\t\tWHERE a.kelas = ? LIMIT 1", [(string) ($cd_cl_sql)]);
	$row_program = db_fetch(db_query_soft($query_program, $__p_query_program ?? []), PDO::FETCH_NUM);
	$nm_program    = $row_program ? $row_program[0] : '';
	$level_program = $row_program ? $row_program[1] : '';

	// ---- Teacher(s) -- SAMA PERSIS dgn $query_teacher di vip_student_record.php ----
	$query_teacher = q_set($__p_query_teacher, "select nm_teacher from vip_teacher_schedule where kelas = ? group by nm_teacher", [(string) ($cd_cl_sql)]);
	$resource_teacher = db_query_soft($query_teacher, $__p_query_teacher ?? []);
	$teacher_name = '';
	while ($row_teacher = db_fetch($resource_teacher, PDO::FETCH_NUM)) {
		$teacher_name .= ($teacher_name != '' ? ', ' : '') . $row_teacher[0];
	}

	// ---- Placement Test Score (jns_test = 1) -- diadopsi dari $query_cek_score
	// di vip_class_student_list.php: TIDAK difilter class_code (placement test
	// biasanya diambil sebelum siswa masuk ke kelas tertentu), dan kalau belum
	// ada baris di vip_class_score_profile, fallback ke ves_inc.tb_acd_history
	// (riwayat skor lama), sama seperti pola di file asli. ----
	$query_placement = q_set($__p_query_placement, "SELECT t.L, t.other, t.S, t.R, t.W, t.total FROM ves_data.vip_class_score_profile t\r
\t\tWHERE t.kd_biodata = ? and jns_test = '1'\r
\t\torder by test_date desc limit 1", [(string) ($kd_biodata_sql)]);
	$row_placement = db_fetch(db_query_soft($query_placement, $__p_query_placement ?? []), PDO::FETCH_NUM);
	if (!$row_placement) {
		$query_placement_fallback = q_set($__p_query_placement_fallback, "SELECT t.L, t.other, t.S, t.R, t.W, t.total FROM ves_inc.tb_acd_history t\r
\t\t\tWHERE t.kd_biodata = ?\r
\t\t\torder by no desc limit 1", [(string) ($kd_biodata_sql)]);
		$row_placement = db_fetch(db_query_soft($query_placement_fallback, $__p_query_placement_fallback ?? []), PDO::FETCH_NUM);
	}

	// ---- Mid Test Score (jns_test = 2) -- sama dgn $query_score_mid di file asli ----
	$query_mid = q_set($__p_query_mid, "SELECT t.L, t.other, t.S, t.R, t.W, t.total, t.test_date FROM ves_data.vip_class_score_profile t\r
\t\tWHERE t.kd_biodata = ? and class_code = ? and jns_test = '2'\r
\t\torder by test_date desc limit 1", [(string) ($kd_biodata_sql), (string) ($cd_cl_sql)]);
	$row_mid = db_fetch(db_query_soft($query_mid, $__p_query_mid ?? []), PDO::FETCH_NUM);

	// ---- Final Test Score (jns_test = 3) -- sama dgn $query_score_final di file asli ----
	$query_final = q_set($__p_query_final, "SELECT t.L, t.other, t.S, t.R, t.W, t.total, t.test_date FROM ves_data.vip_class_score_profile t\r
\t\tWHERE t.kd_biodata = ? and class_code = ? and jns_test = '3'\r
\t\torder by test_date desc limit 1", [(string) ($kd_biodata_sql), (string) ($cd_cl_sql)]);
	$row_final = db_fetch(db_query_soft($query_final, $__p_query_final ?? []), PDO::FETCH_NUM);

	// Final Test Date: pakai tanggal Final kalau ada, kalau belum ada Final
	// pakai tanggal Mid supaya Section 1 tetap terisi
	$final_test_date = $row_final ? $row_final[6] : ($row_mid ? $row_mid[6] : '');

	// ---- Ambil review TERAKHIR yang pernah disimpan untuk siswa+kelas ini
	// (kalau ada), supaya setelah Save form TIDAK kosong lagi -- isian
	// sebelumnya tetap tampil & bisa diedit/disimpan ulang. ----
	$existing_review = null;
	$query_existing = q_set($__p_query_existing, "SELECT reason_review, observations, support_provided, recommended_followup, vcms_status, pic, created_at\r
\t\tFROM ves_data.vip_academic_review\r
\t\tWHERE kd_biodata = ? AND kd_class = ?\r
\t\tORDER BY id DESC LIMIT 1", [(string) ($kd_biodata_sql), (string) ($cd_cl_sql)]);
	$resource_existing = db_query_soft($query_existing, $__p_query_existing ?? []);
	if ($resource_existing && num(db_num_rows($resource_existing)) > 0) {
		$existing_review = db_fetch($resource_existing, PDO::FETCH_NUM);
	}
	$ev_reason   = $existing_review ? $existing_review[0] : '';
	$ev_observ   = $existing_review ? $existing_review[1] : '';
	$ev_support  = $existing_review ? $existing_review[2] : '';
	$ev_followup = $existing_review ? $existing_review[3] : '';
	$ev_vcms     = $existing_review ? $existing_review[4] : '';
?>

      <!-- ====== FORM REVIEW ====== -->
      <form method="post" action="vip_academic_review.php" id="reviewForm"><?php echo csrf_field(); ?>

        <input type="hidden" name="confirm_update" id="confirm_update" value="0">
        <input type="hidden" name="kd_biodata" value="<?php echo htmlspecialchars($kd_biodata); ?>">
        <input type="hidden" name="kd_class" value="<?php echo htmlspecialchars($cd_cl); ?>">
        <input type="hidden" name="nama_lengkap" value="<?php echo htmlspecialchars($nama_lengkap_student); ?>">
        <input type="hidden" name="nm_program" value="<?php echo htmlspecialchars($nm_program); ?>">
        <input type="hidden" name="level_program" value="<?php echo htmlspecialchars($level_program); ?>">
        <input type="hidden" name="teacher_name" value="<?php echo htmlspecialchars($teacher_name); ?>">
        <input type="hidden" name="final_test_date" value="<?php echo htmlspecialchars($final_test_date); ?>">
        <input type="hidden" name="date_start" value="<?php echo htmlspecialchars($date_start); ?>">
        <input type="hidden" name="date_end" value="<?php echo htmlspecialchars($date_end); ?>">
        <input type="hidden" name="plc_L" value="<?php echo e($row_placement ? htmlspecialchars($row_placement[0]) : ''); ?>">
        <input type="hidden" name="plc_St" value="<?php echo e($row_placement ? htmlspecialchars($row_placement[1]) : ''); ?>">
        <input type="hidden" name="plc_S" value="<?php echo e($row_placement ? htmlspecialchars($row_placement[2]) : ''); ?>">
        <input type="hidden" name="plc_R" value="<?php echo e($row_placement ? htmlspecialchars($row_placement[3]) : ''); ?>">
        <input type="hidden" name="plc_W" value="<?php echo e($row_placement ? htmlspecialchars($row_placement[4]) : ''); ?>">
        <input type="hidden" name="plc_Total" value="<?php echo e($row_placement ? htmlspecialchars($row_placement[5]) : ''); ?>">
        <input type="hidden" name="mid_L" value="<?php echo e($row_mid ? htmlspecialchars($row_mid[0]) : ''); ?>">
        <input type="hidden" name="mid_St" value="<?php echo e($row_mid ? htmlspecialchars($row_mid[1]) : ''); ?>">
        <input type="hidden" name="mid_S" value="<?php echo e($row_mid ? htmlspecialchars($row_mid[2]) : ''); ?>">
        <input type="hidden" name="mid_R" value="<?php echo e($row_mid ? htmlspecialchars($row_mid[3]) : ''); ?>">
        <input type="hidden" name="mid_W" value="<?php echo e($row_mid ? htmlspecialchars($row_mid[4]) : ''); ?>">
        <input type="hidden" name="mid_Total" value="<?php echo e($row_mid ? htmlspecialchars($row_mid[5]) : ''); ?>">
        <input type="hidden" name="fin_L" value="<?php echo e($row_final ? htmlspecialchars($row_final[0]) : ''); ?>">
        <input type="hidden" name="fin_St" value="<?php echo e($row_final ? htmlspecialchars($row_final[1]) : ''); ?>">
        <input type="hidden" name="fin_S" value="<?php echo e($row_final ? htmlspecialchars($row_final[2]) : ''); ?>">
        <input type="hidden" name="fin_R" value="<?php echo e($row_final ? htmlspecialchars($row_final[3]) : ''); ?>">
        <input type="hidden" name="fin_W" value="<?php echo e($row_final ? htmlspecialchars($row_final[4]) : ''); ?>">
        <input type="hidden" name="fin_Total" value="<?php echo e($row_final ? htmlspecialchars($row_final[5]) : ''); ?>">

        <?php if ($existing_review) { ?>
        <div class="alert alert-info" style="margin-bottom:12px;">
          Review terakhir untuk siswa ini disimpan oleh <b><?php echo htmlspecialchars($existing_review[5]); ?></b>
          pada <?php echo date('d M Y H:i', strtotime($existing_review[6])); ?>. Review untuk student &amp; kelas ini sudah ada, isian di bawah dimuat dari data tersebut. Saat menekan Save, kamu akan ditanya apakah data yang ada mau di-update atau dibatalkan.
        </div>
        <?php } ?>

        <div class="review-box">
          <h4>1. Student &amp; Class Details</h4>
          <table width="100%">
            <tr><td width="220"><b>Student Name</b></td><td><div class="readonly-field"><?php echo htmlspecialchars($nama_lengkap_student); ?></div></td></tr>
            <tr><td><b>Class Code / Program / Level</b></td><td><div class="readonly-field"><?php echo htmlspecialchars($cd_cl . ' / ' . $nm_program . ' / ' . $level_program); ?></div></td></tr>
            <tr><td><b>Teacher(s)</b></td><td><div class="readonly-field"><?php echo htmlspecialchars($teacher_name); ?></div></td></tr>
            <tr><td><b>Final Test Date</b></td><td><div class="readonly-field"><?php echo e($final_test_date ? date('d M Y', strtotime($final_test_date)) : '-'); ?></div></td></tr>
          </table>
        </div>

        <div class="review-box">
          <h4>2. Score Comparison</h4>
          <table class="score-table">
            <thead>
              <tr><th>Skills</th><th>Placement Test Score</th><th>Mid Test Score</th><th>Final Test Score</th></tr>
            </thead>
            <tbody>
              <tr><td>Listening (L)</td><td><?php echo e($row_placement ? $row_placement[0] : '-'); ?></td><td><?php echo e($row_mid ? $row_mid[0] : '-'); ?></td><td><?php echo e($row_final ? $row_final[0] : '-'); ?></td></tr>
              <tr><td>Reading (R)</td><td><?php echo e($row_placement ? $row_placement[3] : '-'); ?></td><td><?php echo e($row_mid ? $row_mid[3] : '-'); ?></td><td><?php echo e($row_final ? $row_final[3] : '-'); ?></td></tr>
              <tr><td>Writing (W)</td><td><?php echo e($row_placement ? $row_placement[4] : '-'); ?></td><td><?php echo e($row_mid ? $row_mid[4] : '-'); ?></td><td><?php echo e($row_final ? $row_final[4] : '-'); ?></td></tr>
              <tr><td>Speaking (S)</td><td><?php echo e($row_placement ? $row_placement[2] : '-'); ?></td><td><?php echo e($row_mid ? $row_mid[2] : '-'); ?></td><td><?php echo e($row_final ? $row_final[2] : '-'); ?></td></tr>
              <tr><td>Structure (St)</td><td><?php echo e($row_placement ? $row_placement[1] : '-'); ?></td><td><?php echo e($row_mid ? $row_mid[1] : '-'); ?></td><td><?php echo e($row_final ? $row_final[1] : '-'); ?></td></tr>
              <tr style="font-weight:bold;"><td>Overall</td><td><?php echo e($row_placement ? $row_placement[5] : '-'); ?></td><td><?php echo e($row_mid ? $row_mid[5] : '-'); ?></td><td><?php echo e($row_final ? $row_final[5] : '-'); ?></td></tr>
            </tbody>
          </table>
        </div>

        <div class="review-box">
          <h4>3. Reason for Review</h4>
          <textarea name="reason_review" placeholder="Identify unmet targets, declining scores, and/or unchanged scores."><?php echo htmlspecialchars($ev_reason); ?></textarea>
        </div>

        <div class="review-box">
          <h4>4. Observations &amp; Possible Contributing Factors</h4>
          <textarea name="observations" placeholder="Provide specific evidence from classroom performance and the Final Test. Distinguish observed facts from possible explanations."><?php echo htmlspecialchars($ev_observ); ?></textarea>
        </div>

        <div class="review-box">
          <h4>5. Support Provided &amp; Coordination with Pairing Teacher</h4>
          <textarea name="support_provided" placeholder='Describe the support already provided, concerns discussed with the pairing teacher, agreed actions, and the student&#39;s response. Write "Not applicable" for classes without a pairing teacher.'><?php echo htmlspecialchars($ev_support); ?></textarea>
        </div>

        <div class="review-box">
          <h4>6. Recommended Follow-up</h4>
          <textarea name="recommended_followup" placeholder="Identify priority skills and suggest specific practice or further preparation for the Academic Supervisor's consideration."><?php echo htmlspecialchars($ev_followup); ?></textarea>
        </div>

        <div class="review-box">
          <h4>7. VCMS Status</h4>
          <textarea name="vcms_status" placeholder="Confirm that Mid/Final Test scores and teacher comments have been submitted."><?php echo htmlspecialchars($ev_vcms); ?></textarea>
        </div>

        <button type="submit" name="do_save" formaction="vip_academic_review.php" class="btn btn-primary btn-lg"
<?php if ($existing_review) { ?>
          onclick="if (!confirm('Review untuk student & kelas ini sudah ada.\n\nOK = UPDATE data yang ada dengan isian ini\nCancel = BATAL (tidak ada yang disimpan)')) { return false; } document.getElementById('confirm_update').value = '1';"
<?php } ?>
        >
          <i class="fa fa-save"></i> Save Review
        </button>
        <button type="submit" name="do_print" formaction="vip_academic_review_print.php" formtarget="_blank" class="btn btn-default btn-lg">
          <i class="fa fa-print"></i> Print
        </button>
      </form>

<?php
}
?>

    </section>
  </div>
</div>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/app.min.js"></script>
</body>
</html>