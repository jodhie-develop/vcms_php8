<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$id = in_val('id', 'any');
$query_adm = q_set($__p_query_adm, "SELECT * FROM invoice_project where id = ? ", [(string) ($id)]);

	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$id = $row_adm[0]; 
			$invoice_id = $row_adm[2]; 
			$invoice_date = $row_adm[3];
			$invoice_order = $row_adm[4];
			$invoice_description = $row_adm[5];
			$invoice_amount = $row_adm[6];
			$vat = $row_adm[7];
			$invoice_nett = $row_adm[8];
			$invoice_due_date = $row_adm[9];
			}
		}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Invoice Generator</title>
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
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
  <script src="js/tinymce.min.js"/></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
</head>

<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invoice Generator</h1>
    </section>
<form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">

<div class="box box-warning">
  <div class="box-header with-border"><span class="form-group">
    <input type="text" class="form-control"  placeholder="Enter CLass Code" name="id" value="<?php echo e($id) ?>" required>
  </span></div>
  <div class="box-body">
    <div class="col-md-8">
      <div class="form-group">
        <label>Group Business</label>
        <select class="form-control select2" style="width: 100%;" name="corporate"  >

			
          <option selected><?php echo e($$row_adm[1]) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>No Invoice</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="invoice_id" value="<?php echo e($invoice_id) ?>" readonly>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>No Receipt</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="no_receipt" value="<?php echo e($no_receipt) ?>" required>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Invoice Date</label>
        <input type="date" class="form-control"  placeholder="Enter CLass Code" name="invoice_date" value="<?php echo e($invoice_date)  ?>" readonly>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Order By</label>
        <textarea class="textarea" placeholder="Masukkan data order by" style="width: 100%; height: 110px; font-size: 14px; line-height: 10px; border: 1px solid #dddddd; padding: 10px;" name="order_by"><?php echo e($invoice_order) ?></textarea>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Amount</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="amount" value="<?php echo e($invoice_amount) ?>"required>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>VAT</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="vat" value="<?php echo e($vat) ?>" required>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Description</label>
        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="Description"><?php echo e($invoice_description) ?></textarea>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Due Date</label>
        <input type="date" class="form-control"  placeholder="Enter CLass Code" name="due_date" value="<?php echo e($invoice_due_date) ?>" readonly>
      </div>
    </div>
  </div>
</div>
<div class="box-body"></div>

<input type="submit" name="Submit" value="Submit" />
</form>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script>
	$('.textarea').wysihtml5();
</script>

<script type="text/javascript" charset="utf-8">
	$(prettyPrint);
</script>
</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$fullurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$id = in_val('id', 'any');

$no_receipt = in_val('no_receipt', 'any');
$Description = in_val('Description', 'any');
$amount = in_val('amount', 'any'); 
$vat = in_val('vat', 'any');
$due_date = in_val('due_date', 'any');
$invoice_id = in_val('invoice_id', 'any');
$invoice_date = in_val('invoice_date', 'any');
	
	
$pic = $nama_lengkap;	


	
$query_simpan = q_set($__p_query_simpan, "insert into ves_data.invoice_project_paid (invoice_id,receipt_no,amount, vat, pic, dt_entry,keterangan) values (? ,? ,? ,? ,? ,? ,? )", [(string) ($invoice_id), (string) ($no_receipt), (string) ($amount), (string) ($vat), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($Description)]);
	
$resource_simpan = db_query_or_die('errro_simpan2', $query_simpan, $__p_query_simpan ?? []);	

echo "<script type=\"text/javascript\">\n";
echo "alert('Invoice Created by " . e($nama_lengkap) . "');\n";
		echo "window.location = ('ca_invoicelist.php');\n";	
echo "</script>";
}
?>
