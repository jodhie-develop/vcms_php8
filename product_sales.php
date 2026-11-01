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
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kode_cabang = in_val('kode_cabang', 'get');

if ($kode_cabang == '--ALL--'){ 0;}
if ($kode_cabang == 'East Sby'){$kode_cabang = 1;}
if ($kode_cabang == 'West Sby'){$kode_cabang = 2;}
if ($kode_cabang == 'Denpasar'){$kode_cabang = 3;}
if ($kode_cabang == 'South Jkt'){$kode_cabang = 4;}
if ($kode_cabang == 'North Jkt'){$kode_cabang = 5;}
if ($kode_cabang == 'West Jkt'){$kode_cabang = 6;}
if ($kode_cabang == 'Bandung'){$kode_cabang = 7;}
if ($kode_cabang == 'Malang TBI'){$kode_cabang = 8;}
if ($kode_cabang == 'Bandung TBI'){$kode_cabang = 9;}
if ($kode_cabang == 'Bali TBI'){$kode_cabang = 10;}

if (num($kode_cabang) ==0){$cabang = '--ALL--';}
if ($kode_cabang ==''){$cabang = '--ALL--';}

if (num($kode_cabang) ==1){$cabang = 'East Sby';}
if (num($kode_cabang) ==2){$cabang = 'West Sby';}
if (num($kode_cabang) ==3){$cabang = 'Denpasar';}
if (num($kode_cabang) ==4){$cabang = 'South Jkt';}
if (num($kode_cabang) ==5){$cabang = 'North Jkt';}
if (num($kode_cabang) ==6){$cabang = 'West Jkt';}
if (num($kode_cabang) ==7){$cabang = 'Bandung';}
if (num($kode_cabang) ==8){$cabang = 'Malang TBI';}
if (num($kode_cabang) ==9){$cabang = 'Bandung TBI';}
if (num($kode_cabang) ==10){$cabang = 'Bali TBI';}
echo e($kode_cabang);
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
 <form method=get action=product_sales.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Sales Productivity
        <br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Sales Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date3"> Center :</label>
            </small></td>
            <td><small>
            <label for="date4">:</label>
            <select name="kode_cabang"  onChange="this.form.submit()"   class="style33" id="select">
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
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select></small></td>
          </tr>
        </tbody>
      </table>
                 <?php 
					if (num($kode_cabang) == 0 || $kode_cabang == '')
					{
					$query = q_set($__p_query, "SELECT pic, kd_cabang, date_format(enroll_date, '%Y'),count(distinct kd_biodata) FROM ves_data.tb_sales_report where enroll_date between '2016-01-01' and '2021-11-30'  and status = 'OK' and prioritas = 1 group by pic,pic, date_format(enroll_date, '%Y') order by kd_cabang, pic, enroll_date");
				  	}
				  else	
					{
					$query = q_set($__p_query, "SELECT pic, kd_cabang, date_format(enroll_date, '%Y'),count(distinct kd_biodata) FROM ves_data.tb_sales_report where enroll_date between '2016-01-01' and '2021-11-30'  and status = 'OK' and prioritas = 1 and kd_cabang = ? group by pic,pic, date_format(enroll_date, '%Y') order by pic, enroll_date", [(string) ($kode_cabang)]);
						
					}
				  	$_SESSION['ngueri'] = $query; $_SESSION['ngueri__p'] = $__p_query ?? [];
				  	$no_urut = 1;
					$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
				  	$num_rows = db_num_rows($result);?>      
      <table width="200" border="0">
                   <tbody>
                     <tr>
                       <td><br>
Result : <?php echo e($num_rows) ?></td>
                       <td>
    	    	<a href="sales_productivity_form_xl.php?q=1" target="_blank" class="btn btn-info" role="button">Export to xls</a>

    </td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                   </tbody>
      </table>
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="9%">No</th>
                  <th width="57%">Sales Name</th>
                  <th  align="center" width="20%" colspan="3">2016</th>
                  <th width="14%" colspan="3">2017</th>
                  <th width="14%" colspan="3">2018</th>
                  <th colspan="3">2019</th>
                  <th colspan="3">2020</th>
                  <th colspan="3">2021</th>
                  <th width="7%">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
