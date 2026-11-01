<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2017-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_val('kd_cbg', 'get');

if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
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

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdcl = in_val('kdcl', 'get');
$kdprg = in_val('kdprg', 'get');
$nmprg = in_val('nmprg', 'get');
$query_nmprg = q_set($__p_query_nmprg, "select kode_program from vip_teacher_schedule where kelas = ? group by kelas", [(string) ($kdcl)]);

$resource_nmprg = db_query_soft($query_nmprg, $__p_query_nmprg ?? []);			
if(num(db_num_rows($resource_nmprg)) > 0)
	{
	while ($row_nmprg  =  db_fetch($resource_nmprg, PDO::FETCH_NUM))
		{
		$nmprg = $row_nmprg[0];	
		}
	}


$query_mca_data = q_set($__p_query_mca_data, "select  avg_score_improvement, avg_attendance, tlp, dt_certificate, compatibility,fasility,pic, dt_entry from ves_data.vip_mca_data where kelas = ? ", [(string) ($kdcl)]);
$resource_mca_data = db_query_soft($query_mca_data, $__p_query_mca_data ?? []);
if(num(db_num_rows($resource_mca_data)) > 0)
	{
	{
	while ($row_mca_data  =  db_fetch($resource_mca_data, PDO::FETCH_NUM))
		{
$avg_score_improve =$row_mca_data[0];
$teacher_quiz;
$facility_quiz =$row_mca_data[5];
$compatibility =$row_mca_data[4];
$komen =$row_mca_data[0];
$tlp =$row_mca_data[2];
$avg_attendance =$row_mca_data[1];
$dt_certificate =$row_mca_data[3];
		}
	}		
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<?php //========================== left nav ?>
 <?php //   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
<div class="box box-warning">          
  <div class="box-body">
    <div class="col-md-12">
	  <div class="form-group">
	      <p>
		        <strong>Monitoring Class Activities</strong><br>
		        <label>Class Code : <?php echo e($kdcl) ?></label>
		        <br>
		        <label>Meeting : </label>
		        
	        <input type="text" name="kdprg" id="textfield" hidden value=<?php echo e($kdprg) ?> ></input>
	        <input type="text" name="nmprg" id="textfield2"hidden value=<?php echo e($nmprg) ?> >
	      </p>
	      <p>Me </p>
        <table width="100%" class="table table-bordered table-striped" id="example12" border="1">
		        <thead>
	      <tr>
	        <td width=6% height="14" align=center >Student Name</td>
	        <td width="5%" align=center >Class Code</td>
	        <td colspan="6" align=center >Placement Score</td>
	        <td width="5%" align=center >&nbsp;</td>
	        <td width="5%" align=center >&nbsp;</td>
	        <td width="8%" align=center >&nbsp;</td>
	        <td colspan="5" align=center >Mid Test Score</td>
	        <td colspan="5" align=center >Final Test Score</td>
	        <td width="13%" align=center >Remark</td>
	        </tr>
        </thead>
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
	
	
$query_billing = q_set($__p_query_billing, "SELECT date_format(mulai_tm, '%M'),h.minggu, e.nama_lengkap, a.kelas, b.duration_program,date_format(mulai_tm,'%b %d, %Y') FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program left join ves_data.vip_billing g on a.kelas = g.kd_class left join ves_data.vip_student_data e on g.kd_biodata = e.kd_biodata left join ves_data.tb_minggu_detail h on date_format(a.mulai_tm, '%Y-%m-%d') = date_format(h.detail, '%Y-%m-%d') INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where a.kd_branch = '1' and f.min_mulai between '2020-01-01 00:00:00' and '2020-07-15 23:00:00' and a.kd_biodata = '' and a.status_kelas = 1 group by a.kelas, e.kd_biodata order by mulai_tm");					
/* echo $query_billing (debug SQL versi lama) dihapus */
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
			$query_hadir_tutor = q_set($__p_query_hadir_tutor, "SELECT count(mulai_tm) FROM ves_data.vip_teacher_schedule where kelas = ? and kd_biodata = ? group by kd_biodata", [(string) ($row_billing[11]) . " - Tutorial", (string) ($row_billing[7])]);

		$resource_hadir_tutor = db_query_soft($query_hadir_tutor, $__p_query_hadir_tutor ?? []);
		$keluar_hadir_tutor = db_num_rows($resource_hadir_tutor);	
		if(num(db_num_rows($resource_hadir_tutor)) > 0)
			{
			while ($row_hadir_tutor  =  db_fetch($resource_hadir_tutor, PDO::FETCH_NUM))	
				{
				$angka_hadir_tutor = $row_hadir_tutor[0];
				}
			}
		
			
		
			
	?>
	      <tr>
	        <td height="14" align=left class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td colspan="5" align=center class="style24">TOEFL PBT</td>
	        <td width="5%" rowspan="2" align=center class="style24">Sp</td>
	        <td rowspan="2" align=center class="style24">Class Attendance</td>
	        <td rowspan="2" align=center class="style24">LC Visit</td>
	        <td rowspan="2" align=center class="style24">Tutorial Record</td>
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
	        </tr>
	      <tr>
	        <td height="14" align=left class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td width="2%" align=center class="style24">L</td>
	        <td width="2%" align=center class="style24">Str</td>
	        <td width="2%" align=center class="style24">R</td>
	        <td width="5%" align=center class="style24">Total</td>
	        <td width="5%" align=center class="style24">CEFR</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        </tr>
	      <tr>
	        <td align=left class="style24"><a href="vip_student_profile.php?idb=<?php echo e(u($row_billing[0]))  ?>&kdb=<?php echo e(u($row_billing[7])) ?>&cl=<?php echo e(u($row_billing[11])) ?>"><?php echo e($row_billing[6]) ?></td>
	        <td height="14" align=center class="style24"><?php echo e($row_billing[11]); ?></td>
	        <td align=center class="style24">
	          <p><?php echo e($l) ?></p>
</td>
	        <td align=center class="style24"><?php echo e($st) ?></td>
	        <td align=center class="style24"><?php echo e($r) ?></td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24"><?php echo e($sp) ?></td>
	        <td align=center class="style24"><?php echo e($angka_hadir) ?><br>
	          ( <?php echo round(num($persen_hadir)) ?>% )</td>
	        <td align=center class="style24"><?php echo e($angka_hadir_lc) ?></td>
	        <td align=center class="style24"><?php echo e($angka_hadir_tutor) ?></td>
	        <td align=center class="style24"><?php echo e($l_mid) ?></td>
	        <td align=center class="style24"><?php echo e($r_mid) ?></td>
	        <td align=center class="style24"><?php echo e($w_mid) ?></td>
	        <td align=center class="style24"><?php echo e($sp_mid) ?></td>
	        <td align=center class="style24">
	          <p><?php echo e($ttl_mid) ?></p>
	          <p>
</td>
	        <td align=center class="style24"><?php echo e($l_final) ?></td>
	        <td align=center class="style24"><?php echo e($r_final) ?></td>
	        <td align=center class="style24"><?php echo e($w_final) ?></td>
	        <td align=center class="style24"><?php echo e($sp_final) ?></td>
	        <td align=center class="style24">
	          <p><?php echo e($ttl_final) ?></p>
</td>
	        <td align=center class="style24">&nbsp;</td>
	        </tr>
	      <tr>
	        <td height="14" colspan="22" align=left class="style24"><hr></td>
	        </tr>
	      <?php $l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';$tgl_la = '';		$tgl_tutor = '';$tgl_lc='';$tgl_ext = '';}} ?>
        </tbody>
	    <tfoot>
        </tfoot>
    </table>
     <form name="form1" method="post" action="#"><?php echo csrf_field(); ?>
 	  
		      <table width="100%" class="table table-bordered table-striped" id="example" border="1">
		        <thead>
		          <tr>
		            <td colspan="8" align=center >&nbsp;</td>
	              </tr>
		          <?php 
	$i = 0;
$query_teacher = q_set($__p_query_teacher, "select a.nm_teacher from vip_teacher_schedule a left join vip_teacher_name b on a.nm_teacher = b.kd_teacher where kelas = ? and status_kelas = 1 group by nm_teacher", [(string) ($kdcl)]);

$resource_teacher = db_query_soft($query_teacher, $__p_query_teacher ?? []);			
if(num(db_num_rows($resource_teacher)) > 0)
	{
	while ($row_teacher  =  db_fetch($resource_teacher, PDO::FETCH_NUM))
		{					
?>					
		          <?php $i++;} } ?>	
		          <?php 
$query_teacher = q_set($__p_query_teacher, "select b.nm_teacher from vip_teacher_schedule a left join vip_teacher_name b on a.nm_teacher = b.kd_teacher where kelas = ? and status_kelas = 1 group by nm_teacher", [(string) ($kdcl)]);

$resource_teacher = db_query_soft($query_teacher, $__p_query_teacher ?? []);			
if(num(db_num_rows($resource_teacher)) > 0)
	{
	while ($row_teacher  =  db_fetch($resource_teacher, PDO::FETCH_NUM))
		{					
?>					
		          <?php } } ?>
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
	  <?php 
if (isset($_POST['Submit'])) 
{
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$kdcl = in_val('kdcl', 'post');	
$batas = $i;

$avg_score_improve = in_val('avg_score_improve', 'post');
$facility_quiz = in_val('facility_quiz', 'post');
$avg_attendance = in_val('avg_attendance', 'post');
$tlp = in_val('tlp', 'post');
$dt_certificate = in_val('dt_certificate', 'post');
	$compatibility = in_val('compatibility', 'post');
	$fasility_quiz = in_val('fasility_quiz', 'post');

$query_mca_data = q_set($__p_query_mca_data, "select kelas from ves_data.vip_mca_data where kelas = ? ", [(string) ($kdcl)]);
$resource_mca_data = db_query_soft($query_mca_data, $__p_query_mca_data ?? []);
if(num(db_num_rows($resource_mca_data)) > 0)
	{
	$query_upd_mca_data = q_set($__p_query_upd_mca_data, "update ves_data.vip_mca_data set  avg_score_improvement = ? , avg_attendance =? , tlp =? , dt_certificate =? ,compatibility = ? , facility = ? , pic =? , dt_entry =? where kelas = ? ", [(string) ($avg_score_improve), (string) ($avg_attendance), (string) ($tlp), (string) ($dt_certificate), (string) ($compatibility), (string) ($facility_quiz), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($kdcl)]);

	$result_upd_mca_data=db_query_or_die("Wah error nihupdd", $query_upd_mca_data, $__p_query_upd_mca_data ?? []);			
	}
else
	{
	$query_ins_mca_data = q_set($__p_query_ins_mca_data, "insert into ves_data.vip_mca_data (kelas, avg_score_improvement, avg_attendance, tlp, dt_certificate, compatibility, facility, pic, dt_entry)\r
\tvalues(? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($kdcl), (string) ($avg_score_improve), (string) ($avg_attendance), (string) ($tlp), (string) ($dt_certificate), (string) ($compatibility), (string) ($facility_quiz), (string) ($nama_lengkap), (string) ($hari_ini)]);

	$result_ins_mca_data=db_query_or_die("Wah error nihupdaaaaa", $query_ins_mca_data, $__p_query_ins_mca_data ?? []);			
	}

	
for($i=0;$i<=$batas;$i++) 
	{
	$nm_teacher = $_POST['nm_teacher_'.$i]; 
	$teacher_quiz = $_POST['teacher_quiz_'.$i]; 
	$teacher_comment = $_POST['teacher_comment_'.$i];

	$query_teacher_mca = q_set($__p_query_teacher_mca, "SELECT kelas, nm_teacher, quiz_score, kelas_komen, pic, dt_entry FROM ves_data.vip_mca_teacher_record where kelas = ? and nm_teacher =? ", [(string) ($kdcl), (string) ($nm_teacher)]);
	$resource_teacher_mca = db_query_soft($query_teacher_mca, $__p_query_teacher_mca ?? []);
	if(num(db_num_rows($resource_teacher_mca)) > 0)
		{
		$query_teacher_mca = q_set($__p_query_teacher_mca, "update ves_data.vip_mca_teacher_record set quiz_score = ? , kelas_komen = ? , pic = ? , dt_entry  = ? where kelas = ? and nm_teacher = ? ", [(string) ($teacher_quiz), (string) ($teacher_comment), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($kdcl), (string) ($nm_teacher)]);

		$result_teacher_mca=db_query_or_die("Wah error nihupdd", $query_teacher_mca, $__p_query_teacher_mca ?? []);			
		}
	else
		{
		$query_teacher_mca = q_set($__p_query_teacher_mca, "insert into ves_data.vip_mca_teacher_record (kelas, nm_teacher, quiz_score, kelas_komen, pic, dt_entry)\r
\t\tvalues(? ,? ,? ,? ,? ,? )", [(string) ($kdcl), (string) ($nm_teacher), (string) ($teacher_quiz), (string) ($teacher_comment), (string) ($nama_lengkap), (string) ($hari_ini)]);
		$result_teacher_mca=db_query_or_die("Wah error nihupdab", $query_teacher_mca, $__p_query_teacher_mca ?? []);			
		}
	
}
	
				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('" . e($url_asli) . "');\n";
				echo "</script>";	

}
?>
		 		      <input type="submit" name="Submit" value="Submit" />
	  </form>	  
		</div>	
    </div>
	</div></div>
<!-- /.row -->
<!-- /.content -->

<!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post"><?php echo csrf_field(); ?>

          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  <!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.loleftcation = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
	