<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$kd = in_val('kd', 'any');
$nama_lengkap = $_SESSION['nama_lengkap']; 
$posisi = $_SESSION['posisi']; 
if ($nama_lengkap != "alexandria" and $nama_lengkap != "jodhie harjanto")
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($nama_lengkap) . "  tidak diperkenankan me review quistionaire ini');\n";
	echo "window.location = ('dashboard.php');\n";						
	echo "</script>";		
	}
$i=0;
$query= q_set($__p_query, "SELECT jawaban, spv_comment, spv_score FROM ves_data.tb_quiz where kd_staff = ? order by no", [(string) ($kd)]);
$resource = db_query_soft($query, $__p_query ?? []);
while ($row = db_fetch($resource)) 
	{
    $jwbn = $row['0'];
    $comment = $row['1'];
    $score = $row['2'];		
if(num($i)==0){$jawaban1a = $jwbn;$comment1a = $comment;$score1a=$score;}
if(num($i)==1){$jawaban1b = $jwbn;$comment1b = $comment;$score1b=$score;}
if(num($i)==2){$jawaban2a = $jwbn;$comment2a = $comment;$score2a=$score;}
if(num($i)==3){$jawaban2b = $jwbn;$comment2b = $comment;$score2b=$score;}
if(num($i)==4){$jawaban2c = $jwbn;$comment2c = $comment;$score2c=$score;}
if(num($i)==5){$jawaban2d = $jwbn;$comment2d = $comment;$score2d=$score;}
if(num($i)==6){$jawaban3 = $jwbn;$comment3 = $comment;$score3=$score;}
if(num($i)==7){$jawaban4 = $jwbn;$comment4 = $comment;$score4=$score;}
if(num($i)==8){$jawaban5 = $jwbn;$comment5 = $comment;$score5=$score;}
if(num($i)==9){$jawaban6 = $jwbn;$comment6 = $comment;$score6=$score;}
if(num($i)==10){$jawaban7a = $jwbn;$comment7a = $comment;$score7a=$score;}
if(num($i)==11){$jawaban7b = $jwbn;$comment7b = $comment;$score7b=$score;}
if(num($i)==12){$jawaban7c = $jwbn;$comment7c = $comment;$score7c=$score;}
if(num($i)==13){$jawaban8a = $jwbn;$comment8a = $comment;$score8a=$score;}
if(num($i)==14){$jawaban8b = $jwbn;$comment8b = $comment;$score8b=$score;}
if(num($i)==15){$jawaban8c = $jwbn;$comment8c = $comment;$score8c=$score;}
if(num($i)==16){$jawaban9 = $jwbn;$comment9 = $comment;$score9=$score;}
if(num($i)==17){$jawaban10 = $jwbn;$comment10 = $comment;$score10=$score;}
if(num($i)==18){$jawaban11 = $jwbn;$comment11 = $comment;$score11=$score;}
if(num($i)==19){$jawaban12a = $jwbn;$comment12a = $comment;$score12a=$score;}
if(num($i)==20){$jawaban12b = $jwbn;$comment12b = $comment;$score12b=$score;}

	$i++;
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
      <h1>VIP ENGLISH QUIZ
        
      </h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
   <input type="text" name="kds" id="kds" value="<?php echo e($kd)  ?>" hidden>
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
		<a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=1a" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=1a','popup','width=1000,height=300'); return false;"><label>A.</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban1a" 
                 	      value="<?php echo e($jawaban1a) ?>" rows="3" disabled>
<div class="col-md-10">
  <div class="form-group">
    <label>Supervisor Comment</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment1a) ?>" rows="3">
  </div>
</div>
 <div class="col-md-2">
  <div class="form-group">
    <label>Supervisor Score</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score1a) ?>" rows="3" >
  </div>
</div>                  	      
    </div>
  </div>

<div class="col-md-12">
    <div class="form-group">
		<a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=1b" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=1b','popup','width=1000,height=300'); return false;"><label>B.</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban1b" 
                 	      value="<?php echo e($jawaban1b) ?>" disabled>
