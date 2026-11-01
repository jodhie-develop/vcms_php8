<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
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
 <?php   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=ve_inc_list.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>VE Incentive List<br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
            <td><small>
              <label for="date3">Staff Name :</label>
            </small></td>
            <td><strong>: <?php echo e($nama_lengkap) ?></strong></td>
          </tr>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Incentive Period :</label>
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
		  <label>VE Student and Reward List</label>
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=2% align=center >No</td>
	            <td width=7% align=center >Student Name</td>
	            <td width=10% height="14" align=center >Class Code<br>
                Program<br>
                Start Class</td>
	            <td width="7%" align=center >Registration</td>
	            <td width="7%" align=center >Registration Paid</td>
	            <td width="7%" align=center >Material Cost</td>
	            <td width="7%" align=center >Material Cost Paid</td>
	            <td width="7%" align=center >Net Tuition Fee</td>
	            <td width="10%" align=center >TF Paid</td>
	            <td width="10%" align=center >Total Paid</td>
	            <td width="10%" align=center >Outstanding</td>
	            <td width="13%" align=center >Estimated Incentive</td>
	            <td width="7%" align=center >Reward Status</td>
	            <td width="6%" align=center >Action</td>
              </tr>
            </thead>

	        <tbody>
          <?php	
								
$query_billing = q_set($__p_query_billing, "SELECT a.kelas, c.kd_biodata, sc, c.kd_branch, kd_billing,nama_lengkap,nm_program, type_program , private_pax,net_tf,a.mulai_tm,date_format(a.mulai_tm,'%d %b %y'),c.kd_program,reg_fee,material_cost FROM ves_data.vip_teacher_schedule a\r
left join ves_data.vip_billing c on a.kelas = c.kd_class\r
left join vip_student_data d on c.kd_biodata = d.kd_biodata\r
left join vip_mst_code_prg e on c.kd_program = e.kd_program\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
where  f.min_mulai between ? and ?\r
and a.status_kelas = 1 and sc = ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL' and c.kd_program <> 'LC'and c.kd_program <> 'LCT') group by c.kd_biodata,a.kelas order by mulai_tm", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00", (string) ($nama_lengkap)]);
				

			
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
		$harus_bayar = num($row_billing[9])+num($row_billing[13])+num($row_billing[14]);
		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> '' and \r
\t\t(jns_payment = 'Full Payment' or jns_payment = 'Installment 1' or jns_payment = 'Installment 2' or  jns_payment = 'Installment 3' or  jns_payment = 'Down Payment'  )  ", [(string) ($row_billing[4])]);
		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar_tf = $row_bayar[0];	
				}
			}
		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> '' and \r
\t\t(jns_payment = 'Registration' )  ", [(string) ($row_billing[4])]);
		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar_reg = $row_bayar[0];	
				}
			}
		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> '' and \r
\t\t(jns_payment = 'Material' )  ", [(string) ($row_billing[4])]);
		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar_material = $row_bayar[0];	
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
		$mbayar = num($mbayar_tf)+num($mbayar_material)+num($mbayar_reg);
		$mbayar = num($mbayar) - num($refund);
			
