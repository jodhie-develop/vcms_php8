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

if ($kd_cbg == '--ALL--' or $kd_cbg == ''  ){$kd_cbg = 1000;}
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
elseif (num($kd_cbg) == 1000 ){$cabang = '--ALL--';}
elseif ($kd_cbg == '' ){$cabang = '--ALL--';}
$filter_cbg_sales = q_set($__p_filter_cbg_sales, " and a.kd_branch = ?  ", [(string) ($kd_cbg)]);

if (num($kd_cbg) == 1000 ){$filter_cbg_sales = q_set($__p_filter_cbg_sales, " and (a.kd_branch = 1 or  a.kd_branch = 2 or  a.kd_branch = 3 or  a.kd_branch = 4 or  a.kd_branch = 5 or  a.kd_branch = 6 or  a.kd_branch = 7 or  a.kd_branch = 8 or  a.kd_branch = 11 or  a.kd_branch = 12 ) ");}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VIP SITUATION ROOM DASHBOARD</title>
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
 <form method=get action=#> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>VIP SITUATION ROOM</h1>
    <table width="493" border="0">
      <tbody>
        <tr>
          <td width="149">Enroll</td>
          <td width="334"><small><span class="form-group">
            <select name="thn_period"  onChange="this.form.submit()"   class="style33" id="kd_cbg">
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
              <option value="1000">--ALL--</option>
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
                  <h3 class="box-title">TOP VIP SALES PERSON</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                        <?php
$query= q_set($__p_query, "select sc, count(a.kd_billing) as jmlpax, sum(amount) as jmluang from vip_billing a\r
left join vip_mst_code_prg b on a.kd_program = b.kd_program\r
left join vip_billing_payment c on a.kd_billing = c.kd_billing\r
where date_format(a.dt_entry,'%Y') = ? and  date_format(c.dt_payment,'%Y') = ?\r
" . $filter_cbg_sales . " " . ($query_bln ?? '') . "\r
and (a.level_program not like '%Registration%' and a.level_program not like '%Placement%')\r
and c.status = 'Paid'\r
group by a.sc order by jmluang desc limit 7", [(string) ($thn), (string) ($thn), ...($__p_filter_cbg_sales ?? [])]);				  

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
                      <span class="users-list-date"><strong>Rp. <?php   echo number_format(num($row[2]),0,".",".") ?> </strong></span>						
                    </li>
<?php                    }} ?>                     <li>
                      <img src="gbstaff/profileformR.png" alt="User Image">
                      <a class="users-list-name" href="">View All</a>
                    </li>
					  
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
		  <label>VIP Student Sales </label><br>
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
	$query_vip_pax = q_set($__p_query_vip_pax, "select\r
count(distinct(case when date_format(a.dt_entry,'%m') = '01'then a.kd_billing end) )as bln_1,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '02'then a.kd_billing end) )as bln_2,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '03'then a.kd_billing end) )as bln_3,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '04'then a.kd_billing end) )as bln_4,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '05'then a.kd_billing end) )as bln_5,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '06'then a.kd_billing end) )as bln_6,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '07'then a.kd_billing end) )as bln_7,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '08'then a.kd_billing end) )as bln_8,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '09'then a.kd_billing end) )as bln_9,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '10'then a.kd_billing end) )as bln_10,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '11'then a.kd_billing end) )as bln_11,\r
count(distinct(case when date_format(a.dt_entry,'%m') = '12'then a.kd_billing end) )as bln_12\r
from vip_billing a\r
left join vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program\r
left join vip_student_data c on a.kd_biodata = c.kd_biodata\r
left join vip_billing_payment d on a.kd_billing = d.kd_billing\r
where date_format(a.dt_entry,'%Y') = ? \r
" . $filter_cbg_sales . " " . ($query_bln ?? '') . "\r
and b.level_program not like '%Placement%' and d.status = 'PAID' and jns_payment not like '%Registration%' group by date_format(a.dt_entry,'%Y')", [(string) ($thn), ...($__p_filter_cbg_sales ?? [])]);

$resource_ves = db_query_soft($query_vip_pax, $__p_query_vip_pax ?? []);
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
	            <td align=center class="style24">Sales</td>
				  <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[0]) ?></a></td>
	            <td height="14" align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[1]) ?></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[2]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[3]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[4]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[5]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[6]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[7]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[8]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[9]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[10]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves[11]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=1&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($ves_total) ?></a></td>
              </tr>

	          <?php 	} }  ?>
					
	          <tr>
