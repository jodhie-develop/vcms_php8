<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$ada = 0;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Purchase Order</title>
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
  <div class="content">
    <!-- Content Header (Page header) --><!-- Main content -->
    <section class="content">
      <div class="row"><!-- left column --><!--/.col (left) -->
        <!-- right column -->

    
		<div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">E Signature</h3>
        </div>
        <table width="100%" class="table table-bordered table-striped" id="example2">
          <tr>
            <?php
$query_file = q_set($__p_query_file, "SELECT m.nama_file FROM mst_signature m");

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
if(num(db_num_rows($resource_file)) > 0){
	
	while ($row_file  =  db_fetch($resource_file, PDO::FETCH_NUM))
		{$ada = 1; $_POST['ada'] =1; 
?>			  
            <td width="12%" align=left class="style24"><img class="img-responsive pad" src="ecert/<?php echo e($row_file[0]) ?>" alt="Photo" height="80px" width="80px"></td>
  <?php } } ?>
          </tr>

    </tbody>
  
  <tfoot>
  </tfoot>
        </table>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal">
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputFile2">File input</label>
            <input type="file" id="exampleInputFile2" name="file">
            <p class="help-block">Silahkan Upload E-Sign</p>
          </div>
          <div class="form-group"></div>
        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-primary"  name="Upload" value="Upload" >Upload</button>
        </div>

        <!-- /.box-body -->
        <!-- /.box-footer -->
        </div>
        <!-- /.box -->
        <!-- general form elements disabled -->
        <!-- /.box -->
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
$ada = in_val('ada', 'post');	
$statusMsg = '';

//file upload path
$targetDir = "ecert/";
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
			if (num($ada) != 1){
			$query_insert_po_item = q_set($__p_query_insert_po_item, "insert into mst_signature (nama_file)  values (? )", [(string) ($fileName)]);	
				
			}
			else
			{$query_insert_po_item = q_set($__p_query_insert_po_item, "update mst_signature set nama_file = ? ", [(string) ($fileName)]);	}
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
