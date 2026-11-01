<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$q = in_val('q', 'get');
$search = in_val('search', 'get');
$status_payment = in_val('status_payment', 'get');

if ($status_payment==''){$status_payment="All";}
$status_pilihan = in_val('status_pilihan', 'get');
if ($status_pilihan==""){$status_pilihan = "Leaving";}
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";


$st = in_val('st', 'get');
$end = in_val('end', 'get');
if ($st=="")
{$invoice_start = in_val('invoice_start', 'get');
$invoice_end = in_val('invoice_end', 'get');

}

if ($leaving_start ==''){$leaving_start = "2017-07-01";}
if ($leaving_end ==''){$leaving_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');


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
$pilihan_center = in_val('pilihan_center', 'get');

if ($pilihan_center=='All'){$datacabang ="";}
if ($pilihan_center=='East Sby'){$datacabang = q_set($__p_datacabang, " and f.center = 'East Sby' ");}
if ($pilihan_center=='West Sby'){$datacabang = q_set($__p_datacabang, " and f.center = 'West Sby' ");}
if ($pilihan_center=='Denpasar'){$datacabang = q_set($__p_datacabang, " and f.center = 'Bali' ");}
if ($pilihan_center=='South Jkt'){$datacabang = q_set($__p_datacabang, " and f.center = 'Patal Jkt' ");}
if ($pilihan_center=='North Jkt'){$datacabang = q_set($__p_datacabang, " and f.center = 'Central Jkt' ");}
if ($pilihan_center=='West Jkt'){$datacabang = q_set($__p_datacabang, " and f.center = 'Jkt M2' ");}
if ($pilihan_center=='Bandung'){$datacabang = q_set($__p_datacabang, " and f.center = 'Bandung' ");}
if ($pilihan_center=='Malang TBI'){$datacabang = q_set($__p_datacabang, " and f.center = 'Malang TBI' ");}
if ($pilihan_center=='Bali TBI'){$datacabang = q_set($__p_datacabang, " and f.center = '10' ");}
if ($pilihan_center=='Bandung TBI'){$datacabang = q_set($__p_datacabang, " and f.center = '9' ");}

//==========================
 
//$query = "SELECT c.branch, c.nama, c.dest_country, c.dest_school, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice,
//DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay,  DATE_FORMAT(b.dt_payment,'%d %b %y'),
//(case  when  c.final_status = 'L' then 1 else 0 end )as main,
//(case  when  c.final_status <> 'L' then 1 else 0 end )as add_l,
//(case  when  a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing,
//(case  when  b.mount_rp_pay <> '' then 1 else 0 end ) as paid,c.bintang FROM adm_stu_progress c
//left join fin_invoice a on c.no =  a.no_leaving
//left join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice
//where c.final_status like '%L%' and c.comm_date between '2015-07-01' and '2016-06-30' $urutan ";



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

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=""> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Invoice List<br>
     </h1>
     <div class="col-md-12">
  <table width="25%" class="table table-bordered table-striped" id="ww">
       <thead>
         <tr>
           <td width=8% height="14" align=right >&nbsp;</td>
           <td width="22%" align=left >&nbsp;</td>
           <td width="8%" height="14" align=right ><small>
             <label for="date16"> Invoice Period :</label>
            </small></td>
           <td width="30%" align=left ><small>
             <input type="date" format="dd/MM/yyyy" name="invoice_start" id="date7" value="<?php echo e($invoice_start) ; ?>">
             To
             <input type="date" name="invoice_end" id="date3" value="<?php echo e($invoice_end) ; ?>" >
            </small></td>
           <td height="14" align=right ><small>Center</small></td>
           <td align=left ><small>
             <select name="pilihan_center"  >
               <option>All</option>
               <option>East Sby</option>
               <option>West Sby</option>
               <option>Denpasar</option>
               <option>South Jkt</option>
               <option>North Jkt</option>
               <option>West Jkt</option>
               <option>Bandung</option>
               <option>Malang TBI</option>
               <option>Bali TBI</option>
               <option>Bandung TBI</option>
               <option selected><?php echo e($pilihan_center) ?></option>
              </select>
             <input type="text" name="q" id="q" value="<?php echo e($q) ; ?>" hidden="hidden">
             <input type="text" name="search" id="q2" value="<?php echo e($search) ; ?>" hidden="hidden">
            </small></td>
         </tr>
         <tr>
           <td height="14" align=center >&nbsp;</td>
           <td align=left >&nbsp;</td>
           <td align=left >&nbsp;</td>
           <td align=left > <a href="commmonitoring.php"><input type="button" value="Back"></a>
             <input type="button" value="Invoice List" onClick="this.form.submit()">
             <a href="paymentlist.php?st=<?php echo e(u($leaving_start)) ?>&end=<?php echo e(u($leaving_end)) ?>">
              <input type="button" value="Payment List">
              </a><a href="inv_leaving.php?nl=<?php echo e(u($row[20])); ?>" target='_blank'></a>
            <input type="button" value="Report" onClick="window.location='paymentlist.php' target='_blank'"></td>
           <td align=left >&nbsp;</td>
           <td align=left >&nbsp;</td>
         </tr>
       </thead>
       <tbody>
       <tfoot>
       </tfoot>
     </table>	   	
	   </div>
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example1">
               <?php				  


	$query = q_set($__p_query, "SELECT f.kd_invoice, f.dt_invoice, f.country, f.school, f.program, f.nama, f.center,  f.comm_date, f.org_curr, f.org_mount, f.rate, f.mount_rp, f.jatuh_tempo,f.no_leaving,f.no FROM fin_invoice f where f.dt_invoice between ? and ? " . $datacabang . " order by dt_invoice, kd_invoice", [(string) ($invoice_start), (string) ($invoice_end), ...($__p_datacabang ?? [])]);

$nomor = 1;
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);				  
				  ?>
                <thead>
                <tr>
      <td width=2% rowspan="2" align=center >No</td>
      <td width="7%" rowspan="2" align=center >Date</td>
      <td width="6%" rowspan="2" align=center >Invoice Number</td>
      <td width="7%" rowspan="2" align=center >Due Date</td>
      <td height="14" colspan="3" align=center >Destination</td>
      <td width="14%" rowspan="2" align=center >Student Name</td>
      <td width="4%" rowspan="2" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=invoice">Center</a></td>
      <td width="5%" rowspan="2" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Comm Date</a> <br></td>
      <td align=center >&nbsp;</td>
      <td height=14 align=center >&nbsp;</td>
      <td width="8%" height=14 align=center >&nbsp;</td>
      </tr>
    <tr>
      <td width="7%" height="14" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=country">Country</a></td>
      <td width="16%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=school">School</a></td>
      <td width="8%" height=14 align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=program">Program</a></td>
      <td width="9%" align=center >Org Amount</td>
      <td width="7%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Rate</a> <br></td>
      <td align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">IDR Amount</a> <br></td>
      </tr>
                </thead>
                <tbody>