<?php 
		$query_open_class_student = q_set($__p_query_open_class_student, "SELECT \r
\t\tcount(case when date_format(f.min_mulai,'%m') = '01' then g.kd_billing end )as bln_1,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '02' then g.kd_billing end )as bln_2,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '03' then g.kd_billing end )as bln_3,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '04' then g.kd_billing end )as bln_4,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '05' then g.kd_billing end )as bln_5,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '06' then g.kd_billing end )as bln_6,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '07' then g.kd_billing end )as bln_7,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '08' then g.kd_billing end )as bln_8,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '09' then g.kd_billing end )as bln_9,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '10' then g.kd_billing end )as bln_10,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '11' then g.kd_billing end )as bln_11,\r
\t\tcount(case when date_format(f.min_mulai,'%m') = '12' then g.kd_billing end )as bln_12\t\t\r
\t\tFROM ves_data.vip_teacher_schedule a\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas\r
AND a.mulai_tm = f.min_mulai left join vip_billing g on a.kelas = g.kd_class where date_format(f.min_mulai,'%Y')  = ?   " . $filter_cbg_sales . " and a.status_kelas = 1 order by a.kelas", [(string) ($thn), ...($__p_filter_cbg_sales ?? [])]);
$resource_vip_open_class_student = db_query_soft($query_open_class_student, $__p_query_open_class_student ?? []);

if(num(db_num_rows($resource_vip_open_class_student)) > 0)
	{
	while ($rvcopen  =  db_fetch($resource_vip_open_class_student, PDO::FETCH_NUM))
		{
?>		
	            <td align=center class="style24">Class Openned by Student</td>
	             <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[0]) ?></a></td>
	            <td height="14" align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[1]) ?></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[2]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[3]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[4]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[5]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[6]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[7]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[8]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[9]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[10]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($rvcopen[11]) ?></a></td>
	            <td align=center class="style24"><a href="vip_mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e((num($rvcopen[0]) + num($rvcopen[1]) + num($rvcopen[2]) + num($rvcopen[3]) + num($rvcopen[4]) + num($rvcopen[5]) + num($rvcopen[6]) + num($rvcopen[7]) + num($rvcopen[8]) + num($rvcopen[9]) + num($rvcopen[10]) + num($rvcopen[11]))) ?></a></td>
<?php } } ?>				  
	            </tr>
	          <tr>
<?php

	$query_vip_open_class = q_set($__p_query_vip_open_class, "SELECT sum(case when date_format(f.min_mulai,'%m') = '01' then 1 end )as bln_1, sum(case when date_format(f.min_mulai,'%m') = '02' then 1 end )as bln_2, sum(case when date_format(f.min_mulai,'%m') = '03' then 1 end )as bln_3, sum(case when date_format(f.min_mulai,'%m') = '04' then 1 end )as bln_4, sum(case when date_format(f.min_mulai,'%m') = '05' then 1 end )as bln_5, sum(case when date_format(f.min_mulai,'%m') = '06' then 1 end )as bln_6, sum(case when date_format(f.min_mulai,'%m') = '07' then 1 end )as bln_7, sum(case when date_format(f.min_mulai,'%m') = '08' then 1 end )as bln_8, sum(case when date_format(f.min_mulai,'%m') = '09' then 1 end )as bln_9, sum(case when date_format(f.min_mulai,'%m') = '10' then 1 end )as bln_10, sum(case when date_format(f.min_mulai,'%m') = '11' then 1 end )as bln_11, sum(case when date_format(f.min_mulai,'%m') = '12' then 1 end )as bln_12 FROM ves_data.vip_teacher_schedule a INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where date_format(f.min_mulai,'%Y') = ?   " . $filter_cbg_sales . " and a.status_kelas = 1 order by a.kelas", [(string) ($thn), ...($__p_filter_cbg_sales ?? [])]);

$resource_vip_open_class = db_query_soft($query_vip_open_class, $__p_query_vip_open_class ?? []);

