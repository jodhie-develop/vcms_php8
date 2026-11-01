<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$pic_admin = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'any');


$ed = in_val('ed', 'any');

$no = in_val('no', 'any');
$no_sr = in_val('no_sr', 'any');

$st = in_val('st', 'any');
$new = in_val('new', 'any');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$branch = $_SESSION['branch']; 
$asal = in_val('asal', 'any');
$query_enroll = q_set($__p_query_enroll, "SELECT discount_name,  non_refund FROM ves_inc.tb_enrolled where kd_biodata  =  ? and enroll_date = ? ", [(string) ($kdb), (string) ($ed)]);
$resource_enroll  = db_query_soft($query_enroll, $__p_query_enroll ?? []);
if(num(db_num_rows($resource_enroll)) > 0)
	{
	while ($row_enroll   =  db_fetch($resource_enroll, PDO::FETCH_NUM))
		{
		$refund = $row_enroll[1];
		$discount_name =   $row_enroll[0];
		}
	}
if ($refund =='No Discount'){$refund = 'Non Refundable';}
$query_adm = q_set($__p_query_adm, "SELECT kd_biodata, enroll_date, final_status,step,nama,ori_school,sc_name, adm_pic,dest_country,dest_school,group_school,p_np, program_clasifie,mp_ap,dest_program,major,h_nh, ar,agent_referal,tf_full_program,pasport,tf_fee_paid, tf_term_paid,tf_balance_fee,tgl_intake,program_duration,comm_date,\r
\tcomm_date_end,pdo_date,remark_problem,remark_solution,next_update, pic,kd_branch, dt_entry,kd_school,tf_balance_fee_due_date,date_format(tgl_intake, '%m'),date_format(tgl_intake, '%Y'),date_format(enroll_date, '%y%m%d')  \r
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
			$remark_solution = $row_adm['30'];$next_fu_date = $row_adm['31'];$nama_lengkap = $row_adm['32']; $kdcbg = $row_adm['33']; $tgl_hari_ini = $row_adm['34'];$kode_sekolah = $row_adm['35'];$tf_balance_fee_due_date= $row_adm['36'];$intake_date_m = $row_adm['37'];$intake_date_y = $row_adm['38'];$st =0;
			}
		}
//=== cek proffesional fee
if (num($kdcbg) ==1){$cabang = 'East Sby';}
elseif (num($kdcbg) ==2){$cabang = 'West Sby';}
elseif (num($kdcbg) ==3){$cabang = 'Bali';}
elseif (num($kdcbg) ==4){$cabang = 'South Jkt';}
elseif (num($kdcbg) ==5){$cabang = 'North Jkt';}
elseif (num($kdcbg) ==6){$cabang = 'West Jkt';}
elseif (num($kdcbg) ==7){$cabang = 'Bandung';}
elseif (num($kdcbg) ==8){$cabang = 'Malang';}
elseif (num($kdcbg) ==11){$cabang = 'PIK';}
elseif (num($kdcbg) ==14){$cabang = 'Medan';}
//===
$wajib = "form-group has-error";
$tdkwajib = "form-group";
$wajiblabel = "label-danger";
//=====NIK
	$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kdb)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
		while ($row_nik  =  db_fetch($resource_nik))
			{
			$nik = $row_nik[0];
			}
		}	

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
  
<?php //     include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3>Proffesional Fee Payment</h3><h5>ID SOA : <?php echo e($idsoa) ?></h5>
</div>	
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>

	
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
<input type="hidden" ang="en-150"   name="ed" 
                 	      value="<?php echo e($ed) ?>"  >
  </span>
  <div class="col-md-3">
    <div class="wa">
      <label>Center</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="cabang" 
                 	      value="<?php echo e($cabang) ?>" readonly>
    </div>
</div>
  <div class="col-md-3">
    <div class="wa">
      <label>NIK</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="nik" 
                 	      value="<?php echo e($nik) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="text" ang="en-150"   name="st" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
  </span><span class="form-group">
  <input type="hidden" ang="en-150"   name="kdb" 
                 	      value="<?php echo e($kdb) ?>" >
  </span><span class="form-group">
  <input type="hidden" ang="en-150"   name="no_sr" 
                 	      value="<?php echo e($no_sr) ?>" >
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="pic_admin" 
                 	      value="<?php echo e($pic_admin) ?>" hidden="hidden"  >
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
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="school_dest" 
                 	      value="<?php echo e($school_dest) ?>"readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="">
      <label>Destination Country </label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="country_dest" 
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
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="sc_pic" 
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
	  <input type="text" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>" hidden="hidden">
      <input type="text" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="hidden">
