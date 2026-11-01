<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
 include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
$thn_period = in_val('thn_period', 'get');
if ($thn_period==''){$thn_period='2026';}

$thn = $thn_period;

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_cbg = in_val('kd_cbg', 'get');

if ($kd_cbg == '--ALL--' or $kd_cbg == ''  ){$kd_cbg = 00;}
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'HO'){$kd_cbg = 0;}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 14;}
if (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif (num($kd_cbg) ==0){$cabang = 'HO';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}
elseif (num($kd_cbg) == 00 ){$cabang = '--ALL--';}
elseif (num($kd_cbg) == 15){$kd_cbg = 'CA';}
elseif (num($kd_cbg) == 16){$kd_cbg = 'Tangerang';}
$filter_cbg_sales = q_set($__p_filter_cbg_sales, " and kd_cabang = ?  ", [(string) ($kd_cbg)]);
$filter_cbg_admission = q_set($__p_filter_cbg_admission, " and kd_branch = ?  ", [(string) ($kd_cbg)]);
if (num($kd_cbg) == 00 ){$filter_cbg_sales = q_set($__p_filter_cbg_sales, " and (kd_cabang = 1 or  kd_cabang = 2 or  kd_cabang = 3 or  kd_cabang = 4 or  kd_cabang = 5 or  kd_cabang = 6 or  kd_cabang = 7 or  kd_cabang = 8 or  kd_cabang = 11 or  kd_cabang = 12 ) ");$filter_cbg_admission = q_set($__p_filter_cbg_admission, " and (kd_branch = 1 or  kd_branch = 2 or  kd_branch = 3 or  kd_branch = 4 or  kd_branch = 5 or  kd_branch = 6 or  kd_branch = 7 or  kd_branch = 8 or  kd_branch = 11 or  kd_branch = 12 or  kd_branch = 14 ) ");}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
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
 <form method=get action=monitoring.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>SITUATION ROOM</h1>
    <table width="493" border="0">
      <tbody>
        <tr>
          <td width="149">Enroll</td>
          <td width="334"><small><span class="form-group">
            <select name="thn_period"  onChange="this.form.submit()"   class="style33" id="kd_cbg">
              <option value="2026">2026</option>				
				
              <option value="2025">2025</option>				
              <option value="2024">2024</option>				
              <option value="2023">2023</option>				
              <option value="2022">2022</option>
              <option value="2021">2021</option>
              <option value="2020">2020</option>
              
              <option selected="selected"><?php echo e($thn_period) ?></option>
            </select>
          </span></small></td>
        </tr>
        <tr>
          <td>Center</td>
          <td><small><span class="form-group">
            <select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
              <option value="00">--ALL--</option>
			<option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="8">Malang TBI</option>
              <option value="11">PIK</option>              
              <option value="12">Serpong</option>   
              <option value="14">Medan</option>  					
              <option value="0">HO</option> 
              <option value="15">CA</option> 
              <option value="16">Tangerang</option> 
				
              <option selected="<?php echo e($kd_cbg) ?>"><?php echo e($cabang) ?></option>
            </select>
          </span></small></td>
        </tr>
      </tbody>
    </table>
    <h1><br>
    </h1>
  </section>
  <!-- Main content -->
<?php //if($kd_cbg ==''){die;} ?>	  
    <section class="content">
      <div class="row">
            <div class="col-md-12">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">TOP VOS SALES</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                        <?php
$query= q_set($__p_query, "SELECT a.pic, count(kd_biodata) as jml FROM tb_sales_report a left join tb_master_partner b on a.kd_school = b.kd_school where  date_format(enroll_date,'%Y') = ? and status = 'OK' and prioritas = 1 " . $filter_cbg_sales . " " . ($query_bln ?? '') . " group by pic order by jml desc limit 4", [(string) ($thn), ...($__p_filter_cbg_sales ?? [])]);	

$resource = db_query_or_die('error_1', $query, $__p_query ?? []);
if(num(db_num_rows($resource)) > 0)
	{
	$nomor = 1;
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{

?>					  
                    <li>
                      <img src="gbstaff/profileformR.png" alt="User Image">
                      <a class="users-list-name" href="#"><?php echo e($row[0]) ?></a>
                      <span class="users-list-date"><strong><?php echo e($row[1]) ?> PAX</strong></span>
                    </li>
<?php                    }} ?>
					  
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>		  
        <div class="col-md-12">
          <!-- /.box -->

          <div class="box">
		  
            <!-- /.box-header -->
 
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-12">
		<div class="form-group">
		  <label>VOS Sales </label><br>
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td width=7% align=center >&nbsp;</td>
	            <td width=7% align=center >Jan</a></td>
	            <td width=7% height="14" align=center >Feb</td>
	            <td width="7%" align=center >Mar</td>
	            <td width="7%" align=center >Apr</td>
	            <td width="7%" align=center >May</td>
	            <td width="7%" align=center >Jun</td>
	            <td width="7%" align=center >Jul</td>
	            <td width="7%" align=center >Aug</td>
	            <td width="7%" align=center >Sep</td>
	            <td width="7%" align=center >Oct</td>
	            <td width="7%" align=center >Nop</td>
	            <td width="7%" align=center >Dec</td>
	            <td width="10%" align=center >TOTAL</td>
              </tr>
            </thead>
	        <?php 
//===jika ada billing
	$query_ves_brutto = q_set($__p_query_ves_brutto, "select \r
sum(case when  date_format(enroll_date,'%m') = '01' then 1 end )as bln_1,\r
sum(case when  date_format(enroll_date,'%m') = '02' then 1 end )as bln_2,\r
sum(case when  date_format(enroll_date,'%m') = '03' then 1 end )as bln_3,\r
sum(case when  date_format(enroll_date,'%m') = '04' then 1 end )as bln_4,\r
sum(case when  date_format(enroll_date,'%m') = '05' then 1 end )as bln_5,\r
sum(case when  date_format(enroll_date,'%m') = '06' then 1 end )as bln_6,\r
sum(case when  date_format(enroll_date,'%m') = '07' then 1 end )as bln_7,\r
sum(case when  date_format(enroll_date,'%m') = '08' then 1 end )as bln_8,\r
sum(case when  date_format(enroll_date,'%m') = '09' then 1 end )as bln_9,\r
sum(case when  date_format(enroll_date,'%m') = '10' then 1 end )as bln_10,\r
sum(case when  date_format(enroll_date,'%m') = '11' then 1 end )as bln_11,\r
sum(case when  date_format(enroll_date,'%m') = '12' then 1 end )as bln_12\r
from tb_sales_report where date_format(enroll_date,'%Y') = ? and status = 'OK' and prioritas = 1 " . $filter_cbg_sales, [(string) ($thn_period), ...($__p_filter_cbg_sales ?? [])]);	   
$resource_ves = db_query_soft($query_ves_brutto, $__p_query_ves_brutto ?? []);
$keluar_ves = db_num_rows($resource_ves);
if(num(db_num_rows($resource_ves)) > 0)
	{
	while ($row_ves  =  db_fetch($resource_ves, PDO::FETCH_NUM))
		{	
		$ves_jan = $row_ves[0];
		$ves_feb = $row_ves[1];
		$ves_mar = $row_ves[2];
		$ves_apr = $row_ves[3];
		$ves_may = $row_ves[4];
		$ves_jun = $row_ves[5];
		$ves_jul = $row_ves[6];
		$ves_aug = $row_ves[7];
		$ves_sep = $row_ves[8];
		$ves_oct = $row_ves[9];
		$ves_nop = $row_ves[10];
		$ves_des = $row_ves[11];
		$ves_total = (num($row_ves[0])+num($row_ves[1])+num($row_ves[2])+num($row_ves[3])+num($row_ves[4])+num($row_ves[5])+num($row_ves[6])+num($row_ves[7])+num($row_ves[8])+num($row_ves[9])+num($row_ves[10])+num($row_ves[11]));
					   ?>
	        <tbody>
	          <tr>
	            <td align=center class="style24">Brutto</td>
				  <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[0]) ?></a></td>
	            <td height="14" align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[1]) ?></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[2]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[3]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[4]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[5]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[6]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[7]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[8]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[9]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[10]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[11]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=1&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($ves_total) ?></a></td>
              </tr>
	          <?php 	} }  

	$query_ves_cancel = q_set($__p_query_ves_cancel, "select\r
sum(case when  date_format(enroll_date,'%m') = '01' then 1 end )as bln_1,\r
sum(case when  date_format(enroll_date,'%m') = '02' then 1 end )as bln_2,\r
sum(case when  date_format(enroll_date,'%m') = '03' then 1 end )as bln_3,\r
sum(case when  date_format(enroll_date,'%m') = '04' then 1 end )as bln_4,\r
sum(case when  date_format(enroll_date,'%m') = '05' then 1 end )as bln_5,\r
sum(case when  date_format(enroll_date,'%m') = '06' then 1 end )as bln_6,\r
sum(case when  date_format(enroll_date,'%m') = '07' then 1 end )as bln_7,\r
sum(case when  date_format(enroll_date,'%m') = '08' then 1 end )as bln_8,\r
sum(case when  date_format(enroll_date,'%m') = '09' then 1 end )as bln_9,\r
sum(case when  date_format(enroll_date,'%m') = '10' then 1 end )as bln_10,\r
sum(case when  date_format(enroll_date,'%m') = '11' then 1 end )as bln_11,\r
sum(case when  date_format(enroll_date,'%m') = '12' then 1 end )as bln_12\r
from adm_stu_progress where date_format(enroll_date,'%Y') = ? and date_format(update_date,'%Y') >= ? and final_status = 'C' and aktif = 1 " . $filter_cbg_admission, [(string) ($thn_period), (string) ($thn_period), ...($__p_filter_cbg_admission ?? [])]);
	   
$resource_ves_cancel = db_query_soft($query_ves_cancel, $__p_query_ves_cancel ?? []);
$keluar_ves_cancel = db_num_rows($resource_ves_cancel);
if(num(db_num_rows($resource_ves_cancel)) > 0)
	{
	while ($row_ves_cancel  =  db_fetch($resource_ves_cancel, PDO::FETCH_NUM))
		{			  
		$row_ves_cancel_current_jan = $row_ves_cancel[0];
		$row_ves_cancel_current_feb = $row_ves_cancel[1];
		$row_ves_cancel_current_mar = $row_ves_cancel[2];
		$row_ves_cancel_current_apr = $row_ves_cancel[3];
		$row_ves_cancel_current_may = $row_ves_cancel[4];
		$row_ves_cancel_current_jun = $row_ves_cancel[5];
		$row_ves_cancel_current_jul = $row_ves_cancel[6];
		$row_ves_cancel_current_aug = $row_ves_cancel[7];
		$row_ves_cancel_current_sep = $row_ves_cancel[8];
		$row_ves_cancel_current_oct = $row_ves_cancel[9];
		$row_ves_cancel_current_nop = $row_ves_cancel[10];
		$row_ves_cancel_current_dec = $row_ves_cancel[11];
		$row_ves_cancel_current_total = (num($row_ves_cancel[0])+num($row_ves_cancel[1])+num($row_ves_cancel[2])+num($row_ves_cancel[3])+num($row_ves_cancel[4])+num($row_ves_cancel[5])+num($row_ves_cancel[6])+num($row_ves_cancel[7])+num($row_ves_cancel[8])+num($row_ves_cancel[9])+num($row_ves_cancel[10])+num($row_ves_cancel[11]));
		
					   ?>				
	          <tr>
	            <td align=center bgcolor="#FCA6A7" class="style24"><strong>Cancel</strong></td>
	             <td align=center bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[0]) ?></a></td>
	            <td height="14" align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[1]) ?></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[2]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[3]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[4]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[5]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[6]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[7]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[8]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[9]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[10]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel[11]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=2&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current_total) ?></a></td>
              </tr>
	          <tr>
	            <td align=center  class="style24"><strong>Netto</strong></td>
	            <td align=center  class="style24"><?php echo e((num($ves_jan) -  num($row_ves_cancel[0]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_feb) -  num($row_ves_cancel[1]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_mar) -  num($row_ves_cancel[2]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_apr) -  num($row_ves_cancel[3]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_may) -  num($row_ves_cancel[4]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_jun) -  num($row_ves_cancel[5]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_jul) -  num($row_ves_cancel[6]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_aug) -  num($row_ves_cancel[7]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_sep) -  num($row_ves_cancel[8]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_oct) -  num($row_ves_cancel[9]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_nop) -  num($row_ves_cancel[10]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_des) -  num($row_ves_cancel[11]))) ?></td>
	            <td align=center  class="style24"><?php echo e((num($ves_total) -  num($row_ves_cancel_current_total))) ?></td>
              </tr>
