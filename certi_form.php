<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$tahun=date("Y");
$_POST['tgl_hari_ini'] =  "$tahun-$bulan-$hari";
$date_generate = in_val('tgl_hari_ini', 'post');

$kdb = in_val('kdb', 'get');
$_POST['kdb'] = $kdb;
$kdc = in_val('kdc', 'get');
$_POST['kdc'] = $kdc;
$query_certificate = q_set($__p_query_certificate, "SELECT  nm_program, start_date, end_date, cetak_date, kelas, nama_student,kd_class FROM ves_data.ve_certificate a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kelas = b.kd_class  where a.kd_biodata = ? and kelas = ? ", [(string) ($kdb), (string) ($kdc)]);	

$resource_certificate = db_query_or_die('errro_simpan1', $query_certificate, $__p_query_certificate ?? []);	
if(num(db_num_rows($resource_certificate)) > 0)
	{
	while ($row_certificate  =  db_fetch($resource_certificate, PDO::FETCH_NUM))	
		{
		$student_name = $row_certificate[5];
		$kdc = $row_certificate[4];
		$start_class = $row_certificate[1];
		$end_class = $row_certificate[2];
		$date_generate = $row_certificate[3];
		$nm_program = $row_certificate[0];	
		$kd_billing = $row_certificate[6];
		$_POST['kd_billing'] = $kd_billing;
		}
	}	
else
{
	$query_nama = q_set($__p_query_nama, "SELECT nama_lengkap FROM ves_data.vip_student_data where kd_biodata = ? ", [(string) ($kdb)]);	
$resource_nama = db_query_or_die('errro_simpan', $query_nama, $__p_query_nama ?? []);	
if(num(db_num_rows($resource_nama)) > 0)
	{
	while ($row_nama  =  db_fetch($resource_nama, PDO::FETCH_NUM))	
		{
		$student_name = $row_nama[0];
		}
	}
	$query_nama = q_set($__p_query_nama, "SELECT kd_billing FROM ves_data.vip_billing where kd_biodata = ? and kd_class = ? ", [(string) ($kdb), (string) ($kdc)]);	
$resource_nama = db_query_or_die('errro_simpan', $query_nama, $__p_query_nama ?? []);	
if(num(db_num_rows($resource_nama)) > 0)
	{
	while ($row_nama  =  db_fetch($resource_nama, PDO::FETCH_NUM))	
		{
		$kd_billing = $row_nama[0];
		$_POST['kd_billing'] = $kd_billing;
		}
	}	
$query_period = q_set($__p_query_period, "SELECT date_format(min(mulai_tm),'%Y-%m-%d'), date_format(max(mulai_tm),'%Y-%m-%d') FROM ves_data.vip_teacher_schedule where kelas = ? and status_kelas = 1", [(string) ($kdc)]);	

$resource_period = db_query_or_die('errro_simpan', $query_period, $__p_query_period ?? []);	
if(num(db_num_rows($resource_period)) > 0)
	{
	while ($row_period  =  db_fetch($resource_period, PDO::FETCH_NUM))	
		{
		$start_class = $row_period[0];
		$end_class = $row_period[1];
		}
	}
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Editors</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->

  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">	
  <!-- Ionicons -->

  <link rel="stylesheet" href="cdnjs/ionicons.min.css">	
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">



  <!-- Left side column. contains the logo and sidebar -->
<?php //  include __DIR__ . "/left.php";	 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h4>E-Certificate Generator</h4></div>
     </div>
    </section>
<form name="#" id="myform" method="POST" action="#"><?php echo csrf_field(); ?>

    <!-- Main content -->
    <section class="content">	
      <div class="row">
        <div class="box box-warning">
          <div class="box-body"><span class="form-group">
            <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
            </span>
            <div class="col-md-6">
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
            </span>
            <div class="col-md-4">
              <div class="form-group">
                <label>Class Code</label>
                <input name="kdc"  class="form-control"  type="text" size="90" value="<?php echo e($kdc) ?>" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Start Class</label>
                <input name="start_class"  class="form-control"  type="date" size="90" value="<?php echo e($start_class) ?>" />
              </div>
            </div>
            <span class="form-group">
              <input type="text" ang="en-150"   name="st" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
            </span>
            <div class="col-md-4">
              <div class="form-group">
                <label>End Class</label>
                <input name="end_class"  class="form-control"  type="date" size="90" value="<?php echo e($end_class) ?>" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Date Generate</label>
                <input name="date_generate"  class="form-control"  type="date" size="90" value="<?php echo e($date_generate) ?>" />
              </div>
            </div>
            <span class="form-group">            </span><span class="form-group">
                <input type="text" ang="en-150"   name="asal" 
                 	      value="<?php echo e($asal) ?>" hidden="hidden" >
                <input type="hidden" ang="en-150"   name="idb" 
                 	      value="<?php echo e($idb) ?>" >
              </span></div>
        </div>
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Program Name </h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
            
                    <textarea id="editor1" name="nm_program" rows="2" cols="80">
                                           <?php echo e($nm_program) ?>
                    </textarea>
   
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label></label>
              <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />
            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
	  </form>	
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php 
if (isset($_POST['Save'])) 
	{
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";	
	$kdb = in_val('kdb', 'post');
	$kdc = in_val('kdc', 'post') ;
	$kd_billing = 	in_val('kd_billing', 'post');	
	$student_name = in_val('student_name', 'post');
	$start_class= in_val('start_class', 'post');
	$end_class = in_val('end_class', 'post');
	$date_generate = in_val('date_generate', 'post');
	$nm_program = in_val('nm_program', 'post');
	
	$query_certificate = q_set($__p_query_certificate, "SELECT  nm_program, start_date, end_date, cetak_date, kelas, nama_student FROM ves_data.ve_certificate where kd_biodata = ? and kelas = ? ", [(string) ($kdb), (string) ($kdc)]);	
	$resource_certificate = db_query_or_die('errro_simpan1', $query_certificate, $__p_query_certificate ?? []);	
	if(num(db_num_rows($resource_certificate)) > 0)
		{
		$query = q_set($__p_query, "update ve_certificate set nm_program = ? , start_date = ? , end_date = ? , cetak_date = ? where kd_biodata = ? and kelas = ? ", [(string) ($nm_program), (string) ($start_class), (string) ($end_class), (string) ($date_generate), (string) ($kdb), (string) ($kdc)]);	
		$resource = db_query_or_die('errro_simpan1', $query, $__p_query ?? []);	
		}
	else
		{
		$query = q_set($__p_query, "insert into ve_certificate (kd_biodata, nm_program, start_date, end_date, cetak_date, dt_entry, pic, kd_billing, kelas, nama_student) \r
\t\tvalues (? , ? , ? , ? , ? , ? , ? , ? , ? , ? )", [(string) ($kdb), (string) ($nm_program), (string) ($start_class), (string) ($end_class), (string) ($date_generate), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($kd_billing), (string) ($kdc), (string) ($student_name)]);	
		$resource = db_query_or_die('errro_simpan1', $query, $__p_query ?? []);	
		}
				echo "<script type=\"text/javascript\">\n";
				echo "window.close();\n";
				echo " window.opener.location.reload();\n";	
				echo "</script>";	
	}
		
?>	

<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- CK Editor -->

<script src="plugins/ckeditor/ckeditor.js"></script>	
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
</body>
</html>
