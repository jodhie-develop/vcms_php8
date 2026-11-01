<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndbs.php";


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
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
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
<?php //========================== left nav ?>
 <?php //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=""> 
  <div class="content">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Active Staff <br>
     </h1>
   </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example221">
               <?php				  


	$query = q_set($__p_query, "SELECT no_emp, h.nm_emp, h.id_area, h.id_branch, h.datetoday FROM hr_absen h where datetoday between '2017-07-01' and  '2019-06-3' and no_emp <>'' group by nm_emp  order by id_branch");

$nomor = 1;
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);				  
				  ?>
                <thead>
                <tr>
      <td width=2% height="28" align=center >No</td>
      <td width="7%" align=center >Emp Name</td>
      <td width="6%" align=center >Branch</td>
      <td width="6%" align=center >Start Working</td>
      <td width="14%" align=center >Last Date Working</td>
      <td width="8%" align=center >2014 Sem 1</td>
      <td width="8%" align=center >2014 Sem 2</td>
      <td align=center >2015 Sem 1</td>
      <td align=center >2015 Sem 2</td>
      <td align=center >2016 Sem 1</td>
      <td align=center >2016 Sem 2</td>
      <td align=center >2017 Sem 1</td>
      <td align=center >2017 Sem 2</td>
      <td align=center >2018 Sem 1</td>
      <td align=center >2018 Sem 2</td>
      <td align=center >2019 Sem 1</td>
      <td align=center >2019 Sem 2</td>
      <td width="8%" align=center >TOTAL</td>
      </tr>
                </thead>
                <tbody>
<?php
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$no_emp = $row[0];
		$nama_emp = $row[1];
		$cbg = $row[3];				
//start_working 
	$query_sw = q_set($__p_query_sw, "SELECT h.nm_emp, date_format(h.start_working,'%d %b %Y'), h.id_emp FROM hr_emp h where id_emp = ? ", [(string) ($no_emp)]);
$resource_sw = db_query_soft($query_sw, $__p_query_sw ?? []);
if(num(db_num_rows($resource_sw)) > 0)
	{
	while ($row_sw  =  db_fetch($resource_sw, PDO::FETCH_NUM))
		{
		$mulai = $row_sw[1];
		}
	}
//absen terakhir
//start_working 
	$query_last = q_set($__p_query_last, "SELECT date_format(h.datetoday,'%d %b %Y') FROM hr_absen h where no_emp = ? order by datetoday desc limit 1", [(string) ($no_emp)]);
$resource_last = db_query_soft($query_last, $__p_query_last ?? []);
if(num(db_num_rows($resource_last)) > 0)
	{
	while ($row_last  =  db_fetch($resource_last, PDO::FETCH_NUM))
		{
		$terakhir = $row_last[0];
		}
	}			
			
//===2014			
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2014-01-01' and '2014-06-30'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem1_14 = 1;}else {$sem1_14 = '';}
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2014-07-01' and '2014-12-31'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem2_14 = 1;}else {$sem2_14 = '';}
//===2015			
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2015-01-01' and '2015-06-30'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem1_15 = 1;}else {$sem1_15 = '';}
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2015-07-01' and '2015-12-31'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem2_15 = 1;}else {$sem2_15 = '';}
//===2016			
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2016-01-01' and '2016-06-30'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem1_16 = 1;}else {$sem1_16 = '';}
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2016-07-01' and '2016-12-31'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem2_16 = 1;}else {$sem2_16 = '';}			
			
//===2017			
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2017-01-01' and '2017-06-30'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem1_17 = 1;}else {$sem1_17 = '';}
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2017-07-01' and '2017-12-31'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem2_17 = 1;}else {$sem2_17 = '';}			
//===2018			
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2018-01-01' and '2018-06-30'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem1_18 = 1;}else {$sem1_18 = '';}
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2018-07-01' and '2018-12-31'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem2_18 = 1;}else {$sem2_18 = '';}
//===2019			
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2019-01-01' and '2019-06-30'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem1_19 = 1;}else {$sem1_19 = '';}
		$query_dtl = q_set($__p_query_dtl, "SELECT  count(datetoday)  FROM hr_absen where no_emp = ? and datetoday between '2019-07-01' and '2019-12-31'  group by no_emp", [(string) ($no_emp)]);
		$resource_dtl = db_query_soft($query_dtl, $__p_query_dtl ?? []);
		$aktif = db_num_rows($resource_dtl);
		if (num($aktif) >=1 ) {$sem2_19 = 1;}else {$sem2_19 = '';}					
?>	
    <tr>
      <td height="14" align=center class="style24"><?php echo e($nomor) ?></td>
      <td align=center class="style24"><?php echo e($nama_emp) ?></td>
      <td align=center class="style24"><?php echo  e($cbg) ?></td>
      <td align=center class="style24"><?php echo e($mulai) ?></td>
      <td align=center class="style24"><?php echo e($terakhir) ?></td>
      <td align=center class="style24"><?php echo e($sem1_14) ?></td>
      <td align=center class="style24"><?php echo e($sem2_14) ?></td>
      <td align=center class="style24"><?php echo e($sem1_15) ?></td>
      <td align=center class="style24"><?php echo e($sem2_15) ?></td>
      <td align=center class="style24"><?php echo e($sem1_16) ?></td>
      <td align=center class="style24"><?php echo e($sem2_16) ?></td>
      <td align=center class="style24"><?php echo e($sem1_17) ?></td>
      <td align=center class="style24"><?php echo e($sem2_17) ?></td>
      <td align=center class="style24"><?php echo e($sem1_18) ?></td>
      <td align=center class="style24"><?php echo e($sem2_18) ?></td>
      <td align=center class="style24"><?php echo e($sem1_19) ?></td>
      <td align=center class="style24"><?php echo e($sem2_19) ?></td>
      <td align=center class="style24"></td>
      </tr>
<?php 
$nomor = num($nomor)+1; $sem1_14 = '';$sem2_14 = '';$sem1_15 = '';$sem2_15 = '';$sem1_16 = '';$sem2_16 = '';$sem1_17 = '';$sem2_17 = '';}} 

 ?>
                <tfoot>
                </tfoot>
                
              </table>
   
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
	  </div></div>

      <!-- /.row -->
   </section>
   <section class="content">
      <div class="row">
        <!-- /.col -->
     </div></div>

     <!-- /.row -->
   </section>
   
    <!-- /.content -->
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
</div>
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
