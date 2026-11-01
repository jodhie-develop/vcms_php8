<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$st = in_val('st', 'get');
$browser = in_val('browser', 'get');

if ($browser !='')
	{
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('stuadmprogress.php?kdb=" . e(u($browser)) . "&st=1&new=1');\n";				
		echo "</script>";
	}
else
{
	$dpt_kode = in_val('kode_biodata', 'get');
}

//==============list student
$query_student = q_set($__p_query_student, "SELECT t.kd_biodata, t.enroll_date, t.nama, b.country, b.school, t.program FROM tb_sales_report t, tb_master_partner b where t.kd_school = b.kd_school and enroll_date > '2012-07-01'  group by t.kd_biodata,t.kd_school,   t.enroll_date order by enroll_date desc");

$resource_student= db_query_or_die('errro_8', $query_student, $__p_query_student ?? []);
$keluar_student= db_num_rows($resource_student);
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
		{
		$kd_biodata= $row_student[0];				
		$nama= $row_student[2];		
		$enroll_date = $row_student[1];	
		$student_lengkap ="$nama";
		//$list_student.="<OPTION VALUE=\"$student_lengkap\">".$kd_biodata;
		$list_student.="<OPTION VALUE=\"" . e($kd_biodata) . "&ed=" . e(u($enroll_date)) . "\">".e($student_lengkap)." ".e($enroll_date);			
		}
	}

$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";

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
$country_dest = in_val('country_dest', 'get');
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
		$list_school.="<OPTION VALUE=\"" . e($kd_school) . "\">".e($nm_school);
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
//============
//load school
$kode_school = in_val('school_dest', 'get');
$query_school_dest = q_set($__p_query_school_dest, "SELECT country, school, kd_school, grade from tb_master_partner where kd_school = ? ", [(string) ($kode_school)]);
$resource_school_dest = db_query_or_die('errro_', $query_school_dest, $__p_query_school_dest ?? []);
$keluar_school_dest= db_num_rows($resource_school_dest);
if(num(db_num_rows($resource_school_dest)) > 0)
	{
	while ($row_school_dest=  db_fetch($resource_school_dest, PDO::FETCH_NUM))
		{
		$country_dest = $row_school_dest[0];				
		$school_dest = $row_school_dest[1];
		$adm_status = "M";	
		$kode_sekolah = $row_school_dest[2];
		if ($kd_school != $kode_sekolah)
			{
			$adm_status = "M";
			$bintang = $row_school_dest[3]; 				
			}
		}
	}

