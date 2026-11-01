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
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
elseif ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_val('kd_cbg', 'get');

if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
elseif ($kd_cbg == 'Online'){$kd_cbg = 100;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
elseif ($kd_cbg == 'CA'){$kd_cbg = 15;}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 14;}
elseif (num($kd_cbg) ==0){$cabang = '--ALL--';}
elseif ($kd_cbg ==''){$cabang = '--ALL--';}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdprg = in_val('kdprg', 'get');

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang';}
elseif (num($kd_cbg) ==100){$cabang = 'Online';}
elseif (num($kd_cbg) ==111){$cabang = 'All';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif (num($kd_cbg) ==15){$cabang = 'CA';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}

$sc_name = in_val('sc_name', 'get');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VE Score Record</title>
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
    <h1>VIP Placement Test Student List<br>
    </h1>
 <form method=get action=vip_pt_list.php>
   <table width="527" border="0">
     <tbody>
       <tr class="table table-bordered table-striped">
         <th scope="row">Center</th>
         <td><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
           <option value="0">--CHOOSE--</option>
           <option value="1">East Sby</option>
           <option value="2">West Sby</option>
           <option value="3">Denpasar</option>
           <option value="8">Malang</option>
           <option value="101">East Area</option>
           <option value="4">South Jkt</option>
           <option value="5">North Jkt</option>
           <option value="11">PIK</option>
           <option value="12">Serpong</option>
           <option value="6">West Jkt</option>
           <option value="7">Bandung</option>
           <option value="15">CA</option>
           <option value="102">West Area</option>
           <option value="100">Online</option>
           <option value="111">All</option>
           <option selected="selected"><?php echo e($cabang) ?></option>
           </select></td>
         </tr>
       <tr>
         <td width="149"><label for="date5"> Entry Data Period </label>
           </small></td>
         <td width="368"><input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
           To </small><small>
             <input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>"  onChange="this.form.submit()">
            </small></td>
         </tr>
       <tr>
         <td><label for="date3"> Consultant Name</label>
           </small></td>
         <td><select class="form-control" name="sc_name"  onChange="this.form.submit()">
			 <option>--All--</option>
        <?php
							//	$query_cl_code = "SELECT distinct kd_class FROM ves_data.vip_billing a left join vip_teacher_schedule c on a.kd_class = c.kelas where c.kd_branch = '1' and c.mulai_tm between '2018-08-01' and '2018-08-30' group by a.kd_class";

								$query_sc = q_set($__p_query_sc, "SELECT c.pic FROM vip_class_score_profile a left join ves_data.vip_billing c on a.kd_billing = c.kd_billing where a.dt_entry between ? and ? and a.kd_cbg = ? group by c.pic order by c.pic", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);	


								$resource_sc = db_query_or_die('errro_7', $query_sc, $__p_query_sc ?? []);
								while ($row_sc=  db_fetch($resource_sc, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_sc[0]).'">'.e($row_sc[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($sc_name) ?></option>
      </select></td>
         </tr>
     </tbody>
   </table>
 </form>
	 </section><!-- Main content -->

<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Data List</label>
		</div>				
	  </div>	
	  <div class="col-md-12">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td height="14" align=center >Student</td>
	            <td align=center >SC</td>
	            <td align=center >Center</td>
	            <td align=center >Data <br>
                Entry Date</td>
	            <td align=center >Target Score</td>
	            <td align=center >Test Date</td>
	            <td colspan="6" align=center >Placement Test Score</td>
	            <td align=center >&nbsp;</td>
	            <td align=center >&nbsp;</td>
              </tr>
	          <tr>
	            <td width=18% height="14" align=center >&nbsp;</td>
	            <td width=6% align=center >&nbsp;</td>
	            <td width=6% align=center >&nbsp;</td>
	            <td width="13%" align=center >&nbsp;</td>
	            <td width="17%" align=center >&nbsp;</td>
	            <td width="17%" align=center >&nbsp;</td>
	            <td width="4%" align=center >L</td>
	            <td width="4%" align=center >R</td>
	            <td width="4%" align=center >W</td>
	            <td width="5%" align=center >Sp</td>
	            <td width="6%" align=center >St</td>
	            <td width="3%" align=center >Overall</td>
	            <td width="20%" align=center >&nbsp;</td>
	            <td width="20%" align=center >Action</td>
              </tr>
            </thead>

	   
	          <?php	
	$adafile = 0;

//$query_student = "SELECT a.kd_biodata, concat_ws(' ',nama, middle_name, family_name), a.branch,date_format(a.dt_entry,'%d %b %y'),pic,a.no FROM ves_inc.tb_biodata a where concat_ws(' ',nama, middle_name, family_name) like '%$flt_name%' and dt_entry > '2018-01-01'  order by dt_entry desc limit 50";
if ($sc_name =='--All--'){
$query_student = q_set($__p_query_student, "SELECT b.nama_lengkap, c.pic, a.kd_cbg, date_format(a.dt_entry,'%d %b %y'), a.target_score, date_format(a.test_date,'%d %b %y'), a.L, a.R, a.W, a.S, a.other, a.total, a.prg_recom,a.kd_biodata,a.no,a.catatan,a.prg_type  FROM vip_class_score_profile a left join vip_student_data b on a.kd_biodata = b.kd_biodata left join ves_data.vip_billing c on a.kd_billing = c.kd_billing where a.dt_entry between ? and ? and a.kd_cbg = ? group by a.kd_biodata, a.test_date  order by a.dt_entry desc limit 1000 ", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);
}
			else
{
$query_student = q_set($__p_query_student, "SELECT b.nama_lengkap, c.pic, a.kd_cbg, date_format(a.dt_entry,'%d %b %y'), a.target_score, date_format(a.test_date,'%d %b %y'), a.L, a.R, a.W, a.S, a.other, a.total, a.prg_recom,a.kd_biodata,a.no,a.catatan,a.prg_type  FROM vip_class_score_profile a left join vip_student_data b on a.kd_biodata = b.kd_biodata left join ves_data.vip_billing c on a.kd_billing = c.kd_billing where a.dt_entry between ? and ? and a.kd_cbg = ? and c.pic = ? group by a.kd_biodata, a.test_date  order by a.dt_entry desc limit 1000 ", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg), (string) ($sc_name)]);
}
$resource_student = db_query_soft($query_student, $__p_query_student ?? []);	
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_student  =  db_fetch($resource_student, PDO::FETCH_NUM))
		{
		$nama_lengkap_student = $row_student[0];
		$kd_biodata = $row_student[13];
		
		$dt_entry_tampil = $row_student[3];		
		$sc = $row_student[1];			
		$l = $row_student[6];	
				$st = $row_student[10];	
				$sp = $row_student[9];	
				$r = $row_student[7];	
				$w = $row_student[8];						
				$ttl = $row_student[11];
				$nomor_pt = $row_student[14];	
				$test_date = $row_student[5]; if($test_date ==''){$warna =" bgcolor = '#EFCB40'";}else{$warna=" bgcolor = ''";}	
				$test_date_tampil = $row_student[5];
				$catatan = $row_student[15];		
				$prg_recom = $row_student[12];
				$prg_type = $row_student[13];
				$target_score = $row_student[4];
				$duration = $row_student[20];
				$sat_english = $row_student[21];
				$sat_math = $row_student[22];
		
		if($duration !='' and num($duration) != 0){$duration = "$duration months";}else{$duration = '';}
				$no_urut_booking = $row_student[18];		
		if($test_date ==''){$adascore =0;}else{$adascore = 1;}
		





	
	?>     <tbody>
	          <tr bgcolor=#EFCB40>
	            <td height="14" align=left class="style24" <?php echo e($warna) ?>><?php echo  e($nama_lengkap_student)  ?>
	             
                <input type="hidden" name="no_urut_booking" id="textfield" value="<?php echo e($no_urut_booking) ?>"></td>
	            <td align=center class="style24" <?php echo e($warna) ?>><?php echo  e($sc)  ?></td>
				  <td align=center class="style24" <?php echo e($warna) ?>><?php echo  e($row_student[2])  ?></td>
				  <td align=center class="style24" <?php echo e($warna) ?>><?php echo  e($dt_entry_tampil)  ?></td>
				  <td align=center class="style24" <?php echo e($warna) ?>><?php echo e($target_score) ?></td>
	            <td align=center class="style24" <?php echo e($warna) ?>><?php echo e($test_date_tampil) ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($l)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($r)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($w)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($sp)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($st)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($ttl)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>>&nbsp;</td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php if (num($adascore) ==0 and $kelompok =='ACD'){ ?>
					<a href="vip_pt_record_upd.php?kp=<?php echo e(u($kode_po)); ?>&idsoa=<?php echo e(u($idsoa)) ?>" target="popup" onclick="window.open('vip_pt_record_upd.php?nub=<?php echo  e(u($no_urut_booking)) ?>&kdb=<?php echo e(u($kd_biodata)) ?>','popup','width=1000,height=800'); return false;"><button>PT SCORE</button></a>

					
<?php }elseif (num($adascore) == 1 and $kelompok =='ACD') {?>
<a href="vip_pt_record_upd.php?kp=<?php echo e(u($kode_po)); ?>&idsoa=<?php echo e(u($idsoa)) ?>" target="popup" onclick="window.open('vip_pt_record_upd.php?nub=<?php echo  e(u($no_urut_booking)) ?>&kdb=<?php echo e(u($kd_biodata)) ?>&upd=1','popup','width=1000,height=800'); return false;"><button>Modify</button></a>
</div>								
									<a href="vip_pt_record_upd.php?kp=<?php echo e(u($kode_po)); ?>&idsoa=<?php echo e(u($idsoa)) ?>" target="popup" onclick="window.open('vip_pt_record_upd.php?nub=<?php echo  e(u($no_urut_booking)) ?>&kdb=<?php echo e(u($kd_biodata)) ?>&ins=1','popup','width=1000,height=800'); return false;"><button>More PT Score</button></a>
				
					

<a href="ecert/ecertibt.php?kdb=<?php echo e(u($kd_biodata)) ?>&nr=<?php echo e(u($nomor_pt)) ?>&59198753128785321589898951284987321" target="_blank">
<button class="btn btn-info btn-xs">IBT/IELTS PT Print</button>	</a><a href="ecert/ecertpbt.php?kdb=<?php echo e(u($kd_biodata)) ?>&nr=<?php echo e(u($nomor_pt)) ?>&59198753128785321589898951284987321" target="_blank">
<button class="btn btn-info btn-xs">PBT PT Print</button>	</a>	
	<a href="ecert/ecertpredic.php?kdb=<?php echo e(u($kd_biodata)) ?>&nr=<?php echo e(u($nomor_pt)) ?>&59198753128785321589898951284987321" target="_blank">
<button class="btn btn-default btn-xs">Prediction</button>	</a>	
	<a href="ecert/ecertge.php?kdb=<?php echo e(u($kd_biodata)) ?>&nr=<?php echo e(u($nomor_pt)) ?>&59198753128785321589898951284987321" target="_blank">
<button class="btn btn-default btn-xs">GE Program</button>	</a>
	<a href="ecert/ecertsat.php?kdb=<?php echo e(u($kd_biodata)) ?>&nr=<?php echo e(u($nomor_pt)) ?>&59198753128785321589898951284987321" target="_blank">
<button class="btn btn-default btn-xs">SAT Program</button>	</a>			  
				<div id="addmorescore_<?php echo e($i) ?>" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <form method="POST"><?php echo csrf_field(); ?>

     <div class="modal-header">      
      <h4 class="modal-title">ADD MORE <?php echo e($nama_lengkap_student) ;$_POST['nama_lengkap_student'.$i]=$nama_lengkap_student; ?><input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="nama_lengkap_student_baru" 
                 	      value="<?php echo e($nama_lengkap_student) ?>"> </h4>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
     </div>
     <div class="modal-body">     

           	            <input type="hidden" class="form-control"  placeholder="Enter CLass Code" name="kd_biodata_dipilih_<?php echo e($i) ?>" value="<?php echo e($kd_biodata) ?>" required>
		            	            <input type="hidden" class="form-control"  placeholder="Enter CLass Code" name="n_urut" value="<?php echo e($n_urut) ?>" required>
		            	            <input type="hidden" class="form-control"  placeholder="Enter CLass Code" name="kode_student" value="<?php echo e($kd_biodata) ?>" required>		 
<div class="box-body">	
<div class="col-xs-12">	
<div class="col-xs-4">
    <div class="form-group">
      <label>Test Date</label><input type="date" class="form-control"  placeholder="Enter ..." name="tgl_testing" 
                 	      value="<?php echo e($hari_ini) ?>">
    </div>
  </div>
<div class="col-xs-4">
    <div class="form-group">
      <label>Note</label><input type="institution" ang="en-150" class="form-control"  placeholder="Enter ..." name="note_score" 
                 	      value="<?php echo e($note_score) ?>">
    </div>
  </div>
  <div class="col-xs-3">
    <div class="form-group">
      <label>Test Type</label><select class="form-control" name="prg_type" >
	      <option>IELTS</option>
<option>TOEFL IBT</option>
<option>TOEFL PBT</option>
<option>TOEIC</option>
	
		      
              <option selected="selected"><?php echo e($nm_teacher) ?></option>							  		
	        </select>
    </div>
  </div>		
  <div class="col-xs-4">
    <div class="form-group">
      <label>Prg Recom</label><select class="form-control" name="prg_recom" >
	      <option>No </option>
<option>GE</option>
<option>Foundation</option>
<option>IELTS - In Focus</option>
<option>IELTS - Savvy</option>
<option>IELTS - High Achiever</option>
<option>TOEFL iBT - Access</option>
<option>TOEFL iBT - In action</option>
<option>TOEFL iBT - Expert</option>
<option>TOEFL PBT - Workshop</option>
<option>TOEFL PTB - Regular</option>
<option>Vista Cambridge English - Survivor</option>
<option>Vista Cambridge Engslish - Threshold</option>
<option>Vista Cambridge English - Advance</option>
<option>Vista English For Adult - Beginner</option>
<option>Vista English For Adult - Survivor</option>
<option>Vista English For Adult - Threshold</option>
<option>Vista Academic English - Sophomore</option>
<option>Vista Academic English - Junior</option>
<option>Fast Track - IELTS/TOEFL</option>
<option>TTS - IELTS ( L,R,S)</option>
<option>TTS - IELTS (W)</option>
		
		      
              <option selected="selected"><?php echo e($nm_teacher) ?></option>							  		
	        </select>
    </div>
  </div>	
		 </div> 
<div class="col-xs-12">
  <div class="col-xs-4">
    <div class="form-group">
      <label>Listening</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="l" 
                 	      value="<?php echo e($l) ?>">
    </div>
  </div>
  <div class="col-xs-4">
    <div class="form-group">
      <label>Structure</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="st" 
                 	      value="<?php echo e($st) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Speaking</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="sp" 
                 	      value="<?php echo e($sp) ?>">

    </div>
  </div>

</div>
<div class="col-xs-12">
  <div class="col-xs-4">
    <div class="form-group">
      <label>Reading</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="r" 
                 	      value="<?php echo e($r) ?>">
    </div>
  </div>
  <div class="col-xs-4">
    <div class="form-group">
      <label>Writing</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="w" 
                 	      value="<?php echo e($w) ?>">
    </div>
  </div>
  <div class="col-xs-4">
    <div class="form-group">
      <label>TOTAL</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="ttl" 
                 	      value="<?php echo e($ttl) ?>">
    </div>
  </div>	
</div>	  
		
     </div>
     <div class="modal-footer">
      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
      <input type="submit" class="btn btn-success" name="save_score" value="Save Score">
     </div>
<?php 
if (isset($_POST['save_score'])) 
	{
	$hari=date("d");
	$bulan=date("m");
	$tahun=date("Y");
	$tgl_hari_ini =  "$tahun-$bulan-$hari";
$listening_score = in_val('l', 'post');
	$other_score = in_val('st', 'post');
	$speaking_score = in_val('sp', 'post');
	$reading_score = in_val('r', 'post');
	$writing_score = in_val('w', 'post');
	$total_score = in_val('ttl', 'post');
	$prg_type = in_val('prg_type', 'post');	
	$progress_check_1 = in_val('progress_check_1', 'post');
	$progress_check_2 = in_val('progress_check_2', 'post');
	$progress_overall = in_val('progress_overall', 'post');	
	$note_score = in_val('note_score', 'post');
	$tgl_testing = in_val('tgl_testing', 'post');
	$catatan = in_val('note_score', 'post');
	$prg_recom = in_val('prg_recom', 'post');
	if($tgl_testing ==''){$tgl_testing = $tgl_hari_ini;}
	$note_score = in_val('note_score', 'post');	
	$nama_lengkap_student = in_val('nama_lengkap_student_baru', 'post');		
 $kode_student = in_val('kode_student', 'post'); 
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kd_branch = $_SESSION['kd_branch'];
$query_simpan_score_class = q_set($__p_query_simpan_score_class, "insert into ves_data.vip_class_score_profile ( kd_cbg, class_code, kd_biodata,jns_test,L,S,R,W,other,total,remark, test_date,dt_entry,pic,catatan, prg_recom,prg_type) values (? ,? ,? ,'1',? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ) ", [(string) ($kd_branch), (string) ($kdcl), (string) ($kode_student), (string) ($listening_score), (string) ($speaking_score), (string) ($reading_score), (string) ($writing_score), (string) ($other_score), (string) ($total_score), (string) ($note_score), (string) ($tgl_testing), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($catatan), (string) ($prg_recom), (string) ($prg_type)]);	
	$resource_simpan = db_query_or_die('errro_simpan2', $query_simpan_score_class, $__p_query_simpan_score_class ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('vip_pt_record.php?flt_name=" . e(u($nama_lengkap_student)) . "');\n";				
		echo "</script>";	
	die;
	}
 ?>		
    </form>
   </div>
  </div>
 </div>		
											
<?php }elseif (num($adascore) == 1 and $kelompok !='ACD') {?>
 <a href="ecert/ecertibt.php?kdb=<?php echo e(u($kd_biodata)) ?>&nr=<?php echo e(u($nomor_pt)) ?>&59198753128785321589898951284987321" target="_blank">
<button class="btn btn-warning btn-xs">iBT/IELTS PT Print</button>	</a> <a href="ecert/ecertpbt.php?kdb=<?php echo e(u($kd_biodata)) ?>&nr=<?php echo e(u($nomor_pt)) ?>&59198753128785321589898951284987321" target="_blank">
<button class="btn btn-info btn-xs">PBT PT Print</button>	</a>
</a> <a href="ecert/ecertpredic.php?kdb=<?php echo e(u($kd_biodata)) ?>&nr=<?php echo e(u($nomor_pt)) ?>&59198753128785321589898951284987321" target="_blank">
<button class="btn btn-default btn-xs">Prediction</button>	</a>						
<?php }?>
					
</td>
              
	          <?php $i = num($i)+1;
				$l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$nama_lengkap_student  ='';$test_date_tampil='';$prg_recom ='';}} ?></tr>				  
	            

              </tbody>

	        <tfoot>
            </tfoot>
          </table>
	    </div>
            <!-- /.box-body -->
      </div>
          <!-- /.box -->
    </div>
        <!-- /.col -->
      </div>
				
	 </div> <!-- /.row --><!-- /.content -->
	</form> 
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
