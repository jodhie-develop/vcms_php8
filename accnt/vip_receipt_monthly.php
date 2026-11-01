<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
include __DIR__ . "/../atas.php";
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

$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}
if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
elseif ($kd_cbg == 'HO'){$kd_cbg = '00';}
elseif ($kd_cbg == 'National'){$kd_cbg = 100;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 14;}
elseif ($kd_cbg == 'CA'){$kd_cbg = 15;}

if ($kd_cbg ==''){$cabang = '--ALL--';}
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';$db_cabang ='billing.';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';$db_cabang ='billing_west.';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';$db_cabang ='billing_bali.';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';$db_cabang ='billing_jkt_02.';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';$db_cabang ='billing_new_gs.';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';$db_cabang ='billing_m2.';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';$db_cabang ='billing_new_bdg.';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';$db_cabang ='billing_malang.';}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
elseif (num($kd_cbg) ==100){$cabang = 'National';}
elseif ($kd_cbg =='00'){$cabang = 'HO';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}
elseif (num($kd_cbg) ==15){$cabang = 'CA';}

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
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
	<style>
/* default */
.no-print {}

/* PRINT MODE */
@media print {

  /* sembunyikan semua */
  body * {
    visibility: hidden;
  }

  /* tampilkan hanya area print */
  #printArea, #printArea * {
    visibility: visible;
  }



  /* posisikan di kiri atas */
  #printArea {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }

  /* sembunyikan menu, sidebar, header */
  .main-header,
  .main-sidebar,
  .content-header,
  .no-print {
    display: none !important;
  }

  /* rapikan tabel */
  table {
    width: 100% !important;
    border-collapse: collapse !important;
    font-size: 11px;
  }

  th, td {
    border: 1px solid #000 !important;
    padding: 6px !important;page-break-inside: avoid;
  }

  thead {
    display: table-header-group;
  }

  tr {
    page-break-inside: avoid;
  }

  /* judul */
  h3 {
    margin: 10px 0 6px;
    font-size: 14px;
  }.print-section { margin-bottom: 12mm; }
}
</style>

</head>

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=#> 
  <div class="content-wrapper">
	  <section class="content-header no-print">
  <h1>
    VIP Income Summary - ACC
    <button type="button" class="btn btn-sm btn-primary pull-right" onclick="printReport()">
      <i class="fa fa-print"></i> Print
    </button>
  </h1>
</section>
    <!-- Content Header (Page header) -->
   <section class="content-header">

     <?php 
 if ($cabang =='National')
	{
	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd,a.kd_billing,a.no,b.level_program, b.kd_class   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' \r
\tand dt_payment between ? and ? group by id_receipt order by id_receipt desc", [(string) ($date_start), (string) ($date_end)]);		
	}
else
	{
	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd,a.kd_billing,a.no,b.level_program, b.kd_class   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' and a.kd_branch = ?\r
\tand dt_payment between ? and ? group by id_receipt order by id_receipt desc", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);			
	}
$total_rp = 0;

$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         <tr>
           <th width="11%" scope="row">Center</th>
           <td width="89%"><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
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
             <option value="14">Medan</option>
             <option value="15">CA</option>
			   
			   
             <option value="102">West Area</option>
             <option value="00">HO</option>			   
             <option value="100">National</option>
             <option selected="selected"><?php echo e($cabang) ?></option>
           </select></td>
         </tr>
         <tr>
           <th scope="row">Period Date</th>
           <td><small>
             <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
           </small> To <small>
           <input type="date" format="dd/MM/yyyy" name="date_end" id="date" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()">
           </small></td>
         </tr>
       </tbody>
     </table>
   

   </section>
<?php
$query_reg = q_set($__p_query_reg, "SELECT kd_branch, sum(amount) FROM vip_billing_payment a where  dt_payment between ? and ? and status = 'PAID' and jns_payment = 'Registration' group by kd_branch", [(string) ($date_start), (string) ($date_end)]);

$result_reg=db_query_or_die("Wah error nih122", $query_reg, $__p_query_reg ?? []);

