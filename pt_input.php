<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";


$query_enroll_student = q_set($__p_query_enroll_student, "SELECT kd_biodata, nama FROM ves_inc.tb_biodata where branch = 'Medan' and event_st_dtl = 'SMA ST THOMAS 1 IELTS PT'");
$resource_enroll_student= db_query_or_die('errro_visitor1', $query_enroll_student, $__p_query_enroll_student ?? []);
	if(num(db_num_rows($resource_enroll_student)) > 0)
		{
		while ($row_es =   db_fetch($resource_enroll_student, PDO::FETCH_NUM))
			{
			$kd_biodata = $row_es[0];
			$nama = $row_es[1];
			$query_student_data = q_set($__p_query_student_data, "update ves_data.utk_medan set kd_biodata = ? where nama = ? ", [(string) ($kd_biodata), (string) ($nama)]);
			$resource_student_data = db_query_or_die('errro_visitor1', $query_student_data, $__p_query_student_data ?? []);
			
		}
	}
		echo "selesai";die;
?>