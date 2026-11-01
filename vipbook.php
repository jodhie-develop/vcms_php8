<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'any');
$st = in_val('st', 'any');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$storage = in_val('storage', 'any');
$source = in_val('source', 'any');
$nm_book = in_val('nm_book', 'any');
$nm_vendor = in_val('nm_vendor', 'any');
$jml_masuk = in_val('jml_masuk', 'any');
$dt_in = in_val('dt_in', 'any');
$jml_unit = in_val('jml_unit', 'any');

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
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php   include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->
  <form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3>VIP Material Book Management<br>
	</h3>
	<div class="col-md-8">
	  <div class="form-group">
	    <label>Center Storage</label>
	    <select class="form-control" name="storage"  onChange="this.form.submit()">
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
	    </div>
	  </div>
	<h3>&nbsp; </h3>
</div>
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->



<div class="col-md-12">
      <div class="box box-warning">		
  <div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>BOOK  IN</label>
    </div>
  </div>
  <div class="col-md-10">
	      <div class="form-group">
			      <label>Book Name</label>
	        <select class="form-control" name="nm_book">
        <?php
									$query_nm_book = q_set($__p_query_nm_book, "SELECT buku FROM vip_mst_code_prg where buku <> '' and buku <> '-' group by buku order by buku");
								$resource_nm_book = db_query_or_die('errro_7', $query_nm_book, $__p_query_nm_book ?? []);
								while ($row_nm_book=  db_fetch($resource_nm_book, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_book[0]).'">'.e($row_nm_book[0]).'</option>';
							  		}      ?>
			        
			        <option selected><?php echo  e($nm_book) ?></option>
            </select>
          </div>
      </div>
  <div class="col-md-8">
    <div class="form-group">
      <label>SOURCE</label>
      <select class="form-control" name="source"  onChange="this.form.submit()">
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
             
        <option selected><?php echo  e($source) ?></option>
      </select>
    </div>
</div>
 <?php if ($source == 'Vendor'){?>
  <div class="col-md-4">
    <div class="form-group">
      <label>Vendor Name</label>
      <select class="form-control" name="nm_vendor">
        <option>Mentari</option>
        <option>Periplus</option>
        <option>Global</option>       
        <option selected><?php echo  e($nm_vendor) ?></option>
      </select>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="material_fee" 
                 	      value="<?php echo e($material_fee) ?>" hidden="">
    </div>
  </div>
  <?php }?>
  <div class="col-md-3">
    <div class="form-group">
      <label>Jumlah</label>
      <input type="number" name="jml_unit"  class="form-control" value = "<?php echo e($jml_unit)  ?>"/>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Date In</label>
      <input type="date" name="dt_in"  class="form-control" value = "<?php echo e($dt_in)  ?>"/>
    </div>
  </div>
      <div class="col-md-2">
		        <div class="form-group">
		          <label></label>
		          <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />
	            </div>
	          </div>
		      <div class="col-md-2">
		        <div class="form-group">
		          <label></label>
		          <input name="Reset" type="submit" id="Reset"  class="form-control"  value="Reset" />
	            </div>
      </div>
 <input type="hidden" name="tf" id="textfield" value="<?php echo e($tf) ?>" hidden="hidden" >
 <input type="hidden" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>">
      <input type="hidden" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="">
</div>
	  </div><div class="box box-warning">		
<div class="box-body">
			  <div class="col-md-10">
			    <table width="100%" class="table table-bordered table-striped" id="example2">
			      <tbody>
          <tr>
            <td width="6%" height="14" align=center class="style24">No</td>
            <td width="55%" align=center class="style24">Book Name</td>
            <td width="39%" align=center class="style24">Stock</td>
            </tr>
        <?php
	$no_urut = 1;
$query_list_book = q_set($__p_query_list_book, "SELECT buku,sum(jml_in),no FROM vipbookin where buku <> '' and buku <> '-' and kd_branch = ? group by buku order by buku", [(string) ($kd_branch_dipilih)]);
$resource_list_book = db_query_or_die('errro_7', $query_list_book, $__p_query_list_book ?? []);
while ($row_list_book=  db_fetch($resource_list_book, PDO::FETCH_NUM))
	{  
	$query_list_book_out = q_set($__p_query_list_book_out, "SELECT sum(jml_out) FROM vipbookout where buku = ? and kd_branch =  ? ", [(string) ($row_list_book[0]), (string) ($kd_branch_dipilih)]);
	$resource_list_book_out = db_query_or_die('errro_71', $query_list_book_out, $__p_query_list_book_out ?? []);
	while ($row_list_book_out=  db_fetch($resource_list_book_out, PDO::FETCH_NUM))
		{
		$jml_keluar = $row_list_book_out[0];
		}
$sisa = num($row_list_book[1]) - num($jml_keluar);
?>
          <tr>
            <td height="14" align=center class="style24"><?php echo e($no_urut);  ?></td>
            <td align=left class="style24"><a href="vipbookout.php?no=<?php echo e(u($row_list_book[2])); ?>" 
target="popup" 
onclick="window.open('vipbookout.php?no=<?php echo e(u($row_list_book[2])); ?>','popup','width=1000,height=800'); return false;"><?php echo e($row_list_book[0])  ?></a></td>
            <td align=center class="style24"><a href="vipbookout.php?no=<?php echo e(u($row_list_book[2])); ?>" 
target="popup" 
onclick="window.open('vipbookdata.php?no=<?php echo e(u($row_list_book[2])); ?>','popup','width=1000,height=800'); return false;"><?php echo e($sisa)  ?></a></td>
            </tr>
            <?php  $no_urut = num($no_urut) +1 ;} ?>

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
</body>
</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{		
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$kdcbg = $_SESSION['kd_branch']; 
	$kdb = in_val('kdb', 'any');
	$st = in_val('st', 'any');
	$hari=date("d");
	$bulan=date("m");
	$bulanan=date("M");
	$storage = in_val('storage', 'any');

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

	$source = in_val('source', 'any');
	if ($source =='Vendor') {$source = $nm_vendor;}
	$nm_book = in_val('nm_book', 'any');
	$nm_vendor = in_val('nm_vendor', 'any');
	$jml_masuk = in_val('jml_masuk', 'any');
	$dt_in = in_val('dt_in', 'any');
	$jml_unit = in_val('jml_unit', 'any');		
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