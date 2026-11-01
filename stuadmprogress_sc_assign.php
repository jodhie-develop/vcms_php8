<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdb = in_val('kdb', 'any');
$ed = in_val('ed', 'any');

$no = in_val('no', 'any');

$st = in_val('st', 'any');
$new = in_val('new', 'any');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$branch = $_SESSION['branch']; 
$asal = in_val('asal', 'any');
$no_sales = in_val('no_sales', 'any');
if (num($st)==1)
	{
	$querydob = q_set($__p_querydob, "SELECT dob,org_school,kd_branch, branch FROM  ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($kdb)]);								
	$resource_dob  = db_query_soft($querydob, $__p_querydob ?? []);
	$keluar_dob  = db_num_rows($resource_dob);
	if(num(db_num_rows($resource_dob)) > 0)
		{
		while ($row_dob   =  db_fetch($resource_dob, PDO::FETCH_NUM))
			{
			$dob = $row_dob['0'];
			$ori_school = $row_dob['1'];
			}
		}

	if(num($new) ==1)
	{	$query_adm = q_set($__p_query_adm, "SELECT kd_biodata, enroll_date, final_status,step,nama,ori_school,sc_name, adm_pic,dest_country,dest_school,group_school,p_np, program_clasifie,mp_ap,dest_program,major,h_nh, ar,agent_referal,tf_full_program,pasport,tf_fee_paid, tf_term_paid,tf_balance_fee,tgl_intake,program_duration,comm_date,\r
\tcomm_date_end,pdo_date,remark_problem,remark_solution,next_update, pic,kd_branch, dt_entry,kd_school,tf_balance_fee_due_date,date_format(tgl_intake, '%m'),date_format(tgl_intake, '%Y')  \r
\tFROM  adm_stu_progress a where kd_biodata = ? and enroll_date = ? and aktif = 1", [(string) ($kdb), (string) ($ed)]); 	}
	else
	{	$query_adm = q_set($__p_query_adm, "SELECT kd_biodata, enroll_date, final_status,step,nama,ori_school,sc_name, adm_pic,dest_country,dest_school,group_school,p_np, program_clasifie,mp_ap,dest_program,major,h_nh, ar,agent_referal,tf_full_program,pasport,tf_fee_paid, tf_term_paid,tf_balance_fee,tgl_intake,program_duration,comm_date,\r
\tcomm_date_end,pdo_date,remark_problem,remark_solution,next_update, pic,kd_branch, dt_entry,kd_school,tf_balance_fee_due_date,date_format(tgl_intake, '%m'),date_format(tgl_intake, '%Y')  \r
\tFROM  adm_stu_progress a where kd_biodata = ? and aktif = 1", [(string) ($kdb)]);}

	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$kdb = $row_adm['0'];$enroll_date = $row_adm['1']; $adm_status = $row_adm['2'];$adm_step = $row_adm['3'];
			$student_name = $row_adm['4'];$ori_school = $row_adm['5'];$sc_pic = $row_adm['6']; $adm_pic = $row_adm['7'];
			$country_dest = $row_adm['8'];$school_dest = $row_adm['9'];$school_group = $row_adm['10'];$partner_status = $row_adm['11'];
			$program_clasifie = $row_adm['12'];$program_status = $row_adm['13'];$program_dest = $row_adm['14'];
			$major = $row_adm['15'];$major_group = $row_adm['16']; $refer_status = $row_adm['17'];
			$agent_referal = $row_adm['18'];$tf_full_program = $row_adm['19'];$pasport = $row_adm['20'];
			$tf_fee_paid = $row_adm['21']; $tf_term_paid = $row_adm['22'];$tf_balance_fee = $row_adm['23'];
			$tgl_intake = $row_adm['24'];$program_duration = $row_adm['25'];$comm_date = $row_adm['26'];
			$comm_date_end = $row_adm['27'];$pdo_date = $row_adm['28']; $remark_problem = $row_adm['29'];
			$remark_solution = $row_adm['30'];$next_fu_date = $row_adm['31'];$nama_lengkap = $row_adm['32']; $kdcbg = $row_adm['33']; $tgl_hari_ini = $row_adm['34'];$kode_sekolah = $row_adm['35'];$tf_balance_fee_due_date= $row_adm['36'];$intake_date_m = $row_adm['37'];$intake_date_y = $row_adm['38'];$st =0;
			}
		}
	else
		{
		if(num($new) ==1)
		{$query_sales = q_set($__p_query_sales, "SELECT t.nama, a.school,a.groupschool,t.p_np,a.country, t.program, \r
\t\tt.major, t.enroll_date, t.ori_school, t.ori_grade, t.kd_school,  DATE_FORMAT(t.tgl_intake,'%d'),DATE_FORMAT(t.tgl_intake,'%m'),DATE_FORMAT(t.tgl_intake,'%y'), t.pic, \r
\t\tt.kd_cabang,a.grade       \r
\t\tFROM tb_sales_report t,tb_master_partner a where t.kd_school = a.kd_school and t.kd_biodata = ? and enroll_date = ?  order by t.enroll_date desc limit 1", [(string) ($kdb), (string) ($ed)]);}
		else
		{$query_sales = q_set($__p_query_sales, "SELECT t.nama, a.school,a.groupschool,t.p_np,a.country, t.program, \r
\t\tt.major, t.enroll_date, t.ori_school, t.ori_grade, t.kd_school,  DATE_FORMAT(t.tgl_intake,'%d'),DATE_FORMAT(t.tgl_intake,'%m'),DATE_FORMAT(t.tgl_intake,'%y'), t.pic, \r
\t\tt.kd_cabang,a.grade       \r
\t\tFROM tb_sales_report t,tb_master_partner a where t.kd_school = a.kd_school and t.kd_biodata = ?  order by t.enroll_date desc limit 1", [(string) ($kdb)]);}
		

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
else
	{
	$student_name = in_val('student_name', 'any');
	$enroll_date = in_val('enroll_date', 'any');
	$dob = in_val('dob', 'any');		

	$adm_status = in_val('adm_status', 'any');
	$adm_step = in_val('adm_step', 'any');
	$student_name = in_val('student_name', 'any');
	$ori_school = in_val('ori_school', 'any');
	$sc_pic = in_val('sc_pic', 'any');
	$adm_pic = in_val('adm_pic', 'any');
	$country_dest = in_val('country_dest', 'any');
	$school_dest = in_val('school_dest', 'any');
	$kode_sekolah = 		in_val('kode_sekolah', 'any');
	$school_group = in_val('school_group', 'any');
	$partner_status = in_val('partner_status', 'any');
	$program_clasifie = in_val('program_clasifie', 'any');
	$program_status = in_val('program_status', 'any');
	$program_dest = in_val('program_dest', 'any');
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
	$tgl_intake = "$intake_date_y-$intake_date_m-15";
	$program_duration = in_val('program_duration', 'any');
	$comm_date = in_val('comm_date', 'any');
	$comm_date_end = in_val('comm_date_end', 'any');
	$pdo_date = in_val('pdo_date', 'any');
	$payment_status = in_val('payment_status', 'any');
	$remark_problem = in_val('remark_problem', 'any');
	$remark_solution = in_val('remark_solution', 'any');
	$next_fu_date = in_val('next_fu_date', 'any');
	$tf_balance_fee_due_date = in_val('tf_balance_fee_due_date', 'any');		
	}
//==bersihkn step
	$query_step_clear = q_set($__p_query_step_clear, "SELECT nm_step from tb_step_admission where jns_step = ? and nm_step = ? ", [(string) ($adm_status), (string) ($adm_step)]);
	$resource_step_clear = db_query_or_die('errro_a', $query_step_clear, $__p_query_step_clear ?? []);
	$keluar_step_clear= db_num_rows($resource_step_clear);
	if(num(db_num_rows($resource_step_clear)) == 0)
		{
		$adm_step ="";
		}
	$query_school_clear = q_set($__p_query_school_clear, "SELECT school from tb_master_partner where country = ? and school = ? ", [(string) ($country_dest), (string) ($school_dest)]);
	$resource_school_clear = db_query_or_die('errro_a', $query_school_clear, $__p_query_school_clear ?? []);
	$keluar_school_clear= db_num_rows($resource_school_clear);
	if(num(db_num_rows($resource_school_clear)) == 0)
		{
		$school_dest ="";
		}
//==========
if ($refer_status =='N'){$agent_referal = 'NONE';}else{$agent_referal = '';}
//============
//load group
$query_group_school = q_set($__p_query_group_school, "SELECT distinct groupschool FROM tb_master_partner where groupschool <>'' order by groupschool");
$resource_group_school = db_query_or_die('errro_b', $query_group_school, $__p_query_group_school ?? []);
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
//load prg clasified
$query_prg_cl = q_set($__p_query_prg_cl, "SELECT prg_clasifie from tb_mst_prg_clasifie order by prg_clasifie ");
$resource_prg_cl = db_query_or_die('errro_c', $query_prg_cl, $__p_query_prg_cl ?? []);
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
$query_sc = q_set($__p_query_sc, "SELECT distinct nama_detail from tb_user where  (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and aktif = 'Y' and nama_detail is not null  order by nama_detail ");
$resource_sc = db_query_or_die('errro_d', $query_sc, $__p_query_sc ?? []);
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
$resource_step = db_query_or_die('errroe', $query_step, $__p_query_step ?? []);
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

//=============
$query_kd_school = q_set($__p_query_kd_school, "SELECT  t.kd_school,grade  FROM ves_data.tb_master_partner t where school = ? and country = ? ", [(string) ($school_dest), (string) ($country_dest)]);

$resource_kd_school = db_query_or_die('errro_rr', $query_kd_school, $__p_query_kd_school ?? []);
$keluar_kd_school= db_num_rows($resource_kd_school);
if(num(db_num_rows($resource_kd_school)) > 0)
	{
	while ($row_kd_school=  db_fetch($resource_kd_school, PDO::FETCH_NUM))
		{
		$kode_sekolah= $row_kd_school[0];
		$bintang= $row_kd_school[1];
			
		}
	}


if (num($asal) ==2 )
	{
	$queryenroll = q_set($__p_queryenroll, "SELECT enroll_date FROM tb_sales_report  where kd_biodata = ? and no = ? ", [(string) ($kdb), (string) ($no_sales)]);

	$resource_enroll  = db_query_soft($queryenroll, $__p_queryenroll ?? []);
	$keluar_enroll  = db_num_rows($resource_enroll);
	if(num(db_num_rows($resource_enroll)) > 0)
		{
		while ($row_enroll   =  db_fetch($resource_enroll, PDO::FETCH_NUM))
			{
			$enroll_date_asal = $row_enroll['0'];
			$enroll_date = $enroll_date_asal;
			}
		}	
	}
$wajib = "form-group has-error";
$tdkwajib = "form-group";
$wajiblabel = "label-danger";
	

//====================
if($adm_status =='ON' and substr($adm_step,0,2) =='1:') {$langkah = '10';}
if($adm_status =='ON' and substr($adm_step,0,2) =='2:') {$langkah = '20';}
if($adm_status =='ON' and substr($adm_step,0,2) =='3:') {$langkah = '20';}
if($adm_status =='ON' and substr($adm_step,0,2) =='4:') {$langkah = '40';}
if($adm_status =='ON' and substr($adm_step,0,2) =='5:') {$langkah = '60';}
if($adm_status =='ON' and substr($adm_step,0,2) =='6:') {$langkah = '60';}
if($adm_status =='ON' and substr($adm_step,0,2) =='7:') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,2) =='8:') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,2) =='9:') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,2) =='10') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,2) =='11') {$langkah = '80';}
if($adm_status =='ON' and substr($adm_step,0,2) =='12') {$langkah = '80';}
if($adm_status =='C') {$langkah = '1';}
if($adm_status =='PR') {$langkah = '1';}
if($adm_status =='PDO') {$langkah = '90';}
if($adm_status =='L') {$langkah = '100';}

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
  
<?php //  include __DIR__ . "/left.php";	 ?>
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
            <option>PDOl</option>
            <option>L</option>
            <option>Ll</option>            
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
$resource_step = db_query_or_die('errro_i', $query_step, $__p_query_step ?? []);
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
    <div class="<?php 
	if ($langkah >= '10'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>">
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
                 	      value="<?php echo e($enroll_date) ?>" >
  </span>
  <div class="col-md-12">
    <div class=" <?php 
	if ($langkah >= '10' or $adm_status =='PR' or $adm_status ='C'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Original School</label>
      <input name="ori_school"  class="form-control"  type="text" size="90" value="<?php echo e($ori_school)  ?>" />
    </div>
  </div>
  
 
  <div class="col-md-3">
    <div class=" <?php if($langkah >= '10' or $adm_status =='PR'  or $adm_status =='C'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Student Consultant</label>
      <select name="sc_pic"  class="form-control" >
          <option value= "">
          <?=$list_sc?>
          </option>
          <option selected="selected">
        <?php  if ($sc_pic =='') { echo e($pic_list); }else { echo e($sc_pic); }
   ?>
          </option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class=" <?php if ($langkah >= '10'  or $adm_status =='PR'  or $adm_status =='C'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
            <label>Admission Consultant</label>
      <select name="adm_pic" class="form-control">
        <?php
								$query_ac = q_set($__p_query_ac, "SELECT distinct nama_detail from tb_user where (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and aktif = 'Y' and nama_detail is not null  order by nama_detail");
								$resource_ac = db_query_or_die('errro_72', $query_ac, $__p_query_ac ?? []);
								while ($row_ac=  db_fetch($resource_ac, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_ac[0]).'">'.e($row_ac[0]).'</option>';
							  		}      ?>
          <option selected="selected">
        <?php  if ($adm_pic =='') {  echo ""; }else { echo e($adm_pic); }
   ?>
          </option>
      </select>
    </div>
  </div
  <span class="form-group">
  <input type="text" ang="en-150"   name="no" 
                 	      value="<?php echo e($no) ?>" hidden="hidden">
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="langkah" 
                 	      value="<?php echo e($langkah) ?>" hidden>
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="asal" 
                 	      value="<?php echo e($asal) ?>"hidden>
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="no_sales" 
                 	      value="<?php echo e($no_sales) ?>" hidden>
  </span></div>
<div class="box-body">
  <div class="col-md-3">
    <div class=" <?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Destination Country </label>
      <select name="country_dest"  class="form-control" onchange="this.form.submit()" >
        <?php
								$query_country = q_set($__p_query_country, "SELECT  distinct country FROM ves_data.tb_master_partner t where school not like '%DELETE%'");
$resource_country = db_query_or_die('errro_r', $query_country, $__p_query_country ?? []);
$keluar_country= db_num_rows($resource_country);
								while ($row_country=  db_fetch($resource_country, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_country[0]).'">'.e($row_country[0]).'</option>';
							  		}      ?>
          <option selected="selected">
            <?php  echo e($country_dest)    ?>
          </option>
      </select>
    </div>
  </div>
  <div class="col-md-8">
    <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Destination School </label>
      <select name="school_dest"  class="form-control"  onchange="this.form.submit()" > 
      <?php          
$query_school = q_set($__p_query_school, "SELECT  t.kd_school, t.school FROM ves_data.tb_master_partner t where school not like '%DELETE%' and country = ? order by t.school", [(string) ($country_dest)]);
$resource_school = db_query_or_die('errro_h', $query_school, $__p_query_school ?? []);
$keluar_school= db_num_rows($resource_school);	  
if(num(db_num_rows($resource_school)) > 0)
	{
	while ($row_school=  db_fetch($resource_school, PDO::FETCH_NUM))
		{
		echo '<option value="'.e($row_school[1]).'">'.e($row_school[1]).'</option>';
		}  	
	} ?>
 <option selected="selected"><?php  echo e($school_dest) ?></option>
      </select>
    </div>
  </div>
  <input type="kode_sekolah" name="kode_sekolah"  value = "<?php echo e($kode_sekolah)  ?>" hidden />
  <div class="col-md-3">
    <div class="<?php if($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Group of School </label>

      <select name="school_group" size="1" id="school_group" class="form-control" >

          <option value= >
          <?=$list_group_school?>
               <option>NONE</option>          	  
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
    <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
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
  <div class="<?php if ($langkah >= '20'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
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
      <select name="refer_status" class="form-control" onchange="this.form.submit()" >
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
      <input type="text" name="tf_balance_fee_due_date"  class="form-control"  value = "<?php echo e($tf_balance_fee_due_date)    ?>"/>
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
          <option>2018</option>
          <option>2019</option>
          <option>2020</option>
          <option>2021</option>
          <option>2022</option>
          <option>2023</option>		  
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
    <div class=" <?php if ($adm_status == 'PR' or $adm_status == 'C' ){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Description</label>
      <input name="remark_problem" type="text" id="remark_problem" size="200"  class="form-control" 
value = "<?php echo e($remark_problem)  ?>" />
    </div>
  </div>
  <div class="col-md-6">
    <div class=" <?php if ($adm_status == 'PR' or $adm_status == 'C'  ){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
      <label>Solution</label>
      <input name="remark_solution" type="text" id="remark_solution" size="200"  class="form-control" 
value = "<?php echo e($remark_solution)
  ?>" />
    </div>
  </div>
</div>   
<div class="box-body">
  <div class="col-md-6">
    <div class=" <?php if (($langkah >= '10' and $langkah <='99')  or $adm_status =='PR'){echo e($wajib);}else {echo e($tdkwajib) ;} ?>">
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
	$asal = in_val('asal', 'any');	
	$hari=date("d");
	$bulan=date("m");
	$bulanan=date("M");
	$tahun=date("Y");
	$tgl_hari_ini =  "$tahun-$bulan-$hari";		
	$branch = $_SESSION['branch']; 
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$kdcbg = in_val('kdcbg', 'any'); 
	$kdb = in_val('kdb', 'any');
	$student_name = in_val('student_name', 'any');
	$enroll_date = in_val('enroll_date', 'any');

	$adm_status = in_val('adm_status', 'any');
	$adm_step = in_val('adm_step', 'any');
	$student_name = in_val('student_name', 'any');
	$ori_school = in_val('ori_school', 'any');
	$sc_pic = in_val('sc_pic', 'any');
	$adm_pic = in_val('adm_pic', 'any');
	$country_dest = in_val('country_dest', 'any');
	$school_dest = in_val('school_dest', 'any');
	$kode_sekolah = 		in_val('kode_sekolah', 'any');
	$school_group = in_val('school_group', 'any');
	$partner_status = in_val('partner_status', 'any');
	$program_clasifie = in_val('program_clasifie', 'any');
	$program_status = in_val('program_status', 'any');
	$program_dest = in_val('program_dest', 'any');
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
	$tgl_intake = "$intake_date_y-$intake_date_m-15";
	$program_duration = in_val('program_duration', 'any');
	$comm_date = in_val('comm_date', 'any');
	$comm_date_end = in_val('comm_date_end', 'any');
	$pdo_date = in_val('pdo_date', 'any');
	$payment_status = in_val('payment_status', 'any');
	$remark_problem = in_val('remark_problem', 'any');
	$remark_solution = in_val('remark_solution', 'any');
	$next_fu_date = in_val('next_fu_date', 'any');
	$tf_balance_fee_due_date = in_val('tf_balance_fee_due_date', 'any');
	$langkah = in_val('langkah', 'any');
	if ($kdcbg =='1'){$nm_cabang = 'East Sby';}
	elseif ($kdcbg =='2'){$nm_cabang = 'West Sby';}
	elseif ($kdcbg =='3'){$nm_cabang = 'Bali';}
	elseif ($kdcbg =='4'){$nm_cabang = 'Patal Jkt';}
	elseif ($kdcbg =='5'){$nm_cabang = 'Central Jkt';}
	elseif ($kdcbg =='6'){$nm_cabang = 'West Jkt';}
	elseif ($kdcbg =='7'){$nm_cabang = 'Bandung';}
	elseif ($kdcbg =='8'){$nm_cabang = 'Malang TBI';}
	$querydob = q_set($__p_querydob, "SELECT dob,org_school,kd_branch, branch FROM  ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($kdb)]);								
	$resource_dob  = db_query_soft($querydob, $__p_querydob ?? []);
	$keluar_dob  = db_num_rows($resource_dob);
	if(num(db_num_rows($resource_dob)) > 0)
		{
		while ($row_dob   =  db_fetch($resource_dob, PDO::FETCH_NUM))
			{
			$dob = $row_dob['0'];
			$ori_school = $row_dob['1'];
			$kode_branch = $row_dob['2'];
			$nama_branch = $row_dob['3'];
			}
		}	
		
		$gagalsimpan = '';

	if ($adm_status =='ON')
		{
		if ($adm_status =='' or	$adm_step  =='' or $student_name  =='' or 	$sc_pic  =='' or 	$adm_pic =='')
		{$gagalsimpan = 1;}		
		}	
	elseif ($adm_status =='PR')
		{
		if ($adm_status =='' or	$adm_step  =='' or $student_name  =='' or 	$sc_pic  =='' or 	$adm_pic =='' or $remark_problem  =='' or 	$remark_solution  =='')
		{$gagalsimpan = 1;}		
		}
	elseif ($adm_status =='C')
		{
		if ($adm_status =='' or	$adm_step  =='' or $student_name  =='' or $remark_problem  =='' or $remark_solution  =='' )
		{$gagalsimpan = 1;}		
		}		
	if (num($gagalsimpan) <> 1)
		{
		$query_update_last= q_set($__p_query_update_last, "update ves_data.adm_stu_progress set aktif = '0' where kd_biodata = ? and enroll_date = ? ", [(string) ($kdb), (string) ($enroll_date)]);	

		$resource_update_last = db_query_or_die('errro_simpan1', $query_update_last, $__p_query_update_last ?? []);

		$query_simpan= q_set($__p_query_simpan, "insert into adm_stu_progress \r
\t\t(kd_biodata, enroll_date, final_status,step,nama,ori_school,sc_name,\r
\t\tadm_pic,dest_country,dest_school,group_school,p_np,\r
\t\tprogram_clasifie,mp_ap,dest_program,major,h_nh,\r
\t\tar,agent_referal,tf_full_program,pasport,tf_fee_paid,\r
\t\ttf_term_paid,tf_balance_fee,tgl_intake,program_duration,comm_date,\r
\t\tcomm_date_end,pdo_date,remark_problem,remark_solution,next_update,\r
\t\tpic,kd_branch, dt_entry,kd_school,aktif,tf_balance_fee_due_date,update_date,branch\r
\t\t) \r
\t\tvalues \r
\t\t(\r
\t\t? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? , ? ,? ,? ,\r
\t\t? , ? ,? ,? ,1,? ,? ,?\r
\t\t)", [(string) ($kdb), (string) ($enroll_date), (string) ($adm_status), (string) ($adm_step), (string) ($student_name), (string) ($ori_school), (string) ($sc_pic), (string) ($adm_pic), (string) ($country_dest), (string) ($school_dest), (string) ($school_group), (string) ($partner_status), (string) ($program_clasifie), (string) ($program_status), (string) ($program_dest), (string) ($major), (string) ($major_group), (string) ($refer_status), (string) ($agent_referal), (string) ($tf_full_program), (string) ($pasport), (string) ($tf_fee_paid), (string) ($tf_term_paid), (string) ($tf_balance_fee), (string) ($tgl_intake), (string) ($program_duration), (string) ($comm_date), (string) ($comm_date_end), (string) ($pdo_date), (string) ($remark_problem), (string) ($remark_solution), (string) ($next_fu_date), (string) ($nama_lengkap), (string) ($kode_branch), " " . (string) ($tgl_hari_ini), (string) ($kode_sekolah), (string) ($tf_balance_fee_due_date), (string) ($tgl_hari_ini), (string) ($nama_branch)]);

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
		echo "alert('New Admission Progress Submitted');\n";
		if ($asal == '1')
		{
		echo "window.location = ('admission_progress.php');\n";		
		}
		elseif(num($asal)==2)
		{
		echo "window.location = ('carry_on_student.php');\n";				
		}
		else
		{
		echo "window.location = ('admission_progress.php');\n";				
		}		
		echo "</script>";
		}
	else
		{	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Field with Red Border Must be fill in');\n";
		echo "</script>";
		}
	}
?>