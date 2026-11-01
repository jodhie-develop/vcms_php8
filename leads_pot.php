<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
$class_code = in_val('cdl', 'any');
$cabang = in_val('cbg', 'any');
$start_date = in_val('start_date', 'any');
$end_date = in_val('end_date', 'any');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$fp = in_val('fp', 'any');
$no_doc = in_val('no_doc', 'any');
$hari_ini = "$tahun-$bulan-$hari";
if ($start_date==""){$start_date = "$tahun-$bulan-01";}
if ($end_date==""){$end_date = "$tahun-$bulan-31";}
include __DIR__ . "/conndb.php";
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];

$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;	
$kd_student = in_val('kdb', 'any');
$query_bio = q_set($__p_query_bio, "SELECT nama, middle_name,family_name,branch, kd_branch FROM ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($kd_student)]);
$resource_bio = db_query_soft($query_bio, $__p_query_bio ?? []);
$keluar_bio = db_num_rows($resource_bio);
if(num(db_num_rows($resource_bio)) > 0)
	{
	while ($row_bio   =  db_fetch($resource_bio, PDO::FETCH_NUM))
		{
		$nama = $row_bio['0'];
		$middle_name = $row_bio['1'];
		$family_name = $row_bio['2'];
		$branch = $row_bio['3'];
//		$kd_branch = $row_bio['4'];
		}
	}

			
//include __DIR__ . "/profiledata.php";
 //include __DIR__ . "/atas.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Follow Up History</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>   

  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- 

 
 side column. contains the logo and sidebar -->
  <?php    //  include __DIR__ . "/left.php";	 ?>
<form method="post"><?php echo csrf_field(); ?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Potential Enrollment Input</h1>
    </section>

    <!-- Main content -->
<section class="content">
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($nama) ?> <?php echo  e($middle_name) ?> <?php echo  e($family_name) ?>" readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Add Target to Date</label>
      <input type="Date" ang="en-150" class="form-control"  placeholder="Enter ..." name="date_target" 
                 	      value="<?php echo e($date_target) ?>">
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>Remark</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="pot_remark" 
                 	      value="<?php echo e($pot_remark) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Group</label>
 <select name="kelompok"  class="form-control">
	 				<option>VIP</option>	
	 				<option>VES</option>	
                	 <option selected><?php echo e($kelompok) ?></option>
			</select>
    </div>
  </div>
  <span class="form-group">
		<input type="hidden"name="kd_student" value="<?php echo e($kd_student) ?>" >
  </span>  <span class="form-group">
	<input type="text"name="kd_branch" 
                 	      value="<?php echo e($kd_branch) ?>" hidden="hidden" >
	</span><span class="form-group">
	<input type="text"name="fp" 
                 	      value="<?php echo e($fp) ?>" hidden="hidden">
	</span><span class="form-group">
	<input type="text"name="no_doc" 
                 	      value="<?php echo e($no_doc) ?>" hidden="hidden">
	</span></div>	
<div class="row">

 <div class="box-header with-border"></div>     	  
	  <div class="col-md-8"><div class="box-header with-border"><button type="submit" class="btn btn-danger" name="Submit" value="Submit">Submit</button></div>
	  </div>
  </form>


    <!-- Horizontal Form -->
          <!-- /.box -->
          <!-- general form elements disabled -->
		  
            
            <!-- /.box-header --><!-- /.box-body --><!-- /.box --><!--/.col (right) --><!-- /.row --><!-- /.content -->
  </div>
  <!-- /.content-wrapper --><!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;	
$date_target = in_val('date_target', 'any');
$kd_student = in_val('kd_student', 'any');	
$pot_remark = in_val('pot_remark', 'any');	
$kelompok = in_val('kelompok', 'any');		
$sql_simpan_status = q_set($__p_sql_simpan_status, "insert into ves_data.tb_prospect(pic, kd_branch, kd_biodata, remark, dt_target, status,kelompok ) values (? ,? ,? ,? ,? ,'1',? )", [(string) ($nama_lengkap), (string) ($kd_cbg), (string) ($kd_student), (string) ($pot_remark), (string) ($date_target), (string) ($kelompok)]);

$resource_simpan = db_query_or_die('errro_simpan', $sql_simpan_status, $__p_sql_simpan_status ?? []);	
echo "<script type=\"text/javascript\">\n";
echo "alert('Add to Potential Student');\n";
echo "window.opener.location.reload(true);\n";					
echo "window.close();\n";
echo "</script>";
}
?>
