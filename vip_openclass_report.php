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
$sql = q_set($__p_sql, "SELECT min(detail), max(detail),date_format(detail,'%Y-%m') ,date_format(detail,'%Y')FROM ves_data.tb_minggu_detail where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);

$rs = db_query_soft($sql, $__p_sql ?? []);
while($row = db_fetch($rs))
{
	$awal_mgg= $row[0];
	$akhir_mgg = $row[1];
	$last_year_akhir_mgg = num(substr($akhir_mgg,0,4)) - 1;
	$last_year_akhir_tgl = substr($akhir_mgg,5,5);
	
	$dtl_bln = $row[2];
	$dtl_thn = $row[3];
	
	$awal_bln = "$dtl_bln-01";
	$awal_thn = "$dtl_thn-01-01";
	$last_thn = num($dtl_thn)-1;
	$awal_last_year = "$last_thn-01-01";	
	
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
 <form method=get action=vip_openclass_report.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>VIP Open Class Summary<br>
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
$result=db_query_or_die("Wah error nih111", $query, $__p_query ?? []);
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
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th colspan="3" style="text-align: center">Weekly</th>
                  <th colspan="3" style="text-align: center">Monthly</th>
                  <th colspan="3" style="text-align: center">Yearly</th>
                  <th colspan="3" style="text-align: center">Last Year</th>
                  <th colspan="3" style="text-align: center">Different</th>
                  </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th width="3%" rowspan="2" style="text-align: center">PAX</th>
                  <th colspan="2" style="text-align: center">Class</th>
                  <th width="3%" rowspan="2" style="text-align: center">PAX</th>
                  <th colspan="2" style="text-align: center">Class</th>
                  <th width="3%" rowspan="2" style="text-align: center">PAX</th>
                  <th colspan="2" style="text-align: center">Class</th>
                  <th width="3%" rowspan="2" style="text-align: center">PAX</th>
                  <th colspan="2" style="text-align: center">Class</th>
                  <th width="3%" rowspan="2" style="text-align: center">PAX</th>
                  <th colspan="2" style="text-align: center">Class</th>
                  </tr>
                <tr style="font-size: 1em">
                  <th width="3%">No</th>
                  <th width="15%">Center</th>
                  <th width="2%">Private</th>
                  <th width="3%">Reguler</th>
                  <th width="2%">Private</th>
                  <th width="3%">Reguler</th>
                  <th width="2%">Private</th>
                  <th width="3%">Reguler</th>
                  <th width="2%">Private</th>
                  <th width="3%">Reguler</th>
                  <th width="2%">Private</th>
                  <th width="3%">Reguler</th>
                  </tr>
                </thead>
				  </jdl>					  
                <tbody>

				  <?php 
					$query_cabang = q_set($__p_query_cabang, "select kd_branch from vip_teacher_schedule where mulai_tm between ? and ? group by kd_branch ORDER BY FIELD(kd_branch,'00','1','2','3','4','5','11','6','7','8','100','351')", [(string) ($awal_thn), (string) ($akhir_mgg)]);
					$result_cabang=db_query_or_die("Wah error nih112", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$kd_branch = $r_cbg[0];
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
elseif ($kd_branch == '100'){$nama_cabang = 'Online';}	

//====== weekly start														
$query_oc_w = q_set($__p_query_oc_w, "SELECT count(case when type_program = 'REG' then 1 end)as reg, count(case when type_program != 'REG' then 1 end)as nonreg FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where a.kd_branch = ? and f.min_mulai between ? and ?\r
 and a.status_kelas = 1 order by mulai_tm", [(string) ($kd_branch), (string) ($awal_mgg) . " 00:00:00", (string) ($akhir_mgg) . " 23:00:00"]);
$result_oc_w=db_query_or_die("Wah error nih113", $query_oc_w, $__p_query_oc_w ?? []);
	if ($result_oc_w) 
		{ 
		while ($roc_w = db_fetch($result_oc_w))
			{
			$class_reg_w = $roc_w[0];
			$class_pri_w = $roc_w[1];
			}
		}
$query_px_w = q_set($__p_query_px_w, "SELECT count(kd_billing) FROM ves_data.vip_teacher_schedule a left join ves_data.vip_billing g on a.kelas = g.kd_class INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where a.kd_branch = ? and f.min_mulai between ? and ?  and a.status_kelas = 1 order by mulai_tm", [(string) ($kd_branch), (string) ($awal_mgg) . " 00:00:00", (string) ($akhir_mgg) . " 23:00:00"]);
$result_px_w=db_query_or_die("Wah error nih114", $query_px_w, $__p_query_px_w ?? []);
	if ($result_px_w) 
		{ 
		while ($rpx_w = db_fetch($result_px_w))
			{
			$pax_w = $rpx_w[0];
			}
		}							
//====== weekly end													
//====== monthly start
$query_oc_m = q_set($__p_query_oc_m, "SELECT count(case when type_program = 'REG' then 1 end)as reg, count(case when type_program != 'REG' then 1 end)as nonreg FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where a.kd_branch = ? and f.min_mulai between ? and ?\r
 and a.status_kelas = 1 order by mulai_tm", [(string) ($kd_branch), (string) ($awal_bln) . " 00:00:00", (string) ($akhir_mgg) . " 23:00:00"]);
$result_oc_m=db_query_or_die("Wah error nih115", $query_oc_m, $__p_query_oc_m ?? []);
	if ($result_oc_m) 
		{ 
		while ($roc_m = db_fetch($result_oc_m))
			{
			$class_reg_m = $roc_m[0];
			$class_pri_m = $roc_m[1];
			}
		}
$query_px_m = q_set($__p_query_px_m, "SELECT count(kd_billing) FROM ves_data.vip_teacher_schedule a left join ves_data.vip_billing g on a.kelas = g.kd_class INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where a.kd_branch = ? and f.min_mulai between ? and ?  and a.status_kelas = 1 order by mulai_tm", [(string) ($kd_branch), (string) ($awal_bln) . " 00:00:00", (string) ($akhir_mgg) . " 23:00:00"]);
$result_px_m=db_query_or_die("Wah error nih116", $query_px_m, $__p_query_px_m ?? []);
	if ($result_px_m) 
		{ 
		while ($rpx_m = db_fetch($result_px_m))
			{
			$pax_m = $rpx_m[0];
			}
		}
							
//====== monthly end
//====== yearly start	
$query_oc_y = q_set($__p_query_oc_y, "SELECT count(case when type_program = 'REG' then 1 end)as reg, count(case when type_program != 'REG' then 1 end)as nonreg FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where a.kd_branch = ? and f.min_mulai between ? and ?\r
 and a.status_kelas = 1 order by mulai_tm", [(string) ($kd_branch), (string) ($awal_thn) . " 00:00:00", (string) ($akhir_mgg) . " 23:00:00"]); 
$result_oc_y=db_query_or_die("Wah error nih117", $query_oc_y, $__p_query_oc_y ?? []);
	if ($result_oc_y) 
		{ 
		while ($roc_y = db_fetch($result_oc_y))
			{
			$class_reg_y = $roc_y[0];
			$class_pri_y = $roc_y[1];
			}
		}
$query_px_y = q_set($__p_query_px_y, "SELECT count(kd_billing) FROM ves_data.vip_teacher_schedule a left join ves_data.vip_billing g on a.kelas = g.kd_class INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where a.kd_branch = ? and f.min_mulai between ? and ?  and a.status_kelas = 1 order by mulai_tm", [(string) ($kd_branch), (string) ($awal_thn) . "  00:00:00", (string) ($akhir_mgg) . " 23:00:00"]);
$result_px_y=db_query_or_die("Wah error nih118", $query_px_y, $__p_query_px_y ?? []);
	if ($result_px_y) 
		{ 
		while ($rpx_y = db_fetch($result_px_y))
			{
			$pax_y = $rpx_y[0];
			}
		}
							
//====== yearly end
//====== last year start
$query_oc_ly = q_set($__p_query_oc_ly, "SELECT count(case when type_program = 'REG' then 1 end)as reg, count(case when type_program != 'REG' then 1 end)as nonreg FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where a.kd_branch = ? and f.min_mulai between ? and ?\r
 and a.status_kelas = 1 order by mulai_tm", [(string) ($kd_branch), (string) ($awal_last_year) . " 00:00:00", (string) ($last_year_akhir_mgg) . "-" . (string) ($last_year_akhir_tgl) . " 23:00:00"]); 
$result_oc_ly=db_query_or_die("Wah error nih117", $query_oc_ly, $__p_query_oc_ly ?? []);
	if ($result_oc_ly) 
		{ 
		while ($roc_ly = db_fetch($result_oc_ly))
			{
			$class_reg_ly = $roc_ly[0];
			$class_pri_ly = $roc_ly[1];
			}
		}
$query_px_ly = q_set($__p_query_px_ly, "SELECT count(kd_billing) FROM ves_data.vip_teacher_schedule a left join ves_data.vip_billing g on a.kelas = g.kd_class INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1 GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai where a.kd_branch = ? and f.min_mulai between ? and ?  and a.status_kelas = 1 order by mulai_tm", [(string) ($kd_branch), (string) ($awal_last_year) . "  00:00:00", (string) ($last_year_akhir_mgg) . "-" . (string) ($last_year_akhir_tgl) . " 23:00:00"]);
$result_px_ly=db_query_or_die("Wah error nih118", $query_px_ly, $__p_query_px_ly ?? []);
	if ($result_px_ly) 
		{ 
		while ($rpx_ly = db_fetch($result_px_ly))
			{
			$pax_ly = $rpx_ly[0];
			}
		}
										
//====== last year end
							
//--diferent
$pax_diff = num($pax_y) - num($pax_ly);
$oc_p_dif = num($class_pri_y) - num($class_pri_ly);							
$oc_r_dif = num($class_reg_y) - num($class_reg_ly);							


				?>               
					
                <tr>
                  <td height="20"><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($nama_cabang) ; ?>
                  <input type="hidden" name="kd_branch" id="textfield" value="<?php echo e($kd_branch) ?>"></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($pax_w) ; ?></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_pri_w) ; ?></span></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_reg_w) ; ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($pax_m) ; ?></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_pri_m) ; ?></span></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_reg_m); ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($pax_y) ; ?></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_pri_y) ; ?></span></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_reg_y); ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($pax_ly) ; ?></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_pri_ly) ; ?></span></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_reg_ly); ?></span></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($pax_diff) ; ?></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($oc_p_dif) ; ?></span></td>
                  <td style="text-align: right" ><span style="text-align: center"><?php echo e($oc_r_dif); ?></span></td>
                  </tr>
                <?php $no_urut = num($no_urut)+1;$class_pri_w='';$class_reg_w ='';  } } ?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
              <table width="97%" class="table table-hover" id="example1">
                <jdl>
                  <thead>
                    <tr>
                      <th width="3%">&nbsp;</th>
                      <th width="15%">&nbsp;</th>
                      <th colspan="3" style="text-align: center">Weekly</th>
                      <th colspan="3" style="text-align: center">&nbsp;</th>
                      <th colspan="2" style="text-align: center">&nbsp;</th>
                      <th colspan="2" style="text-align: center">&nbsp;</th>
                      <th colspan="2" style="text-align: center">&nbsp;</th>
                    </tr>
                    <tr>
                      <th>&nbsp;</th>
                      <th>&nbsp;</th>
                      <th style="text-align: center">PAX</th>
                      <th colspan="2" style="text-align: center">Class</th>
                      <th style="text-align: center">PAX</th>
                      <th colspan="2" style="text-align: center">Class</th>
                      <th colspan="2" style="text-align: center">Yearly</th>
                      <th colspan="2" style="text-align: center">Last Year</th>
                      <th colspan="2" style="text-align: center">Different </th>
                    </tr>
                    <tr style="font-size: 1em">
                      <th colspan="2">&nbsp;</th>
                      <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                      <th width="2%">Private</th>
                      <th width="3%">Reguler</th>
                      <th width="3%" bgcolor="#C2C2C2" style="text-align: center">Pax</th>
                      <th width="2%">Private</th>
                      <th width="3%">Reguler</th>
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

                  <tr>
                    <td height="20" colspan="2"><strong>TOTAL</strong></td>
                    <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($pax_w) ; ?></td>
                    <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_pri_w) ; ?></span></td>
                    <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_reg_w) ; ?></span></td>
                    <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($pax_m) ; ?></td>
                    <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_pri_m) ; ?></span></td>
                    <td style="text-align: right" ><span style="text-align: center"><?php echo e($class_reg_m); ?></span></td>
                    <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_cl_w) ; ?></td>
                    <td style="text-align: right"><?php echo   number_format(num($reg_amount_cl_w),0,".",".")  ; ?></td>
                    <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($reg_pax_m) ; ?></td>
                    <td style="text-align: right"><?php echo   number_format(num($reg_amount_m),0,".",".")  ; ?></td>
                    <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($tf_pax_m); ?></td>
                    <td><?php echo   number_format(num($tf_amount_m),0,".",".")  ; ?></td>
                  </tr>

                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <div class="box">
              <div class="box-body">
                <label>TOTAL INCOME : Rp. <?php echo number_format(num($total_rp),0,".",".")  ; ?></label>
              </div>
            </div>
            <div class="box">
         	<div class="box-body">
         		<label>Checked by <?php echo e($nama_lengkap) ?></label><input type="submit" name="Submit" value="Submit" />
         	</div>
         </div>
            <!-- /.box-body -->
          </div><a href="rpt_vip_inc.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a><a href="vip_receiptxl.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a>
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
