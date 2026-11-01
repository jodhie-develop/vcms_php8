<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
$kd_cbg = in_val('kd_cbg', 'get');
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');

include __DIR__ . "/conndb.php";
?>
<p>SUMMARY PAYMENT</p>
<table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=4% height="14" align=left >No</td>
	            <td width=16% align=center >SC Name</td>
	            <td width=11% align=center >Branch</td>
	            <td width=11% align=center >ttl</td>
	            <td width=11% align=center >enroll_date</td>
	            <td width=11% align=center >nm_student</td>
              </tr>
  </thead>
	        <tbody>
	          <?php	
$query_sc = q_set($__p_query_sc, "SELECT pic,cabang,kd_cabang from tb_sales_report where pic <>''And kd_cabang between 1 and 14 and status = 'OK' and prioritas = 1 and enroll_date between '2010-01-01' and '2024-04-30' and kd_cabang between 1 and 14  and (cabang = 'East Sby'  or cabang = 'West Sby'  or cabang = 'Bali' or cabang = 'Patal Jkt'  or cabang = 'Central Jkt'  or cabang = 'North Jkt'  or cabang = 'West Jkt'  or cabang = 'Bandung'  or cabang = 'Bandung TBI'  or cabang = 'PIK'  or cabang = 'Serpong') group by pic,cabang  order by kd_cabang, pic, enroll_date");
$no_urut = 1;		
$resource_sc = db_query_soft($query_sc, $__p_query_sc ?? []);
	while ($row_sc  =  db_fetch($resource_sc, PDO::FETCH_NUM))
		{
		$nm_sc = $row_sc[0];
		$cbg = $row_sc[1];
		$kd_cabang = $row_sc[2];	

		$query_sales = q_set($__p_query_sales, "SELECT enroll_date, nama from tb_sales_report where pic = ? and  cabang = ? and status = 'OK' and prioritas = 1 and enroll_date between '2010-01-01' and '2024-04-30' group by kd_biodata, enroll_date order by enroll_date", [(string) ($nm_sc), (string) ($cbg)]);
		$resource_sl = db_query_soft($query_sales, $__p_query_sales ?? []);
			while ($row_sl  =  db_fetch($resource_sl, PDO::FETCH_NUM))
				{ ?>
	          <tr>
	            <td height="14" align=left class="style24"><?php echo e($no_urut) ?></td>
	            <td align=left class="style24"><?php echo e($nm_sc) ?></td>
	            <td align=left class="style24"><?php echo  e($cbg)   ?></td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24"><?php echo  e($row_sl[0])   ?></td>
	            <td align=left class="style24"><?php echo  e($row_sl[1])   ?></td>
              </tr>
	          <?php $no_urut = num($no_urut) +1; }} ?>
  </tbody>
	        <tfoot>
					          <tr>
	            <td align=right class="style24"><strong>Total</strong></td>
	            <td align=right class="style24">&nbsp;</td>
	            <td height="14" align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_1)),0,".",".")  ?></strong></td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_2)),0,".",".")  ?></strong></td>
	            <td align=left class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_3)),0,".",".")  ?></strong></td>
	            </tr>
					          <tr>
					            <td align=right class="style24">&nbsp;</td>
					            <td align=right class="style24">&nbsp;</td>
					            <td height="14" align=center class="style24"><strong><?php echo  number_format(num(($grand_ttl)),0,".",".")  ?></strong></td>
					            <td align=center class="style24">&nbsp;</td>
					            <td height="14" align=center class="style24">&nbsp;</td>
					            <td height="14" align=center class="style24">&nbsp;</td>
              </tr>
  </tfoot>
</table>
