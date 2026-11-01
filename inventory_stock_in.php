<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if ($url_original == ''){$url_original = $url_asli;}
$kdcbg = $_SESSION['kd_branch']; 
$transaksi_id = in_val('no', 'any');
$storage = in_val('st', 'any');
$st = in_val('st', 'any');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$query = q_set($__p_query, "SELECT date_format(m.dt_beli,'%d-%m-%Y'), m.q, m.id_item,vendor,item,m.id FROM ves_data.mst_asset_in m left join ves_data.mst_asset b on  m.id_item = b.id where m.id =? ", [(string) ($transaksi_id)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$book_id = $row[2];
		$book_title = $row[4];
		$dt_beli = $row[0];
		$vendor = $row[3];
		$q_old = $row[1];
		$transaksi_id = $row[5]; 
		
		}
	}

$query_reg = q_set($__p_query_reg, "SELECT count(reg_code) from ves_data.mst_asset_reg_dtl where id_book = ? and id_transaksi  = ? and status = 5", [(string) ($book_id), (string) ($transaksi_id)]);

$resource_reg = db_query_soft($query_reg, $__p_query_reg ?? []);
$keluar_reg = db_num_rows($resource_reg);
if(num(db_num_rows($resource_reg)) > 0)
	{
	while ($row_reg  =  db_fetch($resource_reg, PDO::FETCH_NUM))
		{
		$q_old = $row_reg[0];
		}
	}


	if ($kdcbg == '1') {$storage ='East Sby';}
	else if ($kdcbg =='2') {$storage ='West Sby';}
	else if ($kdcbg =='3'){$storage ='Denpasar';}
	else if ($kdcbg =='8') {$storage ='Malang';}
	else if ($kdcbg =='4') {$storage ='South Jkt';}
	else if ($kdcbg =='5') {$storage ='North Jkt';}
	else if ($kdcbg =='6') {$storage ='West Jkt';}
	else if ($kdcbg =='7') {$storage ='Bandung';}
	else if ($kdcbg =='11') {$storage ='Vpro East';}
	else if ($kdcbg =='12') {$storage ='Vpro West';}
	else if ($kdcbg =='0') {$storage ='HO';}
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
	<h3> Registration Code Input</h3>
	<table width="100%" class="table table-bordered table-striped" id="example2">
	  <tbody>
	    <tr>
	      <td width="17%" height="14" align=center class="style24">Book Title</td>
	      <td width="16%" align=center class="style24">Buying Date</td>
	      <td width="23%" align=center class="style24">Vendor</td>
	      <td width="24%" align=center class="style24">Quantity</td>
	      <td width="20%" align=center class="style24">Registered</td>
	      </tr>
	    <?php
	$no_urut = 1;

?>
	    <tr>
	      <td height="14" align=center class="style24"><?php echo e($book_title) ?></td>
	      <td align=left class="style24"><?php echo e($dt_beli) ?></td>
	      <td align=center class="style24"><?php echo e($vendor) ?></td>
	      <td align=center class="style24"><?php echo e($q) ?></td>
	      <td align=center class="style24"><?php echo e($reg_jml) ?><span class="form-group"></td>
	      </tr>
	    <?php  $no_urut = num($no_urut) +1 ; ?>
	    <tfoot>
        </tfoot>
	  </table>
</div>
     </div>
    </section>
	  
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

	

<div class="col-md-12"> <div class="box box-warning">		
<div class="box-body">
			  <div class="col-md-10">
				  
 <form name="myform" id="myform" action="#" method="post"><?php echo csrf_field(); ?>
			  
			    <table width="100%" class="table table-bordered table-striped" id="example1">
			 <tbody>	
          <tr>
            <td width="28%" align=center class="style24">Storage</td>
            <td width="28%" align=center class="style24">Stock</td>
            <td width="28%" height="14" align=center class="style24">Action</td>
            </tr>
				
        <?php
	$no_urut = 1;

