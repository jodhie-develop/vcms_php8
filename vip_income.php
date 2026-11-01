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
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nm_cabang = in_val('nm_cabang', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'];
$kd_area = $_SESSION['kd_area'];
if ($nm_cabang =='East Sby'){$nm_db= q_set($__p_nm_db, "billing");}
if ($nm_cabang =='West Sby'){$nm_db= q_set($__p_nm_db, "billing_west");}
if ($nm_cabang =='Denpasar'){$nm_db= q_set($__p_nm_db, "billing_bali");}
if ($nm_cabang =='South Jkt'){$nm_db= q_set($__p_nm_db, "billing_jkt_02");}
if ($nm_cabang =='North Jkt'){$nm_db= q_set($__p_nm_db, "billing_new_gs");}
if ($nm_cabang =='West Jkt'){$nm_db= q_set($__p_nm_db, "billing_m2");}
if ($nm_cabang =='Bandung'){$nm_db= q_set($__p_nm_db, "billing_new_bdg");}
if ($nm_cabang =='Malang'){$nm_db= q_set($__p_nm_db, "billing_malang");}

if (num($kd_area) == 5){$area ="";}
elseif(num($kd_area) == 42){$area = " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')";}
elseif(num($kd_area) == 41){$area = " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')";}
elseif(num($kd_area) == 31){$area = " and (kd_branch= '1' or kd_branch= '2')";}
elseif(num($kd_area) == 21) {$area = " and (kd_branch= '2'or kd_branch= '8')";}
elseif(num($kd_area) == 2){$area = " and kd_branch= '$kd_cbg'";}
else {$area = " and kd_branch= '$kd_cbg'";}	

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="500" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables </title>
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
 <?php    include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_income.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>VIP Income Summary<br><?php echo e($kd_cbg) ?>
     </h1>
      <table width="453" border="0">
        <tr>
          <td height="24"><small>
            <label for="date6">Center</label>
          </small></td>
          <td><small>
            <label for="date7">:</label>
            <select name="nm_cabang"  onChange="this.form.submit()"   class="style33" id="select">

              <option value="East Sby">East Sby</option>
              <option value="West Sby">West Sby</option>
              <option value="Denpasar">Denpasar</option>
              <option value="South Jkt">South Jkt</option>
              <option value="North Jkt">North Jkt</option>
              <option value="West Jkt">West Jkt</option>
              <option value="Bandung">Bandung</option>
              <option value="Malang">Malang</option>
                                                                  

                            
              <option selected="selected"><?php echo e($nm_cabang) ?></option>
            </select>
          </small></td>
        </tr>
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Entry Period :</label>
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
              <table width=1432 height=66 border=1 align="center" cellpadding="1" cellspacing=0 bgcolor="#FFFFFF" id=table_main class="table table-bordered table-striped" >
        <tr>
          <td width="5%" colspan="-27" align=center bgcolor="#92C8FE" class="style90">No</td>
          <td width="57%" align=center bgcolor="#92C8FE" class="style90">Detail</td>
          <td width="38%" align=center bgcolor="#92C8FE" class="style90">Amount<span class="style50"></span></td>
          </tr>
      
      
      <?php
	  function buatrpi($angka)
{
if (num($angka) !=0)
{$jadi = "Rp " . number_format(num($angka),0,',',',');
return $jadi;
}
else
{echo e($jadi = 0);}
}
	 $nomor_urut = '1';
	$jml_uang = 0;			  
	$query_sum = q_set($__p_query_sum, "select sum(mount_pat), jns_pay  from " . $nm_db . ".tb_receipt where tgl_pay between ? and ? group by jns_pay", [...($__p_nm_db ?? []), (string) ($date_start), (string) ($date_end)]);

				  $result_sum=db_query_or_die("Wah error nihhhh	! 2", $query_sum, $__p_query_sum ?? []); 

	while ($r_dtli_sum = db_fetch($result_sum))
		{ ?>
      <tr onMouseOver="ChangeBackgroundColor(this)" onMouseOut="RestoreBackgroundColor(this)" bgcolor="<?php if ( num($no_urut_week) % 2 == 0){echo "#ECF0F9" ;  }else {echo "#FFFFFF";}?>" >
        <td height="14" align=center  class="style49"><span class="stylebulan"><?php echo e($nomor_urut) ?></span></td>
        <td align=left  class="style49"><span class="stylebulan"><?php echo e($r_dtli_sum[1])  ?></span></td>
        <td height="14" align=left  class="style49"><span class="stylebulan"><?php echo  e(buatrpi($r_dtli_sum[0])) ?></span></td>
        </tr>
              
		<?php 
			 $jml_uang = num($jml_uang) + num($r_dtli_sum[0]);
			$nomor_urut = num($nomor_urut) +1;
		} 
?>
      <tr onMouseOver="ChangeBackgroundColor(this)" onMouseOut="RestoreBackgroundColor(this)" bgcolor="<?php if ( num($no_urut_week) % 2 == 0){echo "#ECF0F9" ;  }else {echo "#FFFFFF";}?>" >
        <td height="14" align=center  class="style49">&nbsp;</td>
        <td align=left  class="style49">TOTAL</td>
        <td height="14" align=left  class="style49"><span class="stylebulan"><?php echo  e(buatrpi($jml_uang)) ?></span></td>
      </tr>
	  
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
   <div class="col-xs-12">
       
        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#detail">view detail</button>       

	    </div> 
 
         <div class="col-xs-12" >
          <!-- /.box -->
         <div id="detail" class="collapse">    
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width=1432 height=66 border=1 align="center" cellpadding="1" cellspacing=0 bgcolor="#FFFFFF" id=table_main class="table table-bordered table-striped" >
        <tr>
          <td width="3%" colspan="-27" align=center bgcolor="#92C8FE" class="style90">No</td>
          <td width="17%" align=center bgcolor="#92C8FE" class="style90">Receipt</td>
          <td width="17%" align=center bgcolor="#92C8FE" class="style90">Student Name <span class="style50"><br>
          </span></td>
          <td width="16%" align=center bgcolor="#92C8FE" class="style90">Program</td>
          <td width="16%" align=center bgcolor="#92C8FE" class="style90">Detail</td>
          <td width="13%" align=center bgcolor="#92C8FE" class="style90">Amount</td>
          <td width="18%" colspan="-27" align=center bgcolor="#92C8FE" class="style90">Payment By</td>
       </tr>
      
      
      <?php
	  function buatrp($angka)
{
if (num($angka) !=0)
{$jadi = "Rp " . number_format(num($angka),0,',',',');
return $jadi;
}
else
{echo e($jadi = 0);}
}
	  $nomor_urut = '1';
	$query_twi = q_set($__p_query_twi, "select date_format(tgl_pay,'%d %b %y'), id_receipt,nm_student,  nm_prg, mount_pat, jns_pay,pay_mtd from " . $nm_db . ".tb_receipt where tgl_pay between ? and ? order by tgl_pay", [...($__p_nm_db ?? []), (string) ($date_start), (string) ($date_end)]);
	$result_twi=db_query_or_die("Wah error nih	11! 2", $query_twi, $__p_query_twi ?? []); 
	while ($r_dtli = db_fetch($result_twi))
		{ ?>
      <tr onMouseOver="ChangeBackgroundColor(this)" onMouseOut="RestoreBackgroundColor(this)" bgcolor="<?php if ( num($no_urut_week) % 2 == 0){echo "#ECF0F9" ;  }else {echo "#FFFFFF";}?>" >
        <td height="14" align=center  class="style49"><span class="stylebulan"><?php echo e($nomor_urut) ?></span></td>
        <td align=left  class="style49"><span class="stylebulan"><?php echo e($r_dtli[1]) ?> (<?php echo e($r_dtli[0]) ?>)</span></td>
        <td height="14" align=left  class="style49"><span class="stylebulan"><?php echo  e($r_dtli[2]) ?></span></td>
        <td height="14" align=center  class="style49"><span class="stylebulan"><?php echo  e($r_dtli[3]) ?></span></td>
        <td align=left  class="style49"><span class="stylebulan"><?php echo  e($r_dtli[5]) ?></span></td>
        <td align=right  class="style49"><span class="stylebulan"><?php echo  e(buatrp($r_dtli[4])) ?></span></td>
        <td height="14" align=left  class="style49"><span class="stylebulan"><?php echo  e($r_dtli[6]) ?></span></td>
      </tr>
      
		<?php $nomor_urut = num($nomor_urut) +1;
		} 
?>	  
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
