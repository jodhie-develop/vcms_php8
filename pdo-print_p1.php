<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');
$st = in_val('st', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$no = in_val('no', 'get');
if (num($st) == 1)
	{
	$no = in_val('no', 'get');
	$query_pdo = q_set($__p_query_pdo, "SELECT kd_biodata, kd_branch, student_name, country, p_np, intake_date, pdo_date, enroll_date, nama, passport, referensi, gender, school_name,\r
school_address, cp1_school, cp1_position, cp2_school, cp2_position, school_group, school_website, cp1_email, cp1_phone, cp2_email, cp2_phone,\r
study_1, course_1, major_1, course1_length, course1_start, course1_end, tf1, tf1_paid, term_paid1, balance1, balance1_due_date,\r
study_2, course_2, major_2, course2_length, course2_start, course2_end, tf2, tf2_paid, term_paid2, balance2, balance2_due_date,\r
study_3, course_3, major_3, course3_length, course3_start, course3_end, tf3, tf3_paid, term_paid3, balance3, balance3_due_date,\r
study_4, course_4, major_4, course4_length, course4_start, course4_end, tf4, tf4_paid, term_paid4, balance4, balance4_due_date,\r
housing_type, housing_provider, housing_address, housing_rent_fee, housing_rent_fee_term, housing_rent_fee_paid, housing_paid_term, housing_cp,\r
housing_phone, housing_email, housing_notes,\r
test_type, test_date, test_time, test_venue, test_what_to_bring, test_notes,\r
orientation_date, orientation_time, orientation_venue, orientation_what_to_bring, orientation_agenda,\r
 event_name, event_date, event_time, event_venue, event_what_to_bring, event_notes,\r
  visa_number, visa_valid_from, visa_valid_through, visa_entry, visa_reference, visa_notes, visa_website,\r
  flight_airline, flight_code, flight_departure_from, flight_departure_date, flight_departure_time, flight_arival_at,\r
  flight_arival_date, flight_arival_time, flight_arival_note,guardian_provider,guardian_name,guardian_mail,guardian_phone,guardian_what_to_bring,guardian_notes,portal_user,portal_password,portal_url,portal_kjri,address_kjri,special_notes,orientation_date_start,orientation_date_end FROM ves_pdo where no = ?  ", [(string) ($no)]);
	$resource_pdo = db_query_or_die('errro_71', $query_pdo, $__p_query_pdo ?? []);
	while ($rpdo=  db_fetch($resource_pdo, PDO::FETCH_NUM))
		{
					$kd_biodata  = $rpdo['0'];	
		$kdb  = $rpdo['1'];	
		$nama  = $rpdo['2'];			
		$country = $rpdo['3'];
		$p_np = $rpdo['4'];
		$intake_date = $rpdo['5'];
		$pdo_date = $rpdo['6'];
		$enroll_date = $rpdo['7'];
		$nama = $rpdo['8'];
		$passport = $rpdo['9'];
		$referensi = $rpdo['10'];
		$gender = $rpdo['11'];
		$school_name = $rpdo['12'];
		$school_address = $rpdo['13'];
		$cp1_school = $rpdo['14'];
		$cp1_position = $rpdo['15'];
		$cp2_school = $rpdo['16'];
		$cp2_position = $rpdo['17'];
		$school_group = $rpdo['18'];
		$school_website = $rpdo['19'];
		$cp1_email = $rpdo['20'];
		$cp1_phone = $rpdo['21'];
		$cp2_email = $rpdo['22'];
		$cp2_phone = $rpdo['23'];
		$study_1 = $rpdo['24'];
		$course_1 = $rpdo['25'];
		$major_1 = $rpdo['26'];
		$course1_length = $rpdo['27'];
		$course1_start = $rpdo['28'];
		$course1_end = $rpdo['29'];
		$tf1 = $rpdo['30'];
		$tf1_paid = $rpdo['31'];
		$term_paid1 = $rpdo['32'];
		$balance1 = $rpdo['33'];
		$balance1_due_date = $rpdo['34'];
		$study_2 = $rpdo['35'];
		$course_2 = $rpdo['36'];
		$major_2 = $rpdo['37'];
		$course2_length = $rpdo['38'];
		$course2_start = $rpdo['39'];
		$course2_end = $rpdo['40'];
		$tf2 = $rpdo['41'];
		$tf2_paid = $rpdo['42'];
		$term_paid2 = $rpdo['43'];
		$balance2 = $rpdo['44'];
		$balance2_due_date = $rpdo['45'];
		$study_3 = $rpdo['46'];
		$course_3 = $rpdo['47'];
		$major_3 = $rpdo['48'];
		$course3_length = $rpdo['49'];
		$course3_start = $rpdo['50'];
		$course3_end = $rpdo['51'];
		$tf3 = $rpdo['52'];
		$tf3_paid = $rpdo['53'];
		$term_paid3 = $rpdo['54'];
		$balance3 = $rpdo['55'];
		$balance3_due_date = $rpdo['56'];
		$study_4 = $rpdo['57'];
		$course_4 = $rpdo['58'];
		$major_4 = $rpdo['59'];
		$course4_length = $rpdo['60'];
		$course4_start = $rpdo['61'];
		$course4_end = $rpdo['62'];
		$tf4 = $rpdo['63'];
		$tf4_paid = $rpdo['64'];
		$term_paid4 = $rpdo['65'];
		$balance4 = $rpdo['66'];
		$balance4_due_date = $rpdo['67'];
		$housing_type = $rpdo['68'];
		$housing_provider = $rpdo['69'];
		$housing_address = $rpdo['70'];
		$housing_rent_fee = $rpdo['71'];
		$housing_rent_fee_term = $rpdo['72'];
		$housing_rent_fee_paid = $rpdo['73'];
		$housing_paid_term = $rpdo['74'];
		$housing_cp = $rpdo['75'];
		$housing_phone = $rpdo['76'];
		$housing_email = $rpdo['77'];
		$housing_notes = $rpdo['78'];
		$test_type = $rpdo['79'];
		$test_date = $rpdo['80'];
		$test_time = $rpdo['81'];
		$test_venue = $rpdo['82'];
		$test_what_to_bring = $rpdo['83'];
		$test_notes = $rpdo['84'];
		$orientation_date = $rpdo['85'];
		$orientation_time = $rpdo['86'];
		$orientation_venue = $rpdo['87'];
		$orientation_what_to_bring = $rpdo['88'];
		$orientation_agenda = $rpdo['89'];
		$event_name = $rpdo['90'];
		$event_date = $rpdo['91'];
		$event_time = $rpdo['92'];
		$event_venue = $rpdo['93'];
		$event_what_to_bring = $rpdo['94'];
		$event_notes = $rpdo['95'];
		$visa_number = $rpdo['96'];
		$visa_valid_from = $rpdo['97'];
		$visa_valid_through = $rpdo['98'];
		$visa_entry = $rpdo['99'];
		$visa_reference = $rpdo['100'];
		$visa_notes = $rpdo['101'];
		$visa_website = $rpdo['102'];
		$flight_airline = $rpdo['103'];
		$flight_code = $rpdo['104'];
		$flight_departure_from = $rpdo['105'];
		$flight_departure_date = $rpdo['106'];
		$flight_departure_time = $rpdo['107'];
		$flight_arival_at = $rpdo['108'];
		$flight_arival_date = $rpdo['109'];
		$flight_arival_time = $rpdo['110'];
		$flight_arival_note = $rpdo['111'];
		$guardian_provider = $rpdo['112'];
		$guardian_name = $rpdo['113'];
		$guardian_mail = $rpdo['114'];
		$guardian_phone = $rpdo['115'];
		$guardian_what_to_bring = $rpdo['116'];
		$guardian_notes = $rpdo['117'];
		$portal_user = $rpdo['118'];
		$portal_password = $rpdo['119'];
		$portal_url = $rpdo['120'];
		$kjri_url = $rpdo['121'];
		$kjri_address = $rpdo['122'];
		$special_note = $rpdo['123'];	
		$orientation_date_start = $rpdo['124'];
		$orientation_date_start = $rpdo['125'];			
		$st = 0;
		}
	}


//
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
  <link rel="stylesheet" href="cdnjs/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="cdnjs/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <link rel="stylesheet" href="css/cetakk.css">  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
.tabi {position:absolute;left:140px; }
}
<style>p.indent{ padding-left: 1.8em }
.borderless table {
    border-top-style: none;
    border-left-style: none;
    border-right-style: none;
    border-bottom-style: none;
}
.hurup {
    font-size: 11px;
}  

</style>
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-6">
        
          <div class="box-body">
	
</div>
      <table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td width=16% height="14" align=left  class="hurup" ><img src="imgs/vista-logo.png"  alt="" width="75" height="40"/></td>
	            <td width=84% align=center ><h5>PRE-DEPARTURE ORIENTATION FORM</h5></td>
              </tr>
				    </thead>
            <tfoot>
            </tfoot>
          </table>
      </div>
      <div class="col-xs-6">
        <div class="box-body">
<table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td width=4% height="14" align=left  class="hurup" >Country</td>
	            <td width=5% align=left  class="hurup"><?php echo e($country) ?> ( <?php echo e($p_np) ?> )</td>
              </tr>
            	   
	          <tr>
	            <td height="14" align=left  class="hurup">Intake Date</td>
	            <td align=left  class="hurup"><?php echo e($intake_date)  ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup">PDO Date</td>
	            <td align=left  class="hurup"><?php echo e($pdo_date)  ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup">Enroll Date</td>
	            <td align=left  class="hurup"><?php echo e($enroll_date)  ?></td>
              </tr>
				    </thead>
            <tfoot>
            </tfoot>
          </table>        	
        </div>
      </div>
      <hr>
	  </div>      
	  <div class="row">  
      <div class="col-xs-12">
       	<div class=box-body>
<table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td width=17% height="14" align=left  class="hurup" >Branch Address:</td>
	            <td width=83% align=left  class="hurup"><?php echo e($country) ?></td>
              </tr>
            	   
	          <tr>
	            <td height="14" align=left  class="hurup">Phone #:</td>
	            <td align=left  class="hurup"><?php echo e($country) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup">Consultant 1:</td>
	            <td align=left  class="hurup"><?php echo e($country) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup">Consultant 2:</td>
	            <td align=left  class="hurup"><?php echo e($country) ?></td>
              </tr>
				    </thead>
            <tfoot>
            </tfoot>
          </table>   	
		</div>
      </div>
      </div>   
    <div class="row">
      <div class="col-xs-6">
       	<div class=box-body>
<table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td height="14" colspan="2" align=left valign="top"  class="hurup" ><strong>STUDENT INFORMATION</strong></td>
              </tr>
	          <tr>
	            <td width=25% height="14" align=left  class="hurup" valign="top" >Student FULL Name</td>
	            <td width=75% align=left  class="hurup"><?php echo e($nama)  ?></td>
              </tr>
            	   
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Phone #:</td>
	            <td align=left  class="hurup" valign="top" >&nbsp;</td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Passport #</td>
	            <td align=left  class="hurup" valign="top" >&nbsp;</td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Date of Birth</td>
	            <td align=left  class="hurup" valign="top" >&nbsp;</td>
              </tr>
	      </thead>
            <tfoot>
            </tfoot>
          </table>   	
		</div>
      </div>
      <div class="col-xs-6">
        <div class=box-body>
          <table width="100%" class="borderless" id="example2">
            <thead>
              <tr>
                <td height="14" colspan="2" align=left valign="top"  class="hurup" >&nbsp;</td>
              </tr>
              <tr>
                <td width=25% height="14" align=left  class="hurup" valign="top" >Student ID #</td>
                <td width=75% align=left  class="hurup"><?php echo e($kd_biodata)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Other Ref. #</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($referensi)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Gender</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($gender)  ?></td>
              </tr>
            </thead>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div>            
     <div class="row">
      <div class="col-xs-6">
       	<div class=box-body>
<table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td height="14" colspan="2" align=left valign="top"  class="hurup" ><strong>SCHOOL &amp; CONTACT INFORMATION</strong></td>
              </tr>
	          <tr>
	            <td width=25% height="14" align=left  class="hurup" valign="top" >School Name/ Campus Name</td>
	            <td width=75% align=left  class="hurup"><?php echo e($school_name)  ?></td>
              </tr>
            	   
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Address</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($school_address)  ?></td>
              </tr>
	      </thead>
            <tfoot>
            </tfoot>
          </table>   	
		</div>
      </div>
      <div class="col-xs-6">
        <div class=box-body>
          <table width="100%" class="borderless" id="example2">
            <thead>
              <tr>
                <td height="14" colspan="2" align=left valign="top"  class="hurup" >&nbsp;</td>
              </tr>
              <tr>
                <td width=25% height="14" align=left  class="hurup" valign="top" >School Group <br>
                (if any)</td>
                <td width=75% align=left  class="hurup" valign="top"><?php echo e($school_group)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Website</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($school_website)  ?></td>
              </tr>
            </thead>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div>       
     <div class="row">
      <div class="col-xs-6">
       	<div class=box-body>
<table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td width=25% height="14" align=left  class="hurup" valign="top" >Contact Person Name (1)</td>
	            <td width=75% align=left  class="hurup"><?php echo e($cp1_school)  ?></td>
              </tr>
            	   
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Position</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($cp1_position)  ?></td>
              </tr>
	      </thead>
            <tfoot>
            </tfoot>
          </table>   	
		</div>
      </div>
      <div class="col-xs-6">
        <div class=box-body>
          <table width="100%" class="borderless" id="example2">
            <thead>
              <tr>
                <td width=25% height="14" align=left  class="hurup" valign="top" >Email Address</td>
                <td width=75% align=left  class="hurup"><?php echo e($cp1_email)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Phone #</td>
                <td align=left  class="hurup"><?php echo e($cp1_phone)  ?></td>
              </tr>
            </thead>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
     <div class="row">
       <div class="col-xs-6">
         <div class=box-body>
           <table width="100%" class="borderless" id="example3">
             <thead>
               <tr>
                 <td width=25% height="14" align=left  class="hurup" valign="top" >Contact Person Name (2)</td>
                 <td width=75% align=left  class="hurup"><?php echo e($cp2_school)  ?></td>
               </tr>
               <tr>
                 <td height="14" align=left  class="hurup" valign="top" >Position</td>
                 <td align=left  class="hurup" valign="top" ><?php echo e($cp2_position)  ?></td>
               </tr>
             </thead>
             <tfoot>
             </tfoot>
           </table>
         </div>
       </div>
       <div class="col-xs-6">
         <div class=box-body>
           <table width="100%" class="borderless" id="example4">
             <thead>
               <tr>
                 <td width=25% height="14" align=left  class="hurup" valign="top" >Email Address</td>
                 <td width=75% align=left  class="hurup"><?php echo e($cp2_email)  ?></td>
               </tr>
               <tr>
                 <td height="14" align=left  class="hurup" valign="top" >Phone #</td>
                 <td align=left  class="hurup"><?php echo e($cp2_phone)  ?></td>
               </tr>
             </thead>
             <tfoot>
             </tfoot>
           </table>
         </div>
       </div>
     </div>  
     <div class="row">
      <div class="col-xs-6">
       	<div class=box-body>
<table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td height="14" colspan="2" align=left valign="top"  class="hurup" ><strong>COURSE, MAJOR & TUITION FEE INFORMATION</strong></td>
              </tr>
	          <tr>
	            <td width=25% height="14" align=left  class="hurup" valign="top" ><table cellspacing="0" cellpadding="0">
  <td width="96">1st Level    Study</td>
                </table></td>
	            <td width=75% align=left  class="hurup"><?php echo e($study_1)  ?></td>
              </tr>
            	   
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Course Name</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($course_1)  ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Major</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($major_1)  ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Course Length</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($course1_length)  ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Start-End Date</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($course1_start)  ?> To <?php echo e($course1_end)  ?></td>
              </tr>
          </thead>
            <tfoot>
            </tfoot>
          </table>   	
		</div>
      </div>
      <div class="col-xs-6">
        <div class=box-body>
          <table width="100%" class="borderless" id="example2">
            <thead>
              <tr>
                <td height="14" colspan="2" align=left valign="top"  class="hurup" >&nbsp;</td>
              </tr>
              <tr>
                <td width=25% height="14" align=left  class="hurup" valign="top" >Full Prog Tuition</td>
                <td width=75% align=left  class="hurup"><?php echo e($tf1)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Tuition Fee PAID</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($tf1_paid)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >OSHC </td>
                <td align=left  class="hurup" valign="top" >&nbsp;</td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Balance Fee</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($balance1)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Balance Due Date</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($balance1_due_date)  ?></td>
              </tr>
            </thead>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div>          
     <div class="row">
      <div class="col-xs-6">
       	<div class=box-body>
<table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td width=25% height="14" align=left  class="hurup" valign="top" ><table cellspacing="0" cellpadding="0">
    <td width="96">2nd Level    Study</td>
                </table></td>
	            <td width=75% align=left  class="hurup"><?php echo e($study_2)  ?></td>
              </tr>
            	   
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Course Name</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($course_2)  ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Major</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($major_2)  ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Course Length</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($course2_length)  ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Start-End Date</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($course2_start)   ?> To <?php echo e($course2_end)  ?></td>
              </tr>
          </thead>
            <tfoot>
            </tfoot>
          </table>   	
		</div>
      </div>
      <div class="col-xs-6">
        <div class=box-body>
          <table width="100%" class="borderless" id="example2">
            <thead>
              <tr>
                <td width=25% height="14" align=left  class="hurup" valign="top" >Full Prog Tuition</td>
                <td width=75% align=left  class="hurup"><?php echo e($tf2)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Tuition Fee PAID</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($tf2_paid)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >OSHC </td>
                <td align=left  class="hurup" valign="top" ><?php echo e($term_paid2)  ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Balance Fee</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Balance Due Date</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
            </thead>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div> 
<div class="row">
      <div class="col-xs-6">
       	<div class=box-body>
<table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td width=25% height="14" align=left  class="hurup" valign="top" ><table cellspacing="0" cellpadding="0">
      <td width="96">3rd Level    Study</td>
                </table></td>
	            <td width=75% align=left  class="hurup"><?php echo e($country) ?></td>
              </tr>
            	   
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Course Name</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Major</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Course Length</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Start-End Date</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($country) ?> To <?php echo e($country) ?></td>
              </tr>
          </thead>
            <tfoot>
            </tfoot>
          </table>   	
		</div>
      </div>
      <div class="col-xs-6">
        <div class=box-body>
          <table width="100%" class="borderless" id="example2">
            <thead>
              <tr>
                <td width=25% height="14" align=left  class="hurup" valign="top" >Full Prog Tuition</td>
                <td width=75% align=left  class="hurup"><?php echo e($country) ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Tuition Fee PAID</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >OSHC </td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Balance Fee</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Balance Due Date</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
            </thead>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div> 
<div class="row">
      <div class="col-xs-6">
       	<div class=box-body>
<table width="100%" class="borderless" id="example1">
	        <thead>
	          <tr>
	            <td width=25% height="14" align=left  class="hurup" valign="top" ><table cellspacing="0" cellpadding="0">
        <td width="96">4th Level    Study</td>
                </table></td>
	            <td width=75% align=left  class="hurup"><?php echo e($country) ?></td>
              </tr>
            	   
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Course Name</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Major</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Course Length</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left  class="hurup" valign="top" >Start-End Date</td>
	            <td align=left  class="hurup" valign="top" ><?php echo e($country) ?> To <?php echo e($country) ?></td>
              </tr>
          </thead>
            <tfoot>
            </tfoot>
          </table>   	
		</div>
      </div>
      <div class="col-xs-6">
        <div class=box-body>
          <table width="100%" class="borderless" id="example2">
            <thead>
              <tr>
                <td width=25% height="14" align=left  class="hurup" valign="top" >Full Prog Tuition</td>
                <td width=75% align=left  class="hurup"><?php echo e($country) ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Tuition Fee PAID</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >OSHC </td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Balance Fee</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
              <tr>
                <td height="14" align=left  class="hurup" valign="top" >Balance Due Date</td>
                <td align=left  class="hurup" valign="top" ><?php echo e($country) ?></td>
              </tr>
            </thead>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div>                 

  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
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
