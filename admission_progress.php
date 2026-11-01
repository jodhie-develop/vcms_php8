<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$kd_cbg = in_val('kd_cbg', 'get');
if ($kd_cbg == 'National'){$kd_cbg = 100;}

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang'){$kd_cbg = 8;}
if ($kd_cbg == 'East Area'){$kd_cbg = 101;}
if ($kd_cbg == 'West Area'){$kd_cbg = 102;}
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}


if (num($kd_cbg) ==100){$cabang = 'National';}
if ($kd_cbg ==''){$cabang = 'National';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang';}
if (num($kd_cbg) ==101){$cabang = 'East Area';}
if (num($kd_cbg) ==102){$cabang = 'West Area';}
if (num($kd_cbg) ==11){$cabang = 'PIK';}
$q = in_val('q', 'get');

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;

$awal_period = "2020-01-01";

function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
}

if ($kd_cbg == '100' or $kd_cbg == '' ){$filter_cbg = '';}else {$filter_cbg = q_set($__p_filter_cbg, " kd_branch = ? ", [(string) ($kd_cbg)]);}
$flt_status = in_val('flt_status', 'get');
if($flt_status == '' or $flt_status =='ALL')
	{
	$flt_status = 'ALL';
	$cari_status = q_set($__p_cari_status, "  ((final_status = 'L' and comm_date >= ? and aktif = 1 )\r
\tor (final_status = 'Ll' and comm_date >= ?  and aktif = 1 )\r
or (final_status = 'ON' and tgl_intake  >= ? and aktif = 1)\r
or (final_status = 'PR' and a.update_date  >= ? and aktif = 1)\r
or (final_status = 'C' and a.update_date   >= ? )\r
or (final_status = 'PDO' and tgl_intake   >= ? and aktif = 1)\r
)", [(string) ($awal_period), (string) ($awal_period), (string) ($awal_period), (string) ($awal_period), (string) ($awal_period), (string) ($awal_period)]);
	}
elseif($flt_status =='ON')
	{
	$cari_status = q_set($__p_cari_status, "  ((final_status = 'ON'  and aktif = 1 ))");
	}
elseif($flt_status =='PR')
	{
	$cari_status = q_set($__p_cari_status, "  ((final_status = 'PR'  and aktif = 1 ))");
	}
elseif($flt_status =='L')
	{
	$cari_status = q_set($__p_cari_status, "  ((final_status = 'L' and comm_date  >= ? ))", [(string) ($awal_period)]);
	}
elseif($flt_status =='Ll')
	{
	$cari_status = q_set($__p_cari_status, "  ((final_status = 'Ll' and comm_date  >= ? ))", [(string) ($awal_period)]);
	}
elseif($flt_status =='C')
	{
	$cari_status = q_set($__p_cari_status, "  ((final_status = 'C' and a.update_date  >= ? ))", [(string) ($awal_period)]);
	}
elseif($flt_status =='PDO')
	{
	$cari_status = q_set($__p_cari_status, "  ((final_status = 'PDO' and a.tgl_intake  >= ? and aktif = 1))", [(string) ($awal_period)]);
	}
if($filter_cbg <>''){$cari_status = q_set($__p_cari_status, " and " . $cari_status . " ", [...($__p_cari_status ?? [])]);}
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
 <?php    include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=""> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Admission List<br>
     </h1>
     <div class="col-md-12"></div>
   </section><!-- Main content --><span class="col-md-12">
   <?php
