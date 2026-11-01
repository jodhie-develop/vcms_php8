<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php"; 
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
date_default_timezone_set('Asia/Jakarta');
$jamskrg= date('h:i:s', time());
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'any');
$date_end = in_val('date_end', 'any');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$kdb = in_val('kdb', 'any');
//if ($kode_student ==''){$kode_student = in_val('kd_biodata', 'any');}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;
//=== list sc====
$query_sc = q_set($__p_query_sc, "SELECT  nama_detail FROM ves_data.tb_user t where (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and kd_branch = ? and aktif = 'Y' group by nama_detail order by nama_detail", [(string) ($kd_cbg)]);

$resource_sc = db_query_or_die('errro_2', $query_sc, $__p_query_sc ?? []);
$keluar_sc= db_num_rows($resource_sc);
if(num(db_num_rows($resource_sc)) > 0)
	{
	while ($row_sc=  db_fetch($resource_sc, PDO::FETCH_NUM))
		{
		$nm_sc= $row_sc[0];				
		$list_sc.="<OPTION VALUE=\"" . e($nm_sc) . "\">".e($nm_sc);
		}
	}
//======tampilkan detail
$query_detail = q_set($__p_query_detail, "SELECT t.nama, t.middle_name, t.family_name, DATE_FORMAT(t.dob,'%d %b %y'), t.gender, t.address, t.city, t.hm_ph, t.hp, t.org_school, t.grade, t.parent_nm, t.add_parent, t.city_parent, t.hp_parent, t.level_school, t.event_st_dtl, media_src, media_src_dtl, t.ves_last_update, t.vip_last_update, t.vip_remark, t.e_mail, t.hp_2, \r
t.mother_name, t.ph_mother, t.country_1, t.school_1, t.program_1, event_type,event_type_dtl, media_src, media_src_dtl,ves_status,kd_school_1 \r
FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($kdb)]);

$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar_detail = db_num_rows($resource_detail);
if(num(db_num_rows($resource_detail)) > 0)
	{
	while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
		{
		$nama = $row_detail[0];
		$middle_name = $row_detail[1];
		$family_name = $row_detail[2];
		$dob = $row_detail[3];
		$gender = $row_detail[4];
		$address = $row_detail[5];
		$city = $row_detail[6];
		$hm_ph = $row_detail[7];
		$hp = $row_detail[8];
		$org_school = $row_detail[9];
		$grade = $row_detail[10];
		$parent_nm = $row_detail[11];
		$add_parent = $row_detail[12];
		$city_parent = $row_detail[13];
		$hp_parent = $row_detail[14];
		$level_school = $row_detail[15];
		$ves_last_update = $row_detail[19];
		$vip_last_update = $row_detail[20];
		$vip_remark = $row_detail[21];
		$e_mail = $row_detail[22];
		$hp_2 = $row_detail[23];
		$mother_name = $row_detail[24];
		$ph_mother = $row_detail[25];
		$country_1  = $row_detail[26];
		$school_1 = $row_detail[27];
		$program_1 = $row_detail[28];
		$event_type  = $row_detail[29];
		$event_type_dtl  = $row_detail[30];
		$media_src  = $row_detail[31];
		$media_src_dtl	= $row_detail[32];
		$ves_status= $row_detail[33];
		$kd_school_1= $row_detail[34];	
		}
	}
//========
//=============data destination==================

