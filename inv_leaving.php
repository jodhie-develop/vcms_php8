<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
ini_set("memory_limit","256M");
$nama_lengkap = $_SESSION['nama_lengkap']; 
//include __DIR__ . "/atas.php";
$no_leaving = in_val('nl', 'any');
$st_new_invoice = 0;

//$inst_country = in_val('inst_country', 'any');
$inv_new = in_val('inv_new', 'any');
$inv_exist = in_val('inv_exist', 'any');
if ($inv_exist =="--New Invoice--"){$st_new_invoice = 1;}
$inv_date = in_val('inv_date', 'any');
$student_name = in_val('student_name', 'any');

$inst_name = in_val('inst_name', 'any');
$inst_country = in_val('inst_country', 'any');
$inst_group = in_val('inst_group', 'any');
$kd_school = in_val('kd_school', 'any');
$inv_cur = in_val('inv_cur', 'any');
$inv_amount = in_val('inv_amount', 'any');
$inv_rate_rupiah = in_val('inv_rate_rupiah', 'any');
$inv_amount_rp = num($inv_amount) * num($inv_rate_rupiah);
$inv_bank = in_val('inv_bank', 'any');
$jatuh_tempo = in_val('jatuh_tempo', 'any');
$bank_rek = in_val('bank_rek', 'any');

$remark = in_val('remark', 'any');
$inv_remark = in_val('inv_remark', 'any');
$inst_program = in_val('inst_program', 'any');
$comm_date = in_val('comm_date', 'any');

$query_detail = q_set($__p_query_detail, "SELECT kd_biodata, nama, dest_country, dest_school, dest_program, date_format(comm_date,'%d %b %y'),kd_school FROM ves_data.adm_stu_progress where no = ? ", [(string) ($no_leaving)]);
$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar_detail = db_num_rows($resource_detail);	
if(num(db_num_rows($resource_detail)) > 0)
	{
	while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
		{
		$kd_biodata = $row_detail[0];
		$student_name = $row_detail[1];
		$inst_country = $row_detail[2];
		$inst_name = $row_detail[3];
		$inst_program = $row_detail[4];
		$comm_date = $row_detail[5];
		$kd_school = $row_detail[6];			
		}
	}

//===last invoice ===
$query_last_inv= q_set($__p_query_last_inv, "SELECT distinct kd_invoice FROM fin_invoice order by no desc limit 1");
$resource_last_inv = db_query_soft($query_last_inv, $__p_query_last_inv ?? []);
$keluar_last_inv = db_num_rows($resource_last_inv);	
if(num(db_num_rows($resource_last_inv)) > 0)
	{
	while ($row_last_inv  =  db_fetch($resource_last_inv, PDO::FETCH_NUM))
		{
		$inv_akhir = $row_last_inv[0];
		}
	}
//===================
if ($inv_exist !="") {$new_invoice = 0 ;}

function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
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
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invoice Admission - Student
        <label for="textfield">Text Field:</label>
      </h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php    //  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
    <div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Institution Country</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="inst_country" 
                 	      value="<?php echo e($inst_country) ?>">
    </div>
  </div> 
  <div class="col-md-4">
    <div class="form-group">
      <label>Institution Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="inst_name" 
                 	      value="<?php echo e($inst_name) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Program</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="inst_program" 
                 	      value="<?php echo e($inst_program) ?>">
    </div>
  </div>
  <input type="text" name="nl" id="textfield" value="<?php echo e($no_leaving) ?>" hidden="">
  <div class="col-md-4">

  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Commencement Date</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="comm_date" 
                 	      value="<?php echo e($comm_date) ?>">
    </div>
  </div>
  <input type="text" name="kd_biodata" id="textfield2" value="<?php echo e($kd_biodata) ?>" hidden="">
  <input type="text" name="kd_school" id="textfield3" value="<?php echo e($kd_school) ?>" hidden="">