<?php } }  ?>
            </tbody>
	        <tfoot>
            </tfoot>
          </table>
	    </div>
            <!-- /.box-body -->
      </div>
          <!-- /.box -->
    </div>
        <!-- /.col -->
  </div>
<div class="box box-warning">
  <div class="box-body">
    <div class="col-md-8">
      <div class="form-group">
        <label>VOS Cancel </label>
        <br>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <table width="100%" class="table table-bordered table-striped" id="example3">
          <thead>
            <tr>
              <td width=7% align=center >&nbsp;</td>
              <td width=7% align=center >Jan</td>
              <td width=7% height="14" align=center >Feb</td>
              <td width="7%" align=center >Mar</td>
              <td width="7%" align=center >Apr</td>
              <td width="7%" align=center >May</td>
              <td width="7%" align=center >Jun</td>
              <td width="7%" align=center >Jul</td>
              <td width="7%" align=center >Aug</td>
              <td width="7%" align=center >Sep</td>
              <td width="7%" align=center >Oct</td>
              <td width="7%" align=center >Nov</td>
              <td width="7%" align=center >Dec</td>
              <td width="10%" align=center >TOTAL</td>
            </tr>
          </thead>
          <?php 
//===jika ada billing

$query_ves_cancel_current = q_set($__p_query_ves_cancel_current, "select\r
sum(case when  date_format(update_date,'%m') = '01' then 1 end )as bln_1,\r
sum(case when  date_format(update_date,'%m') = '02' then 1 end )as bln_2,\r
sum(case when  date_format(update_date,'%m') = '03' then 1 end )as bln_3,\r
sum(case when  date_format(update_date,'%m') = '04' then 1 end )as bln_4,\r
sum(case when  date_format(update_date,'%m') = '05' then 1 end )as bln_5,\r
sum(case when  date_format(update_date,'%m') = '06' then 1 end )as bln_6,\r
sum(case when  date_format(update_date,'%m') = '07' then 1 end )as bln_7,\r
sum(case when  date_format(update_date,'%m') = '08' then 1 end )as bln_8,\r
sum(case when  date_format(update_date,'%m') = '09' then 1 end )as bln_9,\r
sum(case when  date_format(update_date,'%m') = '10' then 1 end )as bln_10,\r
sum(case when  date_format(update_date,'%m') = '11' then 1 end )as bln_11,\r
sum(case when  date_format(update_date,'%m') = '12' then 1 end )as bln_12\r
from adm_stu_progress where date_format(enroll_date,'%Y') = ? and date_format(update_date,'%Y') >= ? and final_status = 'C' and aktif = 1 " . $filter_cbg_admission, [(string) ($thn_period), (string) ($thn_period), ...($__p_filter_cbg_admission ?? [])]);			
		   
$resource_ves_cancel_current = db_query_soft($query_ves_cancel_current, $__p_query_ves_cancel_current ?? []);
$keluar_ves = db_num_rows($resource_ves_cancel_current);
if(num(db_num_rows($resource_ves_cancel_current)) > 0)
	{
	while ($row_ves_cancel_current  =  db_fetch($resource_ves_cancel_current, PDO::FETCH_NUM))
		{	
		$ves_current_cancel_jan = $row_ves_cancel_current[0];
		$ves_current_cancel_feb = $row_ves_cancel_current[1];
		$ves_current_cancel_mar = $row_ves_cancel_current[2];
		$ves_current_cancel_apr = $row_ves_cancel_current[3];
		$ves_current_cancel_may = $row_ves_cancel_current[4];
		$ves_current_cancel_jun = $row_ves_cancel_current[5];
		$ves_current_cancel_jul = $row_ves_cancel_current[6];
		$ves_current_cancel_aug = $row_ves_cancel_current[7];
		$ves_current_cancel_sep = $row_ves_cancel_current[8];
		$ves_current_cancel_oct = $row_ves_cancel_current[9];
		$ves_current_cancel_nop = $row_ves_cancel_current[10];
		$ves_current_cancel_des = $row_ves_cancel_current[11];
		$ves_current_cancel_total = (num($row_ves_cancel_current[0])+num($row_ves_cancel_current[1])+num($row_ves_cancel_current[2])+num($row_ves_cancel_current[3])+num($row_ves_cancel_current[4])+num($row_ves_cancel_current[5])+num($row_ves_cancel_current[6])+num($row_ves_cancel_current[7])+num($row_ves_cancel_current[8])+num($row_ves_cancel_current[9])+num($row_ves_cancel_current[10])+num($row_ves_cancel_current[11])) ;
					   ?>
          <tbody>
            <tr>
              <td align=center class="style24">Current</td>
               <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[0]) ?></a></td>
	            <td height="14" align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[1]) ?></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[2]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[3]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[4]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[5]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[6]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[7]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[8]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[9]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[10]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current[11]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=3&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_current_total) ?></a></td>
            </tr>
            <?php 	} }  

