<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 

date_default_timezone_set('UTC');
// get the HTML
ob_start();
ini_set('memory_limit', '150M');
$tanggal_hri_ini = date('m/d/Y h:i:s a', time());
$tanggal_hri = date('Y-m-d');

$enroll_dd = date('d');
$enroll_mm = date('m');
$enroll_yy= date('Y');

include __DIR__ . "/conndb.php";
//echo "<link href='css/format.css' rel='stylesheet' type='text/css'>";
$kd_staff = $_SESSION['kd_staff']; 
$posisi = $_SESSION['posisi']; 
$nama_lengkap = $_SESSION['nama_lengkap']; 
$nama_depan= $_SESSION['nama_depan']; 
$kode_student= in_val('kode_student', 'get'); 

$kd_branch = $_SESSION['kd_branch']; 
if ($kd_branch == '01') {$kdcbg= '1';}
if ($kd_branch == '02') {$kdcbg= '2';} 
if ($kd_branch == '03') {$kdcbg= '3';} 
if ($kd_branch == '04') {$kdcbg= '4';} 
if ($kd_branch == '05') {$kdcbg= '5';} 
if ($kd_branch == '06') {$kdcbg= '6';} 
if ($kd_branch == '07') {$kdcbg= '7';} 
if ($kd_branch == '08') {$kdcbg= '8';} 
if ($kd_branch=='01')
	{ 
	$urut_branch = "1";	
	$branch= "East Sby";
	$branch_nm= "EAST SBY";
	
	$branch_field = "East_Sby";
	$kurangi_sales_year = "0";
	}
if ($kd_branch=='02')
	{ 
	$urut_branch = "2";	

	$branch= "West Sby";
	$branch_nm= "WEST SBY";
	$branch_field = "West_Sby";
	$kurangi_sales_year = "6";
	}
if ($kd_branch=='05')
	{ 
	$urut_branch = "5";	
	
	$branch= "Central Jkt";
	$branch_nm= "NORTH JKT";
	$branch_field = "Central_Jkt";	
	$kurangi_sales_year = "1";
	}
if ($kd_branch=='04')
	{ 
	$urut_branch = "4";	
	
	$branch= "Patal Jkt";
	$branch_nm= "SOUTH JKT";
	$branch_field = "South_Jkt";
	$kurangi_sales_year = "7";
	}
if ($kd_branch=='07')
	{ 
	$urut_branch = "7";	
	
	$branch= "Bandung";	
	$branch_nm= "BANDUNG";
	$branch_field = "Bandung";	
	$kurangi_sales_year = "4";
	}
if ($kd_branch=='03')
	{ 
	$urut_branch = "3";	
	
	$branch= "Bali";
	$branch_nm= "DENPASAR";
	$branch_field = "Bali";
	$kurangi_sales_year = "11";
	}
if ($kd_branch=='06')
	{ 
	$urut_branch = "6";	

	$branch= "jkt m2";
	$branch_nm= "WEST JKT";
	$branch_field = "west_Jkt";
	$kurangi_sales_year = "12";
	}
if ($kd_branch=='08')
	{ 
	$urut_branch = "8";	

	$branch= "Malang TBI";
	$branch_nm= "Malang TBI SATELLITE";
	$branch_field = "malang_tbi";
	$kurangi_sales_year = "17";
	}
if ($kd_branch=='10')
	{ 
	$urut_branch = "10";	

	$branch= "Bali TBI";
	$branch_nm= "Bali TBI";
	$branch_field = "bali_tbi";
	$kurangi_sales_year = "17";
	}
if ($kd_branch=='09')
	{ 
	$urut_branch = "9";	
	$branch= "Bandung TBI";
	$branch_nm= "Bandung TBI";
	$branch_field = "bandung_tbi";
	$kurangi_sales_year = "17";
	}

