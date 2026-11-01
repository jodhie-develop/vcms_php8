<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
/* ============================================================
   Helper akses app "Student Academic Review" (dashboard, list, view,
   notifikasi). Dipakai bersama supaya daftar user yang boleh akses
   cukup diubah di SATU tempat ini.

   Aturan: login (st_login = 1) = boleh membuka dashboard & list.
   Academic Supervisor (3 nama di bawah) melihat SEMUA review; user lain
   hanya melihat review yg di-input dirinya sendiri (kolom pic).
   Wajib true dipanggil dulu oleh file yang meng-include.
   ============================================================ */
function ar_allowed_names() {
	return array('Savita Rachma Indrayani', 'Arsyi Aisyah', 'Luqman Sakha Ghia');
}

function ar_is_allowed_name($name) {
	foreach (ar_allowed_names() as $allowed) {
		if (strcasecmp(trim($allowed), trim($name)) === 0) { return true; }
	}
	return false;
}

// sudah login (user V-CMS mana pun yg valid)
function ar_is_logged_in() {
	if (!isset($_SESSION['st_login']) || num($_SESSION['st_login']) != 1) { return false; }
	if (!isset($_SESSION['nama_lengkap']) || trim($_SESSION['nama_lengkap']) == '') { return false; }
	return true;
}

// login + salah satu dari 3 Academic Supervisor (boleh lihat SEMUA review,
// terima notifikasi). User lain hanya melihat review yg dia input sendiri.
function ar_is_supervisor() {
	return ar_is_logged_in() && ar_is_allowed_name($_SESSION['nama_lengkap']);
}