if(num(db_num_rows($resource_vip_open_class)) > 0)
	{
	while ($row_vip_open_class  =  db_fetch($resource_vip_open_class, PDO::FETCH_NUM))
		{			  
		$row_vip_open_class[0];
		 $row_vip_open_class[1];
		$row_vip_open_class[2];
		 $row_vip_open_class[3];
		 $row_vip_open_class[4];
		 $row_vip_open_class[5];
		$row_vip_open_class[6];
		$row_vip_open_class[7];
		$row_vip_open_class[8];
		$row_vip_open_class[9];
		$row_vip_open_class[10];
		$row_vip_open_class[11];
		$row_vip_open_class_total = (num($row_vip_open_class[0])+num($row_vip_open_class[1])+num($row_vip_open_class[2])+num($row_vip_open_class[3])+num($row_vip_open_class[4])+num($row_vip_open_class[5])+num($row_vip_open_class[6])+num($row_vip_open_class[7])+num($row_vip_open_class[8])+num($row_vip_open_class[9])+num($row_vip_open_class[10])+num($row_vip_open_class[11]));
		
					   ?>				  			  
	            <td align=center class="style24">Class Openned</td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[0]) ?></td>
	            <td height="14" align=center class="style24"><?php echo e($row_vip_open_class[1]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[2]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[3]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[4]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[5]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[6]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[7]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[8]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[9]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[10]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class[11]) ?></td>
	            <td align=center class="style24"><?php echo e($row_vip_open_class_total) ?></td>
	            </tr>
	          <?php 	} }  

	$query_vip_amount = q_set($__p_query_vip_amount, "select sum(case when date_format(c.dt_payment,'%m') = '01' then amount end )as bln_1,\r
sum(case when date_format(c.dt_payment,'%m') = '02' then amount end )as bln_2,\r
sum(case when date_format(c.dt_payment,'%m') = '03' then amount end )as bln_3,\r
sum(case when date_format(c.dt_payment,'%m') = '04' then amount end )as bln_4,\r
sum(case when date_format(c.dt_payment,'%m') = '05' then amount end )as bln_5,\r
sum(case when date_format(c.dt_payment,'%m') = '06' then amount end )as bln_6,\r
sum(case when date_format(c.dt_payment,'%m') = '07' then amount end )as bln_7,\r
sum(case when date_format(c.dt_payment,'%m') = '08' then amount end )as bln_8,\r
sum(case when date_format(c.dt_payment,'%m') = '09' then amount end )as bln_9,\r
sum(case when date_format(c.dt_payment,'%m') = '10' then amount end )as bln_10,\r
sum(case when date_format(c.dt_payment,'%m') = '11' then amount end )as bln_11,\r
sum(case when date_format(c.dt_payment,'%m') = '12' then amount end )as bln_12\r
from vip_billing a left join vip_billing_payment c on a.kd_billing = c.kd_billing where date_format(a.dt_entry,'%Y') = ? and  date_format(c.dt_payment,'%Y') = ?\r
" . $filter_cbg_sales . " " . ($query_bln ?? '') . "\r
and (a.level_program not like '%Registration%' and a.level_program not like '%Placement%') and c.status = 'Paid'", [(string) ($thn), (string) ($thn), ...($__p_filter_cbg_sales ?? [])]);
  
$resource_ves_cancel = db_query_soft($query_vip_amount, $__p_query_vip_amount ?? []);
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
    <div class="col-md-12">
      <div class="form-group">
        <label>VIP Income </label>
        <br>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <table width="100%" class="table table-bordered table-striped" id="example4">
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
              <td width="7%" align=center >Nop</td>
              <td width="7%" align=center >Dec</td>
              <td width="10%" align=center >TOTAL</td>
            </tr>
          </thead>
          <?php 
//===jika ada billing
	$query_vip_pax = q_set($__p_query_vip_pax, "select sum(case when  date_format(c.dt_payment,'%m') = '01' then 1 end )as bln_1,\r
sum(case when  date_format(c.dt_payment,'%m') = '02' then 1 end )as bln_2,\r
sum(case when  date_format(c.dt_payment,'%m') = '03' then 1 end )as bln_3,\r
sum(case when  date_format(c.dt_payment,'%m') = '04' then 1 end )as bln_4,\r
sum(case when  date_format(c.dt_payment,'%m') = '05' then 1 end )as bln_5,\r
sum(case when  date_format(c.dt_payment,'%m') = '06' then 1 end )as bln_6,\r
sum(case when  date_format(c.dt_payment,'%m') = '07' then 1 end )as bln_7,\r
sum(case when  date_format(c.dt_payment,'%m') = '08' then 1 end )as bln_8,\r
sum(case when  date_format(c.dt_payment,'%m') = '09' then 1 end )as bln_9,\r
sum(case when  date_format(c.dt_payment,'%m') = '10' then 1 end )as bln_10,\r
sum(case when  date_format(c.dt_payment,'%m') = '11' then 1 end )as bln_11,\r
sum(case when  date_format(c.dt_payment,'%m') = '12' then 1 end )as bln_12\r
\r
from vip_billing a\r
left join vip_billing_payment c on a.kd_billing = c.kd_billing\r
where date_format(a.dt_entry,'%Y') = ? and  date_format(c.dt_payment,'%Y') = ?\r
" . $filter_cbg_sales . " " . ($query_bln ?? '') . "\r
and (a.level_program not like '%Registration%' and a.level_program not like '%Placement%') and c.status = 'Paid'", [(string) ($thn), (string) ($thn), ...($__p_filter_cbg_sales ?? [])]);

$resource_ves = db_query_soft($query_vip_pax, $__p_query_vip_pax ?? []);
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
            <?php 	} }  

	$query_vip_open_class = q_set($__p_query_vip_open_class, "SELECT sum(case when date_format(f.min_mulai,'%m') = '01' then 1 end )as bln_1, sum(case when date_format(f.min_mulai,'%m') = '02' then 1 end )as bln_2, sum(case when date_format(f.min_mulai,'%m') = '03' then 1 end )as bln_3, sum(case when date_format(f.min_mulai,'%m') = '04' then 1 end )as bln_4, sum(case when date_format(f.min_mulai,'%m') = '05' then 1 end )as bln_5, sum(case when date_format(f.min_mulai,'%m') = '06' then 1 end )as bln_6, sum(case when date_format(f.min_mulai,'%m') = '07' then 1 end )as bln_7, sum(case when date_format(f.min_mulai,'%m') = '08' then 1 end )as bln_8, sum(case when date_format(f.min_mulai,'%m') = '09' then 1 end )as bln_9, sum(case when date_format(f.min_mulai,'%m') = '10' then 1 end )as bln_10, sum(case when date_format(f.min_mulai,'%m') = '11' then 1 end )as bln_11, sum(case when date_format(f.min_mulai,'%m') = '12' then 1 end )as bln_12 FROM ves_data.vip_teacher_schedule a INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where date_format(f.min_mulai,'%Y') = ?   " . $filter_cbg_sales . " and a.status_kelas = 1 order by a.kelas", [(string) ($thn), ...($__p_filter_cbg_sales ?? [])]);

