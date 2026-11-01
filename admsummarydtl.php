<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$ft = in_val('ft', 'get'); 
//include __DIR__ . "/atas.php";
$st= in_val('st', 'get');
$end= in_val('end', 'get');



function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
}
//==A===	
if ($ft=="A")
	{
	$judul = "TOTAL PDO";
	$query = q_set($__p_query, "select a.kd_biodata,a.nama, a.dest_school,a.dest_country, a.comm_date, b.kd_invoice, b.dt_invoice, c.dt_payment from ves_data.adm_stu_progress a left join ves_data.fin_invoice b on a.no = b.no_leaving left join ves_data.fin_comm c on a.no = c.no_leaving  where a.comm_date between ? and ? and final_status = 'L' group by kd_biodata ", [(string) ($st), (string) ($end)]);
	}
elseif ($ft=="B")
	{
	$judul = "Total PDO from Current Year Sales	";		
	$query = q_set($__p_query, "select a.kd_biodata,a.nama, a.dest_school,a.dest_country, a.comm_date, b.kd_invoice, b.dt_invoice, c.dt_payment from ves_data.adm_stu_progress a left join ves_data.fin_invoice b on a.no = b.no_leaving left join ves_data.fin_comm c on a.no = c.no_leaving  where a.comm_date between ? and ? and a.enroll_date between ? and ? and final_status = 'L' group by kd_biodata ", [(string) ($st), (string) ($end), (string) ($st), (string) ($end)]);
	}
elseif ($ft=="C")
	{
	$judul = "Total PDO from Current Year Sales	";		
	$query = q_set($__p_query, "select a.kd_biodata,a.nama, a.dest_school,a.dest_country, a.comm_date, b.kd_invoice, b.dt_invoice, c.dt_payment from ves_data.adm_stu_progress a left join ves_data.fin_invoice b on a.no = b.no_leaving left join ves_data.fin_comm c on a.no = c.no_leaving  where a.comm_date between ? and ? and a.enroll_date <  ? and final_status = 'L' group by kd_biodata ", [(string) ($st), (string) ($end), (string) ($st)]);
	}
elseif ($ft=="D")
	{
	$judul = "TOTAL PDO - NON PARTNER";
	$query = q_set($__p_query, "select a.kd_biodata,a.nama, a.dest_school,a.dest_country, a.comm_date, b.kd_invoice, b.dt_invoice, c.dt_payment from ves_data.adm_stu_progress a left join ves_data.fin_invoice b on a.no = b.no_leaving left join ves_data.fin_comm c on a.no = c.no_leaving  where a.comm_date between ? and ? and final_status = 'L' and p_np <> 'P' group by kd_biodata ", [(string) ($st), (string) ($end)]);		
	}
/* echo $query (debug SQL versi lama) dihapus */
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	

$nomor = 1;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>


  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo e($judul) ?>

      </h1>
    </section>
 <form method=get> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php    //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form">
    <div class="col-md-12">
    <div class="box box-warning">
  <div class="box box-warning">
      <div class="box box-warning">
<div class="box-body">         
                <table width="100%" class="table table-bordered table-striped" id="example1">

                <thead>
                <tr>
      <td width=2% rowspan="2" align=center >No</td>
      <td width="27%" rowspan="2" align=center >Student Name</a></td>
      <td height="14" colspan="3" align=center >Destination School</td>
      <td height="14" align=center >Invoice Code </td>
      <td height="14" align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td align=center >School</a></td>
                  <td align=center >Country</a><br></td>
                  <td align=center >Commencement Date</td>
                  <td align=center >Invoice Date</a></td>
                  <td height=14 align=center >Payment Date</a></td>
                </tr>   </thead>
                <tbody>
<?php 
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{           ?>     
                <tr>
                  <td width=2% align=center ><span class="style24"><?php echo e($nomor) ?></span></td>
                  <td width="27%" align=center ><span class="style24"><?php echo e($row[1]) ?></span></td>
      <td width="11%" align=center><span class="style24"><?php echo e($row[2]) ?></span><br></td>
      <td width="15%" align=center><span><span class="style24"><?php echo e($row[3]) ?></span></span></td>
      <td width="16%" align=center><span class="style24"><?php echo e($row[4]) ?></span></td>
      <td width="15%" align=center><span class="style24"><?php echo e($row[5]) ?></span><br>
        <span class="style24"><?php echo e($row[6]) ?></span> <br></td>
      <td width="10%" height=14 align=center ><span class="style24"><?php echo e($row[7]) ?></span></td>
      </tr><?php $nomor = num($nomor) + 1;}} ?>
	  </tbody>
                <tfoot>
                </tfoot>
                
              </table></div>
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
