<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');

$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
//get data stu
$query_student = q_set($__p_query_student, "SELECT t.kd_biodata, t.nama, t.middle_name, t.family_name, t.address, t.city FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($kdb)]);

$resource_student= db_query_or_die('errro_8', $query_student, $__p_query_student ?? []);
$keluar_student= db_num_rows($resource_student);
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
		{
		$kd_biodata= $row_student[0];				
		$nama= $row_student[1];		
		$middle_name = $row_student[2];
		$family_name = $row_student[3];
		$address = $row_student[4];
		$city = $row_student[5];
			
		$student_name ="$nama $middle_name $family_name";
		
		}
	}



?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista Customer System Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="bootstrap/js/sign.js"></script>
<script>
    $(document).ready(function()
    {
        $('#myCanvas').sign({
            resetButton: $('#resetSign'), 
            lineWidth: 5 
        });
    });
</script>

  <style>
        #myCanvas {
            border:4px solid #b22222;
            border-radius: 25px;
        }
    </style>
</head>


  <!-- Left side column. contains the logo and sidebar -->
  
<?php //  include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3>VISTA - E-Sign</h3>
	<h5>Code : <?php echo e($idb) ?></h5>
</div>
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

<form name="myform" id="myform">

    <div class="col-md-12">
<div class="box box-warning">
<div class="box-body"><span class="form-group">
  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
</span>
  <div class="col-md-4">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>" readonly>
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="hidden" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="st" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
  </span><span class="form-group">
  <input type="hidden" ang="en-150"   name="idb" 
                 	      value="<?php echo e($idb) ?>" >
  </span></div>
	  </div>
<div class="box box-warning">
  <div class="box-body"><span class="form-group">
    <input type="text" ang="en-150"  name="kdcbg2"  value="<?php echo e($kdcbg) ?>" hidden="hidden">
    </span>
    <div class="col-md-4">
      <div class="form-group">
        <label>Address</label>
        <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name2" 
                 	      value="<?php echo e($address) ?>" readonly>
      </div>
    </div>
    <span class="form-group">
      <input type="hidden" ang="en-150" name="kdb2" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
      <input type="hidden" ang="en-150"   name="enroll_date2" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
      </span><span class="form-group">
        <input type="text" ang="en-150"   name="st2" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
        </span><span class="form-group">
          <input type="hidden" ang="en-150"   name="idb2" 
                 	      value="<?php echo e($idb) ?>" >
        </span></div>
</div>
<div class="box box-warning">
  <div class="box-body"><span class="form-group">
    <input type="text" ang="en-150"  name="kdcbg3" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
    </span>
    <div class="col-md-8">
    <canvas id="myCanvas"></canvas>
    <input type="button" value="Reset" id='resetSign'>
    </div>
    <div class="col-md-8">
		      <div class="col-md-2">
		        <div class="form-group">
		          <label></label>
		          <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />
	            </div>
	          </div>
    </div>
    <span class="form-group">
      <input type="hidden" ang="en-150" name="kdb3" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
      <input type="hidden" ang="en-150"   name="enroll_date3" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
      </span><span class="form-group">
        <input type="text" ang="en-150"   name="st3" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
        </span><span class="form-group">
          <input type="hidden" ang="en-150"   name="idb3" 
                 	      value="<?php echo e($idb) ?>" >
        </span></div>
</div>
<div class="box box-warning">
	  <div class="box-body">
		    <div class="row"></a></div>

	  </div>
	  </div>
  </div>
<div class="box-body"></div>
<div class="box-body"></div>
</form>
</body>
</html>
<?php 
if (isset($_GET['Save'])) 
	{
	$canpas = in_val('canvas', 'get');
	echo e($canpas);
	}
?>