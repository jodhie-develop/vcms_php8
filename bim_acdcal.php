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

$query_teacher = q_set($__p_query_teacher, "SELECT d.nm_teacher  FROM ves_data.vip_teacher_schedule c left join vip_teacher_name d on c.nm_teacher = d.kd_teacher where c.kd_branch = ? and c.kelas = ? and status_kelas = 1 group by  c.nm_teacher", [(string) ($kdcbg), (string) ($kdcl)]);

$resource_teacher = db_query_soft($query_teacher, $__p_query_teacher ?? []);
$keluar_teacher = db_num_rows($resource_teacher);	
if(num(db_num_rows($resource_teacher)) > 0)
	{
	while ($row_teacher  =  db_fetch($resource_teacher, PDO::FETCH_NUM))
		{
		$sch_teacher = $row_teacher[0];
		if ($tampil_teacher != ''){		$tampil_teacher	 = $tampil_teacher. ' / '.$sch_teacher;}
		else {		$tampil_teacher	 = $sch_teacher;}
			
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
$query_tampil = q_set($__p_query_tampil, "SELECT date_format(v.mulai_tm,'%W'), date_format(v.mulai_tm,'%d %b %y'),date_format(v.mulai_tm,'%H %i'),date_format(v.selesai_tm,'%H %i'), v.nm_teacher,room,skill,urutan,status_kelas,v.id,v.mulai_tm,v.keterangan FROM ves_data.vip_teacher_schedule v where kelas = ? group by mulai_tm,status_kelas, nm_teacher order by mulai_tm asc, id ", [(string) ($kdcl)]);

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
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
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
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
      <div class="row">
        <div class="col-xs-12">
        <div class="col-xs-12">
        <h3 class="page-header" align="center">Academic Calendar<br>
          <?php echo e($nm_program) ?>        <?php echo e($lv_program) ?><br>
          (BIM PROJECT)<br>
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

  	  $resource_tampil= db_query_or_die('errro_visitor1', $query_tampil, $__p_query_tampil ?? []);
$keluar_tampil= db_num_rows($resource_tampil);
				if(num(db_num_rows($resource_tampil)) > 0)
					{
					while ($row_tampil=  db_fetch($resource_tampil, PDO::FETCH_NUM))
						{
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
            $query_absen = q_set($__p_query_absen, "SELECT distinct kd_biodata FROM vip_attendance where kd_class = ? and dt_meeting = ? and st_attendance = 1", [(string) ($kdcl), (string) ($row_tampil[10])]);

			$resource_absen= db_query_or_die('errro_visitor1', $query_absen, $__p_query_absen ?? []);
			$jmlabsensi= db_num_rows($resource_absen);
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
               <a href="vip_clupd.php?no=<?php echo e(u($row_tampil[9])); ?>" target="popup" onclick="window.open('vip_clupd.php?no=<?php echo e(u($row_tampil[9])); ?>','popup','width=1000,height=800'); return false;"><?php echo  e($row_tampil[1]) ?></a> 
               </span>
               <br>
    <p style="color:black"> <strong>(Meeting : <?php echo e($mtg) ?>)</strong>  <button type="button" class="btn bg-purple margin btn-xs" data-toggle="modal" data-target="#gambar">Image</button></p><span class="pull-right badge bg-aqua"><?php echo e($row_tampil[4]) ?></span>
				
        <div class="modal" id="gambar">
          <div class="modal-dialog">
            <div class="modal-content">
    <form method="post"><?php echo csrf_field(); ?>
				
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Student List</h4>
              </div>
              <div class="modal-footer">
      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
      <input type="submit" class="btn btn-success" name="choosestudent" value="Select">
              </div>				
              <div class="modal-body">

                <div class="form-group">
                  <label for="exampleInputFile3">File input</label>
                  <input type="file" id="exampleInputFile3" name="file">
                </div>
                <button type="submit" class="btn btn-primary"  name="Upload" value="Upload" >Upload</button>				  
<?php	  
if (isset($_POST['choosestudent'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$batas = $b;
	for($b=0;$b<=$batas;$b++) 
		{
		$pilih = $_POST['check_'.$b];

		if( empty($_POST['check_'.$b]) ){$dipilih = 0;}else{$dipilih = 1;}	
		if (num($dipilih)==1)
			{

			$kdb = $_POST['kd_biodata_'.$b];							
			}
		}
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('invoicebill.php?kdb=" . e(u($kdb)) . "');\n";				
		echo "</script>";	
}
?>				
              </div>
	  </form>
	  
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>	 				
				
				
				
				
               <?php } else {
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
onclick="window.open('vip_stuattt.php?no=<?php echo e(u($row_tampil[9])) ?>','popup','width=2000,height=600'); return false;">Attendance<span class="pull-right badge bg-red"><?php echo e($jmlabsensi) ?></span></a></li>
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
           <div class="row">Click Submit to Update Skill for Each Meeting
             <input type="submit" name="Submit" value="Submit" />	
       </div>
 
    </form>
    <div class="row">
      <div class="col-xs-12">
      <a href="vip_class_list.php"><button>Back To Class List</button></a><a href= "rpt_acdcal.php?kdcl=<?php echo e(u($kdcl)) ?>&kdcbg=<?php echo   e(u($kdcbg)) ?>" target="_blank"><button>Print</button></a>
	  </div>
	</div>
  </section> 


  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>


