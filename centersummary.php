<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";


$thn_period = in_val('thn_period', 'get');
$mulai_period = "$thn_period-01-01";
$selesai_period = "$thn_period-12-31";
$kd_cabang = in_val('kd_cbg', 'get');

$kode_cabang = in_val('kode_cabang', 'get');

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
if ($kd_cabang == '--ALL--'){$kd_cabang = 0;}
if ($kd_cabang == 'East Sby'){$kd_cabang = 1;}
if ($kd_cabang == 'West Sby'){$kd_cabang = 2;}
if ($kd_cabang == 'Denpasar'){$kd_cabang = 3;}
if ($kd_cabang == 'South Jkt'){$kd_cabang = 4;}
if ($kd_cabang == 'North Jkt'){$kd_cabang = 5;}
if ($kd_cabang == 'West Jkt'){$kd_cabang = 6;}
if ($kd_cabang == 'Bandung'){$kd_cabang = 7;}
if ($kd_cabang == 'Malang TBI'){$kd_cabang = 8;}
if ($kd_cabang == 'Bandung TBI'){$kd_cabang = 9;}
if ($kd_cabang == 'Bali TBI'){$kd_cabang = 10;}

if (num($kode_cabang) ==0){$cabang = '--ALL--';}
if ($kode_cabang ==''){$cabang = '--ALL--';}


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
 <?php   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=centersummary.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Center VOS Achievement
        <br>
      </h1>
                       <div class="box">
            <!-- /.box-header -->
					 <div class="box-body">
			           <div class="col-xs-3">
					         Year Period:
						       <small>
						       <select name="thn_period"  onChange="this.form.submit()"   class="style33" id="thn_period">
						         <option value="2021">2021</option>								   
						         <option value="2020">2020</option>								   
						         <option value="2019">2019</option>
						         <option value="2018">2018</option>
						         <option value="2017">2017</option>
						         <option value="2016">2016</option>
						         <option value="2015">2015</option>
						         <option value="2014">2014</option>
						         <option value="2013">2013</option>
						         <option value="2012">2012</option>
						         <option selected="<?php echo e($thn_period)  ?>"><?php echo e($thn_period)  ?></option>
					           </select>
				         </small></div>
						 					         <div class="col-xs-3"> Center: <small>
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
						 					             <option selected="<?php echo e($kode_cabang) ?>"><?php echo e($cabang) ?></option>
					 					             </select>
						 					         </small></div>
					 </div></div>
                 <?php 
				
										
							
					if ($kode_cabang != '0' and  $kode_cabang != '')
					{
					$filter_cabang_enroll = q_set($__p_filter_cabang_enroll, " and kd_cabang = ? ", [(string) ($kode_cabang)]); 
					$filter_cabang = q_set($__p_filter_cabang, " and kd_branch = ? ", [(string) ($kode_cabang)]); 
					$filter_cabang_enroll_source = q_set($__p_filter_cabang_enroll_source, " and kd_cabang = ? and kd_branch = ? ", [(string) ($kode_cabang), (string) ($kode_cabang)]); 
						
				  	}
				  else	
					{
					$filter_cabang_enroll = q_set($__p_filter_cabang_enroll, " "); 
					$filter_cabang = q_set($__p_filter_cabang, " "); 
					$filter_cabang_enroll_source= q_set($__p_filter_cabang_enroll_source, " ");

					}
$query_target = q_set($__p_query_target, "SELECT kd_target,jan, feb, mar, apr, mei, jun, jul, aug, sep, oct, nop, des FROM ves_data.target_new where kd_branch = ? and tahun = ? ", [(string) ($kode_cabang), (string) ($thn_period)]);
										 
