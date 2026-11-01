<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 

include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$q = in_val('q', 'get');
if($q==''){$q='t';}
$tampilan = in_val('tampilan', 'get');
$kode_teacher = in_val('nm_teacher', 'get');
$posisi = $_SESSION['posisi']; 

$center = in_val('center', 'get');
if ($center==""){$center = "--ALL--";}

if ($tampilan==""){$tampilan = "Teachers Calendar";}
if ($tampilan == "Teachers Calendar") 
	{$q='t';}
else
	{$q='r';}

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kdcbg = in_val('kdcbg', 'get');


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kd_area'] ;
$level_posisi = $_SESSION['level_posisi'] ;
$kdcl = in_val('kdcl', 'get');
$nmcbg = in_val('cntr', 'get');

//header
$tampil_hari = '';
$tampil_teacher = '';
$tampil_jam = '';

$query_data_jml = q_set($__p_query_data_jml, "SELECT mulai_tm  \r
 FROM ves_data.vip_teacher_schedule where kd_branch = ? and kelas = ? and status_kelas = 1 group by mulai_tm", [(string) ($kdcbg), (string) ($kdcl)]);
$resource_data_jml = db_query_soft($query_data_jml, $__p_query_data_jml ?? []);
$keluar_data_jml = db_num_rows($resource_data_jml);		

$query_awal_akhir = q_set($__p_query_awal_akhir, "SELECT min(mulai_tm) as mulai, max(mulai_tm) as selesai \r
 FROM ves_data.vip_teacher_schedule where kd_branch = ? and kelas = ? and status_kelas = 1", [(string) ($kdcbg), (string) ($kdcl)]);

$resource_awal_akhir = db_query_soft($query_awal_akhir, $__p_query_awal_akhir ?? []);
$keluar_awal_akhir = db_num_rows($resource_awal_akhir);	
if(num(db_num_rows($resource_awal_akhir)) > 0)
	{
	while ($row_awal_akhir  =  db_fetch($resource_awal_akhir, PDO::FETCH_NUM))
		{
		$kelas_awal = $row_awal_akhir[0];
		$kelas_akhir = $row_awal_akhir[1];
			
		}
	}

$query_teacher = q_set($__p_query_teacher, "SELECT d.nm_teacher,c.fasilitator  FROM ves_data.vip_teacher_schedule c left join vip_teacher_name d on c.nm_teacher = d.kd_teacher where c.kd_branch = ? and c.kelas = ? and status_kelas = 1 group by  c.nm_teacher", [(string) ($kdcbg), (string) ($kdcl)]);
$resource_teacher = db_query_soft($query_teacher, $__p_query_teacher ?? []);
$keluar_teacher = db_num_rows($resource_teacher);	
if(num(db_num_rows($resource_teacher)) > 0)
	{
	while ($row_teacher  =  db_fetch($resource_teacher, PDO::FETCH_NUM))
		{
		$sch_teacher = $row_teacher[0];
		$each_fasilitator = $row_teacher[1];
		if(num($each_fasilitator) == 1){$nm_fasilitator = $sch_teacher;}
		if ($tampil_teacher != '')
			{$tampil_teacher = $tampil_teacher. ' / '.$sch_teacher;}
			else {$tampil_teacher = $sch_teacher;}
			
		}
	}

$query_data = q_set($__p_query_data, "SELECT c.nm_teacher, date_format(mulai_tm,'%W'),date_format(mulai_tm,'%k:%i'), date_format(selesai_tm,'%k:%i'),room, b.nm_program, c.level_program,c.kelas, d.nm_teacher,\r
min(mulai_tm) as mulai, max(mulai_tm) as selesai,c.kd_branch \r
 FROM ves_data.vip_teacher_schedule c left join ves_data.vip_mst_code_prg b on c.kode_program = b.kd_program left join vip_teacher_name d on c.nm_teacher = d.kd_teacher where c.kd_branch = ?\r
and c.kelas = ? and status_kelas = 1 group by  date_format(mulai_tm,'%W')", [(string) ($kdcbg), (string) ($kdcl)]);

$resource_data = db_query_soft($query_data, $__p_query_data ?? []);
$keluar_data = db_num_rows($resource_data);				
if(num(db_num_rows($resource_data)) > 0)
	{
	while ($row_data  =  db_fetch($resource_data, PDO::FETCH_NUM))
		{
		$sch_teacher = $row_data[8];
		$sch_hari = $row_data[1];
		$sch_jam = "$row_data[2]-$row_data[3]";
		$sch_room = $row_data[4];
		$nm_program = $row_data[5];
		$lv_program = $row_data[6];
		$kode_kelas = $row_data[7];
		if ($tampil_hari !=''){$tampil_hari = $tampil_hari. ' / '.$sch_hari;}
		else {$tampil_hari = $sch_hari;}

		if ($tampil_jam !=''){$tampil_jam = $tampil_jam. ' / '.$sch_jam;}
		else {$tampil_jam = $sch_jam;}
		$kelas_mulai =$row_data[9];			
		$kelas_selesai =$row_data[10];			
		}
	}
$kelas_awal = date("d M Y", strtotime($kelas_awal));
$kelas_akhir = date("d M Y", strtotime($kelas_akhir));

//==jml hari
$query_hr = q_set($__p_query_hr, "SELECT kelas, date_format(mulai_tm, '%a') FROM vip_teacher_schedule where kelas = ? and kd_branch = ? group by kelas, date_format(mulai_tm,'%a')", [(string) ($kdcl), (string) ($kdcbg)]);
$resource_hr = db_query_soft($query_hr, $__p_query_hr ?? []);
$jml_hr = db_num_rows($resource_hr);	


//==

//--
$query_tampil = q_set($__p_query_tampil, "SELECT date_format(v.mulai_tm,'%W'), date_format(v.mulai_tm,'%d %b %y'),date_format(v.mulai_tm,'%H %i'),date_format(v.selesai_tm,'%H %i'), v.nm_teacher,room,skill,urutan,status_kelas,v.id,v.mulai_tm,v.keterangan, type_kelas FROM ves_data.vip_teacher_schedule v where kelas = ? group by mulai_tm,status_kelas, nm_teacher order by mulai_tm asc, id ", [(string) ($kdcl)]);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VIP Academic Calendar</title>
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
<style type="text/css">
<!--

	.style33 {
	color:#000;
	font-size:130%;
	}

</style>  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<?php  //  include ('left.php') ?>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
      <div class="row">
        <div class="col-xs-12">
        <div class="col-xs-12">
        <h3 class="page-header" align="center">Academic Calendar<br>
          <?php echo e($nm_program) ?>        <?php echo e($lv_program) ?><br>
          (Evaluation Version)<br>
        </h3>
        <table width="70%" class="table table" id="table">
          <tbody>

            <tr>
              <td width="161" height="14" align=left class="style24">Class Code</td>
              <td width="718" align=left class="style24"><strong><?php echo e($kode_kelas) ?></strong></td>
              <td width="209" align=left class="style24">Days and Time</td>
              <td width="431" align=left class="style24"><strong><?php echo e($tampil_hari) ?></strong></td>
            </tr>
            <tr>
              <td height="14" align=left class="style24">Meetings</td>
              <td align=left class="style24"><strong><?php echo e($keluar_data_jml) ?></strong></td>
              <td align=center class="style24">&nbsp;</td>
              <td align=left class="style24"><strong><?php echo e($tampil_jam) ?></strong></td>
            </tr>
            <tr>
              <td height="14" align=left class="style24">Teacher[s]</td>
              <td align=left class="style24"><strong><?php echo e($tampil_teacher) ?></strong></td>
              <td align=left class="style24">Period :</td>
              <td align=left class="style24"><strong><?php echo e($kelas_awal) ?> to <?php echo e($kelas_akhir) ?></strong></td>
            </tr>
<?php if(num($kdcbg) == 400){?>			  
            <tr>
              <td height="14" align=left class="style24">Fasilitator</td>
              <td align=left class="style24"><?php echo e($nm_fasilitator) ?><button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addPos">Set Fasilitator</button>
                                    <!-- Modal -->
<div id="addPos" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <form method="post"><?php echo csrf_field(); ?>

     <div class="modal-header">      
      <h4 class="modal-title">Pilih Guru Fasilitator</h4>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
     </div>
     <div class="modal-body">     
		 <?php $_POST['kode_dipilih'] = $kode_kelas; $_POST['kdcbg'] = $kdcbg; ?>
      <div class="form-group">
       <label>Choose Fasilitator</label>
<select class="form-control" name="fasilitator">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT a.nm_teacher, b.nm_teacher FROM vip_teacher_schedule a left join ves_data.vip_teacher_name b on a.nm_teacher = b.kd_teacher\r
where status_kelas = 1 and  kelas = ? group by kelas, a.nm_teacher", [(string) ($kode_kelas)]);
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[0]).'">'.e($row_nm_teacher[1]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($fasilitator) ?></option>
       			  </select>
      </div>
     
     </div>
     <div class="modal-footer">
      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
      <input type="submit" class="btn btn-success" name="addfas" value="Choose">
     </div>
<?php 
if (isset($_POST['addfas'])) 
	{
$fasilitator = in_val('fasilitator', 'post');	
$kdcbg = in_val('kdcbg', 'post');
$kode_dipilih = in_val('kode_dipilih', 'post');		
$query_simpan_score_class = q_set($__p_query_simpan_score_class, "update vip_teacher_schedule set fasilitator = 0  where kelas = ? and fasilitator = 1", [(string) ($kode_dipilih)]);
$resource_simpan_score_class = db_query_or_die('errro_simpan2', $query_simpan_score_class, $__p_query_simpan_score_class ?? []);
	
$query_simpan_score_class = q_set($__p_query_simpan_score_class, "update vip_teacher_schedule set fasilitator = 1 where kelas = ? and nm_teacher = ? ", [(string) ($kode_dipilih), (string) ($fasilitator)]);
$resource_simpan_score_class = db_query_or_die('errro_simpan2', $query_simpan_score_class, $__p_query_simpan_score_class ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('acdcal.php?kdcl=" . e(u($kode_dipilih)) . "&kdcbg=" . e(u($kdcbg)) . "');\n";				
		echo "</script>";	
	}
 ?>		
    </form>
   </div>
  </div>
 </div>

				</td>
              <td align=left class="style24">&nbsp;</td>
              <td align=left class="style24">&nbsp;</td>
            </tr>
<?php }?>         
          </tbody>
          <tfoot>
          </tfoot>
        </table>
        </div></div>
      <!-- /.col -->
    </div>
     <form name="form1" method="post" action="#"><?php echo csrf_field(); ?>

       <span class="form-group">
       <input type="hidden" class="form-control"  placeholder="Enter ..." name="kelas" value="<?php echo e($kode_kelas) ?>" hidden><input type="hidden" class="form-control"  placeholder="Enter ..." name="kd_branch" value="<?php echo e($kdcbg) ?>" hidden>
       </span>
       <div class="row">
   	<div class = "col-xs-12">
 	
   	<?php 
	$mtg  = 1;
$i = 0;

// Jumlah siswa hadir per pertemuan, diambil sekali untuk semua pertemuan kelas ini. Dulu 1 query per
// pertemuan dan vip_attendance (±1,6 juta baris) tidak ber-index -> tiap query scan penuh (±1 detik).
// Hitungan sama dengan "SELECT distinct kd_biodata ..." lama (kd_biodata NULL terhitung 1).
$jml_hadir_meeting = [];
$query_hadir = q_set($__p_query_hadir, "SELECT dt_meeting, COUNT(DISTINCT kd_biodata) + MAX(kd_biodata IS NULL) FROM vip_attendance where kd_class = ? and st_attendance = 1 group by dt_meeting", [(string) ($kdcl)]);
$resource_hadir = db_query_or_die('errro_visitor1', $query_hadir, $__p_query_hadir ?? []);
while ($row_hadir = db_fetch($resource_hadir, PDO::FETCH_NUM))
	{
	$jml_hadir_meeting[(string) $row_hadir[0]] = (int) $row_hadir[1];
	}

  	  $resource_tampil= db_query_or_die('errro_visitor1', $query_tampil, $__p_query_tampil ?? []);
$keluar_tampil= db_num_rows($resource_tampil);
				if(num(db_num_rows($resource_tampil)) > 0)
					{
					while ($row_tampil=  db_fetch($resource_tampil, PDO::FETCH_NUM))
						{ $id_meeting = $row_tampil[9];$class_metodh = $row_tampil[12];
							?>
	<?php if (num($jml_hr) == 1) { ?> 	
					
   	  <div class="col-xs-3">
	<?php } elseif (num($jml_hr) == 2) { ?>

   	   <div class="col-xs-3">
	<?php } elseif (num($jml_hr) == 5) { 
        if(is_int(num($mtg)/5)){ ?>
    
    	  <div class="col-xs-3"> 
     <?php   } else {
			  ?>
			  
   	  <div class="col-xs-2">   	  
	<?php }} else { ?>
 	  
   	  <div class="col-xs-2">
	<?php } ?>
      
      
       <?php if (num($row_tampil[8]) == 1 or num($row_tampil[8]) == 0){ ?>
      	<div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <?php if (num($row_tampil[8])==1){?>
            
            <?php
			$jmlabsensi = $jml_hadir_meeting[(string) $row_tampil[10]] ?? 0;
?>
            <div class="widget-user-header bg-aqua-gradient">
  			<?php }else {$jmlabsensi = 0;?>
            <div class="widget-user-header bg-red">
  			
			<?php } ?>             
              <!-- /.widget-user-image -->
              <h5><span class="style33"><?php echo e($row_tampil[0]) ?><span class="form-group">
                <input type="hidden" class="form-control"  placeholder="Enter ..." name="tgl_meeting_<?php echo e($i) ?>" value="<?php echo e($row_tampil[9]) ?>" ></span>
				  </h5></span>
              <p><span class="style33">
              <?php if (num($row_tampil[8])==1){?>
			<?php if($nama_lengkap == 'Anggita Rizkiarachma'  or $nama_lengkap == 'Savita Rachma Indrayani'   or $nama_lengkap == 'Nadillah Aatifah Rahim'  ){?>	  
               <a href="vip_clupd.php?no=<?php echo e(u($row_tampil[9])); ?>" target="popup" onclick="window.open('vip_clupd.php?no=<?php echo e(u($row_tampil[9])); ?>','popup','width=1000,height=800'); return false;"><?php echo  e($row_tampil[1]) ?></a> 
		<?php }else {?>
				  <?php echo  e($row_tampil[1]) ?>
<?php } ?>				  
				
				  
               </span>
               <br>
               <p style="color:black"> <strong>(Meeting : <?php echo e($mtg) ?>)</strong>
				   <a href="vip_stuattt.php" 
target="popup" 
onclick="window.open('onoff_clupd.php?no=<?php echo e(u($row_tampil[9])) ?>','popup','width=2000,height=600'); return false;"><span class="pull-right badge bg-red"><?php echo e($class_metodh) ?></span></a>
 <?php $query_tampil_image = q_set($__p_query_tampil_image, "SELECT lokasi_file FROM vip_meeting_image where id_meeting  = ?  ", [(string) ($id_meeting)]);
  	  $resource_tampil_image= db_query_or_die('errro_visitor1', $query_tampil_image, $__p_query_tampil_image ?? []);
				if(num(db_num_rows($resource_tampil_image)) > 0){
?>					
			     <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#viewImage_<?php echo e($i) ?>">View Image</button> 
<?php } ?>				   
				   <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addImage_<?php echo e($i) ?>">Upload Image</button>

				   </p><span class="pull-right badge bg-aqua"><?php echo e($row_tampil[4]) ?></span>
<div id="viewImage_<?php echo e($i) ?>" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <form method="post" enctype="multipart/form-data" ><?php echo csrf_field(); ?>

     <div class="modal-header">      
      <h4 class="modal-title">View Image</h4>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
     </div>
     <div class="modal-body">    
		       <h4 class="modal-title">View Image</h4>
		 <?php $_POST['id_meeting'] = $id_meeting;   ?>
		 <input type="hidden" class="form-control" name="id_urut_meeting" placeholder="Enter name" value="<?php echo e($id_meeting) ?>" required>
<?php $query_tampil_image = q_set($__p_query_tampil_image, "SELECT lokasi_file FROM vip_meeting_image where id_meeting  = ?  ", [(string) ($id_meeting)]);
  	  $resource_tampil_image= db_query_or_die('errro_visitor1', $query_tampil_image, $__p_query_tampil_image ?? []);
				if(num(db_num_rows($resource_tampil_image)) > 0){
										{
					while ($row_tampil_image=  db_fetch($resource_tampil_image, PDO::FETCH_NUM))
						{ $lokasi_file = $row_tampil_image[0];
?>			 
      <div class="form-group">
      <img id="myImg" src="<?php echo e($lokasi_file) ?>" alt="Snow" style="width:100%;max-width:300px">
      </div>
<?php }} }?>		 
     </div>
<?php 
if (isset($_POST['addImg'])) 
	{
	$hari=date("d");
	$bulan=date("m");
	$tahun=date("Y");
	$tgl_hari_ini =  "$tahun-$bulan-$hari";
	$dt= "$tahun$bulan$hari";
	$id_urut_meeting = in_val('id_urut_meeting', 'post');
	$kode_dipilih = in_val('kode_dipilih', 'post');	
	$_POST['kdt']=$row_tampil[4];
	$kdt = in_val('kdt', 'post');
	$target_dir = "imgs/meeting/";
	$namafile = $kdt.$dt.$id_meeting.upload_display_name('fileToUpload');;
	$target_file = $target_dir.$kdt.$dt.$id_meeting.upload_random_name('fileToUpload');
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
	if(isset($_POST["addImg"])) 
		{
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) 
			{
			echo "File is an image - " . e($check["mime"]) . ".";
			$uploadOk = 1;
			} 
		else 
			{
			echo "File is not an image.";
			$uploadOk = 0;
			}
		}

// Check if file already exists
if (file_exists($target_file)) {echo "Sorry, file already exists.";$uploadOk = 0;}
// Check file size
if (num($_FILES["fileToUpload"]["size"]) > 50000000) {echo "Sorry, your file is too large.";$uploadOk = 0;}
// Allow certain file formats
if( $imageFileType != "png" and $imageFileType != "jpeg" and $imageFileType != "jpg" and $imageFileType != "JPEG" and $imageFileType != "JPG"  ) {echo "Sorry, only jpeg/jpg/png files are allowed.";$uploadOk = 0;}
// Check if $uploadOk is set to 0 by an error
if (num($uploadOk) == 0) 
	{echo "Sorry, your file was not uploaded.";}// if everything is ok, try to upload file
else 
	{
	if (upload_move('fileToUpload', upload_allow('png', 'jpeg', 'jpg'), $target_file, 50000000)) 
		{
		$query_simpan = q_set($__p_query_simpan, "insert into ves_data.vip_meeting_image (id_meeting, nama_file, dt_entry, lokasi_file ,pic) values (? ,? ,? ,? ,? )", [(string) ($id_urut_meeting), (string) ($namafile), (string) ($tgl_hari_ini), (string) ($target_file), (string) ($nama_lengkap)]);
		/* echo $query_simpan (debug SQL versi lama) dihapus */
		$resource_simpan= db_query_or_die('errro_simpans', $query_simpan, $__p_query_simpan ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('acdcal.php?kdcl=" . e(u($kode_dipilih)) . "&kdcbg=" . e(u($kdcbg)) . "');\n";				
		echo "</script>";	
		}
}}
 ?>		
    </form>
   </div>
  </div>
 </div>	
				<div id="addImage_<?php echo e($i) ?>" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <form method="post" enctype="multipart/form-data" ><?php echo csrf_field(); ?>

     <div class="modal-header">      
      <h4 class="modal-title">Meeting Image</h4>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
     </div>
     <div class="modal-body">     
		 <?php $_POST['id_meeting'] = $id_meeting;  $_POST['kode_dipilih'] = $kode_kelas;  ?>
		 		 <input type="hidden" class="form-control" name="kode_dipilih" placeholder="kode dipilih" value="<?php echo e($kode_kelas) ?>" required>
		 <input type="hidden" class="form-control" name="id_urut_meeting" placeholder="Enter name" value="<?php echo e($id_meeting) ?>" required>
      <div class="form-group">
       <label>Choose Image</label>
                 <input id="middle-name2" class="form-control col-md-7 col-xs-12" required="required" type="file" name="fileToUpload">
      </div>
     
     </div>
     <div class="modal-footer">
      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
      <input type="submit" class="btn btn-success" name="addImg" value="Choose">
     </div>
<?php 
if (isset($_POST['addImg'])) 
	{
	$hari=date("d");
	$bulan=date("m");
	$tahun=date("Y");
	$tgl_hari_ini =  "$tahun-$bulan-$hari";
	$dt= "$tahun$bulan$hari";
	$id_urut_meeting = in_val('id_urut_meeting', 'post');
	$kode_dipilih = in_val('kode_dipilih', 'post');	
	$_POST['kdt']=$row_tampil[4];
	$kdt = in_val('kdt', 'post');
	$target_dir = "imgs/meeting/";
	$namafile = $kdt.$dt.$id_meeting.upload_display_name('fileToUpload');;
	$target_file = $target_dir.$kdt.$dt.$id_meeting.upload_random_name('fileToUpload');
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
	if(isset($_POST["addImg"])) 
		{
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) 
			{
			echo "File is an image - " . e($check["mime"]) . ".";
			$uploadOk = 1;
			} 
		else 
			{
			echo "File is not an image.";
			$uploadOk = 0;
			}
		}
// Check if file already exists
if (file_exists($target_file)) {echo "Sorry, file already exists.";$uploadOk = 0;}
// Check file size
if (num($_FILES["fileToUpload"]["size"]) > 50000000) {echo "Sorry, your file is too large.";$uploadOk = 0;}
// Allow certain file formats
if( $imageFileType != "png" and $imageFileType != "jpeg" and $imageFileType != "jpg" and $imageFileType != "JPEG" and $imageFileType != "JPG"  ) {echo "Sorry, only jpeg/jpg/png files are allowed.";$uploadOk = 0;}
// Check if $uploadOk is set to 0 by an error
if (num($uploadOk) == 0) 
	{echo "Sorry, your file was not uploaded.";}// if everything is ok, try to upload file
else 
	{
	if (upload_move('fileToUpload', upload_allow('png', 'jpeg', 'jpg'), $target_file, 50000000)) 
		{
		$query_simpan = q_set($__p_query_simpan, "insert into ves_data.vip_meeting_image (id_meeting, nama_file, dt_entry, lokasi_file ,pic) values (? ,? ,? ,? ,? )", [(string) ($id_urut_meeting), (string) ($namafile), (string) ($tgl_hari_ini), (string) ($target_file), (string) ($nama_lengkap)]);

		$resource_simpan= db_query_or_die('errro_simpans', $query_simpan, $__p_query_simpan ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('acdcal.php?kdcl=" . e(u($kode_dipilih)) . "&kdcbg=" . e(u($kdcbg)) . "');\n";				
		echo "</script>";	
		}
}}
 ?>		
    </form>
   </div>
  </div>
 </div>	
               <?php  } else {
                echo  e($row_tampil[1]); ?><br>
				<br></span>
                (Day Off) - <?php echo e($row_tampil[11]) ?> </p><span class="pull-right badge bg-aqua"><?php echo e($row_tampil[4]) ?></span>
                
                <?php } ?>
            </div>
	  
	
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#"><?php echo e($row_tampil[5]) ?><span class="pull-right badge bg-blue"><?php echo e($row_tampil[2]).' - '.e($row_tampil[3]) ?></span></a></li>
                <li><a href="#">Skill </a></li>
                <li><input type="text" class="form-control"  placeholder="Enter ..." name="skill_<?php echo e($i) ?>" value="<?php echo e($row_tampil[6]) ?>" <?php if (num($row_tampil[8])==0){ echo "readonly='readonly'";} ?></input></li>
<?php if (num($row_tampil[8])==1){ ?>				  
                <li><a href="vip_stuattt.php" 
target="popup" 
onclick="window.open('vip_stuattt.php?no=<?php echo e(u($row_tampil[9])) ?>','popup','scrollbars,resizable,width=2000,height=600'); return false;">Attendance  <span class="pull-right badge bg-red"><?php echo e($jmlabsensi) ?></span></a></li>
                <li><a href="#" 
target="popup" 
onclick="window.open('vip_crsh.php?kdcl=<?php echo e(u($kode_kelas)) ?>&kdcbg=<?php echo e(u($kdcbg)) ?>&no=<?php echo e(u($row_tampil[9])) ?>','blank'); return false;">Coordination Sheet<span class="pull-right badge bg-red"></a></li>		<?php } ?>		  
              </ul>
            </div>
          </div>
        <?php if (num($row_tampil[8])==1){ $i++; $mtg = num($mtg) + 1;} } ?>

		</div>  
<?php } } ?>
  	
   	</div>
   </div>
   <?php 
if (isset($_POST['Submit'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$kelas = in_val('kelas', 'post');
	$kdcbg = in_val('kd_branch', 'post');
	$batas = $i;
	for($i=0;$i<=$batas;$i++) 
	{
	$tgl_meeting = $_POST['tgl_meeting_'.$i];
	$skill = $_POST['skill_'.$i];
	$query_skil = q_set($__p_query_skil, "update ves_data.vip_teacher_schedule set skill = ? where id = ? ", [(string) ($skill), (string) ($tgl_meeting)]);
	$result_skill=db_query_or_die("Wah error nih1", $query_skil, $__p_query_skil ?? []);
				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('" . e($url_asli) . "');\n";
				echo "</script>";
	}

}
?>
    <!-- title row -->

    <!-- /.row -->
<?php if ($nama_lengkap == 'Anggita Rizkiarachma' or $nama_lengkap == 'Savita Rachma Indrayani' or $nama_lengkap == 'Nadillah Aatifah Rahim' ){?>		  
           <div class="row">Click Submit to Update Skill for Each Meeting
             <input type="submit" name="Submit" value="Submit" />	
       </div>
	  
  <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modifyskill">Skill Configuration</button>
<?php } ?>			  
<div id="modifyskill" class="modal fade">

  <div class="modal-dialog">
	        <h4 class="modal-title">Skill</h4>
   <div class="modal-content">
    <form method="POST"><?php echo csrf_field(); ?>

			<input type="hidden" class="form-control" name="id_kegiatan" value=<?php echo e($id)?>></input>
     <div class="modal-body"> 
		      <div class="modal-footer">
      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
      <input type="submit" class="btn btn-success" name="add" value="Modif Skill">
     </div>	
              <table>
                                            
                                                <tr>
                                                    <td align="center">ID</td>													
                                                    <td align="center">DATE MEETING</td>
                                                    <td align="center">TEACHER</td>
                                                    <td align="center">SKILL</td>
                                 												
												
                                                </tr>
                                           
                                           
<?php
												$a = 0;
$query_skill = q_set($__p_query_skill, "SELECT id, date_format(mulai_tm,'%d-%m-%y'),date_format(mulai_tm,'%H:%i'),date_format(selesai_tm,'%H:%i'),  nm_teacher, skill FROM ves_data.vip_teacher_schedule where status_kelas = 1 and kelas = ? order by mulai_tm", [(string) ($kode_kelas)]);
 
$resource_item_belanja = db_query_soft($query_skill, $__p_query_skill ?? []);
if(num(db_num_rows($resource_item_belanja)) > 0)
{ 
 while ($r  =  db_fetch($resource_item_belanja, PDO::FETCH_NUM))
		{	
	 $no_urut = num($no_urut)+1;
?>												
												
                                                <tr>
                                                    <td align="center" width="20"><?php echo e($no_urut) ?> <br>													
                                                    <td align="center" width="25"><?php echo e($r[1]) ?> <br>
(<?php echo e($r[2]) ?>-<?php echo e($r[3]) ?>)</td>
                                                    <td align="center" width="30"><?php echo e($r[4]) ?></td>
                                                    <td class="center" width="100"><input type="text" width="500"  name="skill_<?php echo e($a) ?>" value="<?php echo e($r[5]) ?>"><input type="hidden" width="350"  name="id_<?php echo e($a) ?>" value="<?php echo e($r[0]) ?>"></input></input>	   
																
                                                </tr>
<?php $a = num($a)+1; } }?>												
                                           
                                        </table>
     
     </div>

<?php	  
if (isset($_POST['add'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
	$batas = $a;
	
	for($a=0;$a<=$batas;$a++) 
		{


		

			$id = $_POST['id_'.$a];
			$skill = $_POST['skill_'.$a];		
			$query_skil = q_set($__p_query_skil, "update ves_data.vip_teacher_schedule set skill = ? where id = ? ", [(string) ($skill), (string) ($id)]);
			$result_skill=db_query_or_die("Wah error nih1", $query_skil, $__p_query_skil ?? []);						
		}
	
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('acdcal.php?kdcl=" . e(u($kode_kelas)) . "&kdcbg=" . e(u($kdcbg)) . "');\n";				
		echo "</script>";
		  }
?>						  
    </form>
   </div>
  </div>
 </div>	
    <div class="row">
      <div class="col-xs-12">
      <button>Back To Class List</button></a><a href= "rpt_acdcal.php?kdcl=<?php echo e(u($kdcl)) ?>&kdcbg=<?php echo  e(u($kdcbg)) ?>" target="_blank"><button>Print</button></a>
		 </div>
	</div>
  </section> 


  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>

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
