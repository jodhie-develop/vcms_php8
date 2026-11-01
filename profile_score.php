<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php"; 
include __DIR__ . "/atas.php";
date_default_timezone_set('Asia/Jakarta');
$jamskrg= date('h:i:s', time());
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'any');
$date_end = in_val('date_end', 'any');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$kode_student = in_val('kdb', 'any');
if ($kode_student ==''){$kode_student = in_val('kd_biodata', 'any');}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;

//======tampilkan detail
$query_detail = q_set($__p_query_detail, "SELECT t.nama, t.middle_name, t.family_name, DATE_FORMAT(t.dob,'%d %b %y'), t.gender, t.address, t.city, t.hm_ph, t.hp, t.org_school, t.grade, t.parent_nm, t.add_parent, t.city_parent, t.hp_parent, t.level_school, t.event_st_dtl, media_src, media_src_dtl, t.ves_last_update, t.vip_last_update, t.vip_remark, t.e_mail, t.hp_2, \r
t.mother_name, t.ph_mother, t.country_1, t.school_1, t.program_1, t.country_2, t.school_2, t.program_2, t.country_3, t.school_3, t.program_3, event_type,event_type_dtl, media_src, media_src_dtl,ves_status \r
FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($kode_student)]);

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
		$ves_status= $row_detail[39];
		}
	}
//========
$kd_school_1 = $kd_school_1_profile ;

$flt_country1 = in_val('flt_country1', 'any');


$current_action = in_val('current_action', 'any');
if ($current_action=='')
	{
	if (num($statussimpan)==0){$pesan="Action ";}
	$statussimpan=1;
	}
$result = in_val('result', 'any');
if ($result =='')
	{
	if (num($statussimpan)==0){$pesan="result ";}
	$statussimpan=1;
	}
$current_status = in_val('current_status', 'any');
if ($current_status=='')
	{
	if (num($statussimpan)==0){$pesan="current status ";}
	$statussimpan=1;
	}

$remark = in_val('remark', 'any');
if ($remark=='')
	{
	if (num($statussimpan)==0){$pesan="remark ";}
	$statussimpan=1;
	}
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
$flt_program1 = in_val('flt_program1', 'any');

$kd_student = in_val('kd_student', 'any');

