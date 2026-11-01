<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
//include __DIR__ . "/atas.php";
$q = in_val('q', 'get');
$search = in_val('search', 'get');
$status_payment = in_val('status_payment', 'get');

if ($status_payment==''){$status_payment="All";}
$status_pilihan = in_val('status_pilihan', 'get');
if ($status_pilihan==""){$status_pilihan = "Leaving";}
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$leaving_start = in_val('leaving_start', 'get');
$leaving_end = in_val('leaving_end', 'get');

$invoice_start = in_val('invoice_start', 'get');
$invoice_end = in_val('invoice_end', 'get');

$enroll_start = in_val('enroll_start', 'get');
$enroll_end = in_val('enroll_end', 'get');

$payment_start = in_val('payment_start', 'get');
$payment_end = in_val('payment_end', 'get');

if ($leaving_start ==''){$leaving_start = "2017-07-01";}
if ($leaving_end ==''){$leaving_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');


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
$pilihan_center = in_val('pilihan_center', 'get');

if ($pilihan_center=='All'){$datacabang ="";}
if ($pilihan_center=='East Sby'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '1' ");}
if ($pilihan_center=='West Sby'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '2' ");}
if ($pilihan_center=='Denpasar'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '3' ");}
if ($pilihan_center=='South Jkt'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '4' ");}
if ($pilihan_center=='North Jkt'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '5' ");}
if ($pilihan_center=='West Jkt'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '6' ");}
if ($pilihan_center=='Bandung'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '7' ");}
if ($pilihan_center=='Malang TBI'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '8' ");}
if ($pilihan_center=='Bali TBI'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '10' ");}
if ($pilihan_center=='Bandung TBI'){$datacabang = q_set($__p_datacabang, " and c.kd_branch = '9' ");}

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



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Excel Bootstrap Table Filter</title>
</head>

<body>
  <!-- Load jQuery -->
  <script src="../vcms/cdnjs/jquery.min.js"></script>
  <!-- Load the plugin bundle. -->
  <script src="../vcms/cdnjs/excel-bootstrap-table-filter-bundle.js"></script>
  <link rel="stylesheet" href="../vcms/cdnjs/bootstrap.min.css" />
  <link rel="stylesheet" href="../vcms/cdnjs/excel-bootstrap-table-filter-style.css" />
 <form method=get action=""> 
  <section class="alternate page-heading">
    <div class="container1">
      <header>
        <h1>Report</h1>
      </header>
      <p class="lead"></p>
      <table width="100%" class="table table-bordered table-striped" id="ww">
       <thead>
         <tr>
           <td width=8% height="14" align=right ><small>
           <label for="date14"> Leaving Period :</label>
           </small></td>
           <td width="22%" align=left ><small>
             <input type="date" format="dd/MM/yyyy" name="leaving_start" id="date5" value="<?php echo e($leaving_start) ; ?>" onChange="this.form.submit()">
             To
             <input type="date" name="leaving_end" id="date2" value="<?php echo e($leaving_end) ; ?>"  >
           </small></td>
           <td width="8%" height="14" align=right ><small>
             <label for="date16"> Invoice Period :</label>
           </small></td>
           <td width="30%" align=left ><small>
             <input type="date" format="dd/MM/yyyy" name="invoice_start" id="date7" value="<?php echo e($invoice_start) ; ?>">
             To
             <input type="date" name="invoice_end" id="date3" value="<?php echo e($invoice_end) ; ?>" >
           </small></td>
           <td width="9%" align=right ><small>
             <label for="date19"> Enroll Period :</label>
           </small></td>
           <td width="23%" align=left ><small>
             <input type="date" format="dd/MM/yyyy" name="enroll_start" id="date6" value="<?php echo e($enroll_start) ; ?>" >
             To </small><small>
  <input type="date" name="enroll_end" id="date" value="<?php echo e($enroll_end) ; ?>" >
</small></td>
          </tr>
         <tr>
           <td height="14" align=right ><small>
             <label for="date18"> Status :</label>
            </small></td>
           <td align=left ><small>
             <select name="status_pilihan"  onChange="this.form.submit()">
               <option>All</option>
               <option>Leaving</option>
               <option>Invoicing</option>
               <option>Paid</option>
               <option>Invoicing + Paid</option>
               <option selected><?php echo e($status_pilihan) ?></option>
              </select>
            </small></td>
           <td align=right ><small>
             <label for="date20"> Payment Period :</label>
            </small></td>
           <td align=left ><small>
             <input type="date" format="dd/MM/yyyy" name="payment_start" id="date8" value="<?php echo e($payment_start) ; ?>">
             To
             <input type="date" name="payment_end" id="date4" value="<?php echo e($payment_end) ; ?>" >
            </small></td>
           <td height="14" align=right ><small>Center</small></td>
           <td align=left ><small>
             <select name="pilihan_center"  >
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
           <td height="14" align=center >&nbsp;</td>
           <td align=left ><input type="button" value="Display	" onClick="this.form.submit()"></td>
           <td align=left >&nbsp;</td>
           <td align=left >&nbsp;</td>
           <td align=left >&nbsp;</td>
           <td align=left >&nbsp;</td>
         </tr>
       </thead>
       <tbody>
       <tfoot>
       </tfoot>
     </table>
   <hr>
<div class="container1">
  <div class="row">
    <div class="col-md-12">
      <h2>&nbsp;</h2>
      <table width="2668" class="table table-bordered table-intel" id="table">
        <thead>
          <tr>
            <th width="68" class="filter">No</th>
            <th width="68" class="filter">Student Name</th>
            <th width="68" class="filter">Enroll Date</th>
            <th width="68" class="filter">Comm Date</th>
            <th width="68" class="filter">Group School</th>
            <th width="68" class="filter">Country</th>
            <th width="68" class="filter">School</th>
            <th width="68" class="filter">Program</th>
            <th width="68" class="filter">P</th>
            <th width="68" class="filter">NP</th>
            <th width="68" class="filter">H</th>
            <th width="68" class="filter">AD</th>
            <th width="68" class="filter">STEM</th>
            <th width="68" class="filter">NON</th>
            <th width="68" class="filter">5</th>
            <th width="68" class="filter">4</th>
            <th width="68" class="filter">3</th>
            <th width="68" class="filter">2</th>
            <th width="68" class="filter">1</th>
            <th width="68" class="filter">Tuition</th>
            <th width="68" class="filter">Invoice Date</th>
            <th width="68" class="filter">Invoice Code</th>
            <th width="68" class="filter">Org Currency</th>
            <th width="68" class="filter">Org Amount</th>
            <th width="68" class="filter">Rupiah Rate</th>
            <th width="68" class="filter"> Amount Rp</th>
            <th width="68" class="filter">Payment  Date</th>
            <th width="68" class="filter">Cur Amount Pay</th>
            <th width="68" class="filter">Amount Pay</th>
            <th width="68" class="filter">Rp Rate Pay</th>
            <th width="68" class="filter">Amount Rp Pay</th>
            <th width="68" class="filter">Remark</th>
            <th width="68" class="filter">Main</th>
            <th width="68" class="filter">Language</th>
            <th width="68" class="filter">Additional</th>
            <th width="68" class="filter">Branch</th>
          </tr>
 <?php
	if ($enroll_start !="" and $enroll_end !="" )
		{$filter_enroll = q_set($__p_filter_enroll, " and c.enroll_date between ? and ? ", [(string) ($enroll_start), (string) ($enroll_end)]);}
	else
		{$filter_enroll="";}
	if ($invoice_start !="" and $invoice_end !="" )
		{$filter_invoice = q_set($__p_filter_invoice, " and a.dt_invoice between ? and ? ", [(string) ($invoice_start), (string) ($invoice_end)]);}
	else
		{$filter_invoice="";}		
	if ($payment_start !="" and $payment_end !="" )
		{$filter_payment = q_set($__p_filter_payment, " and b.dt_payment between ? and ? ", [(string) ($payment_start), (string) ($payment_end)]);}
	else
		{$filter_payment="";}					  
if($status_pilihan == "Leaving")
	{

	$query = q_set($__p_query, "SELECT c.nama, DATE_FORMAT(c.enroll_date,'%d %b %y'), DATE_FORMAT(c.comm_date,'%d %b %y'),\r
d.groupschool,mid(c.dest_country,1,3),\r
c.dest_school,c.dest_program,\r
case when c.p_np='P' then 1 end as P,case when c.p_np <>'P' then 1 end as NP,\r
case when c.h_nh ='H' then 1 end as H,case when c.h_nh = 'AD' then 1 end as AD,case when c.h_nh = 'STEM' then 1 end as STEM,case when c.h_nh = 'NON' then 1 end as NON,\r
case when mid(d.grade,1,3) = 'FIV' then 1 end as s5,\r
case when mid(d.grade,1,3) = 'FOU' then 1 end as s4,\r
case when mid(d.grade,1,3) = 'THR' then 1 end as s3,\r
case when mid(d.grade,1,3) = 'TWO' then 1 end as s2,\r
case when (mid(d.grade,1,3) = 'ONE' and mid(d.grade,1,3) <> 'TWO' and mid(d.grade,1,3) <> 'THR' and mid(d.grade,1,3) <> 'FOU' and mid(d.grade,1,3) <> 'FIV') then 1 end as s1,\r
c.tuition, DATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
a.kd_invoice, a.org_curr, a.org_mount, a.rate,\r
b.org_cur_pay, b.org_mount_pay, b.rate_pay,\r
b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'),\r
a.invoice_remark,b.remark,c.no,c.branch,\r
case when final_status='L' then 1 end as main,\r
case when final_status='Ll' then 1 end as language,\r
case when final_status like'La%' then 1 end as Addi FROM ves_data.adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and a.kd_invoice is null\r
\tand c.comm_date between ? and ? " . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . " \r
\tgroup by c.kd_biodata order by c.comm_date", [(string) ($leaving_start), (string) ($leaving_end), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);	
	}
elseif ($status_pilihan == "Invoicing")
	{
	$query = q_set($__p_query, "SELECT c.nama, DATE_FORMAT(c.enroll_date,'%d %b %y'), DATE_FORMAT(c.comm_date,'%d %b %y'),\r
d.groupschool,mid(c.dest_country,1,3),\r
c.dest_school,c.dest_program,\r
case when c.p_np='P' then 1 end as P,case when c.p_np <>'P' then 1 end as NP,\r
case when c.h_nh ='H' then 1 end as H,case when c.h_nh = 'AD' then 1 end as AD,case when c.h_nh = 'STEM' then 1 end as STEM,case when c.h_nh = 'NON' then 1 end as NON,\r
case when mid(d.grade,1,3) = 'FIV' then 1 end as s5,\r
case when mid(d.grade,1,3) = 'FOU' then 1 end as s4,\r
case when mid(d.grade,1,3) = 'THR' then 1 end as s3,\r
case when mid(d.grade,1,3) = 'TWO' then 1 end as s2,\r
case when (mid(d.grade,1,3) = 'ONE' and mid(d.grade,1,3) <> 'TWO' and mid(d.grade,1,3) <> 'THR' and mid(d.grade,1,3) <> 'FOU' and mid(d.grade,1,3) <> 'FIV') then 1 end as s1,\r
c.tuition, DATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
a.kd_invoice, a.org_curr, a.org_mount, a.rate,\r
b.org_cur_pay, b.org_mount_pay, b.rate_pay,\r
b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'),\r
a.invoice_remark,b.remark,c.no,c.branch,\r
case when final_status='L' then 1 end as main,\r
case when final_status='Ll' then 1 end as language,\r
case when final_status like'La%' then 1 end as Addi FROM ves_data.adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and a.kd_invoice is not null and b.mount_rp_pay is null \r
\tand c.comm_date between ? and ? " . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . "   \r
\tgroup by c.kd_biodata,a.kd_invoice order by c.comm_date", [(string) ($leaving_start), (string) ($leaving_end), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);	
	}
elseif ($status_pilihan == "Paid")
	{
	$query = q_set($__p_query, "select c.nama, DATE_FORMAT(c.enroll_date,'%d %b %y'), DATE_FORMAT(c.comm_date,'%d %b %y'),\r
d.groupschool,mid(c.dest_country,1,3),\r
c.dest_school,c.dest_program,\r
case when c.p_np='P' then 1 end as P,case when c.p_np <>'P' then 1 end as NP,\r
case when c.h_nh ='H' then 1 end as H,case when c.h_nh = 'AD' then 1 end as AD,case when c.h_nh = 'STEM' then 1 end as STEM,case when c.h_nh = 'NON' then 1 end as NON,\r
case when mid(d.grade,1,3) = 'FIV' then 1 end as s5,\r
case when mid(d.grade,1,3) = 'FOU' then 1 end as s4,\r
case when mid(d.grade,1,3) = 'THR' then 1 end as s3,\r
case when mid(d.grade,1,3) = 'TWO' then 1 end as s2,\r
case when (mid(d.grade,1,3) = 'ONE' and mid(d.grade,1,3) <> 'TWO' and mid(d.grade,1,3) <> 'THR' and mid(d.grade,1,3) <> 'FOU' and mid(d.grade,1,3) <> 'FIV') then 1 end as s1,\r
c.tuition, DATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
a.kd_invoice, a.org_curr, a.org_mount, a.rate,\r
b.org_cur_pay, b.org_mount_pay, b.rate_pay,\r
b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'),\r
a.invoice_remark,b.remark,c.no,c.branch,\r
case when final_status='L' then 1 end as main,\r
case when final_status='Ll' then 1 end as language,\r
case when final_status like'La%' then 1 end as Addi FROM ves_data.adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and a.kd_invoice is not null and b.mount_rp_pay is not null \r
\tand c.comm_date between ? and ? " . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . "   \r
\tgroup by c.kd_biodata order by c.comm_date", [(string) ($leaving_start), (string) ($leaving_end), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);	
	}
elseif ($status_pilihan == "Invoicing + Paid")
	{
	$query = q_set($__p_query, "select c.nama, DATE_FORMAT(c.enroll_date,'%d %b %y'), DATE_FORMAT(c.comm_date,'%d %b %y'),\r
d.groupschool,mid(c.dest_country,1,3),\r
c.dest_school,c.dest_program,\r
case when c.p_np='P' then 1 end as P,case when c.p_np <>'P' then 1 end as NP,\r
case when c.h_nh ='H' then 1 end as H,case when c.h_nh = 'AD' then 1 end as AD,case when c.h_nh = 'STEM' then 1 end as STEM,case when c.h_nh = 'NON' then 1 end as NON,\r
case when mid(d.grade,1,3) = 'FIV' then 1 end as s5,\r
case when mid(d.grade,1,3) = 'FOU' then 1 end as s4,\r
case when mid(d.grade,1,3) = 'THR' then 1 end as s3,\r
case when mid(d.grade,1,3) = 'TWO' then 1 end as s2,\r
case when (mid(d.grade,1,3) = 'ONE' and mid(d.grade,1,3) <> 'TWO' and mid(d.grade,1,3) <> 'THR' and mid(d.grade,1,3) <> 'FOU' and mid(d.grade,1,3) <> 'FIV') then 1 end as s1,\r
c.tuition, DATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
a.kd_invoice, a.org_curr, a.org_mount, a.rate,\r
b.org_cur_pay, b.org_mount_pay, b.rate_pay,\r
b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'),\r
a.invoice_remark,b.remark,c.no,c.branch,\r
case when final_status='L' then 1 end as main,\r
case when final_status='Ll' then 1 end as language,\r
case when final_status like'La%' then 1 end as Addi FROM ves_data.adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and a.kd_invoice is not null \r
\tand c.comm_date between ? and ? " . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . "  \r
\tgroup by c.kd_biodata order by c.comm_date", [(string) ($leaving_start), (string) ($leaving_end), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);	
	}				  
elseif ($status_pilihan == "All")
	{
	$query = q_set($__p_query, "select c.nama, DATE_FORMAT(c.enroll_date,'%d %b %y'), DATE_FORMAT(c.comm_date,'%d %b %y'),\r
d.groupschool,mid(c.dest_country,1,3),\r
c.dest_school,c.dest_program,\r
case when c.p_np='P' then 1 end as P,case when c.p_np <>'P' then 1 end as NP,\r
case when c.h_nh ='H' then 1 end as H,case when c.h_nh = 'AD' then 1 end as AD,case when c.h_nh = 'STEM' then 1 end as STEM,case when c.h_nh = 'NON' then 1 end as NON,\r
case when mid(d.grade,1,3) = 'FIV' then 1 end as s5,\r
case when mid(d.grade,1,3) = 'FOU' then 1 end as s4,\r
case when mid(d.grade,1,3) = 'THR' then 1 end as s3,\r
case when mid(d.grade,1,3) = 'TWO' then 1 end as s2,\r
case when (mid(d.grade,1,3) = 'ONE' and mid(d.grade,1,3) <> 'TWO' and mid(d.grade,1,3) <> 'THR' and mid(d.grade,1,3) <> 'FOU' and mid(d.grade,1,3) <> 'FIV') then 1 end as s1,\r
c.tuition, DATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
a.kd_invoice, a.org_curr, a.org_mount, a.rate,\r
b.org_cur_pay, b.org_mount_pay, b.rate_pay,\r
b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'),\r
a.invoice_remark,b.remark,c.no,c.branch,\r
case when final_status='L' then 1 end as main,\r
case when final_status='Ll' then 1 end as language,\r
case when final_status like'La%' then 1 end as Addi \r
\tFROM ves_data.adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' \r
\tand c.comm_date between ? and ? " . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . "  \r
\tgroup by c.kd_biodata order by c.comm_date", [(string) ($leaving_start), (string) ($leaving_end), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);
	}
$nomor = 1;
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{			
				  ?>          
        </thead>
        <tbody>
          <tr>
            <td><?php echo e($nomor) ?></td>
            <td><?php echo e($row[0]) ?></td>
            <td><?php echo e($row[1]) ?></td>
            <td><?php echo e($row[2]) ?></td>
            <td><?php echo e($row[3]) ?></td>
            <td><?php echo e($row[4]) ?></td>
            <td><?php echo e($row[5]) ?></td>
            <td><?php echo e($row[6]) ?></td>
            <td><?php echo e($row[7]) ?></td>
            <td><?php echo e($row[8]) ?></td>
            <td><?php echo e($row[9]) ?></td>
            <td><?php echo e($row[10]) ?></td>
            <td><?php echo e($row[11]) ?></td>
            <td><?php echo e($row[12]) ?></td>
            <td><?php echo e($row[13]) ?></td>
            <td><?php echo e($row[14]) ?></td>
            <td><?php echo e($row[15]) ?></td>
            <td><?php echo e($row[16]) ?></td>
            <td><?php echo e($row[17]) ?></td>
            <td><?php echo e($row[18]) ?></td>
            <td><?php echo e($row[19]) ?></td>
            <td><?php echo e($row[20]) ?></td>
            <td><?php echo e($row[21]) ?></td>
            <td><?php echo e(buatrp($row[22])) ?></td>
            <td><?php echo e(buatrp($row[23])) ?></td>
            <td><?php echo e(buatrp(num($row[22]) * num($row[23]))) ?></td>
            <td><?php echo e($row[28]) ?></td>
            <td><?php echo e($row[24]) ?></td>
            <td><?php echo e(buatrp($row[25])) ?></td>
            <td><?php echo e(buatrp($row[26])) ?></td>
            <td><?php echo e($row[27]) ?></td>
            <td><?php echo e($row[30]) ?></td>
            <td><?php echo e($row[33]) ?></td>
            <td><?php echo e($row[34]) ?></td>
            <td><?php echo e($row[35]) ?></td>
            <td><?php echo e($row[32]) ?></td>
          </tr>
          <?php $nomor = num($nomor)+1;}}?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</form>

  <script>
    // Use the plugin once the DOM has been loaded.
    $(function () {
      // Apply the plugin 
      $('#table').excelTableFilter();
      $('#table2').excelTableFilter();
      $('#table3').excelTableFilter();
    });
  </script>
</body>

</html>

