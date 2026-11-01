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
$idsoa = in_val('idsoa', 'any');

$kode_po = in_val('kp', 'any');
$kd_biodata = in_val('kdb', 'any');

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

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

<div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box"><div class="box-body">
			<div class="box-header with-border">
			  <h3 class="box-title">Item Order (<?php echo e($kode_po) ?>)
			    <input type="hidden" name="kode_po" id="textfield" value="<?php echo e($kode_po) ?>">
			    <input type="hidden" name="idsoa" id="textfield" value="<?php echo e($idsoa) ?>">
			    <input type="hidden" name="kd_biodata" id="textfield" value="<?php echo e($kd_biodata) ?>">				  
			  </h3>
			</div>		 
			<div class="col-md-12">			  

			  <div class="form-group">
				<label for="exampleInputEmail4">Order & Cost</label>
				<textarea name="order_cost" rows="3" class="form-control" placeholder="Enter ..." ><?php echo  e($order_cost) ?></textarea>
			  </div>

		    </div>
			<div class="col-md-8">
			  <div class="form-group">
			    <label for="exampleInputEmail16">Item Remark</label>
			    <textarea name="po_item_remark" rows="3" class="form-control" placeholder="Enter ..." ><?php echo  e($po_item_remark) ?></textarea>
		      </div>
		    </div>
  			<div class="col-md-2">
  			  <div class="form-group">
  			    <label for="exampleInputEmail15">Currency</label>
  			    <select class="form-control select2" style="width: 80%;" name="currency">
  			      <option value="Rp">Rp</option>
  			      <option value="RM">RM</option>					
  			      <option value="SGD">SGD</option>
  			      <option value="USD">USD</option>
  			      <option value="NZD">NZD</option>					
  			      <option selected><?php echo e($currency) ?></option>
		        </select>
		      </div>
		    </div>
  			<div class="col-md-6">	
			  <div class="form-group">
				<label for="exampleInputEmail5">Estimated Amount</label>
				<input type="text" class="form-control" placeholder="Enter ..." name="po_amount" value="<?php echo  e($po_amount) ?>">
			  </div>
  			</div>
<?php if($idsoa !=''){?>							
<div class="col-md-3">
			  <div class="form-group">
				<label for="exampleInputEmail5">Additional Amount</label>
				<input type="text" class="form-control" placeholder="Enter ..." name="po_amount_add" value="<?php echo  e($po_amount_add) ?>">
			  </div>
			</div>	
<?php } ?>			  
  			<div class="col-md-3">
  			  <div class="form-group">
  			    <label for="exampleInputEmail11">PPh 21/23/4(2)</label>
  			    <input type="text" class="form-control" placeholder="Enter ..." name="pph_persen" value="<?php echo  e($pph_persen) ?>">
		      </div>
		    </div>
  			<!-- /.bodfx-header -->
</div>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->
	 <div class="box-footer"></form><input type="submit" name="Submit" value="Submit" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
	$saat_ini = date('Y-m-d H:i:s');	
	$kd_biodata = in_val('kd_biodata', 'any');
	$kode_po = in_val('kode_po', 'any');
	$idsoa = in_val('idsoa', 'any');
	$order_cost = in_val('order_cost', 'any');
	$po_amount = in_val('po_amount', 'any');
	$po_amount_add = in_val('po_amount_add', 'any');	
	$pph_persen = in_val('pph_persen', 'any');
	$currency = in_val('currency', 'any');	
	$po_item_remark = in_val('po_item_remark', 'any');		
	$query_insert_po_item = q_set($__p_query_insert_po_item, "insert into ves_data.purchase_order_item (kode, order_cost, amount,tax_ori,currency,po_item_remark ,id_soa) values (? ,? ,? ,? ,? ,? ,? )", [(string) ($kode_po), (string) ($order_cost), (string) ($po_amount), (string) ($pph_persen), (string) ($currency), (string) ($po_item_remark), (string) ($idsoa)]);	
	$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);	

	if ($idsoa !='' and $kd_biodata !='')
	{
		$po_amount_soa = num($po_amount)+num($po_amount_add);		
	$query_insert_po = q_set($__p_query_insert_po, "insert into ves_data.adm_soa (kd_biodata,  keterangan, cur_kredit, rp_kredit, id_soa, no_ref, jns_transaksi, dt_entry) values (? ,? ,'Rp',? ,? ,? ,3,? )", [(string) ($kd_biodata), (string) ($order_cost), (string) ($po_amount_soa), (string) ($idsoa), (string) ($kode_po), (string) ($saat_ini)]);	
						$resource_insert_po= db_query_or_die('errro_visitor9', $query_insert_po, $__p_query_insert_po ?? []);
	}
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Item Added');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}
?>