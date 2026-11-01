<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2017-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_val('kd_cbg', 'get');

if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdcl = in_val('kdcl', 'get');
$kdprg = in_val('kdprg', 'get');
$nmprg = in_val('nmprg', 'get');
$query_nmprg = q_set($__p_query_nmprg, "select kode_program from vip_teacher_schedule where kelas = ? and kd_branch = ? group by kelas", [(string) ($kdcl), (string) ($kd_cbg)]);
$resource_nmprg = db_query_soft($query_nmprg, $__p_query_nmprg ?? []);			
if(num(db_num_rows($resource_nmprg)) > 0)
	{
	while ($row_nmprg  =  db_fetch($resource_nmprg, PDO::FETCH_NUM))
		{
		$nmprg = $row_nmprg[0];	
		}
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
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
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
<body onload="window.print();">
  <div class="content">

          <!-- /.box -->


		<div class="form-group">
	      <p>
		        <label>Class Code : <?php echo e($kdcl) ?></label>
		        <input type="text" name="kd_cbg" id="textfield5" value=<?php echo e($kd_cbg) ?> hidden>
		        <br>
	        <input type="text" name="kdprg" id="textfield" value=<?php echo e($kdprg) ?> hidden></input>
	        <input type="text" name="kd_cbg" id="textfield3" value=<?php echo e($kd_cbg) ?> hidden>
	      </p>
	      <p><label>SCORE RECORD and TEACHER'S COMMENT</label></p>		</div>
        <table class="table table-striped" border="1" cellpadding="1" cellspacing="0">
		        <thead>
	      <tr style="background-color: yellow">
	        <td width=17% rowspan="2" align=center style="background-color: yellow" >Student Name</td>
	        <td height="14" colspan="5" align=center >Placement Score</td>
	        <td width="12%" rowspan="2" align=center >Class Attendance</td>
	        <td width="12%" rowspan="2" align=center >Tutorial/LC Record</td>
	        <td colspan="5" align=center >Mid Test Score</td>
	        <td colspan="5" align=center >Final Test Score</td>
	        <td width="12%" rowspan="2" align=center >Score <br>
	          Improvement</td>
	        </tr>
	      <tr style="background-color: yellow">
	        <td width="5%" height="14" align=center class="style24">LPT </td>
	        <td width="5%" align=center class="style24">RPT</td>
	        <td width="5%" align=center class="style24">SPT</td>
	        <td width="5%" align=center class="style24">WPT</td>
	        <td width="5%" align=center class="style24">TTL</td>
	        <td width="5%" align=center class="style24">L1</td>
	        <td width="5%" align=center class="style24">R1</td>
	        <td width="5%" align=center class="style24">S1</td>
	        <td width="5%" align=center class="style24">W1</td>
	        <td width="5%" align=center class="style24">TTL</td>
	        <td width="5%" align=center class="style24">LA</td>
	        <td width="5%" align=center class="style24">RA</td>
	        <td width="5%" align=center class="style24">SA</td>
	        <td width="5%" align=center class="style24">WA</td>
	        <td width="5%" align=center class="style24">TTL</td>
	        </tr>					
        </thead>
	    <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   /* echo $query_billing (debug SQL versi lama) dihapus */
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	    <tbody>
	      <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc" ;
			$i=0;
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc" ;
					
$query_billing = q_set($__p_query_billing, "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where  a.kd_class = ?  group by a.kd_billing order by a.dt_entry desc", [(string) ($kdcl)]);					

$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{


		//$query_score = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_inc.tb_acd_history t where t.kd_biodata =  '$row_billing[7]' and  total <> ''  order by test_date desc limit 1";
		$query_score= q_set($__p_query_score, "select L,other,S,R,W,total,no from ves_data.vip_class_score_profile where kd_biodata =  ? and jns_test = 1 order by no desc limit 1", [(string) ($row_billing[7])]);		
		$resource_score = db_query_soft($query_score, $__p_query_score ?? []);
		$keluar_score = db_num_rows($resource_score);	
		if(num(db_num_rows($resource_score)) > 0)
			{
			while ($row_score  =  db_fetch($resource_score, PDO::FETCH_NUM))	
				{
				$l_pt = $row_score[0];	
				$st_pt = $row_score[1];	
				$sp_pt = $row_score[2];	
				$r_pt = $row_score[3];	
				$w_pt = $row_score[4];						
				$ttl_pt = $row_score[5];
				$nomor_pt = $row_score[6];						
				$adascore = 1;
				}
			}
		$query_score_mid = q_set($__p_query_score_mid, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '2' order by test_date desc limit 1", [(string) ($row_billing[7]), (string) ($row_billing[11])]);
		$resource_score_mid = db_query_soft($query_score_mid, $__p_query_score_mid ?? []);
		$keluar_score_mid = db_num_rows($resource_score_mid);	
		if(num(db_num_rows($resource_score_mid)) > 0)
			{
			while ($row_score_mid  =  db_fetch($resource_score_mid, PDO::FETCH_NUM))	
				{
				$l_mid = $row_score_mid[0];	
				$st_mid = $row_score_mid[1];	
				$sp_mid = $row_score_mid[2];	
				$r_mid = $row_score_mid[3];	
				$w_mid = $row_score_mid[4];						
				$ttl_mid = $row_score_mid[5];
				$nomor_mid = $row_score_mid[6];	
				$adascore_mid = 1;
				}
			}
		$query_score_final = q_set($__p_query_score_final, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1", [(string) ($row_billing[7]), (string) ($row_billing[11])]);
		$resource_score_final = db_query_soft($query_score_final, $__p_query_score_final ?? []);
		$keluar_score_final = db_num_rows($resource_score_final);	
		if(num(db_num_rows($resource_score_final)) > 0)
			{
			while ($row_score_final  =  db_fetch($resource_score_final, PDO::FETCH_NUM))	
				{
				$l_final = $row_score_final[0];	
				$st_final = $row_score_final[1];	
				$sp_final = $row_score_final[2];	
				$r_final = $row_score_final[3];	
				$w_final = $row_score_final[4];						
				$ttl_final = $row_score_final[5];
				$nomor_final = $row_score_final[6];						
				$adascore_final = 1;
				}
			}
		$query_komen = q_set($__p_query_komen, "SELECT keterangan,l,r,s,w,other, nilai_ttl,target_score FROM ves_data.vip_student_comment  where kd_cbg = ? and kd_cl = ? and kd_biodata = ? ", [(string) ($kd_cbg), (string) ($kdcl), (string) ($row_billing[7])]);
		$resource_komen = db_query_soft($query_komen, $__p_query_komen ?? []);	
		if(num(db_num_rows($resource_komen)) > 0)
			{
			while ($row_komen  =  db_fetch($resource_komen, PDO::FETCH_NUM))	
				{
				$komen = $row_komen[0];
				$l = $row_komen[1];
				$r = $row_komen[2];
				$s = $row_komen[3];
				$w = $row_komen[4];
				$o = $row_komen[5];					
				$int_ttl = $row_komen[6];					
				$target_score = $row_komen[7];					
					
				}
			}
	?>

	      <tr>
	        <td height="14" align=left class="style24"><strong><?php echo e($row_billing[6]) ?></strong>
  <input type="text" name="textfield" id="textfield2" value=<?php echo e($kdprg) ?> hidden>	          
  <input type="text" name="kd_biodata<?php echo e($i) ?>" id="textfield4" value=<?php echo e($row_billing[7]); ?> hidden>	          <br></td>
	        <td align=center class="style24"><?php echo e($l_pt) ?></td>
	        <td align=center class="style24"><?php echo e($r_pt) ?></td>
	        <td align=center class="style24"><?php echo e($sp_pt) ?></td>
	        <td align=center class="style24"><?php echo e($w_pt) ?></td>
	        <td align=center class="style24"><?php echo e($ttl_pt) ?></td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24"><?php echo e($l_mid) ?></td>
	        <td align=center class="style24"><?php echo e($r_mid) ?></td>
	        <td align=center class="style24"><?php echo e($sp_mid) ?></td>
	        <td align=center class="style24"><?php echo e($w_mid) ?></td>
	        <td align=center class="style24"><?php echo e($ttl_mid) ?></td>
	        <td align=center class="style24"><?php echo e($l_final) ?></td>
	        <td align=center class="style24"><?php echo e($r_final) ?></td>
	        <td align=center class="style24"><?php echo e($sp_final) ?></td>
	        <td align=center class="style24"><?php echo e($w_final) ?></td>
	        <td align=center class="style24"><?php echo e($ttl_final) ?></td>
	        <td align=center class="style24">View</td>
	        </tr>
	      <tr>
	        <td height="4" align=left class="style24">
	          
	          <div class="col-md-10">
	          <div class="form-group">
Comment
	            
	            </div>
	          <br></td>
	        <td height="4" colspan="18" align=left class="style24"><?php echo e($komen) ?></td>
	        </tr>
	      <?php $l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';$l = '0.0';$r = '0.0';$s = '0.0';$w = '0.0';$o = '0.0';$int_ttl = '0.0'; $target_score = '0.0';$i++;}} ?>
        </tbody>
    </table>


<!-- /.row --><!-- /.content -->
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
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.loleftcation = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
	