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
$dt_awal = in_val('dt_awal', 'get');

if ($dt_awal ==''){$dt_awal = $hari_ini;$dt_akhir = $hari_ini;}
$sales_year = '26';
$kd_cbg = in_val('kd_cbg', 'get');



$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;


$thn = substr($dt_awal,0,4);
$thn_lalu = num($thn) - 1;
$bln = substr($dt_awal,5,2);
$awal_bln = "$bln-01";
$awal_thn = "$thn-01-01";
$awal_thn_lalu = "$thn_lalu-01-01";
$awak_bln_lalu = "$thn_lalu-$bln-01";
$dt_lalu = substr($dt_awal,4,7);
$dt_lalu ="$thn_lalu$dt_lalu";
    $source = $dt_awal;
    $date_tgl = new DateTime($source);
    $date_tgl =  $date_tgl->format('d M Y'); // 31-07-2012
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VOS SERVICE FEE DAILY REPORT</title>
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
 <form method=get action=vossf_receipt_daily.php> 	
  <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <section class="content-header">
     <h1>VOS Service Fee Summary<br>
     </h1>

     <table width="100%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         
         <tr>
           <th width="10%" scope="row">Date</th>
           <td width="90%"><span class="form-group">
             <input type="date" maxlength=""  class="form-control" id="exampleInputEmail25" placeholder="Your Name" name="dt_awal" value="<?php echo e($dt_awal) ?>" onChange="this.form.submit()" >
           </span></td>
         </tr>
       </tbody>
     </table>
   

   </section>

      <!-- Main content -->
    
            <!-- /.box-header -->
           
              <table width="80%" class="table table-hover" >
				  <jdl>
                <thead>
					
                <tr style="font-size: 1em">
                  <th colspan="20"  style="text-align: center">SERVICE FEE RECEIPT SUMMARY</th>
                  </tr>
                <tr style="font-size: 1em">
                  <th colspan="20"  style="text-align: center"><strong><span style="font-size: 15">Periode</span> : <?php echo e($date_tgl) ?></strong></th>
                  </tr>
                <tr style="font-size: 1em">
                  <th width="4%">No</th>
                  <th width="19%">Center</th>
                  <th colspan="2" style="text-align: center">Today</th>
                  <th colspan="2" style="text-align: center">Today <br>
                    Last Year</th>
                  <th colspan="2" style="text-align: center">Diff</th>
                  <th colspan="2" style="text-align: center">This <br>
                    Month</th>
                  <th colspan="2" style="text-align: center">This Month  <br>
                    Last Year</th>
                  <th colspan="2" style="text-align: center">Diff</th>
                  <th colspan="2" style="text-align: center">This Year</th>
                  <th colspan="2" style="text-align: center">Last Year</th>
                  <th colspan="2" style="text-align: center">Diff</th>
                  </tr>
                <tr style="font-size: 1em">
                  <th width="4%">No</th>
                  <th width="19%">Center</th>
                  <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="10%">Amount</th>
                  <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="10%">Amount</th>
                  <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="10%">Amount</th>
                  <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th>Amount</th>
                  <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th bgcolor="#FFFFFF">Amount</th>
                  <th width="14%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th>Amount</th>
                  <th width="6%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="10%">Amount</th>
                  <th width="6%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="10%">Amount</th>
                  <th width="6%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                  <th width="10%">Amount</th>
                  </tr>					
                </thead>
				  </jdl>					  


				  <?php $no_urut = 1;
					$query_cabang = q_set($__p_query_cabang, "SELECT branch, case when branch = 'East Sby' then 0 when branch = 'West Sby' then 1 when branch = 'Bali' then 2\r
when branch = 'Patal Jkt' or branch = 'South Jkt' then 3 when branch = 'Central Jkt' or branch = 'North Jkt' then 4 when branch = 'West Jkt' then 5 when branch = 'PIK' then 6 when branch = 'Bandung' then 7 when branch = 'Malang' or branch = 'Malang TBI' then 8 else 10 end as kode\r
FROM ves_inc.tb_prof_bill where tgl_cetak between ? and ? and branch <>''  group by kode ", [(string) ($awal_thn_lalu), (string) ($dt_awal)]);


					$result_cabang=db_query_or_die("Wah error nih11", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$branch = $r_cbg[0]; 

if ($branch == 'Patal Jkt' or $branch == 'South Jkt'){$nama_cabang = 'South Jkt';$q_cbg = q_set($__p_q_cbg, "branch = 'Patal Jkt' or branch = 'South Jkt'");$nmbranch = 'South Jkt';  }
elseif ($branch == 'North Jkt' or $branch == 'Central Jkt'){$nama_cabang = 'North Jkt';$q_cbg = q_set($__p_q_cbg, "branch = 'North Jkt' or branch = 'Central Jkt'");$nmbranch = 'North Jkt'; }
elseif ($branch == 'Malang' or $branch == 'Malang TBI'){$nama_cabang = 'North Jkt';$q_cbg = q_set($__p_q_cbg, "branch = 'Malang' or branch = 'Malang TBI'");$nmbranch = 'Malang'; }							
else {$q_cbg = q_set($__p_q_cbg, "branch = ? ", [(string) ($branch)]);$nmbranch = $branch;}
	
				  ?> 
							
							
							
	                <tbody>						
					
                <tr bgcolor="#FFFD07">
                  <td height="20"><strong><?php echo e($no_urut) ; ?></strong></td>
                  <td><strong><?php echo e($nmbranch) ; ?></strong></td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right" >&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right" >&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right" >&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right">&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right">&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right">&nbsp;</td>

                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right">&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right">&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right">&nbsp;</td>
                  </tr>	
<?php
$query_per_cabang = q_set($__p_query_per_cabang, "SELECT st_refund,\r
count(case when tgl_cetak  = ? then 1 end ) as now_p,\r
sum(case when tgl_cetak  = ? then mount end ) as now_m,\r
count(case when tgl_cetak  = ? then 1 end ) as now_p_last,\r
sum(case when tgl_cetak  = ? then mount end ) as now_m_last,\r
\r
count(case when tgl_cetak  between ? and  ? then 1 end ) as month_p,\r
sum(case when tgl_cetak  between ? and  ? then mount end ) as month_m,\r
count(case when tgl_cetak  between ? and ? then 1 end ) as month_p_last,\r
sum(case when tgl_cetak  between ? and ? then mount end ) as month_m_last,\r
\r
count(case when tgl_cetak  between ? and  ? then 1 end ) as year_p,\r
sum(case when tgl_cetak  between ? and  ? then mount end ) as year_m,\r
count(case when tgl_cetak  between ? and ? then 1 end ) as year_p_last,\r
sum(case when tgl_cetak  between ? and ? then mount end ) as year_m_last,case when st_refund  = 'Refundable' then st_refund else 'Non Refundable' end as kd_st_refund \r
\r
FROM ves_inc.tb_prof_bill where  tgl_cetak between ? and  ? and " . $q_cbg . " group by kd_st_refund", [(string) ($dt_awal), (string) ($dt_awal), (string) ($dt_lalu), (string) ($dt_lalu), (string) ($thn) . "-" . (string) ($bln) . "-01", (string) ($dt_awal), (string) ($thn) . "-" . (string) ($bln) . "-01", (string) ($dt_awal), (string) ($thn_lalu) . "-" . (string) ($bln) . "-01", (string) ($dt_lalu), (string) ($thn_lalu) . "-" . (string) ($bln) . "-01", (string) ($dt_lalu), (string) ($thn) . "-01-01", (string) ($dt_awal), (string) ($thn) . "-01-01", (string) ($dt_awal), (string) ($thn_lalu) . "-01-01", (string) ($dt_lalu), (string) ($thn_lalu) . "-01-01", (string) ($dt_lalu), (string) ($thn_lalu) . "=01-01", (string) ($dt_awal), ...($__p_q_cbg ?? [])]);

$result_per_cabang=db_query_or_die("Wah error nih211", $query_per_cabang, $__p_query_per_cabang ?? []);
if ($result_per_cabang) 
	{ 
	while ($r_p_cbg = db_fetch($result_per_cabang))
		{
		$keterangan = $r_p_cbg[0];
$now_p =$r_p_cbg[1];$tot_now_p = num($tot_now_p) + num($now_p);
$now_m =$r_p_cbg[2];$tot_now_m = num($tot_now_m) + num($now_m);
$now_p_last =$r_p_cbg[3];$tot_now_p_last = num($tot_now_p_last) + num($now_p_last);
$now_m_last =$r_p_cbg[4];$tot_now_m_last = num($tot_now_m_last) + num($now_m_last);
$diff_now_p = num($now_p) - num($now_p_last); $tot_diff_now_p = num($tot_diff_now_p) + num($diff_now_p);
$diff_now_m = num($now_m) - num($now_m_last); $tot_diff_now_p = num($tot_diff_now_p) + num($diff_now_p);
		
$month_p =$r_p_cbg[5];$tot_month_p = num($tot_month_p) + num($month_p);
$month_m =$r_p_cbg[6];$tot_month_m = num($tot_month_m) + num($month_m);
$month_p_last =$r_p_cbg[7];
$month_m_last =$r_p_cbg[8];
$diff_month_p = num($month_p) - num($month_p_last);$tot_diff_month_p = num($tot_diff_month_p) + num($diff_month_p);
$diff_month_m = num($month_m) - num($month_m_last);$tot_diff_month_m = num($tot_diff_month_m) + num($diff_month_m);
	

$year_p =$r_p_cbg[9];
$year_m =$r_p_cbg[10];
$year_p_last =$r_p_cbg[11];
$year_m_last =$r_p_cbg[12];
$diff_year_p = num($year_p) - num($year_p_last);
$diff_year_m = num($year_m) - num($year_m_last);

$tot_month_p_last = num($tot_month_p_last) + num($month_p_last);
$tot_month_m_last = num($tot_month_m_last) + num($month_m_last);

$tot_year_p = num($tot_year_p) + num($year_p);
$tot_year_m = num($tot_year_m) + num($year_m);
$tot_year_p_last = num($tot_year_p_last) + num($year_p_last);
$tot_year_m_last = num($tot_year_m_last) + num($year_m_last);
$tot_diff_year_p = num($tot_year_p) - num($tot_year_p_last);
$tot_diff_year_m = num($tot_year_m) + num($tot_year_m_last);

?>							
	                <tr>
                  <td height="20">&nbsp;</td>
                  <td><?php echo e($keterangan) ; ?></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($now_p) ?></td>
                  <td style="text-align: right" ><span style="text-align: right"><?php echo number_format(num($now_m),0,".",".") ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($now_p_last) ?></td>
                  <td style="text-align: right" ><span style="text-align: right"><?php echo number_format(num($now_m_last),0,".",".") ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($diff_now_p) ?></td>
                  <td style="text-align: right" ><span style="text-align: right"><?php echo number_format(num($diff_now_m),0,".",".") ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($month_p) ?></td>
                  <td style="text-align: right" ><span style="text-align: right"><?php echo number_format(num($month_m),0,".",".") ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($month_p_last) ?></td>
                  <td style="text-align: right" ><span style="text-align: right"><?php echo number_format(num($month_m_last),0,".",".") ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($diff_month_p) ?></td>
                  <td style="text-align: right" ><span style="text-align: right"><?php echo number_format(num($diff_month_m),0,".",".") ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($year_p) ?></td>
                  <td style="text-align: right" ><span style="text-align: right"><?php echo number_format(num($year_m),0,".",".") ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($year_p_last) ?></td>
                  <td style="text-align: right" ><span style="text-align: right"><?php echo number_format(num($year_m_last),0,".",".") ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($diff_year_p) ?></td>
                  <td style="text-align: right" ><span style="text-align: right"><?php echo number_format(num($diff_year_m),0,".",".") ?></span></td>
                    </tr>			
 <?php } } ?>
 <?php $no_urut = num($no_urut)+1;  } } ?>	
                  <tr>
                  <td height="20" colspan="2"><strong>TOTAL</strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tot_now_p) ?></strong></td>
                  <td style="text-align: right" ><strong><span style="text-align: right"><?php echo number_format(num($tot_now_m ),0,".",".")?></span></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tot_now_p_last) ?></strong></td>
                  <td style="text-align: right" ><strong><span style="text-align: right"><?php echo number_format(num($tot_now_m ),0,".",".")?></span></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tot_diff_now_p) ?></strong></td>
                  <td style="text-align: right" ><strong><span style="text-align: right"><?php echo number_format(num($tot_diff_now_m),0,".",".") ?></span></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tot_month_p) ?></strong></td>
                  <td style="text-align: right" ><strong><span style="text-align: right"><?php echo number_format(num($tot_month_m),0,".",".") ?></span></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tot_month_p_last) ?></strong></td>
                  <td style="text-align: right" ><strong><span style="text-align: right"><?php echo number_format(num($tot_month_m_last),0,".",".") ?></span></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tot_diff_month_p) ?></strong></td>
                  <td style="text-align: right" ><strong><span style="text-align: right"><?php echo number_format(num($tot_diff_month_m),0,".",".") ?></span></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tot_year_p) ?></strong></td>
                  <td style="text-align: right" ><strong><span style="text-align: right"><?php echo number_format(num($tot_year_m),0,".",".") ?></span></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tot_year_p_last) ?></strong></td>
                  <td style="text-align: right" ><strong><span style="text-align: right"><?php echo number_format(num($tot_year_m_last),0,".",".") ?></span></strong></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><strong><?php echo e($tot_diff_year_p) ?></strong></td>
                  <td style="text-align: right" ><strong><span style="text-align: right"><?php echo number_format(num($tot_diff_year_m),0,".",".") ?></span></strong></td>
                  </tr>
               
            
                </tbody>
                <tfoot>
                </tfoot>
              </table>
           

            <!-- /.box-body -->
    
      <!-- /.content -->

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
