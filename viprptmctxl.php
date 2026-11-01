<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=viprptmc.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
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
$kd_staff = $_SESSION['kd_staff'] ;?>
<table width="57%"  class="table table-bordered table-striped" id="example2">
  <tbody>
    <tr>
      <th colspan="12" scope="row"><strong>VIP </strong>Summary Income by Material Cost<br>
      Period : <?php echo e($awal_bln) ?> to <?php echo e($akhir_bln) ?></th>
    </tr>
    <tr>
      <th width="13%" scope="row">Week</th>
      <td width="4%">East Sby</td>
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
function jml_minggumc($awal_bln, $akhir_bln){
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
\t\t\tfrom ves_data.vip_billing_payment where jns_payment like 'Material%' and dt_payment between ? and ? ", [(string) ($mulai_minggu_1), (string) ($selesai_minggu_1)]);

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
      <th scope="row"><?php echo e($nm_week) ?>        (<?php echo date('d M',strtotime($mulai_minggu_1)) ?> - <?php echo date('d M',strtotime($selesai_minggu_1)) ?> )</th>
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
\t\t\tfrom ves_data.vip_billing_payment where jns_payment like 'Material%' and dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);
		
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
      <th scope="row"><?php echo e($nm_week) ?>        (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
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
\t\t\tfrom ves_data.vip_billing_payment where  jns_payment like 'Material%' and dt_payment between ? and ? ", [(string) ($mulai_minggu), (string) ($selesai_minggu)]);

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
      <th scope="row"><?php echo e($nm_week) ?>        (<?php echo date('d M',strtotime($mulai_minggu)) ?> - <?php echo date('d M',strtotime($selesai_minggu)) ?> )</th>
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
\t\t\tfrom ves_data.vip_billing_payment where  jns_payment like 'Material%' and dt_payment between ? and ? ", [(string) ($mulai_minggu_terakhir), (string) ($lastDateOfMonth)]);

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
      <th scope="row"><?php echo e($nm_week) ?>        (<?php echo date('d M',strtotime($mulai_minggu_terakhir)) ?> - <?php echo date('d M',strtotime($lastDateOfMonth)) ?> )</th>
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

echo e(jml_minggumc($awal_bln, $akhir_bln));
?>
    <?php 
			$query_periode_monthly = q_set($__p_query_periode_monthly, "SELECT SUM(CASE WHEN kd_branch= '1' THEN amount END) AS east,SUM(CASE WHEN kd_branch= '2' THEN amount END) AS west,\r
\t\t\tSUM(CASE WHEN kd_branch= '3' THEN amount END) AS '3',SUM(CASE WHEN kd_branch= '4' THEN amount END) AS '4',\r
\t\t\tSUM(CASE WHEN kd_branch= '5' THEN amount END) AS '5',SUM(CASE WHEN kd_branch= '6' THEN amount END) AS '6',\r
\t\t\tSUM(CASE WHEN kd_branch= '7' THEN amount END) AS '7',SUM(CASE WHEN kd_branch= '8' THEN amount END) AS '8'\r
\t\t\tfrom ves_data.vip_billing_payment where  jns_payment like 'Material%' and dt_payment like ? ", [(string) ($tgl_dipilih) . "%"]);
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
\t\t\tfrom ves_data.vip_billing_payment where  jns_payment like 'Material%' and dt_payment between '2019-01-01' and ? ", [(string) ($akhir_bln)]);
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
