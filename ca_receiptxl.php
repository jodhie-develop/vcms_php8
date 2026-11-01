<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=ca_rcp$date_start-$date_end.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');

if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');


$cbg_label = in_val('cbg_label', 'get');
$pilihan_sc = in_val('pilihan_sc', 'get');




$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
    

//	$query = "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd,
//case when jns_Payment = 'Down Payment' then amount end as DP,
//case when jns_Payment = 'Registration' then amount end as RF,
//case when jns_Payment = 'Installment 1' then amount end as i1,
//case when jns_Payment = 'Installment 2' then amount end as i2,
//case when jns_Payment = 'Installment 3' then amount end as i3,
//case when jns_Payment = 'Full Payment' then amount end as fp,sc    FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' and a.kd_branch = '$kd_cbg'
//	and dt_payment between '$date_start' and '$date_end' group by id_receipt order by id_receipt";		
if ($kd_cbg == 'CA') {
    // Pilihan "CA" -> filter berdasarkan kd_branch seperti biasa
    $where_filter = "";
} else {
    // Pilihan cabang lain -> filter berdasarkan list sc
    $sc_array = explode(',', $kd_cbg);
    $sc_array = $sc_array;
    $sc_in = q_set($__p_sc_in, "" . db_in(array_values((array) $sc_array)), [...array_map('strval', array_values((array) $sc_array))]);
    $where_filter = q_set($__p_where_filter, "sc IN (" . $sc_in . ")", [...($__p_sc_in ?? [])]);
}

