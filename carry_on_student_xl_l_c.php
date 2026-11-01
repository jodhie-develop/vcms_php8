<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=carry_on_student_LC.xls");
include __DIR__ . "/conndb.php";

$kd_cbg = in_val('kdc', 'get');
$q = in_val('q', 'get');
$sales_period = in_val('sp', 'get');
$ls = in_val('ls', 'get');

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
if (num($kd_cbg) ==11){$cabang = 'PIK';}
if (num($kd_cbg) ==100){$cabang = 'National';}
if ($kd_cbg ==''){$cabang = '--ALL-';}
if ($sales_period ==''){$sales_period = '2018';}
if ($ls ==''){$ls = 'ALL';}
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;

$adm_period = $sales_period;
$carryon_1 = num($sales_period) + 1;
$carryon_2 = num($sales_period) + 2;
$carryon_3 = num($sales_period) + 3;
$carryon_4 = num($sales_period) + 4;
$carryon_5 = num($sales_period) + 5;
$carryon_6 = num($sales_period) + 6;
$carryon_7 = num($sales_period) + 7;
$carryon_8 = num($sales_period) + 8;
$thn_now = 2021;


?>
<?php	
$angka = 1 ;
$kolom = 1;
if($sales_period == '2021'){		  
$query_sales = q_set($__p_query_sales, "select nama, country, school, enroll_date, pic,  kd_biodata,tgl_intake from tb_sales_report a left join tb_master_partner b on a.kd_school = b.kd_school where prioritas = 1 and status = 'OK' and enroll_date between '2021-01-01' and '2021-08-31' and kd_cabang = ? group by kd_biodata order by pic", [(string) ($kd_cbg)]);
}
else
{		  
$query_sales = q_set($__p_query_sales, "select nama, country, school, enroll_date, pic,  kd_biodata,tgl_intake from tb_sales_report a left join tb_master_partner b on a.kd_school = b.kd_school where prioritas = 1 and status = 'OK' and date_format(enroll_date, '%Y') = ? and kd_cabang = ? group by kd_biodata order by pic", [(string) ($sales_period), (string) ($kd_cbg)]);
}


