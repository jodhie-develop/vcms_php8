<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$q = in_val('q', 'get');
$search = in_val('search', 'get');


$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';$nm_db = q_set($__p_nm_db, "billing");}
if (num($kd_cbg) ==2){$cabang = 'West Sby';$nm_db = q_set($__p_nm_db, "billing_west");}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';$nm_db = q_set($__p_nm_db, "billing_bali");}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';$nm_db = q_set($__p_nm_db, "billing_jkt_02");}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';$nm_db = q_set($__p_nm_db, "billing_new_gs");}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';$nm_db = q_set($__p_nm_db, "billing_m2");}
if (num($kd_cbg) ==7){$cabang = 'Bandung';$nm_db = q_set($__p_nm_db, "billing_new_bdg");}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';$nm_db = q_set($__p_nm_db, "billing_mlg");}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kd_area'] ;
$level_posisi = $_SESSION['level_posisi'] ;
if (num($kd_area) == 5){$area ="";}
elseif(num($kd_area) == 42){$area = " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')";}
elseif(num($kd_area) == 41){$area = " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')";}
elseif(num($kd_area) == 31){$area = " and (kd_branch= '1' or kd_branch= '2')";}
elseif(num($kd_area) == 21) {$area = " and (kd_branch= '2'or kd_branch= '8')";}
elseif(num($kd_area) == 2){$area = " and kd_branch= '$kd_cbg'";}
else {$area = " and kd_branch= '$kd_cbg'";}	

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="500" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
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
<?php //========================== left nav ?>
 <?php   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_oc.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>VIP OPEN CLASS</php><br>
      </h1>
     <table width="453" border="0">
        <tr>
          <td height="24"><small>
            <label for="date6">Center</label>
          </small></td>
          <td><small>
            <label for="date7">:</label>
            <select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
             <?php
				if (num($kd_area) >= 5)
				{?>
              <option value="0">--ALL--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="8">Malang TBI</option>
              <option value="9">Bandung TBI</option>
              <option value="10">Bali TBI</option>					
				<?php }
             	elseif (num($kd_area) == 42)
				{?>				

              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
			
				<?php }	
             	elseif (num($kd_area) == 41)
				{?>				
              <option value="0">--ALL--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="8">Malang TBI</option>
				
				<?php }	
             	elseif (num($kd_area) == 31)
				{?>				
	              <option value="0">--ALL--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>		
				<?php }	
             	elseif ($kd_area == "" )
				{?>				
				
	              <option value="1"><?php echo e($cabang) ?></option>
>			<?php }	
             	elseif ($kd_area == "2" )
				{?>				
				
	              <option value="1"><?php echo e($cabang) ?></option>
>			<?php }	?>                                                                     

                            
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select>
          </small></td>
        </tr>
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Entry Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td height="24">&nbsp;</td>
            <td><small>
            <input type="text" name="q" id="q" value="<?php echo e($q) ; ?>" hidden="hidden">
            <input type="text" name="search" id="q2" value="<?php echo e($search) ; ?>" hidden="hidden">
            </small></td>
          </tr>
        </tbody>
      </table>
 
    
    </section><!-- Main content -->
    <section class="content">
     <div class="row">
       <div class="col-xs-12">
          <!-- /.box -->

          <table width=1399 height=86 border=1 align="center" cellspacing=0 bordercolor="#000000" id=AutoNumber1 style=border-collapse: collapse>
      <tr>
        <td width=33 align=center bgcolor=#CCCCCC class="style81">NO</td>
        <td width=243 align=center bgcolor=#CCCCCC class="style81">Consultant Name</td>
        <td width=821 align=center bgcolor=#CCCCCC class="style81">Program</td>
        <td width=284 align=center bgcolor=#CCCCCC class="style81">Count</td>
        </tr>
      
<?php 
			  
$nomor_urut = '1';$warna = "#FFFFFF";
$jml_pax  = '1';
//$query_detail = "SELECT  p.country,  p.school, sr.p_np, sr.nama, sr.ori_school, sr.prioritas, sr.enroll_date, sr.program, sr.intake_date,sr.status_leaving,sr.pic,p.grade,sr.h_nh, sr.kd_biodata, d.nomor_minggu    FROM tb_sales_report sr, tb_master_partner p, tb_minggu_todate d where sr.cabang = '$branch' and sr.sales_year = '$sales_year_cabang' and d.sales_year = '$sales_year'and sr.kd_school = p.kd_school and sr.week = d.minggu and d.minggu and d.nomor_minggu <= '$nmr_urut' and sr.status = 'OK' order by p.country, p.school";

