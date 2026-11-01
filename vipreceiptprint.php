<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
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
	
$query_ambil_center = q_set($__p_query_ambil_center, "select center, alamat,phone from tb_mst_center where kd_center = ? ", [(string) ($kdcbgg)]);

$resource_ambil_center = db_query_or_die('errro_21', $query_ambil_center, $__p_query_ambil_center ?? []);
while ($row_center=  db_fetch($resource_ambil_center, PDO::FETCH_NUM))
		{
		$nm_center = $row_center[0];
		$alamat_center = $row_center[1];
		$phone = $row_center[2];
		}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>  body {
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 21cm;
        min-height: 15cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 1cm;
        border: 5px red solid;
        height: 256mm;
        outline: 2cm #FFEAEA solid;
    }
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }</style>    
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<body class="A4">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php   //   include __DIR__ . "/left.php";	 ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

   <!-- Main content -->
<section class="content">

  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
<input type="text" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="text" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">

  <input type="text" ang="en-150"   name="st" hidden="hidden" 
                 	      value="<?php echo e($st) ?>" >

  <input type="text" ang="en-150"   name="idb" hidden="hidden" 
                 	      value="<?php echo e($idb) ?>" >

  <input type="text" ang="en-150"  name="kdcbg2" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
                 	      
<div class="col-md-12">
    <table width="25%" class="table table-borderless" id="example">
      <tbody>
        <tr>
          <td height="14" align=center><img src="imgs/ves.jpg" width="146" height="89" alt=""/>
           </td>
          <td height="14" align=center> <h3>VIP Receipt</h3>
            <small><strong>Receipt Number : </strong><?php echo e($id_receipt) ?><br>
          <?php echo e($tgl_cetak) ?></small></h2>
          <br></td>
          <td height="14" align=center><img src="imgs/viplog.png" width="114" height="68" alt=""/></td>


        </tr>
        <tr>
          <td width="285" rowspan="4" align=left class="style24"><p style="font-size: 10px;"><strong><br>
            <br>
            REFUND POLICY<br>
          </strong>1. Registration fee, Down Payment and Installment are NON-REFUNDABLE<br>
            <br>
            2. f a student cancels his/her class, the refund policy will be as follows :<br>
            - 1 or 2 weeks prior to the class starting date: 50% of tuition fee <br>
            - 6 days prior to the class starting date: 25% of tuition fee <br>
            - Less than 3 days or after the class starting date: NO Refund<br>
            - 100% of tuition fee paid will be refunded if Vista English is unable to open the class within 2 (two) months following the registration.<br>
            <br>
            3. To postpone a class, notification must be made by the student at least 7 days prior to the class starting date. The paid fees will be accumulated to the very next opening class; otherwise, it will be considered as a cancellation.<br>
            <br>
            4. Notification of cancellation must be informed to a Student Consultant or Center Manager and his/her paid tuition fee is NOT TRANSFERABLE to any other person.</p></td>
          <td width="649" align=left><h5 class="style24"><small>
            <label>Received From</label>
            </small> :
            <small><?php echo e($qq_data) ?>
            <?php echo e($nama) ?></small><br>
          <small>
            <label>NIK :</label>
            </small> :
            <small><?php echo e($remark) ?></small><br>
            <small>
            <label>Payment For :</label>
  <?php echo e($jns_payment)  ?></small></small></h5></td>
          <td width="236" height="14" align=left><h5 class="style24"><small>
            <label>ID :</label>
            <?php echo e($kd_biodata) ?></small>          </small><br>
            <small>
            <label>Program</label>
            </small>:  <small><?php echo e($nm_program) ?> <?php echo e($level_program) ?> <?php echo e($type_program) ?></small><br>
          </h5></td>
        </tr>
        <tr>
          <td colspan="2" align=left class="style24"><span class="form-group"><small>
          <label>Amount :</label>
          </small> <small> Rp. <?php echo number_format(num($amount),0,".",".")    ?> (<?php echo e($pay_mtd)  ?>) </small></span><br>
          <span class="form-group"><small>
          <label>Date Received :</label>
          </small><small><?php echo e($dt_payment)  ?></small></span><br>
          </small></td>
        </tr>
        <tr>
          <td colspan="2" align=left class="style24"><small><strong><?php echo e($terbilang); ?> Rupiah</strong><br><small>
			  The next payment must be made before : <strong><?php echo e($next_payment) ?><br>
			  <br>
			  </strong>
			  <input type="checkbox" name="checkbox" id="checkbox">
I have understood and agreed to the terim & condition of Refund Policy
</label>
<strong>		  </strong>
          </small></small></td>
        </tr>
        <tr>
          <td height="61" align=left class="style24"><small><br>
          <br>
          <?php echo e($nama) ?></small></td>
          <td height="61" align=right class="style24"><small>Received By : <br>
          <br>          
          <?php echo e($nama_lengkap) ?><br>
          </small></td>
        </tr>
        <tr>
          <td height="14" colspan="3" align=center class="style24"><strong><small><?php echo e($nm_center) ?>
            Office : <?php echo e($alamat_center) ?><br>
          Phone : <?php echo e($phone) ?></small></strong>          </td>
        </tr>
      <tfoot>
      </tfoot>
    </table>
</div>
</body>
</html>
<?php 
if (isset($_GET['Save'])) 
	{
	
	}
?>