<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$no = in_val('no', 'any');
$student_name = in_val('student_name', 'any');
$query_nama= q_set($__p_query_nama, "SELECT \r
            b.kd_biodata, \r
            b.nama_lengkap \r
        FROM ves_data.vip_student_data b \r
        WHERE kd_biodata = ?\r
    ", [(string) ($student_name)]);
    $resource_nama = db_query_soft($query_nama, $__p_query_nama ?? []);
		while ($row_nama =   db_fetch($resource_nama, PDO::FETCH_NUM))
			{
			$nama_tampil = $row_nama[1];
			}

$student_name = isset($_GET['student_name']) ? in_val('student_name', 'any') : '';
$attendance = isset($_GET['attendance']) ? in_val('attendance', 'any') : '';
$participation = isset($_GET['participation']) ? in_val('participation', 'any') : '';
$progress_today = isset($_GET['progress_today']) ? in_val('progress_today', 'any') : '';
$meeting_type = isset($_GET['meeting_type']) ? in_val('meeting_type', 'any') : '';
    $selected_Primary_Strength = isset($_GET['Primary_Strength']) ? in_val('Primary_Strength', 'any') : '';
$selected_Primary_Support_area = isset($_GET['Primary_Support_area']) ? in_val('Primary_Support_area', 'any') : '';
$Written_Teachers_Comment = in_val('Written_Teachers_Comment', 'any');
$Attachment_Link = in_val('Attachment_Link', 'any');
$nama_lengkap = $_SESSION['nama_lengkap'];               
$query_kelas = q_set($__p_query_kelas, "SELECT kelas, kd_branch, mulai_tm, nm_teacher,date_format(selesai_tm,'%k:%i'),room,date_format(mulai_tm,'%Y-%m-%d'),urutan,date_format(mulai_tm,'%k:%i') FROM ves_data.vip_teacher_schedule v where id = ? ", [(string) ($no)]);

$resource_kelas= db_query_or_die('errro_visitor1', $query_kelas, $__p_query_kelas ?? []);
$keluar_kelas= db_num_rows($resource_kelas);
	if(num(db_num_rows($resource_kelas)) > 0)
		{
		while ($row_kelas =   db_fetch($resource_kelas, PDO::FETCH_NUM))
			{
			$kdcl = $row_kelas[0];
			$kdcbg = $row_kelas[1];	
			$tgl_meeting_lama = $row_kelas[2];
			$teacher_lama = $row_kelas[3];	
			$end_schedule_lama = $row_kelas[4];
			$room_lama = $row_kelas[5];	
			$tgl_lama = $row_kelas[6];
			$urutan_lama = $row_kelas[7];
			$start_schedule_lama = $row_kelas[8];	
			$tgl_lengkap_lama = $row_kelas[2];
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
      <h1>CA Coordination Sheet Form</h1>
    </section>
<form role="form" method="post"><?php echo csrf_field(); ?>

	<input type="hidden" name="no" value="<?php echo e($no); ?>">
    <!-- Main content -->
<section class="content">
  <div class="row">

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
       	        <input type="text" name="student_name" id="textfield" value="<?php echo e($student_name) ?>">
           	    <input type="text" name="tgl_meeting" id="textfield2" value="<?php echo e($tgl_meeting_lama) ?>">
           	    <input type="text" name="kdcl" id="textfield2" value="<?php echo e($kdcl) ?>">
				  
           	  </div>
           	  <span class="box-body">
           	  <input type="text" name="textfield3" id="textfield3">
       	    </span>			</div>
<div class="box box-warning">
  <div class="box-header with-border"><strong>Student Progress</strong></div>
  <div class="box-body">
    <div class="col-md-4">
      <div class="form-group">
        <label>Student Name</label>
<select class="form-control" name="student_name" disabled>

    <option value=""><?php echo e($nama_tampil) ?></option>

</select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Attendance</label>
        <select class="form-control" name="attendance">
<option>Y</option>
<option>N</option>			
          <option selected><?php echo  e($attendance) ?></option>
        </select>
      </div>
    </div>
<?php if($attendance =='Y'){?>	  
    <div class="col-md-4">
      <div class="form-group">
        <label>Participation</label>
        <select class="form-control" name="participation">
<option>Very Active</option>
<option>Active</option>
<option>Fair</option>
<option>Low Participation</option>

          <option selected><?php echo  e($participation) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Progress Today</label>
        <select class="form-control" name="Progress_Today">
<option>Strong Progress</option>
<option>Good Progress</option>
<option>Fair Progress</option>
<option>Limited Progress</option>

          <option selected><?php echo  e($Progress_Today) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
<label>Meeting Type</label>
<select class="form-control" name="meeting_type">
  <option>--CHOOSE MEETING TYPE--</option>
	<?php
	
    $selected_meeting_type = isset($_GET['meeting_type']) ? in_val('meeting_type', 'any') : '';

    $query_name = q_set($__p_query_name, "\r
        SELECT distinct c.primary_logic FROM ves_data.ca_logic c");

    $resource_type_program = db_query_soft($query_name, $__p_query_name ?? []);

    while ($row_name = db_fetch($resource_type_program, PDO::FETCH_NUM)) {

        $selected = ($selected_meeting_type == $row_name[0]) ? 'selected' : '';

        echo '<option value="'.e($row_name[0]).'" '.e($selected).'>'.e($row_name[0]).'</option>';
    }
    ?>
</select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Primary Strenght</label>
        <select class="form-control" name="Primary_Strength">
          <option>--CHOOSE PRIMARY STRENGHT--</option>
          <?php
	
    $selected_Primary_Strength = isset($_GET['Primary_Strength']) ? in_val('Primary_Strength', 'any') : '';

    $query_name = q_set($__p_query_name, "\r
        SELECT secondary_logic FROM ves_data.ca_logic where  primary_logic =? ", [(string) ($selected_meeting_type)]);

    $resource_type_program = db_query_soft($query_name, $__p_query_name ?? []);

    while ($row_name = db_fetch($resource_type_program, PDO::FETCH_NUM)) {

        $selected = ($selected_Primary_Strength == $row_name[0]) ? 'selected' : '';

        echo '<option value="'.e($row_name[0]).'" '.e($selected).'>'.e($row_name[0]).'</option>';
    }
    ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Primary Support Area</label>
        <select class="form-control" name="Primary_Support_area">
          <option>--CHOOSE PRIMARY SUPPORT AREA--</option>
          <?php
	
    $selected_Primary_Support_area = isset($_GET['Primary_Support_area']) ? in_val('Primary_Support_area', 'any') : '';

    $query_name = q_set($__p_query_name, "\r
        SELECT secondary_logic FROM ves_data.ca_logic where  primary_logic =? and secondary_logic <> ? ", [(string) ($selected_meeting_type), (string) ($selected_Primary_Strength)]);

    $resource_type_program = db_query_soft($query_name, $__p_query_name ?? []);

    while ($row_name = db_fetch($resource_type_program, PDO::FETCH_NUM)) {

        $selected = ($selected_Primary_Support_area == $row_name[0]) ? 'selected' : '';

        echo '<option value="'.e($row_name[0]).'" '.e($selected).'>'.e($row_name[0]).'</option>';
    }
    ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Follow-up Needed</label>
        <select class="form-control" name="Follow_Up_Needed">
<option>No Follow-Up</option>
<option>Monitor Next Meeting</option>
<option>Teacher Follow-Up Needed</option>
<option>Parent Update Needed</option>

          <option selected><?php echo  e($Follow_Up_Needed) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Parent Update Note</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="Parent_Update_Note" value="<?php echo e($Parent_Update_Note) ?>"required>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Written Teacher's Comment</label>
        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"  name="Written_Teachers_Comment"><?php echo e($Written_Teachers_Comment) ?></textarea>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Attachment_Link</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="Attachment_Link" value="<?php echo e($Attachment_Link) ?>"required>
      </div>
    </div>
<?php }?>	  
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
<script>

$(document).ready(function(){

    let scrollpos = localStorage.getItem("scrollpos");

    if(scrollpos !== null){

        $('html, body').animate({
            scrollTop: scrollpos
        }, 300);

    }

    $('select').on('change', function(){

        localStorage.setItem("scrollpos", $(window).scrollTop());

        $(this).closest('form').submit();

    });

});

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
$kd_biodata = in_val('kd_biodata', 'any');
$kdcl = in_val('kdcl', 'any');
$tgl_meeting = in_val('tgl_meeting', 'any');
$student_name = in_val('student_name', 'any');
$attendance = in_val('attendance', 'any');
	if($attendance =='Y'){$attendance = 1;}
$participation = in_val('participation', 'any');
$Progress_Today = in_val('Progress_Today', 'any');
$meeting_typee = in_val('meeting_type', 'any');
$Primary_Strength = in_val('Primary_Strength', 'any');
$Primary_Support_area = in_val('Primary_Support_area', 'any');
$Follow_Up_Needed = in_val('Follow_Up_Needed', 'any');
$Parent_Update_Note = in_val('Parent_Update_Note', 'any');
$Written_Teachers_Comment = in_val('Written_Teachers_Comment', 'any');
$Attachment_Link = in_val('Attachment_Link', 'any');


$query_coor = q_set($__p_query_coor, "select * from ves_data.vip_ca_coshet where kd_biodata = ? and date_cl = ? ", [(string) ($student_name), (string) ($tgl_meeting)]);
$resource_coor= db_query_or_die('errro_visitor21', $query_coor, $__p_query_coor ?? []);
$keluar_coor= db_num_rows($resource_coor);
	if(num(db_num_rows($resource_coor)) > 0)
		{
//$query_coor = "update ves_data.vip_cosheet set subject = '$subject',coverage = '$coverage',material = '$material',assignment = '$assignment',hours = '$hour'  where kd_class = '$kdcl' and tgl_meeting = '$tgl_lengkap_lama'";	
$query_coor_upd = q_set($__p_query_coor_upd, "update ves_data.vip_ca_coshet set kdcl = ? ,\r
date_cl = ? ,\r
kd_biodata = ? ,\r
attendance = ? ,\r
participation = ? ,\r
Progress_Today = ? ,\r
Meeting_Type = ? ,\r
Primary_Strength = ? ,\r
Primary_Support_Area = ? ,\r
Follow_Up_Needed = ? ,\r
Parent_Update_Note = ? ,\r
Written_Teachers_Comment = ? ,\r
Attachment_Link = ? ,\r
dt_entry = ? ,\r
pic = ?\r
\r
  where kd_biodata = ? and date_cl = ? ", [(string) ($kdcl), (string) ($tgl_meeting), (string) ($student_name), (string) ($attendance), (string) ($participation), (string) ($Progress_Today), (string) ($meeting_type), (string) ($Primary_Strength), (string) ($Primary_Support_area), (string) ($Follow_Up_Needed), (string) ($Parent_Update_Note), (string) ($Written_Teachers_Comment), (string) ($Attachment_Link), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($student_name), (string) ($tgl_meeting)]);/* echo $query_coor_upd (debug SQL versi lama) dihapus */			
		

$resource_coor_upd = db_query_or_die('errro_simpan42', $query_coor_upd, $__p_query_coor_upd ?? []);	
		}
	else
	{
$query_coor_insert = q_set($__p_query_coor_insert, "insert into  ves_data.vip_ca_coshet (kdcl,date_cl,kd_biodata,attendance,participation,Progress_Today,Meeting_Type,Primary_Strength,Primary_Support_Area,Follow_Up_Needed,\r
Parent_Update_Note,Written_Teachers_Comment,Attachment_Link,dt_entry, pic) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,\r
? ,? ,? ,? ,? ,? ) ", [(string) ($kdcl), (string) ($tgl_meeting), (string) ($student_name), (string) ($attendance), (string) ($participation), (string) ($Progress_Today), (string) ($meeting_type), (string) ($Primary_Strength), (string) ($Primary_Support_area), (string) ($Follow_Up_Needed), (string) ($Parent_Update_Note), (string) ($Written_Teachers_Comment), (string) ($Attachment_Link), (string) ($hari_ini), (string) ($nama_lengkap)]);	/* echo $query_coor_insert (debug SQL versi lama) dihapus */
		

$resource_coor_insert = db_query_or_die('errro_simpan12', $query_coor_insert, $__p_query_coor_insert ?? []);			

//$resource_simpan = mysql_query($query_simpan) or die('errro_simpan2');	

	}
echo "<script type=\"text/javascript\">\n";
echo "alert('Coordination Sheet sudah di input/DIperbaharui oleh " . e($nama_lengkap) . "');\n";
echo "window.opener.location.reload(true);\n";								
echo "window.close();\n";				
echo "</script>";
}
?>
