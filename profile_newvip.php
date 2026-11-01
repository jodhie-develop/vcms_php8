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
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;
//=== list sc====
$query_sc = q_set($__p_query_sc, "SELECT  nama_login FROM ves_data.tb_user t where (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and kd_branch = ? and aktif = 'Y' order by nama_login", [(string) ($kd_cbg)]);
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
 <?php include __DIR__ . "/left.php";	 ?>
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
              <li><a href="profile_score.php?kdb=<?php echo e(u($kode_student)) ?>" class="tab2">Academic Score</a></li>                           
              <li><a href="profile_berkas.php?kdb=<?php echo e(u($kode_student)) ?>" class="tab3">Document</a></li>
 
           </ul>


              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="post"><?php echo csrf_field(); ?>

              <table width="923"  align="center">
    <tr>
      <td width="1" height="21">&nbsp;</td>
      <td width="910" valign="top"><strong class="huruf">VIP PROGRESS</strong></td>
    </tr>
    <tr>
      <td height="114">&nbsp;</td>
      <td valign="top"><table width="914">
            <tr>
              <td width="147"><strong>Action : </strong></td>
              <td width="175"><strong>Result : </strong><strong class="huruf"><span class="style2">
                <input type="text" name="kd_student" size="15" value="<?php echo e($kode_student) ?>" hidden = "hidden">
              </span></strong></td>
              <td width="224"><strong>Status : </strong></td>
              <td width="343"><input type="text" name="kd_biodata" id="kd_biodata" value="<?php echo e($kode_student) ?>" hidden="hidden"></td>
              <td width="1">&nbsp;</td>
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
              <td><select name="current_status" onChange="this.form.submit()">
                <option>N/A</option>			  
                <option>P</option>
                <option>IP</option>
                <option>E</option>
                <option>L</option>
                <option>Fp</option>
                <option>NP</option>
			  <option selected  = "selected"><?php if ($current_status != '') {echo e($current_status) ;} else {echo e($status) ;} ?></option>
              </select>			  </td>
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
              <td><strong>Remark : </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><label>
                <input type="text" name="remark" size="90" value="<?php echo e($remark) ?>">
              </label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><strong>Preference Program </strong></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Program </strong></td>
              <td><span class="style92" >
                <select name="vip_program" id="vip_program">
                  <option>NG TOEFL</option>
                  <option>TOEFL</option>
                  <option>IELTS</option>
                  <option>ACADEMIC ENGLISH</option>

                  <option selected="selected">
                  <?php  echo e($vip_program) ;?>
                  </option>
                </select>
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td>&nbsp;</td>
              <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Class Type </strong></td>
              <td colspan="4"><span class="style92" >
                <select name="class_type" id="class_type">
                  <option>Reguler</option>
                  <option>Private</option>
                  <option>Other</option>
                  <option selected="selected">
                  <?php  echo e($class_type) ;?>
                  </option>
                </select>
              </span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td>Add to Waiting List</td>
              <td><span class="style92">
                <select name="class_type2" id="class_type2">
                  <option>Reguler</option>
                  <option>Private</option>
                  <option>Other</option>
                  <option selected="selected">
                    <?php  echo e($class_type) ;?>
                  </option>
                </select>
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Day 1 </strong></td>
              <td><span class="style92" >
                <select name="day_1" id="day_1">
                  <option>Monday</option>
                  <option>Tuesday</option>
                  <option>Wednesday</option>
                  <option>Thursday</option>
                  <option>Friday</option>
                  <option>Saturday</option
                  ><option selected="selected">
                  <?php  echo e($day_1) ;?> </option>
                </select>
              </span></td>
              <td><strong>Day 3 <span class="style92" >
                <select name="day_3" id="day_3">
                  <option>Monday</option>
                  <option>Tuesday</option>
                  <option>Wednesday</option>
                  <option>Thursday</option>
                  <option>Friday</option>
                  <option>Saturday</option
                  >
                  <option selected="selected">
                    <?php  echo e($day_3) ;?>
                    </option>
                  </select>
              </span></strong></td>
              <td><strong>Day 5 <span class="style92" >
                <select name="day_5" id="day_5">
                  <option>Monday</option>
                  <option>Tuesday</option>
                  <option>Wednesday</option>
                  <option>Thursday</option>
                  <option>Friday</option>
                  <option>Saturday</option
                  >
                  <option selected="selected">
                    <?php  echo e($day_3) ;?>
                    </option>
                </select>
              </span></strong></td>
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
              <td><strong>Day 2 </strong></td>
              <td><span class="style92" >
                <select name="day_2" id="day_2">
                  <option>Monday</option>
                  <option>Tuesday</option>
                  <option>Wednesday</option>
                  <option>Thursday</option>
                  <option>Friday</option>
                  <option>Saturday</option
                  >
                  <option selected="selected">
                  <?php  echo e($day_2) ;?>
                  </option>
                </select>
              </span></td>
              <td><strong>Day 4<span class="style92" >
                <select name="day_4" id="day_4">
                  <option>Monday</option>
                  <option>Tuesday</option>
                  <option>Wednesday</option>
                  <option>Thursday</option>
                  <option>Friday</option>
                  <option>Saturday</option
                  >
                  <option selected="selected">
                    <?php  echo e($day_4) ;?>
                    </option>
                  </select>
              </span></strong></td>
              <td><strong>Day 6<span class="style92" >
                <select name="day_6" id="day_6">
                  <option>Monday</option>
                  <option>Tuesday</option>
                  <option>Wednesday</option>
                  <option>Thursday</option>
                  <option>Friday</option>
                  <option>Saturday</option
                  >
                  <option selected="selected">
                    <?php  echo e($day_4) ;?>
                    </option>
                </select>
              </span></strong></td>
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
              <td><strong>Billing Code </strong></td>
              <td><input type="billing_code" name="billing_code" size="25" value="<?php echo e($billing_code) ?>"></td>
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
              <td width="147"><strong>Next Action : </strong></td>
              <td width="175"><strong>Remark : </strong></td>
              <td width="224">&nbsp;</td>
              <td width="343">&nbsp;</td>
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
              <td colspan="4"><input type="nextremark" name="nextremark" size="80" value="<?php echo e($nextremark) ?>"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="147"><strong>Due Date  : </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input type="date" name="due_date" value = "<?php echo e($due_date) ?>"/></td>
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
                <input type="submit" name="Submit" value="Submit" />
              </a></strong></td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="bootom">&nbsp;</td>
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
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
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
$vip_program = in_val('vip_program', 'any');
$current_status = in_val('current_status', 'any');
$nextremark = in_val('nextremark', 'any');

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
$nextaction = in_val('nextaction', 'any');
$due_date = in_val('due_date', 'any');
$nextremark = in_val('nextremark', 'any');				
if ($current_status != "E")
	{
	if ($current_status != "L")
		{

		if ($nextaction=='')
			{
			if (num($statussimpan)==0){$pesan="Next Action ";}
			$statussimpan=1;
			}
		if ($nextremark=='')
			{
			if (num($statussimpan)==0){$pesan="Next Remark ";}
			$statussimpan=1;
			}
		if ($due_date=='')
			{
			if (num($statussimpan)==0){$pesan="Date Due Date a ";}
			$statussimpan=1;
			}
		}
	}
