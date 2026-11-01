<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
if ($nm_teacher ==""){$nm_teacher = in_val('nm_teacher', 'any');}
$center = in_val('center', 'any');
$mulai_kelas = in_val('mulai_kelas', 'any');
$selesai_kelas = in_val('selesai_kelas', 'any');
$nm_program = in_val('nm_program', 'any');
$nm_level = in_val('nm_level', 'any');
$kode_kelas = in_val('kode_kelas', 'any');
$type_class = in_val('type_class', 'any');
$kd_type_class = $type_class;
$jml_meeting = in_val('jml_meeting', 'any');
if($nm_program !="" and $nm_level !="")
	{		
	$query_kode_program = q_set($__p_query_kode_program, "SELECT kd_program,no_meeting FROM vip_mst_code_prg where nm_program = ? and level_program = ? and type_program = ? ", [(string) ($nm_program), (string) ($nm_level), (string) ($kd_type_class)]);
	$resource_kode_program = db_query_or_die('errro_7', $query_kode_program, $__p_query_kode_program ?? []);
	while ($row_kode_program=  db_fetch($resource_kode_program, PDO::FETCH_NUM))
		{
		$kode_program =   $row_kode_program[0];
		//$jml_meeting = $row_kode_program[1];
		}   
	}
$day_1 = in_val('day_1', 'any');$nm_room_1 = in_val('room_1', 'any');$start_1 = in_val('start_1', 'any');$end_1 = in_val('end_1', 'any');$nm_teacher_1 = in_val('nm_teacher_1', 'any');
$day_2 = in_val('day_2', 'any');$nm_room_2 = in_val('room_2', 'any');$start_2 = in_val('start_2', 'any');$end_2 = in_val('end_2', 'any');$nm_teacher_2 = in_val('nm_teacher_2', 'any');
$day_3 = in_val('day_3', 'any');$nm_room_3 = in_val('room_3', 'any');$start_3 = in_val('start_3', 'any');$end_3 = in_val('end_3', 'any');$nm_teacher_3 = in_val('nm_teacher_3', 'any');
$day_4 = in_val('day_4', 'any');$nm_room_4 = in_val('room_4', 'any');$start_4 = in_val('start_4', 'any');$end_4 = in_val('end_4', 'any');$nm_teacher_4 = in_val('nm_teacher_4', 'any');
$day_5 = in_val('day_5', 'any');$nm_room_5 = in_val('room_5', 'any');$start_5 = in_val('start_5', 'any');$end_5 = in_val('end_5', 'any');$nm_teacher_5 = in_val('nm_teacher_5', 'any');
$day_6 = in_val('day_6', 'any');$nm_room_6 = in_val('room_6', 'any');$start_6 = in_val('start_6', 'any');$end_6 = in_val('end_6', 'any');$nm_teacher_6 = in_val('nm_teacher_6', 'any');

$day_7 = in_val('day_7', 'any');$nm_room_1 = in_val('room_1', 'any');$start_1 = in_val('start_1', 'any');$end_1 = in_val('end_7', 'any');$nm_teacher_7 = in_val('nm_teacher_7', 'any');
$day_8 = in_val('day_8', 'any');$nm_room_8 = in_val('room_8', 'any');$start_8 = in_val('start_8', 'any');$end_8 = in_val('end_8', 'any');$nm_teacher_8 = in_val('nm_teacher_8', 'any');
$day_9 = in_val('day_9', 'any');$nm_room_9 = in_val('room_9', 'any');$start_9 = in_val('start_9', 'any');$end_9 = in_val('end_9', 'any');$nm_teacher_9 = in_val('nm_teacher_9', 'any');
$day_10 = in_val('day_10', 'any');$nm_room_10 = in_val('room_10', 'any');$start_10 = in_val('start_10', 'any');$end_10 = in_val('end_10', 'any');$nm_teacher_10 = in_val('nm_teacher_10', 'any');
$day_11 = in_val('day_11', 'any');$nm_room_11 = in_val('room_11', 'any');$start_11 = in_val('start_11', 'any');$end_11 = in_val('end_11', 'any');$nm_teacher_11 = in_val('nm_teacher_11', 'any');
$day_12 = in_val('day_12', 'any');$nm_room_12 = in_val('room_12', 'any');$start_12 = in_val('start_12', 'any');$end_12 = in_val('end_12', 'any');$nm_teacher_12 = in_val('nm_teacher_12', 'any');
if($center =='East Sby'){$kd_center = '1'; $kls_cbg='-01';}
if($center =='West Sby'){$kd_center = '2'; $kls_cbg='-04';}
if($center =='Bali'){$kd_center = '3'; $kls_cbg='-06';}
if($center =='South Jkt'){$kd_center = '4'; $kls_cbg='-05';}
if($center =='North Jkt'){$kd_center = '5'; $kls_cbg='-02';}
if($center =='West Jkt'){$kd_center = '6'; $kls_cbg='-07';}
if($center =='Bandung'){$kd_center = '7'; $kls_cbg='-03';}
if($center =='Malang'){$kd_center = '8'; $kls_cbg='-08';}


if ($day_2 != '')
	{if ($day_1 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_2 == $day_1)
		{if ($start_1 != '' and $end_1 != '' and $start_2 !='' and $end_2 != '')
			{$jm_1 = strtotime("$start_1:01");$js_1 = strtotime("$end_1:00");$jm_2 = strtotime("$start_2:01");$js_2 = strtotime("$end_2:00");
			if ($jm_2 <= $js_1)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 1 and Day 2');\n";	echo "</script>";}
			}
		}
		}
	}
if ($day_3 != '')
	{if ($day_2 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_3 == $day_2)
		{if ($start_2 != '' and $end_2 != '' and $start_3 !='' and $end_3 != '')
			{$jm_2 = strtotime("$start_2:01");$js_2 = strtotime("$end_2:00");$jm_3 = strtotime("$start_3:01");$js_3 = strtotime("$end_3:00");
			if ($jm_3 <= $js_2)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 2 and Day 3');\n";	echo "</script>";}
			}
		}
		}
	}
if ($day_4 != '')
	{if ($day_3 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_4 == $day_3)
		{if ($start_3 != '' and $end_3 != '' and $start_4 !='' and $end_4 != '')
			{$jm_3 = strtotime("$start_3:01");$js_3 = strtotime("$end_3:00");$jm_4 = strtotime("$start_4:01");$js_4 = strtotime("$end_4:00");
			if ($jm_4 <= $js_3)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 3 and Day 4');\n";	echo "</script>";}
			}
		}
		}
	}
