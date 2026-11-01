<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$kd_cbg = in_val('kd_cbg', 'get');
if ($kd_cbg == 'ALL'){$kd_cbg = 111;}

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang'){$kd_cbg = 8;}
if ($kd_cbg == 'East Area'){$kd_cbg = 101;}
if ($kd_cbg == 'West Area'){$kd_cbg = 102;}
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}
if ($kd_cbg == 'Serpong'){$kd_cbg = 12;}


if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang';}
if (num($kd_cbg) ==101){$cabang = 'East Area';}
if (num($kd_cbg) ==102){$cabang = 'West Area';}
if (num($kd_cbg) ==11){$cabang = 'PIK';}
if (num($kd_cbg) ==12){$cabang = 'Serpong';}
if (num($kd_cbg) ==111){$cabang = 'ALL';}
$q = in_val('q', 'get');
$sales_period = in_val('sales_period', 'get');
$ls = in_val('ls', 'get');


if (num($kd_cbg) ==100){$cabang = 'National';}
if ($kd_cbg ==''){$cabang = '--ALL-';}
if ($sales_period ==''){$sales_period = '2018';}
if ($ls ==''){$ls = 'ALL';}
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;

$adm_period = $sales_period;
$carryon_1 = num($sales_period) + 1;
$carryon_2 = num($sales_period) + 2;
$carryon_3 = num($sales_period) + 3;
$carryon_4 = num($sales_period) + 4;
$carryon_5 = num($sales_period) + 5;
$carryon_6 = num($sales_period) + 6;
$carryon_7 = num($sales_period) + 7;
$carryon_8 = num($sales_period) + 8;
$thn_now = 2021;

if ($kd_cbg == '100' or $kd_cbg == '' ){$filter_cbg = '';}
elseif ($kd_cbg == '111'  ){$filter_cbg = q_set($__p_filter_cbg, " and kd_cabang between 1 and 12 ");}
else {$filter_cbg = q_set($__p_filter_cbg, "  and kd_cabang = ? ", [(string) ($kd_cbg)]);}

if($filter_cbg <>''){$cari_status = " and $cari_status ";}
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
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
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
 <?php  //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=""> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>ENROLLED & CARRY ON STUDENT LIST SUMMARY</h1><br>
     <div class="col-md-2">
       <div class="form-group">
         <label>Center</label>
         <select class="form-control" name="kd_cbg"  onChange="this.form.submit()">
      <option value="0">--CHOOSE--</option>
      <option value="1">East Sby</option>
      <option value="2">West Sby</option>
      <option value="3">Denpasar</option>
      <option value="8">Malang</option>
      <option value="101">East Area</option>
      <option value="4">South Jkt</option>
      <option value="5">North Jkt</option>
      <option value="11">PIK</option>
      <option value="12">Serpong</option>				 
      <option value="6">West Jkt</option>
      <option value="7">Bandung</option>
      <option value="102">West Area</option>
      <option value="100">National</option>
      <option value="111">ALL</option>			 
      <option selected="selected"><?php echo e($cabang) ?></option>
         </select>
       </div>
     </div>
     <div class="col-md-2">
       <div class="form-group">
         <label>Sales Period</label>
         <select class="form-control" name="sales_period"  onChange="this.form.submit()">
           <option value="2013">2013</option>
           <option value="2014">2014</option>			 
           <option value="2015">2015</option>
           <option value="2016">2016</option>
           <option value="2017">2017</option>			 
           <option value="2018">2018</option>
           <option value="2019">2019</option>
           <option value="2020">2020</option>
           <option value="2021">2021</option>
           <option value="-ALL-">-ALL-</option>
           <option selected="selected"><?php echo e($sales_period) ?></option>
         </select>
       </div>
     </div>
     <div class="col-md-2">
       <div class="form-group">
         <label>Last Status</label>
         <select class="form-control" name="ls"  onChange="this.form.submit()">
           <option value="ALL">ALL</option>
           <option value="PROGRESS">PROGRESS</option>
           <option value="PROBLEM">PROBLEM</option>
           <option value="ON HAND">ON HAND</option>
           <option value="C">C</option>
           <option value="L">L</option>			 
           <option selected="selected"><?php echo e($ls) ?></option>
         </select>
       </div>
     </div>
     <div class="col-md-2">
       <div class="form-group">
         <label></label>
         <input name="Display" type="submit" id="Display"  class="form-control"  value="Display" />
       </div>
     </div>
   </section>
   <!-- Main content --><span class="col-md-12">
   <?php

 		?>
   </span>

  <div class="row">
  <br>
  <section class="content">
     <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <label>Count : <?php echo e($jml_data) ?></label> 
            <div class="box-body">
