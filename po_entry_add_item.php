<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_pemohon = $_SESSION['nama_lengkap'];
if ($email_pemohon == '')
	{
	$query_cek_email_pemohon = q_set($__p_query_cek_email_pemohon, "SELECT e_mail FROM tb_user where nama_detail = ? ", [(string) ($nama_pemohon)]);	
	$resource_cek_email_pemohon = db_query_or_die('errro_1', $query_cek_email_pemohon, $__p_query_cek_email_pemohon ?? []);
	if (num(db_num_rows($resource_cek_email_pemohon)) > 0)
		{
		while ($row_email_pemohon=  db_fetch($resource_cek_email_pemohon, PDO::FETCH_NUM))
			{
			$email_pemohon = $row_email_pemohon['0'];			
			}
		}
	
	}
$kode_po = in_val('kode_po', 'get');
if($kode_po !=''){
$query_po = q_set($__p_query_po, "SELECT kode, nama_pemohon, department, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by,email_pemohon,email_tujuan,kd_branch,corporate  FROM ves_data.purchase_order where kode = ? order by id desc limit 1 ", [(string) ($kode_po)]);	

$resource_po = db_query_or_die('errro_1', $query_po, $__p_query_po ?? []);
if (num(db_num_rows($resource_po)) > 0)
{
while ($row_po=  db_fetch($resource_po, PDO::FETCH_NUM))
	{
	$nama_pemohon = $row_po['1'];
	$department = $row_po['2'];
	$peruntukan = $row_po['3'];
	$dt_po = $row_po['4'];
	$dt_due_po = $row_po['5'];

	$supplier_name = $row_po['6'];
	$supplier_phone = $row_po['7'];
	$supplier_address = $row_po['8'];
	$supplier_bank = $row_po['9'];
	$supplier_bank_account = $row_po['10'];
	$supplier_bank_rekening = $row_po['11'];
	$proposedto = $row_po['12'];
	$email_pemohon = $row_po['13'];		
	$email_tujuan = $row_po['14'];
	$kd_cbg = $row_po['15'];	
	$corporate = $row_po['16'];		
	}
}
	$order_cost = $row_po[''];
	$po_amount = $row_po[''];
}
if ($kd_cbg == 'National'){$kd_cbg = '000';}

if ($kd_cbg == 'East Sby'){$kd_cbg = '001';}
if ($kd_cbg == 'West Sby'){$kd_cbg = '002';}
if ($kd_cbg == 'Denpasar'){$kd_cbg = '003';}
if ($kd_cbg == 'South Jkt'){$kd_cbg = '004';}
if ($kd_cbg == 'North Jkt'){$kd_cbg = '005';}
if ($kd_cbg == 'West Jkt'){$kd_cbg ='006';}
if ($kd_cbg == 'Bandung'){$kd_cbg = '007';}
if ($kd_cbg == 'Malang'){$kd_cbg = '008';}
if ($kd_cbg == 'East Area'){$kd_cbg = '101';}
if ($kd_cbg == 'West Area'){$kd_cbg = '102';}
if ($kd_cbg == 'Online'){$kd_cbg = '100';}
if ($kd_cbg == 'National'){$kd_cbg = '000';}

if ($kd_cbg =='100'){$cabang = 'Online';}
if ($kd_cbg =='000'){$cabang = 'National';}

