<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;



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
  <link rel="stylesheet" href="cdnjs/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="cdnjs/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
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
     <h1>Institution List New Version<br>
      </h1>
     <?php 

$query = q_set($__p_query, "SELECT t.school, t.country, t.groupschool, t.date_partner, t.date_expired, t.update_date,remark,no,kd_school,new,CASE WHEN date_expired < CURDATE() THEN 0 WHEN date_expired >= CURDATE() THEN 1 end FROM ves_data.tb_master_partner t where new  >= 1 order by school ");

$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
    </section><!-- Main content -->
 <form method=get action=institution.php>		  
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example1">
                <thead>
                <tr>
                  <th width="6%">No</th>
                  <th width="35%">Name of Institution</th>
                  <th width="16%">  Country</th>
                  <th width="15%">Group of Institution</th>
                  <th width="9%">Partnership Status</th>
                  <th width="6%">Last <br>
                  Update</th>
                  <th width="6%">ACTION</th>
                </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$kd_school =$r[8];	
							$new = $r[9];
							$kd_inst =$r[7];
							$school =$r[0];							$country =$r[1];							$groupschool =$r[2];							
							$tgl_selesai =$r[4];
							$st_com =$r[10];
							if (num($new) == 1)
								{
								if (num($st_com) == 0) {$status = "Expired"; $wn = '#D7AFAF';}
								else {$status = "Valid";$wn = '#6DFF42';}									
								}
							else	
								{
								$wn = '#E9DA07';$status = "Request to Confirm";$st_com=3;
								}
							
				?>                
                <tr>
                  <td bgcolor="<?php echo e($wn) ?>"><?php echo e($no_urut) ; ?></td>
                  <td bgcolor="<?php echo e($wn) ?>"><?php echo e($r[0]) ; ?></td>
                  <td bgcolor="<?php echo e($wn) ?>"><?php echo e($r[1]) ; ?></td>
                  <td bgcolor="<?php echo e($wn) ?>"><?php echo e($r[2]) ; ?></td>
                  <td bgcolor="<?php echo e($wn) ?>"><?php echo e($status) ; ?><br></td>
                  <td bgcolor="<?php echo e($wn) ?>"><?php echo e($r[5]) ; ?></td>
                  <td bgcolor="<?php echo e($wn) ?>">
					 <?php if ($nama_lengkap =='rika' or $nama_lengkap =='Gabriella Tiffany Kusumo'){?> 
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modif_inst_<?php echo e($i) ?>">Modify</button><?php } ?><?php if(num($st_com)==0){?>
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ask_inst_<?php echo e($i) ?>">Ask</button><?php }elseif(num($st_com)==3){ ?>
					<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#requested_<?php echo e($i) ?>">Need to confirm</button><?php }?>
									  
					</td>
				<div class="modal modal-warning fade" id="requested_<?php echo e($i) ?>">
					<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Institution Requested</h4>
				</div>
				<form name="form2" method="post" action="#"><?php echo csrf_field(); ?>
				
				<div class="modal-body">
				<div class="form-group">
				<label>Institution Name</label>
					 <?php $_POST['kd_inst'] = $kd_inst; $_POST['country'] = $country; $_POST['school'] = $school; $_POST['kd_school'] = $kd_school;  ?>

<?php
$query_request = q_set($__p_query_request, "SELECT t.kd_school, t.remark, t.nama_sc, date_format(t.tgl_request,'%d-%b-%y'), t.st_request FROM ves_data.tb_master_partner_request t where kd_school = ? ", [(string) ($kd_school)]);	
$resource_request = db_query_soft($query_request, $__p_query_request ?? []);
if(num(db_num_rows($resource_request)) > 0)
	{
	while ($row_request  =  db_fetch($resource_request, PDO::FETCH_NUM))
		{
		$reason = $row_request[1];
		$nama_sc = $row_request[2];
		$tgl_request = $row_request[3];


		}
	}
?>								
				<input type="hidden" name="kd_school" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($kd_school) ?>">
					 
				<input type="hidden" name="kd_inst" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($kd_inst) ?>">
				<input type="text" name="school" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($school) ?>" readonly>

				</div>
				<div class="form-group">
				<label>Country</label>
				<input type="text" name="country" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($country) ?>" readonly>

				</div>				
				<div class="form-group">
				<label>Group of School</label>
				<input type="text" name="country" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($groupschool) ?>" readonly>

				</div>					  
				<div class="form-group">
				<label>Reason</label>


				<input type="text" name="reason" class="form-control" id="dt_expired" value="<?php echo e($reason) ?> by <?php echo e($nama_sc) ?> (<?php echo e($tgl_request) ?> )" readonly>

				</div>			  
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
				</div>
		 
				</form> 
				</div>
				<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
				</div>					
				<div class="modal modal-info fade" id="modif_inst_<?php echo e($i) ?>">
					<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Institution Modify</h4>
				</div>
				<form name="form1" method="post" action="#"><?php echo csrf_field(); ?>
				
				<div class="modal-body">
				<div class="form-group">
				<label>Institution Name</label>
					 <?php $_POST['kd_inst'] = $kd_inst; $_POST['country'] = $country; $_POST['school'] = $school;   ?>
				<input type="hidden" name="kd_inst" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($kd_inst) ?>">
				<input type="text" name="school" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($school) ?>">

				</div>
				<div class="form-group">
				<label>Country</label>
				<select class="form-control" name="country">
				<?php
							$query_country = q_set($__p_query_country, "SELECT distinct country FROM ves_data.tb_master_partner group by country order by country");
						$resource_country = db_query_or_die('errro_7', $query_country, $__p_query_country ?? []);
						while ($row_country=  db_fetch($resource_country, PDO::FETCH_NUM))
							{
							echo '<option value="'.e($row_country[0]).'">'.e($row_country[0]).'</option>';
							}      ?>
				<option selected><?php echo  e($country) ?></option>
				</select>
				</div>
				<div class="form-group">
				<label>Group of Institution</label>
				<select class="form-control" name="groupcountry">
				<?php
							$query_groupcountry = q_set($__p_query_groupcountry, "SELECT distinct groupschool FROM ves_data.tb_master_partner group by groupschool order by groupschool");
						$resource_groupcountry = db_query_or_die('errro_7', $query_groupcountry, $__p_query_groupcountry ?? []);
						while ($row_groupcountry=  db_fetch($resource_groupcountry, PDO::FETCH_NUM))
							{
							echo '<option value="'.e($row_groupcountry[0]).'">'.e($row_groupcountry[0]).'</option>';
							}      ?>
				<option selected><?php echo  e($groupschool) ?></option>
				</select>
				</div>				  
				<div class="form-group">
				<label>Date Expired</label>

				<input type="date" name="dt_expired" class="form-control" id="dt_expired" value="<?php echo e($dt_expired) ?>">

				</div>
				<div class="form-group">
				<label>Contract File Upload</label>
				<input type="file" name="fileToUpload">

				</div>				  
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
				<input type="submit" class="btn btn-success" name="modify<?php echo e($i) ?>" value="modify">
				</div>
				<?php 
				if (isset($_POST['modify'.$i])) 
				{

				$hari=date("d");
				$bulan=date("m");
				$tahun=date("Y");
				$tgl_hari_ini =  "$tahun-$bulan-$hari";

				$kd_inst = in_val('kd_inst', 'post');
				$school = in_val('school', 'post');
				$country = in_val('country', 'post');
				$groupschool = in_val('groupschool', 'post');
				$dt_expired = in_val('dt_expired', 'post');	

				$query_simpan = q_set($__p_query_simpan, "update ves_data.tb_master_partner set school = ? , country = ? , date_expired = ? ,update_date = ? where no = ? ", [(string) ($school), (string) ($country), (string) ($dt_expired), (string) ($tgl_hari_ini), (string) ($kd_inst)]);
/* echo $query_simpan (debug SQL versi lama) dihapus */
				$resource_simpan= db_query_or_die('errro_simpans', $query_simpan, $__p_query_simpan ?? []);
				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('institution.php');\n";				
				echo "</script>";	
				die;

				}

				?>		 
				</form> 
				</div>
				<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
				</div>
    				<div class="modal modal-danger fade" id="ask_inst_<?php echo e($i) ?>">
					<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Institution Requested</h4>
				</div>
				<form name="form2" method="post" action="#"><?php echo csrf_field(); ?>
				
				<div class="modal-body">
				<div class="form-group">
				<label>Institution Name</label>
					 <?php $_POST['kd_inst'] = $kd_inst; $_POST['country'] = $country; $_POST['school'] = $school; $_POST['kd_school'] = $kd_school;  ?>


				<input type="hidden" name="kd_school" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($kd_school) ?>">
					 
				<input type="hidden" name="kd_inst" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($kd_inst) ?>">
				<input type="text" name="school" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($school) ?>" readonly>

				</div>
				<div class="form-group">
				<label>Country</label>
				<input type="text" name="country" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($country) ?>" readonly>

				</div>				
				<div class="form-group">
				<label>Group of School</label>
				<input type="text" name="country" class="form-control" id="inputPassword4" placeholder="Institution Name" value="<?php echo e($groupschool) ?>" readonly>

				</div>					  
				<div class="form-group">
				<label>Reason</label>

				<input type="text" name="reason" class="form-control" id="dt_expired">

				</div>			  
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
				<input type="submit" class="btn btn-success" name="ask<?php echo e($i) ?>" value="Send Request">
				</div>
				<?php 
				if (isset($_POST['ask'.$i])) 
				{
				$kd_inst = in_val('kd_inst', 'post');
				$kd_school = in_val('kd_school', 'post');	
				$reason = in_val('reason', 'post');						
				$hari=date("d");
				$bulan=date("m");
				$tahun=date("Y");
				$tgl_hari_ini =  "$tahun-$bulan-$hari";

				$kd_inst = in_val('kd_inst', 'post');
				$query_simpan_request = q_set($__p_query_simpan_request, "insert into ves_data.tb_master_partner_request (kd_school, remark, nama_sc, tgl_request, st_request  ) values (? ,? ,? ,? ,1)", [(string) ($kd_school), (string) ($reason), (string) ($nama_lengkap), (string) ($tgl_hari_ini)]);

				$resource_simpan_request= db_query_or_die('errro_simpans', $query_simpan_request, $__p_query_simpan_request ?? []);

				$query_simpan = q_set($__p_query_simpan, "update ves_data.tb_master_partner set new = 2 where no = ? ", [(string) ($kd_inst)]);

				$resource_simpan= db_query_or_die('errro_simpans', $query_simpan, $__p_query_simpan ?? []);
					
				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('institution.php');\n";				
				echo "</script>";	
				die;

				}

				?>		 
				</form> 
				</div>
				<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
				</div>           
                </tr>
                <?php $no_urut = num($no_urut) + 1; $i= num($i)+1;$st_com=''; } }?>
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
      <!-- /.row -->
   </section>
	  </form>	 
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
