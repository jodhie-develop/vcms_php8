<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$id = in_val('id', 'get');
$kd = in_val('kd', 'get');

$query_file = q_set($__p_query_file, "delete  FROM purchase_order_item where id = ? ", [(string) ($id)]);

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
	echo "<script type=\"text/javascript\">\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";
?>	
