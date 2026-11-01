<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
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
     <form name="form1" method="post" action="#"><?php echo csrf_field(); ?>
 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
<div class="box box-warning">          
	<div class="box-body">
	  <div class="col-md-12">
		<div class="form-group">
	      <p>
		        <label>Class Code : <?php echo e($kdcl) ?></label>
		        <input type="text" name="kd_cbg" id="textfield5" value=<?php echo e($kd_cbg) ?> hidden>
		        <br>
	        <input type="text" name="kdprg" id="textfield" value=<?php echo e($kdprg) ?> hidden></input>
	        <input type="text" name="kd_cbg" id="textfield3" value=<?php echo e($kd_cbg) ?> hidden>
	      </p>
	      <p><label>SCORE RECORD and TEACHER'S COMMENT</label></p>
		      <table width="100%" class="table table-bordered table-striped" id="example12">
		        <thead>
	      <tr>
	        <td width=17% height="14" align=center >Student Name</td>
	        <td width="12%" align=center >Material</td>
	        <td width="12%" align=center >Attendance</td>
	        <td width="12%" align=center >Placement Score</td>
	        <td width="12%" align=center >Mid Test Score</td>
	        <td width="12%" align=center >Final Test Score</td>
	        <td width="12%" align=center >FER</td>
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
		$query_score_final = q_set($__p_query_score_final, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no,t.english,t.math FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1", [(string) ($row_billing[7]), (string) ($row_billing[11])]);
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
				$english = $row_score_final[7];
				$math = $row_score_final[8];
				
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
	        <td align=left class="style24"><strong><?php echo e($row_billing[6]) ?></strong>
<input type="text" name="textfield" id="textfield2" value=<?php echo e($kdprg) ?> hidden>	          
<input type="text" name="kd_biodata<?php echo e($i) ?>" id="textfield4" value=<?php echo e($row_billing[7]); ?> hidden>	          <br></td>
	        <td height="14" align=center class="style24">&nbsp;</td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24"><?php  if (num($adascore) == 1){?>
	          <p>L: <?php echo e($l_pt) ?> St: <?php echo e($st_pt) ?> Sp: <?php echo e($sp_pt) ?> <br>
	            R: <?php echo e($r_pt) ?> W: <?php echo e($w_pt) ?> TTL: <?php echo e($ttl_pt) ?></p>
	          <p>
	            <?php }?>               <a href="vip_scoreupd.php" 
target="popup" 
onclick="window.open('vip_scoreupd.php?no=<?php echo e(u($nomor_pt)); ?>','popup','width=1000,height=800'); return false;">Modify</a>
	            </p></td>
	        <td align=center class="style24"><?php  if (num($adascore_mid) == 1){?>
	          <p>L: <?php echo e($l_mid) ?> St: <?php echo e($st_mid) ?> Sp: <?php echo e($sp_mid) ?> <br>
	            R: <?php echo e($r_mid) ?> W: <?php echo e($w_mid) ?> TTL: <?php echo e($ttl_mid) ?></p>
	          <p>
	            <a href="vip_scoreupd.php" 
target="popup" 
onclick="window.open('vip_scoreupd.php?no=<?php echo e(u($nomor_mid)); ?>','popup','width=1000,height=800'); return false;">Modify</a></p>
	          <?php } else { ?>
	          <a href="vip_score.php" 
target="popup" 
onclick="window.open('vip_score.php?kdb=<?php echo e(u($row_billing[7])); ?>&t=2&kdcl=<?php echo e(u($row_billing[11])) ?>','popup','width=1000,height=800'); return false;">Add</a></p><?php } ?></td>
	        <td align=center class="style24"><?php  if (num($adascore_final) == 1 ){?>
	          <p>L: <?php echo e($l_final) ?> St: <?php echo e($st_final) ?> Sp: <?php echo e($sp_final) ?> <br>
	            R: <?php echo e($r_final) ?> W: <?php echo e($w_final) ?> TTL: <?php echo e($ttl_final) ?></p>
	          <p><a href="vip_scoreupd.php" 
target="popup" 
onclick="window.open('vip_scoreupd.php?no=<?php echo e(u($nomor_final)); ?>','popup','width=1000,height=800'); return false;">Modify</a>
	            <?php }elseif (num($adascore_mid)==1) { ?>
	            <a href="vip_score.php" 
target="popup" 
onclick="window.open('vip_score.php?kdb=<?php echo e(u($row_billing[7])); ?>&t=3&kdcl=<?php echo e(u($row_billing[11])) ?>','popup','width=1000,height=800'); return false;">Add</a></p>
	          <?php } ?></td>
	        <td align=center class="style24">View</td>
	        </tr>
	      <tr>
	        <td height="4" colspan="6" align=left class="style24">

          <div class="col-md-10">
	          <div class="form-group">
	              <label>Comment</label>
	              <br>
	              <textarea class="textarea" placeholder="Place some text here" cols="150" rows="5" name="komen_<?php echo e($i) ?>"><?php echo e($komen) ?></textarea><br>

					 </div>
	          <br></td>
	        <td align=center class="style24">&nbsp;</td>
	        </tr>
	      <tr>
	        <td height="4" colspan="6" align=left class="style24"><div class="form-group">
	          <label>International Test Score</label>
	          <br>

	          <table width="80%" border="0">
	            <tbody>
	              <tr>
	                <th scope="row">Listening</th>
	                <td>reading</td>
	                <td>speaking</td>
	                <td>writing</td>
	                <td>other</td>
	                <td>English</td>
	                <td>Math</td>
	                <td>Total</td>
	                <td>&nbsp;</td>
	                <td>&nbsp;</td>
	                <td>&nbsp;</td>
	                <td>Target Score</td>
	                </tr>
	              <tr>
	                <th scope="row"><input type="text" class="form-control"  placeholder="0.0" name="l_<?php echo e($i) ?>" maxlength="5" value="<?php echo e($l) ?>" required></th>
	                <td><input type="text" class="form-control"  placeholder="0.0" name="r_<?php echo e($i) ?>" maxlength="5" value="<?php echo e($r) ?>" required></td>
	                <td><input type="text" class="form-control"  placeholder="0.0" name="s_<?php echo e($i) ?>" maxlength="5" value="<?php echo e($s) ?>" required></td>
	                <td><input type="text" class="form-control"  placeholder="0.0" name="w_<?php echo e($i) ?>" maxlength="5" value="<?php echo e($w) ?>" required></td>
	                <td><input type="text" class="form-control"  placeholder="0.0" name="o_<?php echo e($i) ?>" maxlength="5" value="<?php echo e($o) ?>" required></td>
	                <td><input type="text" class="form-control"  placeholder="0.0" name="english_<?php echo e($i) ?>2" maxlength="5" value="<?php echo e($english) ?>" required></td>
	                <td><input type="text" class="form-control"  placeholder="0.0" name="math_<?php echo e($i) ?>3" maxlength="5" value="<?php echo e($math) ?>" required></td>
	                <td><input type="text" class="form-control"  placeholder="0.0" name="ttl_<?php echo e($i) ?>2" maxlength="5" value="<?php echo e($int_ttl) ?>" required></td>
	                <td>&nbsp;</td>
	                <td>&nbsp;</td>
	                <td>&nbsp;</td>
	                <td><input type="text" class="form-control"  placeholder="0.0" name="target_score_<?php echo e($i) ?>" maxlength="5" value="<?php echo e($target_score) ?>" required></td>
	                </tr>
	              </tbody>
	            </table>
	          <br>
	          </div></td>
	        <td align=center class="style24">&nbsp;</td>
	        </tr>
	      <?php $l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';$l = '0.0';$r = '0.0';$s = '0.0';$w = '0.0';$o = '0.0';$int_ttl = '0.0'; $target_score = '0.0';$i++;}} ?>
        </tbody>
	    <tfoot>
        </tfoot>
    </table>
	      <?php 
