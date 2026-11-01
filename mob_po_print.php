<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
$id = in_val('id', 'get');
$kode_po = in_val('kode_po', 'get');
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$query_po = q_set($__p_query_po, "SELECT kode, nama_pemohon, department, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, supplier_pic, supplier_pic_phone, supplier_npwp, dt_entry, approved_by, approved_dt, tax_by, tax_date, ack_by, ack_date, paid_by, paid_date    FROM ves_data.purchase_order where kode = ? order by id desc limit 1 ", [(string) ($kode_po)]);	

$resource_po = db_query_or_die('errro_1', $query_po, $__p_query_po ?? []);
if (num(db_num_rows($resource_po)) > 0)
{
while ($row_po=  db_fetch($resource_po, PDO::FETCH_NUM))
	{
	$Kode =  $row_po['0'];	$nama_pemohon =  $row_po['1'];	$department =  $row_po['2'];	$peruntukan =  $row_po['3'];	$dt_po =  $row_po['4'];
	$dt_due_po =  $row_po['5'];	$supplier_name =  $row_po['6'];	$supplier_phone =  $row_po['7'];	$supplier_address =  $row_po['8'];
	$supplier_bank =  $row_po['9'];	$supplier_bank_account =  $row_po['10'];	$supplier_bank_rekening =  $row_po['11'];	$supplier_pic =  $row_po['12'];
	$supplier_pic_phone =  $row_po['13'];	$supplier_npwp =  $row_po['14'];	$dt_entry =  $row_po['15'];	$approved_by =  $row_po['16'];
	$approved_dt =  $row_po['17'];	$tax_by =  $row_po['18'];	$tax_date =  $row_po['19'];	$ack_by =  $row_po['20'];	$ack_date =  $row_po['21'];
	$paid_by =  $row_po['22'];	$paid_date =  $row_po['23']; $corporate =  $row_po['24'];
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
<!-- <body onload="window.print();"> -->
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
<div class="row">
  <div class="col-xs-12">
   
        <img src="imgs/vista-logo.png" width="27" height="14"> <strong>Purchase Order </strong><br>
           <small><small>No.  <?php echo e($corporate) ?><?php echo e($kode_po) ?></small> </small>
          /          <small><small><?php echo e($dt_po) ?></small></small
          <br>
        			  
   
  </div>
      <div class="col-xs-12"> 
       <table class="table table-striped">
         <tbody>
           <tr>
             <td><small><small>Nama:<br>
<strong><?php echo e($nama_pemohon)  ?></strong> </small> </small></td>
             <td><small><small>Department :<br>
             <strong><?php echo e($department)  ?></strong> </small></small></td>
           </tr>
           <tr>
             <td colspan="2"><small><small>Kebutuhan :<br>
             <strong><?php echo e($peruntukan)   ?></strong> </small> </small></td>
           </tr>
           <tr>
			   <td><small><small>To : <?php echo e($approved_by)   ?></small></small> </td>
             <td>&nbsp;</td>
           </tr>
         </tbody>
       </table>
      </div>
    <!-- info row -->
<small>
    <div class="row invoice-info"><!-- /.col --><!-- /.col --><!-- /.col -->
    </div>
</small>      
      <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <small>
          <thead>
         
          <tr>
            <th width="6%" bgcolor="#5F5F5F"><small>NoItem</small></th>
            <th width="72%" bgcolor="#5F5F5F"><small>Nett Amount</small></th>
            </tr>
           
          </thead> </small>
          <tbody>
<?php
$angka = 1;
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount, tax_ori  FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
$resource_po_item = db_query_soft($query_po_item, $__p_query_po_item ?? []);
if(num(db_num_rows($resource_po_item)) > 0){
$angka_item = 1;	
	while ($row_po_item  =  db_fetch($resource_po_item, PDO::FETCH_NUM))
		{
		$amount =  $row_po_item[2] ;
		$tax_ori = $row_po_item[3];
		$amount_after_tax = num($amount) - num((num($amount) * num((num($tax_ori)/100))));
		$tot_amount_after_tax = num($tot_amount_after_tax)  + num($amount_after_tax); 	
	
?>			  
          <tr>
            <td><small><?php echo e($angka) ?>. <?php echo e($row_po_item[1]) ?><br>
             <?php echo e($row_po_item[2]) ?> (<?php echo e($row_po_item[3]) ?>%) </small></td>
            <td align="right"><small><?php echo e($amount_after_tax) ?></small></td>
            </tr>
<?php $angka = num($angka) +1; $ttl_amount = num($ttl_amount) + num($amount); } } ?>
          <tr>
            <td><small><strong>Nett To be Paid</strong></small></td>
            <td align="right"><small><strong><?php echo e($tot_amount_after_tax) ?></strong></small></td>
          </tr>
          <tr>
            <td><small>Due  Date :</small> </td>
            <td align="leftd"><small><p>Tax Checked By:</p>
              <p><strong><small>Kurnia</small></strong></p></small></td>
          </tr>
          </tbody>
        </table>
  <div class="row invoice-info">     <small>
    <div class="col-xs-12 invoice-col">
		  <small><b>Supplier : </b></small><br>
		  <small><strong><?php echo e($supplier_name)     ?></strong></small><b> / <strong><?php echo e($supplier_pic)     ?></strong></b><br>
		  <small><?php echo e($supplier_address)      ?></strong></small><strong><br>
		  <small><small>NPWP :</small> <small><strong> </strong><small><strong><?php echo e($supplier_npwp)      ?></strong></small></small></small>		  <br>
		 <small><strong>Telepon :<?php echo e($supplier_phone)     ?> / <?php echo e($supplier_pic_phone)     ?></strong></small> </strong><br>
		<small><strong>Bank Account :<br>
<?php echo e($supplier_bank)      ?> / <?php echo e($supplier_bank_account)     ?> / <?php echo e($supplier_bank_rekening)     ?></strong></small> </strong><br>		 
  </div></small></div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
     
        <table class="table">
          <tr>
            <th style="width:50%"><small>Payment Method : Cash/TT/CC/DC To : <?php echo e($supplier_bank_account) ?><br>
            Bank :<?php echo e($supplier_bank) ?><br>
            No. Rek : <?php echo e($supplier_bank_rekening) ?></small></th>
          </tr>
          <tr>
            <th><small>Branch :</small></th>
          </tr>
        </table>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <div class="table-responsive">
          <table class="table">
            <tr>
				<th style="width:50%"><small>Paid By:</small><br>
              <small>Date Paid</small></th>
              <td><small>$250.30</small><br>
              <small>$10.34</small></td>
            </tr>
          </table>
        </div>
      </div>
<div class="col-12"></div>		

      <!-- /.col -->
  </div>
    <!-- /.row -->
    <div class="col-xs-6 invoice-col"> <small><b><strong>Propose By</strong></b><br>
      <?php echo e($nama_pemohon) ?>:<br>
      Date :</small><strong><br>
      <br>
      </strong></div>
  <div class="col-xs-6 invoice-col"> <small><b><strong>Approve By</strong></b><br>
      <?php echo e($nama_pemohon) ?>:<br>
      Date :<br>
      <br>
  </small></div>
    <div class="col-xs-3 invoice-col"> <small><b><strong>Ack by</strong></b><br>
      <?php echo e($nama_pemohon) ?>:<br>
      Date :</small></div>
    <div class="col-xs-6 invoice-col"> <small><b><strong>Accounting / Finance By</strong></b><br>
      <?php echo e($nama_pemohon) ?><br>
      Date :</small></div>
  <small>    </small>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
