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
$date_start = in_val('date_start', 'any');
$date_end = in_val('date_end', 'any');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;
$kd_student = in_val('kdb', 'any');
$st_update = in_val('st_update', 'any');
if (num($st_update) != 1)
{//===================
$query_biodata = q_set($__p_query_biodata, "SELECT kd_biodata, \r
nama, middle_name, family_name, \r
date_format(dob,'%d'),date_format(dob,'%m'),date_format(dob,'%Y'), \r
address,city, area, hm_ph, hp, hp_2, e_mail, remark, vip_remark, level_school, org_school, grade, parent_nm, add_parent, city_parent, hp_parent, parent_email, event_st, event_st_dtl, event_type, event_type_dtl, media_src, media_src_dtl, dt_entry, time_entry, pic, branch, kd_branch,gender, signed_to, sm_1,sm_2,sm_3,sm_4,sm_5,sm_6, org_city_school FROM ves_inc.tb_biodata where kd_biodata = ? ", [(string) ($kd_student)]);

$resource_biodata = db_query_or_die('errro_2', $query_biodata, $__p_query_biodata ?? []);
$keluar_biodata= db_num_rows($resource_biodata);
if(num(db_num_rows($resource_biodata)) > 0)
	{
	while ($row_biodata=  db_fetch($resource_biodata, PDO::FETCH_NUM))
		{					
		$kd_student = $row_biodata[0];
		$first_name = $row_biodata[1];
		$middle_name = $row_biodata[2];
		$family_name = $row_biodata[3];
		$dob_dd = $row_biodata[4];
		$dob_mm = $row_biodata[5];
		$dob_yy = $row_biodata[6];
		$address = $row_biodata[7];
		$city = $row_biodata[8];
		$area = $row_biodata[9];
		$phone = $row_biodata[10];
		$hp1 = $row_biodata[11];
		$hp2 = $row_biodata[12];
		$e_mail = $row_biodata[13];
		$ves_remark = $row_biodata[14];
		$vip_remark = $row_biodata[15];
		$school_level = $row_biodata[16];
		$org_school = $row_biodata[17];
		$school_grade = $row_biodata[18];
		$parent_name = $row_biodata[19];
		$parent_address = $row_biodata[20];
		$parent_city = $row_biodata[21];
		$parent_hp = $row_biodata[22];
		$parent_email = $row_biodata[23];
		$event_st = $row_biodata[24];
		$event_st_dtl = $row_biodata[25];
		$mkt_source_event = $row_biodata[26];
		$mkt_source_event_dtl = $row_biodata[27];
		$media_source = $row_biodata[28];
		$media_source_dtl = $row_biodata[29];
		$dt_entry = $row_biodata[30];
		$time_entry = $row_biodata[31];
		$pic = $row_biodata[32];
		$branch = $row_biodata[33];
		$kd_branch = $row_biodata[34];
		$gender = $row_biodata[35];
		$signed_to = $row_biodata[36];
		$fb = $row_biodata[37];
		$twitter = $row_biodata[38];
		$instagram = $row_biodata[39];
		$path = $row_biodata[40];
		$line = $row_biodata[41];
		$wa = $row_biodata[42];
		$school_city = $row_biodata[43];
		
		}
	}
}

//========================
else
{
$kd_student = in_val('kd_student', 'any');
$first_name = in_val('first_name', 'any');
$middle_name = in_val('middle_name', 'any');
$family_name = in_val('family_name', 'any');
$dob_dd = in_val('dob_dd', 'any');
$dob_mm = in_val('dob_mm', 'any');
$dob_yy = in_val('dob_yy', 'any');
$address = in_val('address', 'any');
$city = in_val('city', 'any');
$area = in_val('area', 'any');
$phone = in_val('phone', 'any');
$hp1 = in_val('hp1', 'any');
$hp2 = in_val('hp2', 'any');
$e_mail = in_val('e_mail', 'any');
$ves_remark = in_val('ves_remark', 'any');
$vip_remark = in_val('vip_remark', 'any');
$school_level = in_val('school_level', 'any');
$org_school = in_val('org_school', 'any');
$school_grade = in_val('school_grade', 'any');
$parent_name = in_val('parent_name', 'any');
$parent_address = in_val('parent_address', 'any');
$parent_city = in_val('parent_city', 'any');
$parent_hp = in_val('parent_hp', 'any');
$parent_email = in_val('parent_email', 'any');
$event_st = in_val('event_st', 'any');
$event_st_dtl = in_val('event_st_dtl', 'any');
$mkt_source_event = in_val('mkt_source_event', 'any');
$mkt_source_event_dtl = in_val('mkt_source_event_dtl', 'any');
$media_source = in_val('media_source', 'any');
$media_source_dtl = in_val('media_source_dtl', 'any');
$dt_entry = in_val('dt_entry', 'any');
$time_entry = in_val('time_entry', 'any');
$pic = in_val('pic', 'any');
$branch = in_val('branch', 'any');
$kd_branch = in_val('kd_branch', 'any');
$gender = in_val('gender', 'any');
$signed_to = in_val('signed_to', 'any');
$fb = in_val('fb', 'any');
$twitter = in_val('twitter', 'any');
$instagram = in_val('instagram', 'any');
$path = in_val('path', 'any');
$line = in_val('line', 'any');
$wa = in_val('wa', 'any');
$school_city = in_val('school_city', 'any');
}

	
//==============list city
$query_city = q_set($__p_query_city, "SELECT  nm_city FROM ves_inc.tb_city where country = 'lokal' order by nm_city ");
$resource_city= db_query_or_die('errro_8', $query_city, $__p_query_city ?? []);
$keluar_city= db_num_rows($resource_city);
if(num(db_num_rows($resource_city)) > 0)
	{
	while ($row_city=  db_fetch($resource_city, PDO::FETCH_NUM))
		{					
		$nm_city= $row_city[0];				
		$list_city.="<OPTION VALUE=\"" . e($nm_city) . "\">".e($nm_city);

		}
	}

//=========================	
//==============list ori school
$query_ori_school = q_set($__p_query_ori_school, "SELECT  nm_sch FROM ves_inc.tb_school where (city_sch = ? or city_sch = 'Other') order by nm_sch desc ", [(string) ($school_city)]);
$resource_ori_school= db_query_or_die('errro_9', $query_ori_school, $__p_query_ori_school ?? []);
$keluar_ori_school= db_num_rows($resource_ori_school);
if(num(db_num_rows($resource_ori_school)) > 0)
	{
	while ($row_ori_school=  db_fetch($resource_ori_school, PDO::FETCH_NUM))
		{					
		$nm_ori_school= $row_ori_school[0];				
		$list_ori_school.="<OPTION VALUE=\"" . e($nm_ori_school) . "\">".e($nm_ori_school);
		}
	}
//=========================	
//==============list source
if ($mkt_source_type != 'Event')
	{
	$query_source_type = q_set($__p_query_source_type, "SELECT source FROM ves_inc.tb_mkt_source where event <> 'E'");
	}
else
	{
	$query_source_type = q_set($__p_query_source_type, "SELECT source FROM ves_inc.tb_mkt_source where event = 'E'");
	}

$resource_source_type= db_query_or_die('errro_10', $query_source_type, $__p_query_source_type ?? []);
$keluar_source_type= db_num_rows($resource_source_type);
if(num(db_num_rows($resource_source_type)) > 0)
	{
	while ($row_source_type=  db_fetch($resource_source_type, PDO::FETCH_NUM))
		{					
		$nm_source_type= $row_source_type[0];				
		$list_source_type.="<OPTION VALUE=\"" . e($nm_source_type) . "\">".e($nm_source_type);
		}
	}
	
//==============list mediasource
$query_media_source = q_set($__p_query_media_source, "SELECT source FROM ves_inc.tb_mkt_source where event <> 'E'");
$resource_media_source= db_query_or_die('errro_11', $query_media_source, $__p_query_media_source ?? []);
$keluar_media_source= db_num_rows($resource_media_source);
if(num(db_num_rows($resource_media_source)) > 0)
	{
	while ($row_media_source=  db_fetch($resource_media_source, PDO::FETCH_NUM))
		{					
		$nm_media_source= $row_media_source[0];				
		$list_media_source.="<OPTION VALUE=\"" . e($nm_media_source) . "\">".e($nm_media_source);
		}
	}

?>
?>
<style>
function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
</style>

<!DOCTYPE html>
<html>
<head>
 <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}
