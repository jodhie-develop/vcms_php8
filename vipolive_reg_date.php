<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";

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
              <h3 class="box-title">
                <input type="hidden" name="no_sales" id="no_sales" value="<?php echo e($no_sales)?>"><input type="hidden" name="propose" id="propose" value="<?php echo e($propose)?>">
              </h3>
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
			  <h3 class="box-title"><?php echo e($country) ?> - <?php echo e($school) ?></h3>
			</div>		 
			<div class="col-md-12">
<div class="col-md-6">
      <div class="form-group">
        <label>Period<br>
        </label>
      </div>
      <div class="form-group"><small>
      <input type="date" format="dd/MM/yyyy" name="date_start" id="date" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
        </small>to <small>
        <input type="date" name="date_end" id="date3" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
      </small></div>		
  <div class="form-group">
    <button type="button" class="btn btn-primary" onclick="location.href='vipolive_xl.php?dt_s=<?php echo e(u($date_start)) ?>&dt_e=<?php echo e(u($date_end)) ?>';" >Generate</button>
  </div>			
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
$propose = in_val('propose', 'post');
$no_sales = in_val('no_sales', 'post');
$query_data_sales = q_set($__p_query_data_sales, "SELECT t.kd_cabang, t.enroll_date, t.kd_biodata, t.nama,t.kd_school FROM tb_sales_report  t where no =  ? ", [(string) ($no_sales)]);	
$resource_data_sales = db_query_soft($query_data_sales, $__p_query_data_sales ?? []);
if(num(db_num_rows($resource_data_sales)) > 0)
	{
	while ($row_data_sales  =  db_fetch($resource_data_sales, PDO::FETCH_NUM))
		{
		$kd_cabang = $row_data_sales[0];
		$enroll_date = $row_data_sales[1];
		$kd_biodata = $row_data_sales[2];
		$kd_school		 = $row_data_sales[4];

		}
	}	
if($group_country == 'Eastern'){$besaran = '100000';}	
elseif($group_country == 'Western'){$besaran = '180000';}	
if(num($propose) ==0)
	{
	$query = q_set($__p_query, "insert into vos_incentive(kd_branch, nama_sc,kd_sales_report, kd_biodata, kd_school,st_reward, dt_entry, nominal, remark,pic ) values (? ,? ,? ,? ,? ,'1',? ,? ,'',? )", [(string) ($kd_cabang), (string) ($nama_lengkap), (string) ($no_sales), (string) ($kd_biodata), (string) ($kd_school), (string) ($tgl_hari_ini), (string) ($besaran), (string) ($nama_lengkap)]);
	$resource_input = db_query_soft($query, $__p_query ?? []);	
	}

echo "<script type=\"text/javascript\">\n";
echo "alert('VOS  Incentive Claim Processed');\n";
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
