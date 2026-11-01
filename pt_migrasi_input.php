<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";


$query_enroll_student = q_set($__p_query_enroll_student, "SELECT kd_biodata, nama,l,r FROM ves_data.utk_medan");
$resource_enroll_student= db_query_or_die('errro_visitor1', $query_enroll_student, $__p_query_enroll_student ?? []);
	if(num(db_num_rows($resource_enroll_student)) > 0)
		{
		while ($row_es =   db_fetch($resource_enroll_student, PDO::FETCH_NUM))
			{
			$kd_biodata = $row_es[0];
			$l = $row_es[1];
			$r = $row_es[2];
			$query_student_data = q_set($__p_query_student_data, "SELECT kd_biodata FROM ves_data.vip_class_score_profile where kd_biodata = ? ", [(string) ($kd_biodata)]);
			$resource_student_data = db_query_or_die('errro_visitor1', $query_student_data, $__p_query_student_data ?? []);
		if(num(db_num_rows($resource_student_data)) == 0)
			{

				//echo "blm";die;
				$simpan_kntrb = q_set($__p_simpan_kntrb, "insert into ves_data.vip_class_score_profile (kd_cbg, class_code, kd_biodata, jns_test, L, R) values ('14',' - L/R Placement Test',? ,'1',? ,? )", [(string) ($kd_biodata), (string) ($l), (string) ($r)]);
				$resource_kntrb_mkt_team  = db_query_or_die('errro_simpan_1111', $simpan_kntrb, $__p_simpan_kntrb ?? []);	
				}
			
		}
			
		}
	
		echo "selesai";die;
?>