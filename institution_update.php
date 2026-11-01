<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
//SELECT t.school, t.kd_school, t.country, t.ap_np, t.grade, t.comm, t.groupschool, t.st_prioritas, t.expired_date, t.update_date FROM ves_data.tb_master_partner t;
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
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="cdnjs/ionicons.min.css">
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
 <?php // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Institution Update
        
      </h1>
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
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
         
          <!-- Horizontal Form -->
 <form method="post" name="myform" id="myform"><?php echo csrf_field(); ?>          
          <div class="box box-info">
          <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post"><?php echo csrf_field(); ?>

              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword4" class="col-sm-2 control-label">Institution Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="school" class="form-control" id="inputPassword4" placeholder="Institution Name">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                    <select name="country" class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                </div>
<div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Group of Institution</label>
                  <div class="col-sm-10">
                    <select name="groupschool" class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                </div>   
<div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Partnership</label>
                  <div class="col-sm-10">
                    <select name="pnp" class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                </div>
<div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Star</label>
                  <div class="col-sm-10">
                    <select name="grade" class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                </div>                                                        
<div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Key Partner</label>
                  <div class="col-sm-10">
                    <select name="keypartner" class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                </div>                             
                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Leaving Achievement</label>

                  <div class="col-sm-10">
                    <input type="text" name="leaving"class="form-control" id="inputPassword3" placeholder="Leaving Achievement">
                  </div>
                </div> 
<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Website Profile</label>

                  <div class="col-sm-10">
                    <input type="text" name="website" class="form-control" id="inputPassword3" placeholder="Website">
                  </div>
                </div> 
