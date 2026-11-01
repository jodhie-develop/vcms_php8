<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'any');
$st = in_val('st', 'any');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

if (num($st) == 1)
	{
	$query_pdo = q_set($__p_query_pdo, "SELECT kd_biodata, kd_branch, student_name, country, p_np, intake_date, pdo_date, enroll_date, nama, passport, referensi, gender, school_name,\r
school_address, cp1_school, cp1_position, cp2_school, cp2_position, school_group, school_website, cp1_email, cp1_phone, cp2_email, cp2_phone,\r
study_1, course_1, major_1, course1_length, course1_start, course1_end, tf1, tf1_paid, term_paid1, balance1, balance1_due_date,\r
study_2, course_2, major_2, course2_length, course2_start, course2_end, tf2, tf2_paid, term_paid2, balance2, balance2_due_date,\r
study_3, course_3, major_3, course3_length, course3_start, course3_end, tf3, tf3_paid, term_paid3, balance3, balance3_due_date,\r
study_4, course_4, major_4, course4_length, course4_start, course4_end, tf4, tf4_paid, term_paid4, balance4, balance4_due_date,\r
housing_type, housing_provider, housing_address, housing_rent_fee, housing_rent_fee_term, housing_rent_fee_paid, housing_paid_term, housing_cp,\r
housing_phone, housing_email, housing_notes,\r
test_type, test_date, test_time, test_venue, test_what_to_bring, test_notes,\r
orientation_date, orientation_time, orientation_venue, orientation_what_to_bring, orientation_agenda,\r
 event_name, event_date, event_time, event_venue, event_what_to_bring, event_notes,\r
  visa_number, visa_valid_from, visa_valid_through, visa_entry, visa_reference, visa_notes, visa_website,\r
  flight_airline, flight_code, flight_departure_from, flight_departure_date, flight_departure_time, flight_arival_at,\r
  flight_arival_date, flight_arival_time, flight_arival_note,guardian_provider,guardian_name,guardian_mail,guardian_phone,guardian_what_to_bring,guardian_notes,portal_user,portal_password,portal_url,portal_kjri,address_kjri,special_notes,orientation_date_start,orientation_date_end FROM ves_pdo where kd_biodata = ? ", [(string) ($kdb)]);

	$resource_pdo = db_query_or_die('errro_71', $query_pdo, $__p_query_pdo ?? []);
	if(num(db_num_rows($resource_pdo)) > 0)
	{	
	while ($rpdo=  db_fetch($resource_pdo, PDO::FETCH_NUM))
		{
		$kd_biodata  = $rpdo['0'];	
		$kdcbg = $rpdo['1'];	
		$nama  = $rpdo['2'];			
		$country = $rpdo['3'];
		$p_np = $rpdo['4'];
		$intake_date = $rpdo['5'];
		$pdo_date = $rpdo['6'];
		$enroll_date = $rpdo['7'];
		$nama = $rpdo['8'];
		$passport = $rpdo['9'];
		$referensi = $rpdo['10'];
		$gender = $rpdo['11'];
		$school_name = $rpdo['12'];
		$school_address = $rpdo['13'];
		$cp1_school = $rpdo['14'];
		$cp1_position = $rpdo['15'];
		$cp2_school = $rpdo['16'];
		$cp2_position = $rpdo['17'];
		$school_group = $rpdo['18'];
		$school_website = $rpdo['19'];
		$cp1_email = $rpdo['20'];
		$cp1_phone = $rpdo['21'];
		$cp2_email = $rpdo['22'];
		$cp2_phone = $rpdo['23'];
		$study_1 = $rpdo['24'];
		$course_1 = $rpdo['25'];
		$major_1 = $rpdo['26'];
		$course1_length = $rpdo['27'];
		$course1_start = $rpdo['28'];
		$course1_end = $rpdo['29'];
		$tf1 = $rpdo['30'];
		$tf1_paid = $rpdo['31'];
		$term_paid1 = $rpdo['32'];
		$balance1 = $rpdo['33'];
		$balance1_due_date = $rpdo['34'];
		$study_2 = $rpdo['35'];
		$course_2 = $rpdo['36'];
		$major_2 = $rpdo['37'];
		$course2_length = $rpdo['38'];
		$course2_start = $rpdo['39'];
		$course2_end = $rpdo['40'];
		$tf2 = $rpdo['41'];
		$tf2_paid = $rpdo['42'];
		$term_paid2 = $rpdo['43'];
		$balance2 = $rpdo['44'];
		$balance2_due_date = $rpdo['45'];
		$study_3 = $rpdo['46'];
		$course_3 = $rpdo['47'];
		$major_3 = $rpdo['48'];
		$course3_length = $rpdo['49'];
		$course3_start = $rpdo['50'];
		$course3_end = $rpdo['51'];
		$tf3 = $rpdo['52'];
		$tf3_paid = $rpdo['53'];
		$term_paid3 = $rpdo['54'];
		$balance3 = $rpdo['55'];
		$balance3_due_date = $rpdo['56'];
		$study_4 = $rpdo['57'];
		$course_4 = $rpdo['58'];
		$major_4 = $rpdo['59'];
		$course4_length = $rpdo['60'];
		$course4_start = $rpdo['61'];
		$course4_end = $rpdo['62'];
		$tf4 = $rpdo['63'];
		$tf4_paid = $rpdo['64'];
		$term_paid4 = $rpdo['65'];
		$balance4 = $rpdo['66'];
		$balance4_due_date = $rpdo['67'];
		$housing_type = $rpdo['68'];
		$housing_provider = $rpdo['69'];
		$housing_address = $rpdo['70'];
		$housing_rent_fee = $rpdo['71'];
		$housing_rent_fee_term = $rpdo['72'];
		$housing_rent_fee_paid = $rpdo['73'];
		$housing_paid_term = $rpdo['74'];
		$housing_cp = $rpdo['75'];
		$housing_phone = $rpdo['76'];
		$housing_email = $rpdo['77'];
		$housing_notes = $rpdo['78'];
		$test_type = $rpdo['79'];
		$test_date = $rpdo['80'];
		$test_time = $rpdo['81'];
		$test_venue = $rpdo['82'];
		$test_what_to_bring = $rpdo['83'];
		$test_notes = $rpdo['84'];
		$orientation_date = $rpdo['85'];
		$orientation_time = $rpdo['86'];
		$orientation_venue = $rpdo['87'];
		$orientation_what_to_bring = $rpdo['88'];
		$orientation_agenda = $rpdo['89'];
		$event_name = $rpdo['90'];
		$event_date = $rpdo['91'];
		$event_time = $rpdo['92'];
		$event_venue = $rpdo['93'];
		$event_what_to_bring = $rpdo['94'];
		$event_notes = $rpdo['95'];
		$visa_number = $rpdo['96'];
		$visa_valid_from = $rpdo['97'];
		$visa_valid_through = $rpdo['98'];
		$visa_entry = $rpdo['99'];
		$visa_reference = $rpdo['100'];
		$visa_notes = $rpdo['101'];
		$visa_website = $rpdo['102'];
		$flight_airline = $rpdo['103'];
		$flight_code = $rpdo['104'];
		$flight_departure_from = $rpdo['105'];
		$flight_departure_date = $rpdo['106'];
		$flight_departure_time = $rpdo['107'];
		$flight_arival_at = $rpdo['108'];
		$flight_arival_date = $rpdo['109'];
		$flight_arival_time = $rpdo['110'];
		$flight_arival_note = $rpdo['111'];
		$guardian_provider = $rpdo['112'];
		$guardian_name = $rpdo['113'];
		$guardian_mail = $rpdo['114'];
		$guardian_phone = $rpdo['115'];
		$guardian_what_to_bring = $rpdo['116'];
		$guardian_notes = $rpdo['117'];
		$portal_user = $rpdo['118'];
		$portal_password = $rpdo['119'];
		$portal_url = $rpdo['120'];
		$kjri_url = $rpdo['121'];
		$kjri_address = $rpdo['122'];
		$special_note = $rpdo['123'];	
		$orientation_date_start = $rpdo['124'];
		$orientation_date_start = $rpdo['125'];
		$branch_name = in_val('branch_name', 'any');
		$branch_address = in_val('branch_address', 'any');
		$branch_phone = in_val('branch_phone', 'any');
		$adm_pic = in_val('adm_pic', 'any');
		$adm_pic_email = in_val('adm_pic_email', 'any');
		$adm_pic_2 = in_val('adm_pic_2', 'any');
		$adm_pic_email_2 = in_val('adm_pic_email_2', 'any');
			
		$st = 0;
		}
	}
	else
	{
	$query_adm = q_set($__p_query_adm, "SELECT kd_biodata, enroll_date, nama,adm_pic,dest_country,dest_school,group_school,p_np, program_clasifie,mp_ap,dest_program,major,h_nh, ar,agent_referal,tf_full_program,pasport,tf_fee_paid, tf_term_paid,tf_balance_fee,tgl_intake,program_duration,comm_date,\r
\tcomm_date_end,pdo_date,remark_problem,remark_solution,next_update, pic,kd_branch, dt_entry,kd_school,tf_balance_fee_due_date,date_format(tgl_intake, '%m'),date_format(tgl_intake, '%Y')  \r
\tFROM  adm_stu_progress a where kd_biodata = ? ", [(string) ($kdb)]);
	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
		$kd_biodata  = $row_adm['0'];
		$enroll_date = $row_adm['1'];
		$nama  = $row_adm['2'];
		//$kdcbg = $row_adm['1'];				
		$country = $row_adm['4'];
		$p_np = $row_adm['7'];
		$intake_date = $row_adm['20'];
		$pdo_date = $row_adm['24'];
		$passport = $row_adm['16'];
		//$referensi = $row_adm['10'];
		//$gender = $row_adm['11'];
		$school_name = $row_adm['5'];
		//$school_address = $row_adm['13'];
		//$cp1_school = $row_adm['14'];
		//$cp1_position = $row_adm['15'];
		//$cp2_school = $row_adm['16'];
		//$cp2_position = $row_adm['17'];
		$school_group = $row_adm['6'];
		//$school_website = $row_adm['19'];
		//$cp1_email = $row_adm['20'];
		//$cp1_phone = $row_adm['21'];
		//$cp2_email = $row_adm['22'];
		//$cp2_phone = $row_adm['23'];
		$study_1 = $row_adm['8'];
		$course_1 = $row_adm['10'];
		$major_1 = $row_adm['11'];
		$course1_length = $row_adm['21'];
		$course1_start = $row_adm['22'];
		$course1_end = $row_adm['23'];
		$tf1 = $row_adm['15'];
		$tf1_paid = $row_adm['17'];
		$term_paid1 = $row_adm['18'];
		$balance1 = $row_adm['19'];
		//$balance1_due_date = $row_adm['34'];
		$study_2 = $row_adm['35'];
		$course_2 = $row_adm['36'];
		$major_2 = $row_adm['37'];
		$course2_length = $row_adm['38'];
		$course2_start = $row_adm['39'];
		$course2_end = $row_adm['40'];
		$tf2 = $row_adm['16'];
		$tf2_paid = $row_adm['18'];
		$term_paid2 = $row_adm['43'];
		$balance2 = $row_adm['44'];
		$balance2_due_date = $row_adm['45'];
		$study_3 = $row_adm['46'];
		$course_3 = $row_adm['47'];
		$major_3 = $row_adm['48'];
		$course3_length = $row_adm['49'];
		$course3_start = $row_adm['50'];
		$course3_end = $row_adm['51'];
		$tf3 = $row_adm['52'];
		$tf3_paid = $row_adm['53'];
		$term_paid3 = $row_adm['54'];
		$balance3 = $row_adm['55'];
		$balance3_due_date = $row_adm['56'];
		$study_4 = $row_adm['57'];
		$course_4 = $row_adm['58'];
		$major_4 = $row_adm['59'];
		$course4_length = $row_adm['60'];
		$course4_start = $row_adm['61'];
		$course4_end = $row_adm['62'];
		$tf4 = $row_adm['63'];
		$tf4_paid = $row_adm['64'];
		$term_paid4 = $row_adm['65'];
		$balance4 = $row_adm['66'];
		$balance4_due_date = $row_adm['67'];
		$housing_type = $row_adm['68'];
		$housing_provider = $row_adm['69'];
		$housing_address = $row_adm['70'];
		$housing_rent_fee = $row_adm['71'];
		$housing_rent_fee_term = $row_adm['72'];
		$housing_rent_fee_paid = $row_adm['73'];
		$housing_paid_term = $row_adm['74'];
		$housing_cp = $row_adm['75'];
		$housing_phone = $row_adm['76'];
		$housing_email = $row_adm['77'];
		$housing_notes = $row_adm['78'];
		$test_type = $row_adm['79'];
		$test_date = $row_adm['80'];
		$test_time = $row_adm['81'];
		$test_venue = $row_adm['82'];
		$test_what_to_bring = $row_adm['83'];
		$test_notes = $row_adm['84'];
		$orientation_date = $row_adm['85'];
		$orientation_time = $row_adm['86'];
		$orientation_venue = $row_adm['87'];
		$orientation_what_to_bring = $row_adm['88'];
		$orientation_agenda = $row_adm['89'];
		$event_name = $row_adm['90'];
		$event_date = $row_adm['91'];
		$event_time = $row_adm['92'];
		$event_venue = $row_adm['93'];
		$event_what_to_bring = $row_adm['94'];
		$event_notes = $row_adm['95'];
		$visa_number = $row_adm['96'];
		$visa_valid_from = $row_adm['97'];
		$visa_valid_through = $row_adm['98'];
		$visa_entry = $row_adm['99'];
		$visa_reference = $row_adm['100'];
		$visa_notes = $row_adm['101'];
		$visa_website = $row_adm['102'];
		$flight_airline = $row_adm['103'];
		$flight_code = $row_adm['104'];
		$flight_departure_from = $row_adm['105'];
		$flight_departure_date = $row_adm['106'];
		$flight_departure_time = $row_adm['107'];
		$flight_arival_at = $row_adm['108'];
		$flight_arival_date = $row_adm['109'];
		$flight_arival_time = $row_adm['110'];
		$flight_arival_note = $row_adm['111'];
		$guardian_provider = $row_adm['112'];
		$guardian_name = $row_adm['113'];
		$guardian_mail = $row_adm['114'];
		$guardian_phone = $row_adm['115'];
		$guardian_what_to_bring = $row_adm['116'];
		$guardian_notes = $row_adm['117'];
		$portal_user = $row_adm['118'];
		$portal_password = $row_adm['119'];
		$portal_url = $row_adm['120'];
		$kjri_url = $row_adm['121'];
		$kjri_address = $row_adm['122'];
		$special_note = $row_adm['123'];	
		$orientation_date_start = $row_adm['124'];
		$orientation_date_start = $row_adm['125'];			
		$st = 0;			
			
			}
		}	
	}
	}
