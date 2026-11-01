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
$no = in_val('no', 'any');
$kd_branch = $_SESSION['kd_branch'];
$kode_student = in_val('kdb', 'any');
$kdcl = in_val('kdcl', 'any');
$t = in_val('t', 'any');
$pc = in_val('pc', 'any');
$_GET['pc'] = $pc;
if(num($t) == 1) {$cb_test_type = "Placement Test";}
elseif(num($t) == 2 or num($t) ==21) {$cb_test_type = "Middle Test";}
elseif(num($t) == 3 or num($t)==31) {$cb_test_type = "Final Test";}
elseif(num($pc) == 1) {$cb_test_type = "Progress Check 1";}
elseif(num($pc) == 2) {$cb_test_type = "Progress Check 2";}
elseif(num($pc) == 3) {$cb_test_type = "Progress Check Overall";}
$query_detail = q_set($__p_query_detail, "SELECT t.nama, t.middle_name, t.family_name  \r
FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($kode_student)]);

$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar_detail = db_num_rows($resource_detail);
if(num(db_num_rows($resource_detail)) > 0)
	{
	while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
		{
		$nama = $row_detail[0];
		$middle_name = $row_detail[1];
		$family_name = $row_detail[2];
		}
	}
$test_kategori = in_val('test_kategori', 'any');
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
      <h1>
      CA Score Test - <?php echo e($nama) . " " . e($middle_name) . " " . e($family_name) ?> <br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Test Category</label>
      <select name="test_kategori"  id="cb_test_type" class="form-control"  onChange="this.form.submit()" >
        <option>WSC</option>
        <option>MUN</option>
        <option selected><?php echo e($test_kategori) ?></option>
      </select>
    </div>
  </div>
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
      <input type="date" ang="en-150" class="form-control"  placeholder="" name="tgl_test" 
                 	      value="<?php echo e($tgl_hari_ini)  ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="" name="kode_student" 
                 	      value="<?php echo e($kode_student) ?>" hidden= "hidden">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="" name="kdcl" 
                 	      value="<?php echo e($kdcl) ?>" hidden= "hidden">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="" name="t" 
                 	      value="<?php echo e($t) ?>" hidden= "hidden">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="" name="pc" 
                 	      value="<?php echo e($pc) ?>" hidden= "hidden">	
  </span></div>    
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>Note</label><input type="institution" ang="en-150" class="form-control"  placeholder="" name="note_score" 
                 	      value="<?php echo e($note_score) ?>">
    </div>
  </div>
</div> 

<?php if ($test_kategori =='WSC')
{?>
<div class="box-body">
  <div class="col-md-2">
    <div class="form-group">
      <label>Clarity</label><input type="number" ang="en-150" class="form-control"  placeholder="" name="l" 
                 	      value="<?php echo e($Clarity) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Content</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="st" 
                 	      value="<?php echo e($WContent) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Style</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="sp" 
                 	      value="<?php echo e($Style) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Originality</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="r" 
                 	      value="<?php echo e($Originality) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>TOTAL</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="ttl" 
                 	      value="<?php echo e($wttl) ?>">
    </div>
</div>
</div>
<div class="box-body">
  <div class="col-md-2">
    <div class="form-group">
      <label>Presentation</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="l2" 
                 	      value="<?php echo e($Presentation) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Strategy</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="st2" 
                 	      value="<?php echo e($Strategy) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Content</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="sp2" 
                 	      value="<?php echo e($DContent) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Teamwork</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="r2" 
                 	      value="<?php echo e($Teamwork) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>FeedBack</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="w2" 
                 	      value="<?php echo e($FeedBack) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>TOTAL</label>
      <input type="number" ang="en-150" class="form-control"  placeholder="" name="ttl2" 
                 	      value="<?php echo e($Dttl) ?>">
    </div>
  </div>
</div>
<?php } ?>
<div class="box-body"></div></form><input type="submit" name="Submit" value="Submit" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";		
	$kd_biodata	 = in_val('kode_student', 'any');

	$note_score = in_val('note_score', 'any');
	$tgl_test = in_val('tgl_test', 'any');
	$cb_test_type = in_val('cb_test_type', 'any');
	$note_score = in_val('note_score', 'any');
		$t = in_val('t', 'any');
		$pc = in_val('pc', 'any');

$nama_lengkap = $_SESSION['nama_lengkap']; 
$no = in_val('no', 'any');
$kd_branch = $_SESSION['kd_branch'];
	
		$kdcl = in_val('kdcl', 'any');
$Clarity = in_val('Clarity', 'any');
$WContent = in_val('WContent', 'any');
$Style = in_val('Style', 'any');
$Originality = in_val('Originality', 'any');
$Wttl = in_val('Wttl', 'any');
$Presentation = in_val('Presentation', 'any');
$Strategy = in_val('Strategy', 'any');
$DContent = in_val('DContent', 'any');
$Teamwork = in_val('Teamwork', 'any');
$FeedBack = in_val('FeedBack', 'any');
$Dttl	 = in_val('Dttl', 'any');
		if ($cb_test_type == 'Placement Test') {$cb_test_type = 1;}
		elseif ($cb_test_type == 'Middle Test'){$cb_test_type = 2;}
		elseif ($cb_test_type == 'Final Test'){$cb_test_type = 3;}


	$query_simpan_score_class = q_set($__p_query_simpan_score_class, "insert into ves_data.vip_class_score_profile ( kd_cbg, class_code, kd_biodata,jns_test,L,S,R,W,other,total,remark, test_date,dt_entry,pic) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ) ", [(string) ($kd_branch), (string) ($kdcl), (string) ($kd_biodata), (string) ($cb_test_type), (string) ($listening_score), (string) ($speaking_score), (string) ($reading_score), (string) ($writing_score), (string) ($other_score), (string) ($total_score), (string) ($note_score), (string) ($tgl_test), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);
	

	$resource_simpan_score_class = db_query_or_die('errro_simpan2', $query_simpan_score_class, $__p_query_simpan_score_class ?? []);	 
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VIP Score Submitted');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";		
	}
?>