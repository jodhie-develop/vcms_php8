<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";

$load = in_val('load', 'any');
$incentive_id = in_val('incentive_id', 'any');

	
$npwp = in_val('npwp', 'any');
$email_pemohon = in_val('email_pemohon', 'any');
$department = in_val('department', 'any');
$kd_cbg = in_val('kd_cbg', 'any');
$core = in_val('core', 'any');
$proposedto = in_val('proposedto', 'any');
$email_tujuan = in_val('email_tujuan', 'any');
$tgl = in_val('tgl', 'any');
$jenis_trip = in_val('jenis_trip', 'any');
$keterangan = in_val('keterangan', 'any');

$nama_pemohon = $_SESSION['nama_lengkap'];

$kd_staff = $_SESSION['kd_staff'];
$query_cek_incentive = q_set($__p_query_cek_incentive, "SELECT id_trip, kd_emp, nama_pemohon, npwp, email_pemohon, department, core, kd_cbg, proposedto, email_tujuan, status_trip, dt_entry  FROM ves_data.trip_incentive where id_trip =? and status_trip = 0 order by id limit 1", [(string) ($incentive_id)]);	
$resource_cek_incentive = db_query_or_die('errro_31', $query_cek_incentive, $__p_query_cek_incentive ?? []);
if (num(db_num_rows($resource_cek_incentive)) > 0)
	{
	$sdh_dibuat = 1;
	while ($row_cek_incentive=  db_fetch($resource_cek_incentive, PDO::FETCH_NUM))
		{
		$incentive_id =$row_cek_incentive['0'];
		$kd_staff =$row_cek_incentive['1'];
		$nama_pemohon =$row_cek_incentive['2'];
		$npwp =$row_cek_incentive['3'];
		$email_pemohon =$row_cek_incentive['4'];
		$department =$row_cek_incentive['5'];
		$core =$row_cek_incentive['6'];
		$kd_cbg =$row_cek_incentive['7'];
		$proposedto =$row_cek_incentive['8'];
		$email_tujuan =$row_cek_incentive['9'];
		}
	}
else
	{
	$sdh_dibuat = 0;
$query_urut_po_sementara = q_set($__p_query_urut_po_sementara, "SELECT right(id_trip,5)  FROM ves_data.trip_incentive where kd_emp =? and status_trip = 1 order by id desc limit 1 ", [(string) ($kd_staff)]);	
$resource_urut_po_sementara = db_query_or_die('errro_31', $query_urut_po_sementara, $__p_query_urut_po_sementara ?? []);
if (num(db_num_rows($resource_urut_po_sementara)) > 0)
	{
	while ($row_urut_po_sementara=  db_fetch($resource_urut_po_sementara, PDO::FETCH_NUM))
		{
		$kode_nomor_sementara = $row_urut_po_sementara[0];



		#ketemu angka awal(angka sebelumnya) + dengan 1
		$nextangkasementara=num($kode_nomor_sementara)+1;
		#menhitung jumlah karakter
		$digitsementara=strlen($nextangkasementara);
		if(!$kode_nomor_sementara){ $nol='0000'; }elseif(num($digitsementara)==1){ $nol='0000'; }	elseif(num($digitsementara)==2){ $nol='000'; }	elseif(num($digitsementara)==3){ $nol='00'; }	elseif(num($digitsementara)==4){ $nol='0'; }			


		$incentive_id = $kd_staff.$nol.$nextangkasementara;
		}	
	}
else
	{
	$incentive_id = $kd_staff.'00001';
	}
	
	
	}


