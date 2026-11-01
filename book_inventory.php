<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');
$st = in_val('st', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$storage = in_val('storage', 'get');
$source = in_val('source', 'get');
$nm_book = in_val('nm_book', 'get');
$nm_vendor = in_val('nm_vendor', 'get');
$jml_masuk = in_val('jml_masuk', 'get');
$dt_in = in_val('dt_in', 'get');
$jml_unit = in_val('jml_unit', 'get');
$viewedby = in_val('viewedby', 'get');
if($viewedby ==''){$viewedby ='Stock';}
if ($viewedby =='Stock'){$jdl = 'Stock / Total Price';}
else {$jdl = 'Usage / Total Price';}
	

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

	
    <script src="newdata/js/jquery-3.1.1.min.js"></script>
    <script src="newdata/js/bootstrap.min.js"></script>
    <script src="newdata/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="newdata/css/bootstrap-datepicker.css"></link>
	
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php     include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3> VE Material Book Management<br>
	</h3>

               <a href="inventory_new.php" 
target="popup" 
onclick="window.open('inventory_new.php','popup','width=1000,height=800'); return false;"> <button type="submit" class="btn btn-primary">New Title</button></a>

               <a href="book_stock.php" 
target="_blank"> <button type="submit" class="btn btn-primary">Stock and Usage Book Report</button></a>
</div>
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
			    <table width="100%" class="table table-bordered table-striped" id="example1">
			<thead>
			          <tr>
            <td height="14" colspan="10" align=right class="style24">View By</td>
            <td height="14" colspan="2" align=right class="style24">	        <select class="form-control" name="viewedby"  onChange="this.form.submit()">
              <option>Stock</option>
              <option>Usage</option>
              
              <option selected><?php echo  e($viewedby) ?></option>
            </select></td>
            </tr	
          <tr>
            <td width="6%" rowspan="2" align=center class="style24">No</td>
            <td width="25%" rowspan="2" align=center class="style24">Book Title</td>
            <td width="7%" rowspan="2" align=center class="style24">Code</td>
            <td height="14" colspan="9" align=center class="style24"><?php echo e($jdl) ?></td>
            </tr>
          <tr>
            <td width="4%" height="14" align=center class="style24">HO</td>
            <td width="4%" align=center class="style24">East Sby</td>
            <td width="8%" align=center class="style24">West Sby</td>
            <td width="8%" align=center class="style24">Denpasar</td>
            <td width="8%" align=center class="style24">South Jkt</td>
            <td width="14%" align=center class="style24">North Jkt</td>
            <td width="14%" align=center class="style24">West Jkt</td>
            <td width="14%" align=center class="style24">Bandung</td>
            <td width="14%" align=center class="style24">TOTAL</td>
            </tr></thead>
      <tbody>					
        <?php
	$no_urut = 1;
$query_list_book = q_set($__p_query_list_book, "SELECT item,id,kode_item  FROM mst_asset where kategori = 'BUKU' order by item");
$resource_list_book = db_query_or_die('errro_7', $query_list_book, $__p_query_list_book ?? []);
while ($row_list_book=  db_fetch($resource_list_book, PDO::FETCH_NUM))
	{  
	if ($viewedby == 'Stock'){
	$query_list_book_out = q_set($__p_query_list_book_out, "SELECT   \r
         SUM(CASE WHEN status= 1 and storage = 'East Sby'THEN status ELSE 0 END) AS jml_ea, SUM(CASE WHEN status= 1 and storage = 'East Sby'THEN harga_beli   ELSE 0 END) AS price_ea,\r
         SUM(CASE WHEN status= 1 and storage = 'West Sby'THEN status ELSE 0 END) AS jml_ws, SUM(CASE WHEN status= 1 and storage = 'West Sby'THEN harga_beli   ELSE 0 END) AS price_wa,\r
         SUM(CASE WHEN status= 1 and storage = 'Denpasar'THEN status ELSE 0 END) AS jml_dps, SUM(CASE WHEN status= 1 and storage = 'Denpasar'THEN harga_beli   ELSE 0 END) AS price_dps,\r
         SUM(CASE WHEN status= 1 and storage = 'South Jkt'THEN status ELSE 0 END) AS jml_sj, SUM(CASE WHEN status= 1 and storage = 'South Jkt'THEN harga_beli   ELSE 0 END) AS price_sj,\r
         SUM(CASE WHEN status= 1 and storage = 'North Jkt'THEN status ELSE 0 END) AS jml_nj, SUM(CASE WHEN status= 1 and storage = 'North Jkt'THEN harga_beli   ELSE 0 END) AS price_nj,\r
         SUM(CASE WHEN status= 1 and storage = 'West Jkt'THEN status ELSE 0 END) AS jml_wj, SUM(CASE WHEN status= 1 and storage = 'West Jkt'THEN harga_beli   ELSE 0 END) AS price_wj,\r
         SUM(CASE WHEN status= 1 and storage = 'Bandung'THEN status ELSE 0 END) AS jml_bdg, SUM(CASE WHEN status= 1 and storage = 'Bandung'THEN harga_beli   ELSE 0 END) AS price_bdg,\r
         SUM(CASE WHEN status= 1 and storage = 'Malang'THEN status ELSE 0 END) AS jml_mlg, SUM(CASE WHEN status= 1 and storage = 'Malang'THEN harga_beli   ELSE 0 END) AS price_mlg,\r
SUM(CASE WHEN status= 1 and storage = 'HO'THEN status ELSE 0 END) AS jml_ho, SUM(CASE WHEN status= 1 and storage = 'HO'THEN harga_beli   ELSE 0 END) AS price_ho\t\t \r
          FROM ves_data.mst_asset_reg_dtl a left join ves_data.mst_asset_in b on a.id_book = b.id_item and a.id_transaksi = b.id where b.id_item = ? ", [(string) ($row_list_book[1])]);
	}
	else
	{
		$query_list_book_out = q_set($__p_query_list_book_out, "SELECT\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'East Sby'THEN 1 ELSE 0 END) AS jml_ea, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'East Sby'THEN harga_beli ELSE 0 END) AS price_ea,\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'West Sby'THEN 1 ELSE 0 END) AS jml_ws, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'West Sby'THEN harga_beli ELSE 0 END) AS price_wa,\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Denpasar'THEN 1 ELSE 0 END) AS jml_dps, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Denpasar'THEN harga_beli ELSE 0 END) AS price_dps,\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'South Jkt'THEN 1 ELSE 0 END) AS jml_sj, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'South Jkt'THEN harga_beli ELSE 0 END) AS price_sj,\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'North Jkt'THEN 1 ELSE 0 END) AS jml_nj, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'North Jkt'THEN harga_beli ELSE 0 END) AS price_nj,\r
 SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'West Jkt'THEN 1 ELSE 0 END) AS jml_wj, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'West Jkt'THEN harga_beli ELSE 0 END) AS price_wj,\r
 SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Bandung'THEN 1 ELSE 0 END) AS jml_bdg, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Bandung'THEN harga_beli ELSE 0 END) AS price_bdg,\r
 SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Malang'THEN 1 ELSE 0 END) AS jml_mlg, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Malang'THEN harga_beli ELSE 0 END) AS price_mlg,\r
 SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'HO' THEN 1 ELSE 0 END) AS jml_ho, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'HO'THEN harga_beli ELSE 0 END) AS price_ho\r
 FROM ves_data.mst_asset_reg_dtl a left join ves_data.mst_asset_in b on a.id_book = b.id_item and a.id_transaksi = b.id where b.id_item = ? ", [(string) ($row_list_book[1])]);

	}
		$resource_list_book_out = db_query_or_die('errro_71', $query_list_book_out, $__p_query_list_book_out ?? []);
		while ($row_list_book_out=  db_fetch($resource_list_book_out, PDO::FETCH_NUM))
			{
			$es_jml = $row_list_book_out[0];
			$es_price = $row_list_book_out[1];
			$ws_jml = $row_list_book_out[2];
			$ws_price = $row_list_book_out[3];
			$dps_jml = $row_list_book_out[4];
			$dps_price = $row_list_book_out[5];
			$sj_jml = $row_list_book_out[6];
			$sj_price = $row_list_book_out[7];
			$nj_jml = $row_list_book_out[8];
			$nj_price = $row_list_book_out[9];
			$wj_jml = $row_list_book_out[10];
			$wj_price = $row_list_book_out[11];
			$bdg_jml = $row_list_book_out[12];
			$bdg_price = $row_list_book_out[13];
			$mlg_jml = $row_list_book_out[14];
			$mlg_price = $row_list_book_out[15];
			$ho_jml = $row_list_book_out[16];
			$ho_price = $row_list_book_out[17];			
			$ttl_jml = num($es_jml)+num($ws_jml)+num($dps_jml)+num($sj_jml)+num($nj_jml)+num($wj_jml)+num($bdg_jml)+num($mlg_jml)+num($ho_jml);
			$ttl_price = num($es_price)+num($ws_price)+num($dps_price)+num($sj_price)+num($nj_price)+num($wj_price)+num($bdg_price)+num($mlg_price)+num($ho_price);
			
			}

