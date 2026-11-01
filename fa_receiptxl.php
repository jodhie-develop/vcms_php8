<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=fa_receiptxl.xls");
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

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
elseif ($kd_cbg == 'National'){$kd_cbg = 100;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'FELLOWS ACADEMY'){$kd_cbg = 19;}


if (num($kd_cbg) ==1){$cabang = 'East Sby';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';$nm_cabang = 'Bali';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';$nm_cabang = 'Patal Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';$nm_cabang = 'Central Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==100){$cabang = 'National';$nm_cabang = $cabang;}
elseif ($kd_cbg =='00'){$cabang = 'HO';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==19){$cabang = 'FELLOWS ACADEMY';$nm_cabang = $cabang;}


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
    
 if ($cabang =='National')
	{
	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata where a.id_receipt <> '' \r
\tand dt_payment between ? and ?   and b.kd_program  like 'FA-%'  group by id_receipt order by id_receipt", [(string) ($date_start), (string) ($date_end)]);		
	}
else
	{
	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' and a.kd_branch = ?\r
\tand dt_payment between ? and ?   and b.kd_program  like 'FA-%'  group by id_receipt order by id_receipt", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);		
	}

$total_rp = 0;
$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
<table width="97%" class="table table-bordered table-striped" id="example1">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="7%">Effective Date</th>
                  <th width="7%"> Receipt Date</th>
                  <th width="27%">Student Name</th>
                  <th width="12%">Receipt Number</th>
                  <th width="14%">Program</th>
                  <th width="10%">Detail</th>
                  <th width="10%">Amount</th>
                  <th width="11%">Payment Metodh</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$query_nama = q_set($__p_query_nama, "SELECT concat_ws(' ',nama, middle_name) from ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($r[3])]);
							$result_nama=db_query_or_die("Wah error nih1", $query_nama, $__p_query_nama ?? []);	
							while ($r_nama = db_fetch($result_nama))
								{ $nama_student = $r_nama[0];}
							$query_program = q_set($__p_query_program, "SELECT concat_ws(' ', type_program, nm_program), level_program, buku FROM ves_data.vip_mst_code_prg  where kd_program =  ? group by kd_program", [(string) ($r[4])]);
							$result_program=db_query_or_die("Wah error nih1", $query_program, $__p_query_program ?? []);	
							while ($r_program = db_fetch($result_program))
								{ $nama_program = $r_program[0];$jenis_program = $r_program[1];}		
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[0]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($nama_student) ; ?></td>
                  <td><?php echo e($r[2]) ; ?></td>
                  <td><?php echo e($nama_program) ; ?> - <?php echo e($jenis_program) ; ?></td>
                  <td><?php echo e($r[7]) ; ?></td>
                  <td><?php echo e($r[6]) ; ?></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  </tr>
                <?php $total_rp = num($total_rp) + num($r[6]); $no_urut = num($no_urut) + 1; } }
					$query_lama = q_set($__p_query_lama, "select date_format(waktu,'%b %d, %Y') ,date_format(tgl_cetak,'%b %d, %Y') , nm_student, id_receipt, nm_prg, mount_pat, jns_pay,pay_mtd from " . ($db_cabang ?? '') . "tb_receipt where waktu between ? and ? order by tgl_pay", [(string) ($date_start), (string) ($date_end)]);

							$result_lama=db_query_or_die("Wah error nih2", $query_lama, $__p_query_lama ?? []);	
							while ($r_lama = db_fetch($result_lama))
								{ 
					?><tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r_lama[0]) ; ?></td>
                  <td><?php echo e($r_lama[1]) ; ?></td>
                  <td><?php echo e($r_lama[2]) ; ?></td>
                  <td><?php echo e($r_lama[3]) ; ?></td>
                  <td><?php echo e($r_lama[4]) ; ?></td>
                  <td><?php echo  e($r_lama[6]) ; ?></td>                  
                  <td><?php echo e($r_lama[5]) ; ?></td>
                  <td><?php echo e($r_lama[7]) ; ?></td>  </tr>
                  <?php $total_rp = num($total_rp) + num($r_lama[5]); $no_urut = num($no_urut) + 1; }  ?>              
                </tbody>
                <tfoot>
                </tfoot>
              </table>