if ($day_5 != '')
	{if ($day_4 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_5 == $day_4)
		{if ($start_4 != '' and $end_4 != '' and $start_5 !='' and $end_5 != '')
			{$jm_4 = strtotime("$start_4:01");$js_4 = strtotime("$end_4:00");$jm_5 = strtotime("$start_5:01");$js_5 = strtotime("$end_5:00");
			if ($jm_5 <= $js_4)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 4 and Day 5');\n";	echo "</script>";}
			}
		}
		}
	}
if ($day_6 != '')
	{if ($day_5 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_6 == $day_5)
		{if ($start_6 != '' and $end_6 != '' and $start_6 !='' and $end_6 != '')
			{$jm_5 = strtotime("$start_5:01");$js_5 = strtotime("$end_5:00");$jm_6 = strtotime("$start_6:01");$js_6 = strtotime("$end_6:00");
			if ($jm_6 <= $js_5)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 5 and Day 6');\n";	echo "</script>";}
			}
		}
		}
	}
//===
if ($day_7 != '')
	{if ($day_6 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_7 == $day_6)
		{if ($start_6 != '' and $end_6 != '' and $start_7 !='' and $end_7 != '')
			{$jm_6 = strtotime("$start_6:01");$js_6 = strtotime("$end_6:00");$jm_7 = strtotime("$start_7:01");$js_7 = strtotime("$end_7:00");
			if ($jm_7 <= $js_6)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 6 and Day 7');\n";	echo "</script>";}
			}
		}
		}
	}
if ($day_8 != '')
	{if ($day_7 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_8 == $day_7)
		{if ($start_7 != '' and $end_7 != '' and $start_8 !='' and $end_8 != '')
			{$jm_7 = strtotime("$start_7:01");$js_7 = strtotime("$end_7:00");$jm_8 = strtotime("$start_8:01");$js_8 = strtotime("$end_8:00");
			if ($jm_8 <= $js_7)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 7 and Day 8');\n";	echo "</script>";}
			}
		}
		}
	}
if ($day_9 != '')
	{if ($day_8 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_9 == $day_8)
		{if ($start_8 != '' and $end_8 != '' and $start_9 !='' and $end_9 != '')
			{$jm_8 = strtotime("$start_8:01");$js_8 = strtotime("$end_8:00");$jm_9 = strtotime("$start_9:01");$js_9 = strtotime("$end_9:00");
			if ($jm_9 <= $js_8)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 8 and Day 9');\n";	echo "</script>";}
			}
		}
		}
	}
if ($day_10 != '')
	{if ($day_9 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_10 == $day_9)
		{if ($start_9 != '' and $end_9 != '' and $start_10 !='' and $end_10 != '')
			{$jm_9 = strtotime("$start_9:01");$js_9 = strtotime("$end_9:00");$jm_10 = strtotime("$start_10:01");$js_10 = strtotime("$end_10:00");
			if ($jm_10 <= $js_9)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 9 and Day 10');\n";	echo "</script>";}
			}
		}
		}
	}
if ($day_11 != '')
	{if ($day_10 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_11 == $day_10)
		{if ($start_10 != '' and $end_10 != '' and $start_11 !='' and $end_11 != '')
			{$jm_10 = strtotime("$start_10:01");$js_10 = strtotime("$end_10:00");$jm_11 = strtotime("$start_11:01");$js_11 = strtotime("$end_11:00");
			if ($jm_11 <= $js_10)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 10 and Day 11');\n";	echo "</script>";}
			}
		}
		}
	}
if ($day_12 != '')
	{if ($day_11 == '')	{echo "<script type=\"text/javascript\">\n";echo "alert('Day before must be set');\n";echo "</script>";die;}
	else {if($day_12 == $day_11)
		{if ($start_11 != '' and $end_11 != '' and $start_12 !='' and $end_12 != '')
			{$jm_11 = strtotime("$start_11:01");$js_11 = strtotime("$end_11:00");$jm_12 = strtotime("$start_12:01");$js_12 = strtotime("$end_12:00");
			if ($jm_12 <= $js_11)	
				{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 11 and Day 12');\n";	echo "</script>";}
			}
		}
		}
	}
//===

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
   <style>

function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
.style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
</style>
    <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}

