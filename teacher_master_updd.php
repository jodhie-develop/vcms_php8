<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";


$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$id = in_val('id', 'any');
$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT a.no, nama_detail,kd_teacher, a.branch, posisi, a.aktif FROM ves_data.tb_user a left join ves_data.vip_teacher_name b on a.no = b.kd_user where a.no = ? ", [(string) ($id)]);

$resource_nm_teacher = db_query_soft($query_nm_teacher, $__p_query_nm_teacher ?? []);
			
if(num(db_num_rows($resource_nm_teacher)) > 0)
	{
	while ($row_nm_teacher  =  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
		{
		$nm_teacher = $row_nm_teacher[1];
		$branch = $row_nm_teacher[3];
		$group_teacher = $row_nm_teacher[4];			
		$aktif = $row_nm_teacher[5];			
		}
	}
$query_rate = q_set($__p_query_rate, "SELECT v.id_teacher, v.nama_rate, v.rate, v.update_date FROM ves_data.vip_mst_teacher_rate v where v.id_teacher = ? ", [(string) ($id)]);

$resource_rate = db_query_soft($query_rate, $__p_query_rate ?? []);
			
if(num(db_num_rows($resource_rate)) > 0)
	{
	$i = 1;
	while ($row_rate  =  db_fetch($resource_rate, PDO::FETCH_NUM))
		{
		$nm_rate = $row_rate[1];
		$rate = $row_rate[2];
		if (num($i)==1){$nm_rate_1 = $nm_rate;$rate_1 = $rate;}
		elseif (num($i)==2){$nm_rate_2 = $nm_rate;$rate_2 = $rate;}
		elseif (num($i)==3){$nm_rate_3 = $nm_rate;$rate_3 = $rate;}
		elseif (num($i)==4){$nm_rate_4 = $nm_rate;$rate_4 = $rate;}

		$i = num($i)+1;
		}
	}

if ($kd_center == '1') {$center = 'East Sby';}
if ($kd_center == '2') {$center = 'West Sby';}
if ($kd_center == '3') {$center = 'Bali';}
if ($kd_center == '4') {$center = 'South Jkt';}
if ($kd_center == '5') {$center = 'North Jkt';}
if ($kd_center == '6') {$center = 'West Jkt';}
if ($kd_center == '7') {$center = 'Bandung';}
if ($kd_center == '8') {$center = 'Malang';}


if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}

if ($kd_center == '1') {$center = 'East Sby';}
if ($kd_center == '2') {$center = 'West Sby';}
if ($kd_center == '3') {$center = 'Bali';}
if ($kd_center == '4') {$center = 'South Jkt';}
if ($kd_center == '5') {$center = 'North Jkt';}
if ($kd_center == '6') {$center = 'West Jkt';}
if ($kd_center == '7') {$center = 'Bandung';}
if ($kd_center == '8') {$center = 'Malang';}
$tanggalpilih = in_val('tanggalpilih', 'any');


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
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
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
   <style>

function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
.style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
</style>
    <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}

</script><body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="content">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="box">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Teacher's Scheduler</h1></section>
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->
<form method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
		  	<div class="box box-warning">
		  		<div class="box-header with-border"></div>
           	  <div class="box-body">
           	    <div class="col-md-4">
           	      <div class="form-group">
           	        <label>Teacher's Name</label>
           	        <input type="text" class="form-control"  placeholder="Enter ..." name="nm_teacher" value="<?php echo e($nm_teacher) ?>" readonly>
       	          </div>
       	        </div>
           	    <div class="col-md-3">
           		<div class="form-group">
       		      <label>Center</label>
                 		  <select class="form-control" name="center">
                 	        <option>East Sby</option>
                 	        <option>West Sby</option>
                 	        <option>Bali</option>
                 	        <option>South Jkt</option>
                 	        <option>North Jkt</option>
                 	        <option>West Jkt</option>
                 	        <option>Bandung</option>
                 	        <option>Malang</option>
							<option selected><?php echo e($branch) ?></option>
       	          </select>
			    </div></div>
           	    <div class="col-md-3">
           	      <div class="form-group">
           	        <label>Group</label>
           	        <select class="form-control" name="group_teacher"  >
           	          <option>Full Time</option>
           	          <option>Semi Full Time</option>
           	          <option>Part Time</option>
           	          <option selected><?php echo e($group_teacher) ?></option>
       	            </select>
       	          </div>
       	        </div>
           	    <div class="col-md-3">
           	      <div class="form-group">
           	        <label>Status</label>
           	        <select class="form-control" name="group_teacher2"  >
           	          <option>Full Time</option>
           	          <option>Semi Full Time</option>
           	          <option>Part Time</option>
           	          <option selected><?php echo e($aktif) ?></option>
       	            </select>
       	          </div>
       	        </div>
           	    <div class="col-md-8">
           	      <div class="col-md-4">
           	        <div class="form-group">
           	          <label>Type of Teaching</label>
