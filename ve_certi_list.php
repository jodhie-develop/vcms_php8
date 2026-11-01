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
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$nama_depan = $_SESSION['nama_depan'];
$kelompok = $_SESSION['kelompok'];
if ($kelompok <> 'ACC'){$kd_cbg = $_SESSION['kd_branch'];}
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$query_login = q_set($__p_query_login, "SELECT t.nama_login, t.nama_detail, t.password, t.branch, t.kd_branch, no, posisi FROM tb_user t WHERE no = ? ", [(string) ($kd_staff)]);
$resource_login = db_query_or_die('errro_1', $query_login, $__p_query_login ?? []);
$keluar_login= db_num_rows($resource_login);
if(num(db_num_rows($resource_login)) > 0)
	{
	while ($row_login=  db_fetch($resource_login, PDO::FETCH_NUM))
		{
		$nama_lengkap = $row_login['1'];
		}
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
<?php //========================== left nav ?>
 <?php //   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=#> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>VE E-Certificate Generator<br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
			  <td width="148"><small>
              <label for="date5"> End Class Period :</label>
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
		  <label>E-Certificate List</label>
		</div>				
	  </div>
    <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=4% align=center >No</td>
	            <td width=12% align=center >Student Name</td>
	            <td width=9% height="14" align=center >Class Code<br>
                Program</td>
	            <td width="6%" align=center >Last Meeting</td>
	            <td width="6%" align=center >Outstanding Payment</td>
	            <td width="10%" align=center >Final Test Score</td>
	            <td width="11%" align=center >Meeting Attendance</td>
	            <td width="42%" align=center >Certificate Detail</td>
	            <td width="42%" align=center >Action</td>
              </tr>
            </thead>

	        <tbody>
          <?php	
$query_billing = q_set($__p_query_billing, "SELECT a.kelas, c.kd_biodata, sc, c.kd_branch, kd_billing,nama_lengkap,nm_program, type_program , private_pax,net_tf,date_format(a.mulai_tm,'%d %b %Y') FROM ves_data.vip_teacher_schedule a\r
left join ves_data.vip_billing c on a.kelas = c.kd_class\r
left join vip_student_data d on c.kd_biodata = d.kd_biodata\r
left join vip_mst_code_prg e on c.kd_program = e.kd_program\r
INNER JOIN ( SELECT kelas, MAX(mulai_tm) AS max_mulai FROM vip_teacher_schedule where status_kelas = 1\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.max_mulai\r
where  f.max_mulai between ? and ?\r
and a.status_kelas = 1  group by a.kelas order by mulai_tm ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);

			
$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{

		$ns=$row_billing['2'];
		$da = $date_start;
		$de = $date_end;
		$kdc=$row_billing['3'];
		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> '' and \r
\t\t(jns_payment = 'Full Payment' or jns_payment = 'Installment 1' or jns_payment = 'Installment 2' or  jns_payment = 'Installment 3'or  jns_payment = 'Down Payment' )  ", [(string) ($row_billing[4])]);
		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar = $row_bayar[0];	
				}
			}	
//================jumlah meeting
		$query_jml_meeting = q_set($__p_query_jml_meeting, "SELECT kelas from vip_teacher_schedule where status_kelas = 1 and kelas = ? group by mulai_tm", [(string) ($row_billing[0])]);

		$resource_jml_meeting = db_query_soft($query_jml_meeting, $__p_query_jml_meeting ?? []);
		$jml_meeting = db_num_rows($resource_jml_meeting);	
//================jumlah meeting
		$query_jml_hadir = q_set($__p_query_jml_hadir, "SELECT * FROM ves_data.vip_attendance where kd_biodata = ?  and kd_class = ? group by dt_meeting", [(string) ($row_billing[1]), (string) ($row_billing[0])]);
		$resource_jml_hdr = db_query_soft($query_jml_hadir, $__p_query_jml_hadir ?? []);
		$jml_hdr = db_num_rows($resource_jml_hdr);
		$persen_kehadiran = round(div($jml_hdr, $jml_meeting) * 100,2);
		if (num($persen_kehadiran) >= 80) {$hdr_ok = 1;}else{$hdr_ok = 0;}
//==================		
$query_score_final = q_set($__p_query_score_final, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1", [(string) ($row_billing[1]), (string) ($row_billing[0])]);
		$resource_score_final = db_query_soft($query_score_final, $__p_query_score_final ?? []);
		$keluar_score_final = db_num_rows($resource_score_final);	
		if(num(db_num_rows($resource_score_final)) > 0)
			{
			while ($row_score_final  =  db_fetch($resource_score_final, PDO::FETCH_NUM))	
				{
				$l_final = $row_score_final[0];	
				$st_final = $row_score_final[1];	
				$sp_final = $row_score_final[2];	
				$r_final = $row_score_final[3];	
				$w_final = $row_score_final[4];						
				$ttl_final = $row_score_final[5];
				$nomor_final = $row_score_final[6];						
				$adascore_final = 1;
				}
			}
$ttl_besar_reward = num($ttl_besar_reward) + num($besar_reward);
		//==cek sertifikat
	
		$query_certificate = q_set($__p_query_certificate, "SELECT * FROM ves_data.ve_certificate where kd_biodata = ? and kelas = ? ", [(string) ($row_billing[1]), (string) ($row_billing[0])]);
		$resource_certificat = db_query_soft($query_certificate, $__p_query_certificate ?? []);
		$jml_certificate = db_num_rows($resource_certificat);
		if (num($jml_certificate) != 0){$certi_ada = 1;}else{$certi_ada = 0;}
		
		//=============
	?>
	          <tr>
	            <td align=center class="style24"><?php echo e($no_urut) ?></td>
	            <td align=center class="style24">
	            <?php echo e($row_billing[5]) ?><br>
	            <?php echo e($row_billing[4]) ?><br>
	            <?php echo e($row_billing[2]) ?></td>
	            <td height="14" align=center class="style24"><?php echo e($row_billing[0]) ?> <br>	              
	              <?php echo e($row_billing[6]) ?> <?php echo e($row_billing[7]) ?> <?php echo e($row_billing[8]) ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[10]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num((num($row_billing[9])-num($mbayar))),0,".",".") ?></td>
	            <td align=center class="style24">L: <?php echo e($l_final) ?> St : <?php echo e($st_final) ?> Sp:<?php echo e($sp_final) ?><br>
	              r: <?php echo e($r_final) ?> w : <?php echo e($w_final) ?> TTL : <?php echo e($ttl_final) ?></td>
	            <td align=center class="style24"><?php echo e($jml_hdr) ?> of <?php echo e($jml_meeting) ?> <br>
	              <?php echo e($persen_kehadiran) ?> % </td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">
				<?php if (num($adascore_final) == 1 and num($hdr_ok) == 1	){if (num($certi_ada) == 1){ ?>
					<a href="#" 
target="popup" 
onclick="window.open('certi_form.php?kdb=<?php echo e(u($row_billing[1])) ?>&kdc=<?php echo e(u($row_billing[0])) ?>','popup','width=1000,height=800'); return false;">
				Edit</a> <a href="#" 
target="blank" 
onclick="window.open('certificate/certificate.php?kdb=<?php echo e(u($row_billing[1])) ?>&kdc=<?php echo e(u($row_billing[0])) ?>','popup','width=1000,height=800'); return false;">
				Print</a><?php } else { ?>
					<a href="#" 
target="popup" 
onclick="window.open('certi_form.php?kdb=<?php echo e(u($row_billing[1])) ?>&kdc=<?php echo e(u($row_billing[0])) ?>','popup','width=1000,height=800'); return false;">
				Generate</a><?php } }?>					
				</td>
              </tr>
             <?php $no_urut = num($no_urut) +1;$status_tampil='';$l_final = '';$st_final = '';$sp_final ='';$r_final = '';$w_final = '';$ttl_final = '';							$adascore_final =0; }} ?>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>
    <br>
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
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