</script><body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Open Class Form</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php  //     include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
		  	<div class="box box-warning">
		  		<div class="box-header with-border"></div>
           	  <div class="box-body">
           	    <div class="col-md-12">
           		<div class="form-group">
       		      <label>Center</label>
                 		  <select class="form-control" name="center"  onChange="this.form.submit()">
                 	        <option>East Sby</option>
                 	        <option>West Sby</option>
                 	        <option>Bali</option>
                 	        <option>South Jkt</option>
                 	        <option>North Jkt</option>
                 	        <option>West Jkt</option>
                 	        <option>Bandung</option>
                 	        <option>Malang</option>
							<option selected><?php echo e($center) ?></option>
       	          </select>
			    </div></div>
          		<div class="col-md-4">
          		  <div class="form-group">
          		    <label>Type Class</label>
          		    <select class="form-control" name="type_class"  onChange="this.form.submit()">
          		      <option>REG</option>
          		      <option>PRI</option>
          		            <option>WORKSHOP</option>         		      
          		      <option selected><?php echo  e($type_class) ?></option>
       		        </select>
       		      </div>
       		    </div>
          		<div class="col-md-4">
           		<div class="form-group">
           		  <label>Program</label>
           		  <select class="form-control" name="nm_program"  onChange="this.form.submit()">
                  			  <?php
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct nm_program FROM ves_data.vip_mst_code_prg WHERE type_program = ? ", [(string) ($kd_type_class)]);
								$resource_nm_program = db_query_or_die('errro_7', $query_nm_program, $__p_query_nm_program ?? []);
								while ($row_nm_program=  db_fetch($resource_nm_program, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_program[0]).'">'.e($row_nm_program[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_program) ?></option>
       	          </select>
       		    </div></div>
			    <div class="col-md-4">
				    <div class="form-group">
				      <label>Level</label>
				      <select class="form-control" name="nm_level"  onChange="this.form.submit()">
                  			  <?php
								$query_level = q_set($__p_query_level, "SELECT level_program FROM vip_mst_code_prg where nm_program = ? and  type_program = ? ", [(string) ($nm_program), (string) ($kd_type_class)]);
								$resource_level = db_query_or_die('errro_7', $query_level, $__p_query_level ?? []);
								while ($row_level=  db_fetch($resource_level, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_level[0]).'">'.e($row_level[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_level) ?></option>
			          </select>
			        </div>
			    </div>
       	        <div class="col-md-6">
           	        <div class="form-group">
           	          <label>Program Code
           	            <input type="text" class="form-control"  placeholder="Enter ..." name="kode_program" value="<?php echo e($kode_program)  ?>" readonly>
           	          </label>
       	          </div>
       	        </div>
       	        <div class="col-md-3">
           	        <div class="form-group">
           	          <label>Class Code
           	            <input type="text" class="form-control"  placeholder="Enter CLass Code" name="kode_kelas" value="<?php echo e($kode_kelas) ?>" required>
       	              <strong><?php echo e($kls_cbg) ; ?></strong>           	          </label>
       	          </div>
       	        </div>
       	        <span class="form-group">
       	        <input type="text" name="kode_program"value="<?php echo e($kode_program) ?>" hidden>
       	        <input type="text" name="kls_cbg"value="<?php echo e($kls_cbg) ?>" hidden>
       	        </span></div> 
			</div>
<div class="box box-warning">
		  		<div class="box-header with-border"><strong>Class Period</strong></div>
                 	<div class="box-body">
                 	  <div class="col-md-3">
                 	    <div class="form-group">
                 	      <label>Start Class</label>
                 	      <input type="date" class="form-control"  placeholder="Enter ..." name="mulai_kelas" value="<?php echo e($mulai_kelas) ?>">
               	      </div>
               	    </div>
                 	  <div class="col-md-3">
                 	    <div class="form-group">
                 	      <label>No Of Meeting</label>
                 	      <select class="form-control" name="jml_meeting" required onChange="this.form.submit()">
                 	        <option value="5">5</option>                	                        	        
                 	        <option value="10">10</option>                	        
                 	        <option value="17">17</option>
                 	        <option value="20">20</option>                 	        
                 	        <option value="25">25</option>
                 	        <option value="30">30</option>
                 	        <option selected><?php echo  e($jml_meeting) ?></option>
               	        </select>
               	      </div>
               	    </div>
                 	</div>
<div class="box-body">
  <div class="col-md-2">
                 	    <div class="form-group">
                 	      <label>Day #1</label>            	      
<select class="form-control" name="day_1" required>
	<option>Monday</option>
	<option>Tuesday</option>
	<option>Wednesday</option>
	<option>Thursday</option>
	<option>Friday</option>
	<option>Saturday</option>
<option selected><?php echo  e($day_1) ?></option>
                   	      </select>
               	      </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_1" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_1) ?></option>
       			  </select>
                 	    </div>                	      
                 	    <div class="form-group">
                 	      <label>Room</label>
                 	      <select class="form-control" name="room_1" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_1) ?></option>
               	        </select>
                 	    </div>  
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_1" required>
<option>08:00</option>
<option>08:15</option>
<option>08:30</option>
<option>08:45</option>
<option>09:00</option>
<option>09:15</option>
<option>09:30</option>
<option>09:45</option>
<option>10:00</option>
<option>10:15</option>
<option>10:30</option>
<option>10:45</option>
<option>11:00</option>
<option>11:15</option>
<option>11:30</option>
<option>11:45</option>
<option>12:00</option>
<option>12:15</option>
<option>12:30</option>
<option>12:45</option>
<option>13:00</option>
<option>13:15</option>
<option>13:30</option>
<option>13:45</option>
<option>14:00</option>
<option>14:15</option>
<option>14:30</option>
<option>14:45</option>
<option>15:00</option>
<option>15:15</option>
<option>15:30</option>
<option>15:45</option>
<option>16:00</option>
<option>16:15</option>
<option>16:30</option>
<option>16:45</option>
<option>17:00</option>
<option>17:15</option>
<option>17:30</option>
<option>17:45</option>
<option>18:00</option>
<option>18:15</option>
<option>18:30</option>
<option>18:45</option>
<option>19:00</option>
<option>19:15</option>
<option>19:30</option>
<option>19:45</option>
<option>20:00</option>
<option>20:15</option>
<option>20:30</option>
<option>20:45</option>
<option>21:00</option>
<option selected><?php echo  e($start_1) ?></option>
   	          </select>
       	    </div> 
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_1" required>
       	        <option>08:00</option>
       	        <option>08:15</option>
       	        <option>08:30</option>
       	        <option>08:45</option>
       	        <option>09:00</option>
       	        <option>09:15</option>
       	        <option>09:30</option>
       	        <option>09:45</option>
       	        <option>10:00</option>
       	        <option>10:15</option>
       	        <option>10:30</option>
       	        <option>10:45</option>
       	        <option>11:00</option>
       	        <option>11:15</option>
       	        <option>11:30</option>
       	        <option>11:45</option>
       	        <option>12:00</option>
       	        <option>12:15</option>
       	        <option>12:30</option>
       	        <option>12:45</option>
       	        <option>13:00</option>
       	        <option>13:15</option>
       	        <option>13:30</option>
       	        <option>13:45</option>
       	        <option>14:00</option>
       	        <option>14:15</option>
       	        <option>14:30</option>
       	        <option>14:45</option>
       	        <option>15:00</option>
       	        <option>15:15</option>
       	        <option>15:30</option>
       	        <option>15:45</option>
       	        <option>16:00</option>
       	        <option>16:15</option>
       	        <option>16:30</option>
       	        <option>16:45</option>
       	        <option>17:00</option>
       	        <option>17:15</option>
       	        <option>17:30</option>
       	        <option>17:45</option>
       	        <option>18:00</option>
       	        <option>18:15</option>
       	        <option>18:30</option>
       	        <option>18:45</option>
       	        <option>19:00</option>
       	        <option>19:15</option>
       	        <option>19:30</option>
       	        <option>19:45</option>
       	        <option>20:00</option>
       	        <option>20:15</option>
       	        <option>20:30</option>
       	        <option>20:45</option>
       	        <option>21:00</option>
<option selected><?php echo  e($end_1) ?></option>            	        
   	          </select>
      </div>              	                     	                 	      
           	      </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #2</label>
      <select class="form-control" name="day_2" required>
        <option></option>       
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_2) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_2" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_2) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_2" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_2) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_2" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_2) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_2" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_2) ?></option>             
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #3</label>
      <select class="form-control" name="day_3" required>
        <option></option>         
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_3) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_3" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_3) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_3" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_3) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_3" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_3) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_3" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_3) ?></option>             
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #4</label>
      <select class="form-control" name="day_4" required>
        <option></option>         
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_4) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_4" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_4) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_4" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_4) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_4" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_4) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_4" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_4) ?></option>             
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #5</label>
      <select class="form-control" name="day_5" required>
        <option></option>         
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_5) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_5" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_5) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_5" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_5) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_5" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_5) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_5" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_5) ?></option>             
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #6</label>
      <select class="form-control" name="day_6" required>
        <option></option>         
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_6) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_6" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_6) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_6" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_6) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_6" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_6) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_6" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_6) ?></option>        
      </select>
 
    </div>
  </div>
