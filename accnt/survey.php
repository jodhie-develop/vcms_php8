<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$no = in_val('no', 'any');
$kd_branch = $_SESSION['kd_branch'];
$kd_staff = $_SESSION['kd_staff'];


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
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
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
      <h1>
      Survey Singkat Pengguna<br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Staff Name:<?php echo e($nama_lengkap) ?></label>
    </div>
</div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="no" 
                 	      value="<?php echo e($no) ?>" hidden= "hidden">
  </span></div>    
<div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      Menurut anda, seberapa membantu V-CMS untuk kelancaran pekerjaan anda
                      <div class="form-group">
                  <div class="radio">
                    <label>
                      <input type="radio" name="pil1" id="optionsRadios1" value="5">
                      Sangat Membantu
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="pil1" id="optionsRadios2" value="4">
                      Membantu
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="pil1" id="optionsRadios3" value="3" >
                      Cukup Membantu
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="pil1" id="optionsRadios4" value="2" >
                      Kurang Membantu
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="pil1" id="optionsRadios5" value="1" >
                      Tidak Membantu
                    </label>
                  </div>						  
                </div>
    </div>
</div>
		</div>
<div class="box-body">		
	<div class="col-md-8">
    <div class="form-group">
      Jika ada kendala pada penggunaan V-CMS, bagaima team V-CMS Support membantu anda
        <div class="form-group">
          <div class="radio">
          <label>
            <input type="radio" name="pil2" id="optionsRadios6" value="3">
            Cepat  Merespon</label>
          </div>
        <div class="radio">
          <label>
            <input type="radio" name="pil2" id="optionsRadios7" value="2">
            Lambat Merespon</label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="pil2" id="optionsRadios8" value="1" >
            Tidak Merespon</label>
        </div>
        </div>
    </div>
  </div>
</div>    
<div class="box-body">
  <div class="col-md-8">
	<div class="form-group">
	  Masukan / Saran / Evaluasi dari anda untuk VCMS
	  <textarea class="form-control" rows="3" placeholder="Enter ..." name="masukan"></textarea>
	</div>
  </div>
  <div class="col-md-8">
    <div class="form-group">
      Terima kasih, Semua masukan dan penilaian anda, sangat berguna bagi pengembangan V-CMS kedepan 

    </div>
  </div>
</div>
<div class="box-body"></div></form><input type="submit" name="Submit" value="Submit" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
	$hari=date("d");
	$bulan=date("m");
	$tahun=date("Y");
	$tgl_hari_ini =  "$tahun-$bulan-$hari";
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$no = in_val('no', 'any');
	$kd_branch = $_SESSION['kd_branch'];
	$kd_staff = $_SESSION['kd_staff'];
	$pil1 = in_val('pil1', 'any');
	$pil2 = in_val('pil2', 'any');
	$masukan = in_val('masukan', 'any');
	$query_update_receipt= q_set($__p_query_update_receipt, "update ves_data.tb_user set  st_quiz= 1 where no = ? ", [(string) ($kd_staff)]); 
	$resource_update_payment = db_query_or_die('errro_simpan_1', $query_update_receipt, $__p_query_update_receipt ?? []);	
	$query_insert_booklog = q_set($__p_query_insert_booklog, "insert into  ves_data.tb_masukan (id_survey, soal1, soal2, masukan, kd_staff, dt_entry) values('1',? ,? ,? ,? ,? )", [(string) ($pil1), (string) ($pil2), (string) ($masukan), (string) ($kd_staff), (string) ($tgl_hari_ini)]);	
	$resource_insert_booklog = db_query_or_die('errro_simpan_3', $query_insert_booklog, $__p_query_insert_booklog ?? []);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Terima kasih');\n";
		echo "window.close(); \n";				
	echo "</script>";
	}
?>