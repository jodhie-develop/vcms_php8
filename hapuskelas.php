<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
//include __DIR__ . "/atas.php";
$kdkdl = in_val('kdkdl', 'any');
$kdt = in_val('kdt', 'any');


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Confirmation Form </h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php    //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
   <div class="box box-warning">
<div class="box box-warning">
<div class="box-body">
  <div class="col-md-6">
    <div class="form-group">
      <label> Click Submit button to to delete this class and teacher </label>
      <label for="textfield">:</label>
      <input type="text" name="kdkdl" id="textfield" value="<?php echo e($kdkdl) ?>">
      <input type="text" name="kdt" id="textfield" value="<?php echo e($kdt) ?>">       
      <input type="submit" name="Submit" value="Submit" />
      
    </div>
  </div>
</div>               	    
<div class="box-body"></div>
</form>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
	$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$kdkdl= in_val('kdkdl', 'any');
$kdt= in_val('kdt', 'any');	

$query_simpan= q_set($__p_query_simpan, "delete FROM ves_data.vip_teacher_schedule where kelas = ? and nm_teacher = ? ", [(string) ($kdkdl), (string) ($kdt)]);
$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
$query_simpan= q_set($__p_query_simpan, "insert into ves_data.log_hapus_data(pic, keterangan, dt_entry) values (? ,? ,? )", [(string) ($nama_lengkap), "hapus data kelas untuk kode : " . (string) ($kdkdl) . " dan teacher : " . (string) ($kdt), (string) ($hari_ini)]);
$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);

echo "<script type=\"text/javascript\">\n";
echo "alert('Class Has been deleted by " . e($nama_lengkap) . "');\n";
echo "window.close();\n";				
echo "</script>";	
}
?>
