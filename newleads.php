<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'any');
$date_end = in_val('date_end', 'any');
if ($date_start ==''){$date_start = "2020-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;
$other_school = in_val('other_school', 'any');

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
$vip_leads = in_val('vip_leads', 'any');
$ves_leads = in_val('ves_leads', 'any');
$vpro_leads = in_val('vpro_leads', 'any');
$flt_country1 = in_val('flt_country1', 'any');

$first_name = in_val('first_name', 'any');
if ($first_name=='')
	{
	if (num($statussimpan)==0){$pesan="First Name ";}
	$statussimpan=1;
	}
$middle_name = in_val('middle_name', 'any');
if ($middle_name=='')
	{
	if (num($statussimpan)==0){$pesan="middle_name ";}
	$statussimpan=1;
	}

$family_name = in_val('family_name', 'any');
if ($family_name=='')
	{
	if (num($statussimpan)==0){$pesan="family_name ";}
	$statussimpan=1;
	}
$school_city = in_val('school_city', 'any');
$event_st = in_val('event_st', 'any');
$fb = in_val('fb', 'any');
$twitter = in_val('twitter', 'any');
$instagram = in_val('instagram', 'any');
$path = in_val('path', 'any');
$line = in_val('line', 'any');
$wa = in_val('wa', 'any');
$dob = in_val('dob', 'any');
$address = in_val('address', 'any');
if ($address=='')
	{
	if (num($statussimpan)==0){$pesan="address ";}
	$statussimpan=1;
	}
$student_city = in_val('student_city', 'any');
if ($student_city=='')
	{
	if (num($statussimpan)==0){$pesan="city ";}
	$statussimpan=1;
	}
$area = in_val('area', 'any');
$phone = in_val('phone', 'any');

$hp1 = in_val('hp1', 'any');
if ($hp1=='')
	{
	if (num($statussimpan)==0){$pesan="hp  ";}
	$statussimpan=1;
	}
$hp2 = in_val('hp2', 'any');
$e_mail = in_val('e_mail', 'any');
if ($e_mail=='')
	{
	if (num($statussimpan)==0){$pesan="e_mail  ";}
	$statussimpan=1;
	}

$fb = in_val('fb', 'any');
$twitter = in_val('twitter', 'any');
$instagram = in_val('instagram', 'any');
$path = in_val('path', 'any');
$line = in_val('line', 'any');
$wa = in_val('wa', 'any');
$ves_remark = in_val('ves_remark', 'any');
$vip_remark = in_val('vip_remark', 'any');
$vip_program = in_val('vip_program', 'any');
$school_city = in_val('school_city', 'any');
$school_level = in_val('school_level', 'any');
$school_name = in_val('school_name', 'any');
$school_grade = in_val('school_grade', 'any');
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

$parent_name = in_val('parent_name', 'any');
$parent_address = in_val('parent_address', 'any');
$parent_city = in_val('parent_city', 'any');
$parent_hp = in_val('parent_hp', 'any');
$parent_email = in_val('parent_email', 'any');
$mkt_source_type = in_val('mkt_source_type', 'any');
$mkt_source_event = in_val('mkt_source_event', 'any');
$mkt_source_event_dtl = in_val('mkt_source_event_dtl', 'any');
$media_source = in_val('media_source', 'any');
$media_source_dtl = in_val('media_source_dtl', 'any');
$gender = in_val('gender', 'any');
$other_school = in_val('other_school', 'any');
$other_school_dest = in_val('other_school_dest', 'any');
//========country 1
$query_country = "SELECT  distinct country FROM ves_data.tb_master_partner t where school not like '%DELETE%' order by
case when country like 'USA%' then 0
when country like 'CAN%' then 1
when country like 'SW%' then 2
when country like 'UK%' then 3
when country like 'SPA%' then 4
when country like 'IT%' then 5
when country like 'AUS%' then 6
when country like 'NEW%' then 7
when country like 'SIN%' then 8
when country like 'MAL%' then 9
when country like 'CHI%' then 10
when country like 'IN%' then 11
ELSE 12 end, country asc, school";
//$resource_country = mysql_query($query_country) or die('errro_1');
//$keluar_country= db_num_rows($resource_country);
//if(db_num_rows($resource_country) > 0)
//	{
//	while ($row_country=  db_fetch($resource_country, PDO::FETCH_NUM))
//		{
//		$nm_country1= $row_country[0];				
//		$list_country1.="<OPTION VALUE=\"$nm_country1\">".$nm_country1;
//		}
//	}
	
//=============
//load school country 1
if ($flt_country1 !="")
{
$query_school = "SELECT  t.school FROM ves_data.tb_master_partner t where school not like '%DELETE%' and (country = '$flt_country1' or country = 'OTHER') order by
case when country like 'USA%' then 0
when country like 'CAN%' then 1
when country like 'SW%' then 2
when country like 'UK%' then 3
when country like 'SPA%' then 4
when country like 'IT%' then 5
when country like 'AUS%' then 6
when country like 'NEW%' then 7
when country like 'SIN%' then 8
when country like 'MAL%' then 9
when country like 'CHI%' then 10
when country like 'IN%' then 11
ELSE 12 end, country asc, school";
}
else
{$query_school = "SELECT  t.school FROM ves_data.tb_master_partner t where school not like '%DELETE%'  order by
case when country like 'USA%' then 0
when country like 'CAN%' then 1
when country like 'SW%' then 2
when country like 'UK%' then 3
when country like 'SPA%' then 4
when country like 'IT%' then 5
when country like 'AUS%' then 6
when country like 'NEW%' then 7
when country like 'SIN%' then 8
when country like 'MAL%' then 9
when country like 'CHI%' then 10
when country like 'IN%' then 11
ELSE 12 end, country asc, school";}
//$resource_school = mysql_query($query_school) or die('errro_2');
//$keluar_school= db_num_rows($resource_school);
//if(db_num_rows($resource_school) > 0)
//	{
//	while ($row_school=  db_fetch($resource_school, PDO::FETCH_NUM))
//		{					
//		$nm_school1= $row_school[0];				
//		$list_school1.="<OPTION VALUE=\"$nm_school1\">".$nm_school1;
//		}
//	}
//========
//========country 2
$query_country = "SELECT  distinct country FROM ves_data.tb_master_partner t where school not like '%DELETE%' order by
case when country like 'USA%' then 0
when country like 'CAN%' then 1
when country like 'SW%' then 2
when country like 'UK%' then 3
when country like 'SPA%' then 4
when country like 'IT%' then 5
when country like 'AUS%' then 6
when country like 'NEW%' then 7
when country like 'SIN%' then 8
when country like 'MAL%' then 9
when country like 'CHI%' then 10
when country like 'IN%' then 11
ELSE 12 end, country asc, school";
//$resource_country = mysql_query($query_country) or die('errro_3');
//$keluar_country= db_num_rows($resource_country);
//if(db_num_rows($resource_country) > 0)
//	{
//	while ($row_country=  db_fetch($resource_country, PDO::FETCH_NUM))
//		{
//		$nm_country2= $row_country[0];				
//		$list_country2.="<OPTION VALUE=\"$nm_country2\">".$nm_country2;
//		}
//	}
	
//=============


$query_program = q_set($__p_query_program, "SELECT  nm_program_dest FROM ves_inc.tb_program_dest order by nm_program_dest ");
$resource_program = db_query_or_die('errro_7', $query_program, $__p_query_program ?? []);
$keluar_program= db_num_rows($resource_program);
if(num(db_num_rows($resource_program)) > 0)
	{
	while ($row_program=  db_fetch($resource_program, PDO::FETCH_NUM))
		{					
		$nm_program= $row_program[0];				
		$list_program.="<OPTION VALUE=\"" . e($nm_program) . "\">".e($nm_program);
		}
	}
	
	
//==============list city
$query_city = q_set($__p_query_city, "SELECT  nm_city FROM ves_inc.tb_city where country = 'lokal' order by nm_city ");
$resource_city= db_query_or_die('errro_8', $query_city, $__p_query_city ?? []);
$keluar_city= db_num_rows($resource_city);
if(num(db_num_rows($resource_city)) > 0)
	{
	while ($row_city=  db_fetch($resource_city, PDO::FETCH_NUM))
		{					
		$nm_city= $row_city[0];				
		$list_city.="<OPTION VALUE=\"" . e($nm_city) . "\">".e($nm_city);
		}
	}

//=========================	
//==============list ori school
$query_ori_school = q_set($__p_query_ori_school, "SELECT  nm_sch FROM ves_inc.tb_school where (city_sch = ? or city_sch = 'Other') order by nm_sch desc ", [(string) ($school_city)]);
$resource_ori_school= db_query_or_die('errro_9', $query_ori_school, $__p_query_ori_school ?? []);
$keluar_ori_school= db_num_rows($resource_ori_school);
if(num(db_num_rows($resource_ori_school)) > 0)
	{
	while ($row_ori_school=  db_fetch($resource_ori_school, PDO::FETCH_NUM))
		{					
		$nm_ori_school= $row_ori_school[0];				
		$list_ori_school.="<OPTION VALUE=\"" . e($nm_ori_school) . "\">".e($nm_ori_school);
		}
	}
//=========================	
//==============list source

	$query_source_type = q_set($__p_query_source_type, "SELECT source FROM ves_inc.tb_mkt_source  order by source ");


$resource_source_type= db_query_or_die('errro_10', $query_source_type, $__p_query_source_type ?? []);
$keluar_source_type= db_num_rows($resource_source_type);
if(num(db_num_rows($resource_source_type)) > 0)
	{
	while ($row_source_type=  db_fetch($resource_source_type, PDO::FETCH_NUM))
		{					
		$nm_source_type= $row_source_type[0];				
		$list_source_type.="<OPTION VALUE=\"" . e($nm_source_type) . "\">".e($nm_source_type);
		}
	}
	
//==============list mediasource
$query_media_source = q_set($__p_query_media_source, "SELECT source FROM ves_inc.tb_mkt_source where event <> 'E'");
$resource_media_source= db_query_or_die('errro_11', $query_media_source, $__p_query_media_source ?? []);
$keluar_media_source= db_num_rows($resource_media_source);
if(num(db_num_rows($resource_media_source)) > 0)
	{
	while ($row_media_source=  db_fetch($resource_media_source, PDO::FETCH_NUM))
		{					
		$nm_media_source= $row_media_source[0];				
		$list_media_source.="<OPTION VALUE=\"" . e($nm_media_source) . "\">".e($nm_media_source);
		}
	}

?>
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
 <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}
</script>
<body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>V-CMS</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
    <style type="text/css">
    .style2 {font-family: "Serif", Times, serif; font-size: 24px; }
    .style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
    </style>
    </link>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
 <div class="row">
 	  <div class="col-md-8">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>" readonly>
    </div>
  </div>
 </div>
<div class="row">
<div class="col-md-3">
    <div class="form-group has-error" >
      <label>First Name</label>
      <input type="text" name="first_name"   class="form-control" value = "<?php echo e($first_name)  ?>"/>
    </div>
  </div>
<div class="col-md-3">
  <div class="form-group">
    <label>Middle Name</label>
    <input type="text" name="middle_name"  class="form-control" value = "<?php echo e($middle_name)  ?>"/>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>Family Name</label>
    <input type="text" name="family_name"  class="form-control" value = "<?php echo e($family_name)  ?>"/>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group has-error">
    <label>Gender</label>
    <select name="gender" class="form-control" >
                  <option>M</option>
                  <option>F</option>
              <option selected="selected"> <?php echo e($gender);  ?> </option>
    </select>
  </div>
</div>  	
</div>
<div class="row">
<div class="col-md-2"  bg-light>
    <div class="form-group">
      <label>DOB</label>
      <input type="date" name="dob"  class="form-control" value = "<?php echo e($dob)  ?>"/>
    </div>
  </div>
<div class="row"></div>
</div>
<div class="row">
<div class="col-md-6">
    <div class="form-group has-error">
      <label>Address</label>
      <input type="text" name="address"  class="form-control" value = "<?php echo e($address)  ?>"/>
    </div>
  </div>

</div> 
<div class="row">
<div class="col-md-3">
    <div class="form-group has-error">
      <label>City</label>
            <select name="student_city" id="student_city" class="form-control" >
                <option value= >
                  <?php echo $list_city?>
              <option selected="selected"> <?php 		   
				  if ($student_city !="") { echo e($student_city); }else { echo e($nm_city); }
  ?> </option>
            </select>
    </div>
  </div>
<div class="col-md-2	">
  <div class="form-group">
    <label>Area</label>
    <select name="area" id="area" class="form-control" >
      <option>East</option>
      <option>West</option>
      <option>South</option>
      <option>North</option>
      <option>Central</option>
      <option selected="selected"> <?php echo e($area);  ?></option>
    </select>
    </div>
</div>
 </div>
 
  
   
     
<div class="row">
<div class="col-md-3">
    <div class="form-group has-error">
      <label>Mobile Phone</label>
      <input name="hp1" type="text" id="hp1" value="<?php echo e($hp1) ?>" class="form-control" >
    </div>
  </div>
<div class="col-md-3">
  <div class="form-group">
    <label>Whatsapp</label>
    <input name="wa" type="text" id="wa" value="<?php echo e($wa) ?>" class="form-control" >
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>Home Phone</label>
    <input name="phone" type="text" id="phone" value="<?php echo e($phone) ?>" class="form-control" >
  </div>
</div>
</div>
<div class="row">
<div class="col-md-3">
    <div class="form-group has-error">
      <label>E-Mail</label>
      <input name="e_mail" type="text" id="e_mail" value="<?php echo e($e_mail) ?>" class="form-control" >
    </div>
  </div>
</div> 
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
    <label>Line</label>
    <input name="line" type="text" id="line" value="<?php echo e($line) ?>" class="form-control" >
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>Fb</label>
    <input name="fb" type="text" id="fb" value="<?php echo e($fb) ?>" class="form-control" >
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>Instagram</label>
    <input name="instagram" type="text" id="instagram" value="<?php echo e($instagram) ?>" class="form-control" >
  </div>
</div>
</div> 
<div class="row">
<div class="col-md-6">
    <div class="form-group">
      <label>VOS  Remark</label>
      <input name="ves_remark" type="nextremark" id="ves_remark" value="<?php echo e($ves_remark) ?>"  class="form-control"  />  
	</div>
	</div>

<div class="col-md-6">
    <div class="form-group">
      <label>VE Remark</label>
      <input name="vip_remark" type="nextremark" id="vip_remark" value="<?php echo e($vip_remark) ?>" class="form-control" >
    </div>
  </div>
</div>   

<div class="row">
<div class="col-md-6">
    <div class="form-group has-error">
      <label>City School</label>
      <span class="style2">
      <select name="school_city" id="school_city" onChange="this.form.submit()" class="form-control" >
        <option value= > <?php echo $list_city?>
          <option selected="selected">
            <?php 		   
				  if ($school_city !="") { echo e($school_city); }
  ?>
          </select>
      </span></div>
  </div>
<div class="col-md-6">
  <div class="form-group has-error">
    <label>Level School </label>
    <span class="style2">
    <select name="school_level" id="school_level" class="form-control" >
      <option>SD</option>
      <option>SMP</option>
      <option>SMA</option>
      <option>UNI</option>
      <option>S1</option>
      <option>S2</option>
      <option>S3</option>
      <option>Employee</option>      
      <option selected="selected"> <?php echo e($school_level);  ?></option>
    </select>
    </span></div>
</div>
</div>    
<div class="row">
<div class="col-md-8">
    <div class="form-group">
      <label> School Name</label>
      <span class="style2">
      <select name="school_name" id="school_name"  onChange="this.form.submit()"  class="form-control" >
        <option value= > <?php echo $list_ori_school?>
          <option selected="selected">
            <?php 		   
				  if ($school_name !="") { echo e($school_name); }else { echo e($nm_ori_school); }
  ?>
          </select>
      </span></div>
  </div>
<div class="col-md-3">
  <div class="form-group has-error">
    <label>Grade</label>
    <span class="style2">
    <select name="school_grade" id="school_grade"  class="form-control" >
      <option>O Level</option>
      <option>IB</option>
      <option>Yr 1</option>
      <option>Yr 2</option>
      <option>Yr 3</option>
      <option>Yr 4</option>
      <option>Yr 5</option>
      <option>Yr 6</option>
      <option>Yr 7</option>
      <option>Yr 8</option>
      <option>Yr 9</option>
      <option>Yr 10</option>
      <option>Yr 11</option>
      <option>Yr 12</option>
      <option>Sec 1</option>
      <option>Sec 2</option>
      <option>Sec 3</option>
      <option>Sec 4</option>
      <option>GRADUATE</option>
      <option>NONE</option>      
      <option selected="selected"> <?php echo e($school_grade);  ?></option>
    </select>
    </span></div>
</div>
</div>     
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>Not Listed School</label>
            <input class='form-control' name='other_school' placeholder='Not Listed School' type='text' size="35" 
							<?php if ($school_city == 'Other' || $school_name== 'Other')
							{ 
							$st_other_ori = 1;
							echo ""; 
							}
							else
							{ 
							$st_other_ori = 0;

							echo "hidden='hidden'"; 
							}
							?>
							>
  </div>
	</div>    </div>  
<div class="row">
<div class="col-md-2">
    <div class="form-group">
      <label>Country Destination</label>
      <span style="color: #FFFFFF">
      <select name="flt_country1" id="flt_country1"onChange="this.form.submit()"  class="form-control" >
        <option value= ""> <?php echo e($list_country1)?> </option>
        <option selected="selected">
          <?php  		   if ($flt_country1 !="") { echo e($flt_country1); }else { echo e($country_dest1); }

   ?>
          </option>
      </select>
      </span></div>
  </div>
  <div class="col-md-4">
  <div class="form-group">
    <label>School Destination</label>
    <span class="style92" style="color: #FFFFFF">
    <select name="flt_school1" id="flt_school1" onChange="this.form.submit()" class="form-control" >
      <option value= > <?php echo e($list_school1)?>
        <option selected="selected">
          <?php  
		   if ($flt_school1 !="") { echo e($flt_school1); }else { echo e($school_dest1); }
   ?>
          </option>
    </select>
    </span></div>
</div>


<div class="col-md-3">
    <div class="form-group">
      <label>Program Destination</label>
      <span class="style92" style="color: #FFFFFF">
      <select name="flt_program1" id="flt_program1"  class="form-control" >
        <option value= > <?php echo $list_program?>
          <option selected="selected">
            <?php  if ($flt_program1 !="") { echo e($flt_program1); }else { echo e($program_dest1); }
   ?>
            </option>
      </select>
      </span></div>
  </div>
</div>
<div class="row">
<div class="col-md-8">
  <div class="form-group">
    <label>VIP Program Needed</label>
                <select name="vip_program" id="vip_program"  class="form-control" >
				<option>NG TOEFL</option>
				<option>TOEFL</option>
				<option>IELTS</option>
				<option>ACADEMIC ENGLISH</option>
				<option selected="selected"> <?php echo e($vip_program);  ?> </option>                               
                                </select>
  </div>
</div>
</div>        
<div class="row">
<div class="col-md-3">
  <div class="form-group">
    <label>Parent Name</label>
    <input name="parent_name" type="text" id="parent_name" value="<?php echo e($parent_name) ?>" class='form-control' >
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>Parent Address</label>
    <input name="parent_address" type="text" id="parent_address" value="<?php echo e($parent_address) ?>" class='form-control' >
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>Parent City</label>
    <select name="parent_city" id="parent_city" class='form-control' >
      <option value= > <?php echo $list_city?>
        <option selected="selected">
          <?php 		   
				  if ($parent_city !="") { echo e($parent_city); }else { echo e($nm_city); }
  ?>
          </option>
    </select>
    </div>
</div>
</div>     
<div class="row">
<div class="col-md-3">
  <div class="form-group">
    <label>Parent HP</label>
    <input name="parent_hp" type="text" id="parent_hp" value="<?php echo e($parent_hp) ?>" class='form-control' >
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>Parent E-Mail</label>
    <input name="parent_email" type="text" id="parent_email" value="<?php echo e($parent_email) ?>" class='form-control' >
  </div>
</div>
</div> 
<div class="row">
<div class="col-md-3">
  <div class="form-group">
    <label>Source</label>
            <select name="event_st" id="event_st" class='form-control' onChange="this.form.submit()">
          <option selected disabled>Source</option>
          <option>Event</option>
          <option>Non Event</option>
			<option selected><?php echo e($event_st) ?></option>                       
            </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>Detail</label>
    <input type="text" name="event_st_dtl"  class="form-control" value = "<?php echo e($event_st_dtl)  ?>"/>
  </div>
</div>
</div>
<div class="row">
<div class="col-md-3">
  <div class="form-group">
    <label>Marketing Source</label>
    <select name="mkt_source_event" id="mkt_source_event" class='form-control' >
      <option value= ""> <?php echo $list_source_type ?> </option>
      <option selected="selected">
        <?php  if ($mkt_source_event !="") { echo e($mkt_source_event); }

   ?>
      </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>Detail</label>
    <input name="mkt_source_event_dtl" type="text" id="mkt_source_event_dtl" value="<?php echo e($mkt_source_event_dtl) ?>"  class='form-control' >
  </div>
</div>
</div>
<div class="row"></div>
<input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />

    </div>
		      
 
</form>
</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
{
$statussimpan = 0;
$jamskrg= date('h:i:s', time());

$tanggal_hri = date('Y-m-d');
$nama_lengkap = $_SESSION['nama_lengkap'];

$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ; 
$flt_country1 = in_val('flt_country1', 'any');
$first_name = in_val('first_name', 'any');
if ($first_name=='')
	{
	if (num($statussimpan)==0){$pesan="First Name ";}
	$statussimpan=1;
	}
$family_name = in_val('family_name', 'any');

$gender = in_val('gender', 'any');
if ($gender=='')
	{
	if (num($statussimpan)==0){$pesan="gender ";}
	$statussimpan=1;
	}

$family_name = in_val('family_name', 'any');
$dob = in_val('dob', 'any');
$tgl_lahir = $tgl_lahir;	
$address = in_val('address', 'any');
if ($address=='')
	{
	if (num($statussimpan)==0){$pesan="address ";}
	$statussimpan=1;
	}
$student_city = in_val('student_city', 'any');
if ($student_city=='')
	{
	if (num($statussimpan)==0){$pesan="city ";}
	$statussimpan=1;
	}
$area = in_val('area', 'any');
$phone = in_val('phone', 'any');
$hp1 = in_val('hp1', 'any');
if ($hp1=='')
	{
	if (num($statussimpan)==0){$pesan="hp  ";}
	$statussimpan=1;
	}
$hp2 = in_val('hp2', 'any');
$e_mail = in_val('e_mail', 'any');
if ($e_mail=='')
	{
	if (num($statussimpan)==0){$pesan="e_mail  ";}
	$statussimpan=1;
	}
	
//==sosmed
$fb = in_val('fb', 'any');
$twitter = in_val('twitter', 'any');
$instagram = in_val('instagram', 'any');
$path = in_val('path', 'any');
$line = in_val('line', 'any');
$wa = in_val('wa', 'any');
if ($fb !='')
	{
	$sosmed = "$sosmed fb = $fb ";
	}
if ($twitter !='')
	{
	$sosmed = "$sosmed twitter = $twitter ";
	}
if ($instagram !='')
	{
	$sosmed = "$sosmed instagram = $instagram ";
	}
if ($path !='')
	{
	$sosmed = "$sosmed path = $path ";
	}
if ($line !='')
	{
	$sosmed = "$sosmed line = $line ";
	}
if ($wa !='')
	{
	$sosmed = "$sosmed wa = $fb ";
	}
//====
$ves_remark = in_val('ves_remark', 'any');
$vip_remark = in_val('vip_remark', 'any');
$vip_program = in_val('vip_program', 'any');	
$school_city = in_val('school_city', 'any');
if ($school_city=='')
	{
	if (num($statussimpan)==0){$pesan="school city  ";}
	$statussimpan=1;
	}
$other_school = in_val('other_school', 'any');	
$other_school_dest = in_val('other_school_dest', 'any');	


$school_level = in_val('school_level', 'any');


if ($school_name=='')
	{
	if (num($statussimpan)==0){$pesan="school name";}
	$statussimpan=1;
	}
$school_grade = in_val('school_grade', 'any');
if ($school_grade=='')
	{
	if (num($statussimpan)==0){$pesan="school_grade";}
	$statussimpan=1;
	}
$flt_country1 = in_val('flt_country1', 'any');
$flt_school1 = in_val('flt_school1', 'any');
if ($flt_school1 != '')
	{
	$query_kd_school = q_set($__p_query_kd_school, "SELECT  kd_school FROM ves_data.tb_master_partner t where school = ? and (country = ? or country = 'OTHER')", [(string) ($flt_school1), (string) ($flt_country1)]);
	$resource_kd_school = db_query_or_die('errro_kd_school1', $query_kd_school, $__p_query_kd_school ?? []);
	$keluar_kd_school= db_num_rows($resource_kd_school);
	if(num(db_num_rows($resource_kd_school)) > 0)
		{
		while ($row_kd_school=  db_fetch($resource_kd_school, PDO::FETCH_NUM))
			{
			$kd_school1= $row_kd_school[0];				
			}
		} 
	}

$flt_program1 = in_val('flt_program1', 'any');

$parent_name = in_val('parent_name', 'any');
$parent_address = in_val('parent_address', 'any');
$parent_city = in_val('parent_city', 'any');
$parent_hp = in_val('parent_hp', 'any');
$parent_email = in_val('parent_email', 'any');
$school_city = in_val('school_city', 'any');
$mkt_source_event = in_val('mkt_source_event', 'any');
$mkt_source_event_dtl = in_val('mkt_source_event_dtl', 'any');
if ($mkt_source_event_dtl=='')
	{
	if (num($statussimpan)==0){$pesan="Source Detail ";}
	$statussimpan=1;
	}
$media_source = in_val('media_source', 'any');


$kd_student = in_val('kd_student', 'any');
$jamskrg= date('h:i:s', time());
$nama_depan= $_SESSION['nama_depan']; 
$tanggal_hri = date('Y-m-d');
$kodetgl = date('ymd');
$event_st_dtl = in_val('event_st_dtl', 'any');	

//==========other
if ($school_name =='Other') 
	{
	$school_name = $other_school;
	}
//====
if ( $flt_country1 == 'OTHER' || $flt_school1 =='OTHER') 
	{ 
	$flt_school1 = $other_school_dest; 
	$kd_school1 = 'Other';
	}

if (num($statussimpan)==0)
	{
//===autonumber
	$query = q_set($__p_query, "SELECT MAX(t.no) as max_id FROM ves_inc.tb_biodata t where kd_branch = ? and (kd_biodata is not null or kd_biodata <>'')", [(string) ($kd_cbg)]);
	$result = db_query_soft($query, $__p_query ?? []);
	$data = db_fetch($result);
	$id_max = $data['max_id'];
	$sort_num = $id_max;
	$sort_num++;
	$new_code = sprintf($sort_num);
	$kode_biodata = "$kodetgl$kd_cbg$kd_staff$new_code";
		

//=====
		
	$query_simpan = q_set($__p_query_simpan, "insert into ves_inc.tb_biodata \r
\t(kd_biodata, \r
\tnama, middle_name, family_name, \r
\tdob, \r
\taddress,city, area, \r
\thm_ph, hp, hp_2, \t\r
\te_mail, \r
\tremark, vip_remark, \r
\tlevel_school, org_school, grade, \r
\tcountry_dest, school_dest, program_dest, \r
\tparent_nm, add_parent, city_parent, hp_parent, parent_email,   \r
\tevent_st, event_st_dtl, event_type, event_type_dtl, media_src, media_src_dtl,\r
\tdt_entry, time_entry, pic, branch, kd_branch,gender,\r
\tkd_school_1, country_1, school_1, program_1,vip_program,\r
\tsigned_to, \tsm_1,sm_2,sm_3,sm_4,sm_5,sm_6, org_city_school )\r
\tvalues \r
\t(? ,? , ? , ? , ? , ? , \r
\t? , ? , ? , ? , ? , \r
\t? ,  ? , ? , ? , \r
\t? , ? , ? , ? , ? , \r
\t? , ? , ? , ? , ? , \r
\t? ,? ,? , ? , ? , ? , \r
\t? , ? , ? , ? ,? ,? ,\r
\t? ,? ,? ,? ,? ,\r
\t? ,\r
\t? ,? ,? ,? ,? ,? ,?\t)", [(string) ($kode_biodata), (string) ($first_name), (string) ($middle_name), (string) ($family_name) . " ", (string) ($dob), (string) ($address), (string) ($student_city), (string) ($area) . " ", (string) ($phone) . " ", (string) ($hp1) . " ", (string) ($hp2) . " ", (string) ($e_mail), (string) ($ves_remark) . " ", (string) ($vip_remark) . " ", (string) ($school_level) . " ", (string) ($school_name), (string) ($school_grade), (string) ($country_ref), (string) ($school_ref), (string) ($program_ref), (string) ($parent_name), (string) ($parent_address), (string) ($parent_city) . " ", (string) ($parent_hp) . " ", (string) ($parent_email) . " ", (string) ($event_st), (string) ($event_st_dtl), (string) ($mkt_source_event), (string) ($mkt_source_event_dtl), (string) ($media_source), (string) ($media_source_dtl), (string) ($tanggal_hri), (string) ($jamskrg), (string) ($nama_lengkap), (string) ($branch), (string) ($kd_cbg), (string) ($gender), (string) ($kd_school1), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($vip_program), (string) ($nama_lengkap), (string) ($fb), (string) ($twitter), (string) ($instagram), (string) ($path), (string) ($line), (string) ($wa), (string) ($school_city)]);
	$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('New Leads has been Submitted by " . e($nama_lengkap) . "');\n";
	echo "window.location = ('mon_cm.php');\n";				
	echo "</script>";	
			
	}
else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($pesan) . " must be filled');\n";
	echo "</script>";
		
		
	}

}
?>