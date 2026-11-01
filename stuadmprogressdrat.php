<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'any');
$no = in_val('no', 'any');

$st = in_val('st', 'any');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$branch = $_SESSION['branch']; 

$student_name = in_val('student_name', 'any');
$enroll_date = in_val('enroll_date', 'any');

$ori_school = in_val('ori_school', 'any');
$pic = in_val('pic', 'any');
$adm_pic = in_val('adm_pic', 'any');
$visa_handler = in_val('visa_handler', 'any');
$country_dest = in_val('country_dest', 'any');
$school_dest = in_val('school_dest', 'any');
$program_dest = in_val('program_dest', 'any');
$kode_sekolah = in_val('kode_sekolah', 'any');
$school_group = in_val('school_group', 'any');
$bintang = in_val('bintang', 'any');
$partner_status = in_val('partner_status', 'any');
$dest_program = in_val('dest_program', 'any');
$program_level = in_val('program_level', 'any');
$program_status = in_val('program_status', 'any');
$program_clasifie = in_val('program_clasifie', 'any');
$major = in_val('major', 'any');
$major_group = in_val('major_group', 'any');
$refer_status = in_val('refer_status', 'any');
$intake_date_m = in_val('intake_date_m', 'any');
$intake_date_y = in_val('intake_date_y', 'any');
$comm_date = in_val('comm_date', 'any');
$tf_cur = in_val('tf_cur', 'any');
$tf_mount = in_val('tf_mount', 'any');
$tf_period = in_val('tf_period', 'any');
$last_update = in_val('last_update', 'any');
$last_step = in_val('last_step', 'any');
$adm_status = in_val('adm_status', 'any');
$adm_sub_step = in_val('adm_sub_step', 'any');
$adm_step = in_val('adm_step', 'any');
$doc_progress = in_val('doc_progress', 'any');
$adm_sub_date = in_val('adm_sub_date', 'any');
$last_remark = in_val('last_remark', 'any');
$remark = in_val('remark', 'any');
$pdo_date = in_val('pdo_date', 'any');
$pdo_sub_date = in_val('pdo_sub_date', 'any');
$remark_problem = in_val('remark_problem', 'any');
$remark_solution = in_val('remark_solution', 'any');
$next_fu_date = in_val('next_fu_date', 'any');
$payment_status = in_val('payment_status', 'any');
//============
//load group
$query_group_school = q_set($__p_query_group_school, "SELECT distinct groupschool FROM tb_master_partner where groupschool <>'' order by groupschool");
$resource_group_school = db_query_or_die('errro_', $query_group_school, $__p_query_group_school ?? []);
$keluar_group_school = db_num_rows($resource_group_school);
if(num(db_num_rows($resource_group_school)) > 0)
	{
	while ($row_group_school=  db_fetch($resource_group_school, PDO::FETCH_NUM))
		{
		$nm_group_school= $row_group_school[0];				
		$list_group_school.="<OPTION VALUE=\"" . e($nm_group_school) . "\">".e($nm_group_school);
		}
	}
//=============

//============
//load document
$query_document = q_set($__p_query_document, "SELECT document_name from tb_mst_document order by document_name ");
$resource_document = db_query_or_die('errro_', $query_document, $__p_query_document ?? []);
$keluar_document = db_num_rows($resource_document);
if(num(db_num_rows($resource_document)) > 0)
	{
	while ($row_document=  db_fetch($resource_document, PDO::FETCH_NUM))
		{
		$nm_document= $row_document[0];				
		$list_document.="<OPTION VALUE=\"" . e($nm_document) . "\">".e($nm_document);
		}
	}
//=============
//============
//load prg clasified
$query_prg_cl = q_set($__p_query_prg_cl, "SELECT prg_clasifie from tb_mst_prg_clasifie order by prg_clasifie ");
$resource_prg_cl = db_query_or_die('errro_', $query_prg_cl, $__p_query_prg_cl ?? []);
$keluar_prg_cl= db_num_rows($resource_prg_cl);
if(num(db_num_rows($resource_prg_cl)) > 0)
	{
	while ($row_prg_cl=  db_fetch($resource_prg_cl, PDO::FETCH_NUM))
		{
		$nm_prg_cl= $row_prg_cl[0];				
		$list_prg_cl.="<OPTION VALUE=\"" . e($nm_prg_cl) . "\">".e($nm_prg_cl);
		}
	}
//=============
//load SC
$query_sc = q_set($__p_query_sc, "SELECT distinct nama_detail from tb_user where  (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and kd_branch = ? and nama_detail is not null  order by nama_detail ", [(string) ($kdcbg)]);
$resource_sc = db_query_or_die('errro_0', $query_sc, $__p_query_sc ?? []);
$keluar_sc= db_num_rows($resource_sc);
if(num(db_num_rows($resource_sc)) > 0)
	{
	while ($row_sc=  db_fetch($resource_sc, PDO::FETCH_NUM))
		{
		$pic_list= $row_sc[0];				
		$list_sc.="<OPTION VALUE=\"" . e($pic_list) . "\">".e($pic_list);
		}
	}
