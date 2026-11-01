<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
$id = in_val('id', 'get');
$kode_po = in_val('kode_po', 'get');


include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$query_po = q_set($__p_query_po, "SELECT kode, nama_pemohon, department, peruntukan, date_format(dt_po,'%d %b %y'), date_format(dt_due_po,'%d %b %y'), supplier_name, supplier_phone, supplier_address, supplier_bank, supplier_bank_account, supplier_bank_rekening, approved_by, supplier_pic,supplier_pic_phone,supplier_npwp,po_status,date_format(approved_dt,'%d %b %y'),approved_by,  ack_by, date_format(ack_date,'%d %b %y'), sign_check, tax_by, date_format(tax_date,'%d %b %y'), sign_tax, to_paid_by,date_format(to_paid_date,'%d %b %y') , sign_to_paid, paid_by, date_format(paid_date,'%d %b %y'), sign_paid ,pay_mtd,kd_biodata,core,a.kd_branch,b.ttd_file,remark_acc_1,remark_tax,mid(peruntukan,1,60),mid(peruntukan,61,60) FROM ves_data.purchase_order a left join tb_user b on a.nama_pemohon = b.nama_detail where kode = ?  order by id desc limit 1 ", [(string) ($kode_po)]);	

$resource_po = db_query_or_die('errro_12222', $query_po, $__p_query_po ?? []);
if (num(db_num_rows($resource_po)) > 0)
{
while ($row_po=  db_fetch($resource_po, PDO::FETCH_NUM))
	{
	$nama_pemohon = $row_po['1'];
	$department = $row_po['2'];
	$peruntukan_1 = $row_po['38'];
	$peruntukan_2 = $row_po['39'];
	
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
	$nama_cabang	 = $row_po['32'];	
	$ttd_pemohon	 = $row_po['35'];	
	$kd_cabang	 = $row_po['34'];
	$remark_acc_1	 = $row_po['36'];
	$remark_tax	 = $row_po['37'];	
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

	if ($kd_cabang =='001'){$cabang = 'East Sby';}
if ($kd_cabang =='002'){$cabang = 'West Sby';}
if ($kd_cabang =='003'){$cabang = 'Denpasar';}
if ($kd_cabang =='004'){$cabang = 'South Jkt';}
if ($kd_cabang =='005'){$cabang = 'North Jkt';}
if ($kd_cabang =='006'){$cabang = 'West Jkt';}
if ($kd_cabang =='007'){$cabang = 'Bandung';}
if ($kd_cabang =='008'){$cabang = 'Malang';}
if ($kd_cabang =='101'){$cabang = 'East Area';}
if ($kd_cabang =='102'){$cabang = 'West Area';}	
if ($kd_cabang =='000'){$cabang = 'HO';}	
	
	}

}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PO </title>
    <link rel="stylesheet" href="style.css" media="all" />
  </head>
<body onload="window.print();">
    <header class="clearfix">
      <div id="logo" align="left">
        <table>
          <thead>
            <tr>
              <th width="17%" class="service"><span class="page-header"><img src="../imgs/vista-logo.png" width="124" height="50"></span></th>
              <th width="60%" class="desc">        <h2>
Purchase Order</h2></th>
              <th width="23%"><?php echo e($kode_po) ?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <table>
          <thead>
            <tr>
              <th width="70%" class="service">     
        <div><span>NAME</span> : <strong><?php echo e($nama_pemohon) ?></strong> </div>
        <div><span>DEPARTMENT</span> : <strong><?php echo e($department) ?></strong> </div>
        <div><span>CORE </span>: <strong><?php echo e($core) ?></strong> </div>
        <div><span>CENTER</span>: <strong><?php echo e($cabang) ?></strong></div>

    </th>
              <th width="25%" class="desc"> <h2>&nbsp;</h2></th>
              <th width="35%">
        <div align="right">Supplier : <strong><?php echo e($supplier_name) ?></strong></div>
        <div align="right">NPWP : <strong><?php echo e($supplier_npwp) ?></strong></div>
        <div align="right">Phone : <strong><?php echo e($supplier_phone) ?></strong></div>
</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

  <table>
        <thead>
          <tr class="service">
            <th width="7%" ><strong>NO</strong></th>
            <th width="36%"><strong>ORDER &amp; COST / DESCRIPTION</strong></th>
            <th width="25%"><strong>ESTIMATED <br>
            AMOUNT</strong></th>
            <th width="14%"><strong>TAX</strong></th>
            <th width="18%"><strong>AMOUNT <br>
            AFTER TAX</strong></th>
          </tr>
        </thead>
        <tbody>
