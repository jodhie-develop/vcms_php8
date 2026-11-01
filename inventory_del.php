<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$id = in_val('id', 'get');
$query = q_set($__p_query, "delete from  ves_data.mst_asset_reg_dtl where id =? ", [(string) ($id)]);
$resource = db_query_soft($query, $__p_query ?? []);
	echo "<script type=\"text/javascript\">\n";

	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";			
	echo "</script>";
?>