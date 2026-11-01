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
$id = in_val('id', 'any');
$kd_branch = $_SESSION['kd_branch'];

$query_olive = q_set($__p_query_olive, "SELECT b.e_mail, concat(' ',nama, middle_name, family_name ), b.vip_program,a.dt_entry,a.st,a.id,a.kd_branch ,b.kd_biodata  FROM ves_data.olive_data_list a left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata  where a.id = ? ", [(string) ($id)]);

      $result_olive=db_query_or_die("Wah error nih10", $query_olive, $__p_query_olive ?? []);
if ($result_olive) 
	{ 
	while ($r = db_fetch($result_olive, PDO::FETCH_NUM))
		{
		$e_mail = $r[0];
		$nama = $r[1];
		$program = $r[2];
		$kd_cbg = $r[6];
		$kd_biodata = $r[7];		
		if (num($kd_cbg) == 1){$kd_cbg = 'East Sby';}
		elseif (num($kd_cbg) == 1){$kd_cbg = 'East Sby';}
		elseif (num($kd_cbg) == 2){$kd_cbg = 'West Sby';}
		elseif (num($kd_cbg) == 3){$kd_cbg = 'Denpasar';}
		elseif (num($kd_cbg) == 4){$kd_cbg = 'South Jkt';}
		elseif (num($kd_cbg) == 5){$kd_cbg = 'North Jkt';}
		elseif (num($kd_cbg) == 6){$kd_cbg = 'West Jkt';}
		elseif (num($kd_cbg) == 7){$kd_cbg = 'Bandung';}
		elseif (num($kd_cbg) == 8){$kd_cbg = 'Malang';}
		   		
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
</head>
<?php //========================== left nav ?>
 <?php //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Olive Registration Update<br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-6">
    <div class="form-group">
      <label>E-Mail :<br>
        <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="remark3" readonly 
                 	      value="<?php echo e($e_mail) ?>">
      </label>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>Student Name :<br>
        <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="remark4" 
                 	      value="<?php echo e($nama) ?>" readonly>
        <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="kd_biodata" 
                 	      value="<?php echo e($kd_biodata) ?>" readonly>
      </label>
    </div>
</div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Center Taking Care</label>
<select name="kd_cbg"  class="style33" id="select">
              <option value="0">--CHOOSE--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="8">Malang</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="11">PIK</option>
	
		      <option value="351">Vpro Sby</option>
		      <option value="355">Vpro Jkt</option>
		      <option value="356">Vpro Dps</option>
		      <option value="358">Vpro Mlg</option>
		      <option value="353">Vpro Bdg</option>                	                                    
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select>
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="id" 
                 	      value="<?php echo e($id) ?>" >
  </span></div>    
<div class="box-body">
 <?php if ($jns_payment ==  'Material'){ ?>
 <?php } ?>
</div>    
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>VE Program Requested</label>
                <select name="vip_program" id="vip_program"  class="form-control" >
				<option>--Choose One--</option>					
				<option>IELTS</option>
				<option>ACADEMIC ENGLISH</option>
				<option>iBT TOEFL</option>
				<option>PBT TOEFL</option>
				<option>GENERAL ENGLISH</option>					
				<option selected="selected"> <?php echo e($program);  ?> </option>                               
        </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Date Test</label>
      (R,L,W only)
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="tgl_test" 
                 	      value="<?php echo e($tgl_hari_ini) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Time Test</label>
      (R,L,W only)
      <input type="time" ang="en-150" class="form-control"  placeholder="Enter ..." name="waktu_test" 
                 	      value="<?php echo e($tgl_hari_ini) ?>">
    </div>
  </div>
</div>
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Action</label>
      <select name="test_upd"  id="jns_report2" class="form-control" >
        <option value="1">Approve</option>
        <option value="0">Pending</option>
        <option value="2">Reject</option>
        <option selected="selected"><?php echo e($test_upd) ?></option>
      </select>
    </div>
</div>
  <div class="col-md-8">
    <div class="form-group">
      <label>Reason</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="reason_test" 
                 	      value="<?php echo e($remark) ?>">
    </div>
  </div>
</div></form><input type="submit" name="Submit" value="Submit" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
	$st_simpan = 1;

	

	$id = in_val('id', 'any');
	$vip_program = in_val('vip_program', 'any');
	$waktu_test = in_val('waktu_test', 'any');
	$kd_biodata = in_val('kd_biodata', 'any');	
	$tgl_test = in_val('tgl_test', 'any');
	$tanggal_test = "$tgl_test.' '.$waktu_test";
	$test_upd  = in_val('test_upd', 'any');
	if ($test_upd ==''){$st_simpan = 0;$gagal = "Status must be choosen";}		
	$reason_test = in_val('reason_test', 'any');
	$kd_cbg  = in_val('kd_cbg', 'any');
	if ($kd_cbg ==''){$st_simpan = 0;$gagal = "Center must be choosen";}	

	$hari=date("d");
	$bulan=date("m");
	$kd_branch = $_SESSION['kd_branch'];
	$nama_lengkap = $_SESSION['nama_lengkap']; 

	
	if (num($st_simpan)==1)
		{	
		$query_update_receipt= q_set($__p_query_update_receipt, "update ves_data.olive_data_list set  st= ? , remark = ? , dt_test = ? ,vip_program = ? ,kd_branch = ? where id = ? ", [(string) ($test_upd), (string) ($reason_test), (string) ($tanggal_test), (string) ($vip_program), (string) ($kd_cbg), (string) ($id)]); 
		$resource_update_payment = db_query_or_die('errro_simpan_1', $query_update_receipt, $__p_query_update_receipt ?? []);
		if (num($kd_branch) == 1){$kd_cbg = 'East Sby';}
		elseif (num($kd_branch) == 1){$branch = 'East Sby';}
		elseif (num($kd_branch) == 2){$branch = 'West Sby';}
		elseif (num($kd_branch) == 3){$branch = 'Denpasar';}
		elseif (num($kd_branch) == 4){$branch = 'South Jkt';}
		elseif (num($kd_branch) == 5){$branch = 'Central Jkt';}
		elseif (num($kd_branch) == 6){$branch = 'West Jkt';}
		elseif (num($kd_branch) == 7){$branch = 'Bandung';}
		elseif (num($kd_branch) == 8){$branch = 'Malang';}
		elseif (num($kd_branch) == 11){$branch = 'pik';}		
		   				
		$query_update_leads= q_set($__p_query_update_leads, "update ves_inc.tb_biodata set  kd_branch = ? , branch = ? where kd_biodata = ? ", [(string) ($kd_branch), (string) ($branch), (string) ($kd_biodata)]); 
		$resource_update_leads = db_query_or_die('errro_simpan_1', $query_update_leads, $__p_query_update_leads ?? []);	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Olive Registration Updated');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";
		}
	else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($gagal) . "');\n";
	echo "</script>";		
	}
		
	}
?>