if ($kd_cbg =='001'){$cabang = 'East Sby';}
if ($kd_cbg =='002'){$cabang = 'West Sby';}
if ($kd_cbg =='003'){$cabang = 'Denpasar';}
if ($kd_cbg =='004'){$cabang = 'South Jkt';}
if ($kd_cbg =='005'){$cabang = 'North Jkt';}
if ($kd_cbg =='006'){$cabang = 'West Jkt';}
if ($kd_cbg =='007'){$cabang = 'Bandung';}
if ($kd_cbg =='008'){$cabang = 'Malang';}
if ($kd_cbg =='101'){$cabang = 'East Area';}
if ($kd_cbg =='102'){$cabang = 'West Area';}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Purchase Order</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php //  include ('left.php') ?>
     <form name="form1" method="post" action="#"  enctype="multipart/form-data"><?php echo csrf_field(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) --><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">User Request</h3>
            </div>
		  </div>
	    </div>
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form --><!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box"><div class="box-body">
			<div class="box-header with-border">
			  <h3 class="box-title">Item Order</h3>
			</div>		 
			<div class="col-md-12">			  
			<div class="col-md-8">
			  <div class="form-group">
				<label for="exampleInputEmail4">Order & Cost</label>
				<textarea name="order_cost" rows="3" class="form-control" placeholder="Enter ..." ><?php echo  e($order_cost) ?></textarea>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="form-group">
				<label for="exampleInputEmail5">Estimated Amount</label>
				<input type="text" class="form-control" placeholder="Enter ..." name="po_amount" value="<?php echo  e($po_amount) ?>">
			  </div>
			</div>
			<div class="col-md-2">
			  <div class="form-group">
			    <label for="exampleInputEmail15">Currency</label>
			    <select class="form-control select2" style="width: 80%;" name="currency">
			      <option value="Rp">Rp</option>
			      <option value="SGD">SGD</option>
			      <option value="RM">RM</option>
			      <option value="YEN">YEN</option>
			      <option value="USD">USD</option>
			      <option value="NZD">NZD</option>					
			      <option value="THB">THB</option>					
			      <option selected><?php echo e($currency) ?></option>
			      </select>
			    </div>
			  </div>
			<div class="col-md-4">
			  <div class="form-group">
			    <label for="exampleInputEmail11">PPh 21/23/4(2)</label>
			    <input type="text" class="form-control" placeholder="Enter ..." name="pph_persen" value="<?php echo  e($pph_persen) ?>">
			  </div>
			  </div>
			<div class="col-md-4">
			  <div class="form-group">
			    <label for="exampleInputEmail14"></label>
			    <button type="submit" class="btn btn-primary"   name="checktax" value="checktax">Check Tax</button>
			    </div>
			  </div>
			<div class="col-md-4">
			  <div class="form-group">
			    <label for="exampleInputEmail13">Estimated Net Amount</label>
			    <input type="text" class="form-control" placeholder="Enter ..." name="po_net_amount" value="<?php echo  e($po_net_amount) ?>">
			    </div>
			  </div>
			<div class="box-footer">
				  <button type="submit" class="btn btn-primary"   name="AddItem" value="AddItem">Add Item</button>
			  </div>
			</div> 
            <!-- /.bodfx-header -->
</div>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->
        </div>

        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
	</form>

	
<?php
if (isset($_POST['checktax'])) 
{
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$nama_pemohon = in_val('nama_pemohon', 'post');
	$email_pemohon = in_val('email_pemohon', 'post');
	$proposedto = in_val('proposedto', 'post');
	$email_tujuan = in_val('email_tujuan', 'post');	
	$department = in_val('department', 'post');
	$peruntukan = in_val('peruntukan', 'post');
	$dt_po = in_val('dt_po', 'post');
	$dt_due_po = in_val('dt_due_po', 'post');
	$file_doc = in_val('file_doc', 'post');
	$order_cost = in_val('order_cost', 'post');
	$po_amount = in_val('po_amount', 'post');
	$pph_persen =  in_val('po_amount', 'post');
	$po_net_amount = num($po_amount) - num((num($po_amount) * num((num($pph_persen)/100))));	
	$supplier_name = in_val('supplier_name', 'post');
	$supplier_phone = in_val('supplier_phone', 'post');
	$supplier_npwp = in_val('supplier_npwp', 'post');
	$supplier_pic = in_val('supplier_pic', 'post');
	$supplier_pic_phone = in_val('supplier_pic_phone', 'post');
	$supplier_npwp = in_val('supplier_npwp', 'post');
	
	$supplier_address = in_val('supplier_address', 'post');
	$supplier_bank = in_val('supplier_bank', 'post');
	$supplier_bank_account = in_val('supplier_bank_account', 'post');
	$supplier_bank_rekening = in_val('supplier_bank_rekening', 'post');
	$email_pemohon = in_val('email_pemohon', 'post');
	$email_tujuan = in_val('email_tujuan', 'post');	
		echo "<script type=\"text/javascript\">\n";
		echo "form.submit();\n";
		echo "</script>";		
}
?>	
	<?php 
	