$resource_sales = db_query_or_die('error_sales', $query_sales, $__p_query_sales ?? []);				
?>
<table width="100%" class="table table-bordered table-striped" id="example3">
<thead>
   <tr>
     <td height="14" colspan="17" align=center ><h2><strong>ENROLLED &amp; CARRY ON STUDENT LIST SUMMARY</strong></h2></td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
   </tr>
   <tr>
     <td height="14" colspan="17" align=center ><h3><strong>ENROLLMENT PERIOD : Jan - Dec <?php echo e($sales_period) ?></strong></h3></td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
   </tr>
   <tr>
     <td height="14" colspan="17" align=center ><h3><strong><?php echo e($cabang) ?></strong></h3></td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
   </tr>
   <tr>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
    </tr>
   <tr>
     <td width=47 align=center >No</td>
     <td width=68 align=center >SC</td>
     <td width=68 align=center >Nama</td>
     <td width=77 align=center >Country</td>
     <td width=77 align=center >Instituion</td>
     <td colspan="2" align=center >Enroll</td>
     <td height="14" colspan="3" align=center ><?php echo e($sales_period) ?></td>
     <?php if($carryon_1 <= $thn_now )	 { ?>  
     <td colspan="2" align=center ><?php echo e($carryon_1) ?></td>
     <?php if ($carryon_2 <= $thn_now)	 { ?>	   
     <td colspan="2" align=center ><?php echo e($carryon_2) ?></td>
     <?php if ($carryon_3 <= $thn_now)	 { ?>		   
     <td colspan="2" align=center ><?php echo e($carryon_3) ?></td>
     <?php if ($carryon_4 <= $thn_now)	 { ?>		   
     <td colspan="2" align=center ><?php echo e($carryon_4) ?></td>
     <?php if ($carryon_5 <= $thn_now)	 { ?>		 
     <td colspan="2" align=center ><?php echo e($carryon_5) ?></td>
     <?php if ($carryon_6 <= $thn_now)	 { ?>	   
     <td colspan="2" align=center ><?php echo e($carryon_6) ?></td>
     <?php if ($carryon_7 <= $thn_now)	 { ?>	   
     <td colspan="2" align=center ><?php echo e($carryon_7) ?></td>
     <?php if ($carryon_8 <= $thn_now)	 { ?>	   
     <td colspan="2" align=center ><?php echo e($carryon_8) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
     <?php }}}}}}}}?>	   
     <td colspan="4" align=center >FINAL STATUS</td>
     </tr>
   <tr>
     <td width=47 height="14" align=center >&nbsp;</td>
     <td width=68 align=center >&nbsp;</td>
     <td width=68 align=center >&nbsp;</td>
     <td width=77 align=center >&nbsp;</td>
     <td width=77 align=center >&nbsp;</td>
     <td align=center >&nbsp;</td>
     <td align=center >&nbsp;</td>
     <td width="69" rowspan="2" align=center >ON</td>
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <?php if($carryon_1 <= $thn_now )	 { ?>  	   
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <?php if($carryon_2 <= $thn_now )	 { ?>  	   
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <?php if($carryon_3 <= $thn_now )	 { ?>  	   
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <?php if($carryon_4 <= $thn_now )	 { ?>  	   
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <?php if($carryon_5 <= $thn_now )	 { ?>  		   
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <?php if($carryon_6 <= $thn_now )	 { ?>  	
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <?php if($carryon_7 <= $thn_now )	 { ?>  		   
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <?php if($carryon_8 <= $thn_now )	 { ?>  		   
     <td width="68" rowspan="2" align=center >C</td>
     <td width="70" rowspan="2" align=center >L</td>
     <td  bgcolor="#DFDFDF" ></td>
     <?php }}}}}}}} ?>		   
     <td rowspan="2" align=center >PR</td>
     <td rowspan="2" align=center >ON</td>
     <td rowspan="2" align=center >C</td>
     <td rowspan="2" align=center >L</td>
   
	   
     </tr>
   <tr>
     <td width=47 align=center >&nbsp;</td>
     <td width=68 align=center >&nbsp;</td>
     <td width=68 align=center >&nbsp;</td>
     <td width=77 align=center >&nbsp;</td>
     <td width=77 align=center >&nbsp;</td>
     <td width="71" align=center >Enroll Date </td>
     <td width=70 height="14" align=center >Intake</td>
     <?php if($carryon_1 <= $thn_now )	 { ?>  	  	   
     <?php if($carryon_2 <= $thn_now )	 { ?>  	  		 
     <?php if($carryon_3 <= $thn_now )	 { ?> 	   
     <?php if($carryon_4 <= $thn_now )	 { ?> 	   
     <?php if($carryon_5 <= $thn_now )	 { ?> 	   
	   
     <?php if($carryon_6 <= $thn_now )	 { ?> 	   
	   
     <?php if($carryon_7 <= $thn_now )	 { ?> 	   
     <?php if($carryon_8 <= $thn_now )	 { ?> 	   
		 
     <td  bgcolor="#DFDFDF" ></td>
     <?php }}}}}}}} ?>	   
     </tr>
