<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";


$tgl_dipilih = in_val('tgl_dipilih', 'get');

if ($awal_bln ==''){$awal_bln = $tgl_dipilih."-01";}
$akhir_bln = date("Y-m-t", strtotime($awal_bln));
//====

$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";


$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}
if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
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

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
if (num($kd_cbg) ==100){$cabang = 'National';}



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
 <?php // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_sum_receipt_new.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>VIP Income Summary<br>
     </h1>
     <?php 
 if ($cabang =='National')
	{
	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata where a.id_receipt <> '' \r
\tand dt_payment between ? and ? group by id_receipt order by id_receipt", [(string) ($awal_bln), (string) ($akhir_bln)]);		
	}
else
	{
	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata where a.id_receipt <> '' and a.kd_branch = ?\r
\tand dt_payment between ? and ? group by id_receipt order by id_receipt", [(string) ($kd_cbg), (string) ($awal_bln), (string) ($akhir_bln)]);		
	}

$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         <tr>
           <th width="11%" scope="row">Center</th>
           <td width="89%"><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">

             <option selected="selected">National</option>
           </select>
           <?php echo e($jml_minggu) ; ?></td>
         </tr>
         <tr>
           <th scope="row">Period Date</th>
           <td><strong><font color="#000000"><small>
             <input type="MONTH" format="dd/MM/yyyy" name="tgl_dipilih" id="date2" value="<?php echo e($tgl_dipilih); ; ?>" onChange="this.form.submit()">
           </small></font></strong></td>
         </tr>
       </tbody>
     </table>
   

   </section>
 <?php if ($cabang =='National')
	{
$query_east = q_set($__p_query_east, "SELECT kd_branch, sum(amount) FROM vip_billing_payment a where  dt_payment between ? and ? group by kd_branch", [(string) ($awal_bln), (string) ($akhir_bln)]);
$result_east=db_query_or_die("Wah error nih1", $query_east, $__p_query_east ?? []);
while ($r_total = db_fetch($result_east))
	{ 
	$nomor_cbg = $r_total[0];
	$ttl_amount = $r_total[1];

	if (num($nomor_cbg) == 1){$ttl_1 = $ttl_amount;}	if (num($nomor_cbg) == 2){$ttl_2 = $ttl_amount;}
	if (num($nomor_cbg) == 3){$ttl_3 = $ttl_amount;}	if (num($nomor_cbg) == 4){$ttl_4 = $ttl_amount;}
	if (num($nomor_cbg) == 5){$ttl_5 = $ttl_amount;}	if (num($nomor_cbg) == 6){$ttl_6 = $ttl_amount;}
	if (num($nomor_cbg) == 7){$ttl_7 = $ttl_amount;}	if (num($nomor_cbg) == 8){$ttl_8 = $ttl_amount;}
	
	}	
	
//====
	  ?>  
<?php } ?>	    
 <?php if ($cabang =='National')
	{
$query_east = q_set($__p_query_east, "SELECT kd_branch, sum(amount) FROM vip_billing_payment a where  dt_payment between ? and ? group by kd_branch", [(string) ($awal_bln), (string) ($akhir_bln)]);

$result_east=db_query_or_die("Wah error nih1", $query_east, $__p_query_east ?? []);

while ($r_total = db_fetch($result_east))
	{ 
	$nomor_cbg = $r_total[0];
	$ttl_amount = $r_total[1];

	if (num($nomor_cbg) == 1){$ttl_1 = $ttl_amount;}	if (num($nomor_cbg) == 2){$ttl_2 = $ttl_amount;}
	if (num($nomor_cbg) == 3){$ttl_3 = $ttl_amount;}	if (num($nomor_cbg) == 4){$ttl_4 = $ttl_amount;}
	if (num($nomor_cbg) == 5){$ttl_5 = $ttl_amount;}	if (num($nomor_cbg) == 6){$ttl_6 = $ttl_amount;}
	if (num($nomor_cbg) == 7){$ttl_7 = $ttl_amount;}	if (num($nomor_cbg) == 8){$ttl_8 = $ttl_amount;}
	}		
?>
  
  <section class="content">
         
            <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
          <table width="40%"  class="table table-bordered table-striped" id="example1">
       <tbody>
         <tr>
           <th colspan="12" scope="row"><strong>VIP  </strong>Summary Income by Payment</th>
         </tr>
         <tr>
           <th width="10%" scope="row">Week</th>
           <td width="7%">East Sby</td>
           <td width="9%">West Sby</td>
           <td width="8%">Denpasar</td>
           <td width="8%">Malang</td>
           <td width="10%">East Area Total </td>
           <td width="6%">South  Jkt</td>
           <td width="9%">North Jkt</td>
           <td width="11%">West Jkt</td>
           <td width="7%">Bandung</td>
           <td width="6%">Weast Area Total</td>
           <td width="9%">Grand Total</td>
         </tr>
<?php //==== report weekly == ?>
<?php
function jml_minggu($awal_bln, $akhir_bln){
$detik = 24 * 3600;
$tgl_awal = strtotime($awal_bln);
$tgl_akhir = strtotime($akhir_bln);
$minggu = 1;
$nm_week = 1;
$mulai_minggu_1 = $awal_bln;
for ($i=$tgl_awal; $i < $tgl_akhir; $i = num($i) + num(($detik)))
{

	if (date("w", $i) == "0")
		{
		if (num($minggu) == 1)
		{
		$selesai_minggu_1 = strtotime("-1 day", $i);
		$selesai_minggu_1 = date('Y-m-d',$selesai_minggu_1);					
//		echo $mulai_minggu_1." sampai " .$selesai_minggu_1 ; echo "<br>"; 
			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where  dt_payment between ? and ? ", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7];
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_4_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_5_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_6_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;						
					
					
?>		
<tr>
           <th scope="row"><?php echo e($nm_week) ?> <br>
            (<?php echo date('d M',strtotime($mulai_minggu_1)) ?> - <?php echo date('d M',strtotime($selesai_minggu_1)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>	
<?php }	$nm_week = num($nm_week) +1 ;				
		$mulai_minggu = date('Y-m-d',$i);
		$selesai_minggu = strtotime("+6 day", $i);
		$selesai_minggu = date('Y-m-d',$selesai_minggu);

			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where  dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
		
			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);

			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{

				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;	
		   ?>
<tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
            (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php		
		$nm_week = num($nm_week) +1 ;}
		else
		{
		$mulai_minggu = date('Y-m-d',$i);
		$selesai_minggu = strtotime("+6 day", $i);
		
		if ($selesai_minggu <= $tgl_akhir)
			{
//			$selesai_minggu_terakhir = $selesai_minggu	;
			$selesai_minggu_terakhir = $selesai_minggu; 	
			$selesai_minggu = date('Y-m-d',$selesai_minggu);				

			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where  dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}	
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;				
		   ?>
				
			<tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
             (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>	
<?php
		$nm_week = num($nm_week) +1 ;	}
		else
			{
			$ambiltgltua = $tanggal_akhir;


	//		echo $mulai_minggu_terakhir." sampai " .$lastDateOfMonth ; echo "<br>";	 		
			}		
		}
		$minggu++;
		}

	}
		$lastDateOfMonth = date("Y-m-t", strtotime($akhir_bln));
		$mulai_minggu_terakhir = strtotime("+1 day", $selesai_minggu_terakhir);
		$mulai_minggu_terakhir = date('Y-m-d',$mulai_minggu_terakhir);	

				$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where  dt_payment between ? and ? ", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;	
		   ?>
			         <tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
             (<?php echo date('d M',strtotime($mulai_minggu_terakhir)) ?> - <?php echo date('d M',strtotime($lastDateOfMonth)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php
}

echo e(jml_minggu($awal_bln, $akhir_bln));
?>
<?php 
			$query_periode_monthly = q_set($__p_query_periode_monthly, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where  dt_payment like ? ", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_monthly =db_query_or_die("Wah error nih1", $query_periode_monthly, $__p_query_periode_monthly ?? []);

			while ($r_periode_monthly = db_fetch($result_periode_monthly))
				{ 
				$cbg1 = $r_periode_monthly[0];$cbg2 = $r_periode_monthly[1];$cbg3 = $r_periode_monthly[2];	$cbg4 = $r_periode_monthly[3];$cbg5 = $r_periode_monthly[4];$cbg6 = $r_periode_monthly[5];
				$cbg7 = $r_periode_monthly[6];$cbg8 = $r_periode_monthly[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;		
?>
      <tr>
           <th scope="row">Total Monthly</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php 
			$query_periode_yearly = q_set($__p_query_periode_yearly, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where  dt_payment between '2019-01-01' and ? ", [(string) ($akhir_bln)]);
			$result_periode_yearly =db_query_or_die("Wah error nih1", $query_periode_yearly, $__p_query_periode_yearly ?? []);

			while ($r_periode_yearly = db_fetch($result_periode_yearly))
				{ 
				$cbg1 = $r_periode_yearly[0];$cbg2 = $r_periode_yearly[1];$cbg3 = $r_periode_yearly[2];	$cbg4 = $r_periode_yearly[3];$cbg5 = $r_periode_yearly[4];$cbg6 = $r_periode_yearly[5];
				$cbg7 = $r_periode_yearly[6];$cbg8 = $r_periode_yearly[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;				
?>         
      <tr>
           <th scope="row">Total Year Todate</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>         
       </tbody>
     </table>          	
            </div>
	  </div>       

	   </section> 
<section class="content">
         
            <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
          <table width="40%"  class="table table-bordered table-striped" id="example1">
       <tbody>
         <tr>
           <th colspan="12" scope="row"><strong>VIP  </strong>Summary Income by Registration</th>
         </tr>
         <tr>
           <th width="10%" scope="row">Week</th>
           <td width="7%">East Sby</td>
           <td width="9%">West Sby</td>
           <td width="8%">Denpasar</td>
           <td width="8%">Malang</td>
           <td width="10%">East Area Total </td>
           <td width="6%">South  Jkt</td>
           <td width="9%">North Jkt</td>
           <td width="11%">West Jkt</td>
           <td width="7%">Bandung</td>
           <td width="6%">Weast Area Total</td>
           <td width="9%">Grand Total</td>
         </tr>
<?php //==== report weekly == ?>
<?php
function jml_minggureg($awal_bln, $akhir_bln){
$detik = 24 * 3600;
$tgl_awal = strtotime($awal_bln);
$tgl_akhir = strtotime($akhir_bln);
$minggu = 1;
$nm_week = 1;
$mulai_minggu_1 = $awal_bln;
for ($i=$tgl_awal; $i < $tgl_akhir; $i = num($i) + num(($detik)))
{

	if (date("w", $i) == "0")
		{
		if (num($minggu) == 1)
		{
		$selesai_minggu_1 = strtotime("-1 day", $i);
		$selesai_minggu_1 = date('Y-m-d',$selesai_minggu_1);					
//		echo $mulai_minggu_1." sampai " .$selesai_minggu_1 ; echo "<br>"; 
			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Registration' and dt_payment between ? and ? ", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7];
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_4_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	

			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_5_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_6_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;						
					
					
?>		
<tr>
           <th scope="row"><?php echo e($nm_week) ?> <br>
            (<?php echo date('d M',strtotime($mulai_minggu_1)) ?> - <?php echo date('d M',strtotime($selesai_minggu_1)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>	
<?php }	$nm_week = num($nm_week) +1 ;				
		$mulai_minggu = date('Y-m-d',$i);
		$selesai_minggu = strtotime("+6 day", $i);
		$selesai_minggu = date('Y-m-d',$selesai_minggu);

			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Registration' and dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
		
			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);

			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{

				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;	
		   ?>
<tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
            (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php		
		$nm_week = num($nm_week) +1 ;}
		else
		{
		$mulai_minggu = date('Y-m-d',$i);
		$selesai_minggu = strtotime("+6 day", $i);
		
		if ($selesai_minggu <= $tgl_akhir)
			{
//			$selesai_minggu_terakhir = $selesai_minggu	;
			$selesai_minggu_terakhir = $selesai_minggu; 	
			$selesai_minggu = date('Y-m-d',$selesai_minggu);				

			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Registration' and dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}	
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;				
		   ?>
				
			<tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
             (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>	
<?php
		$nm_week = num($nm_week) +1 ;	}
		else
			{
			$ambiltgltua = $tanggal_akhir;


	//		echo $mulai_minggu_terakhir." sampai " .$lastDateOfMonth ; echo "<br>";	 		
			}		
		}
		$minggu++;
		}

	}
		$lastDateOfMonth = date("Y-m-t", strtotime($akhir_bln));
		$mulai_minggu_terakhir = strtotime("+1 day", $selesai_minggu_terakhir);
		$mulai_minggu_terakhir = date('Y-m-d',$mulai_minggu_terakhir);	

				$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Registration' and dt_payment between ? and ? ", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;	
		   ?>
			         <tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
             (<?php echo date('d M',strtotime($mulai_minggu_terakhir)) ?> - <?php echo date('d M',strtotime($lastDateOfMonth)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php
}

echo e(jml_minggureg($awal_bln, $akhir_bln));
?>
<?php 
			$query_periode_monthly = q_set($__p_query_periode_monthly, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Registration' and dt_payment like ? ", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_monthly =db_query_or_die("Wah error nih1", $query_periode_monthly, $__p_query_periode_monthly ?? []);

			while ($r_periode_monthly = db_fetch($result_periode_monthly))
				{ 
				$cbg1 = $r_periode_monthly[0];$cbg2 = $r_periode_monthly[1];$cbg3 = $r_periode_monthly[2];	$cbg4 = $r_periode_monthly[3];$cbg5 = $r_periode_monthly[4];$cbg6 = $r_periode_monthly[5];
				$cbg7 = $r_periode_monthly[6];$cbg8 = $r_periode_monthly[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;		
?>
      <tr>
           <th scope="row">Total Monthly</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php 
			$query_periode_yearly = q_set($__p_query_periode_yearly, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Registration' and dt_payment between '2019-01-01' and ? ", [(string) ($akhir_bln)]);
			$result_periode_yearly =db_query_or_die("Wah error nih1", $query_periode_yearly, $__p_query_periode_yearly ?? []);

			while ($r_periode_yearly = db_fetch($result_periode_yearly))
				{ 
				$cbg1 = $r_periode_yearly[0];$cbg2 = $r_periode_yearly[1];$cbg3 = $r_periode_yearly[2];	$cbg4 = $r_periode_yearly[3];$cbg5 = $r_periode_yearly[4];$cbg6 = $r_periode_yearly[5];
				$cbg7 = $r_periode_yearly[6];$cbg8 = $r_periode_yearly[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;				
?>         
      <tr>
           <th scope="row">Total Year Todate</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>         
       </tbody>
     </table>          	
            </div>
	  </div>       

	   </section>	
<section class="content">
         
            <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
          <table width="40%"  class="table table-bordered table-striped" id="example1">
       <tbody>
         <tr>
           <th colspan="12" scope="row"><strong>VIP  </strong>Summary Income by Down Payment</th>
         </tr>
         <tr>
           <th width="10%" scope="row">Week</th>
           <td width="7%">East Sby</td>
           <td width="9%">West Sby</td>
           <td width="8%">Denpasar</td>
           <td width="8%">Malang</td>
           <td width="10%">East Area Total </td>
           <td width="6%">South  Jkt</td>
           <td width="9%">North Jkt</td>
           <td width="11%">West Jkt</td>
           <td width="7%">Bandung</td>
           <td width="6%">Weast Area Total</td>
           <td width="9%">Grand Total</td>
         </tr>
<?php //==== report weekly == ?>
<?php
function jml_minggudp($awal_bln, $akhir_bln){
$detik = 24 * 3600;
$tgl_awal = strtotime($awal_bln);
$tgl_akhir = strtotime($akhir_bln);
$minggu = 1;
$nm_week = 1;
$mulai_minggu_1 = $awal_bln;
for ($i=$tgl_awal; $i < $tgl_akhir; $i = num($i) + num(($detik)))
{

	if (date("w", $i) == "0")
		{
		if (num($minggu) == 1)
		{
		$selesai_minggu_1 = strtotime("-1 day", $i);
		$selesai_minggu_1 = date('Y-m-d',$selesai_minggu_1);					
//		echo $mulai_minggu_1." sampai " .$selesai_minggu_1 ; echo "<br>"; 
			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Down Payment' and dt_payment between ? and ? ", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7];
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_4_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	

			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_5_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_6_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;						
					
					
?>		
<tr>
           <th scope="row"><?php echo e($nm_week) ?> <br>
            (<?php echo date('d M',strtotime($mulai_minggu_1)) ?> - <?php echo date('d M',strtotime($selesai_minggu_1)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>	
<?php }	$nm_week = num($nm_week) +1 ;				
		$mulai_minggu = date('Y-m-d',$i);
		$selesai_minggu = strtotime("+6 day", $i);
		$selesai_minggu = date('Y-m-d',$selesai_minggu);

			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Down Payment' and dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
		
			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);

			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{

				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;	
		   ?>
<tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
            (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php		
		$nm_week = num($nm_week) +1 ;}
		else
		{
		$mulai_minggu = date('Y-m-d',$i);
		$selesai_minggu = strtotime("+6 day", $i);
		
		if ($selesai_minggu <= $tgl_akhir)
			{
//			$selesai_minggu_terakhir = $selesai_minggu	;
			$selesai_minggu_terakhir = $selesai_minggu; 	
			$selesai_minggu = date('Y-m-d',$selesai_minggu);				

			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Down Payment' and dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}	
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;				
		   ?>
				
			<tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
             (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>	
<?php
		$nm_week = num($nm_week) +1 ;	}
		else
			{
			$ambiltgltua = $tanggal_akhir;


	//		echo $mulai_minggu_terakhir." sampai " .$lastDateOfMonth ; echo "<br>";	 		
			}		
		}
		$minggu++;
		}

	}
		$lastDateOfMonth = date("Y-m-t", strtotime($akhir_bln));
		$mulai_minggu_terakhir = strtotime("+1 day", $selesai_minggu_terakhir);
		$mulai_minggu_terakhir = date('Y-m-d',$mulai_minggu_terakhir);	

				$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Down Payment' and dt_payment between ? and ? ", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;	
		   ?>
			         <tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
             (<?php echo date('d M',strtotime($mulai_minggu_terakhir)) ?> - <?php echo date('d M',strtotime($lastDateOfMonth)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php
}

echo e(jml_minggudp($awal_bln, $akhir_bln));
?>
<?php 
			$query_periode_monthly = q_set($__p_query_periode_monthly, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Down Payment' and dt_payment like ? ", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_monthly =db_query_or_die("Wah error nih1", $query_periode_monthly, $__p_query_periode_monthly ?? []);

			while ($r_periode_monthly = db_fetch($result_periode_monthly))
				{ 
				$cbg1 = $r_periode_monthly[0];$cbg2 = $r_periode_monthly[1];$cbg3 = $r_periode_monthly[2];	$cbg4 = $r_periode_monthly[3];$cbg5 = $r_periode_monthly[4];$cbg6 = $r_periode_monthly[5];
				$cbg7 = $r_periode_monthly[6];$cbg8 = $r_periode_monthly[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;		
?>
      <tr>
           <th scope="row">Total Monthly</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php 
			$query_periode_yearly = q_set($__p_query_periode_yearly, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where jns_payment = 'Down Payment' and dt_payment between '2019-01-01' and ? ", [(string) ($akhir_bln)]);
			$result_periode_yearly =db_query_or_die("Wah error nih1", $query_periode_yearly, $__p_query_periode_yearly ?? []);

			while ($r_periode_yearly = db_fetch($result_periode_yearly))
				{ 
				$cbg1 = $r_periode_yearly[0];$cbg2 = $r_periode_yearly[1];$cbg3 = $r_periode_yearly[2];	$cbg4 = $r_periode_yearly[3];$cbg5 = $r_periode_yearly[4];$cbg6 = $r_periode_yearly[5];
				$cbg7 = $r_periode_yearly[6];$cbg8 = $r_periode_yearly[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;				
?>         
      <tr>
           <th scope="row">Total Year Todate</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>         
       </tbody>
     </table>          	
            </div>
	  </div>       

	   </section>
<section class="content">
         
            <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
          <table width="40%"  class="table table-bordered table-striped" id="example1">
       <tbody>
         <tr>
           <th colspan="12" scope="row"><strong>VIP  </strong>Summary Income by Tuition</th>
         </tr>
         <tr>
           <th width="10%" scope="row">Week</th>
           <td width="7%">East Sby</td>
           <td width="9%">West Sby</td>
           <td width="8%">Denpasar</td>
           <td width="8%">Malang</td>
           <td width="10%">East Area Total </td>
           <td width="6%">South  Jkt</td>
           <td width="9%">North Jkt</td>
           <td width="11%">West Jkt</td>
           <td width="7%">Bandung</td>
           <td width="6%">Weast Area Total</td>
           <td width="9%">Grand Total</td>
         </tr>
<?php //==== report weekly == ?>
<?php
function jml_minggutf($awal_bln, $akhir_bln){
$detik = 24 * 3600;
$tgl_awal = strtotime($awal_bln);
$tgl_akhir = strtotime($akhir_bln);
$minggu = 1;
$nm_week = 1;
$mulai_minggu_1 = $awal_bln;
for ($i=$tgl_awal; $i < $tgl_akhir; $i = num($i) + num(($detik)))
{

	if (date("w", $i) == "0")
		{
		if (num($minggu) == 1)
		{
		$selesai_minggu_1 = strtotime("-1 day", $i);
		$selesai_minggu_1 = date('Y-m-d',$selesai_minggu_1);					
//		echo $mulai_minggu_1." sampai " .$selesai_minggu_1 ; echo "<br>"; 
			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where (jns_payment like 'Full%' or jns_payment like 'Install%' )  and dt_payment between ? and ? ", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7];
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_4_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	

			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_5_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_6_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;						
					
					
?>		
<tr>
           <th scope="row"><?php echo e($nm_week) ?> <br>
            (<?php echo date('d M',strtotime($mulai_minggu_1)) ?> - <?php echo date('d M',strtotime($selesai_minggu_1)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>	
<?php }	$nm_week = num($nm_week) +1 ;				
		$mulai_minggu = date('Y-m-d',$i);
		$selesai_minggu = strtotime("+6 day", $i);
		$selesai_minggu = date('Y-m-d',$selesai_minggu);

			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where (jns_payment like 'Full%' or jns_payment like 'Install%' )  and dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
		
			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);

			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{

				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;	
		   ?>
<tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
            (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php		
		$nm_week = num($nm_week) +1 ;}
		else
		{
		$mulai_minggu = date('Y-m-d',$i);
		$selesai_minggu = strtotime("+6 day", $i);
		
		if ($selesai_minggu <= $tgl_akhir)
			{
//			$selesai_minggu_terakhir = $selesai_minggu	;
			$selesai_minggu_terakhir = $selesai_minggu; 	
			$selesai_minggu = date('Y-m-d',$selesai_minggu);				

			$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where (jns_payment like 'Full%' or jns_payment like 'Install%' )  and dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}	
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;				
		   ?>
				
			<tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
             (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>	
<?php
		$nm_week = num($nm_week) +1 ;	}
		else
			{
			$ambiltgltua = $tanggal_akhir;


	//		echo $mulai_minggu_terakhir." sampai " .$lastDateOfMonth ; echo "<br>";	 		
			}		
		}
		$minggu++;
		}

	}
		$lastDateOfMonth = date("Y-m-t", strtotime($akhir_bln));
		$mulai_minggu_terakhir = strtotime("+1 day", $selesai_minggu_terakhir);
		$mulai_minggu_terakhir = date('Y-m-d',$mulai_minggu_terakhir);	

				$query_periode_1 = q_set($__p_query_periode_1, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where (jns_payment like 'Full%' or jns_payment like 'Install%' )  and dt_payment between ? and ? ", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);

			$result_periode_1 =db_query_or_die("Wah error nih1", $query_periode_1, $__p_query_periode_1 ?? []);

			while ($r_periode_1 = db_fetch($result_periode_1))
				{ 
				$cbg1 = $r_periode_1[0];$cbg2 = $r_periode_1[1];$cbg3 = $r_periode_1[2];	$cbg4 = $r_periode_1[3];$cbg5 = $r_periode_1[4];$cbg6 = $r_periode_1[5];
				$cbg7 = $r_periode_1[6];$cbg8 = $r_periode_1[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between ? and ? order by tgl_cetak", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;	
		   ?>
			         <tr>
           <th scope="row"><?php echo e($nm_week) ?><br>
             (<?php echo date('d M',strtotime($mulai_minggu_terakhir)) ?> - <?php echo date('d M',strtotime($lastDateOfMonth)) ?> )</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php
}

echo e(jml_minggutf($awal_bln, $akhir_bln));
?>
<?php 
			$query_periode_monthly = q_set($__p_query_periode_monthly, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where (jns_payment like 'Full%' or jns_payment like 'Install%' )  and dt_payment like ? ", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_monthly =db_query_or_die("Wah error nih1", $query_periode_monthly, $__p_query_periode_monthly ?? []);

			while ($r_periode_monthly = db_fetch($result_periode_monthly))
				{ 
				$cbg1 = $r_periode_monthly[0];$cbg2 = $r_periode_monthly[1];$cbg3 = $r_periode_monthly[2];	$cbg4 = $r_periode_monthly[3];$cbg5 = $r_periode_monthly[4];$cbg6 = $r_periode_monthly[5];
				$cbg7 = $r_periode_monthly[6];$cbg8 = $r_periode_monthly[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu like ? order by tgl_cetak", [(string) ($tgl_dipilih) . "%"]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;		
?>
      <tr>
           <th scope="row">Total Monthly</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>
<?php 
			$query_periode_yearly = q_set($__p_query_periode_yearly, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where (jns_payment like 'Full%' or jns_payment like 'Install%' )  and dt_payment between '2019-01-01' and ? ", [(string) ($akhir_bln)]);
			$result_periode_yearly =db_query_or_die("Wah error nih1", $query_periode_yearly, $__p_query_periode_yearly ?? []);

			while ($r_periode_yearly = db_fetch($result_periode_yearly))
				{ 
				$cbg1 = $r_periode_yearly[0];$cbg2 = $r_periode_yearly[1];$cbg3 = $r_periode_yearly[2];	$cbg4 = $r_periode_yearly[3];$cbg5 = $r_periode_yearly[4];$cbg6 = $r_periode_yearly[5];
				$cbg7 = $r_periode_yearly[6];$cbg8 = $r_periode_yearly[7]; 
				}
						$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg1_old = $r_periode_1_old[0];	
				}
			$cbg1 = num($cbg1) + num($cbg1_old);	
			$cbg1_old = 0;
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_west.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg2_old = $r_periode_1_old[0];	
				}
			$cbg2 = num($cbg2) + num($cbg2_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_bali.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg3_old = $r_periode_1_old[0];	
				}
			$cbg3 = num($cbg3) + num($cbg3_old);	
			$cbg3_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_jkt_02.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg4_old = $r_periode_1_old[0];	
				}
			$cbg4 = num($cbg4) + num($cbg4_old);	
			$cbg4_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_gs.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg5_old = $r_periode_1_old[0];	
				}
			$cbg5 = num($cbg5) + num($cbg5_old);	
			$cbg5_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_m2.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg6_old = $r_periode_1_old[0];	
				}
			$cbg6 = num($cbg6) + num($cbg6_old);	
			$cbg6_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_new_bdg.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg7_old = $r_periode_1_old[0];	
				}
			$cbg7 = num($cbg7) + num($cbg7_old);	
			$cbg7_old = 0;	
			$query_periode_1_old = q_set($__p_query_periode_1_old, "SELECT sum(mount_pat) FROM billing_malang.tb_receipt where waktu between '2019-01-01' and ? order by tgl_cetak", [(string) ($akhir_bln)]);
			$result_periode_1_old =db_query_or_die("Wah error nih2", $query_periode_1_old, $__p_query_periode_1_old ?? []);
			while ($r_periode_1_old = db_fetch($result_periode_1_old))
				{
				$cbg8_old = $r_periode_1_old[0];	
				}
			$cbg8 = num($cbg8) + num($cbg8_old);	
			$cbg8_old = 0;				
?>         
      <tr>
           <th scope="row">Total Year Todate</th>
				<td align="right"><?php echo number_format(num($cbg1),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg2),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg3),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg5),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg6),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
				<td align="right"><?php echo number_format(num($cbg1) + num($cbg2) + num($cbg3) + num($cbg8) + num($cbg4) + num($cbg5) + num($cbg6) + num($cbg7),0,".",".") ?>
         </tr>         
       </tbody>
     </table>          	
            </div>
	  </div>       

	   </section>	   	           
<?php } ?>	    
   <!-- Main content -->

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
