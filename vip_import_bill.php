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
$jnspay = in_val('jnspay', 'get');
$no_doc = in_val('no_doc', 'get');
$hari_ini = "$tahun-$bulan-$hari";
if ($start_date==""){$start_date = "$tahun-$bulan-01";}
if ($end_date==""){$end_date = "$tahun-$bulan-31";}
include __DIR__ . "/conndb.php";
$kd_student = in_val('kdb', 'get');
$idb = in_val('idb', 'get');
$nonew = in_val('nonew', 'get');
$kdcbg = $_SESSION['kd_branch']; 
$query_bio = q_set($__p_query_bio, "SELECT a.kd_billing,concat_ws(' ',b.nm_program, a.level_program) as prg_lengkap, b.type_program, concat_ws (' ',c.nama, c.middle_name, c.family_name) as nm_lengkap,a.kd_biodata,a.no FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_biodata = ? and a.kd_billing = ? ", [(string) ($kd_student), (string) ($idb)]);

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
if (num($kdcbg) ==1){$kd_db = q_set($__p_kd_db, "billing");}
elseif (num($kdcbg) ==2){$kd_db = q_set($__p_kd_db, "billing_west");}
elseif (num($kdcbg) ==3){$kd_db = q_set($__p_kd_db, "billing_bali");}
elseif (num($kdcbg) ==4){$kd_db = q_set($__p_kd_db, "billing_jkt_02");}
elseif (num($kdcbg) ==5){$kd_db = q_set($__p_kd_db, "billing_new_gs");}
elseif (num($kdcbg) ==6){$kd_db = q_set($__p_kd_db, "billing_m2");}
elseif (num($kdcbg) ==7){$kd_db = q_set($__p_kd_db, "billing_new_bdg");}
elseif (num($kdcbg) ==8){$kd_db = q_set($__p_kd_db, "billing_malang");}

			
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
  <?php  //    include __DIR__ . "/left.php";	 ?>
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
	<label>ID Billing : <?php echo e($idb) ?></label></div>
  <div class="col-md-3">
    <div class="form-group"><label><?php echo e($nama) ?></label> 
    (
		<label><?php echo e($nm_program) ?> )</label><br>
      Payment for : <?php echo e($jnspay) ?>
    </label></div>
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
	</span><span class="form-group">
	<input type="text"name="idb" 
                 	      value="<?php echo e($idb) ?>" hidden="hidden">
	</span><span class="form-group">
	<input type="text"name="jnspay" 
                 	      value="<?php echo e($jnspay) ?>" hidden="hidden">
	<input type="text"name="nonew" 
                 	      value="<?php echo e($nonew) ?>" hidden="hidden">
	</span></div>	
<div class="row">
  <div class="col-md-8">
    <div class="box box-warning">Receipt List
	      <table id="example1" class="table table-bordered table-striped">
                <thead>
                <?php
$query_doc = q_set($__p_query_doc, "SELECT t.id_receipt, date_format(t.tgl_cetak,'%d %M %y'), t.nm_student, t.nm_prg, t.keterangan, t.jns_pay, t.mount_pat,t.no  FROM " . $kd_db . ".tb_receipt t where tgl_cetak >= '2018-03-01' and nm_event not like 'Move%' order by no desc", [...($__p_kd_db ?? [])]);
$resource_doc= db_query_or_die('errro_visitor1', $query_doc, $__p_query_doc ?? []);
?>
                <tr>
                  <th width="3%"><small>No</small></th>
                  <th width="26%"><small>ID Receipt</small></th>
                  <th width="25%"><small>Student Name</small></th>
                  <th width="23%"><small>Program</small></th>
                  <th width="17%"><small>Amount</small></th>
                  <th width="6%"><small>Add Payment</small></th>
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
                  <td><?php echo e($row_doc[0]) ; ?> <br>                    <?php echo e($row_doc[1]) ; ?></td>
                  <td><?php echo e($row_doc[2]) ; ?></td>
                  <td><?php echo e($row_doc[3]) ; ?> <?php echo e($row_doc[4]) ; ?></td>
                  <td><?php echo e($row_doc[6]) ; ?><br>
                  <?php echo e($row_doc[5]) ; ?></td>
                  <td><a href="vipbillreceipt_dtl_import.php?idb=<?php echo e(u($idb)); ?>&noold=<?php echo e(u($row_doc[7])) ?>&nonew=<?php echo e(u($nonew)) ?>" 
target="popup" 
onclick="window.open('vipbillreceipt_dtl_import.php?idb=<?php echo e(u($idb)); ?>&noold=<?php echo e(u($row_doc[7])) ?>&nonew=<?php echo e(u($nonew)) ?>','popup','width=1000,height=800'); return false;">Add</a></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
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
<!-- AdminLTE for demo purposes --><!-- jQuery 2.2.3 -->
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
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>	
</body>
</html>
<?php 
if (isset($_GET['Print'])) 
	{
$idb= in_val('idb', 'get');
$kdb= in_val('kd_student', 'get');
echo "<script type=\"text/javascript\">\n";
echo "window.location = ('vip_material_listprint.php?idb=" . e(u($idb)) . "&kdb=" . e(u($kdb)) . "');\n";
echo "</script>";
}
?>