if ($dpt_kode !='')
	{
	if ($dapat !='')
		{
		$query_detail = q_set($__p_query_detail, "SELECT kd_biodata, max(update_date) as terakhir FROM adm_stu_progress where kd_biodata = ? ", [(string) ($dpt_kode)]);
		$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
		$keluar_detail = db_num_rows($resource_detail);
		if(num(db_num_rows($resource_detail)) > 0)
			{
			while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
				{

				$terakhir = $row_detail[1];
				$query_adm = q_set($__p_query_adm, "SELECT a.nama, a.dest_school, a.group_school, a.p_np, a.dest_country, a.dest_program, a.program_level, a.mp_ap, a.program_clasifie, a.major, a.h_nh, a.ar, a.tf_cur, a.tf_mount,\t\r
\t\t\t\ta.tf_period, a.step, a.adm_doc, DATE_FORMAT(a.adm_sub_date,'%d'),DATE_FORMAT(a.adm_sub_date,'%m'),DATE_FORMAT(a.adm_sub_date,'%Y'), a.remark, a.final_status, a.final_status_sub, \r
\t\t\t\tDATE_FORMAT(a.pdo_date,'%d'),DATE_FORMAT(a.pdo_date,'%m'),DATE_FORMAT(a.pdo_date,'%Y'),  DATE_FORMAT(a.pdo_sub_date,'%d'),DATE_FORMAT(a.pdo_sub_date,'%m'),DATE_FORMAT(a.pdo_sub_date,'%Y'), \r
\t\t\t\ta.remark_problem, DATE_FORMAT(a.comm_date,'%d'),DATE_FORMAT(a.comm_date,'%m'),DATE_FORMAT(a.comm_date,'%Y'), DATE_FORMAT(a.update_date,'%d %b %Y'), remark_problem, remark_solution, kd_school,\r
\t\t\t\tenroll_date,ori_school,DATE_FORMAT(a.tgl_intake,'%d'),DATE_FORMAT(a.tgl_intake,'%m'),DATE_FORMAT(a.tgl_intake,'%y'),bintang,adm_pic,branch, kd_branch, sc_name, adm_pic, visa_handler,a.comm_date,a.adm_sub_date,a.pdo_date,a.pdo_sub_date,a.kd_school\r
\t\t\t\tFROM  adm_stu_progress a where kd_biodata = ? and update_date = ? ", [(string) ($dpt_kode), (string) ($terakhir)]);
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
							$remark_solution  = $row_adm['35'];	$kd_school = $row_adm['36']; $enroll_date =$row_adm['37']; $ori_school =$row_adm['38'];  
							$intake_date_d = $row_adm['39']; $intake_date_m = $row_adm['40']; $intake_date_y = $row_adm['41'];$bintang = $row_adm['42']; $branch = $row_adm['44'];$kd_branch = $row_adm['45'];
							$pic = $row_adm['46'];$adm_pic = $row_adm['47']; $visa_handler =$row_adm['48']; 
							$comm_date =$row_adm['49'];	$adm_sub_date =$row_adm['50'];$pdo_date =$row_adm['51']; $pdo_sub_date =$row_adm['52'];
							}
						}
				}
			}			
		}
	else
		{$branch = $_SESSION['branch']; 
		$kdcbg = in_val('kdcbg', 'get');
		$kode_biodata = in_val('kode_biodata', 'get');
		$student_name = in_val('student_name', 'get');
		$ori_school = in_val('ori_school', 'get');
		$pic = in_val('pic', 'get');
		$adm_pic = in_val('adm_pic', 'get');
		$visa_handler = in_val('visa_handler', 'get');
		$country_dest = in_val('country_dest', 'get');
		$school_dest = in_val('school_dest', 'get');
		$kode_sekolah = in_val('kode_sekolah', 'get');
		$school_group = in_val('school_group', 'get');
		$bintang = in_val('bintang', 'get');
		$partner_status = in_val('partner_status', 'get');
		$dest_program = in_val('dest_program', 'get');
		$program_level = in_val('program_level', 'get');
		$program_status = in_val('program_status', 'get');
		$program_clasifie = in_val('program_clasifie', 'get');
		$major = in_val('major', 'get');
		$major_group = in_val('major_group', 'get');
		$refer_status = in_val('refer_status', 'get');
		$intake_date_m = in_val('intake_date_m', 'get');
		$intake_date_y = in_val('intake_date_y', 'get');
		$comm_date = in_val('comm_date', 'get');
		$tf_cur = in_val('tf_cur', 'get');
		$tf_mount = in_val('tf_mount', 'get');
		$tf_period = in_val('tf_period', 'get');
		$last_update = in_val('last_update', 'get');
		$last_step = in_val('last_step', 'get');
		$adm_status = in_val('adm_status', 'get');
		$adm_sub_step = in_val('adm_sub_step', 'get');
		$adm_step = in_val('adm_step', 'get');
		$doc_progress = in_val('doc_progress', 'get');
		$adm_sub_date = in_val('adm_sub_date', 'get');
		$last_remark = in_val('last_remark', 'get');
		$remark = in_val('remark', 'get');
		$pdo_date = in_val('pdo_date', 'get');
		$pdo_sub_date = in_val('pdo_sub_date', 'get');
		$remark_problem = in_val('remark_problem', 'get');
		$remark_solution = in_val('remark_solution', 'get');
		$next_fu_date = in_val('next_fu_date', 'get');
		$payment_status = in_val('payment_status', 'get');
		}

	}


//====================

?>

<!DOCTYPE html>
<html>
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
</head>
  <!-- Left side column. contains the logo and sidebar -->

<body class="hold-transition skin-blue sidebar-mini">

<?php   //  include __DIR__ . "/left.php";	 ?>  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
      <h3>Admission Progress Form</h3>
		 </div></div>
    </section>
 <form method=GET> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="get">


	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-body">
			  <div class="col-md-8">
					<div class="form-group">
					  <label>Student Name</label>

					  (Press Enter after click the name choosen)
					  <input list="browsers" name="browser"  class="form-control" onchange="this.form.submit()" >
  						<datalist id="browsers">
     						<option value= ><?php echo $list_student ?>
  						</datalist>										  
					</div>				
				</div>
			  <div class="col-md-2">
			    <div class="form-group">
			      <label></label>
			      
			      <input name="Display" type="submit" id="Display"  class="form-control"  value="Display" />

		        </div>
		      </div>
			</div>
		</div>
	</div>
	  </form> 

</body>
</html>
<?php 
if (isset($_GET['Display'])) 
	{
		$kdb = in_val('browser', 'get');
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('stuadmprogress.php?kdb=" . e(u($kdb)) . "&st=1');\n";				
		echo "</script>";
	}
?>