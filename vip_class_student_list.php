<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
// Variabel yang dipakai tampilan tetapi tidak selalu diisi (versi lama: kosong).
$kelas_cact = '';
$adascore = $adascore_mid = $adascore_final = '';
$target_score = $tgl_tutor = $tgl_la = $tgl_lc = $tgl_ext = $tgl_makeup = '';
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_date('date_start', '', 'get');
$date_end = in_date('date_end', '', 'get');
if ($date_start ==''){$date_start = "2020-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_str('kd_cbg', 20, 'get');

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

if (num($kd_cbg) == 0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}

if ($kd_cbg ==1){$cabang = 'East Sby';}
if ($kd_cbg ==2){$cabang = 'West Sby';}
if ($kd_cbg ==3){$cabang = 'Denpasar';}
if ($kd_cbg ==4){$cabang = 'South Jkt';}
if ($kd_cbg ==5){$cabang = 'North Jkt';}
if ($kd_cbg ==6){$cabang = 'West Jkt';}
if ($kd_cbg ==7){$cabang = 'Bandung';}
if ($kd_cbg ==8){$cabang = 'Malang TBI';}
if ($kd_cbg ==9){$cabang = 'Bandung TBI';}
if ($kd_cbg ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdcl = in_str('kdcl', 45, 'get');
$kdprg = in_str('kdprg', 45, 'get');
$nmprg = in_str('nmprg', 45, 'get');

$query_nmprg = "select kode_program from vip_teacher_schedule where kelas = ? group by kelas";

$resource_nmprg = db_query($query_nmprg, [$kdcl]);			
if($resource_nmprg->rowCount() > 0)
	{
	while ($row_nmprg  =  $resource_nmprg->fetch(PDO::FETCH_NUM))
		{
		$nmprg = $row_nmprg[0];	
		}
	}
$kdcl = in_str('kdcl', 45, 'get');

// strpos mencari posisi teks "CACT-P" dalam $kdcl
if (strpos($kdcl, 'CACT-') !== false) {
    $kelas_cact =  1;
}

$pilihan_sc = in_str('pilihan_sc', 45, 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
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
		        <label>Class Code : <?php echo e($kdcl) ?></label><br>
		        <label>Meeting : </label>
		        
	        <input type="text" name="kdprg" id="textfield" hidden value="<?php echo e($kdprg) ?>" ></input>
	        <input type="text" name="nmprg" id="textfield2"hidden value="<?php echo e($nmprg) ?>" >
	      </p>
	      <p>Me </p>

	      <table width="100%" class="table table-bordered table-striped" id="example12">
		        <thead>
	      <tr>
	        <td width=12% height="14" align=center >Student Name</td>
	        <td width="6%" align=center >Target Score</td>
	        <td width="6%" align=center >Placement Score</td>
	        <td width="11%" align=center >Mid Test Score</td>
	        <td width="10%" align=center >Final Test Score</td>
	        <td width="7%" align=center >Tutorial</td>
	        <td width="6%" align=center >Late Attendance</td>
	        <td width="11%" align=center >LC Visit</td>
	        <td width="14%" align=center >Make Up Test</td>
	        <td width="14%" align=center >Test Extension</td>
	        </tr>
        </thead>
	    <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   echo $query_billing;
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = $resource_billing->rowCount();
					   ?>
	    <tbody>
	      <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc" ;

//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.no FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc" ;
					
$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.no, c.idkey FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where  a.kd_class = ?  group by a.kd_billing order by a.dt_entry desc";					
// (echo $query_billing; debug versi lama menampilkan SQL di halaman, dihapus)
$resource_billing = db_query($query_billing, [$kdcl]);
$keluar_billing = $resource_billing->rowCount();				
if($resource_billing->rowCount() > 0)
	{
	while ($row_billing  =  $resource_billing->fetch(PDO::FETCH_NUM))
		{
		
		$query_target_score = "SELECT v.kd_biodata, v.class_code, v.kd_billing, v.target_score FROM vip_class_score_profile v where kd_billing = ? and kd_biodata = ?";
		$resource_target_score = db_query($query_target_score, ["{$row_billing[0]} ", $row_billing[7]]);			
		if($resource_target_score->rowCount() > 0)
			{
			while ($row_target_score  =  $resource_target_score->fetch(PDO::FETCH_NUM))	
				{
				$target_score = $row_target_score[3];
				}
			}
		
		$query_cek_score = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no,catatan,t.prg_recom FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and jns_test = '1' order by test_date desc limit 1";	
		$resource_cek_score = db_query($query_cek_score, [$row_billing[7]]);	
		if($resource_cek_score->rowCount() > 0)
			{
			while ($row_cek_score  =  $resource_cek_score->fetch(PDO::FETCH_NUM))	
				{
				$l = $row_cek_score[0];	
				$st = $row_cek_score[1];	
				$sp = $row_cek_score[2];	
				$r = $row_cek_score[3];	
				$w = $row_cek_score[4];						
				$ttl = $row_cek_score[5];
				$nomor_pt = $row_cek_score[6];	
				$catatan = $row_cek_score[7];		
				$prg_recom = $row_cek_score[8];						
				$adascore = 1;
				}								
			}
		else
			{
			$query_score = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_inc.tb_acd_history t where t.kd_biodata =  ? order by no desc limit 1";
			$resource_score = db_query($query_score, [$row_billing[7]]);
			$keluar_score = $resource_score->rowCount();	
			if($resource_score->rowCount() > 0)
				{ 
				while ($row_score  =  $resource_score->fetch(PDO::FETCH_NUM))	
					{				
					$l = $row_score[0];	
					$st = $row_score[1];	
					$sp = $row_score[2];	
					$r = $row_score[3];	
					$w = $row_score[4];						
					$ttl = $row_score[5];
					$nomor_pt = $row_score[6];	
					$catatan = $row_score[7] ?? null;		
					$prg_recom = $row_score[8] ?? null;						
					$adascore = 1;	
					$query_simpan = "insert into ves_data.vip_class_score_profile ( kd_cbg, class_code, kd_biodata,jns_test,L,S,R,W,total,remark, test_date,dt_entry,pic) values ('', ?, ?, '1', ?, ?, ?, ?, ?, '', '', '', ?) ";
					$resource_simpan = db_query($query_simpan, [$row_billing[11], $row_billing[7], $l, $sp, $r, $w, $ttl, $nama_lengkap]);	
$query_cek_score = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no,catatan,t.prg_recom FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and jns_test = '1' order by test_date desc limit 1";	

		$resource_cek_score = db_query($query_cek_score, [$row_billing[7]]);	
		if($resource_cek_score->rowCount() > 0)
			{
			while ($row_cek_score  =  $resource_cek_score->fetch(PDO::FETCH_NUM))	
				{
				$l = $row_cek_score[0];	
				$st = $row_cek_score[1];	
				$sp = $row_cek_score[2];	
				$r = $row_cek_score[3];	
				$w = $row_cek_score[4];						
				$ttl = $row_cek_score[5];
				$nomor_pt = $row_cek_score[6];	
				$catatan = $row_cek_score[7];		
				$prg_recom = $row_cek_score[8];						
				$adascore = 1;
				}								
			}					
					

					}			
				}
			}
					
			
			


		
		$query_score_mid = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no,t.catatan FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '2' order by test_date desc limit 1";
		$resource_score_mid = db_query($query_score_mid, [$row_billing[7], $row_billing[11]]);
		$keluar_score_mid = $resource_score_mid->rowCount();	
		if($resource_score_mid->rowCount() > 0)
			{
			while ($row_score_mid  =  $resource_score_mid->fetch(PDO::FETCH_NUM))	
				{
				$l_mid = $row_score_mid[0];	
				$st_mid = $row_score_mid[1];	
				$sp_mid = $row_score_mid[2];	
				$r_mid = $row_score_mid[3];	
				$w_mid = $row_score_mid[4];						
				$ttl_mid = $row_score_mid[5];
				$nomor_mid = $row_score_mid[6];
				$catatan_mid = $row_score_mid[7];
				
				$adascore_mid = 1;
				}
			}
		$query_score_final = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no,t.catatan FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1";
		$resource_score_final = db_query($query_score_final, [$row_billing[7], $row_billing[11]]);
		$keluar_score_final = $resource_score_final->rowCount();	
		if($resource_score_final->rowCount() > 0)
			{
			while ($row_score_final  =  $resource_score_final->fetch(PDO::FETCH_NUM))	
				{
				$l_final = $row_score_final[0];	
				$st_final = $row_score_final[1];	
				$sp_final = $row_score_final[2];	
				$r_final = $row_score_final[3];	
				$w_final = $row_score_final[4];						
				$ttl_final = $row_score_final[5];
				$nomor_final = $row_score_final[6];		
				$catatan_final = $row_score_final[7];				
				$adascore_final = 1;
				}
			}
		$tgl_tutor = '';	
		$query_tutor = "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and status_kelas = '50' and kelas like ?";

		$resource_tutor = db_query($query_tutor, [$row_billing[7], "{$row_billing[11]}%"]);
		$keluar_tutor = $resource_tutor->rowCount();	
		if($resource_tutor->rowCount() > 0)
			{
			while ($row_tutor  =  $resource_tutor->fetch(PDO::FETCH_NUM))	
				{
				if ($tgl_tutor <> ''){$tgl_tutor = "$tgl_tutor<br> $row_tutor[0]";}
				else {$tgl_tutor = $row_tutor[0];}
				}
			}
		$query_tutor = "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and (status_kelas = '60' or status_kelas = '61') and kelas like ? group by mulai_tm";
		$resource_tutor = db_query($query_tutor, [$row_billing[7], "{$row_billing[11]}%"]);
		$keluar_tutor = $resource_tutor->rowCount();	
		if($resource_tutor->rowCount() > 0)
			{
			while ($row_tutor  =  $resource_tutor->fetch(PDO::FETCH_NUM))	
				{
				if ($tgl_la <> ''){$tgl_la = "$tgl_la<br> $row_tutor[0]";}
				else {$tgl_la = $row_tutor[0];}
				}
			}
		$query_tutor = "SELECT date_format(mulai_tm,'%d-%m-%y'), date_format(mulai_tm,'%H:%i'), date_format(selesai_tm,'%H:%i'), round(TIME_TO_SEC(timediff(date_format(selesai_tm,'%H:%i:00'),date_format(mulai_tm,'%H:%i:00'))) / 3600 ) as durasi  FROM ves_data.vip_teacher_schedule where kd_biodata = ? and (status_kelas = '71' or status_kelas = '70'  or status_kelas = '75'  ) and kelas like ?";

		$resource_tutor = db_query($query_tutor, [$row_billing[7], "{$row_billing[11]}%"]);
		$keluar_tutor = $resource_tutor->rowCount();	
		if($resource_tutor->rowCount() > 0)
			{
			while ($row_tutor  =  $resource_tutor->fetch(PDO::FETCH_NUM))	
				{
				if ($tgl_lc <> '')
				{
				$tgl_lc = "$tgl_lc <br> $row_tutor[0] ( $row_tutor[1]-$row_tutor[2]) ($row_tutor[3])";}
				else {$tgl_lc = "$row_tutor[0] ( $row_tutor[1]-$row_tutor[2]) ($row_tutor[3])";}
				}
			}			
			$query_tutor = "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and status_kelas = '90' and kelas like ?";
		$resource_tutor = db_query($query_tutor, [$row_billing[7], "{$row_billing[11]}%"]);
		$keluar_tutor = $resource_tutor->rowCount();	
		if($resource_tutor->rowCount() > 0)
			{
			while ($row_tutor  =  $resource_tutor->fetch(PDO::FETCH_NUM))	
				{
				if ($tgl_ext <> ''){$tgl_ext = "$tgl_ext<br> $row_tutor[0]";}
				else {$tgl_ext = $row_tutor[0];}
				}
			}		
			
			$query_makeup = "SELECT date_format(mulai_tm,'%d-%m-%y'), date_format(mulai_tm,'%H:%i'), date_format(selesai_tm,'%H:%i'), round(TIME_TO_SEC(timediff(date_format(selesai_tm,'%H:%i:00'),date_format(mulai_tm,'%H:%i:00'))) / 3600 ) as durasi  FROM ves_data.vip_teacher_schedule where kd_biodata = ? and (status_kelas = '41' or status_kelas = '40'  or status_kelas = '45'  ) and kelas like ?";

		$resource_makeup = db_query($query_makeup, [$row_billing[7], "{$row_billing[11]}%"]);

		if($resource_makeup->rowCount() > 0)
			{
			while ($row_makeup  =  $resource_makeup->fetch(PDO::FETCH_NUM))	
				{
				if ($tgl_makeup <> '')
				{
				$tgl_makeup = "$tgl_makeup <br> $row_makeup[0] ( $row_makeup[1]-$row_makeup[2]) ($row_makeup[3])";}
				else {$tgl_makeup = "$row_makeup[0] ( $row_makeup[1]-$row_makeup[2]) ($row_makeup[3])";}
				}
			}			
	?>
	      <tr>
	        <td height="14" align=left class="style24"><?php echo e($row_billing[6]) ?><br>
	          <?php //==== admin  
				if($posisi =="Admin")
				{
				?>
	          <a href="vipbillreceipt.php?idb=<?php echo e(u($row_billing[0])) ?>&kdb=<?php echo e(u($row_billing[7])) ?>&st=1">
	            <?php } else { //non admin ?>
	            <a href="vipbill.php?idb=<?php echo e(u($row_billing[0])) ?>&kdb=<?php echo e(u($row_billing[7])) ?>&st=1">
	            <?php } ?>
	            <?php echo e($row_billing[0]) ?></a><br>
                idkey: 
                <input type="text" value="<?php echo e($row_billing[13]) ?>" id="myInput" readonly>
<button onclick="myFunction()">Copy IDKey</button>

<script>
function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);
  
  // Alert the copied text
  alert("Copied Id Key: " + copyText.value);
}
</script></td>
	        <td align=center class="style24"><?php echo e($target_score) ?></td>
	        <td align=center class="style24"><?php  if ($adascore == 1){?>
	          <p>L: <?php echo e($l) ?> St: <?php echo e($st) ?> <br>
	            Sp: <?php echo e($sp) ?>	            R: <?php echo e($r) ?> W: <?php echo e($w) ?> <br>
	            TTL: <?php echo e($ttl) ?><br>
	            Note :  <?php echo e($catatan) ?>
	          </p>
	          <p>
<?php if ($posisi != 'SC'){?>				  
	            <a href="vip_scoreupd.php" 
target="popup" 
onclick="window.open('vip_scoreupd.php?no=<?php echo e(u($nomor_pt)) ?>&pt=1','popup','width=1000,height=800'); return false;">Modify</a>
	            </p> <?php } } else { ?>
<?php if ($posisi != 'SC'){?>				
              <a href="vip_score.php" 
target="popup" 
onclick="window.open('vip_score.php?kdb=<?php echo e(u($row_billing[7])) ?>&t=1&kdcl=<?php echo e(u($row_billing[11])) ?>','popup','width=1000,height=800'); return false;">Add</a></p><?php } }?>              </td>
	        <td align=center class="style24"><?php  if ($adascore_mid == 1){?>
              <p>L: <?php echo e($l_mid) ?> St: <?php echo e($st_mid) ?> <br>
                Sp: <?php echo e($sp_mid) ?>                R: <?php echo e($r_mid) ?> W: <?php echo e($w_mid) ?> <br>
                TTL: <?php echo e($ttl_mid) ?><br>
                Note : <?php echo e($catatan_mid) ?>              </p>
              <p>
               <a href="vip_scoreupd.php" 
target="popup" 
onclick="window.open('vip_scoreupd.php?no=<?php echo e(u($nomor_mid)) ?>&pt=2','popup','width=1000,height=800'); return false;">Modify</a></p>
                <?php } else { ?>
              <a href="vip_score.php" 
target="popup" 
onclick="window.open('vip_score.php?kdb=<?php echo e(u($row_billing[7])) ?>&t=2&kdcl=<?php echo e(u($row_billing[11])) ?>','popup','width=1000,height=800'); return false;">Add</a></p><?php } ?></td>
	        <td align=center class="style24"><?php  if ($adascore_final == 1 ){?>
	          <p>L: <?php echo e($l_final) ?> St: <?php echo e($st_final) ?> <br>
	            Sp: <?php echo e($sp_final) ?> R: <?php echo e($r_final) ?> W: <?php echo e($w_final) ?> <br>
	            TTL: <?php echo e($ttl_final) ?><br>
	            Note : <?php echo e($catatan_final) ?>	          </p>
	          <p><a href="vip_scoreupd.php" 
target="popup" 
onclick="window.open('vip_scoreupd.php?no=<?php echo e(u($nomor_final)) ?>&pt=3','popup','width=1000,height=800'); return false;">Modify</a>
	            <?php }elseif ($adascore_final!=1 and $adascore_mid ==1) { ?>
	            <a href="vip_score.php" 
target="popup" 
onclick="window.open('vip_score.php?kdb=<?php echo e(u($row_billing[7])) ?>&t=3&kdcl=<?php echo e(u($row_billing[11])) ?>','popup','width=1000,height=800'); return false;">Add</a></p>
	          <?php } ?></td>
	        <td align=center class="style24"><p><?php echo $tgl_tutor ?></p>
	          <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=50">Book</a></p></td>
	        <td align=center class="style24"><p><?php echo $tgl_la ?></p>
	          <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=60">Book</a></p></td>
	        <td align=center class="style24"><p><?php echo $tgl_lc ?></p>
	          <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=70">Book</a></p></td>
	        <td align=center class="style24"><p><?php echo $tgl_makeup ?></p>
              <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=40">Book</a></p></td>
	        <td align=center class="style24"><p><?php echo $tgl_ext ?></p>
              <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=90">Book</a></p></td>
	        </tr>
	      <?php $l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';$tgl_la = '';		$tgl_tutor = '';$target_score ='';$tgl_lc='';$tgl_ext = '';$tgl_makeup ='';}} ?>
        </tbody>
	    <tfoot>
        </tfoot>
    </table>
  
		</div>	
	  </div>
<?php // if ($kd_cbg =='351' or $kd_cbg =='356' or $kd_cbg =='358' or $kd_cbg =='355'  ){ ?>
<!--                <a href= "newleadsvpro.php?kdcl=<?php echo e(u($kdcl)) ?>&nmprg=<?php echo e(u($nmprg)) ?>&kdcb=<?php echo e(u($kd_cbg)) ?>">Add Student</a>
<?php // } else { ?> -->   	  
<a href= "vip_student_list.php?kdcl=<?php echo e(u($kdcl)) ?>&nmprg=<?php echo e(u($nmprg)) ?>&kdcb=<?php echo e(u($kd_cbg)) ?>">Add Student</a>
<?php // } ?><br>

	<?php if ($kelas_cact ==1){?> <a href= "cact_student_list.php?kdcl=<?php echo e(u($kdcl)) ?>&nmprg=<?php echo e(u($nmprg)) ?>&kdcb=<?php echo e(u($kd_cbg)) ?>">Add Student (CACT Only) <?php } ?><a></a></div></div>
<div class="box box-warning">          
  <div class="box-body">
    <div class="col-md-3">
		          <a href= "vip_crsh.php?kdcl=<?php echo e(u($kdcl)) ?>&kdcbg=<?php echo e(u($kd_cbg)) ?>" target="_blank" class="btn btn-primary" role="button"><i class="glyphicon glyphicon-apple" aria-hidden="true"></i>
Coordination
Sheet</a>  
	  </div>
	</div>
</div>	
<!-- /.row --><!-- /.content -->

<!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->

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
if (in_raw('Search', 'get') !== null) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.loleftcation = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
	