<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/left.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');

$ed = in_val('ed', 'get');
$edid = in_val('edid', 'get');

$no = in_val('no', 'get');
$nos = in_val('nos', 'get');
$st = in_val('st', 'get');
$new = in_val('new', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$idsoa = $kdb.$nos;
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$branch = $_SESSION['branch']; 
$asal = in_val('asal', 'get');
$query_adm = q_set($__p_query_adm, "SELECT kd_biodata, enroll_date, final_status,step,nama,ori_school,sc_name, adm_pic,dest_country,dest_school,group_school,p_np, program_clasifie,mp_ap,dest_program,major,h_nh, ar,agent_referal,tf_full_program,pasport,tf_fee_paid, tf_term_paid,tf_balance_fee,tgl_intake,program_duration,comm_date,\r
\tcomm_date_end,pdo_date,remark_problem,remark_solution,next_update, pic,kd_branch, dt_entry,kd_school,tf_balance_fee_due_date,date_format(tgl_intake, '%m'),date_format(tgl_intake, '%Y')  \r
\tFROM  adm_stu_progress a where kd_biodata = ? and enroll_date = ? and aktif = 1", [(string) ($kdb), (string) ($ed)]);
	
		
	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$kdb = $row_adm['0'];$enroll_date = $row_adm['1']; $adm_status = $row_adm['2'];$adm_step = $row_adm['3'];
			$student_name = $row_adm['4'];$ori_school = $row_adm['5'];$sc_pic = $row_adm['6']; $adm_pic = $row_adm['7'];
			$country_dest = $row_adm['8'];$school_dest = $row_adm['9'];$school_group = $row_adm['10'];$partner_status = $row_adm['11'];
			$program_clasifie = $row_adm['12'];$program_status = $row_adm['13'];$program_dest = $row_adm['14'];
			$major = $row_adm['15'];$major_group = $row_adm['16']; $refer_status = $row_adm['17'];
			$agent_referal = $row_adm['18'];$tf_full_program = $row_adm['19'];$pasport = $row_adm['20'];
			$tf_fee_paid = $row_adm['21']; $tf_term_paid = $row_adm['22'];$tf_balance_fee = $row_adm['23'];
			$tgl_intake = $row_adm['24'];$program_duration = $row_adm['25'];$comm_date = $row_adm['26'];
			$comm_date_end = $row_adm['27'];$pdo_date = $row_adm['28']; $remark_problem = $row_adm['29'];
			$remark_solution = $row_adm['30'];$next_fu_date = $row_adm['31'];$nama_lengkap = $row_adm['32']; $kdcbg = $row_adm['33']; $tgl_hari_ini = $row_adm['34'];$kode_sekolah = $row_adm['35'];$tf_balance_fee_due_date= $row_adm['36'];$intake_date_m = $row_adm['37'];$intake_date_y = $row_adm['38'];$st =0;$edid = $row_adm[1];
			}
		}
//=== cek proffesional fee


//===
$wajib = "form-group has-error";
$tdkwajib = "form-group";
$wajiblabel = "label-danger";
	

//
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3>Student SOA Form</h3>
	<h5>ID SOA : <?php echo e($idsoa) ?></h5>
</div>	
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

<form name="myform" id="myform" method="GET">
	
  <div class="col-md-12">
<div class="box box-warning">
<div class="box-body"><span class="form-group">
  <input type="hidden" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" >
</span> 
  <div class="col-md-6">

    <div class="">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>" readonly>
    </div>
  </div>
  <span class="form-group">
  <input type="text" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="text" ang="en-150"   name="ed" 
                 	      value="<?php echo e($ed) ?>" >
  </span>
  <div class="col-md-3">
    <div class="wa">
      <label>PASPORT ID</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="pasport" 
                 	      value="<?php echo e($pasport) ?>"readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="wa">
      <label>Center</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="pasport2" 
                 	      value="<?php echo e($kdcbg) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="text" ang="en-150"   name="st" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
  </span><span class="form-group">
  <input type="hidden" ang="en-150"   name="kdb" 
                 	      value="<?php echo e($kdb) ?>" >
  </span></div>
    </div>
