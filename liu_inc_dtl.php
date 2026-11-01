<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");

$act = in_val('act', 'get');

$periode_claim = in_val('periode_claim', 'get');
	$query_claim = q_set($__p_query_claim, "select * from liu_incentive where date_format(periode_claim,'%Y-%m') = ? ", [(string) ($periode_claim)]);
	$result_claim=db_query_or_die("Wah error nih13", $query_claim, $__p_query_claim ?? []);
	$st_claim = db_num_rows($result_claim);	
	if(num($st_claim) > 0){$act = 2;}	
$kd_cbg = in_val('kd_cbg', 'get');


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;

if(num($act) ==1)
	{
	$amkt = in_val('amkt', 'get');

	}
elseif(num($act) ==2)
	{
	$query_claim = q_set($__p_query_claim, "select * from liu_incentive where date_format(periode_claim,'%Y-%m') = ? ", [(string) ($periode_claim)]);
	$result_claim=db_query_or_die("Wah error nih13", $query_claim, $__p_query_claim ?? []);
	$st_claim = db_num_rows($result_claim);	
	if(num($st_claim) == 0)
	{
	
	$amkt = in_val('amkt', 'get');
	$query_staff = q_set($__p_query_staff, "select nama_detail from tb_user where branch = 'LIUMEDIA' and aktif = 'Y' order by nama_detail");
	$result_staff=db_query_or_die("Wah error nih11", $query_staff, $__p_query_staff ?? []);
	$jml_staff = db_num_rows($result_staff);					  
	if ($result_staff) 
	{ 
	while ($r_staff = db_fetch($result_staff))
		{
		$nama_staff = $r_staff[0];
		$nominal_per_staff = div($amkt, $jml_staff);
		$query_inct = q_set($__p_query_inct, "insert into liu_incentive (nama, periode_claim, amount, dt_entry, pic) values (? ,? ,? ,? ,? ) ", [(string) ($nama_staff), (string) ($periode_claim) . "-15", (string) ($nominal_per_staff), (string) ($hari_ini), (string) ($nama_lengkap)]);
		$result_inct=db_query_or_die("Wah error nih11", $query_inct, $__p_query_inct ?? []);
		}
	}}
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
<style>
     .table th {
        font-size: 14px;
    }
	.table td  {
        font-size: 14px;
    }
</style>	
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <div class="col-md-9">
       <div class="form-group">
     <h3>LIUMEDIA Incentive Detail<br>
       Period : <?php echo e($periode_claim) ?> 
     </h3>
       </div>
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
              <table width="100%" class="table table-bordered table-striped" id="example1">
				  <jdl>
                <thead class="thead-dark">
                <tr>
                  <th width="5%" rowspan="2" style="text-align: center">No</th>
                  <th width="18%" rowspan="2">Student Name</th>
                  <th style="text-align: center">&nbsp;</th>
                  <th width="19%" rowspan="2" style="text-align: center">Service Fee</th>
                  <th width="19%" rowspan="2" style="text-align: center">Liu Incentive</th>
                </tr>
                <tr>
                  <th width="39%" bgcolor="#C2C2C2" style="text-align: center">Destination</th>
                  </tr>
                </thead>
				  </jdl>					  
                <tbody>

				  <?php 
	$no_urut = 1;$i = 1;
					$query_cabang = q_set($__p_query_cabang, "SELECT cabang FROM ves_data.tb_sales_report where date_format(enroll_date,'%Y-%m') = ? and length(cabang) > 2 group by cabang ", [(string) ($periode_claim)]);
					
					$result_cabang=db_query_or_die("Wah error nih11", $query_cabang, $__p_query_cabang ?? []);
					if ($result_cabang) 
						{ 
						while ($r_cbg = db_fetch($result_cabang))
							{
							$nama_cabang = $r_cbg[0];
						
							
							$query_hitung_pax = q_set($__p_query_hitung_pax, "select kd_biodata from ves_data.tb_sales_report where date_format(enroll_date,'%Y-%m') = ? and prioritas = 1 and status = 'OK' and cabang = ? and p_np = 'P' group by kd_biodata", [(string) ($periode_claim), (string) ($nama_cabang)]);


							$result_hitung_pax=db_query_or_die("Wah error nih11", $query_hitung_pax, $__p_query_hitung_pax ?? []);
							$jml_hitung_pax = db_num_rows($result_hitung_pax);
														if($nama_cabang =='Central Jkt'){$nama_cabang ='North Jkt';}
							elseif($nama_cabang =='Patal Jkt'){$nama_cabang ='South Jkt';}
							elseif($nama_cabang =='Malang TBI'){$nama_cabang ='Malang';}	
							$query_amount_mkt = q_set($__p_query_amount_mkt, "SELECT sum(mkt_team),sum(rp_mount) FROM ves_inc.tb_prof_bill a\r
left join ves_data.vos_distribute_sf b on a.id_prof_bill = b.id_prof_bill\r
left join tb_sales_report c on b.kd_biodata = c.kd_biodata\r
where date_format(dt_paid,'%Y-%m') = ? and  date_format(enroll_date,'%Y-%m') = ? and a.branch = ? and p_np = 'P'", [(string) ($periode_claim), (string) ($periode_claim), (string) ($nama_cabang)]);
														
							$result_amount_mkt=db_query_or_die("Wah error nih11", $query_amount_mkt, $__p_query_amount_mkt ?? []);
							if ($result_amount_mkt) 
								{ 
								while ($r_amount_mkt = db_fetch($result_amount_mkt))
									{
									$jml_amount_mkt = $r_amount_mkt[0];
									$jml_amount_sf = $r_amount_mkt[1];									
									}
								}
				?>               
					
                <tr style="height: 100%">
                  <td style="height: 200%"><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($nama_cabang) ; ?><input type="hidden" name="nama_cabang" id="nama_cabang" value="<?php echo e($nama_cabang) ?>"><input type="hidden" name="periode_claim" id="periode_claim" value="<?php echo e($periode_claim) ?>">
                  <input hidden="hidden" name="kd_branch" id="textfield" value="<?php echo e($jml_hitung_pax) ?>"></td>
                  <td bgcolor="#C2C2C2" style="text-align: center"><?php echo e($jml_hitung_pax) ?></td>
                  <td style="text-align: right">&nbsp;</td>
                  <td>View</td>

                  </tr>
                <?php $no_urut = num($no_urut)+1;$i = num($i)+1; $tot_pax = num($tot_pax) + num($jml_hitung_pax);$tot_amount_sf = num($tot_amount_sf)+num($jml_amount_sf); $tot_amount_mkt = num($tot_amount_mkt)+num($jml_amount_mkt); $jml_hitung_pax=0; }}  ?>
            
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th width="33%">&nbsp;</th>
                  <th width="17%">PAX</th>
                  <th width="23%">SERVICE FEE</th>
                  <th width="13%">MKT INCENTIVE</th>
                  <th width="14%">ACTION</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><strong>TOTAL</strong></td>
                  <td><?php echo e($tot_pax) ?></td>
                  <td><?php echo number_format(num($tot_amount_sf),0,".",".") ?></td>
                  <td><?php echo number_format(num($tot_amount_mkt),0,".",".") ;
?></td>
                  <td>
					  <?php if($act ==''){ ?>
					  <button type="button" class="btn btn-block btn-success btn-xs" onclick="location.href='?periode_claim=<?php echo e(u($periode_claim)) ?>&act=1&amkt=<?php echo e(u($tot_amount_mkt))?>';">Distribute</button></td>
<?php } ?>
                </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <p><hr></p>
		  </div>
<?php if (num($act) >=1 ){?>		  
		  <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th colspan="3">INCENTIVE PERIOD :                  </th>
                  </tr>
                <tr>
                  <th>STAFF NAME</th>
                  <th width="13%"> INCENTIVE</th>
                  <th width="14%">ACTION</th>
                </tr>
                </thead>
                <tbody>

<?php 
if (num($act) ==2)
	{
		$query_staff = q_set($__p_query_staff, "select nama, amount from liu_incentive where date_format(periode_claim,'%Y-%m') = ? ", [(string) ($periode_claim)]);
	$result_staff=db_query_or_die("Wah error nih11", $query_staff, $__p_query_staff ?? []);

	}
elseif(num($act) ==1)
{
	$query_staff = q_set($__p_query_staff, "select nama_detail from tb_user where branch = 'LIUMEDIA' and aktif = 'Y' order by nama_detail");
	$result_staff=db_query_or_die("Wah error nih11", $query_staff, $__p_query_staff ?? []);
}
	$jml_staff = db_num_rows($result_staff);					  
	if ($result_staff) 
		{ 
		while ($r_staff = db_fetch($result_staff))
			{
			$nama_staff = $r_staff[0];
			$nominal_per_staff = $r_staff[1];
			if($nominal_per_staff == ''){$nominal_per_staff = div($amkt, $jml_staff);}
		
?>					  
		                <tr>			  
                  <td><strong><?php echo e($nama_staff) ?></strong></td>
                  <td><?php echo number_format(num($nominal_per_staff),0,".",".") ?></td>
                  <td></td>

                </tr><?php } } ?>
		                <tr>
		                  <td>
							  <?php if(num($act) ==1){?>
							  <button type="button" class="btn btn-block btn-warning btn-xs" onclick="location.href='?periode_claim=<?php echo e(u($periode_claim)) ?>';">Cancel</button><button type="button" class="btn btn-block btn-success btn-xs" onclick="location.href='?periode_claim=<?php echo e(u($periode_claim)) ?>&act=2&amkt=<?php echo e(u($tot_amount_mkt))?>';">Claim</button><?php } elseif(num($act) ==2){?>
							  <button type="button" class="btn btn-block btn-warning btn-xs" onclick="location.href='?periode_claim=<?php echo e(u($periode_claim)) ?>';">Cancel</button><button type="button" class="btn btn-block btn-success btn-xs" onclick="window.open('liuinctclaim.php?pc=<?php echo e(u($periode_claim))?>','claim','width=900,height=500');">Print</button><?php } ?>
							</td>
		                  <td></td>
		                  <td></td>
                  </tr>
					
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>            
			  <!-- /.box-body -->
          </div>
		  <?php } ?>
		  <a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Print</a>
          <!-- /.box -->
        </div>
        <!-- /.col -->
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
 "pageLength": 50,		
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
