<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_pemohon = $_SESSION['nama_lengkap'];

$check_tax_item = in_val('st_tax', 'get');
$supplier_name = in_val('supplier_name', 'get');

$corporate = in_val('cp', 'get');
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
$query_po = q_set($__p_query_po, "SELECT kode, nama_pemohon, department, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by,email_pemohon,email_tujuan,kd_branch,corporate, supplier_pic,supplier_pic_phone,supplier_npwp,supplier_kd,remark_pemohon   FROM ves_data.purchase_order where kode = ? order by id desc limit 1 ", [(string) ($kode_po)]);	

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
	echo e($nama_detail);
	$email_pemohon = $row_po['13'];		
	$email_tujuan = $row_po['14'];
	$kd_cbg = $row_po['15'];	
	$corporate = $row_po['16'];
	
	$supplier_kd 	 = $row_po['20'];
	$remark_pemohon 	 = $row_po['21'];		
	
	$query_supplier = q_set($__p_query_supplier, "SELECT p.sup_name, p.sup_phone, p.sup_npwp, p.sup_pic, p.sup_pic_phone, p.sup_address, p.sup_bank, p.sup_bank_account, p.sup_rekening FROM ves_data.purchase_supplier p where id = ? ", [(string) ($supplier_kd)]);
	$resource_supplier = db_query_or_die('errro_21', $query_supplier, $__p_query_supplier ?? []);
	if (num(db_num_rows($resource_supplier)) > 0)
		{
		while ($row_sup=  db_fetch($resource_supplier, PDO::FETCH_NUM))
			{
			$sup_ada = 1;
			$supplier_name = $row_sup['0'];
			$supplier_phone = $row_sup['1'];
			$supplier_address = $row_sup['5'];
			$supplier_bank = $row_sup['6'];
			$supplier_bank_account = $row_sup['7'];
			$supplier_bank_rekening = $row_sup['8'];
			$supplier_pic = $row_sup['3'];
			$supplier_pic_phone = $row_sup['4'];
			$supplier_npwp 	 = $row_sup['2'];
			}
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
$item_ada = 0;
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount,id, tax_ori FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
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
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PO Number : <?php echo e($kode_po) ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">	
    <script type="text/javascript" src="cdnjs/jquery.min.js"></script> 
    <link type="text/css" href="js-lib/jquery-ui.css" rel="stylesheet"> 

    <script type="text/javascript" src="sign_script/js/jquery-ui.min.js"></script>
  <!-- Ionicons -->
 
    <script type="text/javascript" src="sign_script/js/jquery.signature.min.js"></script>
    <link rel="stylesheet" type="text/css" href="sign_script//css/jquery.signature.css">
    <style>
        .kbw-signature { width: 400px; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>		
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php // include ('left.php') ?>
     <form name="form1" method="post" action="#"  enctype="multipart/form-data"><?php echo csrf_field(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Purchase Order</h1>
          <span class="form-group">
          <input type="text" name="kode_po" class="form-control" id="exampleInputEmail" value="<?php echo e($kode_po) ?>" readonly>
        <div class="form-group">
          <label for="exampleInputPassword5">Corporate</label>
          <select class="form-control select2" style="width: 100%;" name="corporate">
            <option value selected><?php echo e($corporate) ?></option>
            <option value="VIC">VIC</option>
            <option value="VOS">VOS</option>
            <option value="VE">VE</option>
            <option value="LIUMEDIA">LIUMEDIA</option>
            <option value="VPRO">VPRO</option>
            <option value="OTHER">OTHER</option>
            <option value="Other">Other</option>
          </select>
        </div>			  
      </span>
      <div class="col-md-6">

      </div>
      <h1><span class="form-group">      </span></h1>
    </section>

    <!-- Main content -->
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
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="col-md-6">
                <div class="form-group">
                <label for="exampleInputEmail2">Name</label>
                <input type="text" name="nama_pemohon" class="form-control" id="exampleInputEmail2" placeholder="Your Name" value="<?php echo e($nama_pemohon) ?>" readonly>
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

                  <option value="Sales">Sales</option>
                  <option value="Accounting">Accounting</option>
                  <option value="Academic">Academic</option>
                  <option value="HR">HR</option>
                  <option value="GA">GA</option>
                  <option value="IT">IT</option>
                  <option value="Other">Other</option>	
			        <option selected="selected"><?php echo e($department) ?></option>				
                </select>
              </div>					  
			    </div>
			  <div class="col-md-6">
			    <div class="form-group">
			      <label for="exampleInputPassword3">Center</label>
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
			        <option value="007">Bandung</option>
			        <option value="102">West Area</option>
			        <option value="100">Online</option>
			        <option value="000">HO</option>
			        <option selected="selected"><?php echo e($cabang) ?></option>
		          </select>
		        </div>
		      </div>
			  <div class="col-md-12">				  
				<div class="form-group">
				<label for="exampleInputEmail1">Peruntukan</label>
				<textarea class="form-control" rows="3" placeholder="Enter ..." name="peruntukan"><?php echo e($peruntukan) ?></textarea>
				</div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
			    <label for="exampleInputPassword2">Proposed To</label>
			    <select class="form-control select2" style="width: 100%;" name="proposedto">
			      <?php
				$query_proposedto = q_set($__p_query_proposedto, "SELECT nama_detail FROM tb_user where nama_detail <> '' and aktif = 'Y' group by nama_detail order by nama_detail");
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
			    <label for="exampleInputEmail8">E-Mail</label>
			    <input type="email" name="email_tujuan" class="form-control" id="exampleInputEmail8" placeholder="Supervisor Email" value="<?php echo e($email_tujuan) ?>">
			    </div>
			  </div>
			<div class="col-md-6">
			  <div class="form-group">
			    <label for="exampleInputEmail25">Purchase Date</label>
			    <input type="date" class="form-control" id="exampleInputEmail25" placeholder="Your Name" name="dt_po" value="<?php echo e($dt_po) ?>">
			    </div>
			  </div>
			<div class="col-md-6">
				    <div class="form-group">
				      <label for="exampleInputEmail3">Due Date</label>
				      <input type="date" class="form-control" id="exampleInputEmail3" placeholder="Your Name" name="dt_due_po" value="<?php echo e($dt_due_po) ?>">
		        </div>
		      </div>
            </div>
              <!-- /.box-body -->

              
          
          </div>
          <!-- /.box -->

          <!-- Form Element sizes --><!-- /.box --><!-- /.box -->

          <!-- Input addon --><!-- /.box -->

        </div>
        <div class="col-md-6">
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
                <td align=center class="style24"><a href="" onClick="return popitup('po_view_img.php?id=<?php echo e(u($row_file[0])) ?>&kd=<?php echo e(u($row_file[1])) ?>')"><span class="glyphicon glyphicon-eye-open"></span></a></td>
              </tr>
              <?php }} ?>
    </tbody>
  
  <tfoot>
  </tfoot>
            </table>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
            <?php if ($kode_po != ''){?>
<?php } ?>				
              <!-- /.box-body -->
              <!-- /.box-footer -->
   
          </div>
          <!-- /.box -->
          <!-- general form elements disabled --><!-- /.box -->
        </div>
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box">
              <div class="box-body">
                <div class="box-header with-border">
                  <h3 class="box-title">Supplier Info</h3>
                </div>
                <div class="col-md-12">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInputEmail19">Supplier Name</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="supplier_name" value="<?php echo  e($supplier_name) ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInputEmail20">Supplier Phone</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="supplier_phone" value="<?php echo  e($supplier_phone) ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInputEmail10">Supplier NPWP</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="supplier_npwp" value="<?php echo  e($supplier_npwp) ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInputEmail7">Supplier PIC</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="supplier_pic" value="<?php echo  e($supplier_pic) ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInputEmail9">PIC  Phone</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="supplier_pic_phone" value="<?php echo  e($supplier_pic_phone) ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail21">Address</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="supplier_address" value="<?php echo  e($supplier_address) ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInputEmail22">Bank</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="supplier_bank" value="<?php echo  e($supplier_bank) ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInputEmail23">A/N</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="supplier_bank_account" value="<?php echo  e($supplier_bank_account) ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInputEmail24">No Rek</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="supplier_bank_rekening" value="<?php echo  e($supplier_bank_rekening) ?>">
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
          <!-- /.box -->
          <!-- general form elements disabled -->
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <div class="box">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=4% height="14" align=center >No</td>
	            <td width=70% align=center >Order &amp; Cost</td>
	            <td width=12% align=center >Amount</td>
	            <td width=14% align=center >Tax</td>
	            <td width=14% align=center >Amount After Tax</td>
	            <td width=14% align=center >Action</td>

	            </tr>
            </thead>
<?php
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount,id, tax_ori FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
$resource_po_item = db_query_soft($query_po_item, $__p_query_po_item ?? []);
if(num(db_num_rows($resource_po_item)) > 0)
	{
	$angka_item = 1;	
	while ($row_po_item  =  db_fetch($resource_po_item, PDO::FETCH_NUM))
		{
		$amount_after_tax = num($row_po_item[2]) - num((num($row_po_item[2]) * num((num($row_po_item[4])/100))))
	
?>	
	          <tr>
	            <td height="14" align=center class="style24"><?php echo e($angka_item) ?></td>
	            <td align=left class="style24"><?php echo e($row_po_item[1]) ?></td>
	            <td align=right class="style24"><?php echo e($row_po_item[2]) ?></td>
	            <td align=center class="style24"><?php echo e($row_po_item[4]) ?></td>
	            <td align=center class="style24"><?php echo e($amount_after_tax) ?></td>
	            <td align=center class="style24"><a href="" onClick="return popitup('po_del_item.php?id=<?php echo e(u($row_po_item[3])) ?>')"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
<?php $angka_item = num($angka_item) + 1; }} ?>			  

		    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
          <div class="box">
            <div class="box-body">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail5">Purchasing Remark</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="supervisor_remark2" value="<?php echo  e($remark_pemohon) ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="box">
			<div class="box-body">
	    <div class="col-md-6">
	      <div class="form-group">
	        <label for="exampleInputEmail4">Supervisor Remark</label>
	        <input type="text" class="form-control" placeholder="Enter ..." name="supervisor_remark" value="<?php echo  e($supervisor_remark) ?>">
	        </div>
	      </div>
	    <div class="col-md-6">
	      <div class="form-group">
	        <label for="exampleInputEmail11">Digital Signature</label>
            <div id="sig" ></div>
            <br/>
            <button id="clear">Clear Signature</button>
            <textarea id="signature64" name="signed" style="display: none"></textarea>
	        </div>
	      </div>				
			  </div>
			</div>

	    <div class="box-footer">
<?php if ($proposedto == $_SESSION['nama_lengkap']){ ?>			
		<button type="submit" class="btn btn-primary"   name="approve" value="approve">Approve</button>		
		<button type="submit" class="btn btn-danger"   name="reject" value="reject">Reject</button>
<?php } ?>				
		<button type="submit" class="btn btn-primary"   name="generate" value="generate">Print PO</button>
		<button type="submit" class="btn btn-primary"   name="close" value="close">Close</button>			
		</div>
		
      </div></div>
		  
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
	</form>
	
	<?php 
if (isset($_POST['approve'])) 
{

	
	
$saat_ini = date('Y-m-d H:i:s');
$kode_po = in_val('kode_po', 'post');
$supervisor_remark = in_val('supervisor_remark', 'post');
	
$folderPath = "e_sign/po/";
$file = upload_save_dataurl((string) in_val('signed', 'post'), $folderPath);   // tipe dari isi, nama acak
if ($file === false) { exit('<script>alert(' . js(upload_error()) . '); history.back();</script>'); }	
	
$query_file = q_set($__p_query_file, "update purchase_order set po_status = 2, approved_dt = ? ,remark_supervisor = ? ,sign_approved = ? where kode = ? ", [(string) ($saat_ini), (string) ($supervisor_remark), (string) ($file), (string) ($kode_po)]);
$resource_file = db_query_soft($query_file, $__p_query_file ?? []);	
$query_log = q_set($__p_query_log, "insert into ves_data.purchase_order_log (kode, dt_entry, po_status, pic, remark)values(? ,? ,'2',? ,? )", [(string) ($kode_po), (string) ($saat_ini), (string) ($nama_lengkap), (string) ($supervisor_remark)]);	
$resource_log = db_query_or_die('errro_1', $query_log, $__p_query_log ?? []);	
echo "<script type=\"text/javascript\">\n";
echo "alert('PO sudah Anda Setujui');\n";
echo "window.open('po_print.php?kode_po=" . e(u($kode_po)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";					
echo "</script>";
}
if (isset($_POST['reject'])) 
{

$saat_ini = date('Y-m-d H:i:s');
$kode_po = in_val('kode_po', 'post');
$supervisor_remark = in_val('supervisor_remark', 'post');
$query_file = q_set($__p_query_file, "update purchase_order set po_status = 7, approved_dt = ? ,remark_supervisor = ? where kode = ? ", [(string) ($saat_ini), (string) ($supervisor_remark), (string) ($kode_po)]);
$resource_file = db_query_soft($query_file, $__p_query_file ?? []);	
$query_log = q_set($__p_query_log, "insert into ves_data.purchase_order_log (kode, dt_entry, po_status, pic, remark)values(? ,? ,'2',? ,? )", [(string) ($kode_po), (string) ($saat_ini), (string) ($nama_lengkap), (string) ($supervisor_remark)]);	
$resource_log = db_query_or_die('errro_1', $query_log, $__p_query_log ?? []);		
echo "<script type=\"text/javascript\">\n";
echo "alert('PO sudah Anda Tolak');\n";
echo "window.open('po_print.php?kode_po=" . e(u($kode_po)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";					
echo "</script>";
}
?>	
	<?php 
if (isset($_POST['generate'])) 
{
$mbl = $_SESSION['mbl'];

if (num($mbl) ==1) 
	{ 
		echo "<script type=\"text/javascript\">\n";
echo "window.open('po_print_mobile.php?kode_po=" . e(u($kode_po)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
		echo "</script>";	

	}	
else
{echo "<script type=\"text/javascript\">\n";
echo "window.open('po_print.php?kode_po=" . e(u($kode_po)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";					
echo "</script>";	}	
}


?>	
	<?php 
if (isset($_POST['Close'])) 
{
echo "<script type=\"text/javascript\">\n";
echo "window.close();\n";					
echo "</script>";
}

?>
</div>
<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>

</body>
</html>
