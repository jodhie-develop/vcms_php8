<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
 //include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'any');
$date_end = in_val('date_end', 'any');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];

$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;
$other_school = in_val('other_school', 'any');

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
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

$kdcb = in_val('kdcb', 'any');
$nmprg = in_val('nmprg', 'any');
$kdcl = in_val('kdcl', 'any');

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
$company = in_val('company', 'any');
$other_school_dest = in_val('other_school_dest', 'any');

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
//==============list source
if ($mkt_source_type != 'Event')
	{
	$query_source_type = q_set($__p_query_source_type, "SELECT source FROM ves_inc.tb_mkt_source where event <> 'E'");
	}
else
	{
	$query_source_type = q_set($__p_query_source_type, "SELECT source FROM ves_inc.tb_mkt_source where event = 'E'");
	}

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
  
<?php       include __DIR__ . "/left.php";	 ?>
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
    <div class="form-group">
      <label>Address</label>
      <input type="text" name="address"  class="form-control" value = "<?php echo e($address)  ?>"/>
    </div>
  </div>

</div> 
<div class="row">
<div class="col-md-3">
    <div class="form-group">
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
  <div class="form-group">
    <label>Company</label>
    <input name="company" type="text" id="company" value="<?php echo e($company) ?>" class="form-control" >
  </div>
</div>
<div class="col-md-3">
    <div class="form-group">
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
    <div class="form-group">
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
    <div class="form-group"></div>
</div>
</div>
<div class="row">
  <div class="col-md-3">
<div class="form-group">
    <label>Class Code</label>
    <input name="kdcl" type="text" id="kdcl" value="<?php echo e($kdcl) ?>"  class='form-control' >
  </div>
    
  
  </div>
  <div class="col-md-3">
<div class="form-group">
    <label>Program Code</label>
    <input name="nmprg" type="text" id="nmprg" value="<?php echo e($nmprg) ?>"  class='form-control' >
  </div>
    
  
  </div>  
  <div class="col-md-3">
<div class="form-group">
    <label>Branch Code</label>
    <input name="kdcb" type="text" id="kdcb" value="<?php echo e($kdcb) ?>"  class='form-control' >
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
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	
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
		echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($pesan) . " must be filled');\n";
	echo "</script>";die;
			
	}

$family_name = in_val('family_name', 'any');
$dob = in_val('dob', 'any');
$tgl_lahir = $tgl_lahir;	
$address = in_val('address', 'any');

$student_city = in_val('student_city', 'any');

$area = in_val('area', 'any');
$phone = in_val('phone', 'any');
$hp1 = in_val('hp1', 'any');

$hp2 = in_val('hp2', 'any');
$e_mail = in_val('e_mail', 'any');
$kdcb = in_val('kdcb', 'any');
$nmprg = in_val('nmprg', 'any');
$kdcl = in_val('kdcl', 'any');
	
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

$other_school = in_val('other_school', 'any');	
$other_school_dest = in_val('other_school_dest', 'any');	


$school_level = in_val('school_level', 'any');



$school_grade = in_val('school_grade', 'any');



$parent_name = in_val('parent_name', 'any');
$parent_address = in_val('parent_address', 'any');
$parent_city = in_val('parent_city', 'any');
$parent_hp = in_val('parent_hp', 'any');
$parent_email = in_val('parent_email', 'any');
$school_city = in_val('school_city', 'any');
$mkt_source_event = in_val('mkt_source_event', 'any');
$mkt_source_event_dtl = in_val('mkt_source_event_dtl', 'any');

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

if (num($statussimpan)==0)
	{
//===autonumber
	$query = q_set($__p_query, "SELECT MAX(t.no) as max_id FROM ves_inc.tb_biodata t where kd_branch = ? and (kd_biodata is not null or kd_biodata <>'')", [(string) ($kdcb)]);
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
\t? ,? ,? , ? , ? , 'VPRO', \r
\t? , ? , ? , ? ,? ,? ,\r
\t? ,? ,? ,? ,? ,\r
\t? ,\r
\t? ,? ,? ,? ,? ,? ,?\t)", [(string) ($kode_biodata), (string) ($first_name), (string) ($middle_name), (string) ($family_name), (string) ($tgl_lahir), (string) ($address), (string) ($student_city), (string) ($area) . " ", (string) ($phone) . " ", (string) ($hp1) . " ", (string) ($hp2) . " ", (string) ($e_mail), (string) ($ves_remark) . " ", (string) ($vip_remark) . " ", (string) ($school_level) . " ", (string) ($school_name), (string) ($school_grade), (string) ($country_ref), (string) ($school_ref), (string) ($program_ref), (string) ($parent_name), (string) ($parent_address), (string) ($parent_city) . " ", (string) ($parent_hp) . " ", (string) ($parent_email) . " ", (string) ($event_st), (string) ($event_st_dtl), (string) ($mkt_source_event), (string) ($mkt_source_event_dtl), (string) ($company), (string) ($tanggal_hri), (string) ($jamskrg), (string) ($nama_lengkap), (string) ($branch), (string) ($kdcb), (string) ($gender), (string) ($kd_school1), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($vip_program), (string) ($nama_lengkap), (string) ($fb), (string) ($twitter), (string) ($instagram), (string) ($path), (string) ($line), (string) ($wa), (string) ($school_city)]);
	$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);

