<?php
// Popup ubah skor. Form dikirim POST + token CSRF; parameter awal tetap dari link GET.
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
$pt = in_str('pt', 3);
$query_score = '';
$cb_test_type = $nama = $note_score = $tgl_test = '';
$progress_check_1 = $progress_check_2 = $progress_overall = '';
$l = $st = $sp = $r = $w = $ttl = '';

if ($pt == 1)
{
$nmr_test = in_int('no', 0);
$query_score= "select kd_biodata,jns_test,L,S,R,W,other,total,remark, test_date from ves_data.vip_class_score_profile where no = ?";
}
elseif ($pc == 1 or $pc == 2 or $pc == 3)
{
$nmr_test = in_int('nmr_test', 0);
$row_score_fdst = db_row("SELECT t.progress_check_1, t.progress_check_2, t.progress_overall,remark, test_date, t.no FROM ves_data.vip_class_score_profile t where no = ?", [$nmr_test], PDO::FETCH_NUM);
if ($row_score_fdst !== null)
	{
		$progress_check_1 = $row_score_fdst[0];
		$progress_check_2 = $row_score_fdst[1];
		$progress_overall = $row_score_fdst[2];
		$note_score = $row_score_fdst[3];
		$tgl_test = $row_score_fdst[4];
	}
}
else
{
$nmr_test = in_int('no', 0);
$query_score= "select kd_biodata,jns_test,L,S,R,W,other,total,remark, test_date from ves_data.vip_class_score_profile where no = ?";
}
if ($query_score !='')
{
$resource_score = db_query($query_score, [$nmr_test]);
	while ($row_score = $resource_score->fetch(PDO::FETCH_NUM))
		{
		$kode_student = $row_score[0];
		$t = $row_score[1];
		$l = $row_score[2];
		$sp = $row_score[3];
		$r = $row_score[4];
		$w = $row_score[5];
		$st = $row_score[6];
		$ttl = $row_score[7];
		$note_score = $row_score[8];
		$tgl_test = $row_score[9];
		}
}
if ($pt ==1){$t=1;}
if($t == 1) {$cb_test_type = "Placement Test";}
elseif($t == 2 or $t ==21) {$cb_test_type = "Middle Test";}
elseif($t == 3 or $t==31) {$cb_test_type = "Final Test";}
elseif($pc == 1) {$cb_test_type = "Progress Check 1";}
elseif($pc == 2) {$cb_test_type = "Progress Check 2";}
elseif($pc == 3) {$cb_test_type = "Progress Overall";}

