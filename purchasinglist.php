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
$duabln_lalu =  date('Y-m-d', strtotime('today - 60 days'));
if ($date_start ==''){$date_start = $duabln_lalu;}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');
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
elseif ($kd_cbg == 'LIUMEDIA'){$kd_cbg = 99;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 15;}

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
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
elseif (num($kd_cbg) ==15){$cabang = 'Medan';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kelompok = $_SESSION['kelompok'];
//if ($kelompok <> 'ACC'){$kd_cbg = $_SESSION['kd_branch'];}
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$po_status = in_val('po_status', 'get');
if (num($po_status) == 10){$po_status_selected = '--All--';$filter_display = '';}
elseif (num($po_status) == 1){$po_status_selected = 'Proposed';$filter_display = q_set($__p_filter_display, " and po_status = 1 ");}
elseif (num($po_status) == 2){$po_status_selected = 'Approved';$filter_display = q_set($__p_filter_display, " and po_status = 2 ");}
elseif (num($po_status) == 3){$po_status_selected = 'Acknowledge';$filter_display = q_set($__p_filter_display, " and po_status = 3 ");}
elseif (num($po_status) == 4){$po_status_selected = 'Tax Checked';$filter_display = q_set($__p_filter_display, " and po_status = 4 ");}
elseif (num($po_status) == 5){$po_status_selected = 'To Be Paid';$filter_display = q_set($__p_filter_display, " and po_status = 5 ");}
elseif (num($po_status) == 5){$po_status_selected = 'Paid';$filter_display = q_set($__p_filter_display, " and po_status = 6 ");}
elseif (num($po_status) == 7){$po_status_selected = 'Rejected';$filter_display = q_set($__p_filter_display, " and po_status = 7 ");}
elseif (num($po_status) == 9){$po_status_selected = 'Paid';$filter_display = q_set($__p_filter_display, " and po_status = 9 ");}

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
  <link rel="stylesheet" href="cdnjs/ionicons.min.css">
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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
  <h1>Purchase Order List
        <br>
  </h1>
 
	  
 <form method=get action=purchasinglist.php> 	  
    <table width="453" border="0">
        <tbody>
          <tr>
            <td><small>
              <label for="date3">Center :</label>
            </small></td>
            <td><strong>: </strong><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
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
              <option value="102">West Area</option>
              <option value="100">National</option>
              <option value="99">LIUMEDIA</option>				  
              <option selected="selected"><?php echo e($cabang) ?></option>
              </select></td>
          </tr>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Purchase Order Period:</label>
              </small></td>
            <td width="289"><small><strong>:</strong>
<input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td><small>
              <label for="date4">Filter</label>
            </small></td>
            <td><strong>:</strong>
              <select name="po_status"  onChange="this.form.submit()"   class="style33" id="kd_cbg">
              <option value="10">--All--</option>
              <option value="1">Proposed</option>
              <option value="2">Approved</option>
              <option value="3">Acknowledge</option>				  
              <option value="7">Rejected</option>				  
              <option value="9">Paid</option>
              <option selected="selected"><?php echo e($po_status_selected) ?></option>
              </select></td>
          </tr>
          <tr>
            <td>

                <a href="po_entry.php"  class="btn btn-primary">+ Purchase Order</a>
 	</td>
            <td>&nbsp;</td>
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
		  <label>Invoice  List</label>
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=3% height="14" align=center >No</td>
	            <td width=8% align=center >kode</td>
	            <td width=12% align=center >Nama Pemohon</td>
	            <td width=11% align=center >Ditujukan Ke</td>
	            <td width=21% align=center >Kebutuhan</td>
	            <td width=29% align=center >Desc &amp; Cost || Amount</td>
	            <td width="3%" align=center >File</td>
	            <td width="3%" align=center >Status</td>
	            <td width="10%" align=center >Print</td>
	            <td width="10%" align=center >Action</td>
              </tr>
            </thead>
	        <tbody>
          <?php	
	
$query_purchase = q_set($__p_query_purchase, "SELECT kode, corporate, department, kd_branch, nama_pemohon, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, approved_by, po_status FROM purchase_order where (approved_by = ? or nama_pemohon = ? ) " . $filter_display . " and dt_entry between ? and ? order by dt_entry desc", [(string) ($nama_lengkap), (string) ($nama_lengkap), ...($__p_filter_display ?? []), (string) ($date_start), (string) ($date_end) . " 23:00:00"]);
$no_urut = 1;		
$resource_purchase = db_query_soft($query_purchase, $__p_query_purchase ?? []);			
if(num(db_num_rows($resource_purchase)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_purchase, PDO::FETCH_NUM))
		{
		$po_status_pilih = $row_billing[12];
		$po_status_kode = $row_billing[12];		

		if (num($po_status_pilih) == 1){$po_status_pilih = 'Proposed';}
		elseif (num($po_status_pilih) == 2){$po_status_pilih = 'Approved';}
		elseif (num($po_status_pilih) == 3){$po_status_pilih = 'Acknowledge';}
		elseif (num($po_status_pilih) == 4){$po_status_pilih = 'Tax Checked';}		
		elseif (num($po_status_pilih) == 7){$po_status_pilih = 'Rejected';}
		elseif (num($po_status_pilih) == 9){$po_status_pilih = 'Paid';}			

		
	?>
			<tr>
			<td height="14" align=center class="style24"><?php echo e($no_urut) ?></td>
			<td align=center class="style24">
			<?php echo e($row_billing[1]) ?> - <?php echo e($row_billing[0]) ?><br>
			<div class="btn-group">
                      <a href="po_detail_display.php?kode_po=<?php echo e(u($row_billing[0])) ?>" target="_blank"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open"></span></button></a></div></td>
			<td align=center class="style24"><?php echo e($row_billing[4]) ?><br>
			<?php echo e($row_billing[2]) ?> - 
			<?php echo e($row_billing[3]) ?></td>
			<td align=center class="style24"><?php echo e($row_billing[11]) ?></td>
			<td align=center class="style24"><?php echo  e($row_billing[5])  ?></td>
			<td align=center class="style24"> 
<table width="45%" class="table table-bordered table-striped" id="example1">
	              <tbody>
<?php
$query_purchase_item = q_set($__p_query_purchase_item, "SELECT order_cost, amount FROM purchase_order_item where kode = ? ", [(string) ($row_billing[0])]);	
$resource_purchase_item = db_query_soft($query_purchase_item, $__p_query_purchase_item ?? []);			
if(num(db_num_rows($resource_purchase_item)) > 0)
	{
	while ($row_item  =  db_fetch($resource_purchase_item, PDO::FETCH_NUM))
		{		
?>		
	                <tr>
	                  <td width=68% height="14" align=left ><?php echo e($row_item[0])  ?></td>
	                  <td width=32% align=center ><?php echo e($row_item[1])  ?></td>
                    </tr>
<?php $ttl_amount = num($ttl_amount) + num($row_item[1]) ; } } ?>					  
	                <tr>
	                  <td height="14" align=right ><strong>Total Rp.</strong></td>
	                  <td align=center ><strong><?php echo e($ttl_amount)  ?></strong></td>
                    </tr>
					  
	                </tbody></table>				
				</td>
			<td align=center valign="middle" class="style24"><?php
$query_purchase_file = q_set($__p_query_purchase_file, "SELECT nama_file,kode, id, COALESCE(NULLIF(nama_asli, ''), nama_file) FROM purchase_order_file where kode = ? ", [(string) ($row_billing[0])]);	
	  
$resource_purchase_file = db_query_soft($query_purchase_file, $__p_query_purchase_file ?? []);			
if(num(db_num_rows($resource_purchase_file)) > 0)
	{
	while ($row_file  =  db_fetch($resource_purchase_file, PDO::FETCH_NUM))
		{	
		$file_pendukung = $row_file[3];   // teks saja (nama asli); link memakai id
		?>
<?php echo e($file_pendukung) ?>
<a href="" onClick="return popitup('po_view_img.php?id=<?php echo e(u($row_file[2])) ?>&kd=<?php echo e(u($row_file[1])) ?>')"><span class="glyphicon glyphicon-eye-open"></span></a><br><?php		}
	}	
	
?></td>
              <td align=center valign="middle" class="style24"><?php echo  e($po_status_pilih)  ?></td>
              <td align=center class="style24"><a href="po_print.php?kode_po=<?php echo e(u($row_billing[0])) ?>" target="popup" onclick="window.open('po_print.php?kode_po=<?php echo e(u($row_billing[0])) ?>','popup','width=560,height=340,,toolbar=0,menubar=0,location=0'); return false;"><img src="imgs/printer.png" width="30" height="30"></a> </td>
              <td align=center class="style24"><div class="btn-group">
                      <a href="po_detail_display.php?kode_po=<?php echo e(u($row_billing[0])) ?>" target="_blank"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open"></span></button></a>
				  <?php if (num($po_status_kode) <=1){ ?>
<a href="po_del.php?kode_po=<?php echo e(u($row_billing[0])) ?>" target="popup" onclick="window.open('po_del.php?kode_po=<?php echo e(u($row_billing[0])) ?>','popup','width=560,height=340,,toolbar=0,menubar=0,location=0'); return false;"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>	</a>	<?php } ?>		  
                    </div></td>
              </tr>
              <?php $no_urut = num($no_urut) +1;$ttl_amount ='';}} ?>
		    </tbody>
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
      <!-- /.row --><!-- /.content -->
	</form> 
		  
<!-- /.content-wrapper --><!-- Control Sidebar -->

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
   <script>
   function popitup(url) 
   {
    newwindow=window.open(url,'name','height=600,width=900,screenX=400,screenY=350');
    if (window.focus) {newwindow.focus()}
    return false;
   }
   </script>			
</html>
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
