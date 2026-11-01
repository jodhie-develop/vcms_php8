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
$sc = in_val('sc', 'get');
		$kdcbg = in_val('kdcbg', 'get');

if (num($propose) ==2){
$query = q_set($__p_query, "update ves_data.ve_incentive set st_reward = ? , dt_entry = ? , pic = ? where no = ? ", [(string) ($propose), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($noinc)]);
}
elseif (num($propose) ==3)
{
	if($noinc =='all')
	{$query = q_set($__p_query, "update ves_data.ve_incentive set st_reward = ? ,approved_by = ? ,approved_date =  ? where  st_reward = 2", [(string) ($propose), (string) ($nama_lengkap), (string) ($tgl_hari_ini)]);	}
	else{$query = q_set($__p_query, "update ves_data.ve_incentive set st_reward = ? ,approved_by = ? ,approved_date =  ? where no = ? ", [(string) ($propose), (string) ($nama_lengkap), (string) ($tgl_hari_ini), (string) ($noinc)]);	
}
}
elseif (num($propose) ==4)
	{

	if ($noinc == 'all' and $kdcbg == '111')
		{

		$query = q_set($__p_query, "update ves_data.ve_incentive set st_reward = ? ,acknowledge_by = ? ,acknowledge_date =  ? where st_reward = 3", [(string) ($propose), (string) ($nama_lengkap), (string) ($tgl_hari_ini)]);		
		}
	elseif ($noinc == 'all' and $kdcbg != '111')
		{

		$query = q_set($__p_query, "update ves_data.ve_incentive set st_reward = ? ,acknowledge_by = ? ,acknowledge_date =  ? where st_reward = 3 and kd_branch = ? ", [(string) ($propose), (string) ($nama_lengkap), (string) ($tgl_hari_ini), (string) ($kdcbg)]);		
		}	
	else
		{
		$query = q_set($__p_query, "update ves_data.ve_incentive set st_reward = ? ,acknowledge_by = ? ,acknowledge_date =  ? where  no = ? ", [(string) ($propose), (string) ($nama_lengkap), (string) ($tgl_hari_ini), (string) ($noinc)]);		
		}

	}
/* echo $query (debug SQL versi lama) dihapus */
$resource_update_payment = db_query_or_die('errro_simpan', $query, $__p_query ?? []);	
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