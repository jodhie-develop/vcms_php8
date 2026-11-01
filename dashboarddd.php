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
$query_ambil_foto = q_set($__p_query_ambil_foto, "SELECT lokasifile  from tb_user where no = ? ", [(string) ($kd_staff)]);
$result_foto=db_query_or_die("Wah error nih9", $query_ambil_foto, $__p_query_ambil_foto ?? []);
while ($r_foto = db_fetch($result_foto, PDO::FETCH_NUM))
	{
	$fotoku = $r_foto[0];	
	}


if (num($kd_area) == 5){$area ="";}
elseif(num($kd_area) == 42){$area = q_set($__p_area, " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')");}
elseif(num($kd_area) == 41){$area = q_set($__p_area, " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')");}
elseif(num($kd_area) == 31){$area = q_set($__p_area, " and (kd_branch= '1' or kd_branch= '2')");}
elseif(num($kd_area) == 21) {$area = q_set($__p_area, " and (kd_branch= '2'or kd_branch= '8')");}
elseif(num($kd_area) == 2){$area = q_set($__p_area, " and kd_branch= ? ", [(string) ($kd_cbg)]);}
else {$area = q_set($__p_area, " and kd_branch= ? ", [(string) ($kd_cbg)]);}	
$query = q_set($__p_query, "SELECT concat_ws(' ' ,t.nama, t.middle_name, t.family_name), t.hp, t.ves_status, t.vip_status, \r
\tt.remark, t.vip_remark,t.date_fu,t.next_fu,date_format(t.dt_entry,'%d %M %Y'),t.kd_biodata,org_school, grade FROM ves_inc.tb_biodata t");

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
 <?php    include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <?php if ($kelompok !='ACD' and $kelompok !='ACC' and $posisi !='Admin' and $posisi !='LIU')
{?>
 <section class="content-header">
          <h1>
        Dashboard</h1>
 <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Today's Follow Up Planning</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
<?php
if ($posisi == 'AC' or $posisi == 'SC' or $posisi == 'Admission')
{				  
$query_filter = q_set($__p_query_filter, " where  date_fu = ? and pic = ? group by kd_biodata order by dt_entry desc ", [(string) ($hari_ini), (string) ($nama_lengkap)]);
}
elseif ($posisi == 'CM')
{
$query_filter = q_set($__p_query_filter, " where  date_fu = ? and kd_branch = ? group by kd_biodata order by dt_entry desc ", [(string) ($hari_ini), (string) ($kd_cbg)]);	
}
elseif ($posisi == 'AM')
{
$query_filter = q_set($__p_query_filter, " where  date_fu = ? " . $area . " group by kd_biodata order by dt_entry desc ", [(string) ($hari_ini), ...($__p_area ?? [])]);	
}
elseif ($kelompok == 'LIU')
{
$query_filter = q_set($__p_query_filter, " where  kd_branch = ? ", [(string) ($kd_cbg)]);	
}				  
$query_plan = q_set($__p_query_plan, $query . $query_filter . " limit 5 ", [...($__p_query ?? []), ...($__p_query_filter ?? [])]);
 
$result=db_query_or_die("Wah error nih1", $query_plan, $__p_query_plan ?? []);
$query_plan_all = q_set($__p_query_plan_all, $query . $query_filter, [...($__p_query ?? []), ...($__p_query_filter ?? [])]);

$result_plan_all=db_query_or_die("Wah error nih2", $query_plan_all, $__p_query_plan_all ?? []);
$num_rows_all = db_num_rows($result_plan_all);					  
$angka = $num_rows_all;				  
if ($result) 
	{ 
	while ($r = db_fetch($result))
		{			  
?>
<br>
                <li class="item">
                  <div class="product-img">
                    <img src="dist/img/default-50x50.gif" alt="Product Image">
                  </div>
                  <div class="product-info">
					  <a href="profile.php?kdb=<?php echo e(u($r[9])) ?>"><?php echo e($r[0]) ?>
(<?php echo e($r[1]) ?>) <span class="label label-warning pull-right">VES : <?php echo e($r[2]) ?></span></a> / <?php echo e($r[10]) ?> <?php echo e($r[11]) ?> <br> 
<span class="label label-warning pull-right">VIP : <?php echo e($r[3]) ?></span></a>
                       <span class="product-description">
                        Last Remark :  <?php echo e($r[4]) ?>
                        <?php echo e($r[5]) ?></span>
                        <span class="product-description">
                          <?php echo e($r[7]) ?>
                        </span>
                  </div>
                </li>
                <?php }}?>
                <h4 class="box-title">Count : <?php echo e($angka) ?></h4>

              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="leads.php?q=3" class="uppercase">View All Leads</a>
            </div>
            <!-- /.box-footer -->
   </div>
 <div class="box box-primary">
   <div class="box-header with-border">
     <h3 class="box-title">Recently New Leads</h3>
     <div class="box-tools pull-right">
       <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
       <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
     </div>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
     <ul class="products-list product-list-in-box">
       <?php
 $query_filter = '';		 
if ($posisi == 'AC' or $posisi == 'SC' or $posisi == 'Admission')
{				  
$query_filter = q_set($__p_query_filter, " where (ves_status is null or ves_status = '') and (vip_status is null or vip_status = '') and  pic = ? and dt_entry between ? and ? group by kd_biodata order by dt_entry desc ", [(string) ($nama_lengkap), (string) ($date_start), (string) ($date_end)]);
}
elseif ($posisi == 'CM')
{
$query_filter = q_set($__p_query_filter, " where (ves_status is null or ves_status = '') and (vip_status is null or vip_status = '') and    kd_branch = ? and dt_entry between ? and ?  group by kd_biodata order by dt_entry desc ", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);	
}
elseif ($posisi == 'AM')
{
$query_filter = q_set($__p_query_filter, " where (ves_status is null or ves_status = '') and (vip_status is null or vip_status = '')  and dt_entry between ? and ?    " . $area . " group by kd_biodata order by dt_entry desc ", [(string) ($date_start), (string) ($date_end), ...($__p_area ?? [])]);	
}
elseif ($kelompok == 'LIU')
{
$query_filter = q_set($__p_query_filter, " where  kd_branch = ? ", [(string) ($kd_cbg)]);	
}	
$query_new = q_set($__p_query_new, $query . $query_filter . " limit 5 ", [...($__p_query ?? []), ...($__p_query_filter ?? [])]);	  
$result=db_query_or_die("Wah error nih3", $query_new, $__p_query_new ?? []);
	 
$query_new_all = q_set($__p_query_new_all, $query . $query_filter, [...($__p_query ?? []), ...($__p_query_filter ?? [])]);	
$result_all=db_query_or_die("Wah error nih4", $query_new_all, $__p_query_new_all ?? []);
$num_rows_all = db_num_rows($result_all);		 
$angka = $num_rows_all;			 
if ($result) 
	{ 
	while ($r = db_fetch($result))
		{				  
?>
       <li class="item">
         <div class="product-img"> <img src="dist/img/default-50x50.gif" alt="Product Image"> </div>
         <div class="product-info"> <a href="profile.php?kdb=<?php echo e(u($r[9])) ?>" class="product-title"><?php echo e($r[0]) ?> (<?php echo e($r[1]) ?>) </a> / <?php echo e($r[10]) ?> <?php echo e($r[11]) ?> <br>
         </a> <span class="product-description">  Remark : <?php echo e($r[4]) ?> (<?php echo e($r[8]) ?>)</span> <span class="product-description"> <?php echo e($r[7]) ?> </span> </div>
       </li>
       <?php }}?>
                <h4 class="box-title">Count : <?php echo e($angka) ?> </h4>       
     </ul>
   </div>
   <!-- /.box-body -->
   <div class="box-footer text-center"> <a href="leads.php?q=3" class="uppercase">View All Leads</a> </div>
   <!-- /.box-footer -->
 </div>
 <div class="box box-primary">
   <div class="box-header with-border">
     <h3 class="box-title">Recently Follow Up Leads</h3>
     <div class="box-tools pull-right">
       <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
       <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
     </div>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
     <ul class="products-list product-list-in-box">
       <?php
		 
if ($posisi == 'AC' or $posisi == 'SC' or $posisi == 'Admission')
{				  
$query = q_set($__p_query, "SELECT a.kd_biodata, progress, status, vip_status, date_update,a.no FROM ves_inc.tb_progres_ves a\r
inner join  (SELECT max(no) c, kd_biodata FROM ves_inc.tb_progres_ves b\r
group by kd_biodata) b on a.no = b.c and a.kd_biodata = b.kd_biodata  where a.pic = ? order by a.no desc limit 5", [(string) ($nama_lengkap)]);
}
elseif ($posisi == 'CM')
{
$query = q_set($__p_query, "SELECT a.kd_biodata, progress, status, vip_status, date_update,a.no FROM ves_inc.tb_progres_ves a\r
inner join  (SELECT max(no) c, kd_biodata FROM ves_inc.tb_progres_ves b\r
group by kd_biodata) b on a.no = b.c and a.kd_biodata = b.kd_biodata  where a.pic = ? order by a.no desc limit 5", [(string) ($nama_lengkap)]);
}
elseif ($posisi == 'AM')
{
$query = q_set($__p_query, "SELECT a.kd_biodata, progress, status, vip_status, date_update,a.no FROM ves_inc.tb_progres_ves a\r
inner join  (SELECT max(no) c, kd_biodata FROM ves_inc.tb_progres_ves b\r
group by kd_biodata) b on a.no = b.c and a.kd_biodata = b.kd_biodata  where a.pic = ? order by a.no desc limit 5", [(string) ($nama_lengkap)]);
}
elseif ($kelompok == 'LIU')
{

$query = q_set($__p_query, "SELECT a.kd_biodata, progress, status, vip_status, date_update,a.no FROM ves_inc.tb_progres_ves a\r
inner join  (SELECT max(no) c, kd_biodata FROM ves_inc.tb_progres_ves b\r
group by kd_biodata) b on a.no = b.c and a.kd_biodata = b.kd_biodata where  kd_branch = ?  order by a.no desc limit 5", [(string) ($kd_cbg)]);	
}		  
$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);					
if ($result) 
	{ 
	while ($r = db_fetch($result))
		{	
		$query_dtl = q_set($__p_query_dtl, "SELECT concat_ws(' ' ,t.nama, t.middle_name, t.family_name), t.hp, t.ves_status, t.vip_status, \r
\t\t\tt.remark, t.vip_remark,t.date_fu,t.next_fu,date_format(t.dt_entry,'%d %M %Y') FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($r[0])]);
		$result_dtl=db_query_or_die("Wah error nih6", $query_dtl, $__p_query_dtl ?? []);
			
		if ($result_dtl) 
			{ 
			while ($r_dtl = db_fetch($result_dtl))
				{
				$namastudent = $r_dtl[0];
				$hp  = $r_dtl[1];
				}
			}

?>
       <li class="item">
         <div class="product-img"> <img src="dist/img/default-50x50.gif" alt="Product Image"> </div>
         <div class="product-info"> <a href="profile.php?kdb=<?php echo e(u($r[0])) ?>" class="product-title"><?php echo e($namastudent) ?> (<?php echo e($hp) ?>)</a> <span class="label label-warning pull-right">VES : <?php echo e($r[2]) ?></span> / <?php echo e($r[10]) ?> <?php echo e($r[11]) ?> <br>
           <span class="label label-warning pull-right">VIP : <?php echo e($r[3]) ?></span></a> <span class="product-description">  Remark : <?php echo e($r_dtl[1]) ?> <?php echo e($r[5]) ?></span> <span class="product-description"> <?php echo e($r[7]) ?> </span> </div>
       </li>
       <?php }}?>
     </ul>
   </div>
   <!-- /.box-body -->
   <div class="box-footer text-center"> <a href="leads.php?q=3" class="uppercase">View All Leads</a> </div>
   <!-- /.box-footer -->
 </div>
 <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> Potential Enrollment</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->VES
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                <li class="item">
                  <div class="product-img">
                    <img src="dist/img/default-50x50.gif" alt="Product Image">
                  </div>
       <?php
		  
if ($posisi == 'AC' or $posisi == 'SC' or $posisi == 'Admission')
{				  
$query = q_set($__p_query, "SELECT a.kelompok, a.kd_biodata, concat_ws(' ',b.nama,b.middle_name,b.family_name),b.org_school, b.grade,  a.remark, a.status FROM ves_data.tb_prospect a left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata where a.pic = ? and a.kd_branch = ? and Year(a.dt_target) = ? and Month(a.dt_target) = ? and kelompok = 'VES'", [(string) ($nama_lengkap), (string) ($kd_cbg), (string) ($tahun), (string) ($bulan)]);
}
elseif ($posisi == 'CM')
{
$query = q_set($__p_query, "SELECT a.kelompok, a.kd_biodata, concat_ws(' ',b.nama,b.middle_name,b.family_name),b.org_school, b.grade,  a.remark, a.status FROM ves_data.tb_prospect a left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata where a.kd_branch = ? and Year(a.dt_target) = ? and Month(a.dt_target) = ? and kelompok = 'VES'", [(string) ($kd_cbg), (string) ($tahun), (string) ($bulan)]);
}
elseif ($posisi == 'AM')
{
$query = q_set($__p_query, "SELECT a.kelompok, a.kd_biodata, concat_ws(' ',b.nama,b.middle_name,b.family_name),b.org_school, b.grade,  a.remark, a.status FROM ves_data.tb_prospect a left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata where Year(a.dt_target) = ? and Month(a.dt_target) = ? and kelompok = 'VES'" . $area, [(string) ($tahun), (string) ($bulan), ...($__p_area ?? [])]);
}	
elseif ($kelompok == 'LIU')
{
$query_filter = q_set($__p_query_filter, " where  kd_branch = ? ", [(string) ($kd_cbg)]);	
}	
$result=db_query_or_die("Wah error nih7", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);					
if ($result) 
	{ 
	while ($r = db_fetch($result))
		{	

?>                  
                  <div class="product-info">
					  <a href="javascript:void(0)" class="product-title"><?php echo e($r[2]) ?> </span>  <span class="label label-warning pull-right">$1800</span></a> /<?php echo e($r[3]) ?> - <?php echo e($r[4]) ?>
                        <span class="product-description">
                          Remark : <?php echo e($r[5]) ?></span>
                  </div> 
                  <?php } } ?>
                </li>

              </ul>
            </div>
VIP            
<div class="box-body">
              <ul class="products-list product-list-in-box">
                <li class="item">
                  <div class="product-img">
                    <img src="dist/img/default-50x50.gif" alt="Product Image">
                  </div>
       <?php
		 
if ($posisi == 'AC' or $posisi == 'SC' or $posisi == 'Admission')
{				  
$query = q_set($__p_query, "SELECT a.kelompok, a.kd_biodata, concat_ws(' ',b.nama,b.middle_name,b.family_name),b.org_school, b.grade,  a.remark, a.status FROM ves_data.tb_prospect a left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata where a.pic = ? and a.kd_branch = ? and Year(a.dt_target) = ? and Month(a.dt_target) = ? and kelompok = 'VIP'", [(string) ($nama_lengkap), (string) ($kd_cbg), (string) ($tahun), (string) ($bulan)]);
}
$result=db_query_or_die("Wah error nih8", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);					
if ($result) 
	{ 
	while ($r = db_fetch($result))
		{	

?>                  
                  <div class="product-info">
                    <a href="list_pot.php" class="product-title"><?php echo e($r[2]) ?></span><span class="label label-warning pull-right">$1800</span></a> /<?php echo e($r[3]) ?> - <?php echo e($r[4]) ?>
                        <span class="product-description">
                          Remark : <?php echo e($r[5]) ?></span>
                  </div> <?php } } ?>
                </li>

              </ul>
    </div>            
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="list_pot.php" class="uppercase">View All Potential</a>
            </div>
            <!-- /.box-footer -->
   </div>                 
   </section>
<?php }elseif ($kelompok == 'ACD'){
$query_notif= q_set($__p_query_notif, "select status_kelas from ves_data.vip_teacher_schedule where status_kelas = 50 or status_kelas = 60 or status_kelas = 70 or status_kelas = 80 or status_kelas = 90");
$result_notif=db_query_or_die("Wah error nih9", $query_notif, $__p_query_notif ?? []);	
$jml_notif = db_num_rows($result_notif);
$query = q_set($__p_query, "SELECT date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap,max(v.id) FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata");

//===========academic==
?>
   <section class="content-header">
         <h1>
			 Dashboard</h1>
			 	      <ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#disccusion">My Profile</a></li> 			 	      
    <li><a data-toggle="pill" href="#todayact">Today's Activities</a></li>   
    <li><a data-toggle="pill" href="#listagenda">List Agenda</a></li>
    <li><a data-toggle="pill" href="#meetingorder">Meeting Order
    <?php if (num($jml_notif) <> 0 ){?>
    <span class="badge bg-red"><?php echo e($jml_notif) ?></span>
   	<?php } ?>
    </a>
    </li>    
  </ul>
 <div class="box box-solid">
   <!-- /.box-header -->
           <div class="box-body">

               <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
               <div class="tab-content">
<div id="disccusion" class="tab-pane fade in active">  
   <div class="box-body">
<div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo e($fotoku) ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo e($_SESSION['nama_lengkap']) ?></h3>

              <p class="text-muted text-center">Academic</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Position</b> <a class="pull-right"><?php echo e($_SESSION['posisi']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Center</b> <a class="pull-right"><?php echo e($prof_cbg) ?></a>
                </li>
              </ul>

              <a href="imgupld.php?kdstaff=<?php echo e(u($kd_staff)) ?>" 
				target="popup" 
				onclick="window.open('imgupld.php?kdstaff=<?php echo e(u($kd_staff)) ?>','popup','width=1000,height=800'); return false;" class="btn btn-primary btn-block"><b>My Picture</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <blockquote>
                <h3 class="box-title"><b>TO DO LIST</b>              </h3>
              </blockquote>
            </div>
            <!-- /.box-header -->
<?php
$query_personal = q_set($__p_query_personal, "SELECT v.kelas, v.room, v.keterangan ,v.center,date_format (v.mulai_tm,'%H:%i') FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher  left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata where v.mulai_tm like ? and a.kd_user = ? and (status_kelas = '1' or status_kelas like '%1') group by v.kd_biodata, v.kelas,status_kelas order by v.mulai_tm", [(string) ($hari_ini) . "%", (string) ($kd_staff)]);
      $result_personal=db_query_or_die("Wah error nih9", $query_personal, $__p_query_personal ?? []);
if ($result_personal) 
	{ 
	while ($r_profile = db_fetch($result_personal, PDO::FETCH_NUM))
		{		
?>
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i><?php echo e($r_profile[0]) ?> <br> <?php echo e($r_profile[4]) ?></strong>

              <p class="text-muted">
                <?php echo e($r_profile[1]) ?> <?php echo e($r_profile[2]) ?> <?php echo e($r_profile[3]) ?>
              </p>

              <hr>

            </div>
<?php }}
?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>   
<div class="col-md-8">            
	<div class="panel box box-danger">
	<div class="box-header with-border">
	<h4 class="box-title">New Topics</h4>
	</div>
	</div> 
	


  <!-- Box Comment -->
  <div class="box box-widget">
    <div class="box-header with-border">
      <div class="user-block"> <img class="img-circle" src="<?php echo e($fotoku) ?>" alt="User Image"> <span class="username"><a href="#"><form action="newpost.php?t=1" method="post" target="POPUPW"
    onsubmit="POPUPW = window.open('about:blank','POPUPW',
   'width=600,height=400');"><?php echo csrf_field(); ?>


       <!-- .img-push is used to add margin to elements next to floating images -->
        <div class="img-push">
			<textarea class="textareas" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="thread"></textarea>
          <input type="submit" name="sub" value="Publish">
        </div>

    </form>    
     </a></span></div>
      <!-- /.user-block -->

      <!-- /.box-tools -->
    </div>
    <!-- /.box-header --><!-- /.box-body --><!-- /.box-footer -->
    <!-- /.box-footer -->
  </div>
  <!-- /.box -->
<div class="panel box box-danger">
<div class="box-header with-border">
<h4 class="box-title">Discussion</h4>
</div>
</div> 	
   <div class="box-body">
<?php 
$query_thread = q_set($__p_query_thread, "SELECT d.kd_topik, d.kd_ref, d.pesan, date_format(d.dt_entry,'%d %b %y %H:%i'), d.pic, c.nama_detail, c.posisi, c.branch,d.id,c.lokasifile FROM disc_topik d  join tb_user c on d.pic = c.no where d.kd_topik = 1 order by d.dt_entry desc");
$resource_thread= db_query_or_die('errro_visitor1', $query_thread, $__p_query_thread ?? []);
$keluar_thread= db_num_rows($resource_thread);
		if(num(db_num_rows($resource_thread)) > 0)
			{
			while ($row_thread=  db_fetch($resource_thread, PDO::FETCH_NUM))
				{
?>	
     <div class="col-md-12">
          <!-- Box Comment -->
          <div class="box box-widget">
      
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="<?php echo e($row_thread[9]) ?>" alt="User Image">
                <span class="username"><a href="#"><?php echo e($row_thread[5]) ?></a></span>
                <span class="description">Shared publicly - <?php echo  e(($row_thread[3])) ?></span>

                    <!-- .img-push is used to add margin to elements next to floating images -->

                      <textarea class="textareas"  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly><?php echo e($row_thread[2]) ?></textarea>

              </div>
              <!-- /.user-block -->
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                  <i class="fa fa-circle-o"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">


              <!-- Attachment --><!-- /.attachment-block -->
					
              <!-- Social sharing buttons -->
<?php
$query_reply = q_set($__p_query_reply, "SELECT d.pesan, date_format(d.dt_entry,'%d %b %y %H:%i'), d.pic, c.nama_detail, c.posisi, c.branch,d.id,c.lokasifile FROM disc_topik d left join tb_user c on d.pic = c.no where d.kd_topik = 2 and kd_ref = ?  order by d.dt_entry desc", [(string) ($row_thread[8])]);
	
$resource_reply= db_query_or_die('errro_visitor2', $query_reply, $__p_query_reply ?? []);
$keluar_reply= db_num_rows($resource_reply);
				
?>              
              <span class="pull-right text-muted"><?php echo e($keluar_reply) ?> comments</span>
            </div>
            <!-- /.box-body -->
<?php
if(num(db_num_rows($resource_reply)) > 0)
	{
	while ($row_reply=  db_fetch($resource_reply, PDO::FETCH_NUM))
		{						
?>					
            <div class="box-footer box-comments">
              <div class="box-comment">
                <!-- User image -->
                <img class="img-circle img-sm" src="<?php echo e($row_reply[7]) ?>" alt="User Image">

                <div class="comment-text">
                      <span class="username">
                        <?php echo e($row_reply[3]) ?>
                        <span class="text-muted pull-right"><?php echo e($row_reply[1]) ?></span>
                      </span><!-- /.username -->
                   <?php echo e($row_reply[0]) ?>
                </div>
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
              <!-- /.box-comment -->
            </div>
<?php }} ?>
                        <!-- /.box-footer -->
            <div class="box-footer">
<form action="newpost.php?t=2&r=<?php echo e(u($row_thread[8])) ?>" method="post" target="POPUPW"
    onsubmit="POPUPW = window.open('about:blank','POPUPW',
   'width=600,height=400');"><?php echo csrf_field(); ?>

                <img class="img-responsive img-circle img-sm" src="<?php echo e($fotoku) ?>" alt="Alt Text">
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
          <input type="text" class="form-control input-sm" placeholder="Press enter to Reply Topic" name="thread">
                  <a href="#">
                  <input type="submit" name="sub2" value="Publish">
                </a>                </div>
              </form>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
<?php } } ?>
     </div>  
</div>
   </div>

   </div>               
    <div id="todayact" class="tab-pane fade in">
               <div class="panel box box-primary">
                 <div class="box-header with-border">
                   <h4 class="box-title"> <a data-toggle="collapse" data-parent="#accordion" href="#todayact">Today's Activity</a></h4>
                 </div>
    
             <div class="box-body">
             
<?php
$query_filter_personal = q_set($__p_query_filter_personal, " where v.mulai_tm like ? and a.nm_teacher = ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%", (string) ($nama_lengkap)]);	
if ($posisi == 'FTT')
{
if ($nama_lengkap == 'Rustian Akbar Gunadi' or $nama_lengkap == 'Eka Yuliawati')
{
$query_filter = q_set($__p_query_filter, " where v.mulai_tm like ? and (a.nm_teacher = 'Rustian Akbar Gunadi' or a.nm_teacher = 'Eka Yuliawati') and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%"]);

}
else
{
$query_filter = q_set($__p_query_filter, " where v.mulai_tm like ? and a.nm_teacher = ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%", (string) ($nama_lengkap)]);
}
}
elseif ($posisi == 'AS')
{
$query_filter = q_set($__p_query_filter, " where v.mulai_tm like ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%"]);	
}
elseif ($posisi == 'ACDH')
{
$query_filter = q_set($__p_query_filter, " where v.mulai_tm like ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%"]);	
}
				  
