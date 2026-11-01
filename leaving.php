<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2021-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cabang = in_val('kd_cbg', 'get');

if (num($kd_cabang) ==1){$cabang = 'East Sby';}
if (num($kd_cabang) ==2){$cabang = 'West Sby';}
if (num($kd_cabang) ==3){$cabang = 'Denpasar';}
if (num($kd_cabang) ==4){$cabang = 'South Jkt';}
if (num($kd_cabang) ==5){$cabang = 'North Jkt';}
if (num($kd_cabang) ==6){$cabang = 'West Jkt';}
if (num($kd_cabang) ==7){$cabang = 'Bandung';}
if (num($kd_cabang) ==8){$cabang = 'Malang TBI';}
if (num($kd_cabang) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cabang) ==10){$cabang = 'Bali TBI';}
if ($kd_cabang == '--ALL--'){$kd_cabang = 0;}
if ($kd_cabang == 'East Sby'){$kd_cabang = 1;}
if ($kd_cabang == 'West Sby'){$kd_cabang = 2;}
if ($kd_cabang == 'Denpasar'){$kd_cabang = 3;}
if ($kd_cabang == 'South Jkt'){$kd_cabang = 4;}
if ($kd_cabang == 'North Jkt'){$kd_cabang = 5;}
if ($kd_cabang == 'West Jkt'){$kd_cabang = 6;}
if ($kd_cabang == 'Bandung'){$kd_cabang = 7;}
if ($kd_cabang == 'Malang TBI'){$kd_cabang = 8;}
if ($kd_cabang == 'Bandung TBI'){$kd_cabang = 9;}
if ($kd_cabang == 'Bali TBI'){$kd_cabang = 10;}

if (num($kd_cabang) ==0){$cabang = '--ALL--';}
if ($kd_cabang ==''){$cabang = '--ALL--';}


echo e($cabang);
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
<?php //========================== left nav ?>
 <?php  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=leaving.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Leaving Student
        <br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Commencement Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date3"> Center :</label>
            </small></td>
            <td><small>
            <label for="date4">:</label>
            <select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
              <option value="0">--ALL--</option>
			<option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="8">Malang TBI</option>
              <option value="9">Bandung TBI</option>              
              <option value="10">Bali TBI</option>                            
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select></small></td>
          </tr>
        </tbody>
      </table>
                 <?php 
					if ($kd_cabang == '0' || $kd_cabang == '')
					{
					$query = q_set($__p_query, "SELECT  date_format(a.enroll_date,'%d/%m/%Y'),a.nama,a.dest_school, a.dest_program, a.dest_country,(case when a.h_nh = 'H' then 1 else 0 end) as H,(case when a.h_nh <> 'H' then 1 else 0 end) as NH,(case when a.p_np = 'P' then 1 else 0 end) as P,(case when a.p_np <> 'P' then 1 else 0 end) as NP, date_format(a.comm_date,'%d/%m/%Y'),b.grade,a.branch, b.groupschool,a.no,c.org_school, c.grade  FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata  where a.final_status = 'L' and comm_date between ? and ? and a.kd_branch = ? group by a.kd_biodata, a.kd_school order by comm_date desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_cabang)]);
				  	}
				  else	
					{
					$query = q_set($__p_query, "SELECT  date_format(a.enroll_date,'%d/%m/%Y'),a.nama,a.dest_school, a.dest_program, a.dest_country,(case when a.h_nh = 'H' then 1 else 0 end) as H,(case when a.h_nh <> 'H' then 1 else 0 end) as NH,(case when a.p_np = 'P' then 1 else 0 end) as P,(case when a.p_np <> 'P' then 1 else 0 end) as NP, date_format(a.comm_date,'%d/%m/%Y'),b.grade,a.branch, b.groupschool,a.no,c.org_school, c.grade  FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata  where a.final_status = 'L' and comm_date between ? and ? and a.kd_branch = ? group by a.kd_biodata, a.kd_school order by comm_date desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_cabang)]);						
					}
				  	$_SESSION['ngueri'] = $query; $_SESSION['ngueri__p'] = $__p_query ?? [];
					$no_urut = 1;

					$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
				  	$num_rows = db_num_rows($result);?>      
      <table width="200" border="0">
                   <tbody>
                     <tr>
                       <td><br>
Result : <?php echo e($num_rows) ?></td>
                       
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                   </tbody>
      </table>
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="4%">Enroll Date</th>
                  <th width="10%">Student Name</th>
                  <th width="17%">Former School</th>
                  <th width="19%">Institution</th>
                  <th width="9%">Group of Institution</th>
                  <th width="3%">H</th>
                  <th width="3%">NON</th>
                  <th width="3%">P</th>
                  <th width="4%">NON P</th>
                  <th width="4%">STAR</th>
                  <th width="12%">Comm Date</th>
                  <th width="4%">Center</th>
                  <th width="6%">Status</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$st_komisi = '';
							$no_leaving = $r[13];
							$nama_stu = $r[1];
							$query_paid = q_set($__p_query_paid, "select no_leaving from ves_data.fin_comm where no_leaving = ? ", [(string) ($no_leaving)]);	
							$result_paid=db_query_or_die("Wah error nihpaid", $query_paid, $__p_query_paid ?? []);
							$num_rows_paid = db_num_rows($result_paid); 								
							if (num($num_rows_paid) >= 1) 
								{
								$st_komisi = 'Paid';
								}
							else
								{
								$query_invoice = q_set($__p_query_invoice, "select no_leaving from ves_data.fin_invoice where no_leaving = ? ", [(string) ($no_leaving)]);	
								$result_invoice=db_query_or_die("Wah error nihinv", $query_invoice, $__p_query_invoice ?? []);
								$num_rows_invoice = db_num_rows($result_invoice); 								
								if (num($num_rows_invoice) >= 1) 
									{
									$st_komisi = 'Invoicing';
									}
								}
							
							 					
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[0]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($r[14]) ; ?> - <?php echo e($r[15]) ; ?></td>
                  <td><?php echo e($r[2]) ; ?> - <?php echo e($r[3]) ; ?> (<?php echo e($r[4]) ; ?>)</td>
                  <td><?php echo e($r[12]) ; ?></td>
                  <td><?php echo e($r[5]) ; ?></td>
                  <td><?php echo e($r[6]) ; ?></td>
                  <td><?php echo e($r[7]) ; ?></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  <td><?php echo e($r[10]) ; ?></td>
                  <td><?php echo e($r[9]) ; ?></td>
                  <td><?php echo e($r[11]) ; ?></td>
                  <td><?php echo e($st_komisi) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1;	$st_komisi = ''; } }?>
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
