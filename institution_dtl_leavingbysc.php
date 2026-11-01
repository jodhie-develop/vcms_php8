<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$intake_start = in_val('intake_start', 'get');
$intake_end = in_val('intake_end', 'get');
$dest_country = in_val('dest_country', 'get');
$group_school = in_val('group_school', 'get');
if($intake_start==''){$intake_start= "$tahun-$bulan-01";}
if($intake_end==''){$intake_end= $hari_ini;}

$kd_cbg_dipilih = in_val('kd_cbg_dipilih', 'get');
if($kd_cbg_dipilih==''){$kd_cbg_dipilih= 'National';}
if ($kd_cbg_dipilih_dipilih == '--ALL--'){$kd_cbg_dipilih = 'National';}
if ($kd_cbg_dipilih == 'East Sby'){$kd_cbg_dipilih = 1;}
if ($kd_cbg_dipilih == 'West Sby'){$kd_cbg_dipilih = 2;}
if ($kd_cbg_dipilih == 'Denpasar'){$kd_cbg_dipilih = 3;}
if ($kd_cbg_dipilih == 'South Jkt'){$kd_cbg_dipilih = 4;}
if ($kd_cbg_dipilih == 'North Jkt'){$kd_cbg_dipilih = 5;}
if ($kd_cbg_dipilih == 'West Jkt'){$kd_cbg_dipilih = 6;}
if ($kd_cbg_dipilih == 'Bandung'){$kd_cbg_dipilih = 7;}
if ($kd_cbg_dipilih == 'Malang TBI'){$kd_cbg_dipilih = 8;}
if ($kd_cbg_dipilih == 'Bandung TBI'){$kd_cbg_dipilih = 9;}
if ($kd_cbg_dipilih == 'Bali TBI'){$kd_cbg_dipilih = 10;}
if ($kd_cbg_dipilih == 'National'){$kd_cbg_dipilih = 100;}


if ($kd_cbg_dipilih ==''){$cabang = '--ALL--';}
if (num($kd_cbg_dipilih) ==1){$cabang = 'East Sby';}
if (num($kd_cbg_dipilih) ==2){$cabang = 'West Sby';}
if (num($kd_cbg_dipilih) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg_dipilih) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg_dipilih) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg_dipilih) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg_dipilih) ==7){$cabang = 'Bandung';}
if (num($kd_cbg_dipilih) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg_dipilih) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg_dipilih) ==10){$cabang = 'Bali TBI';}
if (num($kd_cbg_dipilih) ==101){$cabang = 'East Area';}
if (num($kd_cbg_dipilih) ==102){$cabang = 'West Area';}
if (num($kd_cbg_dipilih) ==100){$cabang = 'National';}


if ($dest_country == 'ALL' or $dest_country ==''){$pilih_country = '';}
else
{$pilih_country= "and dest_country = '$dest_country' ";}
if ($group_school == 'ALL' or $group_school ==''){$pilih_group = '';}
else
{$pilih_group = "and groupschool = '$group_school' ";}

if ($kd_cbg_dipilih == '100' or $kd_cbg_dipilih ==''){$pilih_cabang = '';}
elseif ($kd_cbg_dipilih == '101'){$pilih_cabang= "and (kd_branch = '1' or kd_branch = '2' kd_branch = '3' kd_branch = '8') ";}
elseif ($kd_cbg_dipilih == '102'){$pilih_cabang= "and (kd_branch = '4' or kd_branch = '5' kd_branch = '6' kd_branch = '7') ";}

else
{$pilih_cabang= "and kd_branch = '$kd_cbg_dipilih' ";}
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
 <?php    include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=institution_dtl_leavingbystu.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Leaving Achievement
        Comparison By Sales<br>
        Period : Jan 2014 - Dec 2019
        <br>
     </h1>
   </section><!-- Main content -->

      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-body">
              <table id="examples1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="4%">No</th>
                  <th width="36%">SC Name</th>
                  <th width="10%">Center</th>
                  <th width="10%">TOTAL</th>
                  <th width="10%">2019</th>
                  <th width="4%">2018</th>
                  <th width="3%">2017</th>
                  <th width="3%">2016</th>
                  <th width="3%">2015</th>
                  <th width="4%">2014</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
$no_urut = 1;$grandttl=0;
					$query_admission = q_set($__p_query_admission, "SELECT b.pic,b.cabang,\r
SUM(case when comm_date between '2014-01-01' and '2019-12-31' then 1 end) as ttl,\r
SUM(case when comm_date between '2019-01-01' and '2019-12-31' then 1 end) as th2019,\r
SUM(case when comm_date between '2018-01-01' and '2018-12-31' then 1 end) as th2018,\r
SUM(case when comm_date between '2017-01-01' and '2017-12-31' then 1 end) as th2017,\r
SUM(case when comm_date between '2016-01-01' and '2016-12-31' then 1 end) as th2016,\r
SUM(case when comm_date between '2015-01-01' and '2015-12-31' then 1 end) as th2015,\r
SUM(case when comm_date between '2014-01-01' and '2014-12-31' then 1 end) as th2014\r
FROM adm_stu_progress a left join tb_sales_report b on a.kd_biodata = b.kd_biodata and a.enroll_date = b.enroll_date where a.final_status = 'L' and comm_date between '2014-01-01' and '2019-12-01'and b.pic is not null\r
group by b.pic order by ttl desc");
								$resource_admission = db_query_or_die('errro_7', $query_admission, $__p_query_admission ?? []);
								while ($row_adm=  db_fetch($resource_admission, PDO::FETCH_NUM))
									{					
					
					
							
								
							
								
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($row_adm[0]) ; ?></td>
                  <td><?php echo e($row_adm[1]) ; ?></td>
                  <td><?php echo e($row_adm[2]) ; ?></td>
                  <td><?php echo e($row_adm[3]) ; ?></td>
                  <td><?php echo e($row_adm[4]) ; ?></td>
                  <td><?php echo e($row_adm[5]) ; ?></td>
                  <td><?php echo e($row_adm[6]) ; ?></td>
                  <td><?php echo e($row_adm[7]) ; ?></td>
                  <td><?php echo e($row_adm[8]) ; ?></td>
                  </tr> <?php $no_urut = num($no_urut)+1; $grandttl = num($grandttl) + num($row_adm[2]) ;}?>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><?php echo e($grandttl) ; ?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
               
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