$query_enroll_by_year = q_set($__p_query_enroll_by_year, "SELECT date_format(a.enroll_date,'%Y'),\r
sum(case when date_format(a.enroll_date,'%m') = 1 then 1 else 0 end) as jan,\r
sum(case when date_format(a.enroll_date,'%m') = 2 then 1 else 0 end) as feb,\r
sum(case when date_format(a.enroll_date,'%m') = 3 then 1 else 0 end) as mar,\r
sum(case when date_format(a.enroll_date,'%m') = 4 then 1 else 0 end) as apr,\r
sum(case when date_format(a.enroll_date,'%m') = 5 then 1 else 0 end) as mei,\r
sum(case when date_format(a.enroll_date,'%m') = 6 then 1 else 0 end) as jun,\r
sum(case when date_format(a.enroll_date,'%m') = 7 then 1 else 0 end) as jul,\r
sum(case when date_format(a.enroll_date,'%m') = 8 then 1 else 0 end) as aug,\r
sum(case when date_format(a.enroll_date,'%m') = 9 then 1 else 0 end) as sep,\r
sum(case when date_format(a.enroll_date,'%m') = 10 then 1 else 0 end) as okt,\r
sum(case when date_format(a.enroll_date,'%m') = 11 then 1 else 0 end) as nov,\r
sum(case when date_format(a.enroll_date,'%m') = 12 then 1 else 0 end) as des\r
 FROM tb_sales_report a where a.prioritas = '1' and a.enroll_date between '2012-01-01' and ? " . $filter_cabang_enroll . "  group by date_format(a.enroll_date, '%Y') desc", [(string) ($selesai_period), ...($__p_filter_cabang_enroll ?? [])]);	
										 
$query_enroll_by_ori_school= q_set($__p_query_enroll_by_ori_school, "SELECT ori_school,\r
sum(case when date_format(a.enroll_date,'%Y') = 2021 then 1 else 0 end) as y21,\r
sum(case when date_format(a.enroll_date,'%Y') = 2020 then 1 else 0 end) as y20,\r
sum(case when date_format(a.enroll_date,'%Y') = 2019 then 1 else 0 end) as y19,\r
sum(case when date_format(a.enroll_date,'%Y') = 2018 then 1 else 0 end) as y18,\r
sum(case when date_format(a.enroll_date,'%Y') = 2017 then 1 else 0 end) as y17,\r
sum(case when date_format(a.enroll_date,'%Y') = 2016 then 1 else 0 end) as y16,\r
sum(case when date_format(a.enroll_date,'%Y') = 2015 then 1 else 0 end) as y15,\r
sum(case when date_format(a.enroll_date,'%Y') = 2014 then 1 else 0 end) as y14,\r
sum(case when date_format(a.enroll_date,'%Y') = 2013 then 1 else 0 end) as y13,\r
sum(case when date_format(a.enroll_date,'%Y') = 2012 then 1 else 0 end) as y12,\r
sum(case when enroll_date between  '2012-01-01' and '2021-12-31' then 1 else 0 end) as ttl\r
 FROM tb_sales_report a where a.prioritas = '1'\r
  and a.enroll_date between '2012-01-01' and ? " . $filter_cabang_enroll . "  group by ori_school order by ttl desc", [(string) ($selesai_period), ...($__p_filter_cabang_enroll ?? [])]);			

if (($kode_cabang != '0' and $kode_cabang != '') and $thn_period != '')
{

$query_enroll_by_source= q_set($__p_query_enroll_by_source, "SELECT b.event_type,\r
sum(case when date_format(a.enroll_date,'%Y') = 2021 then 1 else 0 end) as y21,\r
sum(case when date_format(a.enroll_date,'%Y') = 2020 then 1 else 0 end) as y20,\r
sum(case when date_format(a.enroll_date,'%Y') = 2019 then 1 else 0 end) as y19,\r
sum(case when date_format(a.enroll_date,'%Y') = 2018 then 1 else 0 end) as y18,\r
sum(case when date_format(a.enroll_date,'%Y') = 2017 then 1 else 0 end) as y17,\r
sum(case when date_format(a.enroll_date,'%Y') = 2016 then 1 else 0 end) as y16,\r
sum(case when date_format(a.enroll_date,'%Y') = 2015 then 1 else 0 end) as y15,\r
sum(case when date_format(a.enroll_date,'%Y') = 2014 then 1 else 0 end) as y14,\r
sum(case when date_format(a.enroll_date,'%Y') = 2013 then 1 else 0 end) as y13,\r
sum(case when date_format(a.enroll_date,'%Y') = 2012 then 1 else 0 end) as y12,\r
sum(case when a.enroll_date between '2012-01-01' and '2019-12-31' then 1 else 0 end) as ttl\r
FROM ves_data.tb_sales_report a left join ves_inc.tb_biodata b on a.kd_biodata= b.kd_biodata and a.kd_cabang = b.kd_branch\r
where a.prioritas = '1' and a.enroll_date between '2012-01-01' and ? " . $filter_cabang_enroll_source . " group by  b.event_type order by ttl desc", [(string) ($selesai_period), ...($__p_filter_cabang_enroll_source ?? [])]);
}
									
$query_leaving_by_institution = q_set($__p_query_leaving_by_institution, "SELECT b.groupschool, a.dest_country, a.dest_school,\r
sum(case when a.comm_date between ? and ?  then 1 else 0 end) as total,\r
sum(case when date_format(a.comm_date,'%m') = 1 then 1 else 0 end) as jan,\r
sum(case when date_format(a.comm_date,'%m') = 2 then 1 else 0 end) as feb,\r
sum(case when date_format(a.comm_date,'%m') = 3 then 1 else 0 end) as mar,\r
sum(case when date_format(a.comm_date,'%m') = 4 then 1 else 0 end) as apr,\r
sum(case when date_format(a.comm_date,'%m') = 5 then 1 else 0 end) as mei,\r
sum(case when date_format(a.comm_date,'%m') = 6 then 1 else 0 end) as jun,\r
sum(case when date_format(a.comm_date,'%m') = 7 then 1 else 0 end) as jul,\r
sum(case when date_format(a.comm_date,'%m') = 8 then 1 else 0 end) as aug,\r
sum(case when date_format(a.comm_date,'%m') = 9 then 1 else 0 end) as sep,\r
sum(case when date_format(a.comm_date,'%m') = 10 then 1 else 0 end) as okt,\r
sum(case when date_format(a.comm_date,'%m') = 11 then 1 else 0 end) as nov,\r
sum(case when date_format(a.comm_date,'%m') = 12 then 1 else 0 end) as des\r
\r
 FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country where a.final_status = 'L' and comm_date between ? and ? " . $filter_cabang . "   group by a.kd_school order by dest_country, dest_school", [(string) ($mulai_period), (string) ($selesai_period), (string) ($mulai_period), (string) ($selesai_period), ...($__p_filter_cabang ?? [])]);
						
$query_total_leaving_by_institution = q_set($__p_query_total_leaving_by_institution, "SELECT b.groupschool, a.dest_country, a.dest_school,\r
sum(case when a.comm_date between ? and ?  then 1 else 0 end) as total,\r
sum(case when date_format(a.comm_date,'%m') = 1 then 1 else 0 end) as jan,\r
sum(case when date_format(a.comm_date,'%m') = 2 then 1 else 0 end) as feb,\r
sum(case when date_format(a.comm_date,'%m') = 3 then 1 else 0 end) as mar,\r
sum(case when date_format(a.comm_date,'%m') = 4 then 1 else 0 end) as apr,\r
sum(case when date_format(a.comm_date,'%m') = 5 then 1 else 0 end) as mei,\r
sum(case when date_format(a.comm_date,'%m') = 6 then 1 else 0 end) as jun,\r
sum(case when date_format(a.comm_date,'%m') = 7 then 1 else 0 end) as jul,\r
sum(case when date_format(a.comm_date,'%m') = 8 then 1 else 0 end) as aug,\r
sum(case when date_format(a.comm_date,'%m') = 9 then 1 else 0 end) as sep,\r
sum(case when date_format(a.comm_date,'%m') = 10 then 1 else 0 end) as okt,\r
sum(case when date_format(a.comm_date,'%m') = 11 then 1 else 0 end) as nov,\r
sum(case when date_format(a.comm_date,'%m') = 12 then 1 else 0 end) as des\r
\r
 FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country where a.final_status = 'L' and comm_date between ? and ? " . $filter_cabang . "  ", [(string) ($mulai_period), (string) ($selesai_period), (string) ($mulai_period), (string) ($selesai_period), ...($__p_filter_cabang ?? [])]);
										 
$query_leaving_per_year = q_set($__p_query_leaving_per_year, "SELECT date_format(a.comm_date,'%Y'),\r
sum(case when date_format(a.comm_date,'%m') = 1 then 1 else 0 end) as jan,\r
sum(case when date_format(a.comm_date,'%m') = 2 then 1 else 0 end) as feb,\r
sum(case when date_format(a.comm_date,'%m') = 3 then 1 else 0 end) as mar,\r
sum(case when date_format(a.comm_date,'%m') = 4 then 1 else 0 end) as apr,\r
sum(case when date_format(a.comm_date,'%m') = 5 then 1 else 0 end) as mei,\r
sum(case when date_format(a.comm_date,'%m') = 6 then 1 else 0 end) as jun,\r
sum(case when date_format(a.comm_date,'%m') = 7 then 1 else 0 end) as jul,\r
sum(case when date_format(a.comm_date,'%m') = 8 then 1 else 0 end) as aug,\r
sum(case when date_format(a.comm_date,'%m') = 9 then 1 else 0 end) as sep,\r
sum(case when date_format(a.comm_date,'%m') = 10 then 1 else 0 end) as okt,\r
sum(case when date_format(a.comm_date,'%m') = 11 then 1 else 0 end) as nov,\r
sum(case when date_format(a.comm_date,'%m') = 12 then 1 else 0 end) as des\r
 FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country\r
 where a.final_status = 'L' and comm_date between '2012-01-01' and ? " . $filter_cabang . "   group by date_format(a.comm_date, '%Y') desc", [(string) ($selesai_period), ...($__p_filter_cabang ?? [])]);					
$query_leaving_ori_school = q_set($__p_query_leaving_ori_school, "SELECT a.ori_school,\r
sum(case when date_format(a.comm_date,'%Y') = 2021 then 1 else 0 end) as y21,\r
sum(case when date_format(a.comm_date,'%Y') = 2020 then 1 else 0 end) as y20,\r
sum(case when date_format(a.comm_date,'%Y') = 2019 then 1 else 0 end) as y19,\r
sum(case when date_format(a.comm_date,'%Y') = 2018 then 1 else 0 end) as y18,\r
sum(case when date_format(a.comm_date,'%Y') = 2017 then 1 else 0 end) as y17,\r
sum(case when date_format(a.comm_date,'%Y') = 2016 then 1 else 0 end) as y16,\r
sum(case when date_format(a.comm_date,'%Y') = 2015 then 1 else 0 end) as y15,\r
sum(case when date_format(a.comm_date,'%Y') = 2014 then 1 else 0 end) as y14,\r
sum(case when date_format(a.comm_date,'%Y') = 2013 then 1 else 0 end) as y13,\r
sum(case when date_format(a.comm_date,'%Y') = 2012 then 1 else 0 end) as y12,\r
sum(case when a.comm_date between '2012-01-01' and '2019-12-31' then 1 else 0 end) as ttl\r
 FROM adm_stu_progress a left join tb_master_partner b on a.dest_school = b.school and a.dest_country = b.country\r
 where a.final_status = 'L' and comm_date between '2012-01-01' and ? " . $filter_cabang . "  \r
 group by ori_school order by ttl desc,ori_school", [(string) ($thn_period) . "-12-31", ...($__p_filter_cabang ?? [])]);	

$query_cancel_per_year = q_set($__p_query_cancel_per_year, "SELECT date_format(a.update_date,'%Y'),\r
sum(case when date_format(a.update_date,'%m') = 1 then 1 else 0 end) as jan,\r
sum(case when date_format(a.update_date,'%m') = 2 then 1 else 0 end) as feb,\r
sum(case when date_format(a.update_date,'%m') = 3 then 1 else 0 end) as mar,\r
sum(case when date_format(a.update_date,'%m') = 4 then 1 else 0 end) as apr,\r
sum(case when date_format(a.update_date,'%m') = 5 then 1 else 0 end) as mei,\r
sum(case when date_format(a.update_date,'%m') = 6 then 1 else 0 end) as jun,\r
sum(case when date_format(a.update_date,'%m') = 7 then 1 else 0 end) as jul,\r
sum(case when date_format(a.update_date,'%m') = 8 then 1 else 0 end) as aug,\r
sum(case when date_format(a.update_date,'%m') = 9 then 1 else 0 end) as sep,\r
sum(case when date_format(a.update_date,'%m') = 10 then 1 else 0 end) as okt,\r
sum(case when date_format(a.update_date,'%m') = 11 then 1 else 0 end) as nov,\r
sum(case when date_format(a.update_date,'%m') = 12 then 1 else 0 end) as des\r
 FROM adm_stu_progress a\r
 where a.final_status = 'C' and a.update_date between '2012-01-01' and ? " . $filter_cabang . "    group by date_format(a.update_date, '%Y') desc", [(string) ($selesai_period), ...($__p_filter_cabang ?? [])]);		
									 
?>
    </section><!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="box">
          <div class="box-body">
 	     <strong>Target (Please Ignore)</strong></div></div>
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="3%">No</th>
                  <th width="13%">Year</th>
                  <th width="15%">Target</th>
                  <th width="15%">TOTAL</th>
                  <th width="5%">Jan</th>
                  <th width="6%">Feb</th>
                  <th width="5%">Mar</th>
                  <th width="4%">Apr</th>
                  <th width="4%">May</th>
                  <th width="4%">Jun</th>
                  <th width="8%">Jul</th>
                  <th width="6%">Aug</th>
                  <th width="6%">Sep</th>
                  <th width="6%">Oct</th>
                  <th width="7%">Nop</th>
                  <th width="8%">Dec</th>
                  </tr>
                </thead>
                <tbody>

				  <?php
								$no_urut = 1;		$result_target=db_query_or_die("Wah error nih51", $query_target, $__p_query_target ?? []);
					if ($result_target) 
						{ 
						while ($r_target = db_fetch($result_target))
							{
								$total_enroll_per_year = num($r_enroll_per_year[1]) + num($r_enroll_per_year[2]) + num($r_enroll_per_year[3]) + num($r_enroll_per_year[4]) + num($r_enroll_per_year[5]) + num($r_enroll_per_year[6]) + num($r_enroll_per_year[7]) + num($r_enroll_per_year[8]) + num($r_enroll_per_year[9]) + num($r_enroll_per_year[10]) + num($r_enroll_per_year[11]) + num($r_enroll_per_year[12]) ;  


							
							
							 					
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td>2019</td>
                  <td>Enrollment</td>
                  <td>&nbsp;</td>
                  <td><?php echo e($r_target[1]) ; ?></td>
                  <td><?php echo e($r_target[2]) ; ?></td>
                  <td><?php echo e($r_target[3]) ; ?></td>
                  <td><?php echo e($r_target[4]) ; ?></td>
                  <td><?php echo e($r_target[5]) ; ?></td>
                  <td><?php echo e($r_target[6]) ; ?></td>
                  <td><?php echo e($r_target[7]) ; ?></td>
                  <td><?php echo e($r_target[8]) ; ?></td>
                  <td><?php echo e($r_target[9]) ; ?></td>
                  <td><?php echo e($r_target[10]) ; ?></td>
                  <td><?php echo e($r_target[11]) ; ?></td>
                  <td><?php echo e($r_target[12]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; 							$r_enroll_per_year[1]=0;$r_enroll_per_year[2]=0;$r_enroll_per_year[3]=0;$r_enroll_per_year[4]=0;$r_enroll_per_year[5]=0;$r_enroll_per_year[6]=0;$r_enroll_per_year[7]=0;$r_enroll_per_year[8]=0;$r_enroll_per_year[9]=0;$r_enroll_per_year[10]=0;$r_enroll_per_year[11]=0;$r_enroll_per_year[12]=0;$r_enroll_per_year[13]=0;$r_enroll_per_year[14]=0;$r_enroll_per_year[15]=0;} }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>	    
	  </div>          
      <div class="row">
        <div class="box">
          <div class="box-body">
 	      <strong>Enroll</strong></div>
            <!-- /.box-header -->
					 <div class="col-xs-12"> <div class="box-body">       
					 	Enrollment 
	    By Year Comparison</div></div></div>
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="17%">Year</th>
                  <th width="9%">TOtal Enroll</th>
                  <th>Jan</th>
                  <th>Feb</th>
                  <th>Mar</th>
                  <th>Apr</th>
                  <th>May</th>
                  <th>Jun</th>
                  <th>Jul</th>
                  <th>Aug</th>
                  <th>Sep</th>
                  <th>Oct</th>
                  <th>Nop</th>
                  <th>Dec</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
										$result_per_year=db_query_or_die("Wah error nih52", $query_enroll_by_year, $__p_query_enroll_by_year ?? []);
					if ($result_per_year) 
						{ 
						while ($r_enroll_per_year = db_fetch($result_per_year))
							{
								$total_enroll_per_year = num($r_enroll_per_year[1]) + num($r_enroll_per_year[2]) + num($r_enroll_per_year[3]) + num($r_enroll_per_year[4]) + num($r_enroll_per_year[5]) + num($r_enroll_per_year[6]) + num($r_enroll_per_year[7]) + num($r_enroll_per_year[8]) + num($r_enroll_per_year[9]) + num($r_enroll_per_year[10]) + num($r_enroll_per_year[11]) + num($r_enroll_per_year[12]) ;  


							
							
							 					
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[0]) ; ?></td>
                  <td><?php echo e($total_enroll_per_year) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[1]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[2]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[3]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[4]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[5]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[6]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[7]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[8]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[9]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[10]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[11]) ; ?></td>
                  <td><?php echo e($r_enroll_per_year[12]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; 							$r_enroll_per_year[1]=0;$r_enroll_per_year[2]=0;$r_enroll_per_year[3]=0;$r_enroll_per_year[4]=0;$r_enroll_per_year[5]=0;$r_enroll_per_year[6]=0;$r_enroll_per_year[7]=0;$r_enroll_per_year[8]=0;$r_enroll_per_year[9]=0;$r_enroll_per_year[10]=0;$r_enroll_per_year[11]=0;$r_enroll_per_year[12]=0;$r_enroll_per_year[13]=0;$r_enroll_per_year[14]=0;$r_enroll_per_year[15]=0;} }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>

          <!-- /.box -->
        </div>
<?php if (($kode_cabang != '0' and $kode_cabang != '') and $thn_period != '')
{ ?>
        <div class="col-xs-12">
          <div class="box-body"> Enrollment 
            By Source</div>
        </div>
      </div> 
          
               <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example4" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="17%">Source</th>
                  <th width="9%">TOtal Enroll</th>
                  <th width="4%">2021</th>
                  <th width="4%">2020</th>
                  <th width="4%">2019</th>
                  <th width="5%">2018</th>
                  <th width="4%">2017</th>
                  <th width="3%">2016</th>
                  <th width="2%">2015</th>
                  <th width="2%">2014</th>
                  <th width="7%">2013</th>
                  <th width="5%">2012</th>
                  </tr>
                </thead>
                <tbody>
				  <?php $no_urut = 1; 
 	$result_enroll_by_source=db_query_or_die("Wah error nih521", $query_enroll_by_source, $__p_query_enroll_by_source ?? []);
					if ($result_enroll_by_source) 
						{ 
						while ($r_enroll_by_source = db_fetch($result_enroll_by_source))
							{

								$r_total_enroll_by_source = num($r_enroll_by_source[1]) + num($r_enroll_by_source[2]) + num($r_enroll_by_source[3]) + num($r_enroll_by_source[4]) + num($r_enroll_by_source[5]) + num($r_enroll_by_source[6]) + num($r_enroll_by_source[7]) + num($r_enroll_by_source[8]) ;
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[0]) ; ?></td>
                  <td><?php echo e($r_total_enroll_by_source) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[1]) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[1]) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[1]) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[2]) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[3]) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[4]) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[5]) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[6]) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[7]) ; ?></td>
                  <td><?php echo e($r_enroll_by_source[8]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1;$r_enroll_by_source[1]= 0; $r_enroll_by_source[2]= 0; $r_enroll_by_source[3]= 0; $r_enroll_by_source[4]= 0; $r_enroll_by_source[5] = 0; $r_enroll_by_source[6] = 0; $r_enroll_by_source[7]= 0; $r_enroll_by_source[8]= 0; 			} }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
       
          </div>
	<?php  } ?>
            
            <!-- /.box-body -->          <div class="box-body"> Enrollment 
                   ByOriginal School 
		</div>
     <div class="box">
                   <!-- /.box-header -->
                   <div class="box-body">
                     <table id="example2" class="table table-bordered table-striped">
                       <thead>
                         <tr>
                           <th width="6%">No</th>
                           <th width="20%">Original School</th>
                           <th width="14%">TOtal Enroll</th>
                           <th width="7%">2021</th>
                           <th width="7%">2020</th>
                           <th width="7%">2019</th>
                           <th width="8%">2018</th>
                           <th width="7%">2017</th>
                           <th width="6%">2016</th>
                           <th width="7%">2015</th>
                           <th width="7%">2014</th>
                           <th width="10%">2013</th>
                           <th width="8%">2012</th>
                         </tr>
                       </thead>
                       <tbody>
                         <?php $no_urut = 1;
	$result_enroll_by_ori_school=db_query_or_die("Wah error nih5", $query_enroll_by_ori_school, $__p_query_enroll_by_ori_school ?? []);					
					if ($result_enroll_by_ori_school) 
						{ 
						$no_urut = 1;
						while ($r_enroll_ori_school = db_fetch($result_enroll_by_ori_school))
							{ $r_total_ori = 0 ;$r_total_ori = num($r_enroll_ori_school[1]) + num($r_enroll_ori_school[2]) + num($r_enroll_ori_school[3]) + num($r_enroll_ori_school[4]) + num($r_enroll_ori_school[5]) + num($r_enroll_ori_school[6]) + num($r_enroll_ori_school[7]) + num($r_enroll_ori_school[8]) ;
				?>
                         <tr>
                           <td><?php echo e($no_urut) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[0]) ; ?></td>
                           <td><?php echo e($r_total_ori) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[1]) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[1]) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[1]) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[2]) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[3]) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[4]) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[5]) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[6]) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[7]) ; ?></td>
                           <td><?php echo e($r_enroll_ori_school[8]) ; ?></td>
                         </tr>
                         <?php $no_urut = num($no_urut) + 1; 							$r_enroll_ori_school[3]=0;$r_enroll_ori_school[4]=0;$r_enroll_ori_school[5]=0;$r_enroll_ori_school[6]=0;$r_enroll_ori_school[7]=0;$r_enroll_ori_school[8]=0;$r_enroll_ori_school[9]=0;$r_enroll_ori_school[10]=0;$r_enroll_ori_school[11]=0;$r_enroll_ori_school[12]=0;$r_enroll_ori_school[13]=0;$r_enroll_ori_school[14]=0;$r_enroll_ori_school[15]=0;} }?>
                       </tbody>
                       <tfoot>
                       </tfoot>
                     </table>
                   </div>
                   <!-- /.box-body -->
                </div>
     <div class="row">

        <div class="box">
          <div class="box-body">
 	      <strong>Leaving</strong></div>
            <!-- /.box-header -->
					 <div class="col-xs-12"> <div class="box-body">       
					 	Leaving
       By Year Comparison</div></div></div>
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="17%">Year</th>
                  <th width="9%">TOtal Leaving</th>
                  <th>Jan</th>
                  <th>Feb</th>
                  <th>Mar</th>
                  <th>Apr</th>
                  <th>May</th>
                  <th>Jun</th>
                  <th>Jul</th>
                  <th>Aug</th>
                  <th>Sep</th>
                  <th>Oct</th>
                  <th>Nop</th>
                  <th>Dec</th>
                  </tr>
                </thead>
                <tbody>

				  <?php   $no_urut = 1;
										$result_leaving_per_year=db_query_or_die("Wah error nih5", $query_leaving_per_year, $__p_query_leaving_per_year ?? []);
					if ($result_leaving_per_year) 
						{ 
						while ($r_leaving_per_year = db_fetch($result_leaving_per_year))
							{
								$total_leaving_per_year = num($r_leaving_per_year[1]) + num($r_leaving_per_year[2]) + num($r_leaving_per_year[3]) + num($r_leaving_per_year[4]) + num($r_leaving_per_year[5]) + num($r_leaving_per_year[6]) + num($r_leaving_per_year[7]) + num($r_leaving_per_year[8]) + num($r_leaving_per_year[9]) + num($r_leaving_per_year[10]) + num($r_leaving_per_year[11]) + num($r_leaving_per_year[12]) ;  


							
							
							 					
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[0]) ; ?></td>
                  <td><?php echo e($total_leaving_per_year) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[1]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[2]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[3]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[4]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[5]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[6]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[7]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[8]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[9]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[10]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[11]) ; ?></td>
                  <td><?php echo e($r_leaving_per_year[12]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; 							$r_leaving_per_year[1]=0;$r_leaving_per_year[2]=0;$r_leaving_per_year[3]=0;$r_leaving_per_year[4]=0;$r_leaving_per_year[5]=0;$r_leaving_per_year[6]=0;$r_leaving_per_year[7]=0;$r_leaving_per_year[8]=0;$r_leaving_per_year[9]=0;$r_leaving_per_year[10]=0;$r_leaving_per_year[11]=0;$r_leaving_per_year[12]=0;} }?>
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
      <div class="row">
                 <div class="box">
            <!-- /.box-header --> <div class="col-xs-12">
					 <div class="box-body">
					 	Leaving
	    By Institution Period : <?php echo e($thn_period) ?></div></div></div>
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example31" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="7%">Country</th>
                  <th width="39%">School</th>
                  <th width="5%">TOtal<br>
                  Leaving</th>
                  <th>Jan</th>
                  <th>Feb</th>
                  <th>Mar</th>
                  <th>Apr</th>
                  <th>May</th>
                  <th>Jun</th>
                  <th>Jul</th>
                  <th>Aug</th>
                  <th>Sep</th>
                  <th>Oct</th>
                  <th>Nop</th>
                  <th>Dec</th>
                  </tr>
                </thead>
                <tbody>
				  <?php 
					$no_urut = 1;

					$result_leaving_by_institution=db_query_or_die("Wah error nih5", $query_leaving_by_institution, $__p_query_leaving_by_institution ?? []);	
					if ($result_leaving_by_institution) 
						{ 
						$no_urut = 1;
						while ($r_leaving_by_institution = db_fetch($result_leaving_by_institution))
							{
				?>                     
                  <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[1]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[2]) ; ?><br>
                  <?php echo e($r_leaving_by_institution[0]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[3]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[4]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[5]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[6]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[7]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[8]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[9]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[10]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[11]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[12]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[13]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[14]) ; ?></td>
                  <td><?php echo e($r_leaving_by_institution[15]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; 							$r_leaving_by_institution[3]=0;$r_leaving_by_institution[4]=0;$r_leaving_by_institution[5]=0;$r_leaving_by_institution[6]=0;$r_leaving_by_institution[7]=0;$r_leaving_by_institution[8]=0;$r_leaving_by_institution[9]=0;$r_leaving_by_institution[10]=0;$r_leaving_by_institution[11]=0;$r_leaving_by_institution[12]=0;$r_leaving_by_institution[13]=0;$r_leaving_by_institution[14]=0;$r_leaving_by_institution[15]=0;} }?>
                <?php
 					$result_total_leaving_by_institution=db_query_or_die("Wah error nih5", $query_total_leaving_by_institution, $__p_query_total_leaving_by_institution ?? []);					
					if ($result_total_leaving_by_institution) 
						{ 
						while ($r_total_leaving_by_institution = db_fetch($result_total_leaving_by_institution))
							{     ?>                       
                  <tr>
                    <td colspan="3">TOTAL</td>
                    <td><?php echo e($r_total_leaving_by_institution[3]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[4]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[5]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[6]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[7]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[8]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[9]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[10]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[11]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[12]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[13]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[14]) ; ?></td>
                    <td><?php echo e($r_total_leaving_by_institution[15]) ; ?></td>
                  </tr><?php } }  ?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <tbody>
                  <?php $no_urut = 1;
					$result_total_leaving_by_institution=db_query_or_die("Wah error nih5", $query_total_leaving_by_institution, $__p_query_total_leaving_by_institution ?? []);					
					if ($result_total_leaving_by_institution) 
						{ 
						while ($r_total_leaving_by_institution = db_fetch($result_total_leaving_by_institution))
							{
							
							
							 					
				?>
                 
                  <tr>
                    <td width="2%">&nbsp;</td>
                    <td width="17%">&nbsp;</td>
                    <td width="29%">                      TOTAL</td>
                    <td width="5%"><?php echo e($r_total_leaving_by_institution[3]) ; ?></td>
                    <td width="4%"><?php echo e($r_total_leaving_by_institution[4]) ; ?></td>
                    <td width="3%"><?php echo e($r_total_leaving_by_institution[5]) ; ?></td>
                    <td width="3%"><?php echo e($r_total_leaving_by_institution[6]) ; ?></td>
                    <td width="3%"><?php echo e($r_total_leaving_by_institution[7]) ; ?></td>
                    <td width="2%"><?php echo e($r_total_leaving_by_institution[8]) ; ?></td>
                    <td width="2%"><?php echo e($r_total_leaving_by_institution[9]) ; ?></td>
                    <td width="2%"><?php echo e($r_total_leaving_by_institution[10]) ; ?></td>
                    <td width="6%"><?php echo e($r_total_leaving_by_institution[11]) ; ?></td>
                    <td width="4%"><?php echo e($r_total_leaving_by_institution[12]) ; ?></td>
                    <td width="5%"><?php echo e($r_total_leaving_by_institution[13]) ; ?></td>
                    <td width="6%"><?php echo e($r_total_leaving_by_institution[14]) ; ?></td>
                    <td width="7%"><?php echo e($r_total_leaving_by_institution[15]) ; ?></td>
                  </tr>
                  <?php $no_urut = num($no_urut) + 1;	$st_komisi = ''; } }?>
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
     <div class="row">
                 <div class="box">
            <!-- /.box-header -->
					 <div class="col-xs-12"> <div class="box-body">
					 	Leaving
						 By Original School</div></div></div>
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example4" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="6%">No</th>
                  <th width="21%">Original School</th>
                  <th width="15%">TOtal Leaving</th>
                  <th width="7%">2019</th>
                  <th width="8%">2018</th>
                  <th width="7%">2017</th>
                  <th width="6%">2016</th>
                  <th width="6%">2015</th>
                  <th width="6%">2014</th>
                  <th width="10%">2013</th>
                  <th width="8%">2012</th>
                  </tr>
                </thead>
                <tbody>
				  <?php $no_urut = 1;
	$result_ori_school=db_query_or_die("Wah error nih5", $query_leaving_ori_school, $__p_query_leaving_ori_school ?? []);					
					if ($result_ori_school) 
						{ 
						$no_urut = 1;
						while ($r = db_fetch($result_ori_school))
							{ $r_total_ori = 0 ;$r_total_ori = num($r[1]) + num($r[2]) + num($r[3]) + num($r[4]) + num($r[5]) + num($r[6]) + num($r[7]) + num($r[8]) ;
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[0]) ; ?></td>
                  <td><?php echo e($r_total_ori) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($r[2]) ; ?></td>
                  <td><?php echo e($r[3]) ; ?></td>
                  <td><?php echo e($r[4]) ; ?></td>
                  <td><?php echo e($r[5]) ; ?></td>
                  <td><?php echo e($r[6]) ; ?></td>
                  <td><?php echo e($r[7]) ; ?></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; 							$r[3]=0;$r[4]=0;$r[5]=0;$r[6]=0;$r[7]=0;$r[8]=0;$r[9]=0;$r[10]=0;$r[11]=0;$r[12]=0;$r[13]=0;$r[14]=0;$r[15]=0;} }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
