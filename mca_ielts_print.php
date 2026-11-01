<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ob_start();
ini_set('memory_limit', '550M');
?>
<?php
include __DIR__ . "/conndb.php";
//$kdcl = in_val('cd_cl', 'get');
$kdcl = in_val('kdcl', 'get');
$query_nmprg = q_set($__p_query_nmprg, "SELECT a.kelas, v.nm_program, v.type_program, a.kode_program, a.level_program FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg v on a.kode_program = v.kd_program where kelas = ? ", [(string) ($kdcl)]);

$resource_nmprg = db_query_soft($query_nmprg, $__p_query_nmprg ?? []);			
if(num(db_num_rows($resource_nmprg)) > 0)
	{
	while ($row_nmprg  =  db_fetch($resource_nmprg, PDO::FETCH_NUM))
		{
		$kelas = $row_nmprg ['0'];
		$nm_program = $row_nmprg ['1'];
		$type_program = $row_nmprg ['2'];
		$kode_program = $row_nmprg ['3'];
		$level_program = $row_nmprg ['4'];
		}
	}


?>
<!DOCTYPE html>
<html>
<head>

<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-size:xxx-small;	
	}
.style24 {
	color: #000;
	font-size: 10px;
	}	
-->
.style32 {
	color:#000;
	font-size:80%;
	}
-->
	.style33 {
	color:#000;
	font-size:75%;
	}
-->
	.style34 {
	color:#000;
	font-size:80%;
	}
-->	
	    .tbl{
     width: 700pt;
     border: 1px solid #000;
    }

</style>
	<style>
