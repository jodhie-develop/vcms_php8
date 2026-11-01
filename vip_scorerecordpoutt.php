<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 

date_default_timezone_set('UTC');
// get the HTML
ob_start();
ini_set('memory_limit', '150M');
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2017-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_val('kd_cbg', 'get');
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdcl = in_val('kdcl', 'get');
$kdprg = in_val('kdprg', 'get');
$nmprg = in_val('nmprg', 'get');

$query_nmprg = q_set($__p_query_nmprg, "select a.kode_program,b.nm_program , b.level_program, min(date_format(a.mulai_tm,'%d %b %Y')), max(date_format(mulai_tm,'%d %b %Y'))   from vip_teacher_schedule a left join vip_mst_code_prg b on a.kode_program = b.kd_program where kelas = ? group by kelas", [(string) ($kdcl)]); 
$resource_nmprg = db_query_soft($query_nmprg, $__p_query_nmprg ?? []);			
if(num(db_num_rows($resource_nmprg)) > 0)
	{
	while ($row_nmprg  =  db_fetch($resource_nmprg, PDO::FETCH_NUM))
		{
		$nmprg = $row_nmprg[1];	
		$lvprg = $row_nmprg[2];	
		$awal_kelas =  $row_nmprg[3];
		$akhir_kelas =  $row_nmprg[4];
		
		}
	}

?>

<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-size:8;	
	}
-->
.style32 {
	color:#000;
	font-size:75%;
	}
-->
</style>
 <div style="display: block; margin: 10; break-before: page; width: 290mm; height: 210mm; transform: rotate(270deg) translate(-296mm, 0);
    transform-origin: 0 0;" >

<table width="1026" border="0" cellpadding="0" cellspacing="0">
    <tr align="center">
       <td width="6" align="center"><div align="center"></div></td>
       <td width="142" align="center"><img src="images/VIP.jpg" width="87" height="65" alt=""/></td>
       <td width="626" align="center"><strong>Monitoring Class Activities</strong></td>
       <td width="20" align="center">&nbsp;</td>
       <td width="20" align="center">&nbsp;</td>
       <td width="20" align="center">&nbsp;</td>
       <td width="20" align="center">&nbsp;</td>
       <td width="20" align="center">&nbsp;</td>
       <td width="20" align="center">&nbsp;</td>
       <td width="20" align="center">&nbsp;</td>
       <td width="20" align="center">&nbsp;</td>
       <td width="20" align="center">&nbsp;</td>
       <td width="44" align="center">&nbsp;</td>
     </tr>
    <tr align="center">
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center"><strong>Program / Class : <?php echo e($nmprg) ?> <?php echo e($lvprg) ?>/<?php echo e($kdcl) ?></strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
     <tr>
       <td colspan="13"><div align="center"><span class="style2"><strong>RULES &amp; REGULATIONS REGARDING PROFESSIONAL FEE</strong></span></div></td>
     </tr>
   </table>
<table width="998" border="0" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td width="4" align="center"><div align="center"></div></td>
    <td width="125" align="center">&nbsp;</td>
    <td width="445" align="center">&nbsp;</td>
    <td width="132" align="center">&nbsp;</td>
    <td width="16" align="center">&nbsp;</td>
    <td width="16" align="center">&nbsp;</td>
    <td width="16" align="center">&nbsp;</td>
    <td width="16" align="center">&nbsp;</td>
    <td width="16" align="center">&nbsp;</td>
    <td width="16" align="center">&nbsp;</td>
    <td width="16" align="center">&nbsp;</td>
    <td width="16" align="center">&nbsp;</td>
    <td width="93" align="center">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="3" align="left">Table 1 : Summary of activities</td>
    <td colspan="10" align="right">Start - Finish Date : <?php echo e($awal_kelas) ?> - <?php echo e($akhir_kelas) ?> </td>
    </tr>
  </table>