$resource_vip_open_class = db_query_soft($query_vip_open_class, $__p_query_vip_open_class ?? []);

if(num(db_num_rows($resource_vip_open_class)) > 0)
	{
	while ($row_vip_open_class  =  db_fetch($resource_vip_open_class, PDO::FETCH_NUM))
		{			  
		$row_vip_open_class[0];
		 $row_vip_open_class[1];
		$row_vip_open_class[2];
		 $row_vip_open_class[3];
		 $row_vip_open_class[4];
		 $row_vip_open_class[5];
		$row_vip_open_class[6];
		$row_vip_open_class[7];
		$row_vip_open_class[8];
		$row_vip_open_class[9];
		$row_vip_open_class[10];
		$row_vip_open_class[11];
		$row_vip_open_class_total = (num($row_vip_open_class[0])+num($row_vip_open_class[1])+num($row_vip_open_class[2])+num($row_vip_open_class[3])+num($row_vip_open_class[4])+num($row_vip_open_class[5])+num($row_vip_open_class[6])+num($row_vip_open_class[7])+num($row_vip_open_class[8])+num($row_vip_open_class[9])+num($row_vip_open_class[10])+num($row_vip_open_class[11]));
		
					   ?>
            <?php 	} }  

	$query_vip_amount = q_set($__p_query_vip_amount, "select sum(case when date_format(c.dt_payment,'%m') = '01' then amount end )as bln_1,\r
sum(case when date_format(c.dt_payment,'%m') = '02' then amount end )as bln_2,\r
sum(case when date_format(c.dt_payment,'%m') = '03' then amount end )as bln_3,\r
sum(case when date_format(c.dt_payment,'%m') = '04' then amount end )as bln_4,\r
sum(case when date_format(c.dt_payment,'%m') = '05' then amount end )as bln_5,\r
sum(case when date_format(c.dt_payment,'%m') = '06' then amount end )as bln_6,\r
sum(case when date_format(c.dt_payment,'%m') = '07' then amount end )as bln_7,\r
sum(case when date_format(c.dt_payment,'%m') = '08' then amount end )as bln_8,\r
sum(case when date_format(c.dt_payment,'%m') = '09' then amount end )as bln_9,\r
sum(case when date_format(c.dt_payment,'%m') = '10' then amount end )as bln_10,\r
sum(case when date_format(c.dt_payment,'%m') = '11' then amount end )as bln_11,\r
sum(case when date_format(c.dt_payment,'%m') = '12' then amount end )as bln_12\r
from vip_billing a left join vip_billing_payment c on a.kd_billing = c.kd_billing where date_format(a.dt_entry,'%Y') = ? and  date_format(c.dt_payment,'%Y') = ?\r
" . $filter_cbg_sales . " " . ($query_bln ?? '') . "\r
and (a.level_program not like '%Registration%' and a.level_program not like '%Placement%') and c.status = 'Paid'", [(string) ($thn), (string) ($thn), ...($__p_filter_cbg_sales ?? [])]);
		
$resource_ves_cancel = db_query_soft($query_vip_amount, $__p_query_vip_amount ?? []);
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
              <td align=center  class="style24"><strong>By Sales</strong></td>
              <td align=center  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[0]),0,".",".") ?>
              </a></td>
              <td height="14" align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[1]),0,".",".") ?>
              </a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[2]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[3]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[4]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[5]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[6]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[7]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[8]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[9]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[10]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;">
                <?php  echo number_format(num($row_ves_cancel[11]),0,".",".") ?>
              </a><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"></a></td>
              <td align=center   class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=2&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo number_format(num($row_ves_cancel_current_total),0,".",".") ?></a></td>
            </tr>
