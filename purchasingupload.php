<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";

$category = in_val('category', 'post');
if ($category == 'Dep 1'){$hrf = 'A';}
elseif ($category == 'Dep 2'){$hrf = 'B';}
elseif ($category == 'Dep 3'){$hrf = 'C';}
elseif ($category == 'Dep 4'){$hrf = 'D';}
$no_purchase = "001/$hrf/III/2020"




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
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Purchasing Form</h1>
    </section>
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php    //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
 <form method="post" action="#" role="form" class="form-horizontal" enctype="multipart/form-data" ><?php echo csrf_field(); ?>
  
    <div class="col-md-12">
    <div class="box box-warning">

<div class="box-body">
	
  <div class="col-md-3">
    <div class="form-group">
      <label>Category</label>
      <select class="form-control"  name="category"   onChange="this.form.submit()" required >
        <option value="Dep 1">Dep 1</option>
        <option value="Dep 2">Dep 2</option>
        <option value="Dep 3">Dep 3</option>
        <option value="Dep 4" >Dep 4</option>
        <option selected><?php echo  e($category) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label> Code</label>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..."  readonly name="id" 
                 	      value="<?php echo e($id) ?>">
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."   name="kode_memo" 
                 	      value="<?php echo e($no_purchase) ?>">
    </div>
  </div>

<div class="col-md-10">
    <div class="form-group">
      <label>Description</label>
      <textarea id="editor1" name="editor1" rows="10" cols="80">
                                          
                    </textarea>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Total Amount</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."   name="subyek_memo" 
                 	      value="<?php echo e($subyek_memo) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Supplier</label>
      <select class="form-control"  name="category5"   onChange="this.form.submit()" required >
        <option value="Dep 1">Dep 1</option>
        <option value="Dep 2">Dep 2</option>
        <option value="Dep 3">Dep 3</option>
        <option value="Dep 4" >Dep 4</option>
        <option selected><?php echo  e($category) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Proposed By</label>
      <select class="form-control"  name="category2"   onChange="this.form.submit()" required >
        <option value="Dep 1">Dep 1</option>
        <option value="Dep 2">Dep 2</option>
        <option value="Dep 3">Dep 3</option>
        <option value="Dep 4" >Dep 4</option>
        <option selected><?php echo  e($category) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Proposed To</label>
      <select class="form-control"  name="category3"   onChange="this.form.submit()" required >
        <option value="Dep 1">Dep 1</option>
        <option value="Dep 2">Dep 2</option>
        <option value="Dep 3">Dep 3</option>
        <option value="Dep 4" >Dep 4</option>
        <option selected><?php echo  e($category) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Acknowledge To</label>
      <select class="form-control"  name="category4"   onChange="this.form.submit()" required >
        <option value="Dep 1">Dep 1</option>
        <option value="Dep 2">Dep 2</option>
        <option value="Dep 3">Dep 3</option>
        <option value="Dep 4" >Dep 4</option>
        <option selected><?php echo  e($category) ?></option>
      </select>
    </div>
  </div>
</div>
<div class="box-body"><br>
  <div class="col-md-8">
    <div class="form-group">
      <label>File Name</label>
      <input id="middle-name2" class="form-control col-md-7 col-xs-12" required="required" type="file" name="fileToUpload">
    </div>
</div>
</div>                         
<div class="box-body"><input type="Submit" name="Submit" value="Submit"  class="btn btn-primary"/></div>

</form>
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