<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
$ed = in_val('ed', 'get');
$query_admin = q_set($__p_query_admin, "SELECT t.no, t.pic, t.sc_handler,t.kd_biodata, t.enroll_date FROM tb_sales_report t where enroll_date >= ? and sc_handler ='' ", [(string) ($ed) . "-01-01"]); 

$resource_admin = db_query_or_die('errro_1', $query_admin, $__p_query_admin ?? []);
if(num(db_num_rows($resource_admin)) > 0)
	{ 
	while ($row_admin = db_fetch($resource_admin))
		{
		$nm_sc = $row_admin[1];
		$nomor = $row_admin[0];
		$kd_biodata = $row_admin[3];
		$enroll_date = $row_admin[4];
		
		$query_sc_list = q_set($__p_query_sc_list, "SELECT distinct nama_detail from tb_user where nama_detail = ? and aktif = 'Y'", [(string) ($nm_sc)]);
		$resource_sc_list = db_query_or_die('errro_7', $query_sc_list, $__p_query_sc_list ?? []);

		if(num(db_num_rows($resource_sc_list)) > 0)
			{ 
			while ($row_sc = db_fetch($resource_sc_list))
				{  
				$sc_handler = $row_sc[0];
				$query_update = q_set($__p_query_update, "update tb_sales_report set sc_handler = ? where no = ? ", [(string) ($sc_handler), (string) ($nomor)]); 
				$resource_update = db_query_or_die('errro_2', $query_update, $__p_query_update ?? []);
				$query_update_adm = q_set($__p_query_update_adm, "update adm_stu_progress set sc_handler = ? where kd_biodata = ? and enroll_date = ? ", [(string) ($sc_handler), (string) ($kd_biodata), (string) ($enroll_date)]);
				$resource_sc_update_adm = db_query_or_die('errro_9', $query_update_adm, $__p_query_update_adm ?? []);				
				}
			}
		else
			{
				$query_update = q_set($__p_query_update, "update tb_sales_report set sc_handler = null where no = ? ", [(string) ($nomor)]); 
				$resource_update = db_query_or_die('errro_3', $query_update, $__p_query_update ?? []);
				$query_update_adm = q_set($__p_query_update_adm, "update adm_stu_progress set sc_handler = null where kd_biodata = ? and enroll_date = ? ", [(string) ($kd_biodata), (string) ($enroll_date)]);
				$resource_sc_update_adm = db_query_or_die('errro_7', $query_update_adm, $__p_query_update_adm ?? []);
			
			}
	}
}


echo "Sampun";
?>