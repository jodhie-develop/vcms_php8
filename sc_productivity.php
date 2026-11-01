<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
$Display = in_val('Display', 'get');
if ($date_end ==''){$date_end = $hari_ini;}
$kd_cbg = in_val('kd_cbg', 'get');
$end_date = in_val('end_date', 'get');
if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'LIUMEDIA'){$kd_cbg = 99;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}
if ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
if (num($kd_cbg) ==0){$cabang = 'ALL';}
if ($kd_cbg ==''){$cabang = 'ALL';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==99){$cabang = 'LIUMEDIA';}
if (num($kd_cbg) ==11){$cabang = 'PIK';}
if (num($kd_cbg) ==12){$cabang = 'Serpong';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kelompok = $_SESSION['kelompok'];
//if ($kelompok <> 'ACC'){$kd_cbg = $_SESSION['kd_branch'];}
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
if($end_date ==''){$end_date = $hari_ini;}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
  <h1>Sales Productivity
        (2021 - 2024)<br>
  </h1>
 
	  
 <form method=get action=#> 	  
    <table width="453" border="0">
        <tbody>
          <tr>
            <td width="148"><small>
              <label for="date3">Center :</label>
            </small></td>
            <td width="289">:
              <select name="kd_cbg"  class="style33" id="select">
                <option value="0">--CHOOSE--</option>
                <option value="0">ALL</option>				  
                <option value="1">East Sby</option>
                <option value="2">West Sby</option>
                <option value="3">Denpasar</option>
                <option value="8">Malang</option>
                <option value="101">East Area</option>
                <option value="4">South Jkt</option>
                <option value="5">North Jkt</option>
                <option value="6">West Jkt</option>
                <option value="7">Bandung</option>
                <option value="11">PIK</option>
                <option value="12">Serpong</option>				  
                <option value="102">West Area</option>
                <option value="100">National</option>
                <option value="99">LIUMEDIA</option>				  
                <option selected="selected"><?php echo e($cabang) ?></option>
              </select></td>
          </tr>
          <tr>
            <td><small>
              <label for="date3">End Date :</label>
            </small></td>
            <td><input type="date" name="end_date"  class="form-control" value = "<?php echo e($end_date)  ?>"/></td>
          </tr>
          <tr>
            <td><input name="Display" type="submit" id="Display"  class="form-control"  value="Display" /></td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
    </table>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        
	          <tr>
	            <td>
	            <td width=4% height="14" align=center >No</td>
	            <td width=11% align=center >Sales Person</td>
	            <td width=11% align=center >No</td>
	            <td width=11% align=center >Sales Year</td>
	            <td colspan="3" align=center >2021</td>
	            <td colspan="3" align=center >2022</td>
	            <td colspan="3" align=center >2023</td>
	            <td colspan="3" align=center >2024</td>
	            <td width="13%" rowspan="2" align=center >Total</td>
              </td>
            

	        <tbody>

	          <tr>
	            <td>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td width="10%" align=center class="style24">Sales</td>
	            <td width="16%" align=center class="style24">Leaving</td>
	            <td width="30%" align=center class="style24">Cancel</td>
	            <td width="13%" align=center class="style24">Sales</td>
	            <td width="13%" align=center class="style24">Leaving</td>
	            <td width="13%" align=center class="style24">Cancel</td>
	            <td width="13%" align=center class="style24">Sales</td>
	            <td width="13%" align=center class="style24">Leaving</td>
	            <td width="13%" align=center class="style24">Cancel</td>
	            <td width="13%" align=center class="style24">Sales</td>
	            <td width="13%" align=center class="style24">Leaving</td>
	            <td width="13%" align=center class="style24">Cancel</td>
	            </td>
<?php	
if ($Display != '')
{
$thnke = 1;$no_urut = 1;		
if (num($kd_cbg) ==0 or $kd_cbg == '')
{
$query_sc = q_set($__p_query_sc, "select a.cabang, a.pic, date_format(a.enroll_date, '%Y') ,count(a.kd_biodata),kd_cabang FROM tb_sales_report a  where enroll_date between '2021-01-01' and ? group by pic, kd_cabang,date_format(a.enroll_date, '%Y')  order by kd_cabang, pic,date_format(a.enroll_date, '%Y') ", [(string) ($end_date)]);	
}
else
{
$query_sc = q_set($__p_query_sc, "select a.cabang, a.pic, date_format(a.enroll_date, '%Y') ,count(a.kd_biodata),kd_cabang FROM tb_sales_report a  where   kd_cabang = ? and enroll_date between '2019-01-01' and ? group by pic, kd_cabang,date_format(a.enroll_date, '%Y') order by kd_cabang, pic,date_format(a.enroll_date, '%Y') ", [(string) ($kd_cbg), (string) ($end_date)]);	
}
$no_urut_sc=1;
$resource_sc = db_query_soft($query_sc, $__p_query_sc ?? []);			
if(num(db_num_rows($resource_sc)) > 0)
	{
	while ($row_sc  =  db_fetch($resource_sc, PDO::FETCH_NUM))
		{

		if ($sc_before != $row_sc[1]){$no_urut_sc =1;}
		$thn_sales= $row_sc[2];
		$thn_next_1 = num($thn_sales) + 1;
		$thn_next_2 = num($thn_sales) + 2;
		$thn_next_3 = num($thn_sales) + 3;
		if ($thn_sales != '2024'){
		$query_progress = q_set($__p_query_progress, "SELECT \r
\tsum(case when b.final_status = 'L' and date_format(a.enroll_date, '%Y')  = ? and date_format(b.tgl_intake,'%Y') = ? then 1 end) ,\r
\tsum(case when b.final_status = 'C' and date_format(a.enroll_date, '%Y')  = ?\tand date_format(b.update_date,'%Y') = ? then 1 end),\r
\r
\tsum(case when b.final_status = 'L' and date_format(a.enroll_date, '%Y')  = ? and date_format(b.tgl_intake,'%Y') = ? then 1 end) ,\r
\tsum(case when b.final_status = 'C' and date_format(a.enroll_date, '%Y')  = ?\tand date_format(b.update_date,'%Y') = ? then 1 end),\r
\t\r
\tsum(case when b.final_status = 'L' and date_format(a.enroll_date, '%Y')  = ? and date_format(b.tgl_intake,'%Y') = ? then 1 end) ,\r
\tsum(case when b.final_status = 'C' and date_format(a.enroll_date, '%Y')  = ?\tand date_format(b.update_date,'%Y') = ? then 1 end),\r
\t\r
\tsum(case when b.final_status = 'L' and date_format(a.enroll_date, '%Y')  = ? and date_format(b.tgl_intake,'%Y') = ? then 1 end) ,\r
\tsum(case when b.final_status = 'C' and date_format(a.enroll_date, '%Y')  = ?\tand date_format(b.update_date,'%Y') = ? then 1 end)\t\r
\tFROM tb_sales_report a left join adm_stu_progress b on a.kd_biodata = b.kd_biodata and a.enroll_date = b.enroll_date\r
\tand a.pic = b.sc_name\r
\twhere kd_cabang =? and a.pic = ? \tand date_format(a.enroll_date, '%Y')  = ?  and status = 'OK' and a.prioritas = 1 \r
\tgroup by a.pic, date_format(a.enroll_date, '%Y') order by  a.kd_cabang,  a.pic, date_format(a.enroll_date, '%Y')", [(string) ($thn_sales), (string) ($thn_sales), (string) ($thn_sales), (string) ($thn_sales), (string) ($thn_sales), (string) ($thn_next_1), (string) ($thn_sales), (string) ($thn_next_1), (string) ($thn_sales), (string) ($thn_next_2), (string) ($thn_sales), (string) ($thn_next_2), (string) ($thn_sales), (string) ($thn_next_3), (string) ($thn_sales), (string) ($thn_next_3), (string) ($row_sc[4]), (string) ($row_sc[1]), (string) ($thn_sales)]);
		}
		else
		{
		$query_progress = q_set($__p_query_progress, "SELECT \r
\tsum(case when b.final_status = 'L' and a.enroll_date between '2024-01-01' and ? and b.tgl_intake  between '2024-01-01' and ? then 1 end) ,\r
\tsum(case when b.final_status = 'C' and a.enroll_date between '2024-01-01' and ? and b.update_date  between '2024-01-01' and ? then 1 end),\r
\r
\tsum(case when b.final_status = 'L' and a.enroll_date between '2024-01-01' and ? and date_format(b.tgl_intake,'%Y') = ? then 1 end) ,\r
\tsum(case when b.final_status = 'C' and a.enroll_date between '2024-01-01' and ?\tand date_format(b.update_date,'%Y') = ? then 1 end),\r
\t\r
\tsum(case when b.final_status = 'L' and a.enroll_date between '2024-01-01' and ? and date_format(b.tgl_intake,'%Y') = ? then 1 end) ,\r
\tsum(case when b.final_status = 'C' and a.enroll_date between '2024-01-01' and ?\tand date_format(b.update_date,'%Y') = ? then 1 end),\r
\t\r
\tsum(case when b.final_status = 'L' and a.enroll_date between '2024-01-01' and ? and date_format(b.tgl_intake,'%Y') = ? then 1 end) ,\r
\tsum(case when b.final_status = 'C' and a.enroll_date between '2024-01-01' and ?\tand date_format(b.update_date,'%Y') = ? then 1 end)\t\r
\tFROM tb_sales_report a left join adm_stu_progress b on a.kd_biodata = b.kd_biodata and a.enroll_date = b.enroll_date\r
\tand a.pic = b.sc_name\r
\twhere kd_cabang =? and a.pic = ? \tand a.enroll_date between '2022-01-01' and ?  and status = 'OK' and a.prioritas = 1 \r
\tgroup by a.pic, date_format(a.enroll_date, '%Y') order by  a.kd_cabang,  a.pic, date_format(a.enroll_date, '%Y')", [(string) ($end_date), (string) ($end_date), (string) ($end_date), (string) ($end_date), (string) ($end_date), (string) ($thn_next_1), (string) ($end_date), (string) ($thn_next_1), (string) ($end_date), (string) ($thn_next_2), (string) ($end_date), (string) ($thn_next_2), (string) ($end_date), (string) ($thn_next_3), (string) ($end_date), (string) ($thn_next_3), (string) ($row_sc[4]), (string) ($row_sc[1]), (string) ($end_date)]);	

		}
		//echo $query_progress."//";
		$resource_progress = db_query_soft($query_progress, $__p_query_progress ?? []);			
		if(num(db_num_rows($resource_progress)) > 0)
			{
			while ($r_pg  =  db_fetch($resource_progress, PDO::FETCH_NUM))
				{
				if($thn_sales =='2019'){
				$sls_0 = $row_sc[3];$l_0 = $r_pg[0];$c_0 = $r_pg[1];$l_1 = $r_pg[2];$c_1 = $r_pg[3];$l_2 = $r_pg[4];$c_2 = $r_pg[5];$l_3 = $r_pg[6];$c_3 = $r_pg[7];
				$tot_sls_0 = num($tot_sls_0)+ num($sls_0);$tot_l_0 = num($tot_l_0) +num($l_0);$tot_c_0 = num($tot_c_0) + num($c_0);
					
				$sls_1 = num($sls_0) - num($l_0) - num($c_0);$sls_2 = num($sls_1) - num($l_1) - num($c_1);$sls_3 = num($sls_2) - num($l_2) - num($c_2);	$sisa = num($sls_3) - num($l_3) - num($c_3);	
				$l_prs_0 = num((div($l_0, $sls_0))) * 100;$l_prs_0 = sprintf('%.2f', $l_prs_0);if(num($l_prs_0) <= 0.00 ){$l_prs_0 ='';}
				$l_prs_1 = num((div($l_1, $sls_0))) * 100;$l_prs_1 = sprintf('%.2f', $l_prs_1);if(num($l_prs_1) <= 0.00 ){$l_prs_1 ='';}
				$l_prs_2 = num((div($l_2, $sls_0))) * 100;$l_prs_2 = sprintf('%.2f', $l_prs_2);if(num($l_prs_2) <= 0.00 ){$l_prs_2 ='';}
				$l_prs_3 = num((div($l_3, $sls_0))) * 100;$l_prs_3 = sprintf('%.2f', $l_prs_3);if(num($l_prs_3) <= 0.00 ){$l_prs_3 ='';}
				$c_prs_0 = num((div($c_0, $sls_0))) * 100;$c_prs_0 = sprintf('%.2f', $c_prs_0);if(num($c_prs_0) <= 0.00 ){$c_prs_0 ='';}
				$c_prs_1 = num((div($c_1, $sls_0))) * 100;$c_prs_1 = sprintf('%.2f', $c_prs_1);if(num($c_prs_1) <= 0.00 ){$c_prs_1 ='';}
				$c_prs_2 = num((div($c_2, $sls_0))) * 100;$c_prs_2 = sprintf('%.2f', $c_prs_2);if(num($c_prs_2) <= 0.00 ){$c_prs_2 ='';}
				$c_prs_3 = num((div($c_3, $sls_0))) * 100;$c_prs_3 = sprintf('%.2f', $c_prs_3);if(num($c_prs_3) <= 0.00 ){$c_prs_3 ='';}
				$sisa_prs = num((div($sisa, $sls_0))) * 100;$sisa_prs = sprintf('%.2f', $sisa_prs);if(num($sisa_prs) <= 0.00 ){$sisa_prs ='';}
				}
				elseif($thn_sales =='2020'){
				$sls_1 = $row_sc[3];$l_1 = $r_pg[0];$c_1 = $r_pg[1];$l_2 = $r_pg[2];$c_2 = $r_pg[3];$l_3 = $r_pg[4];$c_3 = $r_pg[5];$l_4 = $r_pg[6];$c_4 = $r_pg[7];
				$tot_sls_1 = num($tot_sls_1)+ num($sls_1);$tot_l_1 = num($tot_l_1) +num($l_1);$tot_c_1 = num($tot_c_1) + num($c_1);
				$sls_2 = num($sls_1) - num($l_1) - num($c_1);$sls_3 = num($sls_2) - num($l_2) - num($c_2);$sls_4 = num($sls_3) - num($l_3) - num($c_3);		
			//	$l_prs_0 = ($l_0/ $sls_0) * 100;$l_prs_0 = sprintf('%.2f', $l_prs_0);if($l_prs_0 == 0.00 ){$l_prs_0 ='';}
				$l_prs_1 = num((div($l_1, $sls_1))) * 100;$l_prs_1 = sprintf('%.2f', $l_prs_1);if(num($l_prs_1) <= 0.00 ){$l_prs_1 ='';}
				$l_prs_2 = num((div($l_2, $sls_1))) * 100;$l_prs_2 = sprintf('%.2f', $l_prs_2);if(num($l_prs_2) <= 0.00 ){$l_prs_2 ='';}
				$l_prs_3 = num((div($l_3, $sls_1))) * 100;$l_prs_3 = sprintf('%.2f', $l_prs_3);if(num($l_prs_3) <= 0.00 ){$l_prs_3 ='';}
				//$c_prs_0 = ($c_0/ $sls_0) * 100;$c_prs_0 = sprintf('%.2f', $c_prs_0);if($c_prs_0 == 0.00 ){$c_prs_0 ='';}
				$c_prs_1 = num((div($c_1, $sls_1))) * 100;$c_prs_1 = sprintf('%.2f', $c_prs_1);if(num($c_prs_1) <= 0.00 ){$c_prs_1 ='';}
				$c_prs_2 = num((div($c_2, $sls_1))) * 100;$c_prs_2 = sprintf('%.2f', $c_prs_2);if(num($c_prs_2) <= 0.00 ){$c_prs_2 ='';}
				$c_prs_3 = num((div($c_3, $sls_1))) * 100;$c_prs_3 = sprintf('%.2f', $c_prs_3);if(num($c_prs_3) <= 0.00 ){$c_prs_3 ='';}
				}
				elseif($thn_sales =='2021'){
				$sls_2 = $row_sc[3];$l_2 = $r_pg[0];$c_2 = $r_pg[1];$l_3 = $r_pg[2];$c_3 = $r_pg[3];$l_4 = $r_pg[4];$c_4 = $r_pg[5];$l_5 = $r_pg[6];$c_5 = $r_pg[7];
				$tot_sls_2 = num($tot_sls_2)+ num($sls_2);$tot_l_2 = num($tot_l_2) +num($l_2);$tot_c_2 = num($tot_c_2) + num($c_2);	
				$sls_3 = num($sls_2) - num($l_2) - num($c_2);$sls_4 = num($sls_3) - num($l_3) - num($c_3);$sls_5 = num($sls_4) - num($l_4) - num($c_4);		
			//	$l_prs_0 = ($l_0/ $sls_0) * 100;$l_prs_0 = sprintf('%.2f', $l_prs_0);if($l_prs_0 == 0.00 ){$l_prs_0 ='';}
				//$l_prs_1 = ($l_1/ $sls_1) * 100;$l_prs_1 = sprintf('%.2f', $l_prs_1);if($l_prs_1 == 0.00 ){$l_prs_1 ='';}
				$l_prs_2 = num((div($l_2, $sls_2))) * 100;$l_prs_2 = sprintf('%.2f', $l_prs_2);if(num($l_prs_2) <= 0.00 ){$l_prs_2 ='';}
				$l_prs_3 = num((div($l_3, $sls_2))) * 100;$l_prs_3 = sprintf('%.2f', $l_prs_3);if(num($l_prs_3) <= 0.00 ){$l_prs_3 ='';}
				//$c_prs_0 = ($c_0/ $sls_0) * 100;$c_prs_0 = sprintf('%.2f', $c_prs_0);if($c_prs_0 == 0.00 ){$c_prs_0 ='';}
				//$c_prs_1 = ($c_1/ $sls_1) * 100;$c_prs_1 = sprintf('%.2f', $c_prs_1);if($c_prs_1 == 0.00 ){$c_prs_1 ='';}
				$c_prs_2 = num((div($c_2, $sls_2))) * 100;$c_prs_2 = sprintf('%.2f', $c_prs_2);if(num($c_prs_2) <= 0.00 ){$c_prs_2 ='';}
				$c_prs_3 = num((div($c_3, $sls_2))) * 100;$c_prs_3 = sprintf('%.2f', $c_prs_3);if(num($c_prs_3) <= 0.00 ){$c_prs_3 ='';}
				}
				elseif($thn_sales =='2022'){
				$sls_3 = $row_sc[3];$l_3= $r_pg[0];$c_3 = $r_pg[1];$l_4 = $r_pg[2];$c_4 = $r_pg[3];$l_5 = $r_pg[4];$c_5 = $r_pg[5];$l_6 = $r_pg[6];$c_6 = $r_pg[7];			
				$tot_sls_3 = num($tot_sls_3)+ num($sls_3);$tot_l_3 = num($tot_l_3) +num($l_3);$tot_c_3 = num($tot_c_3) + num($c_3);					
				$sls_4 = num($sls_3) - num($l_3) - num($c_3);	
			//	$l_prs_0 = ($l_0/ $sls_0) * 100;$l_prs_0 = sprintf('%.2f', $l_prs_0);if($l_prs_0 == 0.00 ){$l_prs_0 ='';}
				//$l_prs_1 = ($l_1/ $sls_1) * 100;$l_prs_1 = sprintf('%.2f', $l_prs_1);if($l_prs_1 == 0.00 ){$l_prs_1 ='';}
				//$l_prs_2 = ($l_2/ $sls_2) * 100;$l_prs_2 = sprintf('%.2f', $l_prs_2);if($l_prs_2 == 0.00 ){$l_prs_2 ='';}
				$l_prs_3 = num((div($l_3, $sls_3))) * 100;$l_prs_3 = sprintf('%.2f', $l_prs_3);if(num($l_prs_3) <= 0.00 ){$l_prs_3 ='';}
				//$c_prs_0 = ($c_0/ $sls_0) * 100;$c_prs_0 = sprintf('%.2f', $c_prs_0);if($c_prs_0 == 0.00 ){$c_prs_0 ='';}
				//$c_prs_1 = ($c_1/ $sls_1) * 100;$c_prs_1 = sprintf('%.2f', $c_prs_1);if($c_prs_1 == 0.00 ){$c_prs_1 ='';}
				//$c_prs_2 = ($c_2/ $sls_2) * 100;$c_prs_2 = sprintf('%.2f', $c_prs_2);if($c_prs_2 == 0.00 ){$c_prs_2 ='';}
				$c_prs_3 = num((div($c_3, $sls_3))) * 100;$c_prs_3 = sprintf('%.2f', $c_prs_3);if(num($c_prs_3) <= 0.00 ){$c_prs_3 ='';}
				}				
			}
	
?>				
	          <tr>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td rowspan="2" align=center class="style24" valign="middle"><?php echo e($no_urut) ?></td>
	            <td rowspan="2" align=left class="style24" valign="middle"><?php echo e($row_sc[1]) ?><?php if (num($kd_cbg) == 0 or $kd_cbg ==''){?><br>
  <?php echo e($row_sc[0]) ;} ?></td>
	            <td rowspan="2" align=center class="style24" valign="middle"><?php echo e($no_urut_sc) ?></td>
	            <td rowspan="2" align=center class="style24" valign="middle"><?php echo e($thn_sales) ?></td>
	            <td rowspan="2" align=center class="style24" valign="middle"><?php echo e($sls_0) ?></td>
	            <td align=center class="style24"><?php echo e($l_0) ?></td>			  
	            <td align=center class="style24"><?php echo e($c_0) ?></td>
	            <td align=center class="style24" valign="middle"><?php echo e($sls_1) ?></td>
	            <td align=center class="style24"><?php echo e($l_1) ?></td>
	            <td align=center class="style24"><?php echo e($c_1) ?></td>
	            <td rowspan="2" align=center valign="middle" class="style24"><?php echo e($sls_2) ?></td>
	            <td align=center class="style24"><?php echo e($l_2) ?></td>
	            <td align=center class="style24"><?php echo e($c_2) ?></td>
	            <td rowspan="2" align=center valign="middle" class="style24"><?php echo e($sls_3) ?></td>
	            <td align=center class="style24"><?php echo e($l_3) ?></td>
	            <td align=center class="style24"><?php echo e($c_3) ?></td>
	            <td align=center class="style24"><?php echo e($sisa) ?></td>
              </tr>
			
	          <tr>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td align=center class="style24"><?php echo e($l_prs_0) ?></td>
	            <td align=center class="style24"><?php echo e($c_prs_0) ?></td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24"><?php echo e($l_prs_1) ?></td>
	            <td align=center class="style24"><?php echo e($c_prs_1) ?></td>
	            <td align=center class="style24"><?php echo e($l_prs_2) ?></td>
	            <td align=center class="style24"><?php echo e($c_prs_2) ?></td>
	            <td align=center class="style24"><?php echo e($l_prs_3) ?></td>
	            <td align=center class="style24"><?php echo e($c_prs_3) ?></td>
	            <td align=center class="style24"><?php echo e($sisa_prs) ?></td>				  
              </tr>
              <?php $no_urut = num($no_urut) +1; $sls_0 = '';	$l_0 =  '';$c_0 =  '';$l_1 =  '';$c_1 =  '';$l_2 =  '';$c_2 =  '';$l_3 =  '';$c_3 =  ''; 
$sls_1  = '';$sls_2  = '';$sls_3  = '';		
				$l_prs_0  = '';
				$l_prs_1  = '';
				$l_prs_2  = '';
				$l_prs_3  = '';
				$c_prs_0 = '';
				$c_prs_1  = '';
				$c_prs_2  = '';
				$c_prs_3  = '';	$sisa = '';$sisa_prs = '';$sc_before = $row_sc[1];$no_urut_sc = num($no_urut_sc)+1;	
		} 						 }} 
	$tot_l_prs_0 = num((div($tot_l_0, $tot_sls_0))) * 100;$tot_l_prs_0 = sprintf('%.2f', $tot_l_prs_0);if(num($tot_l_prs_0) <= 0.00 ){$tot_l_prs_0 ='';} 
	$tot_c_prs_0 = num((div($tot_c_0, $tot_sls_0))) * 100;$tot_c_prs_0 = sprintf('%.2f', $tot_c_prs_0);if(num($tot_c_prs_0) <= 0.00 ){$tot_c_prs_0 ='';}
$tot_l_prs_1 = num((div($tot_l_1, $tot_sls_1))) * 100;$tot_l_prs_1 = sprintf('%.2f', $tot_l_prs_1);if(num($tot_l_prs_1) <= 0.00 ){$tot_l_prs_1 ='';} 
	$tot_c_prs_1 = num((div($tot_c_1, $tot_sls_1))) * 100;$tot_c_prs_1 = sprintf('%.2f', $tot_c_prs_1);if(num($tot_c_prs_1) <= 0.00 ){$tot_c_prs_1 ='';}
$tot_l_prs_2 = num((div($tot_l_2, $tot_sls_2))) * 100;$tot_l_prs_2 = sprintf('%.2f', $tot_l_prs_2);if(num($tot_l_prs_2) <= 0.00 ){$tot_l_prs_2 ='';} 
	$tot_c_prs_2 = num((div($tot_c_2, $tot_sls_2))) * 100;$tot_c_prs_2 = sprintf('%.2f', $tot_c_prs_2);if(num($tot_c_prs_2) <= 0.00 ){$tot_c_prs_2 ='';}
$tot_l_prs_3 = num((div($tot_l_3, $tot_sls_3))) * 100;$tot_l_prs_3 = sprintf('%.2f', $tot_l_prs_3);if(num($tot_l_prs_3) <= 0.00 ){$tot_l_prs_3 ='';} 
	$tot_c_prs_3 = num((div($tot_c_3, $tot_sls_3))) * 100;$tot_c_prs_3 = sprintf('%.2f', $tot_c_prs_3);if(num($tot_c_prs_3) <= 0.00 ){$tot_c_prs_3 ='';}
	
			?>			
	          <tr>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td colspan="17" align=center valign="middle" class="style24"><hr></td>
              </tr>
	          <tr>
	            <td height="14" colspan="5" align=center class="style24"><strong>TOTAL</strong></td>
	            <td rowspan="2" align=center class="style24" valign="middle"><?php echo e($tot_sls_0) ?></td>
	            <td align=center class="style24"><?php echo e($tot_l_0) ?></td>
	            <td align=center class="style24"><?php echo e($tot_c_0) ?></td>
	            <td align=center class="style24" valign="middle"><?php echo e($tot_sls_1) ?></td>
	            <td align=center class="style24"><?php echo e($tot_l_1) ?></td>
	            <td align=center class="style24"><?php echo e($tot_c_1) ?></td>
	            <td align=center class="style24" valign="middle"><?php echo e($tot_sls_2) ?></td>
	            <td align=center class="style24"><?php echo e($tot_l_2) ?></td>
	            <td align=center class="style24"><?php echo e($tot_c_2) ?></td>
	            <td align=center class="style24" valign="middle"><?php echo e($tot_sls_3) ?></td>
	            <td align=center class="style24"><?php echo e($tot_l_3) ?></td>
	            <td align=center class="style24"><?php echo e($tot_c_3) ?></td>
	            <td align=center class="style24"><?php echo e($tot_sisa) ?></td>
              </tr>
	          <tr>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td align=center class="style24" valign="middle">&nbsp;</td>
	            <td align=left class="style24" valign="middle">&nbsp;</td>
	            <td align=center class="style24" valign="middle">&nbsp;</td>
	            <td align=center class="style24" valign="middle">&nbsp;</td>
	            <td align=center class="style24"><?php echo e($tot_l_prs_0) ?></td>
	            <td align=center class="style24"><?php echo e($tot_c_prs_0) ?></td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24"><?php echo e($tot_l_prs_1) ?></td>
	            <td align=center class="style24"><?php echo e($tot_c_prs_1) ?></td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24"><?php echo e($tot_l_prs_2) ?></td>
	            <td align=center class="style24"><?php echo e($tot_c_prs_2) ?></td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24"><?php echo e($tot_l_prs_3) ?></td>
	            <td align=center class="style24"><?php echo e($tot_c_prs_3) ?></td>
	            <td align=center class="style24"><?php echo e($tot_sisa_prs) ?></td>
              </tr>

				    </tbody>
<?php } ?>		  
            <tfoot>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>
          <!-- /.box -->
  </div>
        <!-- /.col -->
  </div>
      <!-- /.row --><!-- /.content -->
 
	 			  

  <!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
