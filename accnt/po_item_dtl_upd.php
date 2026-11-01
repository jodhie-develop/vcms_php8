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
$id = in_val('id', 'any');
$st = in_val('st', 'any');
$hitung = in_val('hitung', 'any');

$_GET['hitung'] = $hitung;
if($hitung != 'hitung')
{	
if (num($st)!=1){
$query_purchase_file = q_set($__p_query_purchase_file, "SELECT  order_cost, amount, tax_ori, tax_acc FROM purchase_order_item where id = ? ", [(string) ($id)]);	
	  
$resource_purchase_file = db_query_soft($query_purchase_file, $__p_query_purchase_file ?? []);			
if(num(db_num_rows($resource_purchase_file)) > 0)
	{
	while ($row_file  =  db_fetch($resource_purchase_file, PDO::FETCH_NUM))
		{
		$order_cost = $row_file[0];
		$po_amount = $row_file[1];
		$pph_persen_ori = $row_file[2];
		$pph_persen_tax = $row_file[3];		
		}
}
}
else
{
		$order_cost = in_val('order_cost', 'any');
		$po_amount = in_val('po_amount', 'any');
		$pph_persen_ori = in_val('pph_persen_ori', 'any');
		$pph_persen_tax = in_val('pph_persen_tax', 'any');		
}
}
else
{
		$order_cost = in_val('order_cost', 'any');
		$po_amount = in_val('po_amount', 'any');
		$pph_persen_ori = in_val('pph_persen_ori', 'any');
		$pph_persen_tax = in_val('pph_persen_tax', 'any');	
}
$net_amount = in_val('net_amount', 'any');
if($pph_persen_ori !='0')
{$tax_amount = num($po_amount) * num((num($pph_persen_ori)/100));}
else
{$tax_amount = num($po_amount) * num((num($pph_persen_ori)/100));	}
$net_amount  = num($po_amount) - num($tax_amount);
$st= 1;
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
 <?php //  include __DIR__ . "/../left.php";	 ?>
 <?php //====================== ?>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?><form role="form" method="post"><?php echo csrf_field(); ?>

<div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box"><div class="box-body">
			<div class="box-header with-border">
			  <h3 class="box-title">Item Order (<?php echo e($kode_po) ?>)
	
                <input type="hidden" name="id" id="textfield" value="<?php echo e($id) ?>">
			    <input type="hidden" name="st" id="textfield2" value="<?php echo e($st) ?>">
			  </h3>
			</div>		 
			<div class="col-md-12">			  

			  <div class="form-group">
				<label for="exampleInputEmail4">Order & Cost</label>
				<textarea name="order_cost" rows="3" class="form-control" placeholder="Enter ..." ><?php echo  e($order_cost) ?></textarea>
			  </div>

		    </div>
  			<div class="col-md-6">	
			  <div class="form-group">
				<label for="exampleInputEmail5">Estimated Amount</label>
				<input type="text" class="form-control" placeholder="Enter ..." name="po_amount" value="<?php echo  e($po_amount) ?>">
			  </div>
  			</div>
  			<div class="col-md-3">
  			  <div class="form-group">
  			    <label for="exampleInputEmail11">PPh 21/23/4(2)</label>
  			    <input type="text" class="form-control" placeholder="Enter ..." name="pph_persen_ori" value="<?php echo  e($pph_persen_ori) ?>">
		      </div>
		    </div>
  			<div class="col-md-3">
  			  <div class="form-group">
  			    <label for="exampleInputEmail7">PPh 21/23/4(2) - TAX REVISED</label>
  			    <select class="form-control select2" name="pph_remark">
  			      <option value="PPh 21">PPh 21</option>
  			      <option value="PPh 23">PPh 23</option>
  			      <option value="PPh 4(2)">PPh 4(2)</option>
  			      <option selected><?php echo  e($pph_remark) ?></option>
		        </select>
		      </div>
		    </div>
  			<div class="col-md-3">
  			  <div class="form-group">
  			    <label for="exampleInputEmail2">Nilai Pajak</label>
  			    <input type="text" class="form-control" placeholder="Enter ..." name="pph_persen_tax" value="<?php echo  e($pph_persen_tax) ?>">

  			  </div>
		    </div>
  			<div class="col-md-3">
  			  <div class="form-group">
  			    <label>Hitung Amount Rupiah</label>
  			    <input type="submit" name="hitung" value="hitung" />
		      </div>
		    </div>
<?php if ($hitung !=''){ ?>			  
  			<div class="col-md-3">
  			  <div class="form-group">
  			    <label for="exampleInputEmail3">TAX Amount</label>
  			    <input type="text" class="form-control" placeholder="Enter ..." name="tax_amount" value="<?php echo  e($tax_amount) ?>">
		      </div>
		    </div>
  			<div class="col-md-3">
  			  <div class="form-group">
  			    <label for="exampleInputEmail6">Net Amount</label>
  			    <input type="text" class="form-control" placeholder="Enter ..." name="net_amount" value="<?php echo  e($net_amount) ?>">
		      </div>
		    </div>
<?php } ?>
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
	$id = in_val('id', 'any');
	$order_cost = in_val('order_cost', 'any');
	$po_amount = in_val('po_amount', 'any');
	$pph_persen_ori = in_val('pph_persen_ori', 'any');
	$pph_persen_tax = in_val('pph_persen_tax', 'any');
	$pph_remark = in_val('pph_remark', 'any');
	
	
	$query_insert_po_item = q_set($__p_query_insert_po_item, "update ves_data.purchase_order_item set  order_cost = ? , amount = ? ,tax_ori = ? ,tax_remark =? ,tax_acc=? where id = ? ", [(string) ($order_cost), (string) ($po_amount), (string) ($pph_persen_ori), (string) ($pph_remark), (string) ($pph_persen_tax), (string) ($id)]);

	$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);			
	echo "<script type=\"text/javascript\">\n";		
	echo "alert('Item Updated');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hitung']))) 								
	{	
	$po_amount = in_val('po_amount', 'any');
	$pph_persen_ori = in_val('pph_persen_ori', 'any');
	$pph_persen_tax = in_val('pph_persen_tax', 'any');
	$net_amount = in_val('net_amount', 'any');
	}				  
?>