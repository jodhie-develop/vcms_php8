<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kd_cbg = in_val('kdcbg', 'get');
$kdcl = in_val('kdcl', 'get');

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}


$query = q_set($__p_query, "SELECT a.nm_program, a.level_program, type_program,kode_program FROM vip_teacher_schedule v left join vip_mst_code_prg a on v.kode_program = a.kd_program where v.kelas = ? and v.kd_branch = ? group by v.kelas", [(string) ($kdcl), (string) ($kd_cbg)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$nm_program = $row[0];
		$level_program = $row[1];
		$type_program = $row[2];	
		$kode_program = $row[3];				
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Upload Scope &amp; Sequence Form</h1>
    </section>
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php    //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
 <form method="post" action="vip_scsq_save.php" role="form" class="form-horizontal" enctype="multipart/form-data" ><?php echo csrf_field(); ?>
  
    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      <label>Center</label><input type="text" ang="en-150" class="form-control" readonly  placeholder="Enter ..." name="cabang" 
                 	      value="<?php echo e($cabang) ?>">
      <input type="hidden" ang="en-150" class="form-control" readonly  placeholder="Enter ..." name="kd_cbg" 
                 	      value="<?php echo e($kd_cbg) ?>">
    </div>
  </div>
</div>
<div class="box-body">
  <div class="col-md-4">
      <div class="form-group">
        <label>Class Code</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."  readonly name="kdcl" 
                 	      value="<?php echo e($kdcl) ?>">
      </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Program</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."  readonly name="nm_program" 
                 	      value="<?php echo e($nm_program) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Level Program</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."  readonly name="level_program" 
                 	      value="<?php echo e($level_program) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Type</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."  readonly name="type_program" 
                 	      value="<?php echo e($type_program) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Program Code</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."  readonly name="kode_program" 
                 	      value="<?php echo e($kode_program) ?>">
    </div>
  </div>
</div>
<div class="box-body"><br>
  <div class="col-md-8">
    <div class="form-group">
      <label>File Name</label>
      <input id="middle-name2" class="form-control col-md-7 col-xs-12" required="required" type="file" name="fileToUpload">
    </div>
</div>
</div>                         
<div class="box-body"><input type="Submit" name="Submit" value="Submit"  class="btn btn-primary"/></div>

</form>

</body>
</html>