//=== list sc====
$query_sc = q_set($__p_query_sc, "SELECT  nama_login FROM ves_data.tb_user t where (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and branch = ? and aktif = 'Y' order by nama_login", [(string) ($branch)]);
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
$enroll_dd = date('d');
$enroll_mm = date('m');
$enroll_yy= date('Y');
?>
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
<?php //========================== left nav ?>
 <?php  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
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
              <li><a href="profile_score.php?kdb=<?php echo e(u($kdb)) ?>" class="tab2">Academic Score</a></li>                           
              <li><a href="profile_berkas.php?kdb=<?php echo e(u($kdb)) ?>" class="tab3">Document</a></li>
 
           </ul>


              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="post"><?php echo csrf_field(); ?>

              <table width="923"  align="center">
    <tr>
      <td width="1" height="21">&nbsp;</td>
      <td width="910" valign="top"><strong class="huruf">Academic Score</strong></td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td valign="top"><table width="905" border="1">
        <tbody>
          <tr>
            <td rowspan="2" align="center" bgcolor="#DB6E70">Date</td>
            <td rowspan="2" align="center" bgcolor="#DB6E70">Detail</td>
            <td colspan="6" align="center" bgcolor="#DB6E70">Score</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#DB6E70">Listening</td>
            <td align="center" bgcolor="#DB6E70">Speaking</td>
            <td align="center" bgcolor="#DB6E70">Reading</td>
            <td align="center" bgcolor="#DB6E70">Writing</td>
            <td align="center" bgcolor="#DB6E70">Other</td>
            <td align="center" bgcolor="#DB6E70">Total</td>
          </tr>
			<?php
			$query_score = q_set($__p_query_score, "select \tDATE_FORMAT(test_date,'%d %b %y'), test_detil, L,S,R,W, other, total from ves_inc.tb_acd_history where kd_biodata = ? order by test_date", [(string) ($kode_student)]);
		  
			$resource_score = db_query_or_die('errro_', $query_score, $__p_query_score ?? []);
			$keluar_score = db_num_rows($resource_score);
			if(num(db_num_rows($resource_score)) > 0)
				{
				while ($r_score=  db_fetch($resource_score, PDO::FETCH_NUM))
					{
					$tgl_test = $r_score[0];	
					$cb_test_type = $r_score[1];						
					$listening_score = $r_score[2];
					$speaking_score = $r_score[3];
					$reading_score = $r_score[4];	
					$writing_score = $r_score[5];						
					$other_score = $r_score[6];
					$total_score = $r_score[7];
			?>
          <tr>
            <td align="center"><?php echo e($tgl_test) ?></td>
            <td align="center"><?php echo e($cb_test_type) ?></td>
            <td align="center"><?php echo e($listening_score) ?></td>
            <td align="center"><?php echo e($speaking_score) ?></td>
            <td align="center"><?php echo e($reading_score) ?></td>
            <td align="center"><?php echo e($writing_score) ?></td>
            <td align="center"><?php echo e($other_score) ?></td>
            <td align="center"><?php echo e($total_score) ?></td>
          </tr><?php }} ?>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td valign="top"><br></td>
    </tr>
    <tr>
      <td height="114">&nbsp;</td>
      <td valign="top"><table width="914">
            <tr>
              <td width="144">Test Date</td>
              <td colspan="2"><input type="date" name="tgl_test" value = "<?php echo e($tgl_test) ?>"/></td>
              <td colspan="3"><input type="text" name="kd_biodata" id="kd_biodata" value="<?php echo e($kode_student) ?>" hidden="hidden"></td>
              <td width="72">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Test Type</td>
              <td colspan="2"><select name="cb_test_type" >
				  	<option>Placement Test</option>
					<option>Institutional Test</option>
					<option>International Test</option>
					<option>Other</option>
                </option>
              </select></td>
              <td colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td width="117">&nbsp;</td>
              <td width="149">&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Institution</td>
              <td colspan="5"><input type="text" name="note_score" size="90" value="<?php echo e($note_score) ?>"></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Score</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Listening</td>
              <td>Structure</td>
              <td>Speaking</td>
              <td width="176">Reading</td>
              <td width="133">Writing</td>
              <td width="91">Total</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong class="huruf"><span class="style2">
                <input type="text" name="listening_score" size="5" value="<?php echo e($listening_score) ?>" >
              </span></strong></td>
              <td><strong class="huruf"><span class="style2">
                <input type="text" name="other_score" size="5" value="<?php echo e($other_score) ?>" >
              </span></strong></td>
              <td><strong class="huruf"><span class="style2">
                <input type="text" name="speaking_score" size="5" value="<?php echo e($speaking_score) ?>" >
              </span></strong></td>
              <td><strong class="huruf"><span class="style2">
                <input type="text" name="reading_score" size="5" value="<?php echo e($reading_score) ?>" >
              </span></strong></td>
              <td><strong class="huruf"><span class="style2">
                <input type="text" name="writing_score" size="5" value="<?php echo e($writing_score) ?>" >
              </span></strong></td>
              <td><strong class="huruf"><span class="style2">
                <input type="text" name="total_score" size="5" value="<?php echo e($total_score) ?>" >
              </span></strong></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6"><strong class="huruf"><a href="studentprogres.php?kd_biodata=<?php echo e(u($kode_student))?>"  style="font-weight: bold" target="_parent">
                <input type="submit" name="Submit" value="Submit" />
              </a></strong></td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="bootom">&nbsp;</td>
    </tr>
  </table>

              </div>
              
              <!-- /.tab-pane -->
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
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
    <strong>Copyright &copy; 2017</strong></footer>

  <!-- Control Sidebar --><!-- /.control-sidebar -->
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
	$kd_biodata	 = in_val('kd_biodata', 'any');
	$listening_score = in_val('listening_score', 'any');
	$other_score = in_val('other_score', 'any');
	$speaking_score = in_val('speaking_score', 'any');
	$reading_score = in_val('reading_score', 'any');
	$writing_score = in_val('writing_score', 'any');
	$total_score = in_val('total_score', 'any');
	$note_score = in_val('note_score', 'any');
	$tgl_test = in_val('tgl_test', 'any');
	$cb_test_type = in_val('cb_test_type', 'any');
	$note_score = in_val('note_score', 'any');
	$query_simpan = q_set($__p_query_simpan, "insert into ves_inc.tb_acd_history ( kd_biodata, test_type, test_date, test_detil, L, S, R, W,other, total) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ) ", [(string) ($kd_biodata), (string) ($cb_test_type), (string) ($tgl_test), (string) ($note_score), (string) ($listening_score), (string) ($speaking_score), (string) ($reading_score), (string) ($writing_score), (string) ($other_score), (string) ($total_score)]);
	$resource_simpan = db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);	 
			echo "<script type=\"text/javascript\">\n";
			echo "alert('New VIP Score Submitted');\n";
			echo "window.location = ('profile_score.php?kdb='" . e($kd_biodata) . "');\n";				
			echo "</script>";			
		
	}
?>