<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$id = in_val('id', 'get');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
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
<?php //  include ('left.php') ?>
     <form name="form1" method="POST" action="#"  enctype="multipart/form-data"><?php echo csrf_field(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) --><!-- Main content -->
    <section class="content">
      <div class="row"><!-- left column --><!--/.col (left) -->
        <!-- right column -->
		  <?php if ($id != ''){ ?>
    
		<div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Image</h3>
        </div>
        <table width="100%" class="table table-bordered table-striped" id="example2">
          <thead>
            <tr>
              <td width=12% align=center >Image</td>
              <td width=14% align=center >Action</td>
            </tr>
          </thead>
          <?php
$query_file = q_set($__p_query_file, "SELECT id, kode, nama_file, COALESCE(NULLIF(nama_asli, ''), nama_file) FROM purchase_order_file where kode = ? order by id", [(string) ($kode_po)]);

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
if(num(db_num_rows($resource_file)) > 0){
	
	while ($row_file  =  db_fetch($resource_file, PDO::FETCH_NUM))
		{
?>
          <tr>
            <td align=left class="style24"><?php echo e($row_file[3]) ?></td>
            <td align=center class="style24"><a href="" onClick="return popitup('po_view_img.php?id=<?php echo e(u($row_file[0])) ?>&kd=<?php echo e(u($row_file[1])) ?>')"><span class="glyphicon glyphicon-eye-open"></span></a> <a href="" onClick="return popitup('po_del_img.php?id=<?php echo e(u($row_file[0])) ?>&kd=<?php echo e(u($row_file[1])) ?>')"><span class="glyphicon glyphicon-remove"></span></a></td>
          </tr>
          <?php }} ?>
    </tbody>
  
  <tfoot>
  </tfoot>
        </table>

        <input type="hidden" name="id" id="textfield" value="<?php echo e($id) ?>">
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal">
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputFile2">File input</label>
            <input type="file" id="exampleInputFile2" name="file">
            <p class="help-block">Silahkan upload gambar yang dimaksud</p>
          </div>
          <div class="form-group"></div>
        </div>
        <?php if ($id != ''){?>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary"  name="Upload" value="Upload" >Upload</button>
        </div>
        <?php } ?>
        <!-- /.box-body -->
        <!-- /.box-footer -->
        </div>
        <!-- /.box -->
        <!-- general form elements disabled -->
        <!-- /.box -->
        </div>
	    <?php } ?> 		  
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
$id = in_val('id', 'post');
$query_item = q_set($__p_query_item, "SELECT id_cat from brg_master_item where id = ? ", [(string) ($id)]);
$result_item=db_query_or_die("Wah error nih1", $query_item, $__p_query_item ?? []);
if(num(db_num_rows($result_item)) > 0)
	{	
		while ($row_id_cat=  db_fetch($result_item, PDO::FETCH_NUM))
		{
		$id_cat = $row_id_cat[0];
		}
	}
	

$statusMsg = '';

//file upload path
$targetDir = "brg_img/";
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
			$query_insert_po_item = q_set($__p_query_insert_po_item, "insert into brg_master_img (id_brg, id_cat, namafile , nama_asli)  values (? ,? ,?  ,? )", [(string) ($id), (string) ($id_cat), (string) ($fileName), upload_display_name('file')]);	
			$resource_urut_po_item = db_query_or_die('errro_2', $query_insert_po_item, $__p_query_insert_po_item ?? []);				
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
echo "window.close();\n";
echo "window.opener.location.reload();\n";
echo "</script>";	
}

?>		
		

</div>
   <script>
   function popitup(url) 
   {
    newwindow=window.open(url,'name','height=600,width=750,screenX=400,screenY=350');
    if (window.focus) {newwindow.focus()}
    return false;
   }
   </script>
</body>
</html>
