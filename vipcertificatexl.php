<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=vipcert$date_start$date_end.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
$cd_cl = in_val('cd_cl', 'get');
$progress = in_val('progress', 'get');
$Listed = in_val('Listed', 'get');

$query_file = q_set($__p_query_file, "SELECT m.nama_file FROM mst_signature m");

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
if(num(db_num_rows($resource_file)) > 0)
{	
		$adattd = 1; 
}


if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kelompok = $_SESSION['kelompok'];
$kd_staff = $_SESSION['kd_staff'] ;
$flt_name = in_val('flt_name', 'get');
$flt_code = in_val('flt_code', 'get');




?>

<table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td height="14" align=center >Branch</td>
	            <td align=center >Student Name</td>
	            <td align=center >Program - Class Code</td>
	            <td colspan="6" align=center >Placement Test Score</td>
	            <td colspan="6" align=center >Final Test</td>
	            <td colspan="3" align=center >Attendance</td>

              </tr>
	          <tr>
	            <td width=6% height="14" align=center >&nbsp;</td>
	            <td width="17%" align=center >&nbsp;</td>
	            <td width="17%" align=center >&nbsp;</td>
	            <td width="1%" align=center >L</td>
	            <td width="2%" align=center >R</td>
	            <td width="2%" align=center >W</td>
	            <td width="2%" align=center >Sp</td>
	            <td width="2%" align=center >St</td>
	            <td width="3%" align=center >Overall</td>
	            <td width="1%" align=center >L</td>
	            <td width="2%" align=center >R</td>
	            <td width="2%" align=center >W</td>
	            <td width="2%" align=center >Sp</td>
	            <td width="2%" align=center >St</td>
	            <td width="2%" align=center >Overall</td>
	            <td colspan="2" align=center >Class</td>
	            <td width="3%" align=center >&nbsp;</td>

              </tr>
            </thead>

	   
	          <?php	 

	$query_open_class = q_set($__p_query_open_class, "SELECT a.kd_biodata,b.kd_class, a.kd_branch, a.nama_lengkap, b.kd_program FROM ves_data.vip_kd_certificate c\r
left join ves_data.vip_student_data a on c.kd_biodata = a.kd_biodata left join ves_data.vip_billing b on c.kd_biodata = b.kd_biodata\r
where namafile <>'' group by c.kd_biodata,c.kode_kelas order by tgl_cetak desc");

			  

$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);
$keluar_open_class = db_num_rows($resource_open_class);				
if(num(db_num_rows($resource_open_class)) > 0)
	{
	while ($row_open_class  =  db_fetch($resource_open_class, PDO::FETCH_NUM))
		{
		//===selesai===
		$nama_lengkap_student = $row_open_class[3];
		$kode_class = $row_open_class[1];
		$kd_biodata = $row_open_class[0];
		$kode_cabang = $row_open_class[2];
if (num($kode_cabang) ==1){$cabang = 'East Sby';}
elseif (num($kode_cabang) ==2){$cabang = 'West Sby';}
elseif (num($kode_cabang) ==3){$cabang = 'Denpasar';}
elseif (num($kode_cabang) ==4){$cabang = 'South Jkt';}
elseif (num($kode_cabang) ==5){$cabang = 'North Jkt';}
elseif (num($kode_cabang) ==6){$cabang = 'West Jkt';}
elseif (num($kode_cabang) ==7){$cabang = 'Bandung';}
elseif (num($kode_cabang) ==8){$cabang = 'Malang TBI';}
elseif (num($kode_cabang) ==9){$cabang = 'Bandung TBI';}
elseif (num($kode_cabang) ==10){$cabang = 'Bali TBI';}
elseif (num($kode_cabang) ==100){$cabang = 'National';}
elseif (num($kode_cabang) ==11){$cabang = 'PIK';}		
else {$cabang = $kode_cabang;}				
		$kode_program = $row_open_class[4];
		
		
		
		

		//===score placement
		$query_score = q_set($__p_query_score, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '1' order by test_date desc limit 1", [(string) ($kd_biodata), (string) ($kode_class)]);
		$resource_score = db_query_soft($query_score, $__p_query_score ?? []);
		if(num(db_num_rows($resource_score)) > 0)
			{
			while ($row_score  =  db_fetch($resource_score, PDO::FETCH_NUM))	
				{
				$l = $row_score[0];	
				$st = $row_score[1];	
				$sp = $row_score[2];	
				$r = $row_score[3];	
				$w = $row_score[4];						

				$ttl = $row_score[5];
				$nomor_pt = $row_score[6];						
				$adascore = 1;
				}
			}
		else
			{
		$query_score = q_set($__p_query_score, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no,test_date FROM ves_inc.tb_acd_history t where t.kd_biodata =  ? and t.kd_biodata <>'' order by no desc limit 1", [(string) ($kd_biodata)]);
		$resource_score = db_query_soft($query_score, $__p_query_score ?? []);
		$keluar_score = db_num_rows($resource_score);	
		if(num(db_num_rows($resource_score)) > 0)
			{
			while ($row_score  =  db_fetch($resource_score, PDO::FETCH_NUM))	
				{
				$l = $row_score[0];	
				$st = $row_score[1];	
				$sp = $row_score[2];	
				$r = $row_score[3];	
				$w = $row_score[4];						
				$ttl = $row_score[5];
				$nomor_pt = $row_score[6];	
				$test_date = $row_score[7];				
				$adascore = 1;
				}
			}
			
			}

		//===score mid	
		$query_score_mid = q_set($__p_query_score_mid, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '2' order by test_date desc limit 1", [(string) ($kd_biodata), (string) ($kode_class)]);
		$resource_score_mid = db_query_soft($query_score_mid, $__p_query_score_mid ?? []);
		$keluar_score_mid = db_num_rows($resource_score_mid);	
		if(num(db_num_rows($resource_score_mid)) > 0)
			{
			while ($row_score_mid  =  db_fetch($resource_score_mid, PDO::FETCH_NUM))	
				{
				$l_mid = $row_score_mid[0];	
				$st_mid = $row_score_mid[1];	
				$sp_mid = $row_score_mid[2];	
				$r_mid = $row_score_mid[3];	
				$w_mid = $row_score_mid[4];						
				$ttl_mid = $row_score_mid[5];
				$nomor_mid = $row_score_mid[6];	
				$adascore_mid = 1;
				}
			}
		$query_score_final = q_set($__p_query_score_final, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1", [(string) ($kd_biodata), (string) ($kode_class)]);
		$resource_score_final = db_query_soft($query_score_final, $__p_query_score_final ?? []);
		$keluar_score_final = db_num_rows($resource_score_final);	
		if(num(db_num_rows($resource_score_final)) > 0)
			{
			while ($row_score_final  =  db_fetch($resource_score_final, PDO::FETCH_NUM))	
				{
				$l_final = $row_score_final[0];	
				$st_final = $row_score_final[1];	
				$sp_final = $row_score_final[2];	
				$r_final = $row_score_final[3];	
				$w_final = $row_score_final[4];						
				$ttl_final = $row_score_final[5];
				$nomor_final = $row_score_final[6];						
				$adascore_final = 1;
				}
			}		
		//====================
		$query_last_date = q_set($__p_query_last_date, "SELECT max(mulai_tm) as selesai,date_format(max(mulai_tm),'%b %d, %Y') FROM ves_data.vip_teacher_schedule a where a.kelas = ? ", [(string) ($row_open_class[0])]);
		$resource_last_date = db_query_soft($query_last_date, $__p_query_last_date ?? []);
		$keluar_last_date = db_num_rows($resource_last_date);				
		if(num(db_num_rows($resource_last_date)) > 0)
			{
			while ($row_last_date  =  db_fetch($resource_last_date, PDO::FETCH_NUM))
				{
				$kelas_selesai = $row_last_date[1];					
				}
			}
		//=kehadiran
		$query_hadir = q_set($__p_query_hadir, "SELECT sum(st_attendance) FROM vip_attendance v where kd_biodata = ? and kd_class = ? ", [(string) ($kd_biodata), (string) ($kode_class)]);
		$resource_hadir = db_query_soft($query_hadir, $__p_query_hadir ?? []);		
		if(num(db_num_rows($resource_hadir)) > 0)
			{
			while ($row_hadir  =  db_fetch($resource_hadir, PDO::FETCH_NUM))
				{
				$kehadiran= $row_hadir[0];
				}
			}	
$query_selesai = q_set($__p_query_selesai, "SELECT count(distinct mulai_tm) FROM ves_data.vip_teacher_schedule   where kelas= ? and status_kelas = 1 ", [(string) ($kode_class)]);

		$resource_selesai = db_query_soft($query_selesai, $__p_query_selesai ?? []);			
		if(num(db_num_rows($resource_selesai)) > 0)
			{
			while ($row_selesai  =  db_fetch($resource_selesai, PDO::FETCH_NUM))
				{	
				$jml_kelas = $row_selesai[0];
				}
			}		
		$presen_hadir = num((div($kehadiran, $jml_kelas)))*100;
		//==
$query_certificate = q_set($__p_query_certificate, "SELECT kd_biodata, namafile FROM vip_kd_certificate where kd_biodata = ? and kode_kelas = ? ", [(string) ($kd_biodata), (string) ($kode_class)]);

		$resource_certificate = db_query_soft($query_certificate, $__p_query_certificate ?? []);			
		$cert_ada = db_num_rows($resource_certificate) ;
		if(num(db_num_rows($resource_certificate)) > 0)
			{
			while ($row_cert  =  db_fetch($resource_certificate, PDO::FETCH_NUM))
				{	
				$namafile = $row_cert[1];
				if ($namafile !='')
					{
					$st_certificate =2;
					$textlink = "http://allspark.vistaeducation.com/vcms/ecert/ecertbimvista2022.php?kdb=$kd_biodata&kc=$kode_class";
					}
				else
					{
					$st_certificate =1;
					}
				}
			}
		else
				{
				$st_certificate = 0;
				}
			
	?>     <tbody>
	          <tr>
	            <td height="14" align=center class="style24" <?php echo e($warna) ?>><?php echo  e($cabang)  ?></td>
	            <td align=left class="style24" <?php echo e($warna) ?>><?php echo  e($nama_lengkap_student)  ?></td>
			    <td align=left class="style24" <?php echo e($warna) ?>><?php echo  e($kode_class)  ?><br></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($l)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($r)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($w)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($sp)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($st)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($ttl)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($l_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($r_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($w_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($sp_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($st_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($ttl_final)  ?></td>
	            <td width="4%" align=center class="style24"<?php echo e($warna) ?>><?php echo  e($kehadiran)  ?>/<?php echo  e($jml_kelas)  ?></td>
	            <td width="4%" align=center class="style24"<?php echo e($warna) ?>><?php echo  round(num($presen_hadir),2)  ?> % </td>
	            <td align=center class="style24"<?php echo e($warna) ?>>&nbsp;</td>

	          <?php 	$adafile = 0; 				$jadwal_1= '';
				$baris_jadwal = ''; 
				$nmfile ='';					
				$lokasifile = '';$baris_teacher ='';$l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';$tgl_la = '';		$tgl_tutor = '';$tgl_lc='';$tgl_ext = '';$kd_st = 4 ; $nama_lengkap_student  ='';}} ?></tr>
            </tbody>
	  
	        <tfoot>
            </tfoot>
          </table>
