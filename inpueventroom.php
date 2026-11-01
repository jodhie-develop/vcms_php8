<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
$kd_teacher = in_val('kdt', 'get');
$start_date = in_val('start_date', 'get');
$end_date = in_val('end_date', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$dispname = in_val('disp', 'get');
$hari_ini = "$tahun-$bulan-$hari";
if ($start_date==""){$start_date = "$tahun-$bulan-01";}
if ($end_date==""){$end_date = "$tahun-$bulan-31";}
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
 //include __DIR__ . "/atas.php";
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
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>   

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- 

 
 side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Room's Usage Record</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section>

    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form">
 <div class="box-header with-border">
  <div class='col-md-12' align="left">
		    <label>Period</label>
      	  </div>
<div class="row">
       	      <div class="col-md-2">
       	        <div class="form-group">
       	          <input type="date" class="form-control"  placeholder="Enter ..." name="start_date" value="<?php echo e($start_date) ?>" onChange="this.form.submit()">
       	        </div>
	        </div>
       	      <div class="col-md-2">
       	        <div class="form-group">
       	          <input type="date" class="form-control" placeholder="Enter ..." name="end_date" value="<?php echo e($end_date) ?>" onChange="this.form.submit()">
   	            </div>
   	          </div>
       	      <br>
       	      <div class="col-md-2">
       	        <div class="form-group">
       	          <input type="text" name="kdt" value="<?php echo e($kd_teacher) ?>" hidden="hidden">
   	            </div>
   	          </div>
	 </div> </div>     	  
	  <div class="col-md-12">
	    <div class="box box-warning">
  		  <div class="box-header with-border"></div>
       	<table id="example1" class="table table-bordered table-striped">
                <thead>
                <?php
$query_teacher = q_set($__p_query_teacher, "SELECT b.kd_room, b.nm_room ,TIME(SUM(TIMEDIFF(a.selesai_tm, a.mulai_tm))) as durasi\r
FROM ves_data.vip_teacher_schedule a,ves_data.vip_room_name b where a.room = b.kd_room and mulai_tm between ? and ? GROUP BY b.kd_room", [(string) ($start_date), (string) ($end_date)]);

$resource_teacher= db_query_or_die('errro_visitor1', $query_teacher, $__p_query_teacher ?? []);
?>
                <tr>
                  <th width="3%">No</th>
                  <th width="4%"> Room's Name</th>
                  <th width="4%"> Room's Code</th>
                  <th width="12%">Total Room Usage</th>
                  <th width="5%">ACTION</th>
                </tr>
                </thead>
                <tbody>

				  <?php 
					if ($resource_teacher) 
						{ 
							$no_urut = 1;
						while ($row_teacher = db_fetch($resource_teacher))
							{
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><a href="inpuevent.php?kdt=<?php echo e(u($row_teacher[0])); ?>&start_date=<?php echo e(u($start_date)) ?>&end_date=<?php echo e(u($end_date)) ?>&disp=<?php echo e(u($row_teacher[1])); ?>"><?php echo e($row_teacher[1]) ; ?></td>
                  <td><?php echo e($row_teacher[0]) ; ?></td>
                  <td><?php echo e($row_teacher[2]) ?></td>
                  <td><div class="icon"><i class="ion ion-edit"></i></div></a></td>
                </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
		</div>				
<div class="box box-warning">
  		<div class="box-header with-border"></div>
      	         	  
	<div class="box-body"><strong><?php echo e($dispname) ?></strong></div>
	<div class="box-body">Teachers Detail Schedule
   	      
	</div>	      
<div class="box box-warning">
	  		<div class="box-header with-border"></div>
       	<table id="example1" class="table table-bordered table-striped">
                <thead>
                <?php
$query_schedule = q_set($__p_query_schedule, "SELECT date_format(mulai_tm,'%d %b %Y') as tgl, date_format(mulai_tm,'%k:%i') as jam_mulai ,date_format(selesai_tm,'%k:%i') as jam_selesai, nm_teacher, kelas, center, keterangan,dayname(mulai_tm),room FROM ves_data.vip_teacher_schedule where nm_teacher = ? and mulai_tm between ? and ? order by tgl, jam_mulai", [(string) ($kd_teacher), (string) ($start_date), (string) ($end_date)]);

$resource_schedule= db_query_or_die('errro_visitor1', $query_schedule, $__p_query_schedule ?? []);
?>
                <tr>
                  <th width="3%">No</th>
                  <th width="10%">Date</th>
                  <th width="10%">Time</th>
                  <th width="15%">Center</th>
                  <th width="13%">Room</th>
                  <th width="18%">Class Code</th>
                  <th width="31%">Remark</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($resource_schedule) 
						{ 
							$no_urut = 1;
						while ($row_schedule = db_fetch($resource_schedule))
							{
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($row_schedule[7])?><br>
                    <?php echo e($row_schedule[0])?> <br></td>
                  <td><?php echo e($row_schedule[1]) ?> - <?php echo e($row_schedule[2]) ?></td>
                  <td><?php echo e($row_schedule[5]) ?></td>
                  <td><?php echo e($row_schedule[8]) ?></td>
                  <td><?php echo e($row_schedule[4]) ?></td>
                  <td><?php echo e($row_schedule[6]) ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
          </table>
		</div>
   	    </div>
	  </div>
</form>


    <!-- Horizontal Form -->
          <!-- /.box -->
          <!-- general form elements disabled -->
		  
            
            <!-- /.box-header --><!-- /.box-body --><!-- /.box --><!--/.col (right) --><!-- /.row --><!-- /.content -->
  </div>
  <!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post"><?php echo csrf_field(); ?>

          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
</aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
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
</body>
</html>
