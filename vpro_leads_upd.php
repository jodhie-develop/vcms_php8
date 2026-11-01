<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";	 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$id = in_val('id', 'any');

$query_get_leads = q_set($__p_query_get_leads, "SELECT comp_name, comp_id, comp_address, comp_type, comp_size, comp_phone, comp_email, comp_website, comp_media_source, comp_remark, comp_add_information,cp_nama, cp_jabatan, cp_telepon, cp_email,dt_entry,pic,last_remark  FROM vpro_company_data where  id =? ", [(string) ($id)]);

$resource_get_leads = db_query_or_die('errro_27', $query_get_leads, $__p_query_get_leads ?? []);
if(num(db_num_rows($resource_get_leads))>0){

	while ($row_get_leads=  db_fetch($resource_get_leads, PDO::FETCH_NUM))
		{
$vpro_nama = $row_get_leads['0'];
$vpro_kategori = $row_get_leads['3'];
$vpro_prop = $row_get_leads[''];
$vpro_kab = $row_get_leads[''];
$vpro_alamat = $row_get_leads['2'];
$vpro_telepon =$row_get_leads['5'];
$vpro_email = $row_get_leads['6'];
$vpro_website = $row_get_leads['7'];
$vpro_cp_nama = $row_get_leads['11'];
$vpro_cp_jabatan = $row_get_leads['12'];
$vpro_cp_phone = $row_get_leads['13'];
$vpro_cp_email =$row_get_leads['14'];
$vpro_source =$row_get_leads['9'];
$vpro_source_remark = $row_get_leads['8'];
$vpro_add_remark = $row_get_leads['10'];
$vpro_jml_kary = $row_get_leads['4'];
		}



$query_vpro_kab = q_set($__p_query_vpro_kab, "SELECT kab,id  FROM ves_data.mst_wilayah where prop = ?  and kab = ? order by kab ", [(string) ($vpro_prop), (string) ($vpro_kab)]);

$resource_vpro_kab = db_query_or_die('errro_37', $query_vpro_kab, $__p_query_vpro_kab ?? []);
if(num(db_num_rows($resource_vpro_kab))>0){

	while ($row_kab=  db_fetch($resource_vpro_kab, PDO::FETCH_NUM))
		{	
		$vpro_kab = $row_kab[0];
		}
}
else
{$vpro_kab ='';}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VPRO Leads</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="ionicons.min.css">
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
<body class="hold-transition skin-blue sidebar-mini">





  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Corporate Information</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
    	<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>

            <div class="box-body">
			                  <div class="col-xs-6">				  
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Perusahaan</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="vpro_nama" placeholder="Nama Perusahaan (termasuk PT/CV/UD dll)" value="<?php echo e($vpro_nama) ?>">
                </div>
				  </div>
<div class="col-xs-3">
                  <label>Nature of Bussiness</label>
                  <select class="form-control" name="vpro_kategori">
		      <option>--All--</option>
		      <?php

$query_vpro_nature = q_set($__p_query_vpro_nature, "SELECT nama  FROM ves_data.vpro_nature_of_bisnis  order by nama ");

$resource_vpro_nature = db_query_or_die('errro_74', $query_vpro_nature, $__p_query_vpro_nature ?? []);

	while ($row_nature=  db_fetch($resource_vpro_nature, PDO::FETCH_NUM))
		{	
							  		echo '<option value="'.e($row_nature[0]).'">'.e($row_nature[0]).'</option>';
							  		}      ?>
		      <option selected="<?php echo e($vpro_kategori) ?>"><?php echo e($vpro_kategori) ?></option>
                  </select>
              </div>
<span class="form-group">
<input type="text" class="form-control" id="exampleInputEmail2" name="id" placeholder="Nama Perusahaan (termasuk PT/CV/UD dll)" value="<?php echo e($id) ?>">
</span>	
 <div class="col-xs-3">
   <label>Jumlah Karyawan</label>
   <select class="form-control" name="vpro_jml_kary">
     <option>--Pilih--</option>
     <option>1 - 100</option>
     <option>100 - 500</option>
     <option>500 - 1000</option>
     <option>> 1000</option>
	   

     <option selected="<?php echo e($vpro_jml_kary) ?>"><?php echo e($vpro_jml_kary) ?></option>
   </select>
 </div>
          </div>
              <div class="box-body"> 
                <div class="col-xs-3">
                  <label>Provinsi</label>
                  <select name="vpro_prop" class="form-control"   onChange="this.form.submit()" >
		      <option>--All--</option>
		      <?php

$query_vpro_prop = q_set($__p_query_vpro_prop, "SELECT prop,id  FROM ves_data.mst_wilayah group by prop order by prop ");

$resource_vpro_prop = db_query_or_die('errro_7', $query_vpro_prop, $__p_query_vpro_prop ?? []);

	while ($row_prop=  db_fetch($resource_vpro_prop, PDO::FETCH_NUM))
		{	
							  		echo '<option value="'.e($row_prop[0]).'">'.e($row_prop[0]).'</option>';
							  		}      ?>
		      <option selected="selected"><?php echo e($vpro_prop) ?></option>
                  </select>
                </div>
                <div class="col-xs-4">
                  <label>Kabupaten / Kota</label>
                  <select name="vpro_kab" class="form-control">
		      <option>--All--</option>
		      <?php

$query_vpro_prop = q_set($__p_query_vpro_prop, "SELECT kab,id  FROM ves_data.mst_wilayah where prop = ?  order by kab ", [(string) ($vpro_prop)]);

$resource_vpro_prop = db_query_or_die('errro_7', $query_vpro_prop, $__p_query_vpro_prop ?? []);

	while ($row_prop=  db_fetch($resource_vpro_prop, PDO::FETCH_NUM))
		{	
							  		echo '<option value="'.e($row_prop[0]).'">'.e($row_prop[0]).'</option>';
							  		}      ?>
		      <option selected="selected"><?php echo e($vpro_kab) ?></option>
                  </select>
                </div>
                <div class="col-xs-5">
                  <label>Alamat</label>
                  <input type="text" name="vpro_alamat" class="form-control" placeholder="Corporate Alamat" value="<?php echo e($vpro_alamat) ?>">
                </div>
                <div class="col-xs-3">
                  <label>Telepon</label>
                  <input type="text" name="vpro_telepon" class="form-control" placeholder="Corporate Telepon"  value="<?php echo e($vpro_telepon) ?>">
                </div>
                <div class="col-xs-3">
                  <label>E-Mail</label>
                  <input type="email"name="vpro_email" class="form-control" placeholder="Corporate Email"  value="<?php echo e($vpro_email) ?>">
                </div>
                <div class="col-xs-3">
                  <label>Website</label>
                  <input type="text" name="vpro_website" class="form-control" placeholder="website"  value="<?php echo e($vpro_website) ?>">
                </div>
            </div>
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Conctact Person</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
     
                <!-- text input -->
                <div class="col-xs-5">
                  <label>Nama Lengkap</label>
                  <input type="text" name="vpro_cp_nama" class="form-control" placeholder="Nama Contact Person" value="<?php echo e($vpro_cp_nama) ?>">
                </div>
                <div class="col-xs-5">
                  <label>Jabatan</label>
                  <input type="text" class="form-control" name="vpro_cp_jabatan" placeholder="Nama Jabatan / Posisi"  value="<?php echo e($vpro_cp_jabatan) ?>">
                </div>
                <div class="col-xs-5">
                  <label>No HP</label>
                  <input type="enail" class="form-control"name="vpro_cp_phone" placeholder="HP Conctact Person"  value="<?php echo e($vpro_cp_phone) ?>">
                </div>
                <div class="col-xs-5">
                  <label>E-Mail</label>
                  <input type="enail" class="form-control"name="vpro_cp_email" placeholder="Email Conctact Person" value="<?php echo e($vpro_cp_email) ?>">
                </div>



          </div>
            <!-- /.box-body -->
          </div>
<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Source Information</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
                <!-- text input -->
                <div class="col-xs-4">
                  <label>Source</label>
                  <select name="vpro_source" class="form-control">
		      <option>--All--</option>
		      <?php

$query_vpro_data_source = q_set($__p_query_vpro_data_source, "SELECT nama FROM vpro_data_source");

$resource_vpro_data_source = db_query_or_die('errro_7', $query_vpro_data_source, $__p_query_vpro_data_source ?? []);

	while ($row_data_source=  db_fetch($resource_vpro_data_source, PDO::FETCH_NUM))
		{	
							  		echo '<option value="'.e($row_data_source[0]).'">'.e($row_data_source[0]).'</option>';
							  		}      ?>
		      <option selected="selected"><?php echo e($vpro_data_source) ?></option>
                  </select>
                </div>
                <div class="col-xs-8">
                  <label>Source Remark</label>
                  <input type="text" name="vpro_source_remark" class="form-control" placeholder="Source Remark" value="<?php echo e($vpro_source_remark) ?>" >
                </div>
                <div class="col-xs-10">				  
                <div class="form-group">
                  <label>Additional Information</label>
                  <textarea class="form-control" name="vpro_add_remark" rows="3" placeholder="Enter ..."  value="<?php echo e($vpro_source_remark) ?>"></textarea>
					</div></div>
<div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>				  
                <button type="submit" name="Save"  id="Save" class="btn btn-info pull-right">Save</button>
				  
              </div>
				</form>				
          </div>
            <!-- /.box-body -->
          </div>
<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Sales Activities</h3>
				                <button type="submit" name="Save"  id="Save" class="btn btn-warning  pull-right" onclick="location.href='vpro_leads_progress.php?id=<?php echo e(u($id));?>';">New Progress</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=6% height="14" align=center >No</td>
	            <td width=11% align=center >Date Update</td>
	            <td width=40% align=center >Remark</td>
	            <td width=9% align=center >Intake Plan</td>
	            <td width=23% align=center >Offering Package</td>
	            <td width=11% align=center >Status</td>
	            </tr>
            </thead>
	        <tbody>
          <?php	
	
$query_purchase = q_set($__p_query_purchase, "SELECT dt_entry, remark, offering_rp, offering_pax, date_format(intake,'%b %Y'), status FROM vpro_progress where id_comp = ?  order by id desc", [(string) ($id)]);

$no_urut = 1;		
$resource_purchase = db_query_soft($query_purchase, $__p_query_purchase ?? []);			
if(num(db_num_rows($resource_purchase)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_purchase, PDO::FETCH_NUM))
		{

		
	?>
			<tr>
			<td height="14" align=center class="style24"><?php echo e($no_urut) ?></td>
			<td align=center class="style24">
			<?php echo e($row_billing[0]) ?><br><br></td>
			<td align=center class="style24"><?php echo e($row_billing[1]) ?></td>
			<td align=center class="style24"><?php echo e($row_billing[4]) ?></td>
			<td align=center class="style24"><?php echo  e($row_billing[2]) ?> * <?php echo  e($row_billing[3])  ?></td>
			<td align=center class="style24"><?php echo  e($row_billing[5])  ?></td>
			</tr>
              <?php $no_urut = num($no_urut) +1;}} ?>
		    </tbody>
            <tfoot>
            </tfoot>
          </table>
          <!-- text input --></div>
	              
            <!-- /.box-body -->
          </div>				
            </div>				
            <!-- /.box-body -->