$query_ves_cancel_previous = q_set($__p_query_ves_cancel_previous, "select\r
sum(case when  date_format(update_date,'%m') = '01' then 1 end )as bln_1,\r
sum(case when  date_format(update_date,'%m') = '02' then 1 end )as bln_2,\r
sum(case when  date_format(update_date,'%m') = '03' then 1 end )as bln_3,\r
sum(case when  date_format(update_date,'%m') = '04' then 1 end )as bln_4,\r
sum(case when  date_format(update_date,'%m') = '05' then 1 end )as bln_5,\r
sum(case when  date_format(update_date,'%m') = '06' then 1 end )as bln_6,\r
sum(case when  date_format(update_date,'%m') = '07' then 1 end )as bln_7,\r
sum(case when  date_format(update_date,'%m') = '08' then 1 end )as bln_8,\r
sum(case when  date_format(update_date,'%m') = '09' then 1 end )as bln_9,\r
sum(case when  date_format(update_date,'%m') = '10' then 1 end )as bln_10,\r
sum(case when  date_format(update_date,'%m') = '11' then 1 end )as bln_11,\r
sum(case when  date_format(update_date,'%m') = '12' then 1 end )as bln_12\r
from adm_stu_progress where date_format(enroll_date,'%Y') < ? and date_format(update_date,'%Y') >= ? and final_status = 'C' and aktif = 1 " . $filter_cbg_admission, [(string) ($thn_period), (string) ($thn_period), ...($__p_filter_cbg_admission ?? [])]);	

$resource_ves_cancel_previous = db_query_soft($query_ves_cancel_previous, $__p_query_ves_cancel_previous ?? []);
$keluar_ves = db_num_rows($resource_ves_cancel_previous);
if(num(db_num_rows($resource_ves_cancel_previous)) > 0)
	{
	while ($row_ves_cancel_previous  =  db_fetch($resource_ves_cancel_previous, PDO::FETCH_NUM))
		{	
		$ves_previous_cancel_jan = $row_ves_cancel_previous[0];
		$ves_previous_cancel_feb = $row_ves_cancel_previous[1];
		$ves_previous_cancel_mar = $row_ves_cancel_previous[2];
		$ves_previous_cancel_apr = $row_ves_cancel_previous[3];
		$ves_previous_cancel_may = $row_ves_cancel_previous[4];
		$ves_previous_cancel_jun = $row_ves_cancel_previous[5];
		$ves_previous_cancel_jul = $row_ves_cancel_previous[6];
		$ves_previous_cancel_aug = $row_ves_cancel_previous[7];
		$ves_previous_cancel_sep = $row_ves_cancel_previous[8];
		$ves_previous_cancel_oct = $row_ves_cancel_previous[9];
		$ves_previous_cancel_nop = $row_ves_cancel_previous[10];
		$ves_previous_cancel_des = $row_ves_cancel_previous[11];
		$ves_previous_cancel_total = (num($row_ves_cancel_previous[0])+num($row_ves_cancel_previous[1])+num($row_ves_cancel_previous[2])+num($row_ves_cancel_previous[3])+num($row_ves_cancel_previous[4])+num($row_ves_cancel_previous[5])+num($row_ves_cancel_previous[6])+num($row_ves_cancel_previous[7])+num($row_ves_cancel_previous[8])+num($row_ves_cancel_previous[9])+num($row_ves_cancel_previous[10])+num($row_ves_cancel_previous	[11]));
					  
		
					   ?>
            <tr>
              <td align=center bgcolor="#FCA6A7" class="style24"><strong>Previous</strong></td>
              <td align=center bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[0]) ?></a></td>
	            <td height="14" align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[1]) ?></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[2]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[3]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[4]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[5]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[6]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[7]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[8]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[9]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[10]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_cancel_previous[11]) ?></a></td>
	            <td align=center  bgcolor="#FCA6A7" class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=4&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($ves_previous_cancel_total) ?></a></td>
            </tr>
			  <?php } } ?>
            <tr>
              <td align=center  class="style24"><strong>Total</strong></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_jan) +  num($ves_previous_cancel_jan))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_feb) +  num($ves_previous_cancel_feb))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_mar) +  num($ves_previous_cancel_mar))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_apr) +  num($ves_previous_cancel_apr))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_may) + num($ves_previous_cancel_may))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_jun) +  num($ves_previous_cancel_jun))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_jul) +  num($ves_previous_cancel_jul))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_aug) +  num($ves_previous_cancel_aug))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_sep) +  num($ves_previous_cancel_sep))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_oct) +  num($ves_previous_cancel_oct))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_nop) +  num($ves_previous_cancel_nop))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_des) +  num($ves_previous_cancel_des))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_current_cancel_total) +  num($ves_previous_cancel_total))) ?></td>
            </tr>
      
          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<div class="box box-warning">
  <div class="box-body">
    <div class="col-md-8">
      <div class="form-group">
        <label>VOS Leaving </label>
        <br>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <table width="100%" class="table table-bordered table-striped" id="example">
          <thead>
            <tr>
              <td width=7% align=center >&nbsp;</td>
              <td width=7% align=center >Jan</td>
              <td width=7% height="14" align=center >Feb</td>
              <td width="7%" align=center >Mar</td>
              <td width="7%" align=center >Apr</td>
              <td width="7%" align=center >May</td>
              <td width="7%" align=center >Jun</td>
              <td width="7%" align=center >Jul</td>
              <td width="7%" align=center >Aug</td>
              <td width="7%" align=center >Sep</td>
              <td width="7%" align=center >Oct</td>
              <td width="7%" align=center >Nov</td>
              <td width="7%" align=center >Dec</td>
              <td width="10%" align=center >TOTAL</td>
            </tr>
          </thead>
          <?php 