<tr>
                  <td>&nbsp;</td>
                  <td><a href="sales_center_sc.php?pic=<?php echo e(u($r[2])) ?>&branch=<?php echo e(u($r[1])) ?>"></td>
                  <td>S</td>
                  <td bgcolor="#80FF9A">L</td>
                  <td bgcolor="#FFFE6C">C</td>
                  <td>S</td>
                  <td bgcolor="#80FF9A">L</td>
                  <td bgcolor="#FFFE6C">C</td>
                  <td>S</td>
                  <td bgcolor="#80FF9A">L</td>
                  <td bgcolor="#FFFE6C">C</td>
                  <td width="4%">S</td>
                  <td bgcolor="#80FF9A">L</td>
                  <td width="3%" bgcolor="#FFFE6C">C</td>
                  <td width="7%">S</td>
                  <td width="7%" bgcolor="#80FF9A">L</td>
                  <td bgcolor="#FFFE6C">C</td>
                  <td width="7%">S</td>
                  <td width="4%" bgcolor="#80FF9A">L</td>
                  <td width="3%" bgcolor="#FFFE6C">C</td>
                  <td>&nbsp;</td>
                  </tr>
				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$thn_enroll = $r[2];	
							if ($thn_enroll =='2016')
								{
								$s16 = $r[3];	
								$query_adm = q_set($__p_query_adm, "SELECT\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2016 or date_format(b.tgl_intake,'%Y') = 2016 ) then 1 end) as s16_l16,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2016 ) then 1 end) as s16_c16,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2017 or date_format(b.tgl_intake,'%Y') = 2017 ) then 1 end) as s16_l17,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2017 ) then 1 end) as s16_c17,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2018 or date_format(b.tgl_intake,'%Y') = 2018 ) then 1 end) as s16_l18 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2018 ) then 1 end) as s16_c18,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2019 or date_format(b.tgl_intake,'%Y') = 2019 ) then 1 end) as s16_l19 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2019 ) then 1 end) as s16_c19,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2020 or date_format(b.tgl_intake,'%Y') = 2020 ) then 1 end) as s16_l20 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2020 ) then 1 end) as s16_c20,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2021 or date_format(b.tgl_intake,'%Y') = 2021 ) then 1 end) as s16_l21,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2021 ) then 1 end) as s16_c21  FROM adm_stu_progress b left join tb_sales_report a on b.kd_biodata = a.kd_biodata and b.enroll_date = a.enroll_date\r
\t\t\t\t\t\t\t\twhere (b.final_status  = 'L' or b.final_status  = 'C' )and date_format(a.enroll_date,'%Y') = 2016 and a.pic = ? and a.kd_cabang = ? ", [(string) ($r[0]), (string) ($r[1])]);
								$result_adm=db_query_or_die("Wah error nih5", $query_adm, $__p_query_adm ?? []);
								if ($result_adm) 
								{ 
								while ($r_adm = db_fetch($result_adm))
									{
									$s16_l16 =$r_adm[0];$s16_c16 =$r_adm[1]; $s16_17 = num($s16) - num($s16_l16) - num($s16_c16);$s16_l16_psn = round(num((div($s16_l16, $s16)))*100,2);$s16_c16_psn = round(num((div($s16_c16, $s16)))*100,2);
									$s16_l17 =$r_adm[2];$s16_c17 =$r_adm[3];  $s16_18 = num($s16_17) - num($s16_l17) - num($s16_c17);$s16_l17_psn = round(num((div($s16_l17, $s16)))*100,2);$s16_c17_psn = round(num((div($s16_c17, $s16)))*100,2);
									$s16_l18 =$r_adm[4];$s16_c18 =$r_adm[5];  $s16_19 = num($s16_18) - num($s16_l18) - num($s16_c18);$s16_l18_psn = round(num((div($s16_l18, $s16)))*100,2);$s16_c18_psn = round(num((div($s16_c18, $s16)))*100,2);
									$s16_l19 =$r_adm[6];$s16_c19 =$r_adm[7];  $s16_20 = num($s16_19) - num($s16_l19) - num($s16_c19);$s16_l19_psn = round(num((div($s16_l19, $s16)))*100,2);$s16_c19_psn = round(num((div($s16_c19, $s16)))*100,2);
									$s16_l20 =$r_adm[8];$s16_c20 =$r_adm[9];  $s16_21 = num($s16_20) - num($s16_l20) - num($s16_c20);$s16_l20_psn = round(num((div($s16_l20, $s16)))*100,2);$s16_c20_psn = round(num((div($s16_c20, $s16)))*100,2);
									$s16_l21 =$r_adm[10];$s16_c21 =$r_adm[11];$s16_l21_psn = round(num((div($s16_l21, $s16)))*100,2);$s16_c21_psn = round(num((div($s16_c21, $s16)))*100,2); 										
									}
								}
?>
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php  echo e($r[0])  ; ?> - <?php  echo e($thn_enroll)  ; ?></td>
                  <td><?php  echo e($s16) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16) ; ?></td>
                  <td><?php  echo e($s16_17) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l17) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c17) ; ?></td>
                  <td><?php  echo e($s16_18) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l18) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c18) ; ?></td>
                  <td><?php  echo e($s16_19) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l19) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c19) ; ?></td>
                  <td><?php  echo e($s16_20) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l20) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c20) ; ?></td>
                  <td><?php  echo e($s16_21) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l21) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c21) ; ?></td>
                  <td>&nbsp;</td>
                </tr>
	                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l17_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c17_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l18_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c18_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l19_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c19_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l20_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c20_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l21_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c21_psn) ; ?></td>
                  <td>&nbsp;</td>
                </tr>				
