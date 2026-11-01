<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=opencl$kd_cbg$date_start$date_end.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
$date_start = in_val('date_start', 'get');$date_end = in_val('date_end', 'get');$kd_cbg=in_val('kd_cbg', 'get');
if( $kd_cbg ==''){$filter_cbg = q_set($__p_filter_cbg, " ");}
elseif ($kd_cbg == '111'){$filter_cbg = q_set($__p_filter_cbg, " where (kd_branch = '1' or kd_branch = '2' or kd_branch = '3' or kd_branch = '4' or kd_branch = '5' or kd_branch = '6' or kd_branch = '7' or kd_branch = '8' or kd_branch = '11' or kd_branch = '12'  or kd_branch = '100'  )  ");}
elseif ($kd_cbg == '101'){$filter_cbg = q_set($__p_filter_cbg, " where (kd_branch = '1' or kd_branch = '2' or kd_branch = '3' or kd_branch = '8'  )  ");}
elseif ($kd_cbg == '102'){$filter_cbg = q_set($__p_filter_cbg, " where (kd_branch = '4' or kd_branch = '5' or kd_branch = '6' or kd_branch = '7'  )  ");}
else {$filter_cbg = q_set($__p_filter_cbg, " where kd_branch = ? ", [(string) ($kd_cbg)]);}
if ($filter_cbg =='') {$filter_tgl = q_set($__p_filter_tgl, " where mulai_tm between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
else {$filter_tgl = q_set($__p_filter_tgl, " and mulai_tm between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
if ($filter_cbg =='' and $kelas_name !='') {$filter_cari =  " where a.kelas like '$kelas_name%' ";}
else {$filter_cari =  " and a.kelas like '$kelas_name%' ";}
?>
	      <table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td width=12% align=center >Class Code Opened</td>
	            <td width=7% height="14" align=center >Program &amp; Level</td>
	            <td width="12%" align=center >Class Period</td>
	            <td width="11%" align=center >Time Schedule &amp; Teacher</td>
	            <td width="5%" align=center >Student</td>
              </tr>
            </thead>

	        <tbody>
	          <?php	
	$adafile = 0;

$query_open_class = q_set($__p_query_open_class, "SELECT a.kelas, a.kode_program, b.nm_program, b.level_program,type_program,min(mulai_tm) as mulai,\r
max(selesai_tm) as selesai,date_format(min(mulai_tm),'%b %d, %Y') as tampil_mulai, date_format(max(selesai_tm),'%b %d, %Y') as tampil_selesai,b.kd_program,kd_branch,type_kelas  \r
FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg b on a.kode_program  = b.kd_program and a.level_program = b.level_program " . $filter_cbg . "  " . $filter_tgl . " and (a.status_kelas = 1 or a.status_kelas = 11)\r
 group by a.kelas order by min(mulai_tm) desc", [...($__p_filter_cbg ?? []), ...($__p_filter_tgl ?? [])]); 


$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);
$keluar_open_class = db_num_rows($resource_open_class);				
if(num(db_num_rows($resource_open_class)) > 0)
	{
	while ($row_open_class  =  db_fetch($resource_open_class, PDO::FETCH_NUM))
		{
		$query_jml_murid = q_set($__p_query_jml_murid, "SELECT count(kd_billing) as jml FROM ves_data.vip_billing where kd_class= ? ", [(string) ($row_open_class[0])]);

		$resource_jml_murid = db_query_soft($query_jml_murid, $__p_query_jml_murid ?? []);
		$keluar_jml_murid = db_num_rows($resource_jml_murid);				
		if(num(db_num_rows($resource_jml_murid)) > 0)
			{
			while ($row_jml_murid  =  db_fetch($resource_jml_murid, PDO::FETCH_NUM))
				{	
				$jml_murid = $row_jml_murid[0];
				}
			}
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
		$query_scope = q_set($__p_query_scope, "SELECT namafile, lokasifile FROM vip_ssq where  kode_program = ? ", [(string) ($row_open_class[1])]);
		$resource_scope = db_query_soft($query_scope, $__p_query_scope ?? []);		
		if(num(db_num_rows($resource_scope)) > 0)
			{
			while ($row_scope  =  db_fetch($resource_scope, PDO::FETCH_NUM))
				{
				$adafile= 1;
				$nmfile = $row_scope[0];					
				$lokasifile = "/vcms/$row_scope[1]";										
				}
			}	
		$query_time_teacher = q_set($__p_query_time_teacher, "select date_format(mulai_tm, '%a'),  date_format(mulai_tm, '%H:%i'),date_format(selesai_tm, '%H:%i'),nm_teacher from vip_teacher_schedule where kelas = ? group by date_format(mulai_tm, '%a'), nm_teacher", [(string) ($row_open_class[0])]);
		$resource_time_teacher = db_query_soft($query_time_teacher, $__p_query_time_teacher ?? []);		
		if(num(db_num_rows($resource_time_teacher)) > 0)
			{
			while ($row_time_teacher  =  db_fetch($resource_time_teacher, PDO::FETCH_NUM))
				{
				$jadwal_1= e($row_time_teacher[0]) . " (" . e($row_time_teacher[1]) . "-" . e($row_time_teacher[2]) . ") - " . e($row_time_teacher[3]) . "<br>";
				$baris_jadwal = "$baris_jadwal $jadwal_1";	
				}
			}			
			
			
			
	?>
	          <tr>
				  <td align=center class="style24"><?php echo  e($row_open_class[0])  ?> 
            <?php if ($kd_cbg =='100' or num($kd_cbg) == 101 or num($kd_cbg) == 102 or $kd_cbg == '') {  ?>(<?php echo  e($row_open_class[10])  ?>) <?php } ?><br>
<?php echo  e($row_open_class[11])  ?> 
</td>
	            <td height="14" align=center class="style24"><?php echo  e($row_open_class[2])  ?> <?php echo  e($row_open_class[3])  ?> - <?php echo  e($row_open_class[4])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[7])  ?> - <?php echo  e($kelas_selesai)  ?></td>
	            <td align=center class="style24"><?php echo e($baris_jadwal) ?></td>
	            <td align=center class="style24"><?php echo  e($jml_murid)  ?></td>
              </tr>
	          <?php 	$adafile = 0; 				$jadwal_1= '';
				$baris_jadwal = ''; 
				$nmfile ='';					
				$lokasifile = '';}} ?>
            </tbody>
	        <tfoot>
            </tfoot>
          </table>
