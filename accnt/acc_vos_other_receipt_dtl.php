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

$query = q_set($__p_query, "SELECT t.id_cash_receipt, t.nm_stu, t.org_mount, t.pay_mtd, t.tgl_cetak FROM ves_inc.tb_cash_receipt t where  no = ? ", [(string) ($no)]);

$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$id_receipt = $row[0];
		$nama_student = $row[1];
		$rupiah= $row[2];
		$remark = $row[3];	
		$efektif_date = $row[4];			
		$payment_metodh = $row[3];	

		
		$rupiah_old= $row[2];
		$remark_old = $row[3];	
		$efektif_date_old = $row[4];			
		$payment_metodh_old = $row[3];	
		
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
      <h1>VOS Other Payment<br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-6">
    <div class="form-group">
      ID Receipt : <br>
      <?php echo e($id_receipt) ?>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="no" 
                 	      value="<?php echo e($no) ?>">

      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="id_receipt" 
                 	      value="<?php echo e($id_receipt) ?>">
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      Student Name :<br>
      <?php echo e($nama_student) ?>
    </div>
</div>
  <div class="col-md-8">
    <div class="form-group">
      <label>Amount</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah_baru" 
                 	      value="<?php echo e($rupiah) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="no" 
                 	      value="<?php echo e($no) ?>" hidden= "hidden">
  </span></div>    
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Payment Metodh</label>
      <select name="payment_metodh_baru"  id="jns_report2" class="form-control" >
        <option value="Debit Card">Debit Card</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="Dana Cita">Dana Cita</option>		  
        <option value="Cek-Bg">Cek-Bg</option>
        <option value="Voucher">Voucher</option>
        <option selected="selected"><?php echo e($payment_metodh) ?></option>
      </select>
    </div>
</div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Effective Date</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="efektif_date_baru" 
                 	      value="<?php echo e($efektif_date) ?>">
    </div>
</div>
</div>    
<div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      <label>Remark Changed</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="remark_baru" 
                 	      value="<?php echo e($remark_changed) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah_old" 
                 	      value="<?php echo e($rupiah_old)  ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="payment_metodh_old" 
                 	      value="<?php echo e($payment_metodh_old) ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="st_refund" 
                 	      value="<?php echo e($st_refund)  ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="efektif_date" 
                 	      value="<?php echo e($efektif_date)  ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="payment_metodh_old" 
                 	      value="<?php echo e($payment_metodh_old) ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="id_receipt_old" 
                 	      value="<?php echo e($id_receipt_old) ?>">
  </span></div>
<div class="box-body"></div></form><input type="submit" name="Submit" value="Submit" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
	$st_simpan = 1;
	$no = in_val('no', 'any');
	$rupiah_baru = in_val('rupiah_baru', 'any');
	$payment_metodh_baru = in_val('payment_metodh_baru', 'any');
	$st_refund_baru = in_val('st_refund_baru', 'any');
	$efektif_date_baru = in_val('efektif_date_baru', 'any');
	$remark_baru = in_val('remark_baru', 'any');

	
	
		
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";		
	$kd_branch = $_SESSION['kd_branch'];
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$idb = in_val('idb', 'any');
	$id_receipt= in_val('id_receipt', 'any');
$rupiah_old= in_val('rupiah_old', 'any');
$payment_metodh_old= in_val('payment_metodh_old', 'any');
$efektif_date_old= in_val('efektif_date_old', 'any');
$st_refund_old= in_val('st_refund_old', 'any');


		$query_update_receipt= q_set($__p_query_update_receipt, "update  ves_inc.tb_cash_receipt set org_mount = ? , tgl_cetak = ? , pay_mtd = ? where no = ? ", [(string) ($rupiah_baru), (string) ($efektif_date_baru), (string) ($payment_metodh_baru), (string) ($no)]); 

	$resource_update_payment = db_query_or_die('errro_simpan_1', $query_update_receipt, $__p_query_update_receipt ?? []);
	
		$query_simpan_payment= q_set($__p_query_simpan_payment, "insert into ves_data.vip_billing_payment_log (id_receipt,   amount, dt_payment, pay_mtd,pic, dt_entry,remark) \r
\t\tvalues \r
\t\t(? ,? ,? ,? ,? ,? ,? )", [(string) ($id_receipt), (string) ($rupiah_old), (string) ($efektif_date_old), (string) ($payment_metodh_old), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($remark)]);

				$resource_simpan_payment = db_query_or_die('errro_simpan', $query_simpan_payment, $__p_query_simpan_payment ?? []);		
		
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VOS Other Payment Receipt Updated');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";

		
	}
?>