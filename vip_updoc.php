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
$cabang = in_val('cabang', 'get');
$jns_report = in_val('jns_report', 'get');
if ($_SESSION['kelompok']=='ACD'){ $jns_report = 'Academic';}
$week = in_val('week', 'get');
$week =  urlencode(in_val('week', 'get'));
if ($week == '')
	{
$sql_minggu = q_set($__p_sql_minggu, "SELECT minggu FROM ves_data.tb_minggu_detail where detail = ? ", [(string) ($tgl_hari_ini)]);
$resource_sql_minggu= db_query_or_die('errro_a', $sql_minggu, $__p_sql_minggu ?? []);
$keluar_sql_minggu= db_num_rows($resource_sql_minggu);
if(num(db_num_rows($resource_sql_minggu)) > 0)
	{
	while ($row_sql_minggu=  db_fetch($resource_sql_minggu, PDO::FETCH_NUM))
		{						
		$week= $row_sql_minggu[0];				
		}
	}
	}
$query = q_set($__p_query, "SELECT no_week, tgl_periode, bulan FROM master_date where minggu = ? and sales_year = '21'", [(string) ($week)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$urut_week= $row[0];
		$tgl_periode = $row[1];
		}
	}
$query_document = q_set($__p_query_document, "SELECT nama, middle_name, family_name from ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($kd_biodata)]);
$resource_document = db_query_or_die('errro_', $query_document, $__p_query_document ?? []);
$keluar_document = db_num_rows($resource_document);
if(num(db_num_rows($resource_document)) > 0)
	{
	while ($row_document=  db_fetch($resource_document, PDO::FETCH_NUM))
		{
		$nama= $row_document[0];				
		$middle_name= $row_document[1];				
		$family_name= $row_document[2];				
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
      <h1>Upload Document/Image Form</h1>
    </section>
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php    //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
 <form method="post" action="vip_updoc_save.php" role="form" class="form-horizontal" enctype="multipart/form-data" ><?php echo csrf_field(); ?>
  
    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      <label>Center</label><input type="text" ang="en-150" class="form-control" readonly  placeholder="Enter ..." name="cabang" 
                 	      value="<?php echo e($cabang) ?>">
    </div>
  </div>
</div>
<div class="box-body">
  <div class="col-md-4">
      <div class="form-group">
        <label>Report Category</label>
                 	      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..."  readonly name="jns_report" 
                 	      value="<?php echo e($jns_report) ?>">
      </div>
  </div>
</div>
<div class="box-body">
  <div class="col-md-3">
                 	    <div class="form-group">
                 	    <label>Week</label>
                 	    <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="week"  readonly
                 	      value="<?php echo e($week) ?>">
                 	    <label>Period : <?php echo e($tgl_periode) ?></label>  
      </div>
  </div>
  <br>
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