<table width="1065" border="1" cellpadding="0" cellspacing="0">


    <tr>
       <td width="155" rowspan="2" align="center" bgcolor="#400000"><span class="style2"><strong>Student Name</strong></span><span class="style2"></span></td>
       <td colspan="5" align="center" bgcolor="#400000"><span class="style2"><strong>Placement Test</strong></span><span class="style2"></span></td>
       <td rowspan="2" align="center" bgcolor="#400000"><span class="style2"><strong>Class <br>
       Attendance</strong></span><span class="style2"></span></td>
       <td rowspan="2" align="center" bgcolor="#400000"><span class="style2"><strong>Tutorial<br>
       /LC Record</strong></span><span class="style2"></span></td>
       <td colspan="5" align="center" bgcolor="#400000"><span class="style2"><strong>Mid Test</strong></span><span class="style2"></span></td>
       <td colspan="5" align="center" bgcolor="#400000"><span class="style2"><strong>Final  Test</strong></span><span class="style2"></span></td>
       <td width="96" rowspan="2" align="center" bgcolor="#400000"><span class="style2"><strong>Score<br>
       Improvement</strong></span><span class="style2"></span></td>
    </tr>
     <tr>
       <td width="20" height="14"  align="center"  bgcolor="#400000"><span class="style2">LPT</span></td>
       <td width="20" align="center" bgcolor="#400000"><span class="style2">RPT</span></td>
       <td width="20" align="center" bgcolor="#400000"><span class="style2">SPT</span></td>
       <td width="20" align="center"  bgcolor="#400000"><span class="style2">WPT</span></td>
       <td width="20" align="center"  bgcolor="#400000"><span class="style2">TTL</span></td>
       <td width="20" align="center"  bgcolor="#400000"><span class="style2">L1</span></td>
       <td  width="20" align="center"  bgcolor="#400000"><span class="style2">R1</span></td>
       <td  width="20" align="center"  bgcolor="#400000"><span class="style2">S1</span></td>
       <td  width="20" align="center"  bgcolor="#400000"><span class="style2">W1</span></td>
       <td  width="20" align="center"  bgcolor="#400000"><span class="style2">TTL</span></td>
       <td  width="20" align="center"  bgcolor="#400000"><span class="style2">LA</span></td>
       <td width="20" align="center"  bgcolor="#400000"><span class="style2">RA</span></td>
       <td width="20" align="center"  bgcolor="#400000"><span class="style2">SA</span></td>
       <td width="20" align="center"  bgcolor="#400000"><span class="style2">WA</span></td>
       <td width="20" align="center"  bgcolor="#400000"><span class="style2">TTL</span></td>
     </tr>
	      <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc" ;
			$i=0;
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc" ;
					
$query_billing = q_set($__p_query_billing, "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where  a.kd_class = ?  group by a.kd_billing order by a.dt_entry desc", [(string) ($kdcl)]);					

