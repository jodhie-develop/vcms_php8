<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = 	$_SESSION['nama_lengkap']; 
//include __DIR__ . "/atas.php";
$nm_event = in_val('nm_event', 'any');
$no = in_val('kdb', 'any');

$query_detail = q_set($__p_query_detail, "SELECT t.school, t.country,t.groupschool,t.kd_school, t.no FROM ves_data.tb_master_partner t where t.no = ? ", [(string) ($no)]);
$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar_detail = db_num_rows($resource_detail);	
if(num(db_num_rows($resource_detail)) > 0)
	{
	while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
		{
		$institution = $row_detail[0];
		$country = $row_detail[1];
		$groupschool = $row_detail[2];			
		$kd_school = $row_detail[3];
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
      <h1>Add To Event</h1>
    </section>
    <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<p>
<div class="box-body">
  <table width="100%" class="table table-bordered table-striped" id="example1">

                <thead>
    <tr>
      <td width=26% height="14" align=center ><strong>Event Name </strong></td>
      <td width="74%" align=left ><strong>: <?php echo e($nm_event) ?></strong></td>
      </tr>
    <tr>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td align=left class="style24">&nbsp;</td>
    </tr>
    <tr>
      <td height="14" align=center class="style24"><strong>Institution Name </strong></td>
      <td align=left class="style24"><span class="form-group" >
        <label>: <?php echo e($institution) ?></label>
      </span></td>
    </tr>
                </thead> 
                <tbody>

    <tr>
      <td height="14" align=center class="style24"><span class="form-group">
      <label>Country</label></span></td>
      <td align=left class="style24"><strong>: <span class="form-group"><?php echo e($country) ?></span></strong></td>
    </tr>
    <tr>
      <td height="14" align=center class="style24"><span class="form-group">
        <label>Group</label>
        </span></td>
      <td align=left class="style24"><strong>: <span class="form-group"><?php echo e($groupschool) ?></span></strong></td>
    </tr>
    <tfoot>
      </tfoot>
                
</table>
                <p>
                  <input type="text" name="nm_event" id="textfield" value="<?php echo e($nm_event) ?>" hidden="">
                  <input type="text" name="institution" id="textfield2" value="<?php echo e($institution) ?>" hidden="">
                  <input type="text" name="kd_school" id="textfield3" value="<?php echo e($kd_school) ?>" hidden="">
  </p>
</div>
<p><div class="box box-warning">
  </p>
  <div class="box box-warning">
<div class="box-header with-border"><strong>Add as Participant</strong>
  <input type="submit" name="Submit" value="YES" />
</div>
<div class="box-body"></div>
</form>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$lengkap ='0';
$nama_lengkap = 	$_SESSION['nama_lengkap']; 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$school = "$tahun-$bulan-$hari";	
$school = $_GET[''];
$hari_ini = "$tahun-$bulan-$hari";	
$nm_event= in_val('nm_event', 'any');
$institution= in_val('institution', 'any');	
$kd_school= in_val('kd_school', 'any');	

$query_simpan_hapus = q_set($__p_query_simpan_hapus, "insert into ves_event.mst_booth  (nm_booth, nm_event, kd_school) values (? ,? ,? )", [(string) ($institution), (string) ($nm_event), (string) ($kd_school)]); 
$resource_simpan_hapus= db_query_or_die('errro_simpan2', $query_simpan_hapus, $__p_query_simpan_hapus ?? []);
echo "<script type=\"text/javascript\">\n";
echo "alert('Add to Participant');\n";
	echo "window.opener.location.reload(true);\n";					
	echo "window.close();\n";				
echo "</script>";
}


?>
