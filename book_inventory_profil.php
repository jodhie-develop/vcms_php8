<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$klp = $_SESSION['kelompok'];
$no = in_val('no', 'get');
$kd_branch = $_SESSION['kd_branch'];
$kode_cabang_staff = $kd_branch;
$user = in_val('user', 'get');
if ($no != '')
{	
$query = q_set($__p_query, "SELECT m.id, m.kategori, m.item, m.keterangan FROM ves_data.mst_asset m where id = ? ", [(string) ($no)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$book_id = $row[0];
		$book_title = $row[2];
		$book_deskripsi = $row[3];
		}
	}
}
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
if (num($kode_cabang_staff) ==0){$nm_cabang = 'HO';}
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
	   <div class="col-md-3">
	     <div class="box-body"> <img src="dist/img/photo1.png" alt="Photo" width="212" height="141" class="img-responsive"> </div>
       </div>
	   <span class="form-group">
	   <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="book_id" 
                 	      value="<?php echo e($book_id) ?>" hidden= "hidden">
	   </span>
	   <div class="col-md-6"><div class="box-body">
	<h3><?php echo e($book_title) ?></h3>
( <?php echo e($book_deskripsi)?> )
               <br>
         <a href="inventory_new.php" 
target="popup" 
onclick="window.open('inventory_new.php?no=<?php echo e(u($book_id)) ?>','popup','width=1000,height=800'); return false;"> <button type="submit" class="btn btn-primary">Edit  Title</button></a>
		    <a href="inventory_new.php" 
target="popup" 
onclick="window.open('inventory_new.php?no=<?php echo e(u($book_id)) ?>','popup','width=1000,height=800'); return false;"> <button type="submit" class="btn btn-primary">Upload Image</button></a>
		   <a href="inventory_new.php" 
target="popup" 
onclick="window.open('inventory_new.php?no=<?php echo e(u($book_id)) ?>','popup','width=1000,height=800'); return false;"> <button type="submit" class="btn btn-primary">History</button></a>

               <a href="inventory_in.php" 
target="popup" 
onclick="window.open('inventory_in.php?no=<?php echo e(u($book_id)) ?>','popup','width=1000,height=800'); return false;"> <button type="submit" class="btn btn-primary">Check In Item</button></a>
	<a href="inventory_in.php" 
target="popup" 
onclick="window.open('inventory_detail.php?no=<?php echo e(u($book_id)) ?>','popup','width=1000,height=800'); return false;"> <button type="submit" class="btn btn-primary">Reg Item List</button></a>	   
               
</div></div>
     </div>
    </section>
  <form name="myform" id="myform">	  
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->



<div class="col-md-12"><div class="box box-warning">		
<div class="box-body">
			  <div class="col-md-10">
<?php
$query_total_stock = q_set($__p_query_total_stock, "SELECT count(status) FROM ves_data.mst_asset_reg_dtl where id_book = ?  and kd_cbg = ? and status = 1 ", [(string) ($book_id), (string) ($kd_branch)]);

$resource_total_stock = db_query_or_die('errro_7', $query_total_stock, $__p_query_total_stock ?? []);
while ($row_total_stock=  db_fetch($resource_total_stock, PDO::FETCH_NUM))
	{  
	$ttl_stock = $row_total_stock[0];
	}
?>
	
			    <table width="100%" class="table table-bordered table-striped" id="example1">
			<thead>
          <tr>
            <td width="3%" height="14" align=center class="style24">No</td>
            <td width="7%" align=center class="style24">Type</td>
            <td width="13%" align=center class="style24">Buying<br>
              Date</td>
            <td width="14%" align=center class="style24">Quantity</td>
            <td width="14%" align=center class="style24">Unit <br>
              Price</td>
            <td width="20%" align=center class="style24">Item<br>
              Registered</td>
            <td width="23%" align=center class="style24"><?php echo e($nm_cabang) ?><br>
Stock</td>
            <td width="11%" align=center class="style24">In Transit</td>
            <td width="11%" align=center class="style24">Usage</td>
            <td width="11%" align=center class="style24">Vendor</td>
            <td width="9%" align=center class="style24">Action</td>
            </tr></thead>
      <tbody>					
        <?php
	$no_urut = 1;
