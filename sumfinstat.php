<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$q = in_val('q', 'get');
$search = in_val('search', 'get');
$status_payment = in_val('status_payment', 'get');
$pilihan_center = in_val('pilihan_center', 'get');
if ($status_payment==''){$status_payment="All";}
if ($pilihan_center==''){$pilihan_center="All";}

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




function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
}

	$query = q_set($__p_query, "SELECT dest_country,b.groupschool,a.dest_school, a.p_np, a.nama,   a.dest_program, a.tuition, a.comm_date,\r
(case when a.kd_branch = 1 then 'East Sby'\r
when a.kd_branch = 2 then 'West Sby'\r
when a.kd_branch = 3 then 'Denpasar' \r
when a.kd_branch = 4 then 'South Jkt'\r
when a.kd_branch = 5 then 'North Jkt'\r
when a.kd_branch = 6 then 'West Jkt'\r
when a.kd_branch = 7 then 'Bandung' \r
when a.kd_branch = 8 then 'Malang Tbi'\r
when a.kd_branch = 9 then 'Bandung Tbi'\r
when a.kd_branch = 10 then 'Bali Tbi' else 0 end )as center,\r
(case when (c.kd_invoice is not null and  dt_invoice >= '2017-06-30') or   (c.kd_invoice is null) then 1 else 0 end  )as not_yet,\r
(case when (c.dt_invoice between   ? and ? and c.kd_invoice not like 'N%') or (c.dt_invoice is not null and dt_payment < '2017-07-01' and c.kd_invoice not like 'N%') then 1 else 0 end   ) as noninvoiced,\r
(case when (c.dt_invoice between   ? and ? and c.kd_invoice like 'N%') or (c.dt_invoice is not null and dt_payment < '2017-07-01' and c.kd_invoice like 'N%') then 1 else 0 end   ) as invoiced,\r
(case when f.mount_rp_pay is not null and dt_payment between ? and ?  then 1 else 0 end) as paid,\r
CONCAT_WS(' - ',b.groupschool, a.dest_school) as groupandschool,a.kd_school,(case when a.final_status = 'L' then 'Main'\r
when a.final_status = 'Ll'  then 'Language'\r
when a.final_status = 'La'  then 'Additional' else 0 end) as final_status\r
FROM adm_stu_progress a left join tb_master_partner b\r
on a.kd_school = b.kd_school  left join fin_invoice c on a.no = c.no_leaving left join fin_comm f on a.no = f.no_leaving where a.final_status like 'L%'\r
and a.comm_date between ? and ?\r
and (kd_branch = 1 or  kd_branch = 2 or kd_branch = 3 or kd_branch = 4 or kd_branch = 5 or kd_branch = 6 or kd_branch = 7\r
or kd_branch = 8 or kd_branch = 9 or kd_branch = 10) \r
group by a.no,b.kd_school\r
order by case when dest_country like 'USA%' then 0 when dest_country like 'CAN%' then 1 when dest_country like 'SW%' then 2\r
when dest_country like 'UK%' then 3 when dest_country like 'SPA%' then 4 when dest_country like 'IT%' then 5\r
when dest_country like 'AUS%' then 6 when dest_country like 'NEW%' then 7 when dest_country like 'SIN%' then 8\r
when dest_country like 'MAL%' then 9 when dest_country like 'CHI%' then 10 when dest_country like 'IN%' then 11 ELSE 12 end,\r
groupandschool,nama", [(string) ($date_start), (string) ($date_end), (string) ($date_start), (string) ($date_end), (string) ($date_start), (string) ($date_end), (string) ($date_start), (string) ($date_end)]);		   
$nomor = 1;
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);

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
<?php //========================== left nav ?>
 <?php  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=sumfinstat.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Commission Statement<br>
     </h1>
     <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Leaving Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td height="24">&nbsp;</td>
            <td><small>
            <input type="text" name="q" id="q" value="<?php echo e($q) ; ?>" hidden="hidden">
            <input type="text" name="search" id="q2" value="<?php echo e($search) ; ?>" hidden="hidden">
            </small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date9"> Total Leaving</label>
            </small></td>
            <td><strong>:  <?php echo e($keluar) ?></strong></td>
          </tr>
          <tr>
            <td height="24"><small>
              <label for="date11"> Total Not Yet Invoiced</label>
            </small></td>
            <td><strong>: </strong></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date10"> Total Invoiced</label></small></td>
            <td><strong>: </strong></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date3"> Total Paid</label>
            </small></td>
            <td><strong>: </strong></td>
          </tr>
          <tr>
            <td height="24"><small>
              <label for="date4"> Total Mount Paid</label>
            </small></td>
            <td><strong>: </strong></td>
          </tr>
          <tr>
            <td height="24">&nbsp;</td>
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
              <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="96%">
                <thead>
                <tr>
                  <td width=4% align=center >No</a></td>
                  <td width="6%" align=center>Country</a></td>
                  <td width="9%" align=center >Group Of <br>
                  School</a></td>
                  <td width="12%" align=center >School</a></td>
                  <td width="4%" align=center>P/NP</a></td>
                  <td width="12%" align=center >Student Name</a></td>
                  <td width="8%" align=center >Main/<br>
                  Add/<br>
                  Language</td>
                  <td width="6%" align=center >Program</a></td>
                  <td width="5%" align=center >Tuition</a></td>
                  <td width="6%" align=center >Comm Date</a></td>
                  <td width="7%" align=center >Center</a></td>
                  <td width="4%" align=center >Not Send</a></td>
                  <td width="5%" align=center >Non Invoice</a></td>
                  <td width="5%" align=center >Invoiced</a></td>
                  <td width="7%" align=center >Paid</a></td>
                  </tr>
    </thead>
                <tbody>
<?php
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		
?>	
    <tr>
      <td align=center class="style24"><?php echo e($nomor) ?></td>
      <td align=center class="style24"><?php echo e($row[0]) ?></td>
      <td align=left class="style24"><?php echo e($row[1]) ?></td>
      <td height=14 align=left class="style24"><?php echo e($row[2]) ?></td>
      <td align=left class="style24"><?php echo e($row[3]) ?></td>
      <td align=left class="style24"><?php echo e($row[4]) ?></td>
      <td align=left class="style24"><?php echo e($row[15]) ?></td>
      <td height=14 align=left class="style24"><?php echo e($row[5]) ?></td>
      <td align=center class="style24"><?php echo e($row[6]) ?></td>
      <td align=center class="style24"><?php echo e($row[7]) ?></td>
      <td align=center class="style24"><?php echo e($row[8]) ?></td>
      <td align=center class="style24"><?php echo e($row[9]) ?></td>
      <td align=center class="style24"><?php echo e($row[10]) ?></td>
      <td align=center class="style24"><?php echo e($row[11]) ?></td>
      <td align=center class="style24"><?php echo e($row[12]) ?></td>
      </tr>
<?php 
$nomor = num($nomor)+1;}} 

 ?>
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
$(document).ready(function() {
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );
     
    $('table.table').DataTable( {
        scrollY:        800,
        scrollCollapse: true,
        paging:         false
    } );
 
    // Apply a search to the second table for the demo
    $('#myTable2').DataTable().search( 'New York' ).draw();
} );		
</script>
</body>
</html>