</thead>
<tbody>
<?php 
if(num(db_num_rows($resource_sales)) > 0)
	{ 
	while ($row_sales = db_fetch($resource_sales))
		{
		$final_on = 1;
		$ttl_sales = num($ttl_sales) + 1;
		$jalan = '  bgcolor="#D6CBF9"';
		$jalan_cancel = '  bgcolor="#FFF72B"';
		$jalan_leaving = '  bgcolor="#08F00D"';
		
		$jalan_problem = '  bgcolor="#FF0E0E"';
		
		$berhenti = '';
		$st_progress = '1';
		$st_on_awal = 1 ;
		$on_y0 = $st_on_awal;
		$on_y1 = $st_on_awal;
		$on_y2 = $st_on_awal;
		$on_y3 = $st_on_awal;
		$on_y4 = $st_on_awal;
		$on_y5 = $st_on_awal;
		$on_y6 = $st_on_awal;
		$on_y7 = $st_on_awal;
		$on_y8 = $st_on_awal;
		
		$on_y0_next = $st_on_awal;
		$on_y1_next = $st_on_awal;
		$on_y2_next = $st_on_awal;
		$on_y3_next = $st_on_awal;
		$on_y4_next = $st_on_awal;
		$on_y5_next = $st_on_awal;			
		$on_y6_next = $st_on_awal;			
		$on_y7_next = $st_on_awal;			
		$on_y8_next = $st_on_awal;			
		
		$nama = $row_sales[0];
		$dest_country = $row_sales[1];		
		$dest_School = $row_sales[2];
		$enroll_date = $row_sales[3];
		$kd_biodata = $row_sales[5];
		$sc  = $row_sales[4];
		$tgl_intake = $row_admin[8];		
		$query_last = q_set($__p_query_last, "select max(no) from adm_stu_progress where kd_biodata = ? and date_format(enroll_date,'%Y') = ? ", [(string) ($kd_biodata), (string) ($sales_period)]); 
		$resource_last = db_query_or_die('errro_2', $query_last, $__p_query_last ?? []);

		if(num(db_num_rows($resource_last)) > 0)
			{ 
			while ($row_last = db_fetch($resource_last))
				{
				$no_terakhir = $row_last[0];
				}
			}
		$query_admin = q_set($__p_query_admin, "select dest_country, dest_school, final_status, comm_date, update_date, step,tgl_intake, date_format(comm_date, '%Y'), tgl_intake ,date_format(update_date,'%Y'),no from adm_stu_progress where kd_biodata = ? and no = ? ", [(string) ($kd_biodata), (string) ($no_terakhir)]); 
		$resource_admin = db_query_or_die('errro_1', $query_admin, $__p_query_admin ?? []);
		if(num(db_num_rows($resource_admin)) > 0)
			{ 
			while ($row_admin = db_fetch($resource_admin))
				{
				$dest_country = $row_admin[0];		
				$dest_school = $row_admin[1];
				$final_status = $row_admin[2];
				$comm_date = $row_admin[3];
				$thn_comm = $row_admin[7];
				$update_date = $row_admin[4];
				$thn_update = $row_admin[9];
				$tgl_intake = $row_admin[8];
				$nomor_kode = $row_admin[10];				
				if ($final_status == 'L')
					{
					$jalan = $jalan_leaving;
					if($thn_comm == $sales_period){$l_y0 = '1';$on_y0 = num($st_on_awal) - num($l_y0);}
					elseif($thn_comm == $carryon_1){$l_y1 = '1';$on_y1 = num($st_on_awal) - num($l_y1);}
					elseif($thn_comm == $carryon_2){$l_y2 = '1';$on_y2 = num($st_on_awal) - num($l_y2);}	
					elseif($thn_comm == $carryon_3){$l_y3 = '1'; $on_y3 = num($st_on_awal) - num($l_y3);}	
					elseif($thn_comm == $carryon_4){$l_y4 = '1'; $on_y4 = num($st_on_awal) - num($l_y4);}
					elseif($thn_comm == $carryon_5){$l_y5 = '1'; $on_y5 = num($st_on_awal) - num($l_y5);}		
					elseif($thn_comm == $carryon_6){$l_y6 = '1'; $on_y6 = num($st_on_awal) - num($l_y6);}	
					elseif($thn_comm == $carryon_7){$l_y7 = '1'; $on_y7 = num($st_on_awal) - num($l_y7);}	
					elseif($thn_comm == $carryon_8){$l_y8 = '1'; $on_y8 = num($st_on_awal) - num($l_y8);}		
					$final_l = '1';$final_on = '';
					$ttl_leaving = num($ttl_leaving) + 1;
					}
				elseif ($final_status == 'C')
					{
					$jalan = $jalan_cancel;
					if($thn_update == $sales_period){$c_y0 = '1';$on_y0 = num($st_on_awal) - num($c_y0);}
					elseif($thn_update == $carryon_1){$c_y1 = '1';$on_y1 = num($st_on_awal) - num($c_y1);}
					elseif($thn_update == $carryon_2){$c_y2 = '1'; $on_y2 = num($st_on_awal) - num($c_y2);}	
					elseif($thn_update == $carryon_3){$c_y3 = '1'; $on_y3 = num($st_on_awal) - num($c_y3);}	
					elseif($thn_update == $carryon_4){$c_y4 = '1'; $on_y4 = num($st_on_awal) - num($c_y4);}
					elseif($thn_update == $carryon_5){$c_y5 = '1'; $on_y5 = num($st_on_awal) - num($c_y5);}
					elseif($thn_update == $carryon_6){$c_y6 = '1'; $on_y6 = num($st_on_awal) - num($c_y6);}
					elseif($thn_update == $carryon_7){$c_y7 = '1'; $on_y7 = num($st_on_awal) - num($c_y7);}
					elseif($thn_update == $carryon_8){$c_y8 = '1'; $on_y8 = num($st_on_awal) - num($c_y8);}
					$final_c = '1';	$final_on = '';				
										$ttl_cancel = num($ttl_cancel) + 1;
					}
				elseif ($final_status == 'PR')
					{
					$jalan = $jalan_problem;
					if($thn_update == $sales_period){$pr_y0 = '1';$on_y0 = num($st_on_awal) - num($pr_y0);}
					elseif($thn_update == $carryon_1){$pr_y1 = '1';$on_y1 = num($on_y1) - num($pr_y1);}
					elseif($thn_update == $carryon_2){$pr_y2 = '1'; $on_y2 = num($st_on_awal) - num($pr_y2);}	
					elseif($thn_update == $carryon_3){$pr_y3 = '1'; $on_y3 = num($st_on_awal) - num($pr_y3);}	
					elseif($thn_update == $carryon_4){$pr_y4 = '1'; $on_y4 = num($st_on_awal) - num($pr_y4);}
					elseif($thn_update == $carryon_5){$pr_y5 = '1'; $on_y5 = num($st_on_awal) - num($pr_y5);}		
					elseif($thn_update == $carryon_6){$pr_y6 = '1'; $on_y6 = num($st_on_awal) - num($pr_y6);}	
					elseif($thn_update == $carryon_7){$pr_y7 = '1'; $on_y7 = num($st_on_awal) - num($pr_y7);}	
					elseif($thn_update == $carryon_8){$pr_y8 = '1'; $on_y8 = num($st_on_awal) - num($pr_y8);}	
					$final_pr = '1';$final_on = '';						
										$ttl_pr = num($ttl_pr) + 1;
					}
		if (num($on_y0)==0){$on_y0_next = '';$on_y1 ='';$on_y2 ='';	$on_y3 ='';$on_y4 ='';$on_y5 ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y1_next ='';$on_y2_next  ='';	$on_y3_next  ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y1)==0){$on_y1_next = '';$on_y2 ='';	$on_y3 ='';$on_y4 ='';$on_y5 ='';$on_y1_next ='';$on_y2_next  ='';	$on_y3_next  ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y2)==0){$on_y2_next = '';$on_y3 ='';$on_y4 ='';$on_y5 ='';$on_y2_next  ='';	$on_y3_next  ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y3)==0){$on_y3_next = '';$on_y4 ='';$on_y5 ='';	$on_y3_next  ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y4)==0){$on_y4_next = '';$on_y5 ='';$on_y4_next  ='';$on_y5_next  ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y5)==0){$on_y5_next = '';$on_y5 ='';$on_y6 ='';$on_y7 ='';$on_y8 ='';$on_y6_next  ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y6)==0){$on_y6_next = '';$on_y7 ='';$on_y8 ='';$on_y7_next  ='';$on_y8_next  ='';} 
		elseif (num($on_y7)==0){$on_y7_next = '';$on_y8 ='';$on_y8_next  ='';} 
		elseif (num($on_y8)==0){$on_y8_next = '';} 				
				if (($ls =='ALL') or ($ls =='L' and $final_status == 'L') or ($ls =='C' and $final_status == 'C') or ($ls =='PROGRESS' and ($final_status == 'ON' or $final_status == 'PDO')) or ($ls =='PROBLEM' and $final_status == 'PR') or ($ls =='ON HAND' and ($final_status == 'ON' or $final_status == 'PDO'  or $final_status == 'PR'))  ){
?>		
   <tr>
     <td height="14" align=center <?php echo e($jalan) ?> ><?php echo e($angka) ?></td>
     <td <?php echo e($jalan) ?>  align=left ><?php echo e($sc) ?></td>
     <td <?php echo e($jalan) ?>  align=left ><?php echo e($nama) ?></td>
     <td <?php echo e($jalan) ?>  align=left ><?php echo e($dest_country) ?></td>
     <td <?php echo e($jalan) ?>  align=left ><?php echo e($dest_school) ?><br></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($enroll_date) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($tgl_intake) ?></td>
     <td <?php echo e($jalan) ?>  align=center ><?php echo e($st_on_awal) ?></td>
     <td  <?php echo e($jalan); if (num($c_y0) ==1){$jalan = $berhenti;} ?>  align=center ><?php echo e($c_y0) ?></td>
     <td <?php echo e($jalan); if (num($l_y0) ==1){$jalan = $berhenti;} ?> align=center ><?php echo e($l_y0) ?></td>
     <?php if($carryon_1 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan); if (num($c_y1) ==1){$jalan = $berhenti;} ?>  align=center ><?php echo e($c_y1) ?></td>
     <td  <?php echo e($jalan); if (num($l_y1) ==1){$jalan = $berhenti;} ?> align=center ><?php echo e($l_y1) ?></td>
     <?php if($carryon_2 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan); if (num($c_y2) ==1){$jalan = $berhenti;}  ?>  align=center ><?php echo e($c_y2) ?></td>
     <td <?php echo e($jalan); if (num($l_y2) ==1){$jalan = $berhenti;}  ?>  align=center ><?php echo e($l_y2) ?></td>
     <?php if($carryon_3 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y3) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y3) ?></td>
     <td  <?php echo e($jalan); if (num($l_y3) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y3) ?></td>
     <?php if($carryon_4 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y4) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y4) ?></td>
     <td  <?php echo e($jalan); if (num($l_y4) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y4) ?></td>
     <?php if($carryon_5 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y5) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y5) ?></td>
     <td  <?php echo e($jalan); if (num($l_y5) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y5) ?></td>
     <?php if($carryon_6 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y6) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y6) ?></td>
     <td  <?php echo e($jalan); if (num($l_y6) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y6) ?></td>
     <?php if($carryon_7 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y7) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y7) ?></td>
     <td  <?php echo e($jalan); if (num($l_y7) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y7) ?></td>
     <?php if($carryon_8 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y8) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($c_y8) ?></td>
     <td  <?php echo e($jalan); if (num($l_y8) ==1){$jalan = $berhenti;}  ?> align=center ><?php echo e($l_y8) ?></td>
     <td  bgcolor="#DFDFDF" ></td>
     <?php }}}}}}}} ?>	      
     <td <?php echo e($jalan) ?> align=center ><?php echo e($final_pr) ?></td>
     <td  <?php echo e($jalan) ?>align=center ><?php echo e($final_on) ?></td>
     <td <?php echo e($jalan) ?> align=center ><?php echo e($final_c) ?></td>
     <td  <?php echo e($jalan) ?>align=center ><?php echo e($final_l) ?></td>

     </tr>