#1           	          
<select class="form-control" name="nm_rate_1"  >
           	            <option>Online</option>
           	            <option>Offiline</option>
           	            <option>Visit</option>
	       	            <option>Corporate</option>
	
           	            <option selected><?php echo e($nm_rate_1) ?></option>
       	              </select>
       	            </div>
       	          </div>
           	      <div class="col-md-4">
           	        <div class="form-group">
           	          <label>Rate</label>
           	          #1
           	          <input type="text" class="form-control"  placeholder="Enter ..." name="rate_1" value="<?php echo e($rate_1) ?>">
       	            </div>
       	          </div>
       	        </div>
           	    <div class="col-md-8">
           	      <div class="col-md-4">
           	        <div class="form-group">
           	          <label>Type of Teaching</label>
#2           	          
<select class="form-control" name="nm_rate_2"  >
           	            <option>Online</option>
           	            <option>Offiline</option>
           	            <option>Visit</option>
	       	            <option>Corporate</option>
	
           	            <option selected><?php echo e($nm_rate_2) ?></option>
       	              </select>
       	            </div>
       	          </div>
           	      <div class="col-md-4">
           	        <div class="form-group">
           	          <label>Rate</label>
           	          #2
           	          <input type="text" class="form-control"  placeholder="Enter ..." name="rate_2" value="<?php echo e($rate_2) ?>">
       	            </div>
       	          </div>
       	        </div>
           	    <div class="col-md-8">
           	      <div class="col-md-4">
           	        <div class="form-group">
           	          <label>Type of Teaching</label>
#3           	          
<select class="form-control" name="nm_rate_3"  >
           	            <option>Online</option>
           	            <option>Offiline</option>
           	            <option>Visit</option>
	       	            <option>Corporate</option>
	
           	            <option selected><?php echo e($nm_rate_3) ?></option>
       	              </select>
       	            </div>
       	          </div>
           	      <div class="col-md-4">
           	        <div class="form-group">
           	          <label>Rate</label>
           	          #3
           	          <input type="text" class="form-control"  placeholder="Enter ..." name="rate_3" value="<?php echo e($rate_3) ?>">
       	            </div>
       	          </div>
       	        </div>
           	    <div class="col-md-8">
           	      <div class="col-md-4">
           	        <div class="form-group">
           	          <label>Type of Teaching</label>
#4           	          
<select class="form-control" name="nm_rate_4"  >
           	            <option>Online</option>
           	            <option>Offiline</option>
           	            <option>Visit</option>
	       	            <option>Corporate</option>
	
           	            <option selected><?php echo e($nm_rate_4) ?></option>
       	              </select>
       	            </div>
       	          </div>
           	      <div class="col-md-4">
           	        <div class="form-group">
           	          <label>Rate</label>
           	          #4
           	          <input type="text" class="form-control"  placeholder="Enter ..." name="rate_4" value="<?php echo e($rate_4) ?>">
       	            </div>
       	          </div>
       	        </div>
           	    <div class="col-md-6">
           	      <div class="form-group">
           	        <input type="submit" name="Submit" value="Submit"  class="btn btn-primary active"/>
       	          </div>
       	        </div>
           	    <span class="form-group">
       	        <input type="text" name="kd_biodata"value="<?php echo e($kd_biodata) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="id"value="<?php echo e($id) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdcl"value="<?php echo e($kd_class) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdprg"value="<?php echo e($kd_program) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kd_teacher"value="<?php echo e($kd_teacher) ?>" hidden="" >
       	        </span></div> 
			</div>




