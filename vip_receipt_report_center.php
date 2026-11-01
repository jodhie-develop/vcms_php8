<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');

$sales_year = '25';
$kd_cbg = in_val('kd_cbg', 'get');

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 14;}
elseif ($kd_cbg == 'West Area'){$kd_cbg = 102;}
elseif ($kd_cbg == 'National'){$kd_cbg = 100;}

if (num($kd_cbg) ==100){$cabang = 'National';}
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$week = in_val('week', 'get');
$query = q_set($__p_query, "SELECT no_week, tgl_periode, bulan FROM master_date where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);

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
$sql = q_set($__p_sql, "SELECT min(detail), max(detail),date_format(detail,'%Y-%m') ,date_format(detail,'%Y')FROM ves_data.tb_minggu_detail where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);

$rs = db_query_soft($sql, $__p_sql ?? []);
while($row = db_fetch($rs))
{
	$awal_mgg= $row[0];
	$akhir_mgg = $row[1];
	$dtl_bln = $row[2];
	$dtl_thn = $row[3];
	
	$awal_bln = "$dtl_bln-01";
	$awal_thn = "$dtl_thn-01-01";
	
}

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
<style>
     .table th {
        font-size: 8px;
    }
	.table td  {
        font-size: 10px;
    }
</style>	
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_receipt_report_center.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         <tr>
           <td width="11%"><small>
             <label for="date3">Center :</label>
           </small></td>
           <td width="89%">:
             <select name="kd_cbg"     class="style33" id="select"  onChange="this.form.submit()">
               <option value="">--CHOOSE--</option>
               <option value="1">East Sby</option>
               <option value="2">West Sby</option>
               <option value="3">Denpasar</option>
               <option value="8">Malang</option>
               <option value="4">South Jkt</option>
               <option value="5">North Jkt</option>
               <option value="6">West Jkt</option>
               <option value="7">Bandung</option>
               <option value="11">PIK</option>
               <option value="12">Medan</option>				 
               <option value="100">Online</option>
               <option value="100">National</option>
               <option selected="selected"><?php echo e($cabang) ?></option>
             </select></td>
         </tr>
       </tbody>
     </table>	   
     <h1>VIP Income Summary Comparison 2023 / 2024<br>
       Center : <?php echo e($cabang) ?> 
       <br>
     </h1>

   

   </section>


<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
		
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="100%" class="table table-bordered table-striped" id="example1">
				  <jdl>
                <thead class="thead-dark">
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="6" style="text-align: center";>2023</th>
                  <th colspan="6" style="text-align: center">2024</th>
                  <th colspan="6" style="text-align: center">Selisih</th>
                  </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  </tr>
                <tr>
                  <th width="3%">No</th>
                  <th width="15%">Month</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  </tr>
                </thead>
				  </jdl>					  
                <tbody>

				  <?php 
	if($kd_cbg ==''){die;} $no_urut = 1;
					$query_cabang = q_set($__p_query_cabang, "select date_format(dt_cetak, '%m'),date_format(dt_cetak, '%b') from vip_billing_payment where kd_branch = ? and  (date_format(dt_cetak, '%Y') = '2023' or date_format(dt_cetak, '%Y') = '2024') group by date_format(dt_cetak, '%m') order by dt_cetak ", [(string) ($kd_cbg)]); 
					$result_cabang=db_query_or_die("Wah error nih11", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$nm_bln = $r_cbg[0];
							$nm_bln_tampil = $r_cbg[1];
							
							$query_hitung = q_set($__p_query_hitung, "select a.kd_branch,\r
count(case when jns_payment = 'Registration' and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'  then 1 end  ) as reg_pax_w,\r
sum(case when jns_payment = 'Registration' and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'   then amount end  ) as reg_amount_w,\r
\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'   then 1 end  ) as tf_pax_w,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'  then amount end  ) as tf_amount_w,\r
\r
count(case when date_format(dt_payment,'%Y-%m') = ? and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_w,\r
sum(case when date_format(dt_payment,'%Y-%m') = ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_w,\r
\r
count(case when jns_payment = 'Registration' and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'  then 1 end  ) as reg_pax_m,\r
sum(case when jns_payment = 'Registration' and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'   then amount end  ) as reg_amount_m,\r
\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'   then 1 end  ) as tf_pax_m,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and date_format(dt_payment,'%Y-%m') = ? and kd_program not like 'CL%'  then amount end  ) as tf_amount_m,\r
\r
count(case when date_format(dt_payment,'%Y-%m') = ? and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_m,\r
sum(case when date_format(dt_payment,'%Y-%m') = ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_m\r
\r
\r
\r
\r
from vip_billing_payment a left join vip_billing b on a.kd_billing = b.kd_billing  where status = 'PAID' and  (date_format(dt_cetak, '%Y') = '2023' or date_format(dt_cetak, '%Y') = '2024') and a.kd_branch = ? ", ["2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2023-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), "2024-" . (string) ($nm_bln), (string) ($kd_cbg)]);

				$result_hitung=db_query_or_die("Wah error nih11", $query_hitung, $__p_query_hitung ?? []);
					if ($result_hitung) 
						{ 
						while ($rh = db_fetch($result_hitung))
							{
						
							
							
							
$reg_pax_w = $rh[1];
$reg_amount_w = $rh[2];
$tf_pax_w = $rh[3];
$tf_amount_w = $rh[4];
$reg_pax_cl_w = $rh[5];
$reg_amount_cl_w = $rh[6];

$reg_pax_m = $rh[7];
$reg_amount_m = $rh[8];
$tf_pax_m = $rh[9];
$tf_amount_m = $rh[10];
$reg_pax_cl_m = $rh[11];
$reg_amount_cl_m = $rh[12];

$reg_pax_y = num($reg_pax_m) - num($reg_pax_w); 
$reg_amount_y =  num($reg_amount_m) - num($reg_amount_w);
$tf_pax_y = num($tf_pax_m) - num($tf_pax_w);
$tf_amount_y = num($tf_amount_m) - num($tf_amount_w);
$reg_pax_cl_y = num($reg_pax_cl_m)- num($reg_pax_cl_w);
$reg_amount_cl_y = num($reg_amount_cl_m) - num($reg_amount_cl_w);
							
$tot_reg_pax_w = num($tot_reg_pax_w) + num($reg_pax_w); 
$tot_reg_amount_w =  num($tot_reg_amount_w) + num($reg_amount_w);
$tot_tf_pax_w = num($tot_tf_pax_w) + num($tf_pax_w);
$tot_tf_amount_w = num($tot_tf_amount_w) + num($tf_amount_w);
$tot_reg_pax_cl_w = num($tot_reg_pax_cl_w)+ num($reg_pax_cl_w);
$tot_reg_amount_cl_w = num($tot_reg_amount_cl_w) + num($reg_amount_cl_w);
							
$tot_reg_pax_m = num($tot_reg_pax_m) + num($reg_pax_m); 
$tot_reg_amount_m =  num($tot_reg_amount_m) + num($reg_amount_m);
$tot_tf_pax_m = num($tot_tf_pax_m) + num($tf_pax_m);
$tot_tf_amount_m = num($tot_tf_amount_m) + num($tf_amount_m);
$tot_reg_pax_cl_m = num($tot_reg_pax_cl_w)+ num($reg_pax_cl_m);
$tot_reg_amount_cl_m = num($tot_reg_amount_cl_m) + num($reg_amount_cl_m);

$tot_reg_pax_y = num($tot_reg_pax_y) + num($reg_pax_y) ; 
$tot_reg_amount_y =  num($tot_reg_amount_y) + num($reg_amount_y) ;
$tot_tf_pax_y = num($tot_tf_pax_y) + num($tf_pax_y) ;
$tot_tf_amount_y = num($tot_tf_amount_y) + num($tf_amount_y) ;
$tot_reg_pax_cl_y = num($tot_reg_pax_cl_y) + num($reg_pax_cl_y) ;
$tot_reg_amount_cl_y = num($tot_reg_amount_cl_y) + num($reg_amount_cl_y) ;


							
							
							


				?>               
					
                <tr style="height: 100%">
                  <td style="height: 200%"><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($nm_bln_tampil) ; ?>
                  <input type="hidden" name="kd_branch" id="textfield" value="<?php echo e($kd_branch) ?>"></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_w) ; ?></td>
                  <td style="text-align: right" ><?php echo   number_format(num($reg_amount_w),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_w); ?></td>
                  <td><?php echo   number_format(num($tf_amount_w),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_w) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($reg_amount_cl_w),0,".",".")  ; ?></td>

                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_m) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($reg_amount_m),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_m); ?></td>
                  <td><?php echo   number_format(num($tf_amount_m),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_m) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($reg_amount_cl_m),0,".",".")  ; ?></td>
					
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_y) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($reg_amount_y),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_y); ?></td>
                  <td><?php echo   number_format(num($tf_amount_y),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_y) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($reg_amount_cl_y),0,".",".")  ; ?></td>				
                  </tr>
                <?php $no_urut = num($no_urut)+1; }} } } ?>
            
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <div class="box">
         	<div class="box-body">
         		              <table width="100%" class="table table-bordered table-striped" id="example1">
                <thead class="thead-dark">
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="6" style="text-align: center";>2023</th>
                  <th colspan="6" style="text-align: center">2024</th>
                  <th colspan="6" style="text-align: center">Selisih</th>
                  </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  <th colspan="2" style="text-align: center">Registration</th>
                  <th colspan="2" style="text-align: center">Tuition </th>
                  <th colspan="2" style="text-align: center">Clinic</th>
                  </tr>
                <tr>
                  <th width="3%">No</th>
                  <th width="15%">Month</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="5%">Amount</th>
                  </tr>
                </thead>

                <tfoot>
					<tr style="height: 100%">
                  <td colspan="2" style="height: 200%"><strong>TOTAL <?php echo e($cabang) ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_w) ; ?></td>
                  <td style="text-align: right" ><?php echo   number_format(num($tot_reg_amount_w),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_tf_pax_w); ?></td>
                  <td><?php echo   number_format(num($tot_tf_amount_w),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_cl_w) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($tot_reg_amount_cl_w),0,".",".")  ; ?></td>

                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_m) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($tot_reg_amount_m),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_tf_pax_m); ?></td>
                  <td><?php echo   number_format(num($tot_tf_amount_m),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_cl_m) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($tot_reg_amount_cl_m),0,".",".")  ; ?></td>
					
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_y) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($tot_reg_amount_y),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_tf_pax_y); ?></td>
                  <td><?php echo   number_format(num($tot_tf_amount_y),0,".",".")  ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tot_reg_pax_cl_y) ; ?></td>
                  <td style="text-align: right"><?php echo   number_format(num($tot_reg_amount_cl_y),0,".",".")  ; ?></td>				
                  </tr>
                </tfoot>
              </table>
         	</div>
         </div>
            <!-- /.box-body -->
          </div><a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a><a href="viprcptrpot_xl.php?kd_cbg=<?php echo e(u($kd_cbg))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a>
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
 "pageLength": 50,		
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
