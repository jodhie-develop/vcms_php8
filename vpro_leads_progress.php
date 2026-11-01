<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";	 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$id = in_val('id', 'any');
$nama_lengkap = $_SESSION['nama_lengkap'];
$query_get_leads = q_set($__p_query_get_leads, "SELECT comp_name, comp_id, comp_address, comp_type, comp_size, comp_phone, comp_email, comp_website, comp_media_source, comp_remark, comp_add_information,cp_nama, cp_jabatan, cp_telepon, cp_email,dt_entry,pic FROM vpro_company_data where  id =? ", [(string) ($id)]);

$resource_get_leads = db_query_or_die('errro_7', $query_get_leads, $__p_query_get_leads ?? []);
if(num(db_num_rows($resource_get_leads))>0){

	while ($row_get_leads=  db_fetch($resource_get_leads, PDO::FETCH_NUM))
		{
$vpro_nama = $row_get_leads['0'];
$vpro_kategori = $row_get_leads['3'];
$vpro_prop = $row_get_leads[''];
$vpro_kab = $row_get_leads[''];
$vpro_alamat = $row_get_leads['2'];
$vpro_telepon =$row_get_leads['5'];
$vpro_email = $row_get_leads['6'];
$vpro_website = $row_get_leads['7'];
$vpro_cp_nama = $row_get_leads['11'];
$vpro_cp_jabatan = $row_get_leads['12'];
$vpro_cp_phone = $row_get_leads['13'];
$vpro_cp_email =$row_get_leads['14'];
$vpro_source =$row_get_leads['9'];
$vpro_source_remark = $row_get_leads['8'];
$vpro_add_remark = $row_get_leads['10'];
$vpro_jml_kary = $row_get_leads['4'];
		}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VPRO Leads</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="ionicons.min.css">
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
  <div class="content">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Corporate Information</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
    	<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>

            <div class="box-body">
			                  <div class="col-xs-6">				  
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Perusahaan</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="vpro_nama" placeholder="Nama Perusahaan (termasuk PT/CV/UD dll)" value="<?php echo e($vpro_nama) ?>" readonly>
                </div>
				  </div>
              <span class="form-group">
<input type="hidden" class="form-control" id="exampleInputEmail2" name="id" placeholder="Nama Perusahaan (termasuk PT/CV/UD dll)" value="<?php echo e($id) ?>">
</span></div>
              <div class="box-body"></div>
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Sales Activities</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
                <!-- text input -->
                <div class="col-xs-8">
                  <div class="form-group">
                    <label>New Progress</label>
                    <textarea class="form-control" name="vpro_add_remark" rows="3" placeholder="Enter ..."  value="<?php echo e($vpro_source_remark) ?>"></textarea>
                  </div>
              </div>
                <div class="col-xs-5">
                  <label>Offering Package</label>
                  <input type="number" name="offering_rp" class="form-control" placeholder="In Rupiah" value="<?php echo e($offering_rp) ?>">
                </div>
              <div class="col-xs-3">
                  <label>Offering Pax</label>
                  <input type="number" name="offering_pax" class="form-control" placeholder="In Pax" value="<?php echo e($offering_pax) ?>">
                </div>
              <div class="col-xs-4">
                <label>Intake Plan</label>
                  <input name="intake"  class="form-control"  type="month" value="<?php echo e($intake) ?>"  />
              </div>
                <div class="col-xs-4">
                  <label>Status Progress</label>
                  <select name="status" class="form-control">
                    <option>N/A</option>
                                       <option>P</option>
					                      <option>E</option>
					                      <option>NP</option>
                    <option selected="selected"><?php echo e($vpro_data_source) ?></option>
                  </select>
              </div>



          </div>
	              <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>				  
                <button type="submit" name="Save"  id="Save" class="btn btn-info pull-right">Save</button>
				  
              </div>
            <!-- /.box-body -->
          </div>				
            </div>				
            <!-- /.box-body -->

            </form>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{

	$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = date("Y-m-d H:i:s");
$id = in_val('id', 'any');
$vpro_add_remark = in_val('vpro_add_remark', 'any');
$offering_rp = in_val('offering_rp', 'any');
$offering_pax = in_val('offering_pax', 'any');
$intake = in_val('intake', 'any');
$intake = "$intake-15";	
$status = in_val('status', 'any');
$nama_lengkap = $_SESSION['nama_lengkap'];
	
$query_simpan_company = q_set($__p_query_simpan_company, "insert into  vpro_progress (id_comp, remark, offering_rp, offering_pax, intake, status, pic, dt_entry) values (? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($id), (string) ($vpro_add_remark), (string) ($offering_rp), (string) ($offering_pax), (string) ($intake), (string) ($status), (string) ($nama_lengkap), (string) ($hari_ini)]);
$resource_vpro_simpan = db_query_or_die('errro_17', $query_simpan_company, $__p_query_simpan_company ?? []);	

$query_update = q_set($__p_query_update, "update vpro_company_data set last_remark = ? ,comp_progress = ? where id = ? ", [(string) ($vpro_add_remark), (string) ($status), (string) ($id)]);
$resource_update = db_query_or_die('errro_27', $query_update, $__p_query_update ?? []);	
	
	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Progress added Succesfully');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";

	}}
?>			
          </div>

          <!-- /.box -->

        </div>

        <!--/.col (right) -->
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
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