$query_list_book = q_set($__p_query_list_book, "SELECT date_format(m.dt_beli,'%d %M %Y'), m.q, m.id_item,m.vendor,id,harga_beli,pic FROM ves_data.mst_asset_in m where id_item = ?  and kd_cbg = ? order by dt_beli", [(string) ($book_id), (string) ($kd_branch)]);			  
$resource_list_book = db_query_or_die('errro_7', $query_list_book, $__p_query_list_book ?? []);
while ($row_list_book=  db_fetch($resource_list_book, PDO::FETCH_NUM))
	{  
	$query_reg = q_set($__p_query_reg, "SELECT count(reg_code) from ves_data.mst_asset_reg_dtl where id_book = ? and id_transaksi  = ? and reg_code <> ''", [(string) ($row_list_book[2]), (string) ($row_list_book[4])]);

	$resource_reg = db_query_soft($query_reg, $__p_query_reg ?? []);
	$keluar_reg = db_num_rows($resource_reg);
	if(num(db_num_rows($resource_reg)) > 0)
		{
		while ($row_reg  =  db_fetch($resource_reg, PDO::FETCH_NUM))
			{
			$reg_jml = $row_reg[0];
			}
		}
	if ($klp != 'ACC')
		{	
		$query_stok = q_set($__p_query_stok, "SELECT count(reg_code) from ves_data.mst_asset_reg_dtl where id_book = ? and id_transaksi  = ? and status = 1 and kd_cbg = ? ", [(string) ($row_list_book[2]), (string) ($row_list_book[4]), (string) ($kode_cabang_staff)]);
		}
	else
		{	
		$query_stok = q_set($__p_query_stok, "SELECT count(reg_code) from ves_data.mst_asset_reg_dtl where id_book = ? and id_transaksi  = ? and status = 1 and kd_cbg <>''", [(string) ($row_list_book[2]), (string) ($row_list_book[4])]);
		}
		
	$resource_stok = db_query_soft($query_stok, $__p_query_stok ?? []);
	$keluar_stok = db_num_rows($resource_stok);
	if(num(db_num_rows($resource_stok)) > 0)
		{
		while ($row_stok  =  db_fetch($resource_stok, PDO::FETCH_NUM))
			{
			$stock_jml = $row_stok[0];
			}
		}
	$query_usage = q_set($__p_query_usage, "SELECT count(reg_code) from ves_data.mst_asset_reg_dtl where id_book = ? and id_transaksi  = ? and status = 0 and remark <> ''", [(string) ($row_list_book[2]), (string) ($row_list_book[4])]);

	$resource_usage = db_query_soft($query_usage, $__p_query_usage ?? []);
	$keluar_usage = db_num_rows($resource_usage);
	if(num(db_num_rows($resource_stok)) > 0)
		{
		while ($row_usage  =  db_fetch($resource_usage, PDO::FETCH_NUM))
			{
			$usage_jml = $row_usage[0];
			}
		}
	$query_transit = q_set($__p_query_transit, "SELECT count(reg_code) from ves_data.mst_asset_reg_dtl where id_book = ?  and status = 2 and kd_cbg = ? ", [(string) ($row_list_book[2]), (string) ($kode_cabang_staff)]);

	$resource_transit = db_query_soft($query_transit, $__p_query_transit ?? []);
	$keluar_transit = db_num_rows($resource_transit);
	if(num(db_num_rows($resource_transit)) > 0)
		{
		while ($row_transit  =  db_fetch($resource_transit, PDO::FETCH_NUM))
			{
			$intransit_jml = $row_transit[0];
			}
		}	
?>
          <tr>
            <td height="14" align=center class="style24"><?php echo e($no_urut);  ?></td>
            <td align=left class="style24">&nbsp;</td>
            <td align=left class="style24"><?php echo e($row_list_book[0])  ?><br>              
              By : <?php echo e($row_list_book[6])  ?></td>
            <td align=center class="style24"><?php echo e($row_list_book[1])  ?></td>
            <td align=center class="style24"><?php echo number_format(num($row_list_book[5]),0,".",".")   ?></td>
            <td align=center class="style24"><?php if (num($reg_jml) != 0){ echo e($reg_jml);  } else {?>
 <a href="inventory_new.php" 
target="popup" 
onclick="window.open('inventory_generate.php?no=<?php echo e(u($row_list_book[4])); ?>','popup','width=1000,height=800'); return false;"><span class="label label-danger">Generate Code</span></a>				
				
				<?php }?></td>
            <td align=center class="style24"><?php echo e($stock_jml) ?></td>
            <td align=center class="style24"><?php echo e($intransit_jml) ?></td>
            <td align=center class="style24"><?php echo e($usage_jml) ?></td>
            <td align=center class="style24"><?php echo e($row_list_book[3]); ?></td>
         <td>
<?php if ($klp == 'ACC'){?>			 
<a href="inventory_upd.php" 
target="popup" 
onclick="window.open('inventory_upd.php?no=<?php echo e(u($row_list_book[4])); ?>','popup','width=1000,height=800'); return false;"><span class="label label-warning">Modify</span></a>	<br>
<?php } ?>	
<?php if ($reg_jml != '0'){?>				 
			 <a href="inventory_new.php" 
target="popup" 
onclick="window.open('inventory_reg.php?no=<?php echo e(u($row_list_book[4])); ?>','popup','width=1000,height=800'); return false;"><span class="label label-success">Item Reg</span></a><br>
<a href="inventory_stock_in.php" 
target="popup" 
onclick="window.open('inventory_stock_in.php?no=<?php echo e(u($row_list_book[4])); ?>&mv=0','popup','width=1000,height=800'); return false;"><span class="label label-primary">Stock In</span></a><br>
<?php if (num($intransit_jml) != 0){?>  			 
<a href="inventory_new.php" 
target="popup" 
onclick="window.open('inventory_mutasi.php?no=<?php echo e(u($row_list_book[4])); ?>&mv=0','popup','width=1000,height=800'); return false;"><span class="label label-info">Mutasi In <?php echo "( " . e($intransit_jml) . " )"?> </span></a><br><?php } ?>
<?php if ($stock_jml != '0') {?>
 			  <a href="inventory_mutasi.php?no=<?php echo e(u($row_list_book[4])); ?>" 
target="popup" 
onclick="window.open('inventory_mutasi.php?no=<?php echo e(u($row_list_book[4])); ?>&mv=1','popup','width=1000,height=800'); return false;"><span class="label label-default">Mutasi Out</span></a><?php } } ?></td>   
            </tr>            <?php  $no_urut = num($no_urut) +1 ;} ?>
          <tr>
            <td height="14" align=center class="style24">&nbsp;</td>
            <td align=left class="style24">&nbsp;</td>
            <td align=left class="style24">&nbsp;</td>
            <td align=center class="style24">&nbsp;</td>
            <td align=center class="style24">&nbsp;</td>
            <td align=center class="style24"><strong>TOTAL STOCK</strong></td>
            <td align=center class="style24"><strong><?php echo e($ttl_stock) ?></strong></td>
            <td align=center class="style24">&nbsp;</td>
            <td align=center class="style24">&nbsp;</td>
            <td align=center class="style24">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>


        <tfoot>
        </tfoot>
    </table>
