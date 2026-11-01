<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_effective =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap'];
$id = in_val('id', 'any');
$p = in_val('p', 'any');

$kd_branch = $_SESSION['kd_branch'];

$query_adm = q_set($__p_query_adm, "SELECT a.id_soa, a.kd_biodata, b.nama, a.keterangan, a.deskripsi, a.rp_debet, a.dt_entry,a.pay_mtd,a.no_ref,a.rp_kredit, a.st_amount,a.bank_name, a.bank_penerima, a.bank_rekening, a.id_receipt FROM ves_data.adm_soa a left join ves_data.adm_stu_progress b on a.kd_biodata = b.kd_biodata where b.aktif = 1 and a.id= ? ", [(string) ($id)]);

	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$student_name = $row_adm['2'];
			$kdb = $row_adm['1'];
			$statement = $row_adm['3'];	
			$deskripsi = $row_adm['4'];		
			$rupiah = $row_adm['5'];		
			$tgl_hari_ini = $row_adm['6'];		
			$payment_metodh = $row_adm['7'];	
			$noref = $row_adm['8'];	
			$kredit_rupiah = $row_adm['9'];	
			$st_amount = $row_adm['10'];
			$bankname = $row_adm['11'];
			$namapenerima = $row_adm['12'];
			$norek  = $row_adm['13'];				
			$idreceipt  = $row_adm['14'];				
				
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
      <h1><?php if (num($st_amount) ==1) {echo "Uang Masuk Form" ;} else {echo "Uang Keluar Form";} ?> <br>
      <?php echo e($idsoa) ?>
      <span class="form-group">
 <form method="post"><?php echo csrf_field(); ?><form role="form" method="post"><?php echo csrf_field(); ?>
      
      <input type="text" ang="en-150"  name="idsoa" readonly 
                 	      value="<?php echo e($idsoa) ?>" hidden="hidden">
      <input type="text" ang="en-150"  name="ed" readonly 
                 	      value="<?php echo e($ed) ?>" hidden="hidden">
      <input type="text" ang="en-150"  name="enroll_date" readonly 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
      <input type="text" ang="en-150"  name="stu_cbg" readonly 
                 	      value="<?php echo e($stu_cbg) ?>" hidden="hidden">
   <input type="text" ang="en-150"  name="id" readonly 
                 	      value="<?php echo e($id) ?>" hidden="hidden">
   <input type="text" ang="en-150"  name="p" readonly 
                 	      value="<?php echo e($p) ?>" hidden="hidden">
      <input type="text" ang="en-150"  name="st_amount" readonly 
                 	      value="<?php echo e($st_amount) ?>" >
      <input type="text" ang="en-150"  name="idreceipt" readonly 
                 	      value="<?php echo e($idreceipt) ?>" >
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
        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="deskripsi"><?php echo htmlspecialchars($deskripsi); ?></textarea>
      </div>
    </div>
		</div>
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Rupiah</label><input type="number" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah" 
                 	      value="<?php 
		  if (num($st_amount) == 1){  echo e($rupiah) ;  } else {echo e($kredit_rupiah);} ?>" >
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
<?php  
if (num($st_amount) == 2)
{
?>
<div class="box-body">
  <div class="col-md-3">
    <div class="form-group">
      <label>Bank Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="bankname" 
                 	      value="<?php echo e($bankname) ?>" >
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="namapenerima" 
                 	      value="<?php echo e($namapenerima) ?>" >
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Bank Account</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="norek" 
                 	      value="<?php  echo e($norek) ?>" >
    </div>
  </div>
</div>
<?php } ?>
 <div class="box-body">
   <div class="col-md-4">
     <div class="form-group">
       <label>No Referensi</label>
       <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="noref" 
                 	      value="<?php echo e($noref) ?>">
     </div>
   </div>
   <div class="col-md-4">
     <div class="form-group">
       <label>Effective Date</label>
       <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="tgl_effective" 
                 	      value="<?php echo e($tgl_effective) ?>">
     </div>
 </div>
   </div>
 <div class="box-body">
  <input type="submit" name="Submit" value="PAID" />
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
	$id = in_val('id', 'any');
