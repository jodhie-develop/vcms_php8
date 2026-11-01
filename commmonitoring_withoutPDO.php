<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
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

//if ($leaving_start ==''){$leaving_start = "2017-07-01";}
//if ($leaving_end ==''){$leaving_end = $hari_ini;}

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
 <form method=get action=""> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Commision Monitoring<br>
     </h1>
     <div class="col-md-12">
  <table width="25%" class="table table-bordered table-striped" id="ww">
       <thead>
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
               <option>Commision on Follow</option>               
               <option selected><?php echo e($status_pilihan) ?></option>
             </select>
           </small></td>
           <td width="8%" height="14" align=right ><small>
             <label for="date16"> Invoice Period :</label>
           </small></td>
           <td width="25%" align=left ><small>
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
             <label for="date14"> Leaving Period :</label>
            </small></td>
           <td align=left ><small>
             <input type="date" format="dd/MM/yyyy" name="leaving_start" id="date5" value="<?php echo e($leaving_start) ; ?>">
             To
             <input type="date" name="leaving_end" id="date2" value="<?php echo e($leaving_end) ; ?>"  >
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
           <td align=left > <a href="invoicelist.php?st=<?php echo e(u($leaving_start)) ?>&end=<?php echo e(u($leaving_end)) ?>"><input type="button" value="Invoice List"></a>
             <a href="paymentlist.php?st=<?php echo e(u($leaving_start)) ?>&end=<?php echo e(u($leaving_end)) ?>">
              <input type="button" value="Payment List">
              </a><a href="inv_leaving.php?nl=<?php echo e(u($row[20])); ?>" target='_blank'></a>
            <a href="komisireportacc.php" target='_blank'> <input type="button" value="Report"></a></td>
           <td align=left >&nbsp;</td>
           <td align=left >&nbsp;</td>
         </tr>
       </thead>
       <tbody>
       <tfoot>
       </tfoot>
     </table>	   	
	   </div>
   </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example1">
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
				  
	if ($leaving_start !="" and $leaving_end !="" )
		{$filter_leaving = q_set($__p_filter_leaving, "and c.comm_date between ? and ? ", [(string) ($leaving_start), (string) ($leaving_end)]);}
	else
		{$filter_leaving="";}	