else
{
$country = in_val('country', 'any');
$p_np = in_val('p_np', 'any');
$intake_date = in_val('intake_date', 'any');
$pdo_date = in_val('pdo_date', 'any');
$enroll_date = in_val('enroll_date', 'any');
$nama = in_val('nama', 'any');
$kd_biodata = in_val('kd_biodata', 'any');
$dob = in_val('dob', 'any');
$country = in_val('country', 'any');
$p_np = in_val('p_np', 'any');
$pdo_date = in_val('pdo_date', 'any');
$enroll_date = in_val('enroll_date', 'any');
$nama = in_val('nama', 'any');
$passport = in_val('passport', 'any');
$referensi = in_val('referensi', 'any');
$gender = in_val('gender', 'any');
$school_name = in_val('school_name', 'any');
$school_address = in_val('school_address', 'any');
$cp1_school = in_val('cp1_school', 'any');
$cp1_position = in_val('cp1_position', 'any');
$cp2_school = in_val('cp2_school', 'any');
$cp2_position = in_val('cp2_position', 'any');
$school_group = in_val('school_group', 'any');
$school_website = in_val('school_website', 'any');
$cp1_email = in_val('cp1_email', 'any');
$cp1_phone = in_val('cp1_phone', 'any');
$cp2_email = in_val('cp2_email', 'any');
$cp2_phone = in_val('cp2_phone', 'any');
$study_1 = in_val('study_1', 'any');
$course_1 = in_val('course_1', 'any');
$major_1 = in_val('major_1', 'any');
$course1_length = in_val('course1_length', 'any');
$course1_start = in_val('course1_start', 'any');
$course1_end = in_val('course1_end', 'any');
$tf1 = in_val('tf1', 'any');
$tf1_paid = in_val('tf1_paid', 'any');
$term_paid1 = in_val('term_paid1', 'any');
$balance1 = in_val('balance1', 'any');
$balance1_due_date = in_val('balance1_due_date', 'any');
$study_2 = in_val('study_2', 'any');
$course_2 = in_val('course_2', 'any');
$major_2 = in_val('major_2', 'any');
$course2_length = in_val('course2_length', 'any');
$course2_start = in_val('course2_start', 'any');
$course2_end = in_val('course2_end', 'any');
$tf2 = in_val('tf2', 'any');
$tf2_paid = in_val('tf2_paid', 'any');
$term_paid2 = in_val('term_paid2', 'any');
$balance2 = in_val('balance2', 'any');
$balance2_due_date = in_val('balance2_due_date', 'any');
$study_3 = in_val('study_3', 'any');
$course_3 = in_val('course_3', 'any');
$major_3 = in_val('major_3', 'any');
$course3_length = in_val('course3_length', 'any');
$course3_start = in_val('course3_start', 'any');
$course3_end = in_val('course3_end', 'any');
$tf3 = in_val('tf3', 'any');
$tf3_paid = in_val('tf3_paid', 'any');
$term_paid3 = in_val('term_paid3', 'any');
$balance3 = in_val('balance3', 'any');
$balance3_due_date = in_val('balance3_due_date', 'any');
$study_4 = in_val('study_4', 'any');
$course_4 = in_val('course_4', 'any');
$major_4 = in_val('major_4', 'any');
$course4_length = in_val('course4_length', 'any');
$course4_start = in_val('course4_start', 'any');
$course4_end = in_val('course4_end', 'any');
$tf4 = in_val('tf4', 'any');
$tf4_paid = in_val('tf4_paid', 'any');
$term_paid4 = in_val('term_paid4', 'any');
$balance4 = in_val('balance4', 'any');
$balance4_due_date = in_val('balance4_due_date', 'any');		
$housing_type = in_val('housing_type', 'any');
$housing_provider = in_val('housing_provider', 'any');
$housing_address = in_val('housing_address', 'any');
$housing_rent_fee = in_val('housing_rent_fee', 'any');
$housing_rent_fee_term = in_val('housing_rent_fee_term', 'any');
$housing_rent_fee_paid = in_val('housing_rent_fee_paid', 'any');
$housing_paid_term = in_val('housing_paid_term', 'any');
$housing_cp = in_val('housing_cp', 'any');
$housing_phone = in_val('housing_phone', 'any');
$housing_email = in_val('housing_email', 'any');
$housing_notes = in_val('housing_notes', 'any');
$test_type = in_val('test_type', 'any');
$test_date = in_val('test_date', 'any');
$test_time = in_val('test_time', 'any');
$test_venue = in_val('test_venue', 'any');
$test_what_to_bring = in_val('test_what_to_bring', 'any');
$test_notes = in_val('test_notes', 'any');
$orientation_date = in_val('orientation_date', 'any');
$orientation_time = in_val('orientation_time', 'any');
$orientation_venue = in_val('orientation_venue', 'any');
$orientation_what_to_bring = in_val('orientation_what_to_bring', 'any');
$orientation_agenda = in_val('orientation_agenda', 'any');
$event_name = in_val('event_name', 'any');
$event_date = in_val('event_date', 'any');
$event_time = in_val('event_time', 'any');
$event_venue = in_val('event_venue', 'any');
$event_what_to_bring = in_val('event_what_to_bring', 'any');
$event_notes = in_val('event_notes', 'any');
$visa_number = in_val('visa_number', 'any');
$visa_valid_from = in_val('visa_valid_from', 'any');
$visa_valid_through = in_val('visa_valid_through', 'any');
$visa_entry = in_val('visa_entry', 'any');
$visa_reference = in_val('visa_reference', 'any');
$visa_notes = in_val('visa_notes', 'any');
$visa_website = in_val('visa_website', 'any');
$flight_airline = in_val('flight_airline', 'any');
$flight_code = in_val('flight_code', 'any');
$flight_departure_from = in_val('flight_departure_from', 'any');
$flight_departure_date = in_val('flight_departure_date', 'any');
$flight_departure_time = in_val('flight_departure_time', 'any');
$flight_arival_at = in_val('flight_arival_at', 'any');
$flight_arival_date = in_val('flight_arival_date', 'any');
$flight_arival_time = in_val('flight_arival_time', 'any');
$flight_arival_note = in_val('flight_arival_note', 'any');
$guardian_provider = in_val('guardian_provider', 'any');
$guardian_name = in_val('guardian_name', 'any');
$guardian_mail = in_val('guardian_mail', 'any');
$guardian_phone = in_val('guardian_phone', 'any');
$guardian_what_to_bring = in_val('guardian_what_to_bring', 'any');
$guardian_notes = in_val('guardian_notes', 'any');
$portal_user = in_val('portal_user', 'any');
$portal_password = in_val('portal_password', 'any');
$portal_url = in_val('portal_url', 'any');
$kjri_url = in_val('kjri_url', 'any');
$kjri_address = in_val('kjri_address', 'any');
$orientation_date_start = $_GET['$orientation_date_start'];
$orientation_date_start = in_val('orientation_date_start', 'any');
$branch_name = in_val('branch_name', 'any');
$branch_address = in_val('branch_address', 'any');
$branch_phone = in_val('branch_phone', 'any');
$adm_pic = in_val('adm_pic', 'any');
$adm_pic_email = in_val('adm_pic_email', 'any');
$adm_pic_2 = in_val('adm_pic_2', 'any');
$adm_pic_email_2 = in_val('adm_pic_email_2', 'any');	
	
}