if(num($load) !=1)
{


$check_tax_item = in_val('st_tax', 'any');
$supplier_name = in_val('supplier_name', 'any');


if ($email_pemohon == '')
	{
	$query_cek_email_pemohon = q_set($__p_query_cek_email_pemohon, "SELECT e_mail FROM tb_user where nama_detail = ? ", [(string) ($nama_pemohon)]);	
	$resource_cek_email_pemohon = db_query_or_die('errro_1a', $query_cek_email_pemohon, $__p_query_cek_email_pemohon ?? []);
	if (num(db_num_rows($resource_cek_email_pemohon)) > 0)
		{
		while ($row_email_pemohon=  db_fetch($resource_cek_email_pemohon, PDO::FETCH_NUM))
			{
			$email_pemohon = $row_email_pemohon['0'];			
			}
		}
	}
$kode_po = in_val('kode_po', 'any');
if($kode_po !=''){
$query_po = q_set($__p_query_po, "SELECT kode, nama_pemohon, department, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by,email_pemohon,email_tujuan,kd_branch,corporate, supplier_pic,supplier_pic_phone,supplier_npwp,supplier_kd,remark_pemohon,core,kd_branch,kd_biodata,pay_mtd   FROM ves_data.purchase_order where kode = ? order by id desc limit 1 ", [(string) ($kode_po)]);	

$resource_po = db_query_or_die('errro_2', $query_po, $__p_query_po ?? []);
if (num(db_num_rows($resource_po)) > 0)
{
while ($row_po=  db_fetch($resource_po, PDO::FETCH_NUM))
	{
	$nama_pemohon = $row_po['1'];
	$department = $row_po['2'];
	$peruntukan = $row_po['3'];
	$dt_po = $row_po['4'];
	$dt_due_po = $row_po['5'];
	$proposedto = $row_po['12'];
	$email_pemohon = $row_po['13'];		
	$email_tujuan = $row_po['14'];
	$kd_cbg = $row_po['15'];	
	$corporate = $row_po['16'];	
	$supplier_kd 	 = $row_po['20'];
	$remark_pemohon 	 = $row_po['21'];	
	$core 	 = $row_po['22'];		
	$kd_cbg 	 = $row_po['23'];	
	$kd_biodata = $row_po[24];
	$pay_mtd = $row_po[25];
	if ($kd_biodata !='')
		{
		$query_cek_nama = q_set($__p_query_cek_nama, "select kd_biodata, concat(nama, ' ', middle_name, ' ',family_name) from ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($kd_biodata)]);	

		$resource_cek_nama = db_query_or_die('errro_1b', $query_cek_nama, $__p_query_cek_nama ?? []);
		if (num(db_num_rows($resource_cek_nama)) > 0)
			{
			while ($row_cek_nama=  db_fetch($resource_cek_nama, PDO::FETCH_NUM))
				{
				$student_list = $row_cek_nama['1'];	
				$kd_biodata = $row_cek_nama['0'];					
				}	
			}	
		}

	}

}	
if ($kd_cbg == 'HO'){$kd_cbg = '000';}

elseif ($kd_cbg == 'East Sby'){$kd_cbg = '001';}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = '002';}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = '003';}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = '004';}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = '005';}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg ='006';}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = '007';}
elseif ($kd_cbg == 'Malang'){$kd_cbg = '008';}
elseif ($kd_cbg == 'East Area'){$kd_cbg = '101';}
elseif ($kd_cbg == 'West Area'){$kd_cbg = '102';}
elseif ($kd_cbg == 'Online'){$kd_cbg = '100';}
elseif ($kd_cbg == 'HO'){$kd_cbg = '000';}

elseif ($kd_cbg =='100'){$cabang = 'Online';}
elseif ($kd_cbg =='000'){$cabang = 'HO';}

elseif ($kd_cbg =='001'){$cabang = 'East Sby';}
elseif ($kd_cbg =='002'){$cabang = 'West Sby';}
elseif ($kd_cbg =='003'){$cabang = 'Denpasar';}
elseif ($kd_cbg =='004'){$cabang = 'South Jkt';}
elseif ($kd_cbg =='005'){$cabang = 'North Jkt';}
elseif ($kd_cbg =='006'){$cabang = 'West Jkt';}
elseif ($kd_cbg =='007'){$cabang = 'Bandung';}
elseif ($kd_cbg =='008'){$cabang = 'Malang';}
elseif ($kd_cbg =='101'){$cabang = 'East Area';}
elseif ($kd_cbg =='102'){$cabang = 'West Area';}

$item_ada = 0;
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount,id, tax_ori,currency FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
$resource_po_item = db_query_soft($query_po_item, $__p_query_po_item ?? []);
if(num(db_num_rows($resource_po_item)) > 0)
	{
	$item_ada = 1;
	}
	
