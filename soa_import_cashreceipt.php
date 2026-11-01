<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");

$hari_ini = "$tahun-$bulan-$hari";

$idcbg = in_val('idcbg', 'get');
$idsoa = in_val('idsoa', 'get');
$kdb = in_val('kdb', 'get');


if (num($idcbg) <= 9){$idcbg = "00$idcbg";}else {"0$idcbg";}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PO LIST</title>
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

  <div class="wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
  <h1>Purchase Order List
        <br>
  </h1>
 
	  
 <form method=get action=import_po.php>
 </section>
 <!-- Main content -->
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
	            <td width="10%" align=center >Add to <br>
                SOA</td>
              </tr>
            </thead>
	        <tbody>
          <?php	
	
$query_purchase = q_set($__p_query_purchase, "SELECT kode, corporate, department, kd_branch, nama_pemohon, peruntukan, dt_po, dt_due_po, supplier_name, supplier_phone, supplier_address, approved_by, po_status FROM purchase_order where kd_branch = ? and id_soa = '' order by dt_entry desc", [(string) ($idcbg)]);

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
                      <a href="po_detail_display.php?kode_po=<?php echo e(u($row_billing[0])) ?>" target="_blank"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open"></span></button></a></div><br>
<a href="po_print.php?kode_po=<?php echo e(u($row_billing[0])) ?>" target="popup" onclick="window.open('printing/po_print.php?kode_po=<?php echo e(u($row_billing[0])) ?>','blank','width=560,height=340,,toolbar=0,menubar=0,location=0'); return false;"><img src="imgs/printer.png" width="30" height="30"></a> </td>
			<td align=center class="style24"><?php echo e($row_billing[4]) ?><br>
			<?php echo e($row_billing[2]) ?> - 
			<?php echo e($row_billing[3]) ?></td>
			<td align=center class="style24"><?php echo e($row_billing[11]) ?>

              <input type="hidden" name="idsoa" id="idsoa" value="<?php echo e($idsoa) ?>"><input type="hidden" name="kdb" id="idsoa" value="<?php echo e($kdb) ?>"></td>
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
			<td align=center class="style24"><div class="btn-group">
                      <a href="import_po_execute.php?kdp=<?php echo e(u($row_billing[0])) ?>&idsoa=<?php echo e(u($idsoa)) ?>&kdb=<?php echo e(u($kdb)) ?>"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-adjust"></span></button></a>
		  
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