$query_plan = q_set($__p_query_plan, $query . $query_filter . " group by v.kd_biodata, v.kelas,status_kelas order by  v.mulai_tm ", [...($__p_query ?? []), ...($__p_query_filter ?? [])]); 
 
$query_personal = q_set($__p_query_personal, $query . $query_filter_personal . " group by v.kd_biodata, v.kelas,status_kelas order by  v.mulai_tm ", [...($__p_query ?? []), ...($__p_query_filter_personal ?? [])])?>
<br>
<table width="100%" class="table table-bordered table-striped" id="example2">
  <thead>
    <tr>
      <td width="12%" height="14" align=center class="style24">Teacher's Name</td>
      <td width="11%" align=center class="style24">Class</td>
      <td width="20%" align=center class="style24">Schedule</td>
      <td width="10%" align=center class="style24">Room</td>
      <td width="17%" align=center class="style24">Description</td>
      <td width="17%" align=center class="style24">Status</td>
      </tr>
	</thead>
      <tbody>
      <?php 

      $result=db_query_or_die("Wah error nih9", $query_plan, $__p_query_plan ?? []);
if ($result) 
	{ 
	while ($r = db_fetch($result, PDO::FETCH_NUM))
		{

		  ?>
    <tr>
      <td height="14" align=center class="style24"><?php echo  e($r[1]);  ?></td>
      <td align=center class="style24"><?php  echo  e($r[4]);  ?>
        <br>
        <?php  echo e($r[7]);  ?></td>
      <td align=center class="style24"><?php echo  e($r[2]);  ?> -  <?php echo  e($r[3]);  ?></td>
      <td align=center class="style24"><?php echo  e($r[5]);  ?>
        <br></td>
      <td align=center class="style24"><?php  echo e($r[6]);  ?></td>
      <td align=center class="style24"><?php  echo e($r[8]);  ?></td>
      </tr><?php }} ?>
	</tbody>
  <tfoot>
  </tfoot>
