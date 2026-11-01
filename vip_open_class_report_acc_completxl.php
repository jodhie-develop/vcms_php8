<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=vipopenclacc.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');

if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');


if ($kd_cbg == 'National'){$kd_cbg = 100;}

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang'){$kd_cbg = 8;}
if ($kd_cbg == 'East Area'){$kd_cbg = 101;}
if ($kd_cbg == 'West Area'){$kd_cbg = 102;}


if (num($kd_cbg) ==100){$cabang = 'National';}
if ($kd_cbg ==''){$cabang = 'National';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang';}
if (num($kd_cbg) ==101){$cabang = 'East Area';}
if (num($kd_cbg) ==102){$cabang = 'West Area';}



$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}

if($kd_cbg == '100' or $kd_cbg ==''){$filter_cbg = q_set($__p_filter_cbg, " ");}
elseif ($kd_cbg == '101'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '1' or a.kd_branch = '1' or a.kd_branch = '3' or a.kd_branch = '8'  )  ");}
elseif ($kd_cbg == '102'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6' or a.kd_branch = '7'  )  ");}
else {$filter_cbg = q_set($__p_filter_cbg, " where a.kd_branch = ? ", [(string) ($kd_cbg)]);}
if ($filter_cbg =='') {$filter_tgl = q_set($__p_filter_tgl, " where f.min_mulai\t between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
else {$filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}

?>
<table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td width=9% height="14" align=center >Month</td>
	            <td width=4% align=center >Week</td>
	            <td width=2% align=center >No</td>
	            <td width=9% align=center >Class</td>
	            <td width=2% align=center >No </td>
	            <td width=10% align=center >Name</td>
	            <td width="8%" align=center >TF</td>
	            <td width="9%" align=center >Nett TFt</td>
	            <td width="9%" align=center >Discount</td>
	            <td width="10%" align=center >Tuition Paid</td>
	            <td width="8%" align=center >Reg Fee Paid</td>
	            <td width="11%" align=center >Material Book Paid</td>
	            <td width="8%" align=center >Total Paid</td>
	            <td width="1%" align=center >SC</td>
              </tr>
            </thead>
	        <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   echo $query_billing;
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	        <tbody>
	          <?php	
	$adafile = 0;
				$urut_no = 1;
$query_open_class = q_set($__p_query_open_class, "SELECT date_format(mulai_tm, '%M'),h.minggu, e.nama_lengkap, a.kelas, b.duration_program,date_format(mulai_tm,'%b %d, %Y'),g.sc,\r
g.tf, g.net_tf, g.discount,g.kd_billing FROM ves_data.vip_teacher_schedule a\r
left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program\r
left join ves_data.vip_billing g  on a.kelas = g.kd_class\r
left join ves_data.vip_student_data e  on g.kd_biodata = e.kd_biodata\r
left join ves_data.tb_minggu_detail h  on date_format(a.mulai_tm, '%Y-%m-%d') = date_format(h.detail, '%Y-%m-%d')\r
\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai " . $filter_cbg . "  " . $filter_tgl . " and a.kd_biodata = '' and a.status_kelas = 1\r
 group by a.kelas, e.kd_biodata order by mulai_tm", [...($__p_filter_cbg ?? []), ...($__p_filter_tgl ?? [])]); 

$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);
$keluar_open_class = db_num_rows($resource_open_class);				
if(num(db_num_rows($resource_open_class)) > 0)
	{
	while ($row_open_class  =  db_fetch($resource_open_class, PDO::FETCH_NUM))
		{
		$kelas_baru = $row_open_class[3];
		if ($kelas_lama  != $kelas_baru){$hitungperkelas = 1;}
		$query_jml_murid = q_set($__p_query_jml_murid, "SELECT count(kd_billing) as jml FROM ves_data.vip_billing where kd_class= ? and kd_branch = ? ", [(string) ($row_open_class[3]), (string) ($kd_cbg)]);
		$resource_jml_murid = db_query_soft($query_jml_murid, $__p_query_jml_murid ?? []);
		$keluar_jml_murid = db_num_rows($resource_jml_murid);				
		if(num(db_num_rows($resource_jml_murid)) > 0)
			{
			while ($row_jml_murid  =  db_fetch($resource_jml_murid, PDO::FETCH_NUM))
				{	
				$jml_murid = $row_jml_murid[0];
				}
			}
		$query_last_date = q_set($__p_query_last_date, "SELECT max(mulai_tm) as selesai,date_format(max(mulai_tm),'%b %d, %Y') FROM ves_data.vip_teacher_schedule a where a.kelas = ? ", [(string) ($row_open_class[3])]);
		$resource_last_date = db_query_soft($query_last_date, $__p_query_last_date ?? []);
		$keluar_last_date = db_num_rows($resource_last_date);				
		if(num(db_num_rows($resource_last_date)) > 0)
			{
			while ($row_last_date  =  db_fetch($resource_last_date, PDO::FETCH_NUM))
				{
				$kelas_selesai = $row_last_date[1];					
				}
			}
//		$query_time_teacher = "select date_format(mulai_tm, '%a'),  date_format(mulai_tm, '%H:%i'),date_format(selesai_tm, '%H:%i'),nm_teacher 	
		$query_time_teacher = q_set($__p_query_time_teacher, "select nm_teacher from vip_teacher_schedule where kelas = ? group by  nm_teacher", [(string) ($row_open_class[3])]);
			
		$resource_time_teacher = db_query_soft($query_time_teacher, $__p_query_time_teacher ?? []);		
		if(num(db_num_rows($resource_time_teacher)) > 0)
			{
			while ($row_time_teacher  =  db_fetch($resource_time_teacher, PDO::FETCH_NUM))
				{
				//$jadwal_1= "$row_time_teacher[0] ($row_time_teacher[1]-$row_time_teacher[2]) - $row_time_teacher[3]<br>";
				$infoteacher= "$row_time_teacher[0]";
					
				//$baris_jadwal = "$baris_jadwal $jadwal_1";	
				$baris_teacher = "$baris_teacher $infoteacher";	
					
				}
			}
		$query_day_teacher = q_set($__p_query_day_teacher, "select date_format(mulai_tm,'%a') from vip_teacher_schedule where kelas = ? group by date_format(mulai_tm,'%a') order by date_format(mulai_tm, '%w')", [(string) ($row_open_class[3])]);
			
		$resource_day_teacher = db_query_soft($query_day_teacher, $__p_query_day_teacher ?? []);		
		if(num(db_num_rows($resource_day_teacher)) > 0)
			{
			while ($row_day_teacher  =  db_fetch($resource_day_teacher, PDO::FETCH_NUM))
				{
				//$jadwal_1= "$row_time_teacher[0] ($row_time_teacher[1]-$row_time_teacher[2]) - $row_time_teacher[3]<br>";
				$infoday= "$row_day_teacher[0]";
					
				//$baris_jadwal = "$baris_jadwal $jadwal_1";	
				$baris_day = "$baris_day $infoday";	
					
				}
			}			
// tampilkan bayar
		$query_reg = q_set($__p_query_reg, "SELECT  amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Registration' and kd_billing = ? and status = 'PAID' ", [(string) ($row_open_class[10])]); 
		$resource_reg = db_query_or_die('errro_71', $query_reg, $__p_query_reg ?? []);
			while ($row_reg=  db_fetch($resource_reg, PDO::FETCH_NUM))
			{
			$reg_amount =   $row_reg[0];	
			}
		$query_material = q_set($__p_query_material, "SELECT  amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Material' and kd_billing = ? and status = 'PAID' ", [(string) ($row_open_class[10])]); 
		$resource_material = db_query_or_die('errro_71', $query_material, $__p_query_material ?? []);
			while ($row_material=  db_fetch($resource_material, PDO::FETCH_NUM))
			{
			$reg_material =   $row_material[0];	
			}	
		
		$query_tf = q_set($__p_query_tf, "SELECT  sum(amount)  FROM ves_data.vip_billing_payment where  (jns_payment = 'Down Payment' or jns_payment = 'Full Payment' or jns_payment = 'Installment 1' or jns_payment = 'Installment 2'  or jns_payment = 'Installment 3') and kd_billing = ? and status = 'PAID' ", [(string) ($row_open_class[10])]); 
		$resource_tf = db_query_or_die('errro_71', $query_tf, $__p_query_tf ?? []);
			while ($row_tf=  db_fetch($resource_tf, PDO::FETCH_NUM))
			{
			$tf_amount =   $row_tf[0];	
			}	
		$total_paid = num($reg_amount)  +num($reg_material) + num($tf_amount);			
	?>
<?php if (num($hitungperkelas) ==1){?>
	          <tr>
	            <td height="14" colspan="14" align=center bgcolor="#E9DBDB" class="style24">&nbsp;</td>
              </tr>
<?php } ?>          
	          <tr>
	            <td height="14" align=center class="style24"><?php echo  e($row_open_class[0])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[1])  ?></td>
	            <td align=center class="style24"><?php echo e($urut_no) ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[3])  ?></td>
	            <td align=center class="style24"><?php echo e($hitungperkelas) ?></td>
	            <td align=left class="style24"><?php echo  e($row_open_class[2])  ?></td>
	            <td align=center class="style24"><?php echo number_format(num($row_open_class[7]),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($row_open_class[8]),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo e($row_open_class[9]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($tf_amount ),0,".",".")   ?></td>
	            <td align=center class="style24"><?php echo  number_format(num((float)$reg_amount),0,".",".")   ?></td>
	            <td align=center class="style24"><?php echo  number_format(num( (float)$reg_material),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num((float)$total_paid),0,".",".")   ?></td>
	            <td align=center class="style24"><?php echo e($row_open_class[6]) ?></td>
              </tr>

	          <?php 	$adafile = 0; 				$jadwal_1= '';$reg_amount  ='';	$total_paid = ''; $reg_amount = ''; $reg_material = ''; $tf_amount = '';
				$baris_teacher = '';$baris_day=''; $kelas_lama = $kelas_baru;$hitungperkelas = num($hitungperkelas) +1; $urut_no = num($urut_no)+1;}} ?>
            </tbody>
	        <tfoot>
            </tfoot>
          </table>
