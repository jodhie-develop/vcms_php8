<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$id = in_val('id', 'get');
$kd = in_val('kd', 'get');
$spv = in_val('spv', 'get');
$nos = in_val('nos', 'get');
if(num($spv)==1)
{
$query_file = q_set($__p_query_file, "SELECT nama_file, COALESCE(NULLIF(nama_asli, ''), nama_file) FROM adm_doc where no_sales = ? ", [(string) ($nos)]);
$resource_file = db_query_soft($query_file, $__p_query_file ?? []);	
}
else
{	
$query_file = q_set($__p_query_file, "SELECT nama_file, COALESCE(NULLIF(nama_asli, ''), nama_file) FROM adm_doc where id = ? ", [(string) ($id)]);
$resource_file = db_query_soft($query_file, $__p_query_file ?? []);	
}
if(num(db_num_rows($resource_file)) > 0)
{
	while ($row_file  =  db_fetch($resource_file, PDO::FETCH_NUM))
		{
		$nama_file = $row_file[0]; $nama_tampil = $row_file[1]; 
		}
	
}
else
{die;}

?>	
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo e($nama_tampil ?? $nama_file) ?></title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) --><!-- Main content -->
    <section class="content"><!-- /.row -->

      <!-- =========================================================== -->

      <div class="row"><!-- /.col --><!-- /.col --><!-- /.col --><!-- /.col -->
      </div>
      <!-- /.row -->



      <div class="row">
        <div class="col-md-6">
          <!-- Box Comment -->
          <div class="box box-widget">
            <!-- /.box-header -->
            <div class="box-body">
              <img class="img-responsive pad" src="doc_vos/<?php echo e($nama_file) ?>" alt="Photo">
<embed type="application/pdf" src="doc_vos/<?php echo e($nama_file) ?>" width="750" height="600"></embed>				
            </div>

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->


</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
