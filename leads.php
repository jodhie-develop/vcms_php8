<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

$q = in_val('q', 'get');
$search = in_val('search', 'get');
$Submit2=in_val('Submit2', 'get');

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2024-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kode_area'] ;

$level_posisi = $_SESSION['level_posisi'] ;
if ($nama_lengkap =='Debora Mboeik'){$area = q_set($__p_area, " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6' or kd_branch= '11' or kd_branch= '16')");}
elseif (num($kd_area) == 5){$area ="";}
elseif(num($kd_area) == 42){$area = q_set($__p_area, " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')");}
elseif(num($kd_area) == 41){$area = q_set($__p_area, " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')");}
elseif(num($kd_area) == 31){$area = q_set($__p_area, " and (kd_branch= '1' or kd_branch= '2')");}
elseif(num($kd_area) == 21) {$area = q_set($__p_area, " and (kd_branch= '2'or kd_branch= '8')");}
elseif(num($kd_area) == 2){$area = q_set($__p_area, " and kd_branch= ? ", [(string) ($kd_cbg)]);}
elseif(num($kd_area) == 100){$area = q_set($__p_area, " and  (kd_branch= '4' or kd_branch= '5' or kd_branch= '6' or kd_branch= '7' or kd_branch= '8' or kd_branch= '11' or kd_branch= '12' or kd_branch= '1' or kd_branch= '2' or kd_branch= '3')");}
else {$area = q_set($__p_area, " and kd_branch= ? ", [(string) ($kd_cbg)]);}	

$kelompok = $_SESSION['kelompok'];
$r = in_val('r', 'get');

$flt_name = in_val('flt_name', 'get');
$flt_address = in_val('flt_address', 'get');
$flt_phone = in_val('flt_phone', 'get');
$flt_org_school = in_val('flt_org_school', 'get');
$flt_grade = in_val('flt_grade', 'get');
$flt_source = in_val('flt_source', 'get');
$flt_pic = in_val('flt_pic', 'get');

$cb_flt_name = in_val('cb_flt_name', 'get');

$cb_flt_org_school = in_val('cb_flt_org_school', 'get');
$cb_flt_grade = in_val('cb_flt_grade', 'get');
$cb_flt_source = in_val('cb_flt_source', 'get');
$cb_flt_pic = in_val('cb_flt_pic', 'get');
if ($Submit2=='Reset')
	{
		$cb_flt_org_school ='';
		$cb_flt_grade='';
		$cb_flt_source = '';
		$cb_flt_pic = '';
	}
if ($flt_name !="" )
	{$filter_name = q_set($__p_filter_name, " and (t.nama like ? or t.middle_name like ? or t.family_name like ? ) ", ["%" . (string) ($flt_name) . "%", "%" . (string) ($flt_name) . "%", "%" . (string) ($flt_name) . "%"]);}

elseif ($cb_flt_name !="" )
	{$filter_name = q_set($__p_filter_name, " and (t.nama like ? ) ", ["%" . (string) ($cb_flt_name) . "%"]);}
else
	{$filter_name="";}
if ($flt_address !="")
	{$filter_address = q_set($__p_filter_address, " and t.address like ? ", ["%" . (string) ($flt_address) . "%"]);}
else
	{$filter_address="";}		
if ($flt_phone !="")
	{$filter_phone = q_set($__p_filter_phone, " and ( t.hp like ? or t.hp_2 like ? )", ["%" . (string) ($flt_phone) . "%", "%" . (string) ($flt_phone) . "%"]);}
else
	{$filter_phone="";}	
if ($flt_org_school !="")
	{$filter_org_school = q_set($__p_filter_org_school, " and t.org_school like ? ", ["%" . (string) ($flt_org_school) . "%"]);}
elseif ($cb_flt_org_school !="")
	{$filter_org_school = q_set($__p_filter_org_school, " and t.org_school like ? ", ["%" . (string) ($cb_flt_org_school) . "%"]);}
else
	{$filter_org_school="";}
if ($flt_grade !="")
	{$filter_grade = q_set($__p_filter_grade, " and t.grade like ? ", ["%" . (string) ($flt_grade) . "%"]);}
elseif ($cb_flt_grade !="")
	{$filter_grade = q_set($__p_filter_grade, " and t.grade like ? ", ["%" . (string) ($cb_flt_grade) . "%"]);}
else
	{$filter_grade="";}
if ($flt_source !="")
	{$filter_source = q_set($__p_filter_source, " and t.media_source like ? ", ["%" . (string) ($flt_source) . "%"]);}
