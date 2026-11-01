<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/left.php";
$test = in_val('test', 'any');
if (num($test) ==1){$payment_form = 'Test Bakat Minat';}
elseif (num($test) ==2){$payment_form = 'IELTS International Test';}
elseif (num($test) ==3){$payment_form = 'TOEFL Ibt International Test';}
elseif (num($test) ==4){$payment_form = 'NCUK';}

$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'any');
$payment_for = in_val('payment_for', 'any');
$registration = in_val('registration', 'any');
$reg_discount = in_val('reg_discount', 'any');
$admin_fee = in_val('admin_fee', 'any');
$admin_discount = in_val('admin_discount', 'any');
$nominal = in_val('nominal', 'any');
$nominal_discount = in_val('nominal_discount', 'any');
$remark = in_val('remark', 'any');
$add_tbi = in_val('add_tbi', 'any');

$judulinvoice = $payment_for;	

if ($payment_for =='Test Bakat Minat'){$nominal ='600000';}
elseif ($payment_for =='TBI - Test Penjurusan Premium'){$nominal ='2150000';}
elseif(strpos($payment_for, 'TBI - ') !== false){$nominal ='1475000';}
elseif ($payment_for =='TBI - Test Penjurusan'){$add_tbi ='0';}
if ($payment_for =='TBI - Test Penjurusan + 30 Menit Consult'){$add_tbi ='350000';}
elseif ($payment_for =='TBI - Test Penjurusan + 60 Menit Consult'){$add_tbi ='500000';}
if ($payment_for =='TBI - The Ultimate You'){$nominal ='3150000';}
elseif ($payment_for =='Coaching Session'){$nominal = 750000 * num($jml_jam);}
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
//get data stu



$query_student = q_set($__p_query_student, "SELECT t.kd_biodata, t.nama, t.middle_name, t.family_name, t.address, t.city FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($kdb)]);
$resource_student= db_query_or_die('errro_8', $query_student, $__p_query_student ?? []);
$keluar_student= db_num_rows($resource_student);
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
		{
		$kd_biodata= $row_student[0];				
		$nama= $row_student[1];		
		$middle_name = $row_student[2];
		$family_name = $row_student[3];
		$address = $row_student[4];
		$city = $row_student[5];
			
		$student_name ="$nama $middle_name $family_name";
		
		}
	}



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
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3><?php echo e($judulinvoice) ?></h3>
	<h5>Invoice Number : <?php echo e($idb) ?></h5>
</div>
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->



    <div class="col-md-12">
<div class="box box-warning">
<div class="box-body"><span class="form-group">
  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
</span>
  <div class="col-md-8">
    <div class="form-group">
      <label>Company Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>" readonly> <button type="button" class="btn-circle btn-xs" data-toggle="modal" data-target="#student_list"><i class="fa fa-edit"></i></button>
    </div>

        <div class="modal" id="student_list">
          <div class="modal-dialog">
            <div class="modal-content">
    <form method="post"><?php echo csrf_field(); ?>
				
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Student List</h4>
              </div>
              <div class="modal-footer">
      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
      <input type="submit" class="btn btn-success" name="choosestudent" value="Select">
              </div>				
              <div class="modal-body">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
<?php					
$query_student = q_set($__p_query_student, "SELECT kd_biodata,concat_ws(' ',nama, middle_name, family_name) FROM ves_inc.tb_biodata where dt_entry > '2019-01-01' and kd_branch = ? order by nama", [(string) ($kdcbg)]);

$resource_student= db_query_or_die('errro_8', $query_student, $__p_query_student ?? []);
$keluar_student= db_num_rows($resource_student);
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
		{
		$kd_biodata= $row_student[0];				
		$nama_dipilih= $row_student[1];		
		$enroll_date = $row_student[1];	
?>		
                <tr>
                  <td><?php echo e($nama_dipilih) ?><input type="hidden" class="form-control" name="kd_biodata_<?php echo e($b) ?>" value=<?php echo e($kd_biodata) ?>></td>
                  <td><input type="checkbox" name = 'check_<?php echo e($b) ?>' class="flat-red" <?php echo e($paid_checked) ?>>
                  </input></td>
                </tr>
<?php $b = num($b)+1; } }?>                
                </tfoot>
              </table>