if ($kd_cbg =='15')
{
$query = q_set($__p_query, "SELECT \r
    date_format(min(a.dt_payment),'%b %d, %Y'),\r
    date_format(min(a.dt_cetak),'%b %d, %Y'),\r
    a.id_receipt, \r
    a.kd_biodata, \r
    b.kd_program,\r
    a.kd_branch,\r
    amount, \r
    jns_Payment,\r
    a.pay_mtd,\r
    a.kd_billing,\r
    a.no,\r
    case when jns_Payment = 'Down Payment' then amount end as DP,\r
    case when jns_Payment = 'Registration' then amount end as RF,\r
    case when jns_Payment = 'Installment 1' then amount end as i1,\r
    case when jns_Payment = 'Installment 2' then amount end as i2,\r
    case when jns_Payment = 'Installment 3' then amount end as i3,\r
    case when jns_Payment = 'Full Payment' then amount end as fp,\r
    a.dt_cetak,\r
    sc \r
    FROM vip_billing_payment a \r
    LEFT JOIN vip_billing b ON a.kd_biodata = b.kd_biodata AND a.kd_billing = b.kd_billing \r
    WHERE a.id_receipt <> '' \r
    AND (b.kd_program = 'CAWSCDP' or  b.kd_program = 'CAWSCTOC' or (b.kd_program like 'CA%' and b.kd_program not like 'CAWS%' ))\r
    AND dt_payment >= ? AND dt_payment <= ?\r
    GROUP BY id_receipt \r
    ORDER BY id_receipt DESC", [(string) ($date_start), (string) ($date_end)]);
}	
else
{
$query = q_set($__p_query, "SELECT \r
    date_format(min(a.dt_payment),'%b %d, %Y'),\r
    date_format(min(a.dt_cetak),'%b %d, %Y'),\r
    a.id_receipt, \r
    a.kd_biodata, \r
    b.kd_program,\r
    a.kd_branch,\r
    amount, \r
    jns_Payment,\r
    a.pay_mtd,\r
    a.kd_billing,\r
    a.no,\r
    case when jns_Payment = 'Down Payment' then amount end as DP,\r
    case when jns_Payment = 'Registration' then amount end as RF,\r
    case when jns_Payment = 'Installment 1' then amount end as i1,\r
    case when jns_Payment = 'Installment 2' then amount end as i2,\r
    case when jns_Payment = 'Installment 3' then amount end as i3,\r
    case when jns_Payment = 'Full Payment' then amount end as fp,\r
    a.dt_cetak,\r
    sc \r
    FROM vip_billing_payment a \r
    LEFT JOIN vip_billing b ON a.kd_biodata = b.kd_biodata AND a.kd_billing = b.kd_billing \r
    WHERE a.id_receipt <> '' \r
    AND " . $where_filter . "\r
    AND dt_payment >= ? AND dt_payment <= ?\r
    GROUP BY id_receipt \r
    ORDER BY id_receipt DESC", [...($__p_where_filter ?? []), (string) ($date_start), (string) ($date_end)]);
}

$total_rp = 0;
$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
<table width="97%" class="table table-bordered table-striped" id="example1">
                <thead>
                <tr>
                  <th colspan="16">CHAMPIONS ACADEMY INCOME SUMMARY REPORT<br><?php echo e($cbg_label) ?></th>
                  </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th colspan="2">Period :</th>
                  <th colspan="2" align="left"><?php echo e($date_start) ?> to <?php echo e($date_end) ?></th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                </tr>
                <tr bgcolor="#EE0D0D">
                  <th width="2%">No</th>
                  <th width="7%">Effective Date</th>
                  <th width="7%"> Receipt Date</th>
                  <th width="27%">Receipt Number</th>
                  <th width="27%">Student Name</th>
                  <th width="14%">Program</th>
                  <th width="10%">Payment Metodh</th>
                  <th width="10%">Detail</th>
                  <th width="11%">DP</th>
                  <th width="11%">RF</th>
                  <th width="11%">Inst 1</th>
                  <th width="11%">Inst 2</th>
                  <th width="11%">Inst 3</th>
                  <th width="11%">Full P</th>
                  <th width="11%">SC</th>
                  <th width="11%">Cash Back</th>
                  </tr>
                </thead>
                <tbody>

				  <?php  
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							//$query_nama = "SELECT concat_ws(' ',nama, middle_name) from ves_inc.tb_biodata where kd_biodata = '$r[3]' and kd_branch = '$r[5]'";
							$query_nama = q_set($__p_query_nama, "SELECT nama_lengkap from ves_data.vip_student_data where kd_biodata = ? and kd_branch = ? ", [(string) ($r[3]), (string) ($r[5])]);
							$result_nama=db_query_or_die("Wah error nih1", $query_nama, $__p_query_nama ?? []);	
							while ($r_nama = db_fetch($result_nama))
								{ $nama_student = $r_nama[0];}
							$query_program = q_set($__p_query_program, "SELECT concat_ws(' ', type_program, nm_program), level_program, buku FROM ves_data.vip_mst_code_prg  where kd_program =  ? group by kd_program", [(string) ($r[4])]);
							$result_program=db_query_or_die("Wah error nih1", $query_program, $__p_query_program ?? []);	
							while ($r_program = db_fetch($result_program))
								{ $nama_program = $r_program[0];$jenis_program = $r_program[1];}
							
				?>                
                <tr <?php if(num($no_urut) %2 ==0){ ?> bgcolor="#E4DDDD" <?php }?> >
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[0]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($r[2]) ; ?></td>
                  <td><?php echo e($nama_student) ; ?></td>
                  <td><?php echo e($nama_program) ; ?> - <?php echo e($jenis_program) ; ?></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  <td><?php echo e($r[7]) ; ?></td>
                  <td><?php echo e($r[11]) ;  $tot_dp = num($tot_dp)+num($r[11]);?></td>
                  <td><?php echo e($r[12]) ;  $tot_rf = num($tot_rf) + num($r[12]); ?></td>
                  <td><?php echo e($r[13]) ;  $tot_inst_1 = num($tot_inst_1)+num($r[13]); ?></td>
                  <td><?php echo e($r[14]) ;  $tot_inst_2 = num($tot_inst_2)+num($r[14]); ?></td>
                  <td><?php echo e($r[15]) ;  $tot_inst_3 = num($tot_inst_3)+num($r[15]); ?></td>
                  <td><?php echo e($r[16]) ;  $tot_fp = num($tot_fp)+num($r[16]); ?></td>
                  <td><?php echo e($r[18]) ; ?></td>
                  <td>&nbsp;</td>
                  </tr>
                <?php $total_rp = num($total_rp) + num($r[6]); $no_urut = num($no_urut) + 1; } } ?>
				  <tr>
                  <td colspan="8" rowspan="2" align="right"><strong>GRAND TOTAL</strong></td>
                  <td><?php echo e($tot_dp) ; ?></td>
                  <td><?php echo  e($tot_rf) ; ?></td>
                  <td><?php echo  e($tot_inst_1) ; ?></td>
                  <td><?php echo e($tot_inst_2); ?></td>
                  <td><?php echo e($tot_inst_3) ; ?></td>
                  <td><?php echo e($tot_fp) ; ?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>  </tr>
				  <tr>
				    <td colspan="6"><strong><?php echo e(num($tot_dp) + num($tot_rf) + num($tot_inst_1) + num($tot_inst_2) + num($tot_inst_3) + num($tot_fp)) ; ?></strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8" align="right">&nbsp;</td>
				    <td colspan="6">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right"><strong>Total Tuition</strong></td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td colspan="6">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">Down Payment</td>
				    <td align="right"><?php echo e($tot_dp) ; ?></td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td colspan="6">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">Tuition Fee</td>
				    <td align="right"><?php echo  e(num($tot_inst_1) + num($tot_inst_2) + num($tot_inst_3) + num($tot_fp))  ; ?></td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td colspan="6">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">Registration</td>
				    <td align="right"><?php echo  e($tot_rf) ; ?></td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td colspan="6">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right">&nbsp;</td>
				    <td align="right" bgcolor="#E3D4D5"><strong>Total Income</strong></td>
				    <td align="right" bgcolor="#E3D4D5"><strong><?php echo e(num($tot_dp) + num($tot_rf) + num($tot_inst_1) + num($tot_inst_2) + num($tot_inst_3) + num($tot_fp)) ; ?></strong></td>
				    <td align="right" bgcolor="#E3D4D5">&nbsp;</td>
				    <td align="right" bgcolor="#E3D4D5">&nbsp;</td>
				    <td align="right" bgcolor="#E3D4D5">&nbsp;</td>
				    <td colspan="6">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
                  <?php $total_rp = num($total_rp) + num($r_lama[5]); $no_urut = num($no_urut) + 1;   ?>              
                </tbody>
                <tfoot>
                </tfoot>
              </table>
