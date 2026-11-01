<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$sales_year = '26';
$kd_cbg = in_val('kd_cbg', 'get');



$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$week = in_val('week', 'get');
$query = q_set($__p_query, "SELECT no_week, tgl_periode, bulan FROM master_date where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);

$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$urut_week= $row[0];
		$tgl_periode = $row[1];
	}
}
$sql = q_set($__p_sql, "SELECT min(detail), max(detail),date_format(detail,'%Y-%m') ,date_format(detail,'%Y'), date_format(min(detail),'%d %b'),date_format(max(detail),'%d %b %Y') FROM ves_data.tb_minggu_detail where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);

$rs = db_query_soft($sql, $__p_sql ?? []);
while($row = db_fetch($rs))
{
	$awal_mgg= $row[0];
	$akhir_mgg = $row[1];	$akhir_mgg_display = $row[5];
	$dtl_bln = $row[2];
	$dtl_thn = $row[3];
	
	$awal_bln = "$dtl_bln-01";
	$awal_thn = "$dtl_thn-01-01";
	
}

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
<style>
     .table th {
        font-size: 12px;
    }
	.table td  {
        font-size: 12px;
    }
</style>	
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_daily_report.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>VIP  Situation<br>
     </h1>
     <?php 

$query_reg_tw = q_set($__p_query_reg_tw, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es,\r
count(case when kd_branch = 2 then kd_biodata end) as ws,\r
count(case when kd_branch = 3 then kd_biodata end) as dps,\r
count(case when kd_branch = 8 then kd_biodata end) as mlg,\r
count(case when kd_branch = 4 then kd_biodata end) as sj,\r
count(case when kd_branch = 5 then kd_biodata end) as nj,\r
count(case when kd_branch = 6 then kd_biodata end) as wj,\r
count(case when kd_branch = 7 then kd_biodata end) as bdg,\r
count(case when kd_branch = 11 then kd_biodata end) as pik\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment = 'Registration'", [(string) ($awal_mgg), (string) ($akhir_mgg)]);			

$total_rp = 0;
$no_urut = 1;
?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         
         <tr>
           <th width="11%" scope="row">Week</th>
           <td width="89%"><select name="week"  onChange="this.form.submit()"  class="style33" id="nmr_minggu">
			 <?php
			$sql = q_set($__p_sql, "select minggu, no_week from master_date where sales_year = ? group by minggu order by no_week ", [(string) ($sales_year)]);
			$rs = db_query_soft($sql, $__p_sql ?? []);
			while($row = db_fetch($rs))
			{
			  echo "<option value=\"".e($row['minggu'])."\">".e($row['minggu'])."</option>\n  ";
			}
			?>             
	 	<option selected><?php echo e($week) ?></option>
            </select></td>
         </tr>
         <tr>
           <th scope="row">Period Date</th>
           <td>
             <?php echo e($awal_mgg) ?> to <?php echo e($akhir_mgg) ?>
</td>
         </tr>
       </tbody>
     </table>
   

   </section>
<?php
$query_reg_tw = q_set($__p_query_reg_tw, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment = 'Registration'", [(string) ($awal_mgg), (string) ($akhir_mgg)]);		
$result_reg_tw=db_query_or_die("Wah error nih122", $query_reg_tw, $__p_query_reg_tw ?? []);
while ($r_reg_tw = db_fetch($result_reg_tw))
	{ 
$reg_pax_1_tw = $r_reg_tw['0']; $reg_amount_1_tw = $r_reg_tw['1'];$reg_pax_2_tw = $r_reg_tw['2'];$reg_amount_2_tw = $r_reg_tw['3'];$reg_pax_3_tw = $r_reg_tw['4'];$reg_amount_3_tw = $r_reg_tw['5'];$reg_pax_8_tw = $r_reg_tw['6'];$reg_amount_8_tw = $r_reg_tw['7'];$reg_pax_4_tw = $r_reg_tw['8'];
$reg_amount_4_tw = $r_reg_tw['9'];$reg_pax_5_tw = $r_reg_tw['10'];$reg_amount_5_tw = $r_reg_tw['11'];$reg_pax_6_tw = $r_reg_tw['12'];$reg_amount_6_tw = $r_reg_tw['13'];$reg_pax_7_tw = $r_reg_tw['14'];$reg_amount_7_tw = $r_reg_tw['15'];$reg_pax_11_tw = $r_reg_tw['16'];$reg_amount_11_tw = $r_reg_tw['17'];
	}	
$query_reg_month = q_set($__p_query_reg_month, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment = 'Registration'", [(string) ($awal_bln), (string) ($akhir_mgg)]);	
$result_reg_month=db_query_or_die("Wah error nih122", $query_reg_month, $__p_query_reg_month ?? []);
while ($r_reg_month = db_fetch($result_reg_month))
	{ 
$reg_pax_1_month = $r_reg_month['0']; $reg_amount_1_month = $r_reg_month['1'];$reg_pax_2_month = $r_reg_month['2'];$reg_amount_2_month = $r_reg_month['3'];$reg_pax_3_month = $r_reg_month['4'];$reg_amount_3_month = $r_reg_month['5'];$reg_pax_8_month = $r_reg_month['6'];$reg_amount_8_month = $r_reg_month['7'];$reg_pax_4_month = $r_reg_month['8'];$reg_amount_4_month = $r_reg_month['9'];$reg_pax_5_month = $r_reg_month['10'];$reg_amount_5_month = $r_reg_month['11'];$reg_pax_6_month = $r_reg_month['12'];$reg_amount_6_month = $r_reg_month['13'];$reg_pax_7_month = $r_reg_month['14'];$reg_amount_7_month = $r_reg_month['15'];$reg_pax_11_month = $r_reg_month['16'];$reg_amount_11_month = $r_reg_month['17'];

	}
$query_reg_year = q_set($__p_query_reg_year, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment = 'Registration'", [(string) ($awal_thn), (string) ($akhir_mgg)]);	
$result_reg_year=db_query_or_die("Wah error nih122", $query_reg_year, $__p_query_reg_year ?? []);
while ($r_reg_year = db_fetch($result_reg_year))
	{ 
$reg_pax_1_year = $r_reg_year['0']; $reg_amount_1_year = $r_reg_year['1'];$reg_pax_2_year = $r_reg_year['2'];$reg_amount_2_year = $r_reg_year['3'];$reg_pax_3_year = $r_reg_year['4'];$reg_amount_3_year = $r_reg_year['5'];$reg_pax_8_year = $r_reg_year['6'];$reg_amount_8_year = $r_reg_year['7'];$reg_pax_4_year = $r_reg_year['8'];$reg_amount_4_year = $r_reg_year['9'];$reg_pax_5_year = $r_reg_year['10'];$reg_amount_5_year = $r_reg_year['11'];$reg_pax_6_year = $r_reg_year['12'];$reg_amount_6_year = $r_reg_year['13'];$reg_pax_7_year = $r_reg_year['14'];$reg_amount_7_year = $r_reg_year['15'];$reg_pax_11_year = $r_reg_year['16'];$reg_amount_11_year = $r_reg_year['17'];

	}
			
$query_dp_tw = q_set($__p_query_dp_tw, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment = 'Down Payment'", [(string) ($awal_mgg), (string) ($akhir_mgg)]);	
$result_dp_tw=db_query_or_die("Wah error nih122", $query_dp_tw, $__p_query_dp_tw ?? []);
while ($r_dp_tw = db_fetch($result_dp_tw))
	{ 
$dp_pax_1_tw = $r_dp_tw['0']; $dp_amount_1_tw = $r_dp_tw['1'];$dp_pax_2_tw = $r_dp_tw['2'];$dp_amount_2_tw = $r_dp_tw['3'];$dp_pax_3_tw = $r_dp_tw['4'];$dp_amount_3_tw = $r_dp_tw['5'];$dp_pax_8_tw = $r_dp_tw['6'];$dp_amount_8_tw = $r_dp_tw['7'];$dp_pax_4_tw = $r_dp_tw['8'];
$dp_amount_4_tw = $r_dp_tw['9'];$dp_pax_5_tw = $r_dp_tw['10'];$dp_amount_5_tw = $r_dp_tw['11'];$dp_pax_6_tw = $r_dp_tw['12'];$dp_amount_6_tw = $r_dp_tw['13'];$dp_pax_7_tw = $r_dp_tw['14'];$dp_amount_7_tw = $r_dp_tw['15'];$dp_pax_11_tw = $r_dp_tw['16'];$dp_amount_11_tw = $r_dp_tw['17'];
	}	
$query_dp_month = q_set($__p_query_dp_month, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment = 'Down Payment'", [(string) ($awal_bln), (string) ($akhir_mgg)]);	
$result_dp_month=db_query_or_die("Wah error nih122", $query_dp_month, $__p_query_dp_month ?? []);
while ($r_dp_month = db_fetch($result_dp_month))
	{ 
$dp_pax_1_month = $r_dp_month['0']; $dp_amount_1_month = $r_dp_month['1'];$dp_pax_2_month = $r_dp_month['2'];$dp_amount_2_month = $r_dp_month['3'];$dp_pax_3_month = $r_dp_month['4'];$dp_amount_3_month = $r_dp_month['5'];$dp_pax_8_month = $r_dp_month['6'];$dp_amount_8_month = $r_dp_month['7'];$dp_pax_4_month = $r_dp_month['8'];$dp_amount_4_month = $r_dp_month['9'];$dp_pax_5_month = $r_dp_month['10'];$dp_amount_5_month = $r_dp_month['11'];$dp_pax_6_month = $r_dp_month['12'];$dp_amount_6_month = $r_dp_month['13'];$dp_pax_7_month = $r_dp_month['14'];$dp_amount_7_month = $r_dp_month['15'];$dp_pax_11_month = $r_dp_month['16'];$dp_amount_11_month = $r_dp_month['17'];

	}
$query_dp_year = q_set($__p_query_dp_year, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment = 'Down Payment'", [(string) ($awal_thn), (string) ($akhir_mgg)]);		
$result_dp_year=db_query_or_die("Wah error nih122", $query_dp_year, $__p_query_dp_year ?? []);
while ($r_dp_year = db_fetch($result_dp_year))
	{ 
$dp_pax_1_year = $r_dp_year['0']; $dp_amount_1_year = $r_dp_year['1'];$dp_pax_2_year = $r_dp_year['2'];$dp_amount_2_year = $r_dp_year['3'];$dp_pax_3_year = $r_dp_year['4'];$dp_amount_3_year = $r_dp_year['5'];$dp_pax_8_year = $r_dp_year['6'];$dp_amount_8_year = $r_dp_year['7'];$dp_pax_4_year = $r_dp_year['8'];$dp_amount_4_year = $r_dp_year['9'];$dp_pax_5_year = $r_dp_year['10'];$dp_amount_5_year = $r_dp_year['11'];$dp_pax_6_year = $r_dp_year['12'];$dp_amount_6_year = $r_dp_year['13'];$dp_pax_7_year = $r_dp_year['14'];$dp_amount_7_year = $r_dp_year['15'];$dp_pax_11_year = $r_dp_year['16'];$dp_amount_11_year = $r_dp_year['17'];

	}

$query_inst_tw = q_set($__p_query_inst_tw, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment like 'Instal%'", [(string) ($awal_mgg), (string) ($akhir_mgg)]);		
$result_inst_tw=db_query_or_die("Wah error nih122", $query_inst_tw, $__p_query_inst_tw ?? []);
while ($r_inst_tw = db_fetch($result_inst_tw))
	{ 
$inst_paxx_1_tw = $r_inst_tw['0']; $inst_amount_1_tw = $r_inst_tw['1'];$inst_paxx_2_tw = $r_inst_tw['2'];$inst_amount_2_tw = $r_inst_tw['3'];$inst_paxx_3_tw = $r_inst_tw['4'];$inst_amount_3_tw = $r_inst_tw['5'];$inst_paxx_8_tw = $r_inst_tw['6'];$inst_amount_8_tw = $r_inst_tw['7'];$inst_paxx_4_tw = $r_inst_tw['8'];
$inst_amount_4_tw = $r_inst_tw['9'];$inst_paxx_5_tw = $r_inst_tw['10'];$inst_amount_5_tw = $r_inst_tw['11'];$inst_paxx_6_tw = $r_inst_tw['12'];$inst_amount_6_tw = $r_inst_tw['13'];$inst_paxx_7_tw = $r_inst_tw['14'];$inst_amount_7_tw = $r_inst_tw['15'];$inst_paxx_11_tw = $r_inst_tw['16'];$inst_amount_11_tw = $r_inst_tw['17'];
	}	
$query_inst_month = q_set($__p_query_inst_month, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment like 'Instal%'", [(string) ($awal_bln), (string) ($akhir_mgg)]);	
$result_inst_month=db_query_or_die("Wah error nih122", $query_inst_month, $__p_query_inst_month ?? []);
while ($r_inst_month = db_fetch($result_inst_month))
	{ 
$inst_paxx_1_month = $r_inst_month['0']; $inst_amount_1_month = $r_inst_month['1'];$inst_paxx_2_month = $r_inst_month['2'];$inst_amount_2_month = $r_inst_month['3'];$inst_paxx_3_month = $r_inst_month['4'];$inst_amount_3_month = $r_inst_month['5'];$inst_paxx_8_month = $r_inst_month['6'];$inst_amount_8_month = $r_inst_month['7'];$inst_paxx_4_month = $r_inst_month['8'];$inst_amount_4_month = $r_inst_month['9'];$inst_paxx_5_month = $r_inst_month['10'];$inst_amount_5_month = $r_inst_month['11'];$inst_paxx_6_month = $r_inst_month['12'];$inst_amount_6_month = $r_inst_month['13'];$inst_paxx_7_month = $r_inst_month['14'];$inst_amount_7_month = $r_inst_month['15'];$inst_paxx_11_month = $r_inst_month['16'];$inst_amount_11_month = $r_inst_month['17'];

	}
$query_inst_year = q_set($__p_query_inst_year, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment like 'Instal%'", [(string) ($awal_thn), (string) ($akhir_mgg)]);		
$result_inst_year=db_query_or_die("Wah error nih122", $query_inst_year, $__p_query_inst_year ?? []);
while ($r_inst_year = db_fetch($result_inst_year))
	{ 
$inst_paxx_1_year = $r_inst_year['0']; $inst_amount_1_year = $r_inst_year['1'];$inst_paxx_2_year = $r_inst_year['2'];$inst_amount_2_year = $r_inst_year['3'];$inst_paxx_3_year = $r_inst_year['4'];$inst_amount_3_year = $r_inst_year['5'];$inst_paxx_8_year = $r_inst_year['6'];$inst_amount_8_year = $r_inst_year['7'];$inst_paxx_4_year = $r_inst_year['8'];$inst_amount_4_year = $r_inst_year['9'];$inst_paxx_5_year = $r_inst_year['10'];$inst_amount_5_year = $r_inst_year['11'];$inst_paxx_6_year = $r_inst_year['12'];$inst_amount_6_year = $r_inst_year['13'];$inst_paxx_7_year = $r_inst_year['14'];$inst_amount_7_year = $r_inst_year['15'];$inst_paxx_11_year = $r_inst_year['16'];$inst_amount_11_year = $r_inst_year['17'];

	}
			
$query_full_tw = q_set($__p_query_full_tw, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment like 'Full%'", [(string) ($awal_mgg), (string) ($akhir_mgg)]);
$result_full_tw=db_query_or_die("Wah error nih122", $query_full_tw, $__p_query_full_tw ?? []);
while ($r_full_tw = db_fetch($result_full_tw))
	{ 
$full_pax_1_tw = $r_full_tw['0']; $full_amount_1_tw = $r_full_tw['1'];$full_pax_2_tw = $r_full_tw['2'];$full_amount_2_tw = $r_full_tw['3'];$full_pax_3_tw = $r_full_tw['4'];$full_amount_3_tw = $r_full_tw['5'];$full_pax_8_tw = $r_full_tw['6'];$full_amount_8_tw = $r_full_tw['7'];$full_pax_4_tw = $r_full_tw['8'];
$full_amount_4_tw = $r_full_tw['9'];$full_pax_5_tw = $r_full_tw['10'];$full_amount_5_tw = $r_full_tw['11'];$full_pax_6_tw = $r_full_tw['12'];$full_amount_6_tw = $r_full_tw['13'];$full_pax_7_tw = $r_full_tw['14'];$full_amount_7_tw = $r_full_tw['15'];$full_pax_11_tw = $r_full_tw['16'];$full_amount_11_tw = $r_full_tw['17'];
	}	
$query_full_month = q_set($__p_query_full_month, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment like 'Full%'", [(string) ($awal_bln), (string) ($akhir_mgg)]);	
$result_full_month=db_query_or_die("Wah error nih122", $query_full_month, $__p_query_full_month ?? []);
while ($r_full_month = db_fetch($result_full_month))
	{ 
$full_pax_1_month = $r_full_month['0']; $full_amount_1_month = $r_full_month['1'];$full_pax_2_month = $r_full_month['2'];$full_amount_2_month = $r_full_month['3'];$full_pax_3_month = $r_full_month['4'];$full_amount_3_month = $r_full_month['5'];$full_pax_8_month = $r_full_month['6'];$full_amount_8_month = $r_full_month['7'];$full_pax_4_month = $r_full_month['8'];$full_amount_4_month = $r_full_month['9'];$full_pax_5_month = $r_full_month['10'];$full_amount_5_month = $r_full_month['11'];$full_pax_6_month = $r_full_month['12'];$full_amount_6_month = $r_full_month['13'];$full_pax_7_month = $r_full_month['14'];$full_amount_7_month = $r_full_month['15'];$full_pax_11_month = $r_full_month['16'];$full_amount_11_month = $r_full_month['17'];

	}
$query_full_year = q_set($__p_query_full_year, "SELECT\r
count(case when kd_branch = 1 then kd_biodata end) as es_pax1, sum(case when kd_branch = 1 then amount end) as es_amount1, count(case when kd_branch = 2 then kd_biodata end) as es_pax2, sum(case when kd_branch = 2 then amount end) as es_amount2, count(case when kd_branch = 3 then kd_biodata end) as es_pax3, sum(case when kd_branch = 3 then amount end) as es_amount3, count(case when kd_branch = 8 then kd_biodata end) as es_pax8, sum(case when kd_branch = 8 then amount end) as es_amount8, count(case when kd_branch = 4 then kd_biodata end) as es_pax4, sum(case when kd_branch = 4 then amount end) as es_amount4, count(case when kd_branch = 5 then kd_biodata end) as es_pax5, sum(case when kd_branch = 5 then amount end) as es_amount5, count(case when kd_branch = 6 then kd_biodata end) as es_pax6, sum(case when kd_branch = 6 then amount end) as es_amount6, count(case when kd_branch = 7 then kd_biodata end) as es_pax7, sum(case when kd_branch = 7 then amount end) as es_amount7, count(case when kd_branch = 11 then kd_biodata end) as es_pax11, sum(case when kd_branch = 11 then amount end) as es_amount11\r
FROM vip_billing_payment\r
where id_receipt  <> '' and dt_payment between ? and ? and jns_payment like 'Full%'", [(string) ($awal_thn), (string) ($akhir_mgg)]);		
$result_full_year=db_query_or_die("Wah error nih122", $query_full_year, $__p_query_full_year ?? []);
while ($r_full_year = db_fetch($result_full_year))
	{ 
$full_pax_1_year = $r_full_year['0']; $full_amount_1_year = $r_full_year['1'];$full_pax_2_year = $r_full_year['2'];$full_amount_2_year = $r_full_year['3'];$full_pax_3_year = $r_full_year['4'];$full_amount_3_year = $r_full_year['5'];$full_pax_8_year = $r_full_year['6'];$full_amount_8_year = $r_full_year['7'];$full_pax_4_year = $r_full_year['8'];$full_amount_4_year = $r_full_year['9'];$full_pax_5_year = $r_full_year['10'];$full_amount_5_year = $r_full_year['11'];$full_pax_6_year = $r_full_year['12'];$full_amount_6_year = $r_full_year['13'];$full_pax_7_year = $r_full_year['14'];$full_amount_7_year = $r_full_year['15'];$full_pax_11_year = $r_full_year['16'];$full_amount_11_year = $r_full_year['17'];

	}

	

	$ttl_1 = num($ttl_1_reg)+ num($ttl_1_dp) + num($ttl_1_inst) + num($ttl_1_material) + num($ttl_1_full);
	$ttl_2 = num($ttl_2_reg)+ num($ttl_2_dp) + num($ttl_2_inst) + num($ttl_2_material) + num($ttl_2_full);
	$ttl_3 = num($ttl_3_reg)+ num($ttl_3_dp) + num($ttl_3_inst) + num($ttl_3_material) + num($ttl_3_full);
	$ttl_4 = num($ttl_4_reg)+ num($ttl_4_dp) + num($ttl_4_inst) + num($ttl_4_material) + num($ttl_4_full);
	$ttl_5 = num($ttl_5_reg)+ num($ttl_5_dp) + num($ttl_5_inst) + num($ttl_5_material) + num($ttl_5_full);
	$ttl_6 = num($ttl_6_reg)+ num($ttl_6_dp) + num($ttl_6_inst) + num($ttl_6_material) + num($ttl_6_full);
	$ttl_7 = num($ttl_7_reg)+ num($ttl_7_dp) + num($ttl_7_inst) + num($ttl_7_material) + num($ttl_7_full);
		$ttl_8 = num($ttl_8_reg)+ num($ttl_8_dp) + num($ttl_8_inst) + num($ttl_8_material) + num($ttl_8_full);
	$ttl_11 = num($ttl_11_reg)+ num($ttl_11_dp) + num($ttl_11_inst) + num($ttl_11_material) + num($ttl_11_full);


?>

<!-- Main content -->
    <section class="content">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
          <table width="40%"  class="table table-bordered table-striped" id="example1">
       <tbody>
         <tr>
           <th colspan="4" scope="row"><strong>VIP ALL Center </strong>Summary Income</th>
           <th width="9%" scope="row">&nbsp;</th>
           <th width="8%" scope="row">&nbsp;</th>
           <th width="8%" scope="row">&nbsp;</th>
           <th width="8%" scope="row">&nbsp;</th>
           <th width="8%" scope="row">&nbsp;</th>
           <th width="10%" scope="row">&nbsp;</th>
           <th width="6%" scope="row">&nbsp;</th>
           <th width="9%" scope="row">&nbsp;</th>
           <th width="9%" scope="row">&nbsp;</th>
           <th width="11%" scope="row">&nbsp;</th>
           <th width="11%" scope="row">&nbsp;</th>
           <th colspan="7" scope="row">Period : <?php echo e($awal_mgg) ?> to <?php echo e($akhir_mgg_display) ?></th>
           </tr>
         <tr>
           <th width="6%" scope="row">Center</th>
           <td width="11%">&nbsp;</td>
           <td colspan="2" align="center">East Sby</td>
           <td colspan="2" align="center">West Sby</td>
           <td colspan="2" align="center">Denpasar</td>
           <td colspan="2" align="center">Malang</td>
           <td colspan="2" align="center">South  Jkt</td>
           <td colspan="2" align="center">North Jkt</td>
           <td colspan="2" align="center">West Jkt</td>
           <td colspan="2" align="center">Bandung</td>
           <td colspan="2" align="center">PIK</td>
           <td colspan="2" align="center">Grand Total</td>
           </tr>
         <tr>
           <th scope="row">&nbsp;</th>
           <td>&nbsp;</td>
           <td width="11%">Pax</td>
           <td width="9%">Amount</td>
           <td>Pax</td>
           <td>Amount</td>
           <td>Pax</td>
           <td>Amount</td>
           <td>Pax</td>
           <td>Amount</td>
           <td>Pax</td>
           <td>Amount</td>
           <td>Pax</td>
           <td>Amount</td>
           <td>Pax</td>
           <td width="7%">Amount</td>
           <td width="7%">Pax</td>
           <td width="6%">Amount</td>
           <td width="9%">Pax</td>
           <td width="9%">Amount</td>
           <td width="9%">Pax</td>
           <td width="9%">Amount</td>
           </tr>
         <tr>
           <th rowspan="3" style="vertical-align: middle" scope="row">Registration</th>
           <td>This Week</td>
<td><?php echo number_format(num($reg_pax_1_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_1_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_2_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_2_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_3_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_3_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_8_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_8_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_4_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_4_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_5_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_5_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_6_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_6_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_7_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_7_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_11_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_11_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_1_tw) + num($reg_pax_2_tw) + num($reg_pax_3_tw) +num($reg_pax_8_tw) +num($reg_pax_4_tw) +num($reg_pax_5_tw) +num($reg_pax_6_tw) +num($reg_pax_7_tw) +num($reg_pax_11_tw),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_1_tw) + num($reg_amount_2_tw) + num($reg_amount_3_tw) +num($reg_amount_8_tw) +num($reg_amount_4_tw) +num($reg_amount_5_tw) +num($reg_amount_6_tw) +num($reg_amount_7_tw) +num($reg_amount_11_tw),0,".",".") ?></td>



           </tr>
         <tr>
           <td>Month</td>
<td><?php echo number_format(num($reg_pax_1_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_1_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_2_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_2_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_3_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_3_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_8_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_8_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_4_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_4_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_5_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_5_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_6_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_6_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_7_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_7_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_11_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_11_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_pax_1_month) + num($reg_pax_2_month) + num($reg_pax_3_month) +num($reg_pax_8_month) +num($reg_pax_4_month) +num($reg_pax_5_month) +num($reg_pax_6_month) +num($reg_pax_7_month) +num($reg_pax_11_month),0,".",".") ?></td>
<td><?php echo number_format(num($reg_amount_1_month) + num($reg_amount_2_month) + num($reg_amount_3_month) +num($reg_amount_8_month) +num($reg_amount_4_month) +num($reg_amount_5_month) +num($reg_amount_6_month) +num($reg_amount_7_month) +num($reg_amount_11_month),0,".",".") ?></td>

         </tr>
         <tr>
           <td>Year</td>
  <td><?php echo number_format(num($reg_pax_1_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_1_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_pax_2_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_2_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_pax_3_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_3_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_pax_8_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_8_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_pax_4_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_4_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_pax_5_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_5_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_pax_6_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_6_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_pax_7_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_7_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_pax_11_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_11_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_pax_1_year) + num($reg_pax_2_year) + num($reg_pax_3_year) +num($reg_pax_8_year) +num($reg_pax_4_year) +num($reg_pax_5_year) +num($reg_pax_6_year) +num($reg_pax_7_year) +num($reg_pax_11_year),0,".",".") ?></td>
  <td><?php echo number_format(num($reg_amount_1_year) + num($reg_amount_2_year) + num($reg_amount_3_year) +num($reg_amount_8_year) +num($reg_amount_4_year) +num($reg_amount_5_year) +num($reg_amount_6_year) +num($reg_amount_7_year) +num($reg_amount_11_year),0,".",".") ?></td>
           
         </tr>
<tr>
           <th rowspan="3" style="vertical-align: middle" scope="row">Down Payment</th>
           <td>This Week</td>
           <td><?php echo number_format(num($dp_pax_1_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_1_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_2_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_2_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_3_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_3_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_8_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_8_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_4_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_4_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_5_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_5_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_6_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_6_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_7_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_7_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_1_tw) + num($dp_pax_2_tw) + num($dp_pax_3_tw) +num($dp_pax_8_tw) +num($dp_pax_4_tw) +num($dp_pax_5_tw) +num($dp_pax_6_tw) +num($dp_pax_7_tw) +num($dp_pax_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_1_tw) + num($dp_amount_2_tw) + num($dp_amount_3_tw) +num($dp_amount_8_tw) +num($dp_amount_4_tw) +num($dp_amount_5_tw) +num($dp_amount_6_tw) +num($dp_amount_7_tw) +num($dp_amount_11_tw),0,".",".") ?></td>
         </tr>
         <tr>
           <td>Month</td>
           <td><?php echo number_format(num($dp_pax_1_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_1_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_2_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_2_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_3_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_3_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_8_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_8_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_4_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_4_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_5_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_5_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_6_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_6_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_7_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_7_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_1_month) + num($dp_pax_2_month) + num($dp_pax_3_month) +num($dp_pax_8_month) +num($dp_pax_4_month) +num($dp_pax_5_month) +num($dp_pax_6_month) +num($dp_pax_7_month) +num($dp_pax_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_1_month) + num($dp_amount_2_month) + num($dp_amount_3_month) +num($dp_amount_8_month) +num($dp_amount_4_month) +num($dp_amount_5_month) +num($dp_amount_6_month) +num($dp_amount_7_month) +num($dp_amount_11_month),0,".",".") ?></td>
         </tr>
         <tr>
           <td>Year</td>
           <td><?php echo number_format(num($dp_pax_1_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_1_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_2_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_2_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_3_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_3_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_8_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_8_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_4_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_4_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_5_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_5_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_6_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_6_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_7_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_7_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_pax_1_year) + num($dp_pax_2_year) + num($dp_pax_3_year) +num($dp_pax_8_year) +num($dp_pax_4_year) +num($dp_pax_5_year) +num($dp_pax_6_year) +num($dp_pax_7_year) +num($dp_pax_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($dp_amount_1_year) + num($dp_amount_2_year) + num($dp_amount_3_year) +num($dp_amount_8_year) +num($dp_amount_4_year) +num($dp_amount_5_year) +num($dp_amount_6_year) +num($dp_amount_7_year) +num($dp_amount_11_year),0,".",".") ?></td>
         </tr>

         <tr>
           <th rowspan="3" style="vertical-align: middle" scope="row">Installment</th>
           <td>This Week</td>
           <td><?php echo number_format(num($inst_pax_1_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_1_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_2_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_2_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_3_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_3_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_8_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_8_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_4_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_4_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_5_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_5_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_6_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_6_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_7_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_7_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_1_tw) + num($inst_pax_2_tw) + num($inst_pax_3_tw) +num($inst_pax_8_tw) +num($inst_pax_4_tw) +num($inst_pax_5_tw) +num($inst_pax_6_tw) +num($inst_pax_7_tw) +num($inst_pax_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_1_tw) + num($inst_amount_2_tw) + num($inst_amount_3_tw) +num($inst_amount_8_tw) +num($inst_amount_4_tw) +num($inst_amount_5_tw) +num($inst_amount_6_tw) +num($inst_amount_7_tw) +num($inst_amount_11_tw),0,".",".") ?></td>
         </tr>
         <tr>
           <td>Month</td>
           <td><?php echo number_format(num($inst_pax_1_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_1_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_2_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_2_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_3_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_3_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_8_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_8_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_4_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_4_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_5_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_5_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_6_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_6_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_7_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_7_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_1_month) + num($inst_pax_2_month) + num($inst_pax_3_month) +num($inst_pax_8_month) +num($inst_pax_4_month) +num($inst_pax_5_month) +num($inst_pax_6_month) +num($inst_pax_7_month) +num($inst_pax_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_1_month) + num($inst_amount_2_month) + num($inst_amount_3_month) +num($inst_amount_8_month) +num($inst_amount_4_month) +num($inst_amount_5_month) +num($inst_amount_6_month) +num($inst_amount_7_month) +num($inst_amount_11_month),0,".",".") ?></td>
         </tr>
         <tr>
           <td>Year</td>
           <td><?php echo number_format(num($inst_pax_1_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_1_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_2_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_2_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_3_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_3_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_8_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_8_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_4_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_4_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_5_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_5_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_6_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_6_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_7_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_7_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_pax_1_year) + num($inst_pax_2_year) + num($inst_pax_3_year) +num($inst_pax_8_year) +num($inst_pax_4_year) +num($inst_pax_5_year) +num($inst_pax_6_year) +num($inst_pax_7_year) +num($inst_pax_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($inst_amount_1_year) + num($inst_amount_2_year) + num($inst_amount_3_year) +num($inst_amount_8_year) +num($inst_amount_4_year) +num($inst_amount_5_year) +num($inst_amount_6_year) +num($inst_amount_7_year) +num($inst_amount_11_year),0,".",".") ?></td>
         </tr>

         <tr>
           <th rowspan="3" style="vertical-align: middle" scope="row">Full Payment</th>
           <td>This Week</td>
           <td><?php echo number_format(num($full_pax_1_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_1_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_2_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_2_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_3_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_3_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_8_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_8_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_4_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_4_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_5_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_5_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_6_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_6_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_7_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_7_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_1_tw) + num($full_pax_2_tw) + num($full_pax_3_tw) +num($full_pax_8_tw) +num($full_pax_4_tw) +num($full_pax_5_tw) +num($full_pax_6_tw) +num($full_pax_7_tw) +num($full_pax_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_1_tw) + num($full_amount_2_tw) + num($full_amount_3_tw) +num($full_amount_8_tw) +num($full_amount_4_tw) +num($full_amount_5_tw) +num($full_amount_6_tw) +num($full_amount_7_tw) +num($full_amount_11_tw),0,".",".") ?></td>
         </tr>
         <tr>
           <td>Month</td>
           <td><?php echo number_format(num($full_pax_1_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_1_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_2_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_2_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_3_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_3_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_8_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_8_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_4_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_4_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_5_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_5_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_6_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_6_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_7_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_7_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_1_month) + num($full_pax_2_month) + num($full_pax_3_month) +num($full_pax_8_month) +num($full_pax_4_month) +num($full_pax_5_month) +num($full_pax_6_month) +num($full_pax_7_month) +num($full_pax_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_1_month) + num($full_amount_2_month) + num($full_amount_3_month) +num($full_amount_8_month) +num($full_amount_4_month) +num($full_amount_5_month) +num($full_amount_6_month) +num($full_amount_7_month) +num($full_amount_11_month),0,".",".") ?></td>
         </tr>
         <tr>
           <td>Year</td>
           <td><?php echo number_format(num($full_pax_1_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_1_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_2_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_2_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_3_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_3_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_8_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_8_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_4_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_4_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_5_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_5_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_6_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_6_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_7_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_7_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_pax_1_year) + num($full_pax_2_year) + num($full_pax_3_year) +num($full_pax_8_year) +num($full_pax_4_year) +num($full_pax_5_year) +num($full_pax_6_year) +num($full_pax_7_year) +num($full_pax_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($full_amount_1_year) + num($full_amount_2_year) + num($full_amount_3_year) +num($full_amount_8_year) +num($full_amount_4_year) +num($full_amount_5_year) +num($full_amount_6_year) +num($full_amount_7_year) +num($full_amount_11_year),0,".",".") ?></td>
         </tr>

         <tr>
           <th rowspan="3" style="vertical-align: middle" scope="row">TOTAL AMOUNT</th>
           <td>This Week</td>
           <td>&nbsp;</td>
           <td><?php echo number_format(num($reg_amount_1_tw) + num($dp_amount_1_tw) + num($inst_amount_1_tw) + num($full_amount_1_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_2_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_2_tw) + num($dp_amount_2_tw) + num($inst_amount_2_tw) + num($full_amount_2_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_3_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_3_tw) + num($dp_amount_3_tw) + num($inst_amount_3_tw) + num($full_amount_3_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_8_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_8_tw) + num($dp_amount_8_tw) + num($inst_amount_8_tw) + num($full_amount_8_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_4_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_4_tw) + num($dp_amount_4_tw) + num($inst_amount_4_tw) + num($full_amount_4_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_5_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_5_tw) + num($dp_amount_5_tw) + num($inst_amount_5_tw) + num($full_amount_5_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_6_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_6_tw) + num($dp_amount_6_tw) + num($inst_amount_6_tw) + num($full_amount_6_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_7_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_7_tw) + num($dp_amount_7_tw) + num($inst_amount_7_tw) + num($full_amount_7_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_11_tw) + num($dp_amount_11_tw) + num($inst_amount_11_tw) + num($full_amount_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_1_tw) + num($full_pax_2_tw) + num($full_pax_3_tw) +num($full_pax_8_tw) +num($full_pax_4_tw) +num($full_pax_5_tw) +num($full_pax_6_tw) +num($full_pax_7_tw) +num($full_pax_11_tw),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_1_tw) + num($dp_amount_1_tw) + num($inst_amount_1_tw) + num($full_amount_1_tw) +
num($reg_amount_2_tw) + num($dp_amount_2_tw) + num($inst_amount_2_tw) + num($full_amount_2_tw) +
num($reg_amount_3_tw) + num($dp_amount_3_tw) + num($inst_amount_3_tw) + num($full_amount_3_tw) +
num($reg_amount_8_tw) + num($dp_amount_8_tw) + num($inst_amount_8_tw) + num($full_amount_8_tw) +
num($reg_amount_4_tw) + num($dp_amount_4_tw) + num($inst_amount_4_tw) + num($full_amount_4_tw) +
num($reg_amount_5_tw) + num($dp_amount_5_tw) + num($inst_amount_5_tw) + num($full_amount_5_tw) +
num($reg_amount_6_tw) + num($dp_amount_6_tw) + num($inst_amount_6_tw) + num($full_amount_6_tw) +
num($reg_amount_7_tw) + num($dp_amount_7_tw) + num($inst_amount_7_tw) + num($full_amount_7_tw) +
num($reg_amount_11_tw) + num($dp_amount_11_tw) + num($inst_amount_11_tw) + num($full_amount_11_tw) 
 
,0,".",".") ?></td>
         </tr>
         <tr>
           <td>Month</td>
           <td>&nbsp;</td>
           <td><?php echo number_format(num($reg_amount_1_month) + num($dp_amount_1_month) + num($inst_amount_1_month) + num($full_amount_1_month),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_2_month),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_2_month) + num($dp_amount_2_month) + num($inst_amount_2_month) + num($full_amount_2_month),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_3_month),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_3_month) + num($dp_amount_3_month) + num($inst_amount_3_month) + num($full_amount_3_month),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_8_month),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_8_month) + num($dp_amount_8_month) + num($inst_amount_8_month) + num($full_amount_8_month),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_4_month),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_4_month) + num($dp_amount_4_month) + num($inst_amount_4_month) + num($full_amount_4_month),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_5_month),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_5_month) + num($dp_amount_5_month) + num($inst_amount_5_month) + num($full_amount_5_month),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_6_month),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_6_month) + num($dp_amount_6_month) + num($inst_amount_6_month) + num($full_amount_6_month),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_7_month),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_7_month) + num($dp_amount_7_month) + num($inst_amount_7_month) + num($full_amount_7_month),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_11_month) + num($dp_amount_11_month) + num($inst_amount_11_month) + num($full_amount_11_month),0,".",".") ?></td>

           <td><?php echo number_format(num($full_paxx_1_month) + num($full_pax_2_month) + num($full_pax_3_month) +num($full_pax_8_month) +num($full_pax_4_month) +num($full_pax_5_month) +num($full_pax_6_month) +num($full_pax_7_month) +num($full_pax_11_month),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_1_month) + num($dp_amount_1_month) + num($inst_amount_1_month) + num($full_amount_1_month) +
