<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/../conndb.php";
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

$query_adm = q_set($__p_query_adm, "SELECT t.id_invoice, date_format(t.dt_payment,'%d %M %Y'), concat_ws(' ',a.nama, a.middle_name, a.family_name), a.address, a.city, t.keterangan, t.nominal, t.pay_mtd, t.pic,mid(t.keterangan,1,5),t.keterangan_dtl,t.id_billing FROM ves_data.tb_invoice_paid t left join ves_inc.tb_biodata a on t.kd_biodata = a.kd_biodata where t.id = ?  group by id_invoice", [(string) ($id)]);

	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$id_refund = $row_adm['0'];
			$nama_student = $row_adm['2'];
			$dt_refund = $row_adm['1'];	
			$amount= $row_adm['6'];		
			$pay_mtd= $row_adm['7'];		
			$remark= $row_adm['5'];	
			$pic= $row_adm['8'];		
			$alamat= $row_adm['3'];					
			$kota= $row_adm['4'];	
			$kelompok= $row_adm['9'];	
			$detail= $row_adm['10'];
			$id_billing= $row_adm['11'];		
			if($remark =='Business English Communication'){$nama_student = $nama_student.' - UNESA';}
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

if($kelompok == 'TOEFL')
	{
	$kop = 'IBT INTERNATIONAL TEST RECEIPT';
	$logo = 'vista-logo.png';
	$logo_width = 110;
	$logo_height = 72;		
	}
elseif($kelompok == 'IELTS')
	{
	$kop = 'IELTS INTERNATIONAL TEST RECEIPT';
	$logo = 'vista-logo.png';
	$logo_width = 110;
	$logo_height = 72;		
	}
elseif($kelompok == 'NCUK')
	{
	$kop = 'VIC PATHWAY RECEIPT';
	$logo = 'ncuk.jpg';
	$logo_width = 254;
	$logo_height = 88;	
	}
elseif($kelompok == 'Test ')
	{
	$kop = 'TEST BAKAT MINAT RECEIPT';
	$logo = 'vista-logo.png';
	$logo_width = 110;
	$logo_height = 72;	
	}
elseif($kelompok == 'Vista')
	{
	$kop = 'VISTALK EVENT 2020 RECEIPT';
	$logo = 'vista-logo.png';
	$logo_width = 110;
	$logo_height = 72;	
	}
elseif($kelompok == 'VOS C')
	{
	$kop = 'VOS CASH DEPOSIT RECEIPT';
	$logo = 'vista-logo.png';
	$logo_width = 110;
	$logo_height = 72;		
	}
elseif($kelompok == 'VOS C')
	{
	$kop = 'VOS CASH DEPOSIT RECEIPT';
	$logo = 'vista-logo.png';
	$logo_width = 110;
	$logo_height = 72;		
	}
elseif($kelompok == 'Passw')
	{
	$kop = 'VIC PATHWAY RECEIPT';
	$logo = 'ncuk.jpg';
	$logo_width = 254;
	$logo_height = 88;	
	}
elseif($kelompok == 'SAT')
	{
	$kop = 'SAT RECEIPT';
	$logo = 'vista-logo.png';
	$logo_width = 110;
	$logo_height = 72;		
	}
elseif($kelompok == 'TBI -')
	{
	$kop = 'TES BAKAT INDONESIA - VIC';
	$logo = 'vista-logo.png';
	$logo_width = 110;
	$logo_height = 72;		
	}

elseif($kelompok == 'BIM -')
	{
	$kop = 'BIM APPLICATION FEE - VIC';
	$logo = 'vista-logo.png';
	$logo_width = 110;
	$logo_height = 72;		
	}	
elseif($remark == 'Business English Communication')
	{
	$kop = 'RECEIPT';
	$logo = 've.png';
	$logo_width = 110;
	$logo_height = 72;		
	}
elseif($kelompok == 'VPRO ')
	{
	$kop = 'RECEIPT';
	$logo = 'vprolog.png';
	$logo_width = 110;
	$logo_height = 75;		
	}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
		
<style>
    body {
        background-image: url('https://pbs.twimg.com/profile_images/932533142958804992/lMa20scK_400x400.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: 150px 150px; 
        background-size: 200px 200px;
    }
</style>		
    </style>
</head>

<body>
    <div class="invoice-box">

				<table>
              <tr>
                <td width="16%"><img src="../imgs/<?php echo e($logo) ?>" width="<?php echo e($logo_width) ?>" height="<?php echo e($logo_height) ?>" alt=""/></td>
                <td align="center"><strong><?php echo e($kop) ?></strong></td>
              </tr>
            </table>
      <table>
                <tr>
                  <td> To :<br>
                    <strong><?php echo e($nama_student) ?><br />
                      <span class="meta-head"><?php echo e($alamat) ?><?php echo e($kota) ?></span></strong></td>
                  <td align="right">ID Receipt # <strong><?php echo e($id_refund) ?></strong><br>
                    Date: <strong><?php echo e($dt_refund) ?></strong></td>
                </tr>
      </table>
      <table width="500" border="0" cellspacing="0" cellpadding="0" style="background-image:url("../imgs/paidd.png"); background-repeat:repeat;">
                <tbody>
                  <tr>
                    <td><table cellpadding="0" cellspacing="0" >
                      <tr class="top">
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr class="heading">
                        <td width="46%"> Description</td>
                        <td width="28%">Payment By</td>
                        <td width="26%" align="right"> Amount </td>
                      </tr>
                      <tr class="details" >
                        <td><span class="item-name"><?php echo e($remark) ?> <?php echo e($detail) ?></span></td>
                        <td align="left"><?php echo e($pay_mtd) ?></td>
                        <td align="right"> Rp. <span class="price"><?php echo number_format(num($amount),0,".",".") ?></span></td>
                      </tr>
                      <tr class="total">
                        <td colspan="2"></td>
                        <td style="background-image:url("../imgs/paidd.png"); background-repeat:repeat;"> Rp. <span class="price"><?php echo number_format(num($amount),0,".",".") ?></span></td>
                      </tr>
                      <tr class="information">
                        <td colspan="3"><table >
                          <tr>
                            <td colspan="2">Says :<br>
                              <span class="item-name"><?php echo e($membaca) ?></span><br>
                              <hr></td>
                          </tr>
                          <tr>
                            <td align="left">Prepared By:<br/>
                              <br/>
                              <strong><?php echo e($pic) ?></strong><br /></td>
                            <td align="right">Received By:<br/>
                              <br/>
                              <strong><?php echo e($nama_student) ?></strong><br /></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </tbody>
      </table></td>

    </div>
</body>
</html>
