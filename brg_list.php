<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$brg_cat = in_val('brg_cat', 'get');
$cbg = in_val('cbg', 'get');
$flt_model = in_val('flt_model', 'get');
$flt_branch = in_val('flt_branch', 'get');
$flt_user = in_val('flt_user', 'get');
$flt_spesifikasi = in_val('flt_spesifikasi', 'get');
$flt_thn_beli = in_val('flt_thn_beli', 'get');
$flt_status = in_val('flt_status', 'get');
$flt_remark = in_val('flt_remark', 'get');
//if ($flt_model != ''){$q_f = " model = '$flt_model'";}
//if ($flt_branch != ''){$q_f = " branch = '$flt_branch'";}
//if ($flt_user != ''){$q_f = " user = '$flt_user'";}
//if ($flt_spesifikasi != ''){$q_f = " spesifikasi = '$flt_spesifikasi'";}
//if ($flt_thn_beli != ''){$q_f = " thn_beli = '$flt_thn_beli'";}
//if ($flt_status != ''){$q_f = " status = '$flt_status'";}
//if ($flt_remark != ''){$q_f = " remark = '$flt_remark'";}

//if ($flt_model != '' or $flt_branch != '' or $flt_user != '' or  $flt_spesifikasi  != ''  or $flt_thn_beli  != ''  or $flt_status  != '' or $flt_remark  != '' ) {$filter = 1;} else {$filter = 0;}
$conditions = array(); $__p_where = [];   // parameter untuk $where

if ($flt_model != '')         { $conditions[] = 'model = ?'; $__p_where[] = (string) $flt_model; }
if ($flt_branch != '' and $flt_branch !='--All--')        { $conditions[] = 'branch = ?'; $__p_where[] = (string) $flt_branch; }
if ($flt_user != '')          { $conditions[] = 'user = ?'; $__p_where[] = (string) $flt_user; }
if ($flt_spesifikasi != '')   { $conditions[] = 'Processor_Type_and_Speed like ?'; $__p_where[] = '%' . $flt_spesifikasi . '%'; }
if ($flt_thn_beli != '')      { $conditions[] = 'Purchase_Date = ?'; $__p_where[] = (string) $flt_thn_beli; }
if ($flt_status != '')        { $conditions[] = 'status = ?'; $__p_where[] = (string) $flt_status; }
if ($flt_remark != '')        { $conditions[] = 'remark like ?'; $__p_where[] = '%' . $flt_remark . '%'; }


// Jika ada minimal 1 filter, gabungkan dengan AND
if (cnt($conditions) > 0) {
    $where = "WHERE " . implode(" AND ", $conditions);
} else {
    $where = ""; // tanpa filter
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
	  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">	
  <script src="js/tinymce.min.js"/></script>	
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
<script>
$(document).ready(function(){
    $('#office').on('change', function(){
        var officeID = $(this).val();
        if(officeID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'office_id='+officeID,
                success:function(html){
                    $('#lantai').html(html);
                    $('#room').html('<option value="">Select lantai first</option>'); 
                }
            }); 
        }else{
            $('#lantai').html('<option value="">Select office first</option>');
            $('#room').html('<option value="">Select lantai first</option>'); 
        }
    });
    
    $('#state').on('change', function(){
        var lantaiID = $(this).val();
        if(lantaiID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'lantai_id='+lantaiID,
                success:function(html){
                    $('#room').html(html);
                }
            }); 
        }else{
            $('#room').html('<option value="">Select lantai first</option>'); 
        }
    });
});
</script>	
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ASSET MANAGEMENT & INVENTORY
        <small>New Asset</small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
            <form role="form" method="get">		
      <div class="row">
        <!-- left column -->
      <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Item List</h3>
            </div><a href="" 
