<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
 include __DIR__ . "/../atas.php";
 include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'post');
$date_end = in_val('date_end', 'post');
$_POST['date_start'] = $date_start;
$_POST['date_end'] = $date_end;
//if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
//if ($date_end ==''){$date_end = $hari_ini;}
if ($date_start ==''){$date_start = in_val('date_start', 'get');}
if ($date_end ==''){$date_end = in_val('date_end', 'get');}


$kd_cbg = in_val('kd_cbg', 'post');

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
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}
if ($kd_cbg == 'Medan'){$kd_cbg = 14;}

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
if (num($kd_cbg) ==11){$cabang = 'PIK';}
if (num($kd_cbg) ==14){$cabang = 'Medan';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kode_area'] ;

$a = 0;
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
  <link rel="stylesheet" href="file:///C|/xampp/htdocs/vcms/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="file:///C|/xampp/htdocs/vcms/cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="file:///C|/xampp/htdocs/vcms/cdnjs/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="file:///C|/xampp/htdocs/vcms/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="file:///C|/xampp/htdocs/vcms/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="file:///C|/xampp/htdocs/vcms/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

  <!-- Content Wrapper. Contains page content -->
 <form method=POST><?php echo csrf_field(); ?>
 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>TBI Sales List
        <br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Enrolled Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td><small>
            <label for="date3"> SC Name :</label>
            </small></td>
            <td><strong>:</strong><?php echo e($nama_lengkap) ?></td>
          </tr>
        </tbody>
      </table>
<?php
$_POST['date_start'] = $date_start;
$_POST['date_end'] = $date_end;
$query = q_set($__p_query, "SELECT c.pic, concat_ws(' ',b.nama, b.middle_name, b.family_name), a.keterangan, a.nominal, a.id_invoice, date_format(a.dt_payment,'%d %b %y'),c.id_billing,a.id\r
FROM ves_data.tb_invoice_paid a left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata left join ves_data.tb_invoice c on a.id_billing = c.id_billing\r
where a.dt_payment between ? and ? and c.pic = ? and  (a.keterangan like 'TBI%' or a.keterangan like 'Coaching Session' or a.keterangan like 'Program Kolaborasi%') order by dt_payment", [(string) ($date_start), (string) ($date_end), (string) ($nama_lengkap)]);

$_SESSION['ngueri'] = $query; $_SESSION['ngueri__p'] = $__p_query ?? [];
$no_urut = 1;
$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="90%" class="table table-bordered table-striped" id="example1" >
                <thead>
                <tr >
                  <th width="5%" align="center">No</th>
                  <th width="7%">Invoice</th>
                  <th width="19%">Student Name</th>
                  <th width="30%">TBI Product</th>
                  <th width="10%">Tuition Fee</th>
                  <th width="9%">Discount</th>
                  <th width="9%">Net tuition  Fee</th>
                  <th width="12%">Estimated <br>
                  Incentive</th>
                  <th width="8%">Incentive Status</th>
                  <th width="8%">Action</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
								
							$pic = $r[0];
							$nama_student = $r[1];
							$keterangan = $r[2];
							$bayar = $r[3];
							$id_invoice = $r[4];
							$dt_payment = $r[5];
							$id_billing = $r[6];
							$no_urut_invoice = $r[7];
								
						if ($keterangan =='Test Bakat Minat'){$nominal ='600000';$besaran ='15000';}
						elseif ($keterangan =='TBI - Test Penjurusan + 60 Menit Consult' or $keterangan =='TBI - Test Penjurusan + 30 Menit Consult'or $keterangan =='TBI - Test Penjurusan Karier'){$nominal ='1475000';$besaran ='100000';}
						elseif ($keterangan =='TBI - Test Penjurusan Basic'){$nominal ='1450000';$besaran ='30000';}
						elseif ($keterangan =='TBI - The Ultimate You'){$nominal ='3150000';$besaran ='80000';}
						elseif ($keterangan =='TBI - Test Penjurusan Premium'){$nominal ='2150000';$besaran ='50000';}	
						elseif ($keterangan =='Coaching Session'){$nominal ='750000';$besaran ='0';}	
						elseif ( $keterangan =='TBI - Addtional Fee'){$besaran ='0';}		

						elseif ($keterangan =='Program Kolaborasi Tes Penjurusan Vista x Tes'){$nominal ='1475000';$besaran ='100000';}
								elseif ($keterangan =='TBI - Test Penjurusan'){$nominal ='1475000';$besaran ='100000';}					


							$_POST['id_invoice'.$a]= $id_invoice;
							$_POST['besaran'.$a]= $besaran;
							$_POST['id_billing'.$a]= $id_billing;
							$_POST['no_urut_invoice'.$a]= $no_urut_invoice;							
							
	
							$query_cek_incentive = q_set($__p_query_cek_incentive, "SELECT st_reward,nominal FROM tbi_incentive  where id_billing =  ? and id_invoice = ? ", [(string) ($id_billing), (string) ($id_invoice)]);
							$result_cek_incentive=db_query_or_die("Wah error nih6", $query_cek_incentive, $__p_query_cek_incentive ?? []);	
							$jumlah_data = db_num_rows($result_cek_incentive);								
							if (num($jumlah_data) > 0 ) 
								{ 
								while ($r_check = db_fetch($result_cek_incentive))
									{
									$status_reward  = $r_check[0];
									$nominal_reward  = $r_check[1];									
									if (num($status_reward) ==1){$status ='Proposed'; $ada = 1;}
									elseif (num($status_reward) ==2){$status ='Approved';}
									elseif (num($status_reward) ==3){$status ='Acknowledge';}
									elseif (num($status_reward) ==4){$status ='Accounting Check';}
									elseif (num($status_reward) ==5){$status ='Tax Check';}
									elseif (num($status_reward) ==6){$status ='To be Paid';}
									elseif (num($status_reward) ==7){$status ='Paid';}											
									}
								
								}
							else
								{
								$status_reward  = 0;$status ='';
								}

									?>                
                <tr>

                  <td <?php echo e($bg) ?>><?php echo e($no_urut) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($r[5]) ; ?> - <?php echo e($r[4]) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($nama_student) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($keterangan) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo number_format(num(($nominal)),0,".",".") ?></td>
                  <td <?php echo e($bg) ?>>&nbsp;</td>
                  <td <?php echo e($bg) ?>><?php echo number_format(num(($bayar)),0,".",".") ?></td>
                  <td <?php echo e($bg) ?>>
                  	<?php echo  number_format(num(($besaran)),0,".",".")  ?>			
                  </td>
                  <td <?php echo e($bg) ?>><span class="icon">
                    <?php  echo e($status) ?>
                  </span></td>
                  <td <?php echo e($bg) ?>><div class="icon"><span class="style24">
                    <?php if ( num($status_reward)==0 and num($besaran) != 0 	){ $blm = 1;	?>
                  <input type="checkbox" name = 'check_<?php echo e($a) ?>' class="flat-red" <?php echo e($st_checked) ?>>                  </input>
					 Claim <?php } ?>
            </div>
                  </td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; $step =''; $nominal_reward ='';$a = num($a)+1;} }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
		 <?php if ($blm !=''){?> <input type="Submit" name="Submit" value="Submit" class="btn btn-primary" /><?php } ?>

               <label><a href="#" 
