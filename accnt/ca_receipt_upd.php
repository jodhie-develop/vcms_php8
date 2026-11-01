<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$no = in_val('no', 'get');
$kd_branch = $_SESSION['kd_branch'];

$query = q_set($__p_query, "update ves_data.vip_billing_payment set check_paid = 1 where no = ? ", [(string) ($no)]);

$resource = db_query_soft($query, $__p_query ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "alert('CA Receipt Checked');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";

?>