<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
$class_code = in_val('cdl', 'get');
$cabang = in_val('cbg', 'get');
$start_date = in_val('start_date', 'get');
$end_date = in_val('end_date', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$fp = in_val('fp', 'get');
$no_doc = in_val('no_doc', 'get');
$hari_ini = "$tahun-$bulan-$hari";
if ($start_date==""){$start_date = "$tahun-$bulan-01";}
if ($end_date==""){$end_date = "$tahun-$bulan-31";}
include __DIR__ . "/conndb.php";
$kd_student = in_val('kdb', 'get');
$idb = in_val('idb', 'get');
$query_bio = q_set($__p_query_bio, "SELECT a.kd_billing,concat_ws(' ',b.nm_program, a.level_program) as prg_lengkap, b.type_program, concat_ws (' ',c.nama, c.middle_name, c.family_name) as nm_lengkap,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_biodata = ? and a.kd_billing = ? ", [(string) ($kd_student), (string) ($idb)]);
$resource_bio = db_query_soft($query_bio, $__p_query_bio ?? []);
$keluar_bio = db_num_rows($resource_bio);
if(num(db_num_rows($resource_bio)) > 0)
	{
	while ($row_bio   =  db_fetch($resource_bio, PDO::FETCH_NUM))
		{
		$nama = $row_bio['3'];
		$nm_program = $row_bio['1'];
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
<body onload="window.print();">
<body class="A5.landscape">
<body class="hold-transition skin-blue sidebar-mini">

  <!-- 

 
 side column. contains the logo and sidebar -->
  <?php    //  include __DIR__ . "/left.php";	 ?>
<form method=get> 
  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
</section>

    <!-- Main content -->
<section class="content">
<div class="row">
<div class="col-md-3">
	<label><small>Material Received  Form</small></label></div>
  <div class="col-md-3">
    <div class="form-group"><label><?php echo e($nama) ?></label> 
    (
    <label><?php echo e($nm_program) ?> )</label></div>
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
	</span></div>	
<div class="row">
  <div class="col-md-8">
    <div class="box box-warning">
	      <table id="example1" class="table table-bordered table-striped">
                <thead>
                <?php
$query_doc = q_set($__p_query_doc, "SELECT material FROM ves_data.vip_student_material where kd_billing = ? and kd_biodata = ? ", [(string) ($idb), (string) ($kd_student)]);
$resource_doc= db_query_or_die('errro_visitor1', $query_doc, $__p_query_doc ?? []);
?>
                <tr>
                  <th width="4%"><small>No</small></th>
                  <th width="58%"><small>Item</small></th>
                  <th width="10%"><small>Check</small></th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if	 ($resource_doc) 
						{ 
							$no_urut = 1;
						while ($row_doc = db_fetch($resource_doc))
							{
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($row_doc[0]) ; ?></td>
                  <td>&nbsp;</td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
		</div>
	    <div class="box-header with-border">
			<p>Received By <br></br>
	      <?php echo e($nama) ?>
	      </p>
	    </div>
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
