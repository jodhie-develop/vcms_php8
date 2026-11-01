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


$nl = in_val('nl', 'get');
$nb = in_val('nb', 'get');
$st = in_val('st', 'get');
if (num($st) == 1)
{
$query_simpan = q_set($__p_query_simpan, "update ves_data.vip_billing set book_status = 'Distribute' where no = ? ", [(string) ($nb)]);
$resource_simpan= db_query_or_die('errro_simpans1', $query_simpan, $__p_query_simpan ?? []);
$query_simpan = q_set($__p_query_simpan, "update ves_data.vip_book_log set book_status = 'Distribute',dt_entry = ? , pic = ? where id = ? ", [(string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nl)]);
$resource_simpan= db_query_or_die('errro_simpans2', $query_simpan, $__p_query_simpan ?? []);
}
else
{
$query_simpan = q_set($__p_query_simpan, "update ves_data.vip_billing set book_status = 'Booked' where no = ? ", [(string) ($nb)]);
$resource_simpan= db_query_or_die('errro_simpans3', $query_simpan, $__p_query_simpan ?? []);
$query_simpan = q_set($__p_query_simpan, "update ves_data.vip_book_log set book_status = 'Booked',dt_entry = ? , pic = ? where id = ? ", [(string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nl)]);
$resource_simpan= db_query_or_die('errro_simpans4', $query_simpan, $__p_query_simpan ?? []);
}
	
echo "<script type=\"text/javascript\">\n";		
	echo "window.opener.location.reload(true);\n";		
echo "window.close(); \n";	
echo "</script>";		
//=====================
?>