$query_detail = q_set($__p_query_detail, "SELECT PIC, program, count(kd_open_cl) as jml\r
FROM " . $nm_db . ".tb_pay_dtl a, " . $nm_db . ".tb_open_cl b\r
where kd_open_cl = code_class and code_class <>'' and code_class is not null\r
 and (st_rf = 'paid' or st_inst_1 = 'paid'or st_ins_2 = 'paid' or st_inst_3 = 'paid' or st_full_pay = 'paid' or st_dp = 'paid')\r
 and start_cl between ?  and ? group by pic, program order by pic, jml desc", [...($__p_nm_db ?? []), ...($__p_nm_db ?? []), (string) ($date_start), (string) ($date_end)]);

$resource = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	$group_kelas=  "";
	$nomor_urut =  1;
	$baris = 0;
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{ 
		?>				
		<?php	
		if ($group_kelas !=  "") {
			if($group_kelas !=  $row[1] )
				{ 
				$group_sebelumnya = $row[1];

?>
 <?php 
$total_tf =0;

$total_sub_net =0;
$grand_total_sub_net =0;
$total_sub_rf = 0;
$grand_total_sub_rf = 0;
$total_sub_paid	  = 0;
$grand_total_sub_paid	  = 0;
$total_sub_outstanding = 0	;
$grand_total_sub_outstanding = 0	;
$nomor_urut =  1;

}   	$jml_pax = num($jml_pax) + 1;}?> 
      <tr>
        <td height="21" align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e($nomor_urut) ?></td>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e($row[0]) ?></td>
        <td align=left bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e($row[1]) ?><br></td>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e($row[2]) ?><span class=""><br>
        </span></td>
        </tr>
	  
      
	  <?php 
	
$nomor_urut = num($nomor_urut)+1;}
	    ?>

	  <?php  }?>
</table>
          <!-- /.box -->
        </div>
       <p>&nbsp;</p>
        <!-- /.col -->
      </div>
      Detail Report
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <table width=1399 height=86 border=1 align="center" cellspacing=0 bordercolor="#000000" id=AutoNumber1 style=border-collapse: collapse>
      <tr>
        <td width=18 align=center bgcolor=#CCCCCC class="style81">NO</td>
        <td width=145 align=center bgcolor=#CCCCCC class="style81">Student Name </td>
        <td width=134 align=center bgcolor=#CCCCCC class="style81">Program</td>
        <td width=85 align=center bgcolor=#CCCCCC class="style81">Day</td>
        <td width=119 align=center bgcolor=#CCCCCC class="style81">Program Fee <br></td>
        <td width=70 align=center bgcolor=#CCCCCC class="style81">Discount</td>
        <td width="125" align=center bgcolor=#CCCCCC class="style81">Nett Tuition Fee </td>
        <td width="119" align=center bgcolor=#CCCCCC class="style81">Rf</td>
        <td width="88" align=center bgcolor=#CCCCCC class="style81">Paid</td>
        <td width="97" align=center bgcolor=#CCCCCC class="style81">Outstanding</td>
        <td width="100" align=center bgcolor=#CCCCCC class="style81">Remark</td>
        <td width="128" align=center bgcolor=#CCCCCC class="style81">SC</td>
        <td width="117" align=center bgcolor=#CCCCCC class="style81">Accounting Remark </td>
      </tr>
      
<?php 
function buatrp($angka)
{
	if (num($angka) !=0)
	{$jadi = "Rp " . number_format(num($angka),0,',',',');
	return $jadi;
	}
else
	{
		echo e($jadi = 0);
	}
}			  
$nomor_urut = '1';$warna = "#FFFFFF";
$jml_pax  = '1';
//$query_detail = "SELECT  p.country,  p.school, sr.p_np, sr.nama, sr.ori_school, sr.prioritas, sr.enroll_date, sr.program, sr.intake_date,sr.status_leaving,sr.pic,p.grade,sr.h_nh, sr.kd_biodata, d.nomor_minggu    FROM tb_sales_report sr, tb_master_partner p, tb_minggu_todate d where sr.cabang = '$branch' and sr.sales_year = '$sales_year_cabang' and d.sales_year = '$sales_year'and sr.kd_school = p.kd_school and sr.week = d.minggu and d.minggu and d.nomor_minggu <= '$nmr_urut' and sr.status = 'OK' order by p.country, p.school";

