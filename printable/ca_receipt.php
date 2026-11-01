<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$id = in_val('id', 'get');
$idb = in_val('idb', 'get');



$query_adm = q_set($__p_query_adm, "SELECT kd_biodata FROM ves_data.vip_billing_payment where kd_billing = ? ", [(string) ($idb)]);

	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$kd_biodata= $row_adm [0];
			$query_data = q_set($__p_query_data, "SELECT concat_ws(' ',nama, middle_name, family_name),address,city FROM ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($kd_biodata)]);

	$resource_data  = db_query_soft($query_data, $__p_query_data ?? []);
	if(num(db_num_rows($resource_data)) > 0)
		{
		while ($row_data   =  db_fetch($resource_data, PDO::FETCH_NUM))
			{
			$nama = $row_data[0];
			$alamat = $row_data[1];
						$kota = $row_data[2];
			}
		}
		}}
$query_ambil_billing = q_set($__p_query_ambil_billing, "SELECT v.kd_biodata, t.nama_lengkap, t.nama_lengkap, t.nama_lengkap, a.nm_program, v.level_program, a.type_program, v.tf, v.discount, v.promo_persen, v.voucher, v.net_tf, v.material_cost, v.reg_fee, v.pic,t.qq_data FROM ves_data.vip_billing v\r
left join ves_data.vip_student_data t on v.kd_biodata = t.kd_biodata\r
left join ves_data.vip_mst_code_prg a on v.kd_program = a.kd_program where v.kd_billing = ? ", [(string) ($idb)]);


$resource_ambil_billing = db_query_or_die('errro_1', $query_ambil_billing, $__p_query_ambil_billing ?? []);
while ($row_billing=  db_fetch($resource_ambil_billing, PDO::FETCH_NUM))
		{
		$kd_biodata = $row_billing['0'];
		$nama = $row_billing['1'];
		$middle_name = $row_billing['2'];
		$family_name = $row_billing['3'];
		$nm_program = $row_billing['4'];
		$level_program = $row_billing['5'];
		$type_program = $row_billing['6'];
		$tf = $row_billing['7'];
		$discount = $row_billing['8'];
		$promo_persen = $row_billing['9'];
		$voucher = $row_billing['10'];
		$net_tf = $row_billing['11'];
		$material_cost = $row_billing['12'];
		$reg_fee = $row_billing['13'];
		$pic = $row_billing['14'];
		$qq_data = $row_billing['15'];
	

		} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>CA INVOICE</title>
	
	<link rel='stylesheet' type='text/css' href='css/style_inv.css' />
	<link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>
</head>
<body>
<div id="page-wrap"><img src="../imgs/LogoCA.png" width="157" height="122" alt=""/><br/><br />
  <textarea id="header" style="background: #F30206">BILLING STATEMENT</textarea>
  <div id="identity2">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
		    <tbody>
		      <tr>
		        <td width="50%"><strong>Bill To :<br/></strong>
				<p align="justify"><?php echo e($nama); ?><br />
<?php echo e($alamat) ?> <?php echo e($kota) ?> </p>	

		        <td align="right"><strong>Invoice Number :<br />
		            <?php echo e($idb); ?>	            <br />
		        </strong><br /></td>
	          </tr>
	        </tbody>
	      </table>
		  <br />
		  <br />
		  <br />
		  <br />
    <br />
<table width="798" id="items">
      <tr class="item-row">
        <td colspan="4" align="center"  bgcolor="#767172" class="item-name_no">Billing Information</td>
      </tr>
      <tr class="item-row">
        <td width="29" class="item-name_no"  bgcolor="#767172" align="center">No</td>
        <td class="item-name_no"  bgcolor="#767172" align="center">Description</td>
        <td align="center" class="item-name"   bgcolor="#767172" >&nbsp;</td>
        <td align="center" class="item-name"   bgcolor="#767172" >Amount</td>
      </tr>

      <tr class="item-row">
        <td class="item-name_no" align="center"yu="yu">1</td>
        <td class="item-name_no">Registration</td>
        <td width="179" align="right" class="item-name">&nbsp;</td>
        <td width="179" align="right" class="item-name">Rp. <?php echo number_format(num($reg_fee),0,".",".")?></td>
      </tr>
      <tr class="item-row">
        <td class="item-name_no" align="center"yu="yu">2</td>
        <td class="item-name_no">Tuition Fee</td>
        <td width="179" align="right" class="item-name">&nbsp;</td>
        <td width="179" align="right" class="item-name">Rp. <?php echo number_format(num($tf),0,".",".")?></td>
      </tr>		

      <tr>
        <td class="blank"></td>
        <td colspan="2" class="blank"> Total</td>
        <td class="total-line balance"  align="right"  bgcolor="#8F8A8A"><span class="item-name">Rp. <?php echo number_format(num((float)$tot_bayar),0,".",".") ?></span></td>
      </tr>
      <tr>
        <td class="blank"></td>
        <td colspan="2" class="blank">Discount : <?php echo e($discount) ?> (<?php echo e($promo_persen)?>%) </td>
        <td class="total-line balance"  align="right"  bgcolor="#8F8A8A"><span class="item-name">Rp. <?php echo number_format(num((float)$amount_discount),0,".",".") ?></span></td>
      </tr>
      <tr>
        <td class="blank"></td>
        <td colspan="2" class="blank">Nett</td>
        <td class="total-line balance"  align="right"  bgcolor="#8F8A8A"><span class="item-name">Rp. <span class="style24"><?php echo number_format(num($net_tf),0,".",".")?></span></span></td>
      </tr>
    </table>
    <br />

    <div id="logo2">
      <div id="logohelp2"></div>
    </div>
	  </div>
		
		<div style="clear:both"></div>
		
	  
	  <table width="798" id="items2">
	    <tr class="item-row">
	      <td colspan="5" align="center"  bgcolor=#767172 class="item-name_no">Payment Information</td>
        </tr>	
	    <tr class="item-row">
	      <td width="29" class="item-name_no"  bgcolor=#767172 align="center">No</td>
	      <td colspan="2" class="item-name_no"  bgcolor=#767172 align="center">Description</td>
	      <td align="center" class="item-name"   bgcolor=#767172 >Date</td>
	      <td align="center" class="item-name"   bgcolor=#767172 >Amount</td>
        </tr>	    <?php 
	$nomor = 1;
$query_invoice = q_set($__p_query_invoice, "SELECT jns_payment, amount, date_format(dt_payment,'%d %b %Y'),id_receipt, pay_mtd FROM ves_data.vip_billing_payment a   where kd_billing = ? and id_receipt <> ''", [(string) ($idb)]);
$resource_invoice = db_query_soft($query_invoice, $__p_query_invoice ?? []);
$keluar_invoice = db_num_rows($resource_invoice);	
if(num(db_num_rows($resource_invoice)) > 0)

					if(num(db_num_rows($resource_invoice)) > 0)
	{
	while ($row_invoice  =  db_fetch($resource_invoice, PDO::FETCH_NUM))
		{
					
					

						
						?>
	    <tr class="item-row">
	      <td class="item-name_no" align="center"yu><?php echo e($nomor) ?></td>
	      <td colspan="2" class="item-name_no"><?php echo e($row_invoice[0]); ?> - <?php echo e($row_invoice[3]); ?></td>
	      <td width="179" align="right" class="item-name"><span class="item-name_no"><?php echo e($row_invoice[2]); ?> - <?php echo e($row_invoice[4]); ?>	      </span></td>
	      <td width="179" align="right" class="item-name">Rp. <?php echo number_format(num((float)$row_invoice[1]),0,".",".") ?></td>
        </tr>
	    <?php $tot_bayar = num($tot_bayar) + num($row_invoice[1]);  } } ?>
	    <tr>
	      <td class="blank"></td>
	      <td class="blank">&nbsp;</td>
	      <td width="190" class="total-line balance" bgcolor="#8F8A8A"> Total</td>
	      <td class="total-line balance"  align="right"  bgcolor="#8F8A8A">&nbsp;</td>
	      <td class="total-line balance"  align="right"  bgcolor="#8F8A8A"><span class="item-name">Rp. <?php echo number_format(num((float)$tot_bayar),0,".",".") ?></span></td>
        </tr>
  </table>
  <p><br />
  </p>
  <p align="right">	Created by, </p>
  <p><br />
  </p>
  <p align="right"><br />
    Consultant<br />
  </p>
  <table width="100%"id="itemsa">
    <tbody>
      <tr>
        <td class="balnk" align="center"><strong>Champions Academy</strong><br />
          Jl. Manyar Kertoarjo V no 63<br />
          Surabaya          <br /></td>
      </tr>
    </tbody>
  </table>
  <p align="right">    <br />
    
    <br/>
  </p>
  <hr>
<align = "right"></align><br/>

</div>
</body>
</html>