//=============
//load adm_pic

$query_adm_pic = q_set($__p_query_adm_pic, "SELECT distinct nama_detail from tb_user where (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and kd_branch = ? and nama_detail is not null  order by nama_detail", [(string) ($kdcbg)]);
$resource_adm_pic = db_query_or_die('errro_1', $query_adm_pic, $__p_query_adm_pic ?? []);
$keluar_adm_pic= db_num_rows($resource_adm_pic);
if(num(db_num_rows($resource_adm_pic)) > 0)
	{
	while ($row_adm_pic=  db_fetch($resource_adm_pic, PDO::FETCH_NUM))
		{
		$adm_pic_list= $row_adm_pic[0];				
		$list_adm_pic.="<OPTION VALUE=\"" . e($adm_pic_list) . "\">".e($adm_pic_list);
		}
	}
//============
//=============
//load visa handler
$query_visa_handler = q_set($__p_query_visa_handler, "SELECT distinct nama_detail from tb_user where  (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and kd_branch = ? and nama_detail is not null  order by nama_detail", [(string) ($kdcbg)]);
$resource_visa_handler = db_query_or_die('errro_2', $query_visa_handler, $__p_query_visa_handler ?? []);
$keluar_visa_handler= db_num_rows($resource_visa_handler);
if(num(db_num_rows($resource_visa_handler)) > 0)
	{
	while ($row_visa_handler=  db_fetch($resource_visa_handler, PDO::FETCH_NUM))
		{
		$visa_handler_list= $row_visa_handler[0];				
		$list_visa_handler.="<OPTION VALUE=\"" . e($visa_handler_list) . "\">".e($visa_handler_list);
		}
	}
