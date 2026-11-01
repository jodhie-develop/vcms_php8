<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
include __DIR__ . "/conndb.php";
$id	 = in_val('id', 'get');
$s = in_val('s', 'get');
if(num($s) ==1){$status_kelas = '702';}
elseif(num($s) ==2){$status_kelas = '703';}
$query_simpan_program = q_set($__p_query_simpan_program, "update vip_teacher_schedule set status_kelas  =? where id = ? ", [(string) ($status_kelas), (string) ($id)]);	
$resource_simpan_score_class = db_query_or_die('errro_simpan2', $query_simpan_program, $__p_query_simpan_program ?? []);
echo "<script type=\"text/javascript\">\n";

echo "window.opener.location.reload(true);\n";
echo "window.close(); \n";				
echo "</script>";		
?>