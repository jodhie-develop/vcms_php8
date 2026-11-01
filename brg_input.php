<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

//include __DIR__ . "/atas.php";
//include __DIR__ . "/left.php";
$nama_lengkap = $_SESSION['nama_lengkap'];
$mode = in_val('mode', 'get');
$id=in_val('id', 'get');

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">	
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
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="container mt-4">

    <h3 class="mb-4">Input Inventory Data<span class="col-md-4">
    <input type="hidden" class="form-control" name="mode" value="<?php echo e($mode) ?>">
    </span></h3>

    <form id="formInventory" method="POST" action="brg_new_save.php" class="row g-3" enctype="multipart/form-data"><?php echo csrf_field(); ?>


        <!-- Row 1 -->
        <div class="col-md-4">
          <label class="form-label">Branch</label>
          <select class="form-control" name="Branch">
            <?php
					$query_opt = q_set($__p_query_opt, "SELECT distinct branch FROM ves_data.inventory_data order by branch");
					$resource_opt = db_query_or_die('errro_7', $query_opt, $__p_query_opt ?? []);
					while ($row_opt=  db_fetch($resource_opt, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_opt[0]).'">'.e($row_opt[0]).'</option>';
					}      ?>
            <option selected><?php echo  e($Branch) ?></option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Model</label>
          <span class="form-group">
          <select class="form-control" name="model">
              <?php
					$query_opt = q_set($__p_query_opt, "SELECT distinct Model FROM ves_data.inventory_data order by model");
					$resource_opt = db_query_or_die('errro_7', $query_opt, $__p_query_opt ?? []);
					while ($row_opt=  db_fetch($resource_opt, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_opt[0]).'">'.e($row_opt[0]).'</option>';
					}      ?>
              <option selected><?php echo  e($model) ?></option>
            </select>
          </span></div>
        <div class="col-md-4">
          <label class="form-label">Brand / Merk / Manufacturer</label>
            <input type="text" class="form-control" name="Make_Manufacturer">
      </div>


      <!-- Row 2 --><!-- Row 3 --><!-- Row 4 -->
        <div class="col-md-4">
            <label class="form-label">Processor Type & Speed</label>
            <input type="text" class="form-control" name="Processor_Type_and_Speed">
        </div>

        <div class="col-md-4">
            <label class="form-label">Purchase Date</label>
            <input type="date" class="form-control" name="Purchase_Date">
        </div>

        <div class="col-md-4">
            <label class="form-label">Purchase Cost / Budget</label>
            <input type="text" class="form-control" name="Purchase_Cost_Budget">
        </div>

        <div class="col-md-4">
            <label class="form-label">Warranty Expiry Date</label>
            <input type="date" class="form-control" name="Warranty_Expiry_Date">
        </div>

        <!-- Row 6 -->
        <div class="col-md-4">
            <label class="form-label">Remark</label>
            <input type="text" class="form-control" name="REMARK">
        </div>

        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select class="form-control" name="STATUS">
                <option value="ACTIVE">ACTIVE</option>
                <option value="REPAIR">REPAIR</option>
                <option value="SPARE">SPARE</option>
                <option value="DISPOSED">DISPOSED</option>
            </select>
        </div>
<div class="col-md-4">
    <label class="form-label">Upload Invoice </label>
    <input type="file" class="form-control" name="photo" accept=".png,.jpg,.jpeg,.pdf">
</div>
<div class="col-md-4">
    <label class="form-label">Upload Device Photo</label>
    <input type="file" class="form-control" name="photo_device" accept=".png,.jpg,.jpeg">
</div>		
        <!-- Button -->
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-primary">Save Data</button>
            <a href="inventory_list.php" class="btn btn-secondary">Back</a>
        </div>

    </form>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>	
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
