<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php"; 
include __DIR__ . "/atas.php";
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
$kode_student = in_val('kdb', 'any');
if ($kode_student ==''){$kode_student = in_val('kd_biodata', 'any');}
//======tampilkan detail
$query_detail = q_set($__p_query_detail, "SELECT t.nama, t.middle_name, t.family_name, DATE_FORMAT(t.dob,'%d %b %y'), t.gender, t.address, t.city, t.hm_ph, t.hp, t.org_school, t.grade, t.parent_nm, t.add_parent, t.city_parent, t.hp_parent, t.level_school, t.event_st_dtl, media_src, media_src_dtl, t.ves_last_update, t.vip_last_update, t.vip_remark, t.e_mail, t.hp_2, \r
t.mother_name, t.ph_mother, t.country_1, t.school_1, t.program_1, t.country_2, t.school_2, t.program_2, t.country_3, t.school_3, t.program_3, event_type,event_type_dtl, media_src, media_src_dtl,ves_status \r
FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($kode_student)]);

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
		$country_2 = $row_detail[29];
		$school_2 = $row_detail[30];
		$program_2 = $row_detail[31];
		$country_3 = $row_detail[32];
		$school_3 = $row_detail[33];
		$program_3  = $row_detail[34];	
		$event_type  = $row_detail[35];
		$event_type_dtl  = $row_detail[36];
		$media_src  = $row_detail[37];
		$media_src_dtl	= $row_detail[38];
		$ves_status= $row_detail[39];
		}
	}