//============
//load step admission
$query_step = q_set($__p_query_step, "SELECT nm_step from tb_step_admission order by case when nm_step like '1.%' then 0\r
when nm_step like '2.%' then 1\r
when nm_step like '3%' then 2\r
when nm_step like '4%' then 3\r
when nm_step like '5%' then 4\r
when nm_step like '6%' then 5\r
when nm_step like '7%' then 6\r
when nm_step like '8%' then 7\r
when nm_step like '9%' then 8\r
when nm_step like '10%' then 9\r
when nm_step like '11%' then 10\r
when nm_step like '12%' then 11\r
when nm_step like '13%' then 12\r
when nm_step like '14%' then 13\r
ELSE 14 end,nm_step");
$resource_step = db_query_or_die('errro_', $query_step, $__p_query_step ?? []);
$keluar_step= db_num_rows($resource_step);
if(num(db_num_rows($resource_step)) > 0)
	{
	while ($row_step=  db_fetch($resource_step, PDO::FETCH_NUM))
		{
		$nm_step= $row_step[0];				
		$list_step.="<OPTION VALUE=\"" . e($nm_step) . "\">".e($nm_step);
		}
	}
//=============
//load school
$country_dest = in_val('country_dest', 'any');
$query_school = q_set($__p_query_school, "SELECT  t.kd_school, t.school FROM ves_data.tb_master_partner t where school not like '%DELETE%' and country = ? order by\r
case when country like 'USA%' then 0\r
when country like 'CAN%' then 1\r
when country like 'SW%' then 2\r
when country like 'UK%' then 3\r
when country like 'SPA%' then 4\r
when country like 'IT%' then 5\r
when country like 'AUS%' then 6\r
when country like 'NEW%' then 7\r
when country like 'SIN%' then 8\r
when country like 'MAL%' then 9\r
when country like 'CHI%' then 10\r
when country like 'IN%' then 11\r
ELSE 12 end, country asc, school", [(string) ($country_dest)]);
$resource_school = db_query_or_die('errro_', $query_school, $__p_query_school ?? []);
$keluar_school= db_num_rows($resource_school);
if(num(db_num_rows($resource_school)) > 0)
	{
	while ($row_school=  db_fetch($resource_school, PDO::FETCH_NUM))
		{
		$kd_school= $row_school[0];						
		$nm_school= $row_school[1];				
		$list_school.="<OPTION VALUE=\"" . e($nm_school) . "\">".e($nm_school);
		}
	}
//=============
//=============
//load country
$query_country = q_set($__p_query_country, "SELECT  distinct country FROM ves_data.tb_master_partner t where school not like '%DELETE%' order by\r
case when country like 'USA%' then 0\r
when country like 'CAN%' then 1\r
when country like 'SW%' then 2\r
when country like 'UK%' then 3\r
when country like 'SPA%' then 4\r
when country like 'IT%' then 5\r
when country like 'AUS%' then 6\r
when country like 'NEW%' then 7\r
when country like 'SIN%' then 8\r
when country like 'MAL%' then 9\r
when country like 'CHI%' then 10\r
when country like 'IN%' then 11\r
ELSE 12 end, country asc, school");
$resource_country = db_query_or_die('errro_', $query_country, $__p_query_country ?? []);
$keluar_country= db_num_rows($resource_country);
if(num(db_num_rows($resource_country)) > 0)
	{
	while ($row_country=  db_fetch($resource_country, PDO::FETCH_NUM))
		{
		$nm_country= $row_country[0];				
		$list_country.="<OPTION VALUE=\"" . e($nm_country) . "\">".e($nm_country);
		}
	}
//=============

$query_kd_school = q_set($__p_query_kd_school, "SELECT  t.kd_school  FROM ves_data.tb_master_partner t where school = ? and country = ? ", [(string) ($school_dest), (string) ($country_dest)]);
$resource_kd_school = db_query_or_die('errro_', $query_kd_school, $__p_query_kd_school ?? []);
$keluar_kd_school= db_num_rows($resource_kd_school);
if(num(db_num_rows($resource_kd_school)) > 0)
	{
	while ($row_kd_school=  db_fetch($resource_kd_school, PDO::FETCH_NUM))
		{
		$kode_sekolah= $row_kd_school[0];						
		}
	}


if ($st =='1')
	{
	$query_detail = q_set($__p_query_detail, "SELECT kd_biodata, max(update_date) as terakhir FROM adm_stu_progress where kd_biodata = ? ", [(string) ($kdb)]);
	$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
	$keluar_detail = db_num_rows($resource_detail);
	if(num(db_num_rows($resource_detail)) > 0)
		{
		while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
			{
			$terakhir = $row_detail[1];
//			$query_check_status_terakhir = "SELECT a.final_status FROM  adm_stu_progress a where kd_biodata = '$kdb' and update_date = '$terakhir'";	
			$query_check_status_terakhir = q_set($__p_query_check_status_terakhir, "SELECT a.final_status FROM  adm_stu_progress a where kd_biodata = ? and no = ? ", [(string) ($kdb), (string) ($no)]);	
				
			$resource_status_terakhir  = db_query_soft($query_check_status_terakhir, $__p_query_check_status_terakhir ?? []);
			$keluar_status_terakhir  = db_num_rows($resource_status_terakhir);
				if(num(db_num_rows($resource_status_terakhir)) > 0)
					{
					while ($row_status_terakhir   =  db_fetch($resource_status_terakhir, PDO::FETCH_NUM))
						{
						$status_terakhir = $row_status_terakhir[0];
						if ($status_terakhir == "L" or $status_terakhir =="C")
							{
							$query_sales = q_set($__p_query_sales, "SELECT t.nama, a.school,a.groupschool,t.p_np,a.country, t.program, \r
\t\t\t\t\t\t\tt.major, t.enroll_date, t.ori_school, t.ori_grade, t.kd_school,  DATE_FORMAT(t.tgl_intake,'%d'),DATE_FORMAT(t.tgl_intake,'%m'),DATE_FORMAT(t.tgl_intake,'%y'), t.pic, \r
\t\t\t\t\t\t\tt.kd_cabang,a.grade       \r
\t\t\t\t\t\t\tFROM tb_sales_report t,tb_master_partner a where t.kd_school = a.kd_school and t.kd_biodata = ? order by t.enroll_date desc limit 1", [(string) ($kdb)]);

							$resource_sales = db_query_soft($query_sales, $__p_query_sales ?? []);
							$keluar_sales = db_num_rows($resource_sales);
							if(num(db_num_rows($resource_sales)) > 0)
								{
								while ($row_adm   =  db_fetch($resource_sales, PDO::FETCH_NUM))
									{
									$student_name= $row_adm['0'];$school_dest= $row_adm['1'];$school_group= $row_adm['2'];$partner_status= $row_adm['3'];$country_dest= $row_adm['4'];$program_dest= $row_adm['5'];
									$major= $row_adm['6'];  $enroll_date =$row_adm['7'];$ori_school =$row_adm['8'];  $intake_date_d = $row_adm['11']; $intake_date_m = $row_adm['12']; $intake_date_y = $row_adm['13']; 
									$comm_date_d= $row_adm['11'];	$comm_date_m= $row_adm['12'];	$comm_date_y= $row_adm['13'];
									$pic= $row_adm['14'];$kd_branch = $row_adm['15'];  $bintang = $row_adm['16'];
									$adm_status='ON';								
									}
								}
							}
						else
							{
	//		$query_adm = "SELECT a.nama, a.dest_school, a.group_school, a.p_np, a.dest_country, a.dest_program, a.program_level, a.mp_ap, a.program_clasifie, a.major, a.h_nh, a.ar, a.tf_cur, a.tf_mount,	a.tf_period, a.step, a.adm_doc, DATE_FORMAT(a.adm_sub_date,'%d'),DATE_FORMAT(a.adm_sub_date,'%m'),DATE_FORMAT(a.adm_sub_date,'%Y'), a.remark, a.final_status, a.final_status_sub, 		DATE_FORMAT(a.pdo_date,'%d'),DATE_FORMAT(a.pdo_date,'%m'),DATE_FORMAT(a.pdo_date,'%Y'),DATE_FORMAT(a.pdo_sub_date,'%d'),DATE_FORMAT(a.pdo_sub_date,'%m'),DATE_FORMAT(a.pdo_sub_date,'%Y'), 			a.remark_problem, DATE_FORMAT(a.comm_date,'%d'),DATE_FORMAT(a.comm_date,'%m'),DATE_FORMAT(a.comm_date,'%Y'), DATE_FORMAT(a.update_date,'%d %b %Y'), remark_problem, remark_solution, kd_school,			enroll_date,ori_school,DATE_FORMAT(a.tgl_intake,'%d'),DATE_FORMAT(a.tgl_intake,'%m'),DATE_FORMAT(a.tgl_intake,'%y'),bintang,adm_pic,branch, kd_branch, sc_name, adm_pic, visa_handler,a.comm_date,a.adm_sub_date,a.pdo_date,a.pdo_sub_date,a.pay_mtd			FROM  adm_stu_progress a where kd_biodata = '$kdb' and update_date = '$terakhir'";

			$query_adm = q_set($__p_query_adm, "SELECT a.nama, a.dest_school, a.group_school, a.p_np, a.dest_country, a.dest_program, a.program_level, a.mp_ap, a.program_clasifie, a.major, a.h_nh, a.ar, a.tf_cur, a.tf_mount,\t\r
\t\t\ta.tf_period, a.step, a.adm_doc, DATE_FORMAT(a.adm_sub_date,'%d'),DATE_FORMAT(a.adm_sub_date,'%m'),DATE_FORMAT(a.adm_sub_date,'%Y'), a.remark, a.final_status, a.final_status_sub, \r
\t\t\tDATE_FORMAT(a.pdo_date,'%d'),DATE_FORMAT(a.pdo_date,'%m'),DATE_FORMAT(a.pdo_date,'%Y'),  DATE_FORMAT(a.pdo_sub_date,'%d'),DATE_FORMAT(a.pdo_sub_date,'%m'),DATE_FORMAT(a.pdo_sub_date,'%Y'), \r
\t\t\ta.remark_problem, DATE_FORMAT(a.comm_date,'%d'),DATE_FORMAT(a.comm_date,'%m'),DATE_FORMAT(a.comm_date,'%Y'), DATE_FORMAT(a.update_date,'%d %b %Y'), remark_problem, remark_solution, kd_school,\r
\t\t\tenroll_date,ori_school,DATE_FORMAT(a.tgl_intake,'%d'),DATE_FORMAT(a.tgl_intake,'%m'),DATE_FORMAT(a.tgl_intake,'%y'),bintang,adm_pic,branch, kd_branch, sc_name, adm_pic, visa_handler,a.comm_date,a.adm_sub_date,a.pdo_date,a.pdo_sub_date,a.pay_mtd\r
\t\t\tFROM  adm_stu_progress a where kd_biodata = ? and no = ? ", [(string) ($kdb), (string) ($no)]);								
			$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
			$keluar_adm  = db_num_rows($resource_adm);
				if(num(db_num_rows($resource_adm)) > 0)
					{
					while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
						{
						$student_name= $row_adm['0'];$school_dest= $row_adm['1'];$school_group= $row_adm['2'];$partner_status= $row_adm['3'];$country_dest= $row_adm['4'];$program_dest= $row_adm['5'];
						$program_level= $row_adm['6'];$program_status= $row_adm['7'];$program_clasifie= $row_adm['8'];	$major= $row_adm['9'];	$major_group= $row_adm['10'];$refer_status= $row_adm['11'];
						$tf_cur= $row_adm['12'];$tf_mount= $row_adm['13'];	$tf_period= $row_adm['14'];	$last_step= $row_adm['15'];	$doc_progress= $row_adm['16'];	$doc_tgl= $row_adm['17'];
						$doc_bln= $row_adm['18'];	$doc_thn= $row_adm['19'];	$last_remark= $row_adm['20'];$adm_status= $row_adm['21'];	$adm_sub_step= $row_adm['22'];	$pdo_tgl= $row_adm['23'];
						$pdo_bln= $row_adm['24'];	$pdo_thn= $row_adm['25'];	$pdo_sub_tgl= $row_adm['26'];	$pdo_sub_bln= $row_adm['27'];	$pdo_sub_thn= $row_adm['28'];	$problem_remark= $row_adm['29'];
						$comm_date_d= $row_adm['30'];	$comm_date_m= $row_adm['31'];	$comm_date_y= $row_adm['32'];	$last_update = $row_adm['33'];	$remark_problem = $row_adm['34'];
						$remark_solution  = $row_adm['35'];	$kode_sekolah = $row_adm['36']; $enroll_date =$row_adm['37']; $ori_school =$row_adm['38'];  
						$intake_date_d = $row_adm['39']; $intake_date_m = $row_adm['40']; $intake_date_y = $row_adm['41'];$bintang = $row_adm['42']; $branch = $row_adm['44'];$kd_branch = $row_adm['45'];
						$pic = $row_adm['46'];$adm_pic = $row_adm['47']; $visa_handler =$row_adm['48']; 
						$comm_date =$row_adm['49'];	$adm_sub_date =$row_adm['50'];$pdo_date =$row_adm['51']; $pdo_sub_date =$row_adm['52'];$payment_status=$row_adm['53'];
						}
					}								
							}
					}
			}
			//==============================				

else
					{
					$query_sales = q_set($__p_query_sales, "SELECT t.nama, a.school,a.groupschool,t.p_np,a.country, t.program, \r
\t\t\t\t\tt.major, t.enroll_date, t.ori_school, t.ori_grade, t.kd_school,  DATE_FORMAT(t.tgl_intake,'%d'),DATE_FORMAT(t.tgl_intake,'%m'),DATE_FORMAT(t.tgl_intake,'%y'), t.pic, \r
\t\t\t\t\tt.kd_cabang,a.grade       \r
\t\t\t\t\tFROM tb_sales_report t,tb_master_partner a where t.kd_school = a.kd_school and t.kd_biodata = ? order by t.enroll_date desc limit 1", [(string) ($kdb)]);

					$resource_sales = db_query_soft($query_sales, $__p_query_sales ?? []);
					$keluar_sales = db_num_rows($resource_sales);
					if(num(db_num_rows($resource_sales)) > 0)
						{
						while ($row_adm   =  db_fetch($resource_sales, PDO::FETCH_NUM))
							{
							$student_name= $row_adm['0'];$school_dest= $row_adm['1'];$school_group= $row_adm['2'];$partner_status= $row_adm['3'];$country_dest= $row_adm['4'];$program_dest= $row_adm['5'];
							$major= $row_adm['6'];  $enroll_date =$row_adm['7'];$ori_school =$row_adm['8'];  $intake_date_d = $row_adm['11']; $intake_date_m = $row_adm['12']; $intake_date_y = $row_adm['13']; 
							$comm_date_d= $row_adm['11'];	$comm_date_m= $row_adm['12'];	$comm_date_y= $row_adm['13'];
							$pic= $row_adm['14'];$kd_branch = $row_adm['15'];  $bintang = $row_adm['16'];



							$adm_status='ON';
							}
						}
					}		
				
			}
		}
				

	}
$wajib = "form-group has-error";
$tdkwajib = "form-group";
$wajiblabel = "label-danger";
	

//====================
if($adm_status =='ON' and substr($adm_step,0,1) =='1') {$langkah = '10';}
if($adm_status =='ON' and substr($adm_step,0,1) =='2') {$langkah = '20';}
if($adm_status =='ON' and substr($adm_step,0,1) =='3') {$langkah = '20';}
if($adm_status =='ON' and substr($adm_step,0,1) =='4') {$langkah = '40';}
if($adm_status =='ON' and substr($adm_step,0,1) =='5') {$langkah = '60';}
if($adm_status =='ON' and substr($adm_step,0,1) =='6') {$langkah = '60';}
if($adm_status =='ON' and substr($adm_step,0,1) =='7') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,1) =='8') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,1) =='9') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,1) =='10') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,1) =='11') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,1) =='12') {$langkah = '80';}
if($adm_status =='PDO') {$langkah = "90";}
if($adm_status =='L') {$langkah = "100";}
?>

