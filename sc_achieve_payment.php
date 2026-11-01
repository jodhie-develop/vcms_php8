<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=vespf.xls");
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
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
if ($kd_cbg == 'National'){$kd_cbg = 100;}
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}


if (num($kd_cbg) ==1){$cabang = 'East Sby';$nm_cabang = $cabang;}
if (num($kd_cbg) ==2){$cabang = 'West Sby';$nm_cabang = $cabang;}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';$nm_cabang = 'Bali';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';$nm_cabang = 'Patal Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';$nm_cabang = 'Central Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';$nm_cabang = $cabang;}
if (num($kd_cbg) ==7){$cabang = 'Bandung';$nm_cabang = $cabang;}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';$nm_cabang = $cabang;}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';$nm_cabang = $cabang;}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';$nm_cabang = $cabang;}
if (num($kd_cbg) ==100){$cabang = 'National';$nm_cabang = $cabang;}
if (num($kd_cbg) ==11){$cabang = 'PIK';$nm_cabang = $cabang;}



$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;

 if ($cabang =='--ALL--' or $cabang =='National')
	{
	$query = q_set($__p_query, "SELECT t.id_prof_bill, concat_ws(' ',a.nama, a.middle_name,a.family_name), concat_ws(' ',t.country_dest, t.school_dest, t.prg_dest), c.status_host, c.status_part, t.st_refund, t.rp_mount,t.dt_paid, a.branch,t.sc_name,status_part FROM ves_inc.tb_prof_bill t\r
left join ves_inc.tb_biodata a on t.id_stu = a.kd_biodata left join ves_inc.tb_enrolled c on t.school_dest = c.sch_dest and t.country_dest = c.country_dest\r
where dt_paid between ? and ? and t.branch <> '' group by t.id_prof_bill order by t.dt_paid", [(string) ($date_start), (string) ($date_end)]);		
	}
else
	{
	$query = q_set($__p_query, "SELECT t.id_prof_bill, concat_ws(' ',a.nama, a.middle_name,a.family_name), concat_ws(' ',t.country_dest, t.school_dest, t.prg_dest), c.status_host, c.status_part, t.st_refund, t.rp_mount,t.dt_paid,  a.branch,t.sc_name,status_part  FROM ves_inc.tb_prof_bill t\r
left join ves_inc.tb_biodata a on t.id_stu = a.kd_biodata left join ves_inc.tb_enrolled c on t.school_dest = c.sch_dest and t.country_dest = c.country_dest\r
where dt_paid between ? and ? and t.branch = ? group by t.id_prof_bill order by t.dt_paid", [(string) ($date_start), (string) ($date_end), (string) ($nm_cabang)]);		
	}
$no_urut = 1;

$result=db_query_or_die("Wah error nih11", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>

?>
<table width="97%" class="table table-bordered table-striped" id="example1">
  <thead>
    <tr>
      <th width="3%">No</th>
      <th width="12%">Payment Date</th>
      <th width="12%">Receipt Number</th>
      <th width="22%">Student Name</th>
      <th width="25%">Destination</th>
      <th width="12%">P/NP</th>
      <th width="12%">Refund/<br>
        Non Refund</th>
      <th width="14%">SC</th>
      <th width="14%">Amount</th>
    </tr>
  </thead>
  <tbody>
    <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$query_nama = q_set($__p_query_nama, "SELECT concat_ws(' ',nama, middle_name) from ves_inc.tb_biodata where kd_biodata = ? and kd_branch = ? ", [(string) ($r[3]), (string) ($r[5])]);
							$result_nama=db_query_or_die("Wah error nih1", $query_nama, $__p_query_nama ?? []);	
							while ($r_nama = db_fetch($result_nama))
								{ $nama_student = $r_nama[0];}
							$query_program = q_set($__p_query_program, "SELECT concat_ws(' ', type_program, nm_program), level_program, buku FROM ves_data.vip_mst_code_prg  where kd_program =  ? group by kd_program", [(string) ($r[4])]);
							$result_program=db_query_or_die("Wah error nih1", $query_program, $__p_query_program ?? []);	
							while ($r_program = db_fetch($result_program))
								{ $nama_program = $r_program[0];$jenis_program = $r_program[1];}		
							//$query_last_progress= "SELECT pro
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>
    <tr>
      <td><?php echo e($no_urut) ; ?></td>
      <td><?php echo e($r[7]) ; ?></td>
      <td><?php echo e($r[0]) ; ?></td>
      <td><?php echo e($r[1]) ; ?></td>
      <td><?php echo e($r[2]) ; ?></td>
      <td><?php echo e($r[10]) ; ?></td>
      <td><?php echo e($r[5]) ; ?></td>
      <td><?php echo e($r[8]) ; ?> - <?php echo e($r[9]) ; ?></td>
      <td><?php echo e($r[6]) ; ?></td>
    </tr>
    <?php $no_urut = num($no_urut) + 1; } }?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
