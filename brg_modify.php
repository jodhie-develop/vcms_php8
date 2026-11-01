<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";

$id = in_val('id', 'get');

// Ambil data inventory berdasarkan ID
$query = q_set($__p_query, "SELECT Asset_ID, Make_Manufacturer, Model, Branch_id, Branch, DEPT, User, PrimarySecondary_Dev,\r
          Processor_Type_and_Speed, Purchase_Date, Purchase_Cost_Budget, New_Model, Month_Plan,\r
          Warranty_Expiry_Date, REMARK, STATUS \r
          FROM inventory_data WHERE id = ? ", [(string) ($id)]);

$result = db_query_or_die("Error ambil data", $query, $__p_query ?? []);
$data = db_fetch($result, PDO::FETCH_ASSOC);
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
<form method="POST" action="brg_update_save.php"  enctype="multipart/form-data"><?php echo csrf_field(); ?>


    <!-- Hidden ID -->
    <input type="hidden" name="id" value="<?php echo e($id); ?>">

    <div class="col-md-4">
        <label class="form-label">Asset ID</label>
        <input type="number" class="form-control" name="Asset_ID" value="<?php echo e($data['Asset_ID']); ?>" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Make / Manufacturer</label>
        <input type="text" class="form-control" name="Make_Manufacturer" 
               value="<?php echo e($data['Make_Manufacturer']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Model</label>
        <select class="form-control" name="Model">
            <option selected><?php echo e($data['Model']); ?></option>
            <?php
            $q = db_query_soft("SELECT DISTINCT Model FROM ves_data.inventory_data ORDER BY Model");
            while ($r = db_fetch($q, PDO::FETCH_NUM)) {
                echo '<option value="'.e($r[0]).'">'.e($r[0]).'</option>';
            }
            ?>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Branch ID</label>
        <input type="text" class="form-control" name="Branch_id" 
               value="<?php echo e($data['Branch_id']); ?>" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Branch</label>
        <select class="form-control" name="Branch">
            <option selected><?php echo e($data['Branch']); ?></option>
            <?php
            $q2 = db_query_soft("SELECT DISTINCT Branch FROM ves_data.inventory_data ORDER BY Branch");
            while ($r2 = db_fetch($q2, PDO::FETCH_NUM)) {
                echo '<option value="'.e($r2[0]).'">'.e($r2[0]).'</option>';
            }
            ?>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Dept</label>
        <input type="text" class="form-control" name="DEPT" value="<?php echo e($data['DEPT']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">User</label>
        <input type="text" class="form-control" name="User" value="<?php echo e($data['User']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Primary / Secondary Dev</label>
        <input type="number" class="form-control" name="PrimarySecondary_Dev" 
               value="<?php echo e($data['PrimarySecondary_Dev']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Processor Type & Speed</label>
        <input type="text" class="form-control" name="Processor_Type_and_Speed" 
               value="<?php echo e($data['Processor_Type_and_Speed']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Purchase Date</label>
        <input type="date" class="form-control" name="Purchase_Date" 
               value="<?php echo e($data['Purchase_Date']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Purchase Cost / Budget</label>
        <input type="text" class="form-control" name="Purchase_Cost_Budget" 
               value="<?php echo e($data['Purchase_Cost_Budget']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">New Model</label>
        <input type="text" class="form-control" name="New_Model" 
               value="<?php echo e($data['New_Model']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Month Plan</label>
        <input type="text" class="form-control" name="Month_Plan" 
               value="<?php echo e($data['Month_Plan']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Warranty Expiry Date</label>
        <input type="date" class="form-control" name="Warranty_Expiry_Date" 
               value="<?php echo e($data['Warranty_Expiry_Date']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Remark</label>
        <input type="text" class="form-control" name="REMARK" 
               value="<?php echo e($data['REMARK']); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select class="form-control" name="STATUS">
            <option <?php if($data['STATUS']=="ACTIVE") echo "selected"; ?>>ACTIVE</option>
            <option <?php if($data['STATUS']=="REPAIR") echo "selected"; ?>>REPAIR</option>
            <option <?php if($data['STATUS']=="SPARE") echo "selected"; ?>>SPARE</option>
            <option <?php if($data['STATUS']=="DISPOSED") echo "selected"; ?>>DISPOSED</option>
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

    <div class="col-12 mt-4">
      <button type="submit" class="btn btn-success">Update Data</button>
        <a href="inventory_list.php" class="btn btn-secondary">Back</a>
    </div>

</form>
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