<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = 	$_SESSION['nama_lengkap']; 
//include __DIR__ . "/atas.php";
$nfl = in_val('nfl', 'get');

$query_detail = q_set($__p_query_detail, "SELECT v.kd_branch, v.jns_report,  v.week,v.pic,vip_file, COALESCE(NULLIF(v.nama_asli, ''), vip_file) FROM ves_data.vip_data v where no = ? ", [(string) ($nfl)]);
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
		$vip_file = $row_detail[4];
		$vip_file_tampil = $row_detail[5];
		}
	}
require_once VCMS_ROOT . '/_lib/vendor.php';   // phpoffice/phpspreadsheet (pengganti PHPExcel/ lama)
vendor_require(\PhpOffice\PhpSpreadsheet\IOFactory::class, 'pratinjau Excel', 'PhpSpreadsheet');
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
      <h1>Report Preview</h1>
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
    <tr>
      <td height="14" align=center class="style24"><span class="form-group">
        <label>File Name</label>
        </span></td>
      <td align=left class="style24"><strong>: <span class="form-group"><?php echo e($vip_file_tampil ?? $vip_file) ?></span></strong></td>
    </tr>
    <tfoot>
      </tfoot>
                
</table>
                <p>
                  <input type="text" name="nfl" id="textfield" value="<?php echo e($nfl) ?>" hidden="">
                  <input type="text" name="vip_file" id="textfield2" value="<?php echo e($vip_file) ?>" hidden="" >
  </p>
</div>
</p><div class="box box-warning">
  </p>
  <div class="box box-warning">
<Div class="row"></Div>
 <div class="box-header with-border">
   <table width="100%" class="table table-bordered table-striped" id="example2">
     <tbody>
       <tr>
         <td height="14" align=center class="style24">
<?php
$inputFileName = (string) $vip_file;
//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$imageFileType = strtolower(pathinfo($inputFileName,PATHINFO_EXTENSION));
// Path dari DB hanya boleh menunjuk file di folder upload vipfile/ (vip_updoc_save.php).
$dir_vip = realpath(VCMS_ROOT . '/vipfile');
$path_vip = $inputFileName === '' ? false : realpath(VCMS_ROOT . '/' . $inputFileName);
if ($dir_vip === false || $path_vip === false || !is_file($path_vip)
	|| !str_starts_with($path_vip, $dir_vip . DIRECTORY_SEPARATOR))
	{
	exit('File tidak ditemukan.');
	}
if ($imageFileType =='xls')
	{
	$inputFileType = 'Xls';	  	// PHPExcel: Excel5
	}
elseif ($imageFileType=='xlsx')
	{
	$inputFileType = 'Xlsx';	  	// PHPExcel: Excel2007
	}
else
	{
	exit('Pratinjau hanya tersedia untuk file Excel (xls/xlsx).');	// dulu fatal error
	}

try
	{
	$objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
	$objReader->setLoadAllSheets();
	$objPHPExcel = $objReader->load($path_vip);
	$objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Html');
	$objWriter->writeAllSheets();
	$objWriter->save('php://output');
	}
catch (\Throwable $e)
	{
	error_log('V-CMS Excel gagal [' . ($_SERVER['REQUEST_URI'] ?? 'cli') . ']: ' . get_class($e) . ': ' . $e->getMessage());
	echo 'File Excel tidak bisa ditampilkan.';
	}
exit;
?></td>
       </tr>
     <tfoot>
     </tfoot>
   </table>
 </div>
 <div class="box-header with-border"><strong>Are You Sure to Delete This Report ?</strong>
   <input type="text" name="no_leaving" id="textfield5" value="<?php echo e($no_leaving) ?>" hidden="hidden" >
  <input type="text" name="kd_invoice" id="textfield6" value="<?php echo e($kd_invoice) ?>"  hidden="hidden" >
  <input type="text" name="nmr" id="textfield4" value="<?php echo e($nmr) ?>"  hidden="hidden" >
  <input type="submit" name="Submit" value="YES" />
 </div>
<div class="box-body"></div>
</form>

</body>
</html>