<?php
include __DIR__ . "/conndb.php";
if (auth_check()) {
	// Catat jam keluar (dulu dilakukan lewat include atas.php).
	$hari_ini = $_SESSION['hari_ini'] ?? date('Y-m-d');
	db_exec(
		"update tb_report_user_login set tgl_out_log = ?, jam_out_log = ? where id_user_log = ? and tgl_in_log = ? and jam_in_log = ?",
		[$hari_ini, date("h:i:s"), $_SESSION['kd_staff'], $hari_ini, $_SESSION['jam_in_log'] ?? '']
	);
}
auth_logout();
js_alert('End Session', 'login.php');
