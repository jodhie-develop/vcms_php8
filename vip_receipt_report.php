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
    .table td, .table th {
        font-size: 10px;
    }
</style>	
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_receipt_report.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>VIP Income Summary<br>
     </h1>
     <?php 
 if ($cabang =='National')
	{
	$query = q_set($__p_query, "SELECT kd_branch  FROM vip_billing_payment a  where a.id_receipt <> '' \r
\tand dt_payment between ? and ? group by kd_branch order by kd_branch", [(string) ($date_start), (string) ($date_end)]);		
	}
else
	{
	$query = q_set($__p_query, "SELECT kd_branch  FROM vip_billing_payment a  where a.id_receipt <> '' \r
\tand dt_payment between ? and ? and kd_branch = ? group by kd_branch order by kd_branch", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);			
	}
$total_rp = 0;
$no_urut = 1;
$result=db_query_or_die("Wah error nih11", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         
         <tr>
           <th width="11%" scope="row">Week</th>
           <td width="89%"><select name="week"  onChange="this.form.submit()"  class="style33" id="nmr_minggu">
			 <?php
			$sql = q_set($__p_sql, "select minggu, no_week from master_date where sales_year = ? group by minggu order by no_week ", [(string) ($sales_year)]);
			$rs = db_query_soft($sql, $__p_sql ?? []);
			while($row = db_fetch($rs))
			{
			  echo "<option value=\"".e($row['minggu'])."\">".e($row['minggu'])."</option>\n  ";
			}
			?>             
	 	<option selected><?php echo e($week) ?></option>
            </select></td>
         </tr>
         <tr>
           <th scope="row">Period Date</th>
           <td>
             <?php echo e($awal_mgg) ?> to <?php echo e($akhir_mgg) ?>
</td>
         </tr>
       </tbody>
     </table>
   

   </section>


<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
		
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-hover" id="example1">
				  <jdl>
                <thead>
                <tr>
                  <th colspan="8"><strong>Period : <?php echo e($awal_tampil) ?> to <?php echo e($akhir_tampil) ?></strong></th>
                  <th colspan="6" style="text-align: center">&nbsp;</th>
                  <th colspan="6" style="text-align: center">&nbsp;</th>
                </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="6" style="text-align: center";>Weekly</th>
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
					$query_cabang = q_set($__p_query_cabang, "select kd_branch from vip_billing_payment where dt_cetak between ? and ? group by kd_branch order by kd_branch", [(string) ($awal_mgg), (string) ($akhir_mgg)]);
					$result_cabang=db_query_or_die("Wah error nih11", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$nm_cabang = $r_cbg[0];
							$query_hitung = q_set($__p_query_hitung, "select a.kd_branch,\r
count(case when jns_payment = 'Registration' and dt_payment between ? and ?  and kd_program not like 'CL%'  then 1 end  ) as reg_pax_w,\r
sum(case when jns_payment = 'Registration' and dt_payment between ? and ?  and kd_program not like 'CL%'   then amount end  ) as reg_amount_w,\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_payment between ? and ?  and kd_program not like 'CL%'   then 1 end  ) as tf_pax_w,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_payment between ? and ?  and kd_program not like 'CL%'  then amount end  ) as tf_amount_w,\r
\r
count(case when dt_payment between ? and ?  and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_w,\r
sum(case when dt_payment between ? and ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_w,\r
\r
count(case when jns_payment = 'Registration' and dt_payment between ? and ?  and kd_program not like 'CL%'  then 1 end  ) as reg_pax_m,\r
sum(case when jns_payment = 'Registration' and dt_payment between ? and ?  and kd_program not like 'CL%'  then amount end  ) as reg_amount_m,\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_payment between ? and ?   and kd_program not like 'CL%'  then 1 end  ) as tf_pax_m,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_payment between ? and ?  and kd_program not like 'CL%'  then amount end  ) as tf_amount_m,\r
\r
count(case when dt_payment between ? and ?  and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_m,\r
sum(case when dt_payment between ? and ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_m,\r
\r
\r
count(case when jns_payment = 'Registration' and dt_payment between ? and ?  and kd_program not like 'CL%'  then 1 end  ) as reg_pax_y,\r
sum(case when jns_payment = 'Registration' and dt_payment between ? and ?  and kd_program not like 'CL%'  then amount end  ) as reg_amount_y,\r
count(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_payment between ? and ?  and kd_program not like 'CL%'   then 1 end  ) as tf_pax_y,\r
sum(case when (jns_payment like 'Full%' or  jns_payment like 'Down%' or  jns_payment like 'Inst%')  and dt_payment between ? and ?  and kd_program not like 'CL%'  then amount end  )\r
as tf_amount_y,\r
\r
count(case when dt_payment between ? and ?  and kd_program like 'CL%' then 1 end  ) as reg_pax_cl_y,\r
sum(case when dt_payment between ? and ? and kd_program like 'CL%'   then amount end  ) as reg_amount_cl_y\r
\r
from vip_billing_payment a left join vip_billing b on a.kd_billing = b.kd_billing  where status = 'PAID' and dt_cetak between ? and ? and a.kd_branch = ? ", [(string) ($awal_mgg), (string) ($akhir_mgg), (string) ($awal_mgg), (string) ($akhir_mgg), (string) ($awal_mgg), (string) ($akhir_mgg), (string) ($awal_mgg), (string) ($akhir_mgg), (string) ($awal_mgg), (string) ($akhir_mgg), (string) ($awal_mgg), (string) ($akhir_mgg), (string) ($awal_bln), (string) ($akhir_mgg), (string) ($awal_bln), (string) ($akhir_mgg), (string) ($awal_bln), (string) ($akhir_mgg), (string) ($awal_bln), (string) ($akhir_mgg), (string) ($awal_bln), (string) ($akhir_mgg), (string) ($awal_bln), (string) ($akhir_mgg), (string) ($awal_thn), (string) ($akhir_mgg), (string) ($awal_thn), (string) ($akhir_mgg), (string) ($awal_thn), (string) ($akhir_mgg), (string) ($awal_thn), (string) ($akhir_mgg), (string) ($awal_thn), (string) ($akhir_mgg), (string) ($awal_thn), (string) ($akhir_mgg), (string) ($awal_thn), (string) ($akhir_mgg), (string) ($nm_cabang)]);

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
         	<div class="box-body"></div>
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
