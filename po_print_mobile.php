<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
$id = in_val('id', 'get');
$kode_po = in_val('kode_po', 'get');

//-- mobile detection
$useragent = $_SERVER['HTTP_USER_AGENT']; 
$iPod = stripos($useragent, "iPod"); 
$iPad = stripos($useragent, "iPad"); 
$iPhone = stripos($useragent, "iPhone");
$Android = stripos($useragent, "Android"); 
$iOS = stripos($useragent, "iOS");
//-- You can add billion devices 

$DEVICE = ($iPod||$iPad||$iPhone||$Android||$iOS);

if ($DEVICE) 
	{ 
		echo "<script type=\"text/javascript\">\n";
		echo "alert('New Item');\n";
		echo "window.location = ('po_print_mobile.php?kode_po=" . e(u($kode_urut_po)) . "');\n";				
		echo "</script>";	

	}	
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$query_po = q_set($__p_query_po, "SELECT kode, nama_pemohon, department, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by, supplier_pic,supplier_pic_phone,supplier_npwp   FROM ves_data.purchase_order where kode = ? order by id desc limit 1 ", [(string) ($kode_po)]);	

$resource_po = db_query_or_die('errro_1', $query_po, $__p_query_po ?? []);
if (num(db_num_rows($resource_po)) > 0)
{
while ($row_po=  db_fetch($resource_po, PDO::FETCH_NUM))
	{
	$nama_pemohon = $row_po['1'];
	$department = $row_po['2'];
	$peruntukan = $row_po['3'];
	$dt_po = $row_po['4'];
	$dt_due_po = $row_po['5'];

	$supplier_name = $row_po['6'];
	$supplier_phone = $row_po['7'];
	$supplier_address = $row_po['8'];
	$supplier_bank = $row_po['9'];
	$supplier_bank_account = $row_po['10'];
	$supplier_bank_rekening = $row_po['11'];
	$proposedto = $row_po['12'];
	$supplier_pic = $row_po['13'];
	$supplier_pic_phone = $row_po['14'];
	$supplier_npwp	 = $row_po['15'];
	}
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
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
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
		  <div class="col-xs-3">
        <h2 class="page-header">
        <img src="imgs/vista-logo.png" width="107" height="58"></h2>			  
		  </div>
		  <div class="col-xs-6">
        <h5>
Purchase Order Mobile</h5>			  
		  </div>		  
	    <div class="col-xs-3">
        <h1 class="page-header">
          <small class="pull-right">No :<?php echo e($kode_po) ?></small></h1>			  
		  </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        Name
          <address>
          <strong><?php echo e($nama_pemohon) ?></strong><br>
          <?php echo e($department) ?><br>

        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <address>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col"><b>Supplier:</b> <?php echo e($supplier_name) ?><br>
        <b>Phone :</b> <?php echo e($supplier_phone) ?><br>
        <b>Address:</b> <?php echo e($supplier_address) ?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th style="width: 7%" bgcolor="#5F5F5F">No</th>
            <th style="width: 50%" bgcolor="#5F5F5F">Order &amp; Cost</th>
            <th style="width: 15%" bgcolor="#5F5F5F">Amount</th>
            </tr>
          </thead>
          <tbody>
<?php
$angka = 1;
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
$resource_po_item = db_query_soft($query_po_item, $__p_query_po_item ?? []);
if(num(db_num_rows($resource_po_item)) > 0){
$angka_item = 1;	
	while ($row_po_item  =  db_fetch($resource_po_item, PDO::FETCH_NUM))
		{
		$amount =  $row_po_item[2] ;
	
?>			  
          <tr>
            <td><?php echo e($angka) ?></td>
            <td><?php echo e($row_po_item[1]) ?></td>
            <td align="right"><?php echo e($row_po_item[2]) ?></td>
            </tr>
<?php $angka = num($angka) +1; $ttl_amount = num($ttl_amount) + num($amount); } } ?>			  
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Tax : </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><strong>Nett To be Paid</strong></td>
            <td align="right"><?php echo e($ttl_amount) ?></td>
          </tr>
          <tr>
            <td>Due  Date : </td>
            <td align="right">&nbsp;</td>
            <td align="leftd"><p>Tax Checked By:</p>
              <p><strong>Kurnia</strong></p></td>
          </tr>
          </tbody>
        </table>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
     
        <table class="table">
          <tr>
            <th style="width:50%">Payment Method : Cash/TT/CC/DC To : <?php echo e($supplier_bank_account) ?><br>
            Bank :<?php echo e($supplier_bank) ?><br>
            No. Rek : <?php echo e($supplier_bank_rekening) ?></th>
          </tr>
          <tr>
            <th>Branch :</th>
          </tr>
        </table>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Paid By:<br>
              Date Paid</th>
              <td>$250.30<br>
              $10.34</td>
            </tr>
          </table>
        </div>
      </div>
<div class="col-12"></div>		

      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <div class="col-sm-3">
    <address>
      <strong>Prepared By</strong>
    </address>
    <address>
    <br>
      <?php echo e($nama_pemohon) ?><br>

    </address>
  </div>
  <div class="col-sm-3"> 
      <p><strong>Approved By</strong></p>
      <p><br>
        <?php echo e($proposedto) ?><br>
      </p>

    </address>
  </div>
  <div class="col-sm-3">
    <p><strong>Acknowledge By</strong></p>
    <p><br>
      <?php echo e($nama_pemohon) ?><br>
    </p>

    </address>
  </div>
  <div class="col-sm-3">
    <p><strong>Accounting/Finance</strong></p>
    <p><br>
      <?php echo e($nama_pemohon) ?><br>
    </p>

    </address>
  </div>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