</script>
<body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
 <form method="post" action=leadsupdate.php><?php echo csrf_field(); ?> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Leads Update</h1>
    
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
 <form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>

                  <input name='kd_student' type='text' value="<?php echo e($kd_student) ?>"  hidden="hidden">
<input name='st_update_cek' type='text' value="<?php echo e($st_update) ?>" hidden="hidden">                  
  <table  align="center">
    <td width="1073"><tr>
      <td width="1073" valign="top"><table width="977">
        <tr><br>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Complete Name</label>
            <div class='col-md-8'>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' name='first_name' placeholder='First Name' type='text' value="<?php echo e($first_name) ?>">
                  </div>
                </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' name='middle_name' placeholder='Middle Name' type='text' value="<?php echo e($middle_name) ?>">
                  </div>
                </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' name='family_name' placeholder='Family Name' type='text'value="<?php echo e($family_name) ?>">
                  </div>
                </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <select name="gender" id="gender" class='form-control'>
                    <option>M</option>
                    <option>F</option>
                    <option selected="selected"> <?php echo e($gender);  ?> </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          <tr>
            <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Date Of Birth</label>
              <div class='col-md-8'>
                <div class='col-md-3 indent-small'>
                  <div class='form-group internal'>
                    <select name="dob_dd" id="dob_dd" class='form-control' >
                      <option>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                      <option>25</option>
                      <option>26</option>
                      <option>27</option>
                      <option>28</option>
                      <option>29</option>
                      <option>30</option>
                      <option>31</option>
                      <option selected="selected"> <?php echo e($dob_dd);  ?> </option>
                      </select>
                    </div>
                  </div>
                <div class='col-md-3 indent-small'>
                  <div class='form-group internal'>
                    <select name="dob_mm" id="dob_mm" class='form-control' >
                      <option>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option selected="selected"> <?php echo e($dob_mm);  ?> </option>
                      </select>
                    </div>
                  </div>
                <div class='col-md-3 indent-small'>
                  <div class='form-group internal'>
                    <select name="dob_yy" id="dob_yy" class='form-control' >						
                      <option>2020</option>
                      <option>2019</option>
                      <option>2018</option>
                      <option>2017</option>
                      <option>2016</option>
                      <option>2015</option>
                      <option>2014</option>
                      <option>2013</option>
                      <option>2012</option>
                      <option>2011</option>						
                      <option>2010</option>
                      <option>2009</option>
                      <option>2008</option>
                      <option>2007</option>
                      <option>2006</option>
                      <option>2005</option>
                      <option>2004</option>
                      <option>2003</option>
                      <option>2002</option>
                      <option>2001</option>
                      <option>2000</option>
                      <option>1999</option>
                      <option>1998</option>
                      <option>1997</option>
                      <option>1996</option>
                      <option>1995</option>
                      <option>1994</option>
                      <option>1993</option>
                      <option>1992</option>
                      <option>1991</option>
                      <option>1990</option>
                      <option selected="selected"> <?php echo e($dob_yy)  ?> </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>         
            </tr>
        <tr>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Address *</label>
            <div class='col-md-8'>
              <div class='col-md-12 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' name='address' placeholder='address' type='text' size="50" value="<?php echo e($address) ?>">
                  </div>
                </div> 
              </div>
            </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-1' for='id_title'>City</label>
            <div class='col-md-8'>
              <div class='col-md-6 indent-small'>
                <div class='form-group internal'>
                  <select name="city" id="city" class="form-control">
                    <option value= ><?php echo $list_city?>
                      <option selected="selected"><?php  echo e($city)	?> 
                        </option>
                    </select>
                  </div>
                </div> 
              </div>
            
            <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Area</label>
            <div class='col-md-8'>
              <div class='col-md-6 indent-small'>
                <div class='form-group internal'>
                  <select name="area" id="area" class="form-control">
                    <option>East</option>
                    <option>West</option>
                    <option>South</option>
                    <option>North</option>
                    <option>Central</option>
                    <option selected="selected"> <?php echo e($area);  ?> </option>
                    </select>
                  </div>
                </div> 
              </div>
            </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Phone</label>
  <div class='col-md-8'>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <input class='form-control' name='phone' placeholder='Home phone' type='text'value="<?php echo e($phone) ?>">
        </div>
      </div>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <input class='form-control'  name='hp1' placeholder='Primary Handphone' type='text'value="<?php echo e($hp1) ?>">
        </div>
      </div>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <input class='form-control'   name='hp2' placeholder='Secondary Handphone'  type='text'value="<?php echo e($hp2)  ?>">
        </div>
      </div>
    </div></div>
  <div class='form-group'>
    <label class='control-label col-md-2 col-md-offset-1' for='id_title'>E-Mail and Social Media</label>
    <div class='col-md-8'>
      <div class='col-md-3 indent-small'>
        <div class='form-group internal'>
          <input class='form-control' name="e_mail" type="text" id="e_mail" value="<?php echo e($e_mail) ?>" placeholder='E-Mail' >
          </div>
        </div>
      <div class='col-md-3 indent-small'>
        <div class='form-group internal'>
          <input class='form-control' name="fb" type="text" id="fb" value="<?php echo e($fb) ?>"placeholder='fb'>
          </div>
        </div>
      <div class='col-md-3 indent-small'>
        <div class='form-group internal'>
          <input class='form-control' input name="twitter" type="text" id="twitter" value="<?php echo e($twitter) ?>"placeholder='twitter'>
          </div>
        </div>
      <div class='col-md-3 indent-small'>
        <div class='form-group internal'>
          <input class='form-control' input name="instagram" type="text" id="instagram" value="<?php echo e($instagram) ?>"placeholder='instagram'>
          </div>
        </div>
      </div>
    </div>
  <div class='form-group'>
    <label class='control-label col-md-2 col-md-offset-1' for='id_title'></label>
    <div class='col-md-8'>
      <div class='col-md-3 indent-small'>
        <div class='form-group internal'>
          <input class='form-control' name="path" type="text" id="path" value="<?php echo e($path) ?>" placeholder="path" >
          </div>
        </div>
      <div class='col-md-3 indent-small'>
        <div class='form-group internal'>
          <input class='form-control' name="line" type="text" id="line" value="<?php echo e($line) ?>"placeholder="line" >
          </div>
        </div>
      <div class='col-md-3 indent-small'>
        <div class='form-group internal'>
          <input class='form-control' input name="wa" type="text" id="wa" value="<?php echo e($wa) ?>" placeholder="wa" >
          </div>
        </div>
      </div>
    </div>
          <tr>
            <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-1' for='id_title'>VES Remark </label>
              <div class='col-md-8'>
                <div class='col-md-12 indent-small'>
                  <div class='form-group internal'>
                    <input class='form-control' name='ves_remark' placeholder='Overseas Education Remark' type='text' size="50" value="<?php echo e($ves_remark) ?>">
                    </div>
                  </div> 
                </div>
              </div>
            </tr>
        <tr>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-1' for='id_title'>VIP Remark </label>
            <div class='col-md-8'>
              <div class='col-md-12 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' name='vip_remark' placeholder='Education Language Remark' type='text' size="50" value="<?php echo e($vip_remark) ?>">
                  </div>
                </div> 
              </div>
            </div>  
  <tr>
    <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'>City School</label>
      <div class='col-md-8'>
        <div class='col-md-6 indent-small'>
          <div class='form-group internal'>
            <select name="school_city" id="school_city" class="form-control" placeholder="City" onChange="this.form.submit()">
              <option value= >
                <?php echo $list_city?>
                <option selected="selected"><?php  echo e($school_city)	?>                 </select>
            </div>
          </div> 
        </div>	
      </div>
  </tr> 
  <tr>
    <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Level School</label>
      <div class='col-md-8'>
        <div class='col-md-6 indent-small'>
          <div class='form-group internal'>
            <select name="school_level" id="school_level" class="form-control" placeholder="Level School" onChange="this.form.submit()">
                <option>SD</option>
              <option>SMP</option>
              <option>SMA</option>
              <option>UNI</option>
              <option>S1</option>
              <option>S2</option>
              <option>S3</option>
              <option selected="selected"> <?php echo e($school_level);  ?> </option>
              </select>
            </div>
          </div> 
        </div>	
      </div>
  </tr>
  <tr>
    
    <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'>School Name</label>
      <div class='col-md-8'>
        <div class='col-md-6 indent-small'>
          <div class='form-group internal'>
            <select name="org_school" id="org_school" class="form-control" placeholder="school name">
              <option value= ><?php echo $list_ori_school?>
                <option selected="selected">
                  <?php if ($org_school !="") { echo e($org_school); }else { echo e($nm_ori_school); } ?>
                  </select>
            </div>
          </div> 
        </div>  	
      </div>	
  </tr> 
  <tr>
    <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Grade</label>
      <div class='col-md-8'>
        <div class='col-md-6 indent-small'>
          <div class='form-group internal'>
            <select name="school_grade" id="school_grade" class="form-control" placeholder="Grade">
              <option>O Level</option>
              <option>IB</option>
              <option>Yr 1</option>
              <option>Yr 2</option>
              <option>Yr 3</option>
              <option>Yr 4</option>
              <option>Yr 5</option>
              <option>Yr 6</option>
              <option>Yr 7</option>
              <option>Yr 8</option>
              <option>Yr 9</option>
              <option>Yr 10</option>
              <option>Yr 11</option>
              <option>Yr 12</option>
              <option>Sec 1</option>
              <option>Sec 2</option>
              <option>Sec 3</option>
              <option>Sec 4</option>
              <option>GRADUATE</option>						  
              <option selected="selected"> <?php echo e($school_grade);  ?> </option>
              </select>
            </div>
          </div> 
        </div>  	
      </div>	
  </tr>       
  <tr>
    <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Not Listed School</label>
      <div class='col-md-8'>
        <div class='col-md-6 indent-small'>
          <div class='form-group internal'>
            <input class='form-control' name='other_school' placeholder='Not Listed School a' type='text' size="35" 
							<?php if ($school_city == 'Other' || $school_name== 'Other')
							{ 
							$st_other_ori = 1;
							echo ""; 
							}
							else
							{ 
							$st_other_ori = 0;

							echo "hidden='hidden'"; 
							}
							?>
							>
            </div>
          </div> 
        </div>	
      </div>	
  </tr> 


  <tr>
    <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Parent Info</label>
  <div class='col-md-8'>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <input class='form-control' name='parent_name' placeholder='name' type='text'value="<?php echo e($parent_name) ?>" >
        </div>
      </div>
    <div class='col-md-6 indent-small'>
      <div class='form-group internal'>
        <input class='form-control'  name='parent_address' placeholder='address' type='text'value="<?php echo e($parent_address) ?>">
        </div>
      </div>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <select name="parent_city" id="parent_city" class='form-control'>
          <option selected disabled>City Parent</option>
          <option value= >
            <?php echo $list_city?>
            <option selected="selected"> <?php 		   
				  if ($parent_city !="") { echo e($parent_city); }else { echo e($nm_city); }
  ?> </option>
          </select>
        </div>
      </div>
    
    </div></div>
    </tr>
  <tr>
    <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'></label>
  <div class='col-md-8'>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <input class='form-control' name='parent_hp' placeholder='parent hp' type='text'value="<?php echo e($parent_hp) ?>" >
        </div>
      </div>
    <div class='col-md-6 indent-small'>
      <div class='form-group internal'>
        <input class='form-control'  name='parent_email' placeholder='parent email' type='text'value="<?php echo e($parent_email) ?>">
        </div>
      </div>
    
    
    </div></div>
    </tr>
  <tr>
       <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Event</label>
  <div class='col-md-8'>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <select name="event_st" id="event_st" class='form-control' onChange="this.form.submit()">
          <option selected disabled>Source</option>
          <option>Event</option>
          <option>Non Event</option>
			<option selected><?php echo e($event_st) ?></option>                       
                        </select>
        </div>
      </div>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <select name="event_st_dtl" id="event_st_dtl" class='form-control'>
         <option selected disabled>Event Detail</option>
          <option>Call In</option>
          <option>Walk In</option>