<?php																
								}
								elseif ($thn_enroll =='2017')
								{
								$s17_17 = $r[3];	
								$query_adm = q_set($__p_query_adm, "SELECT\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2017 or date_format(b.tgl_intake,'%Y') = 2017 ) then 1 end) as s17_l17,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2017 ) then 1 end) as s17_c17,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2018 or date_format(b.tgl_intake,'%Y') = 2018 ) then 1 end) as s17_l18 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2018 ) then 1 end) as s17_c18,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2019 or date_format(b.tgl_intake,'%Y') = 2019 ) then 1 end) as s17_l19 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2019 ) then 1 end) as s17_c19,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2020 or date_format(b.tgl_intake,'%Y') = 2020 ) then 1 end) as s17_l20 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2020 ) then 1 end) as s17_c20,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2021 or date_format(b.tgl_intake,'%Y') = 2021 ) then 1 end) as s17_l21,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2021 ) then 1 end) as s17_c21  FROM adm_stu_progress b left join tb_sales_report a on b.kd_biodata = a.kd_biodata and b.enroll_date = a.enroll_date\r
\t\t\t\t\t\t\t\twhere (b.final_status  = 'L' or b.final_status  = 'C' )and date_format(a.enroll_date,'%Y') = 2017 and a.pic = ? and a.kd_cabang = ? ", [(string) ($r[0]), (string) ($r[1])]);
								$result_adm=db_query_or_die("Wah error nih5", $query_adm, $__p_query_adm ?? []);
								if ($result_adm) 
								{ 
								while ($r_adm = db_fetch($result_adm))
									{
									$s17_l17 =$r_adm[0];$s17_c17 =$r_adm[1];  $s17_18 = num($s17_17) - num($s17_l17) - num($s17_c17);$s17_l17_psn = round(num((div($s17_l17, $s17_17)))*100,2);$s17_c17_psn = round(num((div($s17_c17, $s17_17)))*100,2);
									$s17_l18 =$r_adm[2];$s17_c18 =$r_adm[3];  $s17_19 = num($s17_18) - num($s17_l18) - num($s17_c18);$s17_l18_psn = round(num((div($s17_l18, $s17_17)))*100,2);$s17_c18_psn = round(num((div($s17_c18, $s17_17)))*100,2);
									$s17_l19 =$r_adm[4];$s17_c19 =$r_adm[5];  $s17_20 = num($s17_19) - num($s17_l19) - num($s17_c19);$s17_l19_psn = round(num((div($s17_l19, $s17_17)))*100,2);$s17_c19_psn = round(num((div($s17_c19, $s17_17)))*100,2);
									$s17_l20 =$r_adm[6];$s17_c20 =$r_adm[7];  $s17_21 = num($s17_20) - num($s17_l20) - num($s17_c20);$s17_l20_psn = round(num((div($s17_l20, $s17_17)))*100,2);$s17_c20_psn = round(num((div($s17_c20, $s17_17)))*100,2);
									$s17_l21 =$r_adm[8];$s17_c21 =$r_adm[9]; $s17_l21_psn = round(num((div($s17_l21, $s17_17)))*100,2);$s17_c21_psn = round(num((div($s17_c21, $s17_17)))*100,2); 										
									}
								}
?>	

	                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php  echo e($r[0])  ; ?> - <?php  echo e($thn_enroll)  ; ?></td>
                  <td><?php  echo e($s16) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16) ; ?></td>
                  <td><?php  echo e($s17_17) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17) ; ?></td>
                  <td><?php  echo e($s17_18) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l18) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c18) ; ?></td>
                  <td><?php  echo e($s17_19) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l19) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c19) ; ?></td>
                  <td><?php  echo e($s17_20) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l20) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c20) ; ?></td>
                  <td><?php  echo e($s17_21) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l21) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c21) ; ?></td>
                  <td>&nbsp;</td>
                </tr>
 <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l18_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c18_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l19_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c19_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l20_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c20_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l21_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c21_psn) ; ?></td>
                  <td>&nbsp;</td>
                </tr>					