<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Expired</label>

                  <div class="col-sm-10">
                    <input type="date" name="expired" class="form-control" id="inputPassword3" placeholder="Password">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right" name="submit">Update</button>
              </div>
              <!-- /.box-footer -->
          </form>
        </div>
			</form>
          <!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->
      </div>
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
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))) 
{
$jamskrg= date('h:i:s', time());

$tanggal_hri = date('Y-m-d');
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ; 
$flt_country1 = in_val('flt_country1', 'any');
$first_name = in_val('first_name', 'any');
if ($first_name=='')
	{
	if (num($statussimpan)==0){$pesan="First Name ";}
	$statussimpan=1;
	}
$middle_name = in_val('middle_name', 'any');
if ($middle_name=='')
	{
	if (num($statussimpan)==0){$pesan="middle_name ";}
	$statussimpan=1;
	}
$gender = in_val('gender', 'any');
if ($gender=='')
	{
	if (num($statussimpan)==0){$pesan="gender ";}
	$statussimpan=1;
	}

$family_name = in_val('family_name', 'any');
$dob_dd = in_val('dob_dd', 'any');
$dob_mm = in_val('dob_mm', 'any');
$dob_yy = in_val('dob_yy', 'any');
$tgl_lahir = "$dob_yy-$dob_mm-$dob_dd";	
$address = in_val('address', 'any');
if ($address=='')
	{
	if (num($statussimpan)==0){$pesan="address ";}
	$statussimpan=1;
	}
$student_city = in_val('student_city', 'any');
if ($student_city=='')
	{
	if (num($statussimpan)==0){$pesan="city ";}
	$statussimpan=1;
	}
$area = in_val('area', 'any');
$phone = in_val('phone', 'any');
$hp1 = in_val('hp1', 'any');
if ($hp1=='')
	{
	if (num($statussimpan)==0){$pesan="hp  ";}
	$statussimpan=1;
	}
$hp2 = in_val('hp2', 'any');
$e_mail = in_val('e_mail', 'any');
if ($e_mail=='')
	{
	if (num($statussimpan)==0){$pesan="e_mail  ";}
	$statussimpan=1;
	}
	
//==sosmed
$fb = in_val('fb', 'any');
$twitter = in_val('twitter', 'any');
$instagram = in_val('instagram', 'any');
$path = in_val('path', 'any');
$line = in_val('line', 'any');
$wa = in_val('wa', 'any');
if ($fb !='')
	{
	$sosmed = "$sosmed fb = $fb ";
	}
if ($twitter !='')
	{
	$sosmed = "$sosmed twitter = $twitter ";
	}
if ($instagram !='')
	{
	$sosmed = "$sosmed instagram = $instagram ";
	}
if ($path !='')
	{
	$sosmed = "$sosmed path = $path ";
	}
if ($line !='')
	{
	$sosmed = "$sosmed line = $line ";
	}
if ($wa !='')
	{
	$sosmed = "$sosmed wa = $fb ";
	}
//====
$ves_remark = in_val('ves_remark', 'any');
$vip_remark = in_val('vip_remark', 'any');
$vip_program = in_val('vip_program', 'any');	
$school_city = in_val('school_city', 'any');
if ($school_city=='')
	{
	if (num($statussimpan)==0){$pesan="school city  ";}
	$statussimpan=1;
	}
$other_school = in_val('other_school', 'any');	
$other_school_dest = in_val('other_school_dest', 'any');	


$school_level = in_val('school_level', 'any');


if ($school_name=='')
	{
	if (num($statussimpan)==0){$pesan="school name";}
	$statussimpan=1;
	}
$school_grade = in_val('school_grade', 'any');
if ($school_grade=='')
	{
	if (num($statussimpan)==0){$pesan="school_grade";}
	$statussimpan=1;
	}
$flt_country1 = in_val('flt_country1', 'any');
$flt_school1 = in_val('flt_school1', 'any');
if ($flt_school1 != '')
	{
	$query_kd_school = q_set($__p_query_kd_school, "SELECT  kd_school FROM ves_data.tb_master_partner t where school = ? and (country = ? or country = 'OTHER')", [(string) ($flt_school1), (string) ($flt_country1)]);
	$resource_kd_school = db_query_or_die('errro_kd_school1', $query_kd_school, $__p_query_kd_school ?? []);
	$keluar_kd_school= db_num_rows($resource_kd_school);
	if(num(db_num_rows($resource_kd_school)) > 0)
		{
		while ($row_kd_school=  db_fetch($resource_kd_school, PDO::FETCH_NUM))
			{
			$kd_school1= $row_kd_school[0];				
			}
		} 
	}

$flt_program1 = in_val('flt_program1', 'any');

$parent_name = in_val('parent_name', 'any');
$parent_address = in_val('parent_address', 'any');
$parent_city = in_val('parent_city', 'any');
$parent_hp = in_val('parent_hp', 'any');
$parent_email = in_val('parent_email', 'any');
$school_city = in_val('school_city', 'any');
$mkt_source_event = in_val('mkt_source_event', 'any');
$mkt_source_event_dtl = in_val('mkt_source_event_dtl', 'any');
if ($mkt_source_event_dtl=='')
	{
	if (num($statussimpan)==0){$pesan="Source Detail ";}
	$statussimpan=1;
	}
$media_source = in_val('media_source', 'any');
if ($media_source=='')
	{
	if (num($statussimpan)==0){$pesan="media_source ";}
	$statussimpan=1;
	}
$media_source_dtl = in_val('media_source_dtl', 'any');
if ($media_source_dtl=='')
	{
	if (num($statussimpan)==0){$pesan="media source dtl ";}
	$statussimpan=1;
	}
$kd_student = in_val('kd_student', 'any');
$jamskrg= date('h:i:s', time());
$nama_depan= $_SESSION['nama_depan']; 
$tanggal_hri = date('Y-m-d');
$kodetgl = date('ymd');
$event_st_dtl = in_val('event_st_dtl', 'any');	

//==========other
if ($school_name =='Other') 
	{
	$school_name = $other_school;
	}
//====
if ( $flt_country1 == 'OTHER' || $flt_school1 =='OTHER') 
	{ 
	$flt_school1 = $other_school_dest; 
	$kd_school1 = 'Other';
	}


if (num($statussimpan)==0)
	{
//===autonumber
	$query = q_set($__p_query, "SELECT MAX(t.no) as max_id FROM ves_inc.tb_biodata t where kd_branch = ? and (kd_biodata is not null or kd_biodata <>'')", [(string) ($kd_cbg)]);
	$result = db_query_soft($query, $__p_query ?? []);
	$data = db_fetch($result);
	$id_max = $data['max_id'];
	$sort_num = $id_max;
	$sort_num++;
	$new_code = sprintf($sort_num);
	$kode_biodata = "$kodetgl$kd_cbg$kd_staff$new_code";
		

//=====
		
	$query_simpan = "insert into ves_inc.tb_biodata 
	(kd_biodata, 
	nama, middle_name, family_name, 
	dob, 
	address,city, area, 
	hm_ph, hp, hp_2, 	
	e_mail, 
	remark, vip_remark, 
	level_school, org_school, grade, 
	country_dest, school_dest, program_dest, 
	parent_nm, add_parent, city_parent, hp_parent, parent_email,   
	event_st, event_st_dtl, event_type, event_type_dtl, media_src, media_src_dtl,
	dt_entry, time_entry, pic, branch, kd_branch,gender,
	kd_school_1, country_1, school_1, program_1,vip_program,
	signed_to, 	sm_1,sm_2,sm_3,sm_4,sm_5,sm_6, org_city_school )
	values 
	('$kode_biodata','$first_name', '$middle_name', '$family_name ', '$tgl_lahir', '$address', 
	'$student_city', '$area ', '$phone ', '$hp1 ', '$hp2 ', 
	'$e_mail',  '$ves_remark ', '$vip_remark ', '$school_level ', 
	'$school_name', '$school_grade', '$country_ref', '$school_ref', '$program_ref', 
	'$parent_name', '$parent_address', '$parent_city ', '$parent_hp ', '$parent_email ', 
	'$event_st','$event_st_dtl','$mkt_source_event', '$mkt_source_event_dtl', '$media_source', '$media_source_dtl', 
	'$tanggal_hri', '$jamskrg', '$nama_depan', '$branch','$kd_cbg','$gender',
	'$kd_school1','$flt_country1','$flt_school1','$flt_program1','$vip_program',
	'$nama_depan',
	'$fb','$twitter','$instagram','$path','$line','$wa','$school_city'	)";
	//$resource_simpan= mysql_query($query_simpan) or die('errro_simpan');
	echo "<script type=\"text/javascript\">\n";
	echo "alert('New Leads has been Submitted by " . e($nama_depan) . "');\n";
	echo "window.location = ('dashboard.php');\n";				
	echo "</script>";	
			
	}
else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($pesan) . " must be filled');\n";
	echo "</script>";
		
		
	}

}
?>