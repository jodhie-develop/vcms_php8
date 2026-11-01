<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;

$group = in_val('group', 'post');
$category = in_val('category', 'post');
$program = in_val('program', 'post');
$level = in_val('level', 'post');
$skill = in_val('skill', 'post');
$description = in_val('description', 'post');
$keyword = in_val('keyword', 'post');



?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head><?php //========================== left nav ?>
<?php   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 
  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Material Upload</h1>
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
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Quick Example</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="material_input.php" role="form" enctype="multipart/form-data" ><?php echo csrf_field(); ?> 
              <div class="box-body">
<div class="form-group">
                  <label>Group</label>
                  <select class="form-control" name="group" value="<?php echo e($group) ?>">
                    <option>Material</option>
                    <option>Practice</option>
                    <option>ACM</option>
                    <option>LC</option>
                  </select>
                </div>              
<div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category" value="<?php echo e($group) ?>">
                    <option>Audio</option>
                    <option>Software</option>
                    <option>Printable</option>
                    <option>Download</option>
                  </select>
                </div>              
               <div class="form-group">
                  <label>Program</label>
                  <select class="form-control"  name="program" onChange="this.form.submit()" >
                    <option>NG-TOEFL</option>
                    <option>IELTS</option>
                    <option>AE</option>
                    <option>GE</option>
                    <option>BE</option>
                    <option>Taylor Made</option>                                        
					<option>PBT</option>
                 	<option selected><?php echo e($program) ?></option>                                        
                  </select>
                </div>
            <div class="form-group">
                  <label>Level</label>
                  <select class="form-control" name="level">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                 	<option selected><?php echo e($level) ?></option>                           
                  </select>
                </div> 
				<div class="form-group">
                  <label>Skill</label>
                  <select class="form-control" name="skill">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
					<option selected><?php echo e($skill) ?></option>                    
                  </select>
                </div>                   
                <div class="form-group">
                  <label for="exampleInputEmail1">Material Description</label>
                  <input type="text"  name ="description" class="form-control" id="exampleInputEmail1" placeholder="Description" required ="required">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Keyword</label>
                  <input type="text" name="keyword" class="form-control" id="exampleInputPassword1" placeholder="keyword" required = "required">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                 <input id="middle-name2" class="form-control col-md-7 col-xs-12" required="required" type="file" name="file_array[]">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <a href="materialsave.php" class="btn btn-info" role="button">Save Material</a></div>
            </form>
          </div>
          <!-- /.box -->

          <!-- Form Element sizes -->
          <!-- /.box -->
          <!-- /.box -->

          <!-- Input addon -->
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
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
</body>
</html>
<?php 
if (isset($_POST['Submit'])) 
{


date_default_timezone_set('Asia/Jakarta'); 		

$nama_lengkap = $_SESSION['nama_lengkap'];

$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;
$jamskrg= date('h:i:s', time());
$hari_ini = date('Y-m-d');	
$group = in_val('group', 'post');
$category = in_val('category', 'post');
$program = in_val('program', 'post');
$level = in_val('level', 'post');
$skill = in_val('skill', 'post');
$description = in_val('description', 'post');
$keyword = in_val('keyword', 'post');

//====upload
if(isset($_FILES['file_array']))
	{
	$i=0;
	$name_array = array_map(fn($k) => upload_random_name('file_array', $k), array_keys((array) $_FILES['file_array']['name']));   // nama acak, ekstensi asli
	$tmp_name_array = $_FILES['file_array']['tmp_name'];
	$type_array = $_FILES['file_array']['type'];
	$size_array = $_FILES['file_array']['size'];
	$error_array = $_FILES['file_array']['error'];
	//===autonumber
	$query = q_set($__p_query, "SELECT MAX(no) as no FROM ves_data.acd_material ");
	$result = db_query_soft($query, $__p_query ?? []);
	$data = $result->fetch();
	$id_max = $data['no'];
	$sort_num = $id_max;
	$sort_num++;
	$new_code = sprintf($sort_num);
	$kode_material= "$group$program$skill$new_code";
		
	$gambar_material = $kode_material.$name_array;
	$hari_ini = date('Y-m-d');
	$query_simpan= q_set($__p_query_simpan, "insert into ves_data.acd_material (material_group, material_category, material_program, material_level, material_skill, material_description, material_keyword, material_dt_update, material_pic, material_gambar, material_kode, nama_asli)\r
\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($group), (string) ($category), (string) ($program), (string) ($level), (string) ($skill), (string) ($description), (string) ($keyword), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kode_material) . (string) ($name_array[$i]), (string) ($kode_material), upload_display_name('file_array', $i)]);

	$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
	for($i = 0; $i < cnt($tmp_name_array); $i++)
		{
		if(upload_move('file_array', upload_allow('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx'), "gbmaterial/".$kode_material.$name_array[$i], 20 * 1024 * 1024, $i))
			{
			echo e($name_array[$i])." upload is complete<br>";
			} 
		else 
			{
			 echo "move_uploaded_file function failed for ".e($mbr_noktp).e($name_array[$i])."<br>";
			}
		}	
	}
	//echo "<script type=\"text/javascript\">\n";
	//echo "alert('Materi sudah terupload,');\n";
	//echo "window.location = ('material_list.php');\n";				
//	echo "</script>";		
//=====
}
?>