<?php }}?>			  
            <tr>
<?php 
$query_open_class_income = q_set($__p_query_open_class_income, "SELECT\r
sum(case when date_format(f.min_mulai,'%m') = '01' then h.amount end )as bln_1,\r
sum(case when date_format(f.min_mulai,'%m') = '02' then h.amount end )as bln_2,\r
sum(case when date_format(f.min_mulai,'%m') = '03' then h.amount end )as bln_3,\r
sum(case when date_format(f.min_mulai,'%m') = '04' then h.amount end )as bln_4,\r
sum(case when date_format(f.min_mulai,'%m') = '05' then h.amount end )as bln_5,\r
sum(case when date_format(f.min_mulai,'%m') = '06' then h.amount end )as bln_6,\r
sum(case when date_format(f.min_mulai,'%m') = '07' then h.amount end )as bln_7,\r
sum(case when date_format(f.min_mulai,'%m') = '08' then h.amount end )as bln_8,\r
sum(case when date_format(f.min_mulai,'%m') = '09' then h.amount end )as bln_9,\r
sum(case when date_format(f.min_mulai,'%m') = '10' then h.amount end )as bln_10,\r
sum(case when date_format(f.min_mulai,'%m') = '11' then h.amount end )as bln_11,\r
sum(case when date_format(f.min_mulai,'%m') = '12' then h.amount end )as bln_12\r
\r
FROM ves_data.vip_teacher_schedule a\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas\r
AND a.mulai_tm = f.min_mulai\r
left join vip_billing g on a.kelas = g.kd_class\r
left join vip_billing_payment h on g.kd_billing = h.kd_billing\r
where date_format(f.min_mulai,'%Y')  = ?\r
" . $filter_cbg_sales . " " . ($query_bln ?? '') . " and a.status_kelas = 1 and h.status = 'PAID' order by a.kelas", [(string) ($thn), ...($__p_filter_cbg_sales ?? [])]);
$resource_open_class_income = db_query_soft($query_open_class_income, $__p_query_open_class_income ?? []);
if(num(db_num_rows($resource_open_class_income)) > 0)
	{
	while ($rvo_income  =  db_fetch($resource_open_class_income, PDO::FETCH_NUM))
		{			
?>						   
              <td align=center class="style24">By Open Class</td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[0]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[1]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[2]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[3]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[4]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[5]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[6]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[7]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[8]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[9]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[10]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[11]),0,".",".") ?></td>
              <td height="14" align=center class="style24"><?php  echo number_format(num($rvo_income[0])+num($rvo_income[1])+num($rvo_income[2])+num($rvo_income[3])+num($rvo_income[4])+num($rvo_income[5])+num($rvo_income[6])+num($rvo_income[7])+num($rvo_income[8])+num($rvo_income[9])+num($rvo_income[10])+num($rvo_income[11]),0,".",".") ?></td>
				
	           <?php } }  ?>			
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
        <label>VIP Program</label>
        <br>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <table width="100%" class="table table-bordered table-striped" id="example3">
          <thead>
            <tr>
              <td width=7% align=center >Program</td>
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

