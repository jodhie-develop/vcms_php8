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
$thn_period = in_val('thn_period', 'get');
if($date_start == ''){$date_start ='2026-01-01';}
if($date_end == ''){$date_end = $hari_ini;}

$thn = $thn_period;

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_cbg = in_val('kd_cbg', 'get');

if ($kd_cbg == '--ALL--' or $kd_cbg == ''  ){$kd_cbg = 00;}
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'HO'){$kd_cbg = 0;}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 14;}
if (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif (num($kd_cbg) ==0){$cabang = 'HO';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}
elseif (num($kd_cbg) == 00 ){$cabang = '--ALL--';}
elseif (num($kd_cbg) == 15){$kd_cbg = 'CA';}
elseif (num($kd_cbg) == 16){$kd_cbg = 'Tangerang';}
$filter_cbg_sales = " and kd_cabang = $kd_cbg ";
$filter_cbg_admission = " and kd_branch = $kd_cbg ";
if (num($kd_cbg) == 00 ){$filter_cbg_sales = " and (kd_cabang = 1 or  kd_cabang = 2 or  kd_cabang = 3 or  kd_cabang = 4 or  kd_cabang = 5 or  kd_cabang = 6 or  kd_cabang = 7 or  kd_cabang = 8 or  kd_cabang = 11 or  kd_cabang = 12 ) ";$filter_cbg_admission = " and (kd_branch = 1 or  kd_branch = 2 or  kd_branch = 3 or  kd_branch = 4 or  kd_branch = 5 or  kd_branch = 6 or  kd_branch = 7 or  kd_branch = 8 or  kd_branch = 11 or  kd_branch = 12 or  kd_branch = 14 ) ";}
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
 <form method=get action=situation.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <!-- Main content -->
<?php //if($kd_cbg ==''){die;} ?>	  
    <section class="content">

		  
            <!-- /.box-header -->
 
<section class="content-header">
  <h1>
    <i class="fa fa-trophy"></i></h1>
  <table width="527" border="0">
    <tbody>
      <tr>
        <td width="149"><label for="date5"> Payment Period </label>
          </small></td>
        <td width="368"><input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
          To </small><small>
            <input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>"  onChange="this.form.submit()">
          </small></td>
      </tr>
    </tbody>
  </table>
  <h1>VIP Leaderboard Sales
    <small>Achievement</small>
  </h1>
</section>

<section class="content">

  <!-- FILTER -->
  <div class="row">
    <div class="col-md-12 text-right">
      <select class="form-control" style="width:200px; display:inline;">
        <option>Mei 2026</option>
        <option>April 2026</option>
      </select>
    </div>
  </div>

  <br>

  <!-- TOP 3 -->
  <div class="row">
<?php
$query_cbg = q_set($__p_query_cbg, "select b.kd_branch, sum(a.amount) as ttl from vip_billing_payment a\r
left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing\r
where dt_payment between ? and ? and status = 'PAID' and (jns_payment <> 'Registration') group by b.kd_branch order by ttl desc ", [(string) ($date_start), (string) ($date_end)]);	

$resource_cbg = db_query_or_die('error_1', $query_cbg, $__p_query_cbg ?? []);
if(num(db_num_rows($resource_cbg)) > 0)
	{
	$nomor = 1;
	while ($row_cbg  =  db_fetch($resource_cbg, PDO::FETCH_NUM))
		{
		$kd_cbg = $row_cbg[0];
		if (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif (num($kd_cbg) ==0){$cabang = 'HO';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}
elseif (num($kd_cbg) == 15){$cabang = 'CA';}
elseif (num($kd_cbg) == 16){$cabang = 'Tangerang';}
	
?>	
    <!-- Rank 2 -->
    <div class="col-md-4">
      <div class="box box-default text-center">
        <div class="box-body">
          <h2><i class="fa fa-trophy text-yellow"></i> #<?php echo e($nomor) ?></h2>
          <img src="https://i.pravatar.cc/80?img=2" class="img-circle" />
           <h3><b><?php echo e($cabang) ?> </b></h3></h4>

          <h2 class="text-yellow"><?php echo  number_format(num($row_cbg[1]),0,".",".") ?></h2>
        </div>
      </div>
    </div>
<?php  $nomor = num($nomor)+1;  }} ?>
    <!-- Rank 1 -->


  </div>

  <!-- MAIN CONTENT -->
  <div class="row">

    <!-- TABLE -->
    <div class="col-md-8">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Sales Person Rank</h3>
        </div>
        <div class="box-body">

          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Rank</th>
                <th>Nama</th>
                <th>Total</th>
                <th>%</th>
                <th>Progress</th>
              </tr>
            </thead>

            <tbody>
<?php 
$query_sc = q_set($__p_query_sc, "select b.sc, b.kd_branch,  sum(a.amount) as ttl from vip_billing_payment a\r
left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing\r
where dt_payment between ? and ? and status = 'PAID' and (jns_payment <> 'Registration') group by b.sc, b.kd_branch order by ttl desc", [(string) ($date_start), (string) ($date_end)]);	

$resource_sc = db_query_or_die('error_1', $query_sc, $__p_query_sc ?? []);
$jml_sc = db_num_rows($resource_sc)	;			
if(num(db_num_rows($resource_sc)) > 0)
	{
	$nomor = 1;
	while ($row_sc  =  db_fetch($resource_sc, PDO::FETCH_NUM))
		{
		if (num($nomor) == 1){$amount_pembanding = $row_sc[2];$pembanding = '100'; $top_sc = $row_sc[0];}else{$pembanding = num((div($row_sc[2], $amount_pembanding)))*100;}
		
?>				
              <tr>
                <td><span class="label label-warning">1</span></td>
                <td><?php echo e($row_sc[0]) ?></td>
                <td><?php echo  number_format(num($row_sc[2]),0,".",".") ?></td>
                <td><?php echo round(num($pembanding),2) ?>%</td>
                <td>
                  <div class="progress">
                    <div class="progress-bar progress-bar-yellow" style="width:<?php echo e($pembanding) ?>%"></div>
                  </div>
                </td>
              </tr>
<?php $nomor = num($nomor) + 1; $total_amount = num($total_amount) + num($row_sc[2]);}} ?>


            </tbody>
          </table>

        </div>
      </div>
    </div>

    <!-- SIDEBAR -->
    <div class="col-md-4">

      <!-- STAT -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Statistik</h3>
        </div>
        <div class="box-body">
          <p><b>Total Income :</b><br><?php echo  number_format(num($total_amount),0,".",".") ?></p>
          <p><b>Sales Aktif:</b><br><?php echo e($jml_sc) ?></p>
          <p><b>Average:</b><br><?php echo  number_format(num((div($total_amount, $jml_sc))),0,".",".") ?> </p>
			
        </div>
      </div>

      <!-- ACHIEVEMENT -->
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Top Achievement</h3>
        </div>
    <div class="col-md-4">
      <div class="box box-default text-center">
        <div class="box-body">
          <h2><i class="fa fa-trophy text-yellow"></i> #1 </h2>
          <img src="https://i.pravatar.cc/80?img=2" class="img-circle" />
           <h3><b><?php echo e($top_sc) ?> </b></h3></h4>
        </div>
      </div>
    </div>
      </div>

    </div>

  </div>

</section>
          </div>
		</div>
	  </div>
		</div>	 
	 </div>
	  </section>
      <!-- /.row --><!-- /.content -->

<!-- /.content-wrapper --><!-- Control Sidebar -->

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

