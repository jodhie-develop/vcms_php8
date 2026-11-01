<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
//include __DIR__ . "/atas.php";
date_default_timezone_set('Asia/Jakarta');
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$class_code = in_val('cdl', 'get');
$kd_cbg = in_val('kd_cbg', 'get');
$nama_lengkap = $_SESSION['nama_lengkap'];

//if (($nama_lengkap !='alexandria') and ($nama_lengkap !='Resty Febrianty') and ($nama_lengkap !='Hanifa Rahmawati') and ($nama_lengkap !='Ricky Ramadhan') )
//{
//$kd_cbg = $_SESSION['kd_branch'];
//}
$cabang = in_val('cabang', 'get');
if(num($kd_cbg) == 1){$cabang ='East Sby';}
if(num($kd_cbg) == 2){$cabang ='West Sby';}
if(num($kd_cbg) == 3){$cabang ='Denpasar';}
if(num($kd_cbg) == 4){$cabang ='South Jkt';}
if(num($kd_cbg) == 5){$cabang ='North Jkt';}
if(num($kd_cbg) == 6){$cabang ='West Jkt';}
if(num($kd_cbg) == 7){$cabang ='Bandung';}
if(num($kd_cbg) == 8){$cabang ='Malang';}

$jns_report = in_val('jns_report', 'get');

$start_date = in_val('start_date', 'get');
$end_date = in_val('end_date', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$fp = in_val('fp', 'get');
$no_doc = in_val('no_doc', 'get');
$hari_ini = "$tahun-$bulan-$hari";
if ($start_date==""){$start_date = "$tahun-$bulan-01";}
if ($end_date==""){$end_date = "$tahun-$bulan-31";}


$week = in_val('week', 'get');
if ($week == '')
	{
$sql_minggu = q_set($__p_sql_minggu, "SELECT minggu FROM ves_data.tb_minggu_detail where detail = ? ", [(string) ($tgl_hari_ini)]);
$resource_sql_minggu= db_query_or_die('errro_a', $sql_minggu, $__p_sql_minggu ?? []);
$keluar_sql_minggu= db_num_rows($resource_sql_minggu);
if(num(db_num_rows($resource_sql_minggu)) > 0)
	{
	while ($row_sql_minggu=  db_fetch($resource_sql_minggu, PDO::FETCH_NUM))
		{						
		$week= $row_sql_minggu[0];				
		}
	}
		
	}
$query = q_set($__p_query, "SELECT no_week, tgl_periode, bulan FROM master_date where minggu = ? and sales_year = '21'", [(string) ($week)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$urut_week= $row[0];
		$tgl_periode = $row[1];
		}
	}

//include __DIR__ . "/profiledata.php";
 //include __DIR__ . "/atas.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista - Customer Management System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>   

  <Script>
  	function createPopup(url) {
    newwindow=window.open(url,'testWindow','height=800,width=600');
    if (window.focus) {newwindow.focus()}
    return false;
}
  </script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head><?php //========================== left nav ?>
 <?php //    include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- 

 
 side column. contains the logo and sidebar -->
  <?php    //  include __DIR__ . "/left.php";	 ?>
<form method=GET> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) --><!-- Main content -->
<section class="content">
<h1>VIP Report</h1>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label>Center</label>
            <select name="cabang"  onChange="this.form.submit()"   id="select" class="form-control" > 
              <option value="0">--ALL--</option>

			<option value="East Sby">East Sby</option>
              <option value="West Sby">West Sby</option>
              <option value="Denpasar">Denpasar</option>
              <option value="South Jkt">South Jkt</option>
              <option value="North Jkt">North Jkt</option>
              <option value="West Jkt">West Jkt</option>
              <option value="Bandung">Bandung</option>
              <option value="Malang">Malang</option>
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Report Category</label>
      <select name="jns_report"  onChange="this.form.submit()"   id="jns_report" class="form-control" >
       
      	        <option selected="selected">Academic</option>
      
       	        <option value="Sales">Sales</option>
        <option value="Marketing">Marketing</option>
      
        <option selected="selected"><?php echo e($jns_report) ?></option>

  
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
                 	    <label>Week</label>
      <select name="week"  onChange="this.form.submit()" class="form-control"  id="nmr_minggu">
			 <?php
			$sql = q_set($__p_sql, "SELECT minggu, nomor_minggu FROM tb_minggu_todate where sales_year = '21' and minggu <>'' order by nomor_minggu ");
			$rs = db_query_soft($sql, $__p_sql ?? []);
			while($row = db_fetch($rs))
			{
			  echo "<option value=\"".e($row['minggu'])."\">".e($row['minggu'])."</option>\n  ";
			}
			?>             
	 	<option selected><?php echo e($week) ?></option>
      </select>
    </div>
  </div>
  <span class="form-group">
	<input type="text"name="no_doc" 
                 	      value="<?php echo e($no_doc) ?>" hidden="hidden">
  </span></div>
	<div class="row"></div>	
