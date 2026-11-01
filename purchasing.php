<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_val('kd_cbg', 'get');

if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdcl = in_val('kdcl', 'get');
$kdprg = in_val('kdprg', 'get');





$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
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
 <?php  // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_open_class_list.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
<section class="content-header">
  <h1>Academic Rules & Interofice Memo<br>
  </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><a href="purchasingupload.php" 
target="blank" class="btn btn-danger" role="button"><i class="glyphicon glyphicon-erase" aria-hidden="true"></i> New
</a></td>
            <td width="289">&nbsp;</td>
          </tr>
        </tbody>
      </table>
</section>
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
<td width=78 align=center bgcolor=#CCCCCC class="style81">NO</td>
        <td width=132 align=center bgcolor=#CCCCCC class="style81">Code<br>
          Date</td>
        <td width=126 align=center bgcolor=#CCCCCC class="style81">Subject <br>
          Description</td>
        <td width=194 align=center bgcolor=#CCCCCC class="style81">Total Amount</td>
        <td width=194 align=center bgcolor=#CCCCCC class="style81">Proposed By</td>
        <td width=241 align=center bgcolor=#CCCCCC class="style81">Approved By<br></td>
        <td width="387" align=center bgcolor=#CCCCCC class="style81">Ack By</td>
        <td width="387" align=center bgcolor=#CCCCCC class="style81">Tax Check</td>
        <td width="387" align=center bgcolor=#CCCCCC class="style81">File</td>
        </tr>
            </thead>
		<?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   /* echo $query_billing (debug SQL versi lama) dihapus */
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	        <tbody>
          <?php	
				$nomor = 1;
$query_billing = q_set($__p_query_billing, "SELECT v.no, v.type_program, v.nm_program, v.level_program, v.kd_material, v.buku, kd_program, v.no_meeting FROM ves_data.vip_mst_code_prg v group by kd_program order by type_program,nm_program,level_program  ");

$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$query_scope = q_set($__p_query_scope, "SELECT namafile, lokasifile FROM vip_ssq where  kode_program = ? ", [(string) ($row_billing[6])]);
		$resource_scope = db_query_soft($query_scope, $__p_query_scope ?? []);		
		if(num(db_num_rows($resource_scope)) > 0)
			{
			while ($row_scope  =  db_fetch($resource_scope, PDO::FETCH_NUM))
				{
				$adafile= 1;
				$nmfile = $row_scope[0];					
				$lokasifile = "$row_scope[1]";										
				}
			}
		
		
	?> 
	          <tr>
	            <td height="14" align=left class="style24"><?php echo e($nomor) ; ?></td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[1]); ?></td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[2]); ?></td>
	            <td align=left class="style24">&nbsp;</td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[3]); ?></td>
	            <td height="14" align=right class="style24"><?php echo e($row_billing[4]); ?></td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td height="14" align=right class="style24"><?php if (num($adafile) == 0){ ?>
	            
	            <a href= "purchasingupload.php" target="_blank">Upload</a>
	            <?php }else { ?>
				<a href="vip_scsq_view.php?f=<?php echo e(u($lokasifile)) ?>" 
				target="popup" 
				onclick="window.open('vip_scsq_view.php?f=<?php echo e(u($lokasifile)) ?>','popup','width=1000,height=800'); return false;">	            
				<?php echo e($nmfile) ?></a>
				<?php } ?></td>
              </tr>
              <?php   $nomor = num($nomor)+1; $adafile ="";} }?>
              <?php //=====sub total start ==== ?>
              <?php //=====sub total end==== ?>

             
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>
          <!-- /.box -->
    </div>
        <!-- /.col -->
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
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.loleftcation = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
	