<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";


$query_enroll_student = q_set($__p_query_enroll_student, "SELECT kd_biodata, l,r FROM ves_data.utk_medan where kd_biodata <> '' order by kd_biodata");
$resource_enroll_student= db_query_or_die('errro_visitor1', $query_enroll_student, $__p_query_enroll_student ?? []);
	if(num(db_num_rows($resource_enroll_student)) > 0)
		{
		while ($row_es =   db_fetch($resource_enroll_student, PDO::FETCH_NUM))
			{
			$kd_biodata = $row_es[0];
			$l = $row_es[1];
			$r = $row_es[2];
			
				$simpan_kntrb = q_set($__p_simpan_kntrb, "update vip_class_score_profile set l = ? ,r=? where kd_biodata = ? ", [(string) ($l), (string) ($r), (string) ($kd_biodata)]);
				$resource_kntrb_mkt_team  = db_query_or_die('errro_simpan_1111', $simpan_kntrb, $__p_simpan_kntrb ?? []);	
				}
			
	}
		echo "selesai";die;
?>