table, th, td {
  border: 0.5px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 1px;
  text-align: left;
}
#t01 {
  width: 50%;    
  background-color: #f1f1c1;
}
</style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<table width="980" id="">

	        <tbody>

	          <tr>
	            <td width="664" height="14" align=center  class="style34"><strong><h5>Monitoring Class Activities</h5>
	            </strong></td>
              </tr>
	          <tr>
	            <td height="14" align=center  class="style34">Program / Class:  IELTS - (Regular/Private)/ (<?php echo e($kdcl) ?>)</td>
              </tr>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
    <br><br><br>
    <table style="width:100%" id="table" border = "0">
      <tbody>
		  <small>
	      <tr>
	        <td width=6%  class="style24" align=center >Student Name</td>
	        <td width="5%" class="style24" align=center >Attendance</td>
	        <td colspan="6"  class="style24" align=center >Placement Score</td>
	        <td width="5%" class="style24"  align=center >&nbsp;</td>
	        <td width="5%" class="style24"  align=center >&nbsp;</td>
	        <td width="8%"  class="style24" align=center >&nbsp;</td>
	        <td colspan="5" class="style24"  align=center >Mid Test Score</td>
	        <td colspan="5" class="style24"  align=center >Final Test Score</td>
	        <td width="13%" class="style24"  align=center >Remark</td>
	        </tr>
	      <tr>
	        <td height="14" align=left class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">LPT</td>
	        <td align=center class="style24">RPT</td>
	        <td align=center class="style24">SPT</td>
	        <td align=center class="style24">WPT</td>
	        <td align=center class="style24">TPT</td>
	        <td width="5%" align=center class="style24">TPT (Conversi)</td>
	        <td align=center class="style24">Class Attendance</td>
	        <td align=center class="style24">LC Visit</td>
	        <td align=center class="style24">Tutorial Record</td>
	        <td width="5%">L</td>
	        <td width="5%">R</td>
	        <td width="5%">Wr</td>
	        <td width="5%">Sp</td>
	        <td width="5%">Overall Score</td>
	        <td width="2%">L</td>
	        <td width="2%">R</td>
	        <td width="2%">Wr</td>
	        <td width="2%">Sp</td>
	        <td width="4%">Overall Score</td>
	        <td align=center class="style24">&nbsp;</td>
	        </tr></small>	
	      <?php		
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
		if (num($angka_hadir) != 0){
		$persen_hadir = num((div($angka_hadir, $angka_jml_meeting)))*100;}
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
 <small>

	          <tr>
	            <td height="14" colspan="22" align=left class="style33" >&nbsp;</td>
  </tr>
	          <tr>
	            <td height="14" align=left class="style33" ><?php echo e($row_billing[6]) ?></td>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td width="2%" align=center class="style24"><p><?php echo e($l) ?></p></td>
	            <td width="2%" align=center class="style24"><?php echo e($st) ?></td>
	            <td width="2%" align=center class="style24"><?php echo e($r) ?></td>
	            <td width="5%" align=center class="style24">&nbsp;</td>
	            <td width="5%" align=center class="style24">&nbsp;</td>
	            <td align=center class="style24"><?php echo e($sp) ?></td>
	            <td align=center class="style24"><?php echo e($angka_hadir) ?><br>
	              ( <?php echo round(num($persen_hadir)) ?>% )</td>
	            <td align=center class="style24"><?php echo e($angka_hadir_lc) ?></td>
	            <td align=center class="style24"><?php echo e($angka_hadir_tutor) ?></td>
	            <td align=center class="style24"><?php echo e($l_mid) ?></td>
	            <td align=center class="style24"><?php echo e($r_mid) ?></td>
	            <td align=center class="style24"><?php echo e($w_mid) ?></td>
	            <td align=center class="style24"><?php echo e($sp_mid) ?></td>
	            <td align=center class="style24"><p><?php echo e($ttl_mid) ?></p></td>
	            <td align=center class="style24"><?php echo e($l_final) ?></td>
	            <td align=center class="style24"><?php echo e($r_final) ?></td>
	            <td align=center class="style24"><?php echo e($w_final) ?></td>
	            <td align=center class="style24"><?php echo e($sp_final) ?></td>
	            <td align=center class="style24"><p><?php echo e($ttl_final) ?></p></td>
	            <td align=center class="style24">&nbsp;</td>
  </tr> 
	      <tr>
	        <td height="14" align=center class="style24">&nbsp;</td>
	        <td colspan="20" align=left class="style24"><em>Teacher's Comment :</em><br>
	          <?php echo e($komentar) ?></td>
	        <td height="14" align=center class="style24">&nbsp;</td>			  
	        </tr>
	      <tr>
	        <td height="14" colspan="22" align=left class="style24"><hr></td>
	        </tr>	 
    </small>
            	      <?php $l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';$tgl_la = '';		$tgl_tutor = '';$tgl_lc='';$tgl_ext = '';}} 						 ?>		  
        </tbody>
          </table>
    <table width="823" id="table2">
      <tbody>
        <tr>
          <td width="239" height="14" align=center   class="style34" >Day</td>
          <td width="183" align=center   class="style34">Time</td>
          <td width="225" align=center  class="style34" >Room</td>
          <td width="192" align=center  class="style34" >Teacher</td>
        </tr>
        <?php	
				
$query_data = q_set($__p_query_data, "SELECT c.nm_teacher, date_format(mulai_tm,'%W'),date_format(mulai_tm,'%k:%i'), date_format(selesai_tm,'%k:%i'),room\r
 FROM ves_data.vip_teacher_schedule c left join ves_data.vip_mst_code_prg b on c.kode_program = b.kd_program where c.kelas = ? group by date_format(mulai_tm,'%W')", [(string) ($cd_cl)]);
		
$resource_data = db_query_soft($query_data, $__p_query_data ?? []);
$keluar_data = db_num_rows($resource_data);				
if(num(db_num_rows($resource_data)) > 0)
	{
	while ($row_data  =  db_fetch($resource_data, PDO::FETCH_NUM))
		{
		$sch_teacher = $row_data[0];
		$sch_hari = $row_data[1];
		$sch_jam = "$row_data[2]-$row_data[3]";
		$sch_room = $row_data[4];
	
	?>
        <tr>
          <td height="14" align=center   class="style34" ><?php echo e($sch_hari); ?></td>
          <td align=center  class="style34" ><?php echo e($sch_jam); ?></td>
          <td align=center  class="style34" ><?php echo e($sch_room); ?></td>
          <td align=center  class="style34" ><?php echo e($sch_teacher); ?></td>
        </tr>
        <?php }} ?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
</body>
</html>
<?php
    $content = ob_get_clean();
	$namafile = "ocp.$kode_student.pdf";
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