<?php	
$angka = 1 ;
$kolom = 1;


if($sales_period == '2021'){		  
$query_sales = q_set($__p_query_sales, "select nama, country, school, enroll_date, pic,  kd_biodata,date_format(tgl_intake,'%b %y'),a.no, tgl_intake, program, major,\r
(case when a.h_NH = 'H' then 1 end) as H,\r
(case when a.h_NH <> 'H' then 1 end) as NH,\r
(case when a.p_np = 'P' then 1 end) as P,\r
(case when a.p_np <> 'P' then 1 end) as NP,a.kd_cabang from tb_sales_report a left join tb_master_partner b on a.kd_school = b.kd_school where prioritas = 1 and status = 'OK' and enroll_date between '2021-01-01' and '2021-08-31' " . $filter_cbg . " group by kd_biodata order by enroll_date", [...($__p_filter_cbg ?? [])]);
}
else
{		  
$query_sales = q_set($__p_query_sales, "select nama, country, school, enroll_date, pic,  kd_biodata,date_format(tgl_intake,'%b %y'),a.no, tgl_intake, program, major,\r
(case when a.h_NH = 'H' then 1 end) as H,\r
(case when a.h_NH <> 'H' then 1 end) as NH,\r
(case when a.p_np = 'P' then 1 end) as P,\r
(case when a.p_np <> 'P' then 1 end) as NP,a.kd_cabang from tb_sales_report a left join tb_master_partner b on a.kd_school = b.kd_school where prioritas = 1 and status = 'OK' and date_format(enroll_date, '%Y') = ? " . $filter_cbg . " group by kd_biodata order by enroll_date", [(string) ($sales_period), ...($__p_filter_cbg ?? [])]);
}
	  
$resource_sales = db_query_or_die('error_sales', $query_sales, $__p_query_sales ?? []);				
?>				
 <table width="87%" class="table table-bordered table-striped" id="example1"> 
<thead>
   <tr>
     <td width=47 rowspan="3" align=center >No</td>
     <td width=68 rowspan="3" align=center >BRanch</td>
     <td width=68 rowspan="3" align=center >SC</td>
     <td width=68 rowspan="3" align=center >Nama</td>
     <td width=77 rowspan="3" align=center >Country</td>
     <td width=77 rowspan="3" align=center >Institution</td>
     <td width=77 rowspan="3" align=center >Jurusan</td>
     <td width=77 rowspan="3" align=center >H</td>
     <td width=77 rowspan="3" align=center>NH</td>
     <td width=77 rowspan="3" align=center >P</td>
     <td width=77 rowspan="3" align=center >NP</td>	   
     <td colspan="3" rowspan="2" align=center >Enroll Date </td>
     <td height="14" colspan="5" align=center ><?php echo e($sales_period) ?></td>
     <td height="14"  bgcolor="#DFDFDF" ></td>
<?php if($carryon_1 <= $thn_now )	 { ?>  
     <td colspan="6" align=center ><?php echo e($carryon_1) ?></td>
     <td height="14" align=center bgcolor="#DFDFDF" >&nbsp;</td>
<?php if ($carryon_2 <= $thn_now)	 { ?>	   
     <td colspan="6" align=center ><?php echo e($carryon_2) ?></td>
     <td height="14"  bgcolor="#DFDFDF" ></td>	
<?php if ($carryon_3 <= $thn_now)	 { ?>		   
     <td colspan="6" align=center ><?php echo e($carryon_3) ?></td>
     <td height="14"  bgcolor="#DFDFDF" ></td>	
<?php if ($carryon_4 <= $thn_now)	 { ?>		   
     <td colspan="6" align=center ><?php echo e($carryon_4) ?></td>
	   <td  bgcolor="#DFDFDF" ></td>
<?php if ($carryon_5 <= $thn_now)	 { ?>		 
     <td colspan="6" align=center ><?php echo e($carryon_5) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if ($carryon_6 <= $thn_now)	 { ?>	   
     <td colspan="6" align=center ><?php echo e($carryon_6) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if ($carryon_7 <= $thn_now)	 { ?>	   
     <td colspan="6" align=center ><?php echo e($carryon_7) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if ($carryon_8 <= $thn_now)	 { ?>	   
     <td colspan="6" align=center ><?php echo e($carryon_8) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
     <?php }}}}}}}}?>	   
     <td colspan="4" align=center >FINAL STATUS</td>
     </tr>
   <tr>
     <td width="69" rowspan="2" align=center >ON</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td colspan="2" align=center >On Hand</td>
     <td height="14"  bgcolor="#DFDFDF" ></td>	   
<?php if($carryon_1 <= $thn_now )	 { ?>  	   
     <td colspan="2" align=center >Carry On #1</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td colspan="2" align=center >On Hand</td>
     <td height="14"  bgcolor="#DFDFDF" ></td>	  
<?php if($carryon_2 <= $thn_now )	 { ?>  	   
     <td colspan="2" align=center >Carry On #2</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td colspan="2" align=center >On Hand</td>
     <td height="14"  bgcolor="#DFDFDF" ></td>
<?php if($carryon_3 <= $thn_now )	 { ?>  	   
     <td colspan="2" align=center >Carry On #3</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td colspan="2" align=center >On Hand</td>
     <td height="14"  bgcolor="#DFDFDF" ></td>
<?php if($carryon_4 <= $thn_now )	 { ?>  	   
     <td colspan="2" align=center >Carry On #4</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td colspan="2" align=center >On Hand</td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_5 <= $thn_now )	 { ?>  		   
     <td colspan="2" align=center >Carry On #5</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td colspan="2" align=center >On Hand</td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_6 <= $thn_now )	 { ?>  	
     <td colspan="2" align=center >Carry On #6</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td colspan="2" align=center >On Hand</td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_7 <= $thn_now )	 { ?>  		   
     <td colspan="2" align=center >Carry On #7</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td colspan="2" align=center >On Hand</td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_8 <= $thn_now )	 { ?>  		   
     <td colspan="2" align=center >Carry On #8</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td colspan="2" align=center >On Hand</td>
	   <td  bgcolor="#DFDFDF" ></td>
     <?php }}}}}}}} ?>		   
     <td align=center >PR</td>
     <td align=center >ON</td>
     <td align=center >C</td>
     <td align=center >L</td>
   
	   
     </tr>
   <tr>
     <td width="71" align=center >Enroll Date </td>
     <td width=70 height="14" align=center >Intake</td>
     <td width="75" align=center >Updated</td>
     <td width="46" align=center >PR</td>
     <td width="73" align=center >PRGS</td>
     <td height="14"  bgcolor="#DFDFDF" ></td>	