//===jika ada billing

$query_ves_leaving_current = q_set($__p_query_ves_leaving_current, "select sum(CASE WHEN (date_format(tgl_intake, '%c') = 1 ) THEN 1 ELSE 0 END) AS jan,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 2 ) THEN 1 ELSE 0 END) AS feb,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 3 ) THEN 1 ELSE 0 END) AS mar,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 4 ) THEN 1 ELSE 0 END) AS apr,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 5 ) THEN 1 ELSE 0 END) AS mei,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 6  ) THEN 1 ELSE 0 END) AS jun,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 7) THEN 1 ELSE 0 END) AS jul,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 8 ) THEN 1 ELSE 0 END) AS aug,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 9  ) THEN 1 ELSE 0 END) AS sep,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 10  ) THEN 1 ELSE 0 END) AS oct,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 11 ) THEN 1 ELSE 0 END) AS nov,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 12  ) THEN 1 ELSE 0 END) AS des\r
from adm_stu_progress a where date_format(enroll_date, '%Y') = ? and final_status = 'L'\r
and (date_format(comm_date, '%Y') = ? or date_format(tgl_intake, '%Y') = ? ) and aktif = 1\r
" . $filter_cbg_admission, [(string) ($thn_period), (string) ($thn_period), (string) ($thn_period), ...($__p_filter_cbg_admission ?? [])]);		

				   
$resource_ves_leaving_current = db_query_soft($query_ves_leaving_current, $__p_query_ves_leaving_current ?? []);
$keluar_ves_leaving_current = db_num_rows($resource_ves_leaving_current);
if(num(db_num_rows($resource_ves_leaving_current)) > 0)
	{
	while ($row_ves_leaving_current  =  db_fetch($resource_ves_leaving_current, PDO::FETCH_NUM))
		{	
		$ves_leaving_current_jan = $row_ves_leaving_current[0];
		$ves_leaving_current_feb = $row_ves_leaving_current[1];
		$ves_leaving_current_mar = $row_ves_leaving_current[2];
		$ves_leaving_current_apr = $row_ves_leaving_current[3];
		$ves_leaving_current_may = $row_ves_leaving_current[4];
		$ves_leaving_current_jun = $row_ves_leaving_current[5];
		$ves_leaving_current_jul = $row_ves_leaving_current[6];
		$ves_leaving_current_aug = $row_ves_leaving_current[7];
		$ves_leaving_current_sep = $row_ves_leaving_current[8];
		$ves_leaving_current_oct = $row_ves_leaving_current[9];
		$ves_leaving_current_nop = $row_ves_leaving_current[10];
		$ves_leaving_current_des = $row_ves_leaving_current[11];
		$ves_leaving_current_total = (num($row_ves_leaving_current[0])+num($row_ves_leaving_current[1])+num($row_ves_leaving_current[2])+num($row_ves_leaving_current[3])+num($row_ves_leaving_current[4])+num($row_ves_leaving_current[5])+num($row_ves_leaving_current[6])+num($row_ves_leaving_current[7])+num($row_ves_leaving_current[8])+num($row_ves_leaving_current[9])+num($row_ves_leaving_current[10])+num($row_ves_leaving_current	[11]));
					   ?>
          <tbody>
            <tr>
              <td align=center class="style24">Current</td>
               <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[0]) ?></a></td>
	            <td height="14" align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[1]) ?></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[2]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[3]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[4]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[5]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[6]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[7]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[8]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[9]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[10]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[11]) ?></a></td>
              <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=5&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($ves_leaving_current_total) ?></a></td>
            </tr>
            <?php 	} }  

