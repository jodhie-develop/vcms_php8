<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
 include __DIR__ . "/../atas.php";
//include __DIR__ . "/left.php";
$st = $_GE['st'];
$nama_lengkap = $_SESSION['nama_lengkap'];

$kode_po = in_val('kode_po', 'get');
$id_po = in_val('id_po', 'get');
$corporate = in_val('corporate', 'get');
$upd = in_val('upd', 'get');
$_GET['upd'] = $upd;
$query_po = q_set($__p_query_po, "SELECT kode,nama_pemohon,email_pemohon,department,kd_branch,peruntukan,approved_by,email_tujuan,dt_po,dt_due_po,supplier_name,supplier_phone,supplier_npwp,supplier_pic,supplier_pic_phone,supplier_address,supplier_bank,supplier_bank_account,supplier_bank_rekening,ack_by,ack_date,tax_by,tax_date,paid_by,paid_date, po_status,corporate,supplier_kd,remark_pemohon, remark_supervisor,remark_acc_1,remark_tax,core,kd_biodata   FROM ves_data.purchase_order where id = ? order by id desc limit 1 ", [(string) ($id_po)]);	

$resource_po = db_query_or_die('errro_1', $query_po, $__p_query_po ?? []);
if (num(db_num_rows($resource_po)) > 0)
{
while ($row_po=  db_fetch($resource_po, PDO::FETCH_NUM))
	{
$kode_po = $row_po['0'];
$kode_po_ori = $row_po['0'];	
$nama_pemohon = $row_po['1'];
$email_pemohon = $row_po['2'];
$department = $row_po['3'];
$kd_cbg = $row_po['4'];
$peruntukan = $row_po['5'];
$proposedto = $row_po['6'];
$email_tujuan = $row_po['7'];
$dt_po = $row_po['8'];
$dt_due_po = $row_po['9'];
$supplier_name = $row_po['10'];
$supplier_phone = $row_po['11'];
$supplier_npwp = $row_po['12'];
$supplier_pic = $row_po['13'];
$supplier_pic_phone = $row_po['14'];
$supplier_address = $row_po['15'];
$supplier_bank = $row_po['16'];
$supplier_bank_account = $row_po['17'];
$supplier_bank_rekening = $row_po['18'];
$ack_by = $row_po['19'];
$ack_date = $row_po['20'];
$tax_by = $row_po['21'];
$tax_date = $row_po['22'];
$paid_by = $row_po['23'];
$paid_date = $row_po['24'];
$po_status = $row_po['25'];
$corporate_ori = $row_po['26'];
$supplier_kd 	 = $row_po['27'];	
$remark_pemohon 	 = $row_po['28'];		
$remark_supervisor	 = $row_po['29'];		
$acc_1_remark	 = $row_po['30'];
$tax_remark	 = $row_po['31'];	
$core	 = $row_po['32'];
$kd_biodata = $row_po['33'];
	if ($kd_biodata != '')
		{
		$query_student = q_set($__p_query_student, "SELECT concat(nama,' ', middle_name,' ', family_name ) from ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($kd_biodata)]);	
		$resource_student = db_query_or_die('errro_1', $query_student, $__p_query_student ?? []);
		if (num(db_num_rows($resource_student)) > 0)
		{
		while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
			{		
			$nama_student = $row_student[0];	
			}
		}
		}	
	
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
	
}
	$order_cost = $row_po[''];
	$po_amount = $row_po[''];


if ($kd_cbg == 'National'){$kd_cbg = '000';}
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
elseif ($kd_cbg == 'National'){$kd_cbg = '000';}
elseif ($kd_cbg =='100'){$cabang = 'Online';}
elseif (num($kd_cbg) ==000){$cabang = 'National';}
elseif (num($kd_cbg) ==001){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==002){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==003){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==004){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==005){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==006){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==007){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang';}
elseif (num($kd_cbg) ==101){$cabang = 'East Area';}
elseif (num($kd_cbg) ==102){$cabang = 'West Area';}

if ($corporate == ''){$corporate = $corporate_ori;}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PO Number : <?php echo e($kode_po) ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">

     <form name="form1" method="post" action="#"  enctype="multipart/form-data"><?php echo csrf_field(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Purchase Request</h1>
          <span class="form-group">
          <input type="hidden" name="id_po" class="form-control" id="exampleInputEmail" value="<?php echo e($id_po) ?>" readonly>
          <input type="text" name="kode_po" class="form-control" id="exampleInputEmail5" value="<?php echo e($kode_po) ?>" readonly>
          <input type="hidden" name="kode_po_ori" class="form-control" id="exampleInputEmail9" value="<?php echo e($kode_po_ori) ?>" readonly>
          <input type="hidden" name="corporate_ori" class="form-control" id="exampleInputEmail4" value="<?php echo e($corporate_ori) ?>" readonly>
          <input type="hidden" name="supplier_kd" class="form-control" id="exampleInputEmail7" value="<?php echo e($supplier_kd) ?>" readonly>
        <div class="form-group">
          <label for="exampleInputPassword5">Corporate</label>
          <select class="form-control select2" style="width: 100%;" name="corporate">

            <option value="VIC">VIC</option>
            <option value="VOS">VOS</option>
            <option value="VE">VE</option>
            <option value="LIUMEDIA">LIUMEDIA</option>
            <option value="VPRO">VPRO</option>
            <option value="OTHER">OTHER</option>
            <option value="Other">Other</option>
			              <option value selected><?php echo e($corporate) ?></option>
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
                  <option value selected><?php echo e($department) ?></option>
                  <option value="Sales">Sales</option>
                  <option value="Accounting">Accounting</option>
                  <option value="Academic">Academic</option>
                  <option value="HR">HR</option>
                  <option value="GA">GA</option>
                  <option value="IT">IT</option>
                  <option value="Other">Other</option>					
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
			<div class="col-md-12">				  
				<div class="form-group">
				<label for="exampleInputEmail1">Peruntukan</label>
				<textarea class="form-control" rows="3" placeholder="Enter ..." name="peruntukan"><?php echo e($peruntukan) ?></textarea>
				</div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
			    <label for="exampleInputEmail13">Student Name</label>
			    <input type="text" name="exampleInputEmail" class="form-control" id="exampleInputEmail13" placeholder="Your Name" value="<?php echo e($nama_student) ?>" readonly>
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
                <td align=center class="style24"><a href="" onClick="return popitup('../po_view_img.php?id=<?php echo e(u($row_file[0])) ?>&kd=<?php echo e(u($row_file[1])) ?>')"><span class="glyphicon glyphicon-eye-open"></span></a></td>
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
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount,id, tax_ori,tax_remark FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
$resource_po_item = db_query_soft($query_po_item, $__p_query_po_item ?? []);
if(num(db_num_rows($resource_po_item)) > 0)
	{
	$angka_item = 1;	
	while ($row_po_item  =  db_fetch($resource_po_item, PDO::FETCH_NUM))
		{

			$nilai_pajak = $row_po_item[4]; $amount_after_tax = num($row_po_item[2]) - num((num($row_po_item[2]) * num((num($row_po_item[4])/100))));
			$tax_pasal = $row_po_item[5];


			

	
?>	
	          <tr>
	            <td height="14" align=center class="style24"><?php echo e($angka_item) ?></td>
	            <td align=left class="style24"><?php echo e($row_po_item[1]) ?></td>
	            <td align=right class="style24"><?php echo number_format(num( $row_po_item[2]),2,".",".") ?></td>
	            <td align=center class="style24"><?php echo e($nilai_pajak) ?> - 
<?php echo e($tax_pasal) ?></td>
	            <td align=center class="style24"><?php echo number_format(num( $amount_after_tax),2,".",".") ?></td>
	            <td align=center class="style24"><a href="" onClick="return popitup('po_item_dtl_upd.php?id=<?php echo e(u($row_po_item[3])) ?>')"><span class="glyphicon glyphicon-edit"></span></a></td>
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
	        <label for="exampleInputEmail5">Purchasing   Remark</label>
	        <input type="text" class="form-control" placeholder="Enter ..." name="supervisor_remark2" value="<?php echo  e($remark_pemohon) ?>">
	        </div>
	      </div>
	    <div class="col-md-6">
	      <div class="form-group">
	        <label for="exampleInputEmail11">Supervisor  Remark</label>
	        <input type="text" class="form-control" placeholder="Enter ..." name="supervisor_remark3" value="<?php echo  e($remark_supervisor) ?>">
	        </div>
	      </div>
	    <div class="col-md-6">
	      <div class="form-group">
	        <label for="exampleInputEmail4">Accounting  Remark</label>
	        <input type="text" class="form-control" placeholder="Enter ..." name="acc_1_remark" value="<?php echo  e($acc_1_remark) ?>">
	        </div>
	      </div>
	    <div class="col-md-6">
	      <div class="form-group">
	        <label for="exampleInputEmail12">TAX  Remark</label>
	        <input type="text" class="form-control" placeholder="Enter ..." name="tax_remark" value="<?php echo  e($tax_remark) ?>">
	        </div>
	      </div>				
			  </div>
			</div>

	    <div class="box-footer">
		<button type="submit" class="btn btn-primary"   name="Update" value="Update">Update</button>
<?php if (num($po_status) == 2 and num($upd) ==1){ ?>			
		<button type="submit" class="btn btn-primary"   name="Check" value="Check">Check</button>	
<?php } elseif (num($po_status) ==3){ ?>			
		<button type="submit" class="btn btn-primary"   name="Tax" value="Tax">Tax</button>
<?php } elseif (num($po_status) ==4){ ?>			
		<button type="submit" class="btn btn-primary"   name="Paid" value="Paid">Approved To be Paid</button>	
<?php }  elseif (num($po_status) ==5){ ?>			
		<button type="submit" class="btn btn-primary"   name="Paidto" value="Paid">Paid</button>	
<?php }  ?>			

		<button type="submit" class="btn btn-primary"   name="generate" value="generate">Print PO</button>
		
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
if (isset($_POST['Update'])) 
{
$id_po = in_val('id_po', 'post');
$kode_po_ori = in_val('kode_po_ori', 'post');	
$nama_pemohon = in_val('nama_pemohon', 'post');
$email_pemohon = in_val('email_pemohon', 'post');
$department = in_val('department', 'post');
$kd_cbg = in_val('kd_cbg', 'post');
$core = in_val('core', 'post');	

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
$peruntukan = in_val('peruntukan', 'post');
$approved_by = in_val('approved_by', 'post');
$email_tujuan = in_val('email_tujuan', 'post');
$dt_po = in_val('dt_po', 'post');
$dt_due_po = in_val('dt_due_po', 'post');
$supplier_kd = in_val('supplier_kd', 'post');	
$supplier_name = in_val('supplier_name', 'post');
$supplier_phone = in_val('supplier_phone', 'post');
$supplier_npwp = in_val('supplier_npwp', 'post');
$supplier_pic = in_val('supplier_pic', 'post');
$supplier_pic_phone = in_val('supplier_pic_phone', 'post');
$supplier_address = in_val('supplier_address', 'post');
$supplier_bank = in_val('supplier_bank', 'post');
$supplier_bank_account = in_val('supplier_bank_account', 'post');
$supplier_bank_rekening = in_val('supplier_bank_rekening', 'post');
$ack_by = in_val('ack_by', 'post');
$ack_date = in_val('ack_date', 'post');
$tax_by = in_val('tax_by', 'post');
$tax_date = in_val('tax_date', 'post');
$paid_by = in_val('paid_by', 'post');
$paid_date = in_val('paid_date', 'post');
$po_status = in_val('po_status', 'post');
$corporate = in_val('corporate', 'post');
$acc_1_remark = in_val('acc_1_remark', 'post');	
$tax_remark = in_val('tax_remark', 'post');		
$corporate_ori = in_val('corporate_ori', 'post');	
if ($corporate == $corporate_ori or $corporate == '')
	{$corporate = $corporate_ori;	

	$query_update = q_set($__p_query_update, "update purchase_order set peruntukan = ? , dt_po = ? , dt_due_po=? , kd_branch = ? , corporate = ? ,remark_acc_1 = ? , remark_tax= ? ,core=? where id = ?  ", [(string) ($peruntukan), (string) ($dt_po), (string) ($dt_due_po), (string) ($kd_cbg), (string) ($corporate), (string) ($acc_1_remark), (string) ($tax_remark), (string) ($core), (string) ($id_po)]);	
	 
	$resource_update = db_query_soft($query_update, $__p_query_update ?? []);	
	}
else
	{

	$tahun=date("y");
$query_urut_po = q_set($__p_query_urut_po, "SELECT kode FROM ves_data.purchase_order where yr_po = ? and corporate = ? order by id desc limit 1 ", [(string) ($tahun), (string) ($corporate)]);	

	$resource_urut_po = db_query_or_die('errro_3', $query_urut_po, $__p_query_urut_po ?? []);
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
			$kode_urut_po = $corporate.$tahun.$nol.$nextangka;	
			}	
		}
	else
		{
		$kode_urut_po = $tahun.'00001';
		}	
		$kode_po = $corporate.$kode_urut_po;
		$kode_po_ori = in_val('kode_po_ori', 'post');
	$acc_1_remark = in_val('acc_1_remark', 'post');
	$query_update = q_set($__p_query_update, "update purchase_order set peruntukan = ? , dt_po = ? , dt_due_po=? , kd_branch = ? , corporate = ? ,kode = ? ,remark_acc_1 = ? where id = ?  ", [(string) ($peruntukan), (string) ($dt_po), (string) ($dt_due_po), (string) ($kd_cbg) . " ", (string) ($corporate), (string) ($kode_po), (string) ($acc_1_remark), (string) ($id_po)]);	
$resource_update = db_query_soft($query_update, $__p_query_update ?? []);	
		$query_update_file = q_set($__p_query_update_file, "update purchase_order_file set kode  = ? where kode = ? ", [(string) ($kode_po), (string) ($kode_po_ori)]);	
$resource_update_file = db_query_soft($query_update_file, $__p_query_update_file ?? []);	
		$query_update_item = q_set($__p_query_update_item, "update purchase_order_item set kode  = ? where kode = ? ", [(string) ($kode_po), (string) ($kode_po_ori)]);	
$resource_update_item = db_query_soft($query_update_item, $__p_query_update_item ?? []);	

	
	}
$query_sup = q_set($__p_query_sup, "update purchase_supplier set sup_name = ? ,sup_phone = ? ,sup_npwp = ? ,sup_pic = ? ,sup_pic_phone = ? ,sup_address = ? ,sup_bank = ? ,sup_bank_account = ? ,sup_rekening = ?  where id = ? ", [(string) ($supplier_name), (string) ($supplier_phone), (string) ($supplier_npwp), (string) ($supplier_pic), (string) ($supplier_pic_phone), (string) ($supplier_address), (string) ($supplier_bank), (string) ($supplier_bank_account), (string) ($supplier_bank_rekening), (string) ($supplier_kd)]);

$resource_sup = db_query_soft($query_sup, $__p_query_sup ?? []);		
	
echo "<script type=\"text/javascript\">\n";
echo "alert('PO " . e($kode_po) . " Updated');\n";	
		echo "window.location = ('po_detail_display_acc.php?id_po=" . e(u($id_po)) . "&upd=1');\n";		
echo "</script>";	
}
elseif (isset($_POST['Check'])) 
{
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
$hari_ini = "$tahun-$bulan-$hari";
$id_po = in_val('id_po', 'post');
	$kode_po = in_val('kode_po', 'post');	
$acc_1_remark = in_val('acc_1_remark', 'post');
$query_file = q_set($__p_query_file, "update purchase_order set po_status = 3, ack_by = ? ,ack_date= ? ,remark_acc_1 = ? where id = ? ", [(string) ($nama_lengkap), (string) ($hari_ini), (string) ($acc_1_remark), (string) ($id_po)]);

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);	
$query_log = q_set($__p_query_log, "insert into ves_data.purchase_order_log (kode, dt_entry, po_status, pic, remark)values(? ,? ,'3',? ,? )", [(string) ($kode_po), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($acc_1_remark)]);	
$resource_log = db_query_or_die('errro_1', $query_log, $__p_query_log ?? []);		
echo "<script type=\"text/javascript\">\n";
echo "alert('PO " . e($kode_po) . " Checked');\n";
		echo "window.location = ('purchasingorder.php');\n";					
echo "</script>";	
}	
elseif (isset($_POST['Tax'])) 
{
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
$hari_ini = "$tahun-$bulan-$hari";
$id_po = in_val('id_po', 'post');
	$kode_po = in_val('kode_po', 'post');

$tax_remark = in_val('tax_remark', 'post');	
$query_file = q_set($__p_query_file, "update purchase_order set po_status = 4, tax_by = ? ,tax_date= ? ,remark_tax= ? where id = ? ", [(string) ($nama_lengkap), (string) ($hari_ini), (string) ($tax_remark), (string) ($id_po)]);
$resource_file = db_query_soft($query_file, $__p_query_file ?? []);	
$query_log = q_set($__p_query_log, "insert into ves_data.purchase_order_log (kode, dt_entry, po_status, pic, remark)values(? ,? ,'4',? ,? )", [(string) ($kode_po), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($tax_remark)]);	
$resource_log = db_query_or_die('errro_1', $query_log, $__p_query_log ?? []);		
echo "<script type=\"text/javascript\">\n";
echo "alert('PO " . e($kode_po) . " tax Checked');\n";
		echo "window.location = ('purchasingorder.php');\n";						
echo "</script>";	
}
elseif (isset($_POST['Paid'])) 
{
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
$hari_ini = "$tahun-$bulan-$hari";
$id_po = in_val('id_po', 'post');
	$kode_po = in_val('kode_po', 'post');

$tax_remark = in_val('tax_remark', 'post');	
$query_file = q_set($__p_query_file, "update purchase_order set po_status = 5, paid_by = ? ,paid_date= ?  where id = ? ", [(string) ($nama_lengkap), (string) ($hari_ini), (string) ($id_po)]);
$resource_file = db_query_soft($query_file, $__p_query_file ?? []);	
$query_log = q_set($__p_query_log, "insert into ves_data.purchase_order_log (kode, dt_entry, po_status, pic, remark)values(? ,? ,'5',? ,'Approve')", [(string) ($kode_po), (string) ($hari_ini), (string) ($nama_lengkap)]);	
$resource_log = db_query_or_die('errro_1', $query_log, $__p_query_log ?? []);		
echo "<script type=\"text/javascript\">\n";
echo "alert('PO " . e($kode_po) . " Approved');\n";
		echo "window.location = ('purchasingorder.php');\n";						
echo "</script>";	
}	
elseif (isset($_POST['Paidto'])) 
{
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
$hari_ini = "$tahun-$bulan-$hari";
$id_po = in_val('id_po', 'post');
	$kode_po = in_val('kode_po', 'post');

$tax_remark = in_val('tax_remark', 'post');	
$query_file = q_set($__p_query_file, "update purchase_order set po_status = 6, to_paid_by = ? ,to_paid_date= ?  where id = ? ", [(string) ($nama_lengkap), (string) ($hari_ini), (string) ($id_po)]);
$resource_file = db_query_soft($query_file, $__p_query_file ?? []);	
$query_log = q_set($__p_query_log, "insert into ves_data.purchase_order_log (kode, dt_entry, po_status, pic, remark)values(? ,? ,'5',? ,'Paid')", [(string) ($kode_po), (string) ($hari_ini), (string) ($nama_lengkap)]);	
$resource_log = db_query_or_die('errro_1', $query_log, $__p_query_log ?? []);		
echo "<script type=\"text/javascript\">\n";
echo "alert('PO " . e($kode_po) . " Already Paid');\n";
		echo "window.location = ('purchasingorder.php');\n";						
echo "</script>";	
}		
elseif (isset($_POST['reject'])) 
{

$saat_ini = date('Y-m-d H:i:s');
$kode_po = in_val('kode_po', 'post');
$supervisor_remark = in_val('supervisor_remark', 'post');
$query_file = q_set($__p_query_file, "update purchase_order set po_status = 7, approved_dt = ? ,remark_acc_1 = ? ,remark_tax=? where kode = ? ", [(string) ($saat_ini), (string) ($acc_1_remark), (string) ($tax_remark), (string) ($kode_po)]);
$resource_file = db_query_soft($query_file, $__p_query_file ?? []);	
$query_log = q_set($__p_query_log, "insert into ves_data.purchase_order_log (kode, dt_entry, po_status, pic, remark)values(? ,? ,'2',? ,? )", [(string) ($kode_po), (string) ($saat_ini), (string) ($nama_lengkap), (string) ($acc_1_remark)]);	
$resource_log = db_query_or_die('errro_1', $query_log, $__p_query_log ?? []);		
echo "<script type=\"text/javascript\">\n";
echo "alert('PO sudah Anda Tolak');\n";
echo "window.open('purchasingorder.php');\n";					
echo "</script>";
}

elseif (isset($_POST['generate'])) 
{
$mbl = $_SESSION['mbl'];

if (num($mbl) ==1) 
	{ 
		echo "<script type=\"text/javascript\">\n";
echo "window.open('../po_print_mobile.php?kode_po=" . e(u($kode_po)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
		echo "</script>";	

	}	
else
{echo "<script type=\"text/javascript\">\n";
echo "window.open('../printing/po_print.php?kode_po=" . e(u($kode_po)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";					
echo "</script>";	}	
}

elseif (isset($_POST['Close'])) 
{
echo "<script type=\"text/javascript\">\n";
echo "window.close();\n";					
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

</body>
</html>