//foto
$query_foto = q_set($__p_query_foto, "SELECT nm_file FROM file_student where kd_biodata = ? and kd_file = 'PDO'", [(string) ($kdb)]);
$resource_foto = db_query_or_die('errro_71', $query_foto, $__p_query_foto ?? []);
if(num(db_num_rows($resource_foto)) > 0)
{	
while ($rfoto=  db_fetch($resource_foto, PDO::FETCH_NUM))
	{
	$filefoto = $rfoto['0'];
	}
}

if ($branch_address =='')
	{
	$query_center = q_set($__p_query_center, "SELECT center, phone, alamat, adm_pic, adm_pic_email, adm_pic_2, adm_pic_email_2 FROM tb_mst_center \r
\twhere center = ? ", [(string) ($branch_name)]);
	$resource_center = db_query_or_die('errro_71', $query_center, $__p_query_center ?? []);
	if(num(db_num_rows($resource_center)) > 0)
		{	
		while ($rp_center=  db_fetch($resource_center, PDO::FETCH_NUM))
			{
			$branch_name = $rp_center['0'];
			$branch_address = $rp_center['2'];
			$branch_phone = $rp_center['1'];
			$adm_pic = $rp_center['3'];
			$adm_pic_email = $rp_center['4'];
			$adm_pic_2 = $rp_center['5'];
			$adm_pic_email_2 = $rp_center['6'];
			}
		}		
	}

//
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista Customer System Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" href="/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php //  include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->
<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>

    <!-- Content Header (Page header) -->
    <section class="content">
		<div class="col-md-6">
     <div class="box box-warning">
<div class="box-body">
	<h3><img src="imgs/vista-logo.png" alt=""/> PRE-DEPARTURE ORIENTATION FORM</h3>
</div>
     </div>			
		</div>
		<div class="col-md-6">
		  <div class="box-header with-border">
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Country </label>
					<div class="col-md-6"><select name="country" id="program_clasifie3" class="form-control"   onChange="this.form.submit()">
        <?php
								$query_exam = q_set($__p_query_exam, "SELECT distinct country FROM tb_master_partner where country <> ''");
								$resource_exam = db_query_or_die('errro_72', $query_exam, $__p_query_exam ?? []);
								while ($row_exam=  db_fetch($resource_exam, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_exam[0]).'">'.e($row_exam[0]).'</option>';
							  		}      ?>
							  	       
        <option selected="selected">          <?php  echo e($country)    ?>          </option>
      </select></div>
                    <div class="col-md-2"><select name="p_np" id="program_clasifie3" class="form-control"   onChange="this.form.submit()">
       							  		<option>P</option>
       							  		<option>NP</option>       
        <option selected="selected">          <?php  echo e($p_np)    ?>          </option>
      </select></div>                  
                </div>

		    </div>
		    <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Intake  </label>
					<div class="col-md-6"><input type="date" class="form-control" id="inputEmail3" placeholder="Intake Date" name="intake_date" value="<?php echo e($intake_date) ?>"></div>
                                      
                </div>
	        </div> 
		    <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">PDO Date  </label>
					<div class="col-md-6"><input type="date" class="form-control" id="inputEmail3" placeholder="PDO Date" name="pdo_date" value="<?php echo e($pdo_date) ?>"></div>
                                      
                </div>
	        </div> 	            
		    <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Enroll Date </label>
					<div class="col-md-6">
					  <input type="date" class="form-control" id="inputEmail" placeholder="Enroll Date" name="enroll_date" value="<?php echo e($enroll_date) ?>">
					</div>
                                      
              </div>
	        </div>	        
	      </div>
	  </div> 
      <div class="col-md-12">
          <label>STAFF INFORMATION</label>
        <div class="box box-warning"></div>
      </div>
      <div class="col-md-12">
<label>STUDENT INFORMATION</label>
	<div class="box box-warning">
	  <div class="col-md-6">
		    <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Student (Full Name) </label>
				<div class="col-md-8"><input type="text" name="nama"  class="form-control" value = "<?php echo e($nama)  ?>"/></div>
              </div>
		      <span class="col-md-8">
		      <input type="hidden" name="kdb"  class="form-control" value = "<?php echo e($kdb)  ?>" hidden/>
	        </span></div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Passport</label>
				<div class="col-md-8"><input type="text" name="passport"  class="form-control" value = "<?php echo e($passport)  ?>"/></div>
              </div>
		    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Date of Birth</label>
				<div class="col-md-8"><input type="date" name="dob"  class="form-control" value = "<?php echo e($dob)  ?>"/></div>
              </div>
		    </div>
		</div>
		<div class="col-md-6">
		  <div class="box-body">
		    <div class="form-group">
		      <label for="inputEmail4" class="col-sm-3 control-label">Student ID#</label>
		      <div class="col-md-8">
		        <input type="text" name="kd_biodata"  class="form-control" value = "<?php echo e($kd_biodata)  ?>"/>
	          </div>
	        </div>
	      </div>
		  <div class="box-body">
		    <div class="form-group">
		      <label for="inputEmail4" class="col-sm-3 control-label">Other Ref #</label>
		      <div class="col-md-8">
		        <input type="text" name="referensi"  class="form-control" value = "<?php echo e($referensi)  ?>"/>
	          </div>
	        </div>
	      </div>
		  <div class="box-body">
		    <div class="form-group">
		      <label for="inputEmail4" class="col-sm-3 control-label">Gender</label>
		      <div class="col-md-8">
		        <select name="gender" id="program_clasifie3" class="form-control">
       							  		<option>M</option>
       							  		<option>F</option>       
        <option selected="selected">          <?php  echo e($gender)    ?>          </option>
      </select>
	          </div>
	        </div>
	      </div>
	  </div>
	</div>	
</div>
<div class="col-md-12">
<label>SCHOOL &amp; CONTACT INFORMATION</label>
	<div class="box box-warning">
	  <div class="col-md-6">
		    <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">School/CampusName<br>
                </label>
				<div class="col-md-8"><select name="school_name" id="program_clasifie3" class="form-control"   onChange="this.form.submit()">
        <?php
								$query_exam = q_set($__p_query_exam, "SELECT distinct school FROM tb_master_partner where country = ? and school <>'DELETE' order by school", [(string) ($country)]);
								$resource_exam = db_query_or_die('errro_73', $query_exam, $__p_query_exam ?? []);
								while ($row_exam=  db_fetch($resource_exam, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_exam[0]).'">'.e($row_exam[0]).'</option>';
							  		}      ?>      
        <option selected="selected">          <?php  echo e($school_name)    ?>          </option>
      </select></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Address</label>
				<div class="col-md-8"><textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="school_address"><?php echo e($school_address) ?></textarea></div>
              </div>
		    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Contact Person  (1)</label>
				<div class="col-md-8"><input type="text" name="cp1_school"  class="form-control" value = "<?php echo e($cp1_school)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Position</label>
				<div class="col-md-8"><input type="text" name="cp1_position"  class="form-control" value = "<?php echo e($cp1_position)  ?>"/></div>
              </div>
		    </div>		
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Contact Person  (2)</label>
				<div class="col-md-8"><input type="text" name="cp2_school"  class="form-control" value = "<?php echo e($cp2_school)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Position</label>
				<div class="col-md-8"><input type="text" name="cp2_position"  class="form-control" value = "<?php echo e($cp2_position)  ?>"/></div>
              </div>
		    </div>			        
		</div>
	  <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">School Group</label>
	        <div class="col-md-8">
	          <input type="text" name="school_group"  class="form-control" value = "<?php echo e($school_group)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Website</label>
	        <div class="col-md-8">
	          <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="school_website"><?php echo e($school_website) ?></textarea>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">E-Mail Address</label>
	        <div class="col-md-8">
	          <input type="text" name="cp1_email"  class="form-control" value = "<?php echo e($cp1_email)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Phone #</label>
	        <div class="col-md-8">
	          <input type="text" name="cp1_phone"  class="form-control" value = "<?php echo e($cp1_phone)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">E-Mail Address</label>
	        <div class="col-md-8">
	          <input type="text" name="cp2_email"  class="form-control" value = "<?php echo e($cp2_email)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Phone #</label>
	        <div class="col-md-8">
	          <input type="text" name="cp2_phone"  class="form-control" value = "<?php echo e($cp2_phone)  ?>"/>
            </div>
          </div>
        </div>

      </div>
	  	
	</div>		
</div>
<div class="col-md-12">
<label>COURSE, MAJOR &amp; TUITION FEE INFORMATION</label>
	<div class="box box-warning">
	  <div class="col-md-6">
		    <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">1st Level Study <br>
                </label>
				<div class="col-md-8">
				  <select name="study_1" id="study_1" class="form-control" >
				    <?php
								$query_prg_cl = q_set($__p_query_prg_cl, "SELECT prg_clasifie from tb_mst_prg_clasifie order by prg_clasifie ");
								$resource_prg_cl = db_query_or_die('errro_', $query_prg_cl, $__p_query_prg_cl ?? []);
								$keluar_prg_cl= db_num_rows($resource_prg_cl);
								if(num(db_num_rows($resource_prg_cl)) > 0)
									{
									while ($row_prg_cl=  db_fetch($resource_prg_cl, PDO::FETCH_NUM))
										{
							  		echo '<option value="'.e($row_prg_cl[0]).'">'.e($row_prg_cl[0]).'</option>';
							  		}   }   ?>
				    <option selected="selected">
				      <?php  echo e($study_1)    ?>
			        </option>
			      </select>
				</div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Course Name</label>
				<div class="col-md-8"><input type="text" name="course_1"  class="form-control" value = "<?php echo e($course_1)  ?>"/></div>
              </div>
		    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Major</label>
				<div class="col-md-8"><input type="text" name="major_1"  class="form-control" value = "<?php echo e($major_1)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Course Length</label>
				<div class="col-md-8"><input type="text" name="course1_length"  class="form-control" value = "<?php echo e($course1_length)  ?>"/></div>
              </div>
		    </div>		
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Period Date</label>
				<div class="col-md-3"><input type="date" name="course1_start"  class="form-control" value = "<?php echo e($course1_start)  ?>"/></div> 
				<label for="inputEmail3" class="col-sm-1 control-label">To</label>
             <div class="col-md-3"><input type="date" name="course1_end"  class="form-control" value = "<?php echo e($course1_end)  ?>"/></div>
              </div>
		    </div>		        
	  </div>
	  <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Full Prog Tuition</label>
	        <div class="col-md-8">
	          <input type="text" name="tf1"  class="form-control" value = "<?php echo e($tf1)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Tuition Fee PAID</label>
	        <div class="col-md-8">
	          <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="tf1_paid"><?php echo e($tf1_paid) ?></textarea>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Term PAID</label>
	        <div class="col-md-8">
	          <input type="text" name="term_paid1"  class="form-control" value = "<?php echo e($term_paid1)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Balance Fee</label>
	        <div class="col-md-8">
	          <input type="text" name="balance1"  class="form-control" value = "<?php echo e($balance1)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Balance Due Date</label>
	        <div class="col-md-8">
	          <input type="text" name="balance1_due_date"  class="form-control" value = "<?php echo e($balance1_due_date)  ?>"/>
            </div>
          </div>
        </div>
      </div>
		
	</div>
	</hr>
</div>     
<div class="col-md-12">
  <div class="box box-warning">
	  <div class="col-md-6">
		    <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">2st Level Study <br>
                </label>
				<div class="col-md-8">
				  <select name="study_2" id="study_2" class="form-control" >
				    <?php
								$query_prg_cl = q_set($__p_query_prg_cl, "SELECT prg_clasifie from tb_mst_prg_clasifie order by prg_clasifie ");
								$resource_prg_cl = db_query_or_die('errro_', $query_prg_cl, $__p_query_prg_cl ?? []);
								$keluar_prg_cl= db_num_rows($resource_prg_cl);
								if(num(db_num_rows($resource_prg_cl)) > 0)
									{
									while ($row_prg_cl=  db_fetch($resource_prg_cl, PDO::FETCH_NUM))
										{
							  		echo '<option value="'.e($row_prg_cl[0]).'">'.e($row_prg_cl[0]).'</option>';
							  		}   }   ?>
				    <option selected="selected">
				      <?php  echo e($study_2)    ?>
			        </option>
			      </select>
				</div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Course Name</label>
				<div class="col-md-8"><input type="text" name="course_2"  class="form-control" value = "<?php echo e($course_2)  ?>"/></div>
              </div>
		    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Major</label>
				<div class="col-md-8"><input type="text" name="major_2"  class="form-control" value = "<?php echo e($major_2)  ?>"/></div>
              </div>

		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Course Length</label>
				<div class="col-md-8"><input type="text" name="course2_length"  class="form-control" value = "<?php echo e($course2_length)  ?>"/></div>
              </div>
		    </div>	
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Period Date</label>
				<div class="col-md-3"><input type="date" name="course2_start"  class="form-control" value = "<?php echo e($course2_start)  ?>"/></div> 
				<label for="inputEmail3" class="col-sm-1 control-label">To</label>
             <div class="col-md-3"><input type="date" name="course2_end"  class="form-control" value = "<?php echo e($course2_end)  ?>"/></div>
              </div>
		    </div>		        
	  </div>
	  <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Full Prog Tuition</label>
	        <div class="col-md-8">
	          <input type="text" name="tf2"  class="form-control" value = "<?php echo e($tf2)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Tuition Fee PAID</label>
	        <div class="col-md-8">
	          	<textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="tf2_paid"><?php echo e($tf2_paid) ?></textarea>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Term PAID</label>
	        <div class="col-md-8">
	          <input type="text" name="term_paid2"  class="form-control" value = "<?php echo e($term_paid2)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Balance Fee</label>
	        <div class="col-md-8">
	          <input type="text" name="balance2"  class="form-control" value = "<?php echo e($balance2)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Balance Due Date</label>
	        <div class="col-md-8">
	          <input type="text" name="balance2_due_date"  class="form-control" value = "<?php echo e($balance2_due_date)  ?>"/>
            </div>
          </div>
        </div>
      </div>
		
	</div>
	
	</hr>
</div>
<div class="col-md-12">
  <div class="box box-warning">
	  <div class="col-md-6">
		    <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">3rd  Level Study <br>
                </label>
				<div class="col-md-8"><select name="study_3" id="study_3" class="form-control" >
				    <?php
								$query_prg_cl = q_set($__p_query_prg_cl, "SELECT prg_clasifie from tb_mst_prg_clasifie order by prg_clasifie ");
								$resource_prg_cl = db_query_or_die('errro_', $query_prg_cl, $__p_query_prg_cl ?? []);
								$keluar_prg_cl= db_num_rows($resource_prg_cl);
								if(num(db_num_rows($resource_prg_cl)) > 0)
									{
									while ($row_prg_cl=  db_fetch($resource_prg_cl, PDO::FETCH_NUM))
										{
							  		echo '<option value="'.e($row_prg_cl[0]).'">'.e($row_prg_cl[0]).'</option>';
							  		}   }   ?>
				    <option selected="selected">
				      <?php  echo e($study_3)    ?>
			        </option>
			      </select></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Course Name</label>
				<div class="col-md-8"><input type="text" name="course_3"  class="form-control" value = "<?php echo e($course_3)  ?>"/></div>
              </div>
		    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Major</label>
				<div class="col-md-8"><input type="text" name="major_3"  class="form-control" value = "<?php echo e($major_3)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Course Length</label>
				<div class="col-md-8"><input type="text" name="course3_length"  class="form-control" value = "<?php echo e($course3_length)  ?>"/></div>
              </div>
		    </div>		
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Period Date</label>
				<div class="col-md-3"><input type="date" name="course3_start"  class="form-control" value = "<?php echo e($course3_start)  ?>"/></div> 
				<label for="inputEmail3" class="col-sm-1 control-label">To</label>
             <div class="col-md-3"><input type="date" name="course3_end"  class="form-control" value = "<?php echo e($course3_end)  ?>"/></div>
              </div>
		    </div>		        
	  </div>
	  <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Full Prog Tuition</label>
	        <div class="col-md-8">
	          <input type="text" name="tf3"  class="form-control" value = "<?php echo e($tf3)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Tuition Fee PAID</label>
	        <div class="col-md-8">
	          <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="tf3_paid"><?php echo e($tf3_paid) ?></textarea>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Term PAID</label>
	        <div class="col-md-8">
	          <input type="text" name="term_paid3"  class="form-control" value = "<?php echo e($term_paid3)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Balance Fee</label>
	        <div class="col-md-8">
	          <input type="text" name="balance3"  class="form-control" value = "<?php echo e($balance3)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Balance Due Date</label>
	        <div class="col-md-8">
	          <input type="text" name="balance3_due_date"  class="form-control" value = "<?php echo e($balance3_due_date)  ?>"/>
            </div>
          </div>
        </div>
      </div>
		
	</div>
	
	</hr>
</div>
<div class="col-md-12">
  <div class="box box-warning">
	  <div class="col-md-6">
		    <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">4rd  Level Study <br>
                </label>
				<div class="col-md-8"><select name="study_4" id="study_4" class="form-control" >
				    <?php
								$query_prg_cl = q_set($__p_query_prg_cl, "SELECT prg_clasifie from tb_mst_prg_clasifie order by prg_clasifie ");
								$resource_prg_cl = db_query_or_die('errro_', $query_prg_cl, $__p_query_prg_cl ?? []);
								$keluar_prg_cl= db_num_rows($resource_prg_cl);
								if(num(db_num_rows($resource_prg_cl)) > 0)
									{
									while ($row_prg_cl=  db_fetch($resource_prg_cl, PDO::FETCH_NUM))
										{
							  		echo '<option value="'.e($row_prg_cl[0]).'">'.e($row_prg_cl[0]).'</option>';
							  		}   }   ?>
				    <option selected="selected">
				      <?php  echo e($study_4)    ?>
			        </option>
			      </select></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Course Name</label>
				<div class="col-md-8"><input type="text" name="course_4"  class="form-control" value = "<?php echo e($course_4)  ?>"/></div>
              </div>
		    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Major</label>
				<div class="col-md-8"><input type="text" name="major_4"  class="form-control" value = "<?php echo e($major_4)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Course Length</label>
				<div class="col-md-8"><input type="text" name="course4_length"  class="form-control" value = "<?php echo e($course4_length)  ?>"/></div>
              </div>
		    </div>		
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Period Date</label>
				<div class="col-md-3"><input type="date" name="course4_start"  class="form-control" value = "<?php echo e($course4_start)  ?>"/></div> 
				<label for="inputEmail3" class="col-sm-1 control-label">To</label>
             <div class="col-md-3"><input type="date" name="course4_end"  class="form-control" value = "<?php echo e($course4_end)  ?>"/></div>
              </div>
		    </div>		        
	  </div>
	  <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Full Prog Tuition</label>
	        <div class="col-md-8">
	          <input type="text" name="tf4"  class="form-control" value = "<?php echo e($tf3)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Tuition Fee PAID</label>
	        <div class="col-md-8">
	          <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="tf4_paid"><?php echo e($tf4_paid) ?></textarea>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Term PAID</label>
	        <div class="col-md-8">
	          <input type="text" name="term_paid4"  class="form-control" value = "<?php echo e($term_paid4)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Balance Fee</label>
	        <div class="col-md-8">
	          <input type="text" name="balance4"  class="form-control" value = "<?php echo e($balance4)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Balance Due Date</label>
	        <div class="col-md-8">
	          <input type="text" name="balance4_due_date"  class="form-control" value = "<?php echo e($balance4_due_date)  ?>"/>
            </div>
          </div>
        </div>
      </div>
		
	</div>
	
	</hr>
</div>
<div class="col-md-12">
<label>HOUSING INFORMATION</label>
	<div class="box box-warning">
	  <div class="col-md-6">
		    <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Housing Type<br>
                </label>
				<div class="col-md-8"><input type="text" name="housing_type"  class="form-control" value = "<?php echo e($housing_type)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Provider Name</label>
				<div class="col-md-8"><input type="text" name="housing_provider"  class="form-control" value = "<?php echo e($housing_provider)  ?>"/></div>
              </div>
		    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Address</label>
				<div class="col-md-8"><textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="housing_address"><?php echo e($housing_address) ?>	</textarea></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Rent Fee</label>
				<div class="col-md-8"><input type="text" name="housing_rent_fee"  class="form-control" value = "<?php echo e($housing_rent_fee)  ?>"/></div>
              </div>
		    </div>		
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Rent Fee Term</label>
				<div class="col-md-8"><input type="text" name="housing_rent_fee_term"  class="form-control" value = "<?php echo e($housing_rent_fee_term)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Rent Fee PAID</label>
				<div class="col-md-8"><input type="text" name="housing_rent_fee_paid"  class="form-control" value = "<?php echo e($housing_rent_fee_paid)  ?>"/></div>
              </div>
		    </div>		
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">PAID Term</label>
				<div class="col-md-8"><input type="text" name="housing_paid_term"  class="form-control" value = "<?php echo e($housing_paid_term) ?>"/></div>
              </div>
		    </div>			    	    		        
	  </div>
	  <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Contact Person</label>
	        <div class="col-md-8">
	          <input type="text" name="housing_cp"  class="form-control" value = "<?php echo e($housing_cp)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Phone #</label>
	        <div class="col-md-8">
	          <input type="text" name="housing_phone"  class="form-control" value = "<?php echo e($housing_phone)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">E-Mail Address</label>
	        <div class="col-md-8">
	          <input type="text" name="housing_email"  class="form-control" value = "<?php echo e($housing_email)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Notes</label>
	        <div class="col-md-8">
	          <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="housing_notes"><?php echo e($housing_notes) ?>	</textarea>
            </div>
          </div>
        </div>
      </div>
		
	</div>
	</hr>
</div>
<div class="col-md-12">
<label>UPON ARRIVAL ACTIVITIES & SCHEDULE</label>

	<div class="box box-warning">
		<div class="col-md-12">  <label>Placement Test</label></div>
	  <div class="col-md-6">

		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Test Type</label>
				<div class="col-md-8"><input type="text" name="test_type"  class="form-control" value = "<?php echo e($test_type)  ?>"/></div>
              </div>
		    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Date</label>
				<div class="col-md-8"><input type="date" name="test_date"  class="form-control" value = "<?php echo e($test_date)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Time</label>
				<div class="col-md-8"><input type="text" name="test_time"  class="form-control" value = "<?php echo e($test_time)  ?>"/></div>
              </div>
		    </div>		
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Venue</label>
				<div class="col-md-8"><input type="text" name="test_venue"  class="form-control" value = "<?php echo e($test_venue)  ?>"/></div>
              </div>
		    </div>
		    	    		        
	  </div>
	  <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">What to Bring</label>
	        <div class="col-md-8">
	          <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="test_what_to_bring"><?php echo e($test_what_to_bring) ?>	</textarea>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Notes #</label>
	        <div class="col-md-8">
	          <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="test_notes"><?php echo e($test_notes) ?>	</textarea>
            </div>
          </div>
        </div>
      </div>
<div class="col-md-12">  <label>Orientation</label></div>
<div class="col-md-6">
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Period Date</label>
				<div class="col-md-3"><input type="date" name="orientation_date_start"  class="form-control" value = "<?php echo e($orientation_date_start)  ?>"/></div> 
				<label for="inputEmail3" class="col-sm-1 control-label">To</label>
             <div class="col-md-3"><input type="date" name="orientation_date_end"  class="form-control" value = "<?php echo e($orientation_date_end)  ?>"/></div>
              </div>
		    </div>	
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail5" class="col-sm-3 control-label">Time</label>
      <div class="col-md-8">
        <input type="text" name="orientation_time"  class="form-control" value = "<?php echo e($orientation_time)  ?>"/>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail5" class="col-sm-3 control-label">Vanue</label>
      <div class="col-md-8">
        <input type="text" name="orientation_venue"  class="form-control" value = "<?php echo e($orientation_venue)  ?>"/>
      </div>
    </div>
  </div>

</div>
<div class="col-md-6">
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail5" class="col-sm-3 control-label">What to Bring</label>
      <div class="col-md-8">
        <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="orientation_what_to_bring"><?php echo e($orientation_what_to_bring) ?>	</textarea>
      </div>
    </div>
  </div> 
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail6" class="col-sm-3 control-label">Agenda</label>
      <div class="col-md-8">
        <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="orientation_agenda"><?php echo e($orientation_agenda) ?>	</textarea>
      </div>
    </div>
  </div>

</div>
<div class="col-md-12">  <label>Other Event</label></div><div class="col-md-6">
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail5" class="col-sm-3 control-label">Event Name</label>
      <div class="col-md-8">
        <input type="text" name="event_name"  class="form-control" value = "<?php echo e($event_name)  ?>"/>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail5" class="col-sm-3 control-label">Date</label>
      <div class="col-md-8">
        <input type="date" name="event_date"  class="form-control" value = "<?php echo e($event_date)  ?>"/>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail5" class="col-sm-3 control-label">Time</label>
      <div class="col-md-8">
        <input type="text" name="event_time"  class="form-control" value = "<?php echo e($event_time)  ?>"/>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail5" class="col-sm-3 control-label">Venue</label>
      <div class="col-md-8">
        <input type="text" name="event_venue"  class="form-control" value = "<?php echo e($event_venue)  ?>"/>
      </div>
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail7" class="col-sm-3 control-label">What to Bring</label>
      <div class="col-md-8">
        <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="event_what_to_bring"><?php echo e($event_what_to_bring) ?>	</textarea>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail7" class="col-sm-3 control-label">Notes</label>
      <div class="col-md-8">
        <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="event_notes"><?php echo e($event_notes) ?>	</textarea>
      </div>
    </div>
  </div>  
</div>
<div class="col-md-12">
  <label>Under 18 Only </label>
</div>
<div class="col-md-6">
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail9" class="col-sm-3 control-label">Guardian Provider</label>
      <div class="col-md-8">
        <input type="text" name="guardian_provider"  class="form-control" value = "<?php echo e($guardian_provider)  ?>"/>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail9" class="col-sm-3 control-label">Guardian </label>
      <div class="col-md-8">
        <input type="text" name="guardian_name"  class="form-control" value = "<?php echo e($guardian_name)  ?>"/>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail9" class="col-sm-3 control-label">E-Mail</label>
      <div class="col-md-8">
        <input type="text" name="guardian_mail"  class="form-control" value = "<?php echo e($guardian_mail)  ?>"/>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail9" class="col-sm-3 control-label">Phone</label>
      <div class="col-md-8">
        <input type="text" name="guardian_phone"  class="form-control" value = "<?php echo e($guardian_phone)  ?>"/>
      </div>
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail10" class="col-sm-3 control-label">What to Bring</label>
      <div class="col-md-8">
        <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="guardian_what_to_bring"><?php echo e($guardian_what_to_bring) ?>	</textarea>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail10" class="col-sm-3 control-label">Notes</label>
      <div class="col-md-8">
        <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="guardian_notes"><?php echo e($guardian_notes) ?>	</textarea>
      </div>
    </div>
  </div>
</div>
		
	</div>
	</hr>
</div>
<div class="col-md-12">
<label>VISA & IMMIGRATION INFORMATION</label>

	<div class="box box-warning">
	  <div class="col-md-6">

		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Visa Number</label>
				<div class="col-md-8"><input type="text" name="visa_number"  class="form-control" value = "<?php echo e($visa_number)  ?>"/></div>
              </div>
	    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Valid From</label>
				<div class="col-md-8"><input type="date" name="visa_valid_from"  class="form-control" value = "<?php echo e($visa_valid_from)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Valid Through</label>
				<div class="col-md-8"><input type="date" name="visa_valid_through"  class="form-control" value = "<?php echo e($visa_valid_through)  ?>"/></div>
              </div>
		    </div>		
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Entry (es)</label>
				<div class="col-md-8"><input type="text" name="visa_entry"  class="form-control" value = "<?php echo e($visa_entry)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Reference #</label>
				<div class="col-md-8"><input type="text" name="visa_reference"  class="form-control" value = "<?php echo e($visa_reference)  ?>"/></div>
              </div>
		    </div>		    	    		        
	  </div>
	  <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Notes</label>
	        <div class="col-md-8">
	          <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="visa_notes"><?php echo e($visa_notes) ?>	</textarea>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail2" class="col-sm-3 control-label">Website</label>
	        <div class="col-md-8">
	          <input type="text" name="visa_website"  class="form-control" value = "<?php echo e($visa_website)  ?>"/>
            </div>
          </div>
        </div>
      </div>
	</div>
	</hr>
</div>
<div class="col-md-12">
<label>FLIGHT DETAILS</label>

	<div class="box box-warning">
	  <div class="col-md-6">

		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Airline</label>
				<div class="col-md-8"><input type="text" name="flight_airline"  class="form-control" value = "<?php echo e($flight_airline)  ?>"/></div>
              </div>
	    </div>	        
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Flight #</label>
				<div class="col-md-8"><input type="text" name="flight_code"  class="form-control" value = "<?php echo e($flight_code)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Departure From</label>
				<div class="col-md-8"><input type="text" name="flight_departure_from"  class="form-control" value = "<?php echo e($flight_departure_from)  ?>"/></div>
              </div>
		    </div>		
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Departure Date</label>
				<div class="col-md-8"><input type="date" name="flight_departure_date"  class="form-control" value = "<?php echo e($flight_departure_date)  ?>"/></div>
              </div>
		    </div>
		    <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Departure Time</label>
				<div class="col-md-8"><input type="text" name="flight_departure_time"  class="form-control" value = "<?php echo e($flight_departure_time)  ?>"/></div>
              </div>
		    </div>		    	    		        
	  </div>
	  <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail8" class="col-sm-3 control-label">Arrival At</label>
	        <div class="col-md-8">
	          <input type="text" name="flight_arival_at"  class="form-control" value = "<?php echo e($flight_arival_at)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail8" class="col-sm-3 control-label">Arrival Date</label>
	        <div class="col-md-8">
	          <input type="date" name="flight_arival_date"  class="form-control" value = "<?php echo e($flight_arival_date)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail8" class="col-sm-3 control-label">Arrival Time</label>
	        <div class="col-md-8">
	          <input type="text" name="flight_arival_time"  class="form-control" value = "<?php echo e($flight_arival_time)  ?>"/>
            </div>
          </div>
        </div>
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail8" class="col-sm-3 control-label">Notes</label>
	        <div class="col-md-8">
	          <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="flight_arival_note"><?php echo e($flight_arival_note) ?>	</textarea>
	        </div>
          </div>
        </div>
      </div>
	</div>
	</hr>
</div>
<div class="col-md-12">
  <label>Student Portal</label>
  <div class="box box-warning">
    <div class="col-md-6">
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail11" class="col-sm-3 control-label">User Name</label>
          <div class="col-md-8">
            <input type="text" name="portal_user"  class="form-control" value = "<?php echo e($portal_user)  ?>"/>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail11" class="col-sm-3 control-label">Password</label>
          <div class="col-md-8">
            <input type="text" name="portal_password"  class="form-control" value = "<?php echo e($portal_password)  ?>"/>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail11" class="col-sm-3 control-label">URL</label>
          <div class="col-md-8">
            <input type="text" name="portal_url"  class="form-control" value = "<?php echo e($portal_url)  ?>"/>
          </div>
        </div>
      </div>

    </div>
    <div class="col-md-6">
	    <div class="box-body">
	      <div class="form-group">
	        <label for="inputEmail8" class="col-sm-3 control-label">KJRI Address</label>
	        <div class="col-md-8">
	          <textarea class="textarea" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="kjri_address"><?php echo e($kjri_address) ?>	</textarea>
	        </div>
          </div>
        </div>
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail11" class="col-sm-3 control-label">KJRI URL</label>
          <div class="col-md-8">
            <input type="text" name="kjri_url"  class="form-control" value = "<?php echo e($kjri_url)  ?>"/>
          </div>
        </div>
      </div>      
    </div>
  </div>
  </hr>
</div>
<div class="col-md-12">
  <label>Special Notes</label>
  
  <div class="box box-warning">
    <div class="col-md-3">
      <div class="box-body box-profile" align="center"><img src="<?php echo e($filefoto) ?>" width="143" height="200" alt=""/><span class="form-group">
       <br>
       <label><a href="pdoimg_up.php?kdb=<?php echo e(u($kdb)) ?>" 
target="popup" 
onclick="window.open('pdoimg_up.php?kdb=<?php echo e(u($kdb)) ?>','popup','width=600,height=300'); return false;">Upload Image</a></label>
      </span></div>
      </div>
    <div class="col-md-8">
      <div class="box-body">
        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="special_note"><?php echo e($special_note) ?></textarea>
        </div>
      </div>
    </div>
  </hr>
</div>
</section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->



    <div class="col-md-12">
      <div class="box box-warning">
    <div class="box-body">
		    <div class="row">
		      <div class="col-md-2">
		        <div class="form-group">
		          <label></label>
		          <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />
	            </div>
	          </div>
	          	        <div class="col-md-2">
	          <div class="form-group">
	       
	           <input name="Print" type="submit" id="Print"  class="form-control"  value="Print" />
              </div>
            </div></a>
            
		    
		    <div class="col-md-2">
		      <div class="form-group">
	        <a href="profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>" onClick="window.open('profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>')"> 
		        <input name="Save2" type="submit" id="Save3"  class="form-control"  value="Exit" /></a>
		        </div>
		      </div>
		    </div>

		  </div>
	  </div>
  </div>
<div class="box-body"></div>
<div class="box-body"></div>
</form>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
</body>
</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'any');		
$country = in_val('country', 'any');
$p_np = in_val('p_np', 'any');
$intake_date = in_val('intake_date', 'any');
$pdo_date = in_val('pdo_date', 'any');
$enroll_date = in_val('enroll_date', 'any');
$nama = in_val('nama', 'any');
$passport = in_val('passport', 'any');
$referensi = in_val('referensi', 'any');
$gender = in_val('gender', 'any');
$school_name = in_val('school_name', 'any');
$school_address = in_val('school_address', 'any');
$cp1_school = in_val('cp1_school', 'any');
$cp1_position = in_val('cp1_position', 'any');
$cp2_school = in_val('cp2_school', 'any');
$cp2_position = in_val('cp2_position', 'any');
$school_group = in_val('school_group', 'any');
$school_website = in_val('school_website', 'any');
$cp1_email = in_val('cp1_email', 'any');

