<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$v = in_val('v', 'get');
$urut = in_val('urut', 'get');
$bln = num($urut)+1;
if (num($bln)<10){$bln = "0$bln";}
$kd_cbg= in_val('kd_cbg', 'get');
$thn = in_val('thn', 'get');
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
elseif (num($kd_cbg) ==00){$cabang = '--ALL--';}

$filter_cbg_sales = q_set($__p_filter_cbg_sales, " and kd_cabang = ?  ", [(string) ($kd_cbg)]);
$filter_cbg_admission = q_set($__p_filter_cbg_admission, " and kd_branch = ?  ", [(string) ($kd_cbg)]);
if (num($kd_cbg) == 00 ){$filter_cbg_sales = q_set($__p_filter_cbg_sales, " and (kd_cabang = 1 or  kd_cabang = 2 or  kd_cabang = 3 or  kd_cabang = 4 or  kd_cabang = 5 or  kd_cabang = 6 or  kd_cabang = 7 or  kd_cabang = 8 or  kd_cabang = 11 or  kd_cabang = 12 ) ");$filter_cbg_admission = q_set($__p_filter_cbg_admission, " and (kd_branch = 1 or  kd_branch = 2 or  kd_branch = 3 or  kd_branch = 4 or  kd_branch = 5 or  kd_branch = 6 or  kd_branch = 7 or  kd_branch = 8 or  kd_branch = 11 or  kd_branch = 12 ) ");}
	
if(num($v)==1)
	{
	$judul = "VOS Sales Brutto List";
	if ($bln !=  '13')
		{
		$query_bln  = q_set($__p_query_bln, " and date_format(enroll_date,'%m') = ? ", [(string) ($bln)]);
		}
	else
		{
		$query_bln  = q_set($__p_query_bln, " ");
		}
	$query= q_set($__p_query, "SELECT a.enroll_date, a.nama, b.school, b.country, a.tgl_intake, a.pic, a.kd_cabang FROM tb_sales_report a left join tb_master_partner b on a.kd_school = b.kd_school where  date_format(enroll_date,'%Y') = ? and status = 'OK' and prioritas = 1 " . $filter_cbg_sales . " " . $query_bln . " order by enroll_date desc", [(string) ($thn), ...($__p_filter_cbg_sales ?? []), ...($__p_query_bln ?? [])]);	
	}
