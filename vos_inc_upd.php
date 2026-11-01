<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$no_sales=in_val('no_sales', 'get');
$propose=in_val('propose', 'get');
$query_data_sales = q_set($__p_query_data_sales, "SELECT t.kd_cabang, t.enroll_date, t.kd_biodata, t.nama,t.kd_school,b.country,b.school FROM tb_sales_report  t left join tb_master_partner b on t.kd_school = b.kd_school  where t.no =  ? ", [(string) ($no_sales)]);	
$resource_data_sales = db_query_soft($query_data_sales, $__p_query_data_sales ?? []);
if(num(db_num_rows($resource_data_sales)) > 0)
	{
	while ($row_data_sales  =  db_fetch($resource_data_sales, PDO::FETCH_NUM))
		{
		$kd_cabang = $row_data_sales[0];
		$enroll_date = $row_data_sales[1];
		$kd_biodata = $row_data_sales[2];
		$kd_school		 = $row_data_sales[4];
		$country = $row_data_sales[5]; 
		$school = $row_data_sales[6]; 		
		}
	}
if ($country == 'AUSTRALIA' or $country == 'CHINA' or $country == 'Hongkong' or $country == 'INDONESIA' or $country == 'JAPAN' or $country == 'MALAYSIA' 
or $country == 'SINGAPORE' or $country == 'SOUTH KOREA' or $country == 'TAIWAN' ) {$list = 'Eastern';$besaran = '100000';}
elseif ($country == 'BELARUSIA' or $country == 'CANADA'or $country == ''or $country == 'France'or $country == 'GERMANY'or $country == 'Holland'or $country == '' or $country == ''or $country == 'IRELAND'or $country == 'ITALY' or $country == 'NETHERLAND'or $country == 'NEW ZEALAND' or $country == 'RUSIA'or $country == 'SPAIN'or $country == 'SWISS'or $country == 'UK'or $country == 'USA') {$list = 'Western';$besaran = '180000';}
else {$list = 'Unknown';$besaran = '0';}

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
			  <div class="col-md-4">
			    <div class="form-group">
				<label for="exampleInputEmail5">Group Country</label>
				<select name="group_country" id="group_country" class="form-control">
				  <option value= "Western">Western</option>
				  <option value= "Eastern">Eastern</option>
				  <option value= "Unknown">Unknown</option>
			        <option selected><?php echo  e($list) ?></option>					
				    </option>
				  </select>
				<input type="hidden" class="form-control" placeholder="Enter ..." name="no" value="<?php echo  e($no) ?>">
			  </div>
			  <div class="box-footer">
			    <button type="submit" class="btn btn-primary"   name="AddItem" value="AddItem">Confirm</button>
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