$query_po_file = q_set($__p_query_po_file, "SELECT * FROM ves_data.purchase_order_file p where kode = ? ", [(string) ($kode_po)]);
$resource_po_file = db_query_soft($query_po_file, $__p_query_po_file ?? []);
if(num(db_num_rows($resource_po_file)) > 0)
	{
	$file_ada = 1;
	}

	$query_cek_email_tujuan = q_set($__p_query_cek_email_tujuan, "SELECT e_mail FROM tb_user where nama_detail = ? ", [(string) ($proposedto)]);	
	$resource_cek_email_tujuan = db_query_or_die('errro_1v', $query_cek_email_tujuan, $__p_query_cek_email_tujuan ?? []);
	if (num(db_num_rows($resource_cek_email_tujuan)) > 0)
		{
		while ($row_email_tujuann=  db_fetch($resource_cek_email_tujuan, PDO::FETCH_NUM))
			{
			$email_tujuan_db = $row_email_tujuann['0'];
			if($email_tujuan_db == '' and $email_tujuan !='')
				{
				$query_cek_email_tujuan_upd = q_set($__p_query_cek_email_tujuan_upd, "update tb_user set  e_mail =? where nama_detail = ? ", [(string) ($email_tujuan), (string) ($proposedto)]);	
				$resource_cek_email_tujuan_upd = db_query_or_die('errro_1d', $query_cek_email_tujuan_upd, $__p_query_cek_email_tujuan_upd ?? []);						
				}
			}
		}
	else
		{
		$email_tujuan = '';	
		
		}
	
}}
else
	{	
	$kd_biodata = in_val('kd_biodata', 'any');
	$student_list = in_val('student_list', 'any');

	if($student_list != '')
		{
		$query_cek_nama = q_set($__p_query_cek_nama, "select kd_biodata, concat(nama, ' ', middle_name, ' ',family_name) from ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($student_list)]);	
		$resource_cek_nama = db_query_or_die('errro_1s', $query_cek_nama, $__p_query_cek_nama ?? []);
		if (num(db_num_rows($resource_cek_nama)) > 0)
			{
			while ($row_cek_nama=  db_fetch($resource_cek_nama, PDO::FETCH_NUM))
				{
				$student_list = $row_cek_nama['1'];	
				$kd_biodata = $row_cek_nama['0'];					
				}	
			}	
		}
	
	$kode_po = $kode_urut_po;
	$corporate = in_val('corporate', 'any');	
	$email_pemohon = in_val('email_pemohon', 'any');

	$email_tujuan = in_val('email_tujuan', 'any');	

	$proposedto = in_val('proposedto', 'any');
	$kd_cbg = in_val('kd_cbg', 'any');
if ($email_pemohon == '')
	{
	$query_cek_email_pemohon = q_set($__p_query_cek_email_pemohon, "SELECT e_mail FROM tb_user where nama_detail = ? ", [(string) ($nama_pemohon)]);	
	$resource_cek_email_pemohon = db_query_or_die('errro_1g', $query_cek_email_pemohon, $__p_query_cek_email_pemohon ?? []);
	if (num(db_num_rows($resource_cek_email_pemohon)) > 0)
		{
		while ($row_email_pemohon=  db_fetch($resource_cek_email_pemohon, PDO::FETCH_NUM))
			{
			$email_pemohon = $row_email_pemohon['0'];			
			}
		}
	else
		{
		$email_pemohon = '';	
		}
	
	}
	$query_cek_email_tujuan = q_set($__p_query_cek_email_tujuan, "SELECT e_mail FROM tb_user where nama_detail = ? ", [(string) ($proposedto)]);	
	$resource_cek_email_tujuan = db_query_or_die('errro_1r', $query_cek_email_tujuan, $__p_query_cek_email_tujuan ?? []);
	if (num(db_num_rows($resource_cek_email_tujuan)) > 0)
		{
		while ($row_email_tujuann=  db_fetch($resource_cek_email_tujuan, PDO::FETCH_NUM))
			{
			$email_tujuan_db = $row_email_tujuann['0'];
			if ($email_tujuan_db !=''){$email_tujuan = $email_tujuan_db;}
			}
		}
	else
		{
		$email_tujuan = '';	
		}
	
	echo e($kd_cbg);
if ($kd_cbg == 'HO'){$kd_cbg = '000';}

elseif ($kd_cbg == 'East Sby'){$kd_cbg = '001';}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = '002';}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = '003';}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = '004';}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = '005';}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg ='006';}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = '007';}
elseif ($kd_cbg == 'Malang'){$kd_cbg = '008';}
elseif ($kd_cbg == 'East Area'){$kd_cbg = '101';}
elseif ($kd_cbg == 'West Area'){$kd_cbg = '102';}
elseif ($kd_cbg == 'Online'){$kd_cbg = '100';}
elseif ($kd_cbg == 'HO'){$kd_cbg = '000';}

elseif ($kd_cbg =='100'){$cabang = 'Online';}
elseif ($kd_cbg =='000'){$cabang = 'HO';}

elseif ($kd_cbg =='001'){$cabang = 'East Sby';}
elseif ($kd_cbg =='002'){$cabang = 'West Sby';}
elseif ($kd_cbg =='003'){$cabang = 'Denpasar';}
elseif ($kd_cbg =='004'){$cabang = 'South Jkt';}
elseif ($kd_cbg =='005'){$cabang = 'North Jkt';}
elseif ($kd_cbg =='006'){$cabang = 'West Jkt';}
elseif ($kd_cbg =='007'){$cabang = 'Bandung';}
elseif ($kd_cbg =='008'){$cabang = 'Malang';}
elseif ($kd_cbg =='101'){$cabang = 'East Area';}
elseif ($kd_cbg =='102'){$cabang = 'West Area';}	
	$department = in_val('department', 'any');
	$core= in_val('core', 'any');	
	$peruntukan = in_val('peruntukan', 'any');
	$dt_po = in_val('dt_po', 'any');
	$dt_due_po = in_val('dt_due_po', 'any');
	$file_doc = in_val('file_doc', 'any');
	$order_cost = in_val('order_cost', 'any');
	$po_amount = in_val('po_amount', 'any');
	$pph_persen = in_val('pph_persen', 'any');	
	$supplier_name = in_val('supplier_name', 'any');
	$supplier_phone = in_val('supplier_phone', 'any');
	$supplier_npwp = in_val('supplier_npwp', 'any');
	$supplier_pic = in_val('supplier_pic', 'any');
	$supplier_pic_phone = in_val('supplier_pic_phone', 'any');
	$supplier_npwp = in_val('supplier_npwp', 'any');
	
	$supplier_address = in_val('supplier_address', 'any');
	$supplier_bank = in_val('supplier_bank', 'any');
	$supplier_bank_account = in_val('supplier_bank_account', 'any');
	$supplier_bank_rekening = in_val('supplier_bank_rekening', 'any');

	$remark_pemohon = in_val('remark_pemohon', 'any');		
	}

