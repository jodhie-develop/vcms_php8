<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = 	$_SESSION['nama_lengkap']; 
//include __DIR__ . "/atas.php";
$nfl = in_val('nfl', 'get');

$query_detail = q_set($__p_query_detail, "SELECT v.kd_branch, v.jns_report,  v.week,v.pic FROM ves_data.vip_data v where no = ? ", [(string) ($nfl)]);
$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar_detail = db_num_rows($resource_detail);	
if(num(db_num_rows($resource_detail)) > 0)
	{
	while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
		{
		$kd_branch = $row_detail[0];
		$jns_report = $row_detail[1];
		$week = $row_detail[2];
		$pic = $row_detail[3];
		}
	}
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
      <h1>VIP Report Status</h1>
    </section>
    <form method=get> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
        <!--/.col (left) -->
        <!-- right column -->
<form role="form">
    <div class="col-md-12">
    <div class="box box-warning">
<p>
<div class="box-body">
  <table width="100%" class="table table-bordered table-striped" id="example1">

                <thead>
    <tr>
      <td width=26% height="14" align=center ><strong>Center</strong></td>
      <td width="74%" align=left ><strong>: <?php echo e($kd_branch) ?></strong></td>
      </tr>
    <tr>
      <td height="14" align=center class="style24"><strong>Report Category</strong></td>
      <td align=left class="style24"><span class="form-group" >
        <label>: <?php echo e($jns_report) ?></label>
      </span></td>
    </tr>
                </thead> 
                <tbody>

    <tr>
      <td height="14" align=center class="style24"><span class="form-group">
      <label>Week</label>
      </span></td>
      <td align=left class="style24"><strong>: <span class="form-group"><?php echo e($week) ?></span></strong></td>
    </tr>
    <tr>
      <td height="14" align=center class="style24"><span class="form-group">
      <label>PIC</label>
      </span></td>
      <td align=left class="style24"><strong>: <span class="form-group"><?php echo e($pic) ?></span></strong></td>
    </tr>

                <tfoot>
                </tfoot>
                
</table>
                <p>
                  <input type="text" name="nfl" id="textfield" value="<?php echo e($nfl) ?>" hidden="">
  </p>
</div>
</p><div class="box box-warning">
  </p>
  <div class="box box-warning">
<Div class="row"></Div>
 <div class="box-header with-border"><strong>Report Status</strong>
   <input type="text" name="no_leaving" id="textfield5" value="<?php echo e($no_leaving) ?>" hidden="hidden" >
  <input type="text" name="kd_invoice" id="textfield6" value="<?php echo e($kd_invoice) ?>"  hidden="hidden" >
  <input type="text" name="nmr" id="textfield4" value="<?php echo e($nmr) ?>"  hidden="hidden" >
  <select name="st_report"  id="jns_report" class="form-control" >
    <option value="Approved">Approved</option>
    <option value="Revised">Revised</option>
    <option selected="selected"><?php echo e($st_report) ?></option>
  </select>
 </div>
 <div class="box-header with-border"><strong>Remark</strong>
   <input type="text" name="no_leaving" id="textfield5" value="<?php echo e($no_leaving) ?>" hidden="hidden" >
  <input type="text" name="kd_invoice" id="textfield6" value="<?php echo e($kd_invoice) ?>"  hidden="hidden" >
  <input type="text" name="nmr" id="textfield4" value="<?php echo e($nmr) ?>"  hidden="hidden" >
  <input type="text" ang="en-150" class="form-control"  placeholder="Remark..." name="remark" 
                 	      value="<?php echo e($remark) ?>">
<input type="submit" name="Submit" value="YES" />
 </div>
<div class="box-body"></div>
</form>

</body>
</html>
<?php
if (isset($_GET['Submit'])) 
{
$nama_lengkap = 	$_SESSION['nama_lengkap']; 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$nfl = in_val('nfl', 'get');
$remark = in_val('remark', 'get');
$st_report = in_val('st_report', 'get');
	if($st_report !='')
	{
$query_update = q_set($__p_query_update, "update ves_data.vip_data f set f.st_report = ? ,dt_st = ? ,pic_st = ? ,remark = ? where no = ? ", [(string) ($st_report), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($remark), (string) ($nfl)]);
$resource_update= db_query_or_die('errro_simpan1', $query_update, $__p_query_update ?? []);
echo "<script type=\"text/javascript\">\n";
echo "alert('Changed by " . e($nama_lengkap) . "');\n";
echo "window.opener.location.reload(true);\n";
echo "window.close(); \n";
echo "</script>";	
	}
else
{
echo "<script type=\"text/javascript\">\n";
echo "alert('Status Report must be choose');\n";
echo "</script>";	
}
}


?>