$statement = in_val('statement', 'any');
$st_amount = in_val('st_amount', 'any');		
$deskripsi = in_val('deskripsi', 'any');
$rupiah = in_val('rupiah', 'any');
$payment_metodh = in_val('payment_metodh', 'any');
$tgl_effective = in_val('tgl_effective', 'any');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$thn=date("y");		
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kd_branch = $_SESSION['kd_branch'];	
$stu_cbg = in_val('stu_cbg', 'any');
$p = in_val('p', 'any');		
$noref = in_val('noref', 'any');
$bankname = in_val('bankname', 'any');
$namapenerima = in_val('namapenerima', 'any');
$norek = in_val('norek', 'any');
$idreceiptlama = in_val('idreceipt', 'any');
if(num($st_amount) == 2)
{
if ($bankname ==''){$st_simpan = 0;$gagal = "Bank Penerima harus terisi";}		
if ($namapenerima ==''){$st_simpan = 0;$gagal = "Nama Penerima harus terisi";}
if ($norek ==''){$st_simpan = 0;$gagal = "No Rekening harus terisi";}
if ($payment_metodh ==''){$st_simpan = 0;$gagal = "Payment Metodh harus terisi";}	
}
//=== receipt id
if ( num($st_amount) == 1)
{

$query_receipt = q_set($__p_query_receipt, "SELECT a.id_soa FROM ves_data.adm_soa a where id_receipt <>'' and kd_branch = ? and st_amount = 1", [(string) ($kd_branch)]);
$resource_receipt  = db_query_soft($query_receipt, $__p_query_receipt ?? []);
$keluar_receipt  = db_num_rows($resource_receipt);
if(num(db_num_rows($resource_receipt)) > 0)
		{
		$jml = num($keluar_receipt) + 1;
		$jml =str_pad($jml, 4, '0', STR_PAD_LEFT);
		$idreceipt = "010$kd_branch$tahun$jml";	
		}
	else
		{		
		$jml = 1;
		$jml =str_pad($jml, 4, '0', STR_PAD_LEFT);
		$idreceipt = "010$kd_branch$tahun$jml";	
		}
}
else
{
$query_receipt = q_set($__p_query_receipt, "SELECT a.id_soa FROM ves_data.adm_soa a where id_receipt <>'' and kd_branch = ? and st_amount = 2", [(string) ($kd_branch)]);
$resource_receipt  = db_query_soft($query_receipt, $__p_query_receipt ?? []);
$keluar_receipt  = db_num_rows($resource_receipt);
if(num(db_num_rows($resource_receipt)) > 0)
		{
		$jml = num($keluar_receipt) + 1;
		$jml =str_pad($jml, 4, '0', STR_PAD_LEFT);
		$idreceipt = "020$kd_branch$tahun$jml";	
		}
	else
		{		
		$jml = 1;
		$jml =str_pad($jml, 4, '0', STR_PAD_LEFT);
		$idreceipt = "020$kd_branch$tahun$jml";	
		}
}
//====
if(num($st_simpan)==1)
	{
	if (num($st_amount) ==1)
	{
		if (num($p)==0)
		{
		if ($idreceiptlama =='')
		{
	$query_simpan = q_set($__p_query_simpan, "update ves_data.adm_soa set  keterangan = ? ,deskripsi = ? , rp_debet = ? ,dt_paid = ? , receive_by = ? , id_receipt = ? , pay_mtd = ? ,no_ref = ? where id= ? ", [(string) ($statement), (string) ($deskripsi), (string) ($rupiah), (string) ($tgl_effective), (string) ($nama_lengkap), (string) ($idreceipt), (string) ($payment_metodh), (string) ($noref), (string) ($id)]);
		}
	else
		{
	$query_simpan = q_set($__p_query_simpan, "update ves_data.adm_soa set  keterangan = ? ,deskripsi = ? , rp_debet = ? ,dt_paid = ? , receive_by = ? , pay_mtd = ? ,no_ref = ? where id= ? ", [(string) ($statement), (string) ($deskripsi), (string) ($rupiah), (string) ($tgl_effective), (string) ($nama_lengkap), (string) ($payment_metodh), (string) ($noref), (string) ($id)]);			
		}
		}
		else
		{
	$query_simpan = q_set($__p_query_simpan, "update ves_data.adm_soa set  no_ref = ? where id= ? ", [(string) ($noref), (string) ($id)]);
		}
	}
	else
	{
		if (num($p)==0)
		{
		if ($idreceiptlama =='')
		{
	$query_simpan = q_set($__p_query_simpan, "update ves_data.adm_soa set  keterangan = ? ,deskripsi = ? , rp_kredit = ? ,dt_paid = ? , receive_by = ? ,  pay_mtd = ? ,no_ref = ? ,id_receipt = ? ,bank_name = ? , bank_penerima = ? , bank_rekening = ? where id= ? ", [(string) ($statement), (string) ($deskripsi), (string) ($rupiah), (string) ($tgl_effective), (string) ($nama_lengkap), (string) ($payment_metodh), (string) ($noref), (string) ($idreceipt), (string) ($bankname), (string) ($namapenerima), (string) ($norek), (string) ($id)]);
			
		}
		else
		{
	$query_simpan = q_set($__p_query_simpan, "update ves_data.adm_soa set  keterangan = ? ,deskripsi = ? , rp_kredit = ? ,dt_paid = ? , receive_by = ? ,  pay_mtd = ? ,no_ref = ? ,bank_name = ? , bank_penerima = ? , bank_rekening = ? where id= ? ", [(string) ($statement), (string) ($deskripsi), (string) ($rupiah), (string) ($tgl_effective), (string) ($nama_lengkap), (string) ($payment_metodh), (string) ($noref), (string) ($bankname), (string) ($namapenerima), (string) ($norek), (string) ($id)]);			
		}
		}
		else
		{
	$query_simpan = q_set($__p_query_simpan, "update ves_data.adm_soa set  no_ref = ? where id= ? ", [(string) ($noref), (string) ($id)]);
		}		
	}
		/* echo $query_simpan (debug SQL versi lama) dihapus */
	$resource_simpan = db_query_or_die('errro_last_billing3', $query_simpan, $__p_query_simpan ?? []);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Statement updated ');\n";
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