<?php }
								elseif ($thn_enroll =='2018')
								{
								$s18_18 = $r[3];	
								$query_adm = q_set($__p_query_adm, "SELECT\r
\t\t\t\t\t\t\t\t\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2018 or date_format(b.tgl_intake,'%Y') = 2018 ) then 1 end) as s18_l18 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2018 ) then 1 end) as s18_c18,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2019 or date_format(b.tgl_intake,'%Y') = 2019 ) then 1 end) as s18_l19 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2019 ) then 1 end) as s18_c19,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2020 or date_format(b.tgl_intake,'%Y') = 2020 ) then 1 end) as s18_l20 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2020 ) then 1 end) as s18_c20,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2021 or date_format(b.tgl_intake,'%Y') = 2021 ) then 1 end) as s18_l21,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2021 ) then 1 end) as s18_c21  FROM adm_stu_progress b left join tb_sales_report a on b.kd_biodata = a.kd_biodata and b.enroll_date = a.enroll_date\r
\t\t\t\t\t\t\t\twhere (b.final_status  = 'L' or b.final_status  = 'C' )and date_format(a.enroll_date,'%Y') = 2018 and a.pic = ? and a.kd_cabang = ? ", [(string) ($r[0]), (string) ($r[1])]);
								$result_adm=db_query_or_die("Wah error nih5", $query_adm, $__p_query_adm ?? []);
								if ($result_adm) 
								{ 
								while ($r_adm = db_fetch($result_adm))
									{
									$s18_l18 =$r_adm[0];$s18_c18 =$r_adm[1];  $s18_19 = num($s18_18) - num($s18_l18) - num($s18_c18);$s18_l18_psn = round(num((div($s18_l18, $s18_18)))*100,2);$s18_c18_psn = round(num((div($s18_c18, $s18_18)))*100,2);
									$s18_l19 =$r_adm[2];$s18_c19 =$r_adm[3];  $s18_20 = num($s18_19) - num($s18_l19) - num($s18_c19);$s18_l19_psn = round(num((div($s18_l19, $s18_18)))*100,2);$s18_c19_psn = round(num((div($s18_c19, $s18_18)))*100,2);
									$s18_l20 =$r_adm[4];$s18_c20 =$r_adm[5];  $s18_21 = num($s18_20) - num($s18_l20) - num($s18_c20);$s18_l20_psn = round(num((div($s18_l20, $s18_18)))*100,2);$s18_c20_psn = round(num((div($s18_c20, $s18_18)))*100,2);
									$s18_l21 =$r_adm[6];$s18_c21 =$r_adm[7]; $s18_l21_psn = round(num((div($s18_l21, $s18_18)))*100,2);$s18_c21_psn = round(num((div($s18_c21, $s18_18)))*100,2);										
									}
								}
