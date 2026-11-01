<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$test = in_val('test', 'any');
$judulinvoice = 'LIU MEDIA BILLING STATEMENT';

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
  <style>

function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
.style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
</style>
    <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}

</script><body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
  
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
 
<?php   include __DIR__ . "/left.php";	 ?>
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

<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>


    <div class="col-md-12">
<div class="box box-warning">
<div class="box-body"><span class="form-group">
  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
</span>
  <div class="col-md-8">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>" readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Detail</label><br>
      <a href="callstudent.php?asal=9"  class="btn btn-primary btn-md"> Search</a>
      <input type="hidden" ang="en-150"   name="material_fee" 
                 	      value="<?php echo e($material_fee) ?>" >
      <input type="hidden" ang="en-150"   name="reg_fee" 
                 	      value="<?php echo e($reg_fee) ?>" >
    </div>
  </div>
  <span class="form-group">

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
  <div class="col-md-3">
    <div class="form-group">
      <label>Event Type</label>
      <select name="payment_for"  id="payment_for" class="form-control"    onChange="this.form.submit()">
			<option value="Awards and competitions">Awards and competitions</option>
			<option value="Conferences">Conferences</option>
			<option value="Festivals and parties">Festivals and parties</option>
			<option value="Networking Sessions">Networking Sessions</option>
			<option value="Seminar">Seminar</option>
			<option value="Speaker session">Speaker session</option>
			<option value="Sponsorships">Sponsorships</option>
			<option value="Trade shows and expos">Trade shows and expos</option>
			<option value="Webinars">Webinars</option>
			<option value="Workshops">Workshops</option>
			  
        <option selected="selected"><?php echo e($payment_for) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-8">
    <div class="form-group">
      <label> Event Name</label>
      <input type="text" name="nm_event"  class="form-control" value = "<?php echo e($nm_event) ?>"/>
    </div>
  </div>
  <?php if ($payment_for != 'Test Bakat Minat' and $payment_for != 'VOS Cash Deposit' and $payment_for != 'Test Bakat Minat Premium' ){?>
  <?php if ($payment_for =='NCUK'){?>
  <?php } }?>	
  <div class="col-md-3">
    <div class="form-group">
      <label> Tuition Fee </label>
      <input type="text" name="nominal"  class="form-control" value = "<?php echo e($nominal) ?>" />
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
<div class="box-body"></div>
<div class="box-body"></div>
</form>
</body>
</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{
	$saat_ini = date('Y-m-d H:i:s');
		
	$bisa = 1;	$branch = $_SESSION['branch'];	$kdb = in_val('kdb', 'any');$kdcbg = $_SESSION['kd_branch'];	$idb = in_val('idb', 'any');		
	
	$payment_for = in_val('payment_for', 'any');
	$nm_event = in_val('nm_event', 'any');
	
	$registration = in_val('registration', 'any');
	$reg_discount = in_val('reg_discount', 'any');
	$admin_fee = in_val('admin_fee', 'any');
	$admin_discount = in_val('admin_discount', 'any');
	$nominal = in_val('nominal', 'any');
	$nominal_discount = in_val('nominal_discount', 'any');
	$remark = in_val('remark', 'any');
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";			
		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}
	$kdb = in_val('kdb', 'any');
	$payment_metodh = in_val('payment_metodh', 'any');
	$nominal = in_val('nominal', 'any');
	$student_name = in_val('student_name', 'any');
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
		$query_last_billing = q_set($__p_query_last_billing, "SELECT t.id_invoice, t.jns_invoice FROM ves_data.tb_invoice t where kd_branch =? order by id desc limit 1", [(string) ($kdcbg)]);
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
			
					$nomor_baru = $nol.$nextangka."/BILL/LIUMEDIA/".$bln_rom."-".$tahun;	
									
				}
			}
		else
		{
						
					$nomor_baru =  "0001/BILL/LIUMEDIA/".$bln_rom."-".$tahun;	
												
				}			
		
		}

			
					$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (id_billing,kd_biodata, nama_lengkap, kd_branch, keterangan, nominal, dt_entry, pic, id_invoice, jns_invoice,remark) \r
\t\t\t\t\tvalues \r
\t\t\t\t\t(? ,? ,? ,? ,'LIUMEDIA',? ,? ,? ,? ,'1',? )", [(string) ($nomor_baru), (string) ($kdb), (string) ($student_name), (string) ($kdcbg), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru), (string) ($payment_for) . "  " . (string) ($nm_event) . " " . (string) ($remark)]);
					
		$resource_simpan_payment = db_query_or_die('errro_simpan31', $query_simpan_payment, $__p_query_simpan_payment ?? []);	
		$st = 1;			
			
		}
	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Billing Submitted');\n";
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