elseif ($cb_flt_source !="")
	{$filter_source = q_set($__p_filter_source, " and t.media_source like ? ", ["%" . (string) ($cb_flt_source) . "%"]);}
else
	{$filter_source="";}
if ($flt_pic !="")
	{$filter_pic = q_set($__p_filter_pic, " and t.pic like ? ", ["%" . (string) ($flt_pic) . "%"]);}
elseif ($cb_flt_pic !="")
	{$filter_pic = q_set($__p_filter_pic, " and t.pic like ? ", ["%" . (string) ($cb_flt_pic) . "%"]);}
else
	{$filter_pic="";}
$filter_gabungan = q_set($__p_filter_gabungan, $filter_name . " " . $filter_address . " " . $filter_phone . " " . $filter_org_school . " " . $filter_grade . " " . $filter_source . " " . $filter_pic, [...($__p_filter_name ?? []), ...($__p_filter_address ?? []), ...($__p_filter_phone ?? []), ...($__p_filter_org_school ?? []), ...($__p_filter_grade ?? []), ...($__p_filter_source ?? []), ...($__p_filter_pic ?? [])]);

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="500" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
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
 <form method=get action=leads.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Leads Data<br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Entry Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date3"> Consultant Name:</label>
            </small></td>
            <td><small>
            <label for="date4">:</label>
 <select name="pilihan_sc"  onChange="this.form.submit()">
	 				<option>All Leads</option>	
	 				<option>My Leads</option>	
                	 <option selected><?php echo e($pilihan_sc) ?></option>
			</select>
 <input type="text" name="q" id="q" value="<?php echo e($q) ; ?>" hidden="hidden">
            <input type="text" name="search" id="q2" value="<?php echo e($search) ; ?>" hidden="hidden">
            </small></td>
          </tr>
        </tbody>
      </table>
      <?php 