<br>
      </div>
</div>
		</div>
</div>
<div class="box-body"></div>
<div class="box-body"></div>
</form>
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
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))   /* blok lama tanpa tombol pemicu: hanya POST+CSRF */) 
	{		
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$kdcbg = $_SESSION['kd_branch']; 
	$kdb = in_val('kdb', 'get');
	$st = in_val('st', 'get');
	$hari=date("d");
	$bulan=date("m");
	$bulanan=date("M");
	$storage = in_val('storage', 'get');

	if ($storage =='East Sby'){$kd_branch_dipilih='1';}
	if ($storage =='West Sby'){$kd_branch_dipilih='2';}
	if ($storage =='Denpasar'){$kd_branch_dipilih='3';}
	if ($storage =='Malang'){$kd_branch_dipilih='8';}
	if ($storage =='South Jkt'){$kd_branch_dipilih='4';}
	if ($storage =='North Jkt'){$kd_branch_dipilih='5';}
	if ($storage =='West Jkt'){$kd_branch_dipilih='6';}
	if ($storage =='Bandung'){$kd_branch_dipilih='7';}
	if ($storage =='HO'){$kd_branch_dipilih='10';}
	if ($storage =='Vpro East'){$kd_branch_dipilih='11';}
	if ($storage =='Vpro West'){$kd_branch_dipilih='12';}		

	$source = in_val('source', 'get');
	if ($source =='Vendor') {$source = $nm_vendor;}
	$nm_book = in_val('nm_book', 'get');
	$nm_vendor = in_val('nm_vendor', 'get');
	$jml_masuk = in_val('jml_masuk', 'get');
	$dt_in = in_val('dt_in', 'get');
	$jml_unit = in_val('jml_unit', 'get');		
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";			
	$query_book_in= q_set($__p_query_book_in, "insert into vipbookin (kd_branch,buku, jml_in, dt_in, source, pic) values (? ,? ,? ,? ,? ,? ) ", [(string) ($kd_branch_dipilih), (string) ($nm_book), (string) ($jml_unit), (string) ($dt_in), (string) ($source), (string) ($nama_lengkap)]); 
	$resource_book_in = db_query_or_die('errro_simpan', $query_book_in, $__p_query_book_in ?? []);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('New Book Submitted');\n";
	echo "window.location = ('vipbook.php?storage=" . e(u($storage)) . "');\n";				
	echo "</script>";
		}
if (isset($_GET['Print'])) 
	{
	if ($idb !='')
		{
		echo "<script type=\"text/javascript\">\n";
		echo "window.open('vipbillprint.php?idb=" . e(u($idb)) . "&kdb" . e($kdb) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
		echo "</script>";		
		}
	}
?>