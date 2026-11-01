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
 <form method=get action=institution_dtl_prblmbystu.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Problem  STUDENT<br>
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
          <tr>
            <td height="24"><small>
              <label for="date6"> Country</label>
            </small></td>
            <td><small>
              <label for="date7">:</label>
              <select name="dest_country"  onChange="this.form.submit()"   class="style33" id="kd_cbg_dipilih">
              <option>ALL</option>
               <?php
								$query_country = q_set($__p_query_country, "SELECT distinct dest_country FROM adm_stu_progress where aktif = '1' and tgl_intake between ? and ? ", [(string) ($intake_start), (string) ($intake_end)]);
								$resource_country = db_query_or_die('errro_7', $query_country, $__p_query_country ?? []);
								while ($row_country=  db_fetch($resource_country, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_country[0]).'">'.e($row_country[0]).'</option>';
							  		}      ?>
                <option selected="selected"><?php echo e($dest_country) ?></option>
              </select>
            </small></td>
          </tr>
          <tr>
            <td height="24"><small>
              <label for="date8"> Group School</label>
            </small></td>
            <td><small>
              <label for="date9">:</label>
              <select name="group_school"  onChange="this.form.submit()"   class="style33" id="group_school">
                <option>ALL</option>
                <?php
								if ($kd_cbg_dipilih =='101'){
					$query_school = q_set($__p_query_school, "SELECT a.groupschool FROM tb_master_partner left join adm_stu_progress b on a.school = b.dest_school and a.country = b.dest_country  where dest_school <>'' and a.groupschool <>'' and (kd_branch = '1' or kd_branch = '2'or kd_branch = '3'or kd_branch = '8') and aktif = 1 and\r
((final_status = 'PR' and tgl_intake between ? and ? )\r
or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? ) \r
) " . $pilih_country . " group by dest_country", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), ...($__p_pilih_country ?? [])]);
					}
elseif ($kd_cbg_dipilih =='100'){
					$query_school_group = q_set($__p_query_school_group, "SELECT a.groupschool FROM tb_master_partner a left join adm_stu_progress b on a.school = b.dest_school where b.aktif = '1' and ((final_status = 'PR' and tgl_intake between ? and ? )\r
or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? ) \r
) " . $pilih_country . "  group by a.groupschool", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), ...($__p_pilih_country ?? [])]);
					}
