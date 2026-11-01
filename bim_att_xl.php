<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
$class = in_val('cl', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
$bulanan=date("M");
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=attd$class$hari$bulan$tahun.xls");
include __DIR__ . "/conndb.php";
?>
<p>STUDENT'S ATTENDANCE</p>
<table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>		
	          <tr>
	            <td width=14% height="14" align=left >No</td>
	            <td width=64% align=center ><?php echo e($nama_student)  ?></td>

<?php 
$query_tgl_p1 = q_set($__p_query_tgl_p1, "select date_format(mulai_tm, '%d-%b-%y'),mulai_tm from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm", [(string) ($class)]);
$resource_tgl_p1 = db_query_or_die('errro_0', $query_tgl_p1, $__p_query_tgl_p1 ?? []);
if(num(db_num_rows($resource_tgl_p1)) > 0)
	{
	while ($row_tgl_p1=  db_fetch($resource_tgl_p1, PDO::FETCH_NUM))
	{$tgl_p1 = $row_tgl_p1[0];$tgl_meeting = $row_tgl_p1[1];	
//$batas = 48; $a = 1;
//for($i=1;$i<=$batas;$i++) {
?>
	            <td width=18% align=center ><?php echo e($tgl_p1) ?></td>
<?php }} ?>				  
	            <td width="2%" align=center >Ttl</td>
	            <td width="2%" align=center >%</td>
			
				</tr>
				
	</thead>
	        <tbody>
<?php	
				$no_urut = 1;
$query_kelas = q_set($__p_query_kelas, "select kelas from vip_teacher_schedule where kelas = ? and status_kelas = 1 group by kelas order by kelas", [(string) ($class)]);				
$resource_kelas = db_query_or_die('errro_0', $query_kelas, $__p_query_kelas ?? []);
if(num(db_num_rows($resource_kelas)) > 0)
	{
	while ($row_kelas=  db_fetch($resource_kelas, PDO::FETCH_NUM))
		{
		$no_student = 1;
		$kode_kelas = $row_kelas[0];
		$query_student = q_set($__p_query_student, "select a.kd_biodata, nama_lengkap from ves_data.vip_billing a left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata where a.kd_class = ? order by nama_lengkap", [(string) ($kode_kelas)]);
		$resource_student = db_query_or_die('errro_0', $query_student, $__p_query_student ?? []);
		if(num(db_num_rows($resource_student)) > 0)
			{
			while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
				{	
				$kode_student = $row_student[0];
				$nama_student = $row_student[1];
				if($kode_kelas_lama != $kode_kelas){$gb = 1;}else{$gb=0;}
	?>			
	          <tr>
	            <td width=14% height="14" align=left ><?php echo e($no_urut) ?></td>
	            <td width=64% align=left ><?php echo e($nama_student)  ?></td>

<?php 	
$query_tgl_p1 = q_set($__p_query_tgl_p1, "select date_format(mulai_tm, '%d-%b-%y'),mulai_tm from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm ", [(string) ($class)]);
$resource_tgl_p1 = db_query_or_die('errro_0', $query_tgl_p1, $__p_query_tgl_p1 ?? []);
if(num(db_num_rows($resource_tgl_p1)) > 0)
	{
	while ($row_tgl_p1=  db_fetch($resource_tgl_p1, PDO::FETCH_NUM))
	{$tgl_p1 = $row_tgl_p1[0];$tgl_meeting = $row_tgl_p1[1];
	$query_hadir = q_set($__p_query_hadir, "SELECT st_attendance FROM vip_attendance where kd_class like ? and kd_biodata = ? and dt_meeting =  ? ", [(string) ($kode_kelas), (string) ($kode_student), (string) ($tgl_meeting)]);
	$resource_hadir = db_query_or_die('errro_0', $query_hadir, $__p_query_hadir ?? []);
	if(num(db_num_rows($resource_hadir)) > 0)
		{$hdr = 1;}else{$hdr = '';}		
//$batas = 48; $a = 1;
//for($i=1;$i<=$batas;$i++) {
?>
	            <td width=18% align=center ><?php echo e($hdr) ?></td>
<?php }} ?>				  
	            <td width="2%" align=center >&nbsp;</td>
	            <td width="2%" align=center >&nbsp;</td>
			
				</tr>
<?php $no_urut = num($no_urut)+1; } } }}?>				
	          <tr>
	            <td height="14" align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
              </tr>
	          <tr>
	            <td height="14" align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
              </tr>
  </tbody>
	        <tfoot>
  </tfoot>
</table>
