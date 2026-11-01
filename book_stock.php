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
$start_stock = in_val('start_stock', 'get');
$end_stock = in_val('end_stock', 'get');
	
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
	if ($storage =='East Sby'){$storage='1';}
	if ($storage =='West Sby'){$storage='2';}
	if ($storage =='Denpasar'){$storage='3';}
	if ($storage =='Malang'){$storage='8';}
	if ($storage =='South Jkt'){$storage='4';}
	if ($storage =='North Jkt'){$storage='5';}
	if ($storage =='PIK'){$storage='11';}
	if ($storage =='West Jkt'){$storage='6';}
	if ($storage =='Bandung'){$storage='7';}
	if ($storage =='Vpro East'){$storage='11';}
	if ($storage =='Vpro West'){$storage='12';}
	if ($storage =='HO'){$storage='10';}	

	if ($storage =='1'){$nm_cabang='East Sby';$kd_branch_dipilih = 1;}
	if ($storage =='2'){$nm_cabang='West Sby';$kd_branch_dipilih = 2;}
	if ($storage =='3'){$nm_cabang='Denpasar';$kd_branch_dipilih = 3;}
	if ($storage =='8'){$nm_cabang='Malang';$kd_branch_dipilih = 8;}
	if ($storage =='4'){$nm_cabang='South Jkt';$kd_branch_dipilih = 4;}
	if ($storage =='5'){$nm_cabang='North Jkt';$kd_branch_dipilih = 5;}
	if ($storage =='6'){$nm_cabang='West Jkt';$kd_branch_dipilih = 6;}
	if ($storage =='7'){$nm_cabang='Bandung';$kd_branch_dipilih = 7;}
	if ($storage =='11'){$nm_cabang='PIK';$kd_branch_dipilih = 11;}
	if ($storage =='12'){$nm_cabang='Vpro West';$kd_branch_dipilih = 12;}
	if ($storage =='10'){$nm_cabang='HO';$kd_branch_dipilih = 10;}
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
  
<?php     include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		  <form name="myform" id="myform">	
     <div class="box box-warning">
<div class="box-body">
	<h3> VE Book Stock and Usage Report<br>
	</h3>
	<div class="col-md-3">
	  <div class="form-group">
	    <label>Center</label>
	    <select name="storage"  onChange="this.form.submit()"   class="form-control"  id="select">
	      <option value="0">--CHOOSE--</option>
	      <option value="1">East Sby</option>
	      <option value="2">West Sby</option>
	      <option value="3">Denpasar</option>
	      <option value="8">Malang</option>
	      <option value="101">East Area</option>
	      <option value="4">South Jkt</option>
	      <option value="5">North Jkt</option>
	      <option value="6">West Jkt</option>
	      <option value="7">Bandung</option>
	      <option value="102">West Area</option>
	      <option value="100">Online</option>
	      <option value="">National</option>
	      <option selected="selected"><?php echo e($nm_cabang) ?></option>
        </select>
	  </div>
    </div>
	<div class="col-md-3">
	  <div class="form-group">
	  <label>Start Period</label>
	  <input type="date" class="form-control"  placeholder="Enter ..." name="start_stock" value="<?php echo e($start_stock) ?>"  onChange="this.form.submit()">
	  </div>
    </div>
	<div class="col-md-3">
	  <div class="form-group">
<label>End Period</label>
<input type="date" class="form-control"  placeholder="Enter ..." name="end_stock" value="<?php echo e($end_stock) ?>"  onChange="this.form.submit()">
	  </div>
    </div>
	<div class="col-md-3">
	  <div class="form-group">
	    <label></label>     <br>
 <a href="inventory_new.php" 
target="popup" 
onclick="window.open('inventory_new.php','popup','width=1000,height=800'); return false;"> <button type="submit" class="btn btn-primary">Print</button></a>
	  </div>
    </div>
	<h3>	  <br>
    </h3>