elseif(num($v)==2)
	{
	$judul = "VOS Cancel Current Year List";

		if ($bln !=  '13')
		{
		$query_bln  = q_set($__p_query_bln, " and date_format(enroll_date,'%m') = ? ", [(string) ($bln)]);
		}
	else
		{
		$query_bln  = q_set($__p_query_bln, " ");
		}
	$query= q_set($__p_query, "select enroll_date, nama, dest_school, dest_country,tgl_intake, sc_name, kd_branch from adm_stu_progress\r
\twhere date_format(enroll_date,'%Y') = ? and date_format(update_date,'%Y') >= ? and   final_status = 'C' and aktif = 1 " . $filter_cbg_admission . " " . $query_bln, [(string) ($thn), (string) ($thn), ...($__p_filter_cbg_admission ?? []), ...($__p_query_bln ?? [])]);	
	}
elseif(num($v)==3)
	{
	$judul = "VOS Cancel from Current Year";
	
		if ($bln !=  '13')
		{
		$query_bln  = q_set($__p_query_bln, " and date_format(update_date,'%m') = ? ", [(string) ($bln)]);
		}
	else
		{
		$query_bln  = q_set($__p_query_bln, " ");
		}
	$query= q_set($__p_query, "select enroll_date, nama, dest_school, dest_country,tgl_intake, sc_name, kd_branch from adm_stu_progress\r
\twhere date_format(enroll_date,'%Y') = ? and date_format(update_date,'%Y') >= ? and   final_status = 'C' and aktif = 1 " . $filter_cbg_admission . " " . $query_bln, [(string) ($thn), (string) ($thn), ...($__p_filter_cbg_admission ?? []), ...($__p_query_bln ?? [])]);	
	}
elseif(num($v)==4)
	{
	$judul = "VOS Cancel from Previous Year List";
	
		if ($bln !=  '13')
		{
		$query_bln  = q_set($__p_query_bln, " and date_format(update_date,'%m') = ? ", [(string) ($bln)]);
		}
	else
		{
		$query_bln  = q_set($__p_query_bln, " ");
		}
	$query= q_set($__p_query, "select enroll_date, nama, dest_school, dest_country,tgl_intake, sc_name, kd_branch from adm_stu_progress\r
\twhere date_format(enroll_date,'%Y') < ? and date_format(update_date,'%Y') >= ? and   final_status = 'C' and aktif = 1 " . $filter_cbg_admission . " " . $query_bln, [(string) ($thn), (string) ($thn), ...($__p_filter_cbg_admission ?? []), ...($__p_query_bln ?? [])]);	
	}
elseif(num($v)==5)
	{
	$judul = "VOS Leaving from Current Year List";
	
		if ($bln !=  '13')
		{
		$query_bln  = q_set($__p_query_bln, " and (date_format(tgl_intake,'%m') = ? or date_format(comm_date,'%m') = ? ) ", [(string) ($bln), (string) ($bln)]);
		}
	else
		{
		$query_bln  = q_set($__p_query_bln, "and \r
((date_format(tgl_intake,'%m') = '01' ) or \r
(date_format(tgl_intake,'%m') = '02' ) or \r
(date_format(tgl_intake,'%m') = '03') or \r
(date_format(tgl_intake,'%m') = '04' ) or \r
(date_format(tgl_intake,'%m') = '05') or \r
(date_format(tgl_intake,'%m') = '06') or \r
(date_format(tgl_intake,'%m') = '07' ) or \r
(date_format(tgl_intake,'%m') = '08') or \r
(date_format(tgl_intake,'%m') = '09' ) or \r
(date_format(tgl_intake,'%m') = '10' ) or \r
(date_format(tgl_intake,'%m') = '11' ) or \r
(date_format(tgl_intake,'%m') = '12'))\r
 ");
		}
	$query= q_set($__p_query, "select enroll_date, nama, dest_school,dest_country, tgl_intake, sc_name, kd_branch from adm_stu_progress\r
\twhere date_format(enroll_date,'%Y') = ? and (date_format(tgl_intake,'%Y') = ?\r
or date_format(comm_date,'%Y') = ? )\r
and final_status = 'L' and aktif = 1 " . $filter_cbg_admission . "  " . $query_bln . " ", [(string) ($thn), (string) ($thn), (string) ($thn), ...($__p_filter_cbg_admission ?? []), ...($__p_query_bln ?? [])]);	
	}
elseif(num($v)==6)
	{
	$judul = "VOS Leaving from Previous Year List";
	
		if ($bln !=  '13')
		{
		$query_bln  = q_set($__p_query_bln, " and (date_format(tgl_intake,'%m') = ? or date_format(comm_date,'%m') = ? ) ", [(string) ($bln), (string) ($bln)]);
		}
	else
		{
		$query_bln  = q_set($__p_query_bln, " and \r
((date_format(tgl_intake,'%m') = '01' or date_format(comm_date,'%m') = '01') or \r
(date_format(tgl_intake,'%m') = '02' or date_format(comm_date,'%m') = '02') or \r
(date_format(tgl_intake,'%m') = '03' or date_format(comm_date,'%m') = '03') or \r
(date_format(tgl_intake,'%m') = '04' or date_format(comm_date,'%m') = '04') or \r
(date_format(tgl_intake,'%m') = '05' or date_format(comm_date,'%m') = '05') or \r
(date_format(tgl_intake,'%m') = '06' or date_format(comm_date,'%m') = '06') or \r
(date_format(tgl_intake,'%m') = '07' or date_format(comm_date,'%m') = '07') or \r
(date_format(tgl_intake,'%m') = '08' or date_format(comm_date,'%m') = '08') or \r
(date_format(tgl_intake,'%m') = '09' or date_format(comm_date,'%m') = '09') or \r
(date_format(tgl_intake,'%m') = '10' or date_format(comm_date,'%m') = '10') or \r
(date_format(tgl_intake,'%m') = '11' or date_format(comm_date,'%m') = '11') or \r
(date_format(tgl_intake,'%m') = '12' or date_format(comm_date,'%m') = '12')) ");
		}
	$query= q_set($__p_query, "select enroll_date, nama, dest_school,dest_country, tgl_intake, sc_name, kd_branch from adm_stu_progress\r
\twhere date_format(enroll_date,'%Y') < ? and (date_format(tgl_intake,'%Y') = ?\r
or date_format(comm_date,'%Y') = ? )\r
and final_status = 'L' and aktif = 1 " . $filter_cbg_admission . "  " . $query_bln . " ", [(string) ($thn), (string) ($thn), (string) ($thn), ...($__p_filter_cbg_admission ?? []), ...($__p_query_bln ?? [])]);	 
	}
///* echo $query (debug SQL versi lama) dihapus */
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Detail Data</title>
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
 <?php   // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=""> 
   <section class="content">
   <!-- Main content -->
   <?php


 		?>
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
<div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo e($judul) ?></h3>
			<h4><?php echo e($cabang) ?></h4>	
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Enroll Date</th>
                  <th>Student</th>
                  <th>Destination</th>
                  <th>Intake</th>
                  <th>SC</th>
                  <th>Center</th>
                </tr>
                </thead>
                <tbody>
<?php /* echo $query (debug SQL versi lama) dihapus */
$resource = db_query_soft($query, $__p_query ?? []);
if(num(db_num_rows($resource)) > 0)
	{
	$nomor = 1;
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		if (num($row[6]) ==1){$row[6] = 'East Sby';}
		elseif (num($row[6]) ==2){$row[6] = 'West Sby';}
		elseif (num($row[6]) ==3){$row[6] = 'Denpasar';}
		elseif (num($row[6]) ==4){$row[6] = 'South Jkt';}
		elseif (num($row[6]) ==5){$row[6] = 'North Jkt';}
		elseif (num($row[6]) ==6){$row[6] = 'West Jkt';}
		elseif (num($row[6]) ==7){$row[6] = 'Bandung';}
		elseif (num($row[6]) ==8){$row[6] = 'Malang TBI';}
		elseif (num($row[6])==11){$row[6] = 'PIK';}
		elseif (num($row[6]) ==12){$row[6] = 'Serpong';}
		elseif (num($row[6]) ==00){$row[6]= '--ALL--';}
?>					
                <tr>
                  <td><?php echo e($nomor) ?></td>
                  <td><?php echo e($row[0]) ?></td>
                  <td><?php echo e($row[1]) ?></td>
                  <td><?php echo e($row[3]) ?> - <?php echo e($row[2]) ?></td>
                  <td><?php echo e($row[4]) ?></td>
                  <td><?php echo e($row[5]) ?></td>
                  <td><?php echo e($row[6]) ?></td>
                </tr>
<?php $nomor = num($nomor)+1; }}?>					
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Enroll Date</th>
                  <th>Student</th>
                  <th>Destination</th>
                  <th>Intake</th>
                  <th>SC</th>
                  <th>Center</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
   
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
	  </div>

      <!-- /.row -->
   </section>
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