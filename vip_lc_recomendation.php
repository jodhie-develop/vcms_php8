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
    <h1>LC Recommendation Student<br>
    </h1>
 <form method=get action=vip_lc_recomendation.php> 	  
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
            <td><small>
            <label for="date2"> Search by Class Code</label>
            </small></td>
            <td><span class="form-group">
              <input name="cdcl"  class="form-control"  type="text" size="10" value="<?php echo e($cdcl) ?>" placeholder="class code you need to find" />
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
	            <td width=19% height="14" align=center >Student</td>
	            <td width=14% align=center >Class Code</td>
	            <td width="21%" align=center >Meeting #</td>
	            <td width="13%" align=center >Academic <br>
                Calendar</td>
	            <td width="16%" align=center >Coordination<br>
                Sheet</td>
	            <td width="17%" align=center >Recommendation</td>
	            <td width="17%" align=center >Action</td>
              </tr>
            </thead>

	        <tbody>
	          <?php	
	$adafile = 0;
if($student_name !='' and $cdcl !='')
	{
$query_lc_recomendation = q_set($__p_query_lc_recomendation, "SELECT a.nama_lengkap, l.kd_biodata, l.kd_class, l.tgl_meeting , l.lc_recommendation, b.center, b.nm_teacher, nm_program, b.level_program, a.idkey FROM ves_data.lc_student_history l\r
left join vip_student_data a on l.kd_biodata  = a.kd_biodata\r
left join vip_teacher_schedule b on l.kd_class = b.kelas and l.tgl_meeting = b.mulai_tm\r
left join vip_mst_code_prg c on b.kode_program = c.kd_program where kd_class like ? and nama_lengkap like ?\r
group by l.kd_biodata ", ["%" . (string) ($cdcl) . "%", "%" . (string) ($student_name) . "%"]); 		
	}
elseif($student_name !='' and $cdcl == '')
	{
$query_lc_recomendation = q_set($__p_query_lc_recomendation, "SELECT a.nama_lengkap, l.kd_biodata, l.kd_class, l.tgl_meeting , l.lc_recommendation, b.center, b.nm_teacher, nm_program, b.level_program, a.idkey FROM ves_data.lc_student_history l\r
left join vip_student_data a on l.kd_biodata  = a.kd_biodata\r
left join vip_teacher_schedule b on l.kd_class = b.kelas and l.tgl_meeting = b.mulai_tm\r
left join vip_mst_code_prg c on b.kode_program = c.kd_program where nama_lengkap like ?\r
group by l.kd_biodata ", ["%" . (string) ($student_name) . "%"]); 		
	}
elseif($student_name =='' and $cdcl != '')
	{
$query_lc_recomendation = q_set($__p_query_lc_recomendation, "SELECT a.nama_lengkap, l.kd_biodata, l.kd_class, l.tgl_meeting , l.lc_recommendation, b.center, b.nm_teacher, nm_program, b.level_program, a.idkey FROM ves_data.lc_student_history l\r
left join vip_student_data a on l.kd_biodata  = a.kd_biodata\r
left join vip_teacher_schedule b on l.kd_class = b.kelas and l.tgl_meeting = b.mulai_tm\r
left join vip_mst_code_prg c on b.kode_program = c.kd_program where kd_class  like ?\r
group by l.kd_biodata ", ["%" . (string) ($cdcl) . "%"]); 	
	}
else
	{
$query_lc_recomendation = q_set($__p_query_lc_recomendation, "SELECT a.nama_lengkap, l.kd_biodata, l.kd_class, l.tgl_meeting , l.lc_recommendation, b.center, b.nm_teacher, nm_program, b.level_program, a.idkey FROM ves_data.lc_student_history l\r
left join vip_student_data a on l.kd_biodata  = a.kd_biodata\r
left join vip_teacher_schedule b on l.kd_class = b.kelas and l.tgl_meeting = b.mulai_tm\r
left join vip_mst_code_prg c on b.kode_program = c.kd_program\r
group by l.kd_biodata order by l.id desc limit 10"); 	
	}
					 



$resource_lc_recomendation = db_query_soft($query_lc_recomendation, $__p_query_lc_recomendation ?? []);			
if(num(db_num_rows($resource_lc_recomendation)) > 0)
	{
	while ($row_lc_recomendation  =  db_fetch($resource_lc_recomendation, PDO::FETCH_NUM))
		{
		$nama_student = $row_lc_recomendation[0];
		$kd_biodata = $row_lc_recomendation[1];
		$kd_class = $row_lc_recomendation[2];
		$tgl_meeting  = $row_lc_recomendation[3];
		$lc_recommendation = $row_lc_recomendation[4];
		$center = $row_lc_recomendation[5];
		$nm_teacher = $row_lc_recomendation[6];
		$nama_program = $row_lc_recomendation[7];
		$level_program = $row_lc_recomendation[8];
		$idkey = $row_lc_recomendation[9];		
		//====meeting ke
		$query_meeting_ke = q_set($__p_query_meeting_ke, "select count(mulai_tm) from vip_teacher_schedule where kelas = ? and mulai_tm <=? and status_kelas = 1", [(string) ($kd_class), (string) ($tgl_meeting)]); 
		$resource_meeting_ke = db_query_soft($query_meeting_ke, $__p_query_meeting_ke ?? []);			
		if(num(db_num_rows($resource_meeting_ke)) > 0)
			{
			while ($row_meeting_ke  =  db_fetch($resource_meeting_ke, PDO::FETCH_NUM))
				{
				$meeting_ke = $row_meeting_ke[0];
				}
			}
		//=============
		//====meeting total
		$query_meeting_ttl = q_set($__p_query_meeting_ttl, "select count(mulai_tm) from vip_teacher_schedule where kelas = ?  and status_kelas = 1", [(string) ($kd_class)]); 
		$resource_meeting_ttl = db_query_soft($query_meeting_ttl, $__p_query_meeting_ttl ?? []);			
		if(num(db_num_rows($resource_meeting_ttl)) > 0)
			{
			while ($row_meeting_ttl  =  db_fetch($resource_meeting_ttl, PDO::FETCH_NUM))
				{
				$meeting_ttl = $row_meeting_ttl[0];
				}
			}
		//=============		
		
			
			
	?>
	          <tr>
	            <td align=left class="style24"><?php echo  e($nama_student)  ?><br>
	              idkey : <?php echo  e($idkey)  ?></td>
				  <td align=left class="style24">[<?php echo e($nm_teacher) ?>] - <?php echo  e($kd_class)  ?><br>				    
				    <?php echo  e($nama_program)  ?> 				    <?php echo  e($level_program)  ?></td>
	            <td align=center class="style24"><?php echo  e($tgl_meeting)  ?><br>	              <?php echo  e($meeting_ke)  ?> of <?php echo e($meeting_ttl) ?></td>
	            <td align=center class="style24"><?php if ($row_open_class[1] == 'LCSTBY') {?><a href= "acdcallc.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&kdcbg=<?php echo   e(u($row_open_class[10])) ?>" target="_blank"><?php } else {?><a href= "acdcal.php?kdcl=<?php echo e(u($kd_class)) ?>" target="_blank"> <?php } ?>View</a> <br></td>
	            <td align=center class="style24"><a href= "vip_crsh.php?kdcl=<?php echo e(u($kd_class)) ?>" target="_blank">View</a> <br></td>
	            <td align=left class="style24"><a href= "vip_lcrecomlist.php?kdb=<?php echo e(u($kd_biodata))?>&kdcl=<?php echo e(u($kd_class)) ?>" target="_blank">View</a></td>
	            <td align=center class="style24">Modify</td>
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