</div>
     </div>
    </section>
  
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
            <td height="14" align=right class="style24">&nbsp;</td>
            <td height="14" align=right class="style24">&nbsp;</td>
            <td height="14" align=right class="style24">&nbsp;</td>
            <td align=right class="style24">&nbsp;</td>
            <td height="14" align=right class="style24">&nbsp;</td>
            <td height="14" align=right class="style24">&nbsp;</td>
            <td align=right class="style24">&nbsp;</td>
            <td align=right class="style24">&nbsp;</td>
            <td height="14" align=right class="style24">&nbsp;</td>

            </tr	
          
			          <tr>
			            <td align=center class="style24">No</td>
			            <td align=center class="style24">Book Title</td>
			            <td align=center class="style24">Stock In</td>
			            <td align=center class="style24">Move In</td>
			            <td align=center class="style24">Stock</td>
			            <td colspan="2" align=center bgcolor="#A8E995" class="style24">Usage</td>
			            <td align=center class="style24">Move Out</td>
			            <td align=center class="style24"><strong>Balance</strong></td>
              </tr>
	          <tr>
              <td width="5%" align=center class="style24">&nbsp;</td>
              <td width="23%" align=center class="style24">TOTAL</td>
              <td width="6%" align=center class="style24">&nbsp;</td>
              <td width="7%" align=center class="style24">&nbsp;</td>
              <td width="7%" align=center class="style24">&nbsp;</td>
              <td width="8%" align=center class="style24">&nbsp;</td>
              <td width="11%" align=center class="style24">&nbsp;</td>
              <td width="12%" align=center class="style24">&nbsp;</td>
              <td width="21%" align=center class="style24">&nbsp;</td>
              
            </tr>
          </thead>
      <tbody>					
        <?php
	$no_urut = 1;
