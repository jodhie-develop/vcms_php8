<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kd_cl = in_val('kd_cl', 'get');
$kd_branch = $_SESSION['kd_branch'];

$query = q_set($__p_query, "insert into ca_class_check(class_code, check_by, check_date) values (? ,? ,? )", [(string) ($kd_cl), (string) ($nama_lengkap), (string) ($tgl_hari_ini)]);

$resource = db_query_soft($query, $__p_query ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "alert('CA Open Class Checked');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";

?>