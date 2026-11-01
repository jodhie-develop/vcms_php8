<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
$th= in_val('th', 'get');

$query_admission = q_set($__p_query_admission, "SELECT no, step, update_date FROM adm_stu_progress where final_status = 'ON' and (step is not null or step <> '' or step = '') and enroll_date  >= ? and must_update_date is null", [(string) ($th) . "-01-01"]);

//$query_admission = "SELECT no, step, update_date FROM adm_stu_progress where final_status = 'ON' and step ='01:Completing Application Requirements'";
$resource_admission = db_query_or_die('errro_7', $query_admission, $__p_query_admission ?? []);
while ($row_admission =  db_fetch($resource_admission, PDO::FETCH_NUM))
	{
	$no_urut = $row_admission[0];
	$tgl_terakhir = $row_admission[2];
	$step_sekarang =   $row_admission[1];

	if ($step_sekarang !='')
	{
	$query_admission_step = q_set($__p_query_admission_step, "SELECT lama_waktu FROM tb_step_admission where nm_step = ? ", [(string) ($step_sekarang)]);

	$resource_admission_step = db_query_or_die('errro_17', $query_admission_step, $__p_query_admission_step ?? []);
	while ($row_admission_step =  db_fetch($resource_admission_step, PDO::FETCH_NUM))
		{
		$lama_waktu = $row_admission_step[0];
		if ($step_sekarang =='01:Completing Application Requirements'){$tgl_harus = date('Y-m-d', strtotime('+21 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='02: Application Documents Sent'){$tgl_harus = date('Y-m-d', strtotime('+7 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='03: School Admissions Process'){$tgl_harus = date('Y-m-d', strtotime('+30 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='04: Admissions Decision' or $step_sekarang =='4: Admissions Decision'){$tgl_harus = date('Y-m-d', strtotime('+7 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='05: Paid Deposit Tuition Fees'){$tgl_harus = date('Y-m-d', strtotime('+30 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='06: Student Visa Application Process'){$tgl_harus = date('Y-m-d', strtotime('+90 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='07: Student Visa Decision'){$tgl_harus = date('Y-m-d', strtotime('+1 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='08: Accommodation Arrangement Process'){$tgl_harus = date('Y-m-d', strtotime('+60 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='09: Accommodation Confirmation'){$tgl_harus = date('Y-m-d', strtotime('+1 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='10: Flight Details'){$tgl_harus = date('Y-m-d', strtotime('+7 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='11: Airport Pick-up Confirmation'){$tgl_harus = date('Y-m-d', strtotime('+1 days', strtotime($tgl_terakhir)));}
		elseif ($step_sekarang =='12: Pre-Departure Information Preparation'){$tgl_harus = date('Y-m-d', strtotime('+1 days', strtotime($tgl_terakhir)));}
		
		$query_update = q_set($__p_query_update, "update adm_stu_progress set must_update_date = ? where no= ?  ", [(string) ($tgl_harus), (string) ($no_urut)]);	
		$resource_simpan_6= db_query_or_die('errro_simpan6', $query_update, $__p_query_update ?? []);	
		$jml= num($jml)+1;
		}
	} 
}
echo "<script type=\"text/javascript\">\n";
echo "alert('selesai " . e($jml) . "');\n";	
echo "</script>";



?>