$query_ves_leaving_previous = q_set($__p_query_ves_leaving_previous, "select sum(CASE WHEN (date_format(tgl_intake, '%c') = 1  ) THEN 1 ELSE 0 END) AS jan,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 2  ) THEN 1 ELSE 0 END) AS feb,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 3  ) THEN 1 ELSE 0 END) AS mar,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 4 ) THEN 1 ELSE 0 END) AS apr,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 5  ) THEN 1 ELSE 0 END) AS mei,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 6  ) THEN 1 ELSE 0 END) AS jun,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 7 ) THEN 1 ELSE 0 END) AS jul,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 8 ) THEN 1 ELSE 0 END) AS aug,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 9  ) THEN 1 ELSE 0 END) AS sep,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 10 ) THEN 1 ELSE 0 END) AS oct,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 11  ) THEN 1 ELSE 0 END) AS nov,\r
sum(CASE WHEN (date_format(tgl_intake, '%c') = 12 ) THEN 1 ELSE 0 END) AS des\r
from adm_stu_progress a where date_format(enroll_date, '%Y') < ? and final_status = 'L'\r
and (date_format(comm_date, '%Y') = ? or date_format(tgl_intake, '%Y') = ? ) and aktif = 1\r
" . $filter_cbg_admission, [(string) ($thn_period), (string) ($thn_period), (string) ($thn_period), ...($__p_filter_cbg_admission ?? [])]);
				   
$resource_ves_leaving_previous = db_query_soft($query_ves_leaving_previous, $__p_query_ves_leaving_previous ?? []);
if(num(db_num_rows($resource_ves_leaving_previous)) > 0)
	{
	while ($row_ves_leaving_previous  =  db_fetch($resource_ves_leaving_previous, PDO::FETCH_NUM))
		{			  
$ves_leaving_previous_jan = $row_ves_leaving_previous[0];
		$ves_leaving_previous_feb = $row_ves_leaving_previous[1];
		$ves_leaving_previous_mar = $row_ves_leaving_previous[2];
		$ves_leaving_previous_apr = $row_ves_leaving_previous[3];
		$ves_leaving_previous_may = $row_ves_leaving_previous[4];
		$ves_leaving_previous_jun = $row_ves_leaving_previous[5];
		$ves_leaving_previous_jul = $row_ves_leaving_previous[6];
		$ves_leaving_previous_aug = $row_ves_leaving_previous[7];
		$ves_leaving_previous_sep = $row_ves_leaving_previous[8];
		$ves_leaving_previous_oct = $row_ves_leaving_previous[9];
		$ves_leaving_previous_nop = $row_ves_leaving_previous[10];
		$ves_leaving_previous_des = $row_ves_leaving_previous[11];
		$ves_leaving_previous_total = (num($row_ves_leaving_previous[0])+num($row_ves_leaving_previous[1])+num($row_ves_leaving_previous[2])+num($row_ves_leaving_previous[3])+num($row_ves_leaving_previous[4])+num($row_ves_leaving_previous[5])+num($row_ves_leaving_previous[6])+num($row_ves_leaving_previous[7])+num($row_ves_leaving_previous[8])+num($row_ves_leaving_previous[9])+num($row_ves_leaving_previous[10])+num($row_ves_leaving_previous	[11]));
					   ?>
            <tr>
              <td align=center bgcolor="#FCA6A7"  class="style24">Previous</td>
               <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[0]) ?></a></td>
	            <td height="14" bgcolor="#FCA6A7"  align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[1]) ?></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[2]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[3]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[4]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[5]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[6]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[7]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[8]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[9]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[10]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[11]) ?></a></td>
              <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('mon_dtl.php?v=6&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($ves_leaving_previous_total) ?></a></td>
            </tr>
            <tr>
              <td align=center  class="style24"><strong>Netto</strong></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_jan) +  num($row_ves_leaving_previous[0]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_feb) +  num($row_ves_leaving_previous[1]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_mar) +  num($row_ves_leaving_previous[2]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_apr) +  num($row_ves_leaving_previous[3]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_may) +  num($row_ves_leaving_previous[4]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_jun) +  num($row_ves_leaving_previous[5]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_jul) +  num($row_ves_leaving_previous[6]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_aug) +  num($row_ves_leaving_previous[7]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_sep) +  num($row_ves_leaving_previous[8]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_oct) +  num($row_ves_leaving_previous[9]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_nop) +  num($row_ves_leaving_previous[10]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_des) +  num($row_ves_leaving_previous[11]))) ?></td>
              <td align=center  class="style24"><?php echo e((num($ves_leaving_current_total) +  num($ves_leaving_previous_total))) ?></td>
            </tr>
            <?php } }  ?>
          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
		 
	
		</div>
		</div>
        <div class="col-md-6"><div class="box">				
