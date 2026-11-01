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
$query = q_set($__p_query, "SELECT kd_branch,  buku FROM ves_data.vipbookin where no = ? ", [(string) ($no)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$kd = $row[0];
	if ($kd=='1') ($storage ='East Sby');
	elseif ($kd=='2')($storage ='West Sby');
	elseif ($kd=='3')($storage ='Denpasar');
	elseif ($kd=='8')($storage ='Malang');
	elseif ($kd=='4')($storage ='South Jkt');
	elseif ($kd=='5')($storage ='North Jkt');
	elseif ($kd=='6')($storage ='West Jkt');
	elseif ($kd=='7')($storage ='Bandung');
	elseif ($kd=='10')($storage ='HO');
	elseif ($kd=='11')($storage ='Vpro East');
	elseif ($kd=='12')($storage ='Vpro West');

		$buku = $row[1];
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
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>VIP Material Stock Out<br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body"><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="no" 
                 	      value="<?php echo e($no) ?>" hidden= "hidden">
  </span></div>    
<div class="col-md-12">
      <div class="box box-warning">		
  <div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>BOOK OUT </label>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>STORAGE</label>
      <select class="form-control" name="storage"  readonly>

        <option selected><?php echo  e($storage) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-8">
	      <div class="form-group">
			      <label>Book Name</label>
	        <select class="form-control" name="nm_book" readonly>

			        
			        <option selected><?php echo  e($buku) ?></option>
            </select>
          </div>
      </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>USER</label>
      <select class="form-control" name="user"  onChange="this.form.submit()">
        <option>Student</option>
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
        <option>Teacher</option>
        
        <option selected><?php echo  e($user) ?></option>
      </select>
    </div>
</div>
  <div class="col-md-5">
    <div class="form-group">
      <label>DESCRIPTION</label>
      <input type="text" name="deskripsi"  class="form-control" value = "<?php echo e($deskripsi)  ?>"/>
    </div>
</div>
 <?php if ($source == 'Vendor'){?>
  <div class="col-md-4">
    <div class="form-group">
      <label>Vendor Name</label>
      <input type="text" name="nm_vendor"  class="form-control" value = "<?php echo e($nm_vendor)  ?>"/>
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
      <label>Date Out</label>
      <input type="date" name="dt_out"  class="form-control" value = "<?php echo e($dt_out)  ?>"/>
    </div>
  </div>
  <input type="hidden" name="tf" id="textfield" value="<?php echo e($tf) ?>" hidden="hidden" >
 <input type="hidden" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>">
      <input type="hidden" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="">
</div>
	  </div><div class="box box-warning">		
<div class="box-body"></div>
		</div>
  </div>   
<div class="box-body"></div>
<div class="box-body"></div></form><input type="submit" name="Submit" value="Submit" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
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
	elseif ($storage =='West Sby'){$kd_branch_dipilih='2';}
	elseif ($storage =='Denpasar'){$kd_branch_dipilih='3';}
	elseif ($storage =='Malang'){$kd_branch_dipilih='8';}
	elseif ($storage =='South Jkt'){$kd_branch_dipilih='4';}
	elseif ($storage =='North Jkt'){$kd_branch_dipilih='5';}
	elseif ($storage =='West Jkt'){$kd_branch_dipilih='6';}
	elseif ($storage =='Bandung'){$kd_branch_dipilih='7';}
	elseif ($storage =='HO'){$kd_branch_dipilih='10';}
	elseif ($storage =='Student'){$kd_branch_dipilih='Student';}	

	elseif ($storage =='Vpro East'){$kd_branch_dipilih='11';}
	elseif ($storage =='Vpro West'){$kd_branch_dipilih='12';}	        
		
	$user = in_val('user', 'any');
	$deskripsi = in_val('deskripsi', 'any');		

	if ($user =='East Sby'){$pengguna='1';}
	elseif ($user =='West Sby'){$pengguna='2';}
	elseif ($user =='Denpasar'){$pengguna='3';}
	elseif ($user =='Malang'){$pengguna='8';}
	elseif ($user =='South Jkt'){$pengguna='4';}
	elseif ($user =='North Jkt'){$pengguna='5';}
	elseif ($user =='West Jkt'){$pengguna='6';}
	elseif ($user =='Bandung'){$pengguna='7';}
	elseif ($user =='HO'){$pengguna='10';}
	elseif ($user =='Student'){$pengguna='Student';}	

	elseif ($user =='Vpro East'){$pengguna='11';}
	elseif ($user =='Vpro West'){$pengguna='12';}	 
	elseif ($user =='Teacher'){$pengguna='Teacher';}	 		
		
		

	$source = in_val('source', 'any');
	$nm_book = in_val('nm_book', 'any');
	$nm_vendor = in_val('nm_vendor', 'any');
	$jml_masuk = in_val('jml_masuk', 'any');
	$dt_out = in_val('dt_out', 'any');
	$jml_unit = in_val('jml_unit', 'any');		
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";	
	if ($user == 'Student')
		{
	$query_book_in= q_set($__p_query_book_in, "insert into vipbookout (kd_branch,buku, jml_out, dt_out, pengguna, pic) values (? ,? ,? ,? ,? ,? ) ", [(string) ($kd_branch_dipilih), (string) ($nm_book), (string) ($jml_unit), (string) ($dt_out), (string) ($pengguna), (string) ($nama_lengkap)]); 
	$resource_book_in = db_query_or_die('errro_simpan', $query_book_in, $__p_query_book_in ?? []);			
		}
	else
		{
		$query_book_in= q_set($__p_query_book_in, "insert into vipbookout (kd_branch,buku, jml_out, dt_out, pengguna, pic) values (? ,? ,? ,? ,? ,? ) ", [(string) ($kd_branch_dipilih), (string) ($nm_book), (string) ($jml_unit), (string) ($dt_out), (string) ($pengguna), (string) ($nama_lengkap)]); 
	$resource_book_in = db_query_or_die('errro_simpan', $query_book_in, $__p_query_book_in ?? []);
			
	$query_book_in= q_set($__p_query_book_in, "insert into vipbookin (kd_branch,buku, jml_in, dt_in, source, pic) values (? ,? ,? ,? ,? ,? ) ", [(string) ($pengguna), (string) ($nm_book), (string) ($jml_unit), (string) ($dt_out), (string) ($kd_branch_dipilih), (string) ($nama_lengkap)]); 
	$resource_book_in = db_query_or_die('errro_simpan', $query_book_in, $__p_query_book_in ?? []);			
		}

	echo "<script type=\"text/javascript\">\n";
	echo "alert('Book Out');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";			
	echo "</script>";
	}
?>