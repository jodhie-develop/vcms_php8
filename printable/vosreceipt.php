<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
ob_start();
ini_set('memory_limit', '150M'); ?>
<?php 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');
$sd = in_val('sd', 'get');
$cd = in_val('cd', 'get');
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

$query_adm = q_set($__p_query_adm, "SELECT concat_ws(' ',nm_stu, middle_name, family_name), country_dest, school_dest, curr, rp_mount, terbilang, pic, id_prof_bill, date_format(tgl_cetak,'%d %b %Y'),pic,pay_mtd,st_refund,date_format(dt_paid,'%d %b %Y') FROM ves_inc.tb_prof_bill where id_stu = ? and country_dest = ? and school_dest = ? order by no desc limit 1", [(string) ($kdb), (string) ($cd), (string) ($sd)]);
	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$student_name = $row_adm['0'];
			$country_dest = $row_adm['1'];
			$school_dest = $row_adm['2'];
			$curr = $row_adm['3'];
			$rp_mount = $row_adm['4'];
			$terbilang = $row_adm['5'];
			//$pic = $row_adm['6'];
			$id_prof_bill = $row_adm['7'];
			$tgl_cetak = $row_adm['8'];
			$pic = $row_adm['9'];
			$pay_mtd = $row_adm['10'];	
			$st_refund = $row_adm['11'];
			$dt_paid = $row_adm['12'];			
			}
		}
//== terbilang
function convertNumber($number)
{
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer[0] == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer[0] == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer[0] == "0")
    {
        $output .= "zero";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
        }

        for ($z = 0; $z < cnt($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - num($z)) . (
                        num($z) < 11
                        && !array_search('', array_slice($groups2, num($z) + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11][0] == '0'
                            ? " and "
                            : ", "
                    );
            }
        }

        $output = rtrim($output, ", ");
    }

    if (num($fraction) > 0)
    {
        $output .= " point";
        for ($i = 0; $i < strlen($fraction); $i++)
        {
            $output .= " " . convertDigit($fraction[$i]);
        }
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
}

 $num = 500254.89;
 $terbilang = convertNumber($rp_mount);
	$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kdb)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
		while ($row_nik  =  db_fetch($resource_nik, PDO::FETCH_NUM))
			{
			$nik = $row_nik[0];
			}
		}
//==
//echo $string;
$query_ambil_center = q_set($__p_query_ambil_center, "select ket_center, alamat,phone from tb_mst_center where kd_center = ? ", [(string) ($kdcbg)]);

$resource_ambil_center = db_query_or_die('errro_21', $query_ambil_center, $__p_query_ambil_center ?? []);
while ($row_center=  db_fetch($resource_ambil_center, PDO::FETCH_NUM))
		{
		$nm_center = $row_center[0];
		$alamat_center = $row_center[1];
		$phone = $row_center[2];
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>SF<?php echo e($kdb)?></title>
	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
	<style type="text/css">
	.style24 {	color: #030303;
	font-size:90%;	
}
    </style>
<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>
</head>
<body>
<div id="page-wrap">
  <textarea id="header">SERVICE FEE RECEIPT</textarea>
		<div id="identity2">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
		    <tbody>
		      <tr>
		        <td width="50%">Number  :<strong><?php echo e($id_prof_bill); ?><br />
	            </strong>Date : <strong><?php echo e($dt_paid)  ?></strong></td>
		        <td align="right"><img src="../imgs/ves.jpg" width="101" height="66" alt=""/></td>
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
                <td align="right" class="meta-head">Received  From</td>
                <td>: <strong><?php echo e($student_name); ?> [<?php echo e($nik); ?>]</strong></td>
              </tr>
              <tr>
                <td align="right" class="meta-head">Payment for</td>
                <td><strong>: Service Fee</strong></td>
              </tr>
              <tr>
                    <td width="116" align="right" class="meta-head">Received Date</td>
                    <td width="172"><strong><span class="style24">: <?php echo e($tgl_cetak) ; ?></span></strong></td>
            </tr>
              <tr>
                <td align="right" class="meta-head">Payment Method</td>
                <td>: <strong><span class="style24"><?php echo e($pay_mtd) ?></span></strong></td>
              </tr>
          </table>
	  </div>
  <table id="items">
		  <tr>
		      <th colspan="3">Institution</th>
		      <th width="244">Amount</th>
		  </tr>
		  <tr class="item-row">
	        <td colspan="3" class="item-name"><strong><?php echo e($school_dest); ?></strong> <strong><?php echo e($country_dest) ?></strong></td>
	        <td align="right"><span class="price"><span class="style24"><?php echo e($curr); ?></span><?php echo number_format(num($rp_mount),0,".",".") ?></span></td>
		  </tr>
		  <tr>
		      <td width="438" class="blank"> </td>
		      <td colspan="2" class="total-line balance"><strong>Total</strong></td>
		      <td class="total-value balance" align="right"><span class="price"><strong><span class="style24"><?php echo e($curr); ?> <?php echo number_format(num($rp_mount),0,".",".") ?></span></strong></span></td>
		  </tr>
		  <tr class="item-row">
		    <td colspan="3" class="item-name">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr class="item-row">
		    <td colspan="4" class="item-name"><strong><em><?php echo e($terbilang); ?> Rupiah</em></strong><br />
	        <strong><span class="style24"><?php echo e($st_refund) ?></span></strong></td>
	      </tr>
		</table>
	  <br />
  <table width="100%"id="itemsa">
    <tbody>
	      <tr>
	        <td width="50%">Received  By<br/>
              <br/>
              <br/>
            <strong><?php echo e($pic); ?></strong><br /></td>
	        <td width="50%" align="right">Student Name<br/>
              <br/>
              <br/>
            <strong><?php echo e($student_name); ?></strong><br /></td>
          </tr>
        </tbody>
  </table>
	  <h5 align="center" class="item-name"><strong><?php echo e($nm_center) ?><small><br />
            <span style="font-size: 10px;"><?php echo e($alamat_center) ?><br />
            <?php echo e($phone) ?></span></small></strong><br/></h5>
	  <hr><br/>

</div>
</body>
</html>