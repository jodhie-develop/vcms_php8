<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=vipopenclaccraw$kd_cbg$date_start$date_end.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');

if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');
$nm_sc = in_val('nm_sc', 'get');
if ($kd_cbg == 'National'){$kd_cbg = '';}

elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang'){$kd_cbg = 8;}
elseif ($kd_cbg == 'CA'){$kd_cbg = 15;}
elseif ($kd_cbg == 'East Area'){$kd_cbg = 101;}
elseif ($kd_cbg == 'JAKARTA'){$kd_cbg = 111;}
elseif ($kd_cbg == 'West Area'){$kd_cbg = 102;}
elseif ($kd_cbg == 'Online'){$kd_cbg = 100;}
elseif ($kd_cbg == 'National'){$kd_cbg = '';}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 14;}

if (num($kd_cbg) ==100){$cabang = 'Online';}
elseif ($kd_cbg ==''){$cabang = 'National';}

elseif (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang';}
elseif (num($kd_cbg) ==15){$cabang = 'CA';}
elseif (num($kd_cbg) ==111){$cabang = 'JAKARTA';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}



if($kd_cbg ==''){$filter_cbg = q_set($__p_filter_cbg, " ");}
elseif ($kd_cbg == '1000'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '1' or a.kd_branch = '2' or a.kd_branch = '3' or a.kd_branch = '4' or a.kd_branch = '5'  or a.kd_branch = '6' or a.kd_branch = '7' or a.kd_branch = '11' or a.kd_branch = '8'  )  ");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and (a.kd_branch = '1' or a.kd_branch = '2' or a.kd_branch = '3' or a.kd_branch = '4' or a.kd_branch = '5'  or a.kd_branch = '6' or a.kd_branch = '7' or a.kd_branch = '11' or a.kd_branch = '8' )";}
elseif($kd_cbg == '100'){$filter_cbg = q_set($__p_filter_cbg, " where a.kd_branch = '100' "); }

