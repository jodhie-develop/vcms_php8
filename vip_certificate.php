<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
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
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VE Student Record</title>
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

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=#> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>VIP E-CERTIFICATE GENERATOR<br>
      </h1>
      <form method=get action=vip_pt_record.php>
        <table width="1033" border="0">
          <tbody>
            <tr>
              <td width="106"><small>
                <label for="date4">Student Name</label>
              </small></td>
              <td width="330"><span class="form-group">
                <input type="text" lang="en-150" class="form-control"  placeholder="Name Search" name="flt_name" 
                 	      value="<?php echo e($flt_name) ?>" ?>
              </span></td>
              <td width="289" align="right"><small>
              <label for="date3">Class Code</label>
              </small></td>
              <td width="290"><span class="form-group">
                <input type="text" lang="en-150" class="form-control"  placeholder="Class Code Search" name="flt_code" 
                 	      value="<?php echo e($flt_code) ?>" ?>
              </span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td></td>
              <td><input name="Listed"  type="submit" id="Listed" class="form-control" value="Certificate Listed" /></td>
              <td>&nbsp;</td>
              <td> <input name="Display" type="submit" id="Save"  class="form-control"  value="Display"  /></td>
            </tr>
          </tbody>
        </table>
      </form>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-12">
		<div class="form-group">
		  <label>Student List</label>
		</div>				
	  </div>
<?php if ($nama_lengkap == 'Kurnia'){?>		
	  <div class="col-md-12">
		<a href="vip_agendadel.php?id=<?php echo e(u($r[14])) ?>" 
target="popup" 
onClick="window.open('vipcer_upload.php?kb=<?php echo e(u($kd_biodata)) ?>&kc=<?php echo e(u($kode_class)) ?>','popup','width=800,height=350,left=700px'); return false;" class="btn btn-block btn-danger  btn-sm" role="button">
					<i class="glyphicon glyphicon-certificate" aria-hidden="true"></i><?php if(num($adattd) ==0) {?> Setting E-Sign <?php } else { ?> Modify E-Sign <?php } ?></a>				
	  </div>		
<?php } ?>
<?php if ($flt_name =='' and $flt_code =='' and $Listed ==''){die;} ?>		
	  <div class="col-md-12">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td height="14" align=center >Branch</td>
	            <td align=center >Student Name</td>
	            <td align=center >Program - Class Code</td>
	            <td colspan="6" align=center >Placement Test Score</td>
	            <td colspan="6" align=center >Final Test</td>
	            <td colspan="3" align=center >Attendance</td>
	            <td align=center >&nbsp;</td>
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
	            <td width="26%" align=center >Certificate</td>
              </tr>
            </thead>

	   
	          <?php	 
	$adafile = 0;
//if ($Listed =='')
//{
if($flt_code=='' and $flt_name != '')
	{
	$kondisi = 1;
	$query_open_class = q_set($__p_query_open_class, "SELECT a.kd_biodata,b.kd_class, a.kd_branch, a.nama_lengkap, b.kd_program FROM ves_data.vip_student_data a left join vip_billing b on a.kd_biodata = b.kd_biodata where a.nama_lengkap like ? and b.kd_class <> '' group by a.kd_biodata,b.kd_class order by a.no desc limit 50", ["%" . (string) ($flt_name) . "%"]);
	}
elseif($flt_code!='' and $flt_name == '')
	{
		$kondisi = 2;
	$query_open_class = q_set($__p_query_open_class, "SELECT a.kd_biodata,b.kd_class, a.kd_branch, a.nama_lengkap,b.kd_program FROM ves_data.vip_student_data a left join vip_billing b on a.kd_biodata = b.kd_biodata where  b.kd_class like ? group by a.kd_biodata,b.kd_class order by a.no desc limit 50", ["%" . (string) ($flt_code) . "%"]);
	}
elseif($flt_code!='' and $flt_name != '')
	{
		$kondisi = 3;
	$query_open_class = q_set($__p_query_open_class, "SELECT a.kd_biodata,b.kd_class, a.kd_branch, a.nama_lengkap,b.kd_program FROM ves_data.vip_student_data a left join vip_billing b on a.kd_biodata = b.kd_biodata where a.nama_lengkap like ? and b.kd_class like ? group by a.kd_biodata,b.kd_class order by a.no desc limit 50", ["%" . (string) ($flt_name) . "%", "%" . (string) ($flt_code) . "%"]);
	}	
