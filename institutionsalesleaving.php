<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";

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
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}
if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}

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
  <title>Sales - Leaving Institution Progress</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
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
 <form method=get action=leads.php> 
  <div class="wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Institution Data Sales &amp; Leaving<br>
      </h1>
     <?php 

$query = q_set($__p_query, "SELECT kd_school, country, school,kd_school FROM ves_data.tb_master_partner where (country = 'USA' OR country = 'CANADA') order by country, school");

$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example1111">
              <thead>
                <tr>
                  <th width="8%"><table width="97%" class="table table-bordered table-striped" id="example">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Country</th>
                        <th>Institution</th>
                        <th>kd</th>
                        <th colspan="2">2012</th>
                        <th colspan="2">2013</th>
                        <th colspan="2">2014</th>
                        <th colspan="2">2015</th>
                        <th colspan="2">2016</th>
                        <th colspan="2">2017</th>
                        <th colspan="2">2018</th>
                        <th colspan="2">2019</th>
                        <th colspan="2">2020</th>
                        <th colspan="2">2021</th>
                        <th colspan="2">2022</th>
                        <th>&nbsp;</th>
                        <th colspan="2">TOTAL</th>
                        </tr>
                      <tr>
                        <th width="6%">&nbsp;</th>
                        <th width="25%">&nbsp;</th>
                        <th width="25%">&nbsp;</th>
                        <th width="25%">&nbsp;</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        <th width="8%">&nbsp;</th>
                        <th width="8%">S</th>
                        <th width="11%">L</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 
if ($result) 
	{	 
	while ($r = db_fetch($result))
		{

		$query_sales= q_set($__p_query_sales, "select \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2012' then 1 end) as s12, \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2013' then 1 end) as s13, \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2014' then 1 end) as s14, \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2015' then 1 end) as s15, \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2016' then 1 end) as s16, \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2017' then 1 end) as s17, \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2018' then 1 end) as s18, \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2019' then 1 end) as s19, \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2020' then 1 end) as s20, \r
\t\t\tcount(case when date_format(enroll_date,'%Y') = '2021' then 1 end) as s21, \r
\t\tcount(case when date_format(enroll_date,'%Y') = '2022' then 1 end) as s22 \t\t\t\r
\t\tfrom tb_sales_report where kd_school = ? ", [(string) ($r[0])]);
		$resource_sales = db_query_soft($query_sales, $__p_query_sales ?? []);
		if(num(db_num_rows($resource_sales)) > 0)
			{

			while ($r_sales=  db_fetch($resource_sales, PDO::FETCH_NUM))
				{
				
				$s12 =$r_sales[0]; 
				$s13 =$r_sales[1]; 				
				$s14 =$r_sales[2]; 				
				$s15 =$r_sales[3]; 				
				$s16 =$r_sales[4]; 				
				$s17 =$r_sales[5]; 				
				$s18 =$r_sales[6]; 				
				$s19 =$r_sales[7]; 				
				$s20 =$r_sales[8]; 				
				$s21 =$r_sales[9]; 				
				$s22 =$r_sales[10]; 				
				
				}
			}
		
	
		$query_leaving= q_set($__p_query_leaving, "select \r
\t\tcount(case when (date_format(comm_date,'%Y') = '2012' or date_format(tgl_intake,'%Y') = '2012') and final_status  = 'L' then 1 end) as l12,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2013' or date_format(tgl_intake,'%Y') = '2013') and final_status  = 'L' then 1 end) as l13,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2014' or date_format(tgl_intake,'%Y') = '2014') and final_status  = 'L' then 1 end) as l14,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2015' or date_format(tgl_intake,'%Y') = '2015') and final_status  = 'L' then 1 end) as l15,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2016' or date_format(tgl_intake,'%Y') = '2016') and final_status  = 'L' then 1 end) as l16,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2017' or date_format(tgl_intake,'%Y') = '2017') and final_status  = 'L' then 1 end) as l17,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2018' or date_format(tgl_intake,'%Y') = '2018') and final_status  = 'L' then 1 end) as l18,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2019' or date_format(tgl_intake,'%Y') = '2019') and final_status  = 'L' then 1 end) as l19,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2020' or date_format(tgl_intake,'%Y') = '2020') and final_status  = 'L' then 1 end) as l20,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2021' or date_format(tgl_intake,'%Y') = '2021') and final_status  = 'L' then 1 end) as l21,\r
\t\tcount(case when (date_format(comm_date,'%Y') = '2022' or date_format(tgl_intake,'%Y') = '2022') and final_status  = 'L' then 1 end) as l22\r
\t\t\r
\t\tfrom adm_stu_progress where dest_country = ? and dest_school = ? and final_status = 'L'", [(string) ($r[1]), (string) ($r[2])]);
		
		$resource_leaving = db_query_soft($query_leaving, $__p_query_leaving ?? []);
		if(num(db_num_rows($resource_leaving)) > 0)
			{
			
			while ($r_leaving=  db_fetch($resource_leaving, PDO::FETCH_NUM))
				{
				$jmll = 1;
				$l12 =$r_leaving[0]; 
				$l13 =$r_leaving[1]; 
				$l14 =$r_leaving[2]; 				
				$l15 =$r_leaving[3]; 				
				$l16 =$r_leaving[4]; 				
				$l17 =$r_leaving[5]; 				
				$l18 =$r_leaving[6]; 				
				$l19 =$r_leaving[7]; 				
				$l20 =$r_leaving[8]; 				
				$l21 =$r_leaving[9]; 				
				$l22 =$r_leaving[10]; 				
				}
			}
	