$cp1_phone = in_val('cp1_phone', 'any');
$cp2_email = in_val('cp2_email', 'any');
$cp2_phone = in_val('cp2_phone', 'any');
$study_1 = in_val('study_1', 'any');
$course_1 = in_val('course_1', 'any');
$major_1 = in_val('major_1', 'any');
$course1_length = in_val('course1_length', 'any');
$course1_start = in_val('course1_start', 'any');
$course1_end = in_val('course1_end', 'any');
$tf1 = in_val('tf1', 'any');
$tf1_paid = in_val('tf1_paid', 'any');
$term_paid1 = in_val('term_paid1', 'any');
$balance1 = in_val('balance1', 'any');
$balance1_due_date = in_val('balance1_due_date', 'any');
$study_2 = in_val('study_2', 'any');
$course_2 = in_val('course_2', 'any');
$major_2 = in_val('major_2', 'any');
$course2_length = in_val('course2_length', 'any');
$course2_start = in_val('course2_start', 'any');
$course2_end = in_val('course2_end', 'any');
$tf2 = in_val('tf2', 'any');
$tf2_paid = in_val('tf2_paid', 'any');
$term_paid2 = in_val('term_paid2', 'any');
$balance2 = in_val('balance2', 'any');
$balance2_due_date = in_val('balance2_due_date', 'any');
$study_3 = in_val('study_3', 'any');
$course_3 = in_val('course_3', 'any');
$major_3 = in_val('major_3', 'any');
$course3_length = in_val('course3_length', 'any');
$course3_start = in_val('course3_start', 'any');
$course3_end = in_val('course3_end', 'any');
$tf3 = in_val('tf3', 'any');
$tf3_paid = in_val('tf3_paid', 'any');
$term_paid3 = in_val('term_paid3', 'any');
$balance3 = in_val('balance3', 'any');
$balance3_due_date = in_val('balance3_due_date', 'any');
$study_4 = in_val('study_4', 'any');
$course_4 = in_val('course_4', 'any');
$major_4 = in_val('major_4', 'any');
$course4_length = in_val('course4_length', 'any');
$course4_start = in_val('course4_start', 'any');
$course4_end = in_val('course4_end', 'any');
$tf4 = in_val('tf4', 'any');
$tf4_paid = in_val('tf4_paid', 'any');
$term_paid4 = in_val('term_paid4', 'any');
$balance4 = in_val('balance4', 'any');
$balance4_due_date = in_val('balance4_due_date', 'any');		
$housing_type = in_val('housing_type', 'any');
$housing_provider = in_val('housing_provider', 'any');
$housing_address = in_val('housing_address', 'any');
$housing_rent_fee = in_val('housing_rent_fee', 'any');
$housing_rent_fee_term = in_val('housing_rent_fee_term', 'any');
$housing_rent_fee_paid = in_val('housing_rent_fee_paid', 'any');
$housing_paid_term = in_val('housing_paid_term', 'any');
$housing_cp = in_val('housing_cp', 'any');
$housing_phone = in_val('housing_phone', 'any');
$housing_email = in_val('housing_email', 'any');
$housing_notes = in_val('housing_notes', 'any');
$test_type = in_val('test_type', 'any');
$test_date = in_val('test_date', 'any');
$test_time = in_val('test_time', 'any');
$test_venue = in_val('test_venue', 'any');
$test_what_to_bring = in_val('test_what_to_bring', 'any');
$test_notes = in_val('test_notes', 'any');
$orientation_date_start = in_val('orientation_date_start', 'any');
$orientation_date_start = in_val('orientation_date_start', 'any');
		