//input billing
$query_last_billing = q_set($__p_query_last_billing, "SELECT kd_billing FROM ves_data.vip_billing where  kd_branch = ? order by no desc limit 1", [(string) ($kdcb)]);
			$resource_last_billing = db_query_or_die('errro_last_billing', $query_last_billing, $__p_query_last_billing ?? []);
			if(num(db_num_rows($resource_last_billing)) > 0)
				{
				while ($row_last_billing=  db_fetch($resource_last_billing, PDO::FETCH_NUM))
					{
					$kd_billing = $row_last_billing[0];
					$ambilangka =  substr($kd_billing,0,-4);
					#ketemu angka awal(angka sebelumnya) + dengan 1
					$nextangka=num($ambilangka)+1;
					#menhitung jumlah karakter
					$digit=strlen($nextangka);
					if(!$kd_billing){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3)
					{ $nol='0'; }	
					$nomor_baru = $nol.$nextangka."/VPRO/".$kdcb."/".$tahun;	
					}
				}
			else
				{
				$nomor_baru =  "0001/VPRO/".$kdcb."/".$tahun;
				}
			$idb = $nomor_baru;
			$query_simpan_billing= q_set($__p_query_simpan_billing, "insert into ves_data.vip_billing (kd_billing,kd_branch,kd_biodata,kd_program,tf,discount,net_tf,dt_entry,pic,sc,material,old_student,voucher,material_cost,reg_fee,promo_persen,level_program,private_pax,private_hours,kd_class) \r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($idb), (string) ($kdcb), (string) ($kode_biodata), (string) ($nmprg), (string) ($tf), (string) ($nm_promo), (string) ($tf_nett), (string) ($tgl_hari_ini), (string) ($first_name) . " " . (string) ($middle_name) . " " . (string) ($family_name), (string) ($nama_lengkap), (string) ($material_book), (string) ($old_student), (string) ($voucher), (string) ($material_fee), (string) ($reg_fee), (string) ($discount_tf), (string) ($nm_level), (string) ($private_pax), (string) ($private_hours), (string) ($kdcl)]);
			$resource_simpan_billing = db_query_or_die('errro_simpan', $query_simpan_billing, $__p_query_simpan_billing ?? []);
		
			$query_cek_student_data = q_set($__p_query_cek_student_data, "select kd_biodata from ves_data.vip_student_data where kd_biodata = ? and kd_branch = ? ", [(string) ($kode_biodata), (string) ($kdcb)]);
			$resource_cek_student_data = db_query_or_die('errro_last_billing', $query_cek_student_data, $__p_query_cek_student_data ?? []);
			if(num(db_num_rows($resource_cek_student_data)) == 0)
				{
				$query_vip_nama = q_set($__p_query_vip_nama, "insert into  ves_data.vip_student_data (kd_branch, nama_lengkap, kd_biodata)values (? ,? ,? )", [(string) ($kdcb), (string) ($first_name) . " " . (string) ($middle_name) . " " . (string) ($family_name), (string) ($kode_biodata)]);
				$resource_vip_nama = db_query_or_die('errro_simpan', $query_vip_nama, $__p_query_vip_nama ?? []);						
				}		
		
//		
		
		
	echo "<script type=\"text/javascript\">\n";
	echo "alert('New Student has been Submitted by " . e($nama_lengkap) . "');\n";
	echo "window.location = ('vip_class_list.php?kd_cbg=" . e(u($kdcb)) . "');\n";				
	echo "</script>";	
			
	}
else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($pesan) . " must be filled');\n";
	echo "</script>";die;
		
		
	}

}
?>