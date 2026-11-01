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

if ($date_start ==''){$date_start = "2020-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
if ($nama_depan == 'Ira00' or $nama_depan == 'hanifa07' or $nama_depan == 'resty04'  or $nama_depan == 'linda00'  or $nama_depan == 'Harianto07' or $nama_depan='nicko01'){
$kd_cbg = in_val('kd_cbg', 'get');
}
else
{$kd_cbg = $_SESSION['kd_branch'];}
if ($kd_cbg == 'Online'){$kd_cbg = 100;}

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang'){$kd_cbg = 8;}
if ($kd_cbg == 'East Area'){$kd_cbg = 101;}
if ($kd_cbg == 'West Area'){$kd_cbg = 102;}
if($kd_cbg =='VPRO Sby'){$kd_cbg = 351;}
if($kd_cbg =='VPRO Dps'){$kd_cbg = 356;}
if($kd_cbg =='VPRO Mlg'){$kd_cbg = 358;}
if($kd_cbg =='VPRO Jkt'){$kd_cbg = 355;}
if($kd_cbg =='Online'){$kd_cbg = 100;}
if($kd_cbg =='Online West Sby'){$kd_cbg = 104;}
if($kd_cbg =='National'){$kd_cbg = 111;}

if (num($kd_cbg) ==100){$cabang = 'Online';}
if ($kd_cbg ==''){$cabang = '--Chose Branch--';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==11){$cabang = 'PIK';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang';}
if (num($kd_cbg) ==101){$cabang = 'East Area';}
if (num($kd_cbg) ==102){$cabang = 'West Area';}
if (num($kd_cbg) ==351){$cabang = 'VPRO Sby';}
if (num($kd_cbg) ==356){$cabang = 'VPRO Dps';}
if (num($kd_cbg) ==358){$cabang = 'VPRO Mlg';}
if (num($kd_cbg) ==355){$cabang = 'VPRO Jkt';}
if (num($kd_cbg) ==100){$cabang = 'Online';}
if (num($kd_cbg) ==104){$cabang = 'Online West Sby';}
if (num($kd_cbg) ==111){$cabang = 'National';}
$kelas_name = in_val('kelas_name', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}

if( $kd_cbg ==''){$filter_cbg = q_set($__p_filter_cbg, " ");}
elseif ($kd_cbg == '111'){$filter_cbg = q_set($__p_filter_cbg, " where (kd_branch = '1' or kd_branch = '2' or kd_branch = '3' or kd_branch = '4' or kd_branch = '5' or kd_branch = '6' or kd_branch = '7' or kd_branch = '8' or kd_branch = '11' or kd_branch = '12'  )  ");}
elseif ($kd_cbg == '101'){$filter_cbg = q_set($__p_filter_cbg, " where (kd_branch = '1' or kd_branch = '2' or kd_branch = '3' or kd_branch = '8'  )  ");}
elseif ($kd_cbg == '102'){$filter_cbg = q_set($__p_filter_cbg, " where (kd_branch = '4' or kd_branch = '5' or kd_branch = '6' or kd_branch = '7'  )  ");}
else {$filter_cbg = q_set($__p_filter_cbg, " where kd_branch = ? ", [(string) ($kd_cbg)]);}
if ($filter_cbg =='') {$filter_tgl = q_set($__p_filter_tgl, " where mulai_tm between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
else {$filter_tgl = q_set($__p_filter_tgl, " and mulai_tm between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
if ($filter_cbg =='' and $kelas_name !='') {$filter_cari = q_set($__p_filter_cari, " where a.kelas like ? ", [(string) ($kelas_name) . "%"]);}
else {$filter_cari = q_set($__p_filter_cari, " and a.kelas like ? ", [(string) ($kelas_name) . "%"]);}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
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
<?php //========================== left nav ?>
 <?php   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_class_list.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>VIP Open Class List<br>
      </h1>
    <table width="453" border="0">
        <tbody>
          <tr>
            <td><small>
            <label for="date3">Center :</label>
            </small></td>
            <td>: 
              <select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
              <option value="0">--CHOOSE--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="8">Malang</option>
              <option value="101">East Area</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="11">PIK</option>				  
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="102">West Area</option>
		      <option value="351">Vpro Sby</option>
		      <option value="355">Vpro Jkt</option>
		      <option value="356">Vpro Dps</option>
		      <option value="358">Vpro Mlg</option>
		      <option value="353">Vpro Bdg</option>                	                       
              <option value="100">Online</option>              
              <option value="104">Online West Sby</option>    
              <option value="111">National</option> 				  
				  
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select></td>
          </tr>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Start Class Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date"  name="date_start" id="date_start" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date_end" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><small>
            <label for="date4"> Search by Class Code</label>
            </small></td>
            <td><span class="form-group">
              <input name="kelas_name"  class="form-control"  type="text" size="10" value="<?php echo e($kelas_name) ?>" placeholder="class code you need to find" />
            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
    </table>
                   <div class="form-group">
          <a href="teachercalendar.php?kd_cbg=<?php echo e(u($kd_cbg)) ?>" 
target="popup" 
onClick="window.open('teachercalendar.php?kd_cbg=<?php echo e(u($kd_cbg)) ?>','popup','width=1000,height=850,left=700px'); return false;" class="btn btn-primary" role="button"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
View Academic Calendar </a>         
          </div>
  </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Class List</label>
		</div>				
	  </div>
<?php if ($kd_cbg ==''){die;} ?>		
	  <div class="col-md-12">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td width=12% align=center >Class Code Opened</td>
	            <td width=7% height="14" align=center >Program &amp; Level</td>
	            <td width="12%" align=center >Class Period</td>
	            <td width="11%" align=center >Time Schedule &amp; Teacher</td>
	            <td width="5%" align=center >Student</td>
	            <td width="8%" align=center >Academic Calendar</td>
	            <td width="9%" align=center >Scope &amp;<br>
                Sequence</td>
	            <td width="9%" align=center >Coordination<br>
                Sheet</td>
	            <td width="6%" align=center >Tutorial Record</td>
	            <td width="6%" align=center >LC Record</td>
	            <td width="5%" align=center >Score Record &amp; Comment</td>
	            <td width="10%" align=center >MCA</td>
              </tr>
            </thead>

	        <tbody>
	          <?php	
	$adafile = 0;
if ($kelas_name =='')
{
$query_open_class = q_set($__p_query_open_class, "SELECT a.kelas, a.kode_program, b.nm_program, b.level_program,type_program,min(mulai_tm) as mulai,\r
max(selesai_tm) as selesai,date_format(min(mulai_tm),'%b %d, %Y') as tampil_mulai, date_format(max(selesai_tm),'%b %d, %Y') as tampil_selesai,b.kd_program,kd_branch  \r
FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg b on a.kode_program  = b.kd_program and a.level_program = b.level_program " . $filter_cbg . "  " . $filter_tgl . " and a.status_kelas = 1\r
 group by a.kelas order by min(mulai_tm) desc", [...($__p_filter_cbg ?? []), ...($__p_filter_tgl ?? [])]); 
}
else
{

$query_open_class = q_set($__p_query_open_class, "SELECT a.kelas, a.kode_program, b.nm_program, b.level_program,type_program,min(mulai_tm) as mulai,\r
max(selesai_tm) as selesai,date_format(min(mulai_tm),'%b %d, %Y') as tampil_mulai, date_format(max(selesai_tm),'%b %d, %Y') as tampil_selesai,b.kd_program,kd_branch  \r
FROM ves_data.vip_teacher_schedule a left join ves_data.vip_mst_code_prg b on a.kode_program  = b.kd_program and a.level_program = b.level_program " . $filter_cbg . " " . $filter_cari . " and a.status_kelas = 1 group by a.kelas order by min(mulai_tm) desc", [...($__p_filter_cbg ?? []), ...($__p_filter_cari ?? [])]); 
}	

$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);
$keluar_open_class = db_num_rows($resource_open_class);				
if(num(db_num_rows($resource_open_class)) > 0)
	{
	while ($row_open_class  =  db_fetch($resource_open_class, PDO::FETCH_NUM))
		{
		$query_jml_murid = q_set($__p_query_jml_murid, "SELECT count(kd_billing) as jml FROM ves_data.vip_billing where kd_class= ? ", [(string) ($row_open_class[0])]);

		$resource_jml_murid = db_query_soft($query_jml_murid, $__p_query_jml_murid ?? []);
		$keluar_jml_murid = db_num_rows($resource_jml_murid);				
		if(num(db_num_rows($resource_jml_murid)) > 0)
			{
			while ($row_jml_murid  =  db_fetch($resource_jml_murid, PDO::FETCH_NUM))
				{	
				$jml_murid = $row_jml_murid[0];
				}
			}
		$query_last_date = q_set($__p_query_last_date, "SELECT max(mulai_tm) as selesai,date_format(max(mulai_tm),'%b %d, %Y') FROM ves_data.vip_teacher_schedule a where a.kelas = ? ", [(string) ($row_open_class[0])]);
		$resource_last_date = db_query_soft($query_last_date, $__p_query_last_date ?? []);
		$keluar_last_date = db_num_rows($resource_last_date);				
		if(num(db_num_rows($resource_last_date)) > 0)
			{
			while ($row_last_date  =  db_fetch($resource_last_date, PDO::FETCH_NUM))
				{
				$kelas_selesai = $row_last_date[1];					
				}
			}
		$query_scope = q_set($__p_query_scope, "SELECT namafile, lokasifile FROM vip_ssq where  kode_program = ? ", [(string) ($row_open_class[1])]);
		$resource_scope = db_query_soft($query_scope, $__p_query_scope ?? []);		
		if(num(db_num_rows($resource_scope)) > 0)
			{
			while ($row_scope  =  db_fetch($resource_scope, PDO::FETCH_NUM))
				{
				$adafile= 1;
				$nmfile = $row_scope[0];					
				$lokasifile = "/vcms/$row_scope[1]";										
				}
			}	
		$query_time_teacher = q_set($__p_query_time_teacher, "select date_format(mulai_tm, '%a'),  date_format(mulai_tm, '%H:%i'),date_format(selesai_tm, '%H:%i'),nm_teacher from vip_teacher_schedule where kelas = ? group by date_format(mulai_tm, '%a'), nm_teacher", [(string) ($row_open_class[0])]);
		$resource_time_teacher = db_query_soft($query_time_teacher, $__p_query_time_teacher ?? []);		
		if(num(db_num_rows($resource_time_teacher)) > 0)
			{
			while ($row_time_teacher  =  db_fetch($resource_time_teacher, PDO::FETCH_NUM))
				{
				$jadwal_1= e($row_time_teacher[0]) . " (" . e($row_time_teacher[1]) . "-" . e($row_time_teacher[2]) . ") - " . e($row_time_teacher[3]) . "<br>";
				$baris_jadwal = "$baris_jadwal $jadwal_1";	
				}
			}			
			
			
			
	?>
	          <tr>
				  <td align=center class="style24"><a href= "vip_class_student_list.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&kdprg=<?php echo   e(u($row_open_class[9])) ?>&kd_cbg=<?php echo e(u($row_open_class[10])) ?>"><?php echo  e($row_open_class[0])  ?> 
            <?php if ($kd_cbg =='100' or num($kd_cbg) == 101 or num($kd_cbg) == 102 or $kd_cbg == '') {  ?>(<?php echo  e($row_open_class[10])  ?>) <?php } ?></a></td>
	            <td height="14" align=center class="style24"><?php echo  e($row_open_class[2])  ?> <?php echo  e($row_open_class[3])  ?> - <?php echo  e($row_open_class[4])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[7])  ?> - <?php echo  e($kelas_selesai)  ?></td>
	            <td align=center class="style24"><?php echo e($baris_jadwal) ?></td>
	            <td align=center class="style24"><?php echo  e($jml_murid)  ?><br>
	            
<?php if ($kd_cbg =='351' or $kd_cbg =='356' or $kd_cbg =='358' or $kd_cbg =='355'  ){ ?>
                <a href= "newleadsvpro.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&nmprg=<?php echo e(u($row_open_class[9])) ?>&kdcb=<?php echo e(u($row_open_class[10])) ?>">Add</a>
<?php } else { ?>                             
                <a href= "vip_class_student_list.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&kdprg=<?php echo   e(u($row_open_class[9])) ?>&kd_cbg=<?php echo e(u($row_open_class[10])) ?>">Add</a>
<?php } ?>                 <br></td>
	            <td align=center class="style24"><a href= "acdcal.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&kdcbg=<?php echo   e(u($row_open_class[10])) ?>" target="_blank">View</a> <br></td>
	            <td align=center class="style24">
	            <?php if (num($adafile) == 0 and num($kd_staff) ==462){ ?>
	            
	            <a href= "vip_scsq.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&kdcbg=<?php echo   e(u($row_open_class[10])) ?>" target="_blank">Upload</a>
	            <?php }else { ?>
				<a href="vip_scsq_view.php?f=<?php echo e(u($lokasifile)) ?>" 
				target="popup" 
				onclick="window.open('vip_scsq_view.php?f=<?php echo e(u($lokasifile)) ?>','popup','width=1000,height=800'); return false;">	            
				<?php echo e($nmfile) ?></a>
				<?php } ?>
	            </td>
	            <td align=center class="style24"><a href= "vip_crsh.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&kdcbg=<?php echo   e(u($row_open_class[10])) ?>" target="_blank">View</a> <br></td>
	            <td align=center class="style24"><a href= "vip_ttrrcd.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&kdcbg=<?php echo   e(u($row_open_class[10])) ?>" target="_blank">View</a> <br></td>
	            <td align=center class="style24"><a href= "vip_lcrcd.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&kdcbg=<?php echo   e(u($row_open_class[10])) ?>" target="_blank">View</a></td>
	            <td align=center class="style24"><a href= "vip_scorerecord.php?kdcl=<?php echo e(u($row_open_class[0])) ?>&kdprg=<?php echo   e(u($row_open_class[9])) ?>&kd_cbg=<?php echo e(u($kd_cbg)) ?>">View</a> <br></td>
	            <td align=center class="style24"><a href= "vip_mca.php?kdcl=<?php echo e(u($row_open_class[0])) ?>">View</a> </td>
              </tr>
	          <?php 	$adafile = 0; 				$jadwal_1= '';
				$baris_jadwal = ''; 
				$nmfile ='';					
				$lokasifile = '';}} ?>
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
      <!-- /.row --><!-- /.content -->
	</form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post"><?php echo csrf_field(); ?>

          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
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
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
