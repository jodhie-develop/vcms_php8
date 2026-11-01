<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
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

//if ($leaving_start ==''){$leaving_start = "2017-07-01";}
//if ($leaving_end ==''){$leaving_end = $hari_ini;}

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
if ($pilihan_center=='East Sby'){$datacabang =" and c.kd_branch = '1' ";}
if ($pilihan_center=='West Sby'){$datacabang =" and c.kd_branch = '2' ";}
if ($pilihan_center=='Denpasar'){$datacabang =" and c.kd_branch = '3' ";}
if ($pilihan_center=='South Jkt'){$datacabang =" and c.kd_branch = '4' ";}
if ($pilihan_center=='North Jkt'){$datacabang =" and c.kd_branch = '5' ";}
if ($pilihan_center=='West Jkt'){$datacabang =" and c.kd_branch = '6' ";}
if ($pilihan_center=='Bandung'){$datacabang =" and c.kd_branch = '7' ";}
if ($pilihan_center=='Malang TBI'){$datacabang =" and c.kd_branch = '8' ";}
if ($pilihan_center=='Bali TBI'){$datacabang =" and c.kd_branch = '10' ";}
if ($pilihan_center=='Bandung TBI'){$datacabang =" and c.kd_branch = '9' ";}

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
<?php //========================== left nav ?>
 <?php     include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=""> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Quiz List<br>
     </h1>
     <div class="col-md-12"></div>
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
$query = q_set($__p_query, "Select kd_staff, pic, dt_entry,dt_score from ves_data.tb_quiz  group by kd_staff order by dt_entry");	
$nomor = 1;
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
				  ?>
                <thead>
                <tr>
      <td width=7% height="14" align=center >No</td>
      <td width="59%" align=center >Staff Name</td>
      <td width="34%" align=center >Date Entry</td>
      <td width="34%" align=center >Date Reviewed</td>
      </tr>
                </thead>
                <tbody>
<?php
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$kd = $row[0];
		$staff_name = $row[1];
		$dt_entry = $row[2];
		$dt_score = $row[3];			
?>	
    <tr>
      <td height="14" align=center class="style24"><?php echo e($nomor) ?></td>
<td align=center class="style24">      <a href="vipquizreview.php?kd=<?php echo e(u($kd)); ?>"> <?php echo e($staff_name) ?><br></a></td>
<td align=center class="style24"><?php echo e($dt_entry) ?></td>
      <td align=center class="style24"><?php if ($dt_score !='0000-00-00') {echo e($dt_score) ;} ?></td>
		</tr>
<?php 
$nomor = num($nomor)+1;
}}
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
   <section class="content">
      <div class="row">
		<div class="col-md-12">   
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body"></div>
			   </div>
		  </div>
     </div>

     <!-- /.row -->
   </section>
   
    <!-- /.content -->
  </form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  
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