if (num($harus_bayar) - num($mbayar) == 0)
{
//=== hitung incentive
		$type_program = $row_billing[7];
		$jml_pax = $row_billing[8];
		$kd_program = $row_billing[12];	

		if ($type_program == 'PRI' and ($kd_program == 'FDST-AP' or $kd_program == 'FDST-BP'))
			{	
			if (num($jml_pax) == 1){$besar_reward = '175000';}
			elseif (num($jml_pax) == 2){$besar_reward = '120000';}
			elseif (num($jml_pax) == 3){$besar_reward = '100000';}
			elseif (num($jml_pax) == 4){$besar_reward = '100000';}
			}
		elseif ($type_program == 'PRI'and ($kd_program != 'FDST-AP' and $kd_program != 'FDST-BP'))
			{	
			if (num($jml_pax) == 1){$besar_reward = '250000';}
			elseif (num($jml_pax) == 2){$besar_reward = '175000';}
			elseif (num($jml_pax) == 3){$besar_reward = '150000';}
			elseif (num($jml_pax) == 4){$besar_reward = '135000';}
			}
		elseif ($type_program == 'REG' and ($kd_program == 'FDST-AR' or  $kd_program == 'FDST-BR'))
			{	
			$besar_reward = '50000';
			}	
		else
			{
			$besar_reward = '60000';
			}
			$query_cek = q_set($__p_query_cek, "SELECT *  FROM  ves_data.ve_incentive where kelas = ? and  kd_biodata = ? and nama_sc = ? and kd_billing = ? ", [(string) ($row_billing[0]), (string) ($row_billing[1]), (string) ($row_billing[2]), (string) ($row_billing[4])]);
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
						$query_update_reward = q_set($__p_query_update_reward, "update ves_data.ve_incentive set nominal = ? ,st_reward = 1 where no = ? ", [(string) ($besar_reward), (string) ($nomor_asli)]);
						$resource_update_reward = db_query_soft($query_update_reward, $__p_query_update_reward ?? []);
						$status_tampil = 'Pending';
						$st_reward =1;
						$ttl_enable_to_claim = num($ttl_enable_to_claim) + num($besar_reward);
						
						}
					elseif (num($st_reward) == 2)
						{
						$status_tampil = 'Approval required';
						$ttl_proposed_to_claim = num($ttl_proposed_to_claim)  + num($besar_reward);
						}
					elseif (num($st_reward) == 3)
						{
						$status_tampil = 'Approved, acknowledge required';
						$ttl_claim_approved = num($ttl_claim_approved) + num($besar_reward);						
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
						$tax_persen = $row_incentive[25];	
						$besaran_persen = "($tax_persen %)";
						$net_besar_reward = num($besar_reward) - num((num($besar_reward) *num((num($tax_persen)/100))));
						}
					elseif (num($st_reward) == 8)
						{
						$status_tampil = 'Paid';
						$ttl_paid = num($ttl_paid)  + num($besar_reward);			
						}						
					}
				}
			else
				{

					$nomor_asli = $row['0'];
					$query_insert_reward = q_set($__p_query_insert_reward, "insert into ve_incentive(kelas, kd_biodata, nama_sc, kd_billing, nominal, kd_branch, st_reward,start_kelas) values (? ,? ,? ,? ,? ,? ,1,? )", [(string) ($row_billing[0]), (string) ($row_billing[1]), (string) ($row_billing[2]), (string) ($row_billing[4]), (string) ($besar_reward), (string) ($row_billing[3]), (string) ($row_billing[10])]);
					$resource_update_reward = db_query_soft($query_insert_reward, $__p_query_insert_reward ?? []);
			$query_cek = q_set($__p_query_cek, "SELECT *  FROM  ves_data.ve_incentive where kelas = ? and  kd_biodata = ? and nama_sc = ? and kd_billing = ? ", [(string) ($row_billing[0]), (string) ($row_billing[1]), (string) ($row_billing[2]), (string) ($row_billing[4])]);
			$resource_cek = db_query_soft($query_cek, $__p_query_cek ?? []);

			if(num(db_num_rows($resource_cek)) > 0)
				{
				while ($row_incentive  =  db_fetch($resource_cek, PDO::FETCH_NUM))
					{
					$nomor_asli = $row_incentive['0'];					
					$st_reward =1;
					$ttl_enable_to_claim = num($ttl_enable_to_claim) + num($besar_reward);
					}	
				}
				

				}	
			}
		else
			{
						$status_tampil = 'Unknown';$st_reward =	0;$besar_reward = 0;			
			}

	?>
	          <tr>
	            <td align=center class="style24"><?php echo e($no_urut) ?></td>
	            <td align=center class="style24">
	            <?php echo e($row_billing[5]) ?><br>
	            <?php echo e($row_billing[4]) ?><br>
	            <?php echo e($row_billing[2]) ?></td>
	            <td height="14" align=center class="style24"><?php echo e($row_billing[0]) ?> <br>	              
	              <?php echo e($row_billing[6]) ?> <?php echo e($row_billing[7]) ?> <?php echo e($row_billing[8]) ?><br>
	              <?php echo e($row_billing[11]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[13])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($mbayar_reg),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[14])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($mbayar_material),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[9])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($mbayar_tf),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($mbayar),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num((num($harus_bayar)-num($mbayar))),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($besar_reward),0,".",".") ?><br>
                <strong><em><?php echo  number_format(num($net_besar_reward),0,".",".") ?></em></strong></td>
	            <td align=center class="style24"><?php echo e($status_tampil) ?><br>
                <?php echo e($besaran_persen) ?></td>
	            <td align=center class="style24">
				<?php if (num($st_reward) == 1	){ ?>
					<a href="#" 
target="popup" 
onclick="window.open('ve_inc_proses.php?noinc=<?php echo e(u($nomor_asli)) ?>&propose=2','popup','width=1000,height=800'); return false;">
				Claim</a><?php } ?>
				</td>
              </tr>
             <?php $no_urut = num($no_urut) +1;$status_tampil='';$besaran_persen='';							$st_reward =0;$net_besar_reward=''; }} ?>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>
<div class="col-md-12">
    <div class="form-group">
      <label>Period : <?php echo e($date_start) ?> to <?php echo e($date_end) ?>
		</label>
    </div>
  </div>
<br>
	  
<div class="col-md-1">
  <div class="pad box-pane-right bg-yellow">
	<div class="form-group">
      <label>Enable to Claim <br>
 Rp. <?php echo  number_format(num($ttl_enable_to_claim),0,".",".") ?> 
		</label>
	 </div></div>
</div>
<div class="col-md-1">
 <div class="pad box-pane-right bg-blue">	
  <div class="form-group">
    <label>Proposed to Claim <br>
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
	  
<div class="col-md-1">
  <div class="pad box-pane-right bg-maroon-active">
    <div class="form-group">
      <label><a href="#" 
target="popup" 
onclick="window.open('ve_incentive_form_sc.php?nmsc=<?php echo e(u($ns)) ?>&da=<?php echo e(u($da)) ?>&de=<?php echo e(u($de)) ?>&kdc=<?php echo e(u($kdc)) ?>','popup','width=1000,height=800'); return false;">	 
						<strong>Claim Form</strong></a></label>
    </div>
  </div>
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
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
