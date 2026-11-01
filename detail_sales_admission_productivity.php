<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); $dbh = true; /* koneksi lewat _lib/db.php (kredensial dihapus dari kode) */
db_use("ves_data");
$query = q_set($__p_query, "SELECT sales_year, minggu FROM set_minggu");
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$sales_year= $row[0];
		$sales_year_umum= $row[0];
		$minggu_ini= $row[1];
		}
	}
	
$week = in_val('week', 'get');
if ($week =='')
	{
	$week = $minggu_ini;
	}

$query = q_set($__p_query, "SELECT no_week, tgl_periode, bulan FROM master_date where minggu = ? and sales_year = '18'", [(string) ($week)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$tgl_periode = $row[1];
		}
	}
$sql = q_set($__p_sql, "SELECT minggu, nomor_minggu, bulan FROM tb_minggu_todate where sales_year = '18' and minggu =? ", [(string) ($week)]);
$rs = db_query_soft($sql, $__p_sql ?? []);
while($row = db_fetch($rs))
{
	$nmr_urut= $row[1];
	$bulan_skr = $row[2];
}

$sql = q_set($__p_sql, "SELECT min(detail), max(detail) FROM ves_data.tb_minggu_detail where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);
$rs = db_query_soft($sql, $__p_sql ?? []);
while($row = db_fetch($rs))
{
	$awal_mg= $row[0];
	$akhir_mg = $row[1];
}
	$awal_enroll= '2015-07-01';

?>
<HTML>
<HEAD>
<TITLE>Sales Report by Institution</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-color: ##EEEEEE;
}
.style12 {font-family: Calibri}
.style33 {color: #000000; font-weight: bold; font-size: 12px; }
.stylebulan {color: #000000; font-weight: bold; font-size: 14px;font-family: Calibri; }
.style35 {	font-family: Calibri;
	color: #010EAD;
	font-weight: bold;
	font-size: 26px;
}
.style49a {color: #010EAD; font-weight: bold; font-size: 12px; font-family: Calibri; }
.style73 {font-family: Calibri; font-weight: bold; font-size: 14px; }
.style81 {color: #000000; font-weight: bold; font-size: 12px; font-family: Calibri; }
.style82 {font-size: 16px}
.style84 {color: #000000; font-weight: bold; font-size: 16px; font-family: Calibri; }
.style49 {color: #33CCFF; font-weight: bold; font-size: 12px; font-family: Calibri; }
-->
</style></HEAD>
<BODY LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<form method=get action="sales_admission_productivity.php">

<table id="Table_01" width="949" height="148" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td height="22" colspan="3">

      <div align="left"><strong><span class="style12"><?php echo e($hariapa) ?></span></strong><span class="style12">, <strong><?php echo e($tampilhari) ?></strong></span></div></td>
  </tr>
  <tr>
    <td width="109" height="22" rowspan="5" class="style35"><div align="right"><img src="images/Page-VIC_04.jpg" width="108" height="100"></div></td>
    <td width="636" rowspan="5" class="style73"><div align="center" class="style35">       VISTA ALL BRANCHES<br>
      SALES ADMISSION PRODUCTIVITY <br>
    Period : July 2015-June 2016</div></td>
    <td width="204" class="style73">&nbsp;</td>
  </tr>
  <tr>
  
    <td height="22" class="style73">&nbsp;</td>
  </tr>
  <tr>
  
    <td height="22" class="style73"><strong><font color="#000000">Week :
          <select name="week"  onChange="this.form.submit()"  class="style33" id="nmr_minggu">
            <?php
			$sql = q_set($__p_sql, "SELECT minggu, nomor_minggu FROM tb_minggu_todate where sales_year = '18' and minggu <>'' order by nomor_minggu ");
			$rs = db_query_soft($sql, $__p_sql ?? []);
			while($row = db_fetch($rs))
			{
			  echo "<option value=\"".e($row['minggu'])."\">".e($row['minggu'])."</option>\n  ";
			}
			?>
            <option selected><?php echo e($week) ?></option>
          </select>
    </font></strong></td>
  </tr>
  <tr>
    <td height="25" class="style73"><strong><font color="#000000">Period : <?php echo e($tgl_periode) ?></font></strong></td>
  </tr>
<strong><font color="#000000"></font></strong>

  <tr>
    <td class="style73">&nbsp;</td>
  </tr>
</table>
</form>

<table width=1614 height=130 border=1 align="center" cellspacing=0 bordercolor="#000000" id=AutoNumber1 style=border-collapse: collapse>
          <tr>
            <td width=53 height="32" align=center bgcolor=#CCCCCC class="style81 style82">No</td>
            <td width=273 align=center bgcolor=#CCCCCC class="style84">Student Consultant </td>
            <td width=69 align=center bgcolor=#CCCCCC class="style84">Center</td>
            <td width="105" align=center bgcolor=#CCCCCC class="style84">Working Duration </td>
            <td width="105" align=center bgcolor=#CCCCCC class="style84">SALES </td>
            <td colspan="2" align=center bgcolor=#FF0000 class="style84">CANCEL</td>
            <td colspan="2" align=center bgcolor=#CCCCCC class="style84">LEAVING</td>
            <td width="411" align=center bgcolor=#CCCCCC class="style84">Score</td>
          </tr>		
		  
          <tr bgcolor="#FFFFFF">
            <td height="32" align=center class="style81 style82">&nbsp;</td>
            <td align=left class="style84">&nbsp;</td>
            <td align=center class="style84">&nbsp;</td>
            <td align=center class="style84">&nbsp;</td>
            <td align=center class="style84">&nbsp;</td>
            <td align=center bgcolor="#FF0000" class="style84">Pax</td>
            <td align=center class="style84">Point</td>
            <td align=center class="style84">Pax</td>
            <td align=center class="style84">Point</td>
            <td align=center class="style84">&nbsp;</td>
          </tr>
      <tr bgcolor="#FFFFFF">
	     <?php $dbh = true; /* koneksi lewat _lib/db.php (kredensial dihapus dari kode) */
db_use("ves_data");
$total_semua= 0;
$total_semua_5 = 0;
$total_semua_4 = 0;
$total_semua_3 = 0;
$total_semua_2 = 0;
$total_semua_1 = 0;
$total_semua_bruto = 0;
$total_semua_netto = 0;
$total_semua_cancel = 0;
$nomor_urut  =1;
$query_pic = q_set($__p_query_pic, "SELECT sr.pic, count(sr.pic) as jml FROM tb_sales_report sr where enroll_date between ? and ? and sr.status = 'OK' and sr.prioritas = '1' group by sr.pic order by jml desc", [(string) ($awal_enroll), (string) ($akhir_mg)]);

$resource_pic = db_query_or_die('errro_3', $query_pic, $__p_query_pic ?? []);
$keluar_pic = db_num_rows($resource_pic);
if(num(db_num_rows($resource_pic)) > 0)
	{
	while ($row_pic=  db_fetch($resource_pic, PDO::FETCH_NUM))
		{
		$sc = $row_pic[0];
		$jml_sales = $row_pic[1];
		$query_work = q_set($__p_query_work, "select a.start_working from hrd.hr_emp a left join ves_data.tb_user b on  a.id_emp = b.hr_code where b.nama_detail = ? ", [(string) ($sc)]);
		$resource_work = db_query_or_die('errro_4', $query_work, $__p_query_work ?? []);
		$keluar_work = db_num_rows($resource_work);
		if(num(db_num_rows($resource_work)) > 0)
			{
			while ($row_work =  db_fetch($resource_work, PDO::FETCH_NUM))
				{
				$jml_work = $row_work[0];
				}
			}
		else
			{
				$jml_leaving = 0;			
			}
		
		//$query_sales = "SELECT   sr.kd_school, mp.grade FROM tb_sales_report sr, tb_master_partner mp,tb_minggu_todate d  where sr.kd_school = mp.kd_school and sr.pic = '$sc' and sr.enroll_date >=  '2015-07-01' and sr.prioritas = '1' and sr.status = 'OK' and sr.week = d.minggu and d.minggu and d.nomor_minggu <= '$nmr_urut'";
		$query_leaving = q_set($__p_query_leaving, "SELECT count(kd_biodata) as jml FROM adm_stu_progress where final_status like 'L%' and comm_date between ? and ? and sc_name = ? ", [(string) ($awal_enroll), (string) ($akhir_mg), (string) ($sc)]);
		$resource_leaving = db_query_or_die('errro_4', $query_leaving, $__p_query_leaving ?? []);
		$keluar_leaving = db_num_rows($resource_leaving);
		if(num(db_num_rows($resource_leaving)) > 0)
			{
			while ($row_leaving=  db_fetch($resource_leaving, PDO::FETCH_NUM))
				{
				$jml_leaving = $row_leaving[0];
				}
			}
		else
			{
				$jml_leaving = 0;			
			}
		$query_cancel = q_set($__p_query_cancel, "SELECT count(kd_biodata) as jml FROM adm_stu_progress where final_status like 'C%' and update_date between ? and ? and sc_name = ? ", [(string) ($awal_enroll), (string) ($akhir_mg), (string) ($sc)]);
		$resource_cancel = db_query_or_die('errro_5', $query_cancel, $__p_query_cancel ?? []);
		$keluar_cancel = db_num_rows($resource_cancel);
		if(num(db_num_rows($resource_cancel)) > 0)
			{
			while ($row_cancel=  db_fetch($resource_cancel, PDO::FETCH_NUM))
				{
				$jml_cancel = $row_cancel[0];
				}
			}
		else
			{
				$jml_cancel = 0;			
			}

?>
        <td height="32" align=center class="style81 style82"><?php echo e($nomor_urut) ?></span></td>
        <td align=left class="style84"><?php echo e($sc) ?></span></td>
        <td align=center class="style84"><?php echo e($cbg) ?></span></td>
        <td align=center class="style84"><?php echo e($jml_work) ?></td>
        <td align=center class="style84"><?php echo e($jml_sales) ?></span></span></td>
        <td align=center bgcolor="#FF0000" class="style84"><?php echo e($jml_cancel) ?></span></td>
        <td align=center class="style84"></span></span></td>
        <td align=center class="style84"><?php echo e($jml_leaving) ?></span></td>
        <td align=center class="style84">&nbsp;</td>
        <td align=center class="style84"><?php echo e($r[14]) ?></span></td>
      </tr>
	  	<?php $nomor_urut = num($nomor_urut) + 1;
	}?>
     <tr>
        <td width="53" align=center bgcolor=#CCCCCC class="style81 style82">&nbsp;</td>
        <td height="32" colspan="2" rowspan="-1" align=center bgcolor=#CCCCCC class="style84"><span class="style81 style82">TOTAL</span></td>
        <td width="105" align=center bgcolor=#CCCCCC class="style84">&nbsp;</td>
        <td width="105" align=center bgcolor=#CCCCCC class="style84"><?php echo e($jml_sales) ?></td>
        <td width="98" align=center bgcolor=#FF0000 class="style84"><?php echo e($total_semua_cancel); ?></td>
        <td width="127" align=center bgcolor=#CCCCCC class="style84">&nbsp;</td>
        <td width="168" align=center bgcolor=#CCCCCC class="style84">&nbsp;</td>
        <td width="163" align=center bgcolor=#CCCCCC class="style84">&nbsp;</td>
        <td width="411" align=center bgcolor=#CCCCCC class="style84">100</td>
  </tr>
	
	<?php }
	?>	
</table>

    <br>

</BODY>
</HTML>