$orientation_time = in_val('orientation_time', 'any');
$orientation_venue = in_val('orientation_venue', 'any');
$orientation_what_to_bring = in_val('orientation_what_to_bring', 'any');
$orientation_agenda = in_val('orientation_agenda', 'any');
$event_name = in_val('event_name', 'any');
$event_date = in_val('event_date', 'any');
$event_time = in_val('event_time', 'any');
$event_venue = in_val('event_venue', 'any');
$event_what_to_bring = in_val('event_what_to_bring', 'any');
$event_notes = in_val('event_notes', 'any');
$visa_number = in_val('visa_number', 'any');
$visa_valid_from = in_val('visa_valid_from', 'any');
$visa_valid_through = in_val('visa_valid_through', 'any');
$visa_entry = in_val('visa_entry', 'any');
$visa_reference = in_val('visa_reference', 'any');
$visa_notes = in_val('visa_notes', 'any');
$visa_website = in_val('visa_website', 'any');
$flight_airline = in_val('flight_airline', 'any');
$flight_code = in_val('flight_code', 'any');
$flight_departure_from = in_val('flight_departure_from', 'any');
$flight_departure_date = in_val('flight_departure_date', 'any');
$flight_departure_time = in_val('flight_departure_time', 'any');
$flight_arival_at = in_val('flight_arival_at', 'any');
$flight_arival_date = in_val('flight_arival_date', 'any');
$flight_arival_time = in_val('flight_arival_time', 'any');
$flight_arival_note = in_val('flight_arival_note', 'any');
$guardian_provider = in_val('guardian_provider', 'any');
$guardian_name = in_val('guardian_name', 'any');
$guardian_mail = in_val('guardian_mail', 'any');
$guardian_phone = in_val('guardian_phone', 'any');
$guardian_what_to_bring = in_val('guardian_what_to_bring', 'any');
$guardian_notes = in_val('guardian_notes', 'any');
$portal_user = in_val('portal_user', 'any');
$portal_password = in_val('portal_password', 'any');
$portal_url = in_val('portal_url', 'any');
$kjri_url = in_val('kjri_url', 'any');
$kjri_address = in_val('kjri_address', 'any');
$special_note = in_val('special_note', 'any');
$special_note = in_val('special_note', 'any');
$orientation_date_start = in_val('orientation_date_start', 'any');
$orientation_date_end = in_val('orientation_date_end', 'any');		
		 				