<?php if ($event_st=='Event')
{?>         
          <option>On The Event</option>
          <?php }
			else
			{?>
			          <option>Promotion</option>
          <?php }?>
			<option selected><?php echo e($event_st_dtl) ?></option>                       
     </select>
      </div>
      </div>
    </div></div>
    <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Marketing Source</label>
  <div class='col-md-8'>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <select name="mkt_source_event" id="mkt_source_event" class='form-control'>
          <option selected disabled>Marketing Source</option>
          <option value= "">
            <?php echo $list_source_type?>
            </option>
          <option selected="selected">
            <?php  if ($mkt_source_event !="") { echo e($mkt_source_event); }   ?>
            </select>
        </div>
      </div>
    <div class='col-md-6 indent-small'>
      <div class='form-group internal'>
        <input class='form-control'  name='mkt_source_event_dtl' placeholder='marketing source detail' type='text'value="<?php echo e($mkt_source_event_dtl) ?>">
        </div>
      </div>
    
    </div></div>
    </tr>
  <tr>
    <div class='form-group'>
      <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Media Source</label>
  <div class='col-md-8'>
    <div class='col-md-3 indent-small'>
      <div class='form-group internal'>
        <select name="media_source" id="media_source" class='form-control'>
          <option selected disabled>Media Source</option>
          <option value= "">
            <?php echo $list_media_source?>
            </option>
          <option selected="selected">
            <?php  		   if ($media_source !="") { echo e($media_source); }else { echo e($media_source); }


   ?>
            </select>
        </div>
      </div>
    <div class='col-md-6 indent-small'>
      <div class='form-group internal'>
        <input class='form-control'  name='media_source_dtl' placeholder='media source detail' type='text'value="<?php echo e($media_source_dtl) ?>">
        </div>
      </div>
    
    
    </div></div>
    </tr>		  
        
  </table>
        
      </td>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"><a href="studentprogress.php?kd_biodata=<?php echo e(u($kode_student))?>" target="_parent">
            <input type="submit" name="Submit" value="Submit" />
            </a></td>
          <td>&nbsp;</td>
          </tr>
        </table>
        <label></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="bootom"><hr width="1000" /></td>
    </tr>
  </table>
                    <input  name='st_update' placeholder='First Name' type='text' value="1" hidden="hidden">
