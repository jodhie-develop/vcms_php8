<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kode_area'] ;
$kelompok = $_SESSION['kelompok'];
if (num($kd_area) == 5){$area ="";}
elseif(num($kd_area) == 42){$area = " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')";}
elseif(num($kd_area) == 41){$area = " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')";}
elseif(num($kd_area) == 31){$area = " and (kd_branch= '1' or kd_branch= '2')";}
elseif(num($kd_area) == 21) {$area = " and (kd_branch= '2'or kd_branch= '8')";}
elseif(num($kd_area) == 2){$area = " and kd_branch= '$kd_cbg'";}
else {$area = " and kd_branch= '$kd_cbg'";}	
if ($kelompok == 'ACD' or $posisi =='Admin')
	{
	if ($nama_depan == 'Ira00' or $nama_depan == 'hanifa07' or $nama_depan == 'resty04')
		{
		$kd_cbg = in_val('kd_cbg', 'get');
		}
else
{

$kd_cbg = $_SESSION['kd_branch'];}
$nm_teacher = in_val('nm_teacher', 'get');			
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

$tgl_awal = in_val('tgl_awal', 'get');
$tgl_akhir = in_val('tgl_akhir', 'get');
$activities = in_val('activities', 'get');
			
if ($tgl_awal == ''){$tgl_awal = $hari_ini;$tgl_akhir=$hari_ini;}
	}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="plugins/jQuery/jquery-2.2.3.min.js"></script>  

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<?php //========================== left nav ?>
 <?php 	  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <?php if ($kelompok !='ACD' and $kelompok !='ACC' and $posisi !='Admin')
{?>
 <?php }elseif ($kelompok == 'ACD' or  $posisi =='Admin'){
$query_notif= q_set($__p_query_notif, "select status_kelas from ves_data.vip_teacher_schedule where status_kelas = 50 or status_kelas = 60 or status_kelas = 70 or status_kelas = 80 or status_kelas = 90");
$result_notif=db_query_or_die("Wah error nih9", $query_notif, $__p_query_notif ?? []);	
$jml_notif = db_num_rows($result_notif);
$query = "SELECT date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata" ;

//===========academic==
?>
<section class="content-header">
<h1>Activities</h1>
           <div class="form-group">
          <a href="teachercalendar.php" 
target="popup" 
onClick="window.open('teachercalendar.php'); return false;" class="btn btn-primary" role="button"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
View Schedule </a>         
          </div>

 <div class="tab-content">
  <div id="act" class="tab-pane fade in active">
	<div class="panel box box-primary">
	<form name="myform" id="myform">
		<div class="box-header with-border">

		<div class="col-md-2">
		  <div class="form-group">
		    <label>Start Period</label>
		    <input name="tgl_awal"  class="form-control"  type="date" value="<?php echo e($tgl_awal) ?>"   onChange="this.form.submit()"/>
		  </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>End Period</label>
		     <input name="tgl_akhir"  class="form-control"  type="date" value="<?php echo e($tgl_akhir) ?>"  onChange="this.form.submit()" />
	      </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>Teacher</label>
		    <select class="form-control" name="nm_teacher"   onChange="this.form.submit()" >
	      <option>--All--</option>
		      <?php
$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT b.nm_teacher,b.kd_teacher FROM vip_teacher_schedule a left join vip_teacher_name b on a.nm_teacher = b.kd_teacher where mulai_tm between ? and ? group by nm_teacher order by nm_teacher", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);
	
$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
$keluar_nm_teacher= db_num_rows($resource_nm_teacher);
	while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
		{	
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
              <option selected="selected"><?php echo e($nm_teacher) ?></option>							  		
	        </select>
	      </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>Center</label>
		    <select class="form-control" name="kd_cbg"   onChange="this.form.submit()" >
              <option value="0">--CHOOSE--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="8">Malang</option>
              <option value="101">East Area</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="102">West Area</option>
              <option value="100">National</option>
              <option selected="selected"><?php echo e($cabang) ?></option>

	        </select>
	      </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>Activities</label>
		    <select class="form-control" name="activities"   onChange="this.form.submit()" >
		      <option>--All--</option>
		      <option>Teaching</option>
		      <option>Non Teaching</option>
		      <option selected="selected"><?php echo e($activities) ?></option>
	        </select>
	      </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label></label>
		    <input name="Save" type="submit" id="Save"  class="form-control"  value="Display" />
	      </div>
		  </div>
		<h4 class="box-title">		  <br>
		</h4>
		</div>
	  </form>

                  <div class="box-body">
             
<?php
	$i=1;
$query_act = q_set($__p_query_act, "SELECT v.id,  date_format(v.mulai_tm,'%W  %d %b %y'),date_format(v.mulai_tm,'%Y-%m-%d') FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata where v.mulai_tm between ? and ? ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);
	
//$query_act = "SELECT id,  date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata" ;
	
if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}
if ($kd_cbg == '101')
	{	$query_filter_act_kd_branch = q_set($__p_query_filter_act_kd_branch, " and (v.kd_branch = '1' or v.kd_branch = '2' or v.kd_branch = '3') ");}
elseif ($kd_cbg == '102')
	{	$query_filter_act_kd_branch = q_set($__p_query_filter_act_kd_branch, " and (v.kd_branch = '4' or v.kd_branch = '5' or v.kd_branch = '6' or  v.kd_branch = '7') ");}
elseif ($kd_cbg == '100')
	{	$query_filter_act_kd_branch = q_set($__p_query_filter_act_kd_branch, " and (v.kd_branch = '1' or v.kd_branch = '2' or v.kd_branch = '3' or  v.kd_branch = '4' or v.kd_branch = '5' or v.kd_branch = '6' or  v.kd_branch = '7') ");}
else 
	{	$query_filter_act_kd_branch = q_set($__p_query_filter_act_kd_branch, " and v.kd_branch = ? ", [(string) ($kd_cbg)]);}	
if ($activities == 'Teaching')
	{	$query_filter_act_activities = q_set($__p_query_filter_act_activities, " and (v.status_kelas = '1' or v.status_kelas = '51'or v.status_kelas = '61'or v.status_kelas = '71'or v.status_kelas = '81'or v.status_kelas = '91') ");}
elseif ($activities == 'Non Teaching')
	{	$query_filter_act_activities = q_set($__p_query_filter_act_activities, " and (v.status_kelas = '22' or v.status_kelas = '33'or v.status_kelas = '44'or v.status_kelas = '66'or v.status_kelas = '77') ");}
else	
	{	$query_filter_act_activities = q_set($__p_query_filter_act_activities, " and v.status_kelas <>0 ");}

				  
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . $query_filter_act_kd_branch . $query_filter_act_activities . " group by date_format(mulai_tm,'%y-%m-%d') order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? []), ...($__p_query_filter_act_kd_branch ?? []), ...($__p_query_filter_act_activities ?? [])]); 

		  
?>
<br>
<table width="100%" class="table table-borderless table-hover" id="example2">
  <tbody>
  <?php
      $result_act=db_query_or_die("Wah error nih19", $query_plan_act, $__p_query_plan_act ?? []);
if ($result_act) 
	{ 
	while ($r_act = db_fetch($result_act, PDO::FETCH_NUM))
		{ ?>
    <tr>
      <td height="14" colspan="6" align=left class="style24"><strong><?php echo  e($r_act[1]);  ?></strong></td>
    </tr>

    <tr>
      <?php 
$query_dtl = q_set($__p_query_dtl, "SELECT date_format(v.mulai_tm,'%H:%i'),date_format(v.selesai_tm,'%H:%i'), a.nm_teacher , v.kelas,v.center,v.room,v.keterangan ,v.status_kelas,v.mulai_tm, v.selesai_tm FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata where v.id = ? group by d.kd_biodata ", [(string) ($r_act[0])]);
		 
		$result_dtl=db_query_or_die("Wah error nih29", $query_dtl, $__p_query_dtl ?? []);		 
		if ($result_dtl) 
		{ 
		while ($r_dtl = db_fetch($result_dtl, PDO::FETCH_NUM))
			{
			$awal  = strtotime($r_dtl[8]);
			$akhir = strtotime($r_dtl[9]);
			$diff  = num($akhir) - num($awal);

			$jam   = floor(div($diff, (60 * 60)));
			$menit = num($diff) - num($jam) * num((60 * 60));
			$durasi =$jam.':'.floor( num($menit) / 60 );
		  ?>         
      <td height="14" align=center class="style24">&nbsp;</td>
      <td width="7%" height="14" align=center class="style24">&nbsp;</td>
      <td width="11%" align=center class="style24"><?php echo  e($r_dtl[0]);  ?> - <?php echo  e($r_dtl[1]);  ?></td>
      <td width="16%" align=center class="style24"><?php echo  e($r_dtl[2]);  ?> : <?php echo  e($r_dtl[3]);  ?></td>
      <td width="28%" align=center class="style24"><?php echo  e($r_dtl[4]);  ?> - <?php echo  e($r_dtl[5]);  ?><br></td>
      <td width="19%" align=center class="style24"><?php echo  e($durasi)  ?><br></td>
      <td width="19%" align=center class="style24">&nbsp;</td>
    </tr><?php  }}?>

    
    <?php   }} ?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
	</a>

        </ul>
        </div>
	</div>
</div>   
           <!-- /.box-body -->
    </div>

 <div class="box box-primary">
   <!-- /.box-header -->
                                 <div id="booking" class="panel-collapse collapse">

									 </a><!-- /.box-body -->
   <div class="box-footer text-center"> <a href="leads.php?q=3" class="uppercase">View All Leads</a> </div>
   <!-- /.box-footer -->
 </div>
   <?php } ?>
 </div>
</div>
</div>					
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="cdnjs/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="cdnjs/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="cdnjs/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
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
