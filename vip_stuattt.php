<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$q = in_val('q', 'get');
if($q==''){$q='t';}
$tampilan = in_val('tampilan', 'get');
$kode_teacher = in_val('nm_teacher', 'get');
$posisi = $_SESSION['posisi']; 

$center = in_val('center', 'get');
if ($center==""){$center = "--ALL--";}

if ($tampilan==""){$tampilan = "Teachers Calendar";}
if ($tampilan == "Teachers Calendar") 
	{$q='t';}
else
	{$q='r';}

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kdcbg = in_val('kdcbg', 'get');


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kd_area'] ;
$level_posisi = $_SESSION['level_posisi'] ;
$kdcl = in_val('kdcl', 'get');
$kdcbg = in_val('kdcbg', 'get');

$nomor = in_val('no', 'get');


//--ambil tanggal kelas
$query_kelas = q_set($__p_query_kelas, "SELECT kelas, kd_branch, mulai_tm,kd_biodata,status_kelas  FROM ves_data.vip_teacher_schedule v where id = ? ", [(string) ($nomor)]);
$resource_kelas= db_query_or_die('errro_visitor128', $query_kelas, $__p_query_kelas ?? []);
$keluar_kelas= db_num_rows($resource_kelas);
	if(num(db_num_rows($resource_kelas)) > 0)
		{
		while ($row_kelas =   db_fetch($resource_kelas, PDO::FETCH_NUM))
			{
			$kdcl = $row_kelas[0];
			$_POST['kode_cl'] = $kdcl;
			$kdcbg = $row_kelas[1];	
			$tgl_meeting = $row_kelas[2];
			$kd_biodata = $row_kelas[3];
			$status_kelas = $row_kelas[4];$_POST['tgl_hari_itu'] = $tgl_meeting;	
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

  <!-- Content Wrapper. Contains page content -->
     <form name="form1" method="post" action="#"><?php echo csrf_field(); ?>

  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
  <div class="box box-warning">
	<div class="box-body">
	  <div class="col-12">
	    <div class="form-group">
	      <label>Class Code : <?php echo e($kdcl) ?></label>


	      <input type="hidden" name="textfield" id="textfield2" value=<?php echo e($kdprg) ?> hidden>

	      <input type="hidden" name="kdcbg" id="textfield4" value=<?php echo e($kdcbg) ?> hidden>
	    </div>
      </div>
	  <div class="col-12">
	    <div class="form-group">
	      <label>Date : <?php echo e($tgl_meeting); ?></label>


	      <input type="hidden" name="textfield" id="textfield2" value=<?php echo e($kdprg) ?> hidden>

	      <input type="hidden" name="kdcbg" id="textfield4" value=<?php echo e($kdcbg) ?> hidden>
	    </div>
      </div>		
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Attendance Record</label>
		</div>				
	  </div>
  <form name="form1" method="post" action="#"><?php echo csrf_field(); ?>

	  <div class="col-md-12">
	    <div class="form-group">
	      <table  width="100%" class="table table-bordered table-striped" id="">
	        <tbody>
	          <tr>
	            <td width="15%">Student Name</td>
	            <td width="7%">Attendance</td>
	            <td width="11%">Skill Recomendation</td>
	            <td width="67%">LC Recommendation</td>
              </tr>
<?php 
	$a = 1;

$query_ambil_data_student = q_set($__p_query_ambil_data_student, "select a.kd_biodata from vip_billing a where a.kd_class = ? ", [(string) ($kdcl)]);
$resource_ambil_data_student= db_query_or_die('errro_visitor112', $query_ambil_data_student, $__p_query_ambil_data_student ?? []);

	if(num(db_num_rows($resource_ambil_data_student)) > 0)
		{
		while ($row_ambil_data_student =   db_fetch($resource_ambil_data_student, PDO::FETCH_NUM))
			{
			$query_cek_student_tgl_meeting  = q_set($__p_query_cek_student_tgl_meeting, "SELECT kd_biodata FROM vip_attendance where kd_class = ? and kd_biodata = ? and dt_meeting = ? ", [(string) ($kdcl), (string) ($row_ambil_data_student[0]), (string) ($tgl_meeting)]);
			$resource_cek_student_tgl_meeting= db_query_or_die('errro_visitor122', $query_cek_student_tgl_meeting, $__p_query_cek_student_tgl_meeting ?? []);
			if(num(db_num_rows($resource_cek_student_tgl_meeting)) == 0)
				{
				$query_absen = q_set($__p_query_absen, "insert into ves_data.vip_attendance (kd_class, kd_branch, kd_biodata, dt_meeting,st_attendance,dt_entry, pic) values(? ,? ,? ,? ,'0',? ,? )", [(string) ($kdcl), (string) ($kdcbg), (string) ($row_ambil_data_student[0]), (string) ($tgl_meeting), (string) ($hari_ini), (string) ($nama_lengkap)]);
				$resource_absen= db_query_or_die('errro_visitor132', $query_absen, $__p_query_absen ?? []);
				}
			}
		}
			 
				 
$query_absensi = q_set($__p_query_absensi, "SELECT  a.kd_biodata, dt_meeting,nama_lengkap, st_attendance,c.no FROM ves_data.vip_billing a\r
left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata\r
left join ves_data.vip_attendance c on a.kd_biodata = c.kd_biodata\r
where a.kd_class = ?  and dt_meeting = ? group by a.kd_biodata", [(string) ($kdcl), (string) ($tgl_meeting)]);
$resource_absensi= db_query_or_die('errro_visitor124', $query_absensi, $__p_query_absensi ?? []);

if(num(db_num_rows($resource_absensi)) > 0)
	{
	
	
		while ($row_absensi =   db_fetch($resource_absensi, PDO::FETCH_NUM))
			{	
			$id_absensi = $row_absensi[4];
			if(num($row_absensi[3]) == 1){ $st_hadir = ' checked';}else  {$st_hadir = ' unchecked';} 
			$query_baca_lc_recom = q_set($__p_query_baca_lc_recom, "SELECT lc_recommendation,lc_skill_recommendation FROM ves_data.lc_student_history where tgl_meeting = ? and kd_biodata = ? ", [(string) ($row_absensi[1]), (string) ($row_absensi[0])]);
			$resource_baca_lc_recom= db_query_or_die('errro_visitor124', $query_baca_lc_recom, $__p_query_baca_lc_recom ?? []);
			if(num(db_num_rows($resource_baca_lc_recom)) > 0)
				{
					while ($row_baca_lc_recom=   db_fetch($resource_baca_lc_recom, PDO::FETCH_NUM))
						{
						$lc_recom = $row_baca_lc_recom[0];
						$lc_skill_recommendation = $row_baca_lc_recom[1];						
						}
				}
			else
				{
				$lc_recom ='';
				}
?>				
	          <tr>
	            <td><?php echo e($row_absensi[2]); ?>
	   
                <input type="text" name="kd_biodata_<?php echo e($a) ?>" id="textfield" value="<?php echo e($row_absensi[0]) ?>" hidden=""></td>
	            <td><input type="checkbox" name = 'kehadiran_<?php echo e($a) ?>' class="flat-red" <?php echo e($st_hadir) ?>></td>
	            <td><select class="form-control select2" style="width: 60%;" name="lc_skill_recommendation_<?php echo e($a) ?>">
	              <option value="-">-</option>					
	              <option value="L">L</option>
	              <option value="R">R</option>
	              <option value="S">S</option>
	              <option value="W">W</option>
	              <option selected><?php echo e($lc_skill_recommendation) ?></option>
                </select></td>
	            <td><textarea name="lc_recommendation_<?php echo e($a) ?>" id="textarea" rows="2" cols="70"><?php echo e($lc_recom) ?></textarea></td>
              </tr>
<?php $a = num($a)+1; } } ?>				
	          <tr>
	            <td> <input type="Submit" name="Submit" value="Submit" /></td>
	            <td>&nbsp;</td>
	            <td>&nbsp;</td>
	            <td>&nbsp;</td>
              </tr>
            </tbody>
          </table>

        </div>
            <!-- /.box-body -->
	  </div>
	  <!-- /.box -->
    </div>
        <!-- /.col -->
  </div>
     <!-- /.row --><!-- /.content -->

<!-- /.content-wrapper --><!-- Control Sidebar -->
   <?php 
if (isset($_POST['Submit'])) 
{
	$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$kdcl = in_val('kode_cl', 'post');
	$kdcbg = in_val('kdcbg', 'post');	
$tot_salah = 0;
	$tgl_meeting = in_val('tgl_hari_itu', 'post') ;
//$kehadiran = in_val('kehadiran_1', 'post');
	$batas = $a;
	for($a=1;$a<=$batas;$a++) 
		{

		$kehadiran = $_POST['kehadiran_'.$a];
		if( empty($_POST['kehadiran_'.$a]) ){$kehadiran = 0;}else{$kehadiran = 1;}			
		$lc_recommendation = $_POST['lc_recommendation_'.$a];
		$lc_skill_recommendation = $_POST['lc_skill_recommendation_'.$a];		
		if ($lc_recommendation =='' or $lc_skill_recommendation =='')
			{
			if (num($kehadiran) ==1)
				{
				$salah = 1;
				}
			else
				{
				$salah = 0;
				}
			}
			else
			{
			$salah = 0;
			}

		$kd_biodata = $_POST['kd_biodata_'.$a ];
		if ($kd_biodata != '')
		{
		$query_check = q_set($__p_query_check, "SELECT v.kd_class, v.kd_branch, v.kd_biodata, v.dt_meeting FROM ves_data.vip_attendance v where kd_class = ? and dt_meeting = ? and kd_biodata = ? ", [(string) ($kdcl), (string) ($tgl_meeting), (string) ($kd_biodata)]);

		$resource_check= db_query_or_die('errro_visitor16', $query_check, $__p_query_check ?? []);
		$keluar_check= db_num_rows($resource_check);
		if(num(db_num_rows($resource_check)) > 0)
			{
			
			$query_absen = q_set($__p_query_absen, "update ves_data.vip_attendance  set st_attendance = ? ,dt_entry = ? ,pic= ? where kd_class = ?  and dt_meeting = ? and kd_biodata = ? ", [(string) ($kehadiran), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kdcl), (string) ($tgl_meeting), (string) ($kd_biodata)]);
		
			if ($lc_recommendation !='')
				{
				$query_lc_recom= q_set($__p_query_lc_recom, "SELECT * FROM lc_student_history where kd_biodata = ? and kd_class = ? and tgl_meeting = ? ", [(string) ($kd_biodata), (string) ($kdcl), (string) ($tgl_meeting)]);
				$resource_lc_recom= db_query_or_die('errro_visitorcari', $query_lc_recom, $__p_query_lc_recom ?? []);
				if(num(db_num_rows($resource_lc_recom)) > 0)
					{
					$query_lc_recom_upd= q_set($__p_query_lc_recom_upd, "update lc_student_history set lc_recommendation = ? ,lc_skill_recommendation = ? where kd_biodata = ? and kd_class = ? and tgl_meeting = ? ", [(string) ($lc_recommendation), (string) ($lc_skill_recommendation), (string) ($kd_biodata), (string) ($kdcl), (string) ($tgl_meeting)]);
					$resource_lc_recom_upd= db_query_or_die('errro_visitorupd', $query_lc_recom_upd, $__p_query_lc_recom_upd ?? []);
					}
				else
					{
					$query_lc_recom_input= q_set($__p_query_lc_recom_input, "insert into  lc_student_history (lc_recommendation, kd_biodata, kd_class, tgl_meeting,lc_skill_recommendation) values (? ,? ,? ,? ,? )", [(string) ($lc_recommendation), (string) ($kd_biodata), (string) ($kdcl), (string) ($tgl_meeting), (string) ($lc_skill_recommendation)]);
					
				$resource_lc_recom_input= db_query_or_die('errro_visitorinp2', $query_lc_recom_input, $__p_query_lc_recom_input ?? []);
					}
				
				}						
			}
		else
			{
			$query_absen = q_set($__p_query_absen, "insert into ves_data.vip_attendance (kd_class, kd_branch, kd_biodata, dt_meeting,st_attendance,dt_entry, pic) values(? ,? ,? ,? ,? ,? ,? )", [(string) ($kdcl), (string) ($kdcbg), (string) ($kd_biodata), (string) ($tgl_meeting), (string) ($kehadiran), (string) ($hari_ini), (string) ($nama_lengkap)]);
			if ($lc_recommendation !='')
				{			
				$query_lc_recom_input= q_set($__p_query_lc_recom_input, "insert into  lc_student_history (lc_recommendation, kd_biodata, kd_class, tgl_meeting,lc_skill_recommendation) values (? ,? ,? ,? ,? )", [(string) ($lc_recommendation), (string) ($kd_biodata), (string) ($kdcl), (string) ($tgl_meeting), (string) ($lc_skill_recommendation)]);
					
				$resource_lc_recom_input= db_query_or_die('errro_visitorinp1', $query_lc_recom_input, $__p_query_lc_recom_input ?? []);
				}
				}

			$resource_absen= db_query_or_die('errro_visitor3', $query_absen, $__p_query_absen ?? []);
		}	


			echo e($salah);
		$tot_salah = num($tot_salah) + num($salah);
		}
	if (num($tot_salah) != 0)
		{
					echo "<script type=\"text/javascript\">\n";
			echo "alert('All LC Skill and Recommendation for the attend Student must be filled ');\n";	
					echo "window.location = ('vip_stuattt.php?no=" . e(u($nomor)) . "');\n";		
			echo "</script>";				
			die;
		}
	else
		{
						echo "<script type=\"text/javascript\">\n";
				echo "window.close();\n";
				echo " window.opener.location.reload();\n";	
				echo "</script>";	
		}

	die;	
}
?></form> 
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

	