<div class="row">

 <div class="box-header with-border">
  <div class='col-md-12' align="left">
		    <label><span class="form-group">Period : <?php echo e($tgl_periode) ?> </span><br>
		    </label>
  </div></div>  
<div class="row">	    
</div>	      	     	  
  <div class="col-md-12">
    <div class="box box-warning">
	  <div class="box-header with-border"></div>
   	  <table id="example1" class="table table-bordered table-striped">
              <thead>
                <?php

	$query_doc = q_set($__p_query_doc, "SELECT v.week, v.vip_file, v.dt_entry, v.pic,v.no,v.st_report,v.remark, COALESCE(NULLIF(v.nama_asli, ''), v.vip_file) FROM ves_data.vip_data v where kd_branch = ? and jns_report = ? and v.dt_entry > '2018-07-01'order by no desc", [(string) ($cabang), (string) ($jns_report)]);
$resource_doc= db_query_or_die('errro_visitor1', $query_doc, $__p_query_doc ?? []);
?>
                <tr>
                  <th width="4%">No</th>
                  <th width="10%">Week</th>
                  <th width="47%">File</th>
                  <th width="14%">Submit Date</th>
                  <th width="25%">PIC</th>
                  <th width="25%">Preview</th>
                  <th width="25%">Status</th>
                  <th width="25%">Delete</th>
                </tr>
              </thead>
              <tbody>

			    <?php 
					if ($resource_doc) 
						{ 
							$no_urut = 1;
						while ($row_doc = db_fetch($resource_doc))
							{
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($row_doc[0]) ; ?></td>
                  <td> <a href="<?php echo e($row_doc[1]); ?>"><?php echo e($row_doc[7]) ?></a><br>
                    Spv Notes : 
                  <a href="<?php echo e($row_doc[1]); ?>"><?php echo e($row_doc[6]) ?><br>
                  </a></td>
                  <td><?php echo e($row_doc[2]) ; ?></td>
                  <td><?php echo e($row_doc[3]) ; ?></td>
                  <td><a href="vip_file_view.php?nfl=<?php echo e(u($row_doc[4])); ?>" 
target="popup" 
onclick="window.open('vip_file_view.php?nfl=<?php echo e(u($row_doc[4])); ?>','popup','width=1500,height=1000'); return false;">Preview</a></td>
                  <td><?php if ($nama_lengkap  == 'alexandria'){ ?>
                    <a href="vip_set_st.php?nfl=<?php echo e(u($row_doc[4])); ?>" 
target="popup" 
onclick="window.open('vip_set_st.php?nfl=<?php echo e(u($row_doc[4])); ?>','popup','width=1500,height=1000'); return false;">
                      <?php if ($row_doc[5] ==''){echo status ; } else { echo e($row_doc[5]);} ?>
                      <?php  } else { echo  e($row_doc[5])  ;}?>
                    </a></td>
                  <td><a href="vip_set_del.php?nfl=<?php echo e(u($row_doc[4])); ?>" 
target="popup" 
onclick="window.open('vip_set_del.php?nfl=<?php echo e(u($row_doc[4])); ?>','popup','width=1000,height=800'); return false;">Delete</a></td>
                </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
              </tbody>
              <tfoot>
              </tfoot>
      </table>
    </div>
  </div>
<?php if ($jns_report !='')
	{?>
	  <div class="col-md-12">
    	<a href="#" onclick="createPopup('vip_updoc.php?cabang=<?php echo e(u($cabang)) ?>&jns_report=<?php echo  e(u($jns_report)) ?>&week=<?php echo e(u($week)) ?>')" target="mine"><input type="submit" name="New" value="Upload"/>   </a>
	</div>
	<?php } ?>	
</form>


    <!-- Horizontal Form -->
          <!-- /.box -->
          <!-- general form elements disabled -->
		  
            
            <!-- /.box-header --><!-- /.box-body --><!-- /.box --><!--/.col (right) --><!-- /.row --><!-- /.content -->
</div>
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
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>	   
