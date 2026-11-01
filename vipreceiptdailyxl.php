<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();  $dt_today = in_val('dt', 'get'); ?>
<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=vipreceiptby$dt_today.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
include __DIR__ . "/conndb.php";



$thnn = substr($dt_today,0,4);
$blnn = substr($dt_today,0,7);
$awal_bln = "$blnn-01";

$awal_thn = "$thnn-01-01";
?>
	      <table width="97%" class="table table-hover" id="example1">
				  <jdl>
                <thead>
                <tr>
                  <th colspan="21">VIP RECEIPT SUMMARY ALL BRANCHES</th>
                  </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th><strong><span style="font-size: 15">Report Date</span> :<?php echo e($dt_today) ?></strong></th>
                  <th>&nbsp;</th>
                  <th colspan="6" style="text-align: center";>&nbsp;</th>
                  <th colspan="6" style="text-align: center">&nbsp;</th>
                  <th colspan="6" style="text-align: center">&nbsp;</th>
                </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="6" style="text-align: center";>Daily</th>
                  <th colspan="6" style="text-align: center">Monthly</th>
                  <th colspan="6" style="text-align: center">Yearly</th>
                  </tr>
                <tr>
                  <th>&nbsp;</th>
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
                <tr style="font-size: 1em">
                  <th width="5%">No</th>
                  <th width="20%">Center</th>
                  <th width="6%">TOTAL</th>
                  <th width="2%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="7%">Amount</th>
                  <th width="2%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="4%">Amount</th>
                  <th width="2%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="4%">Amount</th>
                  <th width="2%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="7%">Amount</th>
                  <th width="2%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="4%">Amount</th>
                  <th width="2%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="4%">Amount</th>
                  <th width="2%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="7%">Amount</th>
                  <th width="2%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="4%">Amount</th>
                  <th width="2%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="10%">Amount</th>
                  </tr>
                </thead>
				  </jdl>					  
                <tbody>

				  <?php 
					$query_cabang = q_set($__p_query_cabang, "select kd_branch from vip_billing_payment where dt_cetak between ? and ? group by kd_branch order by kd_branch", [(string) ($awal_thn), (string) ($dt_today)]);
					$result_cabang=db_query_or_die("Wah error nih11", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$nm_cabang = $r_cbg[0];
							
							
							
							$query_hitung = q_set($__p_query_hitung, "select a.kd_branch,\r
count(case when jns_payment = 'Registration' and dt_cetak = ?   and kd_program not like 'CL%'  then 1 end  ) as reg_pax_w,\r
sum(case when jns_payment = 'Registration' and dt_cetak = ?   and kd_program not like 'CL%'   then amount end  ) as reg_amount_w,\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak = ?   and kd_program not like 'CL%'   then 1 end  ) as tf_pax_w,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak = ?   and kd_program not like 'CL%'  then amount end  ) as tf_amount_w,\r
\r
count(case when dt_cetak = ?   and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_w,\r
sum(case when dt_cetak = ?  and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_w,\r
\r
count(case when jns_payment = 'Registration' and dt_cetak between ? and ?  and kd_program not like 'CL%'  then 1 end  ) as reg_pax_m,\r
sum(case when jns_payment = 'Registration' and dt_cetak between ? and ?  and kd_program not like 'CL%'  then amount end  ) as reg_amount_m,\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak between ? and ?   and kd_program not like 'CL%'  then 1 end  ) as tf_pax_m,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak between ? and ?  and kd_program not like 'CL%'  then amount end  ) as tf_amount_m,\r
\r
count(case when dt_cetak between ? and ?  and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_m,\r
sum(case when dt_cetak between ? and ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_m,\r
\r
\r
count(case when jns_payment = 'Registration' and dt_cetak between ? and ?  and kd_program not like 'CL%'  then 1 end  ) as reg_pax_y,\r
sum(case when jns_payment = 'Registration' and dt_cetak between ? and ?  and kd_program not like 'CL%'  then amount end  ) as reg_amount_y,\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak between ? and ?  and kd_program not like 'CL%'   then 1 end  ) as tf_pax_y,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak between ? and ?  and kd_program not like 'CL%'  then amount end  )\r
as tf_amount_y,\r
\r
count(case when dt_cetak between ? and ?  and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_y,\r
sum(case when dt_cetak between ? and ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_y\r
\r
from vip_billing_payment a left join vip_billing b on a.kd_billing = b.kd_billing  where status = 'PAID' and dt_cetak between ? and ? and a.kd_branch = ? ", [(string) ($dt_today), (string) ($dt_today), (string) ($dt_today), (string) ($dt_today), (string) ($dt_today), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($nm_cabang)]);
				$result_hitung=db_query_or_die("Wah error nih11", $query_hitung, $__p_query_hitung ?? []);
					if ($result_hitung) 
						{ 
						while ($rh = db_fetch($result_hitung))
							{
							$kd_branch = $rh[0];
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

$reg_pax_y = $rh[13];
$reg_amount_y = $rh[14];
$tf_pax_y = $rh[15];
$tf_amount_y = $rh[16];
$reg_pax_cl_y = $rh[17];
$reg_amount_cl_y = $rh[18];
$total_reg_pax_w =num($total_reg_pax_w) + num($reg_pax_w);
$total_reg_amount_w =num($total_reg_amount_w) + num($reg_amount_w);
$total_tf_pax_w =num($total_tf_pax_w) + num($tf_pax_w);
$total_tf_amount_w =num($total_tf_amount_w) + num($tf_amount_w);
$total_reg_pax_cl_w =num($total_reg_pax_cl_w) + num($reg_pax_cl_w);
$total_reg_amount_cl_w =num($total_reg_amount_cl_w) + num($reg_amount_cl_w);

$total_reg_pax_m =num($total_reg_pax_m) + num($reg_pax_m);
$total_reg_amount_m =num($total_reg_amount_m) + num($reg_amount_m);
$total_tf_pax_m =num($total_tf_pax_m) + num($tf_pax_m);
$total_tf_amount_m =num($total_tf_amount_m) + num($tf_amount_m);
$total_reg_pax_cl_m =num($total_reg_pax_cl_m) + num($reg_pax_cl_m);
$total_reg_amount_cl_m =num($total_reg_amount_cl_m) + num($reg_amount_cl_m);

$total_reg_pax_y =num($total_reg_pax_y) + num($reg_pax_y);
$total_reg_amount_y =num($total_reg_amount_y) + num($reg_amount_y);
$total_tf_pax_y =num($total_tf_pax_y) + num($tf_pax_y);
$total_tf_amount_y =num($total_tf_amount_y) + num($tf_amount_y);
$total_reg_pax_cl_y =num($total_reg_pax_cl_y) + num($reg_pax_cl_y);
$total_reg_amount_cl_y =num($total_reg_amount_cl_y) + num($reg_amount_cl_y);

				?>               
					
                <tr>
                  <td height="20"><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($nama_cabang) ; ?></td>
                  <td><input type="hidden" name="kd_branch" id="textfield" value="<?php echo e($kd_branch) ?>"></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_w) ; ?></td>
                  <td style="text-align: right" ><?php echo   e($reg_amount_w)  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_w); ?></td>
                  <td><?php echo   e($tf_amount_w)  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_w) ; ?></td>
                  <td style="text-align: right"><?php echo   e($reg_amount_cl_w)  ; ?></td>

                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_m) ; ?></td>
                  <td style="text-align: right"><?php echo   e($reg_amount_m)  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_m); ?></td>
                  <td style="text-align: right"><?php echo   e($tf_amount_m)  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_m) ; ?></td>
                  <td style="text-align: right"><?php echo   e($reg_amount_cl_m)  ; ?></td>
					
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_y) ; ?></td>
                  <td style="text-align: right"><?php echo   e($reg_amount_y)  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_y); ?></td>
                  <td style="text-align: right"><?php echo   e($tf_amount_y)  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_y) ; ?></td>
                  <td style="text-align: right"><?php echo   e($reg_amount_cl_y)  ; ?></td>				
                  </tr> <?php $no_urut = num($no_urut)+1; }} } } ?>
                <tr>
                  <td height="20"><strong>TOTAL</strong></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_w) ; ?></strong></td>
                  <td style="text-align: right" ><strong><?php echo   e($total_reg_amount_w)  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_tf_pax_w); ?></strong></td>
                  <td><strong><?php echo   e($total_tf_amount_w)  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_cl_w) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   e($total_reg_amount_cl_w)  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_m) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   e($total_reg_amount_m)  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_tf_pax_m); ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   e($total_tf_amount_m)  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_cl_m) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   e($total_reg_amount_cl_m)  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_y) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   e($total_reg_amount_y)  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tf_pax_y); ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   e($total_tf_amount_y)  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_cl_y) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   e($total_reg_amount_cl_y)  ; ?></strong></td>
                  </tr>
               
            
                </tbody>
                <tfoot>
                </tfoot>
              </table>
