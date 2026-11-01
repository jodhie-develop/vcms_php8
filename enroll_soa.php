<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
//include __DIR__ . "/atas.php";
//include __DIR__ . "/left.php";
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$dt_mulai = in_val('dt_mulai', 'get');
$dt_selesai = in_val('dt_selesai', 'get');
$cut_off = in_val('cut_off', 'get');
$date_end = in_val('date_end', 'get');
if ($dt_mulai ==''){$dt_mulai = $hari_ini;}
if ($dt_selesai ==''){$dt_selesai = $hari_ini;}
if ($cut_off ==''){$cut_off = $hari_ini;}
$kd_cbg = in_val('kd_cbg', 'get');



$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$week = in_val('week', 'get');
$query = q_set($__p_query, "SELECT no_week, tgl_periode, bulan FROM master_date where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);

$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$urut_week= $row[0];
		$tgl_periode = $row[1];
	}
}
$sql = q_set($__p_sql, "SELECT  min(detail), max(detail),date_format(detail,'%Y-%m') ,date_format(detail,'%Y'), date_format(min(detail),'%d %b %Y'), date_format(max(detail),'%d %b %Y')  FROM ves_data.tb_minggu_detail where minggu = ? and sales_year = ? ", [(string) ($week), (string) ($sales_year)]);
$rs = db_query_soft($sql, $__p_sql ?? []);
while($row = db_fetch($rs))
{
	$awal_mgg= $row[0];
	$akhir_mgg = $row[1];
	$dtl_bln = $row[2];
	$dtl_thn = $row[3];
	$awal_tampil = $row[4];
	$akhir_tampil = $row[5];
	
	$awal_bln = "$dtl_bln-01";
	$awal_thn = "$dtl_thn-01-01";
	
}
$dt_today = in_val('dt_today', 'get');
$thnn = substr($dt_today,0,4);
$blnn = substr($dt_today,0,7);
$awal_bln = "$blnn-01";

$awal_thn = "$thnn-01-01";
    $source = $dt_today;
    $date_tgl = new DateTime($source);
    $date_tgl =  $date_tgl->format('d M Y'); // 31-07-2012
