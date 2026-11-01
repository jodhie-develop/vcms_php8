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
{$pilih_country= q_set($__p_pilih_country, "and dest_country = ? ", [(string) ($dest_country)]);}
if ($group_school == 'ALL' or $group_school ==''){$pilih_group = '';}
else
{$pilih_group = q_set($__p_pilih_group, "and groupschool = ? ", [(string) ($group_school)]);}

if ($kd_cbg_dipilih == '100' or $kd_cbg_dipilih ==''){$pilih_cabang = '';}
elseif ($kd_cbg_dipilih == '101'){$pilih_cabang= q_set($__p_pilih_cabang, "and (kd_branch = '1' or kd_branch = '2' kd_branch = '3' kd_branch = '8') ");}
elseif ($kd_cbg_dipilih == '102'){$pilih_cabang= q_set($__p_pilih_cabang, "and (kd_branch = '4' or kd_branch = '5' kd_branch = '6' kd_branch = '7') ");}

else
{$pilih_cabang= q_set($__p_pilih_cabang, "and kd_branch = ? ", [(string) ($kd_cbg_dipilih)]);}
?>
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<style type="text/css">
<!--

	.style33 {
	color:#000;
	font-size:75%;
	}

</style>  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          </i>PIPELINE REPORT<br>
        </h2>
        <p>
          <label>Center: <?php echo e($cabang)  ?><br>
          Group School : <?php echo e($group_school) ?> </label>
          <br>
          <label>Country: </label>
          <?php echo e($dest_country)  ?><br>                
          <label>Intake Period: <?php echo e($intake_start) ?> to <?php echo e($intake_end) ?> </label>
          <br>
        </p>                

      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info"><!-- /.col --><!-- /.col --><!-- /.col -->
    </div>
    <!-- /.row -->
                <?php 
					if ($kd_cbg_dipilih =='101'){
					$query_school = q_set($__p_query_school, "SELECT nama, enroll_date, groupschool, dest_school,dest_country, program_clasifie,date_format(tgl_intake,'%d %b %y'),\r
(CASE WHEN final_status = 'ON' and (step like '1:%' or step like '1.%' or step like '15%' or step = '') and tgl_intake between ? and ? THEN '1' END) as step_10,\r
(CASE WHEN final_status = 'ON' and tgl_intake between ? and ? and (step like '2:%' or step like '3:%' or step like '2.%' or step like '3.%') THEN '1' END) as step_30,\r
(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '4%' or step like '5%') THEN '1' END) as step_60,\r
(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '6%' or step like '7%' or step like '8%' or step like '9%' or step like '10%' or step like '11%' or step like '12%') THEN '1' END) as step_80,\r
(CASE WHEN final_status = 'PDO'  and tgl_intake between ? and ? THEN '1' END ) as PDO, (CASE WHEN final_status = 'L' and comm_date between ? and ?  THEN '1' END ) as L,\r
(CASE when kd_branch = '1' then '1' end) as c1,\r
(CASE when kd_branch = '2' then '1' end) as c2,\r
(CASE when kd_branch = '3' then '1' end) as c3,\r
(CASE when kd_branch = '4' then '1' end) as c4,\r
(CASE when kd_branch = '5' then '1' end) as c5,\r
(CASE when kd_branch = '6' then '1' end) as c6,\r
(CASE when kd_branch = '7' then '1' end) as c7,\r
(CASE when kd_branch = '8' then '1' end) as c8,a.kd_biodata FROM adm_stu_progress  a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country where  dest_school <>'' and  aktif = 1 and\r
( (final_status = 'ON' and tgl_intake between ? and ? )\r
or (final_status = 'PDO' and tgl_intake between ? and ? )\r
) " . $pilih_country . " " . $pilih_group . " " . $pilih_cabang . " group by kd_biodata", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_pilih_cabang ?? [])]);

					}