</form>

 
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
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$jamskrg= date('h:i:s', time());

$tanggal_hri = date('Y-m-d');
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ; 
$kd_student = in_val('kd_student', 'any');
$first_name = in_val('first_name', 'any');
$middle_name = in_val('middle_name', 'any');
$family_name = in_val('family_name', 'any');
$nama_lengkap_student = "$first_name $middle_name $family_name";	

$dob_dd = in_val('dob_dd', 'any');
$dob_mm = in_val('dob_mm', 'any');
$dob_yy = in_val('dob_yy', 'any');
$address = in_val('address', 'any');
	
$city = in_val('city', 'any');
$area = in_val('area', 'any');
$phone = in_val('phone', 'any');
$hp1 = in_val('hp1', 'any');
$hp2 = in_val('hp2', 'any');
$e_mail = in_val('e_mail', 'any');
$ves_remark = in_val('ves_remark', 'any');
$vip_remark = in_val('vip_remark', 'any');
$school_level = in_val('school_level', 'any');
$org_school = in_val('org_school', 'any');
$school_grade = in_val('school_grade', 'any');
$parent_name = in_val('parent_name', 'any');
$parent_address = in_val('parent_address', 'any');
$parent_city = in_val('parent_city', 'any');
$parent_hp = in_val('parent_hp', 'any');
$parent_email = in_val('parent_email', 'any');
$event_st = in_val('event_st', 'any');
$event_st_dtl = in_val('event_st_dtl', 'any');
$mkt_source_event = in_val('mkt_source_event', 'any');
$mkt_source_event_dtl = in_val('mkt_source_event_dtl', 'any');
$media_source = in_val('media_source', 'any');
$media_source_dtl = in_val('media_source_dtl', 'any');
$dt_entry = in_val('dt_entry', 'any');
$time_entry = in_val('time_entry', 'any');
$pic = in_val('pic', 'any');
$branch = in_val('branch', 'any');
$kd_branch = in_val('kd_branch', 'any');
$gender = in_val('gender', 'any');
$signed_to = in_val('signed_to', 'any');
$fb = in_val('fb', 'any');
$twitter = in_val('twitter', 'any');
$instagram = in_val('instagram', 'any');
$path = in_val('path', 'any');
$line = in_val('line', 'any');
$wa = in_val('wa', 'any');
$school_city = in_val('school_city', 'any');
$org_school = in_val('org_school', 'any');

		
//==== filter===
if ($first_name=='')
	{
	if (num($statussimpan)==0){$pesan="First Name ";}
	$statussimpan=1;
	}
