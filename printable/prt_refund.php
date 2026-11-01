<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');


$ed = in_val('ed', 'get');
$idsoa = $kdb.$ed;
$no = in_val('no', 'get');

$st = in_val('st', 'get');
$new = in_val('new', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$branch = $_SESSION['branch']; 
$id = in_val('id', 'get');
$p = in_val('p', 'get');

$kd_branch = $_SESSION['kd_branch'];

$query_adm = q_set($__p_query_adm, "SELECT v.id_refund, concat_ws(' ',b.nama, b.middle_name, b.family_name), date_format(v.dt_refund,'%d %M %Y'), v.amount, v.pay_mtd, v.remark, v.pic,b.address, b.city,v.id_receipt FROM ves_data.vip_billing_refund v left join ves_inc.tb_biodata b on v.kd_biodata = b.kd_biodata where v.no = ?  group by b.kd_biodata", [(string) ($id)]);

	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$id_refund = $row_adm['0'];
			$nama_student = $row_adm['1'];
			$dt_refund = $row_adm['2'];	
			$amount = $row_adm['3'];		
			$pay_mtd = $row_adm['4'];		
			$remark = $row_adm['5'];	
			$pic = $row_adm['6'];		
			$alamat = $row_adm['7'];					
			$kota = $row_adm['8'];					
			$id_receipt = $row_adm['9'];				
				
			}
		}
if (num($st_amount) ==2){$rupiah = $kredit_rupiah;}
if (num($kdcbg) ==1){$cabang = 'East Sby';}
if (num($kdcbg) ==2){$cabang = 'West Sby';}
if (num($kdcbg) ==3){$cabang = 'Denpasar';}
if (num($kdcbg) ==4){$cabang = 'South Jkt';}
if (num($kdcbg) ==5){$cabang = 'North Jkt';}
if (num($kdcbg) ==6){$cabang = 'West Jkt';}
if (num($kdcbg) ==7){$cabang = 'Bandung';}
if (num($kdcbg) ==8){$cabang = 'Malang';}

 $membaca=   ucwords(convert_number_to_words($amount))." Rupiah";

