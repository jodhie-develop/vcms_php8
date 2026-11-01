<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
$id = in_val('id', 'get');
$kode_po = in_val('kode_po', 'get');


include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$query_delete = q_set($__p_query_delete, "delete from purchase_order where  kode = ? ", [(string) ($kode_po)]);	
$resource_po = db_query_or_die('errro_1', $query_delete, $__p_query_delete ?? []);
$query_delete = q_set($__p_query_delete, "delete from purchase_order_item where  kode = ? ", [(string) ($kode_po)]);	
$resource_po = db_query_or_die('errro_2', $query_delete, $__p_query_delete ?? []);
$query_delete = q_set($__p_query_delete, "delete from purchase_order_file where  kode = ? ", [(string) ($kode_po)]);	
$resource_po = db_query_or_die('errro_3', $query_delete, $__p_query_delete ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Purchase Order Propose Deleted');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";
?>