<?php	  
if (isset($_POST['choosestudent'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$batas = $b;
	for($b=0;$b<=$batas;$b++) 
		{
		$pilih = $_POST['check_'.$b];

		if( empty($_POST['check_'.$b]) ){$dipilih = 0;}else{$dipilih = 1;}	
		if (num($dipilih)==1)
			{

			$kdb = $_POST['kd_biodata_'.$b];							
			}
		}
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('invoicebillnew.php?kdb=" . e(u($kdb)) . "');\n";				
		echo "</script>";	
}
?>				
              </div>
	  </form>
	  
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>	    <form method="post"><?php echo csrf_field(); ?>

			        <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="kdb" 
                 	      value="<?php echo e($kdb) ?>" readonly>
  </div>
  <span class="form-group">
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="nama_dipilih" 
                 	      value="<?php echo e($student_name) ?>" readonly>
  <input type="hidden" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="hidden" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
  </span>
  <div class="col-md-8">
    <div class="form-group">
      <label>Address</label>
      <input name="address"  class="form-control"  type="text" size="90" value="<?php echo e($address) . " ".e($city) ?>" />
    </div>
  </div>
  <span class="form-group">
  <input type="text" ang="en-150"   name="st" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="asal" 
                 	      value="<?php echo e($asal) ?>" hidden="hidden" >
  <input type="hidden" ang="en-150"   name="idb" 
                 	      value="<?php echo e($idb) ?>" >
  </span></div>
	  </div>
<div class="box box-warning">		
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label> INFO</label>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>Payment For</label>
      <select name="payment_for"  id="payment_for" class="form-control"    onChange="this.form.submit()">	
        <option value="TBI - The Ultimate You">TBI - The Ultimate You</option>		  
        <option value="TBI - Test Penjurusan">TBI - Test Penjurusan</option>
        <option value="TBI - Test Penjurusan Premium">TBI - Test Penjurusan Premium</option>		  
        <option value="TBI - Test Penjurusan + 30 Menit Consult">TBI - Test Penjurusan + 30 Menit Consult</option>
        <option value="TBI - Test Penjurusan + 60 Menit Consult">TBI - Test Penjurusan + 60 Menit Consult</option>					  			  
        <option value="IELTS International Test">IELTS International Test</option>
        <option value="TOEFL Ibt International Test">TOEFL Ibt International Test</option>
        <option value="NCUK">NCUK</option>	
        <option value="VOS Cash Deposit">VOS Cash Deposit</option>		
        <option value="Password Test">Password Test</option>	
        <option value="SAT">SAT</option>	
        <option value="GRE International Test">GRE International Test</option>
        <option value="Coaching Session">Coaching Session</option>		  
        <option value="Other Income">Other Income</option>			  
        <option selected="selected"><?php echo e($payment_for) ?></option>
      </select>
    </div>
  </div>
<?php if ($payment_for =='Coaching Session') { ?>	
  <div class="col-md-1">
    <div class="form-group">
      <label>Hour</label>
      <select name="jml_jam"  id="reg_discount2" class="form-control"     onChange="this.form.submit()" >
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
		  
        <option selected="selected"><?php echo e($jml_jam) ?></option>
      </select>
    </div>
  </div>
<?php } ?>		
  <?php if ($payment_for != 'Test Bakat Minat' and $payment_for != 'VOS Cash Deposit' and $payment_for != 'Test Bakat Minat Premium' and $payment_for != 'Password Test' and $payment_for != 'Vistalk 2020'  and $payment_for != 'SAT'   and $payment_for != 'GRE International Test'   and $payment_for != 'Other Income' and $payment_for != 'TBI - Test Penjurusan' and $payment_for != 'TBI - Test Penjurusan + 30 Menit Consult' and $payment_for != 'TBI - Test Penjurusan + 60 Menit Consult'){?>	
  <div class="col-md-3">
    <div class="form-group">
      <label>Registration</label>
      <select name="registration"  id="diskon" class="form-control"     onChange="this.form.submit()" >
        <option value="Yes">Yes</option>
        <option value="No">No</option>
        <option value="Free Registration">Free Registration</option>
		  
        <option selected="selected"><?php echo e($registration) ?></option>
      </select>
    </div>
  </div>
<?php if ($payment_for =='NCUK'){?>	
  <div class="col-md-3">
    <div class="form-group">
      <label>Registration Discount/Promo</label>
      <select name="reg_discount"  id="registration" class="form-control"     onChange="this.form.submit()" >
        <option value=""></option>

        <option selected="selected"><?php echo e($reg_discount) ?></option>
      </select>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label>Administration Fee</label>
      <input type="text" name="admin_fee"  class="form-control" value = "<?php echo e($admin_fee) ?>" />
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Administration Fee Discount/Promo</label>
      <select name="admin_discount"  id="reg_discount" class="form-control"     onChange="this.form.submit()" >
        <option value=""></option>
        <option selected="selected"><?php echo e($admin_discount) ?></option>
      </select>
    </div>
  </div>
  <?php } }?>	
  <div class="col-md-3">
    <div class="form-group">
      <label> Tuition Fee </label>
      <input type="text" name="nominal"  class="form-control" value = "<?php echo e($nominal) ?>" <?php if (strpos($payment_for, 'TBI - ') !== false){ ?> readonly <?php } ?> />
    </div>
  </div>
<?php if(strpos($payment_for, 'TBI - ') !== false){ ?>	
  <div class="col-md-3">
    <div class="form-group">
      <label> Additional Fee </label>
      <input type="text" name="add_tbi"  class="form-control" value = "<?php echo e($add_tbi) ?>" <?php if (strpos($payment_for, 'TBI - ') !== false){ ?> readonly <?php } ?> />
    </div>
  </div>
<?php } ?>	
  <div class="col-md-3">
    <div class="form-group">
      <label>Tuition Fee Discount/Promo</label>
      <select name="nominal_discount"  id="jns_report2" class="form-control"     onChange="this.form.submit()" >
        <option value="50000">50000</option>		  
        <option value="150000">150000</option>
        <option value="175000">175000</option>		  
        <option value="200000">200000</option>		
        <option value="300000">300000</option>
        <option value="425000">425000</option>		  
        <option value="1500000">1500000</option>
        <option selected="selected"><?php echo e($nominal_discount) ?></option>
      </select>
    </div>
</div>
  <div class="col-md-8">
    <div class="form-group">
      <label> Remark</label>
      <input type="text" name="remark"  class="form-control" value = "<?php echo e($remark) ?>"/>
    </div>
  </div>
  <?php //==== 
if ($type_class == 'PRI')
{
	?>
  <?php }//==== ?>
 <input type="hidden" name="tf" id="textfield" value="<?php echo e($tf) ?>" hidden="hidden" >
 <input type="hidden" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>">
      <input type="hidden" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="">
</div>
	  </div>
<div class="box box-warning">
	  <div class="box-body">
		    <div class="row">
		      <div class="col-md-2">
		        <div class="form-group">
		          <label></label>
		          <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />
	            </div>
	          </div>
   	          <div class="col-md-2">
	          <div class="form-group">
	       
	           <input name="Print" type="submit" id="Print"  class="form-control"  value="Print" />
              </div>
            </div></a>
            <div class="col-md-2">
              <div class="form-group"> <a href="profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>" onClick="window.open('profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>')">
                <input name="Save2" type="submit" id="Save3"  class="form-control"  value="Exit" />
              </a> </div>
            </div>
		    </div>

	  </div>
	  </div>
  </div>
</form>
</body>
</html>
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
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{
	$saat_ini = date('Y-m-d H:i:s');
		
	$bisa = 1;	$branch = $_SESSION['branch'];	$kdb = in_val('kdb', 'any');$kdcbg = $_SESSION['kd_branch'];	$idb = in_val('idb', 'any');		

$payment_for = in_val('payment_for', 'any');
$registration = in_val('registration', 'any');
$reg_discount = in_val('reg_discount', 'any');
$admin_fee = in_val('admin_fee', 'any');
$admin_discount = in_val('admin_discount', 'any');
$nominal = in_val('nominal', 'any');
$add_tbi = in_val('add_tbi', 'any');	
$nominal_discount = in_val('nominal_discount', 'any');
$nominal_net = num($nominal) - num($nominal_discount);	
$remark = in_val('remark', 'any');
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";			
		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}
	$kdb = in_val('kdb', 'any');
	$payment_metodh = in_val('payment_metodh', 'any');

	$nama_dipilih = in_val('nama_dipilih', 'any');
	$keterangan = in_val('textarea', 'any');$amount = in_val('amount', 'any'); 
	//if ($amount == 0 ){$bisa = 0;$pesan ="Amount must be not zero";}
	if(num($bisa) == 1)
		{
		if ($idb !='')
			{
				$query_update_billing= q_set($__p_query_update_billing, "update ves_data.vip_billing set kd_program = ? ,tf = ? ,discount= ? ,net_tf= ? ,pic= ? ,sc= ? ,material= ? ,old_student= ? ,voucher= ? ,material_cost= ? ,reg_fee= ? ,promo_persen = ? ,level_program = ? ,private_pax = ? ,\r
private_hours  = ? ,book_title = ? where  kd_biodata = ? and kd_billing = ? ", [(string) ($kode_program), (string) ($tf), (string) ($nm_promo), (string) ($tf_nett), (string) ($nama_lengkap), (string) ($sc), (string) ($material_book), (string) ($old_student), (string) ($voucher), (string) ($material_fee), (string) ($reg_fee), (string) ($discount_tf), (string) ($nm_level), (string) ($private_pax), (string) ($private_hours), (string) ($book_title), (string) ($kdb), (string) ($idb)]); 
				$resource_update_billing = db_query_or_die('errro_simpan', $query_update_billing, $__p_query_update_billing ?? []);
		}
		else
		{
		$query_last_billing = q_set($__p_query_last_billing, "SELECT t.id_invoice, t.jns_invoice FROM ves_data.tb_invoice t where kd_branch =? and (keterangan = ? or keterangan like ? ) order by id desc limit 1", [(string) ($kdcbg), (string) ($payment_for), (string) ($payment_for) . "%"]);
		$resource_last_billing = db_query_or_die('errro_last_billing', $query_last_billing, $__p_query_last_billing ?? []);
		if(num(db_num_rows($resource_last_billing)) > 0)
			{
			while ($row_last_billing=  db_fetch($resource_last_billing, PDO::FETCH_NUM))
				{
				$kd_invoice = $row_last_billing[0];
				$ambilangka =  substr($kd_invoice,0,-4);
				#ketemu angka awal(angka sebelumnya) + dengan 1
				$nextangka=num($ambilangka)+1;
				#menhitung jumlah karakter
				$digit=strlen($nextangka);
				if(!$kd_invoice){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3)
				{ $nol='0'; }
				if ($payment_for =='Test Bakat Minat'or $payment_for =='Test Bakat Minat Premium' or $payment_for=='Test Penjurusan Online')
					{			
					$nomor_baru = $nol.$nextangka."/BILL/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='IELTS International Test')
					{			
					$nomor_baru = $nol.$nextangka."/BILL/ILT-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru = $nol.$nextangka."/BILL/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='NCUK')
					{			
					$nomor_baru = $nol.$nextangka."/BILL/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
	
				elseif ($payment_for == "VOS Cash Deposit") 
					{
					$nomor_baru = $nol.$nextangka."/BILL/VOS/DEPOSIT/0".$kdcbg."/".$bln_rom."-".$tahun;
					}
				elseif ($payment_for == "Password Test") 
					{
					$nomor_baru = $nol.$nextangka."/BILL/VOS/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;
					}
				elseif ($payment_for == "Vistalk 2020")
					{
					$nomor_baru = $nol.$nextangka."/BILL/VOS/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;
					}	
				elseif ($payment_for == "SAT")
					{
					$nomor_baru = $nol.$nextangka."/BILL/VOS/SAT/0".$kdcbg."/".$bln_rom."-".$tahun;
					}
				elseif ($payment_for == "GRE International Test")
					{
					$nomor_baru = $nol.$nextangka."/BILL/VOS/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;
					}	
				elseif ($payment_for == "Other Income")
					{
					$nomor_baru = $nol.$nextangka."/BILL/ICM/0".$kdcbg."/".$bln_rom."-".$tahun;
					}
				elseif (strpos($payment_for, 'TBI - ') !== false)
					{
					$nomor_baru = $nol.$nextangka."/BILL/TBI/0".$kdcbg."/".$bln_rom."-".$tahun;
					}	
				elseif ($payment_for== 'Coaching Session')
					{
					$nomor_baru = $nol.$nextangka."/BILL/CS/0".$kdcbg."/".$bln_rom."-".$tahun;
					}				
				
				}
			}
		else
		{
				if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium' or $payment_for=='Test Penjurusan Online')
					{			
					$nomor_baru =  "0001/BILL/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='IELTS International Test')
					{			
					$nomor_baru =  "0001/BILL/ILT-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru =  "0001/BILL/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='NCUK')
					{			
					$nomor_baru = "0001/BILL/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				elseif ($payment_for == "VOS Cash Deposit") 
					{
					$nomor_baru = $nol.$nextangka."/BILL/VOS/DEPOSIT/0".$kdcbg."/".$bln_rom."-".$tahun;			
					}
				elseif ($payment_for == "Password Test") 
					{
					$nomor_baru = "0001/BILL/VOS/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;
					}
				elseif ($payment_for == "Vistalk 2020")
					{

					$nomor_baru = "0001/BILL/VOS/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;					
					}	
				elseif ($payment_for == "SAT")
					{
					$nomor_baru = "0001/BILL/VOS/SAT/0".$kdcbg."/".$bln_rom."-".$tahun;
					}
				elseif ($payment_for == "GRE International Test")
					{
					$nomor_baru ="0001/BILL/VOS/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;
					}	
				elseif ($payment_for == "Other Income")
					{
					$nomor_baru = "001/BILL/ICM/0".$kdcbg."/".$bln_rom."-".$tahun;
					}
				elseif (strpos($payment_for, 'TBI - ') !== false)
					{
					$nomor_baru = "0001/BILL/TBI/0".$kdcbg."/".$bln_rom."-".$tahun;
					}	
				elseif ($payment_for== 'Coaching Session')
					{
					$nomor_baru = "0001/BILL/CS/0".$kdcbg."/".$bln_rom."-".$tahun;
					}				
				}			
		
		}

		if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium' or $payment_for =='Test Penjurusan Online')
					{			
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1')", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru)]);
					}
 
	 	elseif (strpos($payment_for, 'TBI - ') !== false)
					{			
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,additional_fee,nominal_discount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal_net), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($add_tbi), (string) ($nominal_discount)]);
					}	 
		elseif ($payment_for== 'VOS Cash Deposit') 
					{
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1')", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for) . " - " . (string) ($remark), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru)]);
					}		
		else if ($payment_for =='IELTS International Test')
					{	
					if($registration == 'Yes'){$registration = '200000';}
					elseif($registration == 'No'){$registration = '0';}
					elseif($registration == 'Free Registration'){$registration = '0';$reg_nama_discount='Free Registration';}
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,reg_amount,reg_nama_discount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($registration), (string) ($reg_nama_discount)]);
					}
		else if ($payment_for =='TOEFL Ibt International Test')
								
					{	
					if($registration == 'Yes'){$registration = '200000';}
					elseif($registration == 'No'){$registration = '0';}
					elseif($registration == 'Free Registration'){$registration = '0';$reg_nama_discount='Free Registration';}				
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,reg_amount,reg_nama_discount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($registration), (string) ($reg_nama_discount)]);
					}
					
		else if ($payment_for =='NCUK')
					{	
					if($registration == 'Yes'){$registration = '150000';}
					elseif($registration == 'No'){$registration = '0';}
					elseif($registration == 'Free Registration'){$registration = '0';$reg_nama_discount='Free Registration';}
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,reg_amount,reg_nama_discount, admin_discount,  admin_amount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? ,? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal_net), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($registration), (string) ($reg_nama_discount), (string) ($admin_discount), (string) ($admin_fee)]);
					}
		else if ($payment_for =='Password Test')
					{	
					if($registration == 'Yes'){$registration = '200000';}
					elseif($registration == 'No'){$registration = '0';}
					elseif($registration == 'Free Registration'){$registration = '0';$reg_nama_discount='Free Registration';}				
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,reg_amount,reg_nama_discount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($registration), (string) ($reg_nama_discount)]);
					}		
		else if ($payment_for =='Vistalk 2020')
					{	
					if($registration == 'Yes'){$registration = '200000';}
					elseif($registration == 'No'){$registration = '0';}
					elseif($registration == 'Free Registration'){$registration = '0';$reg_nama_discount='Free Registration';}
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,reg_amount,reg_nama_discount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($registration), (string) ($reg_nama_discount)]);
					}	
		else if ($payment_for =='SAT')
					{	
					if($registration == 'Yes'){$registration = '200000';}
					elseif($registration == 'No'){$registration = '0';}
					elseif($registration == 'Free Registration'){$registration = '0';$reg_nama_discount='Free Registration';}
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,reg_amount,reg_nama_discount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($registration), (string) ($reg_nama_discount)]);
					}	
		elseif ($payment_for == "GRE International Test")
					{
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,reg_amount,reg_nama_discount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($registration), (string) ($reg_nama_discount)]);
					}
		elseif ($payment_for == "Other Income")
					{
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,reg_amount,reg_nama_discount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($nama_dipilih), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($registration), (string) ($reg_nama_discount)]);
					}	
		elseif ($payment_for == "Coaching Session")		
					{
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,reg_amount,reg_nama_discount) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? ,? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($student_name), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($registration), (string) ($reg_nama_discount)]);
					}		
		
		
		$resource_simpan_payment = db_query_or_die('errro_simpan31', $query_simpan_payment, $__p_query_simpan_payment ?? []);	
		$st = 1;			
			
		}
	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VIP Billing Submitted');\n";
		echo "window.location = ('invoicebilllist.php?idb=" . e(u($idb)) . "&kdb=" . e(u($kdb)) . "&st=" . e(u($st)) . "');\n";				
		echo "</script>";
		}

if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Print']))) 
	{
	if ($idb !='')
		{

			echo "<script type=\"text/javascript\">\n";
			echo "window.open('invoiceprint.php?kdb=" . e(u($kdb)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
			echo "</script>";		

		}
	}
if (isset($_GET['Invoicing'])) 
	{
	if ($idb !='')
		{

			echo "<script type=\"text/javascript\">\n";
			echo "window.open('invoiceprint.php?idb=" . e(u($idb)) . "&kdb=" . e(u($kdb)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
			echo "</script>";		

		}
	}					  
?>