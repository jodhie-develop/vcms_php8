<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$kp = in_val('kp', 'get');
$nama_supplier = in_val('nama_supplier', 'post');
$kd_staff = $_SESSION['kd_staff'];
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
	      <label>ID : <?php echo e($kp) ?></label>
	      <input type="hidden" name="textfield" id="textfield2" value=<?php echo e($kdprg) ?> hidden>

	      <input type="hidden" name="kdcbg" id="textfield4" value=<?php echo e($kdcbg) ?> hidden>
	      <input type="hidden" class="form-control"  placeholder="Enter CLass Code" name="kp" value="<?php echo e($kp) ?>">
	      <br>
	    </div>
      </div>
		
	    <div class="box-body">
	      <div class="col-md-12">
	        <div class="col-md-3">
	          <div class="form-group">
	            <label for="exampleInputEmail19">Supplier Name</label>
	            <input type="text" class="form-control" placeholder="Enter ..." name="supplier_name" value="<?php echo  e($supplier_name) ?>" required>
              </div>
            </div>
	        <div class="col-md-3">
	          <div class="form-group">
	            <label for="exampleInputEmail20">Supplier Phone</label>
	            <input type="text" class="form-control" placeholder="Enter ..." name="supplier_phone" value="<?php echo  e($supplier_phone) ?>">
              </div>
            </div>
	        <div class="col-md-3">
	          <div class="form-group">
	            <label for="exampleInputEmail10">Supplier NPWP</label>
	            <input type="text" class="form-control" placeholder="Enter ..." name="supplier_npwp" value="<?php echo  e($supplier_npwp) ?>">
              </div>
            </div>
	        <div class="col-md-3">
	          <div class="form-group">
	            <label for="exampleInputEmail7">Supplier PIC</label>
	            <input type="text" class="form-control" placeholder="Enter ..." name="supplier_pic" value="<?php echo  e($supplier_pic) ?>">
              </div>
            </div>
	        <div class="col-md-3">
	          <div class="form-group">
	            <label for="exampleInputEmail9">PIC  Phone</label>
	            <input type="text" class="form-control" placeholder="Enter ..." name="supplier_pic_phone" value="<?php echo  e($supplier_pic_phone) ?>" required>
              </div>
            </div>
	        <div class="col-md-6">
	          <div class="form-group">
	            <label for="exampleInputEmail21">Address</label>
	            <input type="text" class="form-control" placeholder="Enter ..." name="supplier_address" value="<?php echo  e($supplier_address) ?>">
              </div>
            </div>
	        <div class="col-md-3">
	          <div class="form-group">
	            <label for="exampleInputEmail22">Bank</label>
	            <input type="text" class="form-control" placeholder="Enter ..." name="supplier_bank" value="<?php echo  e($supplier_bank) ?>" required>
              </div>
            </div>
	        <div class="col-md-3">
	          <div class="form-group">
	            <label for="exampleInputEmail23">A/N</label>
	            <input type="text" class="form-control" placeholder="Enter ..." name="supplier_bank_account" value="<?php echo  e($supplier_bank_account) ?>" required>
              </div>
            </div>
	        <div class="col-md-3">
	          <div class="form-group">
	            <label for="exampleInputEmail24">No Rek</label>
	            <input type="text" class="form-control" placeholder="Enter ..." name="supplier_bank_rekening" value="<?php echo  e($supplier_bank_rekening) ?>" required>
              </div>
            </div>
          </div>
	      <!-- /.bodfx-header -->
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
$supplier_name = in_val('supplier_name', 'post');
	$supplier_phone = in_val('supplier_phone', 'post');
	$supplier_npwp = in_val('supplier_npwp', 'post');
	$supplier_pic = in_val('supplier_pic', 'post');
	$supplier_pic_phone = in_val('supplier_pic_phone', 'post');
	$supplier_npwp = in_val('supplier_npwp', 'post');
	
	$supplier_address = in_val('supplier_address', 'post');
	$supplier_bank = in_val('supplier_bank', 'post');
	$supplier_bank_account = in_val('supplier_bank_account', 'post');
	$supplier_bank_rekening = in_val('supplier_bank_rekening', 'post');
	$email_pemohon = in_val('email_pemohon', 'post');
	$email_tujuan = in_val('email_tujuan', 'post');
	$kp = in_val('kp', 'get');
	$query_insert_po = q_set($__p_query_insert_po, "insert into ves_data.purchase_supplier (sup_name, sup_phone, sup_npwp, sup_pic, sup_pic_phone, sup_address, sup_bank, sup_bank_account, sup_rekening,kd_staff ) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($supplier_name), (string) ($supplier_phone), (string) ($supplier_npwp), (string) ($supplier_pic), (string) ($supplier_pic_phone), (string) ($supplier_address), (string) ($supplier_bank), (string) ($supplier_bank_account), (string) ($supplier_bank_rekening), (string) ($kd_staff)]);	
	$resource_urut_po = db_query_or_die('errro_3', $query_insert_po, $__p_query_insert_po ?? []);	

	$query_sup_pilih = q_set($__p_query_sup_pilih, "select id from  ves_data.purchase_supplier where sup_name = ? and sup_phone = ? and sup_npwp = ? and sup_pic = ? and sup_pic_phone = ? and sup_address = ? and sup_rekening = ? ", [(string) ($supplier_name), (string) ($supplier_phone), (string) ($supplier_npwp), (string) ($supplier_pic), (string) ($supplier_pic_phone), (string) ($supplier_address), (string) ($supplier_bank_rekening)]);

	$resource_sup_pilih= db_query_or_die('errro_visitor1', $query_sup_pilih, $__p_query_sup_pilih ?? []);
	if(num(db_num_rows($resource_sup_pilih)) > 0)
		{
		while ($row_sup_pilih  =  db_fetch($resource_sup_pilih, PDO::FETCH_NUM))
			{	
			$kode_sup = $row_sup_pilih[0];
			$query_absen = q_set($__p_query_absen, "update  ves_data.purchase_order set supplier_kd = ? where kode = ? ", [(string) ($kode_sup), (string) ($kp)]);

			$resource_absen= db_query_or_die('errro_visitor3', $query_absen, $__p_query_absen ?? []);
			}
		}
	
	echo "<script type=\"text/javascript\">\n";
	echo "window.close();\n";
	echo " window.opener.location.reload();\n";	
	echo "</script>";
	}
?>
<div class="box">

  <div class="box-footer">
    <button type="submit" class="btn btn-primary"   name="Submit" value="Submit">Submit</button>
  </div>

</div>
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

	