$query_vip_open_class_by_program = q_set($__p_query_vip_open_class_by_program, "SELECT  nm_program, sum(case when date_format(f.min_mulai,'%m') = '01' then 1 end )as bln_1,\r
sum(case when date_format(f.min_mulai,'%m') = '02' then 1 end )as bln_2,sum(case when date_format(f.min_mulai,'%m') = '03' then 1 end )as bln_3,\r
sum(case when date_format(f.min_mulai,'%m') = '04' then 1 end )as bln_4, sum(case when date_format(f.min_mulai,'%m') = '05' then 1 end )as bln_5,\r
sum(case when date_format(f.min_mulai,'%m') = '06' then 1 end )as bln_6, sum(case when date_format(f.min_mulai,'%m') = '07' then 1 end )as bln_7,\r
sum(case when date_format(f.min_mulai,'%m') = '08' then 1 end )as bln_8, sum(case when date_format(f.min_mulai,'%m') = '09' then 1 end )as bln_9,\r
sum(case when date_format(f.min_mulai,'%m') = '10' then 1 end )as bln_10, sum(case when date_format(f.min_mulai,'%m') = '11' then 1 end )as bln_11,\r
sum(case when date_format(f.min_mulai,'%m') = '12' then 1 end )as bln_12,\r
sum(case when date_format(f.min_mulai,'%Y') = '2023' then 1 end )as total\r
 FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg b\r
on a.kode_program = b.kd_program and a.level_program  = b.level_program\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f\r
ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
where  date_format(f.min_mulai,'%Y') = ? " . $filter_cbg_sales . " and a.status_kelas = 1\r
group by kode_program, b.level_program order by a.kelas", [(string) ($thn), ...($__p_filter_cbg_sales ?? [])]);			
	   
$resource_vip_open_class_by_program = db_query_soft($query_vip_open_class_by_program, $__p_query_vip_open_class_by_program ?? []);
if(num(db_num_rows($resource_vip_open_class_by_program)) > 0)
	{
	while ($row_vip_open_class_by_program  =  db_fetch($resource_vip_open_class_by_program, PDO::FETCH_NUM))
		{	
		$row_vip_open_class_by_program[0];
		$row_vip_open_class_by_program[1];
		$row_vip_open_class_by_program[2];
		$row_vip_open_class_by_program[3];
		$row_vip_open_class_by_program[4];
		$row_vip_open_class_by_program[5];
		$row_vip_open_class_by_program[6];
		$row_vip_open_class_by_program[7];
		$row_vip_open_class_by_program[8];
		$row_vip_open_class_by_program[9];
		$row_vip_open_class_by_program[10];
		$row_vip_open_class_by_program[11];
		$row_vip_open_class_by_program[12];
					   ?>
          <tbody>
            <tr>
              <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[0]) ?></a></td>
               <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[1]) ?></a></td>
	            <td height="14" align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[2]) ?></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[3]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[4]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[5]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[6]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[7]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[8]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[9]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[10]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[11]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[12]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=3&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_vip_open_class_by_program[13]) ?></a></td>
            </tr><?php } } ?>
            <tr>
              <td align=center class="style24">TOTAL</td>
              <td align=center class="style24">&nbsp;</td>
              <td height="14" align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
              <td align=center class="style24">&nbsp;</td>
            </tr>
            <?php 	  

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
from adm_stu_progress where date_format(enroll_date,'%Y') < ? and date_format(update_date,'%Y') >= ? and final_status = 'C' and aktif = 1 " . ($filter_cbg_admission ?? ''), [(string) ($thn_period), (string) ($thn_period)]);	

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
			  <?php } } ?>
      
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
        <label>PLACEMENT TEST </label>
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

