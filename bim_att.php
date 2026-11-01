<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/left.php";
include __DIR__ . "/atas.php";

$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$class = in_val('class', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista Customer System Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	
    <script src="newdata/js/jquery-3.1.1.min.js"></script>
    <script src="newdata/js/bootstrap.min.js"></script>
    <script src="newdata/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="newdata/css/bootstrap-datepicker.css"></link>
	
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
<form name="myform" id="myform">	
	<h3> VIP - BIM Student Attendance</h3>
	<div class="col-md-3">
	  <div class="form-group">
	    <label>Class Code</label>
	    <select class="form-control" name="class"  onChange="this.form.submit()" >
	      <option>ALL</option>
	      <?php
	$query_sc = q_set($__p_query_sc, "SELECT distinct kelas from ves_data.vip_teacher_schedule  where kd_branch = 400 order by kelas");
$resource_sc = db_query_or_die('errro_0', $query_sc, $__p_query_sc ?? []);
$keluar_sc= db_num_rows($resource_sc);
if(num(db_num_rows($resource_sc)) > 0)
	{
	while ($row_sc=  db_fetch($resource_sc, PDO::FETCH_NUM))
		{
		echo '<option value="'.e($row_sc[0]).'">'.e($row_sc[0]).'</option>';		

		}
	}
     ?>
	      <option selected><?php echo  e($class) ?></option>
	      </select>
	    </div>
	  </div>
	<div class="col-md-3">
	  <div class="form-group">
		  <a href="bim_att_xl.php?cl=<?php echo e(u($class)) ?>" target="_blank"> <label>Export XL</label></a>
	  </div>
	  </div>
</div>
     </div>
    </section>
  <form name="myform" id="myform">	  
   <!-- Main content -->
<section class="content">
  <div class="row">
<div class="col-md-12"><div class="box box-warning">		
<div class="box-body">
			  <div class="col-md-12">
			    <table width="100%" class="table  table-sm" id="example1">
			<thead><tr>
            <td colspan="15" align=left class="style24">Class COde</td>
            </tr>
				</thead>
      <tbody>
<?php
	$awal = 1;
if($class=='ALL'){	
$query_kelas = q_set($__p_query_kelas, "select kelas from vip_teacher_schedule where kelas like 'BIM%'and status_kelas = 1 group by kelas order by kelas");
}else{
$query_kelas = q_set($__p_query_kelas, "select kelas from vip_teacher_schedule where kelas = ? and status_kelas = 1 group by kelas order by kelas", [(string) ($class)]);	
}
$resource_kelas = db_query_or_die('errro_0', $query_kelas, $__p_query_kelas ?? []);
if(num(db_num_rows($resource_kelas)) > 0)
	{
	while ($row_kelas=  db_fetch($resource_kelas, PDO::FETCH_NUM))
		{
		$no_student = 1;
		$kode_kelas = $row_kelas[0];
		$query_student = q_set($__p_query_student, "select a.kd_biodata, nama_lengkap from ves_data.vip_billing a left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata where a.kd_class = ? order by nama_lengkap", [(string) ($kode_kelas)]);
		$resource_student = db_query_or_die('errro_0', $query_student, $__p_query_student ?? []);
		if(num(db_num_rows($resource_student)) > 0)
			{
			while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
				{	
				$kode_student = $row_student[0];
				$nama_student = $row_student[1];
				if($kode_kelas_lama != $kode_kelas){$gb = 1;}else{$gb=0;}
	?>
<?php if(num($awal)==1 or num($gb)==1){?>		  
          <tr>
            <td height="14" colspan="15" align=left class="style24"><?php echo e($kode_kelas) ?></td>
          </tr>
<?php } ?>		  
          <tr>
            <td width="10" height="14" align=left class="style24">&nbsp;</td>
            <td colspan="35" align=left class="style24"><?php echo e($no_student)?>. <?php echo e($nama_student) ?></td>
            </tr>
          <tr>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td width="87" align=left class="style24">&nbsp;</td>			  
<?php $part = 1;
$query_tgl_p1 = q_set($__p_query_tgl_p1, "select date_format(mulai_tm, '%d-%b-%y'),mulai_tm from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm limit 0,12", [(string) ($kode_kelas)]);
$resource_tgl_p1 = db_query_or_die('errro_0', $query_tgl_p1, $__p_query_tgl_p1 ?? []);
if(num(db_num_rows($resource_tgl_p1)) > 0)
	{
	while ($row_tgl_p1=  db_fetch($resource_tgl_p1, PDO::FETCH_NUM))
	{$tgl_p1 = $row_tgl_p1[0];$tgl_meeting = $row_tgl_p1[1];
	 
	 
//	$batas = 12; $a = 1;
//	for($i=1;$i<=$batas;$i++) 
		  ?> 			  
            <td width="871" colspan="12" align=left class="style24"><?php echo e($tgl_p1) ?></td>			  
<?php } }?>
          </tr>
          <tr>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td width="87" align=left class="style24">&nbsp;</td>			  
<?php 	$part = 1;
$query_tgl_p1 = q_set($__p_query_tgl_p1, "select date_format(mulai_tm, '%d-%b-%y'),mulai_tm from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm limit 0,12", [(string) ($kode_kelas)]);
$resource_tgl_p1 = db_query_or_die('errro_0', $query_tgl_p1, $__p_query_tgl_p1 ?? []);
if(num(db_num_rows($resource_tgl_p1)) > 0)
	{
	while ($row_tgl_p1=  db_fetch($resource_tgl_p1, PDO::FETCH_NUM))
	{$tgl_p1 = $row_tgl_p1[0];$tgl_meeting = $row_tgl_p1[1];
	$query_hadir = q_set($__p_query_hadir, "SELECT st_attendance FROM vip_attendance where kd_class like ? and kd_biodata = ? and dt_meeting =  ? ", [(string) ($kode_kelas), (string) ($kode_student), (string) ($tgl_meeting)]);
	$resource_hadir = db_query_or_die('errro_0', $query_hadir, $__p_query_hadir ?? []);
	if(num(db_num_rows($resource_hadir)) > 0)
		{$hdr = 1;}else{$hdr = '';}
			  ?> 			  
            <td width="871" colspan="12" align=center class="style24"><?php echo e($hdr) ?></td>			  
<?php } }?>
          </tr>	
          <tr>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td width="87" align=left class="style24">&nbsp;</td>			  
<?php $part = 2;
$query_tgl_p2 = q_set($__p_query_tgl_p2, "select date_format(mulai_tm, '%d-%b-%y') from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm limit 12,12", [(string) ($kode_kelas)]);
$resource_tgl_p2 = db_query_or_die('errro_0', $query_tgl_p2, $__p_query_tgl_p2 ?? []);
if(num(db_num_rows($resource_tgl_p2)) > 0)
	{
	while ($row_tgl_p2=  db_fetch($resource_tgl_p2, PDO::FETCH_NUM))
	{$tgl_p2 = $row_tgl_p2[0];	
//	$batas = 12; $a = 1;
//	for($i=1;$i<=$batas;$i++) 
		  ?> 	 			  
            <td width="871" colspan="12" align=left class="style24"><?php echo e($tgl_p2) ?></td>			  
<?php } }?>
          </tr>
          <tr>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td width="87" align=left class="style24">&nbsp;</td>			  
<?php 	$part = 2;
$query_tgl_p2 = q_set($__p_query_tgl_p2, "select date_format(mulai_tm, '%d-%b-%y'),mulai_tm from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm limit 12,12", [(string) ($kode_kelas)]);
$resource_tgl_p2 = db_query_or_die('errro_0', $query_tgl_p2, $__p_query_tgl_p2 ?? []);
if(num(db_num_rows($resource_tgl_p1)) > 0)
	{
	while ($row_tgl_p2=  db_fetch($resource_tgl_p2, PDO::FETCH_NUM))
	{$tgl_p2 = $row_tgl_p2[0];$tgl_meeting = $row_tgl_p2[1];
	$query_hadir = q_set($__p_query_hadir, "SELECT st_attendance FROM vip_attendance where kd_class like ? and kd_biodata = ? and dt_meeting =  ? ", [(string) ($kode_kelas), (string) ($kode_student), (string) ($tgl_meeting)]);
	$resource_hadir = db_query_or_die('errro_0', $query_hadir, $__p_query_hadir ?? []);
	if(num(db_num_rows($resource_hadir)) > 0)
		{$hdr = 1;}else{$hdr = '';}
			  ?> 			  
            <td width="871" colspan="12" align=center class="style24"><?php echo e($hdr) ?></td>			  
<?php } }?>
          </tr>	
          <tr>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td width="87" align=left class="style24">&nbsp;</td>			  
<?php $part = 3;
$query_tgl_p3 = q_set($__p_query_tgl_p3, "select date_format(mulai_tm, '%d-%b-%y') from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm limit 24,12", [(string) ($kode_kelas)]);
$resource_tgl_p3 = db_query_or_die('errro_0', $query_tgl_p3, $__p_query_tgl_p3 ?? []);
if(num(db_num_rows($resource_tgl_p3)) > 0)
	{
	while ($row_tgl_p3=  db_fetch($resource_tgl_p3, PDO::FETCH_NUM))
	{$tgl_p3 = $row_tgl_p3[0];	
//	$batas = 12; $a = 1;
//	for($i=1;$i<=$batas;$i++) 
		  ?> 			  
            <td width="871" colspan="12" align=left class="style24"><?php echo e($tgl_p3) ?></td>			  
<?php } }?>
          </tr>
          <tr>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td width="87" align=left class="style24">&nbsp;</td>			  
<?php 	$part = 2;
$query_tgl_p2 = q_set($__p_query_tgl_p2, "select date_format(mulai_tm, '%d-%b-%y'),mulai_tm from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm limit 24,12", [(string) ($kode_kelas)]);
$resource_tgl_p2 = db_query_or_die('errro_0', $query_tgl_p2, $__p_query_tgl_p2 ?? []);
if(num(db_num_rows($resource_tgl_p1)) > 0)
	{
	while ($row_tgl_p2=  db_fetch($resource_tgl_p2, PDO::FETCH_NUM))
	{$tgl_p2 = $row_tgl_p2[0];$tgl_meeting = $row_tgl_p2[1];
	$query_hadir = q_set($__p_query_hadir, "SELECT st_attendance FROM vip_attendance where kd_class like ? and kd_biodata = ? and dt_meeting =  ? ", [(string) ($kode_kelas), (string) ($kode_student), (string) ($tgl_meeting)]);
	$resource_hadir = db_query_or_die('errro_0', $query_hadir, $__p_query_hadir ?? []);
	if(num(db_num_rows($resource_hadir)) > 0)
		{$hdr = 1;}else{$hdr = '';}
			  ?> 			  
            <td width="871" colspan="12" align=center class="style24"><?php echo e($hdr) ?></td>			  
<?php } }?>
          </tr>	
          <tr>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td width="87" align=left class="style24">&nbsp;</td>			  
<?php $part = 4;
$query_tgl_p4 = q_set($__p_query_tgl_p4, "select date_format(mulai_tm, '%d-%b-%y') from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm limit 36,12", [(string) ($kode_kelas)]);
$resource_tgl_p4 = db_query_or_die('errro_0', $query_tgl_p4, $__p_query_tgl_p4 ?? []);
if(num(db_num_rows($resource_tgl_p4)) > 0)
	{
	while ($row_tgl_p4=  db_fetch($resource_tgl_p4, PDO::FETCH_NUM))
	{$tgl_p4 = $row_tgl_p4[0];	
//	$batas = 12; $a = 1;
//	for($i=1;$i<=$batas;$i++) 
		  ?>		  
            <td width="871" colspan="12" align=left class="style24"><?php echo e($tgl_p4) ?></td>			  
<?php } }?>
          </tr>
          <tr>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td width="87" align=left class="style24">&nbsp;</td>			  
<?php 	$part = 2;
$query_tgl_p2 = q_set($__p_query_tgl_p2, "select date_format(mulai_tm, '%d-%b-%y'),mulai_tm from vip_teacher_schedule where kelas = ? and status_kelas = 1 order by mulai_tm limit 36,12", [(string) ($kode_kelas)]);
$resource_tgl_p2 = db_query_or_die('errro_0', $query_tgl_p2, $__p_query_tgl_p2 ?? []);
if(num(db_num_rows($resource_tgl_p1)) > 0)
	{
	while ($row_tgl_p2=  db_fetch($resource_tgl_p2, PDO::FETCH_NUM))
	{$tgl_p2 = $row_tgl_p2[0];$tgl_meeting = $row_tgl_p2[1];
	$query_hadir = q_set($__p_query_hadir, "SELECT st_attendance FROM vip_attendance where kd_class like ? and kd_biodata = ? and dt_meeting =  ? ", [(string) ($kode_kelas), (string) ($kode_student), (string) ($tgl_meeting)]);
	$resource_hadir = db_query_or_die('errro_0', $query_hadir, $__p_query_hadir ?? []);
	if(num(db_num_rows($resource_hadir)) > 0)
		{$hdr = 1;$ttl_hdr = num($ttl_hdr) + 1; }else{$hdr = '';}
			  ?> 			  
            <td width="871" colspan="12" align=center class="style24"><?php echo e($hdr) ?></td>			  
<?php   } }?>
          </tr>
          <tr>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td colspan="13" align=left class="style24">TOTAL ATTENDANCE :<?php echo e($ttl_hdr) ?> </td>
            </tr>	
		  
<?php $no_student = num($no_student)+1;$kode_kelas_lama = $kode_kelas;$awal = 0; } }?>		  
<?php } }?>
	</tbody>
        <tfoot>
        </tfoot>
    </table>
<br>
      </div>
</div>
		</div>
</div>
<div class="box-body"></div>
<div class="box-body"></div>
</form>
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
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))   /* blok lama tanpa tombol pemicu: hanya POST+CSRF */) 
	{		
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$kdcbg = $_SESSION['kd_branch']; 
	$kdb = in_val('kdb', 'get');
	$st = in_val('st', 'get');
	$hari=date("d");
	$bulan=date("m");
	$bulanan=date("M");
	$storage = in_val('storage', 'get');

	if ($storage =='East Sby'){$kd_branch_dipilih='1';}
	if ($storage =='West Sby'){$kd_branch_dipilih='2';}
	if ($storage =='Denpasar'){$kd_branch_dipilih='3';}
	if ($storage =='Malang'){$kd_branch_dipilih='8';}
	if ($storage =='South Jkt'){$kd_branch_dipilih='4';}
	if ($storage =='North Jkt'){$kd_branch_dipilih='5';}
	if ($storage =='West Jkt'){$kd_branch_dipilih='6';}
	if ($storage =='Bandung'){$kd_branch_dipilih='7';}
	if ($storage =='HO'){$kd_branch_dipilih='10';}
	if ($storage =='Vpro East'){$kd_branch_dipilih='11';}
	if ($storage =='Vpro West'){$kd_branch_dipilih='12';}		

	$source = in_val('source', 'get');
	if ($source =='Vendor') {$source = $nm_vendor;}
	$nm_book = in_val('nm_book', 'get');
	$nm_vendor = in_val('nm_vendor', 'get');
	$jml_masuk = in_val('jml_masuk', 'get');
	$dt_in = in_val('dt_in', 'get');
	$jml_unit = in_val('jml_unit', 'get');		
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";			
	$query_book_in= q_set($__p_query_book_in, "insert into vipbookin (kd_branch,buku, jml_in, dt_in, source, pic) values (? ,? ,? ,? ,? ,? ) ", [(string) ($kd_branch_dipilih), (string) ($nm_book), (string) ($jml_unit), (string) ($dt_in), (string) ($source), (string) ($nama_lengkap)]); 
	$resource_book_in = db_query_or_die('errro_simpan', $query_book_in, $__p_query_book_in ?? []);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('New Book Submitted');\n";
	echo "window.location = ('vipbook.php?storage=" . e(u($storage)) . "');\n";				
	echo "</script>";
		}
if (isset($_GET['Print'])) 
	{
	if ($idb !='')
		{
		echo "<script type=\"text/javascript\">\n";
		echo "window.open('vipbillprint.php?idb=" . e(u($idb)) . "&kdb" . e($kdb) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
		echo "</script>";		
		}
	}
?>