<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ob_start();
ini_set('memory_limit', '150M'); ?>
<?php 
include __DIR__ . "/conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";



$nmsc = in_val('nmsc', 'get');
$da = in_val('da', 'get');
$de = in_val('de', 'get');
$kdc = in_val('kdc', 'get');
$dat = "$da 00:00:00";
$det = "$de 23:00:00";
$query_billing = q_set($__p_query_billing, "SELECT b.nama_lengkap, a.kd_billing, a.nama_sc, a.kelas, nm_program, type_program , private_pax, net_tf,a.nominal, st_reward  FROM ves_data.ve_incentive a\r
left join vip_billing c on a.kd_biodata = c.kd_biodata\r
left join vip_student_data b on a.kd_biodata = b.kd_biodata\r
left join vip_mst_code_prg d on c.kd_program = d.kd_program where st_reward = 3  and nama_sc = ? and  a.kd_branch = ? and start_kelas between ? and  ? group by a.no\r
", [(string) ($nmsc), (string) ($kdc), (string) ($dat), (string) ($det)]);	
$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);	

?>
<!DOCTYPE html>
<html>
<head>

<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-size:xxx-small;	
	}
-->
.style32 {
	color:#000;
	font-size:80%;
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
	    .tbl{
     width: 1500pt;
     border: 1px solid #000;
    }
</style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>

  <!-- 

 
 side column. contains the logo and sidebar -->

  <table width="1500" class="tbl" >
        <thead><small>
	          <tr>
	            <td height="14" colspan="6" align=center ><strong>VE INCENTIVE CLAIM FORM</strong></td>
            </tr>
	          <tr>
	            <td align=center >&nbsp;</td>
	            <td align=left >&nbsp;</td>
	            <td height="14" align=left >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
        </tr>
	          <tr>
	            <td align=center >&nbsp;</td>
				  <td align=left ><small>SC Name :</small> <?php echo e($nmsc) ?></td>
	            <td height="14" align=left ><small>PAX : <?php echo e($keluar_billing) ?></small></td>
	            <td align=center >&nbsp;</td>
	            <td align=left >&nbsp;</td>
	            <td align=center >&nbsp;</td>
            </tr>
	          <tr>
	            <td align=center >&nbsp;</td>
	            <td align=left >Claim Period : <?php echo e($da) ?> to <?php echo e($de) ?></td>
	            <td height="14" align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
            </tr>
	          <tr>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td height="14" align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
            </tr>
	          <tr>
	            <td width=6% align=center >No</td>
	            <td width=31% align=center >Student Name</td>
	            <td width=17% height="14" align=center >Class Program</td>
	            <td width="19%" align=center >Net Tuition Fee</td>
	            <td width="14%" align=center >Paid</td>
	            <td width="13%" align=center > Reward</td>
              </tr></small>
            </thead>
		<?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   /* echo $query_billing (debug SQL versi lama) dihapus */
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	        <tbody>
          <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, a.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.no desc" ;
//$query_billing = "SELECT a.kd_billing,b.nm_program, a.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.kd_program,a.kd_branch FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata and a.kd_branch = c.kd_branch where a.sc = '$nama_lengkap 'and  a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.no desc" ;	
				

			
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{

		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> '' and \r
\t\t(jns_payment = 'Full Payment' or jns_payment = 'Installment 1' or jns_payment = 'Installment 2' or  jns_payment = 'Installment 3' )  ", [(string) ($row_billing[1])]);
		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar = $row_bayar[0];	
				}
			}	
		$type_program = $row_billing[7];
		$jml_pax = $row_billing[8];
					$nomor_asli = $row_incentive['0'];
					$st_reward = $row_incentive['12'];
					$besar_reward = $row_incentive['4'];
						$query_update_reward = q_set($__p_query_update_reward, "update ves_data.ve_incentive set nominal = ? ,st_reward = 1 where no = ? ", [(string) ($besar_reward), (string) ($nomor_asli)]);
						$resource_update_reward = db_query_soft($query_update_reward, $__p_query_update_reward ?? []);
						
	?>
	          <tr><small>
	            <td align=center class="style24"><?php echo e($no_urut) ?></td>
	            <td align=center class="style24">
	            <?php echo e($row_billing[0]) ?><br>
	            <?php echo e($row_billing[1]) ?></td>
	            <td height="14" align=center class="style24"><?php echo e($row_billing[3]) ?> <br>	              
	              <?php echo e($row_billing[4]) ?> <?php echo e($row_billing[5]) ?> <?php echo e($row_billing[6]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[7])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($mbayar),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($row_billing[8]),0,".",".") ?></td>
	            </small></tr>
             <?php $no_urut = num($no_urut) +1;$status_tampil='';								$st_reward =0; }} ?>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
   	  <br>
   	  <!-- /.box-body -->

</body>
</html>
<?php
    $content = ob_get_clean();
	$namafile = "ve_inc.kimberly.pdf";
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
