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

$query_adm = q_set($__p_query_adm, "SELECT concat_ws(' ',nm_stu, middle_name, family_name), country_dest, school_dest, curr, rp_mount, terbilang, pic, id_prof_bill, date_format(tgl_cetak,'%d %b %Y'),pic,pay_mtd,st_refund FROM ves_inc.tb_prof_bill where id_stu = ? and country_dest = ? and school_dest = ? order by no desc limit 1", [(string) ($kdb), (string) ($cd), (string) ($sd)]);

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

//==
//echo $string;
?>
<!DOCTYPE html>
<html>
<style type="text/css">
<!--
.style24 {
	color: #030303;
	font-size:90%;	
	}
-->
.style32 {
	color:#000;
	font-size:70%;
	}
-->
	.style33 {
	color:#000;
	font-size:75%;
	}
-->
	.style34 {
	color:#000;
	font-size:80%;
	}
-->	
	.stylekop {
	color:#000;
	font-size:150%;
	}
-->		
	    .tbl{
     width: 700pt;
     border: 1px solid #000;
    }
</style>
<head>


</style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<body class="A4">
<body class="hold-transition skin-blue sidebar-mini">

  
    <table width="826" id="">

	        <tbody>

	          <tr>
	            <td align=center  class="style34">&nbsp;</td>
	            <td height="14" align=center  class="style34">&nbsp;</td>
	            <td height="14" colspan="2" align=center  class="stylekop">&nbsp;</td>
	            <td height="14" align=center  class="style34">&nbsp;</td>
              </tr>
	          <tr>
	            <td align=center  class="style34">&nbsp;</td>
	            <td rowspan="2" align=center  class="style34"><img src="imgs/ves.jpg" width="104" height="63" alt=""/></td>
	            <td height="14" colspan="2" align=center  class="stylekop">&nbsp;</td>
	            <td height="14" align=center  class="style34">&nbsp;</td>
              </tr>
	          <tr>
	            <td align=center  class="style34">&nbsp;</td>
	            <td height="14" colspan="2" align=center  class="stylekop"><strong> VISTA OVERSEAS SERVICES<br></strong></td>
	            <td height="14" align=center  class="style34">&nbsp;</td>
              </tr>
	          <tr>
	            <td align=center  class="style34">&nbsp;</td>
	            <td height="14" align=center  class="style34">&nbsp;</td>
	            <td height="14" colspan="2" align=center  class="style34"><strong>RECEIPT<br>
                <strong><?php echo e($id_prof_bill); ?></strong>	            </strong></td>
	            <td height="14" align=center  class="style34">Date Receipt<br>
                <strong><strong><?php echo e($tgl_cetak); ?></strong></strong> <br></td>
              </tr>
	          <tr>
	            <td width="61" align=center  class="style34">&nbsp;</td>
	            <td width="130" height="14" align=center  class="style34"><p>&nbsp;</p></td>
	            <td height="14" colspan="2" align=center  class="style34">&nbsp;</td>
	            <td width="151" height="14" align=center  class="style34">&nbsp;</td>
              </tr>
	          <tr>
	            <td height="14" colspan="5" align=left   class="style34" >&nbsp;</td>
              </tr>
	          <tr>
	            <td align=left   class="style24" >&nbsp;</td>
	            <td height="24" align=left   class="style24" >Received From</td>
	            <td height="24" colspan="2" align=left   class="style34" ><strong><?php echo e($student_name); ?></strong></td>
	            <td height="24" align=left   class="style34" >&nbsp;</td>
              </tr>
	          <tr>
	            <td align=left    class="style24" valign="top">&nbsp;</td>
	            <td height="21" align=left    class="style24" valign="top">Payment For</td>
	            <td height="21" colspan="2" align=left   class="style24" ><strong><?php echo e($school_dest); ?><br>
                <?php echo e($country_dest) ?><br>
	            </strong></td>
	            <td height="21" align=left   class="style34" >&nbsp;</td>
              </tr>
	          <tr>
	            <td align=left   class="style24" >&nbsp;</td>
	            <td height="21" align=left   class="style24" >Sum of Money</td>
	            <td height="21" colspan="2" align=left   class="style24" ><strong><span class="style24"><?php echo e($curr); ?>  <?php echo number_format(num($rp_mount),0,".",".")?> (<?php echo e($pay_mtd) ?>) - <?php echo e($st_refund) ?></span></strong></td>
	            <td height="21" align=left   class="style34" >&nbsp;</td>
              </tr>
	          <tr>
	            <td align=left   class="style24" >&nbsp;</td>
	            <td height="27" align=left   class="style24" >&nbsp;</td>
	            <td height="27" colspan="2" align=left   class="style34" ><strong> <?php echo e($terbilang); ?> Rupiah</strong></td>
	            <td height="27" align=left   class="style34" >&nbsp;</td>
              </tr>
	          <tr>
	            <td align=left   class="style24" >&nbsp;</td>
	            <td height="14" align=left   class="style24" >Date</td>
	            <td height="14" align=left   class="style34" ><strong><span class="style24"><?php echo e($tgl_cetak) ; ?></span></strong></td>
	            <td height="14" align=left   class="style34" >&nbsp;</td>
	            <td height="14" align=left   class="style34" >&nbsp;</td>
              </tr>
	          <tr>
	            <td align=left   class="style24" >&nbsp;</td>
	            <td height="14" align=left   class="style24" >&nbsp;</td>
	            <td width="294" height="14" align=left   class="style34" >&nbsp;</td>
	            <td width="166" height="14" align=left   class="style34" >&nbsp;</td>
	            <td height="14" align=left   class="style34" >&nbsp;</td>
              </tr>
	          <tr>
	            <td align=left   class="style24" >&nbsp;</td>
	            <td height="14" align=left   class="style24" >Received By</td>
	            <td height="14" align=left   class="style34" >&nbsp;</td>
	            <td height="14" align=left   class="style34" >&nbsp;</td>
	            <td height="14" align=left   class="style34" >&nbsp;</td>
              </tr>
	          <tr>
	            <td align=left   class="style24" >&nbsp;</td>
	            <td height="14" align=left   class="style24" >&nbsp;</td>
	            <td height="14" align=center   class="style34" ><strong><?php echo e($pic); ?><br>
	              (Admin)
	            </strong></td>
	            <td height="14" align=center   class="style34" ><strong><?php echo e($student_name); ?><br>
	              (Student)
	            </strong></td>
	            <td height="14" align=left   class="style34" >&nbsp;</td>
              </tr>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
    <br>
<br>
<br>
       	 
   	  <br>
   	  <!-- /.box-body -->

</body>
</html>
<?php
//    $content = ob_get_clean();
//	$namafile = "ocp.$kode_student.pdf";
    // convert in PDF
 //   require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
  //  try
    //{
      //  $html2pdf = new HTML2PDF('P', 'A4', 'en');
 	//	$html2pdf->setTestTdInOnePage(false);		
     //   $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
      //  $html2pdf->Output($namafile);
   // }
    //catch(HTML2PDF_exception $e) {
     //   echo $e;
     //   exit;
    //}
?>
