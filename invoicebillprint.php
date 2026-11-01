<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');
$id = in_val('id', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$query_ambil_billing = q_set($__p_query_ambil_billing, "SELECT t.id_invoice, t.kd_biodata, t.nama_lengkap, t.keterangan, t.nominal, t.pay_mtd, t.dt_entry,t.pic FROM ves_data.tb_invoice t where t.id = ? ", [(string) ($id)]);

$resource_ambil_billing = db_query_or_die('errro_1', $query_ambil_billing, $__p_query_ambil_billing ?? []);
while ($row_billing=  db_fetch($resource_ambil_billing, PDO::FETCH_NUM))
		{
		$id_invoice = $row_billing['0'];
		$kd_biodata = $row_billing['1'];
		$nama = $row_billing['2'];
		$keterangan = $row_billing['3'];
		$nominal = $row_billing['4'];
		$pay_mtd = $row_billing['5'];
		$tgl_entry = $row_billing['6'];
		$pic = $row_billing['7'];
}
function terbilang($n) {
  if (num($n) < 0) return 'minus ' . terbilang(-num($n));
  else if (num($n) < 10) {
    switch ($n) {
      case 0: return 'zero';
      case 1: return 'one';
      case 2: return 'two';
      case 3: return 'three';
      case 4: return 'four';
      case 5: return 'five';
      case 6: return 'six';
      case 7: return 'seven';
      case 8: return 'eight';
      case 9: return 'nine';
    }
  }
  else if (num($n) < 100) {
    $kepala = floor(num($n)/10);
    $sisa = num($n) % 10;
    if (num($kepala) == 1) {
      if (num($sisa) == 0) return 'ten';
      else if (num($sisa) == 1) return 'eleven';
      else if (num($sisa) == 2) return 'twelve';
      else if (num($sisa) == 3) return 'thirteen';
      else if (num($sisa) == 5) return 'fifteen';
      else if (num($sisa) == 8) return 'eighteen';
      else return terbilang($sisa) . 'teen';
    }
    else if (num($kepala) == 2) $hasil = 'twenty';
    else if (num($kepala) == 3) $hasil = 'thirty';
    else if (num($kepala) == 5) $hasil = 'fifty';
    else if (num($kepala) == 8) $hasil = 'eighty';
    else $hasil = terbilang($kepala) . 'ty';
  }
  else if (num($n) < 1000) {
    $kepala = floor(num($n)/100);
    $sisa = num($n) % 100;
    $hasil = terbilang($kepala) . ' hundred';
  }
  else if (num($n) < 1000000) {
    $kepala = floor(num($n)/1000);
    $sisa = num($n) % 1000;
    $hasil = terbilang($kepala) . ' thousand';
  }
  else if (num($n) < 1000000000) {
    $kepala = floor(num($n)/1000000);
    $sisa = num($n) % 1000000;
    $hasil = terbilang($kepala) . ' million';
  }
  else return false;

  if (num($sisa) > 0) $hasil .= ' ' . terbilang($sisa);
  return $hasil;
}

$terbilang =  terbilang($nominal);

		
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }</style>    
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<body class="A5.landscape">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php   //   include __DIR__ . "/left.php";	 ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

   <!-- Main content -->
