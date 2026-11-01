<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();  

$urut = in_val('by', 'get'); 
if ($urut == $urut_lama) 
	{echo "sama ";}
else
	{echo "baru ";}
if ($urut =="") 
	{
	$urutan = " order by c.branch, case when dest_country like 'USA%' then 0
when dest_country like 'CAN%' then 1
when dest_country like 'SW%' then 2
when dest_country like 'UK%' then 3
when dest_country like 'SPA%' then 4
when dest_country like 'IT%' then 5
when dest_country like 'AUS%' then 6
when dest_country like 'NEW%' then 7
when dest_country like 'SIN%' then 8
when dest_country like 'MAL%' then 9
when dest_country like 'CHI%' then 10
when dest_country like 'IN%' then 11
ELSE 12 end, country asc, c.nama, c.comm_date, a.dt_invoice ";
	}
else
	{
	if ($urut == "center"){$urutan = " order by branch ";}
	elseif ($urut == "student"){$urutan = " order by nama ";}
	elseif ($urut == "country"){$urutan = " order by dest_country ";}
	elseif ($urut == "school"){$urutan = " order by dest_school ";}
	elseif ($urut == "program"){$urutan = " order by dest_program ";}
	elseif ($urut == "grade"){$urutan = " order by bintang ";}
	elseif ($urut == "invoice"){$urutan = " order by kd_invoice ";}
	elseif ($urut == "datepay"){$urutan = " order by dt_payment ";}

	}