</div>
<!--- tambah hari start -->            
<div class="box-body">
  <div class="col-md-2">
                 	    <div class="form-group">
                 	      <label>Day #7</label>            	      
<select class="form-control" name="day_7" required>
	<option>Monday</option>
	<option>Tuesday</option>
	<option>Wednesday</option>
	<option>Thursday</option>
	<option>Friday</option>
	<option>Saturday</option>
<option selected><?php echo  e($day_7) ?></option>
                   	      </select>
               	      </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_7" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_7) ?></option>
       			  </select>
                 	    </div>                	      
                 	    <div class="form-group">
                 	      <label>Room</label>
                 	      <select class="form-control" name="room_7" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_7) ?></option>
               	        </select>
                 	    </div>  
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_7" required>
<option>08:00</option>
<option>08:15</option>
<option>08:30</option>
<option>08:45</option>
<option>09:00</option>
<option>09:15</option>
<option>09:30</option>
<option>09:45</option>
<option>10:00</option>
<option>10:15</option>
<option>10:30</option>
<option>10:45</option>
<option>11:00</option>
<option>11:15</option>
<option>11:30</option>
<option>11:45</option>
<option>12:00</option>
<option>12:15</option>
<option>12:30</option>
<option>12:45</option>
<option>13:00</option>
<option>13:15</option>
<option>13:30</option>
<option>13:45</option>
<option>14:00</option>
<option>14:15</option>
<option>14:30</option>
<option>14:45</option>
<option>15:00</option>
<option>15:15</option>
<option>15:30</option>
<option>15:45</option>
<option>16:00</option>
<option>16:15</option>
<option>16:30</option>
<option>16:45</option>
<option>17:00</option>
<option>17:15</option>
<option>17:30</option>
<option>17:45</option>
<option>18:00</option>
<option>18:15</option>
<option>18:30</option>
<option>18:45</option>
<option>19:00</option>
<option>19:15</option>
<option>19:30</option>
<option>19:45</option>
<option>20:00</option>
<option>20:15</option>
<option>20:30</option>
<option>20:45</option>
<option>21:00</option>
<option selected><?php echo  e($start_7) ?></option>
   	          </select>
       	    </div> 
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_7" required>
       	        <option>08:00</option>
       	        <option>08:15</option>
       	        <option>08:30</option>
       	        <option>08:45</option>
       	        <option>09:00</option>
       	        <option>09:15</option>
       	        <option>09:30</option>
       	        <option>09:45</option>
       	        <option>10:00</option>
       	        <option>10:15</option>
       	        <option>10:30</option>
       	        <option>10:45</option>
       	        <option>11:00</option>
       	        <option>11:15</option>
       	        <option>11:30</option>
       	        <option>11:45</option>
       	        <option>12:00</option>
       	        <option>12:15</option>
       	        <option>12:30</option>
       	        <option>12:45</option>
       	        <option>13:00</option>
       	        <option>13:15</option>
       	        <option>13:30</option>
       	        <option>13:45</option>
       	        <option>14:00</option>
       	        <option>14:15</option>
       	        <option>14:30</option>
       	        <option>14:45</option>
       	        <option>15:00</option>
       	        <option>15:15</option>
       	        <option>15:30</option>
       	        <option>15:45</option>
       	        <option>16:00</option>
       	        <option>16:15</option>
       	        <option>16:30</option>
       	        <option>16:45</option>
       	        <option>17:00</option>
       	        <option>17:15</option>
       	        <option>17:30</option>
       	        <option>17:45</option>
       	        <option>18:00</option>
       	        <option>18:15</option>
       	        <option>18:30</option>
       	        <option>18:45</option>
       	        <option>19:00</option>
       	        <option>19:15</option>
       	        <option>19:30</option>
       	        <option>19:45</option>
       	        <option>20:00</option>
       	        <option>20:15</option>
       	        <option>20:30</option>
       	        <option>20:45</option>
       	        <option>21:00</option>
