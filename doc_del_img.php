<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$id = in_val('id', 'get');
$query_file = q_set($__p_query_file, "SELECT nama_file FROM adm_doc where id = ? ", [(string) ($id)]);

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
if(num(db_num_rows($resource_file)) > 0)
{
	while ($row_file  =  db_fetch($resource_file, PDO::FETCH_NUM))
		{
		$nama_file = $row_file[2]; 
		}
}
unlink("doc_vos/" . basename((string) $nama_file));
$query_file = q_set($__p_query_file, "delete  FROM adm_doc where id = ? ", [(string) ($id)]);
$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
	echo "<script type=\"text/javascript\">\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";
?>	