target="popup" 
onclick="window.open('brg_input.php?mode=0','popup','width=1000,height=800'); return false;">				    <button type="button" a class="btn btn-info btn-flat btn-xs"						>New Item</button></a>						  
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
<?php
	
	if ($where =='')
	{	$query_item= q_set($__p_query_item, "select Id, Asset_ID, Make_Manufacturer, PERFORMANCE_SCORE,Model,Branch_id,Branch,DEPT,User,PrimarySecondary_Dev,Processor_Type_and_Speed,Purchase_Date,Purchase_Cost_Budget,New_Model,\r
Month_Plan,Warranty_Expiry_Date,REMARK,STATUS from inventory_data order by Purchase_Date");		}else{	$query_item= q_set($__p_query_item, "select Id, Asset_ID, Make_Manufacturer, PERFORMANCE_SCORE,Model,Branch_id,Branch,DEPT,User,PrimarySecondary_Dev,Processor_Type_and_Speed,Purchase_Date,Purchase_Cost_Budget,New_Model,\r
Month_Plan,Warranty_Expiry_Date,REMARK,STATUS from inventory_data " . $where . " ORDER BY case date_format(dt_entry,'%Y-%m-%d') when ? then 0 else 1 end, Purchase_Date ", [...($__p_where ?? []), (string) ($hari_ini)]);		}
$result_item=db_query_or_die('Wah error nih2', $query_item, $__p_query_item ?? []);
if(num($result_item->rowCount()) > 0)
	{						

?>	
<table width="100%" class="table table-bordered table-striped" id="example2">
                <thead>
                <tr>
                  <th width="10%">Base - User</th>
                  <th width="7%">Model</th>
                  <th width="20%">Spesifikasi</th>
                  <th width="20%">Remark</th>
                  <th width="2%">&nbsp;</th>
                  <th width="13%">Thn Pengadaan</th>
                  <th width="7%">Status</th>
                  <th width="3%">Performance</th>
                  <th width="10%">Action</th>
                  </tr>
                </thead>
                <tbody>
					<tr>
					  <th><span class="form-group">
					    <select class="form-control" name="flt_branch"  onChange="this.form.submit()">
					      <?php
					$query_opt = q_set($__p_query_opt, "SELECT distinct branch FROM ves_data.inventory_data order by branch");
					$resource_opt = db_query_or_die('errro_7', $query_opt, $__p_query_opt ?? []);
					while ($row_opt=  $resource_opt->fetch(PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_opt[0]).'">'.e($row_opt[0]).'</option>';
					}      ?>
					      <option selected><?php echo  e($flt_branch) ?></option>
				      </select>
                      </span><span class="form-group">
                      <select class="form-control" name="flt_user"  onChange="this.form.submit()">
						  <option>--All--</option>
                        <?php
					if ($flt_branch == '')
					{$query_opt = q_set($__p_query_opt, "SELECT distinct user FROM ves_data.inventory_data order by user");}
	else
					{$query_opt = q_set($__p_query_opt, "SELECT distinct user FROM ves_data.inventory_data where branch = ? order by user", [(string) ($flt_branch)]);}
		
					$resource_opt = db_query_or_die('errro_7', $query_opt, $__p_query_opt ?? []);
					while ($row_opt=  $resource_opt->fetch(PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_opt[0]).'">'.e($row_opt[0]).'</option>';
					}      ?>
                        <option selected><?php echo  e($flt_user) ?></option>
                      </select>
                      </span></th>
                  <th><span class="form-group">
                    <select class="form-control" name="flt_model"  onChange="this.form.submit()">
					<?php
					$query_opt = q_set($__p_query_opt, "SELECT distinct Model FROM ves_data.inventory_data order by model");
					$resource_opt = db_query_or_die('errro_7', $query_opt, $__p_query_opt ?? []);
					while ($row_opt=  $resource_opt->fetch(PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_opt[0]).'">'.e($row_opt[0]).'</option>';
					}      ?>
					<option selected><?php echo  e($flt_model) ?></option>
                    </select>
                  </span></th>
                  <th><input type="text" ang="en-150" class="form-control"  placeholder="Type Spec ..." name="flt_spesifikasi" 
                 	      value="<?php echo e($flt_spesifikasi) ?>" ></th>
                  <th><input type="text" ang="en-150" class="form-control"  placeholder="Type Spec ..." name="flt_remark" 
                 	      value="<?php echo e($flt_remark) ?>" ></th>
                  <th>&nbsp;</th>
                  <th><span class="form-group">
                    <select class="form-control" name="flt_thn_beli"  onChange="this.form.submit()">
                      <?php
					$query_opt = q_set($__p_query_opt, "SELECT distinct purchase_date FROM ves_data.inventory_data order by branch");
					$resource_opt = db_query_or_die('errro_7', $query_opt, $__p_query_opt ?? []);
					while ($row_opt=  $resource_opt->fetch(PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_opt[0]).'">'.e($row_opt[0]).'</option>';
					}      ?>
                      <option selected><?php echo  e($flt_thn_beli) ?></option>
                    </select>
                  </span></th>
                  <th><span class="form-group">
                    <select class="form-control" name="flt_status"  onChange="this.form.submit()">
                      <?php
					$query_opt = q_set($__p_query_opt, "SELECT distinct status FROM ves_data.inventory_data order by status");
					$resource_opt = db_query_or_die('errro_7', $query_opt, $__p_query_opt ?? []);
					while ($row_opt=  $resource_opt->fetch(PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_opt[0]).'">'.e($row_opt[0]).'</option>';
					}      ?>
                      <option selected><?php echo  e($flt_status) ?></option>
                    </select>
                  </span></th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  </tr>
				
<?php					
	while ($row_item=  $result_item->fetch(PDO::FETCH_NUM))
		{	
			$purchase_year = $row_item[11];
$current_year  = date('Y');
$age = num($current_year) - num($purchase_year);

// Hitung performance linear
$rumus_performance = 100 - num((num($age) * 10));

// batasi minimum
if (num($rumus_performance) < 20) $rumus_performance = 10;
		$ada_gb = 0;
		$query_img = q_set($__p_query_img, "SELECT b.id_brg, b.id_cat, b.namafile FROM ves_data.brg_master_img b where id_brg = ? ", [(string) ($row_item[0])]);
		$result_img=db_query_or_die('Wah error nih1', $query_img, $__p_query_img ?? []);
		if(num($result_img->rowCount()) > 0)
			{
			$ada_gb = 1;
			}
			
			
		
		
?>		
                <tr>
                  <td><?php echo e($row_item[6]) ?> - <?php echo e($row_item[8]) ?></td>
                  <td><?php echo e($row_item[4]) ?> - <?php echo e($row_item[2]) ?></td>
                  <td><?php echo e($row_item[10]) ?><br></td>
                  <td><?php echo e($row_item[16]) ?></td>
                  <td>&nbsp;</td>
                  <td> <?php echo e($row_item[11]) ?></td>
                  <td><?php echo e($row_item[17]) ?>
                  <td><?php echo e($rumus_performance) ?> %</td>
                  <td><button type="button" class="btn btn-info" target="popup" 
onclick="window.open('brg_upload.php?id=<?php echo e(u($row_item[0])) ?>','popup','width=1000,height=800'); return false;"  data-toggle="tooltip" title="New Image"><span class="glyphicon glyphicon-new-window"></span></button><button type="button" class="btn btn-warning" target="popup" 
onclick="window.open('inventory_view.php?id=<?php echo e(u($row_item[0])) ?>','popup','width=1800,height=800'); return false;"  data-toggle="tooltip" title="View"><span class="glyphicon glyphicon-eye-open"></span></button>
<button type="button" class="btn btn-info" target="popup" 
onclick="window.open('brg_modify.php?id=<?php echo e(u($row_item[0])) ?>','popup','width=1000,height=800'); return false;"  data-toggle="tooltip" title="Modify"><span class="glyphicon glyphicon-asterisk"></span></button></td>
                  <td width="8%">		  
                    </td>
                  </tr>
<?php } ?>					
                </tbody>
                <tfoot>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  </tr>
                </tfoot>
              </table>
<?php } ?>		

	</div>
            <!-- /.box-body -->

          </div>
<!-- /.box -->

        <!-- Form Element sizes --><!-- /.box --><!-- /.box -->

        <!-- Input addon --><!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form --><!-- /.box -->
          <!-- general form elements disabled --><!-- /.box -->
        </div>
        <!--/.col (right) -->
  

	
	  </form>   <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
	  </form>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
  </footer>

  <!-- Control Sidebar -->

<!-- start Modal Update Storage -->

    <div class="modal fade" id="mdlstorage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
  <div class="modal-dialog">
 <form action="brg_upd_storage.php" method="POST"><?php echo csrf_field(); ?>

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Storage</h4>
      </div>
<div class="box box-title">
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">
    <div class="frmDronpDown">
        <div class="row">
            <label>Country:</label><br /> <select name="country"
                id="country-list" class="demoInputBox"
                onChange="getState(this.value);">
                <option value disabled selected>Select Country</option>
<?php
foreach ($countryResult as $country) {
    ?>
<option value="<?php echo e($country["id"]); ?>"><?php echo e($country["country_name"]); ?></option>
<?php
}
?>
</select>
        </div>
        <div class="row">
            <label>State:</label><br /> <select name="state"
                id="state-list" class="demoInputBox"
                onChange="getCity(this.value);">
                <option value="">Select State</option>
            </select>
        </div>
        <div class="row">
            <label>City:</label><br /> <select name="city"
                id="city-list" class="demoInputBox">
                <option>Select City</option>
            </select>
        </div>
    </div>
              </div>
<div class="box-footer">
              <button type="submit" name="Submit" value="Submit" class="btn btn-primary">Submit</button>
            </div>
              <!-- /.box-body -->
           
        </div>
      <div class="modal-footer">				            
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
	  </form>
  </div>
		</div></div></div>
<!-- end Modal Update Storage -->

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
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>	
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
	$('.textarea').wysihtml5();
</script>
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
<script type="text/javascript" charset="utf-8">
	$(prettyPrint);
</script>	
</body>
</html>
