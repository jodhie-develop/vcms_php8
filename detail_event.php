<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
$class_code = in_val('cdl', 'get');
$cabang = in_val('cbg', 'get');
$start_date = in_val('start_date', 'get');
$end_date = in_val('end_date', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$dispname = in_val('disp', 'get');
$hari_ini = "$tahun-$bulan-$hari";
if ($start_date==""){$start_date = "$tahun-$bulan-01";}
if ($end_date==""){$end_date = "$tahun-$bulan-31";}
include __DIR__ . "/conndb.php";

$query_periode = q_set($__p_query_periode, "select min(mulai_tm)as mulai, max(mulai_tm) as selesai, nm_teacher, kelas, center, room\r
FROM ves_data.vip_teacher_schedule  where kelas = ? and center = ? ", [(string) ($class_code), (string) ($cabang)]);

$resource_periode = db_query_or_die('errro_7', $query_periode, $__p_query_periode ?? []);
$keluar_periode= db_num_rows($resource_periode);
if(num(db_num_rows($resource_periode)) > 0)
	{
	while ($row_periode=  db_fetch($resource_periode, PDO::FETCH_NUM))
		{
		$mulai_periode= $row_periode[0];							
		$selesai_periode= $row_periode[1];				
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
  <title>AdminLTE 2 | General Form Elements</title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- 

 
 side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo e($class_code) ?> (<?php echo e($cabang) ?>)</h1>
    </section>

    <!-- Main content -->
<section class="content">
  <div class="row">

<form role="form">
 <div class="box-header with-border">
  <div class='col-md-12' align="left">
		    <label>Period</label>
      	  </div></div>     	  
	  <div class="col-md-12">
	    <div class="box box-warning">
		  		<div class="box-header with-border"></div>
       	<table id="example1" class="table table-bordered table-striped">
                <thead>
                <?php
$query_teacher = q_set($__p_query_teacher, "select b.nm_teacher,dayname(a.mulai_tm) as hari,   date_format(a.mulai_tm, '%H:%i'), date_format(a.selesai_tm, '%H:%i'),a.room FROM ves_data.vip_teacher_schedule a, ves_data.vip_teacher_name b where a.nm_teacher = b.kd_teacher and kelas = ? and center = ? group by hari, nm_teacher", [(string) ($class_code), (string) ($cabang)]);

$resource_teacher= db_query_or_die('errro_visitor1', $query_teacher, $__p_query_teacher ?? []);
?>
                <tr>
                  <th width="6%">No</th>
                  <th width="26%"> Teacher's </th>
                  <th width="44%">Day</th>
                  <th width="24%">Room</th>
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
                  <td><?php echo e($row_teacher[1]) ?> (<?php echo e($row_teacher[2]) ; ?> - <?php echo e($row_teacher[3]) ; ?>)</td>
                  <td><?php echo e($row_teacher[4]) ; ?></td>
                </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
	    </div>				
	  </div>
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
</body>
</html>