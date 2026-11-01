<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$intake_start = in_val('intake_start', 'get');
$intake_end = in_val('intake_end', 'get');

if($intake_start==''){$intake_start= "$tahun-$bulan-01";}
if($intake_end==''){$intake_end= $hari_ini;}

$kd_cbg_dipilih = in_val('kd_cbg_dipilih', 'get');
if($kd_cbg_dipilih==''){$kd_cbg_dipilih= 'National';}
if ($kd_cbg_dipilih_dipilih == '--ALL--'){$kd_cbg_dipilih = 'National';}
if ($kd_cbg_dipilih == 'East Sby'){$kd_cbg_dipilih = 1;}
if ($kd_cbg_dipilih == 'West Sby'){$kd_cbg_dipilih = 2;}
if ($kd_cbg_dipilih == 'Denpasar'){$kd_cbg_dipilih = 3;}
if ($kd_cbg_dipilih == 'South Jkt'){$kd_cbg_dipilih = 4;}
if ($kd_cbg_dipilih == 'North Jkt'){$kd_cbg_dipilih = 5;}
if ($kd_cbg_dipilih == 'West Jkt'){$kd_cbg_dipilih = 6;}
if ($kd_cbg_dipilih == 'Bandung'){$kd_cbg_dipilih = 7;}
if ($kd_cbg_dipilih == 'Malang TBI'){$kd_cbg_dipilih = 8;}
if ($kd_cbg_dipilih == 'Bandung TBI'){$kd_cbg_dipilih = 9;}
if ($kd_cbg_dipilih == 'Bali TBI'){$kd_cbg_dipilih = 10;}
if ($kd_cbg_dipilih == 'National'){$kd_cbg_dipilih = 100;}


if ($kd_cbg_dipilih ==''){$cabang = '--ALL--';}
if (num($kd_cbg_dipilih) ==1){$cabang = 'East Sby';}
if (num($kd_cbg_dipilih) ==2){$cabang = 'West Sby';}
if (num($kd_cbg_dipilih) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg_dipilih) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg_dipilih) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg_dipilih) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg_dipilih) ==7){$cabang = 'Bandung';}
if (num($kd_cbg_dipilih) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg_dipilih) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg_dipilih) ==10){$cabang = 'Bali TBI';}
if (num($kd_cbg_dipilih) ==101){$cabang = 'East Area';}
if (num($kd_cbg_dipilih) ==102){$cabang = 'West Area';}
if (num($kd_cbg_dipilih) ==100){$cabang = 'National';}




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
<?php //========================== left nav ?>
 <?php    include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=institution_leavingbystep.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Admission Student
        by Step base on COUNTRY<br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
		    <td width="148"><small>
            <label for="date5"> Intake Period:</label>
			  </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
              <input type="date" format="dd/MM/yyyy" name="intake_start" id="date2" value="<?php echo e($intake_start) ; ?>" onChange="this.form.submit()">
            to 
            <input type="date" format="dd/MM/yyyy" name="intake_end" id="date" value="<?php echo e($intake_end) ; ?>" onChange="this.form.submit()">
            </small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date3"> Center :</label>
            </small></td>
            <td><small>
            <label for="date4">:</label>
            <select name="kd_cbg_dipilih"  onChange="this.form.submit()"   class="style33" id="select">
              <option value="0">--CHOOSE--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="8">Malang</option>
              <option value="101">East Area</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="102">West Area</option>
              <option value="100">National</option>
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select>
            </small></td>
          </tr>
        </tbody>
      </table>
                 <?php 
					if ($kd_cbg_dipilih =='101'){
					$query_school = q_set($__p_query_school, "SELECT dest_country, count(CASE WHEN final_status = 'C' and update_date between ? and ?  THEN '1' END) as C,\r
count(CASE WHEN (final_status = 'PR' and tgl_intake between ? and ? ) or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )  THEN '1' END) as pr,\r
count(CASE WHEN final_status = 'ON' and step like '1:%' and tgl_intake between ? and ? THEN '1' END) as step_10,\r
count(CASE WHEN final_status = 'ON' and tgl_intake between ? and ? and (step like '2:%' or step like '3:%') THEN '1' END) as step_30,\r
count(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '4%' or step like '5%') THEN '1' END) as step_60,\r
count(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '6%' or step like '7%' or step like '8%' or step like '9%' or step like '10%' or step like '11%' or step like '12%') THEN '1' END) as step_80,\r
count(CASE WHEN final_status = 'PDO'  and tgl_intake between ? and ? THEN '1' END ) as PDO, count(CASE WHEN final_status = 'L' and comm_date between ? and ?  THEN '1' END ) as L,\r
count(CASE WHEN final_status = 'ON' and (step like '15%' or step = '') and tgl_intake between ? and ? THEN '1' END ) as other,\r
count(CASE WHEN final_status <> 'L' and final_status <> 'C' and tgl_intake < ? THEN '1' END ) as outstanding\r
FROM adm_stu_progress  where dest_school <>'' and  (kd_branch = '1' or kd_branch = '2'or kd_branch = '3'or kd_branch = '8') and aktif = 1 and\r
((final_status = 'L' and comm_date between ? and ? )\r
or (final_status = 'ON' and tgl_intake between ? and ? )\r
or (final_status = 'PR' and tgl_intake between ? and ? )\r
or (final_status = 'C' and update_date between ? and ? )\r
or (final_status = 'PDO' and tgl_intake between ? and ? )\r
or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
) group by dest_country", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start)]);
					}