$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$query_hadir = q_set($__p_query_hadir, "SELECT st_attendance FROM vip_attendance where kd_class=? and kd_biodata = ? and st_attendance = 1 group by dt_meeting", [(string) ($kdcl), (string) ($row_billing[7])]); 
		$resource_hadir = db_query_soft($query_hadir, $__p_query_hadir ?? []);
		$jml_hadir = db_num_rows($resource_hadir);	

		$query_hadir_lc = q_set($__p_query_hadir_lc, "SELECT tgl_meeting FROM vip_lc where kd_class like ? and kd_biodata = ? group by tgl_meeting", [(string) ($kdcl) . "%", (string) ($row_billing[7])]); 
		$resource_hadir_lc = db_query_soft($query_hadir_lc, $__p_query_hadir_lc ?? []);
		$jml_hadir_lc = db_num_rows($resource_hadir_lc);			

		//$query_score = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_inc.tb_acd_history t where t.kd_biodata =  '$row_billing[7]' and  total <> ''  order by test_date desc limit 1";
		$query_score= q_set($__p_query_score, "select L,other,S,R,W,total,no from ves_data.vip_class_score_profile where kd_biodata =  ? and jns_test = 1 order by no desc limit 1", [(string) ($row_billing[7])]);		
		$resource_score = db_query_soft($query_score, $__p_query_score ?? []);
		$keluar_score = db_num_rows($resource_score);	
		if(num(db_num_rows($resource_score)) > 0)
			{
			while ($row_score  =  db_fetch($resource_score, PDO::FETCH_NUM))	
				{
				$l_pt = $row_score[0];	
				$st_pt = $row_score[1];	
				$sp_pt = $row_score[2];	
				$r_pt = $row_score[3];	
				$w_pt = $row_score[4];						
				$ttl_pt = $row_score[5];
				$nomor_pt = $row_score[6];						
				$adascore = 1;
				}
			}
		$query_score_mid = q_set($__p_query_score_mid, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '2' order by test_date desc limit 1", [(string) ($row_billing[7]), (string) ($row_billing[11])]);
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
		$query_score_final = q_set($__p_query_score_final, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1", [(string) ($row_billing[7]), (string) ($row_billing[11])]);
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
		$query_komen = q_set($__p_query_komen, "SELECT keterangan,l,r,s,w,other, nilai_ttl,target_score FROM ves_data.vip_student_comment  where  kd_cl = ? and kd_biodata = ? ", [(string) ($kdcl), (string) ($row_billing[7])]);
		$resource_komen = db_query_soft($query_komen, $__p_query_komen ?? []);	
		if(num(db_num_rows($resource_komen)) > 0)
			{
			while ($row_komen  =  db_fetch($resource_komen, PDO::FETCH_NUM))	
				{
				$komen = $row_komen[0];
				$l = $row_komen[1];
				$r = $row_komen[2];
				$s = $row_komen[3];
				$w = $row_komen[4];
				$o = $row_komen[5];					
				$int_ttl = $row_komen[6];					
				$target_score = $row_komen[7];					
					
				}
			}
	?>
     <tr>
       <td><strong><?php echo e($row_billing[6]) ?></strong></td>
       <td align=center class="style24"><?php echo e($l_pt) ?></td>
       <td align=center class="style24"><?php echo e($r_pt) ?></td>
       <td align=center class="style24"><?php echo e($sp_pt) ?></td>
       <td align=center class="style24"><?php echo e($w_pt) ?></td>
       <td align=center class="style24"><?php echo e($ttl_pt) ?></td>
       <td width="76"  align=center class="style24"><?php echo e($jml_hadir) ?></td>
       <td width="76"  align=center class="style24"><?php echo e($jml_hadir_lc) ?></td>
       <td align=center class="style24"><?php echo e($l_mid) ?></td>
       <td align=center class="style24"><?php echo e($r_mid) ?></td>
       <td align=center class="style24"><?php echo e($sp_mid) ?></td>
       <td align=center class="style24"><?php echo e($w_mid) ?></td>
       <td align=center class="style24"><?php echo e($ttl_mid) ?></td>
       <td align=center class="style24"><?php echo e($l_final) ?></td>
       <td align=center class="style24"><?php echo e($r_final) ?></td>
       <td align=center class="style24"><?php echo e($sp_final) ?></td>
       <td align=center class="style24"><?php echo e($w_final) ?></td>
       <td align=center class="style24"><?php echo e($ttl_final) ?></td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td align="center"><strong>Teacher's Comment</strong></td>
       <td colspan="18"><span class="form-group">
         <textarea class="textarea" placeholder="Place some text here" cols="100" rows="5" name="komen_<?php echo e($i) ?>"><?php echo e($komen) ?></textarea>
       </span></td>
     </tr>
	      <?php $i = num($i)+1; }} ?>	   
     <tr>
       <td colspan="19"><div align="center"><span class="style2"><strong>RULES &amp; REGULATIONS REGARDING PROFESSIONAL FEE</strong></span></div></td>
     </tr>
   </table>
<br>
<table width="100%" class="table table-bordered table-striped" id="example" border="0">
		        <thead>
<?php					
					//tampil result	