elseif ($kd_cbg_dipilih =='100'){
					$query_school = q_set($__p_query_school, "SELECT nama, enroll_date, groupschool, dest_school,dest_country, program_clasifie,date_format(tgl_intake,'%d %b %y'),\r
(CASE WHEN final_status = 'ON' and (step like '1:%' or step like '1.%' or step like '15%' or step = '') and tgl_intake between ? and ? THEN '1' END) as step_10,\r
(CASE WHEN final_status = 'ON' and tgl_intake between ? and ? and (step like '2:%' or step like '3:%' or step like '2.%' or step like '3.%') THEN '1' END) as step_30,\r
(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '4%' or step like '5%') THEN '1' END) as step_60,\r
(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '6%' or step like '7%' or step like '8%' or step like '9%' or step like '10%' or step like '11%' or step like '12%') THEN '1' END) as step_80,\r
(CASE WHEN final_status = 'PDO'  and tgl_intake between ? and ? THEN '1' END ) as PDO, (CASE WHEN final_status = 'L' and comm_date between ? and ?  THEN '1' END ) as L,\r
(CASE when kd_branch = '1' then '1' end) as c1,\r
(CASE when kd_branch = '2' then '1' end) as c2,\r
(CASE when kd_branch = '3' then '1' end) as c3,\r
(CASE when kd_branch = '4' then '1' end) as c4,\r
(CASE when kd_branch = '5' then '1' end) as c5,\r
(CASE when kd_branch = '6' then '1' end) as c6,\r
(CASE when kd_branch = '7' then '1' end) as c7,\r
(CASE when kd_branch = '8' then '1' end) as c8,a.kd_biodata\r
FROM adm_stu_progress  a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country where  dest_school <>'' and aktif = 1 and\r
( (final_status = 'ON' and tgl_intake between ? and ? )\r
or (final_status = 'PDO' and tgl_intake between ? and ? )\r
)  " . $pilih_country . " " . $pilih_group . " " . $pilih_cabang . " group by kd_biodata", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_pilih_cabang ?? [])]);
					}
