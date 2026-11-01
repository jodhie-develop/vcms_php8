<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
//include __DIR__ . "/atas.php";
//include __DIR__ . "/left.php";
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$awal_tahun = "$tahun-01-01";
$awal_bulan = "$tahun-$bulan-01";
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');

if ($date_start ==''){$date_start = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}
if ($kd_cbg == ''){$kd_cbg = 100;}
if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
if ($kd_cbg == 'National'){$kd_cbg = 100;}
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}
if ($kd_cbg == 'Serpong'){$kd_cbg = 12;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';$db_cabang ='billing.';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';$db_cabang ='billing_west.';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';$db_cabang ='billing_bali.';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';$db_cabang ='billing_jkt_02.';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';$db_cabang ='billing_new_gs.';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';$db_cabang ='billing_m2.';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';$db_cabang ='billing_new_bdg.';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';$db_cabang ='billing_malang.';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
if (num($kd_cbg) ==100){$cabang = 'National';}
if (num($kd_cbg) ==11){$cabang = 'PIK';}
if (num($kd_cbg) ==12){$cabang = 'Serpong';}


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VIP Report</title>
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
<script>
	
	.table-condensed{
  font-size: 5px;
}
	
</script>	
</head>

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_receiptt.php> 
  <div class="content">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>VIP Income Summary<br>
     </h1>
     <?php 
 if ($cabang =='National')
	{
	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd,a.kd_billing   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' \r
\tand dt_payment between ? and ? group by id_receipt order by id_receipt desc", [(string) ($date_start), (string) ($date_end)]);		
	}
else
	{
	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd,a.kd_billing   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' and a.kd_branch = ?\r
\tand dt_payment between ? and ? group by id_receipt order by id_receipt desc", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);			
	}

$total_rp = 0;
$no_urut = 1;
$result=db_query_or_die("Wah error nih11", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         <tr>
           <th width="11%" scope="row"> Date</th>
           <td width="89%"><small>
             <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
           </small></td>
         </tr>
       </tbody>
     </table>
   

   </section>
<?php


$query_reg = q_set($__p_query_reg, "SELECT kd_branch, sum(amount),\r
sum(case when dt_payment =?  and status = 'PAID' and jns_payment = 'Registration' then amount end) as tdy,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment = 'Registration'  then amount end) as mtd,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment  = 'Registration'  then amount end) as ytd\r
FROM vip_billing_payment a where  dt_payment\r
between ? and ?  and status = 'PAID' and jns_payment  = 'Registration'  group by kd_branch", [(string) ($date_start), (string) ($awal_bulan), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start)]);

$result_reg=db_query_or_die("Wah error nih122", $query_reg, $__p_query_reg ?? []);

while ($r_total_reg = db_fetch($result_reg))
	{ 
	$nomor_cbg = $r_total_reg[0];
	$ttl_amount_reg = $r_total_reg[1];
	$ttl_amount_reg_tdy = $r_total_reg[2];
	$ttl_amount_reg_mtd = $r_total_reg[3];
	$ttl_amount_reg_ytd = $r_total_reg[4];

	if (num($nomor_cbg) == 1){$ttl_1_reg_tdy = $ttl_amount_reg_tdy;$ttl_1_reg_mtd = $ttl_amount_reg_mtd;$ttl_1_reg_ytd = $ttl_amount_reg_ytd;$ttl_1_tdy = num($ttl_1_tdy)+num($ttl_1_reg_tdy);$ttl_1_mtd = num($ttl_1_mtd)+num($ttl_1_reg_mtd);$ttl_1_ytd = num($ttl_1_ytd)+num($ttl_1_reg_ytd);}	
	elseif (num($nomor_cbg) == 2){$ttl_2_reg_tdy = $ttl_amount_reg_tdy;$ttl_2_reg_mtd = $ttl_amount_reg_mtd;$ttl_2_reg_ytd = $ttl_amount_reg_ytd;$ttl_2_tdy = num($ttl_2_tdy)+num($ttl_2_reg_tdy);$ttl_2_mtd = num($ttl_2_mtd)+num($ttl_2_reg_mtd);$ttl_2_ytd = num($ttl_2_ytd)+num($ttl_2_reg_ytd);}	
	elseif (num($nomor_cbg) == 3){$ttl_3_reg_tdy = $ttl_amount_reg_tdy;$ttl_3_reg_mtd = $ttl_amount_reg_mtd;$ttl_3_reg_ytd = $ttl_amount_reg_ytd;$ttl_3_tdy = num($ttl_3_tdy)+num($ttl_3_reg_tdy);$ttl_3_mtd = num($ttl_3_mtd)+num($ttl_3_reg_mtd);$ttl_3_ytd = num($ttl_3_ytd)+num($ttl_3_reg_ytd);}	
	elseif (num($nomor_cbg) == 4){$ttl_4_reg_tdy = $ttl_amount_reg_tdy;$ttl_4_reg_mtd = $ttl_amount_reg_mtd;$ttl_4_reg_ytd = $ttl_amount_reg_ytd;$ttl_4_tdy = num($ttl_4_tdy)+num($ttl_4_reg_tdy);$ttl_4_mtd = num($ttl_4_mtd)+num($ttl_4_reg_mtd);$ttl_4_ytd = num($ttl_4_ytd)+num($ttl_4_reg_ytd);}	
	elseif (num($nomor_cbg) == 5){$ttl_5_reg_tdy = $ttl_amount_reg_tdy;$ttl_5_reg_mtd = $ttl_amount_reg_mtd;$ttl_5_reg_ytd = $ttl_amount_reg_ytd;$ttl_5_tdy = num($ttl_5_tdy)+num($ttl_5_reg_tdy);$ttl_5_mtd = num($ttl_5_mtd)+num($ttl_5_reg_mtd);$ttl_5_ytd = num($ttl_5_ytd)+num($ttl_5_reg_ytd);}	
	elseif (num($nomor_cbg) == 6){$ttl_6_reg_tdy = $ttl_amount_reg_tdy;$ttl_6_reg_mtd = $ttl_amount_reg_mtd;$ttl_6_reg_ytd = $ttl_amount_reg_ytd;$ttl_6_tdy = num($ttl_6_tdy)+num($ttl_6_reg_tdy);$ttl_6_mtd = num($ttl_6_mtd)+num($ttl_6_reg_mtd);$ttl_6_ytd = num($ttl_6_ytd)+num($ttl_6_reg_ytd);}	
	elseif (num($nomor_cbg) == 7){$ttl_7_reg_tdy = $ttl_amount_reg_tdy;$ttl_7_reg_mtd = $ttl_amount_reg_mtd;$ttl_7_reg_ytd = $ttl_amount_reg_ytd;$ttl_7_tdy = num($ttl_7_tdy)+num($ttl_7_reg_tdy);$ttl_7_mtd = num($ttl_7_mtd)+num($ttl_7_reg_mtd);$ttl_7_ytd = num($ttl_7_ytd)+num($ttl_7_reg_ytd);}		
	elseif (num($nomor_cbg) == 8){$ttl_8_reg_tdy = $ttl_amount_reg_tdy;$ttl_8_reg_mtd = $ttl_amount_reg_mtd;$ttl_8_reg_ytd = $ttl_amount_reg_ytd;$ttl_8_tdy = num($ttl_8_tdy)+num($ttl_8_reg_tdy);$ttl_8_mtd = num($ttl_8_mtd)+num($ttl_8_reg_mtd);$ttl_8_ytd = num($ttl_8_ytd)+num($ttl_8_reg_ytd);}	
	elseif (num($nomor_cbg) == 11){$ttl_11_reg_tdy = $ttl_amount_reg_tdy;$ttl_11_reg_mtd = $ttl_amount_reg_mtd;$ttl_11_reg_ytd = $ttl_amount_reg_ytd;$ttl_11_tdy = num($ttl_11_tdy)+num($ttl_11_reg_tdy);$ttl_11_mtd = num($ttl_11_mtd)+num($ttl_11_reg_mtd);$ttl_11_ytd = num($ttl_11_ytd)+num($ttl_11_reg_ytd);}	
	}	
	  

$query_material = q_set($__p_query_material, "SELECT kd_branch, sum(amount),\r
sum(case when dt_payment =?  and status = 'PAID' and jns_payment = 'Material' then amount end) as tdy,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment = 'Material'  then amount end) as mtd,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment  = 'Material'  then amount end) as ytd\r
FROM vip_billing_payment a where  dt_payment\r
between ? and ?  and status = 'PAID' and jns_payment  = 'Material'  group by kd_branch", [(string) ($date_start), (string) ($awal_bulan), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start)]);
	  