$jamwaktu = date("h:ia");
$kode_lagi = $_SESSION['kode_staff'];
$hariapa = date("D"); 
if($hariapa =='Sun'){
$hariapa ="Sunday";
}elseif($hariapa =='Mon'){
$hariapa ="Monday";
}elseif($hariapa =='Tue'){
$hariapa ="Tuesday";
}elseif($hariapa =='Wed'){
$hariapa ="Wednesday";
}elseif($hariapa =='Thu'){
$hariapa ="Thursday";
}elseif($hariapa =='Fri'){
$hariapa ="Friday";
}elseif($hariapa =='Sat'){
$hariapa ="Saturday";
}
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
if(num($bulan)==01){
$bulan1="January";
}elseif(num($bulan)==02){
$bulan1="Pebruary";
}elseif(num($bulan)==03){
$bulan1="Maret";
}elseif(num($bulan)==04){
$bulan1="April";
}elseif(num($bulan)==05){
$bulan1="May";
}elseif(num($bulan)==06){
$bulan1="June";
}elseif(num($bulan)==07){
$bulan1="July";
}elseif(num($bulan)==8){
$bulan1="August";
}elseif(num($bulan)==9){
$bulan1="September";
}elseif(num($bulan)==10){
$bulan1="October";
}elseif(num($bulan)==11){
$bulan1="November";
}elseif(num($bulan)==12){
$bulan1="December";
}elseif(num($bulan)==1){
$bulan1="January";
}elseif(num($bulan)==2){
$bulan1="Pebruary";
}elseif(num($bulan)==3){
$bulan1="Maret";
}elseif(num($bulan)==4){
$bulan1="April";
}elseif(num($bulan)==5){
$bulan1="May";
}elseif(num($bulan)==6){
$bulan1="June";
}elseif(num($bulan)==7){
$bulan1="July";
}elseif(num($bulan)==8){
$bulan1="August";
}elseif(num($bulan)==9){
$bulan1="September";
}elseif(num($bulan)==1){
$bulan1="Januari";
}
$kompleteharidisplay = "$tahun-$bulan-$hari";
$kompletehari = "$bulan1 $hari, $tahun";
$dbh = true; /* koneksi lewat _lib/db.php (kredensial dihapus dari kode) */
db_use("ves_data");
?>
<HTML>
<HEAD>
<TITLE>STATEMENT</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-color: ##EEEEEE;
}
.style20 {
	font-family: Arial;
	font-weight: bold;
}
.style24 {color: #000000; font-weight: bold; font-size: 12px; }
.style26 {font-family: Arial; font-weight: bold; font-size: large; color: #000099; }
-->
</style></HEAD>
<BODY LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table id="Table_01" width="94%" height="177" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td height="19" colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td height="92" colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" colspan="4"><div align="center"><span class="style26">Income Summary Base On Commencement Date<br>
      Sales Year Student</span></div></td>
  </tr>
  <tr>
    <td width="14" height="22">&nbsp;</td>
    <td width="599">&nbsp;</td>
    <td width="310">&nbsp;</td>
    <td width="29">&nbsp;</td>
  </tr>
</table>
<br>
<div align="center">
  <table border=1 style=border-collapse: collapse width=99% id=AutoNumber1 height=46 align="center">
    <tr>
      <td width=3% rowspan="2" align=center bgcolor=#585AB8 class="style24">No</td>
      <td width="5%" rowspan="2" align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=center">Center</a>
	  <select name="select">
        </select>
      </td>
      <td width="14%" rowspan="2" align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=student">Student Name</a>
        <select name="student">
        </select></td>
      <td height=14 colspan="4" align=center bgcolor=#585AB8 class="style24">Destination<span class="style24"><font face="Verdana"> </font></span></td>
      <td width="3%" rowspan="2" align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=comm">Commencement Date</a></td>
      <td height=14 colspan="4" align=center bgcolor=#585AB8 class="style24">Invoice</td>
      <td colspan="2" align=center bgcolor=#585AB8 class="style24">Payment</td>
      <td colspan="2" align=center bgcolor=#585AB8 class="style24">Leaving</td>
      <td colspan="2" align=center bgcolor=#585AB8 class="style24">Status</td>
    </tr>
    <tr>
      <td width="7%" height=14 align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=country">Country</a>
        <select name="select3">
        </select></td>
      <td width="7%" align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=school">School</a>
        <select name="select4">
        </select></td>
      <td width="7%" height=14 align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=program">Program</a>
        <select name="select5">
        </select></td>
      <td width="3%" align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=grade">grade</a>
        <select name="select6">
        </select></td>
      <td width="8%" height=14 align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=invoice">No Invoice/Date</a></td>
      <td width="10%" align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Curr</a>
        <br>
        <select name="select7">
        </select></td>
      <td width="5%" height=14 align=center bgcolor=#585AB8 class="style24">Mount</td>
      <td width="5%" align=center bgcolor=#585AB8 class="style24">Rate</td>
      <td width="7%" align=center bgcolor=#585AB8 class="style24">Mount</td>
      <td width="4%" align=center bgcolor=#585AB8 class="style24"><a href="<?php $_SERVER['PHP_SELF']?>?by=datepay">Date</a></td>
      <td width="3%" align=center bgcolor=#585AB8 class="style24">Main</td>
      <td width="2%" align=center bgcolor=#585AB8 class="style24">Add/Lang</td>
      <td width="4%" align=center bgcolor=#585AB8 class="style24">Invoice</td>
      <td width="3%" align=center bgcolor=#585AB8 class="style24">Paid</td>
    </tr>
<?php
function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
}

 
//$query = "SELECT c.branch, c.nama, c.dest_country, c.dest_school, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice,
//DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay,  DATE_FORMAT(b.dt_payment,'%d %b %y'),
//(case  when  c.final_status = 'L' then 1 else 0 end )as main,
//(case  when  c.final_status <> 'L' then 1 else 0 end )as add_l,
//(case  when  a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing,
//(case  when  b.mount_rp_pay <> '' then 1 else 0 end ) as paid,c.bintang FROM adm_stu_progress c
//left join fin_invoice a on c.no =  a.no_leaving
//left join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice
//where c.final_status like '%L%' and c.comm_date between '2015-07-01' and '2016-06-30' $urutan ";

$query = q_set($__p_query, "SELECT c.branch, c.nama, c.dest_country, c.dest_school, d.grade, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice, DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'), (case when c.final_status = 'L' then 1 else 0 end )as main, (case when c.final_status <> 'L' then 1 else 0 end )as add_l, (case when a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing, (case when b.mount_rp_pay <> '' then 1 else 0 end ) as paid FROM adm_stu_progress c left join tb_master_partner d on  c.kd_school = d.kd_school left join fin_invoice a on c.no = a.no_leaving left join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice where c.final_status like '%L%' and c.comm_date between '2016-07-01' and '2017-06-30' order by c.branch, case when dest_country like 'USA%' then 0 when dest_country like 'CAN%' then 1 when dest_country like 'SW%' then 2 when dest_country like 'UK%' then 3 when dest_country like 'SPA%' then 4 when dest_country like 'IT%' then 5 when dest_country like 'AUS%' then 6 when dest_country like 'NEW%' then 7 when dest_country like 'SIN%' then 8 when dest_country like 'MAL%' then 9 when dest_country like 'CHI%' then 10 when dest_country like 'IN%' then 11 ELSE 12 end, c.nama, c.comm_date, a.dt_invoice");

$nomor = 1;

$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		
?>	
    <tr>
      <td align=center class="style24"><?php echo e($nomor) ?></td>
      <td align=center class="style24"><?php echo e($row[0]) ?></td>
      <td align=left class="style24"><?php echo e($row[1]) ?></td>
      <td height=14 align=left class="style24"><?php echo e($row[2]) ?></td>
      <td align=left class="style24"><?php echo e($row[3]) ?></td>
      <td height=14 align=left class="style24"><?php echo e($row[5]) ?></td>
      <td align=center class="style24"><?php echo e($row[4]) ?></td>
      <td align=center class="style24"><?php echo e($row[6]) ?></td>
      <td height=14 align=center class="style24"><?php echo e($row[7]) ?><br>
      <?php echo e($row[8]) ?><br></td>
      <td align=center class="style24"><?php echo e($row[9]) ?></td>
      <td height=14 align=center class="style24"><?php echo e(buatrp($row[10])) ?></td>
      <td align=center class="style24"><?php echo e(buatrp($row[11])) ?></td>
      <td align=center class="style24"><?php echo e(buatrp($row[12])) ?></td>
      <td align=center class="style24"><?php echo e($row[13]) ?></td>
      <td align=center class="style24"><?php echo e($row[14]) ?></td>
      <td align=center class="style24"><?php echo e($row[15]) ?></td>
      <td align=center class="style24"><?php echo e($row[15]) ?></td>
      <td align=center class="style24"><?php echo e($row[17]) ?></td>
    </tr>
<?php 
$nomor = num($nomor)+1;}} 

 ?>
  </table>
</div>

<p align="center"><p><a href="export.php"><button>Export Data ke Excel</button></a></p></p>
<div align="center">
  </center>
<p>&nbsp;</p>
<p>&nbsp;</p></div>
</BODY>
</HTML>