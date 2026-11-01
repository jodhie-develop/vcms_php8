<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$q = in_val('q', 'get');
$search = in_val('search', 'get');
$status_payment = in_val('status_payment', 'get');
$pilihan_center = in_val('pilihan_center', 'get');
if ($status_payment==''){$status_payment="All";}
if ($pilihan_center==''){$pilihan_center="All";}

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}
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




function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
}
if ($pilihan_center=='All'){$datacabang ="";}
if ($pilihan_center=='East Sby'){$datacabang = q_set($__p_datacabang, " and c.branch = 'East Sby' ");}
if ($pilihan_center=='West Sby'){$datacabang = q_set($__p_datacabang, " and c.branch = 'West Sby' ");}
if ($pilihan_center=='Denpasar'){$datacabang = q_set($__p_datacabang, " and c.branch = 'Bali' ");}
if ($pilihan_center=='South Jkt'){$datacabang = q_set($__p_datacabang, " and c.branch = 'patal Jkt' ");}
if ($pilihan_center=='North Jkt'){$datacabang = q_set($__p_datacabang, " and c.branch = 'Central Jkt' ");}
if ($pilihan_center=='West Jkt'){$datacabang = q_set($__p_datacabang, " and c.branch = 'West Jkt' ");}
if ($pilihan_center=='Bandung'){$datacabang = q_set($__p_datacabang, " and c.branch = 'Bandung' ");}
if ($pilihan_center=='Malang TBI'){$datacabang = q_set($__p_datacabang, " and c.branch = 'Malang TBI' ");}
if ($pilihan_center=='Bali TBI'){$datacabang = q_set($__p_datacabang, " and c.branch = 'Bali TBI' ");}
if ($pilihan_center=='Bandung TBI'){$datacabang = q_set($__p_datacabang, " and c.branch = 'Bandung TBI' ");}

//========================
if ($status_payment=="All")
	{
	$query_total = q_set($__p_query_total, "SELECT  b.mount_rp_pay, a.mount_rp FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date between ? and ? " . $datacabang . "  group by c.kd_biodata, a.kd_invoice ", [(string) ($date_start), (string) ($date_end), ...($__p_datacabang ?? [])]);	
	}
