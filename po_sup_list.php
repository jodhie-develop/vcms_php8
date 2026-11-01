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
	  <div class="col-md-12">
  <div class="box">
            <div class="box-header">
              <h3 class="box-title">Supplier List</h3>
            </div>
            <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
               
                <tr>
                  <th>Supplier  Name</th>
                  <th colspan="2"><input type="text" class="form-control"  placeholder="Supplier Search" name="nama_supplier" value="<?php echo e($nama_supplier) ?>"></th>
                  <th><input type="Submit" name="Display" value="Display" /></th>
                  <th>            <button><a href="po_sup_new.php?kp=<?php echo e(u($kp)); ?>">New Supplier</a></button></th>
                  <th>&nbsp;</th>
                </tr>
                <tr>
                  <th width="10%">&nbsp;</th>
                  <th width="10%">&nbsp;</th>
                  <th width="13%">&nbsp;</th>
                  <th width="15%">&nbsp;</th>
                  <th width="14%">&nbsp;</th>
                  <th width="48%">&nbsp;</th>
                </tr>


          </table>
				
          <table id="example1" class="table table-bordered table-striped">
               
            <tr>
              <th>&nbsp;</th>
              <th colspan="2">&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
                  <th>&nbsp;</th>
              <th><input type="Submit" name="Submit" value="Submit" /></td><td width="7%"></th>
            </tr>
            <tr>
              <th width="5%">No</th>
              <th width="5%">Supplier Name</th>
              <th width="6%">Address - Phone</th>
              <th width="20%">NPWP</th>
              <th width="22%">Contack Person Information</th>
                  <th width="10%">Bank Information</th>
              <th width="25%">Registration CHeck</th>
            </tr>
                
            <tbody>
<?php
if ($nama_supplier !=''){
$query_nama = q_set($__p_query_nama, "SELECT sup_name, sup_address, sup_phone, sup_npwp, sup_pic, sup_pic_phone, sup_bank,sup_bank_account, sup_rekening,id  FROM ves_data.purchase_supplier where kd_staff = ? and sup_name like ? order by sup_name ", [(string) ($kd_staff), "%" . (string) ($nama_supplier) . "%"]);}			
else {
$query_nama = q_set($__p_query_nama, "SELECT sup_name, sup_address, sup_phone, sup_npwp, sup_pic, sup_pic_phone, sup_bank,sup_bank_account, sup_rekening,id  FROM ves_data.purchase_supplier  where kd_staff = ? order by sup_name ", [(string) ($kd_staff)]);		
}	

$a = 1;
$resource_nama= db_query_or_die('errro_visitor1', $query_nama, $__p_query_nama ?? []);
if(num(db_num_rows($resource_nama)) > 0)
	{
	while ($row_nama  =  db_fetch($resource_nama, PDO::FETCH_NUM))
		{					$kd = $row_nama[9];	
		 		 $hadir = 0 ;if(num($hadir) == 1){ $st_hadir = ' checked';}else  {$st_hadir = ' unchecked';$hadir = '';}
		 		$_POST['kd'.$a]= $kd;
		 		$no_urut = $a;
?>					
              <tr>
                <td><?php echo e($a)  ?></td>
                <td><?php echo e($row_nama[0])  ?>
                <input type="hidden" name="no_urut<?php $a ?>" id="textfield" value="<?php echo e($a) ?>"></td>
                <td><?php echo e($row_nama[1])  ?><br>
                <?php echo e($row_nama[2])  ?></td>
                <td><?php echo e($row_nama[3]) ?></td>
				<td><?php echo e($row_nama[4]) ?><br>
				  <?php echo e($row_nama[5]) ?><br>
				<td><?php echo e($row_nama[6]) ?><br>
                  <?php echo e($row_nama[7]) ?><br>
                <?php echo e($row_nama[8]) ?>                                
				<td><input type="checkbox" name = 'check_hadir<?php echo e($a) ?>' class="flat-red" <?php echo e($st_hadir) ?>></input>

              </tr>

<?php $a =num($a)+1;  } }  ?>		
            </tbody>
	<tfoot>                <tr>
	  <td>&nbsp;</td>
                  <td></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
            </tr></tfoot>
	
          
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
<!-- /.content-wrapper --><!-- Control Sidebar -->
	
<?php		 
if (isset($_POST['Submit'])) 
{
	$kp = in_val('kp', 'post');

	
	$batas = $a;
	for($a=0;$a<=$batas;$a++) 	
	{
	$check_hadir = $_POST['check_hadir'.$a];
	if( empty($_POST['check_hadir'.$a]) ){$check = 0;}else{$check = 1;}	
	$kd = $_POST['kd'.$a];
	if (num($check) ==1)
		{
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('po_sup_upd.php?kp=" . e(u($kp)) . "&kd=" . e(u($kd)) . "');\n";	
		echo "</script>";}	
		//$query_absen = "update  ves_data.purchase_order set supplier_kd = '$kd' where kode = '$kp'";
		//$resource_absen= mysql_query($query_absen) or die('errro_visitor3');
					
		}

	//echo "<script type=\"text/javascript\">\n";
	//echo "window.close();\n";
	//echo " window.opener.location.reload();\n";	
	//echo "</script>";	
	}
?></form> 

          
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

	