<?php if($carryon_1 <= $thn_now )	 { ?>  	  	   
     <td width="69" align=center >PR</td>
     <td width="68" align=center >PRGS</td>	   
     <td width="46" align=center >PR</td>
     <td width="73" align=center >PRGS</td>
	   <td height="14"  bgcolor="#DFDFDF" ></td>
<?php if($carryon_2 <= $thn_now )	 { ?>  	  		 
     <td width="69" align=center >PR</td>
     <td width="68" align=center >PRGS</td>
     <td width="46" align=center >PR</td>
     <td width="73" align=center >PRGS</td> 	  	   
     <td height="14"  bgcolor="#DFDFDF" ></td>
<?php if($carryon_3 <= $thn_now )	 { ?> 	   
     <td width="69" align=center >PR</td>
     <td width="68" align=center >PRGS</td>   
     <td width="46" align=center >PR</td>
     <td width="73" align=center >PRGS</td>
     <td height="14"  bgcolor="#DFDFDF" ></td>
<?php if($carryon_4 <= $thn_now )	 { ?> 	   
     <td width="69" align=center >PR</td>
     <td width="68" align=center >PRGS</td>
     <td width="46" align=center >PR</td>
     <td width="73" align=center >PRGS</td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_5 <= $thn_now )	 { ?> 	   
	   
     <td width="69" align=center >PR</td>
     <td width="68" align=center >PRGS</td>
     <td width="46" align=center >PR</td>
     <td width="73" align=center >PRGS</td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_6 <= $thn_now )	 { ?> 	   
	   
     <td width="69" align=center >PR</td>
     <td width="68" align=center >PRGS</td>
     <td width="46" align=center >PR</td>
     <td width="73" align=center >PRGS</td>
	   <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_7 <= $thn_now )	 { ?> 	   
     <td width="69" align=center >PR</td>
     <td width="68" align=center >PRGS</td>
     <td width="46" align=center >PR</td>
     <td width="73" align=center >PRGS</td>
	   <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_8 <= $thn_now )	 { ?> 	   
		 
     <td width="69" align=center >PR</td>
     <td width="68" align=center >PRGS</td>
     <td width="46" align=center >PR</td>
     <td width="73" align=center >PRGS</td>
     <td  bgcolor="#DFDFDF" ></td>
     <?php }}}}}}}} ?>	   
     <td align=center >PR</td>
     <td align=center >ON</td>
     <td align=center >C</td>
     <td align=center >L</td>
	   
     </tr>