$result_material=db_query_or_die("Wah error nih133", $query_material, $__p_query_material ?? []);

while ($r_total_material = db_fetch($result_material))
	{ 
	$nomor_cbg = $r_total_material[0];
	$ttl_amount_material = $r_total_material[1];
	$ttl_amount_material_tdy = $r_total_material[2];
	$ttl_amount_material_mtd = $r_total_material[3];
	$ttl_amount_material_ytd = $r_total_material[4];

	if (num($nomor_cbg) == 1){$ttl_1_material_tdy = $ttl_amount_material_tdy;$ttl_1_material_mtd = $ttl_amount_material_mtd;$ttl_1_material_ytd = $ttl_amount_material_ytd;}	
elseif (num($nomor_cbg) == 2){$ttl_2_material_tdy = $ttl_amount_material_tdy;$ttl_2_material_mtd = $ttl_amount_material_mtd;$ttl_2_material_ytd = $ttl_amount_material_ytd;}	
	elseif (num($nomor_cbg) == 3){$ttl_3_material_tdy = $ttl_amount_material_tdy;$ttl_3_material_mtd = $ttl_amount_material_mtd;$ttl_3_material_ytd = $ttl_amount_material_ytd;}	
	elseif (num($nomor_cbg) == 4){$ttl_4_material_tdy = $ttl_amount_material_tdy;$ttl_4_material_mtd = $ttl_amount_material_mtd;$ttl_4_material_ytd = $ttl_amount_material_ytd;}	
	elseif (num($nomor_cbg) == 5){$ttl_5_material_tdy = $ttl_amount_material_tdy;$ttl_5_material_mtd = $ttl_amount_material_mtd;$ttl_5_material_ytd = $ttl_amount_material_ytd;}	
	elseif (num($nomor_cbg) == 6){$ttl_6_material_tdy = $ttl_amount_material_tdy;$ttl_6_material_mtd = $ttl_amount_material_mtd;$ttl_6_material_ytd = $ttl_amount_material_ytd;}	
	elseif (num($nomor_cbg) == 7){$ttl_7_material_tdy = $ttl_amount_material_tdy;$ttl_7_material_mtd = $ttl_amount_material_mtd;$ttl_7_material_ytd = $ttl_amount_material_ytd;}		
		elseif (num($nomor_cbg) == 8){$ttl_8_material_tdy = $ttl_amount_material_tdy;$ttl_8_material_mtd = $ttl_amount_material_mtd;$ttl_8_material_ytd = $ttl_amount_material_ytd;}	
	elseif (num($nomor_cbg) == 11){$ttl_11_material_tdy = $ttl_amount_material_tdy;$ttl_11_material_mtd = $ttl_amount_material_mtd;$ttl_11_material_ytd = $ttl_amount_material_ytd;}	

	
	}

$query_dp = q_set($__p_query_dp, "SELECT kd_branch, sum(amount),\r
sum(case when dt_payment =?  and status = 'PAID' and jns_payment = 'Down Payment' then amount end) as tdy,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment = 'Down Payment'  then amount end) as mtd,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment  = 'Down Payment'  then amount end) as ytd\r
FROM vip_billing_payment a where  dt_payment\r
between ? and ?  and status = 'PAID' and jns_payment  = 'Down Payment'  group by kd_branch", [(string) ($date_start), (string) ($awal_bulan), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start)]);
$result_dp=db_query_or_die("Wah error nih144", $query_dp, $__p_query_dp ?? []);

