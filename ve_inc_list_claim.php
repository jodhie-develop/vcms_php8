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
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nm_center = in_val('nm_center', 'get');


$nm_sc = in_val('nm_sc', 'get');
$kelompok = $_SESSION['kelompok'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$nama_lengkap = $_SESSION['nama_lengkap'];
if($nm_center == 'East Sby'){$kd_center = 1;}
elseif($nm_center == 'West Sby'){$kd_center = 2;}
elseif($nm_center == 'Denpasar'){$kd_center = 3;}
elseif($nm_center == 'Malang'){$kd_center = 8;}
elseif($nm_center == 'South Jkt'){$kd_center = 4;}
elseif($nm_center == 'North Jkt'){$kd_center = 5;}
elseif($nm_center == 'West Jkt'){$kd_center = 6;}
elseif($nm_center == 'Bandung'){$kd_center = 7;}
elseif($nm_center == 'PIK'){$kd_center = 11;}
elseif($nm_center == 'Serpong'){$kd_center = 12;}
elseif($nm_center == 'Medan'){$kd_center = 14;}
elseif($nm_center == 'All'){$kd_center = 111;}
elseif($nm_center == 'CA'){$kd_center = 15;}
elseif($nm_center == 'Tangerang'){$kd_center = 16;}



if (num($kd_center) != 111)
	{
	$query_nm_sc = q_set($__p_query_nm_sc, "select nama_detail from ves_data.tb_user where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and kd_branch = ?  order by nama_detail", [(string) ($kd_center)]);
	}
else
	{
	$query_nm_sc = q_set($__p_query_nm_sc, "select nama_detail from ves_data.tb_user where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' order by nama_detail");	
	}

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

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=ve_inc_list_claim.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>VE Incentive List<br>
    </h1>
    <div class="col-md-3">
      <div class="form-group">
        <label>Center</label>
        <select class="form-control" name="nm_center"  onChange="this.form.submit()">
<?php if ($nama_lengkap == 'Indah Nur Atika Sari')
		{?>			

              <option value="Denpasar">Denpasar</option>
			
					
<?php 	} 
	elseif ($nama_lengkap == 'jimmy')
		{ ?>			
              <option value="East Sby">East Sby</option>
              <option value="West Sby">West Sby</option>
              <option value="Denpasar">Denpasar</option>
              <option value="Malang">Malang</option>
              <option value="South Jkt">South Jkt</option>
              <option value="North Jkt">North Jkt</option>
              <option value="West Jkt">West Jkt</option>
              <option value="Bandung">Bandung</option>
              <option value="PIK">PIK</option>
              <option value="Serpong">Serpong</option>
              <option value="Medan">Medan</option>
              <option value="CA">CA</option>
			
			
              <option value="All">All</option>				
<?php 	}  			
	elseif ($nama_lengkap =='kimberly')
		{ ?>			
              <option value="East Sby">East Sby</option>
              <option value="West Sby">West Sby</option>
              <option value="Malang">Malang</option>
              <option value="All">All</option>				
<?php 	} elseif ($nama_lengkap == 'maria simbolon')
		{ ?>			

              <option value="Bandung">Bandung</option>			
<?php 	} elseif ($nama_lengkap == 'Dian Nur Anisa') 
		{ ?>			

              <option value="South Jkt">South Jkt</option>
			
<?php 	}  elseif ($nama_lengkap == 'Christine Tania') 
		{ ?>			

              <option value="South Jkt">South Jkt</option>
              <option value="Medan">Medan</option>	
              <option value="Tangerang">Tangerang</option>	
			
			
<?php 	}  elseif ($nama_lengkap == 'Esther') 
		{ ?>			
              <option value="PIK">PIK</option>
              <option value="Serpong">Serpong</option>
              <option value="West Jkt">West Jkt</option>	
              <option value="All">All</option>				
<?php 	}	
	elseif 	($nama_lengkap =='Rivaldy Jonathan')
		{ ?>			
              <option value="North Jkt">North Jkt</option>
<?php 	}	
	elseif 	($nama_lengkap =='Gabriella')
		{ ?>							
              <option value="PIK">PIK</option><br>
              <option value="West Jkt">West Jkt</option>					
<?php 	}	elseif 	($nama_lengkap =='laura natalia 2' or $nama_lengkap =='laura natalia'  )
		{ ?>			
              <option value="Malang">Malang</option>			
<?php 	}	elseif 	($nama_lengkap =='Michael Lee')
		{ ?>
              <option value="West Sby">West Sby</option>	
              <option value="East Sby">East Sby</option>	
			
<?php 	}	elseif 	($nama_lengkap =='kimberly')
		{ ?>
              <option value="East Sby">East Sby</option>			
<?php 	}	elseif 	($nama_lengkap =='Cornelia Nathalie')
		{ ?>
              <option value="CA">CA</option>			
<?php 	}	?>			
					

          <option selected><?php echo  e($nm_center) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>Staff Name</label>
        <select class="form-control" name="nm_sc"  onChange="this.form.submit()">
			              <option value="All">All</option>	
          <?php
									
								$resource_nm_sc = db_query_or_die('errro_7', $query_nm_sc, $__p_query_nm_sc ?? []);
								while ($row_nm_sc=  db_fetch($resource_nm_sc, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_sc[0]).'">'.e($row_nm_sc[0]).'</option>';
							  		}      ?>
		
          <option selected><?php echo  e($nm_sc) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>Period<br>
        </label>
      </div>
      <div class="form-group"><small>
      <input type="date" format="dd/MM/yyyy" name="date_start" id="date" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
        </small>to <small>
        <input type="date" name="date_end" id="date3" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
      </small></div>		
    </div>
  </section>
  <!-- Main content -->
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
		  <label>VE Incentive Claim List </label>
		1</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=2% align=center >No</td>
	            <td width=10% align=center >Branch</td>
	            <td width=10% align=center >Student Name</td>
	            <td width=14% height="14" align=center >Class Code <br>
                Program<br>
                Start Class</td>
	            <td width="10%" align=center >Net Tuition Fee</td>
	            <td width="7%" align=center >Paid</td>
	            <td width="14%" align=center >Outstanding</td>
	            <td width="20%" align=center >Estimated Reward</td>
	            <td width="7%" align=center >Reward Status</td>
	            <td width="16%" align=center >Action</td>
              </tr>
            </thead>
<?php

if ($nm_center == 'All' and $nm_sc =='All')
{ 
	if ($nama_lengkap =='jimmy')
	{
			$query_billing = q_set($__p_query_billing, "SELECT\r
    a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y'),st_target\r
FROM ve_incentive a\r
LEFT JOIN vip_student_data b\r
       ON a.kd_biodata = b.kd_biodata\r
LEFT JOIN vip_billing d \r
       ON a.kelas = d.kd_class\r
      AND a.kd_billing = d.kd_billing\r
LEFT JOIN vip_mst_code_prg c \r
       ON d.kd_program = c.kd_program\r
      AND c.nm_program <> 'CLINIC'\r
      AND c.kd_program NOT IN ('WSCLINL','LC')\r
WHERE a.kd_branch IN (1,2,3,4,5,6,7,8,11,12)\r
  AND a.start_kelas >= ?\r
  AND a.start_kelas <= ? group by kelas, kd_biodata", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 00:00:00"]);	
	}
	elseif ($nama_lengkap =='Esther')
	{
			$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y'),st_target FROM ve_incentive a\r
\t\t\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\t\t\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\t\t\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where (a.kd_branch = 11 or a.kd_branch = 12 or a.kd_branch = 6)   and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	
	}	elseif ($nama_lengkap =='Cynthia Viangga')
	{
			$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y') ,st_targetFROM ve_incentive a\r
\t\t\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\t\t\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\t\t\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where a.kd_branch = 5    and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	
	}
elseif ($nama_lengkap =='kimberly')
	{
			$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y'),st_target FROM ve_incentive a\r
\t\t\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\t\t\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\t\t\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where (a.kd_branch = 1 or a.kd_branch = 2 or a.kd_branch = 8)   and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	
	}	
	
}
elseif ($nm_center == 'CA'  and $nm_sc =='All' )
	{

	$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y'),st_target FROM ve_incentive a\r
\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where  a.kelas like 'CA%'     and a.start_kelas between ? and ?  group by a.kelas, a.kd_biodata", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	

	}	
