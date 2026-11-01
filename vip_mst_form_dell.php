<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$q = in_val('id', 'get');
$query_scope = q_set($__p_query_scope, "delete  FROM vip_ssq where  id = ? ", [(string) ($id)]);
$resource_scope = db_query_soft($query_scope, $__p_query_scope ?? []);		
echo "<script type=\"text/javascript\">\n";
echo "window.close();\n";
echo " window.opener.location.reload();\n";	
echo "</script>";	
?>