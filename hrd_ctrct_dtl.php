<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
 include __DIR__ . "/left.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$id = in_val('id', 'get');
$hr_id = in_val('hr_id', 'get');

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;

$query_billing = q_set($__p_query_billing, "SELECT catatan, nama_file FROM ves_data.hrd_mst_cntrct where id = ? ", [(string) ($id)]);

$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$catatan = $row_billing[0];
		$namafile = $row_billing[1];
	
		}
	}

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
	<script type="text/javascript">
document.onmousedown = disableRightclick;
var message = "Right click not allowed !!";
function disableRightclick(evt){
    if(evt.button == 2){
        alert(message);
        return false;    
    }
}
</script>
</head>
<?php //========================== left nav ?>
 <?php  // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get> 
  <div class="wrapper">
  <div class="content-wrapper">	  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

<div class="box box-warning">
	<div class="box-body">
	  <h1><?php echo e($nama_memo) ?></h1>
	  <div class="col-md-8">
<!--		  
	    <div class="form-group">
<iframe src="<?php echo e($namafile) ?>" width="100%" height="1000px">
    </iframe>
        </div>

-->
		  <div id="pdf">
    <object width="100%" height="650" type="application/pdf" data="<?php echo e($namafile) ?>#zoom=85&scrollbar=0&toolbar=0&navpanes=0" id="pdf_content" style="pointer-events: none;">
        <p>Insert your error message here, if the PDF cannot be displayed.</p>
    </object>
</div>
      </div>
		
 <div class="col-md-4">
	 <table width="100%" class="table table-bordered table-striped" id="example12">
	        <thead>
				<tr><a href="#" target="popup" onclick="window.open('hrd_ctrct_review.php?cid=<?php echo e(u($id)); ?>&hrid=<?php echo e(u($hr_id)) ?>','popup','width=650,height=650'); return false;">
					<button class="btn btn-primary">New Note </button>	</a>				
				</tr>
	          <tr>
	            <td width=81% height="14" align=center >Note</td>

              </tr>
            </thead>
	        <tbody>
          <?php	
	
$query_contract = q_set($__p_query_contract, "SELECT h.id_contract, h.hr_id, h.keterangan, h.dt_entry, h.pic, h.st_review FROM ves_data.hr_cntrct_review h \r
where id_contract =? and hr_id=? order by dt_entry desc", [(string) ($id), (string) ($hr_id)]); 
		
$resource_contract = db_query_soft($query_contract, $__p_query_contract ?? []);			
if(num(db_num_rows($resource_contract)) > 0)
	{ $no_urut = 1;
	while ($row_contract  =  db_fetch($resource_contract, PDO::FETCH_NUM))
		{
		$catatan = $row_contract[2];	
		$pic = $row_contract[4];			
		

	
		

		
	?>
			<tr>
			<td height="14" align=left class="style24">
			  <?php echo e($no_urut)  ?>.<?php echo e($catatan) ?> - <?php echo e($pic) ?><br></td>
              </tr>
              <?php $no_urut = num($no_urut) +1;;}} ?>
		    </tbody>
            <tfoot>
				<tr>
					<a href="#" target="popup" onclick="window.open('hrd_ctrct_st.php?cid=<?php echo e(u($id)); ?>&hrid=<?php echo e(u($hr_id)) ?>','popup','width=650,height=650'); return false;">
					<button class="btn btn-danger">New Note </button>	</a>
					<a href="hrd_list_upd.php?id=<?php echo e(u($id)) ?>">
					<button class="btn btn-info">Back to Profile</button>	</a>					
				</tr>
            </tfoot>
          </table>

	 <br>
		</div>	 
          <!-- /.box -->
    </div>
        <!-- /.col -->
      </div>
		  </div>
		</div>
	  </section>
	 </div>
	 </div> 
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
<?php 
if (isset($_GET['simpan'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.loleftcation = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
	