<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if ($url_original == ''){$url_original = $url_asli;}

$kode_cabang_staff = $_SESSION['kd_branch'];
$klp = $_SESSION['kelompok'];
if (num($kode_cabang_staff) ==1){$nm_cabang = 'East Sby';}
if (num($kode_cabang_staff) ==2){$nm_cabang = 'West Sby';}
if (num($kode_cabang_staff) ==3){$nm_cabang = 'Denpasar';}
if (num($kode_cabang_staff) ==4){$nm_cabang = 'South Jkt';}
if (num($kode_cabang_staff) ==5){$nm_cabang = 'North Jkt';}
if (num($kode_cabang_staff) ==6){$nm_cabang = 'West Jkt';}
if (num($kode_cabang_staff) ==7){$nm_cabang = 'Bandung';}
if (num($kode_cabang_staff) ==8){$nm_cabang = 'Malang TBI';}
if (num($kode_cabang_staff) ==9){$nm_cabang = 'Bandung TBI';}
if (num($kode_cabang_staff) ==10){$nm_cabang = 'Bali TBI';}
if (num($kode_cabang_staff) ==100){$nm_cabang = 'National';}
$no = in_val('no', 'get');
$transaksi_id = in_val('no', 'get');
$storage = in_val('st', 'get');
$st = in_val('st', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$Submit = in_val('Submit', 'get');
$query = q_set($__p_query, "SELECT item FROM mst_asset  where id = ? ", [(string) ($no)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$book_title = $row[0];
		}
	}
if ($klp != 'ACC')
	{
	$query = q_set($__p_query, "SELECT count(a.reg_code) FROM mst_asset_reg_dtl a where id_book = ?  and status = 1 and kd_cbg = ? ", [(string) ($no), (string) ($kode_cabang_staff)]);
	}
else
	{
	$query = q_set($__p_query, "SELECT count(a.reg_code) FROM mst_asset_reg_dtl a where id_book = ?  and status = 1", [(string) ($no)]);
	}
	
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$stock = $row[0];
		}
	}
$query = q_set($__p_query, "SELECT count(a.reg_code) FROM mst_asset_reg_dtl a where id_book = ?  and status = 0 and remark <> ''", [(string) ($no)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$usage = $row[0];
		}
	}
$query_reg = q_set($__p_query_reg, "SELECT count(reg_code) from ves_data.mst_asset_reg_dtl where id_book = ? and id_transaksi  = ? and status = 1 and kd_cbg= ? ", [(string) ($book_id), (string) ($transaksi_id), (string) ($kode_cabang_staff)]);

$resource_reg = db_query_soft($query_reg, $__p_query_reg ?? []);
$keluar_reg = db_num_rows($resource_reg);
if(num(db_num_rows($resource_reg)) > 0)
	{
	while ($row_reg  =  db_fetch($resource_reg, PDO::FETCH_NUM))
		{
		$reg_jml = $row_reg[0];
		}
	}
	if ($storage =='East Sby'){$kd_branch_dipilih='1';}
	if ($storage =='West Sby'){$kd_branch_dipilih='2';}
	if ($storage =='Denpasar'){$kd_branch_dipilih='3';}
	if ($storage =='Malang'){$kd_branch_dipilih='8';}
	if ($storage =='South Jkt'){$kd_branch_dipilih='4';}
	if ($storage =='North Jkt'){$kd_branch_dipilih='5';}
	if ($storage =='West Jkt'){$kd_branch_dipilih='6';}
	if ($storage =='Bandung'){$kd_branch_dipilih='7';}
	if ($storage =='Vpro East'){$kd_branch_dipilih='11';}
	if ($storage =='Vpro West'){$kd_branch_dipilih='12';}
	if ($storage =='HO'){$kd_branch_dipilih='10';}
$storage_destination = in_val('storage_destination', 'get');

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista Customer System Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

  <!-- Left side column. contains the logo and sidebar -->
  