target="popup" 
onclick="window.open('tbi_incentive_form_sc.php?nmsc=<?php echo e(u($nama_lengkap)) ?>&da=<?php echo e(u($date_start)) ?>&de=<?php echo e(u($date_end)) ?>','popup','width=1000,height=800'); return false;">	 
						<strong>>Click Here to Print Claim Form</strong></a></label>></a>

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

<?php	  
if (isset($_POST['Submit'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$date_start = in_val('date_start', 'post');
$date_end = in_val('date_end', 'post');

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$thn=date("y");	
$hari_ini = "$tahun-$bulan-$hari";
	$batas = $a;
	for($a=0;$a<=$batas;$a++) 
		{
		$check = $_POST['check_'.$a];

		

		if( empty($_POST['check_'.$a]) ){$check = 0;}else{$check = 1;}	
		if (num($check)==1)
			{
			$besaran =  $_POST['besaran'.$a];
			if (num($besaran) !=0){
			$no_urut_invoice = $_POST['no_urut_invoice'.$a];	
			$query_tbi = q_set($__p_query_tbi, "SELECT a.id, c.pic, concat_ws(' ',b.nama, b.middle_name, b.family_name), a.keterangan, a.nominal, a.id_invoice, date_format(a.dt_payment,'%d %b %y'),c.id_billing,a.kd_branch,b.kd_biodata,a.dt_payment\r
\t\t\tFROM ves_data.tb_invoice_paid a left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata left join ves_data.tb_invoice c on a.id_billing = c.id_billing\r
\t\t\twhere a.id = ? ", [(string) ($no_urut_invoice)]);	
			$resource_tbi = db_query_soft($query_tbi, $__p_query_tbi ?? []);
			if(num(db_num_rows($resource_tbi)) > 0)
				{
				while ($row_data_tbi  =  db_fetch($resource_tbi, PDO::FETCH_NUM))
					{
					$id_billing = $row_data_tbi[7];
					$id_invoice = $row_data_tbi[5];
					$nama_student = $row_data_tbi[2];
					$kd_branch = $row_data_tbi[8];
					$keterangan_paket = $row_data_tbi[3];
					$nominal = $row_data_tbi[4];
					$dt_payment = $row_data_tbi[10];
					$kd_biodata = $row_data_tbi[9];					
					}
				}						
			$query = q_set($__p_query, "insert into tbi_incentive(id_billing, id_invoice, kd_biodata, nama_student, kd_branch,keterangan_paket, nominal, dt_payment, nama_sc, st_reward, dt_entry ) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? )", [(string) ($id_billing), (string) ($id_invoice), (string) ($kd_biodata), (string) ($nama_student), (string) ($kd_branch), (string) ($keterangan_paket), (string) ($besaran), (string) ($dt_payment), (string) ($nama_lengkap), (string) ($hari_ini)]);
			$resource_input = db_query_soft($query, $__p_query ?? []);	
			}
			}
		}	

				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('tbi_inc_list.php?date_start=" . e(u($date_start)) . "&date_end=" . e(u($date_end)) . "');\n";
				echo "</script>";
}
?>	
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
<script src="file:///C|/xampp/htdocs/vcms/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="file:///C|/xampp/htdocs/vcms/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="file:///C|/xampp/htdocs/vcms/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="file:///C|/xampp/htdocs/vcms/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="file:///C|/xampp/htdocs/vcms/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="file:///C|/xampp/htdocs/vcms/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="file:///C|/xampp/htdocs/vcms/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="file:///C|/xampp/htdocs/vcms/dist/js/demo.js"></script>
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