$query_simpan_pdo= q_set($__p_query_simpan_pdo, "insert into ves_data.ves_pdo(kd_biodata, kd_branch, student_name, country, p_np, intake_date, pdo_date, enroll_date, nama, passport, referensi, gender, school_name,\r
school_address, cp1_school, cp1_position, cp2_school, cp2_position, school_group, school_website, cp1_email, cp1_phone, cp2_email, cp2_phone,\r
study_1, course_1, major_1, course1_length, course1_start, course1_end, tf1, tf1_paid, term_paid1, balance1, balance1_due_date,\r
study_2, course_2, major_2, course2_length, course2_start, course2_end, tf2, tf2_paid, term_paid2, balance2, balance2_due_date,\r
study_3, course_3, major_3, course3_length, course3_start, course3_end, tf3, tf3_paid, term_paid3, balance3, balance3_due_date,\r
study_4, course_4, major_4, course4_length, course4_start, course4_end, tf4, tf4_paid, term_paid4, balance4, balance4_due_date,\r
housing_type, housing_provider, housing_address, housing_rent_fee, housing_rent_fee_term, housing_rent_fee_paid, housing_paid_term, housing_cp,\r
housing_phone, housing_email, housing_notes,\r
test_type, test_date, test_time, test_venue, test_what_to_bring, test_notes,\r
orientation_date, orientation_time, orientation_venue, orientation_what_to_bring, orientation_agenda,\r
 event_name, event_date, event_time, event_venue, event_what_to_bring, event_notes,\r
  visa_number, visa_valid_from, visa_valid_through, visa_entry, visa_reference, visa_notes, visa_website,\r
  flight_airline, flight_code, flight_departure_from, flight_departure_date, flight_departure_time, flight_arival_at,\r
  flight_arival_date, flight_arival_time, flight_arival_note,guardian_provider,guardian_name,guardian_mail,guardian_phone,guardian_what_to_bring,guardian_notes,portal_user,portal_password,portal_url,portal_kjri,address_kjri,special_notes,orientation_date_start,orientation_date_end,branch_name,branch_address,branch_phone,adm_pic,adm_pic_email,adm_pic_2,adm_pic_email_2) \r
  values\r
