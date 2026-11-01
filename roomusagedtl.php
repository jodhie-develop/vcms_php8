<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
$start_date = in_val('sd', 'get');
$end_date = in_val('ed', 'get');
$kd_cbg = in_val('cbg', 'get');
$kdr = in_val('kdr', 'get');
$grp = in_val('grp', 'get');
include __DIR__ . "/conndb.php";
$query_info = q_set($__p_query_info, "select a.center, b.nm_room from vip_teacher_schedule a\r
left join vip_room_name b on a.room = b.kd_room and a.kd_branch = b.kd_branch\r
where a.kd_branch = ? and kd_room = ? group by kd_room", [(string) ($kd_cbg), (string) ($kdr)]);
$resource_info= db_query_or_die('errro_visitor1', $query_info, $__p_query_info ?? []);
if ($resource_info) 
{ 

while ($row_info = db_fetch($resource_info))
	{
	$cabang = $row_info[0];
	$nmroom = $row_info[1];
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
      <h1><?php echo e($nmroom) ?> (<?php echo e($cabang) ?>)</h1>
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
if (num($grp) ==1){	
$query_dtl = q_set($__p_query_dtl, "select date_format(mulai_tm,'%d-%m-%Y'),date_format(mulai_tm,'%H:%s'),date_format(selesai_tm,'%H:%s'),kelas, TIMEDIFF(DATE_ADD(selesai_tm, interval 1 SECOND),mulai_tm) from vip_teacher_schedule a\r
left join vip_room_name b on a.room = b.kd_room and a.kd_branch = b.kd_branch\r
where mulai_tm between ? and ?\r
and a.kd_branch = ? and status_kelas = 1 and (date_format(mulai_tm,'%H:%s') >='09:00:00'\r
and date_format(mulai_tm,'%H:%s') <='14:00:00' ) and kd_room = ? ", [(string) ($start_date), (string) ($end_date), (string) ($kd_cbg), (string) ($kdr)]);  
}
elseif (num($grp) ==2){
$query_dtl = q_set($__p_query_dtl, "select date_format(mulai_tm,'%d-%m-%Y'),date_format(mulai_tm,'%H:%s'),date_format(selesai_tm,'%H:%s'),kelas, TIMEDIFF(DATE_ADD(selesai_tm, interval 1 SECOND),mulai_tm) from vip_teacher_schedule a\r
left join vip_room_name b on a.room = b.kd_room and a.kd_branch = b.kd_branch\r
where mulai_tm between ? and ?\r
and a.kd_branch = ? and status_kelas = 1 and (date_format(mulai_tm,'%H:%s') >='14:00:01'\r
and date_format(mulai_tm,'%H:%s') <='19:00:00' ) and kd_room = ? ", [(string) ($start_date), (string) ($end_date), (string) ($kd_cbg), (string) ($kdr)]); 	
}else{
$query_dtl = q_set($__p_query_dtl, "select date_format(mulai_tm,'%d-%m-%Y'),date_format(mulai_tm,'%H:%s'),date_format(selesai_tm,'%H:%s'),kelas, TIMEDIFF(DATE_ADD(selesai_tm, interval 1 SECOND),mulai_tm) from vip_teacher_schedule a\r
left join vip_room_name b on a.room = b.kd_room and a.kd_branch = b.kd_branch\r
where mulai_tm between ? and ?\r
and a.kd_branch = ? and status_kelas = 1 and (date_format(mulai_tm,'%H:%s') >='19:00:01'\r
and date_format(mulai_tm,'%H:%s') <='22:00:00' ) and kd_room = ? ", [(string) ($start_date), (string) ($end_date), (string) ($kd_cbg), (string) ($kdr)]); 	
}
$resource_dtl= db_query_or_die('errro_visitor1', $query_dtl, $__p_query_dtl ?? []);
?>
                <tr>
                  <th width="6%">No</th>
                  <th width="26%"> Date </th>
                  <th width="44%">Class Code</th>
                  <th width="24%">Duration</th>
                </tr>
                </thead>
                <tbody>

				  <?php 
					if ($resource_dtl) 
						{ 
							$no_urut = 1;
						while ($row_dtl = db_fetch($resource_dtl))
							{
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($row_dtl[0]) ?> (<?php echo e($row_dtl[1]) ; ?> - <?php echo e($row_dtl[2]) ; ?>)</td>
                  <td><?php echo e($row_dtl[3]) ?></td>
                  <td><?php echo e($row_dtl[4]) ; ?></td>
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