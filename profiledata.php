<?php
include __DIR__ . "/conndb.php";

$kd_staff = $_SESSION['kd_staff'] ?? '';
$keluar_login = 0;
if ($kd_staff !== '') {
	$resource_login = db_query("SELECT t.nama_login, t.nama_detail, t.branch, t.kd_branch, no, posisi, usergroup FROM tb_user t WHERE no = ?", [$kd_staff]);
	while ($row_login = $resource_login->fetch(PDO::FETCH_NUM))
		{
		$keluar_login++;
		$status_login = 1;
		$_SESSION['kd_staff']  = $row_login[4];
		$_SESSION['nama_lengkap']  = $row_login[1];
		$_SESSION['nama_depan']= $row_login[0];
		$_SESSION['kd_branch'] = $row_login[3];
		$_SESSION['posisi']  = $row_login[5];
		$_SESSION['usergroup']  = $row_login[6];
		}
}
