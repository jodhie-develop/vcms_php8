<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
include __DIR__ . "/../atas.php";
include __DIR__ . "/left.php";

$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}
if ($kd_cbg == ''){$kd_cbg = 15;$cabang = 'CA';}
elseif ($kd_cbg == 'CA'){$kd_cbg = 15;$cabang = 'CA';}


elseif (num($kd_cbg) ==15){$cabang = 'CA';}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;


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
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=ca_acc_receipt.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
   <h1>CA Income Summary - ACC<br>
     </h1>
     <?php 

	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd,a.kd_billing,a.no,b.level_program,a.check_paid   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' and a.kd_branch = ?\r
\tand dt_payment between ? and ? group by id_receipt order by id_receipt desc", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);			
$total_rp = 0;

$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         <tr>
           <th width="11%" scope="row">Center</th>
           <td width="89%"><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">

             <option value="15">CA</option>

             <option selected="selected"><?php echo e($cabang) ?></option>
           </select></td>
         </tr>
         <tr>
           <th scope="row">Period Date</th>
           <td><small>
             <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
           </small> To <small>
           <input type="date" format="dd/MM/yyyy" name="date_end" id="date" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()">
           </small></td>
         </tr>
       </tbody>
     </table>
   

   </section>

  
 
    
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
		
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example2">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="12%">Receipt Number</th>
                  <th width="7%">Effective Date</th>
                  <th width="7%"> Receipt Date</th>
                  <th width="27%">Student Name</th>
                  <th width="14%">Program</th>
                  <th width="10%">Detail</th>
                  <th width="10%">Amount</th>
                  <th width="11%">Payment Metodh</th>
                  <th width="11%">Action</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$query_nama = q_set($__p_query_nama, "SELECT nama_lengkap from ves_data.vip_student_data where kd_biodata = ? and kd_branch = ? ", [(string) ($r[3]), (string) ($r[5])]);	
							$result_nama=db_query_or_die("Wah error nih1", $query_nama, $__p_query_nama ?? []);	
							while ($r_nama = db_fetch($result_nama))
								{ $nama_student = $r_nama[0];}
							$query_program = q_set($__p_query_program, "SELECT concat_ws(' ', type_program, nm_program), level_program, buku FROM ves_data.vip_mst_code_prg  where kd_program =  ? group by kd_program", [(string) ($r[4])]);

							$result_program=db_query_or_die("Wah error nih1", $query_program, $__p_query_program ?? []);	
							while ($r_program = db_fetch($result_program))
								{ $nama_program = $r_program[0];$jenis_program = $r_program[1];}		
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><a href="#" 
target="popup" 
onclick="window.open('vipbillreceipt_dtl.php?id=<?php echo e(u($r[10])); ?>','popup','width=1000,height=800'); return false;"><?php echo e($r[2]) ; ?></a></td>
                  <td><?php echo e($r[0]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($nama_student) ; ?></td>
                  <td><?php echo e($nama_program) ; ?> - <?php echo e($r[11]) ; ?></td>
                  <td><?php echo e($r[7]) ; ?></td>
                  <td><?php echo number_format(num($r[6]),0,".",".") ; ?></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  <td><?php if(num($r[12]) == 1){?>
					  <a href="vipbookreceiptprint.php" 
target="popup" 
onclick="window.open('../printable/vipreceiptprint.php?no=<?php echo e(u($r[10])); ?>','popup','width=1000,height=800'); return false;"><img src="../imgs/printer.png" width="30" height="30"></a><?php } else {?> <a href="ca_receipt_upd.php" 
target="popup" 
onclick="window.open('ca_receipt_upd.php?no=<?php echo e(u($r[10])); ?>','popup','width=1000,height=800'); return false;"><strong>PAID</strong></a><?php } ?></td>
                </tr>
                <?php $total_rp = num($total_rp) + num($r[6]); $no_urut = num($no_urut) + 1; } }
?>       
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <div class="box">
         	<div class="box-body">
         		<label>TOTAL INCOME : Rp. <?php echo number_format(num($total_rp),0,".",".")  ; ?></label>
         	</div>
         </div>
            <!-- /.box-body -->
          </div><a href="rpt_vip_inc.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a><a href="ca_receiptxl.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
    <!-- /.content -->
  </form> 

</div>

<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./.plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
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
