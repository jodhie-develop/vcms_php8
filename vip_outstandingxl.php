<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
$nm_event = in_val('evn', 'get');
$kd_cbg = in_val('kd_cbg', 'get');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$nm_event.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');


if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
elseif ($kd_cbg ==''){$cabang = '--ALL--';}
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif  (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
elseif (num($kd_cbg) ==15){$cabang = 'CA';}
elseif (num($kd_cbg) ==16){$cabang = 'Tangerang';}
		$query_event = q_set($__p_query_event, "SELECT amount FROM ves_data.ca_event_fee v where nm_event = ? ", [(string) ($nm_event)]);
		$resource_event = db_query_soft($query_event, $__p_query_event ?? []);

		if(num(db_num_rows($resource_event)) > 0)
			{
			while ($row_event_fee  =  db_fetch($resource_event, PDO::FETCH_NUM))	
				{
				$amount_event_fee = $row_event_fee[0];

				}
			}
?>
<table width="100%" class="table table-bordered table-striped" id="example1">
  <thead>
    <tr>
      <td height="33" colspan="10" align=center >OUTSTANDING PAYMENT</td>
    </tr>
    <tr>
      <td height="36" colspan="10" align=center ><?php echo e($nm_event) ?></td>
    </tr>
    <tr>
      <td align=center >&nbsp;</td>
      <td align=right >&nbsp;</td>
      <td height="14" colspan="2" align=center >&nbsp;</td>
      <td align=center >&nbsp;</td>
      <td align=center >&nbsp;</td>
      <td align=center >&nbsp;</td>
      <td align=center >&nbsp;</td>
      <td align=center >&nbsp;</td>
      <td align=center >&nbsp;</td>
    </tr>
    <tr>
      <td width=3% align=center >No</td>
      <td width=13% align=center >ID Billing</td>
      <td width=10% height="30" align=center >Student Name</td>
      <td width="13%" align=center >Program</td>
      <td width="6%" align=center >Invoiced</td>
      <td width="10%" align=center >Paid</td>
      <td width="6%" align=center >Event Fee</td>
      <td width="6%" align=center >Outstanding</td>
      <td width="17%" align=center >SC Name</td>
      <td width="16%" align=center >Class Info</td>
    </tr>
  </thead>
  <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   /* echo $query_billing (debug SQL versi lama) dihapus */
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
  <tbody>
    <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, a.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.no desc" ;		
$query_billing = q_set($__p_query_billing, "SELECT a.kd_billing,b.nm_program, a.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.kd_program,a.kd_branch,a.sc,a.event_fee FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata and a.kd_branch = c.kd_branch where b.nm_program = 'CA'  and a.level_program = ? and a.dt_entry between ? and ?  group by a.kd_billing order by a.no desc", [(string) ($nm_event), (string) ($date_start), (string) ($date_end)]);	

$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
$st_refund = 0;
		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> ''", [(string) ($row_billing[0])]);
		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar = $row_bayar[0];	
				}
			}
		$query_refund = q_set($__p_query_refund, "SELECT v.amount, v.id_refund FROM ves_data.vip_billing_refund v where kd_billing = ? ", [(string) ($row_billing[0])]);
		$resource_refund = db_query_soft($query_refund, $__p_query_refund ?? []);
		$keluar_refund = db_num_rows($resource_refund);	
		if(num(db_num_rows($resource_refund)) > 0)
			{
			while ($row_refund  =  db_fetch($resource_refund, PDO::FETCH_NUM))	
				{
				$refund = $row_refund[0];
				$id_refund = $row_refund[1];
				$id_refund = ($id_refund);
				$st_refund = 1;
				}
			}		
		
		$kurang = num((num($row_billing[8])+num($row_billing[9])+num($row_billing[10]))) - num($mbayar);
if($amount_event_fee !=''){;$kurang = num($amount_event_fee) -num($mbayar);}
else
	($kurang = num($net_tf) - num($mbayar))
				?>
    <tr>
      <td align=center class="style24"><?php echo e($no_urut) ?></td>
      <td align=center class="style24"><?php echo e($row_billing[0]) ?></td>
      <td height="40" align=left class="style24"><?php echo e($row_billing[6]) ?><td align=center class="style24"><?php echo e($row_billing[1]) ?> <?php echo e($row_billing[2]) ?> - <?php echo e($row_billing[3]) ?></td>
      <td align=center class="style24"><?php echo  e($row_billing[4]) ?></td>
      <td align=center class="style24"><?php echo  e($mbayar) ?></td>
      <td align=center class="style24"><?php echo  e($amount_event_fee)  ?></td>
      <td align=center class="style24"><?php echo  e($kurang)  ?></td>
      <td align=left class="style24"><?php echo e($row_billing[14]) ?></td>
      <td align=center class="style24"><?php echo e($row_billing[11]) ?></td>
    </tr>    <?php $ttl_amount_event_fee = num($ttl_amount_event_fee) + num($amount_event_fee); $no_urut = num($no_urut) +1; $jml_kurang =  num($jml_kurang) + num($kurang); $st_refund = 0;$refund =0; $ttl_inv = num($ttl_inv)+num($row_billing[4]);$ttl_paid = num($ttl_paid) + num($mbayar);$ttl_outstanding = num($ttl_outstanding) + num($kurang);   }} ?>
    <tr>
      <td height="42" colspan="4" align=center class="style24">TOTAL</td>
      <td align=center class="style24"><?php echo  e($ttl_inv) ?></td>
      <td align=center class="style24"><?php echo  e($ttl_paid) ?></td>
      <td align=center class="style24"><?php echo  e($ttl_amount_event_fee)  ?></td>
      <td align=center class="style24"><?php echo  e($ttl_outstanding) ?></td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
    </tr>

  </tbody>
  <tfoot>
  </tfoot>
</table>
