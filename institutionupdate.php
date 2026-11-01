<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$nomor_partner = in_val('kdb', 'any');
if (num($st_update) != 1)
	{
	$query_partner= q_set($__p_query_partner, "SELECT school, country, groupschool, ap_np, grade, st_prioritas, leaving, website, date_expired, tagline, videolink, refer_to  FROM ves_data.tb_master_partner where no = ? ", [(string) ($nomor_partner)]);
		/* echo $query_partner (debug SQL versi lama) dihapus */
	$resource_partner = db_query_or_die('errro_2', $query_partner, $__p_query_partner ?? []);
	$keluar_partner= db_num_rows($resource_partner);
	if(num(db_num_rows($resource_partner)) > 0)
		{
		while ($row_partner=  db_fetch($resource_partner, PDO::FETCH_NUM))
			{					
			$school = $row_partner['0'];
			$country = $row_partner['1'];
			$groupschool = $row_partner['2'];
			$ap_np = $row_partner['3'];
			$grade = $row_partner['4'];
			$st_prioritas = $row_partner['5'];
			$leaving = $row_partner['6'];
			$website = $row_partner['7'];
			$date_expired = $row_partner['8'];
			$tagline = $row_partner['9'];
			$videolink = $row_partner['10'];
			$referto = $row_partner['11'];				
			}
		}
	}
else
	{
	$school = in_val('school', 'any');
	$country = in_val('country', 'any');
	$groupschool = in_val('groupschool', 'any');
	$ap_np = in_val('ap_np', 'any');
	$grade = in_val('grade', 'any');
	$st_prioritas = in_val('st_prioritas', 'any');
	$leaving = in_val('leaving', 'any');
	$website = in_val('website', 'any');
	$date_expired = in_val('date_expired', 'any');
	$tagline = in_val('tagline', 'any');
	$videolink = in_val('videolink', 'any');	
	$referto = in_val('referto', 'any');		
	}

//==============list group
$query_group = q_set($__p_query_group, "SELECT distinct groupschool FROM ves_data.tb_master_partner where (groupschool is not null or groupschool <>'') order by groupschool");
$resource_group= db_query_or_die('errro_9', $query_group, $__p_query_group ?? []);
$keluar_group= db_num_rows($resource_group);
if(num(db_num_rows($resource_group)) > 0)
	{
	while ($row_group=  db_fetch($resource_group, PDO::FETCH_NUM))
		{					
		$nm_group= $row_group[0];				
		$list_group.="<OPTION VALUE=\"" . e($nm_groupl) . "\">".e($nm_group);
		}
	}
$st_update = 1;
//=========================	
//==============list source
//================
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
 <?php  include __DIR__ . "/left.php";	 ?>
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
                    <input type="text" name="school" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($school) ?>">
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
                      <option selected><?php echo e($country) ?></option>
                    </select>
                  </div>
                </div>
<div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Group of Institution</label>
                  <div class="col-sm-10">
                    <select name="groupschool" class="form-control">
              <option value= >
                <?php echo $list_group?>
                      <option selected><?php echo e($groupschool) ?></option>
                    </select>
                  </div>
                </div>   
<div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Partnership</label>
                  <div class="col-sm-10">
                    <select name="ap_np" class="form-control">
                      <option>PARTNER</option>
                      <option>NON PARTNER</option>
                      <option>UNKNOWN YET</option>
 						<option selected><?php echo e($ap_np) ?></option>                      
                    </select>
                  </div>
                </div>
<div class="form-group">
            <label for="inputEmail4" class="col-sm-2 control-label">Refer to</label>
                  <div class="col-sm-10">
                    <input type="text" name="referto" class="form-control" id="inputPassword" placeholder="Agent Name" value="<?php echo e($referto) ?>">
                  </div>
</div>                
<div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Star</label>
                  <div class="col-sm-10">
                    <select name="grade" class="form-control">
                      <option>ONE STAR</option>
                      <option>TWO STARS</option>
                      <option>THREE STARS</option>
                      <option>FOUR STARS</option>
                      <option>FIVE STARS</option>
                      <option>SIX STARS</option> 
                      <option>UNKNOWN STARS</option> 
                                           
        	<option selected><?php echo e($grade) ?></option>                
                    </select>
                  </div>
                </div>                                                        
<div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Key Partner</label>
                  <div class="col-sm-10">
                    <select name="st_prioritas" class="form-control">
                      <option>Y</option>
                      <option>N</option>
                      <option selected><?php echo e($st_prioritas) ?></option>
                    </select>
                  </div>
                </div>                             
                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Leaving Achievement</label>

                  <div class="col-sm-10">
                    <input type="text" name="leaving"class="form-control" id="inputPassword3" placeholder="Leaving Achievement" value="<?php echo e($leaving) ?>">
                  </div>
                </div> 
<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Website Profile</label>

                  <div class="col-sm-10">
                    <input type="text" name="website" class="form-control" id="inputPassword3" placeholder="Website" value="<?php echo e($website) ?>">
                  </div>
                </div> 
<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Tag</label>

                  <div class="col-sm-10">
                    <input type="text" name="tagline" class="form-control" id="inputPassword3" placeholder="Tag" value="<?php echo e($tagline) ?>">
                  </div>
                </div>
<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Video Link</label>

                  <div class="col-sm-10">
                    <input type="text" name="videolink" class="form-control" id="inputPassword3" placeholder="videolink" value="<?php echo e($videolink) ?>">
                  </div>
                </div>                                
<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Expired</label>

                  <div class="col-sm-10">
                    <input type="date" name="date_expired" class="form-control" id="inputPassword3" placeholder="Expired Date" value="<?php echo e($date_expired) ?>">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default" name="cancel"  value="cancel">Cancel</button>
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
$school = in_val('school', 'any');
$country = in_val('country', 'any');
$groupschool = in_val('groupschool', 'any');
$ap_np = in_val('ap_np', 'any');
$grade = in_val('grade', 'any');
$st_prioritas = in_val('st_prioritas', 'any');
$leaving = in_val('leaving', 'any');
$website = in_val('website', 'any');
$date_expired = in_val('date_expired', 'any');
$tagline = in_val('tagline', 'any');
$videolink = in_val('videolink', 'any');
$tanggal_hri = date('Y-m-d');
$referto = in_val('referto', 'any');	

if ($school=='')
	{
	if (num($statussimpan)==0){$pesan="School ";}
	$statussimpan=1;
	}
if ($country=='')
	{
	if (num($statussimpan)==0){$pesan="Country ";}
	$statussimpan=1;
	}
if ($ap_np=='')
	{
	if (num($statussimpan)==0){$pesan="Partnership ";}
	$statussimpan=1;
	}
if ($groupschool=='')
	{
	if (num($statussimpan)==0){$pesan="Group  ";}
	$statussimpan=1;
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
elseif (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel']))) 
{
	echo "<script type=\"text/javascript\">\n";
	echo "window.location = ('institution.php');\n";				
	echo "</script>";	
}
?>