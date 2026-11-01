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
if ($kd_cbg == '--ALL--' or $kd_cbg == ''  ){$kd_cbg = 1000;}
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
elseif (num($kd_cbg) == 1000 ){$cabang = '--ALL--';}
elseif ($kd_cbg == '' ){$cabang = '--ALL--';}
$filter_cbg_sales = q_set($__p_filter_cbg_sales, " and a.kd_branch = ?  ", [(string) ($kd_cbg)]);

if (num($kd_cbg) == 1000 ){$filter_cbg_sales = q_set($__p_filter_cbg_sales, " and (a.kd_branch = 1 or  a.kd_branch = 2 or  a.kd_branch = 3 or  a.kd_branch = 4 or  a.kd_branch = 5 or  a.kd_branch = 6 or  a.kd_branch = 7 or  a.kd_branch = 8 or  a.kd_branch = 11 or  a.kd_branch = 12 ) ");}


	
if(num($v)==1)
	{
	$judul = "VIP Sales Pax";

	$query= q_set($__p_query, "select\r
a.dt_entry, nama_lengkap, nm_program, a.level_program, sc\r
from vip_billing a\r
left join vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program\r
left join vip_student_data c on a.kd_biodata = c.kd_biodata\r
left join vip_billing_payment d on a.kd_billing = d.kd_billing\r
where date_format(a.dt_entry,'%m-%Y') = ? \r
" . $filter_cbg_sales . " " . ($query_bln ?? '') . "\r
and b.level_program not like '%Placement%' and d.status = 'PAID' and jns_payment not like '%Registration%' group by a.kd_billing", [(string) ($bln) . "-" . (string) ($thn), ...($__p_filter_cbg_sales ?? [])]);	
	}
elseif(num($v)==2)
	{
	$judul = "VIP Student Open Class";

	$query= q_set($__p_query, "SELECT g.dt_entry, nama_lengkap, i.nm_program, a.kelas, g.sc FROM ves_data.vip_teacher_schedule a\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f\r
ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
left join vip_billing g on a.kelas = g.kd_class\r
left join vip_student_data h on g.kd_biodata = h.kd_biodata\r
left join vip_mst_code_prg i on g.kd_program = i.kd_program and g.level_program = i.level_program\r
where date_format(a.dt_entry,'%m-%Y') = ?  and a.status_kelas = 1\r
" . $filter_cbg_sales . " " . ($query_blng ?? ''), [(string) ($bln) . "-" . (string) ($thn), ...($__p_filter_cbg_sales ?? [])]);	
	}
elseif (num($v)==5)
	{
	$judul = "VIP Free Placement Test";

	$query= q_set($__p_query, "select\r
a.dt_entry, nama_lengkap, nm_program, a.level_program, sc\r
from vip_billing a\r
left join vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program\r
left join vip_student_data c on a.kd_biodata = c.kd_biodata\r
left join vip_billing_payment d on a.kd_billing = d.kd_billing\r
where date_format(a.dt_entry,'%m-%Y') = ?  and a.level_program = 'Free Placement Test'\r
" . $filter_cbg_sales . " group by a.kd_biodata", [(string) ($bln) . "-" . (string) ($thn), ...($__p_filter_cbg_sales ?? [])]);	
	}
elseif (num($v)==6)
	{
	$judul = "VIP Paid Placement Test";

	$query= q_set($__p_query, "select\r
a.dt_entry, nama_lengkap, nm_program, a.level_program, sc\r
from vip_billing a\r
left join vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program\r
left join vip_student_data c on a.kd_biodata = c.kd_biodata\r
left join vip_billing_payment d on a.kd_billing = d.kd_billing\r
where date_format(a.dt_entry,'%m-%Y') = ?   and a.level_program like  '%Placement%' and (reg_fee <> 0  or tf <> 0)\r
" . $filter_cbg_sales . " group by a.kd_biodata", [(string) ($bln) . "-" . (string) ($thn), ...($__p_filter_cbg_sales ?? [])]);	
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
                  <th>Program</th>
                  <th>SC</th>
                  </tr>
                </thead>
                <tbody>
<?php

$resource = db_query_soft($query, $__p_query ?? []);
if(num(db_num_rows($resource)) > 0)
	{
	$nomor = 1;
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{

?>					
                <tr>
                  <td><?php echo e($nomor) ?></td>
                  <td><?php echo e($row[0]) ?></td>
                  <td><?php echo e($row[1]) ?></td>
                  <td><?php echo e($row[2]) ?> - <?php echo e($row[3]) ?></td>
                  <td><?php echo e($row[4]) ?></td>
                  </tr>
<?php $nomor = num($nomor)+1; }}?>					
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Enroll Date</th>
                  <th>Student</th>
                  <th>Destination</th>
                  <th>SC</th>
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