$sttl = num($s12) +   num($s13) +   num($s14) +   num($s15) +   num($s16) +   num($s17) +   num($s18) +   num($s19) +   num($s20) +   num($s21) +   num($s22) ;
$lttl = num($l12) +   num($l13) +   num($l14) +   num($l15) +   num($l16) +   num($l17) +   num($l18) +   num($l19) +   num($l20) +   num($l21) +   num($l22);
	
	
		if(num($s12) != 0 or num($s13) != 0 or num($s14) != 0 or num($s15) != 0 or num($s16) != 0 or num($s17) != 0 or num($s18) != 0 or num($s19) != 0 or num($s20) != 0 or num($s21) != 0 or num($s22) != 0 or num($l12) != 0 or num($l13) != 0 or num($l14) != 0 or num($l15) != 0 or num($l16) != 0 or num($l17) != 0 or num($l18) != 0 or num($l19) != 0 or num($l20) != 0 or num($l21) != 0 or num($l22) != 0){
			
?>
                      <tr>
                        <td><?php echo e($no_urut) ; ?></td>
                        <td><?php echo e($r[1]) ; ?></td>
                        <td><?php echo e($r[2]) ; ?></td>
                        <td><?php echo e($r[3]) ; ?></td>
                        <td><?php echo e($s12) ; ?></td>
                        <td><?php echo e($l12) ; ?></td>
                        <td><?php echo e($s13) ; ?></td>
                        <td><?php echo e($l13) ; ?></td>
                        <td><?php echo e($s14) ; ?></td>
                        <td><?php echo e($l14) ; ?></td>
                        <td><?php echo e($s15) ; ?></td>
                        <td><?php echo e($l15) ; ?></td>
                        <td><?php echo e($s16) ; ?></td>
                        <td><?php echo e($l16) ; ?></td>
                        <td><?php echo e($s17) ; ?></td>
                        <td><?php echo e($l17) ; ?></td>
                        <td><?php echo e($s18) ; ?></td>
                        <td><?php echo e($l18) ; ?></td>
                        <td><?php echo e($s19) ; ?></td>
                        <td><?php echo e($l19) ; ?></td>
                        <td><?php echo e($s20) ; ?></td>
                        <td><?php echo e($l20) ; ?></td>
                        <td><?php echo e($s21) ; ?></td>
                        <td><?php echo e($l21) ; ?></td>
                        <td><?php echo e($s22) ; ?></td>
                        <td><?php echo e($l22) ; ?></td>
                        <td>&nbsp;</td>
                        <td><?php echo e($sttl) ; ?></td>
                        <td><?php echo e($lttl) ; ?></td>
                        </tr>
                      <?php $no_urut = num($no_urut) + 1; $jmls = 0;$jml = 0;
		}	}	}?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table></th>
                </tr>
              </thead>
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