num($reg_amount_2_month) + num($dp_amount_2_month) + num($inst_amount_2_month) + num($full_amount_2_month) +
num($reg_amount_3_month) + num($dp_amount_3_month) + num($inst_amount_3_month) + num($full_amount_3_month) +
num($reg_amount_8_month) + num($dp_amount_8_month) + num($inst_amount_8_month) + num($full_amount_8_month) +
num($reg_amount_4_month) + num($dp_amount_4_month) + num($inst_amount_4_month) + num($full_amount_4_month) +
num($reg_amount_5_month) + num($dp_amount_5_month) + num($inst_amount_5_month) + num($full_amount_5_month) +
num($reg_amount_6_month) + num($dp_amount_6_month) + num($inst_amount_6_month) + num($full_amount_6_month) +
num($reg_amount_7_month) + num($dp_amount_7_month) + num($inst_amount_7_month) + num($full_amount_7_month) +
num($reg_amount_11_month) + num($dp_amount_11_month) + num($inst_amount_11_month) + num($full_amount_11_month) 
,0,".",".") ?></td>
         </tr>
         <tr>
           <td>Year</td>
           <td>&nbsp;</td>
           <td><?php echo number_format(num($reg_amount_1_year) + num($dp_amount_1_year) + num($inst_amount_1_year) + num($full_amount_1_year),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_2_year),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_2_year) + num($dp_amount_2_year) + num($inst_amount_2_year) + num($full_amount_2_year),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_3_year),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_3_year) + num($dp_amount_3_year) + num($inst_amount_3_year) + num($full_amount_3_year),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_8_year),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_8_year) + num($dp_amount_8_year) + num($inst_amount_8_year) + num($full_amount_8_year),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_4_year),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_4_year) + num($dp_amount_4_year) + num($inst_amount_4_year) + num($full_amount_4_year),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_5_year),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_5_year) + num($dp_amount_5_year) + num($inst_amount_5_year) + num($full_amount_5_year),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_6_year),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_6_year) + num($dp_amount_6_year) + num($inst_amount_6_year) + num($full_amount_6_year),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_7_year),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_7_year) + num($dp_amount_7_year) + num($inst_amount_7_year) + num($full_amount_7_year),0,".",".") ?></td>
           <td><?php echo number_format(num($fullL_paxx_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_11_year) + num($dp_amount_11_year) + num($inst_amount_11_year) + num($full_amount_11_year),0,".",".") ?></td>

           <td><?php echo number_format(num($full_paxx_1_year) + num($full_pax_2_year) + num($full_pax_3_year) +num($full_pax_8_year) +num($full_pax_4_year) +num($full_pax_5_year) +num($full_pax_6_year) +num($full_pax_7_year) +num($full_pax_11_year),0,".",".") ?></td>
           <td><?php echo number_format(num($reg_amount_1_year) + num($dp_amount_1_year) + num($inst_amount_1_year) + num($full_amount_1_year) +
num($reg_amount_2_year) + num($dp_amount_2_year) + num($inst_amount_2_year) + num($full_amount_2_year) +
num($reg_amount_3_year) + num($dp_amount_3_year) + num($inst_amount_3_year) + num($full_amount_3_year) +
num($reg_amount_8_year) + num($dp_amount_8_year) + num($inst_amount_8_year) + num($full_amount_8_year) +
num($reg_amount_4_year) + num($dp_amount_4_year) + num($inst_amount_4_year) + num($full_amount_4_year) +
num($reg_amount_5_year) + num($dp_amount_5_year) + num($inst_amount_5_year) + num($full_amount_5_year) +
num($reg_amount_6_year) + num($dp_amount_6_year) + num($inst_amount_6_year) + num($full_amount_6_year) +
num($reg_amount_7_year) + num($dp_amount_7_year) + num($inst_amount_7_year) + num($full_amount_7_year) +
num($reg_amount_11_year) + num($dp_amount_11_year) + num($inst_amount_11_year) + num($full_amount_11_year) 
,0,".",".") ?></td>
         </tr>
         </tbody>
     </table>          	
            </div>
	  </div>       

	   </section>
    <!-- /.content -->
  </form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">

              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post"><?php echo csrf_field(); ?>

          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
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
      "ordering": false,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