$load = 1 ;	

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
<script src="dist/js/jquery.autocomplete.min.js"></script>	
<script type="text/javascript">
            $(document).ready(function() {
                // Selector input yang akan menampilkan autocomplete.
                $( "#student_name" ).autocomplete({
                    serviceUrl: "student_list.php",   // Kode php untuk prosesing data.
                    dataType: "JSON",           // Tipe data JSON.
                    onSelect: function (suggestion) {
                        $( "#student_name" ).val("" + suggestion.student_name);
                    }
                });
            })
        </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

     <form name="form1" action="#"  enctype="multipart/form-data" method="post"><?php echo csrf_field(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><h2>Incentive Claim<span class="form-group">
                <input type="text" class="form-control" placeholder="Enter ..." name="incentive_id" value="<?php echo  e($incentive_id) ?>" readonly>
 <input type="text" class="form-control" placeholder="Enter ..." name="incentive_claim" value="<?php echo  e($incentive_claim) ?>" readonly>				  
              </span></h2>
              </h3>
            </div>
		  </div>
	    </div>
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="col-md-6">
                <div class="form-group">
                <label for="exampleInputEmail2">Name</label>
                <input type="text" name="nama_pemohon" class="form-control" id="exampleInputEmail2" placeholder="Your Name" value="<?php echo e($nama_pemohon) ?>">
              </div>					  
			  </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail4">NPWP</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="npwp" value="<?php echo  e($npwp) ?>">
                </div>
              </div>
				  <div class="col-md-6">
				    <div class="form-group">
				      <label for="exampleInputEmail6">E-Mail</label>
				      <input type="email" name="email_pemohon" class="form-control" id="exampleInputEmail6" placeholder="Your Email" value="<?php echo e($email_pemohon) ?>">
			        </div>
		      </div>
			  <div class="col-md-6">
				    
			    <div class="form-group">
               <label for="exampleInputPassword1">Department</label>
                <select class="form-control select2" style="width: 100%;" name="department">
                  <option value="Marketing and Sales">Marketing and Sales</option>
                  <option value="Opr - Academic">Opr - Academic</option>
                  <option value="Opr - IT">Opr - IT</option>
                  <option value="Opr - HR">Opr - HR</option>
                  <option value="Opr - GA">Opr - GA</option>
                  <option value="Accounting">Accounting</option>
            		<option selected><?php echo e($department) ?></option>						
                </select>
              </div>					  
		      </div>
			  <div class="col-md-6">
			    <div class="form-group">
			      <label for="exampleInputPassword2">Center</label>
			      <select class="form-control select2" style="width: 100%;" name="kd_cbg">
				  <option value="0">--CHOOSE--</option>
				  <option value="001">East Sby</option>
				  <option value="002">West Sby</option>
				  <option value="003">Denpasar</option>
				  <option value="008">Malang</option>
				  <option value="101">East Area</option>
				  <option value="004">South Jkt</option>
				  <option value="005">North Jkt</option>
				  <option value="006">West Jkt</option>
				  <option value="011">PIK</option>
				  <option value="012">Serpong</option>					  
				  <option value="007">Bandung</option>
				  <option value="102">West Area</option>
				  <option value="100">Online</option>
				  <option value="000">HO</option>				  
            		<option selected><?php echo e($cabang) ?></option>	
		          </select>
		        </div>
		      </div>
			  <div class="col-md-6">
			    <div class="form-group">
			      <label for="exampleInputPassword3">Core Businness</label>
			      <select class="form-control select2" style="width: 100%;" name="core">
			        <option value="0">--CHOOSE--</option>
			        <option value="All">All</option>
			        <option value="VOS">VOS</option>
			        <option value="VE">VE</option>
			        <option value="VPRO">VPRO</option>
			        <option value="LIU">LIU</option>
			        <option value="NCUK">NCUK</option>
           			 <option selected><?php echo e($core) ?></option>	
		          </select>
		        </div>
		      </div>
			  <div class="col-md-6">
			    <div class="form-group">
			    <label for="exampleInputPassword2">Proposed To</label>
			    <select class="form-control select2" style="width: 100%;" name="proposedto"  onChange="this.form.submit()">
			      <?php
				$query_proposedto = q_set($__p_query_proposedto, "SELECT nama_detail FROM tb_user where spv = 1 group by nama_detail order by nama_detail");
				$resource_proposedto = db_query_or_die('errro_7', $query_proposedto, $__p_query_proposedto ?? []);
				while ($row_proposedto=  db_fetch($resource_proposedto, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_proposedto[0]).'">'.e($row_proposedto[0]).'</option>';
					}      
				?>
			      <option selected><?php echo  e($proposedto) ?></option>
			      </select>
			    </div>
			  </div>
			<div class="col-md-6">
			  <div class="form-group">
			    <label for="exampleInputEmail14">E-Mail</label>
			    <input type="email" name="email_tujuan" class="form-control" id="email_tujuan" placeholder="Supervisor Email" value="<?php echo e($email_tujuan) ?>">
		      </div>
			  </div>
			
					


            </div>
              <!-- /.box-body -->

              
          
          </div>
        </div>
		  <?php if (num($sdh_dibuat) == 1){ ?>	  

		  
        <div class="col-md-8">
		<div class="box">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=3% height="14" align=center >No</td>
	            <td width=9% align=center >Day - Date</td>
	            <td width=51% align=center >Event</td>
	            <td width=10% align=center >Duration</td>
	            <td width=13% align=center >Remarks</td>
	            <td width=14% align=center >Action</td>

              </tr>
            </thead>
<?php
$query_trip_dtl = q_set($__p_query_trip_dtl, "SELECT t.tanggal_mulai, t.trip_jns, t.tanggal_mulai, t.tanggal_selesai, t.trip_keterangan, t.id FROM ves_data.trip_incentive_dtl t where id_trip = ? ", [(string) ($incentive_id)]);
$resource_trip_dtl = db_query_soft($query_trip_dtl, $__p_query_trip_dtl ?? []);
if(num(db_num_rows($resource_trip_dtl)) > 0)
	{
	$angka_item = 1;	
	while ($row_trip_dtl  =  db_fetch($resource_trip_dtl, PDO::FETCH_NUM))
		{
		
	
?>	
	          <tr>
	            <td height="14" align=center class="style24"><?php echo e($angka_item) ?></td>
	            <td align=left class="style24"><?php echo e($row_po_item[1]) ?> - <?php echo e($row_po_item[6]) ?></td>
	            <td align=right class="style24"><?php echo e($row_po_item[5]) ?> <?php echo e($row_po_item[2]) ?></td>
	            <td align=center class="style24"><?php echo e($row_po_item[4]) ?></td>
	            <td align=center class="style24"><?php echo e($row_po_item[5]) ?> <?php echo e($amount_after_tax) ?></td>
	            <td align=center class="style24"><a href="" onClick="return popitup('po_del_item.php?id=<?php echo e(u($row_po_item[3])) ?>')"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
<?php $angka_item = num($angka_item) + 1; }} ?>			  

		    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
		
        </div></div>
<?php } ?> 
<?php if (num($item_ada) == 0){ ?>		  
        <div class="col-md-8">
          <!-- Horizontal Form -->
          <div class="box"><div class="box-body">
			<div class="box-header with-border">
			  <h3 class="box-title">Add Date Trip</h3>
			</div>
			<div class="col-md-4">
			  <div class="form-group">
			    <label for="exampleInputEmail3">Date</label>
			    <input type="DATE" class="form-control" placeholder="Enter ..." name="tgl" value="<?php echo  e($tgl) ?>">
		      </div>
		    </div>
			<div class="col-md-8">	

				  <div class="form-group">
				    <label for="exampleInputEmail15">Type</label>
				    <select class="form-control select2" style="width: 80%;" name="jenis_trip">
                  <option value="Bussiness Trip Dalam Negeri">Bussiness Trip Dalam Negeri</option>
                  <option value="Bussiness Trip Luar Negeri">Bussiness Trip Luar Negeri</option>						
                  <option value="Event Dalam Kota">Event Dalam Kota</option>
                  <option value="Event Luar Kota">Event Luar Kota</option>
						
                  <option value="USD">USD</option>
            		<option selected><?php echo e($jenis_trip) ?></option>						
                </select>
			      </div>
				  </div>
			<div class="col-md-8">
			  <div class="form-group">
			    <label for="exampleInputEmail7">City Destination</label>
			    <select class="form-control select2" style="width: 80%;" name="city_destination">
			      <option value="Surabaya">Surabaya</option>
			      <option value="Jakarta">Jakarta</option>
			      <option value="Bandung">Bandung</option>
			      <option value="Bali">Bali</option>
			      <option value="Malang">Malang</option>					
			      <option value="Other">Other</option>
			      <option selected><?php echo e($city_destination) ?></option>
		        </select>
		      </div>
		    </div>
			<div class="col-md-12">
			  <div class="form-group">
				<label for="exampleInputEmail5">Description</label>
				<textarea name="trip_keterangan" rows="3" class="form-control" placeholder="Enter ..." ><?php echo  e($trip_keterangan) ?></textarea>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-group">
			    <label for="exampleInputEmail12"></label>
			    			<div class="box-footer">
				  <button type="submit" class="btn btn-primary"   name="AddItem" value="AddItem">Save Item</button>
			  </div>
		      </div>
		    </div>

			</div> 
            <!-- /.bodfx-header -->
</div>
        </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->
      </div>
<?php } ?>	
    
		<div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Supporting Document</h3>
        </div>
        <table width="100%" class="table table-bordered table-striped" id="example2">
          <thead>
            <tr>
              <td width=12% align=center >Document</td>
              <td width=14% align=center >Action</td>
            </tr>
          </thead>
          <?php
$query_file = q_set($__p_query_file, "SELECT id, kode, nama_file, COALESCE(NULLIF(nama_asli, ''), nama_file) FROM purchase_order_file where kode = ? order by id", [(string) ($kode_po)]);

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
if(num(db_num_rows($resource_file)) > 0){
	
	while ($row_file  =  db_fetch($resource_file, PDO::FETCH_NUM))
		{
?>
          <tr>
            <td align=left class="style24"><?php echo e($row_file[3]) ?></td>
            <td align=center class="style24"><a href="" onClick="return popitup('po_view_img.php?id=<?php echo e(u($row_file[0])) ?>&kd=<?php echo e(u($row_file[1])) ?>')"><span class="glyphicon glyphicon-eye-open"></span></a> <a href="" onClick="return popitup('po_del_img.php?id=<?php echo e(u($row_file[0])) ?>&kd=<?php echo e(u($row_file[1])) ?>')"><span class="glyphicon glyphicon-remove"></span></a></td>
          </tr>
          <?php }} ?>
    </tbody>
  
  <tfoot>
  </tfoot>
        </table>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post"><?php echo csrf_field(); ?>


        <!-- /.box-body -->
        <!-- /.box-footer -->
        </div>
        <!-- /.box -->
        <!-- general form elements disabled -->
        <!-- /.box -->
        <?php if ($kode_po != ''){?>			
		<div class="box-footer">

<a href="po_upload_file.php?kp=<?php echo e(u($kode_po)); ?>&cp=<?php echo e(u($corporate)) ?>" target="popup" onclick="window.open('po_upload_file.php?kp=<?php echo e(u($kode_po)); ?>','popup','width=1000,height=800'); return false;"><button>Upload Supporting Document</button></a>	
		</div>		
        <?php } ?>			

		<div class="col-md-6">
		  <div class="form-group">
		    <label for="exampleInputPassword4">Payment Metodh</label>
		    <select class="form-control select2" style="width: 100%;" name="pay_mtd">
			      <option value="Cash">Cash</option>	      
			      <option value="Transfer">Transfer</option>	      
			      <option value="Debit Card">Debit Card</option>	      
			      <option value="Credit Card">Credit Card</option>	      
						      <option value="Virtual Account">Virtual Account</option>	  	
		      <option selected><?php echo  e($pay_mtd) ?></option>
	        </select>
	      </div>
	    </div>        </div>
		<div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box">
<?php if (num($item_ada) == 1 and num($file_ada) ==1){ ?>				
	<div class="box-footer">
		<button type="submit" class="btn btn-primary"   name="generate" value="generate">Generate PO</button>
	
		  </div>
<?php } ?>					
	    </div></div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
	
  </div>
			
	</form>
	<?php 
if (isset($_GET['Upload'])) 
{
$kode_po = in_val('kode_po', 'any');	
$statusMsg = '';

//file upload path
$targetDir = "po_docs/";
$fileName = upload_random_name('file');
echo e($fileName);die;	
$targetFilePath = $targetDir . $fileName;

$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_GET["Upload"]) && !empty($_FILES["file"]["name"])) 
	{

	// file formats yang diperbolehkan
	$allowTypes = array('jpg','png','jpeg','gif','pdf');
	if(in_array($fileType, $allowTypes))
		{
		//upload file to server
		if(upload_move('file', upload_allow('jpg', 'png', 'jpeg', 'gif', 'pdf'), $targetFilePath, 5242880))
			{
			$statusMsg = "The file ".$fileName. " has been uploaded.";
			$query_insert_po_item = q_set($__p_query_insert_po_item, "insert into purchase_order_file (kode, nama_file, nama_asli)  values (? ,?  ,? )", [(string) ($kode_po), (string) ($fileName), upload_display_name('file')]);	
			$resource_urut_po_item = db_query_or_die('errro_2', $query_insert_po_item, $__p_query_insert_po_item ?? []);				
			}
		else
			{
			$statusMsg = "Sorry, there was an error uploading your file.";
			}
		}
	else
		{
		$statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
		}
	}