if (isset($_POST['AddItem'])) 
{
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$kode_po = in_val('kode_po', 'post');	
$kd_cbg = in_val('kd_cbg', 'post');
$corporate = in_val('corporate', 'post');
	$currency = in_val('currency', 'get');	
if ($corporate == '')
	{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Corporate Must Choosed');\n";
		echo "</script>";		
		end;
	}
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
if ($kode_po == '') 
	{
	$query_urut_po = q_set($__p_query_urut_po, "SELECT kode FROM ves_data.purchase_order where mid(kode,1,2) = ? and corporate = ? order by id desc limit 1 ", [(string) ($tahun), (string) ($corporate)]);	
	$resource_urut_po = db_query_or_die('errro_1', $query_urut_po, $__p_query_urut_po ?? []);
	if (num(db_num_rows($resource_urut_po)) > 0)
		{
		while ($row_urut_po=  db_fetch($resource_urut_po, PDO::FETCH_NUM))
			{
			$kode_nomor = $row_urut_po[0];
			$ambilangka =  substr($kode_nomor,3,5);
		
			#ketemu angka awal(angka sebelumnya) + dengan 1
			$nextangka=num($ambilangka)+1;
			#menhitung jumlah karakter
			$digit=strlen($nextangka);
			if(!$kode_nomor){ $nol='0000'; }elseif(num($digit)==1){ $nol='0000'; }	elseif(num($digit)==2){ $nol='000'; }	elseif(num($digit)==3){ $nol='00'; }	elseif(num($digit)==4){ $nol='0'; }
			$kode_urut_po = $tahun.$nol.$nextangka;	
			}	
		}
	else
		{
		$kode_urut_po = $tahun.'00001';
		}
	$nama_pemohon = in_val('nama_pemohon', 'post');
	$email_pemohon = in_val('email_pemohon', 'post');
	$proposedto = in_val('proposedto', 'post');
	$email_tujuan = in_val('email_tujuan', 'post');	
	$department = in_val('department', 'post');
	$peruntukan = in_val('peruntukan', 'post');
	$dt_po = in_val('dt_po', 'post');
	$dt_due_po = in_val('dt_due_po', 'post');
	$file_doc = in_val('file_doc', 'post');
	$order_cost = in_val('order_cost', 'post');
	$po_amount = in_val('po_amount', 'post');
	$supplier_name = in_val('supplier_name', 'post');
	$supplier_phone = in_val('supplier_phone', 'post');
	$supplier_npwp = in_val('supplier_npwp', 'post');
	$supplier_pic = in_val('supplier_pic', 'post');
	$supplier_pic_phone = in_val('supplier_pic_phone', 'post');
	$supplier_npwp = in_val('supplier_npwp', 'post');
	
	$supplier_address = in_val('supplier_address', 'post');
	$supplier_bank = in_val('supplier_bank', 'post');
	$supplier_bank_account = in_val('supplier_bank_account', 'post');
	$supplier_bank_rekening = in_val('supplier_bank_rekening', 'post');
	$email_pemohon = in_val('email_pemohon', 'post');
	$email_tujuan = in_val('email_tujuan', 'post');
	$query_insert_po = q_set($__p_query_insert_po, "insert into ves_data.purchase_order (kode, nama_pemohon, department, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by,email_pemohon, email_tujuan,kd_branch, corporate ) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($kode_urut_po), (string) ($nama_pemohon), (string) ($department), (string) ($peruntukan), (string) ($dt_po), (string) ($dt_due_po), " " . (string) ($supplier_name), (string) ($supplier_phone), (string) ($supplier_address), (string) ($supplier_bank), (string) ($supplier_bank_account), (string) ($supplier_bank_rekening), (string) ($proposedto), (string) ($email_pemohon), (string) ($email_tujuan), (string) ($kd_cbg), (string) ($corporate)]);	
	$resource_urut_po = db_query_or_die('errro_1', $query_insert_po, $__p_query_insert_po ?? []);	
	$query_insert_po_item = q_set($__p_query_insert_po_item, "insert into ves_data.purchase_order_item (kode, order_cost, amount ) values (? ,? ,? )", [(string) ($kode_urut_po), (string) ($order_cost), (string) ($po_amount)]);	
	$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);	

		echo "<script type=\"text/javascript\">\n";
		echo "alert('New Item');\n";
		echo "window.location = ('po_entry.php?kode_po=" . e(u($kode_urut_po)) . "');\n";				
		echo "</script>";	
	}
else
	{
	$order_cost = in_val('order_cost', 'post');
	$po_amount = in_val('po_amount', 'post');	
	$query_insert_po_item = q_set($__p_query_insert_po_item, "insert into ves_data.purchase_order_item (kode, order_cost, amount,currency ) values (? ,? ,? ,? )", [(string) ($kode_po), (string) ($order_cost), (string) ($po_amount), (string) ($currency)]);	
	$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('New Item');\n";
		echo "window.location = ('po_entry.php?kode_po=" . e(u($kode_po)) . "');\n";				
		echo "</script>";		
	}

}

