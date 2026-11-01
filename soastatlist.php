<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$posisi = $_SESSION['posisi'];
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');


$ed = in_val('ed', 'get');
$idsoa = $kdb.$ed;
$no = in_val('no', 'get');

$st = in_val('st', 'get');
$new = in_val('new', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$branch = $_SESSION['branch']; 
$asal = in_val('asal', 'get');



$wajib = "form-group has-error";
$tdkwajib = "form-group";
$wajiblabel = "label-danger";
if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
elseif ($kd_cbg == 'HO'){$kd_cbg = 00;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
elseif ($kd_cbg ==''){$cabang = '--ALL--';}
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif (num($kd_cbg) ==00){$cabang = 'HO';}

//
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
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3>SOA List</h3>
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
	          <option value="12">Serpong</option>
	          <option value="6">West Jkt</option>
	          <option value="7">Bandung</option>
	          <option value="102">West Area</option>
	          <option value="100">National</option>
	          <option value="00">HO</option>
	          <option selected="selected"><?php echo e($cabang) ?></option>
	          </select></td>
	      </tr>
	    <tr>
	      <td width="148"><small>
	        <label for="date5"> Enrolled Date Period :</label>
	        </small></td>
	      <td width="289"><small>
	        <label for="date2">:</label>
	        <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
	        To </small><small>
	          <input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
	          </small></td>
	      </tr>
	    </tbody>
	  </table>
	<h5>&nbsp;</h5>
</div>	
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

<form name="myform" id="myform" method="GET">
	
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-body">
    <div class="col-md-12">
      <table width="100%" class="table table-bordered table-striped" id="example1">
        <thead>
          <tr>
            <th width="2%" align=center class="style24">ID</th>
            <th width="9%" align=center class="style24">ID SOA<br>
              Date</th>
            <th width="22%" align=center class="style24">Student Name<br>
              School Destination</th>
            <th width="22%" align=center class="style24">Statement</th>
            <th width="6%" align=center class="style24">Debet</th>
            <th width="6%" align=center class="style24">Kredit</th>
            <th width="6%" align=center class="style24">Payment Metodh</th>
            <th width="6%" align=center class="style24">Paid Date</th>
            <th width="6%" align=center class="style24">Receipt/<br>
              Ceque No</th>
            <th width="6%" align=center class="style24">Ref No</th>
            <th width="6%" align=center class="style24">Admission</th>
            <th width="15%" align=center class="style24">Approval</th>
            <th width="8%" height="14" align=left class="style24">Action</th>
          </tr>
          </thead>
          <tbody>
          <?php 
			$nomor = 1;
			if ($posisi <>'ACCM')
			{
			$query_soa = q_set($__p_query_soa, "SELECT a.id_soa, a.dt_entry, a.kd_biodata, b.nama, b.dest_school, a.keterangan, a.deskripsi, a.rp_debet, a.rp_kredit, a.pay_mtd, a.dt_paid, a.id_receipt, a.no_ref, b.adm_pic, a.app_by, a.dt_app, a.ack_by, a.dt_ack,a.id,a.st_amount,date_format(a.enroll_date,'%y%m%d')\r
\t\t\tFROM ves_data.adm_soa a left join ves_data.adm_stu_progress b on a.kd_biodata = b.kd_biodata and a.enroll_date = b.enroll_date and b.aktif = 1 and a.kd_branch = ? order by a.id  desc", [(string) ($kdcbg)]);
			}
			else
			{
			$query_soa = q_set($__p_query_soa, "SELECT a.id_soa, a.dt_entry, a.kd_biodata, b.nama, b.dest_school, a.keterangan, a.deskripsi, a.rp_debet, a.rp_kredit, a.pay_mtd, a.dt_paid, a.id_receipt, a.no_ref, b.adm_pic, a.app_by, a.dt_app, a.ack_by, a.dt_ack,a.id,a.st_amount,a.enroll_date\r
\t\t\tFROM ves_data.adm_soa a left join ves_data.adm_stu_progress b on a.kd_biodata = b.kd_biodata and a.enroll_date = b.enroll_date and b.aktif = 1 order by a.id  desc");				
			}
			$resource_soa = db_query_or_die('errro_rr', $query_soa, $__p_query_soa ?? []);
			if(num(db_num_rows($resource_soa)) > 0)
				{
				while ($row_soa=  db_fetch($resource_soa, PDO::FETCH_NUM))
					{
						$st_app = 0;
						$st_ack = 0;
							
					if ($row_soa[14] <>''){$st_app = 1;}
					if ($row_soa[16] <>''){$st_ack = 1;}
						?>
          <tr>
            <td align=center class="style24"><?php echo e($nomor) ?></td>
            <td align=center class="style24"><a href="stuadmsoa.php?kdb=<?php echo e(u($row_soa[2])); ?>&ed=<?php echo e(u($row_soa[20])) ?>"><?php echo e($row_soa[0]) ?></a><br>
              <?php echo e($row_soa[1]) ?></td>
            <td align=left class="style24"><?php echo e($row_soa[3]) ?><br>
              <?php echo e($row_soa[4]) ?></td>
            <td align=left class="style24"><?php echo e($row_soa[5]) ?><br>
              <?php echo e($row_soa[6]) ?></td>
            <td align=center class="style24"><?php echo number_format(num($row_soa[7]),0,".",".")?></td>
            <td align=center class="style24"><?php echo number_format(num($row_soa[8]),0,".",".")?></td>
            <td align=center class="style24"><?php echo e($row_soa[9]) ?></td>
            <td align=center class="style24"><?php echo e($row_soa[10]) ?></td>
            <td align=center class="style24"><?php echo e($row_soa[11]) ?></td>
            <td align=center class="style24">
            <?php 
            if(($row_soa[12] =='' and $posisi == 'Admin') or ($row_soa[12] =='' and $posisi == 'ACCM'))
								{ ?><a href="soaupd.php" 
target="popup" 
onclick="window.open('soaupd.php?id=<?php echo e(u($row_soa[18])) ?>&p=1','popup','width=1000,height=800'); return false;">
           						N/A </a>
           				  <?php } 
								else 
								{ echo e($row_soa[12]);
								} ?></td>
            <td align=center class="style24"><?php echo e($row_soa[13]) ?></td>
            <td align=center class="style24">
            <?php if (num($st_app) == 0 and $posisi == 'CM'){?>
            SPV : <a href="soaapp.php" 
target="popup" 
onclick="window.open('soaapp.php?id=<?php echo e(u($row_soa[18])) ?>&by=spv','popup','width=1000,height=800'); return false;">App</a><?php } 
						else {
						echo e($row_soa[14]);	
						} ?>
						<br>
<?php if (num($st_ack) == 0 and $posisi == 'ACCM'){?>             
              ACCTG
              : <a href="soaapp.php" 
target="popup" 
onclick="window.open('soaapp.php?id=<?php echo e(u($row_soa[18])) ?>&by=acc','popup','width=1000,height=800'); return false;">Ack</a><?php } 
						else {
						echo e($row_soa[16]);	
						} ?></td>
            <td height="14" align=center class="style24">
              <p>
                <?php if ($posisi =='Admin' or $posisi== 'ACCM') { ?>
                <a href="soaupd.php" 
target="popup" 
onclick="window.open('soaupd.php?id=<?php echo e(u($row_soa[18])) ?>&p=0','popup','width=1000,height=800'); return false;">Modify</a>
                <?php } ?>
              </p>
              <p><a href="receiptprint.php" 
target="popup" 
onclick="window.open('receiptprint.php?id=<?php echo e(u($row_soa[18])) ?>&p=0','popup','width=1000,height=800'); return false;">Print </a></p>
            </td><?php $nomor = num($nomor) + 1; } } ?>
          </tr>
		  </tbody>
        <tfoot>
        </tfoot>
      </table>
      <br>
    </div>
  </div>
</div>
  </div>
<div class="box-body"></div>
<div class="box-body"></div>
</form>
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