$query_result = q_set($__p_query_result, "select kelas, avg_score_improvement, avg_attendance, tlp, dt_certificate, compatibility, facility, date_format(dt_certificate,'%Y-%m-%d') from ves_data.vip_mca_data where kelas = ? ", [(string) ($kdcl)]);
$resource_result = db_query_soft($query_result, $__p_query_result ?? []);
$keluar_result = db_num_rows($resource_result);	
if(num(db_num_rows($resource_result)) > 0)
	{
		while ($row_result  =  db_fetch($resource_result, PDO::FETCH_NUM))	
		{$avg_score_improve= $row_result[1]; 
		 $avg_attendance= $row_result[2];
		 $dt_certificate= $row_result[4];
		 $compatibility= $row_result[5];
		 $facility_quiz= $row_result[6];
		 $tlp= $row_result[3];
		 $dt_certificate = $row_result[7];
		}
	}
?>
		          <tr>
		            <td width=3% height="14" align=center >Result:</td>
		            <td width="7%" align=center >&nbsp;</td>
		            <td width="66%" align=center >
	                <input name="kdcl"  class="form-control"  type="hidden" size="5" value="<?php echo e($kdcl) ?>" /></td>
		            <td width="12%" align=center >&nbsp;</td>
		            <td width="1%" align=center >&nbsp;</td>
		            <td width="3%" align=center >&nbsp;</td>
		            <td width="8%" align=center >&nbsp;</td>
		            <td width="0%" align=center >&nbsp;</td>
	              </tr>
		          <tr>
		            <td height="14" align=center >1</td>
		            <td align=left >Average Score Improvement:</td>
		            <td align=center ><input name="avg_score_improve"  class="form-control"  type="text" size="5" value="<?php echo e($avg_score_improve) ?>" /></td>
		            <td align=center >Average Class Attendance:</td>
		            <td colspan="2" align=center ><input name="avg_attendance"  class="form-control"  type="text" length="5" value="<?php echo e($avg_attendance) ?>" /></td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>
		          <tr>
		            <td height="14" align=center >2</td>
		            <td align=left >Average Class Attendance:</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >Certificate distribution date: </td>
		            <td colspan="2" align=center ><input name="dt_certificate"  class="form-control"  type="date" length="5" value="<?php echo e($dt_certificate) ?>" /></td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>
		          <tr>
		            <td height="14" align=center >3</td>
		            <td align=left >Questionnaire Result:</td>
		            <td align=center ></td>
		            <td align=center >&nbsp;</td>
		            <td colspan="2" align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>
<?php 
	$i = 0;
$query_teacher = q_set($__p_query_teacher, "select b.nm_teacher from vip_teacher_schedule a left join vip_teacher_name b on a.nm_teacher = b.kd_teacher where kelas = ? and status_kelas = 1 and a.nm_teacher <> 'Sal' group by nm_teacher order by nm_teacher", [(string) ($kdcl)]);

$resource_teacher = db_query_soft($query_teacher, $__p_query_teacher ?? []);			
if(num(db_num_rows($resource_teacher)) > 0)
	{
	while ($row_teacher  =  db_fetch($resource_teacher, PDO::FETCH_NUM))
		{	
		$query_teacher_score = q_set($__p_query_teacher_score, "SELECT quiz_score, kelas_komen FROM vip_mca_teacher_record where nm_teacher = ? and kelas = ? ", [(string) ($row_teacher[0]), (string) ($kdcl)]);
		$resource_teacher_score = db_query_soft($query_teacher_score, $__p_query_teacher_score ?? []);			
		if(num(db_num_rows($resource_teacher_score)) > 0)
			{
			while ($row_teacher_score  =  db_fetch($resource_teacher_score, PDO::FETCH_NUM))
				{
				$teacher_quiz = $row_teacher_score[0];
				}
			}
			
?>					
		          <tr>
		            <td height="14" align=center >&nbsp;</td>
		            <td align=left >* <?php echo e($row_teacher[0]) ?></td>
		            <td align=center  ><input name="nm_teacher_<?php echo e($i) ?>"  class="form-control"  type="hidden" size="3" value="<?php echo e($row_teacher[0]) ?> "  />		              <input name="teacher_quiz_<?php echo e($i) ?>"  class="form-control"  type="text" size="90" value="<?php echo e($teacher_quiz) ?> " /></td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>

<?php $i++;}$resource_teacher_score='';  } ?>	
		          <tr>
		            <td height="14" align=center >&nbsp;</td>
		            <td align=left >* Services & Facilities (Score):</td>
		            <td align=center ><input name="facility_quiz"  class="form-control"  type="text" size="90" value="<?php echo e($facility_quiz) ?>" /></td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>
		          <tr>
		            <td height="14" align=center >4</td>
		            <td colspan="3" align=left >Compatibility between Sequence of presentation and Coordination sheet:<br>
	                <input name="compatibility"  class="form-control"  type="text" size="90" value="<?php echo e($compatibility) ?>" readonly/></td>
		            <td align=center>&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>
		          <tr>
		            <td height="14" align=center >&nbsp;</td>
		            <td colspan="3" align=left >Teacher's Comment on Class activities:
