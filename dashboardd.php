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
elseif(num($kd_area) == 42){$area = q_set($__p_area, " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')");}
elseif(num($kd_area) == 41){$area = q_set($__p_area, " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')");}
elseif(num($kd_area) == 31){$area = q_set($__p_area, " and (kd_branch= '1' or kd_branch= '2')");}
elseif(num($kd_area) == 21) {$area = q_set($__p_area, " and (kd_branch= '2'or kd_branch= '8')");}
elseif(num($kd_area) == 2){$area = q_set($__p_area, " and kd_branch= ? ", [(string) ($kd_cbg)]);}
else {$area = q_set($__p_area, " and kd_branch= ? ", [(string) ($kd_cbg)]);}	
$query = q_set($__p_query, "SELECT concat_ws(' ' ,t.nama, t.middle_name, t.family_name), t.hp, t.ves_status, t.vip_status, \r
\tt.remark, t.vip_remark,t.date_fu,t.next_fu,date_format(t.dt_entry,'%d %M %Y'),t.kd_biodata,org_school, grade FROM ves_inc.tb_biodata t");
//======
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
 <?php //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <?php if ($kelompok !='ACD' and $kelompok !='ACC' and $posisi !='Admin')
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
				  
$query_plan = q_set($__p_query_plan, $query . $query_filter . " limit 5 ", [...($__p_query ?? []), ...($__p_query_filter ?? [])]);
 
$result=db_query_or_die("Wah error nih1", $query_plan, $__p_query_plan ?? []);
$query_plan_all = q_set($__p_query_plan_all, $query . $query_filter, [...($__p_query ?? []), ...($__p_query_filter ?? [])]);

$result_plan_all=db_query_or_die("Wah error nih1", $query_plan_all, $__p_query_plan_all ?? []);
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
$query_new = q_set($__p_query_new, $query . $query_filter . " limit 5 ", [...($__p_query ?? []), ...($__p_query_filter ?? [])]);	  
$result=db_query_or_die("Wah error nih1", $query_new, $__p_query_new ?? []);
	 
$query_new_all = q_set($__p_query_new_all, $query . $query_filter, [...($__p_query ?? []), ...($__p_query_filter ?? [])]);	
$result_all=db_query_or_die("Wah error nih1", $query_new_all, $__p_query_new_all ?? []);
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
		  
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);					
if ($result) 
	{ 
	while ($r = db_fetch($result))
		{	
		$query_dtl = q_set($__p_query_dtl, "SELECT concat_ws(' ' ,t.nama, t.middle_name, t.family_name), t.hp, t.ves_status, t.vip_status, \r
\t\t\tt.remark, t.vip_remark,t.date_fu,t.next_fu,date_format(t.dt_entry,'%d %M %Y') FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($r[0])]);
		$result_dtl=db_query_or_die("Wah error nih1", $query_dtl, $__p_query_dtl ?? []);
			
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
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
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
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
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
$query = q_set($__p_query, "SELECT date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y') FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail");

//===========academic==
?>
   <section class="content-header">
         <h1>
			 Dashboard</h1>
         <div class="box box-solid">
           <div class="box-header with-border">
             <h3 class="box-title">Collapsible Accordion</h3>
           </div>
           <!-- /.box-header -->
           <div class="box-body">
             <div class="box-group" id="accordion">
               <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
               <div class="panel box box-primary">
                 <div class="box-header with-border">
                   <h4 class="box-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> Collapsible Group Item #1 </a> </h4>
                 </div>
                 <div id="collapseOne" class="panel-collapse collapse in">
                   <div class="box-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                     wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                     eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                     assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                     nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                     farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                     labore sustainable VHS. </div>
                 </div>
               </div>
               <div class="panel box box-danger">
                 <div class="box-header with-border">
                   <h4 class="box-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> Collapsible Group Danger </a> </h4>
                 </div>
                 <div id="collapseTwo" class="panel-collapse collapse">
                   <div class="box-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                     wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                     eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                     assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                     nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                     farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                     labore sustainable VHS. </div>
                 </div>
               </div>
               <div class="panel box box-success">
                 <div class="box-header with-border">
                   <h4 class="box-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"> Collapsible Group Success </a> </h4>
                 </div>
                 <div id="collapseThree" class="panel-collapse collapse">
                   <div class="box-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                     wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                     eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                     assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                     nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                     farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                     labore sustainable VHS. </div>
                 </div>
               </div>
             </div>
           </div>
           <!-- /.box-body -->
         </div>
         <div class="box box-primary">
   <div class="box-header with-border">
     <h4 class="box-title"> <a data-toggle="collapse" data-parent="#accordion" href="#todayact">Today's Activity</a></h4>
   </div>
   <!-- /.box-header -->
                              <div id="todayact" class="panel-collapse collapse">
             <div class="box-body">
              <ul class="products-list product-list-in-box">
<?php
if ($posisi == 'FTT')
{				  
$query_filter = q_set($__p_query_filter, " where v.mulai_tm like ? and a.nm_teacher = ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%", (string) ($nama_lengkap)]);
}
elseif ($posisi == 'AS')
{
$query_filter = q_set($__p_query_filter, " where v.mulai_tm like ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%"]);	
}
elseif ($posisi == 'ACDH')
{
$query_filter = q_set($__p_query_filter, " where v.mulai_tm like ? and (status_kelas = '1' or status_kelas like '%1')", [(string) ($hari_ini) . "%"]);	
}
				  
