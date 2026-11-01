<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2022-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$kd_cbg = in_val('kd_cbg', 'get');
if ($kd_cbg == 'National'){$kd_cbg = 100;}
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
elseif ($kd_cbg == 'LIUMEDIA'){$kd_cbg = 99;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
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
elseif (num($kd_cbg) ==99){$cabang = 'LIUMEDIA';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
elseif (num($kd_cbg) ==100){$cabang = 'National';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kelompok = $_SESSION['kelompok'];
//if ($kelompok <> 'ACC'){$kd_cbg = $_SESSION['kd_branch'];}
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TBI LIST PAYMENT</title>
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

  <!-- Content Wrapper. Contains page content -->
	<div class="box-body">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>TBI List Payment<br>
  </h1>
 
    </section><!-- Main content -->	  
 <form method=get action=tbi_list_payment.php> 	  
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
                <option value="6">West Jkt</option>
                <option value="7">Bandung</option>
                <option value="11">PIK</option>
                <option value="12">Serpong</option>				  
                <option value="102">West Area</option>
                <option value="100">National</option>
                <option value="99">LIUMEDIA</option>				  
                <option selected="selected"><?php echo e($cabang) ?></option>
              </select></td>
          </tr>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Payment Date Period :</label>
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

    <section class="content">

<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Invoice  List</label>
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=4% height="14" align=center >No</td>
	            <td width=16% align=center >ID Billing</td>
	            <td width=11% align=center >Payment Date</td>
	            <td width=11% align=center >ID Receipt</td>
	            <td width=11% align=center >Student Name</td>
	            <td width="10%" align=center >SC</td>
	            <td width="10%" align=center >Payment Form</td>
	            <td width="13%" align=center >Amount</td>
              </tr>
            </thead>
	        <tbody>
          <?php	
if (num($kd_cbg) != 100)
{
$query_billing = q_set($__p_query_billing, "SELECT t.id_billing,t.kd_biodata, t.nama_lengkap, t.kd_branch, t.keterangan,a.nominal, t.dt_entry, t.pic, t.id_invoice, t.jns_invoice, t.pay_mtd, t.remark, t.nominal_discount, t.nominal_nama_discount, t.reg_discount, t.reg_nama_discount, t.reg_amount, t.admin_discount, t.admin_nama_discount, t.admin_amount, a.id_invoice,a.id,additional_fee,date_format(a.dt_payment,'%Y-%m-%d')  FROM ves_data.tb_invoice t left join tb_invoice_paid a on t.id_billing = a.id_billing where t.kd_branch = ? and (t.keterangan like 'TBI%' or t.keterangan = 'Coaching Session'  or t.keterangan like '%Test Bakat%'  or t.keterangan = '60 Menit Consult Additional' or t.keterangan = '30 Menit Consult Additional' ) and a.dt_payment between ? and ?  group by a.id_invoice order by a.dt_payment", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);
}
else
{
$query_billing = q_set($__p_query_billing, "SELECT t.id_billing,t.kd_biodata, t.nama_lengkap, t.kd_branch, t.keterangan, a.nominal, t.dt_entry, t.pic, t.id_invoice, t.jns_invoice, t.pay_mtd, t.remark, t.nominal_discount, t.nominal_nama_discount, t.reg_discount, t.reg_nama_discount, t.reg_amount, t.admin_discount, t.admin_nama_discount, t.admin_amount, a.id_invoice,a.id,additional_fee,date_format(a.dt_payment,'%Y-%m-%d')  FROM ves_data.tb_invoice t left join tb_invoice_paid a on t.id_billing = a.id_billing where  (t.keterangan like 'TBI%' or t.keterangan = 'Coaching Session'  or t.keterangan like '%Test Bakat%' or t.keterangan = '60 Menit Consult Additional' or t.keterangan = '30 Menit Consult Additional'  ) and   t.kd_branch between 1 and 12   and a.dt_payment between ? and ?  group by a.id_invoice order by a.dt_payment", [(string) ($date_start), (string) ($date_end)]);
}

$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$total_amount = num($total_amount) + num($row_billing[5]);
	?>
	          <tr>
	            <td height="14" align=center class="style24"><?php echo e($no_urut) ?></td>
	            <td align=center class="style24">
  

	            <a href="invoicebillreceipt.php?idb=<?php echo e(u($row_billing[0]))  ?>">

	            <?php echo e($row_billing[0]) ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[23]) ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[20]) ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[2]) ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[3]) ?> - <?php echo e($row_billing[7]) ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[4]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[5])),0,".",".")  ?></td>
              </tr>
              <?php $no_urut = num($no_urut) +1; }} ?>				

            <tfoot>
					          <tr>
	            <td height="14" colspan="7" align=center class="style24"><strong>TOTAL</strong></td>
	            <td align=center class="style24"><strong><?php echo  number_format(num(($total_amount)),0,".",".")  ?></strong></td>
	            </tr>

				    </tbody>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=4% height="14" align=center >No</td>
	            <td width=16% align=center >Payment For</td>
	            <td width=11% align=center >East Sby</td>
	            <td width=11% align=center >West Sby</td>
	            <td width=11% align=center >Denpasar</td>
	            <td width="10%" align=center >Malang</td>
	            <td width="10%" align=center >PIM</td>
	            <td width="10%" align=center >MOI</td>
	            <td width="13%" align=center >West Jkt</td>
	            <td width="13%" align=center >SOHO</td>
	            <td width="13%" align=center >PIK</td>
	            <td width="13%" align=center >Bandung</td>
	            </tr>
	          </thead>
	        <tbody>
	          <?php	