</body>
</html>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{

$fullurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$id = in_val('id', 'any');
$center = in_val('center', 'any');
$nm_rate_1 = in_val('nm_rate_1', 'any');
$rate_1 = in_val('rate_1', 'any');	
$nm_rate_2 = in_val('nm_rate_2', 'any');
$rate_2 = in_val('rate_2', 'any');	
$nm_rate_3 = in_val('nm_rate_3', 'any');
$rate_3 = in_val('rate_3', 'any');	
$nm_rate_4 = in_val('nm_rate_4', 'any');
$rate_4 = in_val('rate_4', 'any');	


//day 1	
if ($nm_rate_1 != ''){
$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT v.id_teacher, v.nama_rate, v.rate, v.update_date FROM ves_data.vip_mst_teacher_rate v where id_teacher = ?  and nama_rate = ? ", [(string) ($id), (string) ($nm_rate_1)]);
$result_cek_teacher=db_query_or_die("Wah error nih1111", $query_cek_teacher, $__p_query_cek_teacher ?? []);
if(num(db_num_rows($result_cek_teacher)) > 0)
	{
	while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
		{
		$query_update_rate = q_set($__p_query_update_rate, "update  ves_data.vip_mst_teacher_rate  set rate = ? ,update_date = ? where id_teacher = ?  and nama_rate = ? ", [(string) ($rate_1), (string) ($hari_ini), (string) ($id), (string) ($nm_rate_1)]);
		$result_update=db_query_or_die("Wah error nih2", $query_update_rate, $__p_query_update_rate ?? []);
		}
	}
else
	{
	$query_insert_rate = q_set($__p_query_insert_rate, "insert into   ves_data.vip_mst_teacher_rate  (id_teacher, nama_rate, rate,update_date) values (? ,? ,? ,? )", [(string) ($id), (string) ($nm_rate_1), (string) ($rate_1), (string) ($hari_ini)]);
	$result_insert=db_query_or_die("Wah error nih3", $query_insert_rate, $__p_query_insert_rate ?? []);
	}
	}
if ($nm_rate_2 != ''){	
$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT v.id_teacher, v.nama_rate, v.rate, v.update_date FROM ves_data.vip_mst_teacher_rate v where id_teacher = ?  and nama_rate = ? ", [(string) ($id), (string) ($nm_rate_2)]);
$result_cek_teacher=db_query_or_die("Wah error nih4", $query_cek_teacher, $__p_query_cek_teacher ?? []);
if(num(db_num_rows($result_cek_teacher)) > 0)
	{
	while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
		{
		$query_update_rate = q_set($__p_query_update_rate, "update  ves_data.vip_mst_teacher_rate  set rate = ? ,update_date = ? where id_teacher = ?  and nama_rate = ? ", [(string) ($rate_2), (string) ($hari_ini), (string) ($id), (string) ($nm_rate_2)]);
		$result_update=db_query_or_die("Wah error nih5", $query_update_rate, $__p_query_update_rate ?? []);
		}
	}
else
	{
	$query_insert_rate = q_set($__p_query_insert_rate, "insert into   ves_data.vip_mst_teacher_rate  (id_teacher, nama_rate, rate,update_date) values (? ,? ,? ,? )", [(string) ($id), (string) ($nm_rate_2), (string) ($rate_2), (string) ($hari_ini)]);
	$result_insert=db_query_or_die("Wah error nih6", $query_insert_rate, $__p_query_insert_rate ?? []);
	}	
	}
if ($nm_rate_3 != ''){		
$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT v.id_teacher, v.nama_rate, v.rate, v.update_date FROM ves_data.vip_mst_teacher_rate v where id_teacher = ?  and nama_rate = ? ", [(string) ($id), (string) ($nm_rate_3)]);
$result_cek_teacher=db_query_or_die("Wah error nih7", $query_cek_teacher, $__p_query_cek_teacher ?? []);
if(num(db_num_rows($result_cek_teacher)) > 0)
	{
	while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
		{
		$query_update_rate = q_set($__p_query_update_rate, "update  ves_data.vip_mst_teacher_rate v set rate = ? ,update_date = ? where id_teacher = ?  and nama_rate = ? ", [(string) ($rate_3), (string) ($hari_ini), (string) ($id), (string) ($nm_rate_3)]);
		$result_update=db_query_or_die("Wah error nih8", $query_update_rate, $__p_query_update_rate ?? []);
		}
	}
else
	{
	$query_insert_rate = q_set($__p_query_insert_rate, "insert into   ves_data.vip_mst_teacher_rate (id_teacher, nama_rate, rate,update_date) values (? ,? ,? ,? )", [(string) ($id), (string) ($nm_rate_3), (string) ($rate_3), (string) ($hari_ini)]);
	$result_insert=db_query_or_die("Wah error nih9", $query_insert_rate, $__p_query_insert_rate ?? []);
	}
	}
if ($nm_rate_4 != ''){		
$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT v.id_teacher, v.nama_rate, v.rate, v.update_date FROM ves_data.vip_mst_teacher_rate v where id_teacher = ?  and nama_rate = ? ", [(string) ($id), (string) ($nm_rate_4)]);
$result_cek_teacher=db_query_or_die("Wah error nih10", $query_cek_teacher, $__p_query_cek_teacher ?? []);
if(num(db_num_rows($result_cek_teacher)) > 0)
	{
	while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
		{
		$query_update_rate = q_set($__p_query_update_rate, "update  ves_data.vip_mst_teacher_rate v set rate = ?  ,update_date = ? where id_teacher = ?  and nama_rate = ? ", [(string) ($rate_4), (string) ($hari_ini), (string) ($id), (string) ($nm_rate_4)]);
		$result_update=db_query_or_die("Wah error nih111", $query_update_rate, $__p_query_update_rate ?? []);
		}
	}
else
	{
	$query_insert_rate = q_set($__p_query_insert_rate, "insert into   ves_data.vip_mst_teacher_rate  (id_teacher, nama_rate, rate,update_date) values (? ,? ,? ,? )", [(string) ($id), (string) ($nm_rate_4), (string) ($rate_4), (string) ($hari_ini)]);
	$result_insert=db_query_or_die("Wah error nih13456", $query_insert_rate, $__p_query_insert_rate ?? []);
	}		
}
		echo "<script type=\"text/javascript\">\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";					
		echo "</script>";	
}
?>
