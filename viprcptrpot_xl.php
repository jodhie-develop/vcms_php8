<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun$bulan$hari";
$kd_cbg=in_val('kd_cbg', 'get');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=viprcptrpt2324_$kd_cbg$hari_ini.xls");
include __DIR__ . "/conndb.php";
if (num($kd_cbg) ==100){$cabang = 'National';}
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}
?>
<?php 

$no_urut = 1;
?>
     <h1>VIP Income Summary Comparison 2023 / 2024<br>
       Center : <?php echo e($cabang) ?> 
       <br>
     </h1>
<table width="100%" class="table table-bordered table-striped" id="example1">
				  <jdl>
                <thead class="thead-dark">
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="6" style="text-align: center";>2023</th>
                  <th colspan="6" style="text-align: center">2024</th>
                  <th colspan="6" style="text-align: center">Selisih</th>
                  </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  </tr>
                <tr>
                  <th width="3%">No</th>
                  <th width="15%">Month</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  </tr>
                </thead>
				  </jdl>					  
                <tbody>

				  <?php 
	if($kd_cbg ==''){die;}
					$query_cabang = q_set($__p_query_cabang, "select date_format(dt_cetak, '%m'),date_format(dt_cetak, '%b') from vip_billing_payment where kd_branch = ? and  (date_format(dt_cetak, '%Y') = '2023' or date_format(dt_cetak, '%Y') = '2024') group by date_format(dt_cetak, '%m') order by dt_cetak ", [(string) ($kd_cbg)]); 
					$result_cabang=db_query_or_die("Wah error nih11", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$nm_bln = $r_cbg[0];
							$nm_bln_tampil = $r_cbg[1];
							
							$query_hitung = q_set($__p_query_hitung, "select a.kd_branch,\r
count(case when jns_payment = 'Registration' and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'  then 1 end  ) as reg_pax_w,\r
sum(case when jns_payment = 'Registration' and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'   then amount end  ) as reg_amount_w,\r
\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'   then 1 end  ) as tf_pax_w,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'  then amount end  ) as tf_amount_w,\r
\r
count(case when date_format(dt_payment,'%Y-%m') = ? and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_w,\r
sum(case when date_format(dt_payment,'%Y-%m') = ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_w,\r
\r
count(case when jns_payment = 'Registration' and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'  then 1 end  ) as reg_pax_m,\r
sum(case when jns_payment = 'Registration' and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'   then amount end  ) as reg_amount_m,\r
\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'   then 1 end  ) as tf_pax_m,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'  then amount end  ) as tf_amount_m,\r
\r
count(case when date_format(dt_payment,'%Y-%m') = ? and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_m,\r
sum(case when date_format(dt_payment,'%Y-%m') = ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_m\r
\r
\r
\r
\r
from vip_billing_payment a left join vip_billing b on a.kd_billing = b.kd_billing  where status = 'PAID' and  (date_format(dt_cetak, '%Y') = '2023' or date_format(dt_cetak, '%Y') = '2024') and a.kd_branch = ? ", ["2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), (string) ($kd_cbg)]);

				$result_hitung=db_query_or_die("Wah error nih11", $query_hitung, $__p_query_hitung ?? []);
					if ($result_hitung) 
						{ 
						while ($rh = db_fetch($result_hitung))
							{
						
							
							
							
$reg_pax_w = $rh[1];
$reg_amount_w = $rh[2];
$tf_pax_w = $rh[3];
$tf_amount_w = $rh[4];
$reg_pax_cl_w = $rh[5];
$reg_amount_cl_w = $rh[6];

$reg_pax_m = $rh[7];
$reg_amount_m = $rh[8];
$tf_pax_m = $rh[9];
$tf_amount_m = $rh[10];
$reg_pax_cl_m = $rh[11];
$reg_amount_cl_m = $rh[12];

$reg_pax_y = num($reg_pax_m) - num($reg_pax_w); 
$reg_amount_y =  num($reg_amount_m) - num($reg_amount_w);
$tf_pax_y = num($tf_pax_m) - num($tf_pax_w);
$tf_amount_y = num($tf_amount_m) - num($tf_amount_w);
$reg_pax_cl_y = num($reg_pax_cl_m)- num($reg_pax_cl_w);
$reg_amount_cl_y = num($reg_amount_cl_m) - num($reg_amount_cl_w);
							
$tot_reg_pax_w = num($tot_reg_pax_w) + num($reg_pax_w); 
$tot_reg_amount_w =  num($tot_reg_amount_w) + num($reg_amount_w);
$tot_tf_pax_w = num($tot_tf_pax_w) + num($tf_pax_w);
$tot_tf_amount_w = num($tot_tf_amount_w) + num($tf_amount_w);
$tot_reg_pax_cl_w = num($tot_reg_pax_cl_w)+ num($reg_pax_cl_w);
$tot_reg_amount_cl_w = num($tot_reg_amount_cl_w) + num($reg_amount_cl_w);
							
$tot_reg_pax_m = num($tot_reg_pax_m) + num($reg_pax_m); 
$tot_reg_amount_m =  num($tot_reg_amount_m) + num($reg_amount_m);
$tot_tf_pax_m = num($tot_tf_pax_m) + num($tf_pax_m);
$tot_tf_amount_m = num($tot_tf_amount_m) + num($tf_amount_m);
$tot_reg_pax_cl_m = num($tot_reg_pax_cl_w)+ num($reg_pax_cl_m);
$tot_reg_amount_cl_m = num($tot_reg_amount_cl_m) + num($reg_amount_cl_m);

$tot_reg_pax_y = num($tot_reg_pax_y) + num($reg_pax_y) ; 
$tot_reg_amount_y =  num($tot_reg_amount_y) + num($reg_amount_y) ;
$tot_tf_pax_y = num($tot_tf_pax_y) + num($tf_pax_y) ;
$tot_tf_amount_y = num($tot_tf_amount_y) + num($tf_amount_y) ;
$tot_reg_pax_cl_y = num($tot_reg_pax_cl_y) + num($reg_pax_cl_y) ;
$tot_reg_amount_cl_y = num($tot_reg_amount_cl_y) + num($reg_amount_cl_y) ;


							
							
							


				?>               
					
                <tr style="height: 100%">
                  <td style="height: 200%"><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($nm_bln_tampil) ; ?>
                  <input type="hidden" name="kd_branch" id="textfield" value="<?php echo e($kd_branch) ?>"></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_w) ; ?></td>
                  <td style="text-align: right" ><?php echo e($reg_amount_w)    ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_w); ?></td>
                  <td><?php echo e($tf_amount_w)    ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_w) ; ?></td>
                  <td style="text-align: right"><?php echo e($reg_amount_cl_w)    ; ?></td>

                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_m) ; ?></td>
                  <td style="text-align: right"><?php echo e($reg_amount_m)    ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_m); ?></td>
                  <td><?php echo e($tf_amount_m)    ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_m) ; ?></td>
                  <td style="text-align: right"><?php echo e($reg_amount_cl_m)    ; ?></td>
					
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_y) ; ?></td>
                  <td style="text-align: right"><?php echo e($reg_amount_y)    ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_y); ?></td>
                  <td><?php echo e($tf_amount_y)    ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_y) ; ?></td>
                  <td style="text-align: right"><?php echo e($reg_amount_cl_y)    ; ?></td>				
                  </tr>
                <?php $no_urut = num($no_urut)+1; }} } } ?>
            
                </tbody>
                <tfoot>
					<tr style="height: 100%">
                  <td colspan="2" style="height: 200%"><strong>TOTAL <?php echo e($cabang) ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_w) ; ?></td>
                  <td style="text-align: right" ><?php echo      e($tot_reg_amount_w)      ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_tf_pax_w); ?></td>
                  <td><?php echo      e($tot_tf_amount_w)      ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_cl_w) ; ?></td>
                  <td style="text-align: right"><?php echo      e($tot_reg_amount_cl_w)      ; ?></td>

                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_m) ; ?></td>
                  <td style="text-align: right"><?php echo      e($tot_reg_amount_m)      ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_tf_pax_m); ?></td>
                  <td><?php echo      e($tot_tf_amount_m)      ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_cl_m) ; ?></td>
                  <td style="text-align: right"><?php echo      e($tot_reg_amount_cl_m)      ; ?></td>
					
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_y) ; ?></td>
                  <td style="text-align: right"><?php echo      e($tot_reg_amount_y)      ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_tf_pax_y); ?></td>
                  <td><?php echo      e($tot_tf_amount_y)      ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_cl_y) ; ?></td>
                  <td style="text-align: right"><?php echo      e($tot_reg_amount_cl_y)      ; ?></td>				
                  </tr>
                </tfoot>
              </table>