if (num($kd_cbg) != 100)
{
$query_billing = q_set($__p_query_billing, "SELECT t.keterangan,\r
sum(case when t.kd_branch = 1 then a.nominal end) as east_sby1,\r
sum(case when t.kd_branch = 2 then a.nominal end) as east_sby2 ,\r
sum(case when t.kd_branch = 3 then a.nominal end) as east_sby3 ,\r
sum(case when t.kd_branch = 4 then a.nominal end) as east_sby4 ,\r
sum(case when t.kd_branch = 5 then a.nominal end) as east_sby5 ,\r
sum(case when t.kd_branch = 6 then a.nominal end) as east_sby6 ,\r
sum(case when t.kd_branch = 7 then a.nominal end) as east_sby7 ,\r
sum(case when t.kd_branch = 8 then a.nominal end) as east_sby8,\r
sum(case when t.kd_branch = 11 then a.nominal end) as east_sby11 ,\r
sum(case when t.kd_branch = 12 then a.nominal end) as east_sby12\r
 FROM ves_data.tb_invoice t\r
left join tb_invoice_paid a on t.id_billing = a.id_billing\r
where (t.keterangan like 'TBI%' or t.keterangan = 'Coaching Session'  or t.keterangan like '%Test Bakat%' or t.keterangan = '60 Menit Consult Additional' or t.keterangan = '30 Menit Consult Additional') and t.kd_branch between 1 and 12 and a.dt_payment between ? and ?\r
group by t.keterangan", [(string) ($date_start), (string) ($date_end)]);
}
else
{
$query_billing = q_set($__p_query_billing, "SELECT t.keterangan,\r
sum(case when t.kd_branch = 1 then a.nominal end) as east_sby1,\r
sum(case when t.kd_branch = 2 then a.nominal end) as east_sby2 ,\r
sum(case when t.kd_branch = 3 then a.nominal end) as east_sby3 ,\r
sum(case when t.kd_branch = 4 then a.nominal end) as east_sby4 ,\r
sum(case when t.kd_branch = 5 then a.nominal end) as east_sby5 ,\r
sum(case when t.kd_branch = 6 then a.nominal end) as east_sby6 ,\r
sum(case when t.kd_branch = 7 then a.nominal end) as east_sby7 ,\r
sum(case when t.kd_branch = 8 then a.nominal end) as east_sby8,\r
sum(case when t.kd_branch = 11 then a.nominal end) as east_sby11 ,\r
sum(case when t.kd_branch = 12 then a.nominal end) as east_sby12\r
 FROM ves_data.tb_invoice t\r
left join tb_invoice_paid a on t.id_billing = a.id_billing\r
where (t.keterangan like 'TBI%' or t.keterangan = 'Coaching Session'  or t.keterangan like '%Test Bakat%' or t.keterangan = '60 Menit Consult Additional' or t.keterangan = '30 Menit Consult Additional') and t.kd_branch between 1 and 12 and a.dt_payment  between ? and ?\r
group by t.keterangan", [(string) ($date_start), (string) ($date_end)]);
}

$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$ttl_row_billing_1 = num($ttl_row_billing_1) + num($row_billing[1]);
		$ttl_row_billing_2 = num($ttl_row_billing_2) + num($row_billing[2]);
		$ttl_row_billing_3 = num($ttl_row_billing_3) + num($row_billing[3]);
		$ttl_row_billing_4 = num($ttl_row_billing_4) + num($row_billing[4]);
		$ttl_row_billing_5 = num($ttl_row_billing_5) + num($row_billing[5]);
		$ttl_row_billing_6 = num($ttl_row_billing_6) + num($row_billing[6]);
		$ttl_row_billing_7 = num($ttl_row_billing_7) + num($row_billing[7]);
		$ttl_row_billing_8 = num($ttl_row_billing_8) + num($row_billing[8]);
		$ttl_row_billing_11 = num($ttl_row_billing_11) + num($row_billing[9]);
		$ttl_row_billing_12 = num($ttl_row_billing_12) + num($row_billing[10]);
	
	?>
	          <tr>
	            <td height="14" align=center class="style24"><?php echo e($no_urut) ?></td>
	            <td align=center class="style24"><a href="invoicebillreceipt.php?idb=<?php echo e(u($row_billing[0]))  ?>"> <?php echo e($row_billing[0]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[1])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[2])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[3])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[8])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[4])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[5])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[6])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[11])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[12])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[7])),0,".",".")  ?></td>
	            </tr>

	          <?php $no_urut = num($no_urut) +1; }} ?>
	          </tbody>
	        <tfoot>
					          <tr>
	            <td height="14" colspan="2" align=center class="style24"><strong>Total</strong></td>
	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_1)),0,".",".")  ?></strong></td>
	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_2)),0,".",".")  ?></strong></td>
	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_3)),0,".",".")  ?></strong></td>
	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_8)),0,".",".")  ?></strong></td>								  
	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_4)),0,".",".")  ?></strong></td>
	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_5)),0,".",".")  ?></strong></td>
	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_6)),0,".",".")  ?></strong></td>


	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_11)),0,".",".")  ?></strong></td>
	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_12)),0,".",".")  ?></strong></td>
	            <td align=center class="style24"><strong><?php echo  number_format(num(($ttl_row_billing_7)),0,".",".")  ?></strong></td>								  
	                          </tr>
	          </tfoot>
	        </table>
	      </div>
	    <!-- /.box-body -->
	    </div>
          <!-- /.box -->
    </div>
        <!-- /.col -->
  </div>
<div class="col-md-4">
  <div class="form-group">
    <button type="button" class="btn btn-primary" onclick="location.href='tbi_list_payment_xl.php?kd_cbg=<?php echo e(u($kd_cbg)) ?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end)) ?>';" >Export To Excel</button>
  </div>
</div>
	 </section>   
    <!-- /.row --><!-- /.content -->
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
    </div>
  </aside>
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
