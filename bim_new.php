<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$upd = in_val('upd', 'any');
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'any');
$date_end = in_val('date_end', 'any');
if ($date_start ==''){$date_start = "2022-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;
$other_school = in_val('other_school', 'any');
$kdb = in_val('kdb', 'any');
if (num($upd) ==1)
	{
	$query_upd = q_set($__p_query_upd, "SELECT nama, middle_name, family_name, e_mail, sm_6, hp, address, city,org_city_school, org_school,grade,dob,hm_ph,level_school FROM ves_inc.tb_biodata where event_st = 'Project' and event_st_dtl = 'BIM 2022' and kd_biodata = ? ", [(string) ($kdb)]);
$resource_upd = db_query_soft($query_upd, $__p_query_upd ?? []);			
if(num(db_num_rows($resource_upd)) > 0)
	{
	while ($row_upd  =  db_fetch($resource_upd, PDO::FETCH_NUM))
		
		{
		$first_name = $row_upd[0]; 
		$middle_name  = $row_upd[1];
		$family_name  = $row_upd[2];
		$e_mail =  $row_upd[3];
		$wa = $row_upd[4];
		$school_city  = $row_upd[8];
		$school_level = $row_upd[13];
		$school_name  = $row_upd[9];
		$school_grade  = $row_upd[10];
		$dob  = $row_upd[11];
		$address  = $row_upd[6];
		$phone  = $row_upd[12];
		$hp1  = $row_upd[5];
		$gender  = $row_upd[10];

		$student_city  = $row_upd[7];		
		}
	}
		
	}
else {
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
$school_city = in_val('school_city', 'any');
$event_st = in_val('event_st', 'any');
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

$wa = in_val('wa', 'any');
$school_city = in_val('school_city', 'any');
$school_level = in_val('school_level', 'any');
$school_name = in_val('school_name', 'any');
$school_grade = in_val('school_grade', 'any');

$mkt_source_type = in_val('mkt_source_type', 'any');
$mkt_source_event = in_val('mkt_source_event', 'any');
$mkt_source_event_dtl = in_val('mkt_source_event_dtl', 'any');
$media_source = in_val('media_source', 'any');
$media_source_dtl = in_val('media_source_dtl', 'any');
$gender = in_val('gender', 'any');
$other_school = in_val('other_school', 'any');
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
  <input type="hidden" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>">
</span>
 <div class="row">
 	  <div class="col-md-8">
    <div class="form-group">
      <label>Student Name</label>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>" readonly>      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="kdb" 
                 	      value="<?php echo e($kdb) ?>" readonly>
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
<div class="col-md-3">
    <div class="form-group has-error">
      <label>City</label>

            <select name="student_city" id="student_city" class="form-control" >
		<option>Select City</option>				
                <option value= >
                  <?php echo $list_city?>
              <option selected="selected"> <?php 		   
				  if ($student_city !="") { echo e($student_city); }else { echo e($nm_city); }
  ?> </option>
            </select>
    </div>
  </div>
</div> 
<div class="row">

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
    <select name="school_level" id="school_level" class="form-control" onChange="this.form.submit()" >
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
            <input class='form-control' name='other_school' placeholder='Not Listed School' type='text' size="35" va.ue="
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
							?>"
							>
  </div>
	</div>    </div>              
<div class="row">
<div class="col-md-3">
  <div class="form-group">
    <label>Source</label>
            <select name="event_st" id="event_st" class='form-control' onChange="this.form.submit()">
          <option selected disabled>Source</option>
			<option selected>Project</option>                       
            </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>Detail</label>
    <input type="text" name="event_st_dtl"  class="form-control" value = "BIM 2022" readonly/>
  </div>
</div>
</div>
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

$wa = in_val('wa', 'any');

if ($wa !='')
	{
	$sosmed = "$sosmed wa = $fb ";
	}
//====	
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



$kd_student = in_val('kd_student', 'any');
$jamskrg= date('h:i:s', time());
$nama_depan= $_SESSION['nama_depan']; 
$tanggal_hri = date('Y-m-d');
$kodetgl = date('ymd');
$event_st_dtl = in_val('event_st_dtl', 'any');	
$nama_student_lengkap = "$first_name $middle_name $family_name";
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
	$kdb = in_val('kdb', 'any');
//=====
	if ($kdb == '')		
		{
		$query = q_set($__p_query, "SELECT MAX(t.no) as max_id FROM ves_inc.tb_biodata t where kd_branch = ? and (kd_biodata is not null or kd_biodata <>'')", [(string) ($kd_cbg)]);
		$result = db_query_soft($query, $__p_query ?? []);
		$data = db_fetch($result);
		$id_max = $data['max_id'];
		$sort_num = $id_max;
		$sort_num++;
		$new_code = sprintf($sort_num);
		$kode_biodata = "$kodetgl$kd_cbg$kd_staff$new_code";

		$query_simpan = q_set($__p_query_simpan, "insert into ves_inc.tb_biodata \r
\t\t(kd_biodata, \r
\t\tnama, middle_name, family_name, \r
\t\tdob, \r
\t\taddress,city, area, \r
\t\thm_ph, hp, hp_2, \t\r
\t\te_mail, \r
\t\tremark, vip_remark, \r
\t\tlevel_school, org_school, grade, \r
\t\tcountry_dest, school_dest, program_dest, \r
\t\tparent_nm, add_parent, city_parent, hp_parent, parent_email,   \r
\t\tevent_st, event_st_dtl, event_type, event_type_dtl, media_src, media_src_dtl,\r
\t\tdt_entry, time_entry, pic, branch, kd_branch,gender,\r
\t\tkd_school_1, country_1, school_1, program_1,vip_program,\r
\t\tsigned_to, \tsm_1,sm_2,sm_3,sm_4,sm_5,sm_6, org_city_school )\r
\t\tvalues \r
\t\t(? ,? , ? , ? , ? , ? , \r
\t\t? , ? , ? , ? , ? , \r
\t\t? ,  ? , ? , ? , \r
\t\t? , ? , ? , ? , ? , \r
\t\t? , ? , ? , ? , ? , \r
\t\t? ,? ,? , ? , ? , ? , \r
\t\t? , ? , ? , ? ,? ,? ,\r
\t\t? ,? ,? ,? ,? ,\r
\t\t? ,\r
\t\t? ,? ,? ,? ,? ,? ,?\t)", [(string) ($kode_biodata), (string) ($first_name), (string) ($middle_name), (string) ($family_name) . " ", (string) ($dob), (string) ($address), (string) ($student_city), (string) ($area) . " ", (string) ($phone) . " ", (string) ($hp1) . " ", (string) ($hp2) . " ", (string) ($e_mail), (string) ($ves_remark) . " ", (string) ($vip_remark) . " ", (string) ($school_level) . " ", (string) ($school_name), (string) ($school_grade), (string) ($country_ref), (string) ($school_ref), (string) ($program_ref), (string) ($parent_name), (string) ($parent_address), (string) ($parent_city) . " ", (string) ($parent_hp) . " ", (string) ($parent_email) . " ", (string) ($event_st), (string) ($event_st_dtl), (string) ($mkt_source_event), (string) ($mkt_source_event_dtl), (string) ($media_source), (string) ($media_source_dtl), (string) ($tanggal_hri), (string) ($jamskrg), (string) ($nama_lengkap), (string) ($branch), (string) ($kd_cbg), (string) ($gender), (string) ($kd_school1), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($vip_program), (string) ($nama_lengkap), (string) ($fb), (string) ($twitter), (string) ($instagram), (string) ($path), (string) ($line), (string) ($wa), (string) ($school_city)]);
		$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);

		$query_simpan_vip = q_set($__p_query_simpan_vip, "insert into ves_data.vip_student_data (kd_branch, nama_lengkap, kd_biodata) values ('400',? ,? )", [(string) ($nama_student_lengkap) . " ", (string) ($kode_biodata)]);
		$resource_simpan_vip= db_query_or_die('errro_simpan', $query_simpan_vip, $__p_query_simpan_vip ?? []);

		echo "<script type=\"text/javascript\">\n";
		echo "alert('New BIM data has been Submitted by " . e($nama_lengkap) . "');\n";
		echo "window.location = ('bim_list.php');\n";				
		echo "</script>";	
		}
	else
		{
		$query_upd = q_set($__p_query_upd, "update ves_inc.tb_biodata set nama =? , middle_name =? , family_name =? , e_mail =? , sm_6 =? , hp =? , address =? , city =? ,org_city_school =? , org_school =? ,grade =? ,dob =? ,hm_ph =? ,level_school =?  where event_st = 'Project' and event_st_dtl = 'BIM 2022' and kd_biodata = ? ", [(string) ($first_name), (string) ($middle_name), (string) ($family_name), (string) ($e_mail), (string) ($wa), (string) ($hp1), (string) ($address), (string) ($student_city), (string) ($school_city), (string) ($school_name), (string) ($school_grade), (string) ($dob), (string) ($phone), (string) ($school_level), (string) ($kdb)]);

		$resource_upd = db_query_soft($query_upd, $__p_query_upd ?? []);	
		$query_simpan_vip = q_set($__p_query_simpan_vip, "update  ves_data.vip_student_data set  nama_lengkap = ? where kd_biodata = ? ", [(string) ($first_name) . " " . (string) ($middle_name) . " " . (string) ($family_name), (string) ($kdb)]);
		$resource_simpan_vip= db_query_or_die('errro_simpan', $query_simpan_vip, $__p_query_simpan_vip ?? []);	
				echo "<script type=\"text/javascript\">\n";
		echo "alert('BIM data has been Updated by " . e($nama_lengkap) . "');\n";
		echo "window.location = ('bim_list.php');\n";				
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
?>