<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$intake_start= in_val('ints', 'get');
$intake_end = in_val('inte', 'get');
$cn = in_val('cn', 'get');
$kc = in_val('kc', 'get');
$st = in_val('st', 'get');
$nminst= in_val('nminst', 'get');
$gs= in_val('gs', 'get');
if($nminst==''){$pilih_school = '';}
else
{$pilih_school = q_set($__p_pilih_school, " and dest_school = ? ", [(string) ($nminst)]);}
if($gs==''){$pilih_group = '';}
else
{$pilih_group = q_set($__p_pilih_group, " and  groupschool = ? ", [(string) ($gs)]);}
if ($cn == 'ALL' or $cn ==''){$pilih_country = '';}
else
{$pilih_country= q_set($__p_pilih_country, " and dest_country = ? ", [(string) ($cn)]);}
if ($st == 'oh'){$judul = "On Hand Student";}

elseif ($st == 'pr'){$judul = "PROBLEM";}
elseif ($st == 'ot'){$judul = "ON - OTHER STEP";}
elseif ($st == 'st1'){$judul = "STEP 1";}
elseif ($st == 'st2'){$judul = "STEP 2 - 3";}
elseif ($st == 'st4'){$judul = "STEP 4 - 5";}
elseif ($st == 'st6'){$judul = "STEP 6";}
elseif ($st == 'pdo'){$judul = "PDO";}
elseif ($st == 'prl'){$judul = "LEAVING PREDICTION";}
elseif ($st == 'l'){$judul = "LEAVING";}
elseif ($st == 'c'){$judul = "CANCEL";}



$kd_cbg_dipilih = in_val('kd_cbg_dipilih', 'get');

if ($kc == '--ALL--'){$kd_cbg_dipilih = 100;}
if ($kc == 'East Sby'){$kc = 1;}
if ($kc == 'West Sby'){$kc = 2;}
if ($kc == 'Denpasar'){$kc = 3;}
if ($kc == 'South Jkt'){$kc = 4;}
if ($kc == 'North Jkt'){$kc = 5;}
if ($kc == 'West Jkt'){$kc = 6;}
if ($kc == 'Bandung'){$kc = 7;}
if ($kc == 'Malang TBI'){$kc = 8;}
if ($kc == 'Bandung TBI'){$kc = 9;}
if ($kc == 'Bali TBI'){$kc = 10;}
if ($kc == 'National'){$kc = 100;}

if ($kc ==''){$cabang = '--ALL--';}
if (num($kc) ==1){$cabang = 'East Sby';}
if (num($kc) ==2){$cabang = 'West Sby';}
if (num($kc) ==3){$cabang = 'Denpasar';}
if (num($kc) ==4){$cabang = 'South Jkt';}
if (num($kc) ==5){$cabang = 'North Jkt';}
if (num($kc) ==6){$cabang = 'West Jkt';}
if (num($kc) ==7){$cabang = 'Bandung';}
if (num($kc) ==8){$cabang = 'Malang TBI';}
if (num($kc) ==9){$cabang = 'Bandung TBI';}
if (num($kc) ==10){$cabang = 'Bali TBI';}
if (num($kc) ==101){$cabang = 'East Area';}
if (num($kc) ==102){$cabang = 'West Area';}
if (num($kc) ==100){$cabang = 'National';}

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
 <?php   // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=""> 
   <section class="content">
        <div class="col-xs-12">
             <div class="box">
           <div class="box-body">
 
     <h1>Detail Student<br>
     </h1>
     <table width="453" border="0">
        <tbody>
          <tr>
		    <td width="148"><small>
            <label for="date5"> Intake Period</label>
			  </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
              <?php echo e($intake_start) ?>
            to 
            <?php echo e($intake_end) ?>
            </small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date3"> Center</label>
            </small></td>
            <td><small>
            <label for="date4">: <?php echo e($cabang) ?></label>
            </small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date6"> Institution</label>
            </small></td>
            <td><small>
              <label for="date7">:</label>
              <?php echo  e($nminst) ?> - <?php echo e($cn) ?></small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date8">Title</label>
            </small></td>
            <td><small>
              <label for="date9">:</label>
              <?php echo e($judul) ?></small></td>
          </tr>
        </tbody>
				</table>
				</div>
				</div>
				</div>
   <!-- Main content -->
   <?php