</table>
	</a>

              </ul>
            </div>
              
               </div>
			   </div>
        <div id="listagenda" class="tab-pane fade in ">
               <div class="panel box box-primary">
                 <div class="box-header with-border">
                   <h4 class="box-title"> <a data-toggle="collapse" data-parent="#accordion" href="#todayact">Today's Activity</a></h4>
                 </div>
    
             <div class="box-body">
             
<?php

if ($posisi == 'FTT')
	{
	if ($nama_lengkap == 'Rustian Akbar Gunadi' or $nama_lengkap == 'Eka Yuliawati')
		{

		$query_filter = q_set($__p_query_filter, " where v.dt_entry like ? and (a.nm_teacher = 'Rustian Akbar Gunadi' or a.nm_teacher = 'Eka Yuliawati') and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%"]);	
		}
	else
		{
		$query_filter = q_set($__p_query_filter, " where v.dt_entry like ? and a.nm_teacher = ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%", (string) ($nama_lengkap)]);
		}	



	}
elseif ($posisi == 'AS')
{
$query_filter = q_set($__p_query_filter, " where v.dt_entry like ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%"]);	
}
elseif ($posisi == 'ACDH')
{
$query_filter = q_set($__p_query_filter, " where v.dt_entry like ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%"]);	
}
				  
