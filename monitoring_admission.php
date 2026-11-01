<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$year_period = in_val('year_period', 'get');
$week = in_val('week', 'get');
$query = q_set($__p_query, "SELECT no_week, tgl_periode, bulan FROM master_date where minggu = ? and sales_year = '23'", [(string) ($week)]);

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
$sql = q_set($__p_sql, "SELECT min(detail), max(detail) FROM ves_data.tb_minggu_detail where minggu = ? and sales_year = '23'", [(string) ($week)]);

$rs = db_query_soft($sql, $__p_sql ?? []);
while($row = db_fetch($rs))
{
	$awal_mg= $row[0];
	$akhir_mg = $row[1];
	
}
$dest_country = in_val('dest_country', 'get');
$group_school = in_val('group_school', 'get');
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


if ($dest_country == 'ALL' or $dest_country ==''){$pilih_country = '';}
else
{$pilih_country= "and dest_country = '$dest_country' ";}
if ($group_school == 'ALL' or $group_school ==''){$pilih_group = '';}
else
{$pilih_group = "and groupschool = '$group_school' ";}

if ($kd_cbg_dipilih == '100' or $kd_cbg_dipilih ==''){$pilih_cabang = '';}
elseif ($kd_cbg_dipilih == '101'){$pilih_cabang= "and (kd_branch = '1' or kd_branch = '2' kd_branch = '3' kd_branch = '8') ";}
elseif ($kd_cbg_dipilih == '102'){$pilih_cabang= "and (kd_branch = '4' or kd_branch = '5' kd_branch = '6' kd_branch = '7') ";}

