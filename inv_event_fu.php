<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$kd_invoice_dipilih = in_val('kdi', 'any');
//$inst_country = in_val('inst_country', 'any');
$query_fu = q_set($__p_query_fu, "select \r
cat_event, cat_dtl_event, remark_event, dt_event, \r
no_invoice, dt_invoice, curr_invoice, ori_amount_invoice, rate_invoice,\r
bank_invoice, remark_invoice, \r
institution_name, institution_country, institution_code \r
from ves_data.acc_invoice where no = ? ", [(string) ($kd_invoice_dipilih)]);
$resource_fu = db_query_or_die('errro_7', $query_fu, $__p_query_fu ?? []);
while ($row_fu=  db_fetch($resource_fu, PDO::FETCH_NUM))
	{
$item_kategori = $row_fu[0];
$detail_kategori = $row_fu[1];
$event_remark = $row_fu[2];
$event_tgl = $row_fu[3];

		$inv_no = $row_fu[4];
$inv_date = $row_fu[5];
$inv_cur = $row_fu[6];
$inv_amount = $row_fu[7];
$inv_rate_rupiah = $row_fu[8];
		
$inv_bank = $row_fu[9];
$inv_remark = $row_fu[10];	
		
		$inst_name = $row_fu[11];
$inst_country = $row_fu[12];
$kd_inst = $row_fu[13];
		
	} 




$bank = in_val('bank', 'any');




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
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invoice Form - Follow Up</h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php  //     include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
<div class="box box-warning">
<div class="box-header with-border"><strong>Event &amp; Institution</strong>
  <input type="text" name="kd_invoice_dipilih" id="textfield" value="<?php echo e($kd_invoice_dipilih) ?>" hidden="">
</div>
<div class="box-body">
  <div class="col-md-8">
                 	    <div class="form-group">
                 	    <label>Institution Name</label>
                 	      <select class="form-control" name="inst_name"  readonly>
                 	        <?php
								$query_inst = q_set($__p_query_inst, "SELECT school FROM ves_data.tb_master_partner order by school");
								$resource_inst = db_query_or_die('errro_7', $query_inst, $__p_query_inst ?? []);
								while ($row_inst=  db_fetch($resource_inst, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_inst[0]).'">'.e($row_inst[0]).'</option>';
							  		}      ?>
                 	        <option selected><?php echo  e($inst_name) ?></option>
               	        </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Institution Country</label>
      <select class="form-control" name="inst_country" readonly >
        <?php
								$query_country = q_set($__p_query_country, "SELECT distinct country FROM ves_data.tb_master_partner where school = ? order by country", [(string) ($inst_name)]);
								$resource_country = db_query_or_die('errro_7', $query_country, $__p_query_country ?? []);
								while ($row_country=  db_fetch($resource_country, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_country[0]).'">'.e($row_country[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($inst_country) ?></option>
      </select>
    </div>
  </div> 
  <div class="col-md-4">
                 	    <div class="form-group">
                 	      <label>Item Category</label>
                 	      <select class="form-control" name="item_kategori"  readonly>
                 	        <?php
								$query_item = q_set($__p_query_item, "SELECT distinct pos_category FROM acc_mst_post where pos_group = 'MKT'");
								$resource_item = db_query_or_die('errro_7', $query_item, $__p_query_item ?? []);
								while ($row_item=  db_fetch($resource_item, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_item[0]).'">'.e($row_item[0]).'</option>';
							  		}      ?>
                 	        <option selected><?php echo  e($item_kategori) ?></option>
               	        </select>
       			  
    </div>
  </div>               	  
                 	  <div class="col-md-8">
                 	    <div class="form-group">
                 	      <label>Detail Category</label>
                 	      <select class="form-control" name="detail_kategori" readonly>
                 	        <?php
								$query_detail = q_set($__p_query_detail, "SELECT pos_category_dtl FROM acc_mst_post where pos_category = ? ", [(string) ($item_kategori)]);
								$resource_detail = db_query_or_die('errro_7', $query_detail, $__p_query_detail ?? []);
								while ($row_detail=  db_fetch($resource_detail, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_detail[0]).'">'.e($row_detail[0]).'</option>';
							  		}      ?>
                 	        <option selected><?php echo  e($detail_kategori) ?></option>
               	        </select>
               	      </div>
               	    </div>
  
                 
<div class="col-md-10">
                 	        <div class="form-group">
                 	          <label>Event Remark</label>
                 	          <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="event_remark" 
                 	      value="<?php echo e($event_remark) ?>" readonly>
               	          </div>
               	        </div>
                 	      
                 	 
               
                 	  <div class="col-md-5">
                 	    <div class="form-group">
                 	      <label>Tanggal Event</label>
                 	      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="event_tgl" 
                 	      value="<?php echo e($event_tgl) ?>" readonly>
               	      </div>
               	    </div>
  </div>

<div class="box box-warning">
<div class="box-header with-border"><strong></strong></div>
                 	<div class="box-body">
                 	  <div class="col-md-3">
                 	    <div class="form-group">
                 	      <label>Invoice Number</label>
                 	      <input type="text" class="form-control"  placeholder="Enter ..." name="inv_no" value="<?php echo e($inv_no) ?>" readonly>
               	      </div>
               	    </div>
                 	  <div class="col-md-3">
                 	    <div class="form-group">
                 	      <label>Date Invoice</label><input type="date" class="form-control"  placeholder="Enter ..." name="inv_date" 
                 	      value="<?php echo e($inv_date) ?>" readonly></div>
               	    </div></div>
<div class="box-body">
  <div class="col-md-2">
                 	    <div class="form-group">
                 	      <label>Invoice Currency</label>
                 	      <select class="form-control" name="inv_cur" readonly>
                  			  <?php
								$query_curr = q_set($__p_query_curr, "SELECT kd_curr FROM ves_data.fin_currency");
								$resource_curr = db_query_or_die('errro_7', $query_curr, $__p_query_curr ?? []);
								while ($row_curr=  db_fetch($resource_curr, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_curr[0]).'">'.e($row_curr[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($inv_cur) ?></option>
       			  </select>
               	      </div>
  </div>
  <div class="col-md-3">
                 	    <div class="form-group">
                 	    <label>Original Amount</label>
                 	      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="inv_amount" 
                 	      value="<?php echo e($inv_amount)  ?>"readonly></div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Rupiah Rate</label>
      <input type="number" class="form-control"  placeholder="Enter ..." name="inv_rate_rupiah" 
                 	      value="<?php echo e($inv_rate_rupiah) ?>"readonly>
    </div>
  </div>
</div>
<div class="box box-warning"> 
<div class="box-body">
  <div class="col-md-10">
<table id="example1" class="table table-bordered table-striped">
                <thead>
                <?php
$query_teacher = q_set($__p_query_teacher, "SELECT a.remark, a.date_update,pic FROM ves_data.acc_invoice_progress a where kd_invoice = ? order by no desc", [(string) ($kd_invoice_dipilih)]);

$resource_teacher= db_query_or_die('errro_visitor1', $query_teacher, $__p_query_teacher ?? []);
?>
                <tr>
                  <th width="6%">No</th>
                  <th width="26%"> Remark </th>
                  <th width="44%">Date Update</th>
                  <th width="24%">PIC</th>
                </tr>
                </thead>
                <tbody>

				  <?php 
					if ($resource_teacher) 
						{ 
							$no_urut = 1;
						while ($row_teacher = db_fetch($resource_teacher))
							{
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($row_teacher[0]) ; ?></td>
                  <td><?php echo e($row_teacher[1]) ?></td>
                  <td><?php echo e($row_teacher[2]) ; ?></td>
                </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
	  </table>    </div></div>        	    
<div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      <label>Follow Up Result</label>
      <input type="text" class="form-control"  placeholder="Enter Result Follow Up" name="inv_remark_result" 
                 	      >
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Next Follow Up</label>
      <input type="date" class="form-control"  placeholder="Enter ..." name="inv_next_fu" 
                 	      value="<?php echo e($inv_next_fu)  ?>">
    </div>
  </div>
  <div class="col-md-8">
    <div class="form-group">
      <label>Next Follow Up Remark</label>
      <input type="text" class="form-control"  placeholder="Enter ..." name="inv_remark_next_fu" 
                 	      value="<?php echo e($inv_remark_next_fu)  ?>">
    </div>
  </div>
</div>

            <input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$kd_invoice_dipilih = in_val('kd_invoice_dipilih', 'any');	
$inv_remark_result = in_val('inv_remark_result', 'any');
$inv_next_fu = in_val('inv_next_fu', 'any');
$inv_remark_next_fu = in_val('inv_remark_next_fu', 'any');
//===get inst code==
$query_update = q_set($__p_query_update, "update ves_data.acc_invoice set  remark_invoice = ? where no = ? ", [(string) ($hari_ini) . " - " . (string) ($inv_remark_result), (string) ($kd_invoice_dipilih)]);
$resource_update= db_query_or_die('errro_simpan', $query_update, $__p_query_update ?? []);
$query_simpan = q_set($__p_query_simpan, "insert into ves_data.acc_invoice_progress (kd_invoice, remark, date_update,  next_update, next_remark, pic) \r
values (? ,? ,? ,? ,? ,? )", [(string) ($kd_invoice_dipilih), (string) ($inv_remark_result), (string) ($hari_ini), (string) ($inv_next_fu), (string) ($inv_remark_next_fu), (string) ($nama_depan)]);
$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
	
echo "<script type=\"text/javascript\">\n";
echo "alert('Progress has been submitted by by " . e($nama_depan) . "');\n";
echo "window.close();\n";				
echo "</script>";
}
?>
