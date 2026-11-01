<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if ($url_original == ''){$url_original = $url_asli;}

$kode_cabang_staff = $_SESSION['kd_branch'];
if (num($kode_cabang_staff) ==1){$nm_cabang = 'East Sby';}
if (num($kode_cabang_staff) ==2){$nm_cabang = 'West Sby';}
if (num($kode_cabang_staff) ==3){$nm_cabang = 'Denpasar';}
if (num($kode_cabang_staff) ==4){$nm_cabang = 'South Jkt';}
if (num($kode_cabang_staff) ==5){$nm_cabang = 'North Jkt';}
if (num($kode_cabang_staff) ==11){$nm_cabang = 'PIK';}
if (num($kode_cabang_staff) ==12){$nm_cabang = 'Serpong';}
if (num($kode_cabang_staff) ==6){$nm_cabang = 'South Jkt';}
if (num($kode_cabang_staff) ==7){$nm_cabang = 'Bandung';}
if (num($kode_cabang_staff) ==8){$nm_cabang = 'Malang TBI';}
if (num($kode_cabang_staff) ==9){$nm_cabang = 'Bandung TBI';}
if (num($kode_cabang_staff) ==10){$nm_cabang = 'Bali TBI';}
if (num($kode_cabang_staff) ==100){$nm_cabang = 'National';}
$idb = in_val('idb', 'any');
$transaksi_id = in_val('no', 'any');
$storage = in_val('st', 'any');
$st = in_val('st', 'any');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$sdh_cek = 0;
	
$CHECK = in_val('CHECK', 'any');
if ($CHECK != '')
{
$book_title = in_val('book_title', 'any');	
$query = q_set($__p_query, "SELECT id FROM  ves_data.mst_asset where item = ? ", [(string) ($book_title)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$book_id = $row[0];
		}
	}	
if ($nm_cabang =='PIK'or $nm_cabang =='Serpong'){	
$query = q_set($__p_query, "SELECT reg_code, id FROM ves_data.mst_asset_reg_dtl m where status = 1 and id_book = ?  and storage = 'South Jkt' order by id_transaksi, id limit 1 ", [(string) ($book_id)]);
}
else
{
$query = q_set($__p_query, "SELECT reg_code, id FROM ves_data.mst_asset_reg_dtl m where status = 1 and id_book = ?   and storage = ? order by id_transaksi, id limit 1 ", [(string) ($book_id), (string) ($nm_cabang)]);
	
}
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$reg_code = $row[0];
		$id_inventory_book = $row[1];
		if($id_inventory_book != ''){$sdh_cek = 1;}
		}
	}	
}
else
{
$query = q_set($__p_query, "SELECT book_title,b.id FROM ves_data.vip_billing a left join ves_data.mst_asset b on a.book_title = b.item where kd_billing = ? ", [(string) ($idb)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$book_id = $row[1];
		$book_title = $row[0];
		}
	}	
}
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
    <!-- Content Header (Page header) --><!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

	

<div class="col-md-12"><div class="box box-warning">		
<div class="box-body">
			  <div class="col-md-10">
	    <form name="myform" id="myform" action="#" method="post"><?php echo csrf_field(); ?>
			  
 
			    <table width="100%" class="table table-bordered table-striped" id="example1">
			 <tbody>	
          <tr>
            <td width="28%" align=center class="style24">Book Title<span class="form-group">
              <input type="hidden" name="idb"  class="form-control" value = "<?php echo e($idb)  ?>" />
              <input type="hidden" name="id_inventory_book"  class="form-control" value = "<?php echo e($id_inventory_book)  ?>" />
            </span></td>
            <td width="28%" height="14" align=center class="style24">&nbsp;</td>
            </tr>
				

          <tr>
            <td align=center class="style24"><span class="form-group">
              <select class="form-control" name="book_title">
<?php				  
$query_book = q_set($__p_query_book, "SELECT item  FROM mst_asset where kategori = 'BUKU' order by item");
								$resource_book = db_query_or_die('errro_7', $query_book, $__p_query_book ?? []);
								while ($row_book=  db_fetch($resource_book, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_book[0]).'">'.e($row_book[0]).'</option>';
							  		}
?>				  
                <option selected><?php echo e($book_title) ?></option>
                </select>
            </span></td>
            <td height="14" align=center class="style24"><span class="form-group">
              <input type="hidden" name="book_id"  class="form-control" value = "<?php echo e($book_id)  ?>" /><input name="CHECK" type="submit" id="CHECK"  class="form-control"  value="CHECK" />
            </span></td>
			  
            </tr>
          <tr>
            <td align=left class="style24">Book ID Given: <strong><?php echo e($reg_code) ?><br>
            </strong></td>
            <td height="14" align=center class="style24"><span class="form-group">
              <input type="hidden" name="reg_code"  class="form-control" value = "<?php echo e($reg_code)  ?>" />
<?php if (num($sdh_cek) == 1){?>				
              <input name="Submit" type="submit" id="Submit"  class="form-control"  value="Submit" />
<?php } ?>				
            </span></td>
          </tr>


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

<div class="col-md-12"></div>	
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
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";	
	$idb = in_val('idb', 'any');
	$id_inventory_book = in_val('id_inventory_book', 'any');
	$query_update_billing= q_set($__p_query_update_billing, "update ves_data.mst_asset_reg_dtl set  status = '0', remark = ? ,pic = ? ,dt_entry = ? where id = ? ", [(string) ($idb), (string) ($nama_lengkap), (string) ($tgl_hari_ini), (string) ($id_inventory_book)]); 
	$resource_update_billing = db_query_or_die('errro_simpan', $query_update_billing, $__p_query_update_billing ?? []);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Please Print Receipt Book Material');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";	
	}
?>	