while ($r_total_reg = db_fetch($result_reg))
	{ 
	$nomor_cbg = $r_total_reg[0];
	$ttl_amount_reg = $r_total_reg[1];

	if (num($nomor_cbg) == 1){$ttl_1_reg = $ttl_amount_reg;}	if (num($nomor_cbg) == 2){$ttl_2_reg = $ttl_amount_reg;}
	if (num($nomor_cbg) == 3){$ttl_3_reg = $ttl_amount_reg;}	if (num($nomor_cbg) == 4){$ttl_4_reg = $ttl_amount_reg;}
	if (num($nomor_cbg) == 5){$ttl_5_reg = $ttl_amount_reg;}	if (num($nomor_cbg) == 6){$ttl_6_reg = $ttl_amount_reg;}
	if (num($nomor_cbg) == 7){$ttl_7_reg = $ttl_amount_reg;}	if (num($nomor_cbg) == 8){$ttl_8_reg = $ttl_amount_reg;}
	if (num($nomor_cbg) == 11){$ttl_11_reg = $ttl_amount_reg;}
	if (num($nomor_cbg) == 15){$ttl_15_reg = $ttl_amount_reg;}
		if (num($nomor_cbg) == 14){$ttl_14_reg = $ttl_amount_reg;}
	
	}	
$query_material = q_set($__p_query_material, "SELECT kd_branch, sum(amount) FROM vip_billing_payment a where  dt_payment between ? and ? and status = 'PAID' and jns_payment = 'Material' group by kd_branch", [(string) ($date_start), (string) ($date_end)]);

$result_material=db_query_or_die("Wah error nih133", $query_material, $__p_query_material ?? []);

while ($r_total_material = db_fetch($result_material))
	{ 
	$nomor_cbg = $r_total_material[0];
	$ttl_amount_material = $r_total_material[1];

	if (num($nomor_cbg) == 1){$ttl_1_material = $ttl_amount_material;}	if (num($nomor_cbg) == 2){$ttl_2_material = $ttl_amount_material;}
	if (num($nomor_cbg) == 3){$ttl_3_material = $ttl_amount_material;}	if (num($nomor_cbg) == 4){$ttl_4_material = $ttl_amount_material;}
	if (num($nomor_cbg) == 5){$ttl_5_material = $ttl_amount_material;}	if (num($nomor_cbg) == 6){$ttl_6_material = $ttl_amount_material;}
	if (num($nomor_cbg) == 7){$ttl_7_material = $ttl_amount_material;}	if (num($nomor_cbg) == 8){$ttl_8_material = $ttl_amount_material;}
	if (num($nomor_cbg) == 11){$ttl_11_material = $ttl_amount_material;}
if (num($nomor_cbg) == 15){$ttl_15_material = $ttl_amount_material;}
if (num($nomor_cbg) == 14){$ttl_14_material = $ttl_amount_material;}	
	
	}
$query_dp = q_set($__p_query_dp, "SELECT kd_branch, sum(amount) FROM vip_billing_payment a where  dt_payment between ? and ? and status = 'PAID' and jns_payment = 'Down Payment' group by kd_branch", [(string) ($date_start), (string) ($date_end)]);

$result_dp=db_query_or_die("Wah error nih144", $query_dp, $__p_query_dp ?? []);

while ($r_total_dp = db_fetch($result_dp))
	{ 
	$nomor_cbg = $r_total_dp[0];
	$ttl_amount_dp = $r_total_dp[1];

	if (num($nomor_cbg) == 1){$ttl_1_dp = $ttl_amount_dp;}	if (num($nomor_cbg) == 2){$ttl_2_dp = $ttl_amount_dp;}
	if (num($nomor_cbg) == 3){$ttl_3_dp = $ttl_amount_dp;}	if (num($nomor_cbg) == 4){$ttl_4_dp = $ttl_amount_dp;}
	if (num($nomor_cbg) == 5){$ttl_5_dp = $ttl_amount_dp;}	if (num($nomor_cbg) == 6){$ttl_6_dp = $ttl_amount_dp;}
	if (num($nomor_cbg) == 7){$ttl_7_dp = $ttl_amount_dp;}	if (num($nomor_cbg) == 8){$ttl_8_dp = $ttl_amount_dp;}
	if (num($nomor_cbg) == 11){$ttl_11_dp = $ttl_amount_dp;}
	if (num($nomor_cbg) == 15){$ttl_15_dp = $ttl_amount_dp;}
	if (num($nomor_cbg) == 14){$ttl_14_dp = $ttl_amount_dp;}	
	}
$query_inst = q_set($__p_query_inst, "SELECT kd_branch, sum(amount) FROM vip_billing_payment a where  dt_payment between ? and ? and status = 'PAID' and (jns_payment = 'Installment 1' or jns_payment = 'Installment 2' or jns_payment = 'Installment 3') group by kd_branch", [(string) ($date_start), (string) ($date_end)]);

