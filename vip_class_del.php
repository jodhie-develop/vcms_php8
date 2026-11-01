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
$kd = in_val('kd', 'get');
$query = q_set($__p_query, "delete FROM ves_data.vip_teacher_schedule where kelas = ? ", [(string) ($kd)]);
$resource_simpan_payment = db_query_or_die('errro_simpan', $query, $__p_query ?? []);		
		
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Class Deleted');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";
?>