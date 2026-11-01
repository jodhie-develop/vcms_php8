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
if ($date_start ==''){$date_start = "2017-07-01";}
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
 <?php // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_sales_center.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
<div class="box box-warning">          
	<div class="box-body">
	  <div class="col-md-12">
		<div class="form-group">
		  <label>Class Code : <?php echo e($kdcl) ?></label>
		  
          <input type="text" name="kdprg" id="textfield" value=<?php echo e($kdprg) ?> hidden></input>
		</div>	
		</div>
	</div></div>
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Billing Statement List</label>
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
<td width=98 align=center bgcolor=#CCCCCC class="style81">NO</td>
        <td width=188 align=center bgcolor=#CCCCCC class="style81">Student Name </td>
        <td width=173 align=center bgcolor=#CCCCCC class="style81">Program</td>
        <td width=300 align=center bgcolor=#CCCCCC class="style81">Day</td>
        <td width=369 align=center bgcolor=#CCCCCC class="style81">Program Fee <br></td>
        <td width=189 align=center bgcolor=#CCCCCC class="style81">Discount</td>
        <td width="553" align=center bgcolor=#CCCCCC class="style81">Nett Tuition Fee </td>
        <td width="347" align=center bgcolor=#CCCCCC class="style81">Tution Fee Paid</td>
        <td width="266" align=center bgcolor=#CCCCCC class="style81">Reg Fee</td>
        <td width="239" align=center bgcolor=#CCCCCC class="style81">Material <br>
Cost</td>
        <td width="146" align=center bgcolor=#CCCCCC class="style81">Outstanding</td>
        <td width="123" align=center bgcolor=#CCCCCC class="style81">Remark</td>
        <td width="129" align=center bgcolor=#CCCCCC class="style81">SC</td>
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
$query_billing = q_set($__p_query_billing, "SELECT concat_ws(' ',b.nama, b.middle_name, b.family_name) as nama,\r
kd_class,tf,promo_persen, discount,net_tf,reg_fee,material_cost,a.kd_billing,a.sc\r
 FROM ves_data.vip_billing a left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata where a.kd_branch = ? ", [(string) ($kd_cbg)]);
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	$group_kelas=  "";
	$group_sebelumnya ="awal";	
	$nomor =  1;
	$baris = 0;		
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$group_kelas = $row_billing[1];
		if ($group_sebelumnya !='awal')
		{
			if ($group_sebelumnya == $group_kelas)
			{
	?> 
 
          <tr>
	            <td height="14" align=left class="style24"><?php echo e($nomor) ; ?></td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[0]); ?></td>
	            <td height="14" align=left class="style24"><?php echo e($group_kelas) ?></td>
	            <td height="14" align=left class="style24"><?php echo e($jdwl) ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[2]),0,".","."); ?></td>
	            <td height="14" align=center class="style24"><?php echo e($row_billing[3]); ?>% <br>	              <?php echo e($row_billing[4]); ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[5]),0,".",".") ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[2]),0,".",".") ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[6]),0,".",".") ?><br>
                <?php echo e($rf_status) ?>                </td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[7]),0,".",".") ?>
                <p><?php echo e($mc_status); ?></p></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($sisa),0,".",".") ; ?></td>
	            <td height="14" align=left class="style24">&nbsp;</td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[9]); ?></td>

              </tr>
               <?php 
			$nomor = num($nomor) +1; $group_sebelumnya = $group_kelas;
			}
			else
			{ ?>
 
          <tr>
	            <td height="14" align=left class="style24">SUBTOTAL<?php echo e($nomor) ; ?></td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[0]); ?></td>
	            <td height="14" align=left class="style24"><?php echo e($group_kelas) ?></td>
	            <td height="14" align=left class="style24"><?php echo e($jdwl) ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[2]),0,".","."); ?></td>
	            <td height="14" align=center class="style24"><?php echo e($row_billing[3]); ?>% <br>	              <?php echo e($row_billing[4]); ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[5]),0,".",".") ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[2]),0,".",".") ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[6]),0,".",".") ?><br>
                <?php echo e($rf_status) ?>                </td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[7]),0,".",".") ?>
                <p><?php echo e($mc_status); ?></p></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($sisa),0,".",".") ; ?></td>
	            <td height="14" align=left class="style24">&nbsp;</td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[9]); ?></td>

              </tr>		
			<?php	
			$nomor = num($nomor) +1; $group_sebelumnya = $group_kelas;
			}
			
		}
		else 
		{  ?>
	          <tr>
	            <td height="14" align=left class="style24"><?php echo e($nomor) ; ?></td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[0]); ?></td>
	            <td height="14" align=left class="style24"><?php echo e($group_kelas) ?></td>
	            <td height="14" align=left class="style24"><?php echo e($jdwl) ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[2]),0,".","."); ?></td>
	            <td height="14" align=center class="style24"><?php echo e($row_billing[3]); ?>% <br>	              <?php echo e($row_billing[4]); ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[5]),0,".",".") ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[2]),0,".",".") ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[6]),0,".",".") ?><br>
                <?php echo e($rf_status) ?>                </td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($row_billing[7]),0,".",".") ?>
                <p><?php echo e($mc_status); ?></p></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($sisa),0,".",".") ; ?></td>
	            <td height="14" align=left class="style24">&nbsp;</td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[9]); ?></td>

              </tr>	
		<?php 	
		$nomor = num($nomor) +1; $group_sebelumnya = $group_kelas;} 
		}}  ?>
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
	