//===enroll detail
$query_enroll = q_set($__p_query_enroll, "SELECT date_format(enroll_date,'%d %b %Y') FROM ves_inc.tb_enrolled where kd_biodata = ? order by no desc limit 1", [(string) ($kode_student)]);
$result_twi=db_query_or_die("Wah error nih! 1", $query_enroll, $__p_query_enroll ?? []);
$no_urut_week ="1";	  
	while ($r_dtli = db_fetch($result_twi))
		{ 
		$tgl_enroll  = $r_dtli['0'];	
		}

//====
//======tampilkan detail
$query_biodata = q_set($__p_query_biodata, "select  nama, middle_name, family_name, date_format(dob,'%d'), date_format(dob,'%m'),date_format(dob,'%Y'),address, city, area, hm_ph, hp, hp_2, e_mail, sosmed, remark, vip_remark, level_school, org_school, grade, country_dest, school_dest, program_dest, \r
parent_nm, add_parent, city_parent, hp_parent, parent_email, event_st, event_type,event_type_dtl, media_src, media_src_dtl, dt_entry, time_entry, pic, branch, kd_branch,gender, kd_school_1, country_1, school_1, program_1, kd_school_2, country_2, school_2, program_2, kd_school_3, country_3, school_3, program_3, ves_status, nationality,date_format(dob,'%d %b %Y')  from ves_inc.tb_biodata where kd_biodata = ? order by no desc limit 1", [(string) ($kode_student)]);

$resource_biodata = db_query_or_die('errro_1', $query_biodata, $__p_query_biodata ?? []);
$keluar_biodata= db_num_rows($resource_biodata);
if(num(db_num_rows($resource_biodata)) > 0)
	{
	while ($row_biodata=  db_fetch($resource_biodata, PDO::FETCH_NUM))
		{
		$nama  = $row_biodata['0'];
		$middle_name  = $row_biodata['1'];
		$family_name  = $row_biodata['2'];
		$dob_dd = $row_biodata['3'];
		$dob_mm = $row_biodata['4'];
		$dob_yy = $row_biodata['5'];
		$address = $row_biodata['6'];
		$city = $row_biodata['7'];
		$area  = $row_biodata['8'];
		$hm_ph  = $row_biodata['9'];
		$hp  = $row_biodata['10'];
		$hp_2  = $row_biodata['11'];
		$e_mail  = $row_biodata['12'];
		$sosmed  = $row_biodata['13'];
		$remark  = $row_biodata['14'];
		$vip_remark  = $row_biodata['15'];
		$level_school  = $row_biodata['16'];
		$org_school  = $row_biodata['17'];
		$grade  = $row_biodata['18'];
		$country_dest  = $row_biodata['19'];
		$school_dest  = $row_biodata['20'];
		$program_dest  = $row_biodata['21'];
		$parent_nm  = $row_biodata['22'];
		$add_parent  = $row_biodata['23'];
		$city_parent  = $row_biodata['24'];
		$hp_parent  = $row_biodata['25'];
		$parent_email    = $row_biodata['26'];
		$event_st  = $row_biodata['27'];
		$event_type = $row_biodata['28'];
		$event_type_dtl  = $row_biodata['29'];
		$media_src  = $row_biodata['30'];
		$media_src_dtl = $row_biodata['31'];
		$dt_entry  = $row_biodata['32'];
		$time_entry  = $row_biodata['33'];
		$pic  = $row_biodata['34'];
		$branch  = $row_biodata['35'];
		$kd_branch = $row_biodata['36'];
		$gender = $row_biodata['37'];
		$kd_school_1 = $row_biodata['38'];
		$country_1  = $row_biodata['39'];
		$school_1  = $row_biodata['40'];
		$program_1  = $row_biodata['41'];
		$kd_school_2  = $row_biodata['42'];
		$country_2 = $row_biodata['43'];
		$school_2  = $row_biodata['44'];
		$program_2  = $row_biodata['45'];
		$kd_school_3  = $row_biodata['46'];
		$country_3  = $row_biodata['47'];
		$school_3  = $row_biodata['48'];
		$program_3  = $row_biodata['49'];	
		$status = $row_biodata['50'];
		$nationality = $row_biodata['51'];
		$dob_lengkap = $row_biodata['52']; 
		$alamat_lengkap = "$address $city $nationality";
		}
	}
$query_gb = q_set($__p_query_gb, "SELECT doc_file FROM ves_data.doc_leads where doc_type = 'Profile Picture' and kd_biodata = ? ", [(string) ($kode_student)]);
$resource_gb = db_query_or_die('errro_1', $query_gb, $__p_query_gb ?? []);
$keluar_gb= db_num_rows($resource_gb);
if(num(db_num_rows($resource_gb)) > 0)
	{
	while ($row_gb=  db_fetch($resource_gb, PDO::FETCH_NUM))
		{
		$fotostudent  = $row_gb['0'];
		}
	}

function buatrp($angka)
{
if (num($angka) !=0)
{$jadi = "Rp " . number_format(num($angka),0,',',',');
return $jadi;
}
else
{echo e($jadi = 0);}
}	
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
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
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header" align="center"><table class="table table-striped">
          <thead>
          <tr>
            <th width="19%"><img src="veslog.png" width="183" height="109" alt=""/><br>
              <strong><?php echo e($branch_nm) ?></strong></th>
            <th width="58%" align="center"><h1>Enrollment Form<br>
 </h1></th>
            <th width="23%"><h6> Enroll Date :<strong><?php echo e($tgl_enroll) ?></strong></h6></th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
       
      </div>
<div class="col-sm-4 invoice-col">
        <h5>Student Name :<strong><?php echo  e($nama) ?> <?php echo  e($middle_name) ?> <?php echo  e($family_name) ?></strong><br>
          <strong><?php echo  e($gender) ?></strong><br>
      </h5>
</div>		  
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <strong><img src="<?php if ($fotostudent!=''){echo e($fotostudent) ; }else {echo "imgs/picblank.jpg" ;}?>" width="127" height="183" alt=""/></strong><br>
Date Of Birth :<br>
<strong><?php echo  e($dob_lengkap) ?></strong><br>
</div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col"><strong>Address
          :</strong>
        <address>
          <strong></strong><strong><?php echo  e($address) ?> <br>
          <?php echo  e($city) ?> <?php echo  e($nationality) ?></strong><br>
San Francisco, CA 94107<br>
Phone: <strong><?php echo  e($hm_ph) ?></strong><br>
Handphone : <strong><?php echo  e($hp) ?></strong> <br>
Email: <strong><?php echo  e($e_mail) ?></strong> <b><br>
        <br>
        Parent's Info</b>
        <br>
        Name : <strong><?php echo  e($parent_nm) ?></strong><br>
        Phone: <strong><?php echo  e($hp_parent) ?></strong><br>
      </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <strong>Education :<br>
        </strong><strong><?php echo  e($level_school) ?></strong><br>
        <strong><?php echo  e($org_school) ?> <?php echo  e($grade) ?></strong><br>
      	</div>
      <!-- /.col --><!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
		<hr>
    <div class="row">
      <div class="col-xs-12 table-responsive">
		  	  <div class="col-xs-12" align="center">   <h4><strong>OVERSEAS STUDY PROGRAM</strong></h4></div>
        <table class="table table-striped">
          <thead>
          <tr>
            <th width="54%">Institution Info</th>
            <th width="23%">Intake Date</th>
            <th width="23%">Proffesional Fee</th>
            </tr>
          </thead>
          <tbody>
                <?php 
		$query_enroll = q_set($__p_query_enroll, "SELECT sch_dest, prg_dest, country_dest, major_dest, date_format(intake_date,'%d %b %Y'), prof_fee FROM ves_inc.tb_enrolled where kd_biodata = ? ", [(string) ($kode_student)]);

		$result_twi=db_query_or_die("Wah error nih! 1", $query_enroll, $__p_query_enroll ?? []);
		$no_urut_week ="1";	  
			while ($r_dtli = db_fetch($result_twi))
				{ ?>
          <tr>
            <td><strong><?php echo e($r_dtli[0]); ?> (<?php echo e($r_dtli[2]); ?>) <br>
              <?php echo e($r_dtli[1]); ?> - <?php echo e($r_dtli[3]); ?></strong></td>
            <td><strong><?php echo e($r_dtli[4]); ?></strong></td>
            <td><strong><?php echo e(buatrp($r_dtli[5])); ?></strong></td>
            </tr><?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
		<br>
		<hr>
    <div class="row">

      <div class="col-xs-12 table-responsive">
  	    <div class="col-xs-12" align="center">   <h4><strong>RULES & REGULATIONS REGARDING PROFESSIONAL FEE</strong></h4></div>
        <table class="table table-striped">
          <thead>
          <tr>
            <th width="2%">1. </th>
            <th width="98%">Professional fee is the amount of money paid according to those stated on professional fee details.</th>
            </tr>

          <tr>
            <td>2.</td>
            <td>The Professional fee is non-refundable, including when there is cancellation of application from the applicant for any reason and at any time.</td>
            </tr>
          <tr>
            <td>3.</td>
            <td>In the case a US Visa is rejected, we will refund 50% of the first school's professional fee, provided the applicant has been interviewed twice.</td>
          </tr>
          <tr>
            <td>4.</td>
            <td>The professional fee paid is valid only for the particular schools agreed at the time of payment. If there is an addition or change of schools later on, there will be additional charge.</td>
          </tr>
                    </thead>
      
        </table>
      </div>
      <!-- /.col -->
    </div>
		<hr>
    <div class="row">

      <div class="col-xs-12 table-responsive">
  	    <div class="col-xs-12" align="center">   <h4><strong>RULES & REGULATIONS REGARDING OTHER FEES</strong></h4></div>
		  	  <table class="table table-striped">
		  	    <thead>
		  	      <tr>
		  	        <th width="2%">1. </th>
		  	        <th width="98%">Professional fee also includes translation service by Vista, document sending (max 3 times) by	  	            international courier..</th>
	  	          </tr>
		  	      <tr>
		  	        <td>2.</td>
		  	        <td>Professional fee does not include any fee required by the SCHOOL (application fee, deposits, housing,	  	            etc.).</td>
	  	          </tr>
		  	      <tr>
		  	        <td>3.</td>
		  	        <td>Professional fee does not include Visa Fee, tickets, Fiscal and airport taxes.</td>
	  	          </tr>
		  	      <tr>
		  	        <td>4.</td>
		  	        <td>Visa Fee is officially charged by the Embassy and is substitute to change at any time without prior notice.</td>
	  	          </tr>
		  	      <tr>
		  	        <td>5.</td>
		  	        <td>Professional fee does not include administrative fees charged by other parties, such as sworn translator,	  	            notary public, bank, local school, etc.</td>
	  	          </tr>
		  	      <tr>
		  	        <td>6.</td>
		  	        <td>Professional fee does not include PORTFOLIO SHIPPING HANDLING charged by the courier.</td>
	  	          </tr>
		  	      <tr>
		  	        <td>7.</td>
		  	        <td>In the case of refund, administration charge of 10% fee will occur</td>
	  	          </tr>
	  	        </thead>
  	    </table>
      </div>
      <!-- /.col -->
    </div>		
    <!-- /.row -->
<br>
    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
	<p class="lead">Consultant Name</p>
     
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%"><br>
              <strong><?php echo e($pic) ?></strong></th>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">Signature of Applicant/Guardian</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%"><strong><?php echo  e($nama) ?> <?php echo  e($middle_name) ?> <?php echo  e($family_name) ?></strong></th>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
