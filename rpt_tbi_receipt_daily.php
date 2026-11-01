<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
//include __DIR__ . "/atas.php";
//include __DIR__ . "/left.php";
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$sales_year = '26';
$kd_cbg = in_val('kd_cbg', 'get');



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
$sql = q_set($__p_sql, "SELECT  min(detail), max(detail),date_format(detail,'%Y-%m') ,date_format(detail,'%Y'), date_format(min(detail),'%d %b %Y'), date_format(max(detail),'%d %b %Y')  FROM ves_data.tb_minggu_detail where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);
$rs = db_query_soft($sql, $__p_sql ?? []);
while($row = db_fetch($rs))
{
	$awal_mgg= $row[0];
	$akhir_mgg = $row[1];
	$dtl_bln = $row[2];
	$dtl_thn = $row[3];
	$awal_tampil = $row[4];
	$akhir_tampil = $row[5];
	
	$awal_bln = "$dtl_bln-01";
	$awal_thn = "$dtl_thn-01-01";
	
}
$dt_today = in_val('dt_today', 'get');
$thnn = substr($dt_today,0,4);
$blnn = substr($dt_today,0,7);
$awal_bln = "$blnn-01";

$awal_thn = "$thnn-01-01";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Top Navigation</title>
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
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">


  <!-- Full Width Column -->
 <form method=get action=vip_receipt_daily.php> 	
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
     <h1>VIP Income Summary<br>
     </h1>
     <?php 
 if ($cabang =='National')
	{
	$query = q_set($__p_query, "SELECT kd_branch  FROM vip_billing_payment a  where a.id_receipt <> '' \r
\tand dt_cetak between ? and ? group by kd_branch order by kd_branch", [(string) ($date_start), (string) ($date_end)]);		
	}
else
	{
	$query = q_set($__p_query, "SELECT kd_branch  FROM vip_billing_payment a  where a.id_receipt <> '' \r
\tand dt_cetak between ? and ? and kd_branch = ? group by kd_branch order by kd_branch", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);			
	}
$total_rp = 0;
$no_urut = 1;
$result=db_query_or_die("Wah error nih11", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         
         <tr>
           <th width="11%" scope="row">Date</th>
           <td width="20%"><span class="form-group">
             <input type="date" class="form-control" id="exampleInputEmail25" placeholder="Your Name" name="dt_today" value="<?php echo e($dt_today) ?>" onChange="this.form.submit()" >
           </span></td>
         </tr>
         <tr>
           <th scope="row" style="font-size: 15"> Report Date</th>
           <td style="font-size: 15"> <?php echo e($dt_today) ?>
</td>
         </tr>
       </tbody>
     </table>
   

   </section>

      <!-- Main content -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table width="97%" class="table table-hover" >
				  <jdl>
                <thead>
                <tr>
                  <th colspan="8"><strong><span style="font-size: 15"> Report Date</span> : <?php echo e($dt_today) ?></strong></th>
                  <th colspan="6" style="text-align: center">&nbsp;</th>
                  <th colspan="6" style="text-align: center">&nbsp;</th>
                </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="6" style="text-align: center";>Daily</th>
                  <th colspan="6" style="text-align: center">Monthly</th>
                  <th colspan="6" style="text-align: center">Yearly</th>
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
                <tr style="font-size: 1em">
                  <th width="3%">No</th>
                  <th width="15%">Center</th>
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
					$query_cabang = q_set($__p_query_cabang, "select kd_branch from vip_billing_payment where dt_cetak between ? and ? group by kd_branch order by kd_branch", [(string) ($awal_thn), (string) ($dt_today)]);
					$result_cabang=db_query_or_die("Wah error nih11", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$nm_cabang = $r_cbg[0];
							
							
							
							$query_hitung = q_set($__p_query_hitung, "select a.kd_branch,\r
count(case when jns_payment = 'Registration' and dt_cetak = ?   and kd_program not like 'CL%'  then 1 end  ) as reg_pax_w,\r
sum(case when jns_payment = 'Registration' and dt_cetak = ?   and kd_program not like 'CL%'   then amount end  ) as reg_amount_w,\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak = ?   and kd_program not like 'CL%'   then 1 end  ) as tf_pax_w,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak = ?   and kd_program not like 'CL%'  then amount end  ) as tf_amount_w,\r
\r
count(case when dt_cetak = ?   and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_w,\r
sum(case when dt_cetak = ?  and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_w,\r
\r
count(case when jns_payment = 'Registration' and dt_cetak between ? and ?  and kd_program not like 'CL%'  then 1 end  ) as reg_pax_m,\r
sum(case when jns_payment = 'Registration' and dt_cetak between ? and ?  and kd_program not like 'CL%'  then amount end  ) as reg_amount_m,\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak between ? and ?   and kd_program not like 'CL%'  then 1 end  ) as tf_pax_m,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak between ? and ?  and kd_program not like 'CL%'  then amount end  ) as tf_amount_m,\r
\r
count(case when dt_cetak between ? and ?  and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_m,\r
sum(case when dt_cetak between ? and ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_m,\r
\r
\r
count(case when jns_payment = 'Registration' and dt_cetak between ? and ?  and kd_program not like 'CL%'  then 1 end  ) as reg_pax_y,\r
sum(case when jns_payment = 'Registration' and dt_cetak between ? and ?  and kd_program not like 'CL%'  then amount end  ) as reg_amount_y,\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak between ? and ?  and kd_program not like 'CL%'   then 1 end  ) as tf_pax_y,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_cetak between ? and ?  and kd_program not like 'CL%'  then amount end  )\r
as tf_amount_y,\r
\r
count(case when dt_cetak between ? and ?  and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_y,\r
sum(case when dt_cetak between ? and ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_y\r
\r
from vip_billing_payment a left join vip_billing b on a.kd_billing = b.kd_billing  where status = 'PAID' and dt_cetak between ? and ? and a.kd_branch = ? ", [(string) ($dt_today), (string) ($dt_today), (string) ($dt_today), (string) ($dt_today), (string) ($dt_today), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_bln), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($awal_thn), (string) ($dt_today), (string) ($nm_cabang)]);
				$result_hitung=db_query_or_die("Wah error nih11", $query_hitung, $__p_query_hitung ?? []);
					if ($result_hitung) 
						{ 
						while ($rh = db_fetch($result_hitung))
							{
							$kd_branch = $rh[0];
if ($kd_branch == '1'){$nama_cabang = 'East Sby';}
elseif ($kd_branch == '2'){$nama_cabang = 'West Sby';}
elseif ($kd_branch == '3'){$nama_cabang = 'Denpasar';}
elseif ($kd_branch == '4'){$nama_cabang = 'South Jkt';}
elseif ($kd_branch == '5'){$nama_cabang = 'North Jkt';}
elseif ($kd_branch == '6'){$nama_cabang = 'West Jkt';}
elseif ($kd_branch == '7'){$nama_cabang = 'Bandung';}
elseif ($kd_branch == '8'){$nama_cabang = 'Malang TBI';}
elseif ($kd_branch == '9'){$nama_cabang = 'Bandung TBI';}
elseif ($kd_branch == '00'){$nama_cabang = 'HO';}
elseif ($kd_branch == '11'){$nama_cabang = 'PIK';}
elseif ($kd_branch == '14'){$nama_cabang = 'Medan';}							
							
							
							
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

$reg_pax_y = $rh[13];
$reg_amount_y = $rh[14];
$tf_pax_y = $rh[15];
$tf_amount_y = $rh[16];
$reg_pax_cl_y = $rh[17];
$reg_amount_cl_y = $rh[18];
$total_reg_pax_w =num($total_reg_pax_w) + num($reg_pax_w);
$total_reg_amount_w =num($total_reg_amount_w) + num($reg_amount_w);
$total_tf_pax_w =num($total_tf_pax_w) + num($tf_pax_w);
$total_tf_amount_w =num($total_tf_amount_w) + num($tf_amount_w);
$total_reg_pax_cl_w =num($total_reg_pax_cl_w) + num($reg_pax_cl_w);
$total_reg_amount_cl_w =num($total_reg_amount_cl_w) + num($reg_amount_cl_w);

$total_reg_pax_m =num($total_reg_pax_m) + num($reg_pax_m);
$total_reg_amount_m =num($total_reg_amount_m) + num($reg_amount_m);
$total_tf_pax_m =num($total_tf_pax_m) + num($tf_pax_m);
$total_tf_amount_m =num($total_tf_amount_m) + num($tf_amount_m);
$total_reg_pax_cl_m =num($total_reg_pax_cl_m) + num($reg_pax_cl_m);
$total_reg_amount_cl_m =num($total_reg_amount_cl_m) + num($reg_amount_cl_m);

$total_reg_pax_y =num($total_reg_pax_y) + num($reg_pax_y);
$total_reg_amount_y =num($total_reg_amount_y) + num($reg_amount_y);
$total_tf_pax_y =num($total_tf_pax_y) + num($tf_pax_y);
$total_tf_amount_y =num($total_tf_amount_y) + num($tf_amount_y);
$total_reg_pax_cl_y =num($total_reg_pax_cl_y) + num($reg_pax_cl_y);
$total_reg_amount_cl_y =num($total_reg_amount_cl_y) + num($reg_amount_cl_y);

				?>               
					
                <tr>
                  <td height="20"><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($nama_cabang) ; ?>
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
                  </tr> <?php $no_urut = num($no_urut)+1; }} } } ?>
                <tr>
                  <td height="20"><strong>TOTAL</strong></td>
                  <td>&nbsp;</td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_w) ; ?></strong></td>
                  <td style="text-align: right" ><strong><?php echo   number_format(num($total_reg_amount_w),0,".",".")  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_tf_pax_w); ?></strong></td>
                  <td><strong><?php echo   number_format(num($total_tf_amount_w),0,".",".")  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_cl_w) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   number_format(num($total_reg_amount_cl_w),0,".",".")  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_m) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   number_format(num($total_reg_amount_m),0,".",".")  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_tf_pax_m); ?></strong></td>
                  <td><strong><?php echo   number_format(num($total_tf_amount_m),0,".",".")  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_cl_m) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   number_format(num($total_reg_amount_cl_m),0,".",".")  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_y) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   number_format(num($total_reg_amount_y),0,".",".")  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tf_pax_y); ?></strong></td>
                  <td><strong><?php echo   number_format(num($total_tf_amount_y),0,".",".")  ; ?></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($total_reg_pax_cl_y) ; ?></strong></td>
                  <td style="text-align: right"><strong><?php echo   number_format(num($total_reg_amount_cl_y),0,".",".")  ; ?></strong></td>
                  </tr>
               
            
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <div class="box">
         	<div class="box-body"><a href="vipreceiptdailyxl.php?dt=<?php echo e(u($dt_today)) ?>">Print to XL</a></div>
         </div>
            <!-- /.box-body -->
          </div>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
	</form>	 

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