elseif ($nm_center == 'CA'  and $nm_sc !='All' )
	{

	$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y'),st_target FROM ve_incentive a\r
\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where  a.kelas like 'CA%' and sc = ?     and a.start_kelas between ? and ?  group by a.kelas, a.kd_biodata", [(string) ($nm_sc), (string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	

	}					  
elseif ($nm_center != 'All' and $nm_sc =='All')
	{

	$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y'),st_target FROM ve_incentive a\r
\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where a.kd_branch = ?     and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($kd_center), (string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	

	}
elseif ($nm_center == 'All' and $nm_sc !='All')
	{

	$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y'),st_target FROM ve_incentive a\r
\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where  sc = ?     and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($nm_sc), (string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	

	}					  
else
	{
	if ($nm_sc != 'All')
		{
		$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y') ,st_target FROM ve_incentive a\r
\t\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\t\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\t\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where a.kd_branch = ?  and sc = ?   and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($kd_center), (string) ($nm_sc), (string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	
		}
	else
		{
		if ($nama_lengkap =='jimmy' or $nama_lengkap =='kimberly')
			{
			$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y') ,st_target FROM ve_incentive a\r
\t\t\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\t\t\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\t\t\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where (a.kd_branch = 1 or a.kd_branch = 2 or a.kd_branch = 3 or a.kd_branch = 4 or a.kd_branch = 5 or a.kd_branch = 6 or a.kd_branch = 7 or a.kd_branch = 8 or a.kd_branch = 11 or a.kd_branch = 12 )    and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
			}		
		elseif ($nama_lengkap =='Ragel Suma Wijaya')
			{
			$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y') ,st_target FROM ve_incentive a\r
\t\t\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\t\t\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\t\t\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where (a.kd_branch = 1 or a.kd_branch = 3)   and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
			}
		elseif ($nama_lengkap =='Esther')
			{
			$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y') ,st_target FROM ve_incentive a\r
\t\t\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\t\t\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\t\t\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where (a.kd_branch = 11 or a.kd_branch = 12 or a.kd_branch = 6)   and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
			}
elseif ($nama_lengkap =='Cornelia Nathalie')
			{
			$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y') ,st_target FROM ve_incentive a\r
\t\t\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\t\t\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\t\t\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where a.kd_branch = 15   and a.start_kelas between ? and ? group by a.kelas, a.kd_biodata", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
			}		
		else
			{
			$query_billing = q_set($__p_query_billing, "SELECT a.kelas, a.kd_biodata, nama_sc, a.kd_branch, a.kd_billing, nama_lengkap, nm_program, type_program , private_pax, d.net_tf,date_format(a.start_kelas,'%d %b %y'),st_target FROM ve_incentive a\r
\t\t\tleft join vip_student_data b on a.kd_biodata = b.kd_biodata\r
\t\t\tleft join vip_billing d on a.kelas = d.kd_class and a.kd_billing = d.kd_billing\r
\t\t\tleft join vip_mst_code_prg c on d.kd_program = c.kd_program where a.kd_branch = ?  and a.start_kelas between ? and ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC')  group by a.kelas, a.kd_biodata", [(string) ($kd_center), (string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
			}		
		}	
	}
					 
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
					
$no_urut = 1;
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		if(num($row_billing[3])==1){$nama_cabang = 'East Sby';}
		elseif(num($row_billing[3])==2){$nama_cabang = 'West Sby';}
		elseif(num($row_billing[3])==3){$nama_cabang = 'Denpasar';}
		elseif(num($row_billing[3])==4){$nama_cabang = 'South Jkt';}
		elseif(num($row_billing[3])==5){$nama_cabang = 'North Jkt';}
		elseif(num($row_billing[3])==6){$nama_cabang = 'West Jkt';}
		elseif(num($row_billing[3])==7){$nama_cabang = 'Bandung';}
		elseif(num($row_billing[3])==8){$nama_cabang = 'Malang';}
		elseif(num($row_billing[3])==11){$nama_cabang = 'PIK';}
		elseif(num($row_billing[3])==12){$nama_cabang = 'Serpong';}
		
		if(num($row_billing[11]) ==1){$target = '(Target Achieved)';} else {$target = '';}
		
		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> '' and \r
\t\t(jns_payment = 'Full Payment' or jns_payment = 'Installment 1' or jns_payment = 'Installment 2' or  jns_payment = 'Installment 3' or  jns_payment = 'Down Payment' )  ", [(string) ($row_billing[4])]);

		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar = $row_bayar[0];	
				}
			}	
		$query_refund = q_set($__p_query_refund, "SELECT sum(v.amount)  FROM ves_data.vip_billing_refund v where kd_billing = ? ", [(string) ($row_billing[4])]);

		$resource_refund = db_query_soft($query_refund, $__p_query_refund ?? []);
		$keluar_refund = db_num_rows($resource_refund);	
		if(num(db_num_rows($resource_refund)) > 0)
			{
			while ($row_refund  =  db_fetch($resource_refund, PDO::FETCH_NUM))	
				{
				$refund = $row_refund[0];
				}
			}	
		//$mbayar = $mbayar_tf+$mbayar_material+$mbayar_reg;
		$mbayar = num($mbayar) - num($refund);		

//=== hitung incentive
		$type_program = $row_billing[7];
		$jml_pax = $row_billing[8];

			$query_cek = q_set($__p_query_cek, "SELECT *  FROM  ves_data.ve_incentive where kelas = ? and  kd_biodata = ?  and kd_billing = ? ", [(string) ($row_billing[0]), (string) ($row_billing[1]), (string) ($row_billing[4])]);
			$resource_cek = db_query_soft($query_cek, $__p_query_cek ?? []);

			if(num(db_num_rows($resource_cek)) > 0)
				{
				while ($row_incentive  =  db_fetch($resource_cek, PDO::FETCH_NUM))
					{
					$nomor_asli = $row_incentive['0'];
					$st_reward = $row_incentive['12'];
					$besar_reward = $row_incentive['4'];

					if (num($st_reward) == 1)
						{
						$status_tampil = 'Pending';
						$st_reward =1;
						$ttl_enable_to_claim = num($ttl_enable_to_claim)	  + num($besar_reward);						
						}
					elseif (num($st_reward) == 2)
						{
						$status_tampil = 'Approval required';
						$ttl_proposed_to_claim = num($ttl_proposed_to_claim)  + num($besar_reward);
						}
					elseif (num($st_reward) == 3)
						{
						$status_tampil = 'Approved, acknowledge required';
						$ttl_claim_approved = num($ttl_claim_approved)  + num($besar_reward);						
						}
					elseif (num($st_reward) == 4)
						{
						$status_tampil = 'Approved & Acknowledge';
						$ttl_acknowledge = num($ttl_acknowledge)  + num($besar_reward);							
						}
					elseif (num($st_reward) == 5)
						{
						$status_tampil = 'Accounting Checked';
						
						}
					elseif (num($st_reward) == 6)
						{
						$status_tampil = 'Accounting Correction';
						$ttl_correction = num($ttl_correction)  + num($besar_reward);							
						}	
					elseif (num($st_reward) == 7)
						{
						$status_tampil = 'Tax Processing';
					
						}
					elseif (num($st_reward) == 8)
						{
						$status_tampil = 'Paid';
						$ttl_paid = num($ttl_paid)  + num($besar_reward);			
						}	
					}
				}


		if (num($st_reward) == 2 or num($st_reward) == 3 or num($st_reward) == 4 or num($st_reward) ==5 )
		{	?>					  
	        <tbody>
          
	          <tr>
	            <td align=center class="style24"><?php echo e($no_urut) ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[2]) ?><br>
                <?php echo e($nama_cabang) ?></td>
	            <td align=center class="style24">
	            <?php echo e($row_billing[5]) ?><br>
	            <?php echo e($row_billing[4]) ?><br></td>
	            <td height="14" align=center class="style24"><?php echo e($row_billing[0]) ?> <br>	              
	              <?php echo e($row_billing[6]) ?> <?php echo e($row_billing[7]) ?> <?php echo e($row_billing[8]) ?><br>
	              <?php echo e($row_billing[10]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[9])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($mbayar),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num((num($row_billing[9])-num($mbayar))),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($besar_reward),0,".",".") ?><br><?php echo e($target) ?></td>
	            <td align=center class="style24"><?php echo e($status_tampil) ?></td>
	            <td align=center class="style24">
				<?php if (num($st_reward) == 2 and ($posisi =='CM'  or $nama_lengkap =='jimmy')){ ?>
					<a href="#" 
target="popup" 
onclick="window.open('ve_inc_proses.php?noinc=<?php echo e(u($nomor_asli)) ?>&propose=3','popup','width=1000,height=800'); return false;">
				Approve</a><?php } elseif (num($st_reward) == 3 and ($nama_lengkap =='jimmy' or $nama_lengkap =='Michael Lee')){ ?>
					<a href="#" 
target="popup" 
onclick="window.open('ve_inc_proses.php?noinc=<?php echo e(u($nomor_asli)) ?>&propose=4','popup','width=1000,height=800'); return false;">
				Acknowledge</a><?php } ?>
				</td>
              </tr>
             <?php $no_urut = num($no_urut) +1;$status_tampil='';								$st_reward =0; }} }?>
				<?php if ($ttl_claim_approved != ''and ($nama_lengkap =='jimmy' or $nama_lengkap =='kimberly')){?>
<tr>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center bgcolor="#A108F3" class="style24"><strong>					<a href="#" 
target="popup" 
onclick="window.open('ve_inc_proses.php?noinc=all&propose=3&kdcbg=<?php echo e(u($kd_center)) ?>','popup','width=1000,height=800'); return false;">
				Approve All</a></strong></td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center bgcolor="#A4BAF7" class="style24"><strong>					<a href="#" 
target="popup" 
onclick="window.open('ve_inc_proses.php?noinc=all&propose=4&kdcbg=<?php echo e(u($kd_center)) ?>','popup','width=1000,height=800'); return false;">
				Acknowledge All</a></strong></td>
              </tr>				<?php } ?>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>
