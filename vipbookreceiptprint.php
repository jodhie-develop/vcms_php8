<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$no_log = in_val('nl', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";

$query_ambil_billing = q_set($__p_query_ambil_billing, "SELECT reg_code, item, nama_lengkap FROM ves_data.mst_asset_reg_dtl a left join ves_data.vip_billing b on a.remark = b.kd_billing\r
left join ves_data.vip_student_data c on b.kd_biodata = c.kd_biodata\r
left join ves_data.mst_asset d on id_book = d.id where remark = ? ", [(string) ($no_log)]);

$resource_ambil_billing = db_query_or_die('errro_1', $query_ambil_billing, $__p_query_ambil_billing ?? []);
while ($row_billing=  db_fetch($resource_ambil_billing, PDO::FETCH_NUM))
		{
		$book_title = $row_billing[1];
		$nama_Lengkap = $row_billing[2];
		$dt_entry = $row_billing[2];	
		$id_billing = $no_log;
		$reg_code = $row_billing[0];
			
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }</style>    
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<body class="A4">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php   //   include __DIR__ . "/left.php";	 ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

   <!-- Main content -->
<section class="content">
                 	      
<div class="col-md-12">
    <table width="63%"  id="example">
      <tbody>
        <tr>
          <td height="14" colspan="3" align=center class="style24"><label>Material Book  Received<br>
            <br>
          </label></td>
        </tr>
        <tr>
          <td width="18" rowspan="6" align=left class="style24">&nbsp;</td>
          <td align=left  class="style24"><small>
            <label>ID Billing</label>
          </small></td>
          <td height="14" align=left class="style24"><small><label>: <?php echo e($id_billing) ?></label></small></td>
        </tr>
        <tr>
          <td width="136" align=left  class="style24"><small><label>Book Title</label></small></td>
          <td width="786" height="14" align=left class="style24"><small>
          <label>: <?php echo e($book_title) ?> ( ID : <?php echo e($reg_code)  ?> ) </label></small></td>
        </tr>
        <tr>
          <td align=left  class="style24"><small>
            <label>Received By</label></small></td>
          <td height="14" align=left class="style24"><small><label>: <?php echo e($nama_Lengkap) ?></label></small></td>
        </tr>
        <tr>
          <td align=left  class="style24"><small>
            <label>Date Received</label>
          </small></td>
          <td height="14" align=left class="style24"><small><label> : <?php echo e($tgl_hari_ini) ?></label></small></td>
        </tr>
        <tr>
          <td colspan="2" align=left class="style24">&nbsp;</td>
        </tr>
        <tr>
          <td height="61" align=left class="style24"><small><br>
          <br>
          </small></td>
          <td height="61" align=right class="style24"><p><small>Sign  By : <br>
            </small></p>
            <p><small><br>
            <?php echo e($nama_Lengkap) ?><br>
          </small></p></td>
        </tr>
        <tr>
          <td height="61" colspan="3" align=left class="style24"><hr></td>
        </tr>
      <tfoot>
      </tfoot>
    </table>
</div>
</body>
</html>
<?php 
if (isset($_GET['Save'])) 
	{
	
	}
?>