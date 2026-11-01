<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ob_start();
ini_set('memory_limit', '150M'); ?>
<?php 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
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

$query_adm = q_set($__p_query_adm, "SELECT a.id_soa, a.kd_biodata, b.nama, a.keterangan, a.deskripsi, a.rp_debet, a.dt_entry,a.pay_mtd,a.no_ref,a.rp_kredit, a.st_amount,a.bank_name, a.bank_penerima, a.bank_rekening, a.id_receipt FROM ves_data.adm_soa a left join ves_data.adm_stu_progress b on a.kd_biodata = b.kd_biodata where b.aktif = 1 and a.id= ? ", [(string) ($id)]);

	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$student_name = $row_adm['2'];
			$kdb = $row_adm['1'];
			$statement = $row_adm['3'];	
			$deskripsi = $row_adm['4'];		
			$rupiah = $row_adm['5'];		
			$tgl_hari_ini = $row_adm['6'];		
			$payment_metodh = $row_adm['7'];	
			$noref = $row_adm['8'];	
			$kredit_rupiah = $row_adm['9'];	
			$st_amount = $row_adm['10'];
			$bankname = $row_adm['11'];
			$namapenerima = $row_adm['12'];
			$norek  = $row_adm['13'];				
			$idreceipt  = $row_adm['14'];				
				
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

 $membaca=   ucwords(convert_number_to_words($rupiah))." Rupiah";

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
<!DOCTYPE html>
<html>
<style type="text/css">
  table {width: 100%; border-collapse: collapse;}
  td, th {border: solid 1px black;}
  h1 {text-align: center;}
  span {float: right;}
</style>

<span>
  <b>Invoice No.</b> {{ invoice.number }}<br>
  <b>Date</b> {{ invoice.invoice_date | date: "%B %e, %Y"}}<br>
</span>

<b>Provider</b>
{{ account.company }}<br>
{{ account.representative }}<br>
{{ account.info | multi_line }}

<b>Customer</b>
{{ invoice.contact.name }}<br>
{{ invoice.contact.post_address | multi_line }}

<h1>INVOICE</h1>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Description</th>
      <th>Quantity</th>
      <th>Price/Unit</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
    {% for item in invoice.lines %}
    <tr>
      <td>{{ item.position }}</td>
      <td>{{ item.description | multi_line }}</td>
      <td>x{{ item.quantity | numeric: 4 }}</td>
      <td>{{ item.price | currency }}</td>
      <td>{{ item.total | currency }}</td>
    </tr>
    {% endfor %}
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>Total</td>
      <td>{{ invoice.amount | currency }}</td>
      </tr>        
  </tbody>
</table>
</html>
<?php
    $content = ob_get_clean();
	$namafile = "ocp.$kode_student.pdf";
    // convert in PDF
    require_once VCMS_ROOT . '/_lib/html2pdf.php';   // spipu/html2pdf 5.x (pengganti html2pdf/ lama)
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
 		$html2pdf->setTestTdInOnePage(false);		
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($namafile);
    }
    catch(HTML2PDF_exception $e) {
        html2pdf_fail($e);
    }
?>