$query_plan = q_set($__p_query_plan, $query . $query_filter . " group by v.kd_biodata, v.kelas,status_kelas order by  v.mulai_tm ", [...($__p_query ?? []), ...($__p_query_filter ?? [])]); 
 
		  
?>
<br>
<table width="100%" class="table table-bordered table-striped" id="example2">
  <thead>
    <tr>
      <td width="12%" height="14" align=center class="style24">Teacher's Name</td>
      <td width="11%" align=center class="style24">Class</td>
      <td width="20%" align=center class="style24">Schedule</td>
      <td width="10%" align=center class="style24">Room</td>
      <td width="17%" align=center class="style24">Description</td>
      <td width="17%" align=center class="style24">Status</td>
      </tr>
	</thead>
      <tbody>
      <?php 

      $result=db_query_or_die("Wah error nih9", $query_plan, $__p_query_plan ?? []);
if ($result) 
	{ 
	while ($r = db_fetch($result, PDO::FETCH_NUM))
		{

		  ?>
    <tr>
      <td height="14" align=center class="style24"><?php echo  e($r[1]);  ?></td>
      <td align=center class="style24"><?php  echo  e($r[4]);  ?>
        <br>
        <?php  echo e($r[7]);  ?></td>
      <td align=center class="style24"><?php echo  e($r[2]);  ?> -  <?php echo  e($r[3]);  ?></td>
      <td align=center class="style24"><?php echo  e($r[5]);  ?>
        <br></td>
      <td align=center class="style24"><?php  echo e($r[6]);  ?></td>
      <td align=center class="style24"><?php  echo e($r[8]);  ?></td>
      </tr><?php }} ?>
	</tbody>
  <tfoot>
  </tfoot>
