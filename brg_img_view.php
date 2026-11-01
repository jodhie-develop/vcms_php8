<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$id = in_val('id', 'get');
$brg_sub_cat = in_val('brg_sub_cat', 'get');
$query_cek_item = q_set($__p_query_cek_item, "select id, b.id_cat, b.brg_title, b.proc_length, b.ram_wide, b.hdd_high, b.raw, b.glass, b.coating, b.aksesoris, b.color, b.thn_pembelian, b.nm_vendor, b.hrg_beli,add_information from brg_master_item b where id = ? ", [(string) ($id)]);

	$result_cek_item=db_query_or_die("Wah error nih1", $query_cek_item, $__p_query_cek_item ?? []);
	if(num(db_num_rows($result_cek_item)) > 0)
		{
		while ($row_item=  db_fetch($result_cek_item, PDO::FETCH_NUM))
			{
			$brg_title = $row_item['2'];
			$length = $row_item['3'];
			$wide = $row_item['4'];
			$hight = $row_item[5];
			$raw = $row_item[6];
			$glass = $row_item[7];
			$coating = $row_item[8];
			$aksesoris = $row_item[9];
			$colour = $row_item[10];
			$add_informasi = $row_item[14];
			$hrg_beli = $row_item[13];
			$thn_beli = $row_item[11];
			$brg_vendor = $row_item[12];
			}
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
  <div class="wrapper">


    <!-- Main content -->
 
	
      <div class="row">
        <!-- left column -->
      <div class="col-md-12">
          <!-- general form elements -->
        <div class="box box-title">
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">
        <div class="col-md-6">				  
                <div class="form-group">
                  <label for="exampleInputEmail1">Category</label>
					<select class="form-control" name="brg_cat"  onChange="this.form.submit()">
					<?php
					$query_brg_cat = q_set($__p_query_brg_cat, "SELECT distinct brg_cat FROM ves_data.brg_master_cat order by brg_cat");
					$resource_brg_cat = db_query_or_die('errro_7', $query_brg_cat, $__p_query_brg_cat ?? []);
					while ($row_brg_cat=  db_fetch($resource_brg_cat, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_brg_cat[0]).'">'.e($row_brg_cat[0]).'</option>';
					}      ?>
					<option selected><?php echo  e($brg_cat) ?></option>
					</select>

                </div>
			    </div>
				 <div class="col-md-6">	 
                <div class="form-group">
                  <label for="exampleInputEmail2">Sub Category</label>
                  <select class="form-control" name="brg_sub_cat"  onChange="this.form.submit()">
                    <?php
					$query_brg_cat = q_set($__p_query_brg_cat, "SELECT distinct brg_sub_cat FROM ves_data.brg_master_cat where brg_cat  = ? order by brg_sub_cat", [(string) ($brg_cat)]);
					$resource_brg_cat = db_query_or_die('errro_7', $query_brg_cat, $__p_query_brg_cat ?? []);
					while ($row_brg_cat=  db_fetch($resource_brg_cat, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_brg_cat[0]).'">'.e($row_brg_cat[0]).'</option>';
					}      ?>
                    <option selected><?php echo  e($brg_sub_cat) ?></option>
                  </select>

                </div>
			    </div>	 
              </div>
              <!-- /.box-body -->
           
        </div>
<div class="box box-warning">
					  
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
<div class="col-sm-6">
                      <div class="row">
                        <div class="col-sm-12">
<?php

$query_cek_category = q_set($__p_query_cek_category, "SELECT namafile FROM ves_data.brg_master_img b where id_brg = ? ", [(string) ($id)]);
$result_cek_category=db_query_or_die("Wah error nih1", $query_cek_category, $__p_query_cek_category ?? []);
if(num(db_num_rows($result_cek_category)) > 0)
	{
	while ($row_cat=  db_fetch($result_cek_category, PDO::FETCH_NUM))
		{	
?>	
                          <img class="img-responsive" src="brg_img/<?php echo e($row_cat[0])?>" alt="Photo">
                          <br>
<?php }} ?>							
                          
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
<div class="col-sm-6">
	<div class="box-header with-border">
              <h3 class="box-title"><?php echo e($brg_title) ?></h3>
            </div>




  <div class="row">
    <div class="col-sm-6"> <div class="box-body">
              <table width="122%" class="table table-bordered">
                <tr>
                  <th width="25%" align="center" style="width: 25%">Length</th>
                  <th width="25%" align="center" style="width: 25%">Wide</th>
                  <th width="29%" align="center" style="width: 25%">High</th>
                  <th width="21%" align="center" style="width: 25%">&nbsp;</th>
                </tr>
                <tr>
                  <td align="center"><?php echo e($length) ?></td>
                  <td align="center"><?php echo e($wide) ?></td>
                  <td align="center"><?php echo e($hight) ?></td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"><strong>Raw</strong></td>
                  <td align="center"><strong>Glass</strong></td>
                  <td align="center"><strong>Coating</strong></td>
                  <td align="center"><strong>Colour</strong></td>
                </tr>
                <tr>
                  <td><?php echo e($raw) ?></td>
                  <td><?php echo e($glass) ?></td>
                  <td><?php echo e($coating) ?></td>
                  <td><?php echo e($colour) ?></td>
                </tr>
                <tr>
                  <td align="left"><strong>Accessoris</strong></td>
                  <td>&nbsp;</td>
                  <td>: <?php echo e($aksesoris) ?></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="left">Thn Pembelian</td>
                  <td colspan="2" align="left">: <?php echo e($thn_beli) ?></td>
                  </tr>
                <tr>
                  <td colspan="2" align="left">Harga Pembelian</td>
                  <td colspan="2" align="left">: <?php echo e($hrg_beli) ?></td>
                  </tr>
                <tr>
                  <td colspan="2" align="left">Vendor</td>
                  <td colspan="2" align="left">: <?php echo e($brg_vendor) ?></td>
                  </tr>					  
              </table>
            </div></div>
    <div class="col-sm-6">
      <div class="box-body">
        <table width="122%" class="table table-bordered">
          <tr>
            <th colspan="4" align="center" style="width: 25%">Storage :</th>
            </tr>
          <tr>
            <td width="25%" align="center"><strong>Office</strong></td>
            <td width="25%" align="center"><strong>Floor</strong></td>
            <td colspan="2" width="29%"  align="center"><strong>Room</strong></td>
            </tr>			
          <tr>
            <td align="center"><?php echo e($length) ?></td>
            <td align="center"><?php echo e($wide) ?></td>
            <td colspan="2" align="center"><?php echo e($hight) ?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="29%">&nbsp;</td>
            <td width="21%">&nbsp;</td>
          </tr>
          <tr>
            <td align="left"><strong>User</strong></td>
            <td>&nbsp;</td>
            <td>: <?php echo e($aksesoris) ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left">Note</td>
            <td colspan="2" align="left">: </td>
          </tr>
        </table>
      </div>
    </div>
    <!-- /.col -->

    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<div class="col-sm-6"><?php echo e($add_informasi) ?></div>	

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
      </div>

	
   	 <!-- /.row -->

    <!-- /.content -->
  </div>

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
<script>
	$('.textarea').wysihtml5();
</script>

<script type="text/javascript" charset="utf-8">
	$(prettyPrint);
</script>	
</body>
</html>