</div>
<div class="box box-warning">
<div class="box-header with-border"><strong>Invoice Number (Last Invoice : <?php echo e($inv_akhir) ?> )</strong>
  <div class="col-md-4">
    <div class="form-group">
      <label>Existing  Invoice</label>
      <select class="form-control" name="inv_exist"  onChange="this.form.submit()">
        <option>--New Invoice--</option>
        <?php
								$query_inst = q_set($__p_query_inst, "SELECT distinct kd_invoice FROM fin_invoice order by no desc limit 10");
								$resource_inst = db_query_or_die('errro_7', $query_inst, $__p_query_inst ?? []);
								while ($row_inst=  db_fetch($resource_inst, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_inst[0]).'">'.e($row_inst[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($inv_exist) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>New Invoice</label>
      <input type="text" lang="en-150" class="form-control"  placeholder="Enter ..." name="inv_new" 
                 	      value="<?php echo e($inv_new) ?>" <?php if (num($st_new_invoice)==0) {echo "readonly";} else {echo "autofocus='autofocus'";} ?>></input>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Date Invoice</label>
      <input type="date" class="form-control"  placeholder="Enter ..." name="inv_date" 
                 	      value="<?php echo e($inv_date) ?>">
    </div>
  </div>
</div>


                               <?php
if ($inv_exist !="")
{$query_exist_inv = q_set($__p_query_exist_inv, "SELECT center, nama, org_curr, org_mount, rate, mount_rp, remark FROM fin_invoice where kd_invoice = ? ", [(string) ($inv_exist)]);
$resource_exist_inv = db_query_soft($query_exist_inv, $__p_query_exist_inv ?? []);
$keluar_exist_inv = db_num_rows($resource_exist_inv);	

			  
				  ?>
<?php
if(num(db_num_rows($resource_exist_inv)) > 0)
	{
		?>      <div class="box box-warning">
<div class="box-body">         
                <table width="100%" class="table table-bordered table-striped" id="example1">

                <thead>
                <tr>
      <td width=3% rowspan="2" align=center >No</td>
      <td width="4%" rowspan="2" align=center >Center</td>
      <td width="44%" rowspan="2" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=student">Student Name</a></td>
      <td height="14" colspan="4" align=center >Invoice</td>
      </tr>
    <tr>
      <td width="17%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Amount</a> <br></td>
      <td width="10%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Rate</a> <br></td>
      <td width="17%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">IDR Amount</a> <br></td>
      <td width="5%" height=14 align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=program">Remark</a></td>
      </tr>
                </thead> <?php } ?>
                <tbody>
<?php
					if(num(db_num_rows($resource_exist_inv)) > 0)
	{$nomor = 1;
	while ($row_exist_inv  =  db_fetch($resource_exist_inv, PDO::FETCH_NUM))
		{

		
?>	
    <tr>
      <td align=center class="style24"><?php echo e($nomor) ?></td>
      <td align=center class="style24"><?php echo e($row_exist_inv[0]) ?></td>
		<td align=center class="style24"><?php echo e($row_exist_inv[1]) ?></td>
      <td align=left class="style24"><?php echo e($row_exist_inv[2]) ?> <?php echo e(buatrp($row_exist_inv[3])) ?></td>
      <td height=14 align=left class="style24"><?php echo e(buatrp($row_exist_inv[4])) ?></td>
      <td align=left class="style24"><?php echo e(buatrp($row_exist_inv[5])) ?><br></td>
      <td height=14 align=left class="style24"><?php echo e($row_exist_inv[6]) ?></td>
      </tr>
<?php 
$nomor = num($nomor)+1;}} 

 ?>
                <tfoot>
                </tfoot>
                
              </table><?php } ?></div>
<div class="box box-warning">
<div class="box-header with-border"><strong>Invoice</strong></div>
                 	<div class="box-body"></div>
<div class="box-body">
  <div class="col-md-2">
                 	    <div class="form-group">
                 	      <label>Original Currency</label>
                 	      <select class="form-control" name="inv_cur">
                  			  <?php
								$query_curr = q_set($__p_query_curr, "SELECT kd_curr FROM ves_data.fin_currency");
								$resource_curr = db_query_or_die('errro_7', $query_curr, $__p_query_curr ?? []);
								while ($row_curr=  db_fetch($resource_curr, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_curr[0]).'">'.e($row_curr[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($inv_cur) ?></option>
       			  </select>
               	      </div>
  </div>
  <div class="col-md-3">
                 	    <div class="form-group">
                 	    <label>Original Amount</label>
                 	      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="inv_amount" 
                 	      value="<?php echo e($inv_amount)  ?>"></div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Rupiah Rate</label>
      <input type="text" class="form-control"  placeholder="Enter ..." name="inv_rate_rupiah" 
                 	      value="<?php echo e($inv_rate_rupiah) ?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Hitung Amount Rupiah</label>
      <input type="submit" name="hitung" value="hitung" />
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Original Amount (Rupiah)</label>
      <input type="text" class="form-control"  placeholder="Enter ..." name="pay_amount_rupiah" 
                 	      value="<?php echo e($inv_amount_rp) ?>">
    </div>
  </div>
</div>
<div class="box-body">
  <div class="col-md-2">
    <div class="form-group">
      <label>Bank Invoice</label>
                 	      <select class="form-control" name="inv_bank">
                 	        <?php
								$query_bank = q_set($__p_query_bank, "SELECT nm_bank FROM ves_data.fin_bank_list");
								$resource_bank = db_query_or_die('errro_7', $query_bank, $__p_query_bank ?? []);
								while ($row_bank=  db_fetch($resource_bank, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_bank[0]).'">'.e($row_bank[0]).'</option>';
							  		}      ?>
                 	        <option selected><?php echo  e($inv_bank)  ?></option>
               	        </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Bank Account</label>
      <select class="form-control" name="bank_rek">
        <?php
								$query_bank = q_set($__p_query_bank, "SELECT kd_bank FROM ves_data.fin_bank_list");
								$resource_bank = db_query_or_die('errro_7', $query_bank, $__p_query_bank ?? []);
								while ($row_bank=  db_fetch($resource_bank, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_bank[0]).'">'.e($row_bank[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($bank_rek)  ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Remark</label>
      <select class="form-control" name="remark">
        <option>COHORST</option>
        <option>COHORST (AHN)</option>
        <option>COHORST (OSHC)</option>
        <option>HOMESTAY</option>
                       <option>OTHER</option>
                <option selected><?php echo  e($remark)  ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
                 	    <div class="form-group">
                 	    <label>Remark Invoice</label>
                 	      <input type="text" class="form-control"  placeholder="Enter ..." name="inv_remark" 
                 	      value="<?php echo e($inv_remark)  ?>"></div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Jatuh Tempo</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="jatuh_tempo" 
                 	      value="<?php echo e($jatuh_tempo)  ?>">
    </div>
  </div>
</div>               	    
<div class="box-body"></div>

            <input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
	$nama_lengkap = 	$_SESSION['nama_lengkap']; 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$no_leaving= in_val('nl', 'any');
$inv_new = in_val('inv_new', 'any');
$inv_exist = in_val('inv_exist', 'any');
$inv_date = in_val('inv_date', 'any');
$student_name = in_val('student_name', 'any');
$inst_name = in_val('inst_name', 'any');
$inst_country = in_val('inst_country', 'any');
$inst_group = in_val('inst_group', 'any');
$inv_cur = in_val('inv_cur', 'any');
$inv_amount = in_val('inv_amount', 'any');
$inv_rate_rupiah = in_val('inv_rate_rupiah', 'any');
$inv_amount_rp = 	num($inv_amount) * num($inv_rate_rupiah);
$inv_bank = in_val('inv_bank', 'any');
$bank_rek = in_val('bank_rek', 'any');
$remark = in_val('remark', 'any');
$inv_remark = in_val('inv_remark', 'any');
$inst_program = in_val('inst_program', 'any');
$comm_date = in_val('comm_date', 'any');
$kd_biodata = in_val('kd_biodata', 'any');
$jatuh_tempo = in_val('jatuh_tempo', 'any');



if ($inv_exist=="--New Invoice--")
	{
	$no_invoice = $inv_new;
	}
else
	{
	$no_invoice = $inv_exist;		
	}
	
$query_detail = q_set($__p_query_detail, "SELECT pdo_date, enroll_date, date_format(comm_date,'%b'), date_format(comm_date,'%Y'),comm_date, branch,kd_school FROM ves_data.adm_stu_progress where no = ? ", [(string) ($no_leaving)]);
$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar_detail = db_num_rows($resource_detail);	
if(num(db_num_rows($resource_detail)) > 0)
	{
	while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
		{
		$pdo_date = $row_detail[0];
		$enroll_date = $row_detail[1];
		$bln_intake = $row_detail[2];
		$thn_intake = $row_detail[3];
		$comm_date = $row_detail[4];
		$branch = $row_detail[5];
		$kd_school = $row_detail[6];			
		}
	}	
	
$query_simpan = q_set($__p_query_simpan, "insert into ves_data.fin_invoice \r
(kd_biodata, no_leaving,  nama, country, school, program,comm_date, \r
dt_invoice,org_curr, org_mount, rate, mount_rp,invoice_bank,pic, dt_entry,\r
kd_invoice, remark,status_invoice, \r
pdo_date,   enroll_date,bln_intake, thn_intake,center,kd_school,invoice_remark,bank_rek,jatuh_tempo   ) values \r
(? ,? ,? ,? ,? ,? ,? ,\r
? ,? ,? ,? ,? ,? ,? ,? ,\r
? ,? ,'invoicing',\r
? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($kd_biodata), (string) ($no_leaving), (string) ($student_name), (string) ($inst_country), (string) ($inst_name), (string) ($inst_program), (string) ($comm_date), (string) ($inv_date), (string) ($inv_cur), (string) ($inv_amount), (string) ($inv_rate_rupiah), (string) ($inv_amount_rp), (string) ($inv_bank), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($no_invoice), (string) ($remark), (string) ($pdo_date), (string) ($enroll_date), (string) ($bln_intake), (string) ($thn_intake), (string) ($branch), (string) ($kd_school), (string) ($inv_remark), (string) ($bank_rek), (string) ($jatuh_tempo)]);
$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
echo "<script type=\"text/javascript\">\n";
echo "alert('Invoice has been set by " . e($nama_lengkap) . "');\n";
echo "window.opener.location.reload(true);\n";
echo "window.close(); \n";					
echo "</script>";
}
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hitung']))) 								
{$no_leaving= in_val('nl', 'any');
$inv_new = in_val('inv_new', 'any');
$inv_exist = in_val('inv_exist', 'any');
$inv_date = in_val('inv_date', 'any');
$student_name = in_val('student_name', 'any');
$inst_name = in_val('inst_name', 'any');
$inst_country = in_val('inst_country', 'any');
$inst_group = in_val('inst_group', 'any');
$inv_cur = in_val('inv_cur', 'any');
$inv_amount = in_val('inv_amount', 'any');
$inv_rate_rupiah = in_val('inv_rate_rupiah', 'any');
$inv_amount_rp = 	num($inv_amount) * num($inv_rate_rupiah);
$inv_bank = in_val('inv_bank', 'any');
$remark = in_val('remark', 'any');
$inv_remark = in_val('inv_remark', 'any');
$inst_program = in_val('inst_program', 'any');
$comm_date = in_val('comm_date', 'any');
$kd_biodata = in_val('kd_biodata', 'any');
$bank_rek = in_val('bank_rek', 'any');
$jatuh_tempo = in_val('jatuh_tempo', 'any');
}
?>