$query_ves_leaving_current = q_set($__p_query_ves_leaving_current, "select count(distinct(case when date_format(a.dt_entry,'%m') = '01'then a.kd_billing end) )as bln_1, count(distinct(case when date_format(a.dt_entry,'%m') = '02'then a.kd_billing end) )as bln_2, count(distinct(case when date_format(a.dt_entry,'%m') = '03'then a.kd_billing end) )as bln_3, count(distinct(case when date_format(a.dt_entry,'%m') = '04'then a.kd_billing end) )as bln_4, count(distinct(case when date_format(a.dt_entry,'%m') = '05'then a.kd_billing end) )as bln_5, count(distinct(case when date_format(a.dt_entry,'%m') = '06'then a.kd_billing end) )as bln_6, count(distinct(case when date_format(a.dt_entry,'%m') = '07'then a.kd_billing end) )as bln_7, count(distinct(case when date_format(a.dt_entry,'%m') = '08'then a.kd_billing end) )as bln_8, count(distinct(case when date_format(a.dt_entry,'%m') = '09'then a.kd_billing end) )as bln_9, count(distinct(case when date_format(a.dt_entry,'%m') = '10'then a.kd_billing end) )as bln_10, count(distinct(case when date_format(a.dt_entry,'%m') = '11'then a.kd_billing end) )as bln_11, count(distinct(case when date_format(a.dt_entry,'%m') = '12'then a.kd_billing end) )as bln_12\r
from vip_billing a\r
where date_format(a.dt_entry,'%Y') = ? and a.level_program =  'Free Placement Test' " . $filter_cbg_sales, [(string) ($thn_period), ...($__p_filter_cbg_sales ?? [])]);

				   
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
              <td align=center class="style24">Free</td>
               <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[0]) ?></a></td>
	            <td height="14" align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[1]) ?></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[2]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[3]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[4]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[5]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[6]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[7]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[8]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[9]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[10]) ?></a></td>
	            <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_current[11]) ?></a></td>
              <td align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=5&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($ves_leaving_current_total) ?></a></td>
            </tr>
            <?php 	} }  

$query_ves_leaving_previous = q_set($__p_query_ves_leaving_previous, "select count(distinct(case when date_format(a.dt_entry,'%m') = '01'then a.kd_billing end) )as bln_1, count(distinct(case when date_format(a.dt_entry,'%m') = '02'then a.kd_billing end) )as bln_2, count(distinct(case when date_format(a.dt_entry,'%m') = '03'then a.kd_billing end) )as bln_3, count(distinct(case when date_format(a.dt_entry,'%m') = '04'then a.kd_billing end) )as bln_4, count(distinct(case when date_format(a.dt_entry,'%m') = '05'then a.kd_billing end) )as bln_5, count(distinct(case when date_format(a.dt_entry,'%m') = '06'then a.kd_billing end) )as bln_6, count(distinct(case when date_format(a.dt_entry,'%m') = '07'then a.kd_billing end) )as bln_7, count(distinct(case when date_format(a.dt_entry,'%m') = '08'then a.kd_billing end) )as bln_8, count(distinct(case when date_format(a.dt_entry,'%m') = '09'then a.kd_billing end) )as bln_9, count(distinct(case when date_format(a.dt_entry,'%m') = '10'then a.kd_billing end) )as bln_10, count(distinct(case when date_format(a.dt_entry,'%m') = '11'then a.kd_billing end) )as bln_11, count(distinct(case when date_format(a.dt_entry,'%m') = '12'then a.kd_billing end) )as bln_12\r
from vip_billing a\r
where date_format(a.dt_entry,'%Y') = ? and a.level_program like  '%Placement%' and (reg_fee <> 0  or tf <> 0) " . $filter_cbg_sales, [(string) ($thn_period), ...($__p_filter_cbg_sales ?? [])]);
				   
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
              <td align=center bgcolor="#FCA6A7"  class="style24">Paid</td>
               <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=0&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[0]) ?></a></td>
	            <td height="14" bgcolor="#FCA6A7"  align=center class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=1&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[1]) ?></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=2&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[2]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=3&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[3]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=4&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[4]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=5&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[5]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=6&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[6]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=7&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[7]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=8&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[8]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=9&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[9]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=10&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[10]) ?></a></td>
	            <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=11&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($row_ves_leaving_previous[11]) ?></a></td>
              <td align=center bgcolor="#FCA6A7"  class="style24"><a href="mon_dtl.php" 