<div class="col-md-10">
  <div class="form-group">
    <label>Supervisor Comment</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment1b) ?>" rows="3">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>Supervisor Score</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score1b) ?>" rows="3" >
  </div>
</div>                 	      
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
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=2a" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=2a','popup','width=1000,height=300'); return false;"><label>A.</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban2a" 
                 	      value="<?php echo e($jawaban2a) ?>" disabled>
  <div class="col-md-10">
    <div class="form-group">
      <label>Supervisor Comment</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment2a) ?>" rows="3">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Supervisor Score</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score2a) ?>" rows="3" >
    </div>
  </div>                 	      
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=2b" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=2b','popup','width=1000,height=300'); return false;"><label>B.</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban2b) ?>" disabled>
  <div class="col-md-10">
    <div class="form-group">
      <label>Supervisor Comment</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment2b) ?>" rows="3">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Supervisor Score</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score2b) ?>" rows="3" >
    </div>
  </div>                 	      
    </div>
</div>

<div class="col-md-12">
  <div class="form-group">
    <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=2c" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=2c','popup','width=1000,height=300'); return false;"><label>C.</label></a>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban2c) ?>" disabled>
<div class="col-md-10">
  <div class="form-group">
    <label>Supervisor Comment</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment2c) ?>" rows="3">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>Supervisor Score</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score2c) ?>" rows="3" >
  </div>
</div>                 	      
  </div>
</div>

<div class="col-md-12">
  <div class="form-group">
    <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=2d" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=2d','popup','width=1000,height=300'); return false;"><label>D.</label></a>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban2d) ?>" disabled>
<div class="col-md-10">
  <div class="form-group">
    <label>Supervisor Comment</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment2d) ?>" rows="3">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>Supervisor Score</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score2d) ?>" rows="3" >
  </div>
</div>                  	      
  </div>
</div>
 
</div>
		</div>
<div class="box box-warning">
  <div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=3" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=3','popup','width=1000,height=300'); return false;"><label>3.	What do you know about IELTS™?</label></a>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban3) ?>" disabled>
<div class="col-md-10">
  <div class="form-group">
    <label>Supervisor Comment</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment3) ?>" rows="3">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>Supervisor Score</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score3) ?>" rows="3" >
  </div>
</div>                 	      
    </div>
  </div>

  </div>
</div>

<div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=4" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=4','popup','width=1000,height=300'); return false;"><label>4.	What are the differences between IELTS™ and TOEFL® iBT?</label></a>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban4) ?>" disabled>
<div class="col-md-10">
  <div class="form-group">
    <label>Supervisor Comment</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment4) ?>" rows="3">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>Supervisor Score</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score4) ?>" rows="3" >
  </div>
</div>                 	      
    </div>
  </div>

</div>
</div>

    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=5" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=5','popup','width=1000,height=300'); return false;"><label>5.	What are the selling points of VIP English IELTS™ and Ibt programs? Elaborate!</label></a>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban5) ?>" disabled>
<div class="col-md-10">
  <div class="form-group">
    <label>Supervisor Comment</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]9" 
                 	      value="<?php echo e($comment5) ?>" rows="3">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>Supervisor Score</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score5) ?>" rows="3" >
  </div>
</div>                 	      
    </div>
  </div>

</div>
</div>
    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=6" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=6','popup','width=1000,height=300'); return false;"><label>6.	What’s VIP English method of teaching? Or what will the classes like?</label></a>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban6) ?>" disabled>
<div class="col-md-10">
  <div class="form-group">
    <label>Supervisor Comment</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment6) ?>" rows="3">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>Supervisor Score</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score6) ?>" rows="3" >
  </div>
</div>                 	      
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
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=7a" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=7a','popup','width=1000,height=300'); return false;"><label>A. IELTS™</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban7a) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment7a) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score7a) ?>" rows="3" >
        </div>
      </div>
    </div>
  </div>
