<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/../conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";

$noinc	 = in_val('noinc', 'any');

$tax = in_val('tax', 'any');
$npwp = in_val('npwp', 'any');
$ada = 0;
$query_cek = q_set($__p_query_cek, "SELECT t.nama, v.nama_sc, v.nominal, v.tax_persen,v.no FROM vos_incentive v\r
left join tb_sales_report t on  v.kd_sales_report = t.no\r
where v.no = ? ", [(string) ($noinc)]);

$resource_cek = db_query_soft($query_cek, $__p_query_cek ?? []);
if(num(db_num_rows($resource_cek)) > 0)
	{
	while ($row  =  db_fetch($resource_cek, PDO::FETCH_NUM))
		{
		$nomor_asli = $row['4'];
		$sc = $row['1'];	
		$nama = $row['0'];
		$amount = $row['2'];
		$st_reward = $row[5];	
		}
	}
$kd_staff = $_SESSION['kd_staff'];
if ($npwp == ''){
$query_cek = q_set($__p_query_cek, "SELECT npwp FROM tb_user where nama_detail =? and kd_branch = ? ", [(string) ($sc), (string) ($kd_branch)]);

$resource_cek = db_query_soft($query_cek, $__p_query_cek ?? []);
if(num(db_num_rows($resource_cek)) > 0)
	{
	while ($row  =  db_fetch($resource_cek, PDO::FETCH_NUM))
		
		{
		$npwp = $row[0];
		}
	
	}
}
if ($tax !=''){$tax_amount = num($amount) * num((num($tax)/100));  $net_amount = num($amount) - num((num($amount) * num((num($tax)/100))));}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">	
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tax Input</title>
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
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <script src="../cdnjs/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="../newdata/css/bootstrap-datepicker.css"></link>
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
      VOS Incentive Payment Form<br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Consultant Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="sc"  readonly
                 	      value="<?php echo e($sc) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>NPWP</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="npwp" 
                 	      value="<?php echo e($npwp) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah"  readonly
                 	      value="<?php echo e($nama) ?>">
    </div>
</div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="nomor_asli" 
                 	      value="<?php echo e($nomor_asli) ?>" hidden= "hidden">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="ada" 
                 	      value="<?php echo e($ada) ?>" hidden= "hidden">
  </span>
  <input type="hidden" name="noinc" id="textfield" value="<?php echo e($noinc) ?>">
</div>    
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Incentive (before tax)</label><input type="number" ang="en-150" class="form-control"  placeholder="Enter ..." name="amount" 
                 	      value="<?php echo e($amount) ?>" readonly>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="amount_lama" 
                 	      value="<?php echo e($rupiah_lama) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Tax (%)</label>
      <select name="tax"  id="jns_report2" class="form-control"  onChange="this.form.submit()" >
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="15">15</option>
        <option value="17.5">17.5</option>
        <option value="25">25</option>		  
        <option value="30">30</option>			  
        <option selected="selected"><?php echo e($tax) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Tax Amount</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="Enter ..." name="amount2" 
                 	      value="<?php echo e($tax_amount) ?>" readonly>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="amount_lama3" 
                 	      value="<?php echo e($rupiah_lama) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Net Incentive</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="Enter ..." name="net_amount" 
                 	      value="<?php echo e($net_amount) ?>" readonly>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="amount_lama2" 
                 	      value="<?php echo e($rupiah_lama) ?>">
    </div>
</div>
</div>    
<div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      <label>Remark</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="remark" 
                 	      value="<?php echo e($remark) ?>">
    </div>
  </div>
</div>
<div class="box-body"></div></form><input type="submit" name="Submit" value="Submit" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
	$nama_pic = $_SESSION['nama_lengkap']; 	
	$sc = in_val('sc', 'any'); 
	$kd_branch = in_val('kd_branch', 'any'); 	
	$noinc = in_val('noinc', 'any');
	$net_amount = in_val('net_amount', 'any');
	$npwp = in_val('npwp', 'any');
	
	$tax = in_val('tax', 'any');	
	$hari=date("d");
	$bulan=date("m");
	$tahun=date("Y");
	$tgl_hari_ini =  "$tahun-$bulan-$hari";

	$query = q_set($__p_query, "update ves_data.vos_incentive set tax_persen = ? ,st_reward = 5,tax_by = ? ,tax_date = ? where no = ? ", [(string) ($tax), (string) ($nama_pic), (string) ($tgl_hari_ini), (string) ($noinc)]);		
	$resource_update_payment = db_query_or_die('errro_simpan1', $query, $__p_query ?? []);
	if ($npwp != '')
		{
		$query = q_set($__p_query, "update ves_data.tb_user set npwp = ? where nama_detail = ? ", [(string) ($npwp), (string) ($sc)]);

		$resource_update_payment = db_query_or_die('errro_simpan2', $query, $__p_query ?? []);		
		}
	
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VOS TAX Incentive Submitted');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}

?>