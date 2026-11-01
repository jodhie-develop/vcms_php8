<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();  
include __DIR__ . "/conndb.php";
$id = in_val('id', 'get');

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
	   

            <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
               
            <tr>
              <th colspan="2"><span class="box-title">Student  List</span></th>
            </tr>
            <tr>
              <th width="28%">Student Name</th>
              <th width="15%">Class Information</th>
            </tr>
                
            <tbody>
<?php
$query_data_kelas = q_set($__p_query_data_kelas, "SELECT a.kd_biodata, nama_lengkap, kd_class FROM ves_data.lc_meeting a\r
left join ves_data.vip_teacher_schedule b on a.tgl_meeting = b.mulai_tm and a.nm_teacher = b.nm_teacher\r
left join vip_student_data c on a.kd_biodata = c.kd_biodata\r
where b.id = ?  and (b.status_kelas = 700 or b.status_kelas = 701 or b.status_kelas = 702 or b.status_kelas = 703  ) group by kd_biodata", [(string) ($id)]);
$resource_data_kelas= db_query_or_die('errro_visitor1', $query_data_kelas, $__p_query_data_kelas ?? []);
if(num(db_num_rows($resource_data_kelas)) > 0)
	{
	while ($row_data_kelas  =  db_fetch($resource_data_kelas, PDO::FETCH_NUM))
		{
					
?>				
              <tr>
                <td><?php echo e($row_data_kelas[1])  ?>
                <td><?php echo e($row_data_kelas[2])  ?></td>
              </tr>

<?php  } }  ?>		
            </tbody>
	<tfoot>                <tr>
	  <td></td>
                  <td>&nbsp;</td>
            </tr></tfoot>
	
          
            <tfoot>
            </tfoot>
          </table>
       
		 </div>
            <!-- /.box-body -->
  
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

	