$result_inst=db_query_or_die("Wah error nih155", $query_inst, $__p_query_inst ?? []);

while ($r_total_inst = db_fetch($result_inst))
	{ 
	$nomor_cbg = $r_total_inst[0];
	$ttl_amount_inst = $r_total_inst[1];

	if (num($nomor_cbg) == 1){$ttl_1_inst = $ttl_amount_inst;}	if (num($nomor_cbg) == 2){$ttl_2_inst = $ttl_amount_inst;}
	if (num($nomor_cbg) == 3){$ttl_3_inst = $ttl_amount_inst;}	if (num($nomor_cbg) == 4){$ttl_4_inst = $ttl_amount_inst;}
	if (num($nomor_cbg) == 5){$ttl_5_inst = $ttl_amount_inst;}	if (num($nomor_cbg) == 6){$ttl_6_inst = $ttl_amount_inst;}
	if (num($nomor_cbg) == 7){$ttl_7_inst = $ttl_amount_inst;}	if (num($nomor_cbg) == 8){$ttl_8_inst = $ttl_amount_inst;}
	if (num($nomor_cbg) == 11){$ttl_11_inst = $ttl_amount_inst;}
	if (num($nomor_cbg) == 15){$ttl_15_inst = $ttl_amount_inst;}
	if (num($nomor_cbg) == 14){$ttl_14_inst = $ttl_amount_inst;}	
	}

$query_full = q_set($__p_query_full, "SELECT kd_branch, sum(amount) FROM vip_billing_payment a where  dt_payment between ? and ? and status = 'PAID' and (jns_payment = 'Full Payment') group by kd_branch", [(string) ($date_start), (string) ($date_end)]);

$result_full=db_query_or_die("Wah error nih15555", $query_full, $__p_query_full ?? []);