?>	
	<?php 
if (isset($_POST['generate'])) 
{
$saat_ini = date('Y-m-d H:i:s');	
$nama_pemohon = in_val('nama_pemohon', 'post');
$proposedto = in_val('proposedto', 'post');	
$email_pemohon = in_val('email_pemohon', 'post');	
$query_cek_email_pemohon = q_set($__p_query_cek_email_pemohon, "SELECT e_mail FROM tb_user where nama_detail = ? ", [(string) ($nama_pemohon)]);	
$resource_cek_email_pemohon = db_query_or_die('errro_1', $query_cek_email_pemohon, $__p_query_cek_email_pemohon ?? []);
if (num(db_num_rows($resource_cek_email_pemohon)) > 0)
	{
	while ($row_email_pemohon=  db_fetch($resource_cek_email_pemohon, PDO::FETCH_NUM))
		{
		$email_pemohon_tersedia = $row_email_pemohon['0'];			
		}
	}
if ($email_pemohon == '' and $email_pemohon_tersedia == '')
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('E-mail pemohon harus diisi');\n";			
	echo "</script>";
	die;
	}
elseif ($email_pemohon != '' and $email_pemohon_tersedia == '')
	{
	$query_cek_email_pemohon = q_set($__p_query_cek_email_pemohon, "update tb_user set e_mail = ? where nama_detail = ? ", [(string) ($email_pemohon), (string) ($nama_pemohon)]);	
	$resource_cek_email_pemohon = db_query_or_die('errro_1', $query_cek_email_pemohon, $__p_query_cek_email_pemohon ?? []);
	}
	

$email_tujuan	= in_val('email_tujuan', 'post');
$query_cek_email_tujuan = q_set($__p_query_cek_email_tujuan, "SELECT e_mail FROM tb_user where nama_detail = ? ", [(string) ($email_tujuan)]);	
$resource_cek_email_tujuan = db_query_or_die('errro_1', $query_cek_email_tujuan, $__p_query_cek_email_tujuan ?? []);
if (num(db_num_rows($resource_cek_email_tujuan)) > 0)
	{
	while ($row_email_tujuan=  db_fetch($resource_cek_email_tujuan, PDO::FETCH_NUM))
		{
		$email_tujuan_tersedia = $row_email_tujuan['0'];			
		}
	}
