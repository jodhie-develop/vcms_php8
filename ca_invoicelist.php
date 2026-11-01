<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2023-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');
$flt_jns = in_val('flt_jns', 'get');
if ($flt_jns ==''){$flt_jns ='--ALL--';}
if ($flt_jns == '--ALL--')
	{
	$query_ftl = " ";
	}
else
	{
	$query_ftl = " and t.keterangan like '%$flt_jns%' ";	
	}

if ($nama_lengkap == 'Nella Rosalia'){$kd_cbg ='00';}
if ($kd_cbg == 'National'){$kd_cbg = 100;}
elseif ($kd_cbg == 'HO'){$kd_cbg = '0';}
elseif ($kd_cbg == 'VPRO'){$kd_cbg = '00';}
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
elseif ($kd_cbg == 'LIUMEDIA'){$kd_cbg = 99;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 14;}

elseif (num($kd_cbg) ==0){$cabang = 'HO';}
elseif ($kd_cbg =='00'){$cabang = 'VPRO';}
elseif ($kd_cbg ==''){$cabang = '--ALL--';}
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif(num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
elseif(num($kd_cbg) ==99){$cabang = 'LIUMEDIA';}
elseif(num($kd_cbg) ==11){$cabang = 'PIK';}
elseif(num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif(num($kd_cbg) ==10){$cabang = 'Bali TBI';}
elseif(num($kd_cbg) ==14){$cabang = 'Medan';}
elseif(num($kd_cbg) ==100){$cabang = 'National';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kelompok = $_SESSION['kelompok'];
//if ($kelompok <> 'ACC'){$kd_cbg = $_SESSION['kd_branch'];}
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
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
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
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
      <h1>Invoice
        <br>
  </h1>
 
	  
 <form method=get action=invoicebilllist.php> 	  
    <table width="510" border="0">
        <tbody>
          <tr>
            <td><small>
              <label for="date3">Center :</label>
            </small></td>
            <td><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
				  
                <option selected="15">CA</option>
              </select></td>
          </tr>
          <tr>
			  <td width="149"><small>
              <label for="date5"> Invoice Date Period :</label>
			  </small></td>
            <td width="351"><small>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td><small>
            <label for="date4"> Filter:</label>
            </small></td>
            <td><select class="form-control select2" style="width: 50%;" name="flt_jns"  onChange="this.form.submit()">		
                					  
                <option selected="CA">CA</option>
		    </select></td>
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
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Invoice  List</label>
		</div>				
	  </div>
	  <div class="col-md-4">
		<div class="form-group">
	
                <button type="button" class="btn btn-primary" onclick="location.href='tbi_list_payment.php';" >TBI Report</button>
	
		</div>				
	  </div>		
 
	  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=3% height="14" align=center >No</td>
	            <td width=12% align=center >Invoice ID</td>
	            <td width=8% align=center >Order To</td>
	            <td width=24% align=center >Description</td>
	            <td width="13%" align=center >Amount</td>
	            <td width="10%" align=center >Vat</td>
	            <td width="10%" align=center >Net Amount</td>
	            <td width="5%" align=center >Due Date</td>
	            <td width="15%" align=center >Action</td>
              </tr>
            </thead>
		<?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   /* echo $query_billing (debug SQL versi lama) dihapus */
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	        <tbody>
          <?php	
			
$query_billing = q_set($__p_query_billing, "SELECT i.id, i.busines_group, i.invoice_id, i.invoice_date, i.invoice_order, i.invoice_description, i.invoice_amount, i.vat, i.invoice_nett, i.invoice_due_date FROM ves_data.invoice_project i order by id desc");

$no_urut = 1;
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
			$terbayar = $row_billing[8];
		
		//$query_bayar = "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = '$row_billing[0]' and id_receipt <> ''";
		//$resource_bayar = mysql_query($query_bayar);
		//$keluar_bayar = db_num_rows($resource_bayar);	
		//if(db_num_rows($resource_bayar) > 0)
		//	{
		//	while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
		//		{
		//		$mbayar = $row_bayar[0];	
		//		}
		//	}	
	?>
	          <tr>
	            <td height="14" align=center class="style24"><?php echo e($no_urut) ?></td>
	            <td align=center class="style24">
	            <?php //==== admin  
				if($posisi =="Admin" or $nama_lengkap == 'laura natalia' or $nama_lengkap =='Nella Rosalia')
				{
				?>
	            <a href="invoicebillreceipt.php?idb=<?php echo e(u($row_billing[0]))  ?>">
	            
	            <?php } ?>
	            <?php echo e($row_billing[2]) ?></a><br>
<?php echo e($row_billing[3]) ?></td>
	            <td align="left" valign="top" class="style24"><?php echo e($row_billing[4]) ?></td>
	            <td align="left" valign="top"  class="style24"><?php echo e($row_billing[5]) ?></td>
	            <td align=center class="style24"><?php echo number_format(num(($row_billing[6])),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[7])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num((num($row_billing[6]) + num($row_billing[7]))),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[9]) ?></td>
	            <td align=center class="style24"><a href="print.html"  
    onclick="window.open('printable/invoinceprint.php?id=<?php echo e(u($row_billing[0])) ?>','newwindow','width=800,height=800');return false;">Print<a/><br>
					<?php if ($terbayar!=''){?>
					<a href="print.html"  
    onclick="window.open('ca_invoice_paid.php?id=<?php echo e(u($row_billing[0])) ?>','newwindow','width=800,height=800');return false;">Paid<a/>
						<?php } ?><br><a href="ca_inc_claim.php"  
    onclick="window.open('ca_inc_claim.php?id=<?php echo e(u($row_billing[0])) ?>','newwindow','width=800,height=800');return false;">Incentive Claim</a></td>
              </tr>
              <?php $no_urut = num($no_urut) +1; }} ?>
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
      <!-- /.row --><!-- /.content -->
	</form> 
<form action="invoice_generator.php?kd_cbg=<?php echo e(u($kd_cbg))?>">
	<?php if ($kelompok =='ACC'){$matiin = 'Disable';}else {$matiin = '';} echo e($matiin) ;?>
                <button type="submit" class="btn btn-primary" <?php echo e($matiin) ?>>New Invoice</button>
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
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
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
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
