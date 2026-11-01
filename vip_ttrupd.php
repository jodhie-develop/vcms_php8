<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$no = in_val('no', 'any');
$sttut = in_val('sttut', 'any');
if (num($sttut) == 51){$subject = 'Tutorial';}
if (num($sttut) == 61){$subject = 'Late Attendance';}

$query_kelas = q_set($__p_query_kelas, "SELECT kelas, kd_branch, mulai_tm, nm_teacher,date_format(selesai_tm,'%k:%i'),room,date_format(mulai_tm,'%Y-%m-%d'),urutan,date_format(mulai_tm,'%k:%i') FROM ves_data.vip_teacher_schedule v where id = ? ", [(string) ($no)]);
$resource_kelas= db_query_or_die('errro_visitor1', $query_kelas, $__p_query_kelas ?? []);
$keluar_kelas= db_num_rows($resource_kelas);
	if(num(db_num_rows($resource_kelas)) > 0)
		{
		while ($row_kelas =   db_fetch($resource_kelas, PDO::FETCH_NUM))
			{
			$kdcl = $row_kelas[0];
			$kdcbg = $row_kelas[1];	
			$tgl_meeting_lama = $row_kelas[6];
			$teacher_lama = $row_kelas[3];	
			$end_schedule_lama = $row_kelas[4];
			$room_lama = $row_kelas[5];	
			$tgl_lama = $row_kelas[6];
			$urutan_lama = $row_kelas[7];
			$start_schedule_lama = $row_kelas[8];	
			$tgl_lengkap_lama = $row_kelas[2];
			}
		}
$nama_lengkap = $_SESSION['nama_lengkap'];               
		if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}	

$mulai_kelas_baru = in_val('mulai_kelas_baru', 'any');
if($mulai_kelas_baru ==''){ $mulai_kelas_baru = $tgl_lama;}
$nm_teacher_baru = in_val('nm_teacher_baru', 'any');
if($nm_teacher_baru == ''){$nm_teacher_baru =  $teacher_lama;}
$room_baru = in_val('room_baru', 'any');
if($room_baru == ''){$room_baru = $room_lama;}
$start_schedule = in_val('start_schedule', 'any');
if ($start_schedule == ''){$start_schedule = $start_schedule_lama;}
$end_schedule = in_val('end_schedule', 'any');
if ($end_schedule == ''){$end_schedule = $end_schedule_lama;}

$remark_schedule = in_val('remark_schedule', 'any');
//$query_nm_teacher = "SELECT b.nm_teacher FROM ves_data.vip_teacher_schedule a left join ves_data.vip_teacher_name b on a.nm_teacher = b.kd_teacher  where kelas = '$kode_kelas' group by a.nm_teacher";

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
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
  <script src="js/tinymce.min.js"/></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
</head>

<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Tutorial Records Form</h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
		  	<div class="box box-warning">
		  		<div class="box-header with-border"></div>
           	  <div class="box-body">
           	    <div class="col-md-6">
           	      <div class="form-group">
           	        <label>Class Code : <?php echo e($kdcl) ?></label>
       	          </div>
       	                     	      <div class="form-group">
           	        <label>Date Meeting
       	            : <?php echo e($tgl_meeting_lama) ?></label>
       	          </div>
       	                     	      <div class="form-group">
           	        <label>Time : <?php echo e($start_schedule_lama) ?> to <?php echo e($end_schedule_lama) ?></label>
           	      </div>
       	        </div>
       	                   	      <div class="form-group">
           	        <label>Room
       	            : <?php echo e($room_lama) ?></label>
       	          </div>
       	        <div class="form-group">
           	        <label>Teacher :
       	            <?php echo e($teacher_lama) ?></label>
       	          </div>
       	        <span class="form-group">
       	        <input type="text" name="no"value="<?php echo e($no) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="no"value="<?php echo e($no) ?>" hidden="">
       	        </span><span class="form-group">
       	        <input type="text" name="kdcl"value="<?php echo e($kdcl) ?>"hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdcbg"value="<?php echo e($kdcbg) ?>"hidden>
       	        <input type="text" name="urutan"value="<?php echo e($urutan_lama) ?>" hidden="">
       	        </span><span class="form-group">
       	        <input type="text" name="tgl_lama"value="<?php echo e($tgl_meeting_lama) ?>" hidden="">
       	        </span><span class="form-group">
       	        <input type="text" name="tgl_lengkap_lama"value="<?php echo e($tgl_lengkap_lama) ?>" hidden="">
       	        </span><span class="form-group">
       	        <input type="text" name="teacher"value="<?php echo e($teacher_lama) ?>" hidden="">
       	        </span></div> 
			</div>
<div class="box box-warning">
  <div class="box-header with-border"><strong>Material</strong></div>
  <div class="box-body">
    <div class="col-md-8">
      <div class="form-group">
        <label>Reason</label>
        <input type="text" class="form-control"  placeholder="Reason form Tutorial" name="subject" value="<?php echo e($subject) ?>">
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Material</label>
        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="coverage" value="<?php echo e($coverage) ?>"></textarea>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Hours Completed</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="hour" value="<?php echo e($hour) ?>">
      </div>
    </div>
  </div>
</div>
<div class="box-body"></div>

<input type="submit" name="Submit" value="Submit" />
</form>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script>
	$('.textarea').wysihtml5();
</script>

<script type="text/javascript" charset="utf-8">
	$(prettyPrint);
</script>
</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$fullurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$kdcl = in_val('kdcl', 'any');
$tgl_lengkap_lama = in_val('tgl_lengkap_lama', 'any');
$kdcbg = in_val('kdcbg', 'any');
$teacher = in_val('teacher', 'any');
$subject = in_val('subject', 'any'); 
$coverage = in_val('coverage', 'any');
$material = in_val('material', 'any');
$assignment = in_val('assignment', 'any');
$hour	 = in_val('hour', 'any');
$no = in_val('no', 'any');	
$query_simpan = q_set($__p_query_simpan, "insert into ves_data.vip_tutor (kd_class,kd_branch,tgl_meeting,subject, coverage,hours,dt_entry,pic, teacher,kd_id) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($kdcl), (string) ($kdcbg), (string) ($tgl_lengkap_lama), (string) ($subject), (string) ($coverage), (string) ($hour), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($teacher), (string) ($no)]);
$resource_simpan = db_query_or_die('errro_simpan2', $query_simpan, $__p_query_simpan ?? []);

if($subject == 'Tutorial')
{$query_simpan = q_set($__p_query_simpan, "update vip_teacher_schedule set status_kelas = '55' where id = ? ", [(string) ($no)]);}
elseif ($subject == 'Late Attendance')	
{$query_simpan = q_set($__p_query_simpan, "update vip_teacher_schedule set status_kelas = '65' where id = ? ", [(string) ($no)]);}

$resource_simpan = db_query_or_die('errro_simpan2', $query_simpan, $__p_query_simpan ?? []);	
echo "<script type=\"text/javascript\">\n";
echo "alert('Tutorial sudah di input oleh " . e($nama_lengkap) . "');\n";
echo "window.opener.location.reload(true);\n";								
echo "window.close();\n";				
echo "</script>";
}
?>