if ($email_tujuan == '' and $email_tujuan_tersedia == '')
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('E-mail Tujuan harus diisi');\n";			
	echo "</script>";
	die;
	}
elseif ($email_tujuan != '' and $email_tujuan_tersedia == '')
	{
	$query_cek_email_tujuan = q_set($__p_query_cek_email_tujuan, "update tb_user set e_mail = ? where nama_detail = ? ", [(string) ($email_tujuan), (string) ($proposedto)]);	
	$resource_cek_email_tujuan = db_query_or_die('errro_1', $query_cek_email_tujuan, $__p_query_cek_email_tujuan ?? []);
	}
elseif ($email_tujuan == '' and $email_tujuan_tersedia != '')
	{
$email_tujuan = $email_tujuan_tersedia;
	}	
$kode_po = in_val('kode_po', 'post');
	$currency = in_val('currency', 'get');
$query_update_po = q_set($__p_query_update_po, "update ves_data.purchase_order set po_status = 1, email_pemohon = ? ,email_tujuan = ? ,pic = ? ,dt_entry = ? where kode = ? ", [(string) ($email_pemohon), (string) ($email_tujuan), (string) ($nama_pemohon), (string) ($saat_ini), (string) ($kode_po)]);	
$resource_update_po = db_query_or_die('errro_1', $query_update_po, $__p_query_update_po ?? []);	
$query_log = q_set($__p_query_log, "insert into ves_data.purchase_order_log (kode, dt_entry, po_status, pic, remark)values(? ,? ,'1',? ,'proposed')", [(string) ($kode_po), (string) ($saat_ini), (string) ($nama_pemohon)]);	
$resource_log = db_query_or_die('errro_1', $query_log, $__p_query_log ?? []);	
//====kirim email mulai
$belum = 1 ;	
if ($belum != '')
{
$e_mail = $email_tujuan;
$pengirim = "operation.v1st4@gmail.com";
$subyek = "vcms noreply purchase order request";
$isi = "Dear ".e($proposedto). ",<br>
Staff anda, melakukan purchase order yang ditujukan kepada anda.<br>
Silahkan di check melalui vcms <br>
http://allspark.vistaeducation.com/vcms";	
	
	
include __DIR__ . "/phpmailer/classes/class.phpmailer.php";
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPSecure = 'ssl';
$mail->Host = (string) (vcms_config('smtp')['host'] ?? ''); //hostname masing-masing provider email
$mail->SMTPDebug = 2;
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = (string) (vcms_config('smtp')['user'] ?? ''); //user email
$mail->Password = (string) (vcms_config('smtp')['pass'] ?? ''); //password email
$mail->SetFrom($pengirim,"vcms notification"); //set email pengirim
$mail->Subject = "vcms noreply purchase order request"; //subyek email
$mail->AddAddress($e_mail,$proposedto); //tujuan email
$mail->MsgHTML($isi);
if($mail->Send()) echo "Message has been sent";
else echo "Failed to sending message";	
//====selesai kirim email	
}
echo "<script type=\"text/javascript\">\n";
echo "alert('Notifikasi sudah dikirimkan ke email supervisor');\n";
echo "window.open('po_print.php?kode_po=" . e(u($kode_po)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";					
echo "</script>";

}

?>		

</div>
   <script>
   function popitup(url) 
   {
    newwindow=window.open(url,'name','height=600,width=750,screenX=400,screenY=350');
    if (window.focus) {newwindow.focus()}
    return false;
   }
   </script>
<script>
    function submit(form) {
        form.submit();
    }
</script>
</body>
</html>
