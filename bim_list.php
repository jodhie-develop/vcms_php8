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
if ($date_start ==''){$date_start = "2018-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$date_start =='2021-01-01';
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
if ($kd_cbg == 'LIUMEDIA'){$kd_cbg = 99;}
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
if (num($kd_cbg) ==99){$cabang = 'LIUMEDIA';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kelompok = $_SESSION['kelompok'];
//if ($kelompok <> 'ACC'){$kd_cbg = $_SESSION['kd_branch'];}
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$po_status = in_val('po_status', 'get');
if (num($po_status) == 10){$po_status_selected = '--All--';$filter_display = '';}
elseif (num($po_status) == 1){$po_status_selected = 'Proposed';$filter_display = ' and po_status = 1 ';}
elseif (num($po_status) == 2){$po_status_selected = 'Approved';$filter_display = ' and po_status = 2 ';}
elseif (num($po_status) == 3){$po_status_selected = 'Acknowledge';$filter_display = ' and po_status = 3 ';}
elseif (num($po_status) == 4){$po_status_selected = 'Tax Checked';$filter_display = ' and po_status = 4 ';}
elseif (num($po_status) == 5){$po_status_selected = 'To Be Paid';$filter_display = ' and po_status = 5 ';}
elseif (num($po_status) == 5){$po_status_selected = 'Paid';$filter_display = ' and po_status = 6 ';}
elseif (num($po_status) == 7){$po_status_selected = 'Rejected';$filter_display = ' and po_status = 7 ';}
elseif (num($po_status) == 9){$po_status_selected = 'Paid';$filter_display = ' and po_status = 9 ';}

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
  <link rel="stylesheet" href="cdnjs/ionicons.min.css">
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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
  <h1>BIM Student List<br>
  </h1>
 
	  
 <form method=get action=purchasinglist.php> 	  
    <table width="453" border="0">
        <tbody>
          <tr>
            <td width="148">

                <a href="bim_new.php"  class="btn btn-primary">+ New Student </a>
 	</td>
            <td width="289">&nbsp;</td>
          </tr>
        </tbody>
    </table>
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Student   List</label>
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=3% height="14" align=center >No</td>
	            <td width=13% align=center >Nama Lengkap</td>
	            <td width=7% align=center >E-Mail</td>
	            <td width=7% align=center >Whatsapp</td>
	            <td width=19% align=center >No HP</td>
	            <td width=19% align=center >Asal Sekolah</td>
	            <td width=19% align=center >Alamat</td>
	            <td width="13%" align=center >Action</td>
	            <td width="13%" align=center >Generate</td>
              </tr>
            </thead>
	        <tbody>
          <?php	
	
$query_purchase = q_set($__p_query_purchase, "SELECT a.kd_biodata,  concat_ws(' ',nama, middle_name, family_name), kd_unik, sm_6, hp, address, city,org_school,org_city_school FROM ves_inc.tb_biodata a left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata  where event_st = 'Project' and event_st_dtl = 'BIM 2022' order by a.no desc");

$no_urut = 1;		
$resource_purchase = db_query_soft($query_purchase, $__p_query_purchase ?? []);			
if(num(db_num_rows($resource_purchase)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_purchase, PDO::FETCH_NUM))
		{
		$kode_biodata = $row_billing[0];
		$nama_student = $row_billing[1];
		$e_mail = $row_billing[2];		
		$whatsapp = $row_billing[3];
		$no_hp = $row_billing[4];		
		$address = $row_billing[5];
		$city = $row_billing[6];		
		$org_city_school = $row_billing[7];
		$org_school = $row_billing[8];		
		$grade = $row_billing[9];
	
		

		
	?>
			<tr>
			<td height="14" align=center class="style24"><?php echo e($no_urut) ?></td>
			<td align=left class="style24">
			<?php echo e($nama_student) ?><br></td>
			<td align=center class="style24"><?php echo e($e_mail) ?></td>
			<td align=center class="style24"><?php echo e($whatsapp) ?></td>
			<td align=center class="style24"><?php echo e($no_hp) ?></td>
			<td align=center class="style24"><?php echo e($org_city_school) ?> <?php echo e($org_school) ?> <?php echo e($grade) ?></td>
			<td align=center class="style24"><?php echo  e($address)  ?> <?php echo e($city) ?></td>
			<td align=center class="style24"><div class="btn-group"> <a href="bim_new.php?kdb=<?php echo e(u($row_billing[0])) ?>&upd=1">
			  <button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open"></span></button>
			  </a> </div></td>
			<td align=center class="style24">
				<div class="btn-group">
                      <a href="ecert/ecertbimvista2022.php?kdb=<?php echo e(u($row_billing[0])) ?>&upd=1"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-ok-sign"></span></button></a>		  
                    </div>
				<div class="btn-group">
                      <a href="ecert/ecertbimvista2022.php?kdb=<?php echo e(u($row_billing[0])) ?>&upd=1"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-print"></span></button></a>		  
                    </div></td>
              </tr>
              <?php $no_urut = num($no_urut) +1;$ttl_amount ='';}} ?>
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
   <script>
   function popitup(url) 
   {
    newwindow=window.open(url,'name','height=600,width=900,screenX=400,screenY=350');
    if (window.focus) {newwindow.focus()}
    return false;
   }
   </script>			
</html>
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
