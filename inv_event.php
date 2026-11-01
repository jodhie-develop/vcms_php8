<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$nama_lengkap = 	$_SESSION['nama_lengkap']; 
$st_new_invoice = 0;
$inv_exist = in_val('inv_exist', 'any');
if ($inv_exist =="--New Invoice--"){$st_new_invoice = 1;}
$inv_new = in_val('inv_new', 'any');
$inv_date = in_val('inv_date', 'any');
$partner_type = in_val('partner_type', 'any');
$vendor_name = in_val('vendor_name', 'any');
$group_name = in_val('group_name', 'any');
$vendor_city = in_val('vendor_city', 'any');
$inst_name = in_val('inst_name', 'any');
$inst_country = in_val('inst_country', 'any');
$item_kategori = in_val('item_kategori', 'any');
$detail_kategori = in_val('detail_kategori', 'any');
$description = in_val('description', 'any');
$add_description = in_val('add_description', 'any');
$remark = in_val('remark', 'any');
$date_remark = in_val('date_remark', 'any');
$jatuh_tempo = in_val('jatuh_tempo', 'any');
$inv_no = in_val('inv_no', 'any');
$inv_date = in_val('inv_date', 'any');
$inv_cur = in_val('inv_cur', 'any');
$inv_amount = in_val('inv_amount', 'any');
$inv_rate_rupiah = in_val('inv_rate_rupiah', 'any');
$inv_amount_rp = num($inv_amount) * num($inv_rate_rupiah);
$inv_bank = in_val('inv_bank', 'any');
$inv_remark = in_val('inv_remark', 'any');
//===last invoice ===
$query_last_inv= q_set($__p_query_last_inv, "SELECT distinct no_invoice FROM ves_data.acc_invoice where no_invoice <>'' order by dt_invoice desc,no desc limit 1");
$resource_last_inv = db_query_soft($query_last_inv, $__p_query_last_inv ?? []);
$keluar_last_inv = db_num_rows($resource_last_inv);	
if(num(db_num_rows($resource_last_inv)) > 0)
	{
	while ($row_last_inv  =  db_fetch($resource_last_inv, PDO::FETCH_NUM))
		{
		$inv_akhir = $row_last_inv[0];
		}
	}
//===================
if ($inv_exist != "--New Invoice--" and $inv_exist !="" ) 
	{
	$new_invoice = 0 ;
	$query_get_date= q_set($__p_query_get_date, "SELECT dt_invoice,institution_name, institution_country, invoice_type FROM ves_data.acc_invoice where no_invoice = ? limit 1", [(string) ($inv_exist)]);
	$resource_get_date = db_query_soft($query_get_date, $__p_query_get_date ?? []);
	if(num(db_num_rows($resource_get_date)) > 0)
		{
		while ($row_get_date  =  db_fetch($resource_get_date, PDO::FETCH_NUM))
			{
			$inst_name = $row_get_date[1];
			$inst_country = $row_get_date[2];
			$partner_type = $row_get_date[3];
			$inv_date = $row_get_date[0];
			if ($partner_type == "Vendor")
				{
				$vendor_name = $row_get_date[1];
				$vendor_city = $row_get_date[2];
				}
			}
		}		
	}
function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
}
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
      <h1>Invoice Form - Event</h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php  include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
<div class="box box-warning">
<div class="box-header with-border"><strong>Invoice</strong></div>
<div class="box-header with-border"><strong>Invoice Number (Last Invoice : <?php echo e($inv_akhir) ?> )</strong>
 <div class="row">
 	<div class="col-md-4">
    <div class="form-group">
      <label>Existing  Invoice</label>
      <select class="form-control" name="inv_exist"  onChange="this.form.submit()">
        <option>--New Invoice--</option>
        <?php
			$query_inst = q_set($__p_query_inst, "SELECT distinct no_invoice FROM ves_data.acc_invoice where no_invoice <>'' order by dt_invoice desc");
			$resource_inst = db_query_or_die('errro_7', $query_inst, $__p_query_inst ?? []);
			while ($row_inst=  db_fetch($resource_inst, PDO::FETCH_NUM))
				{
				echo '<option value="'.e($row_inst[0]).'">'.e($row_inst[0]).'</option>';
				}      ?>
        <option selected><?php echo  e($inv_exist) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>New Invoice</label>
      <input type="text" lang="en-150" class="form-control"  placeholder="Enter ..." name="inv_new" 
                 	      value="<?php echo e($inv_new) ?>" <?php if (num($st_new_invoice)==0) {echo "readonly";} else {echo "autofocus='autofocus'";} ?>></input>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Date Invoice</label>
      <input type="date" class="form-control"  placeholder="Enter ..." name="inv_date" 
                 	      value="<?php echo e($inv_date) ?>">
    </div>
  </div>
 </div> 