else{
$query_school = q_set($__p_query_school, "SELECT nama, enroll_date, groupschool, dest_school,dest_country, program_clasifie,date_format(tgl_intake,'%d %b %y'),\r
(CASE WHEN final_status = 'ON' and (step like '1:%' or step like '1.%' or step like '15%' or step = '') and tgl_intake between ? and ? THEN '1' END) as step_10,\r
(CASE WHEN final_status = 'ON' and tgl_intake between ? and ? and (step like '2:%' or step like '3:%' or step like '2.%' or step like '3.%') THEN '1' END) as step_30,\r
(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '4%' or step like '5%') THEN '1' END) as step_60,\r
(CASE WHEN final_status = 'ON' and  tgl_intake between ? and ? and (step like '6%' or step like '7%' or step like '8%' or step like '9%' or step like '10%' or step like '11%' or step like '12%') THEN '1' END) as step_80,\r
(CASE WHEN final_status = 'PDO'  and tgl_intake between ? and ? THEN '1' END ) as PDO, (CASE WHEN final_status = 'L' and comm_date between ? and ?  THEN '1' END ) as L,\r
(CASE when kd_branch = '1' then '1' end) as c1,\r
(CASE when kd_branch = '2' then '1' end) as c2,\r
(CASE when kd_branch = '3' then '1' end) as c3,\r
(CASE when kd_branch = '4' then '1' end) as c4,\r
(CASE when kd_branch = '5' then '1' end) as c5,\r
(CASE when kd_branch = '6' then '1' end) as c6,\r
(CASE when kd_branch = '7' then '1' end) as c7,\r
(CASE when kd_branch = '8' then '1' end) as c8,a.kd_biodata\r
FROM adm_stu_progress  a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country where  dest_school <>'' and aktif = 1 and\r
( (final_status = 'ON' and tgl_intake between ? and ? )\r
or (final_status = 'PDO' and tgl_intake between ? and ? )\r
) " . $pilih_country . " " . $pilih_group . "  " . $pilih_cabang . " group by kd_biodata", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_pilih_cabang ?? [])]);
					}
				  $urutan  = q_set($__p_urutan, " order by a.update_date desc"); 
					$no_urut = 1;
					$query_school = q_set($__p_query_school, $query_school . " " . $urutan, [...($__p_query_school ?? []), ...($__p_urutan ?? [])]);
					$result_school=db_query_or_die("Wah error nih15", $query_school, $__p_query_school ?? []);
				  	$num_rows_school = db_num_rows($result_school);?>     
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table id="examples1" class="table table-bordered ">
                <thead>
                <tr>
                  <th width="4%" rowspan="2">No</th>
                  <th width="6%" rowspan="2">Student Name</th>
                  <th width="8%" rowspan="2">Enroll Date</th>
                  <th width="4%" rowspan="2">Group</th>
                  <th width="8%" rowspan="2">Institution</th>
                  <th width="5%" rowspan="2">Country</th>
                  <th width="5%" rowspan="2">Program</th>
                  <th width="10%" rowspan="2" align="center" valign="middle">Intake</th>
                  <th colspan="5"  align="center">Step</th>
                  <th colspan="8">Center</th>
                  </tr>
                <tr>
                  <th width="4%">10%</th>
                  <th width="4%">30%</th>
                  <th width="4%">60%</th>
                  <th width="4%">80%</th>
                  <th width="4%">100%</th>
                  <th width="6%">East Sby</th>
                  <th width="6%">West Sby</th>
                  <th width="6%">Bali</th>
                  <th width="6%">South Jkt</th>
                  <th width="6%">North Jkt</th>
                  <th width="6%">West Jkt</th>
                  <th width="6%">BDG</th>
                  <th width="6%">MLG</th>
                  </tr>
                </thead>
          <tbody>

				  <?php 

					$ttl_10 = 0;  $ttl_20 = 0;$ttl_30  = 0;$ttl_60  = 0;$ttl_80  = 0;$ttl_100  = 0;$ttl_c1  = 0;$ttl_c2  = 0;$ttl_c3  = 0;$ttl_c4  = 0;$ttl_c5  = 0;$ttl_c6  = 0;$ttl_c7  = 0;$ttl_c8  = 0;
					if ($result_school) 
						{ 
						while ($r_school = db_fetch($result_school))
							{
							if (num($r_school[7]) == 1){$ttl_10 = num($ttl_10) + 1;}
							elseif (num($r_school[8]) == 1){$ttl_30 = num($ttl_30) + 1;}
							elseif (num($r_school[9]) == 1){$ttl_60 = num($ttl_60) + 1;}
							elseif (num($r_school[10]) == 1){$ttl_80 = num($ttl_80) + 1;}
							elseif (num($r_school[11]) == 1){$ttl_100 = num($ttl_100) + 1;}
							if (num($r_school[13]) == 1){$ttl_c1 = num($ttl_c1) + 1;}
							elseif (num($r_school[14]) == 1){$ttl_c2 = num($ttl_c2) + 1;}
							elseif (num($r_school[15]) == 1){$ttl_c3 = num($ttl_c3) + 1;}
							elseif (num($r_school[16]) == 1){$ttl_c4 = num($ttl_c4) + 1;}
							elseif (num($r_school[17]) == 1){$ttl_c5 = num($ttl_c5) + 1;}
							elseif (num($r_school[18]) == 1){$ttl_c6 = num($ttl_c6) + 1;}
							elseif (num($r_school[19]) == 1){$ttl_c7 = num($ttl_c7) + 1;}
							elseif (num($r_school[20]) == 1){$ttl_c8 = num($ttl_c8) + 1;}
								
								
							
								
				?>                
                <tr>
                  <td><strong><?php echo e($no_urut) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[0])  ; ?></strong></td>
                  <td><strong><?php echo e($r_school[1]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[2])  ; ?></strong></td>
                  <td><strong><?php echo e($r_school[3]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[4]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[5]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[6]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[7]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[8]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[9]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[10]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[11]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[13]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[14]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[15]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[16]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[17]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[18]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[19]) ; ?></strong></td>
                  <td><strong><?php echo e($r_school[20]) ; ?></strong></td>
            </tr>
                <?php $no_urut = num($no_urut) + 1; 
															
}} ?>
                          <tr>
                  <td colspan="8" align="right"><strong>TOTAL</strong></td>
                  <td><strong><?php echo e($ttl_10) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_30) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_60) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_80) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_100) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_c1); ?></strong></td>
                  <td><strong><?php echo e($ttl_c2) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_c3) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_c4) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_c5) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_c6) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_c7) ; ?></strong></td>
                  <td><strong><?php echo e($ttl_c8) ; ?></strong></td>
                  </tr>
                  <tr>
                  <td colspan="8" align="right"><strong>GRAND TOTAL</strong></td>
                  <td colspan="5" align="center"><strong><?php echo e((num($ttl_10) + num($ttl_30) + num($ttl_60) + num($ttl_80) + num($ttl_100))) ; ?></strong></td>
                  <td colspan="8" align="center"><strong><?php echo e((num($ttl_c1) + num($ttl_c2) + num($ttl_c3) + num($ttl_c4) + num($ttl_c5) + num($ttl_c6) + num($ttl_c7) + num($ttl_c8))) ; ?></strong></td>
                  </tr>
          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
      <!-- accepted payments column --><!-- /.col --><!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
