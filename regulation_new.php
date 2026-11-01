<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";

$id = in_val('id', 'get');




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
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Upload Scope &amp; Sequence Form</h1>
    </section>
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php    //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
 <form method="post" action="rulesmemouploadsave.php" role="form" class="form-horizontal" enctype="multipart/form-data" ><?php echo csrf_field(); ?>
  
    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">

  <div class="col-md-3">
    <div class="form-group">
      <label>Corporate</label>
      <select class="form-control select2" style="width: 100%;" name="corporate">
        <option value="VIC">VIC</option>
        <option value="VE">VE</option>
        <option value="LIUMEDIA">LIUMEDIA</option>
        <option selected><?php echo e($corporate) ?></option>
    </select>
    </div>
	</div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Department</label>
      <select class="form-control select2" style="width: 100%;" name="department">
        <option value="Marketing and Sales">Marketing and Sales</option>
        <option value="Opr - Academic">Opr - Academic</option>
        <option value="Opr - IT">Opr - IT</option>
        <option value="Opr - HR">Opr - HR</option>
        <option value="Opr - GA">Opr - GA</option>
        <option value="Accounting">Accounting</option>
        <option selected><?php echo e($department) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Center</label>
      <select class="form-control select2" style="width: 100%;" name="kd_cbg">
        <option value="0">--CHOOSE--</option>
        <option value="001">East Sby</option>
        <option value="002">West Sby</option>
        <option value="003">Denpasar</option>
        <option value="008">Malang</option>
        <option value="101">East Area</option>
        <option value="004">South Jkt</option>
        <option value="005">North Jkt</option>
        <option value="006">West Jkt</option>
        <option value="007">Bandung</option>
        <option value="102">West Area</option>
        <option value="100">Online</option>
        <option value="000">HO</option>
        <option selected><?php echo e($cabang) ?></option>
      </select>
    </div>
  </div>	
</div>
<div class="box-body">
  <div class="col-md-6">
    <div class="form-group">
      <label>Name/Title</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."   name="nama_memo" 
                 	      value="<?php echo e($nama_memo) ?>">
    </div>
</div>	
  <div class="col-md-8">
    <div class="form-group">
      <label>Description</label>
      <textarea id="editor1" name="editor1" rows="10" cols="80">
                                          
                    </textarea>
    </div>
</div>	
  <div class="col-md-8">
    <div class="form-group">
      <label>File Name</label>
      <input id="middle-name2" class="form-control col-md-7 col-xs-12" required="required" type="file" name="fileToUpload">
    </div>
</div>	
		</div>	
</div>





</div>
<div class="box-body"><br>

</div>                         
<div class="box-body"><input type="Submit" name="Submit" value="Submit"  class="btn btn-primary"/></div>

</form>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="plugins/ckeditor/ckeditor.js"></script>		
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
</body>
</html>