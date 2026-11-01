<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php"; 
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

date_default_timezone_set('Asia/Jakarta');
$jamskrg= date('h:i:s', time());
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$loadpage = in_val('loadpage', 'any');
$opt_ves = in_val('opt_ves', 'any');
$opt_vip = in_val('opt_vip', 'any');
$nik = in_val('nik', 'any');


if ($loadpage == '' and $opt_ves == ''){$opt_ves = '1';}
if ($loadpage == '' and $opt_vip == ''){$opt_vip = '1';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;	
	
$hari_ini = "$tahun-$bulan-$hari";
$enroll_date = in_val('enroll_date', 'any');
$intake_date = in_val('intake_date', 'any');
$date_start = in_val('date_start', 'any');
$date_end = in_val('date_end', 'any');
$prioritas = in_val('prioritas', 'any');
$org_cur = in_val('org_cur', 'any');
$discount = in_val('discount', 'any');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$kdb = in_val('kdb', 'any');
//if ($kode_student ==''){$kode_student = in_val('kd_biodata', 'any');}
//======tampilkan detail
$query_detail = q_set($__p_query_detail, "SELECT t.nama, t.middle_name, t.family_name, DATE_FORMAT(t.dob,'%d %b %y'), t.gender, t.address, t.city, t.hm_ph, t.hp, t.org_school, t.grade, t.parent_nm, t.add_parent, t.city_parent, t.hp_parent, t.level_school, t.event_st_dtl, media_src, media_src_dtl, t.ves_last_update, t.vip_last_update, t.vip_remark, t.e_mail, t.hp_2, \r
t.mother_name, t.ph_mother, t.country_1, t.school_1, t.program_1, t.country_2, t.school_2, t.program_2, t.country_3, t.school_3, t.program_3, event_type,event_type_dtl, media_src, media_src_dtl,ves_status,vip_status \r
FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($kdb)]);

$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar_detail = db_num_rows($resource_detail);
if(num(db_num_rows($resource_detail)) > 0)
	{
	while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
		{
		$nama = $row_detail[0];
		$middle_name = $row_detail[1];
		$family_name = $row_detail[2];
		$dob = $row_detail[3];
		$gender = $row_detail[4];
		$address = $row_detail[5];
		$city = $row_detail[6];
		$hm_ph = $row_detail[7];
		$hp = $row_detail[8];
		$org_school = $row_detail[9];
		$grade = $row_detail[10];
		$parent_nm = $row_detail[11];
		$add_parent = $row_detail[12];
		$city_parent = $row_detail[13];
		$hp_parent = $row_detail[14];
		$level_school = $row_detail[15];
		$ves_last_update = $row_detail[19];
		$vip_last_update = $row_detail[20];
		$vip_remark = $row_detail[21];
		$e_mail = $row_detail[22];
		$hp_2 = $row_detail[23];
		$mother_name = $row_detail[24];
		$ph_mother = $row_detail[25];
		$country_1  = $row_detail[26];
		$school_1 = $row_detail[27];
		$program_1 = $row_detail[28];
		$country_2 = $row_detail[29];
		$school_2 = $row_detail[30];
		$program_2 = $row_detail[31];
		$country_3 = $row_detail[32];
		$school_3 = $row_detail[33];
		$program_3  = $row_detail[34];	
		$event_type  = $row_detail[35];
		$event_type_dtl  = $row_detail[36];
		$media_src  = $row_detail[37];
		$media_src_dtl	= $row_detail[38];
		$statusves= $row_detail[39];
		$statusvip= $row_detail[40];			
		}
	}
if ($nik =='')
	{
	$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kdb)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
		while ($row_nik  =  db_fetch($resource_nik, PDO::FETCH_NUM))
			{
			$nik = $row_nik[0];
			}
		}
	}