<option selected><?php echo  e($end_7) ?></option>            	        
   	          </select>
      </div>              	                     	                 	      
           	      </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #8</label>
      <select class="form-control" name="day_8" required>
        <option></option>       
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_8) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_8" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_8) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_8" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_8) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_8" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_8) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_8" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_8) ?></option>             
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #9</label>
      <select class="form-control" name="day_9" required>
        <option></option>         
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_9) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_9" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_9) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_9" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_9) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_9" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_9) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_9" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>

        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_9) ?></option>             
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #10</label>
      <select class="form-control" name="day_10" required>
        <option></option>         
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_10) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_4" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_10) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_10" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_10) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_10" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_10) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_10" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_10) ?></option>             
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #11</label>
      <select class="form-control" name="day_11" required>
        <option></option>         
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_11) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_5" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_11) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_11" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_11) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_11" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_11) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_5" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_11) ?></option>             
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Day #12</label>
      <select class="form-control" name="day_12" required>
        <option></option>         
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
<option selected><?php echo  e($day_12) ?></option>        
      </select>
    </div>
                 	    <div class="form-group">
                 	      <label>Teacher</label>
                 	      <select class="form-control" name="nm_teacher_12" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_12) ?></option>
       			  </select>
                 	    </div>          
    <div class="form-group">
      <label>Room</label>
      <select class="form-control" name="room_12" required>
 <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_room_12) ?></option>
      </select>
    </div>
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="start_12" required>
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($start_12) ?></option>        
      </select>
    </div>
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="end_12" required  onChange="this.form.submit()">
        <option>08:00</option>
        <option>08:15</option>
        <option>08:30</option>
        <option>08:45</option>
        <option>09:00</option>
        <option>09:15</option>
        <option>09:30</option>
        <option>09:45</option>
        <option>10:00</option>
        <option>10:15</option>
        <option>10:30</option>
        <option>10:45</option>
        <option>11:00</option>
        <option>11:15</option>
        <option>11:30</option>
        <option>11:45</option>
        <option>12:00</option>
        <option>12:15</option>
        <option>12:30</option>
        <option>12:45</option>
        <option>13:00</option>
        <option>13:15</option>
        <option>13:30</option>
        <option>13:45</option>
        <option>14:00</option>
        <option>14:15</option>
        <option>14:30</option>
        <option>14:45</option>
        <option>15:00</option>
        <option>15:15</option>
        <option>15:30</option>
        <option>15:45</option>
        <option>16:00</option>
        <option>16:15</option>
        <option>16:30</option>
        <option>16:45</option>
        <option>17:00</option>
        <option>17:15</option>
        <option>17:30</option>
        <option>17:45</option>
        <option>18:00</option>
        <option>18:15</option>
        <option>18:30</option>
        <option>18:45</option>
        <option>19:00</option>
        <option>19:15</option>
        <option>19:30</option>
        <option>19:45</option>
        <option>20:00</option>
        <option>20:15</option>
        <option>20:30</option>
        <option>20:45</option>
        <option>21:00</option>
<option selected><?php echo  e($end_12) ?></option>        
      </select>
 
    </div>
  </div>
</div>
<!--- tambah hari end-->            

            <input type="submit" name="Submit" value="Submit" />
</form>

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
$nm_teacher = in_val('nm_teacher', 'any');
$center = in_val('center', 'any');
$mulai_kelas = in_val('mulai_kelas', 'any');
$selesai_kelas = in_val('selesai_kelas', 'any');
$nm_program = in_val('nm_program', 'any');
$nm_level = in_val('nm_level', 'any');
$kode_kelas = in_val('kode_kelas', 'any');
$kode_program = in_val('kode_program', 'any');
$kls_cbg = in_val('kls_cbg', 'any');	
$nama_lengkap = 	$_SESSION['nama_lengkap'];
$kode_lengkap_kelas = "$kode_program $kode_kelas$kls_cbg"; 	
$day_1 = in_val('day_1', 'any');$nm_room_1 = in_val('room_1', 'any');$start_1 = in_val('start_1', 'any');$end_1 = in_val('end_1', 'any');$nm_teacher_1 = in_val('nm_teacher_1', 'any');
$day_2 = in_val('day_2', 'any');$nm_room_2 = in_val('room_2', 'any');$start_2 = in_val('start_2', 'any');$end_2 = in_val('end_2', 'any');$nm_teacher_2 = in_val('nm_teacher_2', 'any');
$day_3 = in_val('day_3', 'any');$nm_room_3 = in_val('room_3', 'any');$start_3 = in_val('start_3', 'any');$end_3 = in_val('end_3', 'any');$nm_teacher_3 = in_val('nm_teacher_3', 'any');
$day_4 = in_val('day_4', 'any');$nm_room_4 = in_val('room_4', 'any');$start_4 = in_val('start_4', 'any');$end_4 = in_val('end_4', 'any');$nm_teacher_4 = in_val('nm_teacher_4', 'any');
$day_5 = in_val('day_5', 'any');$nm_room_5 = in_val('room_5', 'any');$start_5 = in_val('start_5', 'any');$end_5 = in_val('end_5', 'any');$nm_teacher_5 = in_val('nm_teacher_5', 'any');
$day_6 = in_val('day_6', 'any');$nm_room_6 = in_val('room_6', 'any');$start_6 = in_val('start_6', 'any');$end_6 = in_val('end_6', 'any');$nm_teacher_6 = in_val('nm_teacher_6', 'any');
if ($jml_meeting =='' or $jml_meeting == '0')
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Number of Meeting Must be filled');\n";	
	echo "</script>";
	die;
	}
	
	
if ($day_1 != '' or $day_1 !='N/A')	{	if($nm_room_1 == '' or $start_1 =='' or $end_1 == '' or  $nm_teacher_1 =='')
		{echo "<script type=\"text/javascript\">\n";
		echo "alert('Day #1 :Room, Teacher and Time Period must be filled');\n";	
		echo "</script>";
		die;}else {$jmlhr = 1;}	}
if ($day_2 != '' and $day_2 !='N/A')	{	if($nm_room_2 == '' or $start_2 =='' or $end_2 == '' or  $nm_teacher_2 =='')
		{echo "<script type=\"text/javascript\">\n";
		echo "alert('Day #2 :Room, Teacher and Time Period must be filled');\n";	
		echo "</script>";
		die;}else {$jmlhr = 2;}		}
if ($day_3 != '' and $day_3 !='N/A')	{	if($nm_room_3 == '' or $start_3 =='' or $end_3 == '' or  $nm_teacher_3 =='')
		{echo "<script type=\"text/javascript\">\n";
		echo "alert('Day #3 :Room, Teacher and Time Period must be filled');\n";	
		echo "</script>";
		die;}else {$jmlhr = 3;}		}
if ($day_4 != '' and $day_4 !='N/A')	{	if($nm_room_4 == '' or $start_4 =='' or $end_4 == '' or  $nm_teacher_4 =='')
		{echo "<script type=\"text/javascript\">\n";
		echo "alert('Day #1 :Room, Teacher and Time Period must be filled');\n";	
		echo "</script>";
		die;}else {$jmlhr = 4;}		}
if ($day_5 != '' and $day_5 !='N/A')	{	if($nm_room_5 == '' or $start_5 =='' or $end_5 == '' or  $nm_teacher_5 =='')
		{echo "<script type=\"text/javascript\">\n";
		echo "alert('Day #5 :Room, Teacher and Time Period must be filled');\n";	
		echo "</script>";
		die;}else {$jmlhr = 5;}		}
if ($day_6 != '' and $day_6 !='N/A')	{	if($nm_room_6 == '' or $start_6 =='' or $end_6 == '' or  $nm_teacher_6 =='')
		{echo "<script type=\"text/javascript\">\n";
		echo "alert('Day #6 :Room, Teacher and Time Period must be filled');\n";	
		echo "</script>";
		die;}else {$jmlhr = 6;}		}