<section class="content">

  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
 <div class="col-md-12">
   <table width="100%" class="table" id="example" border="0">
        <tbody>
          <tr>
            <td width="16%" height="14" align=Left class="style24"><img src="imgs/ves.jpg" width="99" height="60" alt=""/><br></td>
		    <td height="14" colspan="5" align=center class="style24"><h2>Invoice</h2>
		      <h5><small><strong><?php echo e($id_invoice) ?></strong></small></h5></td>
            <td width="12%" height="14" align=Left class="style24">&nbsp;</td>
          </tr>
          <tr>
            <td align=Left class="style24"><small>
              <label>Student Name </label>
            </small></td>
            <td colspan="2" align=left class="style24"><small><?php echo e($nama) ?></small></td>
            <td height="14" colspan="4" align=left class="style24"><small>
              <label>ID</label>
              <?php echo e($kd_biodata) ?></small><br></td>
          </tr>
          <tr>
            <td align=left class="style24"><span class="form-group"><small>
              <label>Payment For</label>
            </small></span></td>
            <td colspan="2" align=left class="style24"><small><?php echo e($keterangan) ?></small></td>
            <td height="14" colspan="3" align=left class="style24">&nbsp;</td>
            <td></td>
          </tr>
          <tr>
            <td align=left class="style24"><small><strong>Amount</strong></small></td>
            <td colspan="2" align=left class="style24"><small>Rp. <?php echo number_format(num($nominal),0,".",".")  ?></small></td>
            <td height="14" colspan="3" align=left class="style24">&nbsp;</td>
            <td></td>
          </tr>
          <tr>
            <td align=left class="style24"><span class="form-group"> <small>
              <label>In Words :</label></small> </span></td>
            <td colspan="2" align=left class="style24"><small><?php echo e($terbilang) ?> Rupiah</small></td>
            <td height="14" colspan="3" align=left class="style24"><br></td>
            <td></td>
          </tr>
          <tr>
            <td height="14" colspan="7" align=center class="style24"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td align="center"><label> Receipt By</label></td>
                  <td>&nbsp;</td>
                  <td align="center"><small>
                  <label> Student</label>
                  <br>
                  <br>
                  </small></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"> <small><?php echo e($nama_lengkap) ?></small></td>
                  <td>&nbsp;</td>
                  <td align="center"><small><?php echo e($nama) ?></small></td>
                </tr>
              </tbody>
            </table></td>
            <td width="3%"></td>
          </tr>
          <tr>
            <td align=left class="style24"><small>
            
              <br>
              <br>
            </small></td>
            <td width="52%" align=left class="style24">&nbsp;</td>
            <td width="9%" align=left class="style24">&nbsp;</td>
            <td align=left class="style24"></td>
            <td height="14" colspan="2" align=left class="style24">&nbsp;</td>
            <td></td>
          </tr>
        <tfoot>
        </tfoot>
      </table>
   <table width="100%" class="table" id="example2" border="0">
     <tbody>
       <tr>
         <td width="12%" height="14" align=Left class="style24"><img src="imgs/ves.jpg" width="99" height="60" alt=""/><br></td>
         <td height="14" colspan="5" align=center class="style24"><h2>Invoice</h2>
           <h5><small><strong><?php echo e($id_invoice) ?></strong></small></h5></td>
         <td width="12%" height="14" align=Left class="style24">&nbsp;</td>
       </tr>
       <tr>
         <td align=Left class="style24"><small>
           <label>Student Name </label>
         </small></td>
         <td colspan="2" align=left class="style24"><small><?php echo e($nama) ?></small></td>
         <td height="14" colspan="4" align=left class="style24"><small>
           <label>ID</label>
           <?php echo e($kd_biodata) ?></small><br></td>
       </tr>
       <tr>
         <td align=left class="style24"><span class="form-group"><small>
           <label>Payment For</label>
         </small></span></td>
         <td colspan="2" align=left class="style24"><small><?php echo e($keterangan) ?></small></td>
         <td height="14" colspan="3" align=left class="style24">&nbsp;</td>
         <td></td>
       </tr>
       <tr>
         <td align=left class="style24"><small><strong>Amount</strong></small></td>
         <td colspan="2" align=left class="style24"><small>Rp. <?php echo number_format(num($nominal),0,".",".")  ?></small></td>
         <td height="14" colspan="3" align=left class="style24">&nbsp;</td>
         <td></td>
       </tr>
       <tr>
         <td align=left class="style24"><span class="form-group"> <small>
           <label>In Words :</label>
         </small></span></td>
         <td colspan="2" align=left class="style24"><small><?php echo e($terbilang) ?> Rupiah</small></td>
         <td height="14" colspan="3" align=left class="style24"><br></td>
         <td></td>
       </tr>
       <tr>
         <td colspan="7" align="center">         
         
         <td width="3%" height="14"></td>
       </tr>
       <tr>
         <td height="14" colspan="7" align=center class="style24"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tbody>
             <tr>
               <td align="center"><label> Receipt By</label></td>
               <td>&nbsp;</td>
               <td align="center"><small>
                 <label> Student</label>
                 <br>
                 <br>
               </small></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td align="center"><small><?php echo e($nama_lengkap) ?></small></td>
               <td>&nbsp;</td>
               <td align="center"><small><?php echo e($nama) ?></small></td>
             </tr>
           </tbody>
         </table></td>
         <td></td>
       </tr>
       <tr>
         <td align=left class="style24"><small> <br>
           <br>
         </small></td>
         <td width="56%" align=left class="style24">&nbsp;</td>
         <td width="9%" align=left class="style24">&nbsp;</td>
         <td align=left class="style24"></td>
         <td height="14" colspan="2" align=left class="style24">&nbsp;</td>
         <td></td>
       </tr>
     <tfoot>
     </tfoot>
   </table>
   <table width="100%" class="table" id="example3" border="0">
     <tbody>
       <tr>
         <td width="12%" height="14" align=Left class="style24"><img src="imgs/ves.jpg" width="99" height="60" alt=""/><br></td>
         <td height="14" colspan="5" align=center class="style24"><h2>Invoice</h2>
           <h5><small><strong><?php echo e($id_invoice) ?></strong></small></h5></td>
         <td width="12%" height="14" align=Left class="style24">&nbsp;</td>
       </tr>
       <tr>
         <td align=Left class="style24"><small>
           <label>Student Name </label>
         </small></td>
         <td colspan="2" align=left class="style24"><small><?php echo e($nama) ?></small></td>
         <td height="14" colspan="4" align=left class="style24"><small>
           <label>ID</label>
           <?php echo e($kd_biodata) ?></small><br></td>
       </tr>
       <tr>
         <td align=left class="style24"><span class="form-group"><small>
           <label>Payment For</label>
         </small></span></td>
         <td colspan="2" align=left class="style24"><small><?php echo e($keterangan) ?></small></td>
         <td height="14" colspan="3" align=left class="style24">&nbsp;</td>
         <td></td>
       </tr>
       <tr>
         <td align=left class="style24"><small><strong>Amount</strong></small></td>
         <td colspan="2" align=left class="style24"><small>Rp. <?php echo number_format(num($nominal),0,".",".")  ?></small></td>
         <td height="14" colspan="3" align=left class="style24">&nbsp;</td>
         <td></td>
       </tr>
       <tr>
         <td align=left class="style24"><span class="form-group"> <small>
           <label>In Words :</label>
         </small></span></td>
         <td colspan="2" align=left class="style24"><small><?php echo e($terbilang) ?> Rupiah</small></td>
         <td height="14" colspan="3" align=left class="style24"><br></td>
         <td></td>
       </tr>
       <tr>
         <td colspan="7" align="center">         
         <td width="3%" height="14"></td>
       </tr>
       <tr>
         <td height="14" colspan="7" align=center class="style24"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tbody>
             <tr>
               <td align="center"><label> Receipt By</label></td>
               <td>&nbsp;</td>
               <td align="center"><small>
                 <label> Student</label>
                 <br>
                 <br>
               </small></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td align="center"><small><?php echo e($nama_lengkap) ?></small></td>
               <td>&nbsp;</td>
               <td align="center"><small><?php echo e($nama) ?></small></td>
             </tr>
           </tbody>
         </table></td>
         <td></td>
       </tr>
       <tr>
         <td align=left class="style24"><small> <br>
           <br>
         </small></td>
         <td width="56%" align=left class="style24">&nbsp;</td>
         <td width="9%" align=left class="style24">&nbsp;</td>
         <td align=left class="style24"></td>
         <td height="14" colspan="2" align=left class="style24">&nbsp;</td>
         <td></td>
       </tr>
     <tfoot>
     </tfoot>
   </table>
 </div>

  <input type="text" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="text" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">

  <input type="text" ang="en-150"   name="st" hidden="hidden" 
                 	      value="<?php echo e($st) ?>" >

  <input type="text" ang="en-150"   name="idb" hidden="hidden" 
                 	      value="<?php echo e($idb) ?>" >

  <input type="text" ang="en-150"  name="kdcbg2" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
</body>
</html>
<?php 
if (isset($_GET['Save'])) 
	{
	
	}
?>