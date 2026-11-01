<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";



$q = in_val('q', 'get');
if($q==''){$q='t';}
$tampilan = in_val('tampilan', 'get');
$kode_teacher = in_val('nm_teacher', 'get');
$posisi = $_SESSION['posisi']; 

$center = in_val('center', 'get');
if ($center==""){$center = "--ALL--";}

if ($tampilan==""){$tampilan = "Teachers Calendar";}
if ($tampilan == "Teachers Calendar") 
	{$q='t';}
else
	{$q='r';}

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kdcbg = in_val('kdcbg', 'get');


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kd_area'] ;
$level_posisi = $_SESSION['level_posisi'] ;
$kdcl = in_val('kdcl', 'get');
$kdb = in_val('kdb', 'get');

$kdcbg = in_val('kdcbg', 'get');

$nomor = in_val('no', 'get');


//--ambil tanggal kelas
//--ambil tanggal kelas
$query_kelas = q_set($__p_query_kelas, "SELECT kelas, kd_branch, mulai_tm,kd_biodata,status_kelas  FROM ves_data.vip_teacher_schedule v where id = ? ", [(string) ($nomor)]);
$resource_kelas= db_query_or_die('errro_visitor12', $query_kelas, $__p_query_kelas ?? []);


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
 <?php  //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_crsh_print.php> 
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
	      <p>
		        <label>Student Name: <?php echo e($kdcl) ?></label>
		        <br>
		        <label>Class Code : <?php echo e($kdcl) ?></label>
		        <br>
	        <input type="hidden" name="kdprg" id="textfield" value=<?php echo e($kdprg) ?> hidden></input>
	      </p>
	      <p>
          <label>LC RECOMMENDATION RECORD</label></p><table width="100%" class="table table-bordered table-striped" id="example12">
		        <thead>
	      <tr>
	        <td height="14" align=center >Day/Date/Teacher</td>
	        <td colspan="2" align=center >Recommendation</td>
	        <td width="14%" rowspan="2" align=center >Action</td>
	        </tr>
	      <tr>
	        <td width=9% height="14" align=center >&nbsp;</td>
	        <td width="9%" align=center >Skil</td>
	        <td width="26%" align=center >Remark</td>
	        </tr>
        </thead>
	    <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   echo $query_billing;
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	    <tbody>
	      <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc" ;


$query_tanggal = q_set($__p_query_tanggal, "SELECT date_format(tgl_meeting, '%Y-%m-%d'),date_format(tgl_meeting, '%H:%i')  , a.nama_lengkap, l.kd_biodata, l.kd_class,  l.lc_skill_recommendation,l.lc_recommendation, nm_teacher FROM ves_data.lc_student_history l left join vip_student_data a on l.kd_biodata  = a.kd_biodata\r
left join vip_teacher_schedule b on l.kd_class = b.kelas and l.tgl_meeting = b.mulai_tm where l.kd_biodata = ? and l.kd_class = ? order by tgl_meeting", [(string) ($kdb), (string) ($kdcl)]);

$resource_tanggal= db_query_or_die('errro_visitor1', $query_tanggal, $__p_query_tanggal ?? []);
$keluar_tanggal= db_num_rows($resource_tanggal);
	if(num(db_num_rows($resource_tanggal)) > 0)
		{
		while ($row_tanggal=  db_fetch($resource_tanggal, PDO::FETCH_NUM))
			{
			
	
	?>
	      <tr>
	        <td height="14" align=left class="style24"><?php echo e($row_tanggal[0]) ?> / <?php echo e($row_tanggal[1]) ?> / <?php echo e($row_tanggal[7]) ?></td>
	        <td align=center class="style24"><?php echo e($row_tanggal[5]); ?></td>
	        <td align=left class="style24"><?php echo e($row_tanggal[6]); ?></td>
	        <td align=center class="style24">&nbsp;</td>
	        </tr>
	      <?php }} ?>
        </tbody>
	    <tfoot>
        </tfoot>
    </table>
		</div>	
		</div>

	</div></div>
<!-- /.row --><!-- /.content -->
	</form> 
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

	