$query_detail = q_set($__p_query_detail, "SELECT nm_stu,   kd_open_cl, cl_sch, a.tf,  disc, disc_dtl,  net_fee, \r
(case  when  st_rf = 'paid' then rf else 0 end )as rf,\r
(case when  st_dp = 'paid' then dp else 0 end) as dp,\r
(case when  st_inst_1 = 'paid' then inst_1 else 0 end) as inst_1,\r
(case when  st_ins_2 = 'paid' then inst_2 else 0 end) as inst_2,\r
(case when  st_inst_3 = 'paid' then inst_3 else 0 end) as inst_3,\r
(case when  st_full_pay = 'paid' then full_pay else 0 end) as full_pay, \r
date_format(start_cl,'%M %Y'), teacher, time_sch,PIC, date_format(start_cl,'%d %b %y'), date_format(end_cl,'%d %b %y')\r
FROM " . $nm_db . ".tb_pay_dtl a, " . $nm_db . ".tb_open_cl b\r
where kd_open_cl = code_class and code_class <>'' and code_class is not null\r
 and (st_rf = 'paid' or st_inst_1 = 'paid'or st_ins_2 = 'paid' or st_inst_3 = 'paid' or st_full_pay = 'paid' or st_dp = 'paid')\r
 and start_cl between ?  and ? order by start_cl", [...($__p_nm_db ?? []), ...($__p_nm_db ?? []), (string) ($date_start), (string) ($date_end)]);

$resource = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	$group_kelas=  "";
	$nomor_urut =  1;
	$baris = 0;
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{ $persen_discount = num((div($row[4], $row[3]))) * 100;
			if (num($row[9]) == 0) {$remark = "Lunas";} 
		?>				
		<?php	
		if ($group_kelas !=  "") {
			if($group_kelas !=  $row[1] )
				{ 
				$group_sebelumnya = $row[1];

?>
      <tr>
        <td height="21" colspan="4" align=right bgcolor=<?php  echo e($warna) ?> class="style81">Sub Total <?php  echo e($group_kelas) ?> <span class="">(<span class="style86"><?php  echo e($row[17]) ?></span> to <?php  echo e($row[18]) ?>}</span>: </td>
         <td height="21" align=center bgcolor=#CCCCCC class="style81"><?php  echo e(buatrp($total_tf))  ?></td>
         <td height="21" align=right bgcolor=#CCCCCC class="style81">&nbsp;</td>
         <td align=center bgcolor=#CCCCCC class="style81"><span class=""><?php  echo e(buatrp($total_sub_net)) ?></span></td>
        <td align=center bgcolor=#CCCCCC class="style81"><?php  echo e(buatrp($total_sub_rf)) ?></td>
        <td align=center bgcolor=#CCCCCC class="style81"><?php  echo e(buatrp($total_sub_paid)) ?></td>
        <td align=center bgcolor=#CCCCCC class="style81"><?php  echo e(buatrp($total_sub_outstanding)) ?></td>
        <td align=left bgcolor=#CCCCCC class="style81">&nbsp;</td>
        <td align=center bgcolor=#CCCCCC class="style81">&nbsp;</td>
        <td align=center bgcolor=#CCCCCC class="style81">&nbsp;</td>
      </tr>
 <?php 
$total_tf =0;

$total_sub_net =0;
$grand_total_sub_net =0;
$total_sub_rf = 0;
$grand_total_sub_rf = 0;
$total_sub_paid	  = 0;
$grand_total_sub_paid	  = 0;
$total_sub_outstanding = 0	;
$grand_total_sub_outstanding = 0	;
$nomor_urut =  1;

}   	$jml_pax = num($jml_pax) + 1;}?> 
      <tr>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e($nomor_urut) ?></td>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e($row[0]) ?></td>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e($row[1]) ?><br></td>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e($row[2]) ?><span class=""><br>
        <?php  echo e($row[15]) ?><br>
        <?php  echo e($row[14]) ?></span></td>
        <td height="21" align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e(buatrp($row[3])) ?></td>
        <td height="21" align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e($persen_discount) ?> % <br>
        <?php  echo e($row[5]) ?></td>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e(buatrp($row[6])) ?></td>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e(buatrp($row[7])) ?></td>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e(buatrp(num($row[8])+num($row[9])+num($row[10])+num($row[11])+num($row[12]))) ?></td>
        <td align=center bgcolor=<?php  echo e($warna) ?> class="style81"><?php  echo e(buatrp(num($row[6]) - num((num($row[8])+num($row[9])+num($row[10])+num($row[11])+num($row[12]))))) ?></td>
        <td align=left bgcolor=<?php  echo e($warna) ?> class="style81"><?php  
		if (num($row[6]) - num((num($row[8])+num($row[9])+num($row[10])+num($row[11])+num($row[12]))) == 0)
			{
		echo "Lunas";
		}
		elseif (num($row[6]) - num((num($row[8])+num($row[9])+num($row[10])+num($row[11])+num($row[12]))) < 0)
		{
			echo "Refund";

		}
		else
		{
		echo "Belum Lunas";
		}		
		?></td>
        <td align=center bgcolor=#FFFFFF class="style81"><?php  echo e($row[16]) ?></td>
        <td align=center bgcolor=#FFFFFF class="style81">&nbsp;</td>
      </tr>
	  
      
	  <?php 
	
	 	 $grand_total_tf = num($grand_total_tf) + num($row[3]);
		 $grand_total_net = num($grand_total_net) + num($row[6]);
		$grand_total_rf	= 	num($grand_total_rf)	+ 	num($row[7]); 
		$paid = (num($row[8])+num($row[9])+num($row[10])+num($row[11])+num($row[12]));		
		$grand_total_paid = num($grand_total_paid) + num($paid);		
		$kurang = num($row[6]) - num((num($row[8])+num($row[9])+num($row[10])+num($row[11])+num($row[12])));
		$grand_total_outstanding		= num($grand_total_outstanding)		+ num($kurang); 

		$total_sub_paid = num($total_sub_paid) + num($row[8])+num($row[9])+num($row[10])+num($row[11])+num($row[12]);
		$grand_total_sub_paid = num($grand_total_sub_paid) + num($total_sub_paid) ;
		$remark = "";
		$total_tf = num($total_tf) + num($row[3]);

		$total_sub_net = num($total_sub_net) + num($row[6]);
		$grand_total_sub_net = num($grand_total_sub_net) + num($row[6]);
		$total_sub_rf = num($total_sub_rf) + num($row[7]);
		$grand_total_sub_rf = num($grand_total_sub_rf) + num($total_sub_rf);
		$total_sub_outstanding = num($total_sub_outstanding) + num((num($row[6]) - num((num($row[8])+num($row[9])+num($row[10])+num($row[11])+num($row[12])))))	;
		$grand_total_sub_outstanding = num($grand_total_sub_outstanding) + num($total_sub_outstanding) ;
		$group_kelas =  $row[1]; $baris = num($baris) +1; $nomor_urut = num($nomor_urut)+1;}
	    ?>
		   <tr>
        <td height="21" colspan="4" align=right bgcolor=<?php  echo e($warna) ?> class="style81">Sub Total <?php  echo e($group_kelas) ?> <span class="">(<span class="style86"><?php  echo e($row[17]) ?></span> to <?php  echo e($row[18]) ?>}</span>: </td>
         <td height="21" align=center bgcolor=#CCCCCC class="style81"><span class=""><?php  echo e(buatrp($total_tf)) ?></span></td>
         <td height="21" align=right bgcolor=#CCCCCC class="style81">&nbsp;</td>
         <td align=center bgcolor=#CCCCCC class="style81"><?php  echo e(buatrp($total_sub_net)) ?></td>
        <td align=center bgcolor=#CCCCCC class="style81"><span class=""><?php  echo e(buatrp($total_sub_rf)) ?></span></td>
        <td align=center bgcolor=#CCCCCC class="style81"><span class="style86"><?php  echo e(buatrp($total_sub_paid)) ?></span></td>
        <td align=center bgcolor=#CCCCCC class="style81"><span class=""><?php  echo e(buatrp($total_sub_outstanding)) ?></span></td>
        <td align=left bgcolor=#CCCCCC class="style81">&nbsp;</td>
        <td align=center bgcolor=#CCCCCC class="style81">&nbsp;</td>
        <td align=center bgcolor=#CCCCCC class="style81">&nbsp;</td>
      </tr>

	  <?php  }?>
	       <tr bgcolor="#FFFF00">
        <td height="21" colspan="4" align=right class="style81">TOTAL PAYMENT OPEN CLASS   : </td>
         <td height="21" align=center class="style81"><?php  echo e(buatrp($grand_total_tf)) ?></td>
         <td height="21" align=right class="style81">&nbsp;</td>
         <td align=center class="style81"><?php  echo e(buatrp($grand_total_net)) ?></td>
        <td align=center class="style81"><?php  echo e(buatrp($grand_total_rf)) ?></td>
        <td align=center class="style81"><span class="style86"><?php  echo e(buatrp($grand_total_paid)) ?></span></td>
        <td align=center class="style81"><span class=""><?php  echo e(buatrp($grand_total_outstanding)) ?></span></td>
        <td align=left class="style81">&nbsp;</td>
        <td align=center class="style81">&nbsp;</td>
        <td align=center class="style81">&nbsp;</td>
      </tr>
	       <tr bgcolor="#FFFF00">
             <td height="21" colspan="4" align=right bgcolor="#00FFFF" class="style81">TOTAL PAX OPEN CLASS: </td>
	         <td height="21" colspan="9" align=center bgcolor="#00FFFF" class="style81"><?php  echo e($jml_pax) ?></td>
      </tr>
</table>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
    <!-- /.content -->
	</form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">

              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post"><?php echo csrf_field(); ?>

          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
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