$row_detail = db_row("SELECT t.nama_lengkap FROM ves_data.vip_student_data t where t.kd_biodata = ?", [$kode_student], PDO::FETCH_NUM);
if ($row_detail !== null)
	{
		$nama = $row_detail[0];
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
      VIP Score Test - <?php echo e($nama) ?> <br>

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
                 	      value="<?php echo e($tgl_test) ?>">
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
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="nmr_test" 
                 	      value="<?php echo e($nmr_test) ?>" hidden= "hidden">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="pt" 
                 	      value="<?php echo e($pt) ?>" hidden= "hidden">
  </span></div>    
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>Note</label><input type="institution" ang="en-150" class="form-control"  placeholder="Enter ..." name="note_score" 
                 	      value="<?php echo e($note_score) ?>">
    </div>
  </div>
</div>  
<?php if ($pc == 1 or $pc == 2 or $pc == 3  )
{ ?>	
<div class="box-body">
<?php if ($pc == 1 )
{ ?>	
  <div class="col-md-2">
    <div class="form-group">
      <label>Progress Check 1</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="progress_check_11" 
                 	      value="<?php echo e($progress_check_1) ?>">
    </div>
  </div>
<?php } elseif ($pc == 2)
{ ?>	
  <div class="col-md-2">
    <div class="form-group">
      <label>Progress Check 2</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="progress_check_12" 
                 	      value="<?php echo e($progress_check_2) ?>">
    </div>
  </div>
<?php } elseif ($pc ==3)
{ ?>		
  <div class="col-md-2">
    <div class="form-group">
      <label>Progress Overall</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="progress_overalll" 
                 	      value="<?php echo e($progress_overall) ?>">
    </div>
  </div>
<?php } ?>	
</div>
		
<?php } else { ?>
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
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
	$listening_score = in_str('l', 45, 'post');
	$other_score = in_str('st', 45, 'post');
	$speaking_score = in_str('sp', 45, 'post');
	$reading_score = in_str('r', 45, 'post');
	$writing_score = in_str('w', 45, 'post');
	$total_score = in_str('ttl', 45, 'post');
	$note_score = in_str('note_score', 5000, 'post');
	$tgl_test = in_date('tgl_test', '', 'post');
	$cb_test_type = in_str('cb_test_type', 45, 'post');
$nmr_test = in_int('nmr_test', 0, 'post');
		$t = in_str('t', 3, 'post');
		$pc = in_str('pc', 3, 'post');
		// Versi lama membaca nama field yang tidak ada di form (progress_check_11/12, progress_overalll),
		// sehingga nilai progress selalu tersimpan kosong. Dipertahankan; lihat laporan batch 6.
		$progress_check_1 = in_str('progress_check_11', 20, 'post');
		$progress_check_2 = in_str('progress_check_12', 20, 'post');
		$progress_overall = in_str('progress_overalll', 20, 'post');
$nama_lengkap = $_SESSION['nama_lengkap'];
		if ($cb_test_type == 'Placement Test') {$cb_test_type = 1;}
		elseif ($cb_test_type == 'Middle Test'){$cb_test_type = 2;}
		elseif ($cb_test_type == 'Final Test'){$cb_test_type = 3;}
		elseif ($cb_test_type == 'Progress Check 1'){$cb_test_type = 4;}
		elseif ($cb_test_type == 'Progress Check 2'){$cb_test_type = 5;}
		elseif ($cb_test_type == 'Progress Overall'){$cb_test_type = 6;}
// (Versi lama juga menyiapkan query khusus untuk $cb_test_type == 2, tetapi selalu
//  ditimpa oleh rangkaian if/elseif/else di bawah, jadi tidak dibawa.)
$skor_lengkap = [$listening_score, $speaking_score, $reading_score, $writing_score, $other_score, $total_score, $note_score, $tgl_test, $tgl_hari_ini, $nama_lengkap, $nmr_test];
if ($pt ==2 or $pt ==3)
{
	$sql = "update ves_data.vip_class_score_profile set L = ?, S = ?, R = ?, W = ?, other = ?, total = ?, remark = ?, test_date = ?, dt_entry = ?, pic = ? where no = ?";
	$params = $skor_lengkap;
}
elseif ($pc == 1)
{
	$sql = "update ves_data.vip_class_score_profile set progress_check_1 = ?, test_date = ?, dt_entry = ?, pic = ? where no = ?";
	$params = [$progress_check_1, $tgl_test, $tgl_hari_ini, $nama_lengkap, $nmr_test];
}
elseif ($pc == 2)
{
	$sql = "update ves_data.vip_class_score_profile set progress_check_2 = ?, test_date = ?, dt_entry = ?, pic = ? where no = ?";
	$params = [$progress_check_2, $tgl_test, $tgl_hari_ini, $nama_lengkap, $nmr_test];
}
elseif ($pc == 3)
{
	$sql = "update ves_data.vip_class_score_profile set progress_overall = ?, test_date = ?, dt_entry = ?, pic = ? where no = ?";
	$params = [$progress_overall, $tgl_test, $tgl_hari_ini, $nama_lengkap, $nmr_test];
}
else
{
	$sql = "update ves_data.vip_class_score_profile set L = ?, S = ?, R = ?, W = ?, other = ?, total = ?, catatan = ?, test_date = ? where no = ?";
	$params = [$listening_score, $speaking_score, $reading_score, $writing_score, $other_score, $total_score, $note_score, $tgl_test, $nmr_test];
}

	db_exec($sql, $params);

	echo "<script type=\"text/javascript\">\n";
	echo "alert('VIP Score Updated');\n";
	echo "if (window.opener) { window.opener.location.reload(true); }\n";
	echo "window.close(); \n";
	echo "</script>";
	}
?>