elseif ($kd_cbg == '101'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '1' or a.kd_branch = '1' or a.kd_branch = '3' or a.kd_branch = '8'  )");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '1' or a.kd_branch = '1' or a.kd_branch = '3' or a.kd_branch = '8' order by nama_detail";}
elseif ($kd_cbg == '102'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6' or a.kd_branch = '7'  )  ");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6' or a.kd_branch = '7' order by nama_detail";}
elseif ($kd_cbg == '111'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6' or a.kd_branch = '11'  )  ");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and (a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6')";}
elseif ($kd_cbg =='15') {$filter_cbg = q_set($__p_filter_cbg, " where b.nm_program = 'CA' ");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '$kd_cbg' order by nama_detail";}
elseif ($kd_cbg !='15') {$filter_cbg = q_set($__p_filter_cbg, " where  a.kd_branch = ? and b.nm_program <> 'CA' ", [(string) ($kd_cbg)]);$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '$kd_cbg' order by nama_detail";}

else {$filter_cbg = q_set($__p_filter_cbg, " where a.kd_branch = ? ", [(string) ($kd_cbg)]);$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '$kd_cbg' order by nama_detail";}
if ($filter_cbg =='') {$filter_tgl = q_set($__p_filter_tgl, " where f.min_mulai\t between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
else {$filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
if ($kelas_name !=''){$filter_kelas = q_set($__p_filter_kelas, " and a.kelas like ?  ", ["%" . (string) ($kelas_name) . "%"]);} else {$filter_kelas ='';}
$nm_sc = in_val('nm_sc', 'get');

?>
<table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td height="20" align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
              </tr>
	          <tr>
	            <td height="20" align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
              </tr>
	          <tr>
	            <td width="4%" height="20" align=center >No Month</td>
	            <td width="5%" align=center >Month</td>
	            <td width="9%" align=center >Week</td>
	            <td width="4%" align=center >No</td>
	            <td width="2%" align=center >Class</td>
	            <td width="9%" align=center >Program</td>
	            <td width="9%" align=center >Level</td>
	            <td width="9%" align=center >No by Month</td>
	            <td width="2%" align=center >No </td>
	            <td width="2%" align=center >Name</td>
	            <td width="10%" align=center >TF</td>
	            <td width="8%" align=center >Nett TFt</td>
	            <td width="9%" align=center >Discount</td>
	            <td width="4%" align=center >Tuition Paid</td>
	            <td width="5%" align=center >Tuition Refund</td>
	            <td width="10%" align=center >Reg Fee Paid</td>
	            <td width="8%" align=center >Material Book Paid</td>
	            <td width="5%" align=center >Other Refund</td>
	            <td width="6%" align=center >Total Paid</td>
	            <td width="8%" align=center >Center</td>
	            <td width="1%" align=center >SC</td>
	            <td width="1%" align=center >Incentive</td>
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
				$urut_no = 1;				$urut_no_bln = 1;
if ($nm_sc == 'All' or $nm_sc ==''){				   
$query_open_class = q_set($__p_query_open_class, "SELECT date_format(mulai_tm, '%M'),h.minggu, e.nama_lengkap, a.kelas, b.duration_program,date_format(mulai_tm,'%b %d, %Y'),g.sc,\r
g.tf, g.net_tf, g.discount,g.kd_billing,date_format(mulai_tm, '%c'),g.kd_branch,date_format(mulai_tm, '%y'),b.nm_program,a.level_program FROM ves_data.vip_teacher_schedule a\r
left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program\r
left join ves_data.vip_billing g  on a.kelas = g.kd_class\r
left join ves_data.vip_student_data e  on g.kd_biodata = e.kd_biodata\r
left join ves_data.tb_minggu_detail h  on date_format(a.mulai_tm, '%Y-%m-%d') = date_format(h.detail, '%Y-%m-%d')\r
\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai " . $filter_cbg . "  " . $filter_tgl . " " . $filter_kelas . " and a.kd_biodata = ''  and a.status_kelas = 1  \r
 group by a.kelas, e.kd_biodata order by mulai_tm", [...($__p_filter_cbg ?? []), ...($__p_filter_tgl ?? []), ...($__p_filter_kelas ?? [])]); 
}
else
{
$query_open_class = q_set($__p_query_open_class, "SELECT date_format(mulai_tm, '%M'),h.minggu, e.nama_lengkap, a.kelas, b.duration_program,date_format(mulai_tm,'%b %d, %Y'),g.sc,\r
g.tf, g.net_tf, g.discount,g.kd_billing,date_format(mulai_tm, '%c'),g.kd_branch,date_format(mulai_tm, '%y'),b.nm_program,a.level_program FROM ves_data.vip_teacher_schedule a\r
left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program\r
left join ves_data.vip_billing g  on a.kelas = g.kd_class\r
left join ves_data.vip_student_data e  on g.kd_biodata = e.kd_biodata\r
left join ves_data.tb_minggu_detail h  on date_format(a.mulai_tm, '%Y-%m-%d') = date_format(h.detail, '%Y-%m-%d')\r
\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai " . $filter_cbg . "  " . $filter_tgl . " " . $filter_kelas . " and a.kd_biodata = ''  and a.status_kelas = 1  and g.sc = ?\r
 group by a.kelas, e.kd_biodata order by mulai_tm", [...($__p_filter_cbg ?? []), ...($__p_filter_tgl ?? []), ...($__p_filter_kelas ?? []), (string) ($nm_sc)]); 	
}
/* echo $query_open_class (debug SQL versi lama) dihapus */
$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);
$keluar_open_class = db_num_rows($resource_open_class);				
if(num(db_num_rows($resource_open_class)) > 0)
	{
	while ($row_open_class  =  db_fetch($resource_open_class, PDO::FETCH_NUM))
		{
		$kelas_baru = $row_open_class[3];
		$bln_baru = $row_open_class[0];
		if($bln_lama!=$bln_baru)
			{
			$urut_no_bln = 1;
			}
		
if (num($row_open_class[12]) ==100){$cabangdisplay = 'Online';$urutcabang = 14;}
elseif ($row_open_class[12] ==''){$cabangdisplay = 'National';$urutcabang = 15;}
elseif (num($row_open_class[12]) ==1){$cabangdisplay = 'East Sby';$urutcabang = 1;}
elseif (num($row_open_class[12]) ==2){$cabangdisplay = 'West Sby';$urutcabang = 2;}
elseif (num($row_open_class[12]) ==3){$cabangdisplay = 'Denpasar';$urutcabang = 3;}
elseif (num($row_open_class[12]) ==4){$cabangdisplay = 'South Jkt';$urutcabang = 5;}
elseif (num($row_open_class[12]) ==5){$cabangdisplay = 'North Jkt';$urutcabang = 6;}
elseif (num($row_open_class[12]) ==6){$cabangdisplay = 'West Jkt';$urutcabang = 7;}
elseif (num($row_open_class[12]) ==7){$cabangdisplay = 'Bandung';$urutcabang = 8;}
elseif (num($row_open_class[12]) ==8){$cabangdisplay = 'Malang';$urutcabang = 4;}
elseif (num($row_open_class[12]) ==101){$cabangdisplay = 'East Area';$urutcabang = 17;}
elseif (num($row_open_class[12]) ==102){$cabangdisplay = 'West Area';$urutcabang = 18;}
		
		
		if ($kelas_lama  != $kelas_baru)
			{
			$hitungperkelas = 1;$angkakelas = num($angkakelas) + 1;
			if ($bln_lama != $bln_baru)
				{
				$angkakelas_bln = 1;			
				}
			else
				{
				$angkakelas_bln = num($angkakelas_bln) + 1;						
				}
			}

			

		if ($kelas_lama  != $kelas_baru and $bln_lama != $bln_baru ){$hitungperkelas_bln = 1;}else{$hitungperkelas_bln = num($hitungperkelas_bln) + 1;}
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
			$tf_amount_paid =   $row_tf[0];					
			}	
		$query_refund_tf = q_set($__p_query_refund_tf, "SELECT  sum(a.amount)  FROM vip_billing_refund a left join vip_billing_payment b on a.id_receipt = b.id_receipt where  a.kd_billing = ?   and (b.jns_payment = 'Installment 1' or b.jns_payment = 'Installment 2' or b.jns_payment = 'Installment 3' or b.jns_payment = 'Down Payment' or b.jns_payment = 'Full Payment') ", [(string) ($row_open_class[10])]); 

		$resource_refund_tf = db_query_or_die('errro_71', $query_refund_tf, $__p_query_refund_tf ?? []);
			while ($row_refund_tf=  db_fetch($resource_refund_tf, PDO::FETCH_NUM))
			{
			$refund_tf_amount =   $row_refund_tf[0];	
			}
		
		$query_refund_other = q_set($__p_query_refund_other, "SELECT  sum(a.amount)  FROM vip_billing_refund a left join vip_billing_payment b on a.id_receipt = b.id_receipt where  a.kd_billing = ?   and (b.jns_payment = 'Material' or b.jns_payment = 'Registration') ", [(string) ($row_open_class[10])]); 

		$resource_refund_other = db_query_or_die('errro_71', $query_refund_other, $__p_query_refund_other ?? []);
			while ($row_refund_other=  db_fetch($resource_refund_other, PDO::FETCH_NUM))
			{
			$refund_other_amount =   $row_refund_other[0];	
			}
		$query_incentive = q_set($__p_query_incentive, "SELECT  nominal,date_format(a.paid_date, '%Y-%m-%d')  FROM ve_incentive a where  a.kd_billing = ? and a.paid_by <>''", [(string) ($row_open_class[10])]);
		$resource_incentive = db_query_or_die('errro_7331', $query_incentive, $__p_query_incentive ?? []);
			while ($row_incentive =  db_fetch($resource_incentive, PDO::FETCH_NUM))
			{
			$incentive = $row_incentive[0];
			$paid_date = $row_incentive[1];				
			}			
		$tf_amount = num($tf_amount) - num($refund_tf_amount);
		$total_paid = num($reg_amount)  +num($reg_material) + num($tf_amount) - num($refund_amount_tf) - num($refund_other_amount);
		
		$tot_reg_amount_bln =   num($tot_reg_amount_bln) + num($reg_amount);$ttl_incentive =   num($ttl_incentive) + num($incentive);
		$tf = $row_open_class[7]; 
		$tot_tf_bln =   num($tot_tf_bln) + num($tf);
		
		$tf_netto = $row_open_class[8]; 
		$tot_tf_netto_bln =   num($tot_tf_netto_bln) + num($tf_netto);
		
		$tot_refund_other_amount_bln = num($tot_refund_other_amount_bln) + num($refund_other_amount);
		
		$tot_total_paid_bln =   num($tot_total_paid_bln) + num($total_paid);
		$tot_tf_amount_paid_bln = num($tot_tf_amount_paid_bln) + num($tf_amount_paid);
		$tot_reg_material_bln = num($tot_reg_material_bln) + num($reg_material);

		if ($bln_lama !='')
		{
		if($bln_lama == $bln_baru)
			{

			$tot_reg_amount_bln_tampil =  $tot_reg_amount_bln ; 
			$tot_tf_bln_tampil =  $tot_tf_bln ; 
			$tot_tf_netto_bln_tampil = $tot_tf_netto_bln;
			$tot_tf_amount_paid_bln_tampil = $tot_tf_amount_paid_bln;
			$tot_reg_material_bln_tampil = $tot_reg_material_bln;
			$tot_refund_other_amount_bln_tampil =  $tot_refund_other_amount_bln ;
			//$tot_total_paid_bln_tampil =   $tot_total_paid_bln ;	
			$angkakelas_bln_tampil = $angkakelas_bln;
			$tot_total_paid_bln_tampil =   num($tot_reg_amount_bln_tampil) + num($tot_tf_amount_paid_bln_tampil) + num($tot_reg_material_bln_tampil) ;
			}
		else
			{
						$bln_tampil = $bln_lama;
			$tot_reg_amount_bln =$reg_amount;
			$tot_tf_bln = $tf;
			$tot_tf_netto_bln = $tf_netto;
			$tot_tf_amount_paid_bln = $tf_amount_paid;
			$tot_reg_material_bln = $reg_material ;
			$tot_refund_other_amount_bln_tampil =  $refund_other_amount ;
			//$tot_total_paid_bln_tampil =    $total_paid;	
			$angkakelas_bln_tampil =  num($angkakelas_bln_tampil) + num($angkakelas_bln);			
			$tot_total_paid_bln_tampil =   num($tot_reg_amount_bln) + num($tot_tf_amount_paid_bln) + num($tot_reg_material_bln) ;			
			}
		}
	?>
<?php if($bln_lama != $bln_baru)
		{
		if($kd_bln != ''){
?>	
<?php  } $kd_bln = num($kd_bln)+1;	} ?>
<?php if (num($hitungperkelas) ==1){?>
<?php } ?>  

	          <tr>
	            <td height="20" align=center class="style24"><?php echo  e($row_open_class[11])  ?></td>
	            <td height="20" align=center class="style24"><?php echo  e($row_open_class[0])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[1])  ?></td>
	            <td align=center class="style24"><?php echo e($urut_no) ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[3])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[14])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[15])  ?></td>
	            <td align=center class="style24"><?php echo e($urut_no_bln) ?></td>
	            <td align=left class="style24"><?php echo e($hitungperkelas) ?></td>
	            <td align=left class="style24"><?php echo  e($row_open_class[2])  ?></td>
	            <td align=center class="style24"><?php echo e($row_open_class[7]) ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[8]) ?></td>
	            <td align=center class="style24"><?php echo e($row_open_class[9]) ?></td>
	            <td align=center class="style24"><?php echo  e($tf_amount)    ?></td>
	            <td align=center class="style24"><?php echo e($refund_tf_amount)  ?></td>
	            <td align=center class="style24"><?php echo  e($reg_amount)   ?><br></td>
	            <td align=center class="style24"><?php echo  e($reg_material) ?></td>
	            <td align=center class="style24"><?php echo  e($refund_other_amount) ?></td>
	            <td align=center class="style24"><?php echo  e($total_paid)   ?></td>
	            <td align=center class="style24"><?php echo e($urutcabang) ?> <?php echo e($cabangdisplay) ?></td>
	            <td align=center class="style24"><?php echo e($row_open_class[6]) ?></td>
	            <td align=center class="style24">&nbsp;</td>
              </tr>

	          <?php 	$adafile = 0; 
		$grand_total_tf = num($grand_total_tf) +num($tf);
		$grand_total_tf_netto = num($grand_total_tf_netto)+num($tf_netto);
		$grand_total_reg_amount = num($grand_total_reg_amount) +num($reg_amount);	
		$grand_total_total_paid = num($grand_total_total_paid)+ num($total_paid);
		$grand_total_reg_amount = num($grand_total_reg_amount) +num($reg_amount); 
		$grand_total_reg_material= num($grand_total_reg_material)+num($reg_material); 
		$grand_total_tf_amount = num($grand_total_tf_amount) +num($tf_amount);
		$jadwal_1= '';$reg_amount  ='';	$total_paid = ''; $reg_amount = ''; $reg_material = ''; $tf_amount = '';
				$baris_teacher = '';$baris_day=''; $kelas_lama = $kelas_baru;$bln_lama  = $bln_baru; $hitungperkelas = num($hitungperkelas) +1; $urut_no = num($urut_no)+1;$urut_no_bln_tot = $urut_no_bln;$urut_no_bln = num($urut_no_bln)+1;		$bln_lama_tampil = $row_open_class[0];
   }} ?>				

            </tbody>
	        <tfoot>
            </tfoot>
          </table>
