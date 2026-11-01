<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
 include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$hr_id = in_val('id', 'any');
$query_emp = q_set($__p_query_emp, "select hr_name, hr_alamat, dob, hr_type, hr_start_working,id from ves_data.hrd_mst_data where id = ? ", [(string) ($hr_id)]); 
$resource_emp = db_query_soft($query_emp, $__p_query_emp ?? []);			
if(num(db_num_rows($resource_emp)) > 0)
	{
	while ($row_emp  =  db_fetch($resource_emp, PDO::FETCH_NUM))
		{
		$hr_name = $row_emp[0];
		$hr_alamat = $row_emp[1];
		$dob = $row_emp[2];
		$hr_type = $row_emp[3];

		$hr_start_working = $row_emp[4];
		$hr_id = $row_emp[5];		
	}
	}
$query_cek_kontrak = q_set($__p_query_cek_kontrak, "SELECT * FROM ves_data.hrd_mst_cntrct where hr_kode = ?   and  st_contract = 0 ", [(string) ($hr_id)]); 
$resource_cek_kontrak = db_query_soft($query_cek_kontrak, $__p_query_cek_kontrak ?? []);			
if(num(db_num_rows($resource_cek_kontrak)) > 0)
	{
	$ct_pending = 1;
	}
else
	{
	$ct_pending = 0;	
	}
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
<div class="wrapper">


  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
Employee Profile </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
<div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="dist/img/user4-128x128.jpg" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo e($hr_name) ?></h3>

              <p class="text-muted text-center">Photo</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>KTP</b> <a class="pull-right">View</a><a class="pull-right">Modify</a>
                </li>
                <li class="list-group-item">
                  <b>KSK</b> <a class="pull-right">View</a><a class="pull-right">Modify</a>
                </li>
                <li class="list-group-item">
                  <b>NPWP</b> <a class="pull-right">View</a><a class="pull-right">Modify</a>
                </li>
                <li class="list-group-item">
                  <b>OTHER DOCUMENT</b> <a class="pull-right">View</a><a class="pull-right">Modify</a>
                </li>				  
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>		  
        <!-- left column -->
        <div class="col-md-9">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>

              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Employee Name</label>
                  <input type="text" name="hr_name" class="form-control" id="exampleInputEmail1" placeholder="Input Data Employee" value="<?php echo e($hr_name) ?>">
                  <input type="hidden" name="id" class="form-control" id="exampleInputEmail3" placeholder="Input Data Employee" value="<?php echo e($hr_id) ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Alamat</label>
                  <input type="text" class="form-control"name="hr_alamat"  id="exampleInputEmail1" placeholder="Input Data Employee"value="<?php echo e($hr_alamat) ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">DOB</label>
                  <input type="date" name="dob" class="form-control" id="exampleInputEmail2" placeholder="Input Data Employee"value="<?php echo e($dob) ?>">
                </div>
              <div class="form-group">
                <label>Pilihan</label>
                <select class="form-control select2" style="width: 100%;" name="hr_type"value="<?php echo e($hr_type) ?>">
                  <option>FT</option>
                  <option>PKWT</option>
                  <option>PKWTT</option>
                  <option>PTT</option>
                  <option>SFT</option>
                  <option selected="selected"><?php echo e($hr_type) ?></option>
					
                </select>
              </div>				  
                <div class="form-group">
                  <label for="exampleInputEmail1">Start Working</label>
                  <input type="date" name="hr_start_working" class="form-control" id="exampleInputEmail1" placeholder="Input Data Employee"value="<?php echo e($hr_start_working) ?>">
                </div>			  

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="modify">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
		</div>
      <div class="row">
		
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Contract On Progress</label>
		</div>				
	  </div>
	  <div class="col-md-8">
<table width="453" border="0">
        <tbody>
          <tr>
            <td width="148">
				<?php if (num($ct_pending) == 0)
{?>
<a href="hrd_ctrct_new.ph.php?id=<?php echo e(u($hr_id)); ?>" target="popup" onclick="window.open('hrd_ctrct_new.ph.php?id=<?php echo e(u($hr_id)); ?>','popup','width=1000,height=800'); return false;"><button class="btn btn-primary">New Contract </button></a>
	
<?php } else { ?>
	<button class="btn btn-primary disabled">New Contract </button></a>
<?php } ?>
 	</td>
            <td width="289">&nbsp;</td>
          </tr>
        </tbody>
    </table>			
	  </div>		
	  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=4% height="14" align=center >No</td>
	            <td width=14% align=center >Contract Number</td>
	            <td width=17% align=center >Subject</td>
	            <td width=5% align=center >Period</td>
	            <td width=19% align=center >Submited by</td>
	            <td width="9%" align=center >Checked by</td>
	            <td width="7%" align=center > Approved By</td>
	            <td width="10%" align=center >Status</td>
	            <td width="15%" align=center >Action</td>
              </tr>
            </thead>
	        <tbody>
          <?php	
	