$query_plan = q_set($__p_query_plan, $query . $query_filter . "  order by  v.mulai_tm ", [...($__p_query ?? []), ...($__p_query_filter ?? [])]); 
 
		  
?>
<br>
<div id="todaysact" class="panel-collapse collapse">
<table width="100%" class="table table-bordered table-striped" id="example2">
  <tbody>
    <tr>
      <td width="12%" height="14" align=center class="style24">Teacher's Name</td>
      <td width="11%" align=center class="style24">Class</td>
      <td width="20%" align=center class="style24">Schedule</td>
      <td width="10%" align=center class="style24">Room</td>
      <td width="17%" align=center class="style24">Description</td>
      <td width="17%" align=center class="style24">Status</td>
      </tr>
      <?php 
      $result=db_query_or_die("Wah error nih1", $query_plan, $__p_query_plan ?? []);
if ($result) 
	{ 
	while ($r = db_fetch($result, PDO::FETCH_NUM))
		{	?>
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
  <tfoot>
  </tfoot>
</table>
	</a>
                 <li class="item"></li>
            
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
     <h3 class="box-title">Teacher's Booking</h3>
     <div class="box-tools pull-right">
       <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
       <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
     </div>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
     <ul class="products-list product-list-in-box">
       <?php
if ($posisi == 'FTT')
{				  
$query_filter = q_set($__p_query_filter, " where  a.nm_teacher = ?  and    ( status_kelas = '50' or status_kelas = '60' or status_kelas = '70' or status_kelas = '90') ", [(string) ($nama_lengkap)]);
}
elseif ($posisi == 'AS')
{
$query_filter = q_set($__p_query_filter, "  where   ( status_kelas = '50' or status_kelas = '60' or status_kelas = '70' or status_kelas = '90') ");	
}
elseif ($posisi == 'ACDH')
{
$query_filter = q_set($__p_query_filter, " where      ( status_kelas = '50' or status_kelas = '60' or status_kelas = '70' or status_kelas = '90')  ");	
}
				  
$query_plan = q_set($__p_query_plan, $query . $query_filter . "  order by  v.mulai_tm ", [...($__p_query ?? []), ...($__p_query_filter ?? [])]); 
 
		  
?>
       <br>
       <table width="100%" class="table table-bordered table-striped" id="example">
         <tbody>
           <tr>
             <td width="12%" align=center class="style24">Date Request<br>
               By</td>
             <td width="12%" height="14" align=center class="style24">Teacher's Requested</td>
             <td width="11%" align=center class="style24">Class</td>
             <td width="20%" align=center class="style24">Schedule Requested</td>
             <td width="10%" align=center class="style24">Room</td>
             <td width="17%" align=center class="style24">Description</td>
             <td width="17%" align=center class="style24">Status</td>
           </tr>
           <?php 
      $result=db_query_or_die("Wah error nih1", $query_plan, $__p_query_plan ?? []);
if ($result) 
	{ 
	while ($r = db_fetch($result, PDO::FETCH_NUM))
		{	?>
           <tr>
             <td align=center class="style24"><?php echo  e($r[11]);  ?><br>
               <?php echo  e($r[10]);  ?></td>
             <td height="14" align=center class="style24"><?php echo  e($r[1]);  ?></td>
             <td align=center class="style24"><?php  echo  e($r[4]);  ?>
               <br>
               <?php  echo e($r[7]);  ?></td>
             <td align=center class="style24"><?php echo  e($r[2]);  ?> - <?php echo  e($r[3]);  ?></td>
             <td align=center class="style24"><?php echo  e($r[5]);  ?> <br></td>
             <td align=center class="style24"><?php  echo e($r[6]);  ?></td>
             <td align=center class="style24"><?php  echo e($r[8]);  ?></td>
           </tr>
           <?php }} ?>
         <tfoot>
         </tfoot>
       </table>
       <li class="item"></li>
       <h4 class="box-title">Count : <?php echo e($angka) ?></h4>
     </ul>
   </div>
   <!-- /.box-body -->
   <div class="box-footer text-center"> <a href="leads.php?q=3" class="uppercase">View All Leads</a> </div>
   <!-- /.box-footer -->
 </div>
   </section>
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
</body>
</html>