else
{$pilih_cabang= "and kd_branch = '$kd_cbg_dipilih' ";}
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
  <style type="text/css">
  .style33 {color: #000000; font-weight: bold; font-size: 12px; }
.style33 {color: #000000; font-weight: bold; font-size: 12px; }
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<?php //========================== left nav ?>
 <?php  //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=monitoring_admission.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Admission Monitoring Tools<br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
		    <td width="148"><small>
            <label for="date5">Enrolled Period</label>
			  </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <select name="year_period"  onChange="this.form.submit()"   class="style33" id="kd_cbg_dipilih2">
                <option value="2021">2021</option>
                <option value="2020">2020</option>
                <option value="2019">2019</option>
                <option value="2018">2018</option>
                <option selected="selected"><?php echo e($year_period) ?></option>
            </select>
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
          <tr>
            <td height="24"><small>
              <label for="date6"> Week</label>
            </small></td>
            <td><small>
              <label for="date7">:</label>
              <strong><font color="#000000">
              <select name="week"  onChange="this.form.submit()"  class="style33" id="nmr_minggu">
                <?php
			$sql = q_set($__p_sql, "select minggu, no_week from master_date where sales_year = '23' group by minggu order by no ");
			$rs = db_query_soft($sql, $__p_sql ?? []);
			while($row = db_fetch($rs))
			{
			  echo "<option value=\"".e($row['minggu'])."\">".e($row['minggu'])."</option>\n  ";
			}
			?>
                <option selected><?php echo e($week) ?></option>
              </select>
              </font></strong></small></td>
          </tr>
          <tr>
            <td height="24"><small>
              <label for="date8"> Period</label>
            </small></td>
            <td><small>
              <label for="date9">:</label>
              <label for="date8"> <?php echo e($tgl_periode) ?></label>
            </small></td>
          </tr>
        </tbody>
      </table>
   
                 <table width="200" border="0">
                   <tbody>
                     <tr>
                       <td><br>
Result : <?php echo e($num_rows_school) ?> Student(s)<br>
<a href="rpt_instdtlbystu.php?intake_start=<?php echo e(u($intake_start)) ?>&intake_end=<?php echo e(u($intake_end)) ?>&kd_cbg_dipilih=<?php echo e(u($kd_cbg_dipilih)) ?>&dest_country=<?php echo e(u($dest_country)) ?>&group_school=<?php echo e(u($group_school)) ?>" target="_blank">Print</a>
</td>
                   
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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th rowspan="3" style="text-align:center;vertical-align: middle;">No</th>
                  <th rowspan="3"style="text-align:center;vertical-align: middle;">Consultant Name</th>
                  <th colspan="2" bgcolor="#D3D3D3" style="text-align:center;" >&nbsp;</th>
                  <th style="text-align:center;" colspan="2" >&nbsp;</th>
                  <th colspan="2" rowspan="2"  bgcolor="#D3D3D3" style="text-align:center;" >Problem</th>
                  <th style="text-align:center;" colspan="10" >ON</th>
                  <th colspan="2" rowspan="2" bgcolor="#D3D3D3" style="text-align:center;"  >L</th>
                  <th colspan="2" rowspan="2" style="text-align:center;" >C</th>
                </tr>
                <tr>
                  <th colspan="2" bgcolor="#D3D3D3" style="text-align:center;" >Enrollment</th>
                  <th style="text-align:center;" colspan="2" >Mandatory Update</th>
                  <th style="text-align:center;" colspan="2" >1</th>
                  <th style="text-align:center;" colspan="2" bgcolor="#D3D3D3"  >2 - 3</th>
                  <th style="text-align:center;" colspan="2" >4 - 6</th>
                  <th style="text-align:center;" colspan="2" bgcolor="#D3D3D3"  >6 - 12</th>
                  <th style="text-align:center;" colspan="2" >PDO</th>
                  </tr>
                <tr>
                  <td bgcolor="#C6F00A" align="center"><strong>This Week</strong></td>
                  <td  align="center"><strong>Year To Date</strong></td>
                  <td bgcolor="#C6F00A" align="center"><strong>To be Update</strong></td>
                  <td  align="center"><strong>Updated</strong></td>
                  <td bgcolor="#C6F00A" align="center"><strong>This Week</strong></td>
                  <td  align="center"><strong>Year Todate</strong></td>
                  <td bgcolor="#C6F00A" align="center"><strong>This Week</strong></td>
                  <td  align="center"><strong>Year Todate</strong></td>
                  <td bgcolor="#C6F00A" align="center"><strong>This Week</strong></td>
                  <td  align="center"><strong>Year Todate</strong></td>
                  <td bgcolor="#C6F00A" align="center"><strong>This Week</strong></td>
                  <td  align="center"><strong>Year Todate</strong></td>
                  <td bgcolor="#C6F00A" align="center"><strong>This Week</strong></td>
                  <td><strong>Year Todate</strong></td>
                  <td bgcolor="#C6F00A" align="center"><strong>This Week</strong></td>
                  <td><strong>Year Todate</strong></td>
                  <td bgcolor="#C6F00A" align="center"><strong>This Week</strong></td>
                  <td><strong>Year Todate</strong></td>
                  <td bgcolor="#C6F00A" align="center"><strong>This Week</strong></td>
                  <td><strong>Year Todate</strong></td>
                  </tr>					
                </thead>
                <tbody>
<?php
$query = q_set($__p_query, "select sc_name, count(case when enroll_date between ? and ? then 1 end) as enroll_this_week,count(case when enroll_date between '2021-01-01' and ? then 1 end) as enroll_todate,\r
count(case when must_update_date between ? and ? then 1 end) as must,\r
count(case when must_update_date between ? and ? and update_date between ? and ?  then 1 end) as must_done,\r
count(case when final_status = 'PR' and update_date between ? and ?  then 1 end) as pr_this,\r
count(case when final_status = 'PR'and update_date between '2021-01-01' and ?  then 1 end) as problem,\r
count(case when final_status = 'ON' and step   like '01:%'  and update_date between ? and ?  then 1 end) as step_1_this,\r
count(case when final_status = 'ON' and step   like '01:%'  and update_date between '2021-01-01' and ? then 1 end) as step_1,\r
count(case when final_status = 'ON' and (step like '02.%' or step like '03.%') and update_date between ? and ? then 1 end) as step_2_3_this,\r
count(case when final_status = 'ON' and (step like '02.%' or step like '03.%') and update_date between '2021-01-01' and ? then 1 end) as step_2_3,\r
count(case when final_status = 'ON' and (step like '04:%' or step like '05.%') and update_date between ? and ? then 1 end) as step_4_5_this,\r
count(case when final_status = 'ON' and (step like '04:%' or step like '05.%') and update_date between '2021-01-01' and ? then 1 end) as step_4_5,\r
count(case when final_status = 'ON' and (step like '06%' or step like '07%' or step like '08%' or step like '09%' or step like '10%' or step like '11%' or step like '12%') and update_date between ? and ?  then 1 end) as step_6_12_this,\r
count(case when final_status = 'ON' and (step like '06%' or step like '07%' or step like '08%' or step like '09%' or step like '10%' or step like '11%' or step like '12%')and update_date between '2021-01-01' and ?  then 1 end) as step_6_12,\r
count(case when final_status = 'PDO'and update_date between ? and ?  then 1 end) as pdo_this,\r
count(case when final_status = 'PDO' and update_date between '2021-01-01' and ? then 1 end) as pdo,\r
count(case when final_status = 'L' and comm_date between ? and ? then 1 end) as leaving_this,\r
count(case when final_status = 'L' and comm_date between '2021-01-01' and ? then 1 end) as leaving,\r
count(case when final_status = 'C' and update_date between ? and ? then 1 end) as cancel_this,\r
count(case when final_status = 'C' and update_date between '2021-01-01' and ? then 1 end) as cancel\r
from adm_stu_progress where kd_branch = ? and enroll_date between '2021-01-01' and ? and aktif = 1 and sc_name <>''\r
 group by sc_name", [(string) ($awal_mg), (string) ($akhir_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($akhir_mg), (string) ($awal_mg), (string) ($akhir_mg), (string) ($akhir_mg), (string) ($kd_cbg_dipilih), (string) ($akhir_mg)]);
					$nomor = 1;
$resource = db_query_or_die('errro_7', $query, $__p_query ?? []);
while ($row=  db_fetch($resource, PDO::FETCH_NUM))
	{	
	$sc_name = $row['0'];$enroll_this = $row['1'];$enroll_todate = $row['2'];$must = $row['3'];$must_done = $row['4'];$pr_this = $row['5'];$pr_todate = $row['6'];$st_1_this = $row['7'];$st_1_todate = $row['8'];$st_2_3_this = $row['9'];$st_2_3_todate = $row['10'];$st_4_5_this = $row['11'];$st_4_5_todate = $row['12'];$st_6_12_this = $row['13'];
$st_6_12_todate = $row['14'];$st_pdo_this = $row['15'];$st_pdo_todate = $row['16'];$st_l_this = $row['17'];$st_l_todate = $row['18'];$st_c_this = $row['19'];$st_c_todate = $row['20'];
$ttl_enroll_this = num($ttl_enroll_this) + num($enroll_this);
$ttl_enroll_todate = num($ttl_enroll_todate) + num($enroll_todate);
$ttl_must = num($ttl_must) + num($must);
$ttl_must_done = num($ttl_must_done) + num($must_done);
$ttl_pr_this = num($ttl_pr_this) + num($pr_this);
$ttl_pr_todate = num($ttl_pr_todate) + num($pr_todate);
$ttl_st_1_this = num($ttl_st_1_this) + num($st_1_this);
$ttl_st_1_todate = num($ttl_st_1_todate) + num($st_1_todate);
$ttl_st_2_3_this = num($ttl_st_2_3_this) + num($st_2_3_this);
$ttl_st_2_3_todate = num($ttl_st_2_3_todate) + num($st_2_3_todate);
$ttl_st_4_5_this = num($ttl_st_4_5_this) + num($st_4_5_this);
$ttl_st_4_5_todate = num($ttl_st_4_5_todate) + num($st_4_5_todate);
$ttl_st_6_12_this = num($ttl_st_6_12_this) + num($st_6_12_this);
$ttl_st_6_12_todate = num($ttl_st_6_12_todate) + num($st_6_12_todate);
$ttl_st_pdo_this = num($ttl_st_pdo_this) + num($st_pdo_this);
$ttl_st_pdo_todate = num($ttl_st_pdo_todate) + num($st_pdo_todate);
$ttl_st_l_this = num($ttl_st_l_this) + num($st_l_this);
$ttl_st_l_todate = num($ttl_st_l_todate) + num($st_l_todate);
$ttl_st_c_this = num($ttl_st_c_this) + num($st_c_this);



?>	
                <tr>
                  <td align="center"> <?php echo e($nomor) ?></td>
                  <td align="left"><?php echo e($sc_name) ?>
                  </td>
                  <td bgcolor="#C6F00A" align="center"><a href="mon_dtl.php?sc=<?php echo e(u($sc_name))?>&yp=<?php echo e(u($year_period)) ?>&w=<?php echo e(u($week)) ?>&kdq=1" target="_blank"><?php echo e($enroll_this) ?></a></td>
                  <td align="center"><?php echo e($enroll_todate) ?></td>
                  <td bgcolor="#C6F00A" align="center"><?php echo e($must) ?></td>
                  <td align="center"><?php echo e($must_done) ?></td>
                  <td bgcolor="#C6F00A" align="center"><?php echo e($pr_this) ?></td>
                  <td align="center"><?php echo e($pr_todate) ?></td>
                  <td bgcolor="#C6F00A" align="center"><?php echo e($st_1_this) ?></td>
                  <td align="center"><?php echo e($st_1_todate) ?></td>
                  <td bgcolor="#C6F00A" align="center"><?php echo e($st_2_3_this) ?></td>
                  <td align="center"><?php echo e($st_2_3_todate) ?></td>
                  <td bgcolor="#C6F00A" align="center"><?php echo e($st_4_5_this) ?></td>
                  <td align="center"><?php echo e($st_4_5_todate) ?></td>
                  <td bgcolor="#C6F00A" align="center"><?php echo e($st_6_12_this) ?></td>
                  <td align="center"><?php echo e($st_6_12_todate) ?></td>
                  <td bgcolor="#C6F00A" align="center"><?php echo e($st_pdo_this) ?></td>
                  <td align="center"><?php echo e($st_pdo_todate) ?></td>
                  <td bgcolor="#C6F00A" align="center"><?php echo e($st_l_this) ?></td>
                  <td align="center"><?php echo e($st_l_todate) ?></td>
                  <td bgcolor="#C6F00A" align="center"><?php echo e($st_c_this) ?></td>
                  <td align="center"><?php echo e($st_c_todate) ?></td>
                </tr>
<?php $nomor = num($nomor) +1; } ?>					
                </tbody>
                <tfoot>
                <tr>
                  <th>&nbsp;</th>
                  <td><strong>Total
                  </th>
                  </strong>
                  <td bgcolor="#C6F00A" align="center"><strong><?php echo e($ttl_enroll_this) ?>
                  </th>
                  </strong>
                  <td align="center"><strong><?php echo e($ttl_enroll_todate) ?>
                  </th>
                  </strong>
                  <td bgcolor="#C6F00A" align="center"><strong><?php echo e($ttl_must) ?>
                  </th>
                  </strong>
                  <td align="center"><strong><?php echo e($ttl_must_done) ?></strong></td>
                  <td align="center" bgcolor="#C6F00A"><strong><?php echo e($ttl_pr_this) ?></strong></td>
                  <td align="center"><strong><?php echo e($ttl_pr_todate) ?></strong></td>
                  <td align="center" bgcolor="#C6F00A"><strong><?php echo e($ttl_st_1_this) ?></strong></td>
                  <td align="center"><strong><?php echo e($ttl_st_1_todate) ?></strong></td>
                  <td align="center" bgcolor="#C6F00A"><strong><?php echo e($ttl_st_2_3_this) ?></strong></td>
                  <td align="center"><strong><?php echo e($ttl_st_2_3_todate) ?></strong></td>
                  <td align="center" bgcolor="#C6F00A"><strong><?php echo e($ttl_st_4_5_this) ?></strong></td>
                  <td align="center"><strong><?php echo e($ttl_st_4_5_todate) ?></strong></td>
                  <td align="center" bgcolor="#C6F00A"><strong><?php echo e($ttl_st_6_12_this) ?></strong></td>
                  <td align="center"><strong><?php echo e($ttl_st_6_12_todate) ?></strong></td>
                  <td align="center" bgcolor="#C6F00A"><strong><?php echo e($ttl_st_pdo_this) ?></strong></td>
                  <td align="center"><strong><?php echo e($ttl_st_pdo_todate) ?></strong></td>
                  <td align="center" bgcolor="#C6F00A"><strong><?php echo e($ttl_st_l_this) ?></strong></td>
                  <td align="center"><strong><?php echo e($ttl_st_l_todate) ?></strong></td>
                  <td align="center" bgcolor="#C6F00A"><strong><?php echo e($ttl_st_c_this) ?></strong></td>
                  <td align="center"><strong><?php echo e($ttl_st_c_todate) ?></strong></td>
                  </tr>
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