<div class="row">         
<div class="box">
                 <div class="box-body">
					 	<strong>Cancel</strong></div>
            <!-- /.box-header -->
		    <div class="col-xs-12"> <div class="box-body">       
					 	Cancellation 
						 By Year Comparison</div></div>
					 <div class="col-xs-12">
					   <!-- /.box -->
					   <div class="box">
					     <!-- /.box-header -->
					     <div class="box-body">
					       <table id="example4" class="table table-bordered table-striped">
					         <thead>
					           <tr>
					             <th width="2%">No</th>
					             <th width="17%">Year</th>
					             <th width="9%">TOtal Cancel</th>
					             <th>Jan</th>
					             <th>Feb</th>
					             <th>Mar</th>
					             <th>Apr</th>
					             <th>May</th>
					             <th>Jun</th>
					             <th>Jul</th>
					             <th>Aug</th>
					             <th>Sep</th>
					             <th>Oct</th>
					             <th>Nop</th>
					             <th>Dec</th>
				               </tr>
				             </thead>
					         <tbody>
					           <?php 
								 $no_urut = 1;
										$result_cancel_per_year=db_query_or_die("Wah error nih5", $query_cancel_per_year, $__p_query_cancel_per_year ?? []);
					if ($result_cancel_per_year) 
						{ 
						while ($r_cancel_per_year = db_fetch($result_cancel_per_year))
							{
								$total_cancel_per_year = num($r_cancel_per_year[1]) + num($r_cancel_per_year[2]) + num($r_cancel_per_year[3]) + num($r_cancel_per_year[4]) + num($r_cancel_per_year[5]) + num($r_cancel_per_year[6]) + num($r_cancel_per_year[7]) + num($r_cancel_per_year[8]) + num($r_cancel_per_year[9]) + num($r_cancel_per_year[10]) + num($r_cancel_per_year[11]) + num($r_cancel_per_year[12]) ;  
				?>
					           <tr>
					             <td><?php echo e($no_urut) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[0]) ; ?></td>
					             <td><?php echo e($total_cancel_per_year) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[1]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[2]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[3]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[4]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[5]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[6]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[7]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[8]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[9]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[10]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[11]) ; ?></td>
					             <td><?php echo e($r_cancel_per_year[12]) ; ?></td>
				               </tr>
					           <?php $no_urut = num($no_urut) + 1; 							$r_cancel_per_year[1]=0;$r_cancel_per_year[2]=0;$r_cancel_per_year[3]=0;$r_cancel_per_year[4]=0;$r_cancel_per_year[5]=0;$r_cancel_per_year[6]=0;$r_cancel_per_year[7]=0;$r_cancel_per_year[8]=0;$r_cancel_per_year[9]=0;$r_cancel_per_year[10]=0;$r_cancel_per_year[11]=0;$r_cancel_per_year[12]=0;$r_cancel_per_year[13]=0;$r_cancel_per_year[14]=0;$r_cancel_per_year[15]=0;} }?>
				             </tbody>
					         <tfoot>
				             </tfoot>
				           </table>
				         </div>
					     <!-- /.box-body -->
				       </div>
					   <!-- /.box -->
		    </div>
</div>
</div>           <!-- /.box -->
        </div>
        
        <!-- /.col -->
     </div>
      <!-- /.row -->
   </div></section>
    <!-- /.content -->
  </form> 

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
<span class="content">

</span>
  <script>
  $(function () {
    $("#example4").DataTable();	 	  
    $("#example3").DataTable();	  
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
  </script>
  </body>
</html>