<?php 
			
																	 }	$angka_terakhir = $angka ;$angka = num($angka) + 1 ;
$l_y0='';$l_y1='';$l_y2='';$l_y3='';$l_y4='';$l_y5='';$l_y6='';$l_y7='';$l_y8='';
$c_y0='';$c_y1='';$c_y2='';$c_y3='';$c_y4='';$c_y5=''; $c_y6='';$c_y7='';$c_y8='';
$pr_y0='';$pr_y1='';$pr_y2='';$pr_y3='';$pr_y4='';$pr_y5='';$pr_y6='';$pr_y7='';$pr_y8=''; 	
$on_y0='';$on_y1='';$on_y2='';$on_y3='';$on_y4='';$on_y5='';$on_y6='';$on_y7='';$on_y8='';	$final_pr ='';$final_c = '';$final_on = '';$final_l = ''; 	}}} } 
		$ttl_on = num((num($angka) - 1)) - num((num($ttl_cancel) + num($ttl_leaving) + num($ttl_pr)));		 
	?>	

   <tr>
     <td height="14" align=center <?php echo e($jalan) ?> >&nbsp;</td>
     <td <?php echo e($jalan) ?>  align=left >&nbsp;</td>
     <td <?php echo e($jalan) ?>  align=left >&nbsp;</td>
     <td <?php echo e($jalan) ?>  align=left >&nbsp;</td>
     <td <?php echo e($jalan) ?>  align=left >&nbsp;</td>
     <td <?php echo e($jalan) ?>  align=center >&nbsp;</td>
     <td <?php echo e($jalan) ?>  align=center >&nbsp;</td>
     <td <?php echo e($jalan) ?>  align=center >&nbsp;</td>
     <td  <?php echo e($jalan); if (num($c_y0) ==1){$jalan = $berhenti;} ?>  align=center >&nbsp;</td>
     <td <?php echo e($jalan); if (num($l_y0) ==1){$jalan = $berhenti;} ?> align=center >&nbsp;</td>
     <?php if($carryon_1 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan); if (num($c_y1) ==1){$jalan = $berhenti;} ?>  align=center >&nbsp;</td>
     <td  <?php echo e($jalan); if (num($l_y1) ==1){$jalan = $berhenti;} ?> align=center >&nbsp;</td>
     <?php if($carryon_2 <= $thn_now )	 { ?> 	   
     <td <?php echo e($jalan); if (num($c_y2) ==1){$jalan = $berhenti;}  ?>  align=center >&nbsp;</td>
     <td <?php echo e($jalan); if (num($l_y2) ==1){$jalan = $berhenti;}  ?>  align=center >&nbsp;</td>
     <?php if($carryon_3 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y3) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <td  <?php echo e($jalan); if (num($l_y3) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <?php if($carryon_4 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y4) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <td  <?php echo e($jalan); if (num($l_y4) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <?php if($carryon_5 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y5) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <td  <?php echo e($jalan); if (num($l_y5) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <?php if($carryon_6 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y6) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <td  <?php echo e($jalan); if (num($l_y6) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <?php if($carryon_7 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y7) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <td  <?php echo e($jalan); if (num($l_y7) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <?php if($carryon_8 <= $thn_now )	 { ?> 	   
     <td  <?php echo e($jalan); if (num($c_y8) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <td  <?php echo e($jalan); if (num($l_y8) ==1){$jalan = $berhenti;}  ?> align=center >&nbsp;</td>
     <td  bgcolor="#DFDFDF" ></td>
     <?php }}}}}}}} ?>	      
     <td <?php echo e($jalan) ?> align=center >&nbsp;</td>
     <td  <?php echo e($jalan) ?>align=center >&nbsp;</td>
     <td <?php echo e($jalan) ?> align=center >&nbsp;</td>
     <td  <?php echo e($jalan) ?>align=center >&nbsp;</td>

    </tr>
</tbody>
	        <tfoot>
            </tfoot>
          </table>