$nm_center = in_val('nm_center', 'get');
if (num($nm_center)==1){$kode_center = $nm_center; $nm_center='East Sby';}
elseif (num($nm_center)==2){$kode_center = $nm_center; $nm_center='West Sby';}
elseif (num($nm_center)==3){$kode_center = $nm_center; $nm_center='Bali';}
elseif (num($nm_center)==4){$kode_center = $nm_center; $nm_center='South Jkt';}
elseif (num($nm_center)==5){$kode_center = $nm_center; $nm_center='North Jkt';}
elseif (num($nm_center)==11){$kode_center = $nm_center; $nm_center='PIK';}
elseif (num($nm_center)==6){$kode_center = $nm_center; $nm_center='West Jkt';}
elseif (num($nm_center)==7){$kode_center = $nm_center; $nm_center='Bandung';}
elseif (num($nm_center)==8){$kode_center = $nm_center; $nm_center='Malang';}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SOA LIST</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">


  <!-- Full Width Column -->
 <form method=get action=enroll_soa.php> 	
  <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <section class="content-header">
     <h1>SOA Balance Summary<br>
     </h1>
 
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         
         <tr>
           <th scope="row">Branch</th>
           <td><span class="form-group">
             <select  name="nm_center">
               <option value="All">All</option>
               <option value="1">East Sby</option>
               <option value="2">West Sby</option>
               <option value="3">Bali</option>
               <option value="4">South Jkt</option>
               <option value="5">North Jkt</option>
               <option value="11">PIK</option>
               <option value="6">West Jkt</option>
               <option value="7">Bandung</option>
               <option value="8">Malang</option>


               <option selected><?php echo  e($nm_center) ?></option>
             </select>
           </span></td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <th width="12%" scope="row">Enroll Period Date</th>
           <td width="88%" colspan="5"><span class="form-group">
             <input type="date"id="exampleInputEmail25" width="20" placeholder="Your Name" name="dt_mulai" value="<?php echo e($dt_mulai) ?>" >
             to 
             <input type="date" id="exampleInputEmail" placeholder="Your Name" name="dt_selesai" value="<?php echo e($dt_selesai) ?>" ></span></td>
         </tr>
         <tr>
           <th scope="row" style="font-size: 15">Cut Off Balance</th>
           <td colspan="5" style="font-size: 15"><span class="form-group">
             <input type="date" id="exampleInputEmail2" placeholder="Your Name" name="cut_off" value="<?php echo e($cut_off) ?>" >
           </span></td>
         </tr>
         <tr>
           <th scope="row" style="font-size: 15">&nbsp;</th>
           <td colspan="5" style="font-size: 15"><span class="form-group">
             <input type="Submit" name="Simpan" value="Display" class="btn btn-primary" />
           </span></td>
         </tr>
       </tbody>
     </table>
   

   </section>

      <!-- Main content -->
     
            <!-- /.box-header -->
            
              <table width="100%" class="table table-hover">
				  <jdl>
                <thead>
                <tr bordercolordark="#090909">
                  <th height="23" colspan="9" style="text-align: center; font-size: 20px">SOA Student List</th>
                  </tr>
                <tr bordercolordark="#090909">
                  <th height="32" style="text-align: center"><strong><span style="font-size: 15">Periode</span> : <?php echo e($date_tgl) ?></strong></th>
                  <th style="text-align: center">&nbsp;</th>
                  <th style="text-align: center">&nbsp;</th>
                  <th style="text-align: center">&nbsp;</th>
                  <th style="text-align: center">&nbsp;</th>
                  <th style="text-align: center">&nbsp;</th>
                  <th style="text-align: center">&nbsp;</th>
                  <th style="text-align: center">&nbsp;</th>
                  <th style="text-align: center">&nbsp;</th>
                  </tr>
                <tr style="font-size: 1em">
                  <th width="6%"bgcolor="#C2C2C2">No</th>
                  <th width="10%"bgcolor="#C2C2C2">Branch</th>
                  <th width="15%"bgcolor="#C2C2C2">Student Name</th>
                  <th width="8%" bgcolor="#C2C2C2" style="text-align: center">Enroll Date</th>
                  <th width="27%"bgcolor="#C2C2C2">Institution</th>
                  <th width="8%" bgcolor="#C2C2C2" style="text-align: center">Intake Date</th>
                  <th width="9%"bgcolor="#C2C2C2">Status</th>
                  <th width="8%" bgcolor="#C2C2C2" style="text-align: center">Balance</th>
                  <th width="9%" bgcolor="#C2C2C2">Action</th>
                  </tr>
                </thead>
				  </jdl>					  
                <tbody>

				  <?php $no_urut = 1; $total_saldo = 0;
