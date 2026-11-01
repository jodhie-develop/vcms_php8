<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
ini_set("memory_limit","512M");
include __DIR__ . "/conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$blnhr = "$hari$bulan";
$nama_lengkap =	$_SESSION['nama_lengkap']; 
$id = in_val('id', 'get');
$query_simpan = q_set($__p_query_simpan, "delete from ves_data.rulesmemofile where id = ? ", [(string) ($id)]);

$resource_simpan= db_query_or_die('errro_simpans', $query_simpan, $__p_query_simpan ?? []);

echo "<script type=\"text/javascript\">\n";			
echo "window.close(); \n";	
echo "</script>";		
	
//=====================
?>