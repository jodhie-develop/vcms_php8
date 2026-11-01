<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$id = in_val('id', 'get');


$query_adm = q_set($__p_query_adm, "SELECT * FROM invoice_project where id = ? ", [(string) ($id)]);

	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$order_by= $row_adm [4];
			$invoice_number= $row_adm [2];
			$description= $row_adm [5];
			}
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
<div id="page-wrap"><img src="../imgs/LogoCA.png" width="157" height="122" alt=""/><br />
  <textarea id="header">RECEIPT</textarea>	
		<div id="identity2">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
		    <tbody>
		      <tr>
		        <td width="50%" valign="top"><strong>Receive From :<br />
		        </strong>
                  <p><?php echo e(nl2br($order_by)); ?></p>
                  <p align="justify">&nbsp;</p>	

		        <td align="right" valign="top"><strong>Receipt Number :<br />
                </strong>VPRO/rcp/00101/Agustus/2025<strong><br />
		        Receipt Date:<br /> 
		        </strong>25 September 2025<br />                  <br /></td>
	          </tr>
	        </tbody>
	      </table>
		  <br />
		  <div id="logo2">
		    <div id="logohelp2"></div>
	      </div>
	  </div>
		
		<div style="clear:both"></div>
		

	          <?php 
	$nomor = 1;
			$query_soa = q_set($__p_query_soa, "SELECT i.invoice_description, i.invoice_amount, i.vat,invoice_due_date FROM invoice_project i where id = ? ", [(string) ($id)]);

			$resource_soa = db_query_or_die('errro_rr', $query_soa, $__p_query_soa ?? []);

			if(num(db_num_rows($resource_soa)) > 0)
				{
							$nomor_soa = 1; $last = db_num_rows($resource_soa);
				while ($row_soa=  db_fetch($resource_soa, PDO::FETCH_NUM))
					{

					$description= $row_soa[0];
					$amount= $row_soa[1];
					$vat= num((num($amount)*11))/100;
					$due_date= $row_soa[4]	;
					

						
						?><?php   } } ?>		  
      <br />
      <br />
<table width="798" id="items2">

    <tr class="item-row">
	      <td width="29" class="item-name_no"  bgcolor=#767172 align="center">No</td>
	      <td colspan="2" class="item-name_no"  bgcolor=#767172 align="center">Description</td>
	      <td width="179" align="center"   bgcolor=#767172 class="item-name" >Amount</td>
        </tr>	    <?php 
	$nomor = 1;
			$query_soa = q_set($__p_query_soa, "SELECT i.invoice_description, i.invoice_amount, i.vat,invoice_due_date FROM invoice_project i where id = ? ", [(string) ($id)]);

			$resource_soa = db_query_or_die('errro_rr', $query_soa, $__p_query_soa ?? []);

			if(num(db_num_rows($resource_soa)) > 0)
				{
							$nomor_soa = 1; $last = db_num_rows($resource_soa);
				while ($row_soa=  db_fetch($resource_soa, PDO::FETCH_NUM))
					{

					$description= $row_soa[0];
					$amount= $row_soa[1];
					$vat= $row_soa[2];
					$tot_amount = num($amount)+num($vat);
					$due_date= $row_soa[3];
					
					

						
						?>
	    <tr class="item-row">
	      <td class="item-name_no" align="center"yu="yu"><?php echo e($nomor) ?></td>
	      <td colspan="2" class="item-name_no"><?php echo e(nl2br($description)); ?></td>
	      <td align="right" class="item-name">Rp. <?php echo number_format(num((float)$amount),0,".",".") ?></td>
    </tr>
	    <?php   } } ?>
	    <tr>
	      <td class="blank"></td>
	      <td class="blank">&nbsp;</td>
	      <td width="190" class="total-line balance" bgcolor="#8F8A8A"> Total</td>
	      <td class="total-line balance"  align="right"  bgcolor="#8F8A8A"><span class="item-name">Rp. <?php echo number_format(num((float)$amount),0,".",".") ?></span></td>
        </tr>
	    <tr>
	      <td colspan="2" class="blank"></td>
	      <td class="total-line balance" bgcolor="#8F8A8A">Vat</td>
	      <td class="total-line balance" align="right" bgcolor="#8F8A8A"><span class="item-name">Rp. <?php echo number_format(num((float)$vat),0,".",".") ?></span></td>
        </tr>
	    <tr>
	      <td colspan="2" class="blank"></td>
	      <td class="total-line balance" bgcolor="#8F8A8A">Grand Total</td>
	      <td class="total-line balance" align="right" bgcolor="#8F8A8A"><span class="item-name">Rp. <?php echo number_format(num((float)$tot_amount),0,".",".") ?></span></td>
        </tr>
  </table>
  <p>&nbsp;</p>
  <table width="100%"id="itemsa">
    <tbody>
	      <tr>
	        <td class="balnk" width="21%">Bank		  <br />
	          Account Name		<br />
            Account No<br /></td>
	        <td width="79%" align="left">: Bank Central Asia<br />
	          : PT Vista Inspirasi Pendidikan<br />
: 178-303-9005<br /></td>
          </tr>
    </tbody>
  </table>
	  <h5 align="right"><br />
      </h5>
  <p>	Received By, </p>
  <p><br />
    <br />
<br />
  </p>
  <p><br />
    Dewi Tan<br />
    Finance<br/>
  </p>
  <hr>
<align = "right"></align><br/>

</div>
</body>
</html>