$awal_y0 = "2018-07-01";
$awal_y0 = strtotime($awal_y0);
$akhir_y0 = "2019-06-30";
$akhir_y0 = strtotime($akhir_y0);
$awal_y1 = "2017-07-01";
$awal_y1 = strtotime($awal_y1);
$akhir_y1 = "2018-06-30";
$akhir_y1 = strtotime($akhir_y1);
$awal_y2 = "2016-07-01";
$awal_y2 = strtotime($awal_y2);
$akhir_y2 = "2017-06-30";
$akhir_y2 = strtotime($akhir_y2);
$awal_y3 = "2015-07-01";
$awal_y3 = strtotime($awal_y3);
$akhir_y3 = "2016-06-30";
$akhir_y3 = strtotime($akhir_y3);
$awal_y4 = "2014-07-01";
$awal_y4 = strtotime($awal_y4);
$akhir_y4 = "2015-06-30";
$akhir_y4 = strtotime($akhir_y4);

$total_tahun_0_tw ="0";
$total_tahun_1_tw ="0";
$total_tahun_2_tw ="0";
$total_tahun_3_tw ="0";
$total_tahun_4_tw ="0";

$total_p_tw = "0";
$total_np_tw = "0";

$total_h_tw = "0";
$total_nh_tw = "0";

