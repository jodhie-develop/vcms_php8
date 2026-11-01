<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
ob_start();
ini_set('memory_limit', '150M'); ?>
<?php 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$no = in_val('no', 'get');
$idb = in_val('idb', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$query_ambil_billing = q_set($__p_query_ambil_billing, "select b.nama_lengkap, b.nama_lengkap, b.nama_lengkap,   a.kd_biodata, a.jns_payment, a.amount, a.pay_mtd,\r
DATE_FORMAT(a.dt_payment, '%M %d, %Y'), DATE_FORMAT(a.next_payment, '%M %d, %Y'), a.kd_billing,d.nm_program, d.level_program,\r
d.type_program,a.id_receipt,DATE_FORMAT(a.dt_cetak, '%M %d, %Y'),qq_data,remark,a.kd_branch FROM ves_data.vip_billing_payment a\r
left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata\r
left join ves_data.vip_billing c on a.kd_billing = c.kd_billing\r
left join ves_data.vip_mst_code_prg d on c.kd_program = d.kd_program and c.level_program = d.level_program  where a.no = ? ", [(string) ($no)]);

$resource_ambil_billing = db_query_or_die('errro_1', $query_ambil_billing, $__p_query_ambil_billing ?? []);
while ($row_billing=  db_fetch($resource_ambil_billing, PDO::FETCH_NUM))
		{
		$nama = $row_billing['0'];
		$middle_name = $row_billing['1'];
		$family_name = $row_billing['2'];
		$kd_biodata = $row_billing['3'];
		$jns_payment = $row_billing['4'];
		$amount = $row_billing['5'];
		$pay_mtd = $row_billing['6'];
		$dt_payment = $row_billing['7'];
		$next_payment = $row_billing['8'];
		$kd_billing = $row_billing['9'];
		$nm_program = $row_billing['10'];
		$level_program = $row_billing['11'];
		$type_program = $row_billing['12'];
		$id_receipt = $row_billing['13'];
		$tgl_cetak = $row_billing['14'];	
		$qq_data = $row_billing['15'];	
		$remark = $row_billing['16'];
		$kdcbgg = $row_billing['18'];
		$type_program = $row_billing[12];
		} 
	$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kd_biodata)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
		while ($row_nik  =  db_fetch($resource_nik, PDO::FETCH_NUM))
			{
			$nik = $row_nik[0];
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
 $terbilang = convertNumber($amount);

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
$nama_file = "$id_receipt-$nama-$nm_program-$level_program($jns_payment)";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title><?php echo e($nama_file)?></title>
	
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
  <textarea id="header">RECEIPT</textarea>
		<div id="identity2">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
		    <tbody>
		      <tr>
		        <td width="15%"><?php if ($nm_program != 'CA' and $nm_program !='WSC'  and $level_program !='Champions Battle'  and $nm_program !='Champions Battle' and $type_program !='GLBRD' and $type_program !='CA CoT'){?> <img src="../imgs/ves.jpg" width="101" height="66" alt=""/> <?php } ?></php></td>
		        <td width="71%" align="center">Receipt Number  :<strong><small><?php echo e($id_receipt) ?></small><br />
                </strong>Date : <strong><small><?php echo e($tgl_cetak) ?></small></strong></td>
		        <td width="14%" align="right"><?php if ( $type_program  =='FELLOWS ACADEMY') {?><img src="../imgs/fa_logo.png" width="210" height="66" alt=""/><?php }
 elseif ($nm_program != 'CA' and $nm_program !='WSC'  and $level_program !='Champions Battle'  and $nm_program !='Champions Battle' and $type_program !='GLBRD' and $type_program !='CA CoT'){?><img src="../imgs/viplog.png" width="101" height="66" alt=""/><?php } else {?><img src="../imgs/LogoCA.png" width="101" height="66" alt=""/> <?php } ?></td>
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
<?php if ($nm_program =='WSC Global Round-VIETNAM' or $nm_program =='WSC Global Round BANGKOK') { ?>
				                 <td width="313" rowspan="4" align="right" class="meta-head">
				                   <p style="font-size: 10px;"><strong>REFUND POLICY<br />
                <br />
                Regular Class:</strong><br /> 
                To postpone a class, notification must be made by the student at least 7 days before the class starting date. The paid fees will be accumulated to the very next opening class; otherwise, it will be considered a cancellation class. This paid tuition fee is not transferable to any other person.  

                <strong><br />
                <br />
                Refund of AYIMUN/WSC Package Funds</strong> <br />
                Students who register for AYIMUN/WSC through Champions Academy and are subsequently not accepted into AYIMUN/WSC are eligible for a refund of the package funds.
The refund will be processed within 14 working days after confirmation of the student's non-acceptance by AYIMUN/WSC.               </p>
				                   <p style="font-size: 10px;"><br /> 
				                     <strong>Non-Refundable Registration Fee </strong><br />
                The registration fee paid to Champions Academy is non-refundable under all circumstances. This fee covers administrative costs, guidance, and support provided during the application process.

                <strong>Cancellation by the Student </strong><br />
                If  a student cancels their participation in AYIMUN/WSC:
Any fees already paid to third-party providers (e.g., travel, accommodation, event organizers) are non-refundable.
Any fees that have not yet been paid to third parties will be refunded.
A cancellation fee of 10% of the total package cost will be applied.

                <br />
                <strong><br />
                Credit for Future Programs <br />
                </strong>The 10% cancellation fee collected will be credited to the student’s account and can be used for other programs offered by Champions Academy within 12 months.
                <br />
                <br />
Notification of cancellation must be informed to a Student Consultant or Center Manager and his/her paid tuition fee is NOT TRANSFERABLE to any other person.</p></td> 
<?php } elseif ($level_program == 'PWAANATION') { ?>
				                 <td width="313" rowspan="4" align="right" class="meta-head">
				                   <p style="font-size: 10px;"><strong>REFUND POLICY<br />
                <br />
				                   1. The Registration Fee and Placement Test Fee are non-refundable.</strong><br />
				                   <br />
                                   <strong>2. If a student cancels their class enrollment, the refund policy is as follows:</strong><br />
                a. Cancellation made more than 2 weeks before the class start date: 100% of the<br />
                tuition fee paid will be refunded<br />
                b. Cancellation made 1 to 2 weeks before the class start date: 50% of the tuition fee<br />
                paid will be refunded.<br />
                c. Cancellation made 6 days before the class start date: 25% of the tuition fee paid<br />
                will be refunded.<br />
                d. Cancellation made less than 3 days before, or after, the class start date: No refund.<br />
                If Champions Academy is unable to start the class within 3 (three) months after registration<br />
                date, then 100% of the tuition fee paid will be refunded.<br />
                To postpone a class, students must notify the center at least 7 days before the class<br />
                start date. Any fees paid will be applied to the next available class. If the student<br />
                does not attend the next class, the postponement will be considered a cancellation.<br />
                Cancellation notifications must be submitted to a Student Consultant or the Center<br />
                Manager. Tuition fees are non-transferable to another person.</p></td> 
					  
				  
<?php } elseif ($nm_program =='WSC Global Round-VIETNAM' or $nm_program =='WSC Global Round BANGKOK') { ?>
				                 <td width="313" rowspan="4" align="right" class="meta-head">
				                   <p style="font-size: 10px;"><strong>REFUND POLICY<br />
                <br />
                Regular Class:</strong><br /> 
                To postpone a class, notification must be made by the student at least 7 days before the class starting date. The paid fees will be accumulated to the very next opening class; otherwise, it will be considered a cancellation class. This paid tuition fee is not transferable to any other person.  

                <strong><br />
                <br />
                Refund of AYIMUN/WSC Package Funds</strong> <br />
                Students who register for AYIMUN/WSC through Champions Academy and are subsequently not accepted into AYIMUN/WSC are eligible for a refund of the package funds.
The refund will be processed within 14 working days after confirmation of the student's non-acceptance by AYIMUN/WSC.               </p>
				                   <p style="font-size: 10px;"><br /> 
				                     <strong>Non-Refundable Registration Fee </strong><br />
                The registration fee paid to Champions Academy is non-refundable under all circumstances. This fee covers administrative costs, guidance, and support provided during the application process.

                <strong>Cancellation by the Student </strong><br />
                If  a student cancels their participation in AYIMUN/WSC:
Any fees already paid to third-party providers (e.g., travel, accommodation, event organizers) are non-refundable.
Any fees that have not yet been paid to third parties will be refunded.
A cancellation fee of 10% of the total package cost will be applied.

                <br />
                <strong><br />
                Credit for Future Programs <br />
                </strong>The 10% cancellation fee collected will be credited to the student’s account and can be used for other programs offered by Champions Academy within 12 months.
                <br />
                <br />
Notification of cancellation must be informed to a Student Consultant or Center Manager and his/her paid tuition fee is NOT TRANSFERABLE to any other person.</p></td> 
<?php } else { ?>
                <td width="313" rowspan="4" align="right" class="meta-head">
				<span style="font-size: 10px;"><strong>REFUND POLICY<br />
                <br />
                </strong>1. Registration fee, Down Payment and Installment are NON-REFUNDABLE<br />
                <br />
                2. If student cancels his/her class, the refund policy will be as follows:<br />
                - 1 or 2 weeks prior to the class starting date: 50% of tuition fee<br />
                - 6 days prior to the class starting date: 25% of tuition fee<br />
                - Less than 3 days or after the class starting date: NO Refund <br />
                - 100% of tuition fee paid will be refunded if Vista English is unable to open the class within 3(three) months following the registration<br />
                <br />
                3. To postpone a class, notification must be made by the student at least 7 days prior to the class starting date. The paid fees will be accumulated to the very next opening class;otherwise, it bill be considered as a cancellation.<br />
                <br />
4. Notification of cancellation must be informed to a Student Consultant or Center Manager and his/her paid tuition fee is NOT TRANSFERABLE to any other person.</span></td>
<?php } ?>				  
				  
                <td align="right" valign="top">Received  From<br />
                  NIK <br />
                  Payment for</td>
                <td valign="top">: <strong><small><?php echo e($qq_data) ?> <?php echo e($nama) ?></small><br />
                  : <small><?php echo e($nik) ?></small> <br />
                : <small><?php echo e($nm_program) ?> <?php echo e($level_program) ?> <?php echo e($type_program) ?></small> <br />
                : <small><?php echo e($jns_payment) ?></small><br />
                </strong></td>
              </tr>
              <tr>
                <td align="right">Amount</td>
                <td><strong>:<span class="form-group"> <small><?php if ($type_program =='GLBRD'){ echo "$ ";} else {?> Rp. <?php } ?> <?php echo number_format(num($amount),0,".",".")    ?> (<?php echo e($pay_mtd)  ?>) </small></span></strong></td>
              </tr>
              <tr>
                <td width="143" align="right">Received Date</td>
                    <td width="328"><strong><span class="style24">: </span><small><?php echo e($dt_payment)  ?></small></strong></td>
            </tr>
              <tr>
                <td colspan="2" align="right" valign="top" ><small><strong><?php echo e($terbilang); ?> <?php if ($type_program !='GLBRD'){ ?> Rupiah <?php } else {echo "US Dollars";} ?></strong></small></td>
              </tr>
          </table>
	  </div>
	  <br />
  <table width="100%"id="itemsa">
    <tbody>
	      <tr>
	        <td width="50%">Received  By<br/>
              <br/>
              <br/>
            <small><?php echo e($nama_lengkap) ?></small><br /></td>
	        <td width="50%" align="right">Student Name<br/>
              <br/>
              <br/>
            <small><?php echo e($nama) ?></small><br /></td>
          </tr>
        </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
      <tr>
        <th scope="row" align="center"><strong><?php echo e($nm_center) ?><small><br />
        <span style="font-size: 8px;"><?php echo e($alamat_center) ?><br />
			<?php echo e($phone) ?></span></small></strong></th>
      </tr>
    </tbody>
  </table>
  <br/>
    <hr />
  <h5 align="right"><br/>
</h5>
  <h5 align="right"><br />
</h5>
</div>
</body>
</html>