</td>
		            <td align=center>&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>
<?php 
$query_teacher = q_set($__p_query_teacher, "select b.nm_teacher from vip_teacher_schedule a left join vip_teacher_name b on a.nm_teacher = b.kd_teacher where kelas = ? and status_kelas = 1 and a.nm_teacher <> 'Sal' group by nm_teacher", [(string) ($kdcl)]);
	$i = 0;
$resource_teacher = db_query_soft($query_teacher, $__p_query_teacher ?? []);			
if(num(db_num_rows($resource_teacher)) > 0)
	{
	while ($row_teacher  =  db_fetch($resource_teacher, PDO::FETCH_NUM))
		{	
		$query_teacher_score = q_set($__p_query_teacher_score, "SELECT quiz_score, kelas_komen FROM vip_mca_teacher_record where nm_teacher = ? and kelas = ? ", [(string) ($row_teacher[0]), (string) ($kdcl)]);
		
		$resource_teacher_score = db_query_soft($query_teacher_score, $__p_query_teacher_score ?? []);			
		if(num(db_num_rows($resource_teacher_score)) > 0)
			{
			while ($row_teacher_score  =  db_fetch($resource_teacher_score, PDO::FETCH_NUM))
				{
				$komen = $row_teacher_score[1];
				}
			}
?>					
		          <tr>
		            <td height="14" align=center >&nbsp;</td>
		            <td colspan="2" align=left >* <?php echo e($row_teacher[0]) ?><br>
	                <textarea class="textarea" placeholder="Place some text here" cols="150" rows="5" name="teacher_comment_<?php echo e($i) ?>"><?php echo e($komen) ?></textarea></td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>

<?php $i++; }$resource_teacher_score=''; } ?>
		          <tr>
		            <td height="14" align=center >&nbsp;</td>
		            <td align=left >Summary of TLP Activities:</td>
		            <td align=left ><input name="tlp"  class="form-control"  type="text" length="50" value="<?php echo e($tlp) ?>" readonly/></td>
		            <td align=left >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>
		          <tr>
		            <td height="14" align=center >&nbsp;</td>
		            <td align=left >&nbsp;</td>
		            <td align=left >&nbsp;</td>
		            <td align=left >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
		            <td align=center >&nbsp;</td>
	              </tr>					
	            </thead>
		        <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   /* echo $query_billing (debug SQL versi lama) dihapus */
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
		        <tbody>
		          <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc" ;

//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.no FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc"
//hitung jml_meeting	
			$query_jml_meeting = q_set($__p_query_jml_meeting, "SELECT sum(status_kelas) FROM ves_data.vip_teacher_schedule where kelas = ? ", [(string) ($kdcl)]);

		$resource_jml_meeting = db_query_soft($query_jml_meeting, $__p_query_jml_meeting ?? []);
		$keluar_jml_meeting = db_num_rows($resource_jml_meeting);	
		if(num(db_num_rows($resource_jml_meeting)) > 0)
			{
			while ($row_jml_meeting  =  db_fetch($resource_jml_meeting, PDO::FETCH_NUM))	
				{
				$angka_jml_meeting = $row_jml_meeting[0];
				}
			}	
	
	