target="popup" 
onClick="window.open('vip_mon_dtl.php?v=6&urut=12&kd_cbg=<?php echo e(u($kd_cbg)) ?>&thn=<?php echo e(u($thn_period))?>','popup','width=800,height=850,left=700px'); return false;"><?php echo e($ves_leaving_previous_total) ?></a></td>
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
  <div class="box-body"><!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<div class="box box-warning">
  <div class="box-body">
    <div class="col-md-8">
      <div class="form-group">
        <label>INCENTIVE PAID</label>
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

$query_ves_incentive = q_set($__p_query_ves_incentive, "SELECT\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 1 ) THEN nominal ELSE 0 END) AS jan,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 2 ) THEN nominal ELSE 0 END) AS feb,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 3 ) THEN nominal ELSE 0 END) AS mar,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 4 ) THEN nominal ELSE 0 END) AS apr,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 5 ) THEN nominal ELSE 0 END) AS mei,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 6 ) THEN nominal ELSE 0 END) AS jun,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 7 ) THEN nominal ELSE 0 END) AS jul,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 8 ) THEN nominal ELSE 0 END) AS aug,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 9 ) THEN nominal ELSE 0 END) AS sep,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 10 ) THEN nominal ELSE 0 END) AS oct,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 11 ) THEN nominal ELSE 0 END) AS nov,\r
sum(CASE WHEN (date_format(start_kelas, '%m') = 12 ) THEN nominal ELSE 0 END) AS des\r
 FROM ves_data.ve_incentive a where st_reward = 8 and date_format(start_kelas,'%Y') = ? " . $filter_cbg_sales, [(string) ($thn_period), ...($__p_filter_cbg_sales ?? [])]);

$resource_ves_incentive = db_query_soft($query_ves_incentive, $__p_query_ves_incentive ?? []);
if(num(db_num_rows($resource_ves_incentive)) > 0)
	{
	while ($row_ves_incentive  =  db_fetch($resource_ves_incentive, PDO::FETCH_NUM))
		{	
		$ves_incentive_jan = $row_ves_incentive[0];
		$ves_incentive_feb = $row_ves_incentive[1];
		$ves_incentive_mar = $row_ves_incentive[2];
		$ves_incentive_apr = $row_ves_incentive[3];
		$ves_incentive_may = $row_ves_incentive[4];
		$ves_incentive_jun = $row_ves_incentive[5];
		$ves_incentive_jul = $row_ves_incentive[6];
		$ves_incentive_aug = $row_ves_incentive[7];
		$ves_incentive_sep = $row_ves_incentive[8];
		$ves_incentive_oct = $row_ves_incentive[9];
		$ves_incentive_nop = $row_ves_incentive[10];
		$ves_incentive_des = $row_ves_incentive[11];
		$ves_incentive_total = (num($row_ves_incentive[0])+num($row_ves_incentive[1])+num($row_ves_incentive[2])+num($row_ves_incentive[3])+num($row_ves_incentive[4])+num($row_ves_incentive[5])+num($row_ves_incentive[6])+num($row_ves_incentive[7])+num($row_ves_incentive[8])+num($row_ves_incentive[9])+num($row_ves_incentive[10])+num($row_ves_incentive[11]));
					   ?>
          <tbody>
            <tr>
              <td align=center class="style24">Amount</td>
               <td align=center class="style24"><?php  echo number_format(num($ves_incentive_jan),0,".",".") ?></td>
	            <td height="14" align=center class="style24"><?php echo number_format(num($ves_incentive_feb),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($ves_incentive_mar),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo number_format(num($ves_incentive_apr),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo number_format(num($ves_incentive_may),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo number_format(num($ves_incentive_jun),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo number_format(num($ves_incentive_jul),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo number_format(num($ves_incentive_aug),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo number_format(num($ves_incentive_sep),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo number_format(num($ves_incentive_oct),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo number_format(num($ves_incentive_nop),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo number_format(num($ves_incentive_des),0,".",".") ?></td>
              <td align=center class="style24"><?php echo number_format(num($ves_incentive_total),0,".",".") ?></td>
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
" . ($filter_cbg_admission ?? ''), [(string) ($thn_period), (string) ($thn_period), (string) ($thn_period)]);
				   
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
  <div class="box-body"><!-- /.box -->
  </div>
  <!-- /.col -->
</div>		 
	
		</div>
		</div>
        <div class="col-md-6"><div class="box"></div>
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

