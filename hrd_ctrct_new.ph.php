<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";

$hr_id = in_val('id', 'get');




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

<section class="content">
  <div class="row">
        <!-- left column -->
<?php    //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
 <form method="post" action="hrd_ctrct_newsave.php" role="form" class="form-horizontal" enctype="multipart/form-data" ><?php echo csrf_field(); ?>
  

    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-3">
    <div class="form-group">
      <label> Contract Number</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."   name="contract_no" 
                 	      value="<?php echo e($contract_no) ?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Contract Type</label>
      <select class="form-control select2" style="width: 100%;" name="contract_type">
        <option>FT</option>
        <option>PKWT</option>
        <option>PKWTT</option>
        <option>PTT</option>
        <option>SFT</option>
        <option selected="selected"><?php echo e($contract_type) ?></option>
    </select>
    </div>
  </div>	
</div>
<div class="box-body">
  <div class="col-md-3">
    <div class="form-group">
      <label> Contract Start</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..."   name="start_contract" 
                 	      value="<?php echo e($start_contract) ?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label> Contract End</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..."   name="end_contract" 
                 	      value="<?php echo e($end_contract) ?>">
    </div>
  </div>
</div>
<div class="box-body">	
  
  <div class="col-md-6">
    <div class="form-group">
      <label> Contract Subject</label>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..."  readonly name="id2" 
                 	      value="<?php echo e($id) ?>">
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."   name="catatan_title" 
                 	      value="<?php echo e($catatan_title) ?>">
    </div>
  </div>
  <div class="col-md-8">
    <div class="form-group">
      <label>Description</label>
      <textarea id="editor1" name="catatan" rows="10" cols="80">
                                          
                    </textarea>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..."   name="hr_id" 
                 	      value="<?php echo e($hr_id) ?>">
    </div>
</div>
  <div class="col-md-8">
    <div class="form-group">
      <label>File Name</label>
      <input id="middle-name2" class="form-control col-md-7 col-xs-12" required="required" type="file" name="fileToUpload">
    </div>
</div>	
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