while ($r_total_full = db_fetch($result_full))
	{ 
	$nomor_cbg = $r_total_full[0];
	$ttl_amount_full = $r_total_full[1];

	if (num($nomor_cbg) == 1){$ttl_1_full = $ttl_amount_full;}	if (num($nomor_cbg) == 2){$ttl_2_full = $ttl_amount_full;}
	if (num($nomor_cbg) == 3){$ttl_3_full = $ttl_amount_full;}	if (num($nomor_cbg) == 4){$ttl_4_full = $ttl_amount_full;}
	if (num($nomor_cbg) == 5){$ttl_5_full = $ttl_amount_full;}	if (num($nomor_cbg) == 6){$ttl_6_full = $ttl_amount_full;}
	if (num($nomor_cbg) == 7){$ttl_7_full = $ttl_amount_full;}	if (num($nomor_cbg) == 8){$ttl_8_full = $ttl_amount_full;}
	if (num($nomor_cbg) == 11){$ttl_11_full = $ttl_amount_full;}
	if (num($nomor_cbg) == 15){$ttl_15_full = $ttl_amount_full;}
	if (num($nomor_cbg) == 14){$ttl_14_full = $ttl_amount_full;}	
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
	$ttl_15 = num($ttl_15_reg)+ num($ttl_15_dp) + num($ttl_15_inst) + num($ttl_15_material) + num($ttl_15_full);	  
	$ttl_14 = num($ttl_14_reg)+ num($ttl_14_dp) + num($ttl_14_inst) + num($ttl_14_material) + num($ttl_14_full);	 

?>
  
  <section class="content">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
				<div id="printArea">
          <table width="40%"  class="table table-bordered table-striped" id="example1">
       <tbody>
         <tr>
           <th colspan="14" scope="row"><strong>VIP ALL Center </strong>Summary Income</th>
           </tr>
         <tr>
           <th width="6%" scope="row">Center</th>
           <td width="11%">East Sby</td>
           <td width="9%">West Sby</td>
           <td width="8%">Denpasar</td>
           <td width="8%">Malang</td>
           <td width="10%">Medan</td>
           <td width="6%">South  Jkt</td>
           <td width="9%">North Jkt</td>
           <td width="11%">West Jkt</td>
           <td width="7%">Bandung</td>
           <td width="6%">&nbsp;</td>
           <td width="9%">PIK</td>
           <td width="9%">CA</td>
           <td width="9%">Grand Total</td>
         </tr>
         <tr>
           <th scope="row">Registration</th>
           <td><?php echo number_format(num($ttl_1_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_2_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_3_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_8_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_14_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_4_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_5_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_6_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_7_reg),0,".",".") ?></td>
           <td>&nbsp;</td>
           <td><?php echo number_format(num($ttl_11_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_15_reg),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_1_reg) + num($ttl_2_reg) + num($ttl_3_reg) + num($ttl_4_reg) + num($ttl_5_reg) + num($ttl_6_reg) + num($ttl_7_reg) + num($ttl_8_reg) + num($ttl_11_reg) + num($ttl_15_reg) + num($ttl_14_reg),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row">Material Cost</th>
           <td><?php echo number_format(num($ttl_1_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_2_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_3_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_8_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_14_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_4_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_5_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_6_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_7_material),0,".",".") ?></td>
           <td>&nbsp;</td>
           <td><?php echo number_format(num($ttl_11_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_15_material),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_1_material) + num($ttl_2_material) + num($ttl_3_material) + num($ttl_4_material) + num($ttl_5_material) + num($ttl_6_material) + num($ttl_7_material) + num($ttl_8_material) + num($ttl_11_material) + num($ttl_15_material) + num($ttl_14_material),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row"> DP</th>
           <td><?php echo number_format(num($ttl_1_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_2_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_3_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_8_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_14_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_5_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_6_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_7_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_8_dp),0,".",".") ?></td>
           <td>&nbsp;</td>
           <td><?php echo number_format(num($ttl_11_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_15_dp),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_1_dp) + num($ttl_2_dp) + num($ttl_3_dp) + num($ttl_4_dp) + num($ttl_5_dp) + num($ttl_6_dp) + num($ttl_7_dp) + num($ttl_8_dp) + num($ttl_11_dp) + num($ttl_15_dp) + num($ttl_14_dp),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row">Installment</th>
           <td><?php echo number_format(num($ttl_1_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_2_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_3_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_8_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_14_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_4_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_5_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_6_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_7_inst),0,".",".") ?></td>
           <td>&nbsp;</td>
           <td><?php echo number_format(num($ttl_11_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_15_inst),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_1_inst) + num($ttl_2_inst) + num($ttl_3_inst) + num($ttl_4_inst) + num($ttl_5_inst) + num($ttl_6_inst) + num($ttl_7_inst) + num($ttl_8_inst) + num($ttl_11_inst) +num($ttl_15_inst) + num($ttl_14_inst),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row">Full Payment</th>
           <td><?php echo number_format(num($ttl_1_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_2_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_3_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_8_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_14_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_4_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_5_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_6_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_7_full),0,".",".") ?></td>
           <td>&nbsp;</td>
           <td><?php echo number_format(num($ttl_11_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_15_full),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_1_full) + num($ttl_2_full) + num($ttl_3_full) + num($ttl_4_full) + num($ttl_5_full) + num($ttl_6_full) + num($ttl_7_full) + num($ttl_8_full) + num($ttl_11_full) + num($ttl_15_full) + num($ttl_14_full),0,".",".") ?></td>
           </tr>
         <tr>
           <th scope="row">Total Payment</th>
           <td><?php echo number_format(num($ttl_1),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_2),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_3),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_8),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_14),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_4),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_5),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_6),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_7),0,".",".") ?></td>
           <td>&nbsp;</td>
           <td><?php echo number_format(num($ttl_11),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_15),0,".",".") ?></td>
           <td><?php echo number_format(num($ttl_1) + num($ttl_2) + num($ttl_3) + num($ttl_4) + num($ttl_5) + num($ttl_6) + num($ttl_7) + num($ttl_8)+num($ttl_11) + num($ttl_15),0,".",".") ?></td>
         </tr>
       </tbody>
     </table>          	
            
			  <div class="box-body">
<?php
function fmt($n) {
  return number_format(num((float)$n), 0, ',', '.');
}
	// escape (karena pakai mysql_* dan bukan prepared statement)
$start_date_esc = $start_date;
$end_date_esc   = $date_end;

$endMonth = (int)date('n', strtotime($date_end)); // 1..12

$monthKeys  = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec');
$monthNames = array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des');

$visibleMonths     = array_slice($monthKeys, 0, $endMonth);
$visibleMonthNames = array_slice($monthNames, 0, $endMonth);
	
