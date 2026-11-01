<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdb=in_val('kdb', 'get');
$kdc=in_val('kdc', 'get');

$query_cek = q_set($__p_query_cek, "SELECT * FROM ves_data.ve_certificate where kd_biodata = ? and kelas = ? ", [(string) ($kdb), (string) ($kdc)]);	
$resource_query_cek = db_query_or_die('errro_simpan', $query_cek, $__p_query_cek ?? []);	
if (num($propose) ==2)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VE Incentive Claim Processed');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}
elseif (num($propose) ==3)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VE Incentive Claim Approved');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}
elseif (num($propose) ==4)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VE Incentive Claim Acknowledge');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}

?>