else
	{
    $statusMsg = 'Please select a file to upload.';
	}	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('" . e($statusMsg) . "');\n";
		echo "window.location = ('po_entry.php?kode_po=" . e(u($kode_po)) . "');\n";				
		echo "</script>";	
}

?>		
	<?php 
	
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['AddItem']))) 
{
	
$fullurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$kode_po = in_val('kode_po', 'any');	
$kd_cbg = in_val('kd_cbg', 'any');
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
if ($kd_cbg == 'HO'){$kd_cbg = '000';}	
$tanggal_hari_ini = date("Y-m-d h:i:sa");	
$incentive_id = in_val('incentive_id', 'any');
$incentive_claim = in_val('incentive_claim', 'any');
$npwp = in_val('npwp', 'any');
$email_pemohon = in_val('email_pemohon', 'any');
$department = in_val('department', 'any');
$kd_cbg = in_val('kd_cbg', 'any');
$core = in_val('core', 'any');
$proposedto = in_val('proposedto', 'any');
$email_tujuan = in_val('email_tujuan', 'any');
$tgl = in_val('tgl', 'any');
$jenis_trip = in_val('jenis_trip', 'any');
$keterangan = in_val('keterangan', 'any');

$nama_pemohon = $_SESSION['nama_lengkap'];
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
if ($incentive_claim =='')
	{
	$query_insert_incentive = q_set($__p_query_insert_incentive, "insert into ves_data.trip_incentive ( id_trip, kd_emp, nama_pemohon, npwp, email_pemohon, department, core, kd_cbg, proposedto, email_tujuan, status_trip, dt_entry) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,'0',? )", [(string) ($incentive_id), (string) ($kd_staff), (string) ($nama_pemohon), (string) ($npwp), (string) ($email_pemohon), (string) ($department), (string) ($core), (string) ($kd_cbg), (string) ($proposedto), (string) ($email_tujuan), (string) ($tanggal_hari_ini)]);
	$resource_insert_incentive = db_query_or_die('errro_insert', $query_insert_incentive, $__p_query_insert_incentive ?? []);	
	$tgl = in_val('tgl', 'any');
	$jenis_trip = in_val('jenis_trip', 'any');
	$city_destination = in_val('city_destination', 'any');
	$trip_keterangan = in_val('trip_keterangan', 'any');
	$query_insert_incentive_dtl = q_set($__p_query_insert_incentive_dtl, "insert into ves_data.trip_incentive_dtl (id_trip, kd_emp, tanggal, trip_jns, trip_keterangan, trip_dtl_status) values (? ,? ,? ,? ,? ,0)", [(string) ($incentive_id), (string) ($kd_staff), (string) ($tgl), (string) ($jenis_trip), (string) ($trip_keterangan)]);
	$resource_insert_incentive_dtl = db_query_or_die('errro_insert', $query_insert_incentive_dtl, $__p_query_insert_incentive_dtl ?? []);
			echo "<script type=\"text/javascript\">\n";
		echo "alert('New Item');\n";
		echo "window.location = ('incentive_entry.php?incentive_id=" . e(u($incentive_id)) . "');\n";				
		echo "</script>";
	}


}
?>	
	<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate']))) 
{
$nilai = 1;
$tahun=date("y");	
$saat_ini = date('Y-m-d H:i:s');	
$nama_pemohon = in_val('nama_pemohon', 'any');
$proposedto = in_val('proposedto', 'any');	
$email_pemohon = in_val('email_pemohon', 'any');	
$corporate = in_val('corporate', 'any');
if ($corporate == '')
	{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Corporate Must Choosed,please push back button on your browser');\n";
		echo "</script>";		
		$nilai = 0;
	}
$query_cek_email_pemohon = q_set($__p_query_cek_email_pemohon, "SELECT e_mail FROM tb_user where nama_detail = ? ", [(string) ($nama_pemohon)]);	
$resource_cek_email_pemohon = db_query_or_die('errro_1av', $query_cek_email_pemohon, $__p_query_cek_email_pemohon ?? []);
if (num(db_num_rows($resource_cek_email_pemohon)) > 0)
	{
	while ($row_email_pemohon=  db_fetch($resource_cek_email_pemohon, PDO::FETCH_NUM))
		{
		$email_pemohon_tersedia = $row_email_pemohon['0'];			
		}
	}
if ($email_pemohon != '' and $email_pemohon_tersedia == '')
	{
	$query_cek_email_pemohon = q_set($__p_query_cek_email_pemohon, "update tb_user set e_mail = ? where nama_detail = ? ", [(string) ($email_pemohon), (string) ($nama_pemohon)]);	
	$resource_cek_email_pemohon = db_query_or_die('errro_1j', $query_cek_email_pemohon, $__p_query_cek_email_pemohon ?? []);
	}
	

$email_tujuan	= in_val('email_tujuan', 'any');
$query_cek_email_tujuan = q_set($__p_query_cek_email_tujuan, "SELECT e_mail FROM tb_user where nama_detail = ? ", [(string) ($email_tujuan)]);	
$resource_cek_email_tujuan = db_query_or_die('errro_1t', $query_cek_email_tujuan, $__p_query_cek_email_tujuan ?? []);
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
		$nilai = 0;
	}