if ($kd_cbg !='100'){	
$query_monthly = q_set($__p_query_monthly, "SELECT \r
  jenis,\r
  SUM(CASE WHEN MONTH(dt_payment) = 1  THEN amount ELSE 0 END) AS Jan,\r
  SUM(CASE WHEN MONTH(dt_payment) = 2  THEN amount ELSE 0 END) AS Feb,\r
  SUM(CASE WHEN MONTH(dt_payment) = 3  THEN amount ELSE 0 END) AS Mar,\r
  SUM(CASE WHEN MONTH(dt_payment) = 4  THEN amount ELSE 0 END) AS Apr,\r
  SUM(CASE WHEN MONTH(dt_payment) = 5  THEN amount ELSE 0 END) AS May,\r
  SUM(CASE WHEN MONTH(dt_payment) = 6  THEN amount ELSE 0 END) AS Jun,\r
  SUM(CASE WHEN MONTH(dt_payment) = 7  THEN amount ELSE 0 END) AS Jul,\r
  SUM(CASE WHEN MONTH(dt_payment) = 8  THEN amount ELSE 0 END) AS Aug,\r
  SUM(CASE WHEN MONTH(dt_payment) = 9  THEN amount ELSE 0 END) AS Sept,\r
  SUM(CASE WHEN MONTH(dt_payment) = 10 THEN amount ELSE 0 END) AS Oct,\r
  SUM(CASE WHEN MONTH(dt_payment) = 11 THEN amount ELSE 0 END) AS Nov,\r
  SUM(CASE WHEN MONTH(dt_payment) = 12 THEN amount ELSE 0 END) AS `Dec`,\r
  SUM(amount) AS Total\r
FROM (\r
  SELECT\r
    amount,\r
    dt_payment,\r
    CASE\r
      WHEN jns_payment = 'Registration'  THEN 'Registration'\r
      WHEN jns_payment = 'Down Payment' THEN 'DP'\r
      WHEN jns_payment LIKE 'Inst%'     THEN 'Installment'\r
      WHEN jns_payment = 'Full Payment' THEN 'Full Payment'\r
      ELSE NULL\r
    END AS jenis\r
  FROM vip_billing_payment\r
  WHERE status = 'PAID'\r
    AND kd_branch = ?\r
    AND dt_payment BETWEEN ? and ?\r
) x\r
WHERE jenis IS NOT NULL\r
GROUP BY jenis\r
ORDER BY FIELD(jenis,'Registration','DP','Installment','Full Payment')\r
", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);}
else
{	
$query_monthly = q_set($__p_query_monthly, "SELECT \r
  jenis,\r
  SUM(CASE WHEN MONTH(dt_payment) = 1  THEN amount ELSE 0 END) AS Jan,\r
  SUM(CASE WHEN MONTH(dt_payment) = 2  THEN amount ELSE 0 END) AS Feb,\r
  SUM(CASE WHEN MONTH(dt_payment) = 3  THEN amount ELSE 0 END) AS Mar,\r
  SUM(CASE WHEN MONTH(dt_payment) = 4  THEN amount ELSE 0 END) AS Apr,\r
  SUM(CASE WHEN MONTH(dt_payment) = 5  THEN amount ELSE 0 END) AS May,\r
  SUM(CASE WHEN MONTH(dt_payment) = 6  THEN amount ELSE 0 END) AS Jun,\r
  SUM(CASE WHEN MONTH(dt_payment) = 7  THEN amount ELSE 0 END) AS Jul,\r
  SUM(CASE WHEN MONTH(dt_payment) = 8  THEN amount ELSE 0 END) AS Aug,\r
  SUM(CASE WHEN MONTH(dt_payment) = 9  THEN amount ELSE 0 END) AS Sept,\r
  SUM(CASE WHEN MONTH(dt_payment) = 10 THEN amount ELSE 0 END) AS Oct,\r
  SUM(CASE WHEN MONTH(dt_payment) = 11 THEN amount ELSE 0 END) AS Nov,\r
  SUM(CASE WHEN MONTH(dt_payment) = 12 THEN amount ELSE 0 END) AS `Dec`,\r
  SUM(amount) AS Total\r
FROM (\r
  SELECT\r
    amount,\r
    dt_payment,\r
    CASE\r
      WHEN jns_payment = 'Registration'  THEN 'Registration'\r
      WHEN jns_payment = 'Down Payment' THEN 'DP'\r
      WHEN jns_payment LIKE 'Inst%'     THEN 'Installment'\r
      WHEN jns_payment = 'Full Payment' THEN 'Full Payment'\r
      ELSE NULL\r
    END AS jenis\r
  FROM vip_billing_payment\r
  WHERE status = 'PAID'\r
    AND (kd_branch = '1' or kd_branch = '2' or kd_branch = '3' or kd_branch = '4' or kd_branch = '5' or kd_branch = '6' or kd_branch = '7' or kd_branch = '8' or kd_branch = '11' or kd_branch = '14' or kd_branch = '15' ) \r
    AND dt_payment BETWEEN ? and ?\r
) x\r
WHERE jenis IS NOT NULL\r
GROUP BY jenis\r
ORDER BY FIELD(jenis,'Registration','DP','Installment','Full Payment')\r
", [(string) ($date_start), (string) ($date_end)]);}	
$result_monthly=db_query_or_die("Wah error nih15555", $query_monthly, $__p_query_monthly ?? []);
$rows = array();
while ($r = db_fetch($result_monthly, PDO::FETCH_ASSOC)) {
  $rows[] = $r;
} 		   
?>				  
<table class="table table-bordered table-striped" id="example1">
    <thead>
      <tr>
        <th style="text-align:left"><?php echo e($cabang);	  ?></th>

        <?php for ($i=0; $i<cnt($visibleMonthNames); $i++): ?>
          <th class="num"><?php echo e($visibleMonthNames[$i]); ?></th>
        <?php endfor; ?>

        <th class="num">Total</th>
      </tr>
    </thead>

    <tbody>
      <?php if (cnt($rows) == 0): ?>
        <tr>
          <td colspan="<?php echo 2 + cnt($visibleMonths); ?>" style="text-align:center; padding:14px;">
            Data tidak ada pada periode ini.
          </td>
        </tr>
      <?php else: ?>
        <?php for ($i=0; $i<cnt($rows); $i++): $r_m = $rows[$i]; ?>
          <tr>
            <td><?php echo htmlspecialchars($r_m['jenis']); ?></td>

            <?php for ($j=0; $j<cnt($visibleMonths); $j++):
              $m = $visibleMonths[$j];
              $val = isset($r_m[$m]) ? $r_m[$m] : 0;
            ?>
              <td class="num"><?php echo e(fmt($val)); ?></td>
            <?php endfor; ?>

            <td class="num" style="font-weight:bold;">
              <?php echo e(fmt(isset($r_m['Total']) ? $r_m['Total'] : 0)); ?>
            </td>
          </tr>
        <?php endfor; ?>
      <?php endif; ?>
    </tbody>
  </table>	
			  </div>				  
			  </div>

    </div>       
<a href="vip_receipt_monthlyxl.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a
	   </section>         
    
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
		
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example2">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="12%">Receipt Number</th>
                  <th width="7%">Effective Date</th>
                  <th width="7%"> Receipt Date</th>
                  <th width="13%">Student Name</th>
                  <th width="14%">Class Code</th>
                  <th width="14%">Program</th>
                  <th width="10%">Detail</th>
                  <th width="10%">Amount</th>
                  <th width="11%">Payment Metodh</th>
                  <th width="11%">Action</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							//$query_nama = "SELECT nama_lengkap from ves_data.vip_student_data where kd_biodata = '$r[3]' and kd_branch = '$r[5]'";	
						$query_nama = q_set($__p_query_nama, "SELECT nama_lengkap from ves_data.vip_student_data where kd_biodata = ? ", [(string) ($r[3])]);	
							
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
                  <td><a href="#" 
target="popup" 
onclick="window.open('vipbillreceipt_dtl.php?id=<?php echo e(u($r[10])); ?>','popup','width=1000,height=800'); return false;"><?php echo e($r[2]) ; ?></a></td>
                  <td><?php echo e($r[0]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($nama_student) ; ?></td>
                  <td><?php echo e($r[12]) ; ?></td>
                  <td><?php echo e($nama_program) ; ?> - <?php echo e($r[11]) ; ?></td>
                  <td><?php echo e($r[7]) ; ?></td>
                  <td><?php echo number_format(num($r[6]),0,".",".") ; ?></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  <td><a href="vipbookreceiptprint.php" 
target="popup" 
onclick="window.open('../printable/vipreceiptprint.php?no=<?php echo e(u($r[10])); ?>','popup','width=1000,height=800'); return false;"><img src="../imgs/printer.png" width="30" height="30"></a></td>
                </tr>
                <?php $total_rp = num($total_rp) + num($r[6]); $no_urut = num($no_urut) + 1; } }
?>       
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <div class="box">
         	<div class="box-body">
         		<label>TOTAL INCOME : Rp. <?php echo number_format(num($total_rp),0,".",".")  ; ?></label>
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

</div>

<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./.plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
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
	  <script>
function printReport() {
  window.print();
}
</script>
</body>
</html>
