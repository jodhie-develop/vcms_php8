<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login('json');
/* ============================================================
   API kecil utk tombol "Tandai Checked" di kolom "Checked By" pada
   vip_academic_review_list.php. Merekam SIAPA yg menekan tombol
   (dari $_SESSION['nama_lengkap']) & KAPAN, ke kolom checked_by /
   checked_at di tabel vip_academic_review. Ini terpisah dari kolom
   "pic" (yg isi/input review-nya).
   ============================================================ */
include __DIR__ . "/conndb.php";
header('Content-Type: application/json; charset=utf-8');

include __DIR__ . "/vip_academic_review_auth.php";
if (!ar_is_supervisor()) {
	echo json_encode(array('status' => 'error', 'message' => 'Tidak punya akses / sesi habis. Silakan login ulang.'));
	exit;
}

$action = isset($_POST['action']) ? in_val('action', 'post') : (isset($_GET['action']) ? in_val('action', 'get') : '');
$id     = isset($_POST['id'])     ? (int) in_val('id', 'post')     : (isset($_GET['id']) ? (int) in_val('id', 'get') : 0);

$checker = isset($_SESSION['nama_lengkap']) && trim($_SESSION['nama_lengkap']) != '' ? $_SESSION['nama_lengkap'] : 'Unknown';

if ($action == 'mark_checked' && num($id) > 0) {
	$checker_sql = $checker;
	$q = q_set($__p_q, "UPDATE ves_data.vip_academic_review SET checked_by = ? , checked_at = NOW() WHERE id = ? ", [(string) ($checker_sql), (string) ($id)]);
	if (!db_query_soft($q, $__p_q ?? [])) {
		echo json_encode(array('status' => 'error', 'message' => ''));
		exit;
	}
	echo json_encode(array(
		'status' => 'ok',
		'checked_by' => $checker,
		'checked_at_display' => date('d M Y H:i')
	));
	exit;
}

echo json_encode(array('status' => 'error', 'message' => 'Permintaan tidak valid (action/id).'));
