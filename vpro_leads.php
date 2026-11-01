<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
 include __DIR__ . "/left.php";	 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$nature = in_val('nature', 'get');

$progress = in_val('progress', 'get');
if($nature == '' or $nature == '--All--') {$flt_nature = '';}else {$flt_nature = q_set($__p_flt_nature, " comp_type = ? ", [(string) ($nature)]);}
if($progress == '' or $progress == '--All--') {$flt_progress = '';}else {$flt_progress = q_set($__p_flt_progress, " comp_progress = ? ", [(string) ($progress)]);}

if($flt_nature =='' and $flt_progress == ''){$query_flt = '';}
elseif($flt_nature =='' and $flt_progress != ''){$query_flt = q_set($__p_query_flt, "where " . $flt_progress, [...($__p_flt_progress ?? [])]);}
elseif($flt_nature !='' and $flt_progress == ''){$query_flt = q_set($__p_query_flt, "where " . $flt_nature, [...($__p_flt_nature ?? [])]);}
elseif($flt_nature !='' and $flt_progress != ''){$query_flt = q_set($__p_query_flt, "where " . $flt_nature . " and " . $flt_progress, [...($__p_flt_nature ?? []), ...($__p_flt_progress ?? [])]);}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vpro Leads</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="ionicons.min.css">
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
<body class="hold-transition skin-blue sidebar-mini">



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
    	<form name="myform" id="myform">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Company<br>
              </h3>
              <br>
              <div class="col-xs-12">
                <button  onclick="window.location.href='vpro_leads_new.php';" type="button" class="btn btn-block btn-success btn-sm">New Company</button>
              </div>
              <br>
<br>
<div class="col-xs-5">
  <div class="form-group">
    <label for="exampleInputEmail15">Nature of Bussiness</label>
    <select class="form-control" name="nature"  onChange="this.form.submit()">
		      <option>--All--</option>
		      <?php

$query_vpro_nature = q_set($__p_query_vpro_nature, "SELECT nama  FROM ves_data.vpro_nature_of_bisnis  order by nama ");

$resource_vpro_nature = db_query_or_die('errro_7', $query_vpro_nature, $__p_query_vpro_nature ?? []);

	while ($row_nature=  db_fetch($resource_vpro_nature, PDO::FETCH_NUM))
		{	
							  		echo '<option value="'.e($row_nature[0]).'">'.e($row_nature[0]).'</option>';
							  		}      ?>
		      <option selected="<?php echo e($nature) ?>"><?php echo e($nature) ?></option>
                  </select>
  </div>
</div>
<div class="col-xs-3">
  <div class="form-group">	
                  <label>Status Progress</label>
                  <select name="progress" class="form-control" onChange="this.form.submit()">
					  
                    <option>--All--</option>					  
                    <option>N/A</option>
                                       <option>P</option>
					                      <option>E</option>
					                      <option>NP</option>
                    <option selected="selected"><?php echo e($progress) ?></option>
                  </select>
	  </div>	  
                </div>
            </div>
			  
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
             
                <tr>
                  <th>ID</th>
                  <th>Nama Perusahaan</th>
                  <th>Alamat</th>
                  <th>Kota</th>
                  <th>Contact Person</th>
                  <th>Status</th>
                  <th>Remark</th>
                  <th>Action</th>
                  </tr>
               
                <tbody>
                <tr>
                  <td>&nbsp;</td>
                  <td>            <input class="form-control input-sm" type="text" placeholder="Pencarian"></td>
                  <td><input class="form-control input-sm" type="text" placeholder="Pencarian"></td>
                  <td><input class="form-control input-sm" type="text" placeholder="Pencarian"></td>
                  <td><input class="form-control input-sm" type="text" placeholder="Pencarian"></td>
                  <td>&nbsp;</td>
                  <td><input class="form-control input-sm" type="text" placeholder="Pencarian"></td>
                  <td>&nbsp;</td>
                  </tr>
               
<?php 
	$no_urut = 1;
$query_leads = q_set($__p_query_leads, "SELECT id,  comp_name, comp_address, comp_type, cp_nama, cp_telepon, cp_email, last_remark,comp_progress FROM vpro_company_data " . $query_flt . " order by id desc", [...($__p_query_flt ?? [])]);

$resource_leads = db_query_or_die('errro_7', $query_leads, $__p_query_leads ?? []);
if(num(db_num_rows($resource_leads))>0){

	while ($row_leads=  db_fetch($resource_leads, PDO::FETCH_NUM))
		{						
?>					
                  <tr>
                    <td><?php echo e($no_urut); ?></td>
					  <td><a href="#" target="popup" onclick="window.open('vpro_leads_upd.php?id=<?php echo e(u($row_leads[0])); ?>','popup','width=1000,height=800'); return false;"><?php echo e($row_leads[1]) ?></a> <br>
  <?php echo e($row_leads[3]) ?></td>
					<td><?php echo e($row_leads[2]) ?> </td>
					<td><?php echo e($row_leads[4]) ?><br></td>
					<td><?php echo e($row_leads[4]) ?><br>					  <?php echo e($row_leads[5]) ?>  <?php echo e($row_leads[6]) ?></td>
					<td><?php echo e($row_leads[4]) ?></td>
					<td><?php echo e($row_leads[7]) ?> </td>
					<td><a href="#" target="popup" onclick="window.open('vpro_leads_student.php?id=<?php echo e(u($row_leads[0])); ?>','popup','width=1000,height=800'); return false;"><img src="images/vpro_modif.png" width="22" height="22" alt=""/></a></td>
                  </tr>
<?php $no_urut = num($no_urut)+1; }}?>					
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
			</form>			
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
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