</table>
	</a>

              </ul>
            </div>
              
               </div>
			   </div>
<!-- forum start -->

    
<!-- form end===    			   			   -->
     <div id="meetingorder" class="tab-pane fade">              
               <div class="panel box box-danger">
                 <div class="box-header with-border">
                   <h4 class="box-title"> Teacher's Booking </h4>
                 </div>
		</div> 
	

   <div class="box-body">
     <ul class="products-list product-list-in-box">
       <?php
$nama_lengkap=  $_SESSION['nama_lengkap'];
if ($posisi == 'FTT')
	{

	if ($nama_lengkap == 'Rustian Akbar Gunadi' or $nama_lengkap == 'Eka Yuliawati')
		{

		$query_filter = q_set($__p_query_filter, " where v.dt_entry like ? and (a.nm_teacher = 'Rustian Akbar Gunadi' or a.nm_teacher = 'Eka Yuliawati') and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%"]);	
		$query_filter = q_set($__p_query_filter, " where  (a.nm_teacher = 'Rustian Akbar Gunadi' or a.nm_teacher = 'Eka Yuliawati')  and    ( status_kelas like '5%' or status_kelas like '6%' or status_kelas like '7%' or status_kelas like '8%' or status_kelas like '9%') ");	
		}
	else
		{	
	//	$query_filter = " where   ( status_kelas like '5%' or status_kelas like '6%' or status_kelas like '7%' or status_kelas like '8%' or status_kelas like '9%') ";
		$query_filter = q_set($__p_query_filter, " where  (a.nm_teacher = ? )  and    ( status_kelas like '5%' or status_kelas like '6%' or status_kelas like '7%' or status_kelas like '8%' or status_kelas like '9%') ", [(string) ($nama_lengkap)]);	
		}	
	}