(? ,? ,? ,? , ? , ? , ? , ? , ? , ? , ? , ? ,  ? ,? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ,\r
? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ,? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ,? , ? , ? , ? , ? , ? , ? , ? , \r
? , ? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($kdb), (string) ($kdcbg), (string) ($nama), (string) ($country), (string) ($p_np), (string) ($intake_date), (string) ($pdo_date), (string) ($enroll_date), (string) ($nama), (string) ($passport), (string) ($referensi), (string) ($gender), (string) ($school_name), (string) ($school_address), (string) ($cp1_school), (string) ($cp1_position), (string) ($cp2_school), (string) ($cp2_position), (string) ($school_group), (string) ($school_website), (string) ($cp1_email), (string) ($cp1_phone), (string) ($cp2_email), (string) ($cp2_phone), (string) ($study_1), (string) ($course_1), (string) ($major_1), (string) ($course1_length), (string) ($course1_start), (string) ($course1_end), (string) ($tf1), (string) ($tf1_paid), (string) ($term_paid1), (string) ($balance1), (string) ($balance1_due_date), (string) ($study_2), (string) ($course_2), (string) ($major_2), (string) ($course2_length), (string) ($course2_start), (string) ($course2_end), (string) ($tf2), (string) ($tf2_paid), (string) ($term_paid2), (string) ($balance2), (string) ($balance2_due_date), (string) ($study_3), (string) ($course_3), (string) ($major_3), (string) ($course3_length), (string) ($course3_start), (string) ($course3_end), (string) ($tf3), (string) ($tf3_paid), (string) ($term_paid3), (string) ($balance3), (string) ($balance3_due_date), (string) ($study_4), (string) ($course_4), (string) ($major_4), (string) ($course4_length), (string) ($course4_start), (string) ($course4_end), (string) ($tf4), (string) ($tf4_paid), (string) ($term_paid4), (string) ($balance4), (string) ($balance4_due_date), (string) ($housing_type), (string) ($housing_provider), (string) ($housing_address), (string) ($housing_rent_fee), (string) ($housing_rent_fee_term), (string) ($housing_rent_fee_paid), (string) ($housing_paid_term), (string) ($housing_cp), (string) ($housing_phone), (string) ($housing_email), (string) ($housing_notes), (string) ($test_type), (string) ($test_date), (string) ($test_time), (string) ($test_venue), (string) ($test_what_to_bring), (string) ($test_notes), (string) ($orientation_date), (string) ($orientation_time), (string) ($orientation_venue), (string) ($orientation_what_to_bring), (string) ($orientation_agenda), (string) ($event_name), (string) ($event_date), (string) ($event_time), (string) ($event_venue), (string) ($event_what_to_bring), (string) ($event_notes), (string) ($visa_number), (string) ($visa_valid_from), (string) ($visa_valid_through), (string) ($visa_entry), (string) ($visa_reference), (string) ($visa_notes), (string) ($visa_website), (string) ($flight_airline), (string) ($flight_code), (string) ($flight_departure_from), (string) ($flight_departure_date), (string) ($flight_departure_time), (string) ($flight_arival_at), (string) ($flight_arival_date), (string) ($flight_arival_time), (string) ($flight_arival_note), (string) ($guardian_provider), (string) ($guardian_name), (string) ($guardian_mail), (string) ($guardian_phone), (string) ($guardian_what_to_bring), (string) ($guardian_notes), (string) ($portal_user), (string) ($portal_password), (string) ($portal_url), (string) ($kjri_url), (string) ($kjri_address), (string) ($special_note), (string) ($orientation_date_start), (string) ($orientation_date_end), (string) ($branch_name), (string) ($branch_address), (string) ($branch_phone), (string) ($adm_pic), (string) ($adm_pic_email), (string) ($adm_pic_2), (string) ($adm_pic_email_2)]);
$resource_simpan_payment = db_query_or_die('errro_simpan', $query_simpan_pdo, $__p_query_simpan_pdo ?? []);	

		$query_update_last= q_set($__p_query_update_last, "update ves_data.adm_stu_progress set aktif = '0' where kd_biodata = ? ", [(string) ($kdb)]);	
		$resource_update_last = db_query_or_die('errro_simpan1', $query_update_last, $__p_query_update_last ?? []);

		$query_simpan= q_set($__p_query_simpan, "insert into adm_stu_progress \r
\t\t(kd_biodata, enroll_date, final_status,step,nama,ori_school,\r
\t\tsc_name,adm_pic,dest_country,dest_school,group_school,\r
\t\tp_np,program_clasifie,mp_ap,dest_program,major,\r
\t\th_nh, ar,agent_referal,tf_full_program,pasport,\r
\t\ttf_fee_paid,tf_term_paid,tf_balance_fee,tgl_intake,program_duration,\r
\t\tcomm_date,comm_date_end,pdo_date,remark_problem,remark_solution,\r
\t\tnext_update,pic,kd_branch,dt_entry,kd_school,\r
\t\taktif,tf_balance_fee_due_date,update_date\r
\t\t) \r
\t\tvalues \r
\t\t(\r
\t\t? ,? ,'PDO','13: Pre-departure Orientation',? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? , ? ,? ,\r
\t\t? ,? , ? ,? ,? ,'1',? ,?\t)", [(string) ($kdb), (string) ($enroll_date), (string) ($nama), (string) ($ori_school), (string) ($sc_name), (string) ($adm_pic), (string) ($country), (string) ($school_name), (string) ($school_group), (string) ($partner_status), (string) ($program_clasifie), (string) ($program_status), (string) ($program_dest), (string) ($major), (string) ($major_group), (string) ($refer_status), (string) ($agent_referal), (string) ($tf_full_program), (string) ($pasport), (string) ($tf_fee_paid), (string) ($tf_term_paid), (string) ($tf_balance_fee), (string) ($tgl_intake), (string) ($program_duration), (string) ($comm_date), (string) ($comm_date_end), (string) ($pdo_date), (string) ($remark_problem), (string) ($remark_solution), (string) ($next_fu_date), (string) ($nama_lengkap), (string) ($kdcbg), " " . (string) ($tgl_hari_ini), (string) ($kode_sekolah), (string) ($tf_balance_fee_due_date), (string) ($tgl_hari_ini)]);

		$resource_simpan = db_query_or_die('errro_simpan2', $query_simpan, $__p_query_simpan ?? []);

		$nm_panjang = $student_name;
		//$pisah = explode(' ',$nm_panjang);
		$pecah = strtok($nm_panjang, " ");
		$i=0;
		while ($pecah)
			{
			if (num($i)== 0){$nm_depan = $pecah;}
			if (num($i)== 1){$nm_tengah = $pecah;}
			if (num($i)== 2){$nm_belakang = $pecah;}

			$pecah = strtok(" ");
			$i++;
			}
		$query_update= q_set($__p_query_update, "update ves_inc.tb_biodata set dob = ? , nama = ? ,middle_name = ? ,family_name = ? where kd_biodata = ? ", [(string) ($dob), (string) ($nm_depan), (string) ($nm_tengah), (string) ($nm_belakang), (string) ($kdb)]);			
		$resource_update = db_query_or_die('errro_simpan3', $query_update, $__p_query_update ?? []);
		$query_updates= q_set($__p_query_updates, "update ves_data.tb_sales_report set  nama = ? where kd_biodata = ? ", [(string) ($student_name), (string) ($kdb)]);			
		$resource_updates = db_query_or_die('errro_simpan3', $query_updates, $__p_query_updates ?? []);		
		

	echo "<script type=\"text/javascript\">\n";
	echo "alert('PDO has been Submitted by " . e($nama_lengkap) . "');\n";
	echo "window.location = ('dashboard.php');\n";				
	echo "</script>";		
	}
?>