elseif ($kd_cbg_dipilih =='100'){
					$query_school = q_set($__p_query_school, "SELECT dest_country, count(CASE WHEN final_status = 'C' and update_date between ? and ?  THEN '1' END) as C,\r
count(CASE WHEN  (final_status = 'PR' and tgl_intake between ? and ? ) or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? ) THEN '1' END) as pr,\r
count(CASE WHEN final_status = 'ON' and step like '1:%' and tgl_intake between ? and ? THEN '1' END) as step_10,\r
count(CASE WHEN final_status = 'ON' and tgl_intake between ? and ? and (step like '2:%' or step like '3:%') THEN '1' END) as step_30,\r
count(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '4%' or step like '5%') THEN '1' END) as step_60,\r
count(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '6%' or step like '7%' or step like '8%' or step like '9%' or step like '10%' or step like '11%' or step like '12%') THEN '1' END) as step_80,\r
count(CASE WHEN final_status = 'PDO'  and tgl_intake between ? and ? THEN '1' END ) as PDO, count(CASE WHEN final_status = 'L' and comm_date between ? and ?  THEN '1' END ) as L,\r
count(CASE WHEN final_status = 'ON' and (step like '15%' or step = '') and tgl_intake between ? and ? THEN '1' END ) as other,\r
count(CASE WHEN final_status <> 'L' and final_status <> 'C' and tgl_intake < ? THEN '1' END ) as outstanding\r
FROM adm_stu_progress  where  dest_school <>'' and   aktif = 1 and\r
((final_status = 'L' and comm_date between ? and ? )\r
or (final_status = 'ON' and tgl_intake between ? and ? )\r
or (final_status = 'PR' and tgl_intake between ? and ? )\r
or (final_status = 'C' and update_date between ? and ? )\r
or (final_status = 'PDO' and tgl_intake between ? and ? )\r
or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
) group by dest_country", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start)]);
					}
