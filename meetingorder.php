<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
 include __DIR__ . "/left.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$tgl_mulai = in_val('tgl_mulai', 'get');
$tgl_selesai = in_val('tgl_selesai', 'get');
if ($date_start ==''){$date_start = "2024-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kode_area'] ;
$kelompok = $_SESSION['kelompok'];
$display = in_val('display', 'get');


$center = in_val('center', 'get');
$nm_teacher = in_val('nm_teacher', 'get');
$jns_kelas = in_val('jns_kelas', 'get');
if ($jns_kelas == 'Class') { $kd_jns_kelas = '1';  $filter_kelas = q_set($__p_filter_kelas, " and status_kelas = ? ", [(string) ($kd_jns_kelas)]);}
 else if ($jns_kelas == 'LC') { $filter_kelas = q_set($__p_filter_kelas, " and ( status_kelas = '70' or status_kelas = '71' or status_kelas = '75')");}
 else if ($jns_kelas == 'Late Attendance   ') {  $filter_kelas = q_set($__p_filter_kelas, " ( status_kelas = '60' or status_kelas = '61' or status_kelas = '62' or status_kelas = '65')");}
 else if ($jns_kelas == 'Training') { $kd_jns_kelas = '22';  $filter_kelas = q_set($__p_filter_kelas, " and status_kelas = ? ", [(string) ($kd_jns_kelas)]);}
 else if ($jns_kelas == 'Meeting') { $kd_jns_kelas = '33';  $filter_kelas = q_set($__p_filter_kelas, " and status_kelas = ? ", [(string) ($kd_jns_kelas)]);}
 else if ($jns_kelas == 'Class Observation') { $kd_jns_kelas = '44';  $filter_kelas = q_set($__p_filter_kelas, " and status_kelas = ? ", [(string) ($kd_jns_kelas)]);}
 else if ($jns_kelas == 'Scoring') { $kd_jns_kelas = '66';  $filter_kelas = q_set($__p_filter_kelas, " and status_kelas = ? ", [(string) ($kd_jns_kelas)]);}
 else if ($jns_kelas == 'Speaking Test') { $kd_jns_kelas = '899';  $filter_kelas = q_set($__p_filter_kelas, " and (status_kelas = '897' or status_kelas = '899')");}
 else if ($jns_kelas == 'Day Off') { $kd_jns_kelas = '';  $filter_kelas = q_set($__p_filter_kelas, " and status_kelas = ? ", [(string) ($kd_jns_kelas)]);}
 else if ($jns_kelas == 'Free class') { $kd_jns_kelas = '898';  $filter_kelas = q_set($__p_filter_kelas, " and status_kelas = ? ", [(string) ($kd_jns_kelas)]);}
 else if ($jns_kelas == 'Make up Test') { $kd_jns_kelas = '897';  $filter_kelas = q_set($__p_filter_kelas, " and (status_kelas = ? or status_kelas = 40 or status_kelas = 41 or status_kelas = 45 or status_kelas = 896)", [(string) ($kd_jns_kelas)]);}
 else if ($jns_kelas == 'ALL' or $jns_kelas == '') { $kd_jns_kelas = '';  $filter_kelas = q_set($__p_filter_kelas, " and ( status_kelas like '5%' or status_kelas like '6%' or status_kelas like '7%' or status_kelas like '8%' or status_kelas like '9%' or status_kelas = '1' or status_kelas = '897' or status_kelas like '4%'   or status_kelas like '30%')");}




if ($center =='East Sby'){$kd_cbg_teacher = 1;}
if ($center =='West Sby'){$kd_cbg_teacher = 2;}
if ($center =='Denpasar'){$kd_cbg_teacher = 3;}
if ($center =='South Jkt'){$kd_cbg_teacher = 4;}
if ($center =='North Jkt'){$kd_cbg_teacher = 5;}
if ($center =='West Jkt'){$kd_cbg_teacher = 6;}
if ($center =='Bandung'){$kd_cbg_teacher = 7;}
if ($center =='Malang TBI'){$kd_cbg_teacher = 8;}
if ($center =='ONLINE'){$kd_cbg_teacher = 100;}
if ($center=='--ALL--')
	{
	$pilihcabang = "";
	}
elseif ($center == 'ONLINE')
	{
	$pilihcabang = q_set($__p_pilihcabang, " and v.kelas like '%-100%'");
	}
elseif ($center == 'JAKARTA')
	{
	$pilihcabang = q_set($__p_pilihcabang, " and v.center  like '%Jkt'");
	}
elseif ($center == 'SURABAYA')
	{
	$pilihcabang = q_set($__p_pilihcabang, " and v.center  like '%Sby'");
	}
elseif ($center == '')
	{
	$pilihcabang = "";
	}
else
	{
	$pilihcabang = q_set($__p_pilihcabang, " and v.center  =? ", [(string) ($center)]);
	}

if ($nm_teacher=='--ALL--')
	{
	$pilihteacher = "";
	}
elseif ($nm_teacher == '')
	{
	$pilihteacher = "";
	}
else
	{
	$pilihteacher = q_set($__p_pilihteacher, " and v.nm_teacher  =? ", [(string) ($nm_teacher)]);
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

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <?php if ($kelompok !='ACD' and $kelompok !='ACC' and $posisi !='Admin' and $posisi !='LIU')
{?>
 <?php }elseif ($kelompok == 'ACD'){



//===========academic==
?>
   <section class="content-header">
         <h1>
 Teacher Meeting Order</h1>
			 	      <ul class="nav nav-pills">
    <li><a href="dashboard.php">My Profile</a></li> 			 	       
  </ul>
 <div class="box box-solid">
   <!-- /.box-header -->
<form method="GET" >	 
           <div class="box-body">

             


<!-- forum start -->

    
<!-- form end===    			   			   -->
           
             <div class="panel box box-danger">
               <div class="box-header with-border">
                   <h4 class="box-title"> Teacher's Booking </h4>
                 </div>
               <div class="col-md-2">
                 <div class="form-group">
           	       <input type="DATE" class="form-control"   placeholder="Enter ..." name="tgl_mulai" value="<?php echo e($tgl_mulai) ?>">
                 </div>
               </div>
               <div class="col-md-2">
                 <div class="form-group">
           	       <input type="DATE" class="form-control"   placeholder="Enter ..." name="tgl_selesai" value="<?php echo e($tgl_selesai) ?>">
                 </div>
               </div>
               <div class="col-md-2">
                   <div class="form-group">
                     <select class="form-control" name="center" onChange="this.form.submit()">
                       <option>--ALL--</option>
                       <option>JAKARTA</option>
                       <option>SURABAYA</option>
                       <option>East Sby</option>
                       <option>West Sby</option>
                       <option>Bali</option>
                       <option>South Jkt</option>
                       <option>North Jkt</option>
                       <option>West Jkt</option>
                       <option>Bandung</option>
                       <option>Malang</option>
                       <option>ONLINE</option>
                       <option selected><?php echo e($center) ?></option>
                     </select>
                   </div>
                 </div>
               <div class="col-md-2">
                   <div class="form-group">
                     <select class="form-control" name="nm_teacher">
						 <option>--ALL--</option>

        <?php
$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher FROM ves_data.vip_teacher_schedule where mulai_tm > '2025-07-01'  group by nm_teacher order by nm_teacher");

$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[0]).'">'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($nm_teacher) ?></option>						 
                     </select>
                   </div>
                 </div>
               <div class="col-md-2">
                 <div class="form-group">
                   <select class="form-control" name="jns_kelas">
        <option>Class</option>					   
        <option>LC</option>
        <option>Late Attendance</option>   
        <option>Training</option>
        <option>Meeting</option>
        <option>Class Observation</option>
        <option>Scoring</option>   
        <option>Speaking Test</option>            
        <option>Day Off</option>
        <option>Free class</option>
        <option>Make up Test</option>		  
        <option>ALL</option>
        <option selected><?php echo  e($jns_kelas) ?></option>				   
					   
                   </select>
                 </div>
               </div>
               <div class="col-md-2">
        <div class="img-push">

          <input type="submit" name="display" value="Display">
        </div>
                 </div>
		     </div> 
	

   <div class="box-body">
     <ul class="products-list product-list-in-box">
       <?php
	if($display <>'' and $tgl_mulai <>'' and $tgl_selesai <>'')
	{
$query = q_set($__p_query, "SELECT date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,\r
v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap,max(v.id),type_kelas FROM vip_teacher_schedule v\r
left join vip_teacher_name a on v.nm_teacher = a.kd_teacher\r
left join tb_user c on a.nm_teacher = c.nama_detail\r
left join vip_student_data d on v.kd_biodata = d.kd_biodata\r
where v.mulai_tm between ? and ? ", [(string) ($tgl_mulai) . " 00:00:01", (string) ($tgl_selesai) . " 23:00:00"]);



			  
$query_plan = q_set($__p_query_plan, $query . $pilihcabang . $pilihteacher . $filter_kelas . " group by kelas, mulai_tm,status_kelas, nm_teacher, v.kd_biodata order by  v.mulai_tm desc ", [...($__p_query ?? []), ...($__p_pilihcabang ?? []), ...($__p_pilihteacher ?? []), ...($__p_filter_kelas ?? [])]); 
?>
       <br>
       <table width="100%" class="table table-bordered table-striped" id="example1">
         <tbody>
           <tr>
             <td width="12%" align=center class="style24">Date Requested<br>
               By</td>
             <td width="12%" height="14" align=center class="style24">Teacher's Requested</td>
             <td width="11%" align=center class="style24">Student's Name</td>
             <td width="11%" align=center class="style24">Class</td>
             <td width="20%" align=center class="style24">Schedule Requested</td>
             <td width="10%" align=center class="style24">Room</td>
             <td width="17%" align=center class="style24">Description</td>
             <td width="17%" align=center class="style24">Status</td>
           </tr>
           <?php 

      $result=db_query_or_die("Wah error nih10", $query_plan, $__p_query_plan ?? []);
if ($result) 
	{ 
	while ($r = db_fetch($result, PDO::FETCH_NUM))
		{	
		$activity = num($activity) + 1;
			if(($r[8] == '40') or ($r[8] == '50') or ($r[8] == '60') or ($r[8] == '70') or ($r[8] == '80') or ($r[8] == '90')  or ($r[8] == '980')){$status = 'Booking';}
			elseif(($r[8] == '41') or($r[8] == '51') or ($r[8] == '61') or ($r[8] == '71') or ($r[8] == '81') or ($r[8] == '91')  or ($r[8] == '981')){$status = 'Approved';}
			elseif(($r[8] == '42') or($r[8] == '52') or ($r[8] == '62') or ($r[8] == '72') or ($r[8] == '82') or ($r[8] == '92') or ($r[8] == '982')){$status = 'Rejected';}			
			
			 ?>
           <tr>
             <td align=center class="style24"><?php echo  e($r[0]);  ?><br>
               <?php echo  e($r[10]);  ?></td>
             <td height="14" align=center class="style24"><?php echo  e($r[1]);  ?></td>
             <td align=center class="style24"><?php  echo e($r[12]);  ?></td>             
             <td align=center class="style24"><?php  echo  e($r[4]);  ?>
               <br>
				 <?php  echo e($r[7]);  ?></td>
             <td align=center class="style24"><?php echo  e($r[2]);  ?> - <?php echo  e($r[3]);  ?></td>
             <td align=center class="style24"><?php echo  e($r[5]);  ?> <br></td>
             <td align=center class="style24"><?php  echo e($r[14]);  ?></td>
             <td align=center class="style24"> <a href="upd_vip_order.php?id=<?php echo e(u($r[9])); ?>" 
target="popup" 
onclick="window.open('upd_vip_order.php?id=<?php echo e(u($r[9])); ?>&st_class=<?php echo e(u($r[8]))?>','popup','width=1000,height=800'); return false;"><?php  echo e($status);  ?></a></td>
           </tr>
           <?php $status='';$r[8] ='';		}} ?>
         <tfoot>
         </tfoot>
       </table>
       <li class="item"></li>
       <h4 class="box-title">Count : <?php echo e($activity) ?></h4>
		 <?php } ?>
     </ul>
   </div>


           <!-- /.box-body -->
         </div>
	 </form>	
         <div class="box box-primary">

 <div class="box box-primary">
   <!-- /.box-header -->
                                 <div id="booking" class="panel-collapse collapse">

									 </a><!-- /.box-body -->
   <div class="box-footer text-center"> <a href="leads.php?q=3" class="uppercase">View All Leads</a> </div>
   <!-- /.box-footer -->
 </div>
   <?php } ?>
 </div>
<!-- ./wrapper -->

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