while ($r_total_dp = db_fetch($result_dp))
	{ 
	$nomor_cbg = $r_total_dp[0];
	$ttl_amount_dp = $r_total_dp[1];
	$ttl_amount_dp_tdy = $r_total_dp[2];
	$ttl_amount_dp_mtd = $r_total_dp[3];
	$ttl_amount_dp_ytd = $r_total_dp[4];

	if (num($nomor_cbg) == 1){$ttl_1_dp_tdy = $ttl_amount_dp_tdy;$ttl_1_dp_mtd = $ttl_amount_dp_mtd;$ttl_1_dp_ytd = $ttl_amount_dp_ytd;}	
elseif (num($nomor_cbg) == 2){$ttl_2_dp_tdy = $ttl_amount_dp_tdy;$ttl_2_dp_mtd = $ttl_amount_dp_mtd;$ttl_2_dp_ytd = $ttl_amount_dp_ytd;}	
	elseif (num($nomor_cbg) == 3){$ttl_3_dp_tdy = $ttl_amount_dp_tdy;$ttl_3_dp_mtd = $ttl_amount_dp_mtd;$ttl_3_dp_ytd = $ttl_amount_dp_ytd;}	
	elseif (num($nomor_cbg) == 4){$ttl_4_dp_tdy = $ttl_amount_dp_tdy;$ttl_4_dp_mtd = $ttl_amount_dp_mtd;$ttl_4_dp_ytd = $ttl_amount_dp_ytd;}	
	elseif (num($nomor_cbg) == 5){$ttl_5_dp_tdy = $ttl_amount_dp_tdy;$ttl_5_dp_mtd = $ttl_amount_dp_mtd;$ttl_5_dp_ytd = $ttl_amount_dp_ytd;}	
	elseif (num($nomor_cbg) == 6){$ttl_6_dp_tdy = $ttl_amount_dp_tdy;$ttl_6_dp_mtd = $ttl_amount_dp_mtd;$ttl_6_dp_ytd = $ttl_amount_dp_ytd;}	
	elseif (num($nomor_cbg) == 7){$ttl_7_dp_tdy = $ttl_amount_dp_tdy;$ttl_7_dp_mtd = $ttl_amount_dp_mtd;$ttl_7_dp_ytd = $ttl_amount_dp_ytd;}		
		elseif (num($nomor_cbg) == 8){$ttl_8_dp_tdy = $ttl_amount_dp_tdy;$ttl_8_dp_mtd = $ttl_amount_dp_mtd;$ttl_8_dp_ytd = $ttl_amount_dp_ytd;}	
	elseif (num($nomor_cbg) == 11){$ttl_11_dp_tdy = $ttl_amount_dp_tdy;$ttl_11_dp_mtd = $ttl_amount_dp_mtd;$ttl_11_dp_ytd = $ttl_amount_dp_ytd;}	

	
	}
$query_inst = q_set($__p_query_inst, "SELECT kd_branch, sum(amount),\r
sum(case when dt_payment =?  and status = 'PAID' and jns_payment like 'Installment%'  then amount end) as tdy,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment like 'Installment%'  then amount end) as mtd,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment like 'Installment%'  then amount end) as ytd\r
FROM vip_billing_payment a where  dt_payment\r
between ? and ?  and status = 'PAID' and jns_payment like 'Installment%'  group by kd_branch", [(string) ($date_start), (string) ($awal_bulan), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start)]);

$result_inst=db_query_or_die("Wah error nih155", $query_inst, $__p_query_inst ?? []);

while ($r_total_inst = db_fetch($result_inst))
	{ 
	$nomor_cbg = $r_total_inst[0];
	$ttl_amount_inst = $r_total_inst[1];	
	$ttl_amount_inst_tdy = $r_total_inst[2];
	$ttl_amount_inst_mtd = $r_total_inst[3];
	$ttl_amount_inst_ytd = $r_total_inst[4];

	if (num($nomor_cbg) == 1){$ttl_1_inst_tdy = $ttl_amount_inst_tdy;$ttl_1_inst_mtd = $ttl_amount_inst_mtd;$ttl_1_inst_ytd = $ttl_amount_inst_ytd;}	
elseif (num($nomor_cbg) == 2){$ttl_2_inst_tdy = $ttl_amount_inst_tdy;$ttl_2_inst_mtd = $ttl_amount_inst_mtd;$ttl_2_inst_ytd = $ttl_amount_inst_ytd;}	
	elseif (num($nomor_cbg) == 3){$ttl_3_inst_tdy = $ttl_amount_inst_tdy;$ttl_3_inst_mtd = $ttl_amount_inst_mtd;$ttl_3_inst_ytd = $ttl_amount_inst_ytd;}	
	elseif (num($nomor_cbg) == 4){$ttl_4_inst_tdy = $ttl_amount_inst_tdy;$ttl_4_inst_mtd = $ttl_amount_inst_mtd;$ttl_4_inst_ytd = $ttl_amount_inst_ytd;}	
	elseif (num($nomor_cbg) == 5){$ttl_5_inst_tdy = $ttl_amount_inst_tdy;$ttl_5_inst_mtd = $ttl_amount_inst_mtd;$ttl_5_inst_ytd = $ttl_amount_inst_ytd;}	
	elseif (num($nomor_cbg) == 6){$ttl_6_inst_tdy = $ttl_amount_inst_tdy;$ttl_6_inst_mtd = $ttl_amount_inst_mtd;$ttl_6_inst_ytd = $ttl_amount_inst_ytd;}	
	elseif (num($nomor_cbg) == 7){$ttl_7_inst_tdy = $ttl_amount_inst_tdy;$ttl_7_inst_mtd = $ttl_amount_inst_mtd;$ttl_7_inst_ytd = $ttl_amount_inst_ytd;}		
		elseif (num($nomor_cbg) == 8){$ttl_8_inst_tdy = $ttl_amount_inst_tdy;$ttl_8_inst_mtd = $ttl_amount_inst_mtd;$ttl_8_inst_ytd = $ttl_amount_inst_ytd;}	
	elseif (num($nomor_cbg) == 11){$ttl_11_inst_tdy = $ttl_amount_inst_tdy;$ttl_11_inst_mtd = $ttl_amount_inst_mtd;$ttl_11_inst_ytd = $ttl_amount_inst_ytd;}		
	}

