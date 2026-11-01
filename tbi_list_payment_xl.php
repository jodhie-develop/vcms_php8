<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
$periode_claim = in_val('periode_claim', 'get');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=tbi_invoice_$date_start-$date_end.xls");
include __DIR__ . "/conndb.php";
?>
LIUMEDIA Incentive Detail View<br>
Period : <?php echo e($periode_claim) ?>
<table width="100%" class="table table-bordered table-striped" id="example2">
  <jdl>
    <thead class="thead-dark">
      <tr>
        <th width="5%" rowspan="2" style="text-align: center">No</th>
        <th width="8%" rowspan="2">Center</th>
        <th width="19%" rowspan="2">Student Name</th>
        <th width="19%" rowspan="2">ID Receipt</th>
        <th style="text-align: center">&nbsp;</th>
        <th width="10%" rowspan="2" style="text-align: center">Service Fee</th>
        <th width="10%" rowspan="2" style="text-align: center">Liu Incentive</th>
      </tr>
      <tr>
        <th width="48%" style="text-align: center">Destination</th>
      </tr>
    </thead>
  </jdl>
  <tbody>
    <?php 
	$no_urut = 1;$i = 1;

							$query_amount_mkt = q_set($__p_query_amount_mkt, "SELECT branch,nm_stu, enroll_date, country_dest, school_dest,  rp_amount, mkt_team,a.id_prof_bill FROM ves_inc.tb_prof_bill a \r
\t\t\t\t\t\t\tleft join ves_data.vos_distribute_sf b on a.id_prof_bill = b.id_prof_bill and a.id_stu = b.kd_biodata\t\t\t\t\t\t\t\r
\t\t\t\t\t\t\tleft join tb_sales_report c on b.kd_biodata = c.kd_biodata\r
\t\t\t\t\t\t\t where date_format(tgl_cetak,'%Y-%m') = ? and  date_format(enroll_date,'%Y-%m') = ? and prioritas = 1 and status = 'OK'\r
\t\t\t\t\t\t\tand  (cabang = 'Bali'  or cabang = 'Bandung' or cabang = 'Central Jkt' or cabang = 'East Sby'\r
or cabang = 'Patal Jkt' or cabang = 'PIK'  or cabang = 'West Jkt' or cabang = 'West Sby') and p_np = 'P' order by a.branch", [(string) ($periode_claim), (string) ($periode_claim)]);
														
							$result_amount_mkt=db_query_or_die("Wah error nih11", $query_amount_mkt, $__p_query_amount_mkt ?? []);
							if ($result_amount_mkt) 
								{ 
								while ($r_amount_mkt = db_fetch($result_amount_mkt))
									{
									$branch = $r_amount_mkt[0]; 
									$nm_stu = $r_amount_mkt[1];
									$enroll_date = $r_amount_mkt[2];
									$country_dest = $r_amount_mkt[3];
									$school_dest = $r_amount_mkt[4];
									$rp_amount = $r_amount_mkt[5];$tot_rp_amount = num($tot_rp_amount)+ num($rp_amount);
									$mkt_team = $r_amount_mkt[6];$tot_mkt_team = num($tot_mkt_team) + num($mkt_team);

				?>
    <tr style="height: 100%">
      <td style="height: 200%"><?php echo e($no_urut) ; ?></td>
      <td><?php echo e($branch) ; ?>
        <input type="hidden" name="nama_cabang" id="nama_cabang" value="<?php echo e($nama_cabang) ?>">
        <input type="hidden" name="periode_claim" id="periode_claim" value="<?php echo e($periode_claim) ?>"></td>
      <td><?php echo e($nm_stu) ; ?></td>
      <td><?php echo e($r_amount_mkt[7]); ; ?></td>
      <td  style="text-align: left"><?php echo e($school_dest)  ?> <?php echo e($country_dest) ?></td>
      <td style="text-align: right"><?php echo number_format(num($rp_amount),0,".",".") ?></td>
      <td style="text-align: right"><?php echo number_format(num($mkt_team),0,".",".") ?></td>
    </tr>
    <?php $no_urut = num($no_urut)+1;$i = num($i)+1; $tot_pax = num($tot_pax) + num($jml_hitung_pax);$tot_amount_sf = num($tot_amount_sf)+num($jml_amount_sf); $tot_amount_mkt = num($tot_amount_mkt)+num($jml_amount_mkt); $jml_hitung_pax=0; }} $tot_pax = num($no_urut) - 1; ?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<p>SUMMARY PAYMENT</p>
<table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=4% height="14" align=left >No</td>
	            <td width=16% align=center >Payment For</td>
	            <td width=11% align=center >East Sby</td>
	            <td width=11% align=center >West Sby</td>
	            <td width=11% align=center >Denpasar</td>
	            <td width="10%" align=center >Malang</td>
	            <td width="10%" align=center >PIM</td>
	            <td width="10%" align=center >MOI</td>
	            <td width="13%" align=center >West Jkt</td>
	            <td width="13%" align=center >SOHO</td>
	            <td width="13%" align=center >PIK</td>
	            <td width="13%" align=center >Bandung</td>
              </tr>
  </thead>
	        <tbody>
	          <?php	
if (num($kd_cbg) != 100)
{
$query_billing = q_set($__p_query_billing, "SELECT t.keterangan,\r
sum(case when t.kd_branch = 1 then a.nominal end) as east_sby1,\r
sum(case when t.kd_branch = 2 then a.nominal end) as east_sby2 ,\r
sum(case when t.kd_branch = 3 then a.nominal end) as east_sby3 ,\r
sum(case when t.kd_branch = 4 then a.nominal end) as east_sby4 ,\r
sum(case when t.kd_branch = 5 then a.nominal end) as east_sby5 ,\r
sum(case when t.kd_branch = 6 then a.nominal end) as east_sby6 ,\r
sum(case when t.kd_branch = 7 then a.nominal end) as east_sby7 ,\r
sum(case when t.kd_branch = 8 then a.nominal end) as east_sby8,\r
sum(case when t.kd_branch = 11 then a.nominal end) as east_sby11 ,\r
sum(case when t.kd_branch = 12 then a.nominal end) as east_sby12\r
 FROM ves_data.tb_invoice t\r
left join tb_invoice_paid a on t.id_billing = a.id_billing\r
where (t.keterangan like 'TBI%' or t.keterangan = 'Coaching Session' or t.keterangan = '60 Menit Consult Additional' or t.keterangan = '30 Menit Consult Additional' ) and t.kd_branch between 1 and 12 and a.dt_payment between ? and ?\r
group by t.keterangan", [(string) ($date_start), (string) ($date_end)]);
}
else
{
$query_billing = q_set($__p_query_billing, "SELECT t.keterangan,\r
sum(case when t.kd_branch = 1 then a.nominal end) as east_sby1,\r
sum(case when t.kd_branch = 2 then a.nominal end) as east_sby2 ,\r
sum(case when t.kd_branch = 3 then a.nominal end) as east_sby3 ,\r
sum(case when t.kd_branch = 4 then a.nominal end) as east_sby4 ,\r
sum(case when t.kd_branch = 5 then a.nominal end) as east_sby5 ,\r
sum(case when t.kd_branch = 6 then a.nominal end) as east_sby6 ,\r
sum(case when t.kd_branch = 7 then a.nominal end) as east_sby7 ,\r
sum(case when t.kd_branch = 8 then a.nominal end) as east_sby8,\r
sum(case when t.kd_branch = 11 then a.nominal end) as east_sby11 ,\r
sum(case when t.kd_branch = 12 then a.nominal end) as east_sby12\r
 FROM ves_data.tb_invoice t\r
left join tb_invoice_paid a on t.id_billing = a.id_billing\r
where (t.keterangan like 'TBI%' or t.keterangan = 'Coaching Session'  or t.keterangan like '%Test Bakat%' or t.keterangan = '60 Menit Consult Additional' or t.keterangan = '30 Menit Consult Additional' ) and t.kd_branch between 1 and 12 and a.dt_payment  between ? and ?\r
group by t.keterangan", [(string) ($date_start), (string) ($date_end)]);
}

$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$ttl_row_billing_1 = num($ttl_row_billing_1) + num($row_billing[1]);
		$ttl_row_billing_2 = num($ttl_row_billing_2) + num($row_billing[2]);$west_sby_rp = $row_billing[2];
		$ttl_row_billing_3 = num($ttl_row_billing_3) + num($row_billing[3]);
		$ttl_row_billing_4 = num($ttl_row_billing_4) + num($row_billing[4]);
		$ttl_row_billing_5 = num($ttl_row_billing_5) + num($row_billing[5]);
		$ttl_row_billing_6 = num($ttl_row_billing_6) + num($row_billing[6]);
		$ttl_row_billing_7 = num($ttl_row_billing_7) + num($row_billing[7]);
		$ttl_row_billing_8 = num($ttl_row_billing_8) + num($row_billing[8]);
		$ttl_row_billing_11 = num($ttl_row_billing_11) + num($row_billing[9]);
		$ttl_row_billing_12 = num($ttl_row_billing_12) + num($row_billing[10]);
		$grand_ttl = num($ttl_row_billing_1) + num($ttl_row_billing_2) + num($ttl_row_billing_3) + num($ttl_row_billing_4) + num($ttl_row_billing_5) + num($ttl_row_billing_6) + num($ttl_row_billing_7) + num($ttl_row_billing_8)  + num($ttl_row_billing_11)  + num($ttl_row_billing_12);
	
	?>
	          <tr>
	            <td height="14" align=left class="style24"><?php echo e($no_urut) ?></td>
	            <td align=left class="style24"><?php echo e($row_billing[0]) ?></td>
	            <td align=left class="style24"><?php echo  number_format(num($row_billing[1]),0,',','.');   ?></td>
	            <td align=left class="style24"><?php echo  e($west_sby_rp)  ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[3])),0,".",".")  ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[8])),0,".",".")  ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[4])),0,".",".")  ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[5])),0,".",".")  ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[6])),0,".",".")  ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[11])),0,".",".")  ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[12])),0,".",".")  ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[7])),0,".",".")  ?></td>
              </tr>

	          <?php $no_urut = num($no_urut) +1; }} ?>
  </tbody>
	        <tfoot>
					          <tr>
	            <td colspan="2" rowspan="2" align=right class="style24"><strong>Total</strong></td>
	            <td height="14" align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_1)),0,".",".")  ?></strong></td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_2)),0,".",".")  ?></strong></td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_3)),0,".",".")  ?></strong></td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_8)),0,".",".")  ?></strong></td>								  
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_4)),0,".",".")  ?></strong></td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_5)),0,".",".")  ?></strong></td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_6)),0,".",".")  ?></strong></td>


	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_11)),0,".",".")  ?></strong></td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_12)),0,".",".")  ?></strong></td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_7)),0,".",".")  ?></strong></td>								  
	                          </tr>
					          <tr>
					            <td height="14" colspan="10" align=center class="style24"><strong><?php echo  number_format(num(($grand_ttl)),0,".",".")  ?></strong></td>
              </tr>
  </tfoot>
</table>
