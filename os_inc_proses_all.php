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
$noinc=in_val('noinc', 'get');
$propose=in_val('propose', 'get');
$sc = in_val('nmsc', 'get');
$dt = in_val('dt', 'get');
$de = in_val('de', 'get');

		$kdcbg = in_val('kdcbg', 'get');

	if ($noinc == 'all' and $kdcbg == '111' and $sc=='All')
		{

		$query = q_set($__p_query, "update vos_incentive set  st_reward = '3',acknowledge_by = ? , acknowledge_date = ? where st_reward = 2 and dt_entry between ? and ? ", [(string) ($nama_lengkap), (string) ($tgl_hari_ini) . " ", (string) ($dt), (string) ($de)]);		
		}
	elseif ($noinc == 'all' and $kdcbg != '111'  and $sc=='All')
		{

		$query = q_set($__p_query, "update vos_incentive set  st_reward = '3',acknowledge_by = ? , acknowledge_date = ? where st_reward = 2 and dt_entry between ? and ? and kd_branch = ? ", [(string) ($nama_lengkap), (string) ($tgl_hari_ini) . " ", (string) ($dt), (string) ($de), (string) ($kdcbg)]);		
		}	
	else
		{
		$query = q_set($__p_query, "update vos_incentive set  st_reward = '3',acknowledge_by = ? , acknowledge_date = ? where st_reward = 2 and dt_entry between ? and ? and nama_sc = ? ", [(string) ($nama_lengkap), (string) ($tgl_hari_ini) . " ", (string) ($dt), (string) ($de), (string) ($sc)]);			
		}

			$resource_data_sales = db_query_soft($query, $__p_query ?? []);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VOS Incentive Claim Acknwoledge');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";


?>