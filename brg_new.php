<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$c = in_val('c', 'any');
if (num($c) ==1){$jdl = 'New Category';}
elseif (num($c) ==2){$jdl = 'New Sub Category';$cat = in_val('cat', 'any');}
$_GET['c'] = $c;
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
     <?php echo e($jdl) ?><br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
   <div class="box-body">
     <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e($jdl) ?></label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="brg_cat" 
                 	      value="<?php echo e($brg_cat) ?>">
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="cat" 
                 	      value="<?php echo e($cat) ?>">		
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="c" 
                 	      value="<?php echo e($c) ?>">
    </div>
  </div>	   
</div>    

<div class="box-body"></div></form><input type="submit" name="Submit" value="Submit" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
	$c = in_val('c', 'any');
	$brg_cat	 = in_val('brg_cat', 'any');
	$cat = in_val('cat', 'any');
	if (num($c) ==1 ){
	$query_simpan_program = q_set($__p_query_simpan_program, "insert into ves_data.brg_master_cat (brg_cat) values(? )", [(string) ($brg_cat)]);	
	$resource_simpan_score_class = db_query_or_die('errro_simpan2', $query_simpan_program, $__p_query_simpan_program ?? []);
	}
	elseif (num($c) ==2 ){
	$query_simpan_program = q_set($__p_query_simpan_program, "insert into ves_data.brg_master_cat (brg_cat,brg_sub_cat) values(? ,? )", [(string) ($cat), (string) ($brg_cat)]);	
	$resource_simpan_score_class = db_query_or_die('errro_simpan2', $query_simpan_program, $__p_query_simpan_program ?? []);
	}	
	echo "<script type=\"text/javascript\">\n";
	echo "alert('New Category Added');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";		
	}
?>