<div class="col-md-12">
    <div class="form-group">
      <label>Start Class Period : <?php echo e($date_start) ?> to <?php echo e($date_end) ?>
		</label>
    </div>
  </div>
<br>
	  
<div class="col-md-1">
  <div class="pad box-pane-right bg-yellow">
	<div class="form-group">
      <label>To be Claim <br>
 Rp. <?php echo  number_format(num($ttl_enable_to_claim),0,".",".") ?> 
		</label>
	 </div></div>
</div>
<div class="col-md-1">
 <div class="pad box-pane-right bg-blue">	
  <div class="form-group">
    <label>Proposed <br>
      Rp. <?php echo  number_format(num($ttl_proposed_to_claim),0,".",".") ?> </label>
  </div></div>
</div>
<div class="col-md-1">
<div class="pad box-pane-right bg-gray">		
  <div class="form-group">
    <label>Approved <br>
      Rp. <?php echo  number_format(num($ttl_claim_approved),0,".",".") ?></label>
	</div></div>
</div>
<div class="col-md-1">
  <div class="pad box-pane-right bg-teal">
    <div class="form-group">
      <label>Acknowledge <br>
        Rp. <?php echo  number_format(num($ttl_acknowledge),0,".",".") ?></label>
    </div>
  </div>
</div>
<div class="col-md-1">
  <div class="pad box-pane-right bg-red-gradient">		
  <div class="form-group">
    <label>Correction <br>
      Rp. <?php echo  number_format(num($ttl_correction),0,".",".") ?></label>
	</div></div>
</div>
<div class="col-md-1">
<div class="pad box-pane-right bg-green">		
  <div class="form-group">
    <label>Paid <br>
      Rp. <?php echo  number_format(num($ttl_paid),0,".",".") ?></label>
	</div></div>
</div>
  
<!-- /.box -->
  </div>
        <!-- /.col -->
  </div>
      <!-- /.row --><!-- /.content -->
	</form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->

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