//========
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
	$query_get_kode = q_set($__p_query_get_kode, "select kd_school from tb_master_partner where country = ? \r
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
	

	$Major = in_val('Major', 'any');
	if ($Major=='')
		{
		if (num($statussimpan)==0){$pesan="Major ";}
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

//=== list sc====
$query_sc = q_set($__p_query_sc, "SELECT  nama_login FROM ves_data.tb_user t where (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and branch = ? and aktif = 'Y' order by nama_login", [(string) ($branch)]);
$resource_sc = db_query_or_die('errro_', $query_sc, $__p_query_sc ?? []);
$keluar_sc= db_num_rows($resource_sc);
if(num(db_num_rows($resource_sc)) > 0)
	{
	while ($row_sc=  db_fetch($resource_sc, PDO::FETCH_NUM))
		{
		$nm_sc= $row_sc[0];				
		$list_sc.="<OPTION VALUE=\"" . e($nm_sc) . "\">".e($nm_sc);
		}
	}
//=============
$enroll_dd = date('d');
$enroll_mm = date('m');
$enroll_yy= date('Y');
?>
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
<?php //========================== left nav ?>
 <?php //include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
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
                 <li><a href="profile.php?kdb=<?php echo e(u($kode_student)) ?>"  class="tab1">History</a></li>
              <li><a href="profile_new.php?kdb=<?php echo e(u($kode_student)) ?>" class="tab2">VES Progress</a></li>
              <li><a href="profile_newvip.php?kdb=<?php echo e(u($kode_student)) ?>" class="tab2">VIP Progress</a></li>                           
              <li><a href="profile_berkas.php?kdb=<?php echo e(u($kode_student)) ?>" class="tab3">Document</a></li>
           </ul>


              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="post"><?php echo csrf_field(); ?>

              <table width="20%">
            <tr>
              <td width="190"><strong>Action : </strong></td>
              <td width="173"><strong>Result : </strong></td>
              <td width="190"><strong>Status : </strong></td>
              <td width="427">&nbsp;</td>
              <td width="59">&nbsp;</td>
            </tr>
            <tr>
              <td><label>
              <select name="current_action" >
			<option>Call</option>
				<option>Chat</option>
				<option>Appointment</option>
                <option selected  = "selected">
                <?php if ($current_action != '') {echo e($current_action) ;} else {echo e($action) ;} ?>
                </option>
              </select>
              </label></td>
              <td><select name="result" >
                <option>NIT - Not Interested</option>
                <option>NET - Not Enough Time</option>
                <option>Dis - Distances</option>
                <option>CNR - Could Not Reach</option>
                <option>INT- Interested</option>
				<option selected  = "selected">
                  <?php if ($result != '') {echo e($result) ;} else {echo e($result) ;} ?>
                  </option>
              </select></td>
              <td><select name="current_status" onchange="this.form.submit()">
                <option>N/A</option>			  
                <option>P</option>
                <option>IP</option>
                <option>E</option>
                <option>L</option>
                <option>Fp</option>
                <option>NP</option>
			  <option selected  = "selected"><?php if ($current_status != '') {echo e($current_status) ;} else {echo e($status) ;} ?></option>
              </select>			  </td>
              <td><input type="text" name="kd_biodata" id="kd_biodata" value="<?php echo e($kode_student) ?>" hidden="hidden"></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Remark : </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><label>
                <input type="text" name="remark" size="100" value="<?php echo e($remark) ?>">
              </label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><strong>Preference Destination </strong></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><strong>Country<br>
              </strong>
                <select name="flt_country1" id="flt_country1"onChange="this.form.submit()" >
                  <option value= "">
                  <?php echo $list_country1?>
                  </option>
                  <option selected="selected">
                  <?php  		   if ($flt_country1 !="") { echo e($flt_country1); }else { if ($country_dest1 !='') {echo e($country_dest1);}else{echo e($country_1);} }

   ?>	
                  </option>
                </select>
                <label for="textfield"></label>
                <input type="text" name="kd_school_1" id="kd_school_1" value="<?php echo e($kd_school_1) ?>" hidden="hidden">
              </span></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5"><strong>School<br>
              </strong><span class="style92">
                <select name="flt_school1" id="flt_school1" onchange="this.form.submit()" >
                  <option value= >
                  <?php echo $list_school1?>
                  <option selected="selected">
                  <?php  if ($flt_school1 !="") {echo e($flt_school1);}else{if($school_dest1 != ''){echo e($school_dest1);}else{echo e($school_1);}}?>
                  </option>
                </select>
              </span></td>
              </tr>
            <tr>
              <td colspan="4"><strong>Program<br>
              </strong><span class="style92">
                <select name="flt_program1" id="flt_program1">
                  <option value= >
                  <?php echo $list_program?>
                  <option selected="selected">
                  <?php  if ($flt_program1 !="") { echo e($flt_program1); }else { if ($flt_program1 !=''){echo e($program_dest1); }{echo e($program_1);}}
 				  
   ?>
                  </option>
                </select>
              </span></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5">
			  <?php if (($current_status == 'E') ||($status == 'E')) 
			  {
			  if ($status == 'E')
			 	{
				$query_enroll = q_set($__p_query_enroll, "select major_dest, status_host,status_part, date_format(enroll_date,'%d') ,date_format(enroll_date,'%m') ,date_format(enroll_date,'%Y') , date_format(intake_date,'%m') , date_format(intake_date,'%Y') ,status, org_prof_cur,org_prof_fee,prof_fee,  discount_name from ves_inc.tb_enrolled where kd_biodata = ? and sch_dest = ? limit 1", [(string) ($kd_biodata), (string) ($school_dest)]);

				$resource_enroll = db_query_soft($query_enroll, $__p_query_enroll ?? []);
				$keluar_enroll = db_num_rows($resource_enroll);
				if(num(db_num_rows($resource_enroll)) > 0)
					{
					while ($row_enroll  =  db_fetch($resource_enroll, PDO::FETCH_NUM))
						{
						$Major = $row_enroll[0];
						$hadnon = $row_enroll[1];
						$pnp = $row_enroll[2];
						$enroll_dd = $row_enroll[3];
						$enroll_mm = $row_enroll[4];
						$enroll_yy = $row_enroll[5];
						$intake_mmm = $row_enroll[6];
						$intake_yyy = $row_enroll[7];
						$program_status = $row_enroll[8];
						$org_cur = $row_enroll[9];
						$org_pf = $row_enroll[10];
						$pf = $row_enroll[11];
						$discount = $row_enroll[12];
						$pf = $row_enroll[13];
						}
					}
				}

			  ?>
			  <table width="1050" border="0">
                <tr>
                  <td colspan="5"><strong>Major</strong><br><input type="Major" name="Major" size="50" value="<?php echo e($Major) ?>"></td>
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
                      <?php   echo e($hadnon);    ?>
                      </option>
                    </select>
                  </span></td>
                  <td colspan="3"><strong>Partnership</strong><span class="style92"><br>
                    <select name="pnp" id="pnp">
                      <option>P</option>
                      <option>NP</option>
                      <option selected="selected">
                      <?php  echo e($pnp) ;   ?>
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
                      <option selected="selected"> <?php echo e($enroll_dd);  ?> </option>
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
                      <option selected="selected"> <?php echo e($enroll_mm);  ?> </option>
                    </select>
                    <select name="enroll_yyy" id="select3">
                      <option>2016</option>
                      <option>2017</option>
                      <option>2018</option>
                      <option>2019</option>
                      <option selected="selected"> <?php echo e($enroll_yy)  ?> </option>
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
                        <option selected="selected"> <?php if ($intake_mmm != ''){echo e($intake_mmm);} else {echo e($intake_mm);  }?> </option>
                      </select>
                      <select name="intake_yyy" id="intake_yyy">
                        <option>2016</option>
                        <option>2017</option>
                        <option>2018</option>
                        <option selected="selected"><?php if ($intake_yyy != ''){echo e($intake_yyy);} else {echo e($intake_yy);  }?>  </option>
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
                      <option selected="selected"> <?php echo e($program_status);  ?> </option>
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
                      <option selected="selected">
                      <?php  echo e($nm_sc);?>
                                        </select>
                  </span></td>
                  <td colspan="2"><strong>Visa Handler Handler </strong></td>
                  <td><span class="style90">
                    <select name="visahandler" >
                      <option value= "">
                      <?php echo $list_sc?>
                      </option>
                      <option selected="selected">
                      <?php  echo e($nm_sc);    ?>
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
                      <?php   echo e($org_cur);    ?>
                      </option>
                    </select>
                    <input type="org_pf" name="org_pf" size="15" value="<?php echo e($org_pf) ?>">
                  </span></td>
                  <td width="81" align="right"><strong>Rp.</strong></td>
                  <td colspan="2"><span class="style92">
                    <input type="pf" name="pf" size="15" value="<?php echo e($pf) ?>">
                  </span></td>
                  </tr>
                
                <tr>
                  <td><strong>Discount</strong></td>
                  <td><span class="style92">
                    <span class="style92" >
                    <select name="discount" id="discount" >
                    <option>No Discount</option>
                    <option>Link & Match</option>                    
                    <option selected="selected">
                      <?php  echo e($discount);  ?>
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
              </table>
			  <?php } ?> </td>
              </tr>
            <tr>
              <td width="190"><strong>Next Action : </strong></td>
              <td width="173"><strong>Remark : </strong></td>
              <td width="190">&nbsp;</td>
              <td width="427">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="nextaction">
                  <option>Call</option>
                  <option>Chat</option>
                  <option>Appointment</option>
                  <option selected="selected"><?php echo e($nextaction) ?></option>
                </select>
              </label></td>
              <td colspan="4"><input type="nextremark" name="nextremark" size="120" value="<?php echo e($nextremark) ?>"></td>
            </tr>
            <tr>
              <td width="190"><strong>Due Date  : </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span class="style2">
                <select name="due_date_dd" id="due_date_dd">
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
                  <option selected="selected">
                  <?php echo e($due_date_dd);  ?>                  </option>
                </select>
                <select name="due_date_mm" id="due_date_mm">
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
                 <?php echo e($due_date_mm);  ?>                  </option>
                </select>
                <select name="due_date_yy" id="due_date_yy">
                   <option>2016</option>
                  <option>2017</option>
                  <option>2018</option>
                  <option>2019</option>
                  <option selected="selected">
                  <?php echo e($due_date_yy)  ?>                  </option>
                </select>
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><strong class="huruf"><a href="studentprogres.php?kd_biodata=<?php echo e(u($kode_student))?>"  style="font-weight: bold" target="_parent">
                <input type="submit" name="Submitprogress" value="Submit" />
              </a></strong></td>
              <td>&nbsp;</td>
            </tr>
          </table>

              </div>
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
                    </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
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
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submitprogress']))) 
{
{
$current_action = in_val('current_action', 'any');
if ($current_action=='')
	{
	if (num($statussimpan)==0){$pesan="Action ";}
	$statussimpan=1;
	}
$result = in_val('result', 'any');
if ($result=='')
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
if ($flt_country1 !='' and $flt_school1 != '')
	{
	$query_kd_school_1 = q_set($__p_query_kd_school_1, "SELECT  kd_school FROM ves_data.tb_master_partner t where school = ? and country = ? ", [(string) ($flt_school1), (string) ($flt_country1)]);
	$resource_kd_school_1 = db_query_or_die('errro_kd_school1', $query_kd_school_1, $__p_query_kd_school_1 ?? []);
	if(num(db_num_rows($resource_kd_school_1)) > 0)
		{
		while ($row_kd_school_1=  db_fetch($resource_kd_school_1, PDO::FETCH_NUM))
			{
			$kd_school_1= $row_kd_school_1[0];			
			}
		}
	}
$flt_program1 = in_val('flt_program1', 'any');

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
	

	$Major = in_val('Major', 'any');
	if ($Major=='')
		{
		if (num($statussimpan)==0){$pesan="Major ";}
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

	$discount = in_val('discount', 'any');
	if ($discount=='')
		{
		if (num($statussimpan)==0){$pesan="Discount ";}
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
	$event_type  = $row_detail[38];
	$event_type_dtl  = $row_detail[39];
	$media_src  = $row_detail[40];
	$media_src_dtl	= $row_detail[41];	
	$org_cur = in_val('org_cur', 'any');
	$org_pf = in_val('org_pf', 'any');
	$pf = in_val('pf', 'any');
		
	}
$kd_biodata = in_val('kd_biodata', 'any');
$jamskrg= date('h:i:s', time());
$nama_depan= $_SESSION['nama_depan']; 
$tanggal_hri = date('Y-m-d');
$branch = in_val('branch', 'any');

if (num($statussimpan)==0)
	{
	$query_simpan = q_set($__p_query_simpan, "insert into ves_inc.tb_progres_ves \r
\t(kd_biodata, action, result, status, progress, \r
\tcountry, school_dest, program, \r
\tcountry2, school2, program2, \r
\tcountry3, school3, program3,\r
\tnext_action, next_fu, due_date, time_update, pic, date_update,branch, grouping, kd_school_1,kd_school_2, kd_school_3) \r
\tvalues \r
\t(? ,? ,? ,? ,? ,\r
\t? ,? ,? ,\r
\t? ,? ,? ,\r
\t? ,? ,? , \t\r
\t? ,? ,? ,? ,? ,? ,? ,'1','kd_school_1','kd_school_2','kd_school_3'  )", [(string) ($kd_biodata), (string) ($current_action), (string) ($result), (string) ($current_status), (string) ($remark), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($flt_country2), (string) ($flt_school2), (string) ($flt_program2), (string) ($flt_country3), (string) ($flt_school3), (string) ($flt_program3), (string) ($nextremark), (string) ($nextaction), (string) ($due_date_lengkap), (string) ($jamskrg), (string) ($nama_depan), (string) ($hari_ini), (string) ($branch)]);
	$resource_simpan = db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
	$query_update = q_set($__p_query_update, "update ves_inc.tb_biodata set ves_status = ? ,  next_fu = ? , date_fu = ? ,\r
\tcountry_dest = ? , \r
\tschool_dest = ? , \r
\tprogram_dest = ? , \r
\tcountry_1 = ? , \r
\tschool_1 = ? ,  \r
\tprogram_1 = ? ,\r
\tlast_result = ? , ves_last_update = ? , remark = ? , kd_school_1 = ?  \r
\twhere kd_biodata = ? ", [(string) ($current_status), (string) ($nextaction), (string) ($due_date_lengkap), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($result), (string) ($hari_ini), (string) ($remark), (string) ($kd_school_1), (string) ($kd_biodata)]);
	$query_update ;	
	$resource_update = db_query_or_die('errro_update_biodata', $query_update, $__p_query_update ?? []);
	if($current_status =="E")
		{
		$query_tb_enrolled = q_set($__p_query_tb_enrolled, "insert into ves_inc.tb_enrolled \r
\t\t(kd_biodata, kd_school, country_dest, sch_dest, prg_dest,  \r
\t\tmajor_dest, intake_date, enroll_date, status_host, status_part, \r
\t\tpic, status, branch, org_prof_cur,  org_prof_fee, \r
\t\tcur, prof_fee,  discount_name, \tstatus_program )\r
\t\tvalues \r
\t\t(? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t'Rp',? ,? ,? )", [(string) ($kd_biodata), (string) ($kd_school_1), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($Major), (string) ($intake_date), (string) ($enroll_date), (string) ($hadnon), (string) ($pnp), (string) ($nama_depan), (string) ($current_status), (string) ($branch), (string) ($org_cur), (string) ($org_pf), (string) ($pf), (string) ($discount), (string) ($program_status)]);
		$resource_enrolled = db_query_or_die('error_tb_enrolled', $query_tb_enrolled, $__p_query_tb_enrolled ?? []);
//=================		
		$query_sars = q_set($__p_query_sars, "insert into ves_data.tb_sales_report \r
\t\t(kd_biodata, nama, kd_school, program, major, \r
\t\th_nh, p_np, prioritas, pic, cabang, \r
\t\tori_school, ori_grade, mkt_source, mkt_source_dtl, status, \r
\t\tdt_entry, time_entry, enroll_date, tgl_intake, \r
\t\tnm_event, adm_pic, adm_pic_2, kd_cabang)\r
\t\tvalues\r
\t\t(\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,? ,'Pending',\r
\t\t? ,? ,? ,? ,\r
\t\t? ,? ,? ,?\r
\t\t)", [(string) ($kd_biodata), (string) ($nama) . " " . (string) ($middle_name) . " " . (string) ($family_name) . " ", (string) ($kd_school_1), (string) ($flt_program1), (string) ($Major), (string) ($hadnon), (string) ($pnp), (string) ($prioritas), (string) ($nama_depan), (string) ($branch), (string) ($org_school), (string) ($grade), (string) ($media_src), (string) ($media_src_dtl), (string) ($tanggal_hri), (string) ($jamskrg), (string) ($enroll_date), (string) ($intake_date), (string) ($event_type_dtl), (string) ($dochandler), (string) ($visahandler), (string) ($kdcbg)]);	
		$resource_update = db_query_or_die('errro_sars', $query_sars, $__p_query_sars ?? []);	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Please Print Enrollment Form');\n";
		echo "window.location = ('enrollmentformprev.php?kode_student=" . e(u($kd_biodata)) . "');\n";				
		echo "</script>";
		}
	else
		{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('New VES Follow Up Progress Submitted');\n";
		echo "window.location = ('profile.php?kdb=" . e(u($kd_biodata)) . "');\n";				
		echo "</script>";	
		}
	}
else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($pesan) . " must be filled');\n";
	echo "</script>";

	}

}
}
?>