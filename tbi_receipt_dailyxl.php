<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();  $dt_awal = in_val('dt_awal', 'get');; ?>
<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=tbireceiptby$dt_awal.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
//include __DIR__ . "/atas.php";
//include __DIR__ . "/left.php";
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";


if ($dt_awal ==''){$dt_awal = $hari_ini;$dt_akhir = $hari_ini;}
$sales_year = '26';
$kd_cbg = in_val('kd_cbg', 'get');



$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;


$thn = substr($dt_awal,0,4);
$thn_lalu = num($thn) - 1;
$bln = substr($dt_awal,5,2);
$awal_bln = "$bln-01";
$awal_thn = "$thn-01-01";
$awal_thn_lalu = "$thn_lalu-01-01";
$awak_bln_lalu = "$thn_lalu-$bln-01";
$dt_lalu = substr($dt_awal,4,7);
$dt_lalu ="$thn_lalu$dt_lalu";

?>
<table width="80%" class="table table-hover" >
  <jdl>
    <thead>
      <tr style="font-size: 1em">
        <th width="4%">No</th>
        <th width="19%">Center</th>
        <th colspan="2" style="text-align: center">Today</th>
        <th colspan="2" style="text-align: center">Today <br>
          Last Year</th>
        <th colspan="2" style="text-align: center">Diff</th>
        <th colspan="2" style="text-align: center">This <br>
          Month</th>
        <th colspan="2" style="text-align: center">This Month <br>
          Last Year</th>
        <th colspan="2" style="text-align: center">Diff</th>
        <th colspan="2" style="text-align: center">This Year</th>
        <th colspan="2" style="text-align: center">Last Year</th>
        <th colspan="2" style="text-align: center">Diff</th>
      </tr>
      <tr style="font-size: 1em">
        <th width="4%">No</th>
        <th width="19%">Center</th>
        <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
        <th width="10%">Amount</th>
        <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
        <th width="10%">Amount</th>
        <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
        <th width="10%">Amount</th>
        <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
        <th>Amount</th>
        <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
        <th bgcolor="#FFFFFF">Amount</th>
        <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
        <th>Amount</th>
        <th width="6%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
        <th width="10%">Amount</th>
        <th width="6%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
        <th width="10%">Amount</th>
        <th width="6%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
        <th width="10%">Amount</th>
      </tr>
    </thead>
  </jdl>
  <?php $no_urut = 1;
					$query_cabang = q_set($__p_query_cabang, "SELECT kd_branch FROM tb_invoice_paid where (keterangan like 'TBI%' or keterangan like '%Test Bakat%' or keterangan like '%Kolaborasi%' ) and dt_payment between ? and ?  group by kd_branch order by kd_branch", [(string) ($awal_thn_lalu), (string) ($dt_awal)]);

					$result_cabang=db_query_or_die("Wah error nih11", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$kd_branch = $r_cbg[0]; 

if ($kd_branch == '1'){$nama_cabang = 'East Sby';}
elseif ($kd_branch == '2'){$nama_cabang = 'West Sby';}
elseif ($kd_branch == '3'){$nama_cabang = 'Denpasar';}
elseif ($kd_branch == '4'){$nama_cabang = 'South Jkt';}
elseif ($kd_branch == '5'){$nama_cabang = 'North Jkt';}
elseif ($kd_branch == '6'){$nama_cabang = 'West Jkt';}
elseif ($kd_branch == '7'){$nama_cabang = 'Bandung';}
elseif ($kd_branch == '8'){$nama_cabang = 'Malang TBI';}
elseif ($kd_branch == '9'){$nama_cabang = 'Bandung TBI';}
elseif ($kd_branch == '00'){$nama_cabang = 'HO';}
elseif ($kd_branch == '11'){$nama_cabang = 'PIK';}
elseif ($kd_branch == '14'){$nama_cabang = 'Medan';}								
				  ?>
  <tbody>
    <tr bgcolor="#FFFD07">
      <td height="20"><strong><?php echo e($no_urut) ; ?></strong></td>
      <td><strong><?php echo e($nama_cabang) ; ?></strong></td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: right" >&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: right" >&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: right" >&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: right">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: right">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: right">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: right">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: right">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: right">&nbsp;</td>
    </tr>
    <?php
$query_per_cabang = q_set($__p_query_per_cabang, "SELECT keterangan,\r
count(case when dt_payment  = ? then 1 end ) as now_p,\r
sum(case when dt_payment  = ? then nominal end ) as now_m,\r
count(case when dt_payment  = ? then 1 end ) as now_p_last,\r
sum(case when dt_payment  = ? then nominal end ) as now_m_last,\r
\r
count(case when dt_payment  between ? and  ? then 1 end ) as month_p,\r
sum(case when dt_payment  between ? and  ? then nominal end ) as month_m,\r
count(case when dt_payment  between ? and ? then 1 end ) as month_p_last,\r
sum(case when dt_payment  between ? and ? then nominal end ) as month_m_last,\r
\r
count(case when dt_payment  between ? and  ? then 1 end ) as year_p,\r
sum(case when dt_payment  between ? and  ? then nominal end ) as year_m,\r
count(case when dt_payment  between ? and ? then 1 end ) as year_p_last,\r
sum(case when dt_payment  between ? and ? then nominal end ) as year_m_last\r
\r
FROM tb_invoice_paid where (keterangan like 'TBI%' or keterangan like '%Test Bakat%' or keterangan like '%Kolaborasi%' )\r
and dt_payment between ? and  ? and kd_branch = ? group by keterangan", [(string) ($dt_awal), (string) ($dt_awal), (string) ($dt_lalu), (string) ($dt_lalu), (string) ($thn) . "-" . (string) ($bln) . "-01", (string) ($dt_awal), (string) ($thn) . "-" . (string) ($bln) . "-01", (string) ($dt_awal), (string) ($thn_lalu) . "-" . (string) ($bln) . "-01", (string) ($dt_lalu), (string) ($thn_lalu) . "-" . (string) ($bln) . "-01", (string) ($dt_lalu), (string) ($thn) . "-01-01", (string) ($dt_awal), (string) ($thn) . "-01-01", (string) ($dt_awal), (string) ($thn_lalu) . "-01-01", (string) ($dt_lalu), (string) ($thn_lalu) . "-01-01", (string) ($dt_lalu), (string) ($thn_lalu) . "=01-01", (string) ($dt_awal), (string) ($kd_branch)]);
		
$result_per_cabang=db_query_or_die("Wah error nih211", $query_per_cabang, $__p_query_per_cabang ?? []);
if ($result_per_cabang) 
	{ 
	while ($r_p_cbg = db_fetch($result_per_cabang))
		{
		$keterangan = $r_p_cbg[0];
$now_p =$r_p_cbg[1];$tot_now_p = num($tot_now_p) + num($now_p);
$now_m =$r_p_cbg[2];$tot_now_m = num($tot_now_m) + num($now_m);
$now_p_last =$r_p_cbg[3];$tot_now_p_last = num($tot_now_p_last) + num($now_p_last);
$now_m_last =$r_p_cbg[4];$tot_now_m_last = num($tot_now_m_last) + num($now_m_last);
$diff_now_p = num($now_p) - num($now_p_last); $tot_diff_now_p = num($tot_diff_now_p) + num($diff_now_p);
$diff_now_m = num($now_m) - num($now_m_last); $tot_diff_now_p = num($tot_diff_now_p) + num($diff_now_p);
		
$month_p =$r_p_cbg[5];$tot_month_p = num($tot_month_p) + num($month_p);
$month_m =$r_p_cbg[6];$tot_month_m = num($tot_month_m) + num($month_m);
$month_p_last =$r_p_cbg[7];
$month_m_last =$r_p_cbg[8];
$diff_month_p = num($month_p) - num($month_p_last);$tot_diff_month_p = num($tot_diff_month_p) + num($diff_month_p);
$diff_month_m = num($month_m) - num($month_m_last);$tot_diff_month_m = num($tot_diff_month_m) + num($diff_month_m);
	

$year_p =$r_p_cbg[9];
$year_m =$r_p_cbg[10];
$year_p_last =$r_p_cbg[11];
$year_m_last =$r_p_cbg[12];
$diff_year_p = num($year_p) - num($year_p_last);
$diff_year_m = num($year_m) - num($year_m_last);

$tot_month_p_last = num($tot_month_p_last) + num($month_p_last);
$tot_month_m_last = num($tot_month_m_last) + num($month_m_last);

$tot_year_p = num($tot_year_p) + num($year_p);
$tot_year_m = num($tot_year_m) + num($year_m);
$tot_year_p_last = num($tot_year_p_last) + num($year_p_last);
$tot_year_m_last = num($tot_year_m_last) + num($year_m_last);
$tot_diff_year_p = num($tot_year_p) - num($tot_year_p_last);
$tot_diff_year_m = num($tot_year_m) + num($tot_year_m_last);
?>
    <tr>
      <td height="20">&nbsp;</td>
      <td><?php echo e($keterangan) ; ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($now_p) ?></td>
      <td style="text-align: right" ><?php echo e($now_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($now_p_last) ?></td>
      <td style="text-align: right" ><?php echo e($now_m_last) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($diff_now_p) ?></td>
      <td style="text-align: right" ><?php echo e($diff_now_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($month_p) ?></td>
      <td style="text-align: right" ><?php echo e($month_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($month_p_last) ?></td>
      <td style="text-align: right" ><?php echo e($month_m_last) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($diff_month_p) ?></td>
      <td style="text-align: right" ><?php echo e($diff_month_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($year_p) ?></td>
      <td style="text-align: right" ><?php echo e($year_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($year_p_last) ?></td>
      <td style="text-align: right" ><?php echo e($year_m_last) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($diff_year_p) ?></td>
      <td style="text-align: right" ><?php echo e($diff_year_m) ?></td>
    </tr>
    <?php } } ?>
    <?php $no_urut = num($no_urut)+1;  } } ?>
    <tr>
      <td height="20" colspan="2"><strong>TOTAL</strong></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_now_p) ?></td>
      <td style="text-align: right" ><?php echo e($tot_now_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_now_p_last) ?></td>
      <td style="text-align: right" ><?php echo e($tot_now_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_diff_now_p) ?></td>
      <td style="text-align: right" ><?php echo e($tot_diff_now_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_month_p) ?></td>
      <td style="text-align: right" ><?php echo e($tot_month_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_month_p_last) ?></td>
      <td style="text-align: right" ><?php echo e($tot_month_m_last) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_diff_month_p) ?></td>
      <td style="text-align: right" ><?php echo e($tot_diff_month_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_year_p) ?></td>
      <td style="text-align: right" ><?php echo e($tot_year_m) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_year_p_last) ?></td>
      <td style="text-align: right" ><?php echo e($tot_year_m_last) ?></td>
      <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_diff_year_p) ?></td>
      <td style="text-align: right" ><?php echo e($tot_diff_year_m) ?></td>
    </tr>
  </tbody>
  <tfoot>
  </tfoot>
</table>
