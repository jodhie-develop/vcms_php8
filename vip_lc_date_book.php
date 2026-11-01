<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
 include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$opt_date = in_val('opt_date', 'get'); if($opt_date ==''){$opt_date = 'Current';}


$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=#> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>LC Open Date<br>
    </h1>
    <div class="col-md-3">
    <div class="form-group">

      <select class="form-control" name="opt_date"  onChange="this.form.submit()">
        <option>Past</option>
        <option>Current</option>		  
        <option selected><?php echo e($opt_date) ?></option>
      </select>
    </div>
  </div>
  </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-12">
		<div class="form-group">
		  <label>Class List</label>
		</div>				
	  </div>
		
	  <div class="col-md-12">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td width=18% align=center >Date Open</td>
	            <td width=18% align=center >Status</td>
	            <td width=18% height="14" align=center >Student</td>
	            <td width="18%" align=center >Action</td>
              </tr>
            </thead>

	        <tbody>
	          <?php	
	$adafile = 0;
if ($opt_date == 'Current')
	{
	$query_lc_open = q_set($__p_query_lc_open, "SELECT date_format(mulai_tm,'%d %b %Y'),nm_teacher,  date_format(mulai_tm,'%H:%i'), date_format(selesai_tm,'%H:%i'),status_kelas,mulai_tm, id FROM ves_data.vip_teacher_schedule\r
\twhere mulai_tm >=? and  (status_kelas = 700 or status_kelas = 701 or status_kelas = 702 or status_kelas = 703 ) group by mulai_tm, nm_teacher order by mulai_tm", [(string) ($hari_ini)]); 	
	}
else
	{
	$query_lc_open = q_set($__p_query_lc_open, "SELECT date_format(mulai_tm,'%d %b %Y'),nm_teacher,  date_format(mulai_tm,'%H:%i'), date_format(selesai_tm,'%H:%i'),status_kelas,mulai_tm, id FROM ves_data.vip_teacher_schedule\r
\twhere mulai_tm <? and (status_kelas = 700 or status_kelas = 701 or status_kelas = 702 or status_kelas = 703 ) group by mulai_tm, nm_teacher order by mulai_tm", [(string) ($hari_ini)]); 	
	}

$resource_lc_open = db_query_soft($query_lc_open, $__p_query_lc_open ?? []);			
if(num(db_num_rows($resource_lc_open)) > 0)
	{
	while ($row_lc_open  =  db_fetch($resource_lc_open, PDO::FETCH_NUM))
		{

		$tgl_meeting  = $row_lc_open[0];
		$jam_mulai  = $row_lc_open[2];
		$jam_selesai  = $row_lc_open[3];
		$nm_teacher  = $row_lc_open[1];
		$mulai_tm  = $row_lc_open[5];
		
		
		$status_lc_open = $row_lc_open[4];		
		$id_lc_booking = $row_lc_open[6];		
		$query_lc_booking = q_set($__p_query_lc_booking, "SELECT * FROM ves_data.lc_meeting where tgl_meeting = ?  and nm_teacher = ? group by kd_biodata", [(string) ($mulai_tm), (string) ($nm_teacher)]);
		
		$resource_lc_booking = db_query_soft($query_lc_booking, $__p_query_lc_booking ?? []);
		$jml_student = db_num_rows($resource_lc_booking);
		
		
		if($status_lc_open =='700'){$status_lc_open_display = "Listed";}
		elseif($status_lc_open =='701'){$status_lc_open_display = "Booked";}
		elseif($status_lc_open =='702'){$status_lc_open_display = "Opened";}
		elseif($status_lc_open =='703'){$status_lc_open_display = "Closed";}

		
			
	?>
	          <tr>
	            <td align=left class="style24"><?php echo e($tgl_meeting) ?> [<?php echo e($jam_mulai) ?> - <?php echo e($jam_selesai) ?>] - <?php echo  e($nm_teacher)  ?></td>
	            <td align=left class="style24"><?php echo  e($status_lc_open_display)  ?></td>
	            <td align=left class="style24"><a href="#" 
target="popup" 
onclick="window.open('vip_lc_student_book.php?id=<?php echo e(u($id_lc_booking)) ?>&s=2','popup','width=450,height=350'); return false;"><?php echo  e($jml_student)   ?></a></td>
	            <td align=center class="style24"><a class="btn btn-primary btn-xs" href="#" 
target="popup" 
onclick="window.open('vip_lc_book_upd.php?id=<?php echo e(u($id_lc_booking)) ?>&s=1','popup','width=300,height=200'); return false;">Approve</a>  <a class="btn btn-danger btn-xs" href="#" 
target="popup" 
onclick="window.open('vip_lc_book_upd.php?id=<?php echo e(u($id_lc_booking)) ?>&s=2','popup','width=300,height=200'); return false;">Reject</a></td>
              </tr>
	          <?php				$jml_student = ''; 
				}} ?>
            </tbody>
	        <tfoot>
            </tfoot>
          </table>
	    </div>
            <!-- /.box-body -->
      </div>
          <!-- /.box -->
    </div>
        <!-- /.col -->
      </div>
      <!-- /.row --><!-- /.content -->
	</form> 
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
  <!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
