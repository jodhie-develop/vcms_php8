<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
$id = in_val('id', 'get');
$kode_po = in_val('kode_po', 'get');


include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$query_po = q_set($__p_query_po, "SELECT kode, nama_pemohon, department, peruntukan, date_format(dt_po,'%d %b %y'), date_format(dt_due_po,'%d %b %y'), supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by, supplier_pic,supplier_pic_phone,supplier_npwp,po_status,date_format(approved_dt,'%d %b %y'), ack_by, ack_date,tax_by,tax_date, to_paid_by,to_paid_date,paid_by, paid_date, kd_biodata,sign_approved, sign_check, sign_tax, sign_to_paid, sign_paid,pay_mtd     FROM ves_data.purchase_order where kode = ? order by id desc limit 1 ", [(string) ($kode_po)]);	
$resource_po = db_query_or_die('errro_2', $query_po, $__p_query_po ?? []);
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
	$po_status	 = $row_po['16'];
	$approved_dt	 = $row_po['17'];
	$ack_by	 = $row_po['18'];
	$ack_date	 = $row_po['19'];
	$tax_by	 = $row_po['20'];
	$tax_date	 = $row_po['21'];
	$to_paid_by	 = $row_po['22'];
	$to_paid_date	 = $row_po['23'];
	$paid_by	 = $row_po['24'];
	$paid_date	 = $row_po['25'];		
	$kd_biodata	 = $row_po['26'];
	$sign_approved	 = $row_po['27'];	
	$sign_check	 = $row_po['28'];	
	$sign_tax_check	 = $row_po['29'];	
	$sign_to_be_paid	 = $row_po['30'];	
	$sign_paid	 = $row_po['31'];
	$pay_mtd	 = $row_po['32'];		
	if ($kd_biodata != '')
		{
		$query_student = q_set($__p_query_student, "SELECT concat(nama,' ', middle_name,' ', family_name ) from ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($kd_biodata)]);	
		$resource_student = db_query_or_die('errro_1', $query_student, $__p_query_student ?? []);
		if (num(db_num_rows($resource_student)) > 0)
		{
		while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
			{		
			$nama_student = $row_student[0];	
			}
		}
		}
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
  <style type="text/css">
  body,td,th {
    font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 12px;
}
  </style>

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
        <img src="imgs/vista-logo.png" width="83" height="37"></h2>			  
		  </div>
		  <div class="col-xs-6">
        <h3>
Purchase Order</h3>			  
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
    <!-- /.col -->
      <div class="col-sm-4 invoice-col">Supplier: <?php echo e($supplier_name) ?><br>
        Phone : <?php echo e($supplier_phone) ?><br>
        Address : <?php echo e($supplier_address) ?>
    </div>
      <div class="col-sm-4 invoice-col">
        <address>
        <span style="width:50%">Payment Method :<?php echo e($pay_mtd) ?> <br>
Bank Account : <?php echo e($supplier_bank) ?> <?php echo e($supplier_bank_account) ?><br>
 Account Number  : <?php echo e($supplier_bank_rekening) ?></span>
        </address>
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
            <th width="5%" bgcolor="#5F5F5F">No</th>
            <th width="61%" bgcolor="#5F5F5F">Order &amp; Cost</th>
            <th width="15%" bgcolor="#5F5F5F" align="center">Estimated Amount</th>
            <th width="4%" bgcolor="#5F5F5F" align="center">Tax</th>
            <th width="15%" bgcolor="#5F5F5F">Amount</th>
            </tr>
          </thead>
          <tbody>
<?php
$angka = 1;
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount,tax_ori FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
$resource_po_item = db_query_soft($query_po_item, $__p_query_po_item ?? []);
if(num(db_num_rows($resource_po_item)) > 0){
$angka_item = 1;	
	while ($row_po_item  =  db_fetch($resource_po_item, PDO::FETCH_NUM))
		{
		$amount =  $row_po_item[2] ;
		$tax_amount = $row_po_item[3];
		$tax_amount = num($tax_amount) / 100;
		$net_amount = num($amount)  - num((num($amount) * num($tax_amount)));
	
?>			  
          <tr>
            <td><?php echo e($angka) ?></td>
            <td><?php echo e($nama_student)  ?> <?php echo e($row_po_item[1]) ?></td>
            <td align="right"><?php echo number_format(num( $row_po_item[2]),0,".",".") ?></td>
            <td align="right"><?php echo  e($row_po_item[3]) ?></td>
            <td align="right"><?php echo number_format(num( $net_amount ),0,".",".") ?></td>
            </tr>
<?php $angka = num($angka) +1; $ttl_amount = num($ttl_amount) + num($net_amount); } } ?>			  
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><strong>Nett To be Paid</strong></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right"><?php echo number_format(num( $ttl_amount),0,".",".") ?></td>
          </tr>
          <tr>
            <td colspan="2">Due  Date : <?php echo e($dt_due_po) ?></td>
            <td align="leftd">&nbsp;</td>
            <td align="leftd">&nbsp;</td>
            <td align="leftd"><p>&nbsp;</p></td>
          </tr>
          </tbody>
        </table>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <div class="row">

      <!-- /.col -->
    <div class="col-xs-12">
        <table class="table">
          <tr class="animated-dropdown-menu">
            <th width="25%" style="width:15%;font-size: 10px"> Prepared By<br>
            <br>            <?php echo e($nama_pemohon) ?><br>            <?php echo e($dt_po) ?></th>
            <th width="25%" style="width:15%;font-size: 10px"><strong>Approved By</strong><br>
            <?php if (num($po_status) >= 2){ ?>             
            <img src="<?php echo e($sign_approved)  ?>" width="135" height="67">
            <?php  } ?><br>					
            <?php if (num($po_status) >= 2){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 2){ echo e($approved_dt) ; }?>            </th>
            <th width="18%" style="width:15%;font-size: 10px">Checked By<br>
            <?php if (num($po_status) >= 3){ ?>
            <img src="<?php echo e($sign_approved)  ?>" width="135" height="67">
            <?php  } ?>
            <br>
            <?php if (num($po_status) >= 3){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 3){ echo e($approved_dt) ; }?>            </th>
            <th width="32%" style="width:15%;font-size: 10px">Tax Checked By<br>
            <?php if (num($po_status) >= 4){ ?>
            <img src="<?php echo e($sign_approved)  ?>" width="135" height="67">
            <?php  } ?>
            <br>
            <?php if (num($po_status) >= 4){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 4){ echo e($approved_dt) ; }?>            </th>
            <th width="32%" style="width:15%;font-size: 10px">To Be Paid By<br>
            <?php if (num($po_status) >= 5){ ?>
            <img src="<?php echo e($sign_approved)  ?>" width="135" height="67">
            <?php  } ?>
            <br>
            <?php if (num($po_status) >= 5){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 5){ echo e($approved_dt) ; }?>            </th>
            <th width="32%" style="width:15%;font-size: 10px">Paid By<br>
            <?php if (num($po_status) >= 6){ ?>
            <img src="<?php echo e($sign_approved)  ?>" width="135" height="67">
            <?php  } ?>
            <br>
            <?php if (num($po_status) >= 6){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 6){ echo e($approved_dt) ; }?>            </th>
          </tr>
        </table>
        <br>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
<!-- ./wrapper -->
</body>
</html>