<div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=7b" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=7b','popup','width=1000,height=300'); return false;"><label>B. IBT®</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban7b) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment7b) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score7b) ?>" rows="3" >
        </div>
      </div>                 	      
    </div>
  </div>
<div class="col-md-12">
  <div class="form-group">
    <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=7c" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=7c','popup','width=1000,height=300'); return false;"><label>C. PBT®:</label></a>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban7c) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment7c) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score7c) ?>" rows="3" >
        </div>
      </div>                 	      
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
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=8a" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=8a','popup','width=1000,height=300'); return false;"><label>A. GE</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban8a) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment8a) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score8a) ?>" rows="3" >
        </div>
      </div>                 	      
    </div>
  </div>
<div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=8b" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=8b','popup','width=1000,height=300'); return false;"><label>B. BE</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban8b) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment8b) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score8b) ?>" rows="3" >
        </div>
      </div>                 	      
    </div>
  </div>
<div class="col-md-12">
  <div class="form-group">
    <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=8c" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=8c','popup','width=1000,height=300'); return false;"><label>C. AE</label></a>
    <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban8c) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment8c) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score8c) ?>" rows="3" >
        </div>
      </div>                 	      
  </div>
</div>  
</div>
</div>

    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=9" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=9','popup','width=1000,height=300'); return false;"><label>9.	What is the evaluation or assessment used in conversation classes?</label></a>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban9) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment9) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score9) ?>" rows="3" >
        </div>
      </div>                 	      
    </div>
  </div>
</div>
</div>

    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=10" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=10','popup','width=1000,height=300'); return false;"><label>10. What are the differences between VIP English and other language courses?</label></a>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban10) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment10) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score10) ?>" rows="3" >
        </div>
      </div>                 	      
    </div>
  </div>
</div>
</div>

    <div class="box box-warning">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=11" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=11','popup','width=1000,height=300'); return false;"><label>11. Why don’t we use native speakers of English? </label></a>
    </div>
</div>  
<div class="col-md-12">
    <div class="form-group">
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban11) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment11) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score11) ?>" rows="3" >
        </div>
      </div>                 	      
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
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=12a" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=12a','popup','width=1000,height=300'); return false;"><label>A. Academic side</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban12a) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment12a) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score12a) ?>" rows="3" >
        </div>
      </div>                 	      
    </div>
  </div>
<div class="col-md-12">
    <div class="form-group">
      <a href="quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=12b" 
target="popup" 
onclick="window.open('quizupdate.php?kd=<?php echo e(u($kd)) ?>&soal=12b','popup','width=1000,height=300'); return false;"><label>B. Sales and marketing side</label></a>
      <input type="text" ang="en-150" class="form-control"  placeholder="" name="jawaban[]" 
                 	      value="<?php echo e($jawaban12b) ?>" disabled>
      <div class="col-md-10">
        <div class="form-group">
          <label>Supervisor Comment</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="comment[]" 
                 	      value="<?php echo e($comment12b) ?>" rows="3">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Supervisor Score</label>
          <input type="text" ang="en-150" class="form-control"  placeholder="" name="score[]" 
                 	      value="<?php echo e($score12b) ?>" rows="3" >
        </div>
      </div>                 	      
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
	$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$nama_lengkap = $_SESSION['nama_lengkap'];
$kds = in_val('kds', 'any');	
$comment = in_val('comment', 'any');
$score = in_val('score', 'any');
$i=0;
foreach( $comment as $key => $n ) 
{
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
$query_simpan = q_set($__p_query_simpan, "update ves_data.tb_quiz set spv_comment = ? ,spv_score = ? ,dt_score = ? where kd_soal = ? and kd_staff = ? ", [(string) ($comment[$key]), (string) ($score[$key]), (string) ($hari_ini), (string) ($kd_soal), (string) ($kds)]);
$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);	
		echo "<script type=\"text/javascript\">\n";
	echo "alert('Quistionaire has been submit, thank you " . e($nama_lengkap) . "');\n";
	echo "window.location = ('quizlist.php');\n";				
	echo "</script>";
}	
}

?>