if($day_1 != '')	{$jm_1 = strtotime($start_1);$js_1 = strtotime($end_1);
	if ($jm_1 >= $js_1)	{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 1');\n";	echo "</script>";die;}}
if($day_2 != '' and $day_2 !='N/A')	{$jm_2 = strtotime($start_2);$js_2 = strtotime($end_2);
	if ($jm_2 >= $js_2)	{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 2');\n";	echo "</script>";die;}}
if($day_3 != '' and $day_3 !='N/A')	{$jm_3 = strtotime($start_3);$js_3 = strtotime($end_3);
	if ($jm_3 >= $js_3)	{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 3');\n";	echo "</script>";die;}}
if($day_4 != '' and $day_4 !='N/A')	{$jm_4 = strtotime($start_4);$js_4 = strtotime($end_4);
	if ($jm_4 >= $js_4)	{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 4');\n";	echo "</script>";die;}}
if($day_5 != '' and $day_5 !='N/A')	{$jm_5 = strtotime($start_5);$js_5 = strtotime($end_5);
	if ($jm_5 >= $js_5)	{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 5');\n";	echo "</script>";die;}}
if($day_6 != '' and $day_6 !='N/A')	{$jm_6 = strtotime($start_6);$js_6 = strtotime($end_6);
	if ($jm_6 >= $js_6)	{echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time Period - Day 6');\n";	echo "</script>";die;}}	


if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}



$kode_st =  strtotime($mulai_kelas); 

$mulai_kelas_check = $mulai_kelas;
if ($jml_meeting != '')
	{
	$meetke = 1;
	while ($meetke <= $jml_meeting) 
		{

		$ambilhari = date('l', strtotime($mulai_kelas_check));

		if ($day_1 !='')
			{
			if ($ambilhari == $day_1)
				{
				$bisa = 0;
				//day 1	
				$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE  nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR \t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($nm_teacher_1), (string) ($mulai_kelas_check) . " " . (string) ($start_1) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_1) . ":00", (string) ($mulai_kelas_check) . " " . (string) ($start_1) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_1) . ":00"]);
				$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
				if(num(db_num_rows($result_cek_teacher)) > 0)
					{
					while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
						{							
						echo "<script type=\"text/javascript\">\n";
						echo "alert('Day - 1 (" . e($row_cek[6]) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";	
						echo "</script>";
						die;
						}
					}
//==					
				$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas FROM ves_data.vip_teacher_schedule WHERE center = ? and  room =? and mulai_tm like ? order by mulai_tm", [(string) ($center), (string) ($nm_room_1), (string) ($mulai_kelas_check) . "%"]);
				$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
				if(num(db_num_rows($result_cek_room)) > 0)
					{
					while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
						{
						$detail_mulai = "$mulai_kelas_check $start_1:01";
						$detail_selesai = "$mulai_kelas_check $end_1:00";							
						$jamkelas_mulai = $row_room[1];
						$jamkelas_selesai = $row_room[2];	
						$kelas_detail = $row_room[5];	
				
						if (strtotime($detail_mulai) >= strtotime($jamkelas_mulai))
							{
							if ( strtotime($detail_mulai) <= strtotime($jamkelas_selesai))
								{		
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;
								}
							else
								{
								$bisa = "after";
								}
							}
						else
							{
							if (strtotime($detail_selesai) <= strtotime($jamkelas_mulai))
								{	
								$bisa = "before";	
								}
							else
								{
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;	
								}
							}
						}
					}
				//====
				$meetke = num($meetke) + 1;}
			}
		if ($day_2 !='')
			{
			if ($ambilhari == $day_2)
				{		
				//day 2	
				$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p') FROM ves_data.vip_teacher_schedule WHERE  nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t\t\t\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($nm_teacher_2), (string) ($mulai_kelas_check) . " " . (string) ($start_2) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_2) . ":00", (string) ($mulai_kelas_check) . " " . (string) ($start_2) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_2) . ":00"]);
				$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
				if(num(db_num_rows($result_cek_teacher)) > 0)
					{
					while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
						{							
						echo "<script type=\"text/javascript\">\n";
						echo "alert('Day - 2 (" . e($row_cek[6]) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";
						echo "</script>";
						die;
						}
					}
//==					
				$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas FROM ves_data.vip_teacher_schedule WHERE center = ? and  room =? and mulai_tm like ? order by mulai_tm", [(string) ($center), (string) ($nm_room_2), (string) ($mulai_kelas_check) . "%"]);
				$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
				if(num(db_num_rows($result_cek_room)) > 0)
					{
					while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
						{
						$detail_mulai = "$mulai_kelas_check $start_2:01";
						$detail_selesai = "$mulai_kelas_check $end_2:00";							
						$jamkelas_mulai = $row_room[1];
						$jamkelas_selesai = $row_room[2];	
						$kelas_detail = $row_room[5];	
				
						if (strtotime($detail_mulai) >= strtotime($jamkelas_mulai))
							{
							if ( strtotime($detail_mulai) <= strtotime($jamkelas_selesai))
								{		
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;
								}
							else
								{
								$bisa = "after";
								}
							}
						else
							{
							if (strtotime($detail_selesai) <= strtotime($jamkelas_mulai))
								{	
								$bisa = "before";	
								}
							else
								{
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;	
								}
							}
						}
					}
				//====
				}
		$meetke = num($meetke) + 1;}
		if ($day_3 !='')
			{
			if ($ambilhari == $day_3)
				{			
				//day 3
				$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE  nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t\t\t\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($nm_teacher_3), (string) ($mulai_kelas_check) . " " . (string) ($start_3) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_3) . ":00", (string) ($mulai_kelas_check) . " " . (string) ($start_3) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_3) . ":00"]);
				$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
				if(num(db_num_rows($result_cek_teacher)) > 0)
					{
					while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
						{							
						echo "<script type=\"text/javascript\">\n";
						echo "alert('Day - 3 (" . e($row_cek[6]) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";	
						echo "</script>";
						die;
						}
					}
//==					
				$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas FROM ves_data.vip_teacher_schedule WHERE center = ? and  room =? and mulai_tm like ? order by mulai_tm", [(string) ($center), (string) ($nm_room_3), (string) ($mulai_kelas_check) . "%"]);
				$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
				if(num(db_num_rows($result_cek_room)) > 0)
					{
					while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
						{
						$detail_mulai = "$mulai_kelas_check $start_3:01";
						$detail_selesai = "$mulai_kelas_check $end_3:00";							
						$jamkelas_mulai = $row_room[1];
						$jamkelas_selesai = $row_room[2];	
						$kelas_detail = $row_room[5];	
				
						if (strtotime($detail_mulai) >= strtotime($jamkelas_mulai))
							{
							if ( strtotime($detail_mulai) <= strtotime($jamkelas_selesai))
								{		
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;
								}
							else
								{
								$bisa = "after";
								}
							}
						else
							{
							if (strtotime($detail_selesai) <= strtotime($jamkelas_mulai))
								{	
								$bisa = "before";	
								}
							else
								{
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;	
								}
							}
						}
					}
				//====	
				}
			$meetke = num($meetke) + 1;}
		if ($day_4 !='')
			{
			if ($ambilhari == $day_4)
				{					
//day 4	
$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE  nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($nm_teacher_4), (string) ($mulai_kelas_check) . " " . (string) ($start_4) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_4) . ":00", (string) ($mulai_kelas_check) . " " . (string) ($start_4) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_4) . ":00"]);
$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
if(num(db_num_rows($result_cek_teacher)) > 0)
	{
	while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
		{							
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Day - 4 (" . e($row_cek[6]) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";	
		echo "</script>";
		die;
		}
	}
//==					
				$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas FROM ves_data.vip_teacher_schedule WHERE center = ? and  room =? and mulai_tm like ? order by mulai_tm", [(string) ($center), (string) ($nm_room_4), (string) ($mulai_kelas_check) . "%"]);
				$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
				if(num(db_num_rows($result_cek_room)) > 0)
					{
					while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
						{
						$detail_mulai = "$mulai_kelas_check $start_4:01";
						$detail_selesai = "$mulai_kelas_check $end_4:00";							
						$jamkelas_mulai = $row_room[1];
						$jamkelas_selesai = $row_room[2];	
						$kelas_detail = $row_room[5];	
				
						if (strtotime($detail_mulai) >= strtotime($jamkelas_mulai))
							{
							if ( strtotime($detail_mulai) <= strtotime($jamkelas_selesai))
								{		
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;
								}
							else
								{
								$bisa = "after";
								}
							}
						else
							{
							if (strtotime($detail_selesai) <= strtotime($jamkelas_mulai))
								{	
								$bisa = "before";	
								}
							else
								{
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;	
								}
							}
						}
					}
				//====
				}
			$meetke = num($meetke) + 1;}
		if ($day_5 !='')
			{
			if ($ambilhari == $day_5)
				{					
//day 5	
$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE  nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($nm_teacher_5), (string) ($mulai_kelas_check) . " " . (string) ($start_5) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_5) . ":00", (string) ($mulai_kelas_check) . " " . (string) ($start_5) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_5) . ":00"]);
$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
if(num(db_num_rows($result_cek_teacher)) > 0)
	{
	while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
		{							
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Day - 5 (" . e($row_cek[6]) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";	
		echo "</script>";
		die;
		}
	}
//==					
				$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas FROM ves_data.vip_teacher_schedule WHERE center = ? and  room =? and mulai_tm like ? order by mulai_tm", [(string) ($center), (string) ($nm_room_5), (string) ($mulai_kelas_check) . "%"]);
				$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
				if(num(db_num_rows($result_cek_room)) > 0)
					{
					while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
						{
						$detail_mulai = "$mulai_kelas_check $start_5:01";
						$detail_selesai = "$mulai_kelas_check $end_5:00";							
						$jamkelas_mulai = $row_room[1];
						$jamkelas_selesai = $row_room[2];	
						$kelas_detail = $row_room[5];	
				
						if (strtotime($detail_mulai) >= strtotime($jamkelas_mulai))
							{
							if ( strtotime($detail_mulai) <= strtotime($jamkelas_selesai))
								{		
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;
								}
							else
								{
								$bisa = "after";
								}
							}
						else
							{
							if (strtotime($detail_selesai) <= strtotime($jamkelas_mulai))
								{	
								$bisa = "before";	
								}
							else
								{
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;	
								}
							}
						}
					}
				//====	
				}
			$meetke = num($meetke) + 1;}
		if ($day_6 !='')
			{
			if ($ambilhari == $day_6)
				{						
				//day 6	
				$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE  nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t\t\t\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($nm_teacher_6), (string) ($mulai_kelas_check) . " " . (string) ($start_6) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_6) . ":00", (string) ($mulai_kelas_check) . " " . (string) ($start_6) . ":01", (string) ($mulai_kelas_check) . " " . (string) ($end_6) . ":00"]);
				$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
				if(num(db_num_rows($result_cek_teacher)) > 0)
					{
					while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
						{							
						echo "<script type=\"text/javascript\">\n";
						echo "alert('Day - 6 (" . e($row_cek[6]) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";	
						echo "</script>";
						die;
						}
					}