<?php
$angka = 1;
$query_po_item = q_set($__p_query_po_item, "SELECT kode, order_cost, amount,tax_ori,currency,tax_remark,po_item_remark FROM purchase_order_item where kode = ? order by id", [(string) ($kode_po)]);
$resource_po_item = db_query_soft($query_po_item, $__p_query_po_item ?? []);
if(num(db_num_rows($resource_po_item)) > 0){
$angka_item = 1;	
	while ($row_po_item  =  db_fetch($resource_po_item, PDO::FETCH_NUM))
		{
		$amount =  $row_po_item[2] ;
		$tax_amount = $row_po_item[3];
		$currency = $row_po_item[4];
		$pasal = $row_po_item[5];		
		$tax_amount = num($tax_amount) / 100;
		$tax_on_amount = num($amount) * num($tax_amount);
		$net_amount = num($amount)  - num((num($amount) * num($tax_amount)));
	
?>			
          <tr class="service">
            <td valign="top"><?php echo e($angka) ?></td>
            <td class="desc" valign="top"><?php echo e($nama_student)  ?> <?php echo e($row_po_item[1]) ?><br>
            <?php echo e($row_po_item[6]) ?></td>
            <td align="right" valign="top"><?php echo e($row_po_item[4]) ?> <?php echo number_format(num( $row_po_item[2]),2,".",".") ?></td>
            <td class="desc" align="right"><?php echo  e($row_po_item[3]) ?> - <?php echo e($pasal) ?><?php echo number_format(num( $tax_on_amount),0,".",".") ?></td>
            <td class="desc" align="right"><?php echo e($row_po_item[4]) ?> <?php echo number_format(num( $net_amount ),2,".",".") ?></td>
          </tr>
<?php $angka = num($angka) +1; $ttl_amount = num($ttl_amount) + num($net_amount); $ttl_estimate_amount = num($ttl_estimate_amount) + num($amount); $ttl_tax_on_amount = num($ttl_tax_on_amount) + num($tax_on_amount);} } ?>
          <tr>
            <td colspan="2" class="service">NET TO BE PAID</td>
            <td align="right"><span class="unit"><?php echo e($row_po_item[4]) ?> <?php echo number_format(num( $ttl_estimate_amount),2,".",".") ?></span></td>
            <td class="service"><span class="unit"><?php echo number_format(num( $ttl_tax_on_amount),0,".",".") ?></span></td>
            <td class="service"><span class="unit"><?php echo e($row_po_item[4]) ?></span> <?php echo number_format(num( $ttl_amount),2,".",".") ?></td>
          </tr>
        </tbody>
  </table>
<table>
          <thead>
            <tr>
              <th width="46%" class="service">
       <span>Description</span> : <strong><br>
       <?php echo e($peruntukan_1) ?></strong><br>
       <strong><?php echo e($peruntukan_2) ?></strong>
        <div><span>Due Date</span> : <strong><?php echo e($dt_due_po) ?></strong> </div>
        <div><span>Payment Metodh</span>: <strong><?php echo e($pay_mtd) ?></strong> </div>
</th>
              <th width="4%"> <h2>&nbsp;</h2></th>
              <th width="50%" class="service">      
        <div><span>Acctng Remark</span>: <strong><?php echo e($remark_acc_1) ?></strong></div>
        <div><span>Tax Remark</span>: <strong><?php echo e($remark_tax) ?></strong></div>
        <div><span>Finance Check </span>: <strong><?php echo e($remark_acc_1) ?></strong></div>
				  
				</th>
            </tr>
            <tr>
              <th colspan="3" class="service"> <div> to
              Bank Account : <?php echo e($supplier_bank) ?> - <?php echo e($supplier_bank_account)?> || <?php echo e($supplier_bank_rekening) ?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
<div>
  <table>
    <thead>
      <tr>
        <th><strong>Prepared By</strong></th>
        <th><strong>Approved By</strong></th>
        <th><strong>Checked <br>
          By</strong></th>
        <th><strong>Tax Checked <br>
          By</strong></th>
        <th><strong>Approve <br>
          To Be Paid <br>
          By</strong></th>
        <th><strong>            Paid By</strong></th>
      </tr>
    </thead>
    <tbody>
      
      <tr>
        <td valign="bottom" align="center"><img src="../<?php echo e($ttd_pemohon)  ?>" width="83" height="40"></td>
        <td valign="bottom" align="center">   <?php if (num($po_status) >= 2){ ?>             
          <img src="../<?php echo e($ttd_app)  ?>" width="83" height="40">
          <?php  } ?></td>
        <td class="qty" align="center"><?php if (num($po_status) >= 3){ ?>
          <img src="../<?php echo e($ttd_ack)  ?>" width="83" height="40">
          <?php  } ?></td>
        <td class="qty"><?php if (num($po_status) >= 4){ ?>
          <img src="../<?php echo e($ttd_tax)  ?>" width="83" height="40">
          <?php  } ?></td>
        <td class="qty" align="center"><?php if (num($po_status) >= 4){ ?>
          <img src="../<?php echo e($ttd_topaid)  ?>" width="83" height="40">
          <?php  } ?></td>
        <td class="qty " align="center"><?php if (num($po_status) >= 4){ ?>
          <img src="../<?php echo e($sign_paid)  ?>" width="83" height="40">
          <?php  } ?></td>
      </tr>
      <tr>
        <th><strong><?php echo e($nama_pemohon) ?><br>
          <?php echo e($dt_po) ?> </strong></th>
        <th>
          <?php if (num($po_status) >= 2){ ?> 
          <strong><?php echo e($proposedto) ?><br>
            <?php echo e($approved_dt) ?></strong>
          <?php } ?>				
        </th>
        <th>
          <?php if (num($po_status) >= 3){ ?> 				
          <strong><?php echo e($ack_by) ?><br>
            <?php echo e($ack_date) ?></strong>
        </th>
        <?php } ?>			  
        <th>
          <?php if (num($po_status) >= 4){ ?> 				
          <strong><?php echo e($tax_by) ?><br>
            <?php echo e($tax_date) ?></strong>
          <?php } ?>				
        </th>
        <th>
          <?php if (num($po_status) >= 5){ ?> 				
          <strong><?php echo e($paid_by) ?><br>
            <?php echo e($paid_date) ?></strong>
          <?php } ?>	
        </th>
        <th>
          <?php if (num($po_status) >= 6){ ?> 	
          <strong><?php echo e($paid_by) ?><br>
            <?php echo e($paid_date) ?></strong>
          <?php } ?>	
        </th>
      </tr>
    </tbody>
  </table>		
  </div>
  </header>		
  </div>
  </body>
</html>