<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();  
ob_start();
ini_set('memory_limit', '150M');
?>
<?php 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
//include __DIR__ . "/atas.php";
//include __DIR__ . "/left.php";
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$sales_year = '26';
$kd_cbg = in_val('kd_cbg', 'get');



$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$week = in_val('week', 'get');
$query = q_set($__p_query, "SELECT no_week, tgl_periode, bulan FROM master_date where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);

$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$urut_week= $row[0];
		$tgl_periode = $row[1];
	}
}
$sql = q_set($__p_sql, "SELECT  min(detail), max(detail),date_format(detail,'%Y-%m') ,date_format(detail,'%Y'), date_format(min(detail),'%d %b %Y'), date_format(max(detail),'%d %b %Y')  FROM ves_data.tb_minggu_detail where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);
$rs = db_query_soft($sql, $__p_sql ?? []);
while($row = db_fetch($rs))
{
	$awal_mgg= $row[0];
	$akhir_mgg = $row[1];
	$dtl_bln = $row[2];
	$dtl_thn = $row[3];
	$awal_tampil = $row[4];
	$akhir_tampil = $row[5];
	
	$awal_bln = "$dtl_bln-01";
	$awal_thn = "$dtl_thn-01-01";
	
}
$dt_today = in_val('dt_today', 'get');
$thnn = substr($dt_today,0,4);
$blnn = substr($dt_today,0,7);
$awal_bln = "$blnn-01";

$awal_thn = "$thnn-01-01";
    $source = $dt_today;
    $date_tgl = new DateTime($source);
    $date_tgl =  $date_tgl->format('d M Y'); // 31-07-2012
?>


      <!-- Content Header (Page header) -->
      

      <!-- Main content -->
     
            <!-- /.box-header -->
            
  <table width="100%" border="0"  align="center">
             
                <tr >
                  <th height="23" colspan="20" style="text-align: center; font-size: 20px">VIP English  Payment Report</th>
                  </tr>
                <tr >
                  <th colspan="20" style="text-align: center"><strong><span style="font-size: 15">Periode</span> : <?php echo e($date_tgl) ?></strong></th>
                  </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="6" style="text-align: center";>Daily</th>
                  <th colspan="6" style="text-align: center">Monthly</th>
                  <th colspan="6" style="text-align: center">Yearly</th>
                  </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  </tr>
                <tr style="font-size: 1em">
                  <th width="3%">No</th>
                  <th width="15%">Center</th>
                  <th width="3%">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%">Pax</th>
                  <th width="5%">Amount</th>
                  </tr>
<tr >
                  <th height="20"><?php echo e($no_urut) ; ?></th>
                  <th><?php echo e($nama_cabang) ; ?>
                  <th><?php echo e($reg_pax_w) ; ?></th>
                  <th style="text-align: right" ><?php echo   number_format(num($reg_amount_w),0,".",".")  ; ?></th>
                  <th><?php echo e($tf_pax_w); ?></th>
                  <th><?php echo   number_format(num($tf_amount_w),0,".",".")  ; ?></th>
                  <th><?php echo e($reg_pax_cl_w) ; ?></th>
                  <th style="text-align: right"><?php echo   number_format(num($reg_amount_cl_w),0,".",".")  ; ?></th>

                  <th><?php echo e($reg_pax_m) ; ?></th>
                  <th style="text-align: right"><?php echo   number_format(num($reg_amount_m),0,".",".")  ; ?></th>
                  <th><?php echo e($tf_pax_m); ?></th>
                  <th style="text-align: right"><?php echo   number_format(num($tf_amount_m),0,".",".")  ; ?></th>
                  <th><?php echo e($reg_pax_cl_m) ; ?></th>
                  <th style="text-align: right"><?php echo   number_format(num($reg_amount_cl_m),0,".",".")  ; ?></th>
					
                  <th><?php echo e($reg_pax_y) ; ?></th>
                  <th style="text-align: right"><?php echo   number_format(num($reg_amount_y),0,".",".")  ; ?></th>
                  <th><?php echo e($tf_pax_y); ?></th>
                  <th  style="text-align: right"><?php echo   number_format(num($tf_amount_y),0,".",".")  ; ?></th>
                  <th><?php echo e($reg_pax_cl_y) ; ?></th>
                  <th style="text-align: right"><?php echo   number_format(num($reg_amount_cl_y),0,".",".")  ; ?></th>				
                  </tr>	  
              
</table>
   <?php
    $content = ob_get_clean();
	$namafile = "enrollmentform.$kode_student.pdf";
    // convert in PDF
    require_once VCMS_ROOT . '/_lib/html2pdf.php';   // spipu/html2pdf 5.x (pengganti html2pdf/ lama)
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
 		$html2pdf->setTestTdInOnePage(false);   // dulu salah ketik setTestthInOnePage (fatal)		
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($namafile);
    }
    catch(HTML2PDF_exception $e) {
        html2pdf_fail($e);
    }
?>