$awal_y0 = "2021-01-01";
$mulai_int = $awal_y0;	  
$awal_y0 = strtotime($awal_y0);
$akhir_y0 = "2021-12-31";
$akhir_y0 = strtotime($akhir_y0);
$awal_y1 = "2020-01-01";
$awal_y1 = strtotime($awal_y1);
$akhir_y1 = "2020-12-31";
$akhir_y1 = strtotime($akhir_y1);
$awal_y2 = "2019-01-01";
$awal_y2 = strtotime($awal_y2);
$akhir_y2 = "2019-12-31";
$akhir_y2 = strtotime($akhir_y2);
$awal_y3 = "2018-01-01";
$awal_y3 = strtotime($awal_y3);
$akhir_y3 = "2018-12-31";
$akhir_y3 = strtotime($akhir_y3);
$awal_y4 = "2017-01-01";
$awal_y4 = strtotime($awal_y4);
$akhir_y4 = "2017-12-31";
$akhir_y4 = strtotime($akhir_y4);


      	$query_twi = q_set($__p_query_twi, "SELECT\r
a.no, a.kd_biodata, a.nama, a.enroll_date, a.dest_country, a.dest_school, program_clasifie,  a.major,  a.p_np, b.grade, a.h_nh, a.ar,a.mp_ap, b.grade, (case when a.final_status = 'ON' then 1 end) as st_on,(case when a.final_status = 'PR' then 1 end) as st_pr,(case when a.final_status = 'PDO' then 1 end) as st_pdo,(case when a.final_status = 'L' then 1 end) as st_L,(case when a.final_status = 'C' then 1 end) as st_C,(case when a.final_status = 'Ll' then 1 end) as st_1l,  step, a.remark, tgl_intake, adm_pic,tf_full_program,date_format(enroll_date, '%d %b %y'),a.update_date,date_format(a.enroll_date,'%y%m%d') FROM adm_stu_progress a left join tb_master_partner b on a.dest_country  = b.country and a.dest_school = b.school where  " . $filter_cbg . " " . $cari_status . " group by a.kd_biodata, a.enroll_date order by a.no desc", [...($__p_filter_cbg ?? []), ...($__p_cari_status ?? [])]);

	  $_SESSION['query_xl'] =  $query_twi; $_SESSION['query_xl__p'] = $__p_query_twi ?? [];
	  
$result_twi=db_query_or_die("Wah error nih! 1", $query_twi, $__p_query_twi ?? []);
$no_urut_week ="1";
$jml_data = db_num_rows($result_twi);
 		?>
   </span>
<input type="submit" name="new" value="New Progress" />
<input type="submit" name="reset" value="Reset Data" />
  <div class="row">
  <br>
  <div class="col-xs-4"> <span class="form-group"> Center :
    <select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
      <option value="0">--CHOOSE--</option>
      <option value="1">East Sby</option>
      <option value="2">West Sby</option>
      <option value="3">Denpasar</option>
      <option value="8">Malang</option>
      <option value="101">East Area</option>
      <option value="4">South Jkt</option>
      <option value="5">North Jkt</option>
      <option value="11">PIK</option>		
      <option value="6">West Jkt</option>
      <option value="7">Bandung</option>
      <option value="102">West Area</option>
      <option value="100">National</option>
      <option selected="selected"><?php echo e($cabang) ?></option>
    </select>
  </span> </div>
               <div class="col-xs-2">
      </div>
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <label>Count : <?php echo e($jml_data) ?></label> 
            <div class="box-body">
              <table width="87%" class="table table-bordered table-striped" id="example1"> 
<thead>
   <tr>
     <td width=41 rowspan="3" align=center >No</td>
     <td width=63 rowspan="3" align=center >Nama</td>
     <td width=65 rowspan="3" align=center >Enroll Date </td>
     <td width="63" rowspan="3" align=center >Sales Year</td>
     <td height="14" colspan="3" align=center >Destination</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" colspan="6" align=center >Admission Status<br>
       <span class="style92" style="color: #FFFFFF">
       <select class="form-control" name="flt_status" onChange="this.form.submit()" >
         <option>ALL</option>
         <?php
								$query_inst = q_set($__p_query_inst, "SELECT \r
distinct a.final_status FROM adm_stu_progress a where aktif = 1 order by a.no desc");
		   
								$resource_inst = db_query_or_die('errro_7', $query_inst, $__p_query_inst ?? []);
								while ($row_inst=  db_fetch($resource_inst, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_inst[0]).'">'.e($row_inst[0]).'</option>';
							  		}      ?>
         <option selected><?php echo  e($flt_status) ?></option>
       </select>
       </span></td>
     <td height="14" colspan="3" align=center >Admission Progress Log</td>
     <td width="58" rowspan="3" align=center >Intake Date</td>
     <td width="35" rowspan="2" align=center >AC</td>
     <td width="59" rowspan="3" align=center >Tuition Info </td>
     <td width="59" rowspan="3" align=center >Last Update</td>
     </tr>
   <tr>
     <td width="74" rowspan="2" align=center >Country</td>
     <td width="74" rowspan="2" align=center >School </td>
     <td width="78" rowspan="2" align=center >Program</td>
     <td width="38" rowspan="2" align=center >P<br>
     /NP</td>
     <td width="58" rowspan="2" align=center >H<br>
       /AD<br>
       /STEM<br>
     /NON</td>
     <td width="33" rowspan="2" align=center ><p>N/</p>
       <p>R/</p>
       <p>A</p></td>
     <td width="52" rowspan="2" align=center >Main<br>
       /Ad<br>
     /Lang</td>
     <td width="42" rowspan="2" align=center >Star</td>
     <td width="40" rowspan="2" align=center >ON </td>
     <td width="35" rowspan="2" align=center >PR</td>
     <td width="46" rowspan="2" align=center >PDO</td>
     <td width="33" rowspan="2" align=center >L</td>
     <td width="33" rowspan="2" align=center ><p>C</p>
       <p>&nbsp;</p></td>
     <td width="33" rowspan="2" align=center >1L</td>
     <td width="49" rowspan="2" align=center > Step </td>
     <td width="69" rowspan="2" align=center > Remark </td>
     <td width="56" rowspan="2" align=center >Next Follow<br>
       Up </td>
   </tr>
   <tr>
     <td height="14" align=center >SC</td>
     </tr></thead><tbody>
<?php
   if ($result_twi) 
	{ 
	
	while ($r_dtl = db_fetch($result_twi))
		{
		$enroll_convert= strtotime($r_dtl[3]);
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

		if (substr($r_dtl[13],0,2) == 'ON')
		{
		$grd = '1';
		}
		elseif (substr($r_dtl[13],0,2) == 'TW')
		{
		$grd = '2';

		}
		elseif (substr($r_dtl[13],0,2) == 'TH')
		{
		$grd = '3';

		}
		elseif (substr($r_dtl[13],0,2) == 'FO')
		{
		$grd = '4';

		}

		elseif (substr($r_dtl[13],0,2) == 'FI')
		{
		$grd = '5';

		}	
		else
		{$grd = '1';}
				  ?>
     <tr>
     <td align=center  class="style49"><?php echo e($no_urut_week) ?></td>
     <td align=left  class="style49"><a href="stuadmprogress.php?kdb=<?php echo e(u($r_dtl[1])); ?>&st=1&asal=1&no=<?php echo e(u($r_dtl[0])) ?>"><?php echo e($r_dtl[2]) ?><br></a>
		 <a href="stuadmsoa.php?kdb=<?php echo e(u($r_dtl[1])); ?>&ed=<?php echo e(u($r_dtl[27])) ?>">SOA</a><br></td>
     <td align=center  class="style49"><?php echo e($r_dtl[25]) ?></td>
     <td  width="63"  align=center  class="style49"><?php echo e($kode_thn) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[4]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[5]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[6]) ?><br>
       <?php echo e($r_dtl[7]) ?>     
     <td align=center  class="style49"><?php echo e($r_dtl[8]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[10]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[11]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[12]) ?></td>
     <td align=center  class="style49"><?php echo e($grd) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[14]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[15]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[16]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[17]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[18]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[19]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[20]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[21]) ?></td>
     <td align=center  class="style49">&nbsp;</td>
     <td align=center  class="style49"><?php echo e($r_dtl[22]) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[23]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[24]) ?></td>
     <td align=center  class="style49"><?php echo e($r_dtl[26]) ?></td>
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
            <div class="box-body">
            <input type="submit" name="Export" value="Export" />
		    </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>

      <!-- /.row -->
   </section>
   <section class="content">
      <div class="row">
        <!-- /.col -->
     </div></div>

     <!-- /.row -->
   </section>
   
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
<?php
if (isset($_GET['new'])) 
{
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('prestuadmprogress.php');\n";				
		echo "</script>";}
if (isset($_GET['reset'])) 
{
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('admission_progress.php');\n";				
		echo "</script>";
}
if (isset($_GET['Export'])) 
{
echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('admxl.php');\n";				
		echo "</script>";
}
?>