elseif ($posisi == 'AS')
	{
	$query_filter = q_set($__p_query_filter, "  where   (  status_kelas like '5%' or status_kelas like '6%' or status_kelas like '7%' or status_kelas like '8%' or status_kelas like '9%') ");	
	}
elseif ($posisi == 'ACDH')
	{
	$query_filter = q_set($__p_query_filter, " where      (  status_kelas like '5%' or status_kelas like '6%' or status_kelas like '7%' or status_kelas like '8%' or status_kelas like '9%')  ");	
	}				  
$query_plan = q_set($__p_query_plan, $query . $query_filter . " group by kelas, mulai_tm,status_kelas, nm_teacher, v.kd_biodata order by  v.id desc ", [...($__p_query ?? []), ...($__p_query_filter ?? [])]); 

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
			if(($r[8] == '50') or ($r[8] == '60') or ($r[8] == '70') or ($r[8] == '80') or ($r[8] == '90')){$status = 'Booking';}
			if(($r[8] == '51') or ($r[8] == '61') or ($r[8] == '71') or ($r[8] == '81') or ($r[8] == '91')){$status = 'Approved';}
			if(($r[8] == '52') or ($r[8] == '62') or ($r[8] == '72') or ($r[8] == '82') or ($r[8] == '92')){$status = 'Rejected';}			
			
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
             <td align=center class="style24"><?php  echo e($r[6]);  ?></td>
             <td align=center class="style24"> <a href="upd_vip_order.php?id=<?php echo e(u($r[9])); ?>" 
target="popup" 
onclick="window.open('upd_vip_order.php?id=<?php echo e(u($r[9])); ?>','popup','width=1000,height=800'); return false;"><?php  echo e($status);  ?></a></td>
           </tr>
           <?php $status='';$r[8] ='';}} ?>
         <tfoot>
         </tfoot>
       </table>
       <li class="item"></li>
       <h4 class="box-title">Count : <?php echo e($angka) ?></h4>
     </ul>
   </div>
  </div>
   </div>
           <!-- /.box-body -->
         </div>
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