elseif ($email_tujuan != '' and $email_tujuan_tersedia == '')
	{
	$query_cek_email_tujuan = q_set($__p_query_cek_email_tujuan, "update tb_user set e_mail = ? where nama_detail = ? ", [(string) ($email_tujuan), (string) ($proposedto)]);	
	$resource_cek_email_tujuan = db_query_or_die('errro_1u', $query_cek_email_tujuan, $__p_query_cek_email_tujuan ?? []);
	}
elseif ($email_tujuan == '' and $email_tujuan_tersedia != '')
	{
$email_tujuan = $email_tujuan_tersedia;
	}	
$kd_staff = $_SESSION['kd_staff'];	
$kode_po_sementara = in_val('kode_po', 'any');
$nama_pemohon = in_val('nama_pemohon', 'any');
	$email_pemohon = in_val('email_pemohon', 'any');
	$proposedto = in_val('proposedto', 'any');
	$email_tujuan = in_val('email_tujuan', 'any');	
	$department = in_val('department', 'any');
	$peruntukan = in_val('peruntukan', 'any');
	$dt_po = in_val('dt_po', 'any');
	$dt_due_po = in_val('dt_due_po', 'any');
	$file_doc = in_val('file_doc', 'any');
	$order_cost = in_val('order_cost', 'any');
	$po_amount = in_val('po_amount', 'any');
	$pph_persen = in_val('pph_persen', 'any');	
	$supplier_name = in_val('supplier_name', 'any');
	$supplier_phone = in_val('supplier_phone', 'any');
	$supplier_npwp = in_val('supplier_npwp', 'any');
	$supplier_pic = in_val('supplier_pic', 'any');
	$supplier_pic_phone = in_val('supplier_pic_phone', 'any');
	$supplier_npwp = in_val('supplier_npwp', 'any');
	
	$supplier_address = in_val('supplier_address', 'any');
	$supplier_bank = in_val('supplier_bank', 'any');
	$supplier_bank_account = in_val('supplier_bank_account', 'any');
	$supplier_bank_rekening = in_val('supplier_bank_rekening', 'any');
	$email_pemohon = in_val('email_pemohon', 'any');
	$email_tujuan = in_val('email_tujuan', 'any');
	$remark_pemohon = in_val('remark_pemohon', 'any');	
	$pay_mtd = in_val('pay_mtd', 'any');	