if 	($filter_leaving !="" or $filter_enroll !="" or $filter_invoice !="" or $filter_payment !="")
{
if($status_pilihan == "Leaving")
	{

	$query = q_set($__p_query, "SELECT\r
\tc.nama, DATE_FORMAT(c.comm_date,'%d %b %y'),DATE_FORMAT(c.enroll_date,'%d %b %y'),mid(c.dest_country,1,3), c.dest_school, d.groupschool,c.dest_program,c.tuition,\r
\tDATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
\ta.kd_invoice,\r
\ta.org_curr, a.org_mount, a.rate,\r
\tb.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'),a.invoice_remark,b.remark,c.no,c.branch,  case\r
when mid(d.grade,1,3) = 'ONE' then 1\r
when mid(d.grade,1,3) = 'TWO' then 2\r
when mid(d.grade,1,3) = 'THR' then 3\r
when mid(d.grade,1,3) = 'FOU' then 4\r
when mid(d.grade,1,3) = 'FIV' then 5\r
else 1\r
end as grade ,case when final_status='L' then 'Main'when final_status='Ll' then 'Language' when final_status like'La%' then 'Add' end as Statusprogram   , d.groupschool,b.bank_cash,a.mount_rp\r
\tFROM ves_data.adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' and a.kd_invoice is null " . $filter_leaving . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . " \r
\tgroup by c.kd_biodata,c.dest_school,c. dest_program order by c.comm_date", [...($__p_filter_leaving ?? []), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);	
	}
elseif ($status_pilihan == "Invoicing")
	{
	$query = q_set($__p_query, "SELECT c.nama, DATE_FORMAT(c.comm_date,'%d %b %y'),DATE_FORMAT(c.enroll_date,'%d %b %y'),mid(c.dest_country,1,3), c.dest_school, d.groupschool,c.dest_program,c.tuition, DATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
\ta.kd_invoice, a.org_curr, a.org_mount, a.rate, b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay,\r
\tDATE_FORMAT(b.dt_payment,'%d %b %y'),a.invoice_remark,b.remark,c.no,c.branch,\r
\tcase when mid(d.grade,1,3) = 'ONE' then 1 when mid(d.grade,1,3) = 'TWO' then 2 when mid(d.grade,1,3) = 'THR' then 3\r
\twhen mid(d.grade,1,3) = 'FOU' then 4 when mid(d.grade,1,3) = 'FIV' then 5 else 1 end as grade ,\r
\tcase when final_status='L' then 'Main'when final_status='Ll' then 'Language' when final_status like'La%' then 'Add' end as Statusprogram ,\r
\td.groupschool,b.bank_cash,a.mount_rp FROM fin_invoice a\r
\tleft join adm_stu_progress c on a.no_leaving = c.no\r
\tleft join tb_master_partner d on a.school = d.school and a.country = d.country\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere  dt_payment is null\r
\t" . $filter_leaving . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . "   \r
\tgroup by a.kd_invoice,c.no order by a.no desc", [...($__p_filter_leaving ?? []), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);	
	}
elseif ($status_pilihan == "Paid")
	{
	$query = q_set($__p_query, "SELECT c.nama, DATE_FORMAT(c.comm_date,'%d %b %y'),DATE_FORMAT(c.enroll_date,'%d %b %y'),mid(c.dest_country,1,3), c.dest_school, d.groupschool,c.dest_program,c.tuition, DATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
a.kd_invoice, a.org_curr, a.org_mount, a.rate, b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay,\r
DATE_FORMAT(b.dt_payment,'%d %b %y'),a.invoice_remark,b.remark,c.no,c.branch,\r
case when mid(d.grade,1,3) = 'ONE' then 1 when mid(d.grade,1,3) = 'TWO' then 2 when mid(d.grade,1,3) = 'THR' then 3\r
when mid(d.grade,1,3) = 'FOU' then 4 when mid(d.grade,1,3) = 'FIV' then 5 else 1 end as grade ,\r
case when final_status='L' then 'Main'when final_status='Ll' then 'Language' when final_status like'La%' then 'Add' end as Statusprogram ,\r
d.groupschool,b.bank_cash,a.mount_rp FROM fin_invoice a\r
left join adm_stu_progress c on a.no_leaving = c.no\r
left join tb_master_partner d on a.school = d.school and a.country = d.country\r
left join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
where  dt_payment is not null\r
\t" . $filter_leaving . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . "   \r
\tgroup by a.kd_invoice,c.no order by a.no desc", [...($__p_filter_leaving ?? []), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);		
	}
elseif ($status_pilihan == "Invoicing + Paid")
	{
	$query = q_set($__p_query, "SELECT c.nama, DATE_FORMAT(c.comm_date,'%d %b %y'),DATE_FORMAT(c.enroll_date,'%d %b %y'),mid(c.dest_country,1,3), c.dest_school, d.groupschool,c.dest_program,c.tuition, DATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
\ta.kd_invoice, a.org_curr, a.org_mount, a.rate, b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay,\r
\tDATE_FORMAT(b.dt_payment,'%d %b %y'),a.invoice_remark,b.remark,c.no,c.branch,\r
\tcase when mid(d.grade,1,3) = 'ONE' then 1 when mid(d.grade,1,3) = 'TWO' then 2 when mid(d.grade,1,3) = 'THR' then 3\r
\twhen mid(d.grade,1,3) = 'FOU' then 4 when mid(d.grade,1,3) = 'FIV' then 5 else 1 end as grade ,\r
\tcase when final_status='L' then 'Main'when final_status='Ll' then 'Language' when final_status like'La%' then 'Add' end as Statusprogram ,\r
\td.groupschool,b.bank_cash,a.mount_rp FROM fin_invoice a\r
\tleft join adm_stu_progress c on a.no_leaving = c.no\r
\tleft join tb_master_partner d on a.school = d.school and a.country = d.country\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere  a.kd_invoice is not null\r
\t" . $filter_leaving . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . "   \r
\tgroup by a.kd_invoice,c.no order by a.no desc", [...($__p_filter_leaving ?? []), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);	
	}				  
elseif ($status_pilihan == "All")
	{
	$query = q_set($__p_query, "SELECT\r
\tc.nama, DATE_FORMAT(c.comm_date,'%d %b %y'),DATE_FORMAT(c.enroll_date,'%d %b %y'),mid(c.dest_country,1,3), c.dest_school, d.groupschool,c.dest_program,c.tuition,\r
\tDATE_FORMAT(a.dt_invoice,'%d %b %y'),\r
\ta.kd_invoice,\r
\ta.org_curr, a.org_mount, a.rate,\r
\tb.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay, DATE_FORMAT(b.dt_payment,'%d %b %y'),a.invoice_remark,b.remark,c.no,c.branch,  case\r
\twhen mid(d.grade,1,3) = 'ONE' then 1\r
\twhen mid(d.grade,1,3) = 'TWO' then 2\r
\twhen mid(d.grade,1,3) = 'THR' then 3\r
\twhen mid(d.grade,1,3) = 'FOU' then 4\r
\twhen mid(d.grade,1,3) = 'FIV' then 5\r
\telse 1\r
\tend as grade ,case when final_status='L' then 'Main' when final_status='Ll' then 'Language' when final_status like'La%' then 'Add' end as Statusprogram   , d.groupschool,b.bank_cash,a.mount_rp\r
\tFROM ves_data.adm_stu_progress c\r
\tleft join tb_master_partner d on c.kd_school = d.kd_school\r
\tleft join fin_invoice a on c.no = a.no_leaving\r
\tleft join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice\r
\twhere c.final_status like '%L%' \r
\t" . $filter_leaving . $filter_enroll . $filter_invoice . $filter_payment . $datacabang . "  \r
\tgroup by c.kd_biodata, c.dest_school, c.dest_program,a.kd_invoice order by c.comm_date", [...($__p_filter_leaving ?? []), ...($__p_filter_enroll ?? []), ...($__p_filter_invoice ?? []), ...($__p_filter_payment ?? []), ...($__p_datacabang ?? [])]);
	}	
$nomor = 1;
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
				$ttl_invoiced = 0;
				$ttl_bankcharge = 0;
				$ttl_paid = 0;
				  ?>
                <thead>
                <tr>
      <td width=2% rowspan="2" align=center >No</td>
      <td width="5%" rowspan="2" align=center >Comm<br>
        Date</td>
      <td width="4%" rowspan="2" align=center >Enroll Date</td>
      <td width="8%" rowspan="2" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=student">Student Name</a></td>
      <td width="4%" rowspan="2" align=center >Center</td>
      <td height="14" colspan="7" align=center >Destination</td>
      <td height=14 colspan="5" align=center >Invoice</td>
      <td colspan="4" align=center >Payment</td>
      </tr>
    <tr>
      <td width="4%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=country">Group</a></td>
      <td width="6%" height=14 align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=country">Country</a></td>
      <td width="4%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=school">School</a></td>
      <td width="5%" height=14 align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=program">Program</a></td>
      <td width="4%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=tuition">Tuition</a></td>
      <td width="4%" align=center >Grade</td>
      <td width="4%" align=center >Status Leaving</td>
      <td width="3%" align=center >Date</td>
      <td width="4%" height=14 align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=invoice">No Invoice</a></td>
      <td width="5%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Amount</a> <br></td>
      <td width="3%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Rate</a> <br></td>
      <td align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">IDR Amount</a> <br></td>
      <td width="5%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=datepay">Date</a></td>
      <td width="6%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Amount</a> <br></td>
      <td width="7%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Rate</a> <br></td>
      <td align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">IDR Amount</a> <br></td>
      </tr>
                </thead>
                <tbody>
<?php
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
			$invoice_rp = num($row[11]) * num($row[12]);
		$payment_rp = $row[16];
		$bank_charge= $row[25];
		$query_file = q_set($__p_query_file, "SELECT nm_file, COALESCE(NULLIF(nama_asli, ''), nm_file) FROM ves_data.fnc_data where kode_file = ? ", [(string) ($row[9])]);
		$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
		if(num(db_num_rows($resource_file)) > 0)
			{
			while ($row_file  =  db_fetch($resource_file, PDO::FETCH_NUM))
				{
				$nm_file_invoice = $row_file[0];
				$nm_file_tampil = $row_file[1];   // nama asli untuk teks link
				}
			}
		if ($nm_file_invoice !=''){$adafile = 1;}			
		if ($nm_file_invoice =='' and $row[9] != ''){$nm_file_invoice = 'File';$adafile = 0;}
		if ($nm_file_invoice =='' and $row[9] == ''){$nm_file_invoice = '';$adafile = 0;}
			
?>	
    <tr>
      <td align=center class="style24"><?php echo e($nomor) ?></td>
      <td align=center class="style24"><?php echo e($row[1]) ?><br></td>
      <td align=center class="style24"><?php echo e($row[2]) ?></td>
		<td align=center class="style24">
		  <?php 
		if ($status_pilihan=="Leaving")
		{
		?>
		  <a href="inv_leaving.php?nl=<?php echo e(u($row[20])); ?>" 
target="popup" 
onclick="window.open('inv_leaving.php?nl=<?php echo e(u($row[20])); ?>','popup','width=1000,height=800'); return false;"> <?php } elseif ($status_pilihan == "Invoicing")
		{?>
		    <a href="pay_leaving.php?nl=<?php echo e(u($row[20])); ?>&kdin=<?php echo e(u($row[9])) ?>" 
target="popup" 
onclick="window.open('pay_leaving.php?nl=<?php echo e(u($row[20])); ?>&kdin=<?php echo e(u($row[9])) ?>','popup','width=1000,height=800'); return false;">
		    <?php } ?>
		    <?php echo e($row[0]) ?><br>
		  </a>
		  <?php if ($status_pilihan == "Invoicing" or $status_pilihan == "Invoicing + Paid" or $status_pilihan == "Paid" )  
			{?> 
			 <a href="inv_leaving.php?nl=<?php echo e(u($row[20])); ?>" 
target="popup" 
onclick="window.open('inv_leaving.php?nl=<?php echo e(u($row[20])); ?>','popup','width=1000,height=800'); return false;">[ Next Invoice ]</a> 
			<?php } ?>
		  </td>
		<td align=left class="style24"><?php echo e($row[21]) ?></td>
		<td align=left class="style24"><?php echo e($row[5]) ?></td>
		<td height=14 align=left class="style24"><?php echo e($row[3]) ?></td>
		<td align=left class="style24"><?php echo e($row[4]) ?><br></td>
		<td height=14 align=left class="style24"><?php echo e($row[6]) ?></td>
		<td align=center class="style24"><?php echo e($row[7]) ?></td>
		<td align=center class="style24"><?php echo e($row[22]) ?></td>
		<td align=center class="style24"><?php echo e($row[23]) ?></td>
      <td align=center class="style24"><?php echo e($row[8]) ?></td>
      <td height=14 align=center class="style24"><?php echo e($row[9]) ?><br>
        <?php echo e($row[18]) ?> <br>
       <?php 
		  if(num($adafile) == 0)
		  {
		  ?>  
         <a href="fnc_updoc.php?noi=<?php echo e(u($row[9])); ?>" 
target="popup" 
onclick="window.open('fnc_updoc.php?noi=<?php echo e(u($row[9])); ?>','popup','width=1000,height=800'); return false;">
      <?php  }
       else
       {
       ?>
       <a href="<?php echo e($nm_file_invoice); ?>" 
target="popup" 
onclick="window.open('<?php echo e($nm_file_invoice); ?>','popup','width=1000,height=800'); return false;">
      <?php } ?>
       <?php echo e($adafile == 1 ? $nm_file_tampil : $nm_file_invoice) ?></a><br>        
        <br></td>
      <td align=center class="style24"><?php echo e($row[10]) ?> <?php echo e(buatrp($row[11])) ?><br></td>
      <td align=center class="style24"><?php echo e(buatrp($row[12])) ?></td>
      <td align=center class="style24"><?php echo e(buatrp($invoice_rp)) ?></td>
      <td align=center class="style24"><?php echo e($row[17]) ?></td>
      <td align=center class="style24"><?php echo e($row[13]) ?> <?php echo e(buatrp($row[14])) ?><br></td>
      <td align=center class="style24"><?php echo e(buatrp($row[15])) ?></td>
      <td align=center class="style24"><?php echo e(buatrp($payment_rp)) ?></td>
      </tr>
<?php 
$nomor = num($nomor)+1;	$nm_file_invoice='';	$ttl_invoiced = num($ttl_invoiced) + num($invoice_rp);		$ttl_paid = num($ttl_paid) + num($payment_rp); $ttl_bankcharge=num($ttl_bankcharge)+num($bank_charge);

}} }
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
   <section class="content">
      <div class="row">
		<div class="col-md-12">   
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="25%" class="table table-bordered table-striped" id="tt">
                <tbody>
                  <tr>
                    <td width="10%">Summary</td>
                    <td width="10%">&nbsp;</td>
                    <td width="6%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                    <td width="13%">&nbsp;</td>
                    <td width="56%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Total Leaving </td>
                    <td>Total Invoiced</td>
                    <td>Total Paid</td>
                    <td>Different</td>
                    <td>Total Bank Charge</td>
                    <td>Different Netto</td>
                  </tr>
                  <tr>
                    <td><?php echo e($keluar) ?></td>
                    <td><?php echo e(buatrp($ttl_invoiced)) ?></td>
                    <td><?php echo e(buatrp($ttl_paid)) ?></td>
                    <td><?php echo e(buatrp(num($ttl_invoiced) - num($ttl_paid))) ?></td>
                    <td><?php echo e(buatrp($ttl_bankcharge)) ?></td>
                    <td><?php echo e(buatrp(num($ttl_invoiced) - num($ttl_paid) - num($ttl_bankcharge))) ?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
              </table>
            </div>
			   </div>
		  </div>
     </div>

     <!-- /.row -->
   </section>
   
    <!-- /.content -->
  </form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  
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
