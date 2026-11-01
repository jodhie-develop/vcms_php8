<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get();   // cek login sendiri lewat ar_is_logged_in() (respon JSON auth=false)
/* ============================================================
   API kecil utk fitur notifikasi Student Academic Review.
   Dipanggil via AJAX (polling) dari dashboard & list, supaya terasa
   seperti "push notification" tanpa infrastruktur Web Push (VAPID /
   push server) yg tidak tersedia di hosting PHP legacy ini.

   User diambil dari SESSION (bukan dari parameter URL), dan hanya 3
   Academic Supervisor terdaftar yg boleh memakai API ini.

   action=poll          : NON-destruktif. Param after_id=N -> kembalikan
                          notifikasi belum-dibaca dgn id > N (utk
                          popup/notifikasi OS), plus total unread (utk
                          badge di dashboard) & max_id. Tidak menandai
                          dibaca, jadi badge di dashboard tetap menyala
                          sampai user membuka list.
   action=mark_all_read : tandai semua notifikasi user ini sudah dibaca
                          (dipanggil saat user membuka list).
   action=check         : (dipakai halaman list) ambil notifikasi yg belum
                          dibaca sekaligus menandainya dibaca.
   action=unread_count  : hitung jumlah notifikasi belum dibaca.
   ============================================================ */
include __DIR__ . "/conndb.php";
include __DIR__ . "/vip_academic_review_auth.php";
header('Content-Type: application/json; charset=utf-8');

if (!ar_is_logged_in()) {
	echo json_encode(array('notifications' => array(), 'count' => 0, 'max_id' => 0, 'auth' => false));
	exit;
}

$action   = isset($_GET['action']) ? in_val('action', 'get') : '';
$user     = trim($_SESSION['nama_lengkap']);
$user_sql = $user;

if ($action == 'poll') {
	$after_id = isset($_GET['after_id']) ? (int) in_val('after_id', 'get') : 0;

	$count = 0;
	$res = db_query_soft("SELECT COUNT(*), COALESCE(MAX(id), 0) FROM ves_data.vip_academic_review_notif\r
\t\tWHERE target_user = ? AND is_read = 0", [(string) ($user_sql)]);
	$max_id = 0;
	if ($res) {
		$row = $res->fetch(PDO::FETCH_NUM);
		$count  = (int) $row[0];
		$max_id = (int) $row[1];
	}

	$out = array();
	$res = db_query_soft("SELECT id, message, created_at FROM ves_data.vip_academic_review_notif\r
\t\tWHERE target_user = ? AND is_read = 0 AND id > ?  ORDER BY id ASC LIMIT 20", [(string) ($user_sql), (string) ($after_id)]);
	if ($res) {
		while ($row = $res->fetch(PDO::FETCH_NUM)) {
			$out[] = array('id' => (int) $row[0], 'message' => $row[1], 'created_at' => $row[2]);
		}
	}
	echo json_encode(array('auth' => true, 'count' => $count, 'max_id' => $max_id, 'notifications' => $out));
	exit;
}

if ($action == 'mark_all_read') {
	db_query_soft("UPDATE ves_data.vip_academic_review_notif SET is_read = 1\r
\t\tWHERE target_user = ? AND is_read = 0", [(string) ($user_sql)]);
	echo json_encode(array('auth' => true, 'status' => 'ok'));
	exit;
}

if ($action == 'check') {
	$q = q_set($__p_q, "SELECT id, message, created_at FROM ves_data.vip_academic_review_notif\r
\t\tWHERE target_user = ? AND is_read = 0 ORDER BY id ASC LIMIT 20", [(string) ($user_sql)]);
	$res = db_query_soft($q, $__p_q ?? []);
	$out = array();
	$ids = array();
	if ($res) {
		while ($row = $res->fetch(PDO::FETCH_NUM)) {
			$out[] = array('id' => (int) $row[0], 'message' => $row[1], 'created_at' => $row[2]);
			$ids[] = (int) $row[0];
		}
	}
	if (cnt($ids) > 0) {
		$id_list = implode(',', $ids);
		db_query_soft("UPDATE ves_data.vip_academic_review_notif SET is_read = 1 WHERE id IN (" . db_in($ids) . ")", array_values($ids));
	}
	echo json_encode(array('notifications' => $out));
	exit;
}

if ($action == 'unread_count') {
	$q = q_set($__p_q, "SELECT COUNT(*) FROM ves_data.vip_academic_review_notif WHERE target_user = ? AND is_read = 0", [(string) ($user_sql)]);
	$res = db_query_soft($q, $__p_q ?? []);
	$row = $res ? $res->fetch(PDO::FETCH_NUM) : array(0);
	echo json_encode(array('count' => (int) $row[0]));
	exit;
}

echo json_encode(array('error' => 'unknown action'));