//========
$kd_school_1 = $kd_school_1_profile ;
$flt_country1 = in_val('flt_country1', 'any');
//========country 1
$query_country = q_set($__p_query_country, "SELECT  distinct country FROM ves_data.tb_master_partner t where school not like '%DELETE%' order by\r
case when country like 'USA%' then 0\r
when country like 'CAN%' then 1\r
when country like 'SW%' then 2\r
when country like 'UK%' then 3\r
when country like 'SPA%' then 4\r
when country like 'IT%' then 5\r
when country like 'AUS%' then 6\r
when country like 'NEW%' then 7\r
when country like 'SIN%' then 8\r
when country like 'MAL%' then 9\r
when country like 'CHI%' then 10\r
when country like 'IN%' then 11\r
ELSE 12 end, country asc, school");
$resource_country = db_query_or_die('errro_', $query_country, $__p_query_country ?? []);
$keluar_country= db_num_rows($resource_country);
if(num(db_num_rows($resource_country)) > 0)
	{
	while ($row_country=  db_fetch($resource_country, PDO::FETCH_NUM))
		{
		$nm_country1= $row_country[0];				
		$list_country1.="<OPTION VALUE=\"" . e($nm_country1) . "\">".e($nm_country1);
		}
	}
//=============
//load school country 1
if ($flt_country1 !="")
{
$query_school = q_set($__p_query_school, "SELECT  t.school FROM ves_data.tb_master_partner t where school not like '%DELETE%' and country = ? and (kd_school is not null  or kd_school <> '') order by\r
case when country like 'USA%' then 0\r
when country like 'CAN%' then 1\r
when country like 'SW%' then 2\r
when country like 'UK%' then 3\r
when country like 'SPA%' then 4\r
when country like 'IT%' then 5\r
when country like 'AUS%' then 6\r
when country like 'NEW%' then 7\r
when country like 'SIN%' then 8\r
when country like 'MAL%' then 9\r
when country like 'CHI%' then 10\r
when country like 'IN%' then 11\r
ELSE 12 end, country asc, school", [(string) ($flt_country1)]);
}
else
{$query_school = q_set($__p_query_school, "SELECT  t.school FROM ves_data.tb_master_partner t where school not like '%DELETE%'  and (kd_school is not null  or kd_school <> '') order by\r
case when country like 'USA%' then 0\r
when country like 'CAN%' then 1\r
when country like 'SW%' then 2\r
when country like 'UK%' then 3\r
when country like 'SPA%' then 4\r
when country like 'IT%' then 5\r
when country like 'AUS%' then 6\r
when country like 'NEW%' then 7\r
when country like 'SIN%' then 8\r
when country like 'MAL%' then 9\r
when country like 'CHI%' then 10\r
when country like 'IN%' then 11\r
ELSE 12 end, country asc, school");}
$resource_school = db_query_or_die('errro_', $query_school, $__p_query_school ?? []);
$keluar_school= db_num_rows($resource_school);
if(num(db_num_rows($resource_school)) > 0)
	{
	while ($row_school=  db_fetch($resource_school, PDO::FETCH_NUM))
		{					
		$nm_school1= $row_school[0];				
		$list_school1.="<OPTION VALUE=\"" . e($nm_school1) . "\">".e($nm_school1);
		}
	}
	
//========
//=============
$query_program = q_set($__p_query_program, "SELECT  nm_program_dest FROM ves_inc.tb_program_dest order by nm_program_dest ");
$resource_program = db_query_or_die('errro_', $query_program, $__p_query_program ?? []);
$keluar_program= db_num_rows($resource_program);
if(num(db_num_rows($resource_program)) > 0)
	{
	while ($row_program=  db_fetch($resource_program, PDO::FETCH_NUM))
		{					
		$nm_program= $row_program[0];				
		$list_program.="<OPTION VALUE=\"" . e($nm_program) . "\">".e($nm_program);
		}
	}
$current_action = in_val('current_action', 'any');
if ($current_action=='')
	{
	if (num($statussimpan)==0){$pesan="Action ";}
	$statussimpan=1;
	}

$pnp = in_val('pnp', 'any');	
$ves_status = in_val('ves_status', 'any');
$vip_status = in_val('vip_status', 'any');
$vip_remark = in_val('vip_remark', 'any');
$vip_program = in_val('vip_program', 'any');

$flt_country1 = in_val('flt_country1', 'any');
$flt_school1 = in_val('flt_school1', 'any');
if ($flt_country1 !="" and $flt_school1 !="")
	{
	$query_get_kode = q_set($__p_query_get_kode, "select kd_school from tb_master_partner where country = ? \r
\tand school = ? ", [(string) ($flt_country1), (string) ($flt_school1)]);
	$resource_get_kode = db_query_or_die('errro_1', $query_get_kode, $__p_query_get_kode ?? []);
	if(num(db_num_rows($resource_get_kode)) > 0)
		{
		while ($row_get_kode=  db_fetch($resource_get_kode, PDO::FETCH_NUM))
			{
			$kd_school_1= $row_get_kode[0];				
			}
		}
		
	}
	$Major = in_val('Major', 'any');
$hadnon = in_val('hadnon', 'any');
$program_status = in_val('program_status', 'any');
$flt_program1 = in_val('flt_program1', 'any');
$flt_country2 = in_val('flt_country2', 'any');
$flt_school2 = in_val('flt_school2', 'any');
$flt_program2 = in_val('flt_program2', 'any');
$flt_country3 = in_val('flt_country3', 'any');
$flt_school3 = in_val('flt_school3', 'any');
$flt_program3 = in_val('flt_program3', 'any');
$kdb = in_val('kdb', 'any');
$ves_remark = in_val('ves_remark', 'any');
$nextaction = in_val('nextaction', 'any');
$due_date = in_val('due_date', 'any');
$nextremark = in_val('nextremark', 'any');
$dochandler = in_val('dochandler', 'any');
$visahandler = in_val('visahandler', 'any');
$pf = in_val('pf', 'any');
$st_refund = in_val('st_refund', 'any');

//=== list sc====
$query_sc = q_set($__p_query_sc, "SELECT  nama_detail FROM ves_data.tb_user t where (posisi = 'AC' or posisi = 'SC' or posisi = 'Admission' or posisi = 'CM')  and aktif = 'Y' group by nama_detail order by nama_login");
$resource_sc = db_query_or_die('errro_', $query_sc, $__p_query_sc ?? []);
$keluar_sc= db_num_rows($resource_sc);
if(num(db_num_rows($resource_sc)) > 0)
	{
	while ($row_sc=  db_fetch($resource_sc, PDO::FETCH_NUM))
		{
		$nm_sc= $row_sc[0];				
		$list_sc.="<OPTION VALUE=\"" . e($nm_sc) . "\">".e($nm_sc);
		}
	}
//=============
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | User Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="cdnjs/ionicons.min.css">
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">User profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="dist/img/user4-128x128.jpg" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo e($nama) ?> <?php echo e($middle_name)  ?><?php echo e($family_name)  ?></h3> 
              <span class="profile-username text-center"></span>
              <p class="text-muted text-center"><?php echo e($dob) ?></p>
 <p class="text-muted text-center"><?php echo e($org_school) ?> <?php echo e($grade)?></p>
                  
       
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Leads</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><strong><em class="fa fa-book margin-r-5"></em> Address</strong>
              <p class="text-muted">
                <?php echo e($address)  ?><?php echo e($city) ?>
              </p>
              <strong><em class="fa fa-map-marker margin-r-5"></em> Phone Number</strong>
              <p class="text-muted"><?php echo e($hp) ?></p>
              <strong><em class="fa fa-map-marker margin-r-5"></em> E-Mail</strong>
              <p class="text-muted"><?php echo e($e_mail)  ?></p>
      
              <hr>
              <strong><em class="fa fa-book margin-r-5"></em> Parent &nbsp;Info</strong>
              <p class="text-muted">
                <strong>Father :</strong> 
              </p>
               <p class="text-muted">
                <strong>Mother :</strong> 
              </p>

<hr>
              <strong><em class="fa fa-map-marker margin-r-5"></em> Marketing Info</strong>
              <p class="text-muted"><?php echo e($event_type)   ?><?php echo e($event_type_dtl)   ?></p><br>
			  <p class="text-muted"><?php echo e($media_src)   ?><?php echo e($media_src_dtl)   ?></p>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="profile.php?kdb=<?php echo e(u($kdb)) ?>"  class="tab1">History</a></li>
              <li><a href="profile_progress.php?kdb=<?php echo e(u($kdb)) ?>" class="tab2">Follow Up</a></li>                           
              <li><a href="#" class="tab2">Academic Score</a></li>                           
              <li><a href="profile_berkas.php?kdb=<?php echo e(u($kdb)) ?>" class="tab3">Document</a></li>
 			<li><a href="prestuvip.php?browser=<?php echo e(u($kdb)) ?>" class="tab3">VE Billing Statement</a></li>                  
             </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="timeline">

                  <!-- END timeline item -->
                  <!-- timeline item -->

                  <!-- END timeline item -->
                  <!-- timeline time label -->
                   <!-- END timeline item -->
                </ul>
              </div>
              <div class="active tab-pane" id="berkas">
                <form class="form-horizontal" method="post"><?php echo csrf_field(); ?>

                <div class="row">
               	  <div class="col-md-10">
               	  <div class="col-md-2">
                	  <div class="form-group">
                	    <input type="checkbox" id="opt_ves" name="opt_ves" value="1"  onclick="this.form.submit()" <?php if(num($opt_ves) ==1){echo "checked";} ?> >
												<label for="opt_ves">VOS </label>
												<div class="check"></div>
  </div>	
                	</div>
               	  <div class="col-md-1">
               	    <div class="form-group">

               	    </div>
             	    </div>
               	  <div class="col-md-2">
               	    <div class="form-group">
               	      <input type="checkbox" id="opt_vip" name="opt_vip" value="1"  onclick="this.form.submit()" <?php if(num($opt_vip) ==1){echo "checked";} ?> >
               	      <label for="opt_vip">VIP</label>
               	      <div class="check"></div>
           	        </div>
             	    </div>
               	  <input type="text" name="loadpage" id="kd_school_2" value="1" hidden="hidden"left. ><input type="hidden" name="kdb" size="15" value="<?php echo e($kdb) ?>">
               	  </div>
                  </div>                
                <div class="row">
               	  <div class="col-md-10">
               	  <div class="col-md-2">
                	  <div class="form-group">
    <label>Action</label>
    <select name="current_action"  class="form-control">
			<option>Call</option>
				<option>Chat</option>
				<option>Appointment</option>
                <option selected  = "selected">
                <?php if ($current_action != '') {echo e($current_action) ;} else {echo e($action) ;} ?>
                </option>
              </select>
  </div>	
                	</div>
               	  <div class="col-md-1">
               	    <div class="form-group">

               	    </div>
             	    </div>
<?php if(num($opt_ves) ==1){ ?>              	    
               	  <div class="col-md-2">
               	    <div class="form-group">
               	      <label>VES Status</label>
<select name="ves_status" onchange="this.form.submit()" class="form-control">
                <option>N/A</option>			  
                <option>P</option>
                <option>VP</option>
                <option>E</option>
                <option>L</option>
                <option>Fp</option>
                <option>NP</option>
			  <option selected  = "selected"><?php if ($ves_status != '') {echo e($ves_status) ;} else {echo e($statusves) ;} ?></option>
              </select>
           	        </div>
				    </div>
<?php } ?>
               	  <div class="col-md-1">
               	    <div class="form-group"></div>
             	    </div>
<?php if(num($opt_vip) ==1){ ?>               	    
               	  <div class="col-md-2">
               	    <div class="form-group">
               	      <label>VIP Status</label>
               	      <select name="vip_status" onchange="this.form.submit()" class="form-control">
               	        <option>N/A</option>
               	        <option>P</option>
               	        <option>VP</option>
               	        <option>E</option>
               	        <option>L</option>
               	        <option>Fp</option>
               	        <option>NP</option>
               	        <option selected  = "selected">
               	          <?php if ($vip_status != '') {echo e($vip_status) ;} else {echo e($statusvip) ;} ?>
               	          </option>
             	        </select>
             	      </div>
           	    </div>
<?php } ?>              	  
               	  </div>
                  </div>
<?php //== ves ?>      
<?php if(num($opt_ves) ==1){?>   
                 <hr>         
                  <label>VES</label>
                <div class="row">
               	  
               	  <div class="col-md-10">
               	  <div class="col-md-10">
                	  <div class="form-group">
    <label>Remark</label>
     <input type="text" name="ves_remark"  value="<?php echo e($ves_remark) ?>" class="form-control">
  </div>	
                	</div>
				  </div>                	
                  </div>
                  <label>Preference Destination</label>
                  <div class="row">
                    <div class="col-md-10">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Country</label>
                          <select name="flt_country1" id="flt_country1" onChange="this.form.submit()" class="form-control" >
                            <option value= ""> <?php echo $list_country1?> </option>
                            <option selected="selected">
                              <?php  		   if ($flt_country1 !="") { echo e($flt_country1); }else { if ($country_dest1 !='') {echo e($country_dest1);}else{echo e($country_1);} }

   ?>
                            </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group"></div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Program</label>
                          <span class="style92">
                          <select name="flt_program1" id="flt_program1" class="form-control" >
                            <option value= > <?php echo $list_program?>
                            <option selected="selected">
                                <?php  if ($flt_program1 !="") { echo e($flt_program1); }else { if ($flt_program1 !=''){echo e($program_dest1); }{echo e($program_1);}}
 				  
   ?>
                            </option>
                          </select>
                          </span></div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-10">
                      <div class="col-md-10">
                        <div class="form-group">
                          <label>School</label>
                          <span class="style92">
                          <select name="flt_school1" id="flt_school1" onchange="this.form.submit()"  class="form-control" >
                            <option value= > <?php echo $list_school1?>
                            <option selected="selected">
                                <?php  if ($flt_school1 !="") {echo e($flt_school1);}else{if($school_dest1 != ''){echo e($school_dest1);}else{echo e($school_1);}}?>
                            </option>
                          </select>
                          </span></div>
                      </div>
                      <input type="text" name="kd_school_1" id="kd_school_1" value="<?php echo e($kd_school_1) ?>" hidden="hidden">
                    </div>
                  </div>   
<?php //================ ?>
<?php if ($ves_status == 'E'){?>
                <div class="row">
               	  <div class="col-md-10">
               	  <div class="col-md-5">
                	  <div class="form-group">
    <label>Major</label>
    <input type="Major" name="Major" size="50" value="<?php echo e($Major) ?>" class="form-control">
                	  </div>	
                	</div>
               	  <div class="col-md-1">
               	    <div class="form-group">

               	    </div>
             	    </div>
               	  <div class="col-md-2">
               	    <div class="form-group">
               	      <label>H/STEM/AD/OTHER</label>
               	      <span class="style92">
               	      <select name="hadnon" id="hadnon" class="form-control">
                      <option>H</option>
                      <option>STEM</option>
                      <option>AD</option>
                      <option>NON</option>
                      <option selected="selected">
                      <?php   echo e($hadnon);    ?>
                      </option>
                    </select>
               	      </span></div>
				    </div>
               	  <div class="col-md-1">
               	    <div class="form-group"></div>
             	    </div>
               	  <div class="col-md-2">
               	    <div class="form-group">
               	      <label>PARTNER/NON</label>
               	      <span class="style92">
               	        <select name="pnp" id="pnp" class="form-control">
                      <option>P</option>
                      <option>NP</option>
                      <option selected="selected">
                      <?php  echo e($pnp) ;   ?>
                      </option>
                    </select>
             	        </span></div>
             	    </div>
               	  </div>
               	  <div class="col-md-10">
               	    <div class="col-md-3">
               	      <div class="form-group">
               	        <label>Enroll Date</label>
               	        <input type="date" name="enroll_date" size="50" value="<?php echo e($enroll_date) ?>" class="form-control">
           	          </div>
           	        </div>
               	    <div class="col-md-3">
               	      <div class="form-group">
               	        <label>Intake Date</label>
               	        <input type="date" name="intake_date" size="50" value="<?php echo e($intake_date) ?>" class="form-control">
               	      </div>
           	        </div>
               	    <div class="col-md-2">
               	      <div class="form-group">
               	        <label>Program Status</label>
               	        <span class="style92">
               	          <select name="program_status" id="program_status" class="form-control">
                      <option>Main</option>
                      <option>Language</option>
                      <option>Additional</option>
                      <option selected="selected"> <?php echo e($program_status);  ?> </option>
                    </select>
           	            </span></div>
           	        </div>
               	    <div class="col-md-2">
               	      <div class="form-group">
               	        <label>Priority</label>
               	        <span class="style92">
               	        <select name="prioritas" id="prioritas" class="form-control">
               	          <option>1</option>
               	          <option>2</option>
               	          <option>3</option>
               	          <option>4</option>
               	          <option>5</option>
               	          <option>6</option>
               	          <option selected="selected">
               	            <?php   echo e($prioritas);    ?>
           	              </option>
           	            </select>
               	        </span></div>
           	        </div>
           	      </div>
               	  <div class="col-md-10">
               	    <div class="col-md-3">
               	      <div class="form-group">
               	        <label>Admission Handler</label>
               	        <span class="style92">
               	        <select name="dochandler" class="form-control" >
                      <option value= "">
                      <?php echo $list_sc ?>
                      </option>
                      <option selected="selected">
                      <?php  echo e($dochandler);?>
                                        </select>
               	        </span></div>
           	        </div>
               	    <div class="col-md-1">
               	      <div class="form-group"></div>
           	        </div>
               	    <div class="col-md-3">
               	      <div class="form-group">
               	        <label>Visa Handler</label>
               	        <span class="style92">
               	        <select name="visahandler"  class="form-control" >
                      <option value= "">
                      <?php echo $list_sc?>
                      </option>
                      <option selected="selected">
                      <?php  echo e($visahandler);    ?>
                        </select>
               	        </span></div>
           	        </div>
<?php if($nama_lengkap =='BIM'){ ?>					  
               	    <div class="col-md-3">
               	      <div class="form-group">
               	        <label>SC Name</label>
               	        <span class="style92">
               	          <select name="sc_name"  class="form-control" >
               	            <option value= ""> <?php echo $list_sc?> </option>
               	            <option selected="selected">
               	              <?php  echo $list_sc;    ?>
       	                </select>
           	            </span></div>
           	        </div>
<?php } ?>					  

               	  </div>
               	  <div class="col-md-10">
               	    <label>Net Tuition Fee</label>
           	      </div>
                  <div class="col-md-10">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Discount</label>
                        <span class="style92">
                        <select name="discount" id="discount" class="form-control">
                    <option>No Discount</option>
                    <option>Link & Match</option>  
                    <option>Sibling</option>
                    <option>VIP Student</option>
                    <option>Referensi</option>                                           
                    <option>BCA Prioritas & Solitaire</option>   
                    <option>4 C 2025</option> 
                    <option>USA CANADA FAIR 24</option> 
							
                    <option selected="selected">
                      <?php  echo e($discount);  ?>
                      </option>
                    </select>
                      </span></div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                         <label>Curr</label>
                          <select name="org_cur" id="org_cur" class="form-control">
					<option>Rp</option>                          
					<option>USD </option>
					<option>EUR</option>
					<option>GBP</option>
					<option>AUD</option>
					<option>CAD </option>
					<option>SGD</option>
					<option>CHF</option>
					<option>MYR</option>
					<option>JPY</option>
					<option>CNY</option>
                      <option selected="selected">
                      <?php   echo e($org_cur);    ?>
                      </option>
                    </select>
                        </span></div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                       <label>Amount</label>
                        <input type="pf" name="pf"  value="<?php echo e($pf) ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Type</label>
                        <span class="style92">
                          <select name="st_refund" id="discount2" class="form-control">
                            <option>Non Refundable</option>							  
                            <option>Refundable</option>
                            <option selected="selected">
                              <?php  echo e($st_refund);  ?>
                            </option>
                          </select>
                        </span></div>
                    </div>
                  </div>
                  <div class="col-md-10">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>NIK</label>
                        <input type="pf" name="nik"  value="<?php echo e($nik) ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
<?php } ?>                
<?php // enroll lengkap================ ?>
<?php //====ves === ?>

<?php }?>   
<?php //===vip == ?>
<?php if(num($opt_vip) ==1){?>  
 <hr>
     <label>VIP</label>
 <div class="row">
   <div class="col-md-10">
  <div class="col-md-10">
    <div class="form-group">
      <label>Remark</label>
      <input type="text" name="vip_remark"  value="<?php echo e($vip_remark) ?>" class="form-control">
    </div>
  </div>
	 </div>
   <div class="col-md-10">
     <div class="col-md-10">
       <div class="form-group">
         <label>Preference Program</label>
         <select name="vip_program" id="vip_program" class="form-control">
                  <option>NG TOEFL</option>
                  <option>TOEFL</option>
                  <option>IELTS</option>
                  <option>ACADEMIC ENGLISH</option>
                  <option>GENERAL ENGLISH</option>                  
                  <option>BUSSINESS ENGLISH</option>   
                  <option>TOEIC</option>   
                  <option>ESP</option>   
                  <option>MOVE</option>
                  <option>OTHER</option>                                            
                  <option selected="selected">
                  <?php  echo e($vip_program) ;?>
                  </option>
                </select>
       </div>
     </div>
   </div>
				  </div>
				  <?php } ?>
<?php // ===== ?>          
                  <hr>                                                                                        
                  <label>Next Plan</label>
                  <div class="row">
                    <div class="col-md-10">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Action</label>
                          <select name="nextaction"  class="form-control" >
                            <option>Call</option>
                            <option>Chat</option>
                            <option>Appointment</option>
                            <option selected="selected"><?php echo e($nextaction) ?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group"></div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Due Date</label>
                          <input type="date" name="due_date"  value="<?php echo e($due_date) ?>" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <div class="col-md-10">
                        <div class="form-group">
                          <label>Planning</label>
                          <input type="nextremark" name="nextremark" value="<?php echo e($nextremark) ?>" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <div class="col-md-10">
                        <div class="form-group">
                          <button type="submit" class="btn btn-danger" name="Submit" value="Submit">Submit</button>
                        </div>
                      </div>
                    </div>
                    <p>&nbsp;</p>
                  </div>
                  <label><br>
                  </label>

                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.tab-content -->
                    </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper --><!-- Control Sidebar --><!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$opt_ves = in_val('opt_ves', 'any');
$opt_vip = in_val('opt_vip', 'any');
$sc_name = in_val('sc_name', 'any');
if($sc_name ==''){$sc_name = $nama_lengkap;}	
$current_action = in_val('current_action', 'any');
if ($current_action=='')
	{if (num($statussimpan)==0){$pesan="Action ";}	$statussimpan=1;	}
if (num($opt_vip) ==1)
	{	
	$vip_status = in_val('vip_status', 'any');
	if ($vip_status=='')
	{if (num($statussimpan)==0){$pesan="Vip status ";} $statussimpan=1; 	}
	$vip_program = in_val('vip_program', 'any');
	if ($vip_program =='')
	{if (num($statussimpan)==0){$pesan="vip program ";} $statussimpan=1; }	
	$vip_remark = in_val('vip_remark', 'any');
	if ($vip_remark =='')
	{if (num($statussimpan)==0){$pesan="VIP remark ";}$statussimpan=1;}
	}
if (num($opt_ves) ==1)
	{
	$ves_remark = in_val('ves_remark', 'any');	
	if ($ves_remark =='')
	{if (num($statussimpan)==0){$pesan="ves remark ";}	$statussimpan=1;	}
	$ves_status = in_val('ves_status', 'any');
	if ($ves_status=='')
	{if (num($statussimpan)==0){$pesan="Ves status ";}	$statussimpan=1;	}
	}
$flt_country1 = in_val('flt_country1', 'any');
$flt_school1 = in_val('flt_school1', 'any');
if ($flt_country1 !='' and $flt_school1 != '')
	{
	$query_kd_school_1 = q_set($__p_query_kd_school_1, "SELECT  kd_school FROM ves_data.tb_master_partner t where school = ? and country = ? ", [(string) ($flt_school1), (string) ($flt_country1)]);
	$resource_kd_school_1 = db_query_or_die('errro_kd_school1', $query_kd_school_1, $__p_query_kd_school_1 ?? []);
	if(num(db_num_rows($resource_kd_school_1)) > 0)
		{
		while ($row_kd_school_1=  db_fetch($resource_kd_school_1, PDO::FETCH_NUM))
			{
			$kd_school_1= $row_kd_school_1[0];			
			}
		}
	}
$flt_program1 = in_val('flt_program1', 'any');
if ($ves_status != "E")
	{
	if ($ves_status != "L")
		{
		$nextaction = in_val('nextaction', 'any');
		if ($nextaction=='')
			{if (num($statussimpan)==0){$pesan="Next Action ";}			$statussimpan=1;			}
		$nextremark = in_val('nextremark', 'any');
		if ($nextremark=='')
			{if (num($statussimpan)==0){$pesan="Next Remark ";}			$statussimpan=1;			}	
		$due_date = in_val('due_date', 'any');
		if ($due_date=='')
			{if (num($statussimpan)==0){$pesan="Due Date ";}			$statussimpan=1;			}
		}
	}
else
	{
$st_refund = in_val('st_refund', 'any');

	$kd_school_1 = in_val('kd_school_1', 'any');
	if ($kd_school_1=='')
		{if (num($statussimpan)==0){$pesan="Country  & School doesnt match ";}		$statussimpan=1;		}
	$flt_country1 = in_val('flt_country1', 'any');
	if ($flt_country1=='')
		{if (num($statussimpan)==0){$pesan="Country  Destination ";}		$statussimpan=1;		}
	$flt_school1 = in_val('flt_school1', 'any');
	if ($flt_school1=='')
		{if (num($statussimpan)==0){$pesan="School Destination ";}		$statussimpan=1;		}
	$flt_program1 = in_val('flt_program1', 'any');
	if ($flt_program1=='')
		{if (num($statussimpan)==0){$pesan="Program Destination ";}		$statussimpan=1;		}
	$Major = in_val('Major', 'any');
	if ($Major=='')
		{if (num($statussimpan)==0){$pesan="Major ";}		$statussimpan=1;		}
	$hadnon = in_val('hadnon', 'any');
	if ($hadnon=='')
		{if (num($statussimpan)==0){$pesan="H/AD/Other ";}		$statussimpan=1;		}
	$pnp = in_val('pnp', 'any');
	if ($pnp=='')
		{
		if (num($statussimpan)==0){$pesan="P/NP ";}		$statussimpan=1;		}
	$enroll_date = in_val('enroll_date', 'any');
	if ($enroll_date=='')
		{if (num($statussimpan)==0){$pesan="Enroll Date  ";}		$statussimpan=1;		}
	$intake_date = in_val('intake_date', 'any');
	if ($intake_date=='')
		{if (num($statussimpan)==0){$pesan="Intake Date  ";}		$statussimpan=1;		}
	$program_status	 = in_val('program_status', 'any');
	if ($program_status=='')
		{if (num($statussimpan)==0){$pesan="Program Status ";}		$statussimpan=1;		}
	$dochandler = in_val('dochandler', 'any');
	if ($dochandler=='')
		{if (num($statussimpan)==0){$pesan="Document Handler ";}		$statussimpan=1;		}		
	$visahandler = in_val('visahandler', 'any');
	if ($visahandler=='')
		{if (num($statussimpan)==0){$pesan="Visa Handler";}		$statussimpan=1;		}
	$org_cur = in_val('org_cur', 'any');
	if ($org_cur=='')
		{if (num($statussimpan)==0){$pesan="Original Currency ";}		$statussimpan=1;		}
	$pf = in_val('pf', 'any');
	if ($pf=='')
		{if (num($statussimpan)==0){$pesan="Proffesional Fee ";}		$statussimpan=1;		}
	$discount = in_val('discount', 'any');
	if ($discount=='')
		{if (num($statussimpan)==0){$pesan="Discount ";}		$statussimpan=1;		}	

	$prioritas = in_val('prioritas', 'any');	
	if ($prioritas=='')
		{if (num($statussimpan)==0){$pesan="Priority ";}		$statussimpan=1;		}	

	$nik = in_val('nik', 'any');	
	if ($nik=='')
		{if (num($statussimpan)==0){$pesan="NIK must be filled ";}		$statussimpan=1;		}	
	
	$st_refund = in_val('st_refund', 'any');
	if ($st_refund=='')
		
		{if (num($statussimpan)==0){$pesan="Refund / Non Refundable must be choosen ";}		$statussimpan=1;		}		
	$event_type  = $row_detail[38];
	$event_type_dtl  = $row_detail[39];
	$media_src  = $row_detail[40];
	$media_src_dtl	= $row_detail[41];	
	$org_cur = in_val('org_cur', 'any');
	$org_pf = in_val('org_pf', 'any');
	$pf = in_val('pf', 'any');
	}					
$kdb = in_val('kdb', 'any');
$jamskrg= date('h:i:s', time());
$nama_depan= $_SESSION['nama_depan']; 
$tanggal_hri = date('Y-m-d');
$nik = in_val('nik', 'any');	


if (num($opt_ves)==1)
	{	
	if (num($statussimpan)==0)
		{
			$query_get_kode_school = q_set($__p_query_get_kode_school, "select kd_school from tb_master_partner where country = ? and school = ? ", [(string) ($flt_country1), (string) ($flt_school1)]);
		$resource_get_kode_school = db_query_or_die('errro_1', $query_get_kode_school, $__p_query_get_kode_school ?? []);
		if(num(db_num_rows($resource_get_kode_school)) > 0)
			{
			while ($row_get_kode_school=  db_fetch($resource_get_kode_school, PDO::FETCH_NUM))
				{
				$kd_school_1= $row_get_kode_school[0];				
				}
			}	
		if($nama_lengkap != 'BIM'){
		$query_simpan = q_set($__p_query_simpan, "insert into ves_inc.tb_progres_ves \r
\t\t(kd_biodata, action, result, status, progress, \r
\t\tcountry, school_dest, program, \r
\t\tcountry2, school2, program2, \r
\t\tcountry3, school3, program3,\r
\t\tnext_action, next_fu, due_date, time_update, pic, date_update,branch, grouping, kd_school_1,kd_school_2, kd_school_3,kd_branch) \r
\t\tvalues \r
\t\t(? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,\r
\t\t? ,? ,? ,\r
\t\t? ,? ,? , \t\r
\t\t? ,? ,? ,? ,? ,? ,? ,'1',? ,'kd_school_2','kd_school_3',?  )", [(string) ($kdb), (string) ($current_action), (string) ($result), (string) ($ves_status), (string) ($ves_remark), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($flt_country2), (string) ($flt_school2), (string) ($flt_program2), (string) ($flt_country3), (string) ($flt_school3), (string) ($flt_program3), (string) ($nextremark), (string) ($nextaction), (string) ($due_date), (string) ($jamskrg), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($branch), (string) ($kd_school_1), (string) ($kd_cbg)]);
		$resource_simpan = db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
		$query_update = q_set($__p_query_update, "update ves_inc.tb_biodata set ves_status = ? ,  next_fu = ? , date_fu = ? ,\r
\t\tcountry_dest = ? , \r
\t\tschool_dest = ? , \r
\t\tprogram_dest = ? , \r
\t\tcountry_1 = ? , country_2 = ? , country_3 = ? ,\r
\t\tschool_1 = ? , school_2 = ? , school_3 = ? , \r
\t\tprogram_1 = ? , program_2 = ? , program_3 = ? ,\r
\t\tlast_result = ? , ves_last_update = ? , remark = ? , kd_school_1 = ? ,kd_school_2 = ? ,kd_school_3 = ?   where kd_biodata = ? ", [(string) ($ves_status), (string) ($nextaction), (string) ($due_date), (string) ($flt_country1) . " " . (string) ($flt_country2) . " " . (string) ($flt_country3), (string) ($flt_school1) . " " . (string) ($flt_school2) . " " . (string) ($flt_school3), (string) ($flt_program1) . " " . (string) ($flt_program2) . " " . (string) ($flt_program3), (string) ($flt_country1), (string) ($flt_country2), (string) ($flt_country3), (string) ($flt_school1), (string) ($flt_school2), (string) ($flt_school3), (string) ($flt_program1), (string) ($flt_program2), (string) ($flt_program3), (string) ($result), (string) ($tanggal_hri), (string) ($ves_remark), (string) ($kd_school_1), (string) ($kd_school_2), (string) ($kd_school_3), (string) ($kdb)]);;	
		$resource_update = db_query_or_die('errro_update_biodata', $query_update, $__p_query_update ?? []);
		}
		else
		{		$query_simpan = q_set($__p_query_simpan, "insert into ves_inc.tb_progres_ves \r
\t\t(kd_biodata, action, result, status, progress, \r
\t\tcountry, school_dest, program, \r
\t\tcountry2, school2, program2, \r
\t\tcountry3, school3, program3,\r
\t\tnext_action, next_fu, due_date, time_update, pic, date_update,branch, grouping, kd_school_1,kd_school_2, kd_school_3,kd_branch) \r
\t\tvalues \r
\t\t(? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,\r
\t\t? ,? ,? ,\r
\t\t? ,? ,? , \t\r
\t\t? ,? ,? ,? ,? ,? ,? ,'1',? ,'kd_school_2','kd_school_3',?  )", [(string) ($kdb), (string) ($current_action), (string) ($result), (string) ($ves_status), (string) ($ves_remark), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($flt_country2), (string) ($flt_school2), (string) ($flt_program2), (string) ($flt_country3), (string) ($flt_school3), (string) ($flt_program3), (string) ($nextremark), (string) ($nextaction), (string) ($due_date), (string) ($jamskrg), (string) ($sc_name), (string) ($hari_ini), (string) ($branch), (string) ($kd_school_1), (string) ($kd_cbg)]);
		$resource_simpan = db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
		$query_update = q_set($__p_query_update, "update ves_inc.tb_biodata set ves_status = ? ,  next_fu = ? , date_fu = ? ,\r
\t\tcountry_dest = ? , \r
\t\tschool_dest = ? , \r
\t\tprogram_dest = ? , \r
\t\tcountry_1 = ? , country_2 = ? , country_3 = ? ,\r
\t\tschool_1 = ? , school_2 = ? , school_3 = ? , \r
\t\tprogram_1 = ? , program_2 = ? , program_3 = ? ,\r
\t\tlast_result = ? , ves_last_update = ? , remark = ? , kd_school_1 = ? ,kd_school_2 = ? ,kd_school_3 = ?   where kd_biodata = ? ", [(string) ($ves_status), (string) ($nextaction), (string) ($due_date), (string) ($flt_country1) . " " . (string) ($flt_country2) . " " . (string) ($flt_country3), (string) ($flt_school1) . " " . (string) ($flt_school2) . " " . (string) ($flt_school3), (string) ($flt_program1) . " " . (string) ($flt_program2) . " " . (string) ($flt_program3), (string) ($flt_country1), (string) ($flt_country2), (string) ($flt_country3), (string) ($flt_school1), (string) ($flt_school2), (string) ($flt_school3), (string) ($flt_program1), (string) ($flt_program2), (string) ($flt_program3), (string) ($result), (string) ($tanggal_hri), (string) ($ves_remark), (string) ($kd_school_1), (string) ($kd_school_2), (string) ($kd_school_3), (string) ($kdb)]);;	
		$resource_update = db_query_or_die('errro_update_biodata', $query_update, $__p_query_update ?? []);	}
		if($ves_status =="E")
			{
			if($nama_lengkap !='BIM'){
			$query_tb_enrolled = q_set($__p_query_tb_enrolled, "insert into ves_inc.tb_enrolled \r
\t\t\t(kd_biodata, kd_school, country_dest, sch_dest, prg_dest,  \r
\t\t\tmajor_dest, intake_date, enroll_date, status_host, status_part, \r
\t\t\tpic, status, branch, org_prof_cur,  org_prof_fee, \r
\t\t\tcur, prof_fee,  discount_name, \tstatus_program,kd_branch,non_refund )\r
\t\t\tvalues \r
\t\t\t(? ,? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,? ,? ,\r
\t\t\t'Rp',? ,? ,? ,? ,? )", [(string) ($kdb), (string) ($kd_school_1), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($Major), (string) ($intake_date), (string) ($enroll_date), (string) ($hadnon), (string) ($pnp), (string) ($nama_lengkap), (string) ($ves_status), (string) ($branch), (string) ($org_cur), (string) ($org_pf), (string) ($pf), (string) ($discount), (string) ($program_status), (string) ($kd_cbg), (string) ($st_refund)]);
			$resource_enrolled = db_query_or_die('error_tb_enrolled', $query_tb_enrolled, $__p_query_tb_enrolled ?? []);
	//=================		
			$query_sars = q_set($__p_query_sars, "insert into ves_data.tb_sales_report \r
\t\t\t(kd_biodata, nama, kd_school, program, major, \r
\t\t\th_nh, p_np, prioritas, pic, cabang, \r
\t\t\tori_school, ori_grade, mkt_source, mkt_source_dtl, status, \r
\t\t\tdt_entry, time_entry, enroll_date, tgl_intake, \r
\t\t\tnm_event, adm_pic, adm_pic_2, kd_cabang)\r
\t\t\tvalues\r
\t\t\t(\r
\t\t\t? ,? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,? ,'Pending',\r
\t\t\t? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,?\r
\t\t\t)", [(string) ($kdb), (string) ($nama) . " " . (string) ($middle_name) . " " . (string) ($family_name) . " ", (string) ($kd_school_1), (string) ($flt_program1), (string) ($Major), (string) ($hadnon), (string) ($pnp), (string) ($prioritas), (string) ($nama_lengkap), (string) ($branch), (string) ($org_school), (string) ($grade), (string) ($media_src), (string) ($media_src_dtl), (string) ($tanggal_hri), (string) ($jamskrg), (string) ($enroll_date), (string) ($intake_date), (string) ($event_type_dtl), (string) ($dochandler), (string) ($visahandler), (string) ($kd_cbg)]);	
			$resource_update = db_query_or_die('errro_sars', $query_sars, $__p_query_sars ?? []);	
			}else
{
			$query_tb_enrolled = q_set($__p_query_tb_enrolled, "insert into ves_inc.tb_enrolled \r
\t\t\t(kd_biodata, kd_school, country_dest, sch_dest, prg_dest,  \r
\t\t\tmajor_dest, intake_date, enroll_date, status_host, status_part, \r
\t\t\tpic, status, branch, org_prof_cur,  org_prof_fee, \r
\t\t\tcur, prof_fee,  discount_name, \tstatus_program,kd_branch,non_refund )\r
\t\t\tvalues \r
\t\t\t(? ,? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,? ,? ,\r
\t\t\t'Rp',? ,? ,? ,? ,? )", [(string) ($kdb), (string) ($kd_school_1), (string) ($flt_country1), (string) ($flt_school1), (string) ($flt_program1), (string) ($Major), (string) ($intake_date), (string) ($enroll_date), (string) ($hadnon), (string) ($pnp), (string) ($sc_name), (string) ($ves_status), (string) ($branch), (string) ($org_cur), (string) ($org_pf), (string) ($pf), (string) ($discount), (string) ($program_status), (string) ($kd_cbg), (string) ($st_refund)]);
			$resource_enrolled = db_query_or_die('error_tb_enrolled', $query_tb_enrolled, $__p_query_tb_enrolled ?? []);
	//=================		
			$query_sars = q_set($__p_query_sars, "insert into ves_data.tb_sales_report \r
\t\t\t(kd_biodata, nama, kd_school, program, major, \r
\t\t\th_nh, p_np, prioritas, pic, cabang, \r
\t\t\tori_school, ori_grade, mkt_source, mkt_source_dtl, status, \r
\t\t\tdt_entry, time_entry, enroll_date, tgl_intake, \r
\t\t\tnm_event, adm_pic, adm_pic_2, kd_cabang)\r
\t\t\tvalues\r
\t\t\t(\r
\t\t\t? ,? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,? ,'Pending',\r
\t\t\t? ,? ,? ,? ,\r
\t\t\t? ,? ,? ,?\r
\t\t\t)", [(string) ($kdb), (string) ($nama) . " " . (string) ($middle_name) . " " . (string) ($family_name) . " ", (string) ($kd_school_1), (string) ($flt_program1), (string) ($Major), (string) ($hadnon), (string) ($pnp), (string) ($prioritas), (string) ($sc_name), (string) ($branch), (string) ($org_school), (string) ($grade), (string) ($media_src), (string) ($media_src_dtl), (string) ($tanggal_hri), (string) ($jamskrg), (string) ($enroll_date), (string) ($intake_date), (string) ($event_type_dtl), (string) ($dochandler), (string) ($visahandler), (string) ($kd_cbg)]);	
			$resource_update = db_query_or_die('errro_sars', $query_sars, $__p_query_sars ?? []);	
			}
//=====NIK
	$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kdb)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
	$query_updnik = q_set($__p_query_updnik, "update ves_data.tb_nik set nik = ?  where kd_biodata = ? ", [(string) ($nik), (string) ($kdb)]);	
	$resource_updnik = db_query_soft($query_updnik, $__p_query_updnik ?? []);		
		}
	else
		{
	$query_insnik = q_set($__p_query_insnik, "insert into  ves_data.tb_nik (nik,kd_biodata) values (? ,? )", [(string) ($nik), (string) ($kdb)]);	
	$resource_insnik = db_query_soft($query_insnik, $__p_query_insnik ?? []);			
		}
//===adm stu progress
			$query_adm_stu = q_set($__p_query_adm_stu, "insert into adm_stu_progress \r
(kd_biodata, enroll_date, final_status,step,nama,ori_school,sc_name,\r
\t\tadm_pic,dest_country,dest_school,p_np,\r
\t\th_nh,remark_problem,remark_solution,\r
\t\tpic,kd_branch, dt_entry,kd_school,aktif,update_date,tgl_intake\r
\t\t) value (? ,? ,'ON','01 : Completing Application Requirements',? ,? ,? ,? ,? ,\r
\t\t? ,? ,? ,'No Desc','No Solution',? ,? ,? ,? ,1,? ,? )", [(string) ($kdb), (string) ($enroll_date), (string) ($nama) . " " . (string) ($middle_name) . " " . (string) ($family_name), (string) ($org_school), (string) ($nama_lengkap), (string) ($dochandler), (string) ($flt_country1), (string) ($flt_school1), (string) ($pnp), (string) ($hadnon), (string) ($nama_lengkap), (string) ($kd_cbg), (string) ($hari_ini), (string) ($kd_school_1), (string) ($hari_ini), (string) ($intake_date)]);

			$resource_adm_stu = db_query_or_die('errro_adm', $query_adm_stu, $__p_query_adm_stu ?? []);				
//====================
//===log activities
			$kegiatan = 'Enroll VES Student '.$kdb;	
			$query_log_aktifitas = q_set($__p_query_log_aktifitas, "insert into tb_log_activities (kd_user, kd_branch, kegiatan, dt_entry, jm_entry,status)\r
\t\t\tvalues(? ,? ,? ,? ,? ,'0')", [(string) ($kd_staff), (string) ($kd_cbg), (string) ($kegiatan), (string) ($hari_ini), (string) ($jamskrg)]);
			$resource_log_aktifitas = db_query_or_die('errro_log', $query_log_aktifitas, $__p_query_log_aktifitas ?? []);					
//===				
			echo "<script type=\"text/javascript\">\n";
			echo "alert('Please Print Enrollment Form');\n";
			echo "window.location = ('enrollmentformprev.php?kode_student=" . e(u($kdb)) . "');\n";				
			echo "</script>";
			}
		else
		{
//===log activities
				$kegiatan = 'Follow Up VES Student '.$kdb;	
				$query_log_aktifitas = q_set($__p_query_log_aktifitas, "insert into tb_log_activities (kd_user, kd_branch, kegiatan, dt_entry, jm_entry,status)\r
\t\t\t\tvalues(? ,? ,? ,? ,? ,'0')", [(string) ($kd_staff), (string) ($kd_cbg), (string) ($kegiatan), (string) ($hari_ini), (string) ($jamskrg)]);
				$resource_log_aktifitas = db_query_or_die('errro_log', $query_log_aktifitas, $__p_query_log_aktifitas ?? []);					
//===				
		echo "<script type=\"text/javascript\">\n";
		echo "alert('New VES Follow Up Progress Submitted');\n";
		echo "window.location = ('profile.php?kdb=" . e(u($kdb)) . "');\n";				
		echo "</script>";}
		}
	else
		{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('" . e($pesan) . " must be filled');\n";
		echo "</script>";
		}		
		
	}
else
if (num($opt_vip)==1)
	{	
	if (num($statussimpan)==0)
		{
		$query_simpan = q_set($__p_query_simpan, "insert into ves_inc.tb_progres_ves \r
\t\t(kd_biodata, date_update, progress, vip_status, vip_program, next_action, next_fu, due_date, time_update, pic, branch,kd_branch) \r
\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,\r
\t\t? ,? )", [(string) ($kdb), (string) ($tanggal_hri), (string) ($vip_remark), (string) ($vip_status), (string) ($vip_program), (string) ($nextremark), (string) ($nextaction), (string) ($due_date), (string) ($jamskrg), (string) ($nama_depan), (string) ($branch), (string) ($kd_cbg)]);
		$resource_simpan = db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
		$query_update = q_set($__p_query_update, "update ves_inc.tb_biodata set vip_status = ? ,  next_fu = ? , date_fu = ? ,last_result = ? , vip_last_update = ? , vip_remark = ? ,vip_program = ?  where kd_biodata = ? ", [(string) ($vip_status), (string) ($nextaction), (string) ($due_date), (string) ($result), (string) ($tanggal_hri), (string) ($vip_remark), (string) ($vip_program), (string) ($kdb)]);
		$resource_update = db_query_or_die('errro_update_biodata', $query_update, $__p_query_update ?? []);	
		if ($vip_status == "E")
			{
			$sql_simpan_status = q_set($__p_sql_simpan_status, "insert into ves_inc.vip_student_status (kd_branch, program, kd_biodata, hari_1,hari_2, hari_3, hari_4, hari_5, hari_6, status_class ) values (? ,? ,? ,\t? ,? ,? ,? ,? ,? ,1\t)", [(string) ($kd_cbg), (string) ($vip_program), (string) ($kdb), (string) ($day_1), (string) ($day_2), (string) ($day_3), (string) ($day_4), (string) ($day_5), (string) ($day_6)]);
			$resource_simpan = db_query_or_die('errro_simpan', $sql_simpan_status, $__p_sql_simpan_status ?? []);
			$query_vip_nama = q_set($__p_query_vip_nama, "insert into  ves_data.vip_student_data (kd_branch, nama_lengkap, kd_biodata)values (? ,? ,? )", [(string) ($kd_cbg), (string) ($nama) . " " . (string) ($middle_name) . " " . (string) ($family_name), (string) ($kdb)]);
			$resource_vip_nama = db_query_or_die('errro_simpan', $query_vip_nama, $__p_query_vip_nama ?? []);	
//===log activities
				$kegiatan = 'Enroll VIP Student '.$kdb;	
				$query_log_aktifitas = q_set($__p_query_log_aktifitas, "insert into tb_log_activities (kd_user, kd_branch, kegiatan, dt_entry, jm_entry,status)\r
\t\t\t\tvalues(? ,? ,? ,? ,? ,'0')", [(string) ($kd_staff), (string) ($kd_cbg), (string) ($kegiatan), (string) ($hari_ini), (string) ($jamskrg)]);
				$resource_log_aktifitas = db_query_or_die('errro_log', $query_log_aktifitas, $__p_query_log_aktifitas ?? []);	
//=====NIK
	$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kdb)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
	$query_updnik = q_set($__p_query_updnik, "update ves_data.tb_nik set nik = ?  where kd_biodata = ? ", [(string) ($nik), (string) ($kdb)]);	
	$resource_updnik = db_query_soft($query_updnik, $__p_query_updnik ?? []);		
		}
	else
		{
	$query_insnik = q_set($__p_query_insnik, "insert into  ves_data.tb_nik (nik,kd_biodata) values (? ,? )", [(string) ($nik), (string) ($kdb)]);	
	$resource_insnik = db_query_soft($query_insnik, $__p_query_insnik ?? []);			
		}			
//===				
			echo "<script type=\"text/javascript\">\n";
			echo "alert('New VIP Enrolled Submitted');\n";
			echo "window.location = ('prestuvip.php?browser=" . e(u($kdb)) . "');\n";				
			echo "</script>"	;		
			}
		else		
			{
//===log activities
				$kegiatan = 'Follow Up VIP Student '.$kdb;	
				$query_log_aktifitas = q_set($__p_query_log_aktifitas, "insert into tb_log_activities (kd_user, kd_branch, kegiatan, dt_entry, jm_entry,status)\r
\t\t\t\tvalues(? ,? ,? ,? ,? ,'0')", [(string) ($kd_staff), (string) ($kd_cbg), (string) ($kegiatan), (string) ($hari_ini), (string) ($jamskrg)]);
				$resource_log_aktifitas = db_query_or_die('errro_log', $query_log_aktifitas, $__p_query_log_aktifitas ?? []);					
//===					
			echo "<script type=\"text/javascript\">\n";
			echo "alert('New VIP Follow Up Progress Submitted');\n";
			echo "window.location = ('profile.php?kdb=" . e(u($kdb)) . "');\n";				
			echo "</script>";
			}
		}
	else
		{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('" . e($pesan) . " must be filled');\n";
		echo "</script>";			
		}
	}
}
?>