?>
          <tr>
            <td height="14" align=center class="style24"><?php echo e($no_urut);  ?></td>
            <td align=left class="style24"><a href="book_inventory_profil.php?no=<?php echo e(u($row_list_book[1])); ?>" target="_blank"><?php echo e($row_list_book[0])  ?></a></td>
            <td align=left class="style24"><?php echo e($row_list_book[2])  ?></td>
            <td align=center class="style24"><?php echo e($ho_jml)  ?><br>
              <?php echo number_format(num($ho_price),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo e($es_jml)  ?><?php echo number_format(num($es_price),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo e($ws_jml)  ?><br>
              <?php echo number_format(num($ws_price),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo e($dps_jml)  ?><br>
              <?php echo number_format(num($dps_price),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo e($sj_jml)  ?><br>
              <?php echo number_format(num($sj_price),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo e($nj_jml)  ?><br>
              <?php echo number_format(num($nj_price),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo e($wj_jml)  ?><br>
              <?php echo number_format(num($wj_price),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo e($bdg_jml)  ?><br>
              <?php echo number_format(num($bdg_price),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo e($ttl_jml)  ?><br>
              <?php echo number_format(num($ttl_price),0,".",".")  ?></td>
            </tr>
            <?php  $no_urut = num($no_urut) +1 ;$ttl_jml = 0;$ttl_price=0;$es_jml = 0;
			$es_price = 0;
			$ws_jml = 0;
			$ws_price = 0;
			$dps_jml = 0;
			$dps_price = 0;
			$sj_jml = 0;
			$sj_price =0;
			$nj_jml = 0;
			$nj_price = 0;
			$wj_jml = 0;
			$wj_price = 0;
			$bdg_jml = 0;
			$bdg_price = 0;
			$mlg_jml = 0;
			$mlg_price = 0;			$ho_jml = 0;
			$ho_price = 0;} ?>

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