//==					
				$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas FROM ves_data.vip_teacher_schedule WHERE center = ? and  room =? and mulai_tm like ? order by mulai_tm", [(string) ($center), (string) ($nm_room_6), (string) ($mulai_kelas_check) . "%"]);
				$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
				if(num(db_num_rows($result_cek_room)) > 0)
					{
					while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
						{
						$detail_mulai = "$mulai_kelas_check $start_6:01";
						$detail_selesai = "$mulai_kelas_check $end_6:00";							
						$jamkelas_mulai = $row_room[1];
						$jamkelas_selesai = $row_room[2];	
						$kelas_detail = $row_room[5];	
				
						if (strtotime($detail_mulai) >= strtotime($jamkelas_mulai))
							{
							if ( strtotime($detail_mulai) <= strtotime($jamkelas_selesai))
								{		
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;
								}
							else
								{
								$bisa = "after";
								}
							}
						else
							{
							if (strtotime($detail_selesai) <= strtotime($jamkelas_mulai))
								{	
								$bisa = "before";	
								}
							else
								{
								echo "<script type=\"text/javascript\">\n";
								echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
								echo "</script>";
								die;	
								}
							}
						}
					}
				//====	
		}	
//==		
	$meetke = num($meetke) + 1;}
		$mulai_kelas_check = date ("Y-m-d", strtotime("+1 day", strtotime($mulai_kelas_check)));
		}
	}
	