<div class="box box-warning">		
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>PROGRAM INFO</label>
    </div>
  </div>
  <div class="col-md-4">
    <div class="">
      <label>Destination School </label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name2" 
                 	      value="<?php echo e($school_dest) ?>"readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="">
      <label>Destination Country </label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name3" 
                 	      value="<?php echo e($country_dest) ?>"readonly>
    </div>
  </div>
  <div class="col-md-4">
    <div class="">
      <label>Course Name</label>
      <input type="dest_program"  class="form-control" name="program_dest" size="90"  value = "<?php echo e($program_dest)  ?>" readonly/>
    </div>
</div>
  <div class="col-md-3">
    <div class="">
      <label>Major</label>
      <input type="text" name="major"  class="form-control" value = "<?php echo e($major)  ?>" readonly/>
    </div>
  </div>
  <div class="col-md-3">
    <div class="">
      <label>Student Consultant</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name5" 
                 	      value="<?php echo e($sc_pic) ?>"readonly>
    </div>
</div>
  <div class="col-md-3">
  <div class="form-group">
    <label>Admission Consultant</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name6" 
                 	      value="<?php echo e($adm_pic) ?>"readonly>
  </div>
  </div>
  <input type="text" name="tf" id="textfield" value="<?php echo e($tf) ?>" hidden="hidden" >
	  <input type="text" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>" hidden="">
      <input type="text" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="">
</div>
    </div>