else{
					$query_school_group = q_set($__p_query_school_group, "SELECT a.groupschool FROM tb_master_partner a left join adm_stu_progress b on a.school = b.dest_school and a.country = b.dest_country  where  dest_school <>'' and a.groupschool <>''  and  kd_branch = ? and aktif = 1 and\r
((final_status = 'ON' and tgl_intake between ? and ? )\r
or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
) " . $pilih_country . "  group by dest_country", [(string) ($kd_cbg_dipilih), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), ...($__p_pilih_country ?? [])]);}
						$resource_school_group = db_query_or_die('errro_7', $query_school_group, $__p_query_school_group ?? []);
						while ($row_group=  db_fetch($resource_school_group, PDO::FETCH_NUM))
							{
							echo '<option value="'.e($row_group[0]).'">'.e($row_group[0]).'</option>';
							}      ?>
                <option selected="selected"><?php echo e($group_school) ?></option>
              </select>
            </small></td>
          </tr>
        </tbody>
      </table>
                 <?php 
					if ($kd_cbg_dipilih =='101'){
					$query_school = q_set($__p_query_school, "SELECT nama, enroll_date, groupschool, dest_school,dest_country, program_clasifie,date_format(tgl_intake,'%d %b %y'),a.step,\r
a.remark_problem,\r
a.remark_solution,\r
a.update_date,\r
a.next_update,\r
a.final_status,\r
(CASE when kd_branch = '1' then '1' end) as c1,\r
(CASE when kd_branch = '2' then '1' end) as c2,\r
(CASE when kd_branch = '3' then '1' end) as c3,\r
(CASE when kd_branch = '4' then '1' end) as c4,\r
(CASE when kd_branch = '5' then '1' end) as c5,\r
(CASE when kd_branch = '6' then '1' end) as c6,\r
(CASE when kd_branch = '7' then '1' end) as c7,\r
(CASE when kd_branch = '8' then '1' end) as c8,a.kd_biodata FROM adm_stu_progress  a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country where  dest_school <>'' and  aktif = 1 and\r
( (final_status = 'PR' and tgl_intake between ? and ? ) or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
) " . $pilih_country . " " . $pilih_group . " " . $pilih_cabang . " group by kd_biodata", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_pilih_cabang ?? [])]);

					}
elseif ($kd_cbg_dipilih =='100'){
					$query_school = q_set($__p_query_school, "SELECT nama, enroll_date, groupschool, dest_school,dest_country, program_clasifie,date_format(tgl_intake,'%d %b %y'),a.step,\r
a.remark_problem,\r
a.remark_solution,\r
a.update_date,\r
a.next_update,\r
a.final_status,\r
(CASE when kd_branch = '1' then '1' end) as c1,\r
(CASE when kd_branch = '2' then '1' end) as c2,\r
(CASE when kd_branch = '3' then '1' end) as c3,\r
(CASE when kd_branch = '4' then '1' end) as c4,\r
(CASE when kd_branch = '5' then '1' end) as c5,\r
(CASE when kd_branch = '6' then '1' end) as c6,\r
(CASE when kd_branch = '7' then '1' end) as c7,\r
(CASE when kd_branch = '8' then '1' end) as c8,a.kd_biodata\r
FROM adm_stu_progress  a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country where  dest_school <>'' and aktif = 1 and\r
( (final_status = 'PR' and tgl_intake between ? and ? ) or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
)  " . $pilih_country . " " . $pilih_group . " " . $pilih_cabang . " group by kd_biodata", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_pilih_cabang ?? [])]);
					}
else{
$query_school = q_set($__p_query_school, "SELECT nama, enroll_date, groupschool, dest_school,dest_country, program_clasifie,date_format(tgl_intake,'%d %b %y'),a.step,\r
a.remark_problem,\r
a.remark_solution,\r
a.update_date,\r
a.next_update,\r
a.final_status,\r
(CASE when kd_branch = '1' then '1' end) as c1,\r
(CASE when kd_branch = '2' then '1' end) as c2,\r
(CASE when kd_branch = '3' then '1' end) as c3,\r
(CASE when kd_branch = '4' then '1' end) as c4,\r
(CASE when kd_branch = '5' then '1' end) as c5,\r
(CASE when kd_branch = '6' then '1' end) as c6,\r
(CASE when kd_branch = '7' then '1' end) as c7,\r
(CASE when kd_branch = '8' then '1' end) as c8,a.kd_biodata\r
FROM adm_stu_progress  a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country where  dest_school <>'' and aktif = 1 and\r
( (final_status = 'PR' and tgl_intake between ? and ? ) or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
) " . $pilih_country . " " . $pilih_group . "  " . $pilih_cabang . " group by kd_biodata", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_pilih_cabang ?? [])]);
					}
				  $urutan  = q_set($__p_urutan, " order by a.update_date desc"); 
					$no_urut = 1;
					$query_school = q_set($__p_query_school, $query_school . " " . $urutan, [...($__p_query_school ?? []), ...($__p_urutan ?? [])]);
					$result_school=db_query_or_die("Wah error nih15", $query_school, $__p_query_school ?? []);
				  	$num_rows_school = db_num_rows($result_school);?>     
                 <table width="200" border="0">
                   <tbody>
                     <tr>
                       <td><br>
Result : <?php echo e($num_rows_school) ?> Student(s)<br>
<a href="rpt_instprblbystu.php?intake_start=<?php echo e(u($intake_start)) ?>&intake_end=<?php echo e(u($intake_end)) ?>&kd_cbg_dipilih=<?php echo e(u($kd_cbg_dipilih)) ?>&dest_country=<?php echo e(u($dest_country)) ?>&group_school=<?php echo e(u($group_school)) ?>" target="_blank">Print</a>
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
              <table id="examples1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="4%">No</th>
                  <th width="6%">Student Name</th>
                  <th width="8%">Enroll Date</th>
                  <th width="4%">Group</th>
                  <th>Institution</th>
                  <th width="5%">Program</th>
                  <th width="10%">Intake</th>
                  <th width="4%">Step </th>
                  <th width="3%">Reason<br></th>
                  <th width="3%">Solution<br></th>
                  <th width="3%">Last Update<br></th>
                  <th width="4%">Next Update<br></th>
                  <th width="3%" bgcolor="#A44F50">&nbsp;</th>
                  <th width="3%">East Sby</th>
                  <th width="4%">West Sby</th>
                  <th width="3%">Bali</th>
                  <th width="4%">South Jkt</th>
                  <th width="4%">North Jkt</th>
                  <th width="4%">West Jkt</th>
                  <th width="6%">Bandung</th>
                  <th width="5%">Malang</th>
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
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><a href="stuadmprogress.php?kdb=<?php echo e(u($r_school[21])) ?>&st=1&asal=2" target="_blank"><?php echo e($r_school[0])  ; ?></a></td>
                  <td><?php echo e($r_school[1]) ; ?></td>
                  <td><?php echo e($r_school[2])  ; ?></td>
                  <td><?php echo e($r_school[4]) ; ?><br>                    <?php echo e($r_school[3]) ; ?></td>
                  <td><?php echo e($r_school[5]) ; ?></td>
                  <td><?php echo e($r_school[6]) ; ?></td>
                  <td><?php echo e($r_school[12]) ; ?> - <?php echo e($r_school[7]) ; ?></td>
                  <td><?php echo e($r_school[8]) ; ?></td>
                  <td><?php echo e($r_school[9]) ; ?></td>
                  <td><?php echo e($r_school[10]) ; ?></td>
                  <td><?php echo e($r_school[11]) ; ?></td>
                  <td bgcolor="#A44F50">&nbsp;</td>
                  <td><?php echo e($r_school[13]) ; ?></td>
                  <td><?php echo e($r_school[14]) ; ?></td>
                  <td><?php echo e($r_school[15]) ; ?></td>
                  <td><?php echo e($r_school[16]) ; ?></td>
                  <td><?php echo e($r_school[17]) ; ?></td>
                  <td><?php echo e($r_school[18]) ; ?></td>
                  <td><?php echo e($r_school[19]) ; ?></td>
                  <td><?php echo e($r_school[20]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; 
															
}} ?>
                          <tr>
                  <td colspan="12" align="right"><strong>TOTAL</strong></td>
                  <td bgcolor="#A44F50">&nbsp;</td>
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
                  <td colspan="12" align="right"><strong>GRAND TOTAL</strong></td>
                  <td bgcolor="#A44F50">&nbsp;</td>
                  <td colspan="8" align="center"><strong><?php echo e((num($ttl_c1) + num($ttl_c2) + num($ttl_c3) + num($ttl_c4) + num($ttl_c5) + num($ttl_c6) + num($ttl_c7) + num($ttl_c8))) ; ?></strong></td>
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