<?php //   include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->

  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3> Registration Code List</h3>
	<table width="100%" class="table table-bordered table-striped" id="example2">
	  <tbody>
	    <tr>
	      <td width="28%" height="14" align=center class="style24">Book Title</td>
	      <td width="16%" align=center class="style24">Center</td>
	      <td width="12%" align=center class="style24">Stock</td>
	      <td width="20%" align=center class="style24">Usage</td>
	      </tr>
	    <?php
	$no_urut = 1;

?>
	    <tr>
	      <td height="14" align=left class="style24"><?php echo e($book_title) ?></td>
	      <td align=left class="style24"><?php echo e($nm_cabang) ?></td>
	      <td align=center class="style24"><?php echo e($stock) ?></td>
	      <td align=center class="style24"><?php echo e($usage) ?><span class="form-group"></td>
	      </tr>
	    <?php  $no_urut = num($no_urut) +1 ; ?>
	    <tfoot>
        </tfoot>
	  </table>
</div>
     </div>
     <div class="box box-warning">
       <div class="box-body">
     
         <table width="100%" class="table table-bordered table-striped" id="example3">
        <thead>
          <tr>
            <td width="3%" height="14" align=center class="style24">No</td>
            <td width="22%" align=center class="style24">Reg Code</td>
            <td width="37%" align=center class="style24">Status</td>
          </tr>
        </thead>
        <tbody>
          <?php
				 	$no_urut = 1;
$i = 1;
if ($klp !='ACC')
	{
	$query_reg_dtl= q_set($__p_query_reg_dtl, "SELECT reg_code, status, remark FROM mst_asset_reg_dtl where id_book = ?  and kd_cbg = ?  and (status = 1 or status = 0) order by id", [(string) ($no), (string) ($kode_cabang_staff)]);
	}
else
	{
	$query_reg_dtl= q_set($__p_query_reg_dtl, "SELECT reg_code, status, remark FROM mst_asset_reg_dtl where id_book = ?  and kd_cbg <>''and (status = 1 or status = 0) order by id", [(string) ($no)]);
	}
	
$resource_reg_dtl = db_query_soft($query_reg_dtl, $__p_query_reg_dtl ?? []);

if(num(db_num_rows($resource_reg_dtl)) > 0)
	{
	while ($row_reg_dtl  =  db_fetch($resource_reg_dtl, PDO::FETCH_NUM))
		{
		$reg_code = $row_reg_dtl[0];
		$status = $row_reg_dtl[1];
		
		$remark = $row_reg_dtl[2];
		if ($remark !='' and $klp =='ACC')
			{
			$query_reg_cbg= q_set($__p_query_reg_cbg, "SELECT kd_billing,a.kd_branch, nama_lengkap FROM vip_billing a left join vip_student_data b on a.kd_biodata = b.kd_biodata where kd_billing = ? ", [(string) ($remark)]);

			$resource_reg_cbg = db_query_soft($query_reg_cbg, $__p_query_reg_cbg ?? []);

			if(num(db_num_rows($resource_reg_cbg)) > 0)
				{
				while ($row_reg_cbg  =  db_fetch($resource_reg_cbg, PDO::FETCH_NUM))
					{
					$nama_cbg = $row_reg_cbg[1];
					$nama_student = $row_reg_cbg[2];
					}
			}
					
					
			}

			 

?>
          <tr>
            <td height="14" align=center class="style24"><?php echo e($no_urut);  ?></td>
            <td align=center class="style24"><?php echo e($reg_code) ?><span class="form-group">
              <br>
              <input type="hidden" name="id_reg_code_<?php echo e($i) ?>" maxlength="5"  class="form-control" value = "<?php echo e($id_reg_code)  ?>"/>
            </span></td>
            <td align=center class="style24"><?php echo e($remark) ?><span class="form-group"><br>
            <?php echo e($nama_cbg) ?><?php echo e($nama_student) ?></span></td>
          </tr>
          <?php  $no_urut = num($no_urut) +1; $i = num($i)+1;					$nama_cbg ='';$nama_student =''; } } ; ?>
        <tfoot>
        </tfoot>
      </table>
       </div>
     </div>
    </section>

   <!-- Main content -->


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