?>	
	                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php  echo e($r[0])  ; ?> - <?php  echo e($thn_enroll)  ; ?></td>
                  <td><?php  echo e($s16) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16) ; ?></td>
                  <td><?php  echo e($s17_17) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17) ; ?></td>
                  <td><?php  echo e($s18_18) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l18) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c18) ; ?></td>
                  <td><?php  echo e($s18_19) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l19) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c19) ; ?></td>
                  <td><?php  echo e($s18_20) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l20) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c20) ; ?></td>
                  <td><?php  echo e($s18_21) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l21) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c21) ; ?></td>
                  <td>&nbsp;</td>
                </tr>	
 <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l18_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c18_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l19_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c19_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l20_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c20_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l21_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c21_psn) ; ?></td>
                  <td>&nbsp;</td>
                </tr>
						
<?php }
								elseif ($thn_enroll =='2019')
								{
								$s19_19 = $r[3];	
								$query_adm = q_set($__p_query_adm, "SELECT\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2019 or date_format(b.tgl_intake,'%Y') = 2019 ) then 1 end) as s19_l19 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2019 ) then 1 end) as s19_c19,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2020 or date_format(b.tgl_intake,'%Y') = 2020 ) then 1 end) as s19_l20 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2020 ) then 1 end) as s19_c20,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2021 or date_format(b.tgl_intake,'%Y') = 2021 ) then 1 end) as s19_l21,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2021 ) then 1 end) as s19_c21  FROM adm_stu_progress b left join tb_sales_report a on b.kd_biodata = a.kd_biodata and b.enroll_date = a.enroll_date\r
\t\t\t\t\t\t\t\twhere (b.final_status  = 'L' or b.final_status  = 'C' )and date_format(a.enroll_date,'%Y') = 2019 and a.pic = ? and a.kd_cabang = ? ", [(string) ($r[0]), (string) ($r[1])]);
								$result_adm=db_query_or_die("Wah error nih5", $query_adm, $__p_query_adm ?? []);
								if ($result_adm) 
								{ 
								while ($r_adm = db_fetch($result_adm))
									{
									$s19_l19 =$r_adm[0];$s19_c19 =$r_adm[1];  $s19_20 = num($s19_19) - num($s19_l19) - num($s19_c19);$s19_l19_psn = round(num((div($s19_l19, $s19_19)))*100,2);$s19_c19_psn = round(num((div($s19_c19, $s19_19)))*100,2);
									$s19_l20 =$r_adm[2];$s19_c20 =$r_adm[3];  $s19_21 = num($s19_20) - num($s19_l20) - num($s19_c20);$s19_l20_psn = round(num((div($s19_l20, $s19_19)))*100,2);$s19_c20_psn = round(num((div($s19_c20, $s19_19)))*100,2);
									$s19_l21 =$r_adm[4];$s19_c21 =$r_adm[5]; $s19_l21_psn = round(num((div($s19_l21, $s19_19)))*100,2);$s19_c21_psn = round(num((div($s19_c21, $s19_19)))*100,2);										
									}
								}
?>	
	                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php  echo e($r[0])  ; ?> - <?php  echo e($thn_enroll)  ; ?></td>
                  <td><?php  echo e($s16) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16) ; ?></td>
                  <td><?php  echo e($s17_17) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17) ; ?></td>
                  <td><?php  echo e($s18_18) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l18) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c18) ; ?></td>
                  <td><?php  echo e($s19_19) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l19) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c19) ; ?></td>
                  <td><?php  echo e($s19_20) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l20) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c20) ; ?></td>
                  <td><?php  echo e($s19_21) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l21) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c21) ; ?></td>
                  <td>&nbsp;</td>
                </tr>	
 <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l18_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c18_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l19_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c19_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l20_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c20_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l21_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c21_psn) ; ?></td>
                  <td>&nbsp;</td>
                </tr>					
