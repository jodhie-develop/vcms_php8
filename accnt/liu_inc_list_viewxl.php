<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login();
$kd_cbg = in_val('kd_cbg', 'get');
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
$periode_claim = in_val('periode_claim', 'get');

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=liuincentive$periode_claim.xls");
include __DIR__ . "/../conndb.php";
?>
LIUMEDIA Incentive Detail View<br>
Period : <?php echo e($periode_claim) ?>
<table width="100%" class="table table-bordered table-striped" id="example1">
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
							if ($periode_claim =='2024-07' or $periode_claim =='2024-11'  or $periode_claim =='2025-01' or $periode_claim =='2025-03')
				{
							$query_amount_mkt = q_set($__p_query_amount_mkt, "SELECT branch,nm_stu, enroll_date, country_dest, school_dest,  rp_amount, mkt_team,a.id_prof_bill FROM ves_inc.tb_prof_bill a \r
\t\t\t\t\t\t\tleft join ves_data.vos_distribute_sf b on a.id_prof_bill = b.id_prof_bill and a.id_stu = b.kd_biodata\t\t\t\t\t\t\t\r
\t\t\t\t\t\t\tleft join tb_sales_report c on b.kd_biodata = c.kd_biodata\r
\t\t\t\t\t\t\t where date_format(tgl_cetak,'%Y-%m') = ? and  date_format(enroll_date,'%Y-%m') = ? and prioritas = 1 and status = 'OK'\r
\t\t\t\t\t\t\tand  (cabang = 'Bali'  or cabang = 'Bandung'  or cabang = 'North Jkt' or cabang = 'Central Jkt' or cabang = 'East Sby'\r
or cabang = 'Patal Jkt' or cabang = 'South Jkt'  or cabang = 'PIK'  or cabang = 'West Jkt' or cabang = 'West Sby' or cabang = 'Malang' or cabang = 'Malang TBI' or cabang = 'Medan') and p_np = 'P' and liu_count = 1 order by a.branch", [(string) ($periode_claim), (string) ($periode_claim)]);}else
							{
							$query_amount_mkt = q_set($__p_query_amount_mkt, "SELECT branch,nm_stu, enroll_date, country_dest, school_dest,  rp_amount, mkt_team,a.id_prof_bill FROM ves_inc.tb_prof_bill a \r
\t\t\t\t\t\t\tleft join ves_data.vos_distribute_sf b on a.id_prof_bill = b.id_prof_bill and a.id_stu = b.kd_biodata\t\t\t\t\t\t\t\r
\t\t\t\t\t\t\tleft join tb_sales_report c on b.kd_biodata = c.kd_biodata\r
\t\t\t\t\t\t\t where date_format(tgl_cetak,'%Y-%m') = ? and  date_format(enroll_date,'%Y-%m') = ? and prioritas = 1 and status = 'OK'\r
\t\t\t\t\t\t\tand  (cabang = 'Bali'  or cabang = 'Bandung' or cabang = 'Central Jkt' or cabang = 'East Sby'\r
or cabang = 'Patal Jkt' or cabang = 'PIK'  or cabang = 'West Jkt' or cabang = 'West Sby' or cabang = 'Malang' or cabang = 'Malang TBI' or cabang = 'Medan') and p_np = 'P'  order by a.branch", [(string) ($periode_claim), (string) ($periode_claim)]);}
														
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
                  <td><?php echo e($branch) ; ?><input type="hidden" name="nama_cabang" id="nama_cabang" value="<?php echo e($nama_cabang) ?>"><input type="hidden" name="periode_claim" id="periode_claim" value="<?php echo e($periode_claim) ?>"></td>
                  <td><?php echo e($nm_stu) ; ?></td>
                  <td><?php echo e($r_amount_mkt[7]); ; ?></td>
                  <td  style="text-align: left"><?php echo e($school_dest)  ?> <?php echo e($country_dest) ?></td>
                  <td style="text-align: right"><?php echo e($rp_amount) ?></td>
                  <td style="text-align: right"><?php echo e($mkt_team) ?></td>

                  </tr>
                <?php $no_urut = num($no_urut)+1;$i = num($i)+1; $tot_pax = num($tot_pax) + num($jml_hitung_pax);$tot_amount_sf = num($tot_amount_sf)+num($jml_amount_sf); $tot_amount_mkt = num($tot_amount_mkt)+num($jml_amount_mkt); $jml_hitung_pax=0; }} $tot_pax = num($no_urut) - 1; ?>
            
                </tbody>
                <tfoot>
                </tfoot>
</table>
<br>
<table id="example2" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th width="33%">&nbsp;</th>
      <th width="17%">PAX</th>
      <th width="23%">SERVICE FEE</th>
      <th width="13%">MKT INCENTIVE</th>
      <th width="14%">ACTION</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>TOTAL</strong></td>
      <td><?php echo e($tot_pax) ?></td>
      <td><?php echo number_format(num($tot_rp_amount),0,".",".") ?></td>
      <td><?php echo number_format(num($tot_mkt_team),0,".",".") ;
?></td>
      <td></td>
    </tr>
  </tbody>
  <tfoot>
  </tfoot>
</table>