$query_contract = q_set($__p_query_contract, "SELECT h.contract_no, h.catatan_title, catatan, h.start_contract, h.end_contract, pic_create, dt_create, pic_ack, dt_ack, pic_app, dt_app,h.st_contract,id FROM ves_data.hrd_mst_cntrct h where hr_kode = ? and st_contract = 0", [(string) ($hr_id)]); 
$no_urut = 1;		
$resource_contract = db_query_soft($query_contract, $__p_query_contract ?? []);			
if(num(db_num_rows($resource_contract)) > 0)
	{
	while ($row_contract  =  db_fetch($resource_contract, PDO::FETCH_NUM))
		{
		$contract_no = $row_contract[0];	
		$catatan_title = $row_contract[1];
		$catatan = $row_contract[2];		
		$start_contract = $row_contract[3];		
		$end_contract = $row_contract[4];
		$pic_create = $row_contract[5];
		$dt_create = $row_contract[6];
		$pic_ack  = $row_contract[7];
		$dt_ack = $row_contract[8];
		$pic_app = $row_contract[9];
		$dt_app = $row_contract[10];		
		
		$st_contract = $row_contract[11];
		if(num($st_contract) ==0){$st_contract ="Pending";}
		elseif(num($st_contract) ==1){$st_contract ="Ack";}

		$id_contract = $row_contract[12];		

	
		

		
	?>
			<tr>
			<td height="14" align=center class="style24"><?php echo e($no_urut) ?></td>
			<td align=left class="style24">
			<?php echo e($contract_no) ?><br></td>
			<td align=center class="style24"><?php echo  e($catatan_title)  ?></td>
			<td align=center class="style24"><?php echo e($start_contract) ?> - <?php echo e($end_contract) ?> </td>
			<td align=center class="style24"><?php echo e($pic_create) ?><br>
			  <?php echo e($dt_create) ?></td>
			<td align=center class="style24"><?php echo e($pic_ack) ?><br>
              <?php echo e($dt_ack) ?></td>
			<td align=center class="style24"><?php echo e($pic_app) ?><br>
              <?php echo e($dt_app) ?></td>
			<td align=center class="style24"><?php echo e($st_contract) ?></td>
			<td align=center class="style24"><div class="btn-group">
			  <a href="hrd_ctrct_dtl.php?id=<?php echo e(u($id_contract)) ?>&hr_id=<?php echo e(u($hr_id)) ?>"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open"></span></button></a>		  
			  </div></td>
              </tr>
              <?php $no_urut = num($no_urut) +1;$ttl_amount ='';}} ?>
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
          <!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->		
      <div class="row">
		
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Employee History</label>
		</div>				
	  </div>
	  <div class="col-md-8">
<table width="453" border="0">
        <tbody>
          <tr>
            <td width="148">

                <a href="hrd_list_new.php"  class="btn btn-primary disabled" >+ New History </a>
 	</td>
            <td width="289">&nbsp;</td>
          </tr>
        </tbody>
    </table>			
	  </div>		
	  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=4% height="14" align=center >No</td>
	            <td width=14% align=center >Jabatan</td>
	            <td width=17% align=center >Posisi</td>
	            <td width=5% align=center >Level</td>
	            <td width=19% align=center >Penugasan</td>
	            <td width="9%" align=center >Center</td>
	            <td width="7%" align=center > Supervisor</td>
	            <td width="10%" align=center >Sub Ordinate</td>
	            <td width="10%" align=center >Contract Period</td>
	            <td width="15%" align=center >Action</td>
              </tr>
            </thead>
	        <tbody>
          <?php	
	
$query_hr_list = q_set($__p_query_hr_list, "SELECT h.hr_name, h.dob, h.hr_alamat, h.hr_start_working,id FROM ves_data.hrd_mst_data h where hr_status = 1 order by hr_name");

$no_urut = 1;		
$resource_hr_list = db_query_soft($query_hr_list, $__p_query_hr_list ?? []);			
if(num(db_num_rows($resource_hr_list)) > 0)
	{
	while ($row_hr_list  =  db_fetch($resource_hr_list, PDO::FETCH_NUM))
		{
		$nama_student = $row_hr_list[0];	
		$address = $row_hr_list[2];
		$city = $row_billing[6];		
		$org_city_school = $row_billing[7];
		$org_school = $row_billing[8];		
		$grade = $row_billing[9];
	
		

		
	?>
			<tr>
			<td height="14" align=center class="style24"><?php echo e($no_urut) ?></td>
			<td align=left class="style24">
			<?php echo e($nama_student) ?><br></td>
			<td align=center class="style24"><?php echo  e($address)  ?> <?php echo e($city) ?></td>
			<td align=center class="style24"><?php echo e($no_hp) ?></td>
			<td align=center class="style24">&nbsp;</td>
			<td align=center class="style24">&nbsp;</td>
			<td align=center class="style24">&nbsp;</td>
			<td align=center class="style24">&nbsp;</td>
			<td align=center class="style24">&nbsp;</td>
			<td align=center class="style24"><div class="btn-group">
                      <a href="hrd_list_upd.php?id=<?php echo e(u($row_hr_list[4])) ?>&upd=1"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open"></span></button></a>		  
                    </div></td>
              </tr>
              <?php $no_urut = num($no_urut) +1;$ttl_amount ='';}} ?>
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
          <!-- /.box -->

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
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modify']))) 
	{
	$saat_ini = date('Y-m-d');
	$hr_id = in_val('id', 'any');	
	$hr_name = in_val('hr_name', 'any');
	$hr_alamat = in_val('hr_alamat', 'any');
	$dob = in_val('dob', 'any');
	$hr_type = in_val('hr_type', 'any');
	$hr_start_working = in_val('hr_start_working', 'any');
	$query_simpan = q_set($__p_query_simpan, "update ves_data.hrd_mst_data set hr_name= ? , hr_alamat = ? , dob = ? , hr_type = ? , hr_start_working = ? where id = ? ", [(string) ($hr_name), (string) ($hr_alamat), (string) ($dob), (string) ($hr_type), (string) ($hr_start_working) . " ", (string) ($hr_id)]); 
	$resource_simpan = db_query_or_die('errro_1t', $query_simpan, $__p_query_simpan ?? []);	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Modify Success');\n";
		echo "window.location = ('hrd_list_upd.php?id=" . e(u($hr_id)) . "');\n";				
		echo "</script>";		
	}
?>