<?php }
								elseif ($thn_enroll =='2020')
								{
								$s20_20 = $r[3];	
								$query_adm = q_set($__p_query_adm, "SELECT\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2020 or date_format(b.tgl_intake,'%Y') = 2020 ) then 1 end) as s20_l20 ,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2020 ) then 1 end) as s20_c20,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2021 or date_format(b.tgl_intake,'%Y') = 2021 ) then 1 end) as s20_l21,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2021 ) then 1 end) as s20_c21  FROM adm_stu_progress b left join tb_sales_report a on b.kd_biodata = a.kd_biodata and b.enroll_date = a.enroll_date\r
\t\t\t\t\t\t\t\twhere (b.final_status  = 'L' or b.final_status  = 'C' )and date_format(a.enroll_date,'%Y') = 2020 and a.pic = ? and a.kd_cabang = ? ", [(string) ($r[0]), (string) ($r[1])]);
								$result_adm=db_query_or_die("Wah error nih5", $query_adm, $__p_query_adm ?? []);
								if ($result_adm) 
								{ 
								while ($r_adm = db_fetch($result_adm))
									{
									$s20_l20 =$r_adm[0];$s20_c20 =$r_adm[1];  $s20_21 = num($s20_20) - num($s20_l20) - num($s20_c20);$s20_l20_psn = round(num((div($s20_l20, $s20_20)))*100,2);$s20_c20_psn = round(num((div($s20_c20, $s20_20)))*100,2);
									$s20_l21 =$r_adm[2];$s20_c21 =$r_adm[3]; $s20_l21_psn = round(num((div($s20_l21, $s20_20)))*100,2);$s20_c21_psn = round(num((div($s20_c21, $s20_20)))*100,2);										
									}
								}
?>	
	                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php  echo e($r[0])  ; ?> - <?php  echo e($thn_enroll)  ; ?></td>
                  <td><?php  echo e($s16) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16) ; ?></td>
                  <td><?php  echo e($s17_17) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17) ; ?></td>
                  <td><?php  echo e($s18_18) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l18) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c18) ; ?></td>
                  <td><?php  echo e($s19_19) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l19) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c19) ; ?></td>
                  <td><?php  echo e($s20_20) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s20_l20) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s20_c20) ; ?></td>
                  <td><?php  echo e($s20_21) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s20_l21) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s20_c21) ; ?></td>
                  <td>&nbsp;</td>
                </tr>
 <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l18_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c18_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l19_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c19_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s20_l20_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s20_c20_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s20_l21_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s20_c21_psn) ; ?></td>
                  <td>&nbsp;</td>
				  </tr>					
<?php }
								elseif ($thn_enroll =='2021')
								{
								$s21_21 = $r[3];	
								$query_adm = q_set($__p_query_adm, "SELECT\r
\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'L' and (date_format(b.comm_date,'%Y') = 2021 or date_format(b.tgl_intake,'%Y') = 2021 ) then 1 end) as s21_l21,\r
\t\t\t\t\t\t\t\tcount(case when  b.final_status  = 'C' and (date_format(b.update_date,'%Y') = 2021 ) then 1 end) as s21_c21  FROM adm_stu_progress b left join tb_sales_report a on b.kd_biodata = a.kd_biodata and b.enroll_date = a.enroll_date\r
\t\t\t\t\t\t\t\twhere (b.final_status  = 'L' or b.final_status  = 'C' )and date_format(a.enroll_date,'%Y') = 2021 and a.pic = ? and a.kd_cabang = ? ", [(string) ($r[0]), (string) ($r[1])]);
								$result_adm=db_query_or_die("Wah error nih5", $query_adm, $__p_query_adm ?? []);
								if ($result_adm) 
								{ 
								while ($r_adm = db_fetch($result_adm))
									{

									$s21_l21 =$r_adm[0];$s21_c21 =$r_adm[1]; $s21_l21_psn = round(num((div($s21_l21, $s21_21)))*100,2);$s21_c21_psn = round(num((div($s21_c21, $s21_21)))*100,2);											
									}
								}
?>	
	                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php  echo e($r[0])  ; ?> - <?php  echo e($thn_enroll)  ; ?></td>
                  <td><?php  echo e($s16) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16) ; ?></td>
                  <td><?php  echo e($s17_17) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17) ; ?></td>
                  <td><?php  echo e($s18_18) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s18_l18) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s18_c18) ; ?></td>
                  <td><?php  echo e($s19_19) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l19) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c19) ; ?></td>
                  <td><?php  echo e($s20_20) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s20_l20) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s20_c20) ; ?></td>
                  <td><?php  echo e($s21_21) ; ?></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s21_l21) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s21_c21) ; ?></td>
                  <td>&nbsp;</td>
                </tr>	
 <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s16_l16_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s16_c16_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l17_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c17_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s17_l18_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s17_c18_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s19_l19_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s19_c19_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s20_l20_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s2_c20_psn) ; ?></td>
                  <td></td>
                  <td bgcolor="#80FF9A"><?php  echo e($s21_l21_psn) ; ?></td>
                  <td bgcolor="#FFFE6C"><?php  echo e($s21_c21_psn) ; ?></td>
                  <td>&nbsp;</td>
				  </tr>					
