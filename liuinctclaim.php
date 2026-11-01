<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ob_start();
ini_set('memory_limit', '150M'); ?>
<?php 
include __DIR__ . "/conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$periode_claim = in_val('pc', 'get');


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ve_incentive_claim</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->

    <!-- title row --><!-- info row -->
  <div class="row invoice-info">

    <!-- /.col --><!-- /.col -->
    <!-- /.col -->
  </div>
  <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">

                <thead>
                <tr>
                  <th colspan="3">LIUMEDIA
                  INCENTIVE <br>
                  PERIOD : <?php echo e($periode_claim) ?> </th>
                  </tr>
                <tr>
                  <th>STAFF NAME</th>
                  <th colspan="2"> INCENTIVE</th>
                  </tr>
                </thead>
                <tbody>

<?php 
		$query_staff = q_set($__p_query_staff, "select nama, amount,pic,dt_entry from liu_incentive where date_format(periode_claim,'%Y-%m') = ? ", [(string) ($periode_claim)]);
	$result_staff=db_query_or_die("Wah error nih11", $query_staff, $__p_query_staff ?? []);
	$jml_staff = db_num_rows($result_staff);					  
	if ($result_staff) 
		{ 
		while ($r_staff = db_fetch($result_staff))
			{
			$nama_staff = $r_staff[0];
			$nominal_per_staff = $r_staff[1];
			$pic = $r_staff[2];	$dt_entry = $r_staff[3];			
		
?>					  
		                <tr>			  
                  <td><strong><?php echo e($nama_staff) ?></strong></td>
                  <td colspan="2"><?php echo number_format(num($nominal_per_staff),0,".",".") ?></td>
                  </tr><?php } } ?>
		                <tr>
					
                </tbody>

              </table>
      </div>
      <!-- /.col -->
  </div>
    <!-- /.row -->
    <div class="row">
      <!-- accepted payments column --><!-- /.col -->
      <div class="col-xs-12">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th width="10%" >&nbsp;</th>
              <th width="15%" >&nbsp;</th>
              <th width="15%" >&nbsp;</th>
              <th width="15%">&nbsp;</th>
              <th width="15%">&nbsp;</th>
              <th width="15%">&nbsp;</th>
              <th width="20%">&nbsp;</th>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <th>&nbsp;</th>
              <th><small>Proposed By</small></th>
              <th><small>Approved By</small></th>
              <th><small>Acknowledge By</small></th>
              <th><small>Check By</small></th>
              <th><small>Tax By</small></th>
              <th><small>Paid By</small></th>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <th >&nbsp;</th>
              <th >&nbsp;</th>
              <th >&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <th height="22" >&nbsp;</th>
              <th ><small><?php echo e($pic) ?><br>
              <?php echo e($dt_entry) ?></small></th>
              <th ><small><?php echo e($nm_app) ?><br>
              <?php echo e($approve_date) ?></small></th>
              <th><small><?php echo e($nm_ack) ?><br>
              <?php echo e($ack_date) ?></small></th>
              <th><small><?php echo e($nm_check)	 ?><br>
              <?php echo e($checked_date) ?></small></th>
              <th><small><?php echo e($nm_tax) ?><br>
              <?php echo e($tax_date) ?></small></th>
              <th><small><?php echo e($nm_paid) ?><br>
              <?php echo e($paid_date) ?> </small></th>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