if($nm_center != 'All'){				   
					$query_cabang = q_set($__p_query_cabang, "select a.cabang, a.nama, b.country, b.school, a.enroll_date,a.kd_biodata  from tb_sales_report a\r
left join tb_master_partner b on a.kd_school = b.kd_school\r
where a.enroll_date between ? and ? and prioritas =  1  and kd_cabang = ?  order by\r
a.enroll_date ", [(string) ($dt_mulai), (string) ($dt_selesai), (string) ($kode_center)]);}else {				   
					$query_cabang = q_set($__p_query_cabang, "select a.cabang, a.nama, b.country, b.school, a.enroll_date,a.kd_biodata  from tb_sales_report a\r
left join tb_master_partner b on a.kd_school = b.kd_school\r
where a.enroll_date between ? and ? and prioritas =  1    order by\r
case when kd_cabang = 1 then 0\r
when kd_cabang = 2 then 1\r
when kd_cabang = 3 then 2\r
when kd_cabang = 4 then 3\r
when kd_cabang = 5 then 4\r
when kd_cabang = 6 then 5\r
when kd_cabang = 11 then 6\r
when kd_cabang = 7 then 7\r
when kd_cabang = 8 then 8\r
else 20 end , a. enroll_date  ", [(string) ($dt_mulai), (string) ($dt_selesai)]);}

					$result_cabang=db_query_or_die("Wah error nih11", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$cabang = $r_cbg[0];
							$nama = $r_cbg[1];
							$country = $r_cbg[2];
							$school = $r_cbg[3];
							$enroll_date = $r_cbg[4];
							$kd_biodata = $r_cbg[5];
					$query_adm = q_set($__p_query_adm, "select no from adm_stu_progress where kd_biodata = ? and enroll_date = ? order by no desc limit 1", [(string) ($kd_biodata), (string) ($enroll_date)]);
					$result_adm=db_query_or_die("Wah error nih11", $query_adm, $__p_query_adm ?? []);
					if ($result_adm) 
						{ 
						while ($r_adm = db_fetch($result_adm))
							{
							$no_terkahir = $r_adm[0];
							}
						}
					$query_adm_st = q_set($__p_query_adm_st, "select final_status, tgl_intake from adm_stu_progress where kd_biodata = ? and enroll_date = ? order by no desc limit 1", [(string) ($kd_biodata), (string) ($enroll_date)]);
					$result_adm_st=db_query_or_die("Wah error nih13", $query_adm_st, $__p_query_adm_st ?? []);
					if ($result_adm_st) 
						{ 
						while ($r_adm_st = db_fetch($result_adm_st))
							{
							$final_status = $r_adm_st[0];
							$tgl_intake = $r_adm_st[1];
							
							}
					}	
					$query_soa = q_set($__p_query_soa, "select id_soa from adm_soa where kd_biodata = ? and enroll_date  = ?  order by id desc limit 1", [(string) ($kd_biodata), (string) ($enroll_date)]);
					$result_soa =db_query_or_die("Wah error nih15", $query_soa, $__p_query_soa ?? []);
					if ($result_soa) 
						{ 
						while ($r_soa = db_fetch($result_soa))
							{
							$id_soa = $r_soa[0];
							
							}
					}								
					$query_balance = q_set($__p_query_balance, "select (sum(rp_debet) - sum(rp_kredit)) from adm_soa where id_soa = ? and keterangan <> 'Service Fee Paid'  and dt_entry <=? ", [(string) ($id_soa), (string) ($cut_off)]);
					$result_balance =db_query_or_die("Wah error nih15", $query_balance, $__p_query_balance ?? []);
					if ($result_balance) 
						{ 
						while ($r_balance = db_fetch($result_balance))
							{
							$saldo = $r_balance[0]; $total_saldo = num($total_saldo) + num($saldo);
							
							}
					}

				?>               
					
                <tr class style="border: #050505">
                  <td height="20"><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($cabang) ; ?>                                    
                  <td><?php echo e($nama) ; ?>
                  - <?php echo e($id_soa) ; ?>
                  <td style="text-align: center"><?php echo e($enroll_date) ; ?></td>
                  <td style="text-align: left"><?php echo e($country) ; ?> - <?php echo e($school) ; ?></td>
                  <td style="text-align: center"><?php echo e($tgl_intake) ; ?></td>					
                  <td style="text-align: center"><?php echo e($final_status) ; ?></td>	
                  <td><?php echo   number_format(num($saldo),0,".",".")  ; ?></td>
                  <td style="text-align: center"><a href="soa_dtl.php'" 
target="blank" 
onclick="window.open('printable/prt_soa.php?idsoa=<?php echo e(u($id_soa)) ?>&ed=<?php echo e(u($enroll_date)) ?>','popup','width=1000,height=800'); return false;">view</a></td>
                  </tr> <?php $no_urut = num($no_urut)+1;  } } ?>
                <tr>
                  <td height="20"><strong>TOTAL</strong></td>
                  <td>&nbsp;</td>
                  <td height="20">&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right" >&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td style="text-align: center"><?php echo   number_format(num($total_saldo),0,".",".")  ; ?></td>
                  <td style="text-align: right">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="20">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td height="20">&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right" >&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td style="text-align: center">&nbsp;</td>
                  <td style="text-align: right">&nbsp;</td>
                  </tr>
               
            
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            
            <div class="box">
         	<div class="box-body" align="right">generated from vcms</div>
      </div>
            <!-- /.box-body -->
   
      <!-- /.content -->
    </div>
    <!-- /.container -->
  
  <!-- /.content-wrapper -->
	</form>	 

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
