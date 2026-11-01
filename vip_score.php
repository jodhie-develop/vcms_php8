<?php
// Popup input skor (placement / middle / final / progress check).
// Form dikirim POST + token CSRF; parameter awal (kdb, kdcl, t, pc) tetap dari link GET.
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
auth_require_login();
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap'];
$no = in_str('no', 20);
$kd_branch = $_SESSION['kd_branch'];
$kode_student = in_str('kdb', 45);
$kdcl = in_str('kdcl', 45);
$t = in_str('t', 3);
$pc = in_str('pc', 3);
$cb_test_type = '';
$nama = $middle_name = $family_name = '';
// field form kosong saat dibuka (versi lama: variabel tidak terdefinisi)
$note_score = $progress_check_1 = $progress_check_2 = $progress_overall = '';
$l = $st = $sp = $r = $w = $ttl = '';
if($t == 1) {$cb_test_type = "Placement Test";}
elseif($t == 2 or $t ==21) {$cb_test_type = "Middle Test";}
elseif($t == 3 or $t==31) {$cb_test_type = "Final Test";}
elseif($pc == 1) {$cb_test_type = "Progress Check 1";}
elseif($pc == 2) {$cb_test_type = "Progress Check 2";}
elseif($pc == 3) {$cb_test_type = "Progress Check Overall";}
$row_detail = db_row("SELECT t.nama, t.middle_name, t.family_name FROM ves_inc.tb_biodata t where t.kd_biodata = ?", [$kode_student], PDO::FETCH_NUM);
if ($row_detail !== null)
	{
	$nama = $row_detail[0];
	$middle_name = $row_detail[1];
	$family_name = $row_detail[2];
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
 <?php //  include ("left.php");	 ?>
 <?php //====================== ?>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      VIP Score Test - <?php echo e("$nama $middle_name $family_name") ?> <br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post" role="form"><?php echo csrf_field(); ?>
    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Test Type</label>
      <select name="cb_test_type"  id="payment_metodh" class="form-control" >
        <option>Placement Test</option>
        <option>Institutional Test</option>
        <option>International Test</option>
        <option>Other</option>
        <option selected><?php echo e($cb_test_type) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Test Date</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="tgl_test" 
                 	      value="<?php echo e($tgl_hari_ini) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="kode_student" 
                 	      value="<?php echo e($kode_student) ?>" hidden= "hidden">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="kdcl" 
                 	      value="<?php echo e($kdcl) ?>" hidden= "hidden">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="t" 
                 	      value="<?php echo e($t) ?>" hidden= "hidden">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="pc" 
                 	      value="<?php echo e($pc) ?>" hidden= "hidden">	
  </span></div>    
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>Note</label><input type="institution" ang="en-150" class="form-control"  placeholder="Enter ..." name="note_score" 
                 	      value="<?php echo e($note_score) ?>">
    </div>
  </div>
</div> 

<div class="box-body">
<?php if ($pc ==1)
{ ?>	
  <div class="col-md-2">
    <div class="form-group">
      <label>Progress Check 1</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="progress_check_1" 
                 	      value="<?php echo e($progress_check_1) ?>">
    </div>
  </div>
<?php } elseif ($pc ==2) {?>	
  <div class="col-md-2">
    <div class="form-group">
      <label>Progress Check 2</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="progress_check_2" 
                 	      value="<?php echo e($progress_check_2) ?>">
    </div>
  </div>
<?php } elseif ($pc ==3) {?>	
  <div class="col-md-2">
    <div class="form-group">
      <label>Progress Overall</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="progress_overall" 
                 	      value="<?php echo e($progress_overall) ?>">
    </div>
  </div>
<?php } else {?>	
</div>
	

<div class="box-body">
  <div class="col-md-2">
    <div class="form-group">
      <label>Listening</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="l" 
                 	      value="<?php echo e($l) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Structure</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="st" 
                 	      value="<?php echo e($st) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Speaking</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="sp" 
                 	      value="<?php echo e($sp) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Reading</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="r" 
                 	      value="<?php echo e($r) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Writing</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="w" 
                 	      value="<?php echo e($w) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>TOTAL</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="ttl" 
                 	      value="<?php echo e($ttl) ?>">
    </div>
  </div>
</div>
<?php } ?>
<div class="box-body"></div><input type="submit" name="Submit" value="Submit" /></form>
</body>

</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))
	{
	$kd_biodata	 = in_str('kode_student', 45, 'post');
	$listening_score = in_str('l', 45, 'post');
	$other_score = in_str('st', 45, 'post');
	$speaking_score = in_str('sp', 45, 'post');
	$reading_score = in_str('r', 45, 'post');
	$writing_score = in_str('w', 45, 'post');
	$total_score = in_str('ttl', 45, 'post');
	$progress_check_1 = in_str('progress_check_1', 20, 'post');
	$progress_check_2 = in_str('progress_check_2', 20, 'post');
	$progress_overall = in_str('progress_overall', 20, 'post');
	$note_score = in_str('note_score', 5000, 'post');
	$tgl_test = in_date('tgl_test', '', 'post');
	$cb_test_type = in_str('cb_test_type', 45, 'post');
	$t = in_str('t', 3, 'post');
	$pc = in_str('pc', 3, 'post');
	$kdcl = in_str('kdcl', 45, 'post');
		if ($cb_test_type == 'Placement Test') {$cb_test_type = 1;}
		elseif ($cb_test_type == 'Middle Test'){$cb_test_type = 2;}
		elseif ($cb_test_type == 'Final Test'){$cb_test_type = 3;}
		elseif ($cb_test_type == 'Progress Check 1'){$cb_test_type = 4;}
		elseif ($cb_test_type == 'Progress Check 2'){$cb_test_type = 5;}
		elseif ($cb_test_type == 'Progress Overall'){$cb_test_type = 6;}

	$sql_score_class = "insert into ves_data.vip_class_score_profile ( kd_cbg, class_code, kd_biodata,jns_test,L,S,R,W,other,total,remark, test_date,dt_entry,pic) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$params_score_class = [$kd_branch, $kdcl, $kd_biodata, (string) $cb_test_type, $listening_score, $speaking_score, $reading_score, $writing_score, $other_score, $total_score, $note_score, $tgl_test, $tgl_hari_ini, $nama_lengkap];

	if ($cb_test_type != 3 and $cb_test_type != 2 and $cb_test_type != 31 and $cb_test_type != 21  and $cb_test_type != 4  and $cb_test_type != 5  and $cb_test_type != 6)
	{
		$rumus =1;
	db_exec(
		"insert into ves_inc.tb_acd_history ( kd_biodata, test_type, test_date, test_detil, L, S, R, W,other, total) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
		[$kd_biodata, (string) $cb_test_type, $tgl_test, $note_score, $listening_score, $speaking_score, $reading_score, $writing_score, $other_score, $total_score]
	);
	db_exec($sql_score_class, $params_score_class);
	}

	if 	($t ==21)
	{		$rumus =2;
	// Versi lama: "...other = '..',total,remark = '..'" (SQL tidak valid, selalu gagal); total diisi seperti cabang lain.
	$sql = "update ves_data.vip_class_score_profile set L = ?, S = ?, R = ?, W = ?, other = ?, total = ?, remark = ?, test_date = ?, dt_entry = ?, pic = ? where class_code = ? and kd_biodata = ? and jns_test = '2'";
	$params = [$listening_score, $speaking_score, $reading_score, $writing_score, $other_score, $total_score, $note_score, $tgl_test, $tgl_hari_ini, $nama_lengkap, $kdcl, $kd_biodata];
	}
	elseif ($t ==31)
	{			$rumus =3;
	$sql = $sql_score_class; $params = $params_score_class;
	}
	elseif ($pc ==1)
	{			$rumus =4;
	$sql = "insert into ves_data.vip_class_score_profile ( kd_cbg, class_code, kd_biodata,jns_test,progress_check_1,remark, test_date,dt_entry,pic) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$params = [$kd_branch, $kdcl, $kd_biodata, (string) $cb_test_type, $progress_check_1, $note_score, $tgl_test, $tgl_hari_ini, $nama_lengkap];
	}
		elseif ($pc ==2)
	{			$rumus =4;
	$sql = "insert into ves_data.vip_class_score_profile ( kd_cbg, class_code, kd_biodata,jns_test,progress_check_2,remark, test_date,dt_entry,pic) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$params = [$kd_branch, $kdcl, $kd_biodata, (string) $cb_test_type, $progress_check_2, $note_score, $tgl_test, $tgl_hari_ini, $nama_lengkap];
	}
	else
	{		$rumus =5;
	$sql = $sql_score_class; $params = $params_score_class;
	}

	db_exec($sql, $params);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VIP Score Submitted');\n";
	echo "if (window.opener) { window.opener.location.reload(true); }\n";
	echo "window.close(); \n";
	echo "</script>";
	}
?>