else{
					$query_school = q_set($__p_query_school, "SELECT dest_country, count(CASE WHEN final_status = 'C' and update_date between ? and ?  THEN '1' END) as C,\r
count(CASE WHEN  (final_status = 'PR' and tgl_intake between ? and ? ) or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? ) THEN '1' END) as pr,\r
count(CASE WHEN final_status = 'ON' and step like '1:%' and tgl_intake between ? and ? THEN '1' END) as step_10,\r
count(CASE WHEN final_status = 'ON' and tgl_intake between ? and ? and (step like '2:%' or step like '3:%') THEN '1' END) as step_30,\r
count(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '4%' or step like '5%') THEN '1' END) as step_60,\r
count(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '6%' or step like '7%' or step like '8%' or step like '9%' or step like '10%' or step like '11%' or step like '12%') THEN '1' END) as step_80,\r
count(CASE WHEN final_status = 'PDO'  and tgl_intake between ? and ? THEN '1' END ) as PDO, count(CASE WHEN final_status = 'L' and comm_date between ? and ?  THEN '1' END ) as L,\r
count(CASE WHEN final_status = 'ON' and (step like '15%' or step = '') and tgl_intake between ? and ? THEN '1' END ) as other,\r
count(CASE WHEN final_status <> 'L' and final_status <> 'C' and tgl_intake < ? THEN '1' END ) as outstanding\r
FROM adm_stu_progress  where   dest_school <>'' and kd_branch = ? and aktif = 1 and\r
((final_status = 'L' and comm_date between ? and ? )\r
or (final_status = 'ON' and tgl_intake between ? and ? )\r
or (final_status = 'PR' and tgl_intake between ? and ? )\r
or (final_status = 'C' and update_date between ? and ? )\r
or (final_status = 'PDO' and tgl_intake between ? and ? )\r
or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
) group by dest_country", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($kd_cbg_dipilih), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start)]);
					}
				  
				  $urutan  = q_set($__p_urutan, " order by case \r
\t\t\t\t  when dest_country like 'USA%' then 1\r
\t\t\t\t  when dest_country like 'CAN%' then 2\r
\t\t\t\t  when dest_country like 'SWI%' then 3\r
\t\t\t\t  when dest_country like 'UK%' then 4\r
\t\t\t\t  when dest_country like 'SP%' then 5\r
\t\t\t\t  when dest_country like 'IT%' then 6\t\t\t\t  \r
\t\t\t\t  when dest_country like 'AUS%' then 7\r
\t\t\t\t  when dest_country like 'NEW%' then 8\r
\t\t\t\t  when dest_country like 'SIN%' then 9\r
\t\t\t\t  when dest_country like 'MAL%' then 10\r
\t\t\t\t  when dest_country like 'CHI%' then 11\r
\t\t\t\t  when dest_country like 'IND%' then 12\r
\t\t\t\t  else 13 end "); 
					$no_urut = 1;

					$query_school = q_set($__p_query_school, $query_school . " " . $urutan, [...($__p_query_school ?? []), ...($__p_urutan ?? [])]);
					$result_school=db_query_or_die("Wah error nih5", $query_school, $__p_query_school ?? []);
				  	$num_rows_school = db_num_rows($result_school);?>      
      <table width="200" border="0">
                   <tbody>
                     <tr>
                       <td><br>
Result : <?php echo e($num_rows_school) ?> Country (ies)<br>
<a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=a" target="_blank">
            <label>Display All Detail Data</label></button></a></td>
                   
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                   </tbody>
      </table>
    </section><!-- Main content -->

      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-body">
              <table id="examples1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="4%">No</th>
                  <th width="17%">Country</th>
                  <th width="7%">On <br>
                  Hand Student</th>
                  <th width="16%">Problem</th>
                  <th width="5%">Other</th>
                  <th width="8%">Step 1</th>
                  <th width="6%">2 - 3</th>
                  <th width="8%">4 - 5</th>
                  <th width="6%">6 - 12</th>
                  <th width="4%">PDO</th>
                  <th width="6%">Leaving <br>
                  Prediction Total</th>
                  <th width="5%">Cancel</th>
                  <th width="8%">Leaving</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					$jml_ttl_onhand = 0;  $ttl_r_school[1] = 0;$ttl_r_school[2]  = 0;$ttl_r_school[3]  = 0;$ttl_r_school[4]  = 0;$ttl_r_school[5]  = 0;$ttl_r_school[6]  = 0;$ttl_r_school[7] = 0;$ttl_r_school[8]  = 0; $ttl_r_school[9] = 0; $ttl_r_school[10] = 0;$jml_ttl_prediksi = 0;
					if ($result_school) 
						{ 
						while ($r_school = db_fetch($result_school))
							{
							$ttl_onhand =  num($r_school[9]) +num($r_school[3]) +num($r_school[4]) +num($r_school[5]) +num($r_school[6])+num($r_school[7]);
							$ttl_prediksi=  num($r_school[4]) + num($r_school[5]) +num($r_school[6]) +num($r_school[7]);	
							$ttl_baris = num($r_school[2]) +num($r_school[3]) +num($r_school[4]) +num($r_school[5]) +num($r_school[6]) +num($r_school[7])+num($r_school[8]) + num($r_school[9]);
							
								
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>" target="_blank"><?php echo e($r_school[0]) ; ?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=oh" target="_blank"><?php echo e($ttl_onhand)?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=pr" target="_blank"><?php echo e($r_school[2]) ; ?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=ot" target="_blank"><?php echo e($r_school[9]) ; ?></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=st1" target="_blank"><?php echo e($r_school[3]) ; ?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=st2" target="_blank"><?php echo e($r_school[4]) ; ?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=st4" target="_blank"><?php echo e($r_school[5]) ; ?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=st6" target="_blank"><?php echo e($r_school[6]) ; ?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=pdo" target="_blank"><?php echo e($r_school[7]) ; ?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=prl" target="_blank"><?php echo e($ttl_prediksi) ?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=c" target="_blank"><?php echo e($r_school[1]) ; ?></a></td>
                  <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=l" target="_blank"><?php echo e($r_school[8]) ; ?></a></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; 
								$jml_ttl_onhand = num($jml_ttl_onhand) + num($ttl_onhand) ; 
								$ttl_r_school[1]=num($ttl_r_school[1]) + num($r_school[1]);								
								$ttl_r_school[2]=num($ttl_r_school[2]) + num($r_school[2]);
								$ttl_r_school[3]=num($ttl_r_school[3]) + num($r_school[3]);
								$ttl_r_school[4]=num($ttl_r_school[4]) + num($r_school[4]);
								$ttl_r_school[5]=num($ttl_r_school[5]) + num($r_school[5]);
								$ttl_r_school[6]=num($ttl_r_school[6]) + num($r_school[6]);
								$ttl_r_school[7]=num($ttl_r_school[7]) + num($r_school[7]);
								$ttl_r_school[8]=num($ttl_r_school[8]) + num($r_school[8]);
								$ttl_r_school[9]=num($ttl_r_school[9]) + num($r_school[9]);
								$ttl_r_school[10]=num($ttl_r_school[10]) + num($r_school[10]);
								$jml_ttl_prediksi=num($jml_ttl_prediksi) + num($ttl_prediksi);									
}} ?>
                          <tr>
                            <td colspan="2"><strong>TOTAL</strong></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=toh" target="_blank"><?php echo e($jml_ttl_onhand) ?></a></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tpr" target="_blank"><?php echo e($ttl_r_school[2]) ; ?></a></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tot" target="_blank"><?php echo e($ttl_r_school[9]) ; ?></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tst1" target="_blank"><?php echo e($ttl_r_school[3]) ; ?></a></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tst2" target="_blank"><?php echo e($ttl_r_school[4]) ; ?></a></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tst4" target="_blank"><?php echo e($ttl_r_school[5]) ; ?></a></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tst6" target="_blank"><?php echo e($ttl_r_school[6]) ; ?></a></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tpdo" target="_blank"><?php echo e($ttl_r_school[7]) ; ?></a></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tprl" target="_blank"><?php echo e($jml_ttl_prediksi) ?></a></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tc" target="_blank"><?php echo e($ttl_r_school[1]) ; ?></a></td>
                            <td><a href="admdtl.php?cn=<?php echo e(u($r_school[0])) ?>&kc=<?php echo   e(u($cabang)) ?>&ints=<?php echo   e(u($intake_start)) ?>&inte=<?php echo   e(u($intake_end)) ?>&st=tl" target="_blank"><?php echo e($ttl_r_school[8]) ; ?></a></td>
                          </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
     
      <div class="row">
        <div class="col-xs-12">
                         <div class="form-group">
                        </div></div>
        <!-- /.col -->
	  </div>

      <!-- /.row -->
  
         
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