</div>

<div class="box-header with-border"><strong>To</strong></div>
<?php //============== ?>
<div class="row">
<div class="box-body">
  <div class="col-md-6">
                 	    <div class="form-group">
                 	    <label>Partner Type</label>
                 	      <select class="form-control" name="partner_type"  onChange="this.form.submit()">                 	      
                 	      <option>Group</option>
                 	      <option>Institution</option>
                 	      <option>Vendor</option>
                 	      <option selected><?php echo  e($partner_type) ?></option>
               	        </select>
    </div>
  </div>
</div>	
</div>
<?php 
if ($partner_type == "Vendor")
{
?>
<div class="row">

<div class="box-body">
  <div class="col-md-8">
                 	    <div class="form-group">
                 	    <label>Vendor Name</label>
                 	      <select class="form-control" name="vendor_name"  onChange="this.form.submit()">
                 	        <?php
								$query_inst = q_set($__p_query_inst, "SELECT nm_vendor FROM ves_data.mst_vendor  order by nm_vendor");
								$resource_inst = db_query_or_die('errro_7', $query_inst, $__p_query_inst ?? []);
								while ($row_inst=  db_fetch($resource_inst, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_inst[0]).'">'.e($row_inst[0]).'</option>';
							  		}      ?>
                 	        <option selected><?php echo  e($inst_name) ?></option>
               	        </select>
    </div>
  </div>
</div>	
</div>
<?php } 
elseif ($partner_type=="Institution")
{
?>
<div class="row">
<div class="box-body">
  <div class="col-md-8">
                 	    <div class="form-group">
                 	    <label>Institution Name</label>
                 	      <select class="form-control" name="inst_name"  onChange="this.form.submit()">
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
      <select class="form-control" name="inst_country" required >
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
</div>	
</div>
<?php } 
//===================== 
elseif ($partner_type=="Group")
{
?>
<div class="row">
<div class="box-body">
  <div class="col-md-8">
                 	    <div class="form-group">
                 	    <label>Group Name</label>
                 	      <select class="form-control" name="group_name"  onChange="this.form.submit()">
                 	        <?php
								$query_inst = q_set($__p_query_inst, "SELECT distinct groupschool FROM ves_data.tb_master_partner where (groupschool is not null and groupschool <> '')order by groupschool");
								$resource_inst = db_query_or_die('errro_7', $query_inst, $__p_query_inst ?? []);
								while ($row_inst=  db_fetch($resource_inst, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_inst[0]).'">'.e($row_inst[0]).'</option>';
							  		}      ?>
                 	        <option selected><?php echo  e($group_name) ?></option>
               	        </select>
    </div>
  </div>
</div>	
</div>
<?php } 
//===================== 
?>
<?php if($inv_exist != "--New Invoice--" and $inv_exist != "")
	{?>
<div class="row">	  
	<div class="col-md-12">
	<div class="box-body">
	  <table width="100%" class="table table-bordered table-striped" id="example1">

                <thead>
                <tr>
      <td width=3% height="14" align=center >No</td>
      <td width="39%" align=center >Description</td>
      <td width="17%" align=center >Original Amount</td>
      <td width="17%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=student">Amount Rupiah</a></td>
      <td width="24%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=student">Bank</a></td>
      </tr>
		</thead> 
		<tbody>
<?php 
	$query_dtl_inv= q_set($__p_query_dtl_inv, "SELECT a.cat_event, a.cat_dtl_event, a.description, a.add_description, a.remark,  date_format(a.dt_event,'%d %b %Y'), a.curr_invoice, a.ori_amount_invoice, a.rate_invoice, a.bank_invoice, a.remark_invoice FROM ves_data.acc_invoice a where a.no_invoice = ? ", [(string) ($inv_exist)]);
	$resource_dtl_inv = db_query_soft($query_dtl_inv, $__p_query_dtl_inv ?? []);
	if(num(db_num_rows($resource_dtl_inv)) > 0)
		{
			$no_urut = 1;
		while ($row_dtl_inv  =  db_fetch($resource_dtl_inv, PDO::FETCH_NUM))
			{
?>
  <tr>
      <td height="14" align=center class="style24"><?php echo e($no_urut); ?></td>
      <td align=left class="style24"><?php echo e($row_dtl_inv[0]); ?> <?php echo e($row_dtl_inv[1]); ?><br>
        <?php echo e($row_dtl_inv[2]); ?> <?php echo e($row_dtl_inv[3]); ?> <?php echo e($row_dtl_inv[4]); ?> <?php echo e($row_dtl_inv[5]); ?></td> 
      <td align=center class="style24"><?php echo e($row_dtl_inv[6]); ?> <?php echo e(buatrp($row_dtl_inv[7])); ?> (<?php echo e(buatrp($row_dtl_inv[8])); ?>)</td>
       <td align=center class="style24"><?php echo e(buatrp(num($row_dtl_inv[7]) * num($row_dtl_inv[8]))); ?></td>
        <td align=center class="style24"><?php echo e($row_dtl_inv[9]); ?></td>
	    </tr><?php } $no_urut = num($no_urut) + 1 ;} ?></table>
	</div>	
	</div>

	
</div>
	<?php } ?>