<div class="box box-warning">
  <div class="box-body">
    <div class="col-md-12">
      <div class="form-group">
        <label>LATES VOS SALES</label>
        <br>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <table id="example12" class="table table-bordered table-striped">
	        <thead>
	          <tr>
	            <th width="19%"><small>Enroll Date</small></th>
	            <th width="81%"><small>Student</small></th>
	            </tr>
	          </thead>
	        <tbody>
	          <?php
$query= q_set($__p_query, "SELECT a.enroll_date, a.nama, b.school, b.country, date_format(a.tgl_intake,'%b %y'), a.pic, a.kd_cabang FROM tb_sales_report a left join tb_master_partner b on a.kd_school = b.kd_school where  date_format(enroll_date,'%Y') = ? and status = 'OK' and prioritas = 1 " . $filter_cbg_sales . " " . ($query_bln ?? '') . " order by enroll_date desc limit 5", [(string) ($thn), ...($__p_filter_cbg_sales ?? [])]);					
$resource = db_query_or_die('error_1', $query, $__p_query ?? []);
if(num(db_num_rows($resource)) > 0)
	{
	$nomor = 1;
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		if (num($row[6]) ==1){$row[6] = 'East Sby';}
		elseif (num($row[6]) ==2){$row[6] = 'West Sby';}
		elseif (num($row[6]) ==3){$row[6] = 'Denpasar';}
		elseif (num($row[6]) ==4){$row[6] = 'South Jkt';}
		elseif (num($row[6]) ==5){$row[6] = 'North Jkt';}
		elseif (num($row[6]) ==6){$row[6] = 'West Jkt';}
		elseif (num($row[6]) ==7){$row[6] = 'Bandung';}
		elseif (num($row[6]) ==8){$row[6] = 'Malang TBI';}
		elseif (num($row[6])==11){$row[6] = 'PIK';}
		elseif (num($row[6]) ==12){$row[6] = 'Serpong';}
		elseif (num($row[6]) ==00){$row[6]= '--ALL--';}
?>
	          <tr>
	            <td><small><?php echo e($row[0]) ?></small></td>
	            <td><small><?php echo e($row[1]) ?><br>
	              <?php echo e($row[2]) ?>	              (<?php echo e($row[4]) ?>)<br>
	              SC : <?php echo e($row[5]) ?></small></td>
	            </tr>
	          <?php $nomor = num($nomor)+1; }}?>
	          </tbody>
	        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
            </div>
	</div>
	  </div>
		</div>	 
	 </div>
	  </section>
      <!-- /.row --><!-- /.content -->

<!-- /.content-wrapper --><!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  <!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>