?>
          <tr>
            <td align=center class="style24"><span class="form-group">
              <select class="form-control" name="storage">
                <option>Vendor</option>
                <option>HO</option>
                <option>East Sby</option>
                <option>West Sby</option>
                <option>Denpasar</option>
                <option>Malang</option>
                <option>South Jkt</option>
                <option>North Jkt</option>
                <option>West Jkt</option>
                <option>Bandung</option>
                <option>Vpro East</option>
                <option>Vpro West</option>
                <option selected><?php echo e($storage) ?></option>
              </select>
            </span></td>
            <td align=center class="style24"><span class="form-group">
              <input type="number"  class="form-control"  placeholder="Enter ..." name="q" 
                 	      value="<?php echo e($q_old) ?>">
              <input type="hidden"  class="form-control"  placeholder="Enter ..." name="book_id" 
                 	      value="<?php echo e($book_id) ?>">
              <input type="hidden"  class="form-control"  placeholder="Enter ..." name="transaksi_id" 
                 	      value="<?php echo e($transaksi_id) ?>">
              <input type="hidden"  class="form-control"  placeholder="Enter ..." name="q_old" 
                 	      value="<?php echo e($q_old) ?>">
            </span></td>
            <td height="14" align=center class="style24"><input type="submit" name="Submit" value="Submit" /></td>
    		  
            </tr>
            <?php  $no_urut = num($no_urut) +1 ; ?>

        <tfoot>
        </tfoot>
    </table>
		  </form>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
	$book_id = in_val('book_id', 'any');
	$transaksi_id = in_val('transaksi_id', 'any');
	$storage = in_val('storage', 'any');
	$q = in_val('q', 'any');
	$q_old = in_val('q_old', 'any');
	if ($q > $q_old)
		{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Wrong Quantity Submitted');\n";
		echo "window.close(); \n";			
		echo "</script>";	
		die;
		}
	if ( $storage =='')
		{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Storage Empty');\n";
		echo "window.close(); \n";			
		echo "</script>";	
		die;
		}	
	$storage = in_val('storage', 'any');
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
	if ($storage =='HO'){$kd_branch_dipilih='0';}	

	$querylastcode = q_set($__p_querylastcode, "SELECT id FROM ves_data.mst_asset_reg_dtl m WHERE id_transaksi = ?  and id_book = ?  and status = 5 order by id limit ? ", [(string) ($transaksi_id), (string) ($book_id), (int) num($q)]);

$resourcelastcode = db_query_soft($querylastcode, $__p_querylastcode ?? []);
$keluar = db_num_rows($resourcelastcode);
if(num(db_num_rows($resourcelastcode)) > 0)
	{
	while ($rowlastcode  =  db_fetch($resourcelastcode, PDO::FETCH_NUM))
		{
		$id = $rowlastcode[0];
		$query_update_= q_set($__p_query_update_, "update ves_data.mst_asset_reg_dtl set status = '1', kd_cbg = ? , storage = ? ,pic = ? where id = ? ", [(string) ($kd_branch_dipilih), (string) ($storage), (string) ($nama_lengkap), (string) ($id)]);
		$resource_update = db_query_or_die('errro_simpan', $query_update_, $__p_query_update_ ?? []);
		}
	}
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Stock In Succesfully');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";	
}
?>
			<br>
      </div>
			  <p>&nbsp;</p>
</div>
		</div>
</div>

<div class="col-md-12"><div class="box box-warning">		
<div class="box-body">
			  <div class="col-md-10">
	  <form name="myform" id="myform" method="POST" action="#"><?php echo csrf_field(); ?>
			  
			    <table width="100%" class="table table-bordered table-striped" id="example1">
<thead>
          <tr>
            <td width="2%" height="14" align=center class="style24">No</td>
            <td width="22%" align=center class="style24">Storage</td>
            <td width="21%" align=center class="style24">Reg Code</td>
            <td width="26%" align=center class="style24">Action</td>
            </tr>
				</thead> <tbody>				
        <?php
				 	$no_urut = 1;
$i = 1;
$query_reg_dtl= q_set($__p_query_reg_dtl, "SELECT reg_code, storage,id from ves_data.mst_asset_reg_dtl where id_book = ? and id_transaksi  = ? and status = 5 and kd_cbg = ? order by id", [(string) ($book_id), (string) ($transaksi_id), (string) ($kdcbg)]);
$resource_reg_dtl = db_query_soft($query_reg_dtl, $__p_query_reg_dtl ?? []);
if(num(db_num_rows($resource_reg_dtl)) > 0)
	{
	while ($row_reg_dtl  =  db_fetch($resource_reg_dtl, PDO::FETCH_NUM))
		{
		$reg_code = $row_reg_dtl[0];
		$storage = $row_reg_dtl[1];
		$id_reg_code = $row_reg_dtl[2];
?>
          <tr>
            <td height="14" align=center class="style24"><?php echo e($no_urut);  ?></td>
            <td align=center class="style24"><?php echo e($storage) ?></td>
            <td align=left class="style24"><?php echo e($reg_code) ?><span class="form-group">
              <input type="hidden" name="id_reg_code_<?php echo e($i) ?>" maxlength="5"  class="form-control" value = "<?php echo e($id_reg_code)  ?>"/>
            </span></td>
            <td align=center class="style24"><a href="inventory_del.php?id=<?php echo e(u($row_reg_dtl[2])) ?>" 
target="popup" 
onclick="window.open('inventory_del.php?id=<?php echo e(u($row_reg_dtl[2])) ?>','popup','width=1000,height=800'); return false;"> <button type="submit" class="btn btn-danger">Delete</button></a></td>
		  
            </tr>
            <?php  $no_urut = num($no_urut) +1; $i = num($i)+1; } } ; ?>

        <tfoot>
        </tfoot>
    </table>
			
								  </form>
			<br>
      </div>
			  <p>&nbsp;</p>
</div>
		</div>
</div>	
<div class="box-body"></div>
<div class="box-body"></div>

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