</div>
    </div>
<div class="box box-warning">
 <div class="box-body">
   <input type="hidden" name="no_enrolled" id="textfield4" value="<?php echo e($no_enrolled) ?>" >
 </div>
  <div class="box-body">
    <div class="col-md-12">
      <table width="100%" class="table table-bordered table-striped" id="example2">
        <tbody>
          <tr>
            <td width="7%" align=center class="style24">Currency</td>
            <td width="29%" height="14" align=center class="style24">Amount</td>
            <td width="13%" align=center class="style24">Payment Metodh</td>
            <td width="16%" align=center class="style24">Effective Date</td>
            <td width="16%" align=center class="style24">Status</td>
            <td width="14%" align=center class="style24">Discount</td>
            <td width="5%" align=center class="style24">&nbsp;</td>
            </tr>
          <?php 
	$nomor = 1;
			$query_pf = q_set($__p_query_pf, "select prof_fee, non_refund,kd_biodata,cur,no from ves_inc.tb_enrolled where kd_biodata = ? and enroll_date = ? ", [(string) ($kdb), (string) ($enroll_date)]);

			$resource_pf = db_query_or_die('errro_rr', $query_pf, $__p_query_pf ?? []);
			if(num(db_num_rows($resource_pf)) > 0)
				{
				while ($row_pf=  db_fetch($resource_pf, PDO::FETCH_NUM))
					{
						$prof_fee = $row_pf[0];
						$non_refund = $row_pf[1];
						$cur = $row_pf[3];
						$no_enrolled = $row_pf[4];
						
					}
				}
						?>
          <tr>
            <td align=center class="style24"><span class="style92">
              <select name="cur" id="org_cur"  class="form-control">
                <option>Rp</option>               
                <option>USD </option>
                <option>EUR</option>
                <option>GBP</option>

                <option>AUD</option>
                <option>CAD </option>
                <option>SGD</option>
                <option>CHF</option>
                <option>MYR</option>
                <option>JPY</option>
                <option>CNY</option>
                <option selected="selected">
                  <?php   echo e($cur);    ?>
                  </option>
            </select>
            </span></td>
            <td height="14" align=center class="style24"><span class="form-group">
              <input type="number" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah" 
                 	      value="<?php echo e($prof_fee) ?>" >
            </span></td>
            <td align=left class="style24"><span class="form-group">
              <select name="payment_metodh"  id="jns_report2" class="form-control" >
                <option value="Debit Card">Debit Card</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
                <option value="Cek-Bg">Cek-Bg</option>
                <option value="Voucher">Voucher</option>
                <option value="QRIS">QRIS</option>
				  
                <option selected="selected"><?php echo e($payment_metodh) ?></option>
              </select>
            </span></td>
            <td align=center class="style24"><span class="form-group">
              <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="tgl_effective" 
                 	      value="<?php echo e($tgl_effective) ?>">
            </span></td>
            <td align=center class="style24"><span class="form-group">
              <select name="refund"  id="non_refund" class="form-control" >
                <option value="Refundable">Refundable</option>
                <option value="Non Refundable">Non Refundable</option>
                <option selected="selected"><?php echo e($refund) ?></option>
              </select>
            </span></td>
            <td align=center class="style24"><span class="style92">
              <select name="discount_name" id="discount_name"  class="form-control">
                <option>No Discount</option>
                <option>Link & Match</option>
                <option>BCA Prioritas</option>
                <option>Returning Student</option>
                <option>Referral Student</option>	
                <option>Sibling</option>	
                <option>WWEF 2023</option>						  
                <option selected="selected">
                  <?php  echo e($discount_name);  ?>
                  </option>
              </select>
            </span></td>
            <td align=center class="style24">&nbsp;</td>

          </tr>
          <tr>
            <td height="14" colspan="6" align=left class="style24"><div class="col-md-8">
              <div class="">
                Remark
                <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="note" 
                 	      value="<?php echo e($remark) ?>">
              </div>
            </div></td>
            <td align=center class="style24"><input type="submit" name="Submit" value="PAID" /></td>
          </tr>
        <tfoot>
        </tfoot>
      </table>
      <br>
    </div>
  </div>