<?php								}								

				?>                  
                


                <?php $no_urut = num($no_urut) + 1;$s16=''; $s16_l16 ='';$s16_c16 = '';$s16_l17 ='';$s16_c17 = '';$s16_l18 ='';$s16_c18 = '';$s16_l19 ='';$s16_c19 = '';$s16_l20 ='';$s16_c20 = '';$s16_l21 ='';$s16_c21 = '';$s16_17='';$s16_18='';$s16_19='';$s16_20='';$s16_21='';
$s17_17=''; $s17_l17 ='';$s17_c17 = '';$s17_l18 ='';$s17_c18 = '';$s17_l19 ='';$s17_c19 = '';$s17_l20 ='';$s17_c20 = '';$s17_l21 ='';$s17_c21 = '';$s17_17='';$s17_18='';$s17_19='';$s17_20='';$s17_21='';$s18_l18 ='';$s18_c18 = '';$s18_l19 ='';$s18_c19 = '';$s18_l20 ='';$s18_c20 = '';$s18_l21 ='';$s18_c21 = '';$s18_18='';$s18_19='';$s18_20='';$s18_21='';	
$s19_c19 = '';$s19_l19 ='';$s19_c19 = '';$s19_l20 ='';$s19_c20 = '';$s19_l21 ='';$s19_c21 = '';$s19_19='';$s19_19='';$s19_20='';$s19_21='';
$s20_l20 ='';$s20_c20 = '';$s20_l21 ='';$s20_c21 = '';$s20_20='';$s19_19='';$s21_c21 = '';$s21_l21 ='';$s21_c21 = '';$s21_21='';$s19_19='';
$s16_l16_psn ='';$s16_l17_psn ='';$s16_l18_psn ='';$s16_l19_psn ='';$s16_l20_psn ='';$s16_l21_psn ='';
$s16_c16_psn ='';$s16_c17_psn ='';$s16_c18_psn ='';$s16_c19_psn ='';$s16_c20_psn ='';$s16_c21_psn ='';	
$s17_l17_psn ='';$s17_l17_psn ='';$s17_l18_psn ='';$s17_l19_psn ='';$s17_l20_psn ='';$s17_l21_psn ='';
$s17_c17_psn ='';$s17_c17_psn ='';$s17_c18_psn ='';$s17_c19_psn ='';$s17_c20_psn ='';$s17_c21_psn ='';
$s18_l16_psn ='';$s18_l17_psn ='';$s18_l18_psn ='';$s18_l19_psn ='';$s18_l20_psn ='';$s18_l21_psn ='';
$s18_c18_psn ='';$s18_c17_psn ='';$s18_c18_psn ='';$s18_c19_psn ='';$s18_c20_psn ='';$s18_c21_psn ='';
$s16_l16_psn ='';$s16_l17_psn ='';$s16_l18_psn ='';$s19_l19_psn ='';$s19_l20_psn ='';$s19_l21_psn ='';
$s16_c16_psn ='';$s16_c17_psn ='';$s16_c18_psn ='';$s19_c19_psn ='';$s19_c20_psn ='';$s19_c21_psn ='';
$s16_l16_psn ='';$s16_l17_psn ='';$s16_l18_psn ='';$s16_l19_psn ='';$s20l20_psn ='';$s21_l21_psn ='';
$s16_c16_psn ='';$s16_c17_psn ='';$s16_c18_psn ='';$s16_c19_psn ='';$s20_c20_psn ='';$s21_c21_psn ='';
$s16_l16_psn ='';$s16_l17_psn ='';$s16_l18_psn ='';$s16_l19_psn ='';$s16_l20_psn ='';$s21_l21_psn ='';
$s16_c16_psn ='';$s16_c17_psn ='';$s16_c18_psn ='';$s16_c19_psn ='';$s16_c20_psn ='';$s21_c21_psn ='';							
							} }?>
                </tbody>
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