$query_enroll = q_set($__p_query_enroll, "SELECT a.kd_school, a.country_dest, a.sch_dest, a.prg_dest, a.major_dest,\r
a.status_host,a.status_part,\r
DATE_FORMAT(a.enroll_date,'%d'),DATE_FORMAT(a.enroll_date,'%m'),yeaR(a.enroll_date),\r
DATE_FORMAT(a.intake_date,'%m'),  YEAR(a.intake_date),  a.status_program, a.pic, b.adm_pic, b.adm_pic_2, b.prioritas, a.org_prof_cur, a.org_prof_fee, a.prof_fee, a.discount_name, a.no\r
FROM ves_inc.tb_enrolled a, ves_data.tb_sales_report b where a.kd_biodata = b.kd_biodata and a.kd_school = b.kd_school and a.enroll_date = b.enroll_date and a.kd_biodata = ? ", [(string) ($kdb)]);
				$resource_enroll = db_query_soft($query_enroll, $__p_query_enroll ?? []);
				$keluar_enroll = db_num_rows($resource_enroll);
				if(num(db_num_rows($resource_enroll)) > 0)
					{
					while ($row_enroll  =  db_fetch($resource_enroll, PDO::FETCH_NUM))
						{
						$kd_school = $row_enroll[0];
						$country_dest = $row_enroll[1];
						$sch_dest = $row_enroll[2];
						$prg_dest = $row_enroll[3];
						$major_dest = $row_enroll[4];
						$status_host = $row_enroll[5];
						$status_part = $row_enroll[6];
						$enroll_date_d = $row_enroll[7];
						$enroll_date_m = $row_enroll[8];
						$enroll_date_y = $row_enroll[9];
						$intake_date_m = $row_enroll[10];
						$intake_date_y = $row_enroll[11];
						$status_program = $row_enroll[12];
						$pic = $row_enroll[13];
						$adm_pic_pilih = $row_enroll[14];
						$adm_pic_2_pilih = $row_enroll[15];
						$prioritas = $row_enroll[16];
						$org_prof_cur = $row_enroll[17];
						$org_prof_fee = $row_enroll[18];
						$prof_fee = $row_enroll[19];
						$discount_name = $row_enroll[20];
						$no_enrolled = $row_enroll[21];	
						}
					}
$kd_school_1 = $kd_school_1_profile ;

$flt_country1 = in_val('flt_country1', 'any');


//========country 1
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
		$nm_country1= $row_country[0];				
		$list_country1.="<OPTION VALUE=\"" . e($nm_country1) . "\">".e($nm_country1);
		}
	}