if (isset($_POST['Submit'])) 
{
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$batas = $i;


for($i=0;$i<=$batas;$i++) 
	{
	$kd_biodata = $_POST['kd_biodata'.$i];

		
	$komen = $_POST['komen_'.$i];
	$l = $_POST['l_'.$i];
	$r = $_POST['r_'.$i];
	$s = $_POST['s_'.$i];
	$w = $_POST['w_'.$i];
	$o = $_POST['o_'.$i];
	$ttl = $_POST['ttl_'.$i];	
	$target_score = $_POST['target_score_'.$i];		
	$query_comment = q_set($__p_query_comment, "select keterangan from vip_student_comment where kd_cbg = ? and kd_cl = ? and kd_biodata = ? ", [(string) ($kd_cbg), (string) ($kdcl), (string) ($kd_biodata)]);
	$resource_comment = db_query_soft($query_comment, $__p_query_comment ?? []);
	if(num(db_num_rows($resource_comment)) > 0)
		{
		$query_comment = q_set($__p_query_comment, "update ves_data.vip_student_comment set keterangan = ? ,l =? ,r =? ,s =? ,w =? ,other =? ,nilai_ttl =? ,target_score = ? where kd_cbg = ? and kd_cl = ? and kd_biodata = ? ", [(string) ($komen), (string) ($l), (string) ($r), (string) ($s), (string) ($w), (string) ($o), (string) ($ttl), (string) ($target_score), (string) ($kd_cbg), (string) ($kdcl), (string) ($kd_biodata)]);
		$result_upd_comment=db_query_or_die("Wah error nihupd", $query_comment, $__p_query_comment ?? []);			
		}
	else
		{
		$query_comment = q_set($__p_query_comment, "insert into ves_data.vip_student_comment (kd_biodata,kd_cbg,kd_cl,keterangan,pic,dt_entry,l,r,s,w,other, nilai_ttl,target_score)\r
\t\tvalues(? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($kd_biodata), (string) ($kd_cbg), (string) ($kdcl), (string) ($komen), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($l), (string) ($r), (string) ($s), (string) ($w), (string) ($o), (string) ($ttl), (string) ($target_score)]);
		$result_insert_comment=db_query_or_die("Wah error nihupd", $query_comment, $__p_query_comment ?? []);			
		}
	
	}

				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('" . e($url_asli) . "');\n";
				echo "</script>";	
}

?>
		      <input type="submit" name="Submit" value="Submit" />
		</div>	
		</div>

	</div></div>
<!-- /.row --><!-- /.content -->
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
	