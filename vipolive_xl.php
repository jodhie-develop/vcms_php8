<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
$kd_cbg = in_val('kd_cbg', 'get');
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=tbi_invoice_$date_start-$date_end.xls");
include __DIR__ . "/conndb.php";
?>
	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td height="14" colspan="8" align=center >TBI PAYMENT LIST</td>
              </tr>
	          <tr>
	            <td height="14" colspan="8" align=right >Period : <?php echo e($date_start) ?> to <?php echo e($date_end) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left >&nbsp;</td>
	            <td align=left >&nbsp;</td>
	            <td align=left >&nbsp;</td>
	            <td align=left >&nbsp;</td>
	            <td align=left >&nbsp;</td>
	            <td align=left >&nbsp;</td>
	            <td align=left >&nbsp;</td>
	            <td align=left >&nbsp;</td>
              </tr>
	          <tr>
	            <td width=4% height="14" align=center >No</td>
	            <td width=16% align=center >ID Billing</td>
	            <td width=11% align=center >Payment Date</td>
	            <td width=11% align=center >ID Receipt</td>
	            <td width=11% align=center >Student Name</td>
	            <td width="10%" align=center >SC</td>
	            <td width="10%" align=center >Payment Form</td>
	            <td width="13%" align=center >Amount</td>
              </tr>
            </thead>
	        <tbody>
          <?php	
if (num($kd_cbg) != 100)
{
$query_billing = q_set($__p_query_billing, "SELECT t.id_billing,t.kd_biodata, t.nama_lengkap, t.kd_branch, t.keterangan,a.nominal, t.dt_entry, t.pic, t.id_invoice, t.jns_invoice, t.pay_mtd, t.remark, t.nominal_discount, t.nominal_nama_discount, t.reg_discount, t.reg_nama_discount, t.reg_amount, t.admin_discount, t.admin_nama_discount, t.admin_amount, a.id_invoice,a.id,additional_fee,date_format(a.dt_payment,'%Y-%m-%d')  FROM ves_data.tb_invoice t left join tb_invoice_paid a on t.id_billing = a.id_billing where t.kd_branch = ? and t.keterangan like 'TBI%' and a.dt_payment between ? and ?  group by a.id_invoice order by a.dt_payment,a.id_invoice", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);
}
else
{
$query_billing = q_set($__p_query_billing, "SELECT t.id_billing,t.kd_biodata, t.nama_lengkap, t.kd_branch, t.keterangan, a.nominal, t.dt_entry, t.pic, t.id_invoice, t.jns_invoice, t.pay_mtd, t.remark, t.nominal_discount, t.nominal_nama_discount, t.reg_discount, t.reg_nama_discount, t.reg_amount, t.admin_discount, t.admin_nama_discount, t.admin_amount, a.id_invoice,a.id,additional_fee,date_format(a.dt_payment,'%Y-%m-%d')  FROM ves_data.tb_invoice t left join tb_invoice_paid a on t.id_billing = a.id_billing where  t.keterangan like 'TBI%' and   t.kd_branch between 1 and 12   and a.dt_payment between ? and ?  group by a.id_invoice order by a.dt_payment,a.id_invoice", [(string) ($date_start), (string) ($date_end)]);
}

$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$total_amount = num($total_amount) + num($row_billing[5]);
	?>
	          <tr>
	            <td height="14" align=left class="style24"><?php echo e($no_urut) ?></td>
	            <td align=left class="style24">
  	            <?php echo e($row_billing[0]) ?></td>
	            <td align=left class="style24"><?php echo e($row_billing[23]) ?></td>
	            <td align=left class="style24"><?php echo e($row_billing[20]) ?></td>
	            <td align=left class="style24"><?php echo e($row_billing[2]) ?></td>
	            <td align=left class="style24"><?php echo e($row_billing[7]) ?></td>
	            <td align=left class="style24"><?php echo e($row_billing[4]) ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[5])),0,".",".")  ?></td>
              </tr>
              <?php $no_urut = num($no_urut) +1; }} ?>				

            <tfoot>
					          <tr>
	            <td height="14" colspan="7" align=center class="style24"><strong>TOTAL</strong></td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($total_amount)),0,".",".")  ?></strong></td>
	            </tr>

				    </tbody>
            </tfoot>
          </table><p>SUMMARY PAYMENT</p>
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
where t.keterangan like 'TBI%' and t.kd_branch between 1 and 12 and a.dt_payment between ? and ?\r
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
where t.keterangan like 'TBI%' and t.kd_branch between 1 and 12 and a.dt_payment  between ? and ?\r
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
		$ttl_row_billing_2 = num($ttl_row_billing_2) + num($row_billing[2]);
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
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[1])),0,".",".")  ?></td>
	            <td align=left class="style24"><?php echo  number_format(num(($row_billing[2])),0,".",".")  ?></td>
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