$query_urut_po = q_set($__p_query_urut_po, "SELECT kode FROM ves_data.purchase_order where yr_po = ? and corporate = ? and po_status <> 0 order by id desc limit 1 ", [(string) ($tahun), (string) ($corporate)]);	
	$resource_urut_po = db_query_or_die('errro_31', $query_urut_po, $__p_query_urut_po ?? []);
	if (num(db_num_rows($resource_urut_po)) > 0)
		{
		while ($row_urut_po=  db_fetch($resource_urut_po, PDO::FETCH_NUM))
			{
			$kode_nomor = $row_urut_po[0];
			$ambilangka =  substr($kode_nomor,-4,4);

			#ketemu angka awal(angka sebelumnya) + dengan 1
			$nextangka=num($ambilangka)+1;
			#menhitung jumlah karakter
			$digit=strlen($nextangka);
			if(!$kode_nomor){ $nol='0000'; }elseif(num($digit)==1){ $nol='0000'; }	elseif(num($digit)==2){ $nol='000'; }	elseif(num($digit)==3){ $nol='00'; }	elseif(num($digit)==4){ $nol='0'; }
			$kode_urut_po = $corporate.$tahun.$kd_staff.$nol.$nextangka;	
			}	
		}
	else
		{
		$kode_urut_po = $corporate.$tahun.$kd_staff.'00001';
		}
