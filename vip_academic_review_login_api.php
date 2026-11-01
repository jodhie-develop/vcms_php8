<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login('json');
/* ============================================================
   API kecil utk popup login di vip_academic_review_list.php.

   Logic login ("cek saja") diadopsi dari login.php: cocokkan
   nama_login + password ke tabel tb_user (aktif = 'Y'/'y'), SAMA
   query-nya dengan login.php. Tapi di sini TIDAK menulis log
   (tb_report_user_login / tb_log_activities) seperti login.php --
   cuma mengecek kredensial & set session, sesuai instruksi
   ("cukup cek saja").

   Semua user aktif di tb_user boleh login di sini. Pembatasan data
   (supervisor melihat semua review, user lain hanya review miliknya)
   dilakukan di halaman list / view lewat vip_academic_review_auth.php.
   ============================================================ */
include __DIR__ . "/conndb.php";
header('Content-Type: application/json; charset=utf-8');


$name     = isset($_POST['name']) ? trim(in_val('name', 'post')) : '';
$password = isset($_POST['password']) ? in_val('password', 'post') : '';

if ($name == '' || $password == '') {
	echo json_encode(array('status' => 'error', 'message' => 'Username & password harus diisi.'));
	exit;
}

$name_sql     = $name;
$password_sql = $password;

// query SAMA PERSIS strukturnya dgn login.php ($query_login)
$query_login = q_set($__p_query_login, "SELECT t.nama_login, t.nama_detail, t.password, t.branch, t.kd_branch, t.no, t.posisi, t.kd_area, t.level_posisi, t.usergroup\r
\tFROM tb_user t\r
\tWHERE nama_login = ? AND password = ? AND (aktif = 'Y' OR aktif = 'y')", [(string) ($name_sql), (string) ($password_sql)]);
$resource = db_query_soft($query_login, $__p_query_login ?? []);
if (!$resource) {
	echo json_encode(array('status' => 'error', 'message' => 'Query error: ' . ''));
	exit;
}

if (num(db_num_rows($resource)) == 0) {
	echo json_encode(array('status' => 'error', 'message' => 'Username atau password salah.'));
	exit;
}

$row = db_fetch($resource, PDO::FETCH_NUM);
$nama_lengkap = $row[1];

// login valid & termasuk daftar yg diizinkan -- set session minimal
// yg dipakai di app Student Academic Review ini
$_SESSION['st_login']     = 1;
$_SESSION['nama_lengkap'] = $nama_lengkap;
$_SESSION['nama_depan']   = $row[0];
$_SESSION['kd_staff']     = $row[5];
$_SESSION['posisi']       = $row[6];
$_SESSION['kd_branch']    = $row[4];
$_SESSION['branch']       = $row[3];

echo json_encode(array('status' => 'ok', 'nama_lengkap' => $nama_lengkap));