$query = q_set($__p_query, "SELECT \r
\tt.nama, t.middle_name, t.family_name, t.gender, t.address, \r
\tt.city, t.area, t.hm_ph, t.hp, t.hp_2, \r
\tt.org_school, t.level_school, t.grade, t.ves_status, t.vip_status, \r
\tt.remark, t.vip_remark, t.ves_last_update, t.vip_last_update, DATE_FORMAT(dt_entry,'%d %b %y'),\r
\tpic, t.kd_biodata, sign_note, remark, ves_last_update,ves_status, event_type, event_type_dtl, media_src, media_src_dtl   FROM ves_inc.tb_biodata t");
if ($search =='')
	{
	if (num($kd_area) >= 2)
		{ 
//==========================	
		if (num($q)==0)
			{
			$query_filter = q_set($__p_query_filter, " where  (signed_date = ? or date_fu = ? ) and (next_fu is null or next_fu <>'Appointment') " . $area . " " . $filter_gabungan . " group by kd_biodata order by dt_entry desc", [(string) ($hari_ini), (string) ($hari_ini), ...($__p_area ?? []), ...($__p_filter_gabungan ?? [])]);
			}
		elseif (num($q)==1)
			{
			$query_filter = q_set($__p_query_filter, " where  (signed_date = ? or date_fu = ? )  and next_fu = 'Appointment' " . $area . " " . $filter_gabungan . "  group by kd_biodata order by dt_entry desc", [(string) ($hari_ini), (string) ($hari_ini), ...($__p_area ?? []), ...($__p_filter_gabungan ?? [])]);
			}				  
		elseif (num($q)==2)
			{
			$query_filter = q_set($__p_query_filter, " where  (signed_date < ? or date_fu < ? )  and (ves_status not like 'E%' and ves_status not like 'L%') " . $area . " " . $filter_gabungan . "   group by kd_biodata order by dt_entry desc", [(string) ($hari_ini), (string) ($hari_ini), ...($__p_area ?? []), ...($__p_filter_gabungan ?? [])]);
			}
		elseif (num($q)==4)
			{
			$query_filter = q_set($__p_query_filter, "  where  (signed_date < ? or date_fu < ? )  and (vip_status not like 'E%' and vip_status not like 'L%') " . $area . " " . $filter_gabungan . "   group by kd_biodata order by dt_entry desc", [(string) ($hari_ini), (string) ($hari_ini), ...($__p_area ?? []), ...($__p_filter_gabungan ?? [])]);
			}	
		elseif (num($q)==3)
			{
			if ($pilihan_sc =='My Leads')
				{	
				$query_filter = q_set($__p_query_filter, " where dt_entry between ? and ? and pic = ? " . $filter_gabungan . "  group by kd_biodata order by dt_entry desc", [(string) ($date_start), (string) ($date_end), (string) ($nama_lengkap), ...($__p_filter_gabungan ?? [])]);
				}
			else
				{
				$query_filter = q_set($__p_query_filter, " where dt_entry between ? and ? " . $area . " " . $filter_gabungan . "  group by kd_biodata order by dt_entry desc", [(string) ($date_start), (string) ($date_end), ...($__p_area ?? []), ...($__p_filter_gabungan ?? [])]);			
				}
			}
		}
	else
		{
		//==========================	
		//==========================	
		if($nama_lengkap =='Stevanus Yustiawan' and $nama_depan =='Stevanus06')
			{
			$query_filter = q_set($__p_query_filter, " where (kd_branch = '4' or kd_branch = '5' or kd_branch = '6' or kd_branch = '11') and (next_fu is null or next_fu <>'Appointment') " . $filter_gabungan . " group by kd_biodata order by dt_entry desc", [...($__p_filter_gabungan ?? [])]);			
			}

		elseif (num($q)==0)
			{
			$query_filter = q_set($__p_query_filter, " where pic = ? and (signed_date = ? or date_fu = ? ) and kd_branch = ? and (next_fu is null or next_fu <>'Appointment') " . $filter_gabungan . " group by kd_biodata order by dt_entry desc", [(string) ($nama_lengkap), (string) ($hari_ini), (string) ($hari_ini), (string) ($kd_cbg), ...($__p_filter_gabungan ?? [])]);
			}
		elseif (num($q)==1)
			{
			$query_filter = q_set($__p_query_filter, " where pic = ? and (signed_date = ? or date_fu = ? ) and kd_branch = ? and next_fu = 'Appointment' group by kd_biodata order by dt_entry desc", [(string) ($nama_lengkap), (string) ($hari_ini), (string) ($hari_ini), (string) ($kd_cbg)]);
			}				  
		elseif (num($q)==2)
			{
			$query_filter = q_set($__p_query_filter, " where pic = ? and (signed_date < ? or date_fu < ? ) and kd_branch = ? and (ves_status <> 'E' and ves_status not like 'L%')   group by kd_biodata order by dt_entry desc", [(string) ($nama_lengkap), (string) ($hari_ini), (string) ($hari_ini), (string) ($kd_cbg)]);
			}
		elseif (num($q)==4)
			{
			$query_filter = q_set($__p_query_filter, " where pic = ? and (signed_date < ? or date_fu < ? ) and kd_branch = ? and (vip_status <> 'E' and vip_status <> 'L')" . $filter_gabungan . "   group by kd_biodata order by dt_entry desc", [(string) ($nama_lengkap), (string) ($hari_ini), (string) ($hari_ini), (string) ($kd_cbg), ...($__p_filter_gabungan ?? [])]);
			}	
		elseif (num($q)==3)
			{
			if ($pilihan_sc =='My Leads')
				{	
				$query_filter = q_set($__p_query_filter, " where dt_entry between ? and ? and kd_branch = ? and pic = ? " . $filter_gabungan . "  group by kd_biodata order by dt_entry desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg), (string) ($nama_lengkap), ...($__p_filter_gabungan ?? [])]);
				}
			else
				{
				$query_filter = q_set($__p_query_filter, " where dt_entry between ? and ? and kd_branch = ? " . $filter_gabungan . "  group by kd_biodata order by dt_entry desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg), ...($__p_filter_gabungan ?? [])]);			
				}
			}
		}
	}
//==========================	

else
	{
	if($kelompok == 'ACC')
	{
	$query_filter = q_set($__p_query_filter, " where (t.nama like ? or  t.middle_name like ? or   t.family_name  like ? or   t.gender  like ? or   t.address like ? or  \r
\tt.city like ? or  t.area  like ? or   t.hm_ph  like ? or   t.hp  like ? or   t.hp_2  like ? or  \tt.org_school  like ? or   t.level_school  like ? or   t.grade  like ? or   t.ves_status  like ? or   t.vip_status  like ? or  t.remark  like ? or   t.vip_remark  like ? or    \r
\tpic  like ? or    remark like ? or   ves_status  like ? or   event_type  like ? or   event_type_dtl  like ? or   media_src  like ? or   media_src_dtl  like ?  ) group by kd_biodata order by dt_entry desc", ["%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%"]);		
	}
	else
	{
//	$query_filter = " where kd_branch = '$kd_cbg' and (t.nama like '%$search%' or  t.middle_name like '%$search%' or   t.family_name  like '%$search%' or   t.gender  like '%$search%' or   t.address like '%$search%' or  
//	t.city like '%$search%' or  t.area  like '%$search%' or   t.hm_ph  like '%$search%' or   t.hp  like '%$search%' or   t.hp_2  like '%$search%' or  	t.org_school  like '%$search%' or   t.level_school  like '%$search%' or   t.grade  like '%$search%' or   t.ves_status  like '%$search%' or   t.vip_status  like '%$search%' or  t.remark  like '%$search%' or   t.vip_remark  like '%$search%' or    
//	pic  like '%$search%' or    remark like '%$search%' or   ves_status  like '%$search%' or   event_type  like '%$search%' or   event_type_dtl  like '%$search%' or   media_src  like '%$search%' or   media_src_dtl  like '%$search%'  ) group by kd_biodata order by dt_entry desc";		

	$query_filter = q_set($__p_query_filter, " where kd_branch = ? and ( CONCAT(nama, ' ' ,middle_name, ' ',family_name ) like ? or t.gender  like ? or   t.address like ? or  \r
\tt.city like ? or  t.area  like ? or   t.hm_ph  like ? or   t.hp  like ? or   t.hp_2  like ? or  \tt.org_school  like ? or   t.level_school  like ? or   t.grade  like ? or   t.ves_status  like ? or   t.vip_status  like ? or  t.remark  like ? or   t.vip_remark  like ? or    \r
\tpic  like ? or    remark like ? or   ves_status  like ? or   event_type  like ? or   event_type_dtl  like ? or   media_src  like ? or   media_src_dtl  like ?  ) group by kd_biodata order by dt_entry desc", [(string) ($kd_cbg), "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%", "%" . (string) ($search) . "%"]);
	}
		
	}

$query = q_set($__p_query, $query . $query_filter, [...($__p_query ?? []), ...($__p_query_filter ?? [])]);

$_SESSION['ngueri'] = $query; $_SESSION['ngueri__p'] = $__p_query ?? [];
$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?> 
      
      <!-- export tool -->
                <?php if (num($level_posisi) >= 4) 
{ ?>
                 <table width="200" border="0">
                   <tbody>
                     <tr>
                       <td><br>
Result : <?php echo e($num_rows) ?></td>
                       <td>
    	    	<a href="leaving_xl.php?q=1" target="_blank" class="btn btn-info" role="button">Export to xls</a>

    </td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                   </tbody>
      </table>
      <?php } ?>
 <!-- export tools  -->     
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <blockquote>
                <table width="200" class="table table-bordered table-striped" id="example1">
                  <tbody>
                    <tr>
                      <td align="center">Name</td>
                      <td align="center">Address</td>
                      <td align="center">Phone</td>
                      <td align="center">Org School</td>
                      <td align="center">Grade</td>
                      <td align="center">Source</td>
                      <td align="center">SC Name</td>
                      <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>
                        <input type="text" lang="en-150" class="form-control"  placeholder="Name Search" name="flt_name" 
                 	      value="<?php echo e($flt_name) ?>" ?>
                      </td>
                      <td><input type="text" lang="en-150" class="form-control"  placeholder="Enter ..." name="flt_address" 
                 	      value="<?php echo e($flt_address) ?>" ?></td>
                      <td><input type="text" lang="en-150" class="form-control"  placeholder="Enter ..." name="flt_phone" 
                 	      value="<?php echo e($flt_phone) ?>" ?></td>
                      <td><input type="text" lang="en-150" class="form-control"  placeholder="Enter ..." name="flt_org_school" 
                 	      value="<?php echo e($flt_org_school) ?>" ?></td>
                      <td><input type="text" lang="en-150" class="form-control"  placeholder="Enter ..." name="flt_grade" 
                 	      value="<?php echo e($flt_grade) ?>" ?></td>
                      <td><input type="text" lang="en-150" class="form-control"  placeholder="Enter ..." name="flt_source" 
                 	      value="<?php echo e($flt_source) ?>" ?></td>
                      <td><input type="text" lang="en-150" class="form-control"  placeholder="Enter ..." name="flt_pic" 
                 	      value="<?php echo e($flt_pic) ?>" ?></td>
                      <td>
                       <a href="leads.php?q=3&r=1"><input type="submit" name="Submit2" value="Reset" /></a> 
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>
                      <h5><select name="cb_flt_org_school">
                         <?php
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct \r
\tt.org_school FROM ves_inc.tb_biodata t" . $query_filter, [...($__p_query_filter ?? [])]);
								$resource_nm_program = db_query_or_die('errro_7', $query_nm_program, $__p_query_nm_program ?? []);
								while ($row_nm_program=  db_fetch($resource_nm_program, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_program[0]).'">'.e($row_nm_program[0]).'</option>';
							  		}      ?>
                          <option selected><?php echo e($cb_flt_org_school) ?></option>
                        </select></h5>
                      </td>
                      <td><h5>
                      <select name="cb_flt_grade">
                         <?php
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct \r
\tt.grade FROM ves_inc.tb_biodata t" . $query_filter, [...($__p_query_filter ?? [])]);
								$resource_nm_program = db_query_or_die('errro_7', $query_nm_program, $__p_query_nm_program ?? []);
								while ($row_nm_program=  db_fetch($resource_nm_program, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_program[0]).'">'.e($row_nm_program[0]).'</option>';
							  		}      ?>
                          <option selected><?php echo e($cb_flt_grade) ?></option>
                        </select>
                      </h5></td>
                      <td><h5>
                      <select name="cb_flt_source">
                         <?php
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct media_src FROM ves_inc.tb_biodata WHERE dt_entry between ? and ? and kd_branch = ? order by media_src", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);
								$resource_nm_program = db_query_or_die('errro_7', $query_nm_program, $__p_query_nm_program ?? []);
								while ($row_nm_program=  db_fetch($resource_nm_program, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_program[0]).'">'.e($row_nm_program[0]).'</option>';
							  		}      ?>
                          <option selected><?php echo e($cb_flt_source) ?></option>
                        </select>
                      </h5></td>
                      <td><h5>
                        <select name="cb_flt_pic">
                   <?php
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct pic FROM ves_inc.tb_biodata WHERE dt_entry between ? and ? and kd_branch = ? order by pic", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);
								$resource_nm_program = db_query_or_die('errro_7', $query_nm_program, $__p_query_nm_program ?? []);
								while ($row_nm_program=  db_fetch($resource_nm_program, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_program[0]).'">'.e($row_nm_program[0]).'</option>';
							  		}      ?>
                          <option selected><?php echo e($cb_flt_pic) ?></option>
                        </select>
                      </h5></td>
                      <td><span class="hold-transition skin-blue sidebar-mini">
                        <input type="submit" name="Submit" value="Search" />
                      </span></td>
                    </tr>
                  </tbody>
                </table>
              Count : <?php echo e($num_rows) ?> </blockquote>
              <table width="97%" class="table table-bordered table-striped" id="example1">
              <thead>
                <tr>
                  <th width="19%"><table width="97%" class="table table-bordered table-striped" id="example2">
                    <thead>
                      <tr>
                        <th width="4%">No</th>
                        <th width="5%"> Name</th>
                        <th width="16%">Address</th>
                        <th width="8%">Phone</th>
                        <th width="13%">Original School</th>
                        <th width="8%">Entry</th>
                        <th width="24%">Description</th>
                        <th width="4%">VOS</th>
                        <th width="3%">VE</th>
                        <th width="10%">SC Name</th>
                        <th width="5%">ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>
                      <tr>
                        <td><?php echo e($no_urut) ; ?></td>
                        <td><a href="leads_history.php?kdb=<?php echo e(u($r[21])); ?>" 
target="popup" 
onClick="window.open('leads_history.php?kdb=<?php echo e(u($r[21])); ?>','popup','width=600,height=850,left=700px'); return false;"><?php echo e($r[0]) ; ?> <?php echo e($r[1]) ; ?> <?php echo e($r[2]) ; ?></a></td>
                        <td><?php echo e($r[4]) ; ?> - <?php echo e($r[5]) ; ?> (<?php echo e($r[6]) ; ?>)</td>
                        <td><?php echo e($r[8]) ; ?> <?php echo e($r[9]) ; ?></td>
                        <td><?php echo e($r[11]) ; ?> <?php echo e($r[10]) ; ?> <?php echo e($r[12]) ; ?></td>
                        <td><?php echo e($r[19]) ; ?></td>
                        <td><?php echo e($r[15]) ; ?><br>
                          <?php echo e($r[16]) ; ?></td>
                        <td><?php echo e($r[13]) ; ?></td>
                        <td><?php echo e($r[14]) ; ?><br></td>
                        <td><?php echo e($r[20]) ; ?></td>
                        <td><a href="profile.php?kdb=<?php echo e(u($r[21])); ?>" target="_blank">
                          <div class="icon"><img src="imgs/action.png" height="15" width="15"> </a></div>
                       </td>
                      </tr>
                      <?php $no_urut = num($no_urut) + 1; } }?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table></th>
                </tr>
              </thead>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
    <!-- /.content -->
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
</div>
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
