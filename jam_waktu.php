<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); 
include __DIR__ . "/conndb.php";
date_default_timezone_set('Asia/Jakarta');//Menyesuaikan waktu dengan tempat kita tinggal

$hari=date("d");
$bulan=date("m");
$bln=date("M");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$hari_ini_tampil = "$hari $bln $tahun";

$jam_hari_ini = date("H:i:s");
$pin = in_val('pin', 'any');
$ok = in_val('ok', 'any');

$jam_skr =  strtotime($jam_hari_ini); 
$jam_tengah =  "16:00:00"; 
$jam_bts =  strtotime($jam_tengah); 




if($pin != '')
	{

	$query_pin = q_set($__p_query_pin, "SELECT nama_lengkap, id_emp FROM emp_master  where pwd  = ?  and st_emp =0", [(string) ($pin)]); 
	$resource_pin = db_query_soft($query_pin, $__p_query_pin ?? []);
	if(num(db_num_rows($resource_pin)) > 0)
		{
		while ($r_emp=  db_fetch($resource_pin, PDO::FETCH_NUM))
			{
			$st = 1;
			$nm_lengkap = $r_emp[0];
			$id = $r_emp[1];
			}
		}
	}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VCMS - Your Attendance Record</title>
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
 <form action=# method="post"><?php echo csrf_field(); ?>
 
  <div class="wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>VCMS - Attendance Records<br>
    </h1>
    <table width="569" border="0">
        <tbody>
          <tr>
            <td width="563" height="37">Today : <?php echo e($hari_ini_tampil) ?></td>
          </tr>
          <tr>
            <td height="37">Time Now: <?php echo e($jam_hari_ini) ?></td>
          </tr>
        </tbody>
    </table>
  </section><!-- Main content -->
    <section class="content">
      <div class="row">
<div class="col-xs-12">
    <div class="form-group">
 <?php if(num($st) ==1 ){?> 
		<label><?php echo e($nm_lengkap) ?></label>
		      <input name="kode"  class="form-control"  type="hidden" size="90" value="<?php echo e($id) ?>"/>		
<?php }else{ ?>		
      <label>Your PIN (ddmmyyyy)</label>

      <input name="pin"  class="form-control"  type="number" size="90" value="<?php echo e($nm_lengkap) ?>"/>
<?php } ?>		
    </div>	

  </div>
<div class="col-xs-12">
<?php if (num($st) != 1){?>	
		        <div class="form-group">
		          <input name="Cek" type="submit" id="Cek"  class="form-control"  value="Cek" />
	            </div>
<?php } else { ?>	
		        <div class="form-group">
		          <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />
	            </div>	
<?php } ?>	
	          </div>		  
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
<?php if (num($ok) ==1){?>
	  <div class="col-xs-12">
		<div class="form-group">
		  <label>Attendance List</label>
		</div>				
	  </div>	
	  <div class="col-xs-12">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td width=12% align=center >Employee Name</td>
	            <td width=7% height="14" align=center >Log In</td>
	            <td width="12%" align=center >Log Out</td>
              </tr>
            </thead>

	        <tbody>
	          <?php	
if($jam_skr>$jam_bts)
	{$query_list = q_set($__p_query_list, "SELECT nama_lengkap, date_format(a.time_in,'%H:%i:%s'), date_format(a.time_out,'%H:%i:%s'),  a.cat_in, a.cat_out FROM ves_data.attendance a left join  emp_master b on a.kd_emp  = b.id_emp  where tgl_hari = ? order by a.time_in desc", [(string) ($hari_ini)]); 
	}else
	{$query_list = q_set($__p_query_list, "SELECT nama_lengkap, date_format(a.time_in,'%H:%i:%s'), date_format(a.time_out,'%H:%i:%s'),  a.cat_in, a.cat_out FROM ves_data.attendance a left join  emp_master b on a.kd_emp  = b.id_emp  where tgl_hari = ? order by a.id desc", [(string) ($hari_ini)]); 
	}
	


$resource_list = db_query_soft($query_list, $__p_query_list ?? []);		
if(num(db_num_rows($resource_list)) > 0)
	{
	while ($row_list  =  db_fetch($resource_list, PDO::FETCH_NUM))
		{

			
			
	?>
	          <tr>
	            <td align=center class="style24"><?php echo  e($row_list[0])  ?></td>
	            <td height="14" align=center class="style24"><?php echo  e($row_list[1])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_list[2])  ?></td>
              </tr>
	          <?php 	}} ?>
            </tbody>
	        <tfoot>
            </tfoot>
          </table>
	    </div>
            <!-- /.box-body -->
      </div>
<?php } ?>
      <!-- /.row --><!-- /.content -->
	</form> 
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{
	$hari=date("d");
	$bulan=date("m");
	$bln=date("M");
	$tahun=date("Y");
	$id = in_val('kode', 'any');
	$hari_ini = "$tahun-$bulan-$hari";
	$jam_hari_ini = date("h:i:s a");
	$query_absen = q_set($__p_query_absen, "SELECT kd_emp, tgl_hari, time_in, time_out, cat_in, cat_out FROM attendance where tgl_hari  = ? and kd_emp = ? ", [(string) ($hari_ini), (string) ($id)]); 
	$resource_absen = db_query_soft($query_absen, $__p_query_absen ?? []);

	if(num(db_num_rows($resource_absen)) > 0)
		{

		$query_out = q_set($__p_query_out, "update attendance set time_out = ? where tgl_hari  = ? and kd_emp = ? ", [(string) ($hari_ini) . " " . (string) ($jam_hari_ini), (string) ($hari_ini), (string) ($id)]); 
		$resource_out = db_query_soft($query_out, $__p_query_out ?? []);				
		}
	else
		{
		$query_in = q_set($__p_query_in, "insert into attendance(kd_emp, tgl_hari, time_in) value(? ,? ,? )", [(string) ($id), (string) ($hari_ini), (string) ($hari_ini) . " " . (string) ($jam_hari_ini)]); 

		$resource_in = db_query_soft($query_in, $__p_query_in ?? []);
		}
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Your In / Out Attendance has been recorded');\n";
		echo "window.location = ('attendance.php?ok=1');\n";				
		echo "</script>";
	}
?>	
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
  