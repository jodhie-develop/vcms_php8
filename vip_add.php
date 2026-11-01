<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcl = in_val('kdcl', 'get');
$kdb = in_val('kdb', 'get');
$lvl = in_val('lvl', 'get');
$kdcbg = in_val('kdcbg', 'get');

$query_billing = q_set($__p_query_billing, "SELECT level_program FROM vip_teacher_schedule where kelas = ?  group by level_program", [(string) ($kdcl)]);

$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$lvl = $row_billing[0];
		}
	}
	$query_update = q_set($__p_query_update, "update ves_data.vip_billing set kd_class =? , level_program = ? where kd_billing = ? ", [(string) ($kdcl), (string) ($lvl), (string) ($kdb)]);
	$resource_simpan = db_query_or_die('errro_simpan', $query_update, $__p_query_update ?? []);	 
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VIP Student Added to Class');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";		

?>