//}
//else
	//{
	//	$kondisi = 4;
//	$query_open_class = "SELECT a.kd_biodata,b.kd_class, a.kd_branch, a.nama_lengkap, b.kd_program FROM ves_data.vip_kd_certificate c
//left join ves_data.vip_student_data a on c.kd_biodata = a.kd_biodata left join ves_data.vip_billing b on c.kd_biodata = b.kd_biodata
//where namafile <>'' group by c.kd_biodata,c.kode_kelas order by tgl_cetak desc";
	
//}

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
					//$textlink = "http://allspark.vistaeducation.com/vcms/ecert/view.php?kdb=$kd_biodata&kc=$kode_class";
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
	            <td height="14" align=center class="style24" <?php echo e($warna) ?>><?php echo  e($kode_cabang)  ?></td>
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
	            <td align=center class="style24"<?php echo e($warna) ?>> 
					<?php 		if((num($st_certificate) == 0 and num($adascore_final) ==1) or (num($st_certificate) == 0 and num($adascore) ==1 and $kode_program  =='VAE-JOP') ) {?><a href="vip_agendadel.php?id=<?php echo e(u($r[14])) ?>" 
target="popup" 
onClick="window.open('vipcer_create.php?kb=<?php echo e(u($kd_biodata)) ?>&kc=<?php echo e(u($kode_class)) ?>&a=1','popup','width=800,height=350,left=700px'); return false;" class="btn btn-block btn-primary  btn-sm" role="button">
					<i class="glyphicon glyphicon-certificate" aria-hidden="true"></i>Generate</a></td>
<?php } elseif(num($st_certificate) == 2){ ?>
					<a href="vip_agendadel.php?id=<?php echo e(u($r[14])) ?>" 
target="popup" 
onClick="window.open('ecert/view.php?kdb=<?php echo e(u($kd_biodata)) ?>&kc=<?php echo e(u($kode_class)) ?>','blank'); return false;" class="btn btn-block btn-success  btn-sm" role="button">
						
					<i class="glyphicon glyphicon-certificate" aria-hidden="true"></i>View</a><br>
				  <input type="hidden" value="<?php echo e($textlink) ?>" id="myInput">
 <button type="button" class="btn btn-block btn-warning btn-xs" onclick="myFunction()">Share Link</button></td>				  
				  <?php } elseif(num($st_certificate) == 1){ ?><strong>Pending</strong><a href="vip_agendadel.php?id=<?php echo e(u($r[14])) ?>" 
target="popup" 
onClick="window.open('ecert/view.php?kdb=<?php echo e(u($kd_biodata)) ?>&kc=<?php echo e(u($kode_class)) ?>','blank'); return false;" class="btn btn-block btn-success  btn-sm" role="button">
						
					<i class="glyphicon glyphicon-certificate" aria-hidden="true"></i>Preview</a></td>
			  <?php } ?>
              
	          <?php 	$adafile = 0; 				$jadwal_1= '';
				$baris_jadwal = ''; 
				$nmfile ='';					
				$lokasifile = '';$baris_teacher ='';$l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';$tgl_la = '';		$tgl_tutor = '';$tgl_lc='';$tgl_ext = '';$kd_st = 4 ; $nama_lengkap_student  ='';}} ?></tr>
            </tbody>
	  
	        <tfoot>
            </tfoot>
          </table>
	    </div>
            <!-- /.box-body -->
      </div>
          <!-- /.box -->
    </div>
        <!-- /.col -->
      </div>
      <!-- /.row --><!-- /.content -->
	</form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->

  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->

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
function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

   // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  alert("Copied the text: " + copyText.value);
}	
</script>
</body>
</html>
<?php 
if (isset($_GET['Export'])) 
{
echo "<script type=\"text/javascript\">\n";
		echo "window.location=('vip_student_recordxl.php?cd_cl=" . e(u($cd_cl)) . "&progress=" . e(u($progress)) . "&ds=" . e(u($date_start)) . "&de=" . e(u($date_end)) . "');\n";				
		echo "</script>";
}
						  
?>