<div class="row">
<div class="box-body">
  <div class="col-md-4">
                 	    <div class="form-group">
                 	      <label>Item Category</label>
                 	      <select class="form-control" name="item_kategori"  onChange="this.form.submit()">
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
                 	      <select class="form-control" name="detail_kategori"  onChange="this.form.submit()">
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
</div>	
</div>
<div class="row">
<div class="box-body">
  <div class="col-md-8">
                 	    <div class="form-group">
                 	      <label>Description</label>
                 	      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="description" 
                 	      value="<?php echo e($description) ?>">
               	      </div>
  </div>
                 	  <div class="col-md-4">
                 	    <div class="form-group">
                 	      <label>Additional Description</label>
                 	      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="add_description" 
                 	      value="<?php echo e($add_description) ?>">
               	      </div>
               	    </div>
    <div class="col-md-8">
                 	    <div class="form-group">
                 	      <label>Remark</label>
                 	      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="remark" 
                 	      value="<?php echo e($remark) ?>">
               	      </div>
               	    </div>
                 	  <div class="col-md-4">
                 	    <div class="form-group">
                 	      <label>Tanggal Event</label>
                 	      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="date_remark" 
                 	      value="<?php echo e($date_remark) ?>">
               	      </div>
               	    </div>
</div>	
</div>
<div class="box box-warning">
<div class="box-header with-border"><strong>Invoice</strong></div>
                 	
<div class="box-body">
  <div class="col-md-2">
                 	    <div class="form-group">
                 	      <label>Invoice Currency</label>
                 	      <select class="form-control" name="inv_cur">
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
                 	      value="<?php echo e($inv_amount)  ?>"></div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Rupiah Rate</label>
      <input type="number" class="form-control"  placeholder="Enter ..." name="inv_rate_rupiah" 
                 	      value="<?php echo e($inv_rate_rupiah) ?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Hitung Rupiah</label>
      <br>
      <input type="submit" name="hitung" value="hitung" />
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Original Amount (Rupiah)</label>
      <input type="text" class="form-control"  placeholder="Enter ..." name="pay_amount_rupiah" 
                 	      value="<?php echo e($inv_amount_rp) ?>">
    </div>
  </div>