<!DOCTYPE html>
<html>
<style>
function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
</style>
<!DOCTYPE html>
<html>
<style>

function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
.style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
</style>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
   <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}

</script><body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php   //   include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
      <h3>Admission Progress Form<br>
      <a href="leadsupdate.php?kdb=<?php echo e(u($kdb)) ?>"  class="btn btn-primary btn-md">Student Profile</a>      
</h3>
</div>
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>


    <div class="col-md-12">
<div class="box box-warning">
<div class="box-body"><span class="form-group">
  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
</span>
 <div class="col-md-2">
      <div class="form-group has-error">
      <label>Admission Status</label>
      <select name="adm_status" id="adm_status" class="form-control"  onchange="this.form.submit()">
            <option>ON</option>
            <option>C</option>
            <option>PR</option>
            <option>PDO</option>
            <option>L</option>
            <option selected="selected">
              <?php  echo e($adm_status)
    ?>
            </option>
          </select>
    </div>
</div>
 <div class="col-md-6">
    <div class="form-group has-error">
      <label>Admission Step</label>
      <select name="adm_step" id="adm_step" class="form-control" onchange="this.form.submit()">
					
        <?php
								$query_step = q_set($__p_query_step, "SELECT nm_step from tb_step_admission where jns_step = ? order by  no", [(string) ($adm_status)]);
