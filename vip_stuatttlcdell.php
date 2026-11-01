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
$query_kelas = q_set($__p_query_kelas, "SELECT kelas, kd_branch, mulai_tm  FROM ves_data.vip_teacher_schedule v where id = ? ", [(string) ($nomor)]);
$resource_kelas= db_query_or_die('errro_visitor1', $query_kelas, $__p_query_kelas ?? []);
$keluar_kelas= db_num_rows($resource_kelas);
	if(num(db_num_rows($resource_kelas)) > 0)
		{
		while ($row_kelas =   db_fetch($resource_kelas, PDO::FETCH_NUM))
			{
			$kdcl = $row_kelas[0];
			$_POST['kode_cl'] = $kdcl;
			$kdcbg = $row_kelas[1];	
			$tgl_meeting = $row_kelas[2];	
			$_POST['tgl_hari_itu'] = $tgl_meeting ;
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
 <?php //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
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
	  <div class="col-md-12">
	    <div class="form-group">
	      <label>Class Code : <?php echo e($kdcl) ?></label>
<?php $_POST['kode_kelas'] = $kdcl; ?>

	      <input type="hidden" name="textfield" id="textfield2" value=<?php echo e($kdprg) ?> hidden>

	      <input type="hidden" name="kdcbg" id="textfield4" value=<?php echo e($kdcbg) ?> hidden>
	      <br>
	      <strong>Date : <?php echo e($tgl_meeting) ?>
        </strong></div>
      </div>
	  <div class="col-md-12">
	    <div class="box">
	      <div class="box-header">
	        <h3 class="box-title">Student Registered</h3>
          </div>
	      <!-- /.box-header -->
	      <div class="box-body">
	        <table id="h" class="table table-bordered table-striped">
	          <thead>
	            <tr>
	              <th width="10%">Kd Biodata</th>
	              <th width="10%">Student Name</th>
	              <th width="13%">Program - Class</th>
	              <th width="15%">Center</th>
	              <th width="14%">Status</th>
	              <th width="48%">Registration CHeck</th>
                </tr>
              </thead>
	          <tbody>
	            <?php

$query_namaa = q_set($__p_query_namaa, "SELECT b.nama_lengkap,b.kd_biodata,nm_program, a.level_program, c.type_program,b.kd_branch,d.no FROM ves_data.vip_billing a left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata\r
left join vip_mst_code_prg c on a.kd_program = c.kd_program left join vip_attendance d on a.kd_biodata = d.kd_biodata and d.st_attendance = 1 where d.kd_class = ? and dt_meeting = ?\r
group by kd_biodata, d.kd_class order by b.nama_lengkap", [(string) ($kdcl), (string) ($tgl_meeting)]);					
	
$b = 1;
$resource_namaa= db_query_or_die('errro_visitor1', $query_namaa, $__p_query_namaa ?? []);
if(num(db_num_rows($resource_namaa)) > 0)
	{
	while ($row_namaa  =  db_fetch($resource_namaa, PDO::FETCH_NUM))
		{					$_POST['nou_'.$b] = $row_namaa[6];	
		 		$nou = $_POST['nou_'.$b] ; $ada = 1 ;if(num($ada) == 1){ $st_ada = ' checked';}else  {$st_ada = ' unchecked';$ada = '';}
?>
	            <tr>
	              <td><?php echo e($row_namaa[1]) ?></td>
	              <td><?php echo e($row_namaa[0]) ?>
	                <input type="hidden" name="nou_<?php echo e($b)?>" value="<?php echo e($nou) ?>" id="textfield3"></td>
	              <td><?php echo e($row_namaa[3]) ?> (<?php echo e($row_namaa[4]) ?>)</td>
	              <td>(<?php echo e($row_namaa[5]) ?> ) </td>
	              <td>Registered</td>
	              <td><input type="checkbox" name = 'ada_<?php echo e($b) ?>' class="flat-red" <?php echo e($st_ada) ?>>
	                </input>
                </tr>
	            <?php $b =num($b)+1;  } } ?>
              </tbody>
	          <tfoot>
	            <tr>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td></td>
	              <td><input type="Submit" name="Delete" value="Delete" /></td>
	                </td>
                </tr>
              </tfoot>
	          <tfoot>
              </tfoot>
            </table>
          </div>
	      <!-- /.box-body -->
        </div>
	    <!-- /.box-body -->
      </div>
	  <!-- /.box -->
    </div>
        <!-- /.col -->
  </div>
     <!-- /.row --><!-- /.content -->
<?php		 
if (isset($_POST['Delete'])) 
{

	$batasb = $b;
	for($b=0;$b<=$batasb;$b++) 	
	{
	$nou = $_POST['nou_'.$b] ;	
	$ada_ = $_POST['ada_'.$b];
	if( empty($_POST['ada_'.$b]) ){$checkhdr = 0;}else{$checkhdr = 1;}	

	if (num($checkhdr) ==0 and $nou!='')
		{
	
		$query_absen = q_set($__p_query_absen, "delete from ves_data.vip_attendance where no = ? ", [(string) ($nou)]);	

		$resource_absen= db_query_or_die('errro_visitor3', $query_absen, $__p_query_absen ?? []);
		}			
	}
	echo "<script type=\"text/javascript\">\n";
	echo "window.close();\n";
	echo " window.opener.location.reload();\n";	
	echo "</script>";	
	}

?>
<!-- /.content-wrapper --><!-- Control Sidebar -->
</form>
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
      "ordering": false,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>

	