<div class="box box-warning">
  <div class="box-body">
    <div class="col-md-12">
      <table width="100%" class="table table-bordered table-striped" id="example2">
        <tbody>
          <tr>
            <td width="2%" align=center class="style24">ID</td>
            <td width="9%" align=center class="style24">Date</td>
            <td width="22%" align=center class="style24">Description</td>
            <td width="6%" align=center class="style24">Reference No</td>
            <td width="15%" align=center class="style24">Amount Received</td>
            <td width="14%" align=center class="style24">Amount Expenses</td>
            <td width="14%" align=left class="style24">Balance</td>
            <td width="10%" align=left class="style24">Approved/Ack By</td>
            <td width="8%" height="14" align=left class="style24">Action</td>
          </tr>
          <?php 
	
			$query_soa = q_set($__p_query_soa, "SELECT a.dt_entry, a.keterangan, no_ref,   a.rp_debet FROM ves_data.adm_soa a\r
where a.id_soa = ? and keterangan = 'Service Fee Paid'", [(string) ($idsoa)]);

			$resource_soa = db_query_or_die('errro_rr', $query_soa, $__p_query_soa ?? []);
			if(num(db_num_rows($resource_soa)) > 0)
				{
				while ($row_soa=  db_fetch($resource_soa, PDO::FETCH_NUM))
					{$nomor = num($nomor) + 1;
						$st_app = 0;
						$st_ack = 0;
					$tgl_entry= $row_soa[0];
					$keterangan= $row_soa[1];
					$id_receipt= $row_soa[2];
					$rp_debet= $row_soa[3];
					$rp_kredit= $row_soa[4];						
					$saldo= $row_soa[5];
					$app_by= $row_soa[6];
					$dt_app= $row_soa[7];
					$ack_by= $row_soa[8];
					$dt_ack= $row_soa[9];						
					$no_ref= $row_soa[2];
					$deskripsi= $row_soa[11];						

						
						?>
          <tr>
            <td align=center class="style24"><?php echo e($nomor) ?></td>
            <td align=center class="style24"><?php echo e($tgl_entry) ?></td>
            <td align=left class="style24"><?php echo e($keterangan) ?><br>
              <?php echo e($deskripsi) ?></td>
            <td align=center class="style24"><?php echo e($no_ref) ?></td>
            <td align=center class="style24"><?php echo number_format(num((float)$rp_debet),0,".",".")?></td>
            <td align=center class="style24"><?php echo number_format(num((float)$rp_kredit),0,".",".")?></td>
            <td align=center class="style24"><?php echo number_format(num($saldo),0,".",".")?></td>
            <td align=center class="style24"><?php echo e($app_by) ?><br>              
              <?php echo e($ack_by) ?></td>
            <td height="14" align=center class="style24">&nbsp;</td><?php  } } ?>
          </tr>			
          <?php 
	$nomor = num($nomor)+1;
			$query_soa = q_set($__p_query_soa, "SELECT\r
a.dt_entry, a.keterangan, a.id_receipt, a.rp_debet,a.rp_kredit,@saldo:=@saldo+a.rp_debet-a.rp_kredit AS saldo , app_by, dt_app, ack_by,dt_ack,  no_ref,a.deskripsi  FROM ves_data.adm_soa a\r
JOIN (SELECT @saldo:=0) a where a.id_soa = ? and keterangan <> 'Service Fee Paid'   union select null,  null,  null,  null, 'SALDO AKHIR',@saldo, null,null,  null,  null,null,null ", [(string) ($idsoa)]);

			$resource_soa = db_query_or_die('errro_rr', $query_soa, $__p_query_soa ?? []);
			if(num(db_num_rows($resource_soa)) > 0)
				{
				while ($row_soa=  db_fetch($resource_soa, PDO::FETCH_NUM))
					{
						$st_app = 0;
						$st_ack = 0;
					$tgl_entry= $row_soa[0];
					$keterangan= $row_soa[1];
					$id_receipt= $row_soa[2];
					$rp_debet= $row_soa[3];
					$rp_kredit= $row_soa[4];						
					$saldo= $row_soa[5];
					$app_by= $row_soa[6];
					$dt_app= $row_soa[7];
					$ack_by= $row_soa[8];
					$dt_ack= $row_soa[9];						
					$no_ref= $row_soa[10];
					$deskripsi= $row_soa[11];						

						
						?>
          <tr>
            <td align=center class="style24"><?php echo e($nomor) ?></td>
            <td align=center class="style24"><?php echo e($tgl_entry) ?></td>
            <td align=left class="style24"><?php echo e($keterangan) ?><br>
              <?php echo e($deskripsi) ?></td>
            <td align=center class="style24"><?php echo e($no_ref) ?></td>
            <td align=center class="style24"><?php echo number_format(num((float)$rp_debet),0,".",".")?></td>
            <td align=center class="style24"><?php echo number_format(num((float)$rp_kredit),0,".",".")?></td>
            <td align=center class="style24"><?php echo number_format(num($saldo),0,".",".")?></td>
            <td align=center class="style24"><?php echo e($app_by) ?><br>              
              <?php echo e($ack_by) ?></td>
            <td height="14" align=center class="style24">&nbsp;</td><?php $nomor = num($nomor) + 1; } } ?>
          </tr>
          <tr>
            <td height="14" colspan="3" align=left class="style24"><a href="po_entry.php?kdbsoa=<?php echo e(u($kdb)) ?>&idsoa=<?php echo e(u($idsoa))  ?>" 
																	  target="_blank">Purchase Order</a></td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24"><a href="soa_dtl.php'" 
target="blank" 
onclick="window.open('printable/prt_soa.php?idsoa=<?php echo e(u($idsoa)) ?>&ed=<?php echo e(u($ed)) ?>','popup','width=1000,height=800'); return false;">Print Version</a></td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">&nbsp;</td>
          </tr>
          <tr>
            <td height="14" colspan="3" align=left class="style24"><a href="#'" 
target="blank" 
onclick="window.open('import_po.php?idcbg=<?php echo e(u($kdcbg)) ?>&idsoa=<?php echo e(u($idsoa)) ?>&kdb=<?php echo e(u($kdb)) ?>','popup','width=1000,height=800'); return false;">Import Purchase Order</a></td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24"><a href="#" target="popup" onclick="window.open('soa_adminfee.php?idsoa=<?php echo e(u($idsoa)) ?>&kdb=<?php echo  e(u($kdb))?>','popup','width=1000,height=800'); return false;">Admin Fee</a></td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">&nbsp;</td>
          </tr>
          <tr>
            <td height="14" colspan="3" align=left class="style24"><a href="invoicebill.php?kdb=<?php echo e(u($kdb)) ?>&soa=<?php echo e(u($idsoa))  ?>&payment_for=VOS Cash Deposit" 
																	  target="_blank">Cash Deposit</a></td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">
<a href="#" target="popup" onclick="window.open('soa_cashback.php?idsoa=<?php echo e(u($idsoa)) ?>&kdb=<?php echo  e(u($kdb))?>','popup','width=1000,height=800'); return false;">Balancing Cash Back</a></td>
            <td height="14" align=left class="style24">&nbsp;</td>
            <td height="14" align=left class="style24">&nbsp;</td>
          </tr>
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
</body>
</html>