</thead>			  
<tbody>
<?php 
if(num(db_num_rows($resource_sales)) > 0)
	{ 
	while ($row_sales = db_fetch($resource_sales))
		{
		$final_on = 1;
		$ttl_sales = num($ttl_sales) + 1;
		$jalan = '  bgcolor="#D6CBF9"';
		$jalan_cancel = '  bgcolor="#FFF72B"';
		$jalan_leaving = '  bgcolor="#08F00D"';
		
		$jalan_problem = '  bgcolor="#FF0E0E"';
		
		$berhenti = '';
		$st_progress = '1';
		$st_on_awal = 1 ;
		$on_y0 = $st_on_awal;
		$on_y1 = $st_on_awal;
		$on_y2 = $st_on_awal;
		$on_y3 = $st_on_awal;
		$on_y4 = $st_on_awal;
		$on_y5 = $st_on_awal;
		$on_y6 = $st_on_awal;
		$on_y7 = $st_on_awal;
		$on_y8 = $st_on_awal;
		
		$on_y0_next = $st_on_awal;
		$on_y1_next = $st_on_awal;
		$on_y2_next = $st_on_awal;
		$on_y3_next = $st_on_awal;
		$on_y4_next = $st_on_awal;
		$on_y5_next = $st_on_awal;			
		$on_y6_next = $st_on_awal;			
		$on_y7_next = $st_on_awal;			
		$on_y8_next = $st_on_awal;			
		
		$nama = $row_sales[0];
		$dest_country = $row_sales[1];		
		$dest_School = $row_sales[2];
		$enroll_date = $row_sales[3];
		$kd_biodata = $row_sales[5];
		$sc  = $row_sales[4];
		$nomor_sales = $row_sales[7];
		$tgl_intake = $row_admin[8];		
		$program = $row_sales[9];
		$major = $row_sales[10];
		
		$query_last = q_set($__p_query_last, "select max(no) from adm_stu_progress where kd_biodata = ? and date_format(enroll_date,'%Y') = ? ", [(string) ($kd_biodata), (string) ($sales_period)]); 
		$resource_last = db_query_or_die('errro_2', $query_last, $__p_query_last ?? []);

		if(num(db_num_rows($resource_last)) > 0)
			{ 
			while ($row_last = db_fetch($resource_last))
				{
				$no_terakhir = $row_last[0];
				}
			}
		$query_admin = q_set($__p_query_admin, "select dest_country, dest_school, final_status, comm_date, update_date, step,date_format(tgl_intake,'%b %y'), date_format(comm_date, '%Y'), date_format(tgl_intake,'%b %y'),date_format(update_date,'%Y'),no from adm_stu_progress where kd_biodata = ? and no = ? ", [(string) ($kd_biodata), (string) ($no_terakhir)]); 
		$resource_admin = db_query_or_die('errro_1', $query_admin, $__p_query_admin ?? []);
		if(num(db_num_rows($resource_admin)) > 0)
			{ 
			while ($row_admin = db_fetch($resource_admin))
				{
				$dest_country = $row_admin[0];		
				$dest_school = $row_admin[1];
				$final_status = $row_admin[2];
				$comm_date = $row_admin[3];
				$thn_comm = $row_admin[7];
				$update_date = $row_admin[4];
				$thn_update = $row_admin[9];
				$tgl_intake = $row_admin[8];
				$nomor_kode = $row_admin[10];				
				if ($final_status == 'L')
					{
					$jalan = $jalan_leaving;
					if($thn_comm == $sales_period){$l_y0 = '1';$on_y0 = num($st_on_awal) - num($l_y0);}
					elseif($thn_comm == $carryon_1){$l_y1 = '1';$on_y1 = num($st_on_awal) - num($l_y1);}
					elseif($thn_comm == $carryon_2){$l_y2 = '1';$on_y2 = num($st_on_awal) - num($l_y2);}	
					elseif($thn_comm == $carryon_3){$l_y3 = '1'; $on_y3 = num($st_on_awal) - num($l_y3);}	
					elseif($thn_comm == $carryon_4){$l_y4 = '1'; $on_y4 = num($st_on_awal) - num($l_y4);}
					elseif($thn_comm == $carryon_5){$l_y5 = '1'; $on_y5 = num($st_on_awal) - num($l_y5);}		
					elseif($thn_comm == $carryon_6){$l_y6 = '1'; $on_y6 = num($st_on_awal) - num($l_y6);}	
					elseif($thn_comm == $carryon_7){$l_y7 = '1'; $on_y7 = num($st_on_awal) - num($l_y7);}	
					elseif($thn_comm == $carryon_8){$l_y8 = '1'; $on_y8 = num($st_on_awal) - num($l_y8);}		
					$final_l = '1';$final_on = '';
					$ttl_leaving = num($ttl_leaving) + 1;
					}
				elseif ($final_status == 'C')
					{
					$jalan = $jalan_cancel;
					if($thn_update == $sales_period){$c_y0 = '1';$on_y0 = num($st_on_awal) - num($c_y0);}
					elseif($thn_update == $carryon_1){$c_y1 = '1';$on_y1 = num($st_on_awal) - num($c_y1);}
					elseif($thn_update == $carryon_2){$c_y2 = '1'; $on_y2 = num($st_on_awal) - num($c_y2);}	
					elseif($thn_update == $carryon_3){$c_y3 = '1'; $on_y3 = num($st_on_awal) - num($c_y3);}	
					elseif($thn_update == $carryon_4){$c_y4 = '1'; $on_y4 = num($st_on_awal) - num($c_y4);}
					elseif($thn_update == $carryon_5){$c_y5 = '1'; $on_y5 = num($st_on_awal) - num($c_y5);}
					elseif($thn_update == $carryon_6){$c_y6 = '1'; $on_y6 = num($st_on_awal) - num($c_y6);}
					elseif($thn_update == $carryon_7){$c_y7 = '1'; $on_y7 = num($st_on_awal) - num($c_y7);}
					elseif($thn_update == $carryon_8){$c_y8 = '1'; $on_y8 = num($st_on_awal) - num($c_y8);}
					$final_c = '1';	$final_on = '';				
										$ttl_cancel = num($ttl_cancel) + 1;
					}
				elseif ($final_status == 'PR')
					{
					$jalan = $jalan_problem;
					if($thn_update == $sales_period){$pr_y0 = '1';$on_y0 = num($st_on_awal) - num($pr_y0);}
					elseif($thn_update == $carryon_1){$pr_y1 = '1';$on_y1 = num($on_y1) - num($pr_y1);}
					elseif($thn_update == $carryon_2){$pr_y2 = '1'; $on_y2 = num($st_on_awal) - num($pr_y2);}	
					elseif($thn_update == $carryon_3){$pr_y3 = '1'; $on_y3 = num($st_on_awal) - num($pr_y3);}	
					elseif($thn_update == $carryon_4){$pr_y4 = '1'; $on_y4 = num($st_on_awal) - num($pr_y4);}
					elseif($thn_update == $carryon_5){$pr_y5 = '1'; $on_y5 = num($st_on_awal) - num($pr_y5);}		
					elseif($thn_update == $carryon_6){$pr_y6 = '1'; $on_y6 = num($st_on_awal) - num($pr_y6);}	
					elseif($thn_update == $carryon_7){$pr_y7 = '1'; $on_y7 = num($st_on_awal) - num($pr_y7);}	
					elseif($thn_update == $carryon_8){$pr_y8 = '1'; $on_y8 = num($st_on_awal) - num($pr_y8);}	
					$final_pr = '1';$final_on = '';						
										$ttl_pr = num($ttl_pr) + 1;
					}
		if (num($on_y0)==0){$on_y0_next = '';$on_y1 ='';$on_y2 ='';	$on_y3 ='';$on_y4 ='';$on_y5 ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y1_next ='';$on_y2_next  ='';	$on_y3_next  ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y1)==0){$on_y1_next = '';$on_y2 ='';	$on_y3 ='';$on_y4 ='';$on_y5 ='';$on_y1_next ='';$on_y2_next  ='';	$on_y3_next  ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y2)==0){$on_y2_next = '';$on_y3 ='';$on_y4 ='';$on_y5 ='';$on_y2_next  ='';	$on_y3_next  ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y3)==0){$on_y3_next = '';$on_y4 ='';$on_y5 ='';	$on_y3_next  ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y4)==0){$on_y4_next = '';$on_y5 ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y5)==0){$on_y5_next = '';$on_y5 ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y6)==0){$on_y6_next = '';$on_y7 ='';$on_y8 ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y7)==0){$on_y7_next = '';$on_y8 ='';$on_y8_next  ='';} 
		elseif (num($on_y8)==0){$on_y8_next = '';} 				
				if (($ls =='ALL') or ($ls =='L' and $final_status == 'L') or ($ls =='C' and $final_status == 'C') or ($ls =='PROGRESS' and ($final_status == 'ON' or $final_status == 'PDO')) or ($ls =='PROBLEM' and $final_status == 'PR') or ($ls =='ON HAND' and ($final_status == 'ON' or $final_status == 'PDO'  or $final_status == 'PR'))  ){
?>		
   <tr>
     <td <?php echo e($jalan) ?> align=center ><?php echo e($angka) ?></td>
     <td <?php echo e($jalan) ?>  align=left ><?php echo e($row_sales[15])  ?></td>
     <td <?php echo e($jalan) ?>  align=left ><?php echo e($sc) ?></td>
     <td <?php echo e($jalan) ?>  align=left ><a href="stuadmprogress.php?kdb=<?php echo e(u($kd_biodata)); ?>&st=1&no=<?php echo e(u($nomor_kode)) ?>&asal=2&no_sales=<?php echo e(u($nomor_sales)) ?>"><?php echo e($nama) ?></a></td>
     <td <?php echo e($jalan) ?>  align=left ><a href="stuadmprogress.php?kdb=<?php echo e(u($kd_biodata)); ?>&st=1&no=<?php echo e(u($nomor_kode)) ?>&asal=2&no_sales=<?php echo e(u($nomor_sales)) ?>"><?php echo e($dest_country) ?></a></td>
     <td <?php echo e($jalan) ?>  align=left ><?php echo e($dest_school) ?><br></td>
     <td <?php echo e($jalan) ?>  align=left > <?php echo e($major) ?></td>
     <td <?php echo e($jalan) ?>  align=left > <?php echo e($row_sales[11])  ?></td>
     <td <?php echo e($jalan) ?>  align=left > <?php echo e($row_sales[12])  ?></td>
     <td <?php echo e($jalan) ?>  align=left > <?php echo e($row_sales[13])  ?></td>
     <td <?php echo e($jalan) ?>  align=left > <?php echo e($row_sales[14])  ?></td>	   
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($enroll_date) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($tgl_intake) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($update_date) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($st_on_awal) ?></td>
     <td  <?php echo e($jalan); if (num($c_y0) ==1){$jalan = $berhenti;} ?>  align=center ><?php echo e($c_y0) ?></td>
     <td <?php echo e($jalan); if (num($l_y0) ==1){$jalan = $berhenti;} ?> align=center ><?php echo e($l_y0) ?></td>
     <td <?php echo e($jalan); if (num($pr_y0) ==1){$jalan = $berhenti;} ?>  align=center ><?php echo e($pr_y0) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y0) ?></td>
     <td height="14"  bgcolor="#DFDFDF" ></td>
