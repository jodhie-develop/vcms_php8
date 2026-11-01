<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
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

if ($kd_cbg == '100' or $kd_cbg == '' ){$filter_cbg = '';}else {$filter_cbg = " kd_branch = '$kd_cbg' ";}
$flt_status = in_val('flt_status', 'get');
if($flt_status == '' or $flt_status =='ALL')
	{
	$flt_status = 'ALL';
	$cari_status = "  ((final_status = 'L' and comm_date >= '$awal_period' and aktif = 1 )
	or (final_status = 'Ll' and comm_date >= '$awal_period'  and aktif = 1 )
or (final_status = 'ON' and tgl_intake  >= '$awal_period' and aktif = 1)
or (final_status = 'PR' and a.update_date  >= '$awal_period' and aktif = 1)
or (final_status = 'C' and a.update_date   >= '$awal_period')
or (final_status = 'PDO' and tgl_intake   >= '$awal_period' and aktif = 1)
)";
	}
elseif($flt_status =='ON')
	{
	$cari_status = "  ((final_status = 'ON'  and aktif = 1 ))";
	}
elseif($flt_status =='PR')
	{
	$cari_status = "  ((final_status = 'PR'  and aktif = 1 ))";
	}
elseif($flt_status =='L')
	{
	$cari_status = "  ((final_status = 'L' and comm_date  >= '$awal_period'))";
	}
elseif($flt_status =='Ll')
	{
	$cari_status = "  ((final_status = 'Ll' and comm_date  >= '$awal_period'))";
	}
elseif($flt_status =='C')
	{
	$cari_status = "  ((final_status = 'C' and a.update_date  >= '$awal_period'))";
	}
elseif($flt_status =='PDO')
	{
	$cari_status = "  ((final_status = 'PDO' and a.tgl_intake  >= '$awal_period' and aktif = 1))";
	}
if($filter_cbg <>''){$cari_status = " and $cari_status ";}
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
      	$query_twi = q_set($__p_query_twi, "select kd_biodata, enroll_date, pic, nama, country, school,program,cabang from tb_sales_report a left join tb_master_partner b on a.kd_school = b.kd_school where school like '%University of British Columbia%'order by enroll_date");

$result_twi=db_query_or_die("Wah error nih! 1", $query_twi, $__p_query_twi ?? []);
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
     <td height="14" align=center >Destination</td>
     <td height="14" align=center >&nbsp;</td>
     <td align=center >Branch</td>
     <td align=center >Nama</td>
     <td align=center >Enroll Date</td>
     <td height="14" align=center >&nbsp;</td>
     <td height="14" align=center >Admission Progress Log</td>
     <td width="58" rowspan="3" align=center >Intake Date</td>
     <td width="35" rowspan="2" align=center >SC</td>
     <td width="59" rowspan="3" align=center >Last Update</td>
     <td width="59" rowspan="3" align=center >Remark</td>
     </tr>
   <tr>
     <td width="74" rowspan="2" align=center >Country</td>
     <td width="74" rowspan="2" align=center >School </td>
     <td width="78" rowspan="2" align=center >&nbsp;</td>
     <td width="78" rowspan="2" align=center >&nbsp;</td>
     <td width="78" rowspan="2" align=center >&nbsp;</td>
     <td width="78" rowspan="2" align=center >Program</td>
     <td width="49" rowspan="2" align=center > Step </td>
     </tr>
   <tr>
     <td height="14" align=center >AC</td>
     </tr></thead><tbody>
<?php $no_urut_week = 1;
   if ($result_twi) 
	{ 
	
	while ($r_dtl = db_fetch($result_twi))
		{
		$query_akhir= q_set($__p_query_akhir, "select final_status, dest_country, dest_school, adm_pic, sc_name,update_date,tgl_intake,step from adm_stu_progress where kd_biodata = ? and enroll_date = ? order by no desc limit 1", [(string) ($r_dtl[0]), (string) ($r_dtl[1])]);
		$resource_akhir = db_query_soft($query_akhir, $__p_query_akhir ?? []);
		if(num(db_num_rows($resource_akhir)) > 0)
			{

			while ($r_akhir=  db_fetch($resource_akhir, PDO::FETCH_NUM))
				{
				$final_status = $r_akhir[0];
				$dest_country = $r_akhir[1];
				$dest_school = $r_akhir[2];
				$adm_pic = $r_akhir[3];
				$sc_name = $r_akhir[4];
				$update_date = $r_akhir[5];
				$tgl_intake = $r_akhir[6];	
								$step = $r_akhir[7];	

				}
			}
		$country = $r_dtl[4];
		$school = $r_dtl[5];
		if ($dest_country ==$country){$dest_country = '';}
		if ($dest_school ==$school){$dest_school = '';}
		
				  ?>
     <tr>
     <td align=center  class="style49"><?php echo e($no_urut_week) ?></td>
     <td align=center  class="style49"><?php echo e($country) ?></td>
     <td align=left  class="style49"><?php echo e($school) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[7]) ?>          
     <td align=left  class="style49"><?php echo e($r_dtl[3]) ?>     
     <td align=left  class="style49"><?php echo e($r_dtl[1]) ?>     
     <td align=left  class="style49"><?php echo e($r_dtl[6]) ?><td align=left  class="style49"><?php echo e($final_status) ?></td>
     <td align=center  class="style49"><?php echo e($tgl_intake) ?></td>
     <td align=left  class="style49"><?php echo e($r_dtl[2]) ?><br>
       <?php echo e($adm_pic)  ?></td>
     <td align=center  class="style49"><?php echo e($update_date) ?></td>
     <td align=center  class="style49"><?php echo e($step) ?><br>
       <?php echo e($dest_school) ?></td>
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