//====check hari dan jam sama

		//======
if ($jml_meeting != '')
	{
	$meetke = 1;
	$harian = $mulai_kelas;	
	while ($meetke <= $jml_meeting) 
		{
		
		$ambilhari = date('l', strtotime($mulai_kelas));
		$query_liburan = q_set($__p_query_liburan, "select keterangan from day_off where date_off = ? ", [(string) ($mulai_kelas)]);
		$result_liburan=db_query_or_die("Wah error nih1", $query_liburan, $__p_query_liburan ?? []);
		if(num(db_num_rows($result_liburan)) > 0)
			{
			while ($row_libur=  db_fetch($result_liburan, PDO::FETCH_NUM))
				{
				$keterangan = $row_libur[0];
				$dihitung = 0;
				$catatan = $keterangan;
				$status_kelas = 0;	
				}
			}
		else
			{$dihitung= 1;				
			 $catatan = "";
			 $status_kelas = 1;
			}
		if ($ambilhari == $day_1)
			{
			$query_simpan_1 = q_set($__p_query_simpan_1, "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, room, mulai_tm, selesai_tm,dt_entry, pic,kode_program,level_program,kd_branch,urutan,status_kelas)\r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($nm_teacher_1), (string) ($kode_lengkap_kelas), (string) ($center), (string) ($nm_room_1), (string) ($mulai_kelas) . " " . (string) ($start_1) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_1) . ":00", (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kode_program), (string) ($nm_level), (string) ($kd_center), (string) ($meetke), (string) ($status_kelas)]);
			$resource_simpan_1= db_query_or_die('errro_simpan1', $query_simpan_1, $__p_query_simpan_1 ?? []);	
			$meetke = 	num($meetke) + num($dihitung);
			}
//		elseif ($ambilhari == $day_2)
			
		if ($ambilhari == $day_2)
			{
			$query_simpan_2 = q_set($__p_query_simpan_2, "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, room, mulai_tm, selesai_tm,dt_entry, pic,kode_program,level_program,kd_branch,urutan,status_kelas)\r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($nm_teacher_2), (string) ($kode_lengkap_kelas), (string) ($center), (string) ($nm_room_2), (string) ($mulai_kelas) . " " . (string) ($start_2) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_2) . ":00", (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kode_program), (string) ($nm_level), (string) ($kd_center), (string) ($meetke), (string) ($status_kelas)]);
			$resource_simpan_2= db_query_or_die('errro_simpan2', $query_simpan_2, $__p_query_simpan_2 ?? []);	
							$meetke = 	num($meetke) + num($dihitung);
			}
//		elseif ($ambilhari == $day_3)
		if ($ambilhari == $day_3)
			
			{
			$query_simpan_3 = q_set($__p_query_simpan_3, "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, room, mulai_tm, selesai_tm,dt_entry, pic,kode_program,level_program,kd_branch,urutan,status_kelas)\r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($nm_teacher_3), (string) ($kode_lengkap_kelas), (string) ($center), (string) ($nm_room_3), (string) ($mulai_kelas) . " " . (string) ($start_3) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_3) . ":00", (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kode_program), (string) ($nm_level), (string) ($kd_center), (string) ($meetke), (string) ($status_kelas)]);	
			$resource_simpan_3= db_query_or_die('errro_simpan3', $query_simpan_3, $__p_query_simpan_3 ?? []);	
							$meetke = 	num($meetke) + num($dihitung);
			}
//		elseif ($ambilhari == $day_4)
			
		if ($ambilhari == $day_4)
			{
			$query_simpan_4 = q_set($__p_query_simpan_4, "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, room, mulai_tm, selesai_tm,dt_entry, pic,kode_program,level_program,kd_branch,urutan,status_kelas)\r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($nm_teacher_4), (string) ($kode_lengkap_kelas), (string) ($center), (string) ($nm_room_4), (string) ($mulai_kelas) . " " . (string) ($start_4) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_4) . ":00", (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kode_program), (string) ($nm_level), (string) ($kd_center), (string) ($meetke), (string) ($status_kelas)]);	
			$resource_simpan_4= db_query_or_die('errro_simpan4', $query_simpan_4, $__p_query_simpan_4 ?? []);	
							$meetke = 	num($meetke) + num($dihitung);
			}
//		elseif ($ambilhari == $day_5)
			
		if ($ambilhari == $day_5)
			{
			$query_simpan_5 = q_set($__p_query_simpan_5, "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, room, mulai_tm, selesai_tm,dt_entry, pic,kode_program,level_program,kd_branch,urutan,status_kelas)\r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($nm_teacher_5), (string) ($kode_lengkap_kelas), (string) ($center), (string) ($nm_room_5), (string) ($mulai_kelas) . " " . (string) ($start_5) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_5) . ":00", (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kode_program), (string) ($nm_level), (string) ($kd_center), (string) ($meetke), (string) ($status_kelas)]);	
			$resource_simpan_5= db_query_or_die('errro_simpan5', $query_simpan_5, $__p_query_simpan_5 ?? []);	
			$meetke = 	num($meetke) + num($dihitung);
			}
//		elseif ($ambilhari == $day_6)
			
		if ($ambilhari == $day_6)
			{
			$query_simpan_6 = q_set($__p_query_simpan_6, "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, room, mulai_tm, selesai_tm,dt_entry, pic,kode_program,level_program,kd_branch,urutan,status_kelas)\r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($nm_teacher_6), (string) ($kode_lengkap_kelas), (string) ($center), (string) ($nm_room_6), (string) ($mulai_kelas) . " " . (string) ($start_6) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_6) . ":00", (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kode_program), (string) ($nm_level), (string) ($kd_center), (string) ($meetke), (string) ($status_kelas)]);		
			$resource_simpan_6= db_query_or_die('errro_simpan6', $query_simpan_6, $__p_query_simpan_6 ?? []);	
			$meetke = 	num($meetke) + num($dihitung);
			}
		$mulai_kelas = date ("Y-m-d", strtotime("+1 day", strtotime($mulai_kelas)));	
		}	
	}
					echo "<script type=\"text/javascript\">\n";
				echo "alert('New Scheduled has been set by " . e($nama_depan) . "');\n";
				echo "window.location = ('acdcal.php?kdcl=" . e(u($kode_lengkap_kelas)) . "&kdcbg=" . e(u($kd_center)) . "');\n";				
				echo "</script>";
}
?>