$query_list_book = q_set($__p_query_list_book, "SELECT item,id,kode_item  FROM mst_asset where kategori = 'BUKU' order by item");
$resource_list_book = db_query_or_die('errro_7', $query_list_book, $__p_query_list_book ?? []);
while ($row_list_book=  db_fetch($resource_list_book, PDO::FETCH_NUM))
	{  
//stock in
$query_stock_in = q_set($__p_query_stock_in, "SELECT count(reg_code) FROM mst_asset_reg_dtl  a left join mst_asset_in b on a.id_book = b.id_item and a.id_transaksi = b.id where dt_beli between ? and ? and a.id_book = ? and a.kd_cbg = ? ", [(string) ($start_stock), (string) ($end_stock), (string) ($row_list_book[1]), (string) ($kd_branch_dipilih)]);	
	
$resource_stock_in = db_query_or_die('errro_715', $query_stock_in, $__p_query_stock_in ?? []);
	while ($row_stock_in=  db_fetch($resource_stock_in, PDO::FETCH_NUM))
		{
		$stock_in = $row_stock_in[0];	
		}
//===
//move in
$query_in = q_set($__p_query_in, "SELECT count(a.reg_code) FROM mst_asset_move a left join mst_asset_reg_dtl b on a.reg_code = b.reg_code where b.id_book = ? and kd_cbg_destination =? and dt_entry_receive  between ? and ? ", [(string) ($row_list_book[1]), (string) ($kd_branch_dipilih), (string) ($start_stock), (string) ($end_stock)]);	

$resource_in = db_query_or_die('errro_712', $query_in, $__p_query_in ?? []);
	while ($row_in=  db_fetch($resource_in, PDO::FETCH_NUM))
		{
		$move_in = $row_in[0];	
		}
//===	
//stock
$query_stock = q_set($__p_query_stock, "SELECT count(reg_code) FROM mst_asset_reg_dtl a where id_book = ? and kd_cbg = ? and (status = 1 or (remark <> '' and dt_entry > ? ))", [(string) ($row_list_book[1]), (string) ($kd_branch_dipilih), (string) ($end_stock)]);	

$resource_stock = db_query_or_die('errro_741', $query_stock, $__p_query_stock ?? []);
	while ($row_stock=  db_fetch($resource_stock, PDO::FETCH_NUM))
		{
		$stock_asal = $row_stock[0];
		$stock_skrg = $row_stock[0];
		
		}
//===	
//===	
//usage
$query_usage = q_set($__p_query_usage, "SELECT count(a.reg_code) FROM mst_asset_reg_dtl a where id_book = ? and kd_cbg = ? and status = 0 and remark <> '' and a.dt_entry between ? and ? ", [(string) ($row_list_book[1]), (string) ($kd_branch_dipilih), (string) ($start_stock), (string) ($end_stock)]);	

$resource_usage = db_query_or_die('errro_741', $query_usage, $__p_query_usage ?? []);
	while ($row_usage=  db_fetch($resource_usage, PDO::FETCH_NUM))
		{
		$usage = $row_usage[0];	
		}	
	
$stock_asal = num($stock_asal) + num($usage);	
//===	
//nm_kelas
$query_kelas = q_set($__p_query_kelas, "SELECT kd_class,count(kd_billing) FROM mst_asset_reg_dtl a left join vip_billing b on a.remark = b.kd_billing where id_book = ? and kd_cbg = ? and status = 0 and remark <> '' and a.dt_entry between ? and ? and kd_class <> '' group by kd_class ", [(string) ($row_list_book[1]), (string) ($kd_branch_dipilih), (string) ($start_stock), (string) ($end_stock)]);	
$resource_kelas = db_query_or_die('errro_741', $query_kelas, $__p_query_kelas ?? []);
	while ($row_kelas=  db_fetch($resource_kelas, PDO::FETCH_NUM))
		{
		$jml_stu = $row_kelas[1];
		$list_kelas = "$row_kelas[0]($jml_stu)";
		
		if ($nm_kelas <> ''){$nm_kelas = $nm_kelas . "<br>";}
		$nm_kelas = "$nm_kelas $list_kelas";
		}		

//move out
$query_out = q_set($__p_query_out, "SELECT count(a.reg_code) FROM mst_asset_move a left join mst_asset_reg_dtl b on a.reg_code = b.reg_code where b.id_book = ? and kd_cbg_source =? and dt_entry_send  between ? and ? ", [(string) ($row_list_book[1]), (string) ($kd_branch_dipilih), (string) ($start_stock), (string) ($end_stock)]);	

$resource_out = db_query_or_die('errro_712', $query_out, $__p_query_out ?? []);
	while ($row_out=  db_fetch($resource_out, PDO::FETCH_NUM))
		{
		$move_out = $row_out[0];	
		}
//===		
		$query_list_book_out = q_set($__p_query_list_book_out, "SELECT\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'East Sby'THEN 1 ELSE 0 END) AS jml_ea, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'East Sby'THEN harga_beli ELSE 0 END) AS price_ea,\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'West Sby'THEN 1 ELSE 0 END) AS jml_ws, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'West Sby'THEN harga_beli ELSE 0 END) AS price_wa,\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Denpasar'THEN 1 ELSE 0 END) AS jml_dps, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Denpasar'THEN harga_beli ELSE 0 END) AS price_dps,\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'South Jkt'THEN 1 ELSE 0 END) AS jml_sj, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'South Jkt'THEN harga_beli ELSE 0 END) AS price_sj,\r
SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'North Jkt'THEN 1 ELSE 0 END) AS jml_nj, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'North Jkt'THEN harga_beli ELSE 0 END) AS price_nj,\r
 SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'West Jkt'THEN 1 ELSE 0 END) AS jml_wj, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'West Jkt'THEN harga_beli ELSE 0 END) AS price_wj,\r
 SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Bandung'THEN 1 ELSE 0 END) AS jml_bdg, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Bandung'THEN harga_beli ELSE 0 END) AS price_bdg,\r
 SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Malang'THEN 1 ELSE 0 END) AS jml_mlg, SUM(CASE WHEN status= 0 and a.remark <> ''  and storage = 'Malang'THEN harga_beli ELSE 0 END) AS price_mlg\r
 FROM ves_data.mst_asset_reg_dtl a left join ves_data.mst_asset_in b on a.id_book = b.id_item and a.id_transaksi = b.id where b.id_item = ? ", [(string) ($row_list_book[1])]);

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
			$ttl_jml = num($es_jml)+num($ws_jml)+num($dps_jml)+num($sj_jml)+num($nj_jml)+num($wj_jml)+num($bdg_jml)+num($mlg_jml);
			$ttl_price = num($es_price)+num($ws_price)+num($dps_price)+num($sj_price)+num($nj_price)+num($wj_price)+num($bdg_price)+num($mlg_price);
			
			}

?>
          <tr>
            <td height="14" align=center class="style24"><?php echo e($no_urut);  ?></td>
            <td align=left class="style24"><a href="book_inventory_profil.php?no=<?php echo e(u($row_list_book[1])); ?>" target="_blank"><?php echo e($row_list_book[0])  ?> (<?php echo e($row_list_book[2])  ?>)</a></td>
            <td align=center class="style24"><?php echo e($stock_in) ?></td>
            <td align=center class="style24"><?php echo e($move_in) ?></td>
            <td align=center class="style24"><?php echo e($stock_asal)  ?><br></td>
            <td align=center class="style24" bgcolor="#A8E995"><?php echo e($usage)  ?><br></td>
            <td align=center class="style24" bgcolor="#A8E995"><?php echo $nm_kelas  ?></td>
            <td align=center class="style24"><?php echo e($move_out) ?><?php echo e($move_out) ?></td>
            <td align=center class="style24"><strong><?php echo e($stock_skrg)  ?></strong><br></td>

            </tr>
            <?php  $no_urut = num($no_urut) +1; $nm_kelas = ''; $list_kelas = '';} ?>

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