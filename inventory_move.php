<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari_ini = date("Y-m-d");
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 

$id = in_val('id', 'get');
$storage = in_val('stor', 'get');
	if ($storage =='East Sby'){$kd_branch_dipilih='1';}
	elseif ($storage =='West Sby'){$kd_branch_dipilih='2';}
	elseif ($storage =='Denpasar'){$kd_branch_dipilih='3';}
	elseif ($storage =='Malang'){$kd_branch_dipilih='8';}
	elseif ($storage =='South Jkt'){$kd_branch_dipilih='4';}
	elseif ($storage =='North Jkt'){$kd_branch_dipilih='5';}
	elseif ($storage =='West Jkt'){$kd_branch_dipilih='6';}
	elseif ($storage =='Bandung'){$kd_branch_dipilih='7';}
	elseif ($storage =='Vpro East'){$kd_branch_dipilih='11';}
	elseif ($storage =='Vpro West'){$kd_branch_dipilih='12';}
	elseif ($storage =='HO'){$kd_branch_dipilih='10';}

$mv = in_val('mv', 'get');
if (num($mv) == 1)
	{
	if ($storage != '')
		{	
		$query = q_set($__p_query, "update  ves_data.mst_asset_reg_dtl set storage = ? ,kd_cbg = ? , status = 2 where id =? ", [(string) ($storage), (string) ($kd_branch_dipilih), (string) ($id)]);
		}
	echo "<script type=\"text/javascript\">\n";
	echo "window.history.go(-1);\n";
	echo "</script>";
	}
elseif (num($mv) == 0)
	{
	$query_reg_dtl= q_set($__p_query_reg_dtl, "SELECT reg_code from ves_data.mst_asset_reg_dtl where id = ?  ", [(string) ($id)]);
	$resource_reg_dtl = db_query_soft($query_reg_dtl, $__p_query_reg_dtl ?? []);

	if(num(db_num_rows($resource_reg_dtl)) > 0)
		{
		while ($row_reg_dtl  =  db_fetch($resource_reg_dtl, PDO::FETCH_NUM))
			{
			$reg_code = $row_reg_dtl[0];
			}	
			}		
	$query = q_set($__p_query, "update  ves_data.mst_asset_reg_dtl set status = 1,kd_cbg = ? ,storage = ? ,pic  = ? where id =? ", [(string) ($kdcbg), (string) ($storage), (string) ($nama_lengkap), (string) ($id)]);	
	$resource = db_query_soft($query, $__p_query ?? []);		
	$query = q_set($__p_query, "update mst_asset_move set kd_cbg_destination = ? , pic_destination = ? , dt_entry_receive = ? , status = '1' where reg_code = \r
\t? ", [(string) ($kd_branch_dipilih), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($reg_code)]);	

	$resource = db_query_soft($query, $__p_query ?? []);		
	
	echo "<script type=\"text/javascript\">\n";
	echo "window.history.go(-1);\n";
	echo "</script>";
}
?>