$query_full = q_set($__p_query_full, "SELECT kd_branch, sum(amount),\r
sum(case when dt_payment =?  and status = 'PAID' and jns_payment = 'Full Payment' then amount end) as tdy,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment = 'Full Payment'  then amount end) as mtd,\r
sum(case when dt_payment between ? and ?  and status = 'PAID' and jns_payment  = 'Full Payment'  then amount end) as ytd\r
FROM vip_billing_payment a where  dt_payment\r
between ? and ?  and status = 'PAID' and jns_payment  = 'Full Payment'  group by kd_branch", [(string) ($date_start), (string) ($awal_bulan), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start), (string) ($awal_tahun), (string) ($date_start)]);
$result_full=db_query_or_die("Wah error nih15555", $query_full, $__p_query_full ?? []);

while ($r_total_full = db_fetch($result_full))
	{ 
	$nomor_cbg = $r_total_full[0];
	$ttl_amount_full = $r_total_full[1];
	$ttl_amount_full_tdy = $r_total_full[2];
	$ttl_amount_full_mtd = $r_total_full[3];
	$ttl_amount_full_ytd = $r_total_full[4];

	if (num($nomor_cbg) == 1){$ttl_1_full_tdy = $ttl_amount_full_tdy;$ttl_1_full_mtd = $ttl_amount_full_mtd;$ttl_1_full_ytd = $ttl_amount_full_ytd;}	
elseif (num($nomor_cbg) == 2){$ttl_2_full_tdy = $ttl_amount_full_tdy;$ttl_2_full_mtd = $ttl_amount_full_mtd;$ttl_2_full_ytd = $ttl_amount_full_ytd;}	
	elseif (num($nomor_cbg) == 3){$ttl_3_full_tdy = $ttl_amount_full_tdy;$ttl_3_full_mtd = $ttl_amount_full_mtd;$ttl_3_full_ytd = $ttl_amount_full_ytd;}	
	elseif (num($nomor_cbg) == 4){$ttl_4_full_tdy = $ttl_amount_full_tdy;$ttl_4_full_mtd = $ttl_amount_full_mtd;$ttl_4_full_ytd = $ttl_amount_full_ytd;}	
	elseif (num($nomor_cbg) == 5){$ttl_5_full_tdy = $ttl_amount_full_tdy;$ttl_5_full_mtd = $ttl_amount_full_mtd;$ttl_5_full_ytd = $ttl_amount_full_ytd;}	
	elseif (num($nomor_cbg) == 6){$ttl_6_full_tdy = $ttl_amount_full_tdy;$ttl_6_full_mtd = $ttl_amount_full_mtd;$ttl_6_full_ytd = $ttl_amount_full_ytd;}	
	elseif (num($nomor_cbg) == 7){$ttl_7_full_tdy = $ttl_amount_full_tdy;$ttl_7_full_mtd = $ttl_amount_full_mtd;$ttl_7_full_ytd = $ttl_amount_full_ytd;}		
		elseif (num($nomor_cbg) == 8){$ttl_8_full_tdy = $ttl_amount_full_tdy;$ttl_8_full_mtd = $ttl_amount_full_mtd;$ttl_8_full_ytd = $ttl_amount_full_ytd;}	
	elseif (num($nomor_cbg) == 11){$ttl_11_full_tdy = $ttl_amount_full_tdy;$ttl_11_full_mtd = $ttl_amount_full_mtd;$ttl_11_full_ytd = $ttl_amount_full_ytd;}	

	
	}	
	

	$ttl_1 = num($ttl_1_reg)+ num($ttl_1_dp_tdy) + num($ttl_1_inst) + num($ttl_1_material) + num($ttl_1_full);
	$ttl_2 = num($ttl_2_reg)+ num($ttl_2_dp_tdy) + num($ttl_2_inst) + num($ttl_2_material) + num($ttl_2_full);
	$ttl_3 = num($ttl_3_reg)+ num($ttl_3_dp_tdy) + num($ttl_3_inst) + num($ttl_3_material) + num($ttl_3_full);
	$ttl_4 = num($ttl_4_reg)+ num($ttl_4_dp_tdy) + num($ttl_4_inst) + num($ttl_4_material) + num($ttl_4_full);
	$ttl_5 = num($ttl_5_reg)+ num($ttl_5_dp_tdy) + num($ttl_5_inst) + num($ttl_5_material) + num($ttl_5_full);
	$ttl_6 = num($ttl_6_reg)+ num($ttl_6_dp_tdy) + num($ttl_6_inst) + num($ttl_6_material) + num($ttl_6_full);
	$ttl_7 = num($ttl_7_reg)+ num($ttl_7_dp_tdy) + num($ttl_7_inst) + num($ttl_7_material) + num($ttl_7_full);
		$ttl_8 = num($ttl_8_reg)+ num($ttl_8_dp_tdy) + num($ttl_8_inst) + num($ttl_8_material) + num($ttl_8_full);
	$ttl_11 = num($ttl_11_reg)+ num($ttl_11_dp_tdy) + num($ttl_11_inst) + num($ttl_11_material) + num($ttl_11_full);


