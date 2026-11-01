<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$q = in_val('q', 'get');
$search = in_val('search', 'get');


$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2017-07-01";}
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
$kd_area = $_SESSION['kode_area'] ;
$level_posisi = $_SESSION['level_posisi'] ;
if (num($kd_area) == 5){$area ="";}
elseif(num($kd_area) == 42){$area = q_set($__p_area, " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')");}
elseif(num($kd_area) == 41){$area = q_set($__p_area, " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')");}
elseif(num($kd_area) == 31){$area = q_set($__p_area, " and (kd_branch= '1' or kd_branch= '2')");}
elseif(num($kd_area) == 21) {$area = q_set($__p_area, " and (kd_branch= '2'or kd_branch= '8')");}
elseif(num($kd_area) == 2){$area = q_set($__p_area, " and kd_branch= ? ", [(string) ($kd_cbg)]);}
else {$area = q_set($__p_area, " and kd_branch= ? ", [(string) ($kd_cbg)]);}	
$kelompok = $_SESSION['kelompok'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="500" />
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
 <?php    include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=leadsmon.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>My Data<br>
      </h1>
      <table width="453" border="0">
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
        </tbody>
      </table>
      <table width="200" border="0">
        <tbody>
          <tr>
            <td>&nbsp;</td>
            <td><a href="leads.php?q=3" target="_parent" class="btn btn-info" role="button">My Leads</a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table>
      <!-- export tools  -->     
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-3">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">

<?php              
if(num($kd_area) == 2 or $kd_area == '')
{
$query = q_set($__p_query, "SELECT concat_ws (' ',nama,middle_name,family_name) as lngkp,  DATE_FORMAT(dt_entry,'%d %b %y'),kd_biodata FROM ves_inc.tb_biodata where pic = ? and dt_entry between ? and ? " . $area . " order by dt_entry desc", [(string) ($nama_lengkap), (string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);	
}
else
{
$query = q_set($__p_query, "SELECT concat_ws (' ',nama,middle_name,family_name) as lngkp,  DATE_FORMAT(dt_entry,'%d %b %y'),kd_biodata FROM ves_inc.tb_biodata where dt_entry between ? and ? " . $area . " order by dt_entry desc", [(string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);		
}
			
$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>				
              <blockquote>New Leads (<?php echo e($num_rows) ?>)</blockquote>				

<table width="97%" class="table table-bordered table-striped" id="example1">
                <thead>
                <tr>
                  <th width="11%">No</th>
                  <th width="54%"> Name</th>
                  <th width="35%">Entry Date</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><a href="profile.php?kdb=<?php echo e(u($r[2])); ?>" target="_blank"><?php echo e($r[0])  ?></a></td>
                  <td><?php echo e($r[1]) ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-3">
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <?php
if(num($kd_area) == 2 or $kd_area == '')
{
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  ves_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where pic = ? and ves_last_update between ? and ? " . $area . " order by ves_last_update desc", [(string) ($nama_lengkap), (string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}
else
{
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  ves_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where ves_last_update between ? and ? " . $area . " order by ves_last_update desc", [(string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}				  
$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>             
              <blockquote>Ves Last Follow Up(<?php echo e($num_rows) ?>)

              </blockquote>
              <table width="97%" class="table table-bordered table-striped" id="example11">
                <thead>
                  <tr>
                    <th width="10%">No</th>
                    <th width="78%"> Name</th>
                    <th width="12%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>
                  <tr>
                    <td><?php echo e($no_urut) ; ?></td>
                    <td><a href="profile.php?kdb=<?php echo e(u($r[2])); ?>" target="_blank"><?php echo e($r[0])  ?></a></td>
                    <td><?php echo e($r[1]) ?></td>
                  </tr>
                  <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-4">
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
<?php   
if(num($kd_area) == 2 or $kd_area == '')
{
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  vip_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where pic = ? and vip_last_update between ? and ?  " . $area . " order by vip_last_update desc", [(string) ($nama_lengkap), (string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}
else
{
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  vip_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where  vip_last_update between ? and ?  " . $area . " order by vip_last_update desc", [(string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}				 
$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>             
              <blockquote>VIP Last Follow Up (<?php echo e($num_rows) ?>)

              </blockquote>
              <table width="97%" class="table table-bordered table-striped" id="example13">
                <thead>
                  <tr>
                    <th width="11%">No</th>
                    <th width="73%"> Name</th>
                    <th width="16%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>
                  <tr>
                    <td><?php echo e($no_urut) ; ?></td>
                    <td><a href="profile.php?kdb=<?php echo e(u($r[2])); ?>" target="_blank"><?php echo e($r[0])  ?></a></td>
                    <td><?php echo e($r[1]) ?></td>
                  </tr>
                  <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-3">
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">

<?php
if(num($kd_area) == 2 or $kd_area == '')
{
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  vip_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where pic = ? and ves_last_update between ? and ? " . $area . "  and ves_status = 'P' order by ves_last_update desc", [(string) ($nama_lengkap), (string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}
else
{
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  vip_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where ves_last_update between ? and ? " . $area . "  and ves_status ='P' order by ves_last_update desc", [(string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}					  

$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
              <blockquote>VES Potential(<?php echo e($num_rows) ?>)             
              </blockquote>
              <table width="97%" class="table table-bordered table-striped" id="example14">
                <thead>
                  <tr>
                    <th width="11%">No</th>
                    <th width="73%"> Name</th>
                    <th width="16%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>
                  <tr>
                    <td><?php echo e($no_urut) ; ?></td>
                    <td><a href="profile.php?kdb=<?php echo e(u($r[2])); ?>" target="_blank"><?php echo e($r[0])  ?></a></td>
                    <td><?php echo e($r[1]) ?></td>
                  </tr>
                  <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-3">
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <?php
if(num($kd_area) == 2 or $kd_area == '')
{
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  ves_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where pic = ? and ves_last_update between ? and ? " . $area . "  and  (ves_status ='IP' or ves_status ='fP') order by ves_last_update desc", [(string) ($nama_lengkap), (string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}
else
{
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  ves_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where ves_last_update between ? and ? " . $area . "  and (ves_status ='IP' or ves_status ='fP') order by ves_last_update desc", [(string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}					  

$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
              <blockquote>VES In Progress(<?php echo e($num_rows) ?>) </blockquote>
              <table width="97%" class="table table-bordered table-striped" id="example16">
                <thead>
                  <tr>
                    <th width="11%">No</th>
                    <th width="73%"> Name</th>
                    <th width="16%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>
                  <tr>
                    <td><?php echo e($no_urut) ; ?></td>
                    <td><a href="profile.php?kdb=<?php echo e(u($r[2])); ?>" target="_blank"><?php echo e($r[0])  ?></a></td>
                    <td><?php echo e($r[1]) ?></td>
                  </tr>
                  <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-3">
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">

<?php 
if(num($kd_area) == 2 or $kd_area == '')
{
				  
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  vip_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where pic = ? and dt_entry between ? and ?  " . $area . "   and vip_status = 'P' order by ves_last_update desc", [(string) ($nama_lengkap), (string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}
else
{
$query = q_set($__p_query, "SELECT concat_ws(' ',nama,middle_name,family_name) as lngkp,  vip_status,kd_biodata\r
\tFROM ves_inc.tb_biodata where  dt_entry between ? and ?  " . $area . "    and vip_status = 'P' order by ves_last_update desc", [(string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);
}					  

$no_urut = 1;
			
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
              <blockquote>VIP Potential(<?php echo e($num_rows) ?>)             
              </blockquote>
              <table width="97%" class="table table-bordered table-striped" id="example14">
                <thead>
                  <tr>
                    <th width="11%">No</th>
                    <th width="73%"> Name</th>
                    <th width="16%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>
                  <tr>
                    <td><?php echo e($no_urut) ; ?></td>
                    <td><a href="profile.php?kdb=<?php echo e(u($r[2])); ?>" target="_blank"><?php echo e($r[0])  ?></a></td>
                    <td><?php echo e($r[1]) ?></td>
                  </tr>
                  <?php $no_urut = num($no_urut) + 1; } }?>
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
    $("#example11").DataTable();	
    $("#example13").DataTable();
    $("#example14").DataTable();
    $("#example15").DataTable();	
    $("#example16").DataTable();		  
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