<?php if($carryon_1 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan) ?> align=center ><?php echo e($pr_y0_next) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y0_next) ?></td>
     <td <?php echo e($jalan); if (num($c_y1) ==1){$jalan = $berhenti;} ?>  align=center ><?php echo e($c_y1) ?></td>
     <td  <?php echo e($jalan); if (num($l_y1) ==1){$jalan = $berhenti;} ?> align=center ><?php echo e($l_y1) ?></td>
     <td <?php echo e($jalan); if (num($pr_y1) ==1){$jalan = $berhenti;} ?>  align=center ><?php echo e($pr_y1) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y1) ?></td>
     <td height="14"  bgcolor="#DFDFDF" ></td>	
<?php if($carryon_2 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($pr_y1_next) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y1_next) ?></td>
     <td <?php echo e($jalan); if (num($c_y2) ==1){$jalan = $berhenti;}  ?>  align=center ><?php echo e($c_y2) ?></td>
     <td <?php echo e($jalan); if (num($l_y2) ==1){$jalan = $berhenti;}  ?>  align=center ><?php echo e($l_y2) ?></td>
     <td  <?php echo e($jalan); if (num($pr_y2) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($pr_y2) ?></td>
     <td  <?php echo e($jalan) ?> align=center ><?php echo e($on_y2) ?></td>
     <td height="14"  bgcolor="#DFDFDF" ></td>	  
<?php if($carryon_3 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($pr_y2_next) ?></td>
     <td  <?php echo e($jalan) ?> align=center ><?php echo e($on_y2_next) ?></td>
     <td  <?php echo e($jalan); if (num($c_y3) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y3) ?></td>
     <td  <?php echo e($jalan); if (num($l_y3) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y3) ?></td>
     <td  <?php echo e($jalan); if (num($pr_y3) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($pr_y3) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y3) ?></td>
     <td height="14"  bgcolor="#DFDFDF" ></td>	   
<?php if($carryon_4 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($pr_y3_next) ?></td>
     <td  <?php echo e($jalan) ?> align=center ><?php echo e($on_y3_next) ?></td>
     <td  <?php echo e($jalan); if (num($c_y4) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y4) ?></td>
     <td  <?php echo e($jalan); if (num($l_y4) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y4) ?></td>
     <td  <?php echo e($jalan); if (num($pr_y4) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($pr_y4) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y4) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_5 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($pr_y4_next) ?></td>
     <td  <?php echo e($jalan) ?> align=center ><?php echo e($on_y4_next) ?></td>
     <td  <?php echo e($jalan); if (num($c_y5) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y5) ?></td>
     <td  <?php echo e($jalan); if (num($l_y5) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y5) ?></td>
     <td  <?php echo e($jalan); if (num($pr_y5) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($pr_y5) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y5) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_6 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($pr_y5_next) ?></td>
     <td  <?php echo e($jalan) ?> align=center ><?php echo e($on_y5_next) ?></td>
     <td  <?php echo e($jalan); if (num($c_y6) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y6) ?></td>
     <td  <?php echo e($jalan); if (num($l_y6) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y6) ?></td>
     <td  <?php echo e($jalan); if (num($pr_y6) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($pr_y6) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y6) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_7 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($pr_y6_next) ?></td>
     <td  <?php echo e($jalan) ?> align=center ><?php echo e($on_y6_next) ?></td>
     <td  <?php echo e($jalan); if (num($c_y7) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y7) ?></td>
     <td  <?php echo e($jalan); if (num($l_y7) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y7) ?></td>
     <td  <?php echo e($jalan); if (num($pr_y7) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($pr_y7) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y7) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
<?php if($carryon_8 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($pr_y7_next) ?></td>
     <td  <?php echo e($jalan) ?> align=center ><?php echo e($on_y7_next) ?></td>
     <td  <?php echo e($jalan); if (num($c_y8) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y8) ?></td>
     <td  <?php echo e($jalan); if (num($l_y8) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y8) ?></td>
     <td  <?php echo e($jalan); if (num($pr_y8) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($pr_y8) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($on_y8) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
     <?php }}}}}}}} ?>	      
     <td <?php echo e($jalan) ?> align=center ><?php echo e($final_pr) ?></td>
     <td  <?php echo e($jalan) ?>align=center ><?php echo e($final_on) ?></td>
     <td <?php echo e($jalan) ?> align=center ><?php echo e($final_c) ?></td>
     <td  <?php echo e($jalan) ?>align=center ><?php echo e($final_l) ?></td>

     </tr>
