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
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');

if ($date_start ==''){$date_start = "2023-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$student_name = in_val('student_name', 'get');
$cdcl = in_val('cdcl', 'get');

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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>LC Student Record<br>
    </h1>
 <form method=get action=#> 	  
    <table width="453" border="0">
        <tbody>
          <tr>
            <td width="148">&nbsp;</td>
            <td width="289">&nbsp;</td>
          </tr>
          <tr>
            <td><small>
            <label for="date4"> Search by Name</label></small></td>
            <td><span class="form-group">
              <input name="student_name"  class="form-control"  type="text" size="10" value="<?php echo e($student_name) ?>" placeholder="Name you need to find" />
            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><span class="form-group">
            <input type="submit" name="submit" id="submit" value="Submit">
            </span></td>
          </tr>
        </tbody>
    </table>
	  </form>
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
	            <td width=11% align=center >Branch</td>
	            <td width=19% height="14" align=center >Student</td>
	            <td width=17% align=center >Teacher - Class Code</td>
	            <td width="9%" align=center >Number of <br>
	              LC Visit</td>
	            <td width="9%" align=center >Total Duration (H)</td>
	            <td width="35%" align=center >Detail Information</td>
              </tr>
            </thead>

	        <tbody>
	          <?php	
	$adafile = 0;if($student_name ==''){die;}
else
	{
$query_lc_pax = q_set($__p_query_lc_pax, "SELECT \r
case when a.kd_branch = 1 then 'East Sby'\r
when a.kd_branch = 2 then 'West Sby'\r
when a.kd_branch = 3 then 'Denpasar'\r
when a.kd_branch = 4 then 'South Jkt'\r
when a.kd_branch = 5 then 'NOrth Jkt'\r
when a.kd_branch = 6 then 'West Jkt'\r
when a.kd_branch = 7 then 'Bandung'\r
when a.kd_branch = 8 then 'Malang'\r
when a.kd_branch = 11 then 'PIK' end\r
\r
, \r
a.kd_biodata,nama_lengkap, kelas,nm_teacher, count(mulai_tm),\r
sum(TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') ) as durasi_jam,sum(\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') ) as durasi_menit,idkey  FROM vip_teacher_schedule b\r
left join vip_student_data a on b.kd_biodata = a.kd_biodata\r
where nama_lengkap like ? and kelas like '%LC Visit' and idkey <> ''\r
group by kelas,b.kd_biodata order by kelas, mulai_tm desc ", ["%" . (string) ($student_name) . "%"]); 		
	}
$resource_lc_pax = db_query_soft($query_lc_pax, $__p_query_lc_pax ?? []);			
if(num(db_num_rows($resource_lc_pax)) > 0)
	{
	while ($row_lc_pax  =  db_fetch($resource_lc_pax, PDO::FETCH_NUM))
		{	
		$cbg_info = $row_lc_pax[0];
		$nama_student = $row_lc_pax[2];
		$kd_biodata = $row_lc_pax[1];
		$kd_class = $row_lc_pax[3];
		$nm_teacher = $row_lc_pax[4];
		$jml_visit = $row_lc_pax[5];
		$idkey = $row_lc_pax[8];
		$dur_jam = $row_lc_pax[6];
		$dur_menit = $row_lc_pax[7];
		
	
			
			
	?>
	          <tr>
	            <td align=left class="style24"><?php echo  e($cbg_info)  ?></td>
	            <td align=left class="style24"><?php echo  e($nama_student)  ?><br>
	              idkey : <?php echo  e($idkey)  ?></td>
				  <td align=left class="style24">[<?php echo e($nm_teacher) ?>] - <?php echo  e($kd_class)  ?></td>
	            <td align=center class="style24"><?php echo  e($jml_visit)  ?><br></td>
	            <td align=center class="style24"><?php echo  e($dur_jam)  ?><br></td>
	            <td align=left class="style24">
  <?php
$query_detail = q_set($__p_query_detail, "SELECT date_format(mulai_tm,'%d %b %y'),date_format(mulai_tm,'%H:%S'), date_format(selesai_tm,'%H:%S'), keterangan, dtl_keterangan, nm_teacher FROM vip_teacher_schedule where kd_biodata = ? and kelas = ? ", [(string) ($kd_biodata), (string) ($kd_class)]); 
$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);			
if(num(db_num_rows($resource_detail)) > 0)
	{
	while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
		{
		?>
	              <?php echo e($row_detail[0]) ?> <?php echo e($row_detail[1]);?> <?php echo e($row_detail[2]) ?>/<?php echo e($row_detail[3]) ?>/<?php echo e($row_detail[4])?>/<?php echo e($row_detail[5]); ?> <br>			
  <?php					
		}
	}		
?>		
                </td>
              </tr>
	          <?php 	$adafile = 0; 				$jadwal_1= '';
				$baris_jadwal = ''; 
				$nmfile ='';					
				$lokasifile = '';}} ?>
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
