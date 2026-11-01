<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_pemohon = $_SESSION['nama_lengkap'];

$no = in_val('no_sales', 'get');
$source = in_val('src', 'get');
if(num($source) ==1)
{
$query_pv = q_set($__p_query_pv, "SELECT date_format(t.enroll_date,'%d/%m/%y'),t.nama, a.country, a.school, t.program, t.major, t.pv_estimated FROM tb_sales_report  t left join tb_master_partner a on t.kd_school = a.kd_school  where t.no = ? ", [(string) ($no)]);	
}

$resource_pv = db_query_or_die('errro_1', $query_pv, $__p_query_pv ?? []);
if (num(db_num_rows($resource_pv)) > 0)
{
while ($row_pv=  db_fetch($resource_pv, PDO::FETCH_NUM))
	{
	$nama = $row_pv['1'];
	$country = $row_pv['2'];
	$school = $row_pv['3'];
	$program = $row_pv['4'];
	$major = $row_pv['5'];
	$pv_estimated = $row_pv['6'];	
	}
}
$_GET['no']=$no;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PV Update</title>
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
     <form name="form1" method="post" action="#"  enctype="multipart/form-data"><?php echo csrf_field(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) --><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo e($nama) ?></h3>
            </div>
		  </div>
	    </div>
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form --><!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box"><div class="box-body">
			<div class="box-header with-border">
			  <h3 class="box-title"><?php echo e($country) ?></h3><br>
			   <h4 class="box-title"><?php echo e($school) ?> - <?php echo e($program) ?> - <?php echo e($major) ?>  </h4><br>
			</div>		 
			<div class="col-md-12">
			  <div class="col-md-4">
			    <div class="form-group">
				<label for="exampleInputEmail5">PV Estimated </label>
				<input type="number" class="form-control" placeholder="Enter ..." name="pv_estimated" value="<?php echo  e($pv_estimated) ?>"><input type="hidden" class="form-control" placeholder="Enter ..." name="no" value="<?php echo  e($no) ?>">
			  </div>
			</div>
			  <div class="box-footer">
			    <button type="submit" class="btn btn-primary"   name="AddItem" value="AddItem">Save</button>
			  </div>
			</div> 
            <!-- /.bodfx-header -->
</div>
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
	
if (isset($_POST['AddItem'])) 
{
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$no = in_val('no', 'post');	
$pv_estimated = in_val('pv_estimated', 'post');
$query_update_po = q_set($__p_query_update_po, "update ves_data.tb_sales_report set pv_estimated = ?   where no = ? ", [(string) ($pv_estimated), (string) ($no)]);	

$resource_update_po = db_query_or_die('errro_1', $query_update_po, $__p_query_update_po ?? []);	
echo "<script type=\"text/javascript\">\n";
echo "alert('PV Updated');\n";
echo "window.opener.location.reload(true);\n";								
echo "window.close();\n";				
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
<script>
    function submit(form) {
        form.submit();
    }
</script>
</body>
</html>