?>
  
  <section class="content">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
				
          <table width="40%"  class="table table-bordered table-striped table-condensed" id="example1">
       <tbody>
         <tr>
			 <th colspan="31" scope="row" align="center"><strong>VIP Summary Income</stroing></th>
           </tr>
         <tr>
           <th width="6%" scope="row">Center</th>
           <td colspan="3" align="center"><strong>East Sby</strong></td>
           <td colspan="3" align="center"><strong>West Sby</strong></td>
           <td colspan="3" align="center"><strong>Denpasar</strong></td>
           <td colspan="3" align="center"><strong>Malang</strong></td>
           <td colspan="3" align="center"><strong>South  Jkt</strong></td>
           <td colspan="3" align="center"><strong>North Jkt</strong></td>
           <td colspan="3" align="center"><strong>West Jkt</strong></td>
           <td colspan="3" align="center"><strong>Bandung</strong></td>
           <td colspan="3" align="center"><strong>PIK</strong></td>
           <td colspan="3" align="center"><strong>Grand Total</strong></td>
           </tr>
         <tr>
           <th scope="row">&nbsp;</th>
           <td width="11%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="9%" align="center"><strong>Mtd</strong></td>
           <td width="9%" align="center"><strong>Ytd</strong></td>
           <td width="9%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="8%" align="center"><strong>Mtd</strong></td>
           <td width="8%" align="center"><strong>Ytd</strong></td>
           <td width="8%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="8%" align="center"><strong>Mtd</strong></td>
           <td width="8%" align="center"><strong>Ytd</strong></td>
           <td width="8%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="10%" align="center"><strong>Mtd</strong></td>
           <td width="10%" align="center"><strong>Ytd</strong></td>
           <td width="6%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="9%" align="center"><strong>Mtd</strong></td>
           <td width="9%" align="center"><strong>Ytd</strong></td>
           <td width="9%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="11%" align="center"><strong>Mtd</strong></td>
           <td width="11%" align="center"><strong>Ytd</strong></td>
           <td width="11%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="7%" align="center"><strong>Mtd</strong></td>
           <td width="7%" align="center"><strong>Ytd</strong></td>
           <td width="7%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="6%" align="center"><strong>Mtd</strong></td>
           <td width="9%" align="center"><strong>Ytd</strong></td>
           <td width="9%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="9%" align="center"><strong>Mtd</strong></td>
           <td width="9%" align="center"><strong>Ytd</strong></td>
           <td width="9%" align="center" bgcolor="#B4FAA7"><strong>Tdy</strong></td>
           <td width="9%" align="center"><strong>Mtd</strong></td>
           <td width="9%" align="center"><strong>Ytd</strong></td>
           </tr>
         <tr>
           <th scope="row">Registration</th>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_reg_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_2_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_reg_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_3_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_reg_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_8_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_reg_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_4_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_reg_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_5_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_reg_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_6_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_reg_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_7_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_reg_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_11_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_reg_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_reg_tdy) + num($ttl_2_reg_tdy) + num($ttl_3_reg_tdy) + num($ttl_4_reg_tdy) + num($ttl_5_reg_tdy) + num($ttl_6_reg_tdy) + num($ttl_7_reg_tdy) + num($ttl_8_reg_tdy) + num($ttl_11_reg_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_reg_mtd) + num($ttl_2_reg_mtd) + num($ttl_3_reg_mtd) + num($ttl_4_reg_mtd) + num($ttl_5_reg_mtd) + num($ttl_6_reg_mtd) + num($ttl_7_reg_mtd) + num($ttl_8_reg_mtd) + num($ttl_11_reg_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_reg_ytd) + num($ttl_2_reg_ytd) + num($ttl_3_reg_ytd) + num($ttl_4_reg_ytd) + num($ttl_5_reg_ytd) + num($ttl_6_reg_ytd) + num($ttl_7_reg_ytd) + num($ttl_8_reg_ytd) + num($ttl_11_reg_ytd),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row">Material Cost</th>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_material_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_2_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_material_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_3_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_material_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_8_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_material_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_4_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_material_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_5_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_material_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_6_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_material_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_7_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_material_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_11_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_material_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_material_tdy) + num($ttl_2_material_tdy) + num($ttl_3_material_tdy) + num($ttl_4_material_tdy) + num($ttl_5_material_tdy) + num($ttl_6_material_tdy) + num($ttl_7_material_tdy) + num($ttl_8_material_tdy) + num($ttl_11_material_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_material_mtd) + num($ttl_2_material_mtd) + num($ttl_3_material_mtd) + num($ttl_4_material_mtd) + num($ttl_5_material_mtd) + num($ttl_6_material_mtd) + num($ttl_7_material_mtd) + num($ttl_8_material_mtd) + num($ttl_11_material_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_material_ytd) + num($ttl_2_material_ytd) + num($ttl_3_material_ytd) + num($ttl_4_material_ytd) + num($ttl_5_material_ytd) + num($ttl_6_material_ytd) + num($ttl_7_material_ytd) + num($ttl_8_material_ytd) + num($ttl_11_material_ytd),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row"> DP</th>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_dp_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_2_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_dp_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_3_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_dp_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_8_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_dp_ytd),0,".",".") ?></td>
			 
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_4_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_dp_ytd),0,".",".") ?></td>
			 
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_5_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_dp_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_6_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_dp_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_7_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_dp_ytd),0,".",".") ?></td>

           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_11_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_dp_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_dp_tdy) + num($ttl_2_dp_tdy) + num($ttl_3_dp_tdy) + num($ttl_4_dp_tdy) + num($ttl_5_dp_tdy) + num($ttl_6_dp_tdy) + num($ttl_7_dp_tdy) + num($ttl_8_dp_tdy) + num($ttl_11_dp_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_dp_mtd) + num($ttl_2_dp_mtd) + num($ttl_3_dp_mtd) + num($ttl_4_dp_mtd) + num($ttl_5_dp_mtd) + num($ttl_6_dp_mtd) + num($ttl_7_dp_mtd) + num($ttl_8_dp_mtd) + num($ttl_11_dp_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_dp_ytd) + num($ttl_2_dp_ytd) + num($ttl_3_dp_ytd) + num($ttl_4_dp_ytd) + num($ttl_5_dp_ytd) + num($ttl_6_dp_ytd) + num($ttl_7_dp_ytd) + num($ttl_8_dp_ytd) + num($ttl_11_dp_ytd),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row">Installment</th>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_inst_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_2_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_inst_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_3_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_inst_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_8_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_inst_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_4_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_inst_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_5_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_inst_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_6_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_inst_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_7_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_inst_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_11_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_inst_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_inst_tdy) + num($ttl_2_inst_tdy) + num($ttl_3_inst_tdy) + num($ttl_4_inst_tdy) + num($ttl_5_inst_tdy) + num($ttl_6_inst_tdy) + num($ttl_7_inst_tdy) + num($ttl_8_inst_tdy) + num($ttl_11_inst_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_inst_mtd) + num($ttl_2_inst_mtd) + num($ttl_3_inst_mtd) + num($ttl_4_inst_mtd) + num($ttl_5_inst_mtd) + num($ttl_6_inst_mtd) + num($ttl_7_inst_mtd) + num($ttl_8_inst_mtd) + num($ttl_11_inst_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_inst_ytd) + num($ttl_2_inst_ytd) + num($ttl_3_inst_ytd) + num($ttl_4_inst_ytd) + num($ttl_5_inst_ytd) + num($ttl_6_inst_ytd) + num($ttl_7_inst_ytd) + num($ttl_8_inst_ytd) + num($ttl_11_inst_ytd),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row">Full Payment</th>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_full_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_2_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_2_full_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_3_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_3_full_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_8_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_8_full_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_4_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_4_full_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_5_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_5_full_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_6_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_6_full_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_7_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_7_full_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_11_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_11_full_ytd),0,".",".") ?></td>
           <td align="right" bgcolor="#B4FAA7"><?php echo number_format(num($ttl_1_full_tdy) + num($ttl_2_full_tdy) + num($ttl_3_full_tdy) + num($ttl_4_full_tdy) + num($ttl_5_full_tdy) + num($ttl_6_full_tdy) + num($ttl_7_full_tdy) + num($ttl_8_full_tdy) + num($ttl_11_full_tdy),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_full_mtd) + num($ttl_2_full_mtd) + num($ttl_3_full_mtd) + num($ttl_4_full_mtd) + num($ttl_5_full_mtd) + num($ttl_6_full_mtd) + num($ttl_7_full_mtd) + num($ttl_8_full_mtd) + num($ttl_11_full_mtd),0,".",".") ?></td>
           <td align="right"><?php echo number_format(num($ttl_1_full_ytd) + num($ttl_2_full_ytd) + num($ttl_3_full_ytd) + num($ttl_4_full_ytd) + num($ttl_5_full_ytd) + num($ttl_6_full_ytd) + num($ttl_7_full_ytd) + num($ttl_8_full_ytd) + num($ttl_11_full_ytd),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row"><strong>Total Payment</strong></th>
           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_1_reg_tdy) + num($ttl_1_dp_tdy)+num($ttl_1_material_tdy)+num($ttl_1_inst_tdy)+num($ttl_1_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_1_reg_mtd) + num($ttl_1_dp_mtd)+num($ttl_1_material_mtd)+num($ttl_1_inst_mtd)+num($ttl_1_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_1_reg_ytd) + num($ttl_1_dp_ytd)+num($ttl_1_material_ytd)+num($ttl_1_inst_ytd)+num($ttl_1_full_ytd),0,".",".") ?></strong></td>
           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_2_reg_tdy) + num($ttl_2_dp_tdy)+num($ttl_2_material_tdy)+num($ttl_2_inst_tdy)+num($ttl_2_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_2_reg_mtd) + num($ttl_2_dp_mtd)+num($ttl_2_material_mtd)+num($ttl_2_inst_mtd)+num($ttl_2_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_2_reg_ytd) + num($ttl_2_dp_ytd)+num($ttl_2_material_ytd)+num($ttl_2_inst_ytd)+num($ttl_2_full_ytd),0,".",".") ?></strong></td>

           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_3_reg_tdy) + num($ttl_3_dp_tdy)+num($ttl_3_material_tdy)+num($ttl_3_inst_tdy)+num($ttl_3_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_3_reg_mtd) + num($ttl_3_dp_mtd)+num($ttl_3_material_mtd)+num($ttl_3_inst_mtd)+num($ttl_3_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_3_reg_ytd) + num($ttl_3_dp_ytd)+num($ttl_3_material_ytd)+num($ttl_3_inst_ytd)+num($ttl_3_full_ytd),0,".",".") ?></strong></td>

           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_8_reg_tdy) + num($ttl_8_dp_tdy)+num($ttl_8_material_tdy)+num($ttl_8_inst_tdy)+num($ttl_8_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_8_reg_mtd) + num($ttl_8_dp_mtd)+num($ttl_8_material_mtd)+num($ttl_8_inst_mtd)+num($ttl_8_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_8_reg_ytd) + num($ttl_8_dp_ytd)+num($ttl_8_material_ytd)+num($ttl_8_inst_ytd)+num($ttl_8_full_ytd),0,".",".") ?></strong></td>

           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_4_reg_tdy) + num($ttl_4_dp_tdy)+num($ttl_4_material_tdy)+num($ttl_4_inst_tdy)+num($ttl_4_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_4_reg_mtd) + num($ttl_4_dp_mtd)+num($ttl_4_material_mtd)+num($ttl_4_inst_mtd)+num($ttl_4_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_4_reg_ytd) + num($ttl_4_dp_ytd)+num($ttl_4_material_ytd)+num($ttl_4_inst_ytd)+num($ttl_4_full_ytd),0,".",".") ?></strong></td>

           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_5_reg_tdy) + num($ttl_5_dp_tdy)+num($ttl_5_material_tdy)+num($ttl_5_inst_tdy)+num($ttl_5_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_5_reg_mtd) + num($ttl_5_dp_mtd)+num($ttl_5_material_mtd)+num($ttl_5_inst_mtd)+num($ttl_5_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_5_reg_ytd) + num($ttl_5_dp_ytd)+num($ttl_5_material_ytd)+num($ttl_5_inst_ytd)+num($ttl_5_full_ytd),0,".",".") ?></strong></td>

           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_6_reg_tdy) + num($ttl_6_dp_tdy)+num($ttl_6_material_tdy)+num($ttl_6_inst_tdy)+num($ttl_6_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_6_reg_mtd) + num($ttl_6_dp_mtd)+num($ttl_6_material_mtd)+num($ttl_6_inst_mtd)+num($ttl_6_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_6_reg_ytd) + num($ttl_6_dp_ytd)+num($ttl_6_material_ytd)+num($ttl_6_inst_ytd)+num($ttl_6_full_ytd),0,".",".") ?></strong></td>

           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_7_reg_tdy) + num($ttl_7_dp_tdy)+num($ttl_7_material_tdy)+num($ttl_7_inst_tdy)+num($ttl_7_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_7_reg_mtd) + num($ttl_7_dp_mtd)+num($ttl_7_material_mtd)+num($ttl_7_inst_mtd)+num($ttl_7_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_7_reg_ytd) + num($ttl_7_dp_ytd)+num($ttl_7_material_ytd)+num($ttl_7_inst_ytd)+num($ttl_7_full_ytd),0,".",".") ?></strong></td>

           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_11_reg_tdy) + num($ttl_11_dp_tdy)+num($ttl_11_material_tdy)+num($ttl_11_inst_tdy)+num($ttl_11_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_11_reg_mtd) + num($ttl_11_dp_mtd)+num($ttl_11_material_mtd)+num($ttl_11_inst_mtd)+num($ttl_11_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_11_reg_ytd) + num($ttl_11_dp_ytd)+num($ttl_11_material_ytd)+num($ttl_11_inst_ytd)+num($ttl_11_full_ytd),0,".",".") ?></strong></td>

           <td align="right" bgcolor="#B4FAA7"><strong><?php echo number_format(num($ttl_1_reg_tdy) + num($ttl_1_dp_tdy)+num($ttl_1_material_tdy)+num($ttl_1_inst_tdy)+num($ttl_1_full_tdy) + num($ttl_2_reg_tdy) + num($ttl_2_dp_tdy)+num($ttl_2_material_tdy)+num($ttl_2_inst_tdy)+num($ttl_2_full_tdy) + num($ttl_3_reg_tdy) + num($ttl_3_dp_tdy)+num($ttl_3_material_tdy)+num($ttl_3_inst_tdy)+num($ttl_3_full_tdy) + num($ttl_4_reg_tdy) + num($ttl_4_dp_tdy)+num($ttl_4_material_tdy)+num($ttl_4_inst_tdy)+num($ttl_4_full_tdy) + num($ttl_5_reg_tdy) + num($ttl_5_dp_tdy)+num($ttl_5_material_tdy)+num($ttl_5_inst_tdy)+num($ttl_5_full_tdy) + num($ttl_6_reg_tdy) + num($ttl_6_dp_tdy)+num($ttl_6_material_tdy)+num($ttl_6_inst_tdy)+num($ttl_6_full_tdy) + num($ttl_7_reg_tdy) + num($ttl_7_dp_tdy)+num($ttl_7_material_tdy)+num($ttl_7_inst_tdy)+num($ttl_7_full_tdy) + num($ttl_8_reg_tdy) + num($ttl_8_dp_tdy)+num($ttl_8_material_tdy)+num($ttl_8_inst_tdy)+num($ttl_8_full_tdy) + num($ttl_11_reg_tdy) + num($ttl_11_dp_tdy)+num($ttl_11_material_tdy)+num($ttl_11_inst_tdy)+num($ttl_11_full_tdy),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_1_reg_mtd) + num($ttl_1_dp_mtd)+num($ttl_1_material_mtd)+num($ttl_1_inst_mtd)+num($ttl_1_full_mtd) + num($ttl_2_reg_mtd) + num($ttl_2_dp_mtd)+num($ttl_2_material_mtd)+num($ttl_2_inst_mtd)+num($ttl_2_full_mtd) + num($ttl_3_reg_mtd) + num($ttl_3_dp_mtd)+num($ttl_3_material_mtd)+num($ttl_3_inst_mtd)+num($ttl_3_full_mtd) + num($ttl_4_reg_mtd) + num($ttl_4_dp_mtd)+num($ttl_4_material_mtd)+num($ttl_4_inst_mtd)+num($ttl_4_full_mtd) + num($ttl_5_reg_mtd) + num($ttl_5_dp_mtd)+num($ttl_5_material_mtd)+num($ttl_5_inst_mtd)+num($ttl_5_full_mtd) + num($ttl_6_reg_mtd) + num($ttl_6_dp_mtd)+num($ttl_6_material_mtd)+num($ttl_6_inst_mtd)+num($ttl_6_full_mtd) + num($ttl_7_reg_mtd) + num($ttl_7_dp_mtd)+num($ttl_7_material_mtd)+num($ttl_7_inst_mtd)+num($ttl_7_full_mtd) + num($ttl_8_reg_mtd) + num($ttl_8_dp_mtd)+num($ttl_8_material_mtd)+num($ttl_8_inst_mtd)+num($ttl_8_full_mtd) + num($ttl_11_reg_mtd) + num($ttl_11_dp_mtd)+num($ttl_11_material_mtd)+num($ttl_11_inst_mtd)+num($ttl_11_full_mtd),0,".",".") ?></strong></td>
           <td align="right"><strong><?php echo number_format(num($ttl_1_reg_ytd) + num($ttl_1_dp_ytd)+num($ttl_1_material_ytd)+num($ttl_1_inst_ytd)+num($ttl_1_full_ytd) + num($ttl_2_reg_ytd) + num($ttl_2_dp_ytd)+num($ttl_2_material_ytd)+num($ttl_2_inst_ytd)+num($ttl_2_full_ytd) + num($ttl_3_reg_ytd) + num($ttl_3_dp_ytd)+num($ttl_3_material_ytd)+num($ttl_3_inst_ytd)+num($ttl_3_full_ytd) + num($ttl_4_reg_ytd) + num($ttl_4_dp_ytd)+num($ttl_4_material_ytd)+num($ttl_4_inst_ytd)+num($ttl_4_full_ytd) + num($ttl_5_reg_ytd) + num($ttl_5_dp_ytd)+num($ttl_5_material_ytd)+num($ttl_5_inst_ytd)+num($ttl_5_full_ytd) + num($ttl_6_reg_ytd) + num($ttl_6_dp_ytd)+num($ttl_6_material_ytd)+num($ttl_6_inst_ytd)+num($ttl_6_full_ytd) + num($ttl_7_reg_ytd) + num($ttl_7_dp_ytd)+num($ttl_7_material_ytd)+num($ttl_7_inst_ytd)+num($ttl_7_full_ytd) + num($ttl_8_reg_ytd) + num($ttl_8_dp_ytd)+num($ttl_8_material_ytd)+num($ttl_8_inst_ytd)+num($ttl_8_full_ytd) + num($ttl_11_reg_ytd) + num($ttl_11_dp_ytd)+num($ttl_11_material_ytd)+num($ttl_11_inst_ytd)+num($ttl_11_full_ytd),0,".",".") ?></strong></td>
         </tr>
       </tbody>
     </table>          	
            </div>
	  </div>       
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
		
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example1">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="5%">Effective Date / Receipt Date</th>
                  <th width="14%"> SC / Branch</th>
                  <th width="15%">Student Name</th>
                  <th width="12%">Receipt Number</th>
                  <th width="8%">Discount</th>
                  <th width="5%">Voucher</th>
                  <th width="10%">Program</th>
                  <th width="7%">Detail</th>
                  <th width="7%">Amount</th>
                  <th width="15%">Payment Metodh</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd,a.kd_billing,b.pic   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' \r