<?php
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
	//	f.kd_invoice, f.dt_invoice, f.country, f.school, f.program, f.nama, f.center,  f.comm_date, f.org_curr, f.org_mount, f.rate, f.mount_rp 
?>	
    <tr>
      <td align=center class="style24"><?php echo e($nomor) ?></td>
      <td align=center class="style24"><?php echo e($row[1]) ?><br></td>
      <td align=center class="style24"><?php echo e($row[0]) ?><br></td>
      <td align=center class="style24"><?php echo e($row[12]) ?></td>
      <td height="14" align=left class="style24"><?php echo e($row[2]) ?></td>
		<td align=left class="style24"><?php echo e($row[3]) ?><br></td>
		<td height=14 align=left class="style24"><?php echo e($row[4]) ?></td>
		<td align=center class="style24"><?php echo e($row[5]) ?><br>
		   <a href="inv_del.php?nl=<?php echo e(u($row[13])); ?>&kdin=<?php echo e(u($row[0])) ?>" 
target="popup" 
onclick="window.open('inv_del.php?nl=<?php echo e(u($row[13])); ?>&kdin=<?php echo e(u($row[0])) ?>&nmr=<?php echo e(u($row[14])) ?>	','popup','width=1000,height=600'); return false;">[Delete]</a>
			<a href="inv_void.php?nl=<?php echo e(u($row[13])); ?>&kdin=<?php echo e(u($row[0])) ?>" 
target="popup" 
onclick="window.open('inv_void.php?nl=<?php echo e(u($row[13])); ?>&kdin=<?php echo e(u($row[0])) ?>&nmr=<?php echo e(u($row[14])) ?>	','popup','width=1000,height=600'); return false;">[Void]</a></td>
      <td height=14 align=center class="style24"><?php echo e($row[6]) ?><br>        <br></td>
      <td align=center class="style24"><?php echo e($row[7]) ?><br></td>
      <td align=center class="style24"><?php echo e($row[8]) ?><?php echo e($row[9]) ?></td>
      <td align=center class="style24"><?php echo e(buatrp($row[10])) ?></td>
      <td align=center class="style24"><?php echo e(buatrp(num($row[9]) * num($row[10]))) ?></td>
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
	  </div></div>

      <!-- /.row -->
   </section>
   <section class="content">
      <div class="row">
        <!-- /.col -->
     </div></div>

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