elseif ($status_payment=="Leaving")
	{
	$query_total = q_set($__p_query_total, "SELECT b.mount_rp_pay, a.mount_rp  FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date between ? and ?\r
\tand (a.dt_invoice is null or a.dt_invoice ='') and (b.dt_payment is null or b.dt_payment = '') " . $datacabang . "  group by c.kd_biodata, a.kd_invoice", [(string) ($date_start), (string) ($date_end), ...($__p_datacabang ?? [])]);	
	}
elseif ($status_payment=="Invoicing")
	{
	$query_total = q_set($__p_query_total, "SELECT b.mount_rp_pay, a.mount_rp  FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date between ? and ?\r
\tand (a.dt_invoice is not null or a.dt_invoice <>'') and (b.dt_payment is null or b.dt_payment = '')  " . $datacabang . "  group by c.kd_biodata, a.kd_invoice", [(string) ($date_start), (string) ($date_end), ...($__p_datacabang ?? [])]);	
	}						   
elseif ($status_payment=="Paid")
	{
	$query_total = q_set($__p_query_total, "SELECT b.mount_rp_pay, a.mount_rp  FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date between ? and ?\r
\tand (a.dt_invoice is not null or a.dt_invoice <>'') and (b.dt_payment is not null or b.dt_payment <> '')  " . $datacabang . "  group by c.kd_biodata, a.kd_invoice", [(string) ($date_start), (string) ($date_end), ...($__p_datacabang ?? [])]);	
	}	
elseif ($status_payment=="Prev Sales Paid")
	{
	$query_total = q_set($__p_query_total, "SELECT b.mount_rp_pay, a.mount_rp  FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date < ?\r
\tand (a.dt_invoice is not null or a.dt_invoice <>'') and (b.dt_payment is not null or b.dt_payment <> '') and dt_payment >=?  " . $datacabang . "  group by c.kd_biodata, a.kd_invoice", [(string) ($date_start), (string) ($date_start), ...($__p_datacabang ?? [])]);	
	}	

$total_amount_tampil =0;
$total_amount_invoice_tampil =0;

$resource_total = db_query_or_die('errro_2', $query_total, $__p_query_total ?? []);
$keluar_total= db_num_rows($resource_total);
if(num(db_num_rows($resource_total)) > 0)
	{
	while ($row_total=  db_fetch($resource_total, PDO::FETCH_NUM))
		{					
		$total_amount = $row_total[0];
		$total_amount_tampil = num($total_amount_tampil) + 	num($total_amount);
		$total_amount_invoice = $row_total[1];
		$total_amount_invoice_tampil = num($total_amount_invoice_tampil) + 	num($total_amount_invoice);			
		}
	}
//==========================
 
//$query = "SELECT c.branch, c.nama, c.dest_country, c.dest_school, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice,
//DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay,  DATE_FORMAT(b.dt_payment,'%d %b %y'),
//(case  when  c.final_status = 'L' then 1 else 0 end )as main,
//(case  when  c.final_status <> 'L' then 1 else 0 end )as add_l,
//(case  when  a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing,
//(case  when  b.mount_rp_pay <> '' then 1 else 0 end ) as paid,c.bintang FROM adm_stu_progress c
//left join fin_invoice a on c.no =  a.no_leaving
//left join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice
//where c.final_status like '%L%' and c.comm_date between '2015-07-01' and '2016-06-30' $urutan ";
if ($status_payment=="All")
	{
	$query = q_set($__p_query, "SELECT c.branch, c.nama, c.dest_country, c.dest_school, d.grade, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice, DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'), (case when c.final_status = 'L' then 1 else 0 end )as main, (case when c.final_status <> 'L' then 1 else 0 end )as add_l, (case when a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing, (case when b.mount_rp_pay <> '' then 1 else 0 end ) as paid,c.tuition,  DATE_FORMAT(c.enroll_date,'%d %b %y'),d.groupschool  FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date between ? and ? " . $datacabang . "  \r
\t group by c.kd_biodata, a.kd_invoice\r
\torder by c.branch,\r
\tcase when dest_country like 'USA%' then 0 when dest_country like 'CAN%' then 1 when dest_country like 'SW%' then 2\r
\twhen dest_country like 'UK%' then 3 when dest_country like 'SPA%' then 4 when dest_country like 'IT%' then 5\r
\twhen dest_country like 'AUS%' then 6 when dest_country like 'NEW%' then 7 when dest_country like 'SIN%' then 8\r
\twhen dest_country like 'MAL%' then 9 when dest_country like 'CHI%' then 10 when dest_country like 'IN%' then 11 ELSE 12 end,\r
\tc.nama, c.comm_date, a.dt_invoice", [(string) ($date_start), (string) ($date_end), ...($__p_datacabang ?? [])]);	
	}
elseif ($status_payment=="Leaving")
	{
	$query = q_set($__p_query, "SELECT c.branch, c.nama, c.dest_country, c.dest_school, d.grade, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice, DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'), (case when c.final_status = 'L' then 1 else 0 end )as main, (case when c.final_status <> 'L' then 1 else 0 end )as add_l, (case when a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing, (case when b.mount_rp_pay <> '' then 1 else 0 end ) as paid,c.tuition,  DATE_FORMAT(c.enroll_date,'%d %b %y'),d.groupschool  FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date between ? and ?\r
\tand (a.dt_invoice is null or a.dt_invoice ='') and (b.dt_payment is null or b.dt_payment = '')  " . $datacabang . "  group by c.kd_biodata, a.kd_invoice\r
\torder by c.branch,\r
\tcase when dest_country like 'USA%' then 0 when dest_country like 'CAN%' then 1 when dest_country like 'SW%' then 2\r
\twhen dest_country like 'UK%' then 3 when dest_country like 'SPA%' then 4 when dest_country like 'IT%' then 5\r
\twhen dest_country like 'AUS%' then 6 when dest_country like 'NEW%' then 7 when dest_country like 'SIN%' then 8\r
\twhen dest_country like 'MAL%' then 9 when dest_country like 'CHI%' then 10 when dest_country like 'IN%' then 11 ELSE 12 end,\r
\tc.nama, c.comm_date, a.dt_invoice", [(string) ($date_start), (string) ($date_end), ...($__p_datacabang ?? [])]);	
	}
elseif ($status_payment=="Invoicing")
	{
	$query = q_set($__p_query, "SELECT c.branch, c.nama, c.dest_country, c.dest_school, d.grade, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice, DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'), (case when c.final_status = 'L' then 1 else 0 end )as main, (case when c.final_status <> 'L' then 1 else 0 end )as add_l, (case when a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing, (case when b.mount_rp_pay <> '' then 1 else 0 end ) as paid ,c.tuition,  DATE_FORMAT(c.enroll_date,'%d %b %y'),d.groupschool  FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date between ? and ?\r
\tand (a.dt_invoice is not null or a.dt_invoice <>'') and (b.dt_payment is null or b.dt_payment = '') " . $datacabang . "   group by c.kd_biodata, a.kd_invoice\r
\torder by c.branch,\r
\tcase when dest_country like 'USA%' then 0 when dest_country like 'CAN%' then 1 when dest_country like 'SW%' then 2\r
\twhen dest_country like 'UK%' then 3 when dest_country like 'SPA%' then 4 when dest_country like 'IT%' then 5\r
\twhen dest_country like 'AUS%' then 6 when dest_country like 'NEW%' then 7 when dest_country like 'SIN%' then 8\r
\twhen dest_country like 'MAL%' then 9 when dest_country like 'CHI%' then 10 when dest_country like 'IN%' then 11 ELSE 12 end,\r
\tc.nama, c.comm_date, a.dt_invoice", [(string) ($date_start), (string) ($date_end), ...($__p_datacabang ?? [])]);	
	}						   
elseif ($status_payment=="Paid")
	{
	$query = q_set($__p_query, "SELECT c.branch, c.nama, c.dest_country, c.dest_school, d.grade, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice, DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'), (case when c.final_status = 'L' then 1 else 0 end )as main, (case when c.final_status <> 'L' then 1 else 0 end )as add_l, (case when a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing, (case when b.mount_rp_pay <> '' then 1 else 0 end ) as paid,c.tuition,  DATE_FORMAT(c.enroll_date,'%d %b %y'),d.groupschool   FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date between ? and ?\r
\tand (a.dt_invoice is not null or a.dt_invoice <>'') and (b.dt_payment is not null or b.dt_payment <> '') " . $datacabang . "   group by c.kd_biodata, a.kd_invoice\r
\torder by c.branch,\r
\tcase when dest_country like 'USA%' then 0 when dest_country like 'CAN%' then 1 when dest_country like 'SW%' then 2\r
\twhen dest_country like 'UK%' then 3 when dest_country like 'SPA%' then 4 when dest_country like 'IT%' then 5\r
\twhen dest_country like 'AUS%' then 6 when dest_country like 'NEW%' then 7 when dest_country like 'SIN%' then 8\r
\twhen dest_country like 'MAL%' then 9 when dest_country like 'CHI%' then 10 when dest_country like 'IN%' then 11 ELSE 12 end,\r
\tc.nama, c.comm_date, a.dt_invoice", [(string) ($date_start), (string) ($date_end), ...($__p_datacabang ?? [])]);	
	}	
elseif ($status_payment=="Prev Sales Paid")
	{
	$query = q_set($__p_query, "SELECT c.branch, c.nama, c.dest_country, c.dest_school, d.grade, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice, DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'), (case when c.final_status = 'L' then 1 else 0 end )as main, (case when c.final_status <> 'L' then 1 else 0 end )as add_l, (case when a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing, (case when b.mount_rp_pay <> '' then 1 else 0 end ) as paid,c.tuition,  DATE_FORMAT(c.enroll_date,'%d %b %y'),d.groupschool   FROM adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and c.comm_date < ?\r
\tand (a.dt_invoice is not null or a.dt_invoice <>'') and (b.dt_payment is not null or b.dt_payment <> '') and dt_payment >='2016-07-01' " . $datacabang . "   group by c.kd_biodata, a.kd_invoice\r
\torder by c.branch,\r
\tcase when dest_country like 'USA%' then 0 when dest_country like 'CAN%' then 1 when dest_country like 'SW%' then 2\r
\twhen dest_country like 'UK%' then 3 when dest_country like 'SPA%' then 4 when dest_country like 'IT%' then 5\r
\twhen dest_country like 'AUS%' then 6 when dest_country like 'NEW%' then 7 when dest_country like 'SIN%' then 8\r
\twhen dest_country like 'MAL%' then 9 when dest_country like 'CHI%' then 10 when dest_country like 'IN%' then 11 ELSE 12 end,\r
\tc.nama, c.comm_date, a.dt_invoice", [(string) ($date_start), ...($__p_datacabang ?? [])]);	
	}				   


$nomor = 1;

$resource = db_query_soft($query, $__p_query ?? []);

$keluar = db_num_rows($resource);

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
<?php //========================== left nav ?>
 <?php   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=leadstatement.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Leaving, Invoicing &amp; Payment<br>
      </h1>
     <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Leaving Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td height="24"><small>
              <label for="date7"> Status</label>
            </small></td>
            <td><small>
              <label for="date8">:</label>
              <select name="status_payment"  onChange="this.form.submit()">
                <option>All</option>               
                <option>Leaving</option>
                <option>Invoicing</option>
                <option>Paid</option>
                <option>Prev Sales Paid</option>
                            
                <option selected><?php echo e($status_payment) ?></option>
              </select>
            </small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date3"> Center</label>
            </small></td>
            <td><small>
            <label for="date4">:</label>
 <select name="pilihan_center"  onChange="this.form.submit()">
                <option>All</option>               
                <option>East Sby</option>
                <option>West Sby</option>
                <option>Denpasar</option>
                <option>South Jkt</option>
                <option>North Jkt</option>
                <option>West Jkt</option>
                <option>Bandung</option>
                <option>Malang TBI</option> 
                <option>Bali TBI</option> 
                <option>Bandung TBI</option>                                                            
                <option selected><?php echo e($pilihan_center) ?></option>  
			</select>
 <input type="text" name="q" id="q" value="<?php echo e($q) ; ?>" hidden="hidden">
            <input type="text" name="search" id="q2" value="<?php echo e($search) ; ?>" hidden="hidden">
            </small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date9"> Total Data</label>
            </small></td>
            <td><strong>: <?php echo e($keluar) ?> </strong></td>
          </tr>
          <tr>
            <td height="24"><small>
              <label for="date11"> Total Amount Invoice</label>
            </small></td>
            <td><strong>: <?php echo e(buatrp($total_amount_invoice_tampil)) ?></strong></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date10"> Total Amount Paid</label>
            </small></td>
            <td><strong>: <?php echo e(buatrp($total_amount_tampil)) ?></strong></td>
          </tr>
        </tbody>
     </table>
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
   <tr>
      <td width=3% rowspan="2" align=center >No</td>
      <td width="5%" rowspan="2" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=center">Center</a></td>
      <td width="14%" rowspan="2" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=student">Student Name</a></td>
      <td align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=student">Enrolled Date</a></td>
      <td height=14 align=center >Destination</td>
      <td height=14 align=center >&nbsp;</td>
      <td height=14 align=center >&nbsp;</td>
      <td align=center >&nbsp;</td>
      <td height=14 align=center >&nbsp;</td>
      <td width="3%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=comm">Commencement Date</a></td>
      <td height=14 align=center >Invoice</td>
      <td height=14 align=center >&nbsp;</td>
      <td height=14 align=center >&nbsp;</td>
      <td height=14 align=center >&nbsp;</td>
      <td align=center >Payment</td>
      <td align=center >&nbsp;</td>
      <td align=center >Leaving</td>
      <td align=center >&nbsp;</td>
      <td align=center >Status</td>
      <td align=center >&nbsp;</td>
    </tr>
    <tr>
      <td width="7%" align=center >&nbsp;</td>
      <td width="7%" height=14 align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=country">Country</a></td>
      <td width="7%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=school">School</a></td>
      <td width="7%" height=14 align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=program">Program</a></td>
      <td width="3%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=tuition">Tuition</a></td>
      <td width="3%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=grade">grade</a></td>
      <td width="3%" align=center >&nbsp;</td>
      <td width="8%" height=14 align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=invoice">No Invoice/Date</a></td>
      <td width="10%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Curr</a>
        <br></td>
      <td width="5%" height=14 align=center >Mount</td>
      <td width="5%" align=center >Rate</td>
      <td width="7%" align=center >Mount</td>
      <td width="4%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=datepay">Date</a></td>
      <td width="3%" align=center >Main</td>
      <td width="2%" align=center >Add/Lang</td>
      <td width="4%" align=center >Invoice</td>
      <td width="3%" align=center >Paid</td>
    </tr>
                </thead>
                <tbody>
<?php
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		
?>	
    <tr>
      <td align=center class="style24"><?php echo e($nomor) ?></td>
      <td align=center class="style24"><?php echo e($row[0]) ?></td>
      <td align=left class="style24"><?php echo e($row[1]) ?></td>
      <td align=left class="style24"><?php echo e($row[19]) ?></td>
      <td height=14 align=left class="style24"><?php echo e($row[2]) ?></td>
      <td align=left class="style24"><?php echo e($row[3]) ?><br>
        <?php echo e($row[20]) ?></td>
      <td height=14 align=left class="style24"><?php echo e($row[5]) ?></td>
      <td align=center class="style24"><?php echo e($row[18]) ?></td>
      <td align=center class="style24"><?php echo e($row[4]) ?></td>
      <td align=center class="style24"><?php echo e($row[6]) ?></td>
      <td height=14 align=center class="style24"><?php echo e($row[7]) ?><br>
      <?php echo e($row[8]) ?><br></td>
      <td align=center class="style24"><?php echo e($row[9]) ?></td>
      <td height=14 align=center class="style24"><?php echo e(buatrp($row[10])) ?></td>
      <td align=center class="style24"><?php echo e(buatrp($row[11])) ?></td>
      <td align=center class="style24"><?php echo e(buatrp($row[12])) ?></td>
      <td align=center class="style24"><?php echo e($row[13]) ?></td>
      <td align=center class="style24"><?php echo e($row[14]) ?></td>
      <td align=center class="style24"><?php echo e($row[15]) ?></td>
      <td align=center class="style24"><?php echo e($row[15]) ?></td>
      <td align=center class="style24"><?php echo e($row[17]) ?></td>
    </tr>
<?php 
$nomor = num($nomor)+1;}} 

 ?>
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
