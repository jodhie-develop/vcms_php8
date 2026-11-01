<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$kode_po = in_val('kode_po', 'get');
if($kode_po !=''){
$query_po = q_set($__p_query_po, "SELECT kode, nama_pemohon, department, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by  FROM ves_data.purchase_order where kode = ? order by id desc limit 1 ", [(string) ($kode_po)]);	

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
	}
}
	$order_cost = $row_po[''];
	$po_amount = $row_po[''];
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

	  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php // include ('left.php') ?>
     <form name="form1" method="post" action="#"  enctype="multipart/form-data"><?php echo csrf_field(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Purchase Order
          <span class="form-group">
          <input type="text" name="kode_po" class="form-control" id="exampleInputEmail" value="<?php echo e($kode_po) ?>">
      </span></h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">User Request</h3>
            </div>
		  </div>
	    </div>
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
				  <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail2">Name</label>
                <input type="text" name="nama_pemohon" class="form-control" id="exampleInputEmail2" placeholder="Your Name" value="<?php echo e($nama_pemohon) ?>">
              </div>					  
				  </div>
 <div class="col-md-6">

              <div class="form-group">
               <label for="exampleInputPassword1">Department</label>
                <select class="form-control select2" style="width: 100%;" name="department">
                  <option value selected><?php echo e($department) ?></option>
                  <option value="Sales">Sales</option>
                  <option value="Accounting">Accounting</option>
                  <option value="Academic">Academic</option>
                  <option value="HR">HR</option>
                  <option value="GA">GA</option>
                  <option value="IT">IT</option>
                  <option value="Other">Other</option>					
                </select>
              </div>					  
			    </div>
			<div class="col-md-12">				  
				<div class="form-group">
				<label for="exampleInputEmail1">Peruntukan</label>
				<textarea class="form-control" rows="3" placeholder="Enter ..." name="peruntukan"><?php echo e($peruntukan) ?></textarea>
				</div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
			    <label for="exampleInputEmail25">Purchase Date</label>
			    <input type="date" class="form-control" id="exampleInputEmail25" placeholder="Your Name" name="dt_po" value="<?php echo e($dt_po) ?>">
			    </div>
			  </div>
			<div class="col-md-6">
				    <div class="form-group">
				      <label for="exampleInputEmail3">Due Date</label>
				      <input type="date" class="form-control" id="exampleInputEmail3" placeholder="Your Name" name="dt_due_po" value="<?php echo e($dt_due_po) ?>">
		        </div>
		      </div>
			<div class="col-md-6">
			  <div class="form-group">
			    <label for="exampleInputPassword2">Proposed To</label>
			    <select class="form-control select2" style="width: 100%;" name="department2">
			      <option value selected><?php echo e($department) ?></option>
			      <option value="Sales">Sales</option>
			      <option value="Accounting">Accounting</option>
			      <option value="Academic">Academic</option>
			      <option value="HR">HR</option>
			      <option value="GA">GA</option>
			      <option value="IT">IT</option>
			      <option value="Other">Other</option>
			      </select>
			    </div>
			  </div>
            </div>
              <!-- /.box-body -->

              
          
          </div>
          <!-- /.box -->

          <!-- Form Element sizes --><!-- /.box --><!-- /.box -->

          <!-- Input addon --><!-- /.box -->

        </div>
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Supporting Document</h3>
            </div>
            <table width="100%" class="table table-bordered table-striped" id="example2">
              <thead>
                <tr>

                  <td width=12% align=center >Document</td>
                  <td width=14% align=center >Action</td>
                </tr>
              </thead>
              <?php
$query_file = q_set($__p_query_file, "SELECT kode, nama_file, COALESCE(NULLIF(nama_asli, ''), nama_file) FROM purchase_order_file where kode = ? order by id", [(string) ($kode_po)]);

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
if(num(db_num_rows($resource_file)) > 0){
	
	while ($row_file  =  db_fetch($resource_file, PDO::FETCH_NUM))
		{
	
?>
              <tr>

                <td align=left class="style24"><?php echo e($row_file[2]) ?></td>
                <td align=center class="style24"><a href="" onClick="return popitup('po_view_img.php')"><span class="glyphicon glyphicon-eye-open"></span></a> <span class="glyphicon glyphicon-remove"></span></td>
              </tr>
              <?php }} ?>
    </tbody>
  
  <tfoot>
  </tfoot>
            </table>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputFile3">File input</label>
                  <input type="file" id="exampleInputFile3" name="file">
                  <p class="help-block">Demi kelancaran proses PO anda, upload penawaran vendor dll yang dibutuhkan</p>
                </div>
                <div class="form-group"></div>
              </div>
<?php if ($kode_po != ''){?>				
			<div class="box-footer">
                <button type="submit" class="btn btn-primary"  name="Upload" value="Upload" >Upload</button>
            </div>	
<?php } ?>				
              <!-- /.box-body -->
              <!-- /.box-footer -->
   
          </div>
          <!-- /.box -->
          <!-- general form elements disabled --><!-- /.box -->
        </div>
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Supplier Info</h3>
            </div>
            <div class="col-md-12">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="exampleInputEmail19">Supplier Name</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="supplier_name" value="<?php echo  e($supplier_name) ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="exampleInputEmail20">Phone</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="supplier_phone" value="<?php echo  e($supplier_phone) ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail21">Address</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="supplier_address" value="<?php echo  e($supplier_address) ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="exampleInputEmail22">Bank</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="supplier_bank" value="<?php echo  e($supplier_bank) ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="exampleInputEmail23">A/N</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="supplier_bank_account" value="<?php echo  e($supplier_bank_account) ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="exampleInputEmail24">No Rek</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="supplier_bank_rekening" value="<?php echo  e($supplier_bank_rekening) ?>">
                </div>
              </div>
            </div>
            <!-- /.bodfx-header -->
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Item Order</h3>
            </div>
         <div class="col-md-12">			  
            <div class="col-md-8">
              <div class="form-group">
                <label for="exampleInputEmail4">Order & Cost</label>
                <textarea name="order_cost" rows="3" class="form-control" placeholder="Enter ..." ><?php echo  e($order_cost) ?></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="exampleInputEmail5">Estimated Amount</label>
                <input type="text" class="form-control" placeholder="Enter ..." name="po_amount" value="<?php echo  e($po_amount) ?>">
              </div>
            </div>
			 			<div class="box-footer">
                <button type="submit" class="btn btn-primary"   name="AddItem" value="AddItem">Add Item</button>
              </div>
		    </div> 
            <!-- /.bodfx-header -->

          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->
        </div>
        <div class="col-md-12">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=4% height="14" align=center >No</td>
	            <td width=70% align=center >Order &amp; Cost</td>
	            <td width=12% align=center >Amount</td>
	            <td width=14% align=center >Action</td>

	            </tr>
            </thead>
<?php
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
$resource_po_item = db_query_soft($query_po_item, $__p_query_po_item ?? []);
if(num(db_num_rows($resource_po_item)) > 0){
$angka_item = 1;	
	while ($row_po_item  =  db_fetch($resource_po_item, PDO::FETCH_NUM))
		{
	
?>	
	          <tr>
	            <td height="14" align=center class="style24"><?php echo e($angka_item) ?></td>
	            <td align=left class="style24"><?php echo e($row_po_item[1]) ?></td>
	            <td align=right class="style24"><?php echo e($row_po_item[2]) ?></td>
	            <td align=center class="style24"><span class="glyphicon glyphicon-remove"></span></td>
              </tr>
<?php $angka_item = num($angka_item) + 1; }} ?>			  

		    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary"   name="generate" value="generate">Generate PO</button>
          </div>			
        </div>
		  
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
	</form>
	<?php 
if (isset($_POST['Upload'])) 
{
$kode_po = in_val('kode_po', 'post');	
$statusMsg = '';

//file upload path
$targetDir = "po_docs/";
$fileName = upload_random_name('file');
$targetFilePath = $targetDir . $fileName;

$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["Upload"]) && !empty($_FILES["file"]["name"])) 
	{
	// file formats yang diperbolehkan
	$allowTypes = array('jpg','png','jpeg','gif','pdf');
	if(in_array($fileType, $allowTypes))
		{
		//upload file to server
		if(upload_move('file', upload_allow('jpg', 'png', 'jpeg', 'gif', 'pdf'), $targetFilePath, 5242880))
			{
			$statusMsg = "The file ".$fileName. " has been uploaded.";
			$query_insert_po_item = q_set($__p_query_insert_po_item, "insert into purchase_order_file (kode, nama_file, nama_asli)  values (? ,?  ,? )", [(string) ($kode_po), (string) ($fileName), upload_display_name('file')]);	
			$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);				
			}
		else
			{
			$statusMsg = "Sorry, there was an error uploading your file.";
			}
		}
	else
		{
		$statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
		}
	}