$day_1 = in_val('day_1', 'any');
$day_2 = in_val('day_2', 'any');
$day_3 = in_val('day_3', 'any');
$day_4 = in_val('day_4', 'any');
$day_5 = in_val('day_5', 'any');
$day_6 = in_val('day_6', 'any');
$vip_program = in_val('vip_program', 'any');
$class_type = in_val('class_type', 'any');
$vip_schedule = "$day_1  $day_2  $day_3  $day_4";			
$kode_student = in_val('kd_biodata', 'any');
$jamskrg= date('h:i:s', time());
$nama_depan= $_SESSION['nama_depan']; 
$tanggal_hri = date('Y-m-d');

if (num($statussimpan)==0)
	{
	$query_simpan = q_set($__p_query_simpan, "insert into ves_inc.tb_progres_ves \r
\t(kd_biodata, date_update, progress, vip_status, vip_program, next_action, next_fu, due_date, time_update, pic, branch, day_1,day_2,day_3,day_4, grouping) \r
\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,\r
\t? , ? ,? ,? ,? ,'2')", [(string) ($kode_student), (string) ($tanggal_hri), (string) ($remark), (string) ($current_status), (string) ($vip_program), (string) ($nextremark), (string) ($nextaction), (string) ($due_date), (string) ($jamskrg), (string) ($nama_depan), (string) ($branch), (string) ($day_1), (string) ($day_2), (string) ($day_3), (string) ($day_4)]);
	$resource_simpan = db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
	$query_update = q_set($__p_query_update, "update ves_inc.tb_biodata set vip_status = ? ,  next_fu = ? , date_fu = ? ,last_result = ? , vip_last_update = ? , vip_remark = ? , vip_schedule=? ,vip_program = ?  where kd_biodata = ? ", [(string) ($current_status), (string) ($nextaction), (string) ($due_date), (string) ($result), (string) ($tanggal_hri), (string) ($remark), (string) ($vip_schedule), (string) ($vip_program), (string) ($kode_student)]);
	$resource_update = db_query_or_die('errro_update_biodata', $query_update, $__p_query_update ?? []);
	if ($current_status == "E")
		{
		$sql_simpan_status = q_set($__p_sql_simpan_status, "insert into ves_inc.vip_student_status (kd_branch, program, kd_biodata, hari_1,hari_2, hari_3, hari_4, hari_5, hari_6, status_class ) values (? ,? ,? ,\t? ,? ,? ,? ,? ,? ,1\t)", [(string) ($kd_cbg), (string) ($vip_program), (string) ($kode_student), (string) ($day_1), (string) ($day_2), (string) ($day_3), (string) ($day_4), (string) ($day_5), (string) ($day_6)]);
		$resource_simpan = db_query_or_die('errro_simpan', $sql_simpan_status, $__p_sql_simpan_status ?? []);	
			echo "<script type=\"text/javascript\">\n";
	echo "alert('New VIP Enrolled Submitted');\n";
	echo "window.location = ('prestuvip.php?browser=" . e(u($kode_student)) . "');\n";				
	echo "</script>"	;		
		}
	else
	{	echo "<script type=\"text/javascript\">\n";
	echo "alert('New VES Follow Up Progress Submitted');\n";
	echo "window.location = ('profile.php?kdb=" . e(u($kode_student)) . "');\n";				
	echo "</script>";}
	
	}
else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($pesan) . " must be filledess');\n";
	echo "</script>";
	}

}
?>