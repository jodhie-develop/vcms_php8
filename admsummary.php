<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";

$cy_start = "2017";
$cy_end = num($cy_start) + 1;

$py_start = num($cy_start) - 1;
$py_end = num($py_start) + 1;

$py_py_start = num($py_start) - 1;
$py_py_end = num($py_end) - 1;


$current_start = "$cy_start-07-01";
$current_end = "$cy_end-06-30";

$prev_start = "$py_start-07-01";
$prev_end = "$py_end-06-30";

$prev_prev_start = "$py_start-07-01";
$prev_prev_end = "$py_end-06-30";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";


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
if ($pilihan_center=='East Sby'){$datacabang =" and c.kd_branch = '1' ";}
if ($pilihan_center=='West Sby'){$datacabang =" and c.kd_branch = '2' ";}
if ($pilihan_center=='Denpasar'){$datacabang =" and c.kd_branch = '3' ";}
if ($pilihan_center=='South Jkt'){$datacabang =" and c.kd_branch = '4' ";}
if ($pilihan_center=='North Jkt'){$datacabang =" and c.kd_branch = '5' ";}
if ($pilihan_center=='West Jkt'){$datacabang =" and c.kd_branch = '6' ";}
if ($pilihan_center=='Bandung'){$datacabang =" and c.kd_branch = '7' ";}
if ($pilihan_center=='Malang TBI'){$datacabang =" and c.kd_branch = '8' ";}
if ($pilihan_center=='Bali TBI'){$datacabang =" and c.kd_branch = '10' ";}
if ($pilihan_center=='Bandung TBI'){$datacabang =" and c.kd_branch = '9' ";}

// previous ====
//=====total pdo===
$periode_mulai = $prev_start;
$periode_selesai = $prev_end;

