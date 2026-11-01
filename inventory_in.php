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
$no = in_val('no', 'any');
$kd_branch = $_SESSION['kd_branch'];
$user = in_val('user', 'any');
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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">	
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
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
<?php //========================== left nav ?>
 <?php //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
<section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3> VE New Material </h3>
 
</div>
     </div>
    </section><form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body"><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="id_item" 
                 	      value="<?php echo e($book_id) ?>" hidden= "hidden">
  </span></div>    
<div class="col-md-12">
      <div class="box box-warning">		
  <div class="box-body">
    <div class="col-md-3">
      <div class="form-group">
      <label>KATEGORI</label>
      <select class="form-control" name="storage"  readonly>

        <option selected>BUKU</option>
      </select>
    </div>
</div>
  <div class="col-md-8">
	      <div class="form-group">
			      <label>Book Title</label>
	        <input type="text" name="book_deskripsi2"  class="form-control" value = "<?php echo e($book_title)  ?>" readonly />
	      </div>
      </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>DATE</label>
      <input type="date" name="dt_beli"  class="form-control" value = "<?php echo e($dt_beli)  ?>"/>
    </div>
</div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Quantity</label>
      <input type="number" name="q"  class="form-control" value = "<?php echo e($q)  ?>" />
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Buying Price (Rp)</label>
      <input type="number" name="harga_beli"  class="form-control" value = "<?php echo e($harga_beli)  ?>" />
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Vendor Name</label>
      <select class="form-control" name="vendor">
        <option>Mentari</option>
        <option>Periplus</option>
        <option>Global</option>
        <option selected><?php echo  e($vendor) ?></option>
      </select>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="material_fee" 
                 	      value="<?php echo e($material_fee) ?>" hidden="">
    </div>
</div>
  <div class="col-md-8">
    <div class="form-group">
      <label>Description</label>
      <input type="text" name="book_deskripsi"  class="form-control" value = "<?php echo e($book_deskripsi)  ?>" />
    </div>
</div>
  </div>
	  </div><div class="box box-warning">		
<div class="box-body"></div>
		</div>
  </div>   
<div class="box-body"></div>
<div class="box-body"></div></form><input type="submit" name="Submit" value="Submit" />
<input type="submit" name="Delete" value="Delete" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
	$kd_branch = $_SESSION['kd_branch'];
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$id_item = in_val('id_item', 'any'); 
	$dt_beli = in_val('dt_beli', 'any'); 
	$harga_beli = in_val('harga_beli', 'any');
	$vendor = in_val('vendor', 'any');
	$q = in_val('q', 'any');	$book_deskripsi = in_val('book_deskripsi', 'any');	
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
	
	if ($id_item == ''){echo "title must be filled";die;}
	$query_book_in= q_set($__p_query_book_in, "insert into ves_data.mst_asset_in (id_item, dt_beli, q, harga_beli, vendor,pic, dt_entry,remark,kd_cbg) values (? ,? ,? ,? ,? ,? ,? ,? ,? ) ", [(string) ($id_item), (string) ($dt_beli), (string) ($q), (string) ($harga_beli), (string) ($vendor), (string) ($nama_lengkap), (string) ($tgl_hari_ini), (string) ($book_deskripsi), (string) ($kd_branch)]); 

	$resource_book_in = db_query_or_die('errro_simpan', $query_book_in, $__p_query_book_in ?? []);			
		echo "<script type=\"text/javascript\">\n";
	echo "alert('Item Saved ');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";			
	echo "</script>";
	}

?>