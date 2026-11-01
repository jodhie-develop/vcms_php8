<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');

$kds = in_val('kds', 'get');
$klp = in_val('klp', 'get');
$dt = in_val('dt', 'get');

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");

include __DIR__ . "/conndb.php";
$nama = $_SESSION['nama_lengkap'];

$query_staff = q_set($__p_query_staff, "SELECT t.nama_detail, t.branch FROM tb_user t where t.no = ? ", [(string) ($kds)]);
$resource_staff = db_query_soft($query_staff, $__p_query_staff ?? []);
if(num(db_num_rows($resource_staff)) > 0)
	{
	while ($row_staff   =  db_fetch($resource_staff, PDO::FETCH_NUM))
		{
		$nama_staff = $row_staff[0];
		$nama_branch = $row_staff[1];
			
		}
	}
			
//include __DIR__ . "/profiledata.php";
 //include __DIR__ . "/atas.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Follow Up History</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
 
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

  <!-- 

 
 side column. contains the logo and sidebar -->
  <?php    //  include __DIR__ . "/left.php";	 ?>
<form method=get> 
  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Detail</h1>
    </section>

    <!-- Main content -->
<section class="content">
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>Staff Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($nama_staff) ?>" readonly>
    </div>
  </div>
  <span class="form-group">
		<input type="text"name="kd_student" 
                 	      value="<?php echo e($kd_student) ?>" hidden="hidden">
  </span>  <span class="form-group">
	<input type="text"name="kd_branch" 
                 	      value="<?php echo e($kd_branch) ?>" hidden="hidden">
	</span><span class="form-group">
	<input type="text"name="fp" 
                 	      value="<?php echo e($fp) ?>" hidden="hidden">
	</span><span class="form-group">
	<input type="text"name="no_doc" 
                 	      value="<?php echo e($no_doc) ?>" hidden="hidden">
	</span>
	<div class="col-md-3">
	  <div class="form-group">
	    <label>Center</label>
	    <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="branch" 
                 	      value="<?php echo e($nama_branch) ?>" readonly>
	    </div>
	  </div>
</div>	
<div class="row">

 <div class="box-header with-border">
  <div class='col-md-8' align="left">
		    <label>Activities Log</label></div></div>     	  
	  <div class="col-md-8">
	    <div class="box box-warning">
		  		<div class="box-header with-border"></div>
       	<table id="example1" class="table table-bordered table-striped">
                <thead>
                <?php
if (num($klp) == 1){
$query_bio = q_set($__p_query_bio, "SELECT concat_ws(' ',b.nama,b.middle_name,b.family_name),  a.remark FROM ves_data.tb_prospect a\r
left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata left join tb_user c on a.pic = c.nama_detail where c.no  = ?  and dt_target like   ? and kelompok = 'VES'", [(string) ($kds), (string) ($dt) . "%"]);
}
elseif (num($klp) == 2){
$query_bio = q_set($__p_query_bio, "SELECT concat_ws(' ',b.nama,b.middle_name,b.family_name),  a.remark FROM ves_data.tb_prospect a\r
left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata left join tb_user c on a.pic = c.nama_detail where c.no  = ?  and dt_target like   ? and kelompok = 'VIP'", [(string) ($kds), (string) ($dt) . "%"]);
}
	
			 $no_urut  = 1;

?>
                <tr>
                  <th width="13%">No</th>
                  <th width="26%">Leads</th>
                  <th width="61%">Remark </th>
                  </tr>
                </thead>
                <tbody>

				  <?php 

$resource_bio = db_query_soft($query_bio, $__p_query_bio ?? []);
if(num(db_num_rows($resource_bio)) > 0)
	{
	while ($row_bio   =  db_fetch($resource_bio, PDO::FETCH_NUM))
		{
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($row_bio[0]) ; ?></td>
                  <td><?php echo e($row_bio[1]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
		</div><div class="box-header with-border"></div>
	  </div>
  </form>


    <!-- Horizontal Form -->
          <!-- /.box -->
          <!-- general form elements disabled -->
		  
            
            <!-- /.box-header --><!-- /.box-body --><!-- /.box --><!--/.col (right) --><!-- /.row --><!-- /.content -->
  </div>
  <!-- /.content-wrapper --><!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php
if (isset($_GET['New'])) 
{
$kd_student = in_val('kd_student', 'get');
$kd_branch = in_val('kd_branch', 'get');
echo "<script type=\"text/javascript\">\n";
echo "window.location = ('updoc.php?kdb=" . e(u($kd_student)) . "&kdc=" . e(u($kd_branch)) . "');\n";
echo "</script>";
}
?>
