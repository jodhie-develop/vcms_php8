<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";


$query_group = q_set($__p_query_group, "select no_emp, nm_emp from absensi.hr_absen where datetoday between '2019-06-10' and '2019-06-15' group by no_emp");
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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


      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-body">
              <table id="examples1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="4%">No</th>
                  <th width="11%">Student Name</th>
                  <th width="3%">10</th>
                  <th width="4%">11</th>
                  <th width="4%">12</th>
                  <th width="5%">13</th>
                  <th width="5%">14</th>
                  <th width="5%">15</th>
                  <th width="59%">TOTAL<br></th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					$no_urut = 1;
					$jmlhadir= 0;
					$resource_group = db_query_or_die('errro_17', $query_group, $__p_query_group ?? []);
					while ($row_group=  db_fetch($resource_group, PDO::FETCH_NUM))
						{
						$kd_emp = $row_group[0];
						$query_dtl = q_set($__p_query_dtl, "select datetoday from absensi.hr_absen where no_emp = ? and datetoday = '2019-06-10'", [(string) ($kd_emp)]);
					
						$resource_dtl = db_query_or_die('errro_7', $query_dtl, $__p_query_dtl ?? []);
						while ($row_dtl=  db_fetch($resource_dtl, PDO::FETCH_NUM))
							{
							$tgl10 = 1;
							$jmlhadir = num($jmlhadir) + 1;
							}
						$query_dtl = q_set($__p_query_dtl, "select datetoday from absensi.hr_absen where no_emp = ? and datetoday = '2019-06-11'", [(string) ($kd_emp)]);
						$resource_dtl = db_query_or_die('errro_7', $query_dtl, $__p_query_dtl ?? []);
						while ($row_dtl=  db_fetch($resource_dtl, PDO::FETCH_NUM))
							{
							$tgl11 = 1;
							$jmlhadir = num($jmlhadir) + 1;
								
							}
						$query_dtl = q_set($__p_query_dtl, "select datetoday from absensi.hr_absen where no_emp = ? and datetoday = '2019-06-12'", [(string) ($kd_emp)]);
						$resource_dtl = db_query_or_die('errro_7', $query_dtl, $__p_query_dtl ?? []);
						while ($row_dtl=  db_fetch($resource_dtl, PDO::FETCH_NUM))
							{
							$tgl12 = 1;
							$jmlhadir = num($jmlhadir) + 1;
								
							}
						$query_dtl = q_set($__p_query_dtl, "select datetoday from absensi.hr_absen where no_emp = ? and datetoday = '2019-06-13'", [(string) ($kd_emp)]);
						$resource_dtl = db_query_or_die('errro_7', $query_dtl, $__p_query_dtl ?? []);
						while ($row_dtl=  db_fetch($resource_dtl, PDO::FETCH_NUM))
							{
							$tgl13 = 1;
							$jmlhadir = num($jmlhadir) + 1;
								
							}
						$query_dtl = q_set($__p_query_dtl, "select datetoday from absensi.hr_absen where no_emp = ? and datetoday = '2019-06-14'", [(string) ($kd_emp)]);
						$resource_dtl = db_query_or_die('errro_7', $query_dtl, $__p_query_dtl ?? []);
						while ($row_dtl=  db_fetch($resource_dtl, PDO::FETCH_NUM))
							{
							$tgl14 = 1;
							$jmlhadir = num($jmlhadir) + 1;
								
							}
						$query_dtl = q_set($__p_query_dtl, "select datetoday from absensi.hr_absen where no_emp = ? and datetoday = '2019-06-15'", [(string) ($kd_emp)]);
						$resource_dtl = db_query_or_die('errro_7', $query_dtl, $__p_query_dtl ?? []);
						while ($row_dtl=  db_fetch($resource_dtl, PDO::FETCH_NUM))
							{
							$tgl15 = 1;
							$jmlhadir = num($jmlhadir) + 1;
								
							}							

								
								
							
								
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($row_group[1]) ?></td>
                  <td><?php echo e($tgl10) ; ?></td>
                  <td><?php echo e($tgl11)  ; ?></td>
                  <td><?php echo e($tgl12) ; ?></td>
                  <td><?php echo e($tgl13) ; ?></td>
                  <td><?php echo e($tgl14) ; ?></td>
                  <td><?php echo e($tgl15) ; ?></td>
                  <td><?php echo e($jmlhadir) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1;$tgl10 = 0;$tgl11 = 0;$tgl12 = 0;$tgl13 = 0;$tgl14 = 0;$tgl15 = 0;$jmlhadir = 0;
															
} ?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
     
      <div class="row">
        <div class="col-xs-12">
                         <div class="form-group">
                        </div></div>
        <!-- /.col -->
	  </div>

      <!-- /.row -->
  
         
          <!-- /.box -->
        </div>
        <!-- /.col -->
   </div>
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
