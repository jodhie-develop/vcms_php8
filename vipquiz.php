<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kd_staff = $_SESSION['kd_staff']; 
$posisi = $_SESSION['posisi']; 
if ($kd_staff =="")
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Anda tidak diperkenankan mengisi quistionaire ini');\n";
	echo "window.location = ('dashboard.php');\n";						
	echo "</script>";		
	}
//include __DIR__ . "/atas.php";
//=====cek====.
if ($nama_lengkap !="")
{
$query_cek_quiz = q_set($__p_query_cek_quiz, "SELECT * FROM tb_quiz where pic = ? and kd_quiz = '1'", [(string) ($nama_lengkap)]);
$resource_cek_quiz = db_query_soft($query_cek_quiz, $__p_query_cek_quiz ?? []);
$keluar_cek_quiz  = db_num_rows($resource_cek_quiz);	
if(num(db_num_rows($resource_cek_quiz)) > 0)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($nama_lengkap) . " sudah pernah mengisi quis ini, sehingga tidak diperkenankan untuk mengisi kembali');\n";
	echo "window.location = ('dashboard.php');\n";						
	echo "</script>";
	}
}
else
{
		echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($nama_lengkap) . " sudah pernah mengisi quis ini, sehingga tidak diperkenankan untuk mengisi kembali');\n";
	echo "window.close();\n";				
	echo "</script>";
}
//

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
	    <link rel="stylesheet" href="../vcms/bootstrap/css/bootstrap.min.css"></link>
    <script src="../vcms/cdnjs/jquery.min.js"></script>
    <script src="../vcms/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vcms/bootstrap/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="../vcms/bootstrap/css/bootstrap-datepicker.css"></link>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>


  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>VIP ENGLISH QUIZ</h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php  //    include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
    <div class="box-body">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>1.	Mention VIP English main programs</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <label>A.</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" rows="3" required>
    </div>
  </div>
<div class="col-md-12">
    <div class="form-group">
      <label>B.</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>  
</div>
<div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>2.	Mention VIP English additional programs to support the main courses</label>
    </div>
</div>
  <div class="col-md-12">
    <div class="form-group">
      <label>A.</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label>B.</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
<div class="col-md-12">
  <div class="form-group">
    <label>C.</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
  </div>
</div>
<div class="col-md-12">
  <div class="form-group">
    <label>D.</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
  </div>
</div>  
</div>
		</div>
<div class="box box-warning">
  <div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>3.	What do you know about IELTS™?</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
</div>
</div>

<div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>4.	What are the differences between IELTS™ and TOEFL® iBT?</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
</div>
</div>

    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>5.	What are the selling points of VIP English IELTS™ and Ibt programs? Elaborate!</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
</div>
</div>
    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>6.	What’s VIP English method of teaching? Or what will the classes like?</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
</div>
</div>
    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>7.	What is the evaluation or assessment used in exam preparation programs?</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <label>A. IELTS™</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
<div class="col-md-12">
    <div class="form-group">
      <label>B. IBT®</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
<div class="col-md-12">
  <div class="form-group">
    <label>C. PBT®:</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
  </div>
</div>  
</div>
</div>

    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>8.	What is the evaluation or assessment used in GE, BE, AE?</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <label>A. GE</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
<div class="col-md-12">
    <div class="form-group">
      <label>B. BE</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
<div class="col-md-12">
  <div class="form-group">
    <label>C. AE</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
  </div>
</div>  
</div>
</div>

    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>9.	What is the evaluation or assessment used in conversation classes?</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
</div>
</div>

    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>10. What are the differences between VIP English and other language courses?</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
</div>
</div>

    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>11. Why don’t we use native speakers of English? </label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
</div>
</div>

<div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>12. What should we do to have more VIP English students?</label>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <label>A. Academic side</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>
<div class="col-md-12">
    <div class="form-group">
      <label>B. Sales and marketing side</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Write your answer here..." name="jawaban[]" 
                 	      value="<?php echo e($jawaban[$i]) ?>" required>
    </div>
  </div>  
</div>
</div>
<input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
	$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$nama_lengkap = $_SESSION['nama_lengkap'];
$kd_staff = $_SESSION['kd_staff'];	
$jawaban = in_val('jawaban', 'any');
	$i=0;
foreach( $jawaban as $key => $n ) {
	if(num($key)==0){$kd_soal = "1a"; }
	if(num($key)==1){$kd_soal = "1b"; }
	if(num($key)==2){$kd_soal = "2a"; }
	if(num($key)==3){$kd_soal = "2b"; }
	if(num($key)==4){$kd_soal = "2c"; }
	if(num($key)==5){$kd_soal = "2d"; }
	if(num($key)==6){$kd_soal = "3"; }
	if(num($key)==7){$kd_soal = "4"; }
	if(num($key)==8){$kd_soal = "5"; }
	if(num($key)==9){$kd_soal = "6"; }
	if(num($key)==10){$kd_soal = "7a"; }
	if(num($key)==11){$kd_soal = "7b"; }
	if(num($key)==12){$kd_soal = "7c"; }
	if(num($key)==13){$kd_soal = "8a"; }
	if(num($key)==14){$kd_soal = "8b"; }
	if(num($key)==15){$kd_soal = "8c"; }
	if(num($key)==16){$kd_soal = "9"; }
	if(num($key)==17){$kd_soal = "10"; }
	if(num($key)==18){$kd_soal = "11"; }
	if(num($key)==19){$kd_soal = "12a"; }
	if(num($key)==20){$kd_soal = "12b"; }
//  print "The name is ".$n." and email is ".$jawaban[$key].", thank you\n";
$query_simpan = q_set($__p_query_simpan, "insert into tb_quiz (kd_quiz, kd_soal,jawaban, pic, dt_entry,kd_staff) values ('1',? ,? ,? ,? ,? )", [(string) ($kd_soal), (string) ($jawaban[$key]), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($kd_staff)]);
$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);	
		echo "<script type=\"text/javascript\">\n";
	echo "alert('Quistionaire has been submit, thank you " . e($nama_lengkap) . "');\n";
	echo "window.location = ('dashboard.php');\n";				
	echo "</script>";	
}
//$numbers = array();
//$array_size = 10;

// for loop runs as long as 2nd condition evaluates to true
//for ($i=0;$i<$array_size;$i++) { 

	
	
}
?>
