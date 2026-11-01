<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
$jns= in_val('jns', 'any');
$n= in_val('n', 'any');
$cat= in_val('cat', 'any');

if (num($n) == 0){$judul = "New Category";}
if (num($n) == 1){$judul = "New Sub Category $cat";}

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
<?php //========================== left nav ?>
 <?php //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) --><!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php    //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>
  
    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-8">
      <div class="form-group inline">
		  
        <label><?php echo e($judul) ?></label>
                <span class="form-group">
                <input type="text" class="form-control"  placeholder="Enter ..." name="nama_nilai" value="<?php echo e($nama_nilai) ?>">
                <input type="hidden" name="n" value="<?php echo e($n) ?>">
                </span></div>
      <span class="form-group">
      <input type="hidden" name="cat" value="<?php echo e($cat) ?>">
    </span></div>
</div>
		          <input name="Save" type="submit" id="Save"    value="Save" />
</form>
		          <a href="vip_upfile.php" 
 class="btn btn-primary" role="button"><i class="glyphicon glyphicon-new-window" aria-hidden="true"></i>
Cancel</a> 


</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{
	include __DIR__ . "/conndb.php";
	$n = in_val('n', 'any');
	$nama_nilai = in_val('nama_nilai', 'any');
	$cat= in_val('cat', 'any');
	if (num($n) == 0)
		{
		$query_check = q_set($__p_query_check, "SELECT nm_cat FROM ves_data.file_cat where nm_cat =? ", [(string) ($nama_nilai)]);

		$resource_check_billing = db_query_or_die('errro_last_billing', $query_check, $__p_query_check ?? []);
		if(num(db_num_rows($resource_check_billing)) == 0)
			{
			$query_insert_kd = q_set($__p_query_insert_kd, "insert into ves_data.file_cat(nm_cat)values(? )", [(string) ($nama_nilai)]);
			$resource = db_query_or_die('errro_simpan1', $query_insert_kd, $__p_query_insert_kd ?? []);				
			}
		echo "<script type=\"text/javascript\">\n";
		echo "alert('New Category Added');\n";
		echo "window.location = ('vip_upfile.php');\n";				
		echo "</script>";		
		}
	if (num($n) == 1)
		{
		$query_check = q_set($__p_query_check, "SELECT nm_sub_cat FROM ves_data.file_cat where nm_cat =? and nm_sub_cat = ? ", [(string) ($cat), (string) ($nama_nilai)]);

		$resource_check_billing = db_query_or_die('errro_last_billing', $query_check, $__p_query_check ?? []);
		if(num(db_num_rows($resource_check_billing)) == 0)
			{
			$query_insert_kd = q_set($__p_query_insert_kd, "insert into ves_data.file_cat(nm_cat,nm_sub_cat)values(? ,? )", [(string) ($cat), (string) ($nama_nilai)]);
			$resource = db_query_or_die('errro_simpan1', $query_insert_kd, $__p_query_insert_kd ?? []);				
			}
		echo "<script type=\"text/javascript\">\n";
		echo "alert('New Sub Category Added');\n";
		echo "window.location = ('vip_upfile.php');\n";				
		echo "</script>";		
		}		
	}
?>