</div>
<div class="box-body">
  <div class="col-md-2">
    <div class="form-group">
      <label>Bank Invoice</label>
                 	      <select class="form-control" name="inv_bank">
                 	        <?php
								$query_bank = q_set($__p_query_bank, "SELECT nm_bank FROM ves_data.fin_bank_list");
								$resource_bank = db_query_or_die('errro_7', $query_bank, $__p_query_bank ?? []);
								while ($row_bank=  db_fetch($resource_bank, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_bank[0]).'">'.e($row_bank[0]).'</option>';
							  		}      ?>
                 	        <option selected><?php echo  e($inv_bank)  ?></option>
               	        </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Bank Account</label>
      <select class="form-control" name="bank_rek">
        <?php
								$query_bank = q_set($__p_query_bank, "SELECT kd_Bank FROM ves_data.fin_bank_list");
								$resource_bank = db_query_or_die('errro_7', $query_bank, $__p_query_bank ?? []);
								while ($row_bank=  db_fetch($resource_bank, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_bank[0]).'">'.e($row_bank[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($bank_rek)  ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-10">
                 	    <div class="form-group">
                 	    <label>Remark Invoice</label>
    <input type="text" class="form-control"  placeholder="Enter ..." name="inv_remark" 
                 	      value="<?php echo e($inv_remark)  ?>"></div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Jatuh Tempo</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="jatuh_tempo" 
                 	      value="<?php echo e($jatuh_tempo) ?>">
    </div>
  </div>
</div>               	    
<div class="box-body"></div>

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
$inv_exist = in_val('inv_exist', 'any');
$inv_new = in_val('inv_new', 'any');
$partner_type = in_val('partner_type', 'any');
$vendor_name = in_val('vendor_name', 'any');
$vendor_city = in_val('vendor_city', 'any');
$inst_name = in_val('inst_name', 'any');
$inst_country = in_val('inst_country', 'any');
$item_kategori = in_val('item_kategori', 'any');
$detail_kategori = in_val('detail_kategori', 'any');
$description = in_val('description', 'any');
$add_description = in_val('add_description', 'any');
$remark = in_val('remark', 'any');
$date_remark = in_val('date_remark', 'any');	
if ($inv_exist =='--New Invoice--')
	{$inv_no = $inv_new;}
else
	{$inv_no = $inv_exist;}
if($partner_type=="Institution")
	{
	$inst_country = in_val('inst_country', 'any');	
	$inst_name = in_val('inst_name', 'any');
	}
elseif($partner_type=="Vendor")
	{
	$inst_country = "Vendor";			
	$inst_name = in_val('vendor_name', 'any');		
	}
elseif($partner_type=="Group")
	{
	$inst_country = "Group";			
	$inst_name = in_val('group_name', 'any');		
	}
	
$inv_date = in_val('inv_date', 'any');
$inv_cur = in_val('inv_cur', 'any');
$inv_amount = in_val('inv_amount', 'any');
$inv_rate_rupiah = in_val('inv_rate_rupiah', 'any');
$inv_bank = in_val('inv_bank', 'any');
$inv_remark = in_val('inv_remark', 'any');
$jatuh_tempo = in_val('jatuh_tempo', 'any');
$bank_rek = in_val('bank_rek', 'any');
$inv_amount_rp = num($inv_amount) * num($inv_rate_rupiah);
$query_simpan = q_set($__p_query_simpan, "insert into ves_data.acc_invoice \r
(no_invoice, dt_invoice, \r
institution_name, institution_country, \r
cat_event, cat_dtl_event, description, add_description, remark, dt_event, \r
curr_invoice, ori_amount_invoice, rate_invoice, bank_invoice, remark_invoice,dt_entry,pic,invoice_type,jatuh_tempo,bank_rek) values \r
(? ,? ,\r
? ,? ,\r
? ,? ,? ,? ,? ,? ,\r
? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($inv_no), (string) ($inv_date), (string) ($inst_name), (string) ($inst_country), (string) ($item_kategori), (string) ($detail_kategori), (string) ($description), (string) ($add_description), (string) ($remark), (string) ($date_remark), (string) ($inv_cur), (string) ($inv_amount), (string) ($inv_rate_rupiah), (string) ($inv_bank), (string) ($inv_remark), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($partner_type), (string) ($jatuh_tempo), (string) ($bank_rek)]);
/* echo $query_simpan (debug SQL versi lama) dihapus */
$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
		echo "<script type=\"text/javascript\">\n";
	echo "alert('Invoice has been set by " . e($nama_lengkap) . "');\n";
	echo "window.location = ('event_commision.php');\n";				
	echo "</script>";
}
?>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$inv_amount = in_val('inv_amount', 'any');
$inv_rate_rupiah = in_val('inv_rate_rupiah', 'any');
$inv_amount_rp = num($inv_amount) * num($inv_rate_rupiah);	
}
?>