<?php 
			
																	 }	$angka = num($angka) + 1 ;
$l_y0='';$l_y1='';$l_y2='';$l_y3='';$l_y4='';$l_y5='';$l_y6='';$l_y7='';$l_y8='';
$c_y0='';$c_y1='';$c_y2='';$c_y3='';$c_y4='';$c_y5=''; $c_y6='';$c_y7='';$c_y8='';
$pr_y0='';$pr_y1='';$pr_y2='';$pr_y3='';$pr_y4='';$pr_y5='';$pr_y6='';$pr_y7='';$pr_y8=''; 	
$on_y0='';$on_y1='';$on_y2='';$on_y3='';$on_y4='';$on_y5='';$on_y6='';$on_y7='';$on_y8='';	$final_pr ='';$final_c = '';$final_on = '';$final_l = ''; 	}}} } 
		$ttl_on = num((num($angka) - 1)) - num((num($ttl_cancel) + num($ttl_leaving) + num($ttl_pr)));		 
	?>	


</tbody>


<tbody>
 </tbody>
<tfoot>
              </tfoot>
 </table>
   
            </div>
            <!-- /.box-body -->
            <div class="box-body">
			
 

		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		      <tbody>
		        <tr>
		          <td align="right" bgcolor="#FFFFFF"><?php echo e($cabang) ?></td>
		          <td bgcolor="#FFFFFF" align="right">Sales Period :</td>
		          <td colspan="6" align="left" bgcolor="#FFFFFF"><?php echo e($sales_period) ?></td>
		          <td bgcolor="#FFFFFF"  align="center">&nbsp;</td>
		          <td bgcolor="#FFFFFF">&nbsp;</td>
	            </tr>
		        <tr bgcolor="#FFFFFF">
		          <td align="right">Sales Brutto</td>
		          <td align="center"><?php echo e((num($angka) - 1)) ?></td>
		          <td width="9%" align="right">Cancel : </td>
		          <td width="5%" align="left" bgcolor="#FFF72B"><strong><?php echo e($ttl_cancel) ?></strong></td>
		          <td width="10%" align="right">Leaving</td>
		          <td width="4%" align="left"  bgcolor="#08F00D" ><strong><?php echo e($ttl_leaving) ?></strong></td>
		          <td width="10%" align="right">Problem</td>
		          <td width="8%" align="left" bgcolor="#FF0E0E"  ><strong><?php echo e($ttl_pr) ?></strong></td>
		          <td  align="center">&nbsp;</td>
		          <td>&nbsp;</td>
	            </tr>
		        <tr>
		          <td width="5%" align="right">Progress</td>
		          <td width="8%" bgcolor="#D6CBF9" align="center"><strong><?php echo e($ttl_on) ?></strong></td>
		          <td colspan="6"align="right" bgcolor="#FFFFFF">&nbsp;</td>
		          <td width="9%" bgcolor="#FFFFFF"  align="center">&nbsp;</td>
		          <td width="32%" bgcolor="#FFFFFF">&nbsp;</td>
	            </tr>
		        <tr>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td colspan="6">&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
	            </tr>
	          </tbody>
		      </table>
				           <input type="submit" name="Export" value="Export" />
				           <input type="submit" name="Export_CL" value="Export_CL" />	
				           <input type="submit" name="Export_instituion_CL" value="Export_instituion_CL" />					
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>

      <!-- /.row -->
   </section>
   <section class="content">
      <div class="row">
        <!-- /.col -->
     </div></div>

     <!-- /.row -->
   </section>
   
    <!-- /.content -->
  </form> 
</div>
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
<?php
if (isset($_GET['new'])) 
{
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('prestuadmprogress.php');\n";				
		echo "</script>";}
if (isset($_GET['reset'])) 
{
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('admission_progress.php');\n";				
		echo "</script>";
}
if (isset($_GET['Export'])) 
{
echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('carry_on_student_xl.php?kdc=" . e(u($kd_cbg)) . "&sp=" . e(u($sales_period)) . "');\n";				
		echo "</script>";
}
if (isset($_GET['Export_CL'])) 
{
echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('carry_on_student_xl_l_c.php?kdc=" . e(u($kd_cbg)) . "&sp=" . e(u($sales_period)) . "');\n";				
		echo "</script>";
}	
if (isset($_GET['Export_instituion_CL'])) 
{
echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('institution_country_xl.php?kdc=" . e(u($kd_cbg)) . "&sp=" . e(u($sales_period)) . "');\n";				
		echo "</script>";
}						  
?>