if ($middle_name=='')
	{
	if (num($statussimpan)==0){$pesan="middle_name ";}
	$statussimpan=1;
	}


//=====
if (num($statussimpan)==0)
	{
	$query_update = q_set($__p_query_update, "update ves_inc.tb_biodata set  \r
\tkd_biodata = ? ,\r
\tnama = ? ,\r
\tmiddle_name = ? ,\r
\tfamily_name = ? ,dob = ? ,\r
\taddress = ? ,\r
\tcity = ? ,\r
\tarea = ? ,\r
\thm_ph = ? ,\r
\thp = ? ,\r
\thp_2 = ? ,\r
\te_mail = ? ,\r
\tremark = ? ,\r
\tvip_remark = ? ,\r
\tlevel_school = ? ,\r
\torg_school = ? ,\r
\tgrade = ? ,\r
\tparent_nm = ? ,\r
\tadd_parent = ? ,\r
\tcity_parent = ? ,\r
\thp_parent = ? ,\r
\tparent_email = ? ,\r
\tevent_st = ? ,\r
\tevent_st_dtl = ? ,\r
\tevent_type = ? ,\r
\tevent_type_dtl = ? ,\r
\tmedia_src = ? ,\r
\tmedia_src_dtl = ? ,\r
\tgender = ? ,\r
\tsigned_to = ? ,\r
\tsm_1 = ? ,\r
\tsm_2 = ? ,\r
\tsm_3 = ? ,\r
\tsm_4 = ? ,\r
\tsm_5 = ? ,\r
\tsm_6 = ? ,\r
\torg_city_school = ? where kd_biodata = ? ", [(string) ($kd_student), (string) ($first_name), (string) ($middle_name), (string) ($family_name), (string) ($dob_yy) . "-" . (string) ($dob_mm) . "-" . (string) ($dob_dd), (string) ($address), (string) ($city), (string) ($area), (string) ($phone), (string) ($hp1), (string) ($hp2), (string) ($e_mail), (string) ($ves_remark), (string) ($vip_remark), (string) ($school_level), (string) ($org_school), (string) ($school_grade), (string) ($parent_name), (string) ($parent_address), (string) ($parent_city), (string) ($parent_hp), (string) ($parent_email), (string) ($event_st), (string) ($event_st_dtl), (string) ($mkt_source_event), (string) ($mkt_source_event_dtl), (string) ($media_source), (string) ($media_source_dtl), (string) ($gender), (string) ($signed_to), (string) ($fb), (string) ($twitter), (string) ($instagram), (string) ($path), (string) ($line), (string) ($wa), (string) ($school_city), (string) ($kd_student)]);
	$resource_update = db_query_or_die('errro_simpan', $query_update, $__p_query_update ?? []);
	$query = q_set($__p_query, "update vip_student_data set nama_lengkap = ? where kd_biodata = ? ", [(string) ($nama_lengkap_student), (string) ($kd_student)]);
	$resource_update = db_query_or_die('errro_simpan', $query, $__p_query ?? []);

	echo "<script type=\"text/javascript\">\n";
	echo "alert('Leads has been Updated by " . e($nama_depan) . "');\n";
	echo "window.location = ('dashboard.php');\n";				
	echo "</script>";	
	}
else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($pesan) . " must be filled');\n";
	echo "</script>";
	}	
}
?>