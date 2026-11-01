<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
$id = in_val('id', 'get');
$kode_po = in_val('kode_po', 'get');


include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$query_po = q_set($__p_query_po, "SELECT kode, nama_pemohon, department, peruntukan, date_format(dt_po,'%d %b %y'), date_format(dt_due_po,'%d %b %y'), supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by, supplier_pic,supplier_pic_phone,supplier_npwp,po_status,date_format(approved_dt,'%d %b %y'),approved_by,  ack_by, date_format(ack_date,'%d %b %y'), sign_check, tax_by, date_format(tax_date,'%d %b %y'), sign_tax, to_paid_by,date_format(to_paid_date,'%d %b %y') , sign_to_paid, paid_by, date_format(paid_date,'%d %b %y'), sign_paid ,pay_mtd,kd_biodata,core,a.kd_branch,b.ttd_file,remark_acc_1,remark_tax,mid(peruntukan,1,60),mid(peruntukan,61,60),remark_supervisor,corporate FROM ves_data.purchase_order a left join tb_user b on a.nama_pemohon = b.nama_detail where kode = ?  order by id desc limit 1", [(string) ($kode_po)]);	
$resource_po = db_query_or_die('errro_2', $query_po, $__p_query_po ?? []);
if (num(db_num_rows($resource_po)) > 0)
{
while ($row_po=  db_fetch($resource_po, PDO::FETCH_NUM))
	{
	$nama_pemohon = $row_po['1'];
	$department = $row_po['2'];
	$peruntukan = $row_po['3'];
	
	$peruntukan_1 = $row_po['38'];
	$peruntukan_2 = $row_po['39'];
	$corporate = $row_po['40'];
	
	$dt_po = $row_po['4'];
	$dt_due_po = $row_po['5'];

	$supplier_name = $row_po['6'];
	$supplier_phone = $row_po['7'];
	$supplier_address = $row_po['8'];
	$supplier_bank = $row_po['9'];
	$supplier_bank_account = $row_po['10'];
	$supplier_bank_rekening = $row_po['11'];
	$proposedto = $row_po['12'];
	$supplier_pic = $row_po['13'];
	$supplier_pic_phone = $row_po['14'];
	$supplier_npwp	 = $row_po['15'];
	$po_status	 = $row_po['16'];
	$approved_dt	 = $row_po['17'];
	$approved_by	 = $row_po['18'];		
	$ack_by	 = $row_po['19'];
	$ack_date	 = $row_po['20'];
	$sign_check	 = $row_po['21'];	
	$tax_by	 = $row_po['22'];
	$tax_date	 = $row_po['23'];
	$sign_tax_check	 = $row_po['24'];	
	$to_paid_by	 = $row_po['24'];
	$to_paid_date	 = $row_po['25'];
	$sign_to_be_paid	 = $row_po['27'];	
	$paid_by	 = $row_po['28'];
	$paid_date	 = $row_po['29'];		
	$sign_paid	 = $row_po['30'];
	$pay_mtd	 = $row_po['31'];		
	$kd_biodata	 = $row_po['32'];
	$core	 = $row_po['33'];
	$kd_cbg_tugas = $row_po['34'];
	$ttd_pemohon	 = $row_po['35'];	
	$remark_acc_1	 = $row_po['36'];
	$remark_tax	 = $row_po['37'];	
	$remark_supervisor	 = $row_po['40'];	
	
//==== ttd approve =====
		$query_ttd_app = q_set($__p_query_ttd_app, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? ", [(string) ($approved_by)]);	
	$resource_ttd_app = db_query_or_die('errro_1', $query_ttd_app, $__p_query_ttd_app ?? []);
	if (num(db_num_rows($resource_ttd_app)) > 0)
	{
	while ($row_ttd_app=  db_fetch($resource_ttd_app, PDO::FETCH_NUM))
		{		
		$ttd_app = $row_ttd_app[0];	
		}
	}
//======================

//==== ttd ack =====
	$query_ttd_ack = q_set($__p_query_ttd_ack, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? ", [(string) ($ack_by)]);	
	$resource_ttd_ack = db_query_or_die('errro_1', $query_ttd_ack, $__p_query_ttd_ack ?? []);
	if (num(db_num_rows($resource_ttd_ack)) > 0)
	{
	while ($row_ttd_ack=  db_fetch($resource_ttd_ack, PDO::FETCH_NUM))
		{		
		$ttd_ack = $row_ttd_ack[0];	
		}
	}	
//======================
	
//==== ttd tax =====
	$query_ttd_tax = q_set($__p_query_ttd_tax, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? ", [(string) ($tax_by)]);	
	$resource_ttd_tax = db_query_or_die('errro_1', $query_ttd_tax, $__p_query_ttd_tax ?? []);
	if (num(db_num_rows($resource_ttd_tax)) > 0)
	{
	while ($row_ttd_tax=  db_fetch($resource_ttd_tax, PDO::FETCH_NUM))
		{		
		$ttd_tax = $row_ttd_tax[0];	
		}
	}		
//======================
	
//==== ttd paid  =====
	$query_ttd_topaid = q_set($__p_query_ttd_topaid, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? ", [(string) ($paid_by)]);	
	$resource_ttd_topaid = db_query_or_die('errro_1', $query_ttd_topaid, $__p_query_ttd_topaid ?? []);
	if (num(db_num_rows($resource_ttd_topaid)) > 0)
	{
	while ($row_ttd_topaid=  db_fetch($resource_ttd_topaid, PDO::FETCH_NUM))
		{		
		$ttd_topaid = $row_ttd_topaid[0];	
		}
	}	
//======================	
	if ($kd_cbg_tugas == '000'){$nm_cbg = 'HO';}
	elseif ($kd_cbg_tugas == '001'){$nm_cbg = 'East Sby';}
	elseif ($kd_cbg_tugas == '002'){$nm_cbg = 'West Sby';}
	elseif ($kd_cbg_tugas == '003'){$nm_cbg = 'Bali';}
	elseif ($kd_cbg_tugas == '004'){$nm_cbg = 'PIM';}
	elseif ($kd_cbg_tugas == '005'){$nm_cbg = 'MOI';}
	elseif ($kd_cbg_tugas == '006'){$nm_cbg = 'SOHO';}
	elseif ($kd_cbg_tugas == '007'){$nm_cbg = 'Bandung';}
	elseif ($kd_cbg_tugas == '008'){$nm_cbg = 'Malang';}
	elseif ($kd_cbg_tugas == '011'){$nm_cbg = 'PIK';}
	elseif ($kd_cbg_tugas == '014'){$nm_cbg = 'MDN';}
	

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
//==== ttd approve =====
		$query_ttd_app = q_set($__p_query_ttd_app, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? ", [(string) ($approved_by)]);	
	$resource_ttd_app = db_query_or_die('errro_1', $query_ttd_app, $__p_query_ttd_app ?? []);
	if (num(db_num_rows($resource_ttd_app)) > 0)
	{
	while ($row_ttd_app=  db_fetch($resource_ttd_app, PDO::FETCH_NUM))
		{		
		$ttd_app = $row_ttd_app[0];	
		}
	}
//======================

//==== ttd ack =====
	$query_ttd_ack = q_set($__p_query_ttd_ack, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? ", [(string) ($ack_by)]);	
	$resource_ttd_ack = db_query_or_die('errro_1', $query_ttd_ack, $__p_query_ttd_ack ?? []);
	if (num(db_num_rows($resource_ttd_ack)) > 0)
	{
	while ($row_ttd_ack=  db_fetch($resource_ttd_ack, PDO::FETCH_NUM))
		{		
		$ttd_ack = $row_ttd_ack[0];	
		}
	}	
//======================
	
//==== ttd tax =====
	$query_ttd_tax = q_set($__p_query_ttd_tax, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? ", [(string) ($tax_by)]);	
	$resource_ttd_tax = db_query_or_die('errro_1', $query_ttd_tax, $__p_query_ttd_tax ?? []);
	if (num(db_num_rows($resource_ttd_tax)) > 0)
	{
	while ($row_ttd_tax=  db_fetch($resource_ttd_tax, PDO::FETCH_NUM))
		{		
		$ttd_tax = $row_ttd_tax[0];	
		}
	}		
//======================
	
//==== ttd paid  =====
	$query_ttd_topaid = q_set($__p_query_ttd_topaid, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? ", [(string) ($paid_by)]);	
	$resource_ttd_topaid = db_query_or_die('errro_1', $query_ttd_topaid, $__p_query_ttd_topaid ?? []);
	if (num(db_num_rows($resource_ttd_topaid)) > 0)
	{
	while ($row_ttd_topaid=  db_fetch($resource_ttd_topaid, PDO::FETCH_NUM))
		{		
		$ttd_topaid = $row_ttd_topaid[0];	
		}
	}	
//======================	
	}
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PO <?php echo e($kode_po) ?></title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
		  <div class="col-xs-3">
        <h2 class="page-header">
        <img src="imgs/vista-logo.png" width="83" height="37"></h2>			  
		  </div>
		  <div class="col-xs-6">
        <h3>
Purchase Order</h3>			  
		  </div>		  
	    <div class="col-xs-3">
        <h1 class="page-header">
          <small class="pull-right">No :<?php echo e($kode_po) ?></small></h1>			  
	    </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-6 invoice-col">
        Name
          <address>
          <strong><?php echo e($nama_pemohon) ?></strong><br>
          <?php echo e($department) ?><br>

        </address>
    </div>
      <!-- /.col -->
    <!-- /.col -->
      <div class="col-sm-6 invoice-col">Supplier: <?php echo e($supplier_name) ?> || <?php echo e($supplier_phone) ?><br>
        Address : <?php echo e($supplier_address) ?>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th width="5%" bgcolor="#5F5F5F">No</th>
            <th width="61%" bgcolor="#5F5F5F">Order &amp; Cost</th>
            <th width="15%" bgcolor="#5F5F5F" align="center">Estimated Amount</th>
            <th width="4%" bgcolor="#5F5F5F" align="center">Tax</th>
            <th width="15%" bgcolor="#5F5F5F">Amount</th>
            </tr>
          </thead>
          <tbody>
<?php
$angka = 1;
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount,tax_ori,po_item_remark FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
$resource_po_item = db_query_soft($query_po_item, $__p_query_po_item ?? []);
if(num(db_num_rows($resource_po_item)) > 0){
$angka_item = 1;	
	while ($row_po_item  =  db_fetch($resource_po_item, PDO::FETCH_NUM))
		{
		$amount =  $row_po_item[2] ;
		$tax_amount = $row_po_item[3];
		$tax_amount = num($tax_amount) / 100;
		$net_amount = num($amount)  - num((num($amount) * num($tax_amount)));
		$po_item_remark =  $row_po_item[4] ;
		
	
?>			  
          <tr>
            <td><?php echo e($angka) ?></td>
            <td><?php echo e($nama_student)  ?> <?php echo e($row_po_item[1]) ?><br>
            <?php echo e($po_item_remark) ?></td>
            <td align="right"><?php echo  number_format(num($row_po_item[2]), 2, ",", ".") ?></td>
            <td align="right"><?php echo  e(($row_po_item[3])) ?></td>
            <td align="right"><?php echo number_format(num($net_amount), 2, ",", ".") ?></td>
            </tr>
<?php $angka = num($angka) +1; $ttl_amount = num($ttl_amount) + num($net_amount); } } ?>			  
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><strong>Nett To be Paid</strong></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right"><?php echo number_format(num( $ttl_amount), 2, ",", ".") ?></td>
          </tr>
          <tr>
            <td colspan="2">Note : <?php echo e($peruntukan) ?> || <?php echo e($core) ?> - <?php echo e($nm_cbg) ?><br>
            Due  Date : <?php echo e($dt_due_po) ?></td>
            <td colspan="3" align="right"><p>Bank Information : <span style="width:50%" ><?php echo e($supplier_bank_account) ?> || <?php echo e($supplier_bank) ?> - <?php echo e($supplier_bank_rekening) ?> [<?php echo e($pay_mtd) ?>]</span>            </p></td>
            </tr>
          </tbody>
        </table>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <div class="row">

      <!-- /.col -->
    <div class="col-xs-12">
        <table class="table">
          <tr class="animated-dropdown-menu">
            <th width="25%" style="width:15%;font-size: 10px"> Prepared By<br>
              <img src="<?php echo e($ttd_pemohon)  ?>" width="135" height="67"> <br>
            <br>            <?php echo e($nama_pemohon) ?><br>            <?php echo e($dt_po) ?></th>
            <th width="25%" style="width:15%;font-size: 10px"><strong>Approved By</strong><br>
            <?php if (num($po_status) >= 2){ ?>             
            <img src="<?php echo e($ttd_app)  ?>" width="135" height="67">
            <?php  } ?><br>					
            <?php if (num($po_status) >= 2){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 2){ echo e($approved_dt) ; }?>            </th>
            <th width="18%" style="width:15%;font-size: 10px">Checked By<br>
            <?php if (num($po_status) >= 3){ ?>
            <img src="<?php echo e($sign_approved)  ?>" width="135" height="67">
            <?php  } ?>
            <br>
            <?php if (num($po_status) >= 3){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 3){ echo e($approved_dt) ; }?>            </th>
            <th width="32%" style="width:15%;font-size: 10px">Tax Checked By<br>
            <?php if (num($po_status) >= 4){ ?>
            <img src="<?php echo e($sign_approved)  ?>" width="135" height="67">
            <?php  } ?>
            <br>
            <?php if (num($po_status) >= 4){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 4){ echo e($approved_dt) ; }?>            </th>
            <th width="32%" style="width:15%;font-size: 10px">To Be Paid By<br>
            <?php if (num($po_status) >= 5){ ?>
            <img src="<?php echo e($sign_approved)  ?>" width="135" height="67">
            <?php  } ?>
            <br>
            <?php if (num($po_status) >= 5){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 5){ echo e($approved_dt) ; }?>            </th>
            <th width="32%" style="width:15%;font-size: 10px">Paid By<br>
            <?php if (num($po_status) >= 6){ ?>
            <img src="<?php echo e($sign_approved)  ?>" width="135" height="67">
            <?php  } ?>
            <br>
            <?php if (num($po_status) >= 6){ echo e($proposedto) ; }?>
            <br>            <?php if (num($po_status) >= 6){ echo e($approved_dt) ; }?>            </th>
          </tr>
        </table>
        <br>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
<!-- ./wrapper -->
</body>
</html>
