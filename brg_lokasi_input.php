<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$brg_cat = in_val('brg_cat', 'any');
$brg_sub_cat = in_val('brg_sub_cat', 'any');
$query_cek_category = q_set($__p_query_cek_category, "SELECT id from brg_master_cat where brg_cat = ? and brg_sub_cat = ? ", [(string) ($brg_cat), (string) ($brg_sub_cat)]);
$result_cek_category=db_query_or_die("Wah error nih1", $query_cek_category, $__p_query_cek_category ?? []);
if(num(db_num_rows($result_cek_category)) > 0)
	{
	while ($row_cat=  db_fetch($result_cek_category, PDO::FETCH_NUM))
		{
		$id_cat = $row_cat[0];
		}
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
<div class="content">




  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ASSET MANAGEMENT & INVENTORY
        <small>New Asset</small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
            <form role="form" method="post"><?php echo csrf_field(); ?>
		
      <div class="row">
        <!-- left column -->
      <div class="col-md-12">
          <!-- general form elements -->
        <div class="box box-title">
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">
        <div class="col-md-4">				  
                <div class="form-group">
                  <label for="exampleInputEmail1">Office/Building</label>
					<select class="form-control" name="brg_cat"  onChange="this.form.submit()">
					<?php
					$query_brg_cat = q_set($__p_query_brg_cat, "SELECT distinct brg_cat FROM ves_data.brg_master_cat order by brg_cat");
					$resource_brg_cat = db_query_or_die('errro_7', $query_brg_cat, $__p_query_brg_cat ?? []);
					while ($row_brg_cat=  db_fetch($resource_brg_cat, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_brg_cat[0]).'">'.e($row_brg_cat[0]).'</option>';
					}      ?>
					<option selected><?php echo  e($brg_cat) ?></option>
					</select>
				  <button type="button" class="btn btn-info btn-flat btn-xs" target="popup" 
onclick="window.open('brg_new1.php?c=1','popup','width=1000,height=800'); return false;">New Category</button>
                </div>
			    </div>
				 <div class="col-md-4">	 
                <div class="form-group">
                  <label for="exampleInputEmail2">Floor</label>
                  <select class="form-control" name="brg_sub_cat"  onChange="this.form.submit()">
                    <option>Floor 1</option>
                    <option>Floor 2</option>
                    <option>Floor 3</option>			  
                    <option>Floor 4</option>
                    <option>Basement</option>
					  
                  </select>
				  <button type="button" class="btn btn-info btn-flat btn-xs" target="popup" 
onclick="window.open('brg_new1.php?c=2&cat=<?php echo e(u($brg_cat)) ?>','popup','width=1000,height=800'); return false;">New Category</button>
                </div>
			    </div>
				 <div class="col-md-4">
				   <div class="form-group">
				     <label for="exampleInputEmail4">Room</label>
				     <select class="form-control" name="brg_sub_cat2"  onChange="this.form.submit()">
				       <option>Floor 1</option>
				       <option>Floor 2</option>
				       <option>Floor 3</option>
				       <option>Floor 4</option>
				       <option>Basement</option>
			         </select>
				     <button type="button" class="btn btn-info btn-flat btn-xs" target="popup" 
onclick="window.open('brg_new1.php?c=2&cat=<?php echo e(u($brg_cat)) ?>','popup','width=1000,height=800'); return false;">New Category</button>
			       </div>
			    </div>
				 <div class="col-md-6">
				   <div class="form-group">
				     <label>Tanggal Penempatan</label>
				     <input type="date" class="form-control" name="brg_tgl_beli" value="<?php echo e($brg_tgl_beli) ?>" placeholder="Enter ...">
			       </div>
			    </div>
              </div>
              <!-- /.box-body -->
           
        </div>
        <!-- /.box -->

        <!-- Form Element sizes --><!-- /.box --><!-- /.box -->

        <!-- Input addon --><!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column --><!--/.col (right) -->
      </div>
				            <div class="box-footer">
              <button type="submit" name="Submit" value="Submit" class="btn btn-primary">Submit</button>
            </div>

   			 </form>   <!-- /.row -->
    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->


  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
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
	
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$fullurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";		
$brg_cat = in_val('brg_cat', 'any');
$brg_sub_cat = in_val('brg_sub_cat', 'any');
$query_cek_category = q_set($__p_query_cek_category, "SELECT id from brg_master_cat where brg_cat = ? and brg_sub_cat = ? ", [(string) ($brg_cat), (string) ($brg_sub_cat)]);
$result_cek_category=db_query_or_die("Wah error nih1", $query_cek_category, $__p_query_cek_category ?? []);
if(num(db_num_rows($result_cek_category)) > 0)
	{
	while ($row_cat=  db_fetch($result_cek_category, PDO::FETCH_NUM))
		{
		$id_cat = $row_cat[0];
		}
	}
	
$brg_title  = in_val('brg_title', 'any');	
$brg_deskripsi  = in_val('brg_deskripsi', 'any');	
$brg_tgl_beli = in_val('brg_tgl_beli', 'any');
$brg_vendor = in_val('brg_vendor', 'any');	
	
	$query_simpan_program = q_set($__p_query_simpan_program, "insert into ves_data.brg_master_item(id_cat, brg_title, brg_description, thn_pembelian, nm_vendor, item_registration,dt_entry) values(? ,? ,? ,? ,? ,'',? )", [(string) ($id_cat), (string) ($brg_title), (string) ($brg_deskripsi), (string) ($brg_tgl_beli), (string) ($brg_vendor), (string) ($hari_ini)]);

	$resource_simpan_score_class = db_query_or_die('errro_simpan2', $query_simpan_program, $__p_query_simpan_program ?? []);
					echo "<script type=\"text/javascript\">\n";
				echo "alert('New Item Submitted');\n";
				echo "window.open('brg_list.php?brg_cat=" . e(u($brg_cat)) . "&brg_sub_cat=" . e(u($brg_sub_cat)) . "', '_self');\n";				
				echo "</script>";	
}
?>	