</div>
  </div>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{

		
	$hari=date("d");$bulan=date("m");$tahun=date("Y");$thn = date('y');
		$waku = date("H:i:s");
	$hari_ini = "$tahun-$bulan-$hari";		
	$kd_branch = $_SESSION['kd_branch'];
		
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$pic_admin = in_val('pic_admin', 'any');
$id_prof = in_val('id_prof', 'any');
$kdb = in_val('kdb', 'any');
$no_sr = in_val('no_sr', 'any');	
$id_soa	 = "$kdb$no_sr";
$student_name = in_val('student_name', 'any');
$rupiah = in_val('rupiah', 'any');
$note = in_val('note', 'any');
$$tgl_hari_ini = $_GET['$tgl_hari_ini'];
$cur = in_val('cur', 'any');
$rupiah = in_val('rupiah', 'any');
$terbilang = in_val('terbilang', 'any');
$waktu = in_val('waktu', 'any');
$pic = in_val('pic', 'any');
$country_dest = in_val('country_dest', 'any');
$school_dest = in_val('school_dest', 'any');
$major = in_val('major', 'any');
$payment_metodh = in_val('payment_metodh', 'any');
$cabang = in_val('cabang', 'any');
$sc_pic = in_val('sc_pic', 'any');
$refund = in_val('refund', 'any');
$tgl_effective = in_val('tgl_effective', 'any');
$refund = in_val('refund', 'any');	
$nik = in_val('nik', 'any');	
$query_get_id = q_set($__p_query_get_id, "SELECT id_prof_bill FROM ves_inc.tb_prof_bill where branch = ? and id_prof_bill <> '' order by no desc limit 1", [(string) ($cabang)]);
$resource_id  = db_query_soft($query_get_id, $__p_query_get_id ?? []);
if(num(db_num_rows($resource_id)) > 0)
	{
	while ($row_id   =  db_fetch($resource_id, PDO::FETCH_NUM))
		{
		$no_receipt = $row_id[0];
		}
	}
$last_receipt = substr($no_receipt,0,4);		
		
		
$receipt_baru = num($last_receipt) +1;
if(num($receipt_baru) <=9){$receipt_baru = "000$receipt_baru";}		
elseif(num($receipt_baru) >=10 and num($receipt_baru) <=99){$receipt_baru = "00$receipt_baru";}				
elseif(num($receipt_baru) >=100 and num($receipt_baru) <=999){$receipt_baru = "0$receipt_baru";}				
if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}
if ($branch =='Bali'){$branch_receipt='BLI';}
elseif ($branch =='Bandung'){$branch_receipt='BDG';}
elseif ($branch =='Central Jkt'){$branch_receipt='MOI';}
elseif ($branch =='East Sby'){$branch_receipt='ESB';}
elseif ($branch =='Malang TBI'){$branch_receipt='MLG';}
elseif ($branch =='Medan'){$branch_receipt='MDN';}
elseif ($branch =='Patal Jkt'){$branch_receipt='PIM';}
elseif ($branch =='PIK'){$branch_receipt='PIK';}
elseif ($branch =='Serpong'){$branch_receipt='SRP';}
elseif ($branch =='West Jkt'){$branch_receipt='SOH';}
elseif ($branch =='West Sby'){$branch_receipt='WES';}
elseif ($branch =='HO'){$branch_receipt='WES';}	
if ($branch_receipt =='')
	{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Service Fee Failed to create, please logout and re login');\n";
		echo "window.close(); \n";				
		echo "</script>";
	die;
	}	
$id_receipt = "$receipt_baru/VOS/PF/$branch_receipt/$bln_rom/$thn";	
	
$simpan_receipt= q_set($__p_simpan_receipt, "insert into ves_inc.tb_prof_bill (id_prof_bill, id_stu, nm_stu,  mount, note, dt_paid, curr, rp_mount, terbilang, waktu,pic, country_dest, school_dest, prg_dest, pay_mtd, branch, sc_name, st_refund, tgl_cetak,id_soa ) values (? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ,? )", [(string) ($id_receipt), (string) ($kdb), (string) ($student_name), (string) ($rupiah), (string) ($note), (string) ($tgl_hari_ini), (string) ($cur), (string) ($rupiah), (string) ($terbilang), (string) ($waktu), (string) ($pic_admin), (string) ($country_dest), (string) ($school_dest), (string) ($major), (string) ($payment_metodh), (string) ($cabang), (string) ($sc_pic), (string) ($refund), (string) ($tgl_effective), (string) ($id_soa)]);
$resource_simpan_receipt = db_query_or_die('errro_simpan_1', $simpan_receipt, $__p_simpan_receipt ?? []);

