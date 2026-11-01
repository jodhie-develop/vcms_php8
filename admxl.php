<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
$query = q_set($__p_query, $_SESSION['query_xl'] ?? '', $_SESSION['query_xl__p'] ?? []);

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=admxl.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
/* $query = $_GET['q'] (SQL dari URL) dihapus: query diambil dari sesi */
$no_urut_week = 1;
$query = q_set($__p_query, $_SESSION['query_xl'] ?? '', $_SESSION['query_xl__p'] ?? []);

$result_twi=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);?>    

               <table width="87%" class="table table-bordered table-striped" id="example1"> 
<thead>
   <tr>
     <td width=41 rowspan="3" align=center >No</td>
     <td width=63 rowspan="3" align=center >Nama</td>
     <td width=65 rowspan="3" align=center >Enroll Date </td>
     <td width="63" rowspan="3" align=center >Sales Year</td>
     <td height="14" colspan="9" align=center >Destination</td>
     <td height="14" colspan="6" align=center >Admission Status<br></td>
     <td height="14" colspan="3" align=center >Admission Progress Log</td>
     <td width="58" rowspan="3" align=center >Intake Date</td>
     <td width="35" rowspan="2" align=center >AC</td>
     <td width="59" rowspan="3" align=center >Tuition Info </td>
     <td width="59" rowspan="3" align=center >Last Update</td>
     </tr>
   <tr>
     <td width="74" rowspan="2" align=center >Country</td>
     <td width="74" rowspan="2" align=center >School </td>
     <td width="78" rowspan="2" align=center >Program</td>
     <td width="38" rowspan="2" align=center >Major</td>
     <td width="38" rowspan="2" align=center >P<br>
     /NP</td>
     <td width="58" rowspan="2" align=center >H<br>
       /AD<br>
       /STEM<br>
     /NON</td>
     <td width="33" rowspan="2" align=center ><p>N/</p>
       <p>R/</p>
       <p>A</p></td>
     <td width="52" rowspan="2" align=center >Main<br>
       /Ad<br>
     /Lang</td>
     <td width="42" rowspan="2" align=center >Star</td>
     <td width="40" rowspan="2" align=center >ON </td>
     <td width="35" rowspan="2" align=center >PR</td>
     <td width="46" rowspan="2" align=center >PDO</td>
     <td width="33" rowspan="2" align=center >L</td>
     <td width="33" rowspan="2" align=center ><p>C</p>
       <p>&nbsp;</p></td>
     <td width="33" rowspan="2" align=center >1L</td>
     <td width="49" rowspan="2" align=center > Step </td>
     <td width="69" rowspan="2" align=center > Remark </td>
     <td width="56" rowspan="2" align=center >Next Follow<br>
       Up </td>
   </tr>
   <tr>
     <td height="14" align=center >SC</td>
     </tr></thead><tbody>
<?php

   if ($result_twi) 
	{ 
	
	while ($r_dtl = db_fetch($result_twi))
		{
		$enroll_convert= strtotime($r_dtl[3]);
		if ($enroll_convert >= $awal_y0)
			{
			if($enroll_convert <= $akhir_y0)
				{
				$kode_thn = "C";
				$tahun_0 ="1";
				$total_tahun_0_tw = num($total_tahun_0_tw) + 1;
				}
			}
		elseif ($enroll_convert >= $awal_y1)
			{
			if($enroll_convert <= $akhir_y1)
				{
				$kode_thn = "-1";				
				$tahun_1 ="1";
				$total_tahun_1_tw = num($total_tahun_1_tw) + 1;
				}			
			}
		elseif ($enroll_convert >= $awal_y2)
			{
			if($enroll_convert <= $akhir_y2)
				{
				$kode_thn = "-2";
				$tahun_2 ="1";
				$total_tahun_2_tw = num($total_tahun_2_tw) + 1;
				}			
			}
		elseif ($enroll_convert >= $awal_y3)
			{
			if($enroll_convert <= $akhir_y3)
				{
				$kode_thn = "-3";				
				$tahun_3 ="1";
				$total_tahun_3_tw = num($total_tahun_3_tw) + 1;
				}			
			}
		elseif ($enroll_convert >= $awal_y4)
			{
			if($enroll_convert <= $akhir_y4)
				{
				$kode_thn = "-4";
				$tahun_4 ="1";
				$total_tahun_4_tw = num($total_tahun_4_tw) + 1;
				}			
			}

		if (substr($r_dtl[13],0,2) == 'ON')
		{
		$grd = '1';
		}
		elseif (substr($r_dtl[13],0,2) == 'TW')
		{
		$grd = '2';

		}
		elseif (substr($r_dtl[13],0,2) == 'TH')
		{
		$grd = '3';

		}
		elseif (substr($r_dtl[13],0,2) == 'FO')
		{
		$grd = '4';

		}

		elseif (substr($r_dtl[13],0,2) == 'FI')
		{
		$grd = '5';

		}	
		else
		{$grd = '1';}
				  ?>
     <tr>
     <td align=center  class="style49"><?php echo e($no_urut_week) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[2]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[25]) ?></td>
     <td  width="63"  align=center  class="style49"><?php echo e($kode_thn) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[4]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[5]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[6]) ?><br>
     <td align=center  class="style49"><?php echo e($r_dtl[7]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[8]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[10]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[11]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[12]) ?></td>
     <td align=center  class="style49"><?php echo e($grd) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[14]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[15]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[16]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[17]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[18]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[19]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[20]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[21]) ?></td>
     <td align=center  class="style49">&nbsp;</td>
     <td align=center  class="style49"><?php echo e($r_dtl[22]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[23]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[24]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[26]) ?></td>
     </tr>
      <?php $no_urut_week = num($no_urut_week) +1;}
 		} 
?>             
   </tbody>
<tfoot>
                </tfoot>
 </table>