$resource_step = db_query_or_die('errro_', $query_step, $__p_query_step ?? []);
$keluar_step= db_num_rows($resource_step);
								while ($row_step=  db_fetch($resource_step, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_step[0]).'">'.e($row_step[0]).'</option>';
							  		}      ?>
          <option selected="selected"><?php  echo e($adm_step) ?> </option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>" readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="<?php if ($langkah >= '90'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>DOB</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="dob" 
                 	      value="<?php echo e($dob) ?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="<?php if ($langkah >= '90'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>PASPORT ID</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="pasport" 
                 	      value="<?php echo e($pasport) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="text" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="text" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
  </span>
  <div class="col-md-12">
    <div class=" <?php 
	if ($langkah >= '10'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Original School</label>
      <input name="ori_school"  class="form-control"  type="text" size="90" value="<?php echo e($ori_school)  ?>" />
    </div>
  </div>
  
 
  <div class="col-md-3">
    <div class=" <?php if($langkah >= '10'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Student Consultant</label>
      <select name="pic"  class="form-control" >
          <option value= "">
          <?=$list_sc?>
          </option>
          <option selected="selected">
        <?php  if ($pic =='') { echo e($pic_list); }else { echo e($pic); }
   ?>
          </option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class=" <?php if ($langkah >= '10'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
            <label>Admission Consultant</label>
      <select name="adm_pic" class="form-control">
          <option value= "">
          <?=$list_adm_pic?>
          </option>
          <option selected="selected">
        <?php  if ($adm_pic =='') {  echo "NOT SET"; }else { echo e($adm_pic); }
   ?>
          </option>
      </select>
    </div>
  </div>

  <span class="form-group">
  <input type="text" ang="en-150"   name="no" 
                 	      value="<?php echo e($no) ?>" hidden="hidden">
  </span></div>
<div class="box-body">
  <div class="col-md-3">
    <div class=" <?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Destination Country </label>
      <select name="country_dest"  class="form-control" onchange="this.form.submit()" >
          <option value= "">
          <?=$list_country?>
          </option>
          <option selected="selected">
            <?php  echo e($country_dest)
   ?>
          </option>
      </select>
    </div>
  </div>
  <div class="col-md-8">
    <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Destination School </label>
      <select name="school_dest"  class="form-control"  onchange="this.form.submit()" >          
	  <option value= >
          <?=$list_school?>	  
 <option selected="selected"><?php  echo e($school_dest)
   ?></option>
      </select>
    </div>
  </div>
  <input type="kode_sekolah" name="kode_sekolah"  value = "<?php echo e($kode_sekolah)  ?>"/>
  <div class="col-md-3">
    <div class="<?php if($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Group of School </label>
      <select name="school_group" size="1" id="school_group" class="form-control" >
          <option value= >
          <?=$list_group_school?>	  
        <option selected="selected"><?php  echo e($school_group)
  ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Star</label>
      <input type="bintang" name="bintang"  class="form-control"  value = "<?php echo e($bintang)
  ?>" readonly/>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Partner Status</label>
      <select name="partner_status" class="form-control" >
          <option>P</option>
          <option>NP</option>
          <option selected="selected">
            <?php  echo e($partner_status)
   ?>
          </option>
      </select>
    </div>
  </div>
  <div class="col-md-8">
    <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
    <label>Level of Study</label>
    <select name="program_clasifie" id="program_clasifie" class="form-control" >
      <option value= "">
        <?=$list_prg_cl?>
        </option>
      <option selected="selected">
        <?php  echo e($program_clasifie)
    ?>
        </option>
    </select>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
      <label> Level of Study Status</label>
      <select name="program_status" class="form-control" >
          <option>Main</option>
          <option>Add</option>
          <option>Language</option>
          <option>Continued</option>
          <option selected="selected">
          <?php  echo e($program_status)
    ?>
          </option>
        </select>
    </div>
</div>
<div class="col-md-5">
  <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
    <label>Course Name</label>
    <input type="dest_program"  class="form-control" name="program_dest" size="90"  value = "<?php echo e($program_dest)  ?>"/>
  </div>
</div>
<div class="col-md-3">
  <div class="<?php if($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
    <label>Major</label>
    <input type="text" name="major"  class="form-control" value = "<?php echo e($major)  ?>"/>
  </div>
</div>
<div class="col-md-3">
  <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
    <label>Group Major</label>
    <select name="major_group" class="form-control" >
      <option>H</option>
      <option>AD</option>
      <option>STEM</option>
      <option>NON</option>
      <option selected="selected">
        <?php  echo e($major_group)
    ?>
        </option>
    </select>
  </div>
</div>
<div class="row">
  <div class="form-group"></div>	
</div>

</div>
<div class="box-body">
  <div class="col-md-3">
    <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Status Refer</label>
      <select name="refer_status" class="form-control" >
        <option>N</option>
        <option>R</option>
        <option>A</option>
        <option selected="selected">
        <?php  echo e($refer_status)
 ?>
        </option>
      </select>
    </div>
</div>
  <div class="col-md-5">
    <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Agent Referral Name</label>
      <input type="dest_program"  class="form-control" name="agent_referal" size="90"  value = "<?php echo e($agent_referal) ?>"/>
    </div>
  </div>

</div>
<div class="box-body">
      <label>Tuition Fee</label>
</div>
<div class="box-body">
    <div class="col-md-4">
		    <div class="<?php if ($langkah >= '90'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Full Program Tuition Fee</label>
      <span class="<?php if ($langkah >= '90'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <input type="text" name="tf_full_program"  class="form-control" value = "<?php echo e($tf_full_program)  ?>"/>
      </span></div>
</div>
  <div class="col-md-4">
    <div class="<?php if ($langkah >= '90'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Tuition Fee Paid</label>
      <input type="text" name="tf_fee_paid"  class="form-control"  value = "<?php echo e($tf_fee_paid)
   ?>"/>
    </div>
  </div>
  <div class="col-md-4">
    <div class="<?php if ($langkah >= '90'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Term Paid</label>
      <input type="text" name="tf_term_paid"  class="form-control"  value = "<?php echo e($tf_term_paid)
   ?>"/>
    </div>
  </div>
  <div class="col-md-3">
    <div class="<?php if ($langkah >= '90'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Balance Fee</label>
      <input type="text" name="tf_balance_fee"  class="form-control"  value = "<?php echo e($tf_balance_fee)
   ?>"/>
    </div>
  </div>
  <div class="col-md-3">
    <div class="<?php if ($langkah >= '90'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Balance Due Date</label>
      <input type="text" name="tf_mount4"  class="form-control"  value = "<?php echo e($tf_mount)
   ?>"/>
    </div>
  </div>
</div>
<div class="box-body">
		  <div class="col-md-2">
		    <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Month Intake</label>
      <select name="intake_date_m" class="form-control" >
          <option>01</option>
          <option>02</option>
          <option>03</option>
          <option>04</option>
          <option>05</option>
          <option>06</option>
          <option>07</option>
          <option>08</option>
          <option>09</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
          <option selected="selected">
            <?php  echo e($intake_date_m)   ?>
          </option>
        </select>
    </div>
</div>
  <div class="col-md-2">
    <div class="<?php if($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Year Intake</label>
      <select name="intake_date_y" class="form-control">
          <option>2016</option>
          <option>2017</option>
          <option>2018</option>
          <option>2019</option>
          <option selected="selected">
            <?php  echo e($intake_date_y)   ?>
          </option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Program Duration</label>
      <input type="text" name="program_duration"  class="form-control" value = "<?php echo e($program_duration)  ?>"/>
    </div>
  </div>
<div class="col-md-3">
  <div class="<?php if ( $langkah >= "90"){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>School Start</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="comm_date" 
                 	      value="<?php echo e($comm_date) ?>"></div>
</div>
<div class="col-md-3">
  <div class="<?php if ( $langkah >= "90"){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
    <label>Until</label>
    <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="comm_date_end" 
                 	      value="<?php echo e($comm_date_end) ?>">
  </div>
</div>
</div>

<div class="box-body">
    <label>Leaving Detail</label>
</div>
<div class="box-body">
  <div class="col-md-6">
    <div class="<?php if ($langkah >= '90'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>PDO Date</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="pdo_date" 
                 	      value="<?php echo e($pdo_date) ?>">
    </div>
  </div>
</div> 
<div class="box-body">
      <label>Problem</label>
</div>
<div class="box-body">
  <div class="col-md-6">
    <div class=" <?php if ($langkah >= '10'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Description</label>
      <input name="remark_problem" type="text" id="remark_problem" size="200"  class="form-control" 
value = "<?php echo e($remark_problem)  ?>" />
    </div>
  </div>
  <div class="col-md-6">
    <div class=" <?php if ($langkah >= '10'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Solution</label>
      <input name="remark_solution" type="text" id="remark_solution" size="200"  class="form-control" 
value = "<?php echo e($remark_solution)
  ?>" />
    </div>
  </div>
</div>   
<div class="box-body">
  <div class="col-md-6">
    <div class=" <?php if ($langkah >= '10'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Next Follow Up </label>
      <input name="next_fu_date" type="date" id="remark_problem" size="200"  class="form-control" 
value = "<?php echo e($next_fu_date)
  ?>" />
    </div>
  </div>
  
</div>    
 <div class="col-md-2">
			    <div class="form-group">
			      <label></label>
			      
			      <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />

		        </div>
		      </div>
 
</form>
</body>
</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{
$branch = $_SESSION['branch']; 

$kdb = in_val('kdb', 'any');
$student_name = in_val('student_name', 'any');
$enroll_date = in_val('enroll_date', 'any');

$adm_status = in_val('adm_status', 'any');
$adm_step = in_val('adm_step', 'any');
$student_name = in_val('student_name', 'any');
$ori_school = in_val('ori_school', 'any');
$pic = in_val('pic', 'any');
$adm_pic = in_val('adm_pic', 'any');
$country_dest = in_val('country_dest', 'any');
$school_dest = in_val('school_dest', 'any');
$school_group = in_val('school_group', 'any');
$partner_status = in_val('partner_status', 'any');
$program_clasifie = in_val('program_clasifie', 'any');
$program_status = in_val('program_status', 'any');
$dest_program = in_val('dest_program', 'any');
$major = in_val('major', 'any');
$major_group = in_val('major_group', 'any');
$refer_status = in_val('refer_status', 'any');
$agent_referal = in_val('agent_referal', 'any');
$tf_full_program = in_val('tf_full_program', 'any');
$dob = in_val('dob', 'any');
$pasport = in_val('pasport', 'any');
$tf_fee_paid = in_val('tf_fee_paid', 'any');
$tf_term_paid = in_val('tf_term_paid', 'any');
$tf_balance_fee = in_val('tf_balance_fee', 'any');
$intake_date_m = in_val('intake_date_m', 'any');
$intake_date_y = in_val('intake_date_y', 'any');
$program_duration = in_val('program_duration', 'any');
$comm_date = in_val('comm_date', 'any');
$comm_date_end = in_val('comm_date_end', 'any');
$pdo_date = in_val('pdo_date', 'any');
$payment_status = in_val('payment_status', 'any');
$remark_problem = in_val('remark_problem', 'any');
$remark_solution = in_val('remark_solution', 'any');
$next_fu_date = in_val('next_fu_date', 'any');

$query_simpan= q_set($__p_query_simpan, "insert into adm_stu_progress \r
(kd_branch, branch, kd_biodata, nama, dest_school, group_school, p_np, dest_country, \r
dest_program, program_level, mp_ap, program_clasifie, major, \r
h_nh, ar, tf_cur, tf_mount,\ttf_period,\r
step, adm_doc, adm_sub_date, remark, final_status,\r
final_status_sub, pdo_date,pdo_sub_date,comm_date,\r
update_date, remark_problem, remark_solution, kd_school,\r
enroll_date,ori_school,tgl_intake,bintang,adm_pic,sc_name, visa_handler,\r
next_update,last_step,last_remark, pay_mtd, prioritas) \r
values \r
(\r
? ,? ,? ,? ,? ,? ,? ,? ,\r
? , ? , ? ,? ,? , \r
? ,? ,? ,? ,? , \r
? ,? ,? ,? , ? ,\r
? ,? , ? ,? ,\r
? ,? ,? ,? ,\r
? ,? ,? ,? , ? ,? ,? ,\r
? ,? ,? , ? , '1')", [(string) ($kdcbg), (string) ($branch), (string) ($kdb), (string) ($student_name), (string) ($school_dest), (string) ($school_group), (string) ($partner_status), (string) ($country_dest), (string) ($program_dest), (string) ($program_level), (string) ($program_status), (string) ($program_clasifie), (string) ($major), (string) ($major_group), (string) ($refer_status), (string) ($tf_cur), (string) ($tf_mount), (string) ($tf_period), (string) ($adm_step), (string) ($doc_progress), (string) ($adm_sub_date), (string) ($remark), (string) ($adm_status), (string) ($adm_sub_step), (string) ($pdo_date), (string) ($pdo_sub_date), (string) ($comm_date), (string) ($tgl_hari_ini), (string) ($remark_problem), (string) ($remark_solution), (string) ($kode_sekolah), (string) ($enroll_date), (string) ($ori_school), (string) ($intake_date_y) . "-" . (string) ($intake_date_m) . "-01", (string) ($bintang), (string) ($adm_pic), (string) ($pic), (string) ($visa_handler), (string) ($next_fu_date), (string) ($last_step), (string) ($last_remark), (string) ($payment_status)]);
$resource_simpan = db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
echo "<script type=\"text/javascript\">\n";
echo "alert('New Admission Progress Submitted');\n";
echo "window.location = ('admission_progress.php');\n";				
echo "</script>";
	}
?>