//=============
//load school country 1
if ($flt_country1 !="")
{
$query_school = q_set($__p_query_school, "SELECT  t.school FROM ves_data.tb_master_partner t where school not like '%DELETE%' and country = ? and (kd_school is not null  or kd_school <> '') order by\r
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
ELSE 12 end, country asc, school", [(string) ($flt_country1)]);
}
else
{$query_school = q_set($__p_query_school, "SELECT  t.school FROM ves_data.tb_master_partner t where school not like '%DELETE%'  and (kd_school is not null  or kd_school <> '') order by\r
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
ELSE 12 end, country asc, school");}
$resource_school = db_query_or_die('errro_', $query_school, $__p_query_school ?? []);
$keluar_school= db_num_rows($resource_school);
if(num(db_num_rows($resource_school)) > 0)
	{
	while ($row_school=  db_fetch($resource_school, PDO::FETCH_NUM))
		{					
		$nm_school1= $row_school[0];				
		$list_school1.="<OPTION VALUE=\"" . e($nm_school1) . "\">".e($nm_school1);
		}
	}
	
//========
//=============
$query_program = q_set($__p_query_program, "SELECT  nm_program_dest FROM ves_inc.tb_program_dest order by nm_program_dest ");
$resource_program = db_query_or_die('errro_', $query_program, $__p_query_program ?? []);
$keluar_program= db_num_rows($resource_program);
if(num(db_num_rows($resource_program)) > 0)
	{
	while ($row_program=  db_fetch($resource_program, PDO::FETCH_NUM))
		{					
		$nm_program= $row_program[0];				
		$list_program.="<OPTION VALUE=\"" . e($nm_program) . "\">".e($nm_program);
		}
	}
$current_action = in_val('current_action', 'any');
if ($current_action=='')
	{
	if (num($statussimpan)==0){$pesan="Action ";}
	$statussimpan=1;
	}
$result = in_val('result', 'any');
if ($result =='')
	{
	if (num($statussimpan)==0){$pesan="result ";}
	$statussimpan=1;
	}
$current_status = in_val('current_status', 'any');
if ($current_status=='')
	{
	if (num($statussimpan)==0){$pesan="current status ";}
	$statussimpan=1;
	}

$remark = in_val('remark', 'any');
if ($remark=='')
	{
	if (num($statussimpan)==0){$pesan="remark ";}
	$statussimpan=1;
	}
$flt_country1 = in_val('flt_country1', 'any');
$flt_school1 = in_val('flt_school1', 'any');
if ($flt_country1 !="" and $flt_school1 !="")
	{
	$query_get_kode = q_set($__p_query_get_kode, "select kd_school from ves_data.tb_master_partner where country = ? \r
\tand school = ? ", [(string) ($flt_country1), (string) ($flt_school1)]);
	$resource_get_kode = db_query_or_die('errro_1', $query_get_kode, $__p_query_get_kode ?? []);
	if(num(db_num_rows($resource_get_kode)) > 0)
		{
		while ($row_get_kode=  db_fetch($resource_get_kode, PDO::FETCH_NUM))
			{
			$kd_school_1= $row_get_kode[0];				
			}
		}
		
	}
$flt_program1 = in_val('flt_program1', 'any');
$flt_country2 = in_val('flt_country2', 'any');
$flt_school2 = in_val('flt_school2', 'any');
$flt_program2 = in_val('flt_program2', 'any');
$flt_country3 = in_val('flt_country3', 'any');
$flt_school3 = in_val('flt_school3', 'any');
$flt_program3 = in_val('flt_program3', 'any');
if ($current_status != "E")
	{
	if ($current_status != "L")
		{
		$nextaction = in_val('nextaction', 'any');
		if ($nextaction=='')
			{
			if (num($statussimpan)==0){$pesan="Next Action ";}
			$statussimpan=1;
			}
		$nextremark = in_val('nextremark', 'any');
		if ($nextremark=='')
			{
			if (num($statussimpan)==0){$pesan="Next Remark ";}
			$statussimpan=1;
			}
			
		$due_date_dd = in_val('due_date_dd', 'any');
		if ($due_date_dd=='')
			{
			if (num($statussimpan)==0){$pesan="Date Due Date ";}
			$statussimpan=1;
			}
		$due_date_mm = in_val('due_date_mm', 'any');
		if ($due_date_mm=='')
			{
			if (num($statussimpan)==0){$pesan="Month Due Date ";}
			$statussimpan=1;
			}
		$due_date_yy = in_val('due_date_yy', 'any');
		if ($due_date_yy=='')
			{
			if (num($statussimpan)==0){$pesan="year Due Date ";}
			$statussimpan=1;
			}
		$due_date_lengkap = "$due_date_yy-$due_date_mm-$due_date_dd";	
		}
	}
else
	{
	$flt_country1 = in_val('flt_country1', 'any');
	if ($flt_country1=='')
		{
		if (num($statussimpan)==0){$pesan="Country  Destination ";}
		$statussimpan=1;
		}

	$flt_school1 = in_val('flt_school1', 'any');
	if ($flt_school1=='')
		{
		if (num($statussimpan)==0){$pesan="School Destination ";}
		$statussimpan=1;
		}
	
	$flt_program1 = in_val('flt_program1', 'any');
	if ($flt_program1=='')
		{
		if (num($statussimpan)==0){$pesan="Program Destination ";}
		$statussimpan=1;
		}
	


	$hadnon = in_val('hadnon', 'any');
	if ($hadnon=='')
		{
		if (num($statussimpan)==0){$pesan="H/AD/Other ";}
		$statussimpan=1;
		}
	
	$pnp = in_val('pnp', 'any');
	if ($pnp=='')
		{
		if (num($statussimpan)==0){$pesan="P/NP ";}
		$statussimpan=1;
		}
	
	$enroll_ddd = in_val('enroll_ddd', 'any');
	if ($enroll_ddd=='')
		{
		if (num($statussimpan)==0){$pesan="Enroll Date  ";}
		$statussimpan=1;
		}
	
	$enroll_mmm = in_val('enroll_mmm', 'any');
	if ($enroll_mmm=='')
		{
		if (num($statussimpan)==0){$pesan="Enroll Month  ";}
		$statussimpan=1;
		}
	
	$enroll_yyy = in_val('enroll_yyy', 'any');
	if ($enroll_yyy=='')
		{
		if (num($statussimpan)==0){$pesan="Enroll Year  ";}
		$statussimpan=1;
		}
	
	$enroll_date = "$enroll_yyy-$enroll_mmm-$enroll_ddd";
	$intake_mmm = in_val('intake_mmm', 'any');
	if ($intake_mmm=='')
		{
		if (num($statussimpan)==0){$pesan="Intake Month  ";}
		$statussimpan=1;
		}
	
	$intake_yyy = in_val('intake_yyy', 'any');
	if ($intake_yyy=='')
		{
		if (num($statussimpan)==0){$pesan="Intake Year  ";}
		$statussimpan=1;
		}

	$intake_date = "$intake_yyy-$intake_mmm-01";
	
	$program_status = in_val('program_status', 'any');
	if ($program_status=='')
		{
		if (num($statussimpan)==0){$pesan="Program Status ";}
		$statussimpan=1;
		}

	$dochandler = in_val('dochandler', 'any');
	if ($dochandler=='')
		{
		if (num($statussimpan)==0){$pesan="Document Handler";}
		$statussimpan=1;
		}
	
	$visahandler = in_val('visahandler', 'any');
	if ($visahandler=='')
		{
		if (num($statussimpan)==0){$pesan="Visa Handler";}
		$statussimpan=1;
		}
	$prioritas = in_val('prioritas', 'any');	
	if ($prioritas=='')
		{
		if (num($statussimpan)==0){$pesan="Priority ";}
		$statussimpan=1;
		}	
	$query_kd_school = q_set($__p_query_kd_school, "SELECT  kd_school FROM ves_data.tb_master_partner t where school = ? and country = ? ", [(string) ($flt_school1), (string) ($flt_country1)]);
	$resource_kd_school = db_query_or_die('errro_kd_school1', $query_kd_school, $__p_query_kd_school ?? []);
	$keluar_kd_school= db_num_rows($resource_kd_school);
	if(num(db_num_rows($resource_kd_school)) > 0)
		{
		while ($row_kd_school=  db_fetch($resource_kd_school, PDO::FETCH_NUM))
			{
			$kd_school1= $row_kd_school[0];				
			}
		}
	$org_cur = in_val('org_cur', 'any');
	if ($org_cur=='')
		{
		if (num($statussimpan)==0){$pesan="Original Currency ";}
		$statussimpan=1;
		}
	
	$org_pf = in_val('org_pf', 'any');
	if ($org_pf=='')
		{
		if (num($statussimpan)==0){$pesan="Original Proffesional Fee ";}
		$statussimpan=1;
		}
	
	$pf = in_val('pf', 'any');
	if ($pf=='')
		{
		if (num($statussimpan)==0){$pesan="Proffesional Fee ";}
		$statussimpan=1;
		}

	$program_status	 = in_val('program_status', 'any');
	if ($program_status=='')
		{
		if (num($statussimpan)==0){$pesan="Program Status ";}
		$statussimpan=1;
		}
	$prioritas = in_val('prioritas', 'any');	
	if ($prioritas=='')
		{
		if (num($statussimpan)==0){$pesan="Priority ";}
		$statussimpan=1;
		}
	$discount = in_val('discount', 'any');
	if ($discount=='')
		{
		if (num($statussimpan)==0){$pesan="Discount ";}
		$statussimpan=1;
		}
	
	$event_type  = $row_detail[38];
	$event_type_dtl  = $row_detail[39];
	$media_src  = $row_detail[40];
	$media_src_dtl	= $row_detail[41];	
	$org_cur = in_val('org_cur', 'any');
	$org_pf = in_val('org_pf', 'any');
	$pf = in_val('pf', 'any');			
	}
$kd_student = in_val('kd_student', 'any');


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | User Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="cdnjs/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">User profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
<div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="dist/img/user4-128x128.jpg" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo e($nama) ?> <?php echo e($middle_name)  ?><?php echo e($family_name)  ?></h3> 
              <span class="profile-username text-center"></span>
              <p class="text-muted text-center"><?php echo e($dob) ?></p>
 <p class="text-muted text-center"><?php echo e($org_school) ?> <?php echo e($grade)?></p>
                  
       
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Leads</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><strong><em class="fa fa-book margin-r-5"></em> Address</strong>
              <p class="text-muted">
                <?php echo e($address)  ?><?php echo e($city) ?>
              </p>
              <strong><em class="fa fa-map-marker margin-r-5"></em> Phone Number</strong>
              <p class="text-muted"><?php echo e($hp) ?></p>
              <strong><em class="fa fa-map-marker margin-r-5"></em> E-Mail</strong>
              <p class="text-muted"><?php echo e($e_mail)  ?></p>
      
              <hr>
              <strong><em class="fa fa-book margin-r-5"></em> Parent &nbsp;Info</strong>
              <p class="text-muted">
                <strong>Father :</strong> 
              </p>
               <p class="text-muted">
                <strong>Mother :</strong> 
              </p>

<hr>
              <strong><em class="fa fa-map-marker margin-r-5"></em> Marketing Info</strong>
              <p class="text-muted"><?php echo e($event_type)   ?><?php echo e($event_type_dtl)   ?></p><br>
			  <p class="text-muted"><?php echo e($media_src)   ?><?php echo e($media_src_dtl)   ?></p>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
<ul class="nav nav-tabs">
  <li></li>
  <li></li>
  <li></li>                           
  <li></li>
           </ul>


              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="post"><?php echo csrf_field(); ?>

              <table width="20%">
            <tr>
              <td width="1000"><strong>VES Enroll Data</strong></td>
              <td width="34">&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Country<br>
              </strong>
                <select name="flt_country1" id="flt_country1"onChange="this.form.submit()" >
                  <option value= "">
                  <?php echo $list_country1?>
                  </option>
                  <option selected="selected">
                  <?php  		   if ($flt_country1 !="") { echo e($flt_country1); }else { if ($country_dest !='') {echo e($country_dest);}else{echo e($country_dest);} }

   ?>	
                  </option>
                </select>
                <label for="textfield"></label>
                <input type="text" name="kd_school" id="kd_school" value="<?php echo e($kd_school) ?>"  hidden="hidden">
              </span>
              <input type="text" name="kdb" id="kd_biodata" value="<?php echo e($kdb) ?>"  >
              <input type="text" name="no_enrolled" id="kd_biodata2" value="<?php echo e($no_enrolled) ?>"  ></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><strong>School<br>
              </strong><span class="style92">
                <select name="flt_school1" id="flt_school1" onchange="this.form.submit()" >
                  <option value= >
                  <?php echo $list_school1?>
                  <option selected="selected">
                  <?php  if ($flt_school1 !="") {echo e($flt_school1);}else{if($flt_school1 != ''){echo e($flt_school1);}else{echo e($sch_dest);}}?>
                  </option>
                </select>
              </span></td>
              </tr>
            <tr>
              <td><strong>Program<br>
              </strong><span class="style92">
                <select name="flt_program1" id="flt_program1">
                  <option value= >
                  <?php echo $list_program?>
                  <option selected="selected">
                  <?php  if ($flt_program1 !="") { echo e($flt_program1); }else { if ($flt_program1 !=''){echo e($program_dest1); }{echo e($prg_dest);}}
 				  
   ?>
                  </option>
                </select>
              </span></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">

			  <table width="1050" border="0">
                <tr>
                  <td colspan="5"><strong>Major</strong><br><input type="text" name="major" size="50" value="<?php echo e($major_dest)  ?>"></td>
                  </tr>
                <tr>
                  <td colspan="2"><strong>H/AD/Other</strong><span class="style92">
                    <br>
                    <select name="hadnon" id="hadnon">
                      <option>H</option>
                      <option>STEM</option>
                      <option>AD</option>
                      <option>NON</option>
                      <option selected="selected">
                      <?php   echo e($status_host) ;    ?>
                      </option>
                    </select>
                  </span></td>
                  <td colspan="3"><strong>Partnership</strong><span class="style92"><br>
                    <select name="pnp" id="pnp">
                      <option>P</option>
                      <option>NP</option>
                      <option selected="selected">
                      <?php  echo e($status_part) ;   ?>
                      </option>
                    </select>
                  </span></td>
                </tr>
                <tr>
                  <td width="174"><strong>Enroll Date </strong></td>
                  <td colspan="4"><span class="style2">
                    <select name="enroll_ddd" id="select">
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
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                      <option>25</option>
                      <option>26</option>
                      <option>27</option>
                      <option>28</option>
                      <option>29</option>
                      <option>30</option>
                      <option>31</option>
                      <option selected="selected"> <?php echo e($enroll_date_d);  ?> </option>
                    </select>
                    <select name="enroll_ddd2" id="enroll_ddd" hidden="hidden">
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
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                      <option>25</option>
                      <option>26</option>
                      <option>27</option>
                      <option>28</option>
                      <option>29</option>
                      <option>30</option>
                      <option>31</option>
                      <option selected="selected"> <?php echo e($enroll_date_d);  ?></option>
                    </select>
                    <select name="enroll_mmm" id="select2">
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
                      <option selected="selected"> <?php echo e($enroll_date_m);  ?> </option>
                    </select>
                    <select name="enroll_mmm2" id="enroll_mmm" hidden="hidden">
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
                      <option selected="selected"> <?php echo e($enroll_date_m);  ?></option>
                    </select>
                    <select name="enroll_yyy" id="select3">
                      <option>2016</option>
                      <option>2017</option>
                      <option>2018</option>
                      <option>2019</option>
                      <option>2020</option>
                      <option>2021</option>                                            
                      <option selected="selected"> <?php echo e($enroll_date_y)  ?> </option>
                    </select>
                  <select name="enroll_yyy2" id="enroll_yyy" hidden="hidden">
                      <option>2016</option>
                      <option>2017</option>
                      <option>2018</option>
                      <option>2019</option>
                      <option>2020</option>
                      <option>2021</option>                                            
                      
                      <option selected="selected"> <?php echo e($enroll_date_y)  ?></option>
                  </select>
                  </span></td>
                  </tr>
                <tr>
                  <td><strong>Intake Date </strong></td>
                  <td colspan="4"><span class="style2">
                      <select name="intake_mmm" id="intake_mmm">
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
                        <option selected="selected"> <?php echo e($intake_date_m) ?> </option>
                      </select>
                      <select name="intake_yyy" id="intake_yyy">
                        <option>2016</option>
                        <option>2017</option>
                        <option>2018</option>
                        <option>2019</option>                        
                      <option>2020</option>
                      <option>2021</option>                                            
                        
                        <option selected="selected"><?php echo e($intake_date_y) ?></option>
                      </select>
                  </span></td>
                  </tr>
                <tr>
                  <td><strong>Program Status </strong></td>
                  <td width="189"><span class="style2">
                    <select name="program_status" id="program_status">
                      <option>Main</option>
                      <option>Language</option>
                      <option>Additional</option>
                      <option selected="selected"> <?php echo e($status_program);  ?> </option>
                    </select>
                  </span></td>
                  <td colspan="2">&nbsp;</td>
                  <td width="498">&nbsp;</td>
                </tr>
                <tr>
                  <td><strong>Admission Handler </strong></td>
                  <td><span class="style90">
                    <select name="dochandler"  >
                      <option value= "">
                      <?php echo $list_sc?>
                      </option>
						<option selected="selected"><?php  echo e($adm_pic_pilih);?></option>
                                        </select>
                  </span></td>
                  <td colspan="2"><strong>Visa Handler Handler </strong></td>
                  <td><span class="style90">
                    <select name="visahandler" >
                      <option value= "">
                      <?php echo $list_sc?>
                      </option>
                      <option selected="selected">
                      <?php  echo e($adm_pic_2_pilih);    ?>
                                        </select>
                  </span></td>
                </tr>
                <tr>
                  <td><strong>Priority</strong></td>
                  <td colspan="4"><span class="style92">
                    <select name="prioritas" id="prioritas">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
					  
                      <option selected="selected">
                      <?php   echo e($prioritas);    ?>
                      </option>
                    </select>
                  </span></td>
                  </tr>
                <tr>
                  <td colspan="5"><strong> Proffesional Fee </strong></td>
                  </tr>
                <tr>
                  <td><strong>Currency</strong></td>
                  <td><span class="style92">
                    <select name="org_cur" id="org_cur">
					<option>USD </option>
					<option>EUR</option>
					<option>GBP</option>
					<option>IDR</option>
					<option>AUD</option>
					<option>CAD </option>
					<option>SGD</option>
					<option>CHF</option>
					<option>MYR</option>
					<option>JPY</option>
					<option>CNY</option>
                      <option selected="selected">
                      <?php   echo e($org_prof_cur);    ?>
                      </option>
                    </select>
                  </span></td>
                  <td width="81" align="right"><strong>Rp.</strong></td>
                  <td colspan="2"><span class="style92">
                    <input type="pf" name="pf" size="15" value="<?php echo e($prof_fee) ?>">
                  </span></td>
                  </tr>
                
                <tr>
                  <td><strong>Discount</strong></td>
                  <td><span class="style92">
                    <span class="style92" >
                    <select name="discount_name" id="discount_name" >
                    <option>No Discount</option>
                    <option>Link & Match</option>                    
                    <option selected="selected">
                      <?php  echo e($discount_name);  ?>
                      </option>
                    </select>
                    </span></span></td>
                  <td  align="right" colspan="2">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td><strong>Marketing Source: </strong></td>
                  <td colspan="4"><select name="mkt_source_event">
                    <<option selected disabled>Marketing Source</option>
          <option value= "">
            <?php echo e($list_source_type)?>
            </option>
          <option selected="selected">
            <?php  echo e($event_type)   ?>
                  </select>
                  <input type="Major" name="mkt_source_event_dtl" size="80" value="<?php echo e($event_type_dtl)  ?>"></td>
                </tr>
                <tr>
                  <td><strong>Media Source: </strong></td>
                  <td colspan="4"><select name="media_source">
                             <option selected disabled>Media Source</option>
          <option value= "">
            <?php echo e($list_media_source)?>
            </option>
          <option selected="selected">
            <?php echo e($media_src)     ?>
                    </select>
                    <input type="Major" name="media_source_dtl" size="80" value="<?php echo e($media_src_dtl)  ?>"></td>
                </tr>
                <tr>
                  <td><strong>Student Consultant </strong></td>
                  <td colspan="4"><span class="style90">
                    <select name="pic"  >
                      <option value= ""> <?php echo $list_sc?> </option>
                      <option selected="selected">
                        <?php  echo e($pic); ?>
                  </select>
                  </span></td>
                </tr>
              </table>
		      </td>
              </tr>
            <tr>
              <td><strong class="huruf"><a href="studentprogres.php?kd_biodata=<?php echo e(u($kode_student))?>"  style="font-weight: bold" target="_parent">
                <input type="submit" name="Submitapprove" value="Approved" />
              </a></strong></td>
              <td>&nbsp;</td>
            </tr>
          </table>

              <!-- /.tab-pane --><!-- /.tab-content --><!-- /.nav-tabs-custom --><!-- /.col --><!-- /.row --><!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
<strong>Copyright &copy; 2017</strong></footer>

  <!-- Control Sidebar --><!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submitapprove']))) 
{
	
$no_enrolled = in_val('no_enrolled', 'any');		
$kd_school2 = in_val('kd_school', 'any');
$pic = in_val('pic', 'any');	
$kdb = in_val('kdb', 'any');
$flt_country1 = in_val('flt_country1', 'any');$flt_school1 = in_val('flt_school1', 'any');$flt_program1 = in_val('flt_program1', 'any');
$query = q_set($__p_query, "SELECT kd_school  FROM tb_master_partner  where country = ? and school = ? ", [(string) ($flt_country1), (string) ($flt_school1)]);
$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
if ($result) 
	{ 
	while ($r = db_fetch($result))
		{
		$kd_school = $r[0];	
		}
	}
$major = in_val('major', 'any');$hadnon = in_val('hadnon', 'any');$pnp = in_val('pnp', 'any');
$enroll_ddd = in_val('enroll_ddd', 'any');$enroll_mmm = in_val('enroll_mmm', 'any');$enroll_yyy = in_val('enroll_yyy', 'any');
$enroll_ddd2 = in_val('enroll_ddd2', 'any');$enroll_mmm2 = in_val('enroll_mmm2', 'any');$enroll_yyy2 = in_val('enroll_yyy2', 'any');
$intake_mmm = in_val('intake_mmm', 'any');$intake_yyy = in_val('intake_yyy', 'any');
$program_status = in_val('program_status', 'any');
$dochandler = in_val('dochandler', 'any');$visahandler = in_val('visahandler', 'any');
$prioritas = in_val('prioritas', 'any');
$org_cur = in_val('org_cur', 'any');$org_pf = in_val('org_pf', 'any');$pf = in_val('pf', 'any');
$discount_name = in_val('discount_name', 'any');
$mkt_source_event = in_val('mkt_source_event', 'any');$mkt_source_event_dtl = in_val('mkt_source_event_dtl', 'any');
$media_source = in_val('media_source', 'any');$media_source_dtl = in_val('media_source_dtl', 'any');

$pic = in_val('pic', 'any');	
$jamskrg= date('h:i:s', time());
$nama_depan= $_SESSION['nama_depan']; 
$tanggal_hri = date('Y-m-d');
$branch = $_SESSION['branch'] ;

$query_sars = q_set($__p_query_sars, "update  ves_data.tb_sales_report \r
set status = 'OK', dt_approved = ?  where kd_biodata=? and enroll_date= ? and kd_school=? ", [(string) ($tanggal_hri), (string) ($kdb), (string) ($enroll_yyy) . "-" . (string) ($enroll_mmm) . "-" . (string) ($enroll_ddd), (string) ($kd_school2)]);
$resource_update = db_query_or_die('errro_sars', $query_sars, $__p_query_sars ?? []);	
echo "<script type=\"text/javascript\">\n";
echo "alert('Update Success');\n";
echo "window.location = ('sales_center.php');\n";				
echo "</script>";
}
//	else
//		{
//		echo "<script type=\"text/javascript\">\n";
//		echo "alert('New VES Follow Up Progress Submitted');\n";
//		echo "window.location = ('profile.php?kdb=$kd_biodata');\n";				
//		echo "</script>";	
//		}
//										   }
//										   else
//	{
//	echo "<script type=\"text/javascript\">\n";
//	echo "alert('$pesan must be filled');\n";
//	echo "</script>";

//	}

//}
?>