function convert_number_to_words($number) {
    
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if ((num($number) >= 0 && (int) $number < 0) || (int) $number < 0 - num(PHP_INT_MAX)) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if (num($number) < 0) {
        return $negative . convert_number_to_words(abs(num($number)));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case num($number) < 21:
            $string = $dictionary[$number];
            break;
        case num($number) < 100:
            $tens   = num(((int) (num($number) / 10))) * 10;
            $units  = num($number) % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case num($number) < 1000:
            $hundreds  = num($number) / 100;
            $remainder = num($number) % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(num(log($number, 1000))));
            $numBaseUnits = (int) (div($number, $baseUnit));
            $remainder = num($number) % num($baseUnit);
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= num($remainder) < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>Editable Invoice</title>
	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>
</head>
<body>
<div id="page-wrap">
  <textarea id="header">REFUND STATEMENT</textarea>
		<div id="identity2">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
		    <tbody>
		      <tr>
		        <td width="50%">To : <strong><br />
	            <?php echo e($nama_student) ?><br /> 
	            <span class="meta-head"><?php echo e($alamat) ?><?php echo e($kota) ?></span></strong></td>
		        <td align="right"><img src="../imgs/ve.png" width="84" height="55" alt=""/></td>
	          </tr>
	        </tbody>
	      </table>
		  <br />
		  <div id="logo2">
		    <div id="logohelp2"></div>
	      </div>
	  </div>
		
		<div style="clear:both"></div>
		<div id="customer">
		  <table id="meta">
              <tr>
                <td align="right" class="meta-head">ID Refund :</td>
                <td><?php echo e($id_refund) ?></td>
              </tr>
              <tr>
                <td align="right" class="meta-head">Id Receipt :</td>
                <td><?php echo e($id_receipt) ?></td>
              </tr>
              <tr>
                    <td width="116" align="right" class="meta-head">Date :</td>
                    <td width="172"><?php echo e($dt_refund) ?></td>
            </tr>
          </table>
	  </div>
	  <table id="items">
		  <tr>
		      <th colspan="3">Description</th>
		      <th width="244">Amount</th>
		  </tr>
		  <tr class="item-row">
	        <td colspan="3" class="item-name"><?php echo e($remark) ?></td>
	        <td align="right"><span class="price">Rp. <?php echo number_format(num($amount),0,".",".") ?></span></td>
		  </tr>
		  <tr>
		      <td width="438" class="blank"> </td>
		      <td colspan="2" class="total-line balance"><strong>Total</strong></td>
		      <td class="total-value balance" align="right"><span class="price"><strong>Rp.  <?php echo number_format(num($amount),0,".",".") ?></strong></span></td>
		  </tr>
		  <tr class="item-row">
		    <td colspan="3" class="item-name">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr class="item-row">
		    <td colspan="4" class="item-name"><?php echo e($membaca) ?>		      <br/></td>
	      </tr>
		  <tr>
		    <td colspan="4" class="blank"></td>
	      </tr>
		  <tr>
		    <td colspan="4" class="blank"></td>
	      </tr>
		</table>
	  <br />
  <table width="100%"id="itemsa">
    <tbody>
	      <tr>
	        <td width="50%">Prepared  By:<br/>
              <br/>
              <br/>
            <strong><?php echo e($nama_lengkap) ?></strong><br /></td>
	        <td width="50%" align="right">Received By:<br/>
              <br/>
              <br/>
            <strong><?php echo e($nama_student) ?></strong><br /></td>
          </tr>
        </tbody>
  </table>
	  <h5 align="right"><br />
      </h5>
<br/><hr><br/>

  <textarea id="header">REFUND STATEMENT</textarea>
		<div id="identity2">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
		    <tbody>
		      <tr>
		        <td width="50%">To : <strong><br />
	            <?php echo e($nama_student) ?><br /> 
	            <span class="meta-head"><?php echo e($alamat) ?><?php echo e($kota) ?></span></strong></td>
		        <td align="right"><img src="../imgs/ve.png" width="84" height="55" alt=""/></td>
	          </tr>
	        </tbody>
	      </table>
		  <br />
		  <div id="logo2">
		    <div id="logohelp2"></div>
	      </div>
	  </div>
		
		<div style="clear:both"></div>
		<div id="customer">
		  <table id="meta">
              <tr>
                <td align="right" class="meta-head">ID Refund :</td>
                <td><?php echo e($id_refund) ?></td>
              </tr>
              <tr>
                <td align="right" class="meta-head">Id Receipt :</td>
                <td><?php echo e($id_receipt) ?></td>
              </tr>
              <tr>
                    <td width="116" align="right" class="meta-head">Date :</td>
                    <td width="172"><?php echo e($dt_refund) ?></td>
            </tr>
          </table>
	  </div>
	  <table id="items">
		  <tr>
		      <th colspan="3">Description</th>
		      <th width="244">Amount</th>
		  </tr>
		  <tr class="item-row">
	        <td colspan="3" class="item-name"><?php echo e($remark) ?></td>
	        <td align="right"><span class="price">Rp. <?php echo number_format(num($amount),0,".",".") ?></span></td>
		  </tr>
		  <tr>
		      <td width="438" class="blank"> </td>
		      <td colspan="2" class="total-line balance"><strong>Total</strong></td>
		      <td class="total-value balance" align="right"><span class="price"><strong>Rp.  <?php echo number_format(num($amount),0,".",".") ?></strong></span></td>
		  </tr>
		  <tr class="item-row">
		    <td colspan="3" class="item-name">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr class="item-row">
		    <td colspan="4" class="item-name"><?php echo e($membaca) ?>		      <br/></td>
	      </tr>
		  <tr>
		    <td colspan="4" class="blank"></td>
	      </tr>
		  <tr>
		    <td colspan="4" class="blank"></td>
	      </tr>
		</table>
	  <br />
  <table width="100%"id="itemsa">
    <tbody>
	      <tr>
	        <td width="50%">Prepared  By:<br/>
              <br/>
              <br/>
            <strong><?php echo e($nama_lengkap) ?></strong><br /></td>
	        <td width="50%" align="right">Received By:<br/>
              <br/>
              <br/>
            <strong><?php echo e($nama_student) ?></strong><br /></td>
          </tr>
        </tbody>
  </table>
	  <h5 align="right"><br />
      </h5>	
</div>
</body>
</html>