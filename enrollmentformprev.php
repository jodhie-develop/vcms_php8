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
$query_enroll = q_set($__p_query_enroll, "SELECT date_format(enroll_date,'%d %b %Y'),pic FROM ves_inc.tb_enrolled where kd_biodata = ? order by no desc limit 1", [(string) ($kode_student)]);
$result_twi=db_query_or_die("Wah error nih! 1", $query_enroll, $__p_query_enroll ?? []);
$no_urut_week ="1";	  
	while ($r_dtli = db_fetch($result_twi))
		{ 
		$tgl_enroll  = $r_dtli['0'];	
		$pic  = $r_dtli['1'];				
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
	//	$pic  = $row_biodata['34'];
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
		$nationality	 = $row_biodata['51'];
		$dob_lengkap = 		"$dob_dd-$dob_mm-$dob_yy"; 				
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
	$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kode_student)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
		while ($row_nik  =  db_fetch($resource_nik, PDO::FETCH_NUM))
			{
			$nik = $row_nik[0];
			}
		}	
?>

<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-size:xx-small;	
	}
-->
.style32 {
	color:#000;
	font-size:75%;
	}
-->
</style>
<table width="680" border="0" bgcolor="#FFFFFF" align="center">
  <tr>
    <td colspan="2" rowspan="3" align="center"><img src="pelem/vista-logo.png" width="120" height="66" /></td>
    <td colspan="2" rowspan="2" align="center"><strong>VISTA ENROLLMENT FORM<br />
    </strong></td>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left">Consultant : <strong><?php echo e($pic) ?></strong></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong><?php echo e($branch_nm) ?></strong></td>
    <td colspan="4" align="left">Enroll Date : <strong><?php echo e($tgl_enroll) ?></strong></td>
  </tr>
  <tr>
    <td height="9" colspan="8" align="center"><hr width="650"></td>
  </tr>
  <tr>
    <td width="3" height="40">&nbsp;</td>
    <td width="116" valign="bottom">Full Name    </td>
    <td width="101">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" valign="bottom">Gender</td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td colspan="3"><strong><?php echo  e($nama) ?> <?php echo  e($middle_name) ?> <?php echo  e($family_name) ?> <br>
    [<?php echo e($nik) ?>]</strong></td>
    <td colspan="4" valign="top"><strong><?php echo  e($gender) ?></strong></td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td colspan="2" valign="bottom">Date Of Birth </td>
    <td width="209" valign="bottom">Phone</td>
    <td colspan="4" valign="bottom">Handphone</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><?php echo  e($dob_lengkap) ?></strong></td>
    <td><strong><?php echo  e($hm_ph) ?></strong></td>
    <td colspan="4"><strong><?php echo  e($hp) ?></strong></td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td colspan="2" valign="bottom">Email</td>
    <td colspan="5" valign="bottom">Address</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" valign="top"><strong><?php echo  e($e_mail) ?></strong></td>
    <td colspan="5"><strong><?php echo  e($address) ?> <br>
    <?php echo  e($city) ?> <?php echo  e($nationality) ?></strong></td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td colspan="2" valign="bottom">Education</td>
    <td colspan="5" valign="bottom">Current/Previous School </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><?php echo  e($level_school) ?></strong></td>
    <td colspan="5"><strong><?php echo  e($org_school) ?> <?php echo  e($grade) ?></strong></td>
  </tr>
  <tr>
    <td height="37">&nbsp;</td>
    <td colspan="2" valign="bottom">Parent's Name </td>
    <td valign="bottom">Parent's Phone</td>
    <td colspan="4" valign="bottom">Company Name </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><?php echo  e($parent_nm) ?></strong></td>
    <td><strong><?php echo  e($hp_parent) ?></strong></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="205">&nbsp;</td>
    <td width="1">&nbsp;</td>
    <td width="11">&nbsp;</td>
    <td width="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><table width="648" border="0">
      <tr>
        <td colspan="6" bgcolor="#400000" align="center">&gt;<span class="style2"><strong>OVERSEAS STUDY PROGRAM </strong></span><span class="style2"></span></td>
        </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#400000"><span class="style2"><strong>School Name </strong></span><span class="style2"><strong>Program Study </strong></span><span class="style2"><strong>Country</strong></span><span class="style2"></span><span class="style2"><strong>Major</strong></span></td>
        <td bgcolor="#400000"width="94" align="center"><span class="style2"><strong>Intake Date </strong></span></td>
        <td bgcolor="#400000" width="146" align="center"><span class="style2"><strong>Proffesional Fee </strong></span></td>
        </tr>
      <?php 
		$query_enroll = q_set($__p_query_enroll, "SELECT left(sch_dest,75), prg_dest, country_dest, major_dest, date_format(intake_date,'%d %b %Y'), prof_fee,mid(sch_dest,76,150),non_refund FROM ves_inc.tb_enrolled where kd_biodata = ? order by no desc limit 1", [(string) ($kode_student)]);
		$result_twi=db_query_or_die("Wah error nih! 1", $query_enroll, $__p_query_enroll ?? []);
		$no_urut_week ="1";	  
			while ($r_dtli = db_fetch($result_twi))
				{ ?>
      
      <tr class="style32">
        <td colspan="4"><strong><?php echo e($r_dtli[0]); ?><br>
          <?php echo e($r_dtli[6]); ?><br>          
          (<?php echo e($r_dtli[2]); ?>)<br>
          <?php echo e($r_dtli[1]); ?> - <?php echo e($r_dtli[3]); ?><br>
          </strong><strong><br>
          </strong></td>
        <td valign="middle"><strong><?php echo e($r_dtli[4]); ?></strong></td>
        <td align="right" valign="middle"><strong><?php echo e(buatrp($r_dtli[5])); ?></strong><br>
(<?php echo e($r_dtli[7]) ?> )</td>
        </tr><?php } ?>
      <tr>
        <td width="95">&nbsp;</td>
        <td width="108">&nbsp;</td>
        <td width="97">&nbsp;</td>
        <td width="82">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="6" bgcolor="#400000"><div align="center"><span class="style2"><strong>RULES &amp; REGULATIONS REGARDING PROFESSIONAL FEE</strong></span></div></td>
        </tr>
      <tr>
        <td colspan="6"><ol><li> Professional fee is the amount of money paid according to those stated on professional fee details.</li>
          <li>The Professional fee is non-refundable, including when there is cancellation of application from the applicant for any reason and at any time.</li>
          <li>In the case a US Visa is rejected, we will refund 50% of the first school's professional fee, provided the applicant has been interviewed twice.</li>
          <li>The professional fee paid is valid only for the particular schools agreed at the time of payment. If there is an addition or change of schools later on, there will be additional charge.</li>
          </ol>		  </td>
        </tr>
      <tr>
        <td colspan="6" bgcolor="#400000"><span class="style2"><strong>RULES &amp; REGULATIONS REGARDING OTHER FEES</strong></span></td>
        </tr>
      <tr>
        <td colspan="6"><ol>
          <li>Professional fee also includes translation service by Vista, document sending (max 3 times) by international courier.</li>
          <li>Professional fee does not include any fee required by the SCHOOL (application fee, deposits, housing, etc.).</li>
          <li>Professional fee does not include Visa Fee, tickets, Fiscal and airport taxes.</li>
          <li>Visa Fee is officially charged by the Embassy and is substitute to change at any time without prior notice.</li>
          <li>Professional fee does not include administrative fees charged by other parties, such as sworn translator, notary public, bank, local school, etc.</li>
          <li>Professional fee does not include PORTFOLIO SHIPPING HANDLING charged by the courier.</li>
          <li>In the case of refund, administration charge of 10% fee will occur</li>
          </ol>        </td>
        </tr>
      <tr>
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3">Source Data :</td>
        <td>&nbsp;</td>
        <td colspan="2" align="center">Signature of Applicant/Guardian </td>
        </tr>
      <tr>
        <td colspan="4"><strong><?php echo  e($event_type) ?><br>
        </strong><strong><?php echo  e($event_type_dtl) ?></strong></td>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" align="center"><strong><?php echo  e($nama) ?> <?php echo  e($middle_name) ?> <?php echo  e($family_name) ?></strong></td>
        </tr>
    </table>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
    $content = ob_get_clean();
	$namafile = "enrollmentform.$kode_student.pdf";
    // convert in PDF
    require_once VCMS_ROOT . '/_lib/html2pdf.php';   // spipu/html2pdf 5.x (pengganti html2pdf/ lama)
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
 		$html2pdf->setTestTdInOnePage(false);		
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($namafile);
    }
    catch(HTML2PDF_exception $e) {
        html2pdf_fail($e);
    }
?>