$query_get_no_bill = q_set($__p_query_get_no_bill, "SELECT no FROM ves_inc.tb_prof_bill where id_prof_bill =? ", [(string) ($id_receipt)]);
$resource_get_no_bill  = db_query_soft($query_get_no_bill, $__p_query_get_no_bill ?? []);
if(num(db_num_rows($resource_get_no_bill)) > 0)
	{
	while ($row_get_no_id   =  db_fetch($resource_get_no_bill, PDO::FETCH_NUM))
		{	
		$no_service_fee = $row_get_no_id[0];
		}
}
	
	
$query_insert_service_fee = q_set($__p_query_insert_service_fee, "insert into ves_data.adm_soa (kd_biodata, enroll_date, keterangan, cur_debet, rp_debet, id_soa, no_ref,jns_transaksi,dt_entry,id_nomor) values (? ,? ,'Service Fee Paid',? ,? ,? ,? ,1,? ,? )", [(string) ($kdb), (string) ($enroll_date), (string) ($cur), (string) ($rupiah), (string) ($id_soa), (string) ($id_receipt), (string) ($tgl_effective), (string) ($no_service_fee)]);
$resource_insert_service_fee= db_query_or_die('errro_visitor3', $query_insert_service_fee, $__p_query_insert_service_fee ?? []);
	
	
$query_upd_service_fee = q_set($__p_query_upd_service_fee, "update ves_data.tb_sales_report set id_soa = ? where no  =? ", [(string) ($id_soa), (string) ($no_sr)]);
$resource_upd_service_fee= db_query_or_die('errro_visitor4', $query_upd_service_fee, $__p_query_upd_service_fee ?? []);	
	
	
	
	
if(num($rupiah) > 900000){$nominal_dibagi = 900000;}else {$nominal_dibagi = $rupiah;}
$mkt_team = num($nominal_dibagi) * 0.1;
$mkt_tool = num($nominal_dibagi) * 0.2;
$csr = num($nominal_dibagi) * 0.05;
$cntrsaving = num($nominal_dibagi) * 0.1;
$cntrincome = num($nominal_dibagi) * 0.14;
$ppn = num($nominal_dibagi) * 0.11;	
		
$simpan_kntrb = q_set($__p_simpan_kntrb, "insert into ves_data.vos_distribute_sf (id_prof_bill, rp_amount, center_income, center_saving,csr,mkt_team,mkt_tool,dt_entry,ppn,kd_biodata) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ) ", [(string) ($id_receipt), (string) ($rupiah), (string) ($cntrincome), (string) ($cntrsaving), (string) ($csr), (string) ($mkt_team), (string) ($mkt_tool), (string) ($tgl_hari_ini), (string) ($ppn), (string) ($kdb)]);
$resource_kntrb_mkt_team  = db_query_or_die('errro_simpan_1111', $simpan_kntrb, $__p_simpan_kntrb ?? []);	
		
	$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kdb)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
		while ($row_nik  =  db_fetch($resource_nik, PDO::FETCH_NUM))
			{
			$update_nik = q_set($__p_update_nik, "update ves_data.tb_nik set nik = ? where kd_biodata = ? ", [(string) ($nik), (string) ($kdb)]);
			$resource_update_nik = db_query_or_die('errro_simpan_1', $update_nik, $__p_update_nik ?? []);			
			}
		}	
	else
		{
			$update_nik = q_set($__p_update_nik, "insert into ves_data.tb_nik (nik,kd_biodata) values (? ,? ", [(string) ($nik), (string) ($kdb)]);
			$resource_update_nik = db_query_or_die('errro_simpan_1', $update_nik, $__p_update_nik ?? []);			
		
		}
	
		$update_status = q_set($__p_update_status, "update ves_data.tb_sales_report set byr = 'OK' where no = ? ", [(string) ($no_sr)]);
	$resource_update_status = db_query_or_die('errro_simpan_1', $update_status, $__p_update_status ?? []);			
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VOS Receipt Created');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";

		
	}
?>
</form>
</body>
</html>