<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdb = in_val('kdb', 'any');
$ed = in_val('ed', 'any');
$edid = in_val('edid', 'any');
$idsoa = "$kdb$edid";
$kd_branch = $_SESSION['kd_branch'];

$soatype = in_val('soatype', 'any');
$statement  = in_val('statement', 'any');
$deskripsi  = in_val('deskripsi', 'any');
$rupiah = in_val('rupiah', 'any');
$payment_metodh = in_val('payment_metodh', 'any');
$query_adm = q_set($__p_query_adm, "SELECT nama,enroll_date,kd_branch \tFROM  adm_stu_progress a where kd_biodata = ? and enroll_date = ? and aktif = 1", [(string) ($kdb), (string) ($ed)]);
	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$student_name = $row_adm['0'];
			$enroll_date = $row_adm['1'];
			$stu_cbg = $row_adm['2'];				
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
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
  <script src="js/tinymce.min.js"/></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<?php //========================== left nav ?>
 <?php //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>SOA Form<br></h1>
      <?php echo e($idsoa) ?>
      <span class="form-group">
<form role="form" method="post"><?php echo csrf_field(); ?>
      
      <input type="text" ang="en-150"  name="idsoa" readonly 
                 	      value="<?php echo e($idsoa) ?>" hidden="hidden">
      <input type="text" ang="en-150"  name="ed" readonly 
                 	      value="<?php echo e($ed) ?>" hidden="hidden">
      <input type="text" ang="en-150"  name="enroll_date" readonly 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
      <input type="text" ang="en-150"  name="stu_cbg" readonly 
                 	      value="<?php echo e($stu_cbg) ?>" hidden="hidden">
      </span><br>

      <!--/.col (left) -->
        <!-- right column -->

   <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>ID Student</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="kdb" readonly 
                 	      value="<?php echo e($kdb) ?>">
    </div>
</div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah2"  readonly
                 	      value="<?php echo e($student_name) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="no" 
                 	      value="<?php echo e($no) ?>" hidden= "hidden">
  </span></div>
<div class="box-body">
  <div class="col-md-7">
    <div class="form-group">
      <label>SOA Type</label>
      <select name="soatype"  id="statement" class="form-control"  readonly>

        <option selected="selected">Kredit</option>
      </select>
    </div>
  </div>

</div>
<div class="box-body">
  <div class="col-md-7">
    <div class="form-group">
      <label>Statement</label>
      <select name="statement"  id="payment_metodh" class="form-control" >
        <option value="Tuition Fee">Tuition Fee</option>
        <option value="Visa Proccess">Visa Proccess</option>
        <option value="Document Proccess">Document Proccess</option>
        <option value="Accomodation">Accomodation</option>
        <option value="Other">Other</option>
        <option selected="selected"><?php echo e($statement) ?></option>
      </select>
    </div>
  </div>
  
    <div class="col-md-8">
      <div class="form-group">
        <label>Remark</label>
        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="deskripsi" value="<?php echo e($deskripsi) ?>"><?php echo htmlspecialchars($deskripsi); ?></textarea>
      </div>
    </div>
		</div>
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Rupiah</label><input type="number" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah" 
                 	      value="<?php echo e($rupiah) ?>" >
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Payment Metodh</label>
      <select name="payment_metodh"  id="jns_report2" class="form-control" >
        <option value="Debit Card">Debit Card</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="Cek-Bg">Cek-Bg</option>
        <option value="Voucher">Voucher</option>
        <option selected="selected"><?php echo e($payment_metodh) ?></option>
      </select>
    </div>
  </div>
</div>
<div class="box-body">
  <div class="col-md-4">
      <div class="form-group">
        <label>Proposed Date</label>
        <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="efektif_date" 
                 	      value="<?php echo e($tgl_hari_ini) ?>">
      </div>
  </div>
</div>
<div class="box-body">
<input type="submit" name="Submit" value="Submit" />
		</div>
</form>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script>
	$('.textarea').wysihtml5();
</script>
<script type="text/javascript" charset="utf-8">
	$(prettyPrint);
</script>
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{
	$st_simpan = 1;		
	$idsoa = in_val('idsoa', 'any');
$ed = in_val('ed', 'any');
$kdb = in_val('kdb', 'any');
$statement = in_val('statement', 'any');
$deskripsi = in_val('deskripsi', 'any');
$rupiah = in_val('rupiah', 'any');
$payment_metodh = in_val('payment_metodh', 'any');
$efektif_date = in_val('efektif_date', 'any');
$enroll_date = in_val('enroll_date', 'any');		
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kd_branch = $_SESSION['kd_branch'];	
$stu_cbg = in_val('stu_cbg', 'any');
$soatype = in_val('soatype', 'any');
if ($soatype ==''){$st_simpan = 0;$gagal = "Debet/Kredit must be choosen";}		

if ($statement ==''){$st_simpan = 0;$gagal = "Statement must be filled";}
if ($deskripsi ==''){$st_simpan = 0;$gagal = "Description must be filled";}
if ($rupiah ==''){$st_simpan = 0;$gagal = "Amount method must be filled";}
if(num($st_simpan)==1)
	{
	if ($soatype =='Debet')
	{
	$query_simpan = q_set($__p_query_simpan, "insert into ves_data.adm_soa (id_soa,kd_biodata,enroll_date, keterangan,deskripsi, rp_debet,st_amount,dt_entry, pic,kd_branch) values (? ,? ,? ,? ,? ,? ,'1',? ,? ,? )", [(string) ($idsoa), (string) ($kdb), (string) ($enroll_date), (string) ($statement), (string) ($deskripsi), (string) ($rupiah), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($stu_cbg)]);
	}
	else
	{
	$query_simpan = q_set($__p_query_simpan, "insert into ves_data.adm_soa (id_soa,kd_biodata,enroll_date, keterangan,deskripsi, rp_kredit,st_amount,dt_entry, pic,kd_branch) values (? ,? ,? ,? ,? ,? ,'2',? ,? ,? )", [(string) ($idsoa), (string) ($kdb), (string) ($enroll_date), (string) ($statement), (string) ($deskripsi), (string) ($rupiah), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($stu_cbg)]);	
	}	
	$resource_simpan = db_query_or_die('errro_last_billing1', $query_simpan, $__p_query_simpan ?? []);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('New Statement inserted ');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}
else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($gagal) . "');\n";
	echo "</script>";		
	}
	}
?>