//==A===	
$query = q_set($__p_query, "select kd_biodata from ves_data.adm_stu_progress where comm_date between ? and ? and final_status = 'L' group by kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$A = $keluar;

//==B===	
$query = q_set($__p_query, "select kd_biodata from ves_data.adm_stu_progress where comm_date between ? and ? and final_status = 'L' and enroll_date between ? and ? group by kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai), (string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$B = $keluar;

//==c===	
$query = q_set($__p_query, "select kd_biodata from ves_data.adm_stu_progress where comm_date between ? and ? and final_status = 'L' and enroll_date < ? group by kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai), (string) ($prev_prev_start)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$C = $keluar;

//==D===	
$query = q_set($__p_query, "select kd_biodata from ves_data.adm_stu_progress where comm_date between ? and ? and final_status = 'L' and p_np <> 'P' group by kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$D = $keluar;

//==F===	
$query = q_set($__p_query, "select kd_biodata from ves_data.adm_stu_progress where comm_date between ? and ? and final_status = 'L' and p_np = 'P' group by kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$F = $keluar;

//==G==	
$query = q_set($__p_query, "select kd_biodata from ves_data.adm_stu_progress where comm_date between ? and ? and final_status = 'L' and p_np = 'P' group by kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$G = $keluar;

//==H==	
$query = q_set($__p_query, "SELECT a.no_leaving FROM fin_invoice a left join adm_stu_progress b on a.no_leaving = b.no where b.comm_date between ? and ? group by a.kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$H = $keluar;

//==I==	
$query = q_set($__p_query, "SELECT a.no_leaving FROM fin_invoice a left join adm_stu_progress b on a.no_leaving = b.no where b.comm_date between ? and ? and dt_invoice between ? and ? group by a.kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai), (string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$I = $keluar;

//==J==	
$query = q_set($__p_query, "SELECT a.no_leaving FROM fin_invoice a left join adm_stu_progress b on a.no_leaving = b.no where b.comm_date between ? and ? and dt_invoice > ? group by a.kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$J = $keluar;

//==K==	
$query = q_set($__p_query, "SELECT b.no, b.kd_biodata,  b.nama, dest_school, b.comm_date FROM ves_data.adm_stu_progress b where b.comm_date between ? and ? and final_status = 'L' and b.no not in (select no_leaving from ves_data.fin_invoice) group by b.kd_biodata order by comm_date ", [(string) ($periode_mulai), (string) ($periode_selesai)]);

$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$K = $keluar;

//==L==	
$query = q_set($__p_query, "SELECT b.comm_date, a.no_leaving,dt_payment,c.mount_rp_pay FROM fin_invoice a left join adm_stu_progress b on a.no_leaving = b.no left join fin_comm c on a.no_leaving =  c.no_leaving where b.comm_date between ? and ? and dt_payment is not null group by a.kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$L = $keluar;

//==M==	
$query = q_set($__p_query, "SELECT b.comm_date, a.no_leaving,dt_payment,c.mount_rp_pay FROM fin_invoice a left join adm_stu_progress b on a.no_leaving = b.no left join fin_comm c on a.no_leaving =  c.no_leaving where b.comm_date between ? and ? and dt_payment between ? and ? group by a.kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai), (string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$M = $keluar;

//==N==	
$query = q_set($__p_query, "SELECT b.comm_date, a.no_leaving,dt_payment,c.mount_rp_pay FROM fin_invoice a left join adm_stu_progress b on a.no_leaving = b.no left join fin_comm c on a.no_leaving =  c.no_leaving where b.comm_date between ? and ? and dt_payment > ? group by a.kd_biodata ", [(string) ($periode_mulai), (string) ($periode_selesai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$N = $keluar;

//==O==	
$query = q_set($__p_query, "SELECT b.no, b.kd_biodata,  b.nama, dest_school, b.comm_date FROM adm_stu_progress b where b.comm_date between ? and ? and final_status = 'L' and b.no not in (select no_leaving from fin_invoice) group by b.kd_biodata order by comm_date ", [(string) ($periode_mulai), (string) ($periode_selesai)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);	
$O = $keluar;
$P = num((num($A) - num($H))) + num($O);
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
 <?php  //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=""> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Summary Commision Report<br>
     </h1>
     <div class="col-md-8">
  <table width="25%" class="table table-bordered table-striped" id="ww">
       <thead>
         <tr>
           <td width=15% height="14" align=right ><small>
             <label for="date14">  Period :</label>
            </small></td>
           <td width="85%" align=left ><small>
             <input type="date" format="dd/MM/yyyy" name="leaving_start" id="date5" value="<?php echo e($leaving_start) ; ?>" onChange="this.form.submit()">
             To
             <input type="date" name="leaving_end" id="date2" value="<?php echo e($leaving_end) ; ?>"  >
            </small></td>
         </tr>
         <tr>
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
        <div class="col-xs-10">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example1">

                <thead>
                <tr>
                  <td height="14" align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                  <td colspan="2" align=center ><strong>
                    <input type="text" name="prev_txt_start" id="textfield" value="<?php echo e($prev_start)?>">
                  Previous Year 
                  <input type="text" name="prev_txt_end" id="textfield2"  value="<?php echo e($prev_end)?>">
                  </strong></td>
                  <td colspan="2" align=center ><strong>
                    <input type="text" name="curr_txt_start" id="textfield3"  value="<?php echo e($current_start) ?>">
                  Current Year </a>
                  <input type="text" name="curr_txt_end" id="textfield4" value="<?php echo e($current_end) ?>">
                  </strong></td>
                  </tr>
                <tr>
      <td width=2% height="14" align=center >&nbsp;</td>
      <td width="20%" align=center >&nbsp;</td>
      <td width="24%" align=center ><strong>Previous Week</strong></td>
      <td width="19%" align=center ><strong>This Week</a></strong></td>
      <td width="17%" align=center ><strong>Previous Week</strong></td>
      <td width="18%" align=center ><strong>This Week</a></strong></td>
                </tr>
                <tr>
                  <td height="14" align=center >A</td>
                  <td align=center >Total PDO</td>
                  <td align=center ><a href="admsummarydtl.php?ft=A&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=A&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=1000'); return false;"><?php echo e($A) ?></a></td>
                  <td align=center ><?php echo e($AA) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >B</td>
                  <td align=center >Total PDO from Current Year Sales</td>
                  <td align=center ><a href="admsummarydtl.php?ft=B&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=B&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($B) ?></a></td>
                  <td align=center ><?php echo e($BB) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >C</td>
                  <td align=center >Total PDO from Prev Year -1</td>
                  <td align=center ><a href="admsummarydtl.php?ft=C&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=C&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($C) ?></a></td>
                  <td align=center ><?php echo e($CC) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >D</td>
                  <td align=center >Non Partner</td>
                  <td align=center ><a href="admsummarydtl.php?ft=D&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=D&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($D) ?></a></td>
                  <td align=center ><?php echo e($DD) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >E</td>
                  <td align=center >Non Partner Refer</td>
                  <td align=center ><a href="admsummarydtl.php?ft=E&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=E&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($E) ?></a></td>
                  <td align=center ><?php echo e($EE) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >F</td>
                  <td align=center >Partner</td>
                  <td align=center ><a href="admsummarydtl.php?ft=F&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=F&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($F) ?></a></td>
                  <td align=center ><?php echo e($FF) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >G</td>
                  <td align=center >Total Invoicable</td>
                  <td align=center ><a href="admsummarydtl.php?ft=G&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=G&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($G) ?></a></td>
                  <td align=center ><?php echo e($GG) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >H</td>
                  <td align=center >Invoiced TOTAL</td>
                  <td align=center ><a href="admsummarydtl.php?ft=H&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=H&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($H) ?></a></td>
                  <td align=center ><?php echo e($HH) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >I</td>
                  <td align=center >Invoiced in Current Year</td>
                  <td align=center ><a href="admsummarydtl.php?ft=I&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=I&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($I) ?></a></td>
                  <td align=center ><?php echo e($II) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >J</td>
                  <td align=center >Invoiced in Curr Yr +1</td>
                  <td align=center ><a href="admsummarydtl.php?ft=J&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=J&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($J) ?></a></td>
                  <td align=center ><?php echo e($JJ) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >K</td>
                  <td align=center >Pending Invoice</td>
                  <td align=center ><a href="admsummarydtl.php?ft=K&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=K&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($K) ?></A></td>
                  <td align=center ><?php echo e($KK) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >L</td>
                  <td align=center >PAID TOTAL</td>
                  <td align=center ><a href="admsummarydtl.php?ft=L&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=L&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($L) ?></a></td>
                  <td align=center ><?php echo e($LL) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >M</td>
                  <td align=center >PAID in Current Year</td>
                  <td align=center ><a href="admsummarydtl.php?ft=M&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=M&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($M) ?></a></td>
                  <td align=center ><?php echo e($MM) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >N</td>
                  <td align=center >PAID in Cur Yr +1</td>
                  <td align=center ><a href="admsummarydtl.php?ft=N&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=N&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($N) ?></a></td>
                  <td align=center ><?php echo e($NN) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >O</td>
                  <td align=center >NOT YET PAID (Based-on Invoiced)</td>
                  <td align=center ><a href="admsummarydtl.php?ft=O&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=O&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($O) ?></a></td>
                  <td align=center ><?php echo e($OO) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >P</td>
                  <td align=center >Total Expected Income (by Pax)</td>
                  <td align=center ><a href="admsummarydtl.php?ft=P&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>" 
target="popup" 
onclick="window.open('admsummarydtl.php?ft=P&st=<?php echo e(u($prev_start)) ?>&end=<?php echo e(u($prev_end)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($P) ?></a></td>
                  <td align=center ><?php echo e($PP) ?></td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                <tr>
                  <td height="14" align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                  <td align=center >&nbsp;</td>
                </tr>
                </thead>
                <tbody>

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
