<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$load = in_val('load', 'get');
$kode_po = in_val('kode_po', 'get');
$nama_pemohon = $_SESSION['nama_lengkap'];
$kd_staff = $_SESSION['kd_staff']; 

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Purchase Order</title>
  <!-- Tell the browser to be responsive to screen width -->
	  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">	
    <script type="text/javascript" src="cdnjs/jquery.min.js"></script> 
    <link type="text/css" href="js-lib/jquery-ui.css" rel="stylesheet"> 

    <script type="text/javascript" src="sign_script/js/jquery-ui.min.js"></script>
  <!-- Ionicons -->
 
    <script type="text/javascript" src="sign_script/js/jquery.signature.min.js"></script>
    <link rel="stylesheet" type="text/css" href="sign_script//css/jquery.signature.css">
  
    <style>
        .kbw-signature { width: 400px; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>	

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php //  include ('left.php') ?>
     <form name="form1" method="POST" action="#"  enctype="multipart/form-data"><?php echo csrf_field(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
			<div class="col-md-8">	  		
      <h1>
        E-Sign Speciment<span class="form-group">
        <input type="hidden" name="load" class="form-control" id="exampleInputEmail4" value="<?php echo e($load) ?>">
        </span></h1>
          <span class="form-group">
          <input type="text" name="kd_staff" class="form-control" id="exampleInputEmail" value="<?php echo e($kd_staff) ?>">
		  
      </span>

      <h1><span class="form-group">      </span></h1>
				</di>
	  </div></section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">User Information</h3>
            </div>
		  </div>
	    </div>
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="col-md-6">
                <div class="form-group">
                <label for="exampleInputEmail2">Name</label>
                <input type="text" name="nama_pemohon" class="form-control" id="exampleInputEmail2" placeholder="Your Name" value="<?php echo e($nama_pemohon) ?>">
              </div>					  
			  </div>
				  <div class="col-md-6">
				    <div class="form-group">
				      <label for="exampleInputEmail6">E-Mail</label>
				      <input type="email" name="email_pemohon" class="form-control" id="exampleInputEmail6" placeholder="Your Email" value="<?php echo e($email_pemohon) ?>">
			        </div>
		      </div>


            </div>
              <!-- /.box-body -->

              
              <div class="col-md-6">
            <label class="" for="">Signature:</label>
            <br/>
            <div id="sig" ></div>
            <br/>
            <button id="clear">Clear Signature</button>
            <textarea id="signature64" name="signed" style="display: none"></textarea>
        </div> 
          </div>
          <!-- /.box -->

          <!-- Form Element sizes --><!-- /.box --><!-- /.box -->

          <!-- Input addon --><!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
<
	    <div class="col-md-8">
	      <!-- Horizontal Form -->
	      <div class="box">
		
	<div class="box-footer">
		<button type="submit" class="btn btn-primary"   name="Submit" value="Submit">Submit</button>
	
			</div>
				
					</div></div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
			
	</form>
		

</div>
<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>
</body>
</html>
	<?php 
if (isset($_POST['Submit'])) 
{
  	$nama_pemohon = in_val('nama_pemohon', 'post');
  	$email_pemohon = in_val('email_pemohon', 'post');
$kd_staff = $_SESSION['kd_staff']; 
	
    $folderPath = "e_sign/speciment/";
  
    $file = upload_save_dataurl((string) in_val('signed', 'post'), $folderPath);   // tipe dari isi, nama acak
if ($file === false) { exit('<script>alert(' . js(upload_error()) . '); history.back();</script>'); }
$query_update_po_item = q_set($__p_query_update_po_item, "update ves_data.tb_user  set e_mail = ? ,e_sign = ? where no = ? ", [(string) ($email_pemohon), (string) ($file), (string) ($kd_staff)]);	
$resource_update_po_item = db_query_or_die('errro_1', $query_update_po_item, $__p_query_update_po_item ?? []);
	
	echo "<script type=\"text/javascript\">\n";
	echo "alert('E-Sign anda sudah dibuat');\n";
	echo "window.location = ('purchasinglist.php');\n";		
	echo "</script>";
}
?>