<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{

	$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = date("Y-m-d H:i:s");
$vpro_nama = in_val('vpro_nama', 'any');
$vpro_kategori = in_val('vpro_kategori', 'any');
$vpro_prop = in_val('vpro_prop', 'any');
$vpro_kab = in_val('vpro_kab', 'any');
$id = in_val('id', 'any');
$query_vpro_wil_id = q_set($__p_query_vpro_wil_id, "SELECT id  FROM ves_data.mst_wilayah where prop = ?  and kab = ? ", [(string) ($vpro_prop), (string) ($vpro_kab)]);
$resource_wil_id = db_query_or_die('errro_7', $query_vpro_wil_id, $__p_query_vpro_wil_id ?? []);
if(num(db_num_rows($resource_wil_id))>0){

	while ($row_wil_id=  db_fetch($resource_wil_id, PDO::FETCH_NUM))
		{	
		$vpro_id_alamat = $row_wil_id[0];
		}
}	
$vpro_alamat = in_val('vpro_alamat', 'any');
$vpro_telepon = in_val('vpro_telepon', 'any');
$vpro_email = in_val('vpro_email', 'any');
$vpro_website = in_val('vpro_website', 'any');
$vpro_cp_nama = in_val('vpro_cp_nama', 'any');
$vpro_cp_jabatan = in_val('vpro_cp_jabatan', 'any');
$vpro_cp_phone = in_val('vpro_cp_phone', 'any');
$vpro_cp_email = in_val('vpro_cp_email', 'any');
$vpro_source = in_val('vpro_source', 'any');
$vpro_source_remark = in_val('vpro_source_remark', 'any');
$vpro_add_remark = in_val('vpro_add_remark', 'any');
$vpro_kategori = in_val('vpro_kategori', 'any');
$vpro_jml_kary = in_val('vpro_jml_kary', 'any');
	$nama_lengkap = $_SESSION['nama_lengkap'];
$query_simpan_company = q_set($__p_query_simpan_company, "update   vpro_company_data set comp_name =? ,  comp_address =? , comp_type = ? , comp_size = ? , comp_phone=? , comp_email=? , comp_website=? , comp_media_source=? , comp_remark = ? , comp_add_information = ? ,cp_nama =? , cp_jabatan = ? , cp_telepon = ? , cp_email = ? ,dt_entry = ? ,pic = ? where id = ? ", [(string) ($vpro_nama), (string) ($vpro_id_alamat), (string) ($vpro_kategori), (string) ($vpro_jml_kary), (string) ($vpro_telepon), (string) ($vpro_email), (string) ($vpro_website), (string) ($vpro_source), (string) ($vpro_source_remark), (string) ($vpro_add_remark), (string) ($vpro_cp_nama), (string) ($vpro_cp_jabatan), (string) ($vpro_cp_phone), (string) ($vpro_cp_email), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($id)]);/* echo $query_simpan_company (debug SQL versi lama) dihapus */
$resource_vpro_simpan = db_query_or_die('errro_17', $query_simpan_company, $__p_query_simpan_company ?? []);	
	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Company Updated');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";			
		echo "</script>";	

	}}
?>			
          </div>

          <!-- /.box -->

        </div>

        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 

  <!-- Control Sidebar -->
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
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post"><?php echo csrf_field(); ?>

          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->

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
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