$query_billing = q_set($__p_query_billing, "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.no FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where  a.kd_class = ?  group by a.kd_billing order by a.dt_entry desc", [(string) ($kdcl)]);					

$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$query_score = q_set($__p_query_score, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_inc.tb_acd_history t where t.kd_biodata =  ? order by test_date desc limit 1", [(string) ($row_billing[7])]);
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
				$adascore = 1;
				}
			}
		$query_score_mid = q_set($__p_query_score_mid, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '2' order by test_date desc limit 1", [(string) ($row_billing[7]), (string) ($row_billing[11])]);
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
		$query_score_final = q_set($__p_query_score_final, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1", [(string) ($row_billing[7]), (string) ($row_billing[11])]);
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
		$tgl_tutor = '';	
		$query_tutor = q_set($__p_query_tutor, "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and status_kelas = '50' and kelas like ? ", [(string) ($row_billing[7]), (string) ($row_billing[11]) . "%"]);

		$resource_tutor = db_query_soft($query_tutor, $__p_query_tutor ?? []);
		$keluar_tutor = db_num_rows($resource_tutor);	
		if(num(db_num_rows($resource_tutor)) > 0)
			{
			while ($row_tutor  =  db_fetch($resource_tutor, PDO::FETCH_NUM))	
				{
				if ($tgl_tutor <> ''){$tgl_tutor = $tgl_tutor . "<br> " . e($row_tutor[0]);}
				else {$tgl_tutor = $row_tutor[0];}
				}
			}
		$query_tutor = q_set($__p_query_tutor, "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and status_kelas = '60' and kelas like ? ", [(string) ($row_billing[7]), (string) ($row_billing[11]) . "%"]);
		$resource_tutor = db_query_soft($query_tutor, $__p_query_tutor ?? []);
		$keluar_tutor = db_num_rows($resource_tutor);	
		if(num(db_num_rows($resource_tutor)) > 0)
			{
			while ($row_tutor  =  db_fetch($resource_tutor, PDO::FETCH_NUM))	
				{
				if ($tgl_la <> ''){$tgl_la = $tgl_la . "<br> " . e($row_tutor[0]);}
				else {$tgl_la = $row_tutor[0];}
				}
			}
		$query_tutor = q_set($__p_query_tutor, "SELECT date_format(mulai_tm,'%d-%m-%y'), date_format(mulai_tm,'%H:%i'), date_format(selesai_tm,'%H:%i'), round(TIME_TO_SEC(timediff(date_format(selesai_tm,'%H:%i:00'),date_format(mulai_tm,'%H:%i:00'))) / 3600 ) as durasi  FROM ves_data.vip_teacher_schedule where kd_biodata = ? and (status_kelas = '71' or status_kelas = '70' ) and kelas like ? ", [(string) ($row_billing[7]), (string) ($row_billing[11]) . "%"]);

		$resource_tutor = db_query_soft($query_tutor, $__p_query_tutor ?? []);
		$keluar_tutor = db_num_rows($resource_tutor);	
		if(num(db_num_rows($resource_tutor)) > 0)
			{
			while ($row_tutor  =  db_fetch($resource_tutor, PDO::FETCH_NUM))	
				{
				if ($tgl_lc <> '')
				{
				$tgl_lc = $tgl_lc . " <br> " . e($row_tutor[0]) . " ( " . e($row_tutor[1]) . "-" . e($row_tutor[2]) . ") (" . e($row_tutor[3]) . ")";}
				else {$tgl_lc = "$row_tutor[0] ( $row_tutor[1]-$row_tutor[2]) ($row_tutor[3])";}
				}
			}			
			$query_tutor = q_set($__p_query_tutor, "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and status_kelas = '90' and kelas like ? ", [(string) ($row_billing[7]), (string) ($row_billing[11]) . "%"]);
		$resource_tutor = db_query_soft($query_tutor, $__p_query_tutor ?? []);
		$keluar_tutor = db_num_rows($resource_tutor);	
		if(num(db_num_rows($resource_tutor)) > 0)
			{
			while ($row_tutor  =  db_fetch($resource_tutor, PDO::FETCH_NUM))	
				{
				if ($tgl_ext <> ''){$tgl_ext = $tgl_ext . "<br> " . e($row_tutor[0]);}
				else {$tgl_ext = $row_tutor[0];}
				}
			}		
//hitung kehadiran	
			$query_hadir = q_set($__p_query_hadir, "SELECT sum(st_attendance) FROM ves_data.vip_attendance where kd_class = ? and kd_biodata = ? group by kd_biodata", [(string) ($row_billing[11]), (string) ($row_billing[7])]);

		$resource_hadir = db_query_soft($query_hadir, $__p_query_hadir ?? []);
		$keluar_hadir = db_num_rows($resource_hadir);	
		if(num(db_num_rows($resource_hadir)) > 0)
			{
			while ($row_hadir  =  db_fetch($resource_hadir, PDO::FETCH_NUM))	
				{
				$angka_hadir = $row_hadir[0];
				}
			}	
		$persen_hadir = num((div($angka_hadir, $angka_jml_meeting)))*100;
//hitung kehadiran	lc
			$query_hadir_lc = q_set($__p_query_hadir_lc, "SELECT count(mulai_tm) FROM ves_data.vip_teacher_schedule where kelas = ? and kd_biodata = ? and status_kelas='71' group by kd_biodata", [(string) ($row_billing[11]) . " - LC Visit", (string) ($row_billing[7])]);

		$resource_hadir_lc = db_query_soft($query_hadir_lc, $__p_query_hadir_lc ?? []);
		$keluar_hadir_lc = db_num_rows($resource_hadir_lc);	
		if(num(db_num_rows($resource_hadir_lc)) > 0)
			{
			while ($row_hadir_lc  =  db_fetch($resource_hadir_lc, PDO::FETCH_NUM))	
				{
				$angka_hadir_lc = $row_hadir_lc[0];
				}
			}		
//hitung kehadiran	tutorial
			$query_hadir_tutor = q_set($__p_query_hadir_tutor, "SELECT count(mulai_tm) FROM ves_data.vip_teacher_schedule where kelas = ? and kd_biodata = ? and status_kelas='51' group by kd_biodata", [(string) ($row_billing[11]) . " - Tutorial", (string) ($row_billing[7])]);

		$resource_hadir_tutor = db_query_soft($query_hadir_tutor, $__p_query_hadir_tutor ?? []);
		$keluar_hadir_tutor = db_num_rows($resource_hadir_tutor);	
		if(num(db_num_rows($resource_hadir_tutor)) > 0)
			{
			while ($row_hadir_tutor  =  db_fetch($resource_hadir_tutor, PDO::FETCH_NUM))	
				{
				$angka_hadir_tutor = $row_hadir_tutor[0];
				}
			}
//komentar teacher
			$query_komentar = q_set($__p_query_komentar, "SELECT keterangan from ves_data.vip_student_comment where kd_cl = ? and kd_biodata = ? ", [(string) ($row_billing[11]), (string) ($row_billing[7])]);

		$resource_komentar = db_query_soft($query_komentar, $__p_query_komentar ?? []);
		$keluar_komentar = db_num_rows($resource_komentar);	
		if(num(db_num_rows($resource_komentar)) > 0)
			{
			while ($row_komentar  =  db_fetch($resource_komentar, PDO::FETCH_NUM))	
				{
				$komentar = $row_komentar[0];
				}
			}		
			
		
			
	?>
		          <?php $l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';$tgl_la = '';		$tgl_tutor = '';$tgl_lc='';$tgl_ext = '';}} ?>
	            </tbody>
		        <tfoot>
	            </tfoot>
        </table>
 </div>
	 <?php
    $content = ob_get_clean();
	$namafile = "MCA .$kdcl.pdf";
    // convert in PDF
    require_once VCMS_ROOT . '/_lib/html2pdf.php';   // spipu/html2pdf 5.x (pengganti html2pdf/ lama)
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
 		$html2pdf->setTestTdInOnePage(false);		
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($namafile);
    }
    catch(HTML2PDF_exception $e) {
        html2pdf_fail($e);
    }
?>