else
	{
    $statusMsg = 'Please select a file to upload.';
	}	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('" . e($statusMsg) . "');\n";
		echo "window.location = ('po_entry.php?kode_po=" . e(u($kode_po)) . "');\n";				
		echo "</script>";	
}

?>	
	<?php 
	
if (isset($_POST['AddItem'])) 
{
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$kode_po = in_val('kode_po', 'post');	
$kode_branch = in_val('kode_branch', 'post');
$kode_branch = '01';
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
if ($kode_po == '') 
	{
	$kode_tgl = "$tahun$bulan$hari$kode_branch";
	$query_urut_po = q_set($__p_query_urut_po, "SELECT kode FROM ves_data.purchase_order_item where mid(kode,1,8) = ? order by id desc limit 1 ", [(string) ($kode_tgl)]);	

	$resource_urut_po = db_query_or_die('errro_1', $query_urut_po, $__p_query_urut_po ?? []);
	if (num(db_num_rows($resource_urut_po)) > 0)
		{
		while ($row_urut_po=  db_fetch($resource_urut_po, PDO::FETCH_NUM))
			{
			$kode_nomor = $row_urut_po[0];
			$ambilangka =  substr($kode_nomor,8,4);
		
			#ketemu angka awal(angka sebelumnya) + dengan 1
			$nextangka=num($ambilangka)+1;
			#menhitung jumlah karakter
			$digit=strlen($nextangka);
			if(!$kode_nomor){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3){ $nol='0'; }
			$kode_urut_po = $kode_tgl.$nol.$nextangka;	
			}	
		}
	else
		{
		$kode_urut_po = $kode_tgl.'0001';
		}
	$nama_pemohon = in_val('nama_pemohon', 'post');
	$department = in_val('department', 'post');
	$peruntukan = in_val('peruntukan', 'post');
	$dt_po = in_val('dt_po', 'post');
	$dt_due_po = in_val('dt_due_po', 'post');
	$file_doc = in_val('file_doc', 'post');
	$order_cost = in_val('order_cost', 'post');
	$po_amount = in_val('po_amount', 'post');
	$supplier_name = in_val('supplier_name', 'post');
	$supplier_phone = in_val('supplier_phone', 'post');
	$supplier_address = in_val('supplier_address', 'post');
	$supplier_bank = in_val('supplier_bank', 'post');
	$supplier_bank_account = in_val('supplier_bank_account', 'post');
	$supplier_bank_rekening = in_val('supplier_bank_rekening', 'post');		
	$query_insert_po = q_set($__p_query_insert_po, "insert into ves_data.purchase_order (kode, nama_pemohon, department, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by ) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,'approved_by')", [(string) ($kode_urut_po), (string) ($nama_pemohon), (string) ($department), (string) ($peruntukan), (string) ($dt_po), (string) ($dt_due_po), " " . (string) ($supplier_name), (string) ($supplier_phone), (string) ($supplier_address), (string) ($supplier_bank), (string) ($supplier_bank_account), (string) ($supplier_bank_rekening)]);	
	$resource_urut_po = db_query_or_die('errro_1', $query_insert_po, $__p_query_insert_po ?? []);	
	$query_insert_po_item = q_set($__p_query_insert_po_item, "insert into ves_data.purchase_order_item (kode, order_cost, amount ) values (? ,? ,? )", [(string) ($kode_urut_po), (string) ($order_cost), (string) ($po_amount)]);	
	$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);	

		echo "<script type=\"text/javascript\">\n";
		echo "alert('New Item');\n";
		echo "window.location = ('po_entry.php?kode_po=" . e(u($kode_urut_po)) . "');\n";				
		echo "</script>";	
	}
else
	{
	$order_cost = in_val('order_cost', 'post');
	$po_amount = in_val('po_amount', 'post');	
	$query_insert_po_item = q_set($__p_query_insert_po_item, "insert into ves_data.purchase_order_item (kode, order_cost, amount ) values (? ,? ,? )", [(string) ($kode_po), (string) ($order_cost), (string) ($po_amount)]);	
	$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('New Item');\n";
		echo "window.location = ('po_entry.php?kode_po=" . e(u($kode_po)) . "');\n";				
		echo "</script>";		
	}

}

?>	
	<?php 
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	
if (isset($_POST['generate'])) 
{
echo "<script type=\"text/javascript\">\n";
echo "alert('generate');\n";
				echo "window.location = ('" . e($url_asli) . "');\n";	
echo "</script>";
}

?>		

</div>
   <script>
   function popitup(url) 
   {
    newwindow=window.open(url,'name','height=300,width=650,screenX=400,screenY=350');
    if (window.focus) {newwindow.focus()}
    return false;
   }
   </script>

</body>
</html>
