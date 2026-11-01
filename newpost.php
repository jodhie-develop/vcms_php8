<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
ini_set("memory_limit","512M");
include __DIR__ . "/conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_posting = date('Y-m-d H:i:s');
$nama_lengkap =	$_SESSION['nama_lengkap'];
$kd_staff =	$_SESSION['kd_staff'];
$t = in_val('t', 'get');
$r = in_val('r', 'get');
$thread = in_val('thread', 'post');
if (num($t) ==1)
{

	$query_simpan = q_set($__p_query_simpan, "insert into ves_data.disc_topik (kd_topik,kd_ref,pesan,dt_entry,pic)values (? ,0,? ,? ,? )", [(string) ($t), (string) ($thread), (string) ($tgl_posting), (string) ($kd_staff)]);
	$resource_simpan= db_query_or_die('errro_simpans', $query_simpan, $__p_query_simpan ?? []);
}
elseif (num($t)==2)
{

	$query_simpan = q_set($__p_query_simpan, "insert into ves_data.disc_topik (kd_topik,kd_ref,pesan,dt_entry,pic)values (? ,? ,? ,? ,? )", [(string) ($t), (string) ($r), (string) ($thread), (string) ($tgl_posting), (string) ($kd_staff)]);
	$resource_simpan= db_query_or_die('errro_simpans', $query_simpan, $__p_query_simpan ?? []);
}
	
echo "<script type=\"text/javascript\">\n";		
	echo "window.opener.location.reload(true);\n";		
echo "window.close(); \n";	
echo "</script>";		
//=====================
?>