$total_btg_1_tw ="0";
$total_btg_2_tw ="0";
$total_btg_3_tw ="0";
$total_btg_4_tw ="0";
$total_btg_5_tw ="0";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$no_urut_week_mentah = "1";
if ($st=='')	
	{$cari = q_set($__p_cari, " and\r
((final_status = 'L' and tgl_intake between ? and ? )\r
or (final_status = 'ON' and tgl_intake between ? and ? )\r
or (final_status = 'PR' and tgl_intake between ? and ? )\r
or (final_status = 'C' and tgl_intake between ? and ? )\r
or (final_status = 'PDO' and tgl_intake between ? and ? )\r
or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
) group by kd_biodata order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start)]);}	
elseif ($st=='oh')	
	{$cari = q_set($__p_cari, " and\r
((final_status = 'ON' and tgl_intake between ? and ? )\r
or (final_status = 'PR' and tgl_intake between ? and ? )\r
or (final_status = 'PDO' and tgl_intake between ? and ? )\r
or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
) group by kd_biodata  order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start), (string) ($intake_end), (string) ($intake_start)]);}
elseif ($st=='pr')	
	{$cari = q_set($__p_cari, " and\r
(\r
 (final_status = 'PR' and tgl_intake between ? and ? )\r
or (final_status <> 'L' and final_status <> 'C' and tgl_intake < ? )\r
) group by kd_biodata order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end), (string) ($intake_start)]);}	
elseif ($st=='ot')	
	{$cari = q_set($__p_cari, " and\r
final_status = 'ON' and (step like '15%' or step ='') and tgl_intake between ? and ? group by kd_biodata  order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end)]);}
elseif ($st=='st1')	
	{$cari = q_set($__p_cari, " and\r
final_status = 'ON' and step like '1:%' and tgl_intake between ? and ? group by kd_biodata order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end)]);}
elseif ($st=='st2')	
	{$cari = q_set($__p_cari, " and\r
final_status = 'ON' and (step like '2:%' or step like '3:%')  and tgl_intake between ? and ? group by kd_biodata order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end)]);}	
elseif ($st=='st4')	
	{$cari = q_set($__p_cari, " and\r
(final_status = 'ON' and (step like '4%' or step like '5%'))  and tgl_intake between ? and ?  group by kd_biodata order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end)]);}
elseif ($st=='st6')	
	{$cari = q_set($__p_cari, " and\r
(final_status = 'ON' and (step like '6%' or step like '7%' or step like '8%' or step like '9%' or step like '10%' or step like '11%' or step like '12%'))  and tgl_intake between ? and ? group by kd_biodata  order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end)]);}	
elseif ($st=='pdo')	
	{$cari = q_set($__p_cari, " and\r
(final_status = 'PDO'  and tgl_intake between ? and ? ) group by kd_biodata   order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end)]);}
elseif ($st=='c')	
	{$cari = q_set($__p_cari, " and\r
(final_status = 'C'  and tgl_intake between ? and ? ) group by kd_biodata   order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end)]);}	
elseif ($st=='l')	
	{$cari = q_set($__p_cari, " and\r
(final_status = 'L'  and tgl_intake between ? and ? )  order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end)]);}
elseif ($st=='prl')	
	{$cari = q_set($__p_cari, " and\r
(final_status = 'ON' and step not like '15:%'  and tgl_intake between ? and ? ) group by kd_biodata  order by tgl_intake ", [(string) ($intake_start), (string) ($intake_end)]);}					
if ($cn !='')
	{if ($kc == '100')
	{
$query_twi = q_set($__p_query_twi, "SELECT  kd_biodata, nama,enroll_date, DATE_FORMAT(a.enroll_date,'%d %b %y'),  dest_school, dest_program, p_np,h_nh,ar, mp_ap, grade_leaving,(case when final_status = 'ON' then 1 else 0 end) as pr_ON, (case when final_status = 'M' then 1 else 0 end) as M,(case when final_status = 'PS' then 1 else 0 end) as PS, (case when final_status = 'PDO' then 1 else 0 end) as PDO, (case when final_status like 'PR%' then 1 else 0 end) as PR,(case when final_status = 'L' then 1 else 0 end) as L,(case when final_status like 'C%' then 1 else 0 end) as C,step, a.remark,DATE_FORMAT(a.next_update,'%d %b %y'),DATE_FORMAT(a. tgl_intake,'%d %b %y'),adm_pic, sc_name, tf_cur, tf_mount, \r
tf_period,mid(dest_country,1,3), remark_problem, remark_solution,dest_country,tf_full_program FROM adm_stu_progress a   left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country where aktif = 1 " . $pilih_school . " " . $pilih_country . " " . $pilih_group . " " . $cari . " ", [...($__p_pilih_school ?? []), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_cari ?? [])]);
	}
elseif ($kc == '101')
	{
$query_twi = q_set($__p_query_twi, "SELECT  kd_biodata, nama,enroll_date, DATE_FORMAT(a.enroll_date,'%d %b %y'),  dest_school, dest_program, p_np,h_nh,ar, mp_ap, grade_leaving,(case when final_status = 'ON' then 1 else 0 end) as pr_ON, (case when final_status = 'M' then 1 else 0 end) as M,(case when final_status = 'PS' then 1 else 0 end) as PS, (case when final_status = 'PDO' then 1 else 0 end) as PDO, (case when final_status like 'PR%' then 1 else 0 end) as PR,(case when final_status = 'L' then 1 else 0 end) as L,(case when final_status like 'C%' then 1 else 0 end) as C,step, a.remark,DATE_FORMAT(a.next_update,'%d %b %y'),DATE_FORMAT(a. tgl_intake,'%d %b %y'),adm_pic, sc_name, tf_cur, tf_mount, \r
tf_period,mid(dest_country,1,3), remark_problem, remark_solution,dest_country,tf_full_program FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country  where (kd_branch = '1' or  kd_branch = '2' or  kd_branch = '3' or  kd_branch = '8')   and  aktif = 1  " . $pilih_school . " " . $pilih_country . " " . $pilih_group . " " . $cari . " ", [...($__p_pilih_school ?? []), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_cari ?? [])]);
	}				  
elseif ($kc == '102')
	{
$query_twi = q_set($__p_query_twi, "SELECT  kd_biodata, nama,enroll_date, DATE_FORMAT(a.enroll_date,'%d %b %y'),  dest_school, dest_program, p_np,h_nh,ar, mp_ap, grade_leaving,(case when final_status = 'ON' then 1 else 0 end) as pr_ON, (case when final_status = 'M' then 1 else 0 end) as M,(case when final_status = 'PS' then 1 else 0 end) as PS, (case when final_status = 'PDO' then 1 else 0 end) as PDO, (case when final_status like 'PR%' then 1 else 0 end) as PR,(case when final_status = 'L' then 1 else 0 end) as L,(case when final_status like 'C%' then 1 else 0 end) as C,step, a.remark,DATE_FORMAT(a.next_update,'%d %b %y'),DATE_FORMAT(a. tgl_intake,'%d %b %y'),adm_pic, sc_name, tf_cur, tf_mount, \r
tf_period,mid(dest_country,1,3), remark_problem, remark_solution,dest_country,tf_full_program\r
\t \t FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country  where " . $pilih_country . "(kd_branch = '4' or  kd_branch = '5' or  kd_branch = '6' or  kd_branch = '7')   and  aktif = 1  " . $pilih_school . " " . $pilih_country . " " . $pilih_group . " " . $cari . " ", [...($__p_pilih_country ?? []), ...($__p_pilih_school ?? []), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_cari ?? [])]);
	}				  		
else
	{
$query_twi = q_set($__p_query_twi, "SELECT  kd_biodata, nama,enroll_date, DATE_FORMAT(a.enroll_date,'%d %b %y'),  dest_school, dest_program, p_np,h_nh,ar, mp_ap, grade_leaving,(case when final_status = 'ON' then 1 else 0 end) as pr_ON, (case when final_status = 'M' then 1 else 0 end) as M,(case when final_status = 'PS' then 1 else 0 end) as PS, (case when final_status = 'PDO' then 1 else 0 end) as PDO, (case when final_status like 'PR%' then 1 else 0 end) as PR,(case when final_status = 'L' then 1 else 0 end) as L,(case when final_status like 'C%' then 1 else 0 end) as C,step, a.remark,DATE_FORMAT(a.next_update,'%d %b %y'),DATE_FORMAT(a. tgl_intake,'%d %b %y'),adm_pic, sc_name, tf_cur, tf_mount, \r
tf_period,mid(dest_country,1,3), remark_problem, remark_solution,dest_country,tf_full_program\r
\t \t FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country  where  kd_branch = ?   and aktif = 1  " . $pilih_school . " " . $pilih_country . " " . $pilih_group . "  " . $cari, [(string) ($kc), ...($__p_pilih_school ?? []), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_cari ?? [])]);
	}}
else
	{if ($kc == '100')
	{
$query_twi = q_set($__p_query_twi, "SELECT  kd_biodata, nama,enroll_date, DATE_FORMAT(a.enroll_date,'%d %b %y'),  dest_school, dest_program, p_np,h_nh,ar, mp_ap, grade_leaving,(case when final_status = 'ON' then 1 else 0 end) as pr_ON, (case when final_status = 'M' then 1 else 0 end) as M,(case when final_status = 'PS' then 1 else 0 end) as PS, (case when final_status = 'PDO' then 1 else 0 end) as PDO, (case when final_status like 'PR%' then 1 else 0 end) as PR,(case when final_status = 'L' then 1 else 0 end) as L,(case when final_status like 'C%' then 1 else 0 end) as C,step, a.remark,DATE_FORMAT(a.next_update,'%d %b %y'),DATE_FORMAT(a. tgl_intake,'%d %b %y'),adm_pic, sc_name, tf_cur, tf_mount, \r
tf_period,mid(dest_country,1,3), remark_problem, remark_solution,dest_country,tf_full_program FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country  where aktif = 1  " . $pilih_school . " " . $pilih_country . " " . $pilih_group . " " . $cari . " ", [...($__p_pilih_school ?? []), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_cari ?? [])]);
	}
elseif ($kc == '101')
	{
$query_twi = q_set($__p_query_twi, "SELECT  kd_biodata, nama,enroll_date, DATE_FORMAT(a.enroll_date,'%d %b %y'),  dest_school, dest_program, p_np,h_nh,ar, mp_ap, grade_leaving,(case when final_status = 'ON' then 1 else 0 end) as pr_ON, (case when final_status = 'M' then 1 else 0 end) as M,(case when final_status = 'PS' then 1 else 0 end) as PS, (case when final_status = 'PDO' then 1 else 0 end) as PDO, (case when final_status like 'PR%' then 1 else 0 end) as PR,(case when final_status = 'L' then 1 else 0 end) as L,(case when final_status like 'C%' then 1 else 0 end) as C,step, a.remark,DATE_FORMAT(a.next_update,'%d %b %y'),DATE_FORMAT(a. tgl_intake,'%d %b %y'),adm_pic, sc_name, tf_cur, tf_mount, \r
tf_period,mid(dest_country,1,3), remark_problem, remark_solution,dest_country,tf_full_program FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country  where  (kd_branch = '1' or  kd_branch = '2' or  kd_branch = '3' or  kd_branch = '8')   and  aktif = 1  " . $pilih_school . " " . $pilih_country . " " . $pilih_group . "  " . $cari . " ", [...($__p_pilih_school ?? []), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_cari ?? [])]);
	}				  
elseif ($kc == '102')
	{
$query_twi = q_set($__p_query_twi, "SELECT  kd_biodata, nama,enroll_date, DATE_FORMAT(a.enroll_date,'%d %b %y'),  dest_school, dest_program, p_np,h_nh,ar, mp_ap, grade_leaving,(case when final_status = 'ON' then 1 else 0 end) as pr_ON, (case when final_status = 'M' then 1 else 0 end) as M,(case when final_status = 'PS' then 1 else 0 end) as PS, (case when final_status = 'PDO' then 1 else 0 end) as PDO, (case when final_status like 'PR%' then 1 else 0 end) as PR,(case when final_status = 'L' then 1 else 0 end) as L,(case when final_status like 'C%' then 1 else 0 end) as C,step, a.remark,DATE_FORMAT(a.next_update,'%d %b %y'),DATE_FORMAT(a. tgl_intake,'%d %b %y'),adm_pic, sc_name, tf_cur, tf_mount, \r
tf_period,mid(dest_country,1,3), remark_problem, remark_solution,dest_country,tf_full_program\r
\t \t FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country  where  (kd_branch = '4' or  kd_branch = '5' or  kd_branch = '6' or  kd_branch = '7')   and  aktif = 1  " . $pilih_school . " " . $pilih_country . " " . $pilih_group . " " . $cari . " ", [...($__p_pilih_school ?? []), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_cari ?? [])]);
	}				  		
else
	{
$query_twi = q_set($__p_query_twi, "SELECT  kd_biodata, nama,enroll_date, DATE_FORMAT(a.enroll_date,'%d %b %y'),  dest_school, dest_program, p_np,h_nh,ar, mp_ap, grade_leaving,(case when final_status = 'ON' then 1 else 0 end) as pr_ON, (case when final_status = 'M' then 1 else 0 end) as M,(case when final_status = 'PS' then 1 else 0 end) as PS, (case when final_status = 'PDO' then 1 else 0 end) as PDO, (case when final_status like 'PR%' then 1 else 0 end) as PR,(case when final_status = 'L' then 1 else 0 end) as L,(case when final_status like 'C%' then 1 else 0 end) as C,step, a.remark,DATE_FORMAT(a.next_update,'%d %b %y'),DATE_FORMAT(a. tgl_intake,'%d %b %y'),adm_pic, sc_name, tf_cur, tf_mount, \r
tf_period,mid(dest_country,1,3), remark_problem, remark_solution,dest_country,tf_full_program\r
\t \t FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country  where   kd_branch = ?   and aktif = 1  " . $pilih_school . " " . $pilih_country . " " . $pilih_group . "  " . $cari . "  ", [(string) ($kc), ...($__p_pilih_school ?? []), ...($__p_pilih_country ?? []), ...($__p_pilih_group ?? []), ...($__p_cari ?? [])]);
	}}
				
$result_twi=db_query_or_die("Wah error nih! 12", $query_twi, $__p_query_twi ?? []);
$no_urut_week ="1";

 		?>
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example1"> 
<thead>
   <tr>
     <td width=18 rowspan="3" align=center >No</td>
     <td width=132 rowspan="3" align=center >Nama</td>
     <td width=90 rowspan="3" align=center >Enroll Date </td>
     <td width="30" rowspan="3" align=center >Sales Year</td>
     <td height="14" colspan="5" align=center >Destination</td>
     <td height="14" colspan="6" align=center >Admission Status</td>
     <td height="14" colspan="2" align=center >Admission Progress Log</td>
     <td width="55" rowspan="3" align=center >Intake Date </td>
     <td rowspan="2" align=center >AC</td>
     <td width="60" rowspan="3" align=center >Tuition Info </td>
   </tr>
   <tr>
     <td rowspan="2" align=center >Institution</td>
     <td rowspan="2" align=center >P<br>
       /NP<br>
       H<br>
       /AD<br>
       /STEM<br>
       /NON</td>
     <td width="41" rowspan="2" align=center >Normal<br>
       Refer<br>
       Accept</td>
     <td width="57" rowspan="2" align=center >Main<br>
       /Add<br>
     /Language</td>
     <td width="22" rowspan="2" align=center >Star</td>
     <td height="14" colspan="2" align=center >ON Progress</td>
     <td colspan="2" align=center >PR</td>
     <td width="41" rowspan="2" align=center >Leaving</td>
     <td width="35" rowspan="2" align=center >Cancel</td>
     <td width="28" rowspan="2" align=center > Step </td>
     <td rowspan="2" align=center >Next Follow<br>
       Up </td>
     </tr>
   <tr>
     <td height="14" align=center >ON</td>
     <td align=center >PDO</td>
     <td width="23" align=center >&nbsp;</td>
     <td width="51" align=center >Problem<br>
       /Solution</td>
     <td align=center >SC</td>
     </tr></thead><tbody>
   <?php if ($result_twi) 
	{ 
	
	while ($r_dtli = db_fetch($result_twi))
		{


		$tahun_0 ="";
		$tahun_1 ="";
		$tahun_2 ="";
		$tahun_3 ="";
		$tahun_4 ="";

		$enroll = $r_dtli[2];
		$enroll_hr = $r_dtli[3];
		$enroll_bl = $r_dtli[4];
		$enroll_th = $r_dtli[5];

		$enroll_convert= strtotime($r_dtli[2]);
		$p_np = $r_dtli[9];
		$h_nh= $r_dtli[10];
		if ($enroll_convert >= $awal_y0)
			{
			if($enroll_convert <= $akhir_y0)
				{
				$kode_thn = "C";
				$tahun_0 ="1";
				$total_tahun_0_tw = num($total_tahun_0_tw) + 1;
				}
			}
		elseif ($enroll_convert >= $awal_y1)
			{
			if($enroll_convert <= $akhir_y1)
				{
				$kode_thn = "-1";				
				$tahun_1 ="1";
				$total_tahun_1_tw = num($total_tahun_1_tw) + 1;
				}			
			}
		elseif ($enroll_convert >= $awal_y2)
			{
			if($enroll_convert <= $akhir_y2)
				{
				$kode_thn = "-2";
				$tahun_2 ="1";
				$total_tahun_2_tw = num($total_tahun_2_tw) + 1;
				}			
			}
		elseif ($enroll_convert >= $awal_y3)
			{
			if($enroll_convert <= $akhir_y3)
				{
				$kode_thn = "-3";				
				$tahun_3 ="1";
				$total_tahun_3_tw = num($total_tahun_3_tw) + 1;
				}			
			}
		elseif ($enroll_convert >= $awal_y4)
			{
			if($enroll_convert <= $akhir_y4)
				{
				$kode_thn = "-4";
				$tahun_4 ="1";
				$total_tahun_4_tw = num($total_tahun_4_tw) + 1;
				}			
			}

		if (substr($r_dtli[11],0,2) == 'ON')
			{
			$btg_1 = "1";
			$btg_2 = "";
			$btg_3 = "";
			$btg_4 = "";
			$btg_5 = "";
			$total_btg_1_tw = num($total_btg_1_tw) + 1;		
			}
		elseif (substr($r_dtli[11],0,2) == 'TW')
			{
			$btg_1 = "";
			$btg_2 = "1";
			$btg_3 = "";
			$btg_4 = "";
			$btg_5 = "";
			$total_btg_2_tw = num($total_btg_2_tw) + 1;
			}

		elseif (substr($r_dtli[11],0,2) == 'TH')
			{
			$btg_1 = "";
			$btg_2 = "";
			$btg_3 = "1";
			$btg_4 = "";
			$btg_5 = "";
			$total_btg_3_tw = num($total_btg_3_tw) + 1;

			}

		elseif (substr($r_dtli[11],0,2) == 'FO')
			{
			$btg_1 = "";
			$btg_2 = "";
			$btg_3 = "";
			$btg_4 = "1";
			$btg_5 = "";
			$total_btg_4_tw = num($total_btg_4_tw) + 1;
			
			}

		elseif (substr($r_dtli[11],0,2) == 'FI')
			{
			$btg_1 = "";
			$btg_2 = "";
			$btg_3 = "";
			$btg_4 = "";
			$btg_5 = "1";
			$total_btg_5_tw = num($total_btg_5_tw) + 1;
			}
		else
					{
			$btg_1 = "1";
			$btg_2 = "";
			$btg_3 = "";
			$btg_4 = "";
			$btg_5 = "";
			$total_btg_1_tw = num($total_btg_1_tw) + 1;
			}
				  ?>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($no_urut_week) ?></span></td>
     <td align=left  class="style49"><span class="stylebulan"><a href="stuadmprogress.php?kdb=<?php echo e(u($r_dtli[0])) ?>&st=1&asal=1" target="_blank"><?php echo e($r_dtli[1]) ?></a></span></td>
     <td align=center  class="style49"><?php echo e($r_dtli[2]) ?></td>
     <td  width="30"  align=center  class="style49"><span class="stylebulan"><?php echo e($kode_thn)  ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><span class="style87"><?php echo e($r_dtli[30]) ?> - <?php echo e($r_dtli[4]) ?><br>
       <?php echo e($r_dtli[5]) ?><br>
     </span></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[6]) ?> - <?php echo e($r_dtli[7]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[8]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[9]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[10]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[11]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[14]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[15]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[28]) ?><br>
       /<?php echo e($r_dtli[29]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[16]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[17]) ?></span></td>
     <td align=left  class="style49"><span class="stylebulan"><?php echo e($r_dtli[18]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[20]) ?></span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[21]) ?></span></td>
     <td align=left  class="style49"><span class="stylebulan"><?php echo e($r_dtli[22]) ?><br>
       <?php echo e($r_dtli[23]) ?><br>
     </span></td>
     <td align=center  class="style49"><span class="stylebulan"><?php echo e($r_dtli[31]) ?></span><br></td>
   </tr>
      <?php $no_urut_week = num($no_urut_week) +1;}
 		
	}
?>
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