\tand dt_payment = ? group by id_receipt order by id_receipt desc", [(string) ($date_start)]);
$no_urut = 1;
$result=db_query_or_die("Wah error nih11", $query, $__p_query ?? []);			   
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$kd_cabang = $r[5];
							if (num($kd_cabang) ==1){$cabang = 'East Sby';$db_cabang ='billing.';}
if (num($kd_cabang) ==2){$cabang = 'West Sby';}
if (num($kd_cabang) ==3){$cabang = 'Denpasar';}
if (num($kd_cabang) ==4){$cabang = 'South Jkt';}
if (num($kd_cabang) ==5){$cabang = 'North Jkt';}
if (num($kd_cabang) ==6){$cabang = 'West Jkt';}
if (num($kd_cabang) ==7){$cabang = 'Bandung';}
if (num($kd_cabang) ==8){$cabang = 'Malang';}
if (num($kd_cabang) ==11){$cabang = 'PIK';}
//							$query_nama = "SELECT concat_ws(' ',nama, middle_name) from ves_inc.tb_biodata where kd_biodata = '$r[3]' and kd_branch = '$r[5]'";
							$query_discount = q_set($__p_query_discount, "SELECT discount,tf,net_tf,voucher from ves_data.vip_billing where kd_billing = ? ", [(string) ($r[9])]);

							$result_discount=db_query_or_die("Wah error nih1", $query_discount, $__p_query_discount ?? []);	
							while ($r_discount = db_fetch($result_discount))
							{ $nm_discount = $r_discount[0];
							 $tf_asli = $r_discount[1];
							 $tf_nett = $r_discount[2];
							  $nm_voucher = $r_discount[3];
							 $tf_selisih = num($tf_asli) - num($tf_nett);
							 $bsr_discount = num((div($tf_selisih, $tf_asli)))*100;
							}
							
							$query_nama = q_set($__p_query_nama, "SELECT nama_lengkap from ves_data.vip_student_data where kd_biodata = ? and kd_branch = ? ", [(string) ($r[3]), (string) ($r[5])]);
								
							$result_nama=db_query_or_die("Wah error nih1", $query_nama, $__p_query_nama ?? []);	
							while ($r_nama = db_fetch($result_nama))
								{ $nama_student = $r_nama[0];}
							$query_program = q_set($__p_query_program, "SELECT concat_ws(' ', type_program, nm_program), level_program, buku FROM ves_data.vip_mst_code_prg  where kd_program =  ? group by kd_program", [(string) ($r[4])]);

							$result_program=db_query_or_die("Wah error nih1", $query_program, $__p_query_program ?? []);	
							while ($r_program = db_fetch($result_program))
								{ $nama_program = $r_program[0];$jenis_program = $r_program[1];}		
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[0]) ; ?><br>
                  <?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($r[10]) ; ?><br>
                  <?php echo e($cabang) ; ?></td>
                  <td><?php echo e($nama_student) ; ?></td>
                  <td><?php echo e($r[2]) ; ?></td>
                  <td><?php echo e($nm_discount) ; ?></td>
                  <td><?php echo e($nm_voucher) ; ?></td>
                  <td><?php echo e($nama_program) ; ?> - <?php echo e($jenis_program) ; ?></td>
                  <td><?php echo e($r[7]) ; ?></td>
                  <td><?php echo number_format(num($r[6]),0,".",".") ; ?></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  </tr>
                <?php $total_rp = num($total_rp) + num($r[6]); $no_urut = num($no_urut) + 1; $r[6] =''; } } ?>
            
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <div class="box">
         	<div class="box-body">
         		<label>TODAY'S INCOME : Rp. <?php echo number_format(num($total_rp),0,".",".")  ; ?></label>
         	</div>
         </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
	   </section>      
    
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
		
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
				<table  width="97%" class="table table-bordered table-striped" id="example1">
  <tbody>
    <tr>
      <td width="13%">Center</td>
      <td width="37%">Today's Class</td>
      <td width="50%">Running Class</td>
    </tr>
    <tr>
      <td>East Sby</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>West Sby</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Denpasar</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Malang</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>South Jkt</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>West Jkt</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>PIK</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Bandung</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>TOTAL</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>


            </div>
            <div class="box">
         	<div class="box-body">
         		<label>TODAY'S INCOME : Rp. <?php echo number_format(num($total_rp),0,".",".")  ; ?></label>
         	</div>
         </div>
            <!-- /.box-body -->
          </div><a href="rpt_vip_inc.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a><a href="vip_receiptxl.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
