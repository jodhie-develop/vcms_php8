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
$no_sales=in_val('no_sales', 'get');
$propose=in_val('propose', 'get');
$query_data_sales = q_set($__p_query_data_sales, "SELECT t.kd_cabang, t.enroll_date, t.kd_biodata, t.nama,t.kd_school FROM tb_sales_report  t where no =  ? ", [(string) ($no_sales)]);	
$resource_data_sales = db_query_soft($query_data_sales, $__p_query_data_sales ?? []);

if(num(db_num_rows($resource_data_sales)) > 0)
	{
	while ($row_data_sales  =  db_fetch($resource_data_sales, PDO::FETCH_NUM))
		{
		$kd_cabang = $row_data_sales[0];
		$enroll_date = $row_data_sales[1];
		$kd_biodata = $row_data_sales[2];
		$kd_school		 = $row_data_sales[4];

		}
	}

if(num($propose) ==0){
	$query = q_set($__p_query, "insert into vos_incentive(kd_branch, nama_sc,kd_sales_report, kd_biodata, kd_school,st_reward, dt_entry, nominal, remark,pic ) values (? ,? ,? ,? ,? ,'1',? ,'0','',? )", [(string) ($kd_cabang), (string) ($nama_lengkap), (string) ($no_sales), (string) ($kd_biodata), (string) ($kd_school), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);
	$resource_input = db_query_soft($query, $__p_query ?? []);	
	}

elseif (num($propose) ==1){
	$query = q_set($__p_query, "update ves_data.vos_incentive set st_reward = ? , dt_entry = ? , pic = ? where no = ? ", [(string) ($propose), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($noinc)]);
	$resource_input = db_query_soft($query, $__p_query ?? []);	
	}
elseif (num($propose) ==2){	
	$query = q_set($__p_query, "update ves_data.vos_incentive set st_reward = ? ,approved_by = ? ,approved_date =  ? where no = ? ", [(string) ($propose), (string) ($nama_lengkap), (string) ($tgl_hari_ini), (string) ($noinc)]);
	$resource_input = db_query_soft($query, $__p_query ?? []);	
	}
elseif (num($propose) ==3){
	if ($noinc == 'all' and $kdcbg == '111')
		{

		$query = q_set($__p_query, "update ves_data.vos_incentive set st_reward = ? ,acknowledge_by = ? ,acknowledge_date =  ? where st_reward = 3", [(string) ($propose), (string) ($nama_lengkap), (string) ($tgl_hari_ini)]);
		$resource_input = db_query_soft($query, $__p_query ?? []);	
		}
	elseif ($noinc == 'all' and $kdcbg != '111')
		{

		$query = q_set($__p_query, "update ves_data.vos_incentive set st_reward = ? ,acknowledge_by = ? ,acknowledge_date =  ? where st_reward = 3 and kd_branch = ? ", [(string) ($propose), (string) ($nama_lengkap), (string) ($tgl_hari_ini), (string) ($kdcbg)]);
		$resource_input = db_query_soft($query, $__p_query ?? []);	
		}	
	else
		{
		$query = q_set($__p_query, "update ves_data.vos_incentive set st_reward = ? ,acknowledge_by = ? ,acknowledge_date =  ? where  no = ? ", [(string) ($propose), (string) ($nama_lengkap), (string) ($tgl_hari_ini), (string) ($noinc)]);
		$resource_input = db_query_soft($query, $__p_query ?? []);	
		}

	}

if (num($propose) ==0)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VOS  Incentive Claim Processed');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}
elseif (num($propose) ==1)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VOS Incentive Claim Approved');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}
elseif (num($propose) ==2)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VOS Incentive Claim Acknowledge');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}

?>