if (num($nilai) == 1)
{	
$query_update_po_item = q_set($__p_query_update_po_item, "update ves_data.purchase_order_item set kode = ? where kode = ? ", [(string) ($kode_urut_po), (string) ($kode_po_sementara)]);	
$resource_update_po_item = db_query_or_die('errro_1i', $query_update_po_item, $__p_query_update_po_item ?? []);
	
$query_update_po_file = q_set($__p_query_update_po_file, "update ves_data.purchase_order_file set kode = ? where kode = ? ", [(string) ($kode_urut_po), (string) ($kode_po_sementara)]);	
$resource_update_po_file = db_query_or_die('errro_1p', $query_update_po_file, $__p_query_update_po_file ?? []);		
	
$query_update_po = q_set($__p_query_update_po, "update ves_data.purchase_order set po_status = 1, email_pemohon = ? ,email_tujuan = ? ,pic = ? ,dt_entry = ? ,nama_pemohon = ? , department = ? , peruntukan = ? , dt_po = ? , dt_due_po = ? , supplier_name = ? , supplier_phone = ? , supplier_address = ? , supplier_bank = ? , supplier_bank_account = ? , supplier_bank_rekening = ? , approved_by = ? ,email_pemohon = ? , email_tujuan = ? ,kd_branch = ? , corporate = ? , supplier_pic = ? , supplier_pic_phone = ? , supplier_npwp = ? ,yr_po = ? ,remark_pemohon = ? ,kode= ? ,pay_mtd = ? where kode = ? ", [(string) ($email_pemohon), (string) ($email_tujuan), (string) ($nama_pemohon), (string) ($saat_ini), (string) ($nama_pemohon), (string) ($department), (string) ($peruntukan), (string) ($dt_po), (string) ($dt_due_po), (string) ($supplier_name), (string) ($supplier_phone), (string) ($supplier_address), (string) ($supplier_bank), (string) ($supplier_bank_account), (string) ($supplier_bank_rekening), (string) ($proposedto), (string) ($email_pemohon), (string) ($email_tujuan), (string) ($kd_cbg), (string) ($corporate), (string) ($supplier_pic), (string) ($supplier_pic_phone), "\$" . (string) ($supplier_npwp), (string) ($tahun), (string) ($remark_pemohon), (string) ($kode_urut_po), (string) ($pay_mtd), (string) ($kode_po_sementara)]);	
$resource_update_po = db_query_or_die('errro_1q', $query_update_po, $__p_query_update_po ?? []);	
$query_log = q_set($__p_query_log, "insert into ves_data.purchase_order_log (kode, dt_entry, po_status, pic, remark)values(? ,? ,'1',? ,? )", [(string) ($kode_po), (string) ($saat_ini), (string) ($nama_pemohon), (string) ($remark_pemohon)]);	
$resource_log = db_query_or_die('errro_1h', $query_log, $__p_query_log ?? []);	
//====kirim email mulai
$belum = 0 ;	
if (num($belum) != 0)
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
	
//$ua = new UserAgent();

//if site is accessed from mobile, then redirect to the mobile site.

		echo "<script type=\"text/javascript\">\n";
//		echo "window.location = ('purchasinglist.php');\n";	
		echo "window.open('purchasinglist.php','_self');\n";
		echo "</script>";}
	

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
</body>
</html>
