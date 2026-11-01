<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
auth_require_login();
// Menu "Master Salary" hanya untuk posisi ACCM dan HRD; tombol Delete di bawah khusus Savita (ACD/AS).
auth_require(auth_is('posisi', 'ACCM', 'HRD') || (auth_is('kelompok', 'ACD') && auth_is('posisi', 'AS')));
include __DIR__ . "/atas.php";

include __DIR__ . "/left.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$group_teacher = in_enum('group_teacher', ['Full Time', 'Semi Full Time', 'Part Time', 'Academic', 'All'], '', 'get');

$nama_lengkap = $_SESSION['nama_lengkap'];

$kd_staff = $_SESSION['kd_staff'];

// Tabel Teacher Shift di bawah memakai variabel yang tidak pernah diisi di halaman ini
// (versi lama juga selalu kosong).
$nm_teacher = $no_teacher = $day_1 = $day_2 = $day_3 = $day_4 = $day_5 = $day_6 = '';

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
 <!--   <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
	/* ===== Polish tambahan untuk halaman Teacher's Setting (tidak mengubah logic) ===== */
	.page-title {
		display: flex;
		align-items: center;
		gap: 10px;
		margin: 0 0 15px 0;
	}
	.page-title i { color: #3c8dbc; }

	.panel-clean {
		border: none;
		border-radius: 6px;
		box-shadow: 0 1px 4px rgba(0,0,0,.12);
		margin-bottom: 22px;
		overflow: hidden;
	}
	.panel-clean > .box-header {
		background: #f7f9fb;
		border-bottom: 1px solid #e7eaee;
		padding: 14px 18px;
	}
	.panel-clean > .box-header .box-title {
		font-size: 15px;
		font-weight: 600;
		color: #333;
		margin: 0;
	}
	.panel-clean > .box-header .box-title a { color: #3c8dbc; }
	.panel-clean > .box-body { padding: 18px; }

	.filter-group label {
		font-weight: 600;
		font-size: 12px;
		color: #555;
		margin-bottom: 4px;
	}

	table.table thead td, table.table thead th {
		background: #3c8dbc;
		color: #fff !important;
		font-weight: 600;
		font-size: 12.5px;
		vertical-align: middle;
	}
	table.table tbody td { vertical-align: middle; font-size: 13px; }

	.badge-active   { background: #00a65a; padding: 4px 10px; border-radius: 10px; color: #fff; font-size: 11px; }
	.badge-inactive { background: #dd4b39; padding: 4px 10px; border-radius: 10px; color: #fff; font-size: 11px; }

	.action-btns .btn { margin: 2px; }

	.shift-table th, .shift-table td { text-align: center; vertical-align: middle; }
	.shift-table thead td { font-weight: 600; }

	function fScroll(val)
	{
	        var hidScroll = document.getElementById('hidScroll');
	        hidScroll.value = val.scrollTop;
	}

	// function moves scroll position to saved value
	function fScrollMove(what)
	{
	        var hidScroll = document.getElementById('hidScroll');
	        document.getElementById(what).scrollTop = hidScroll.value;
	}
	.style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
</style>
    <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}

</script><body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 class="page-title"><i class="fa fa-graduation-cap"></i> Teacher's Setting</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!-- ===================== TEACHER LIST ===================== -->
        <div class="col-md-12">
          <div class="box panel-clean">
            <div class="box-header with-border">
              <form method="get" class="form-inline filter-group">
                <div class="form-group" style="margin-right:8px;">
                  <label>Group Teacher</label><br>
                  <select class="form-control" name="group_teacher" onChange="this.form.submit()">
                    <option>Full Time</option>
                    <option>Semi Full Time</option>
                    <option>Part Time</option>
                    <option>Academic</option>
                    <option>All</option>
                    <option selected><?php echo e($group_teacher) ?></option>
                  </select>
                </div>
              </form>
              <h4 class="box-title" style="margin-top:8px;">Teacher List</h4>
            </div>

            <div class="box-body">
<?php
if($group_teacher =='Full Time')
{
$query = "SELECT a.no, nama_detail,kd_teacher, a.branch, posisi, a.aktif FROM ves_data.tb_user a left join ves_data.vip_teacher_name b on a.no = b.kd_user where usergroup = 'ACD' and a.aktif = 'Y' and posisi = 'FTT' order by nama_detail" ;
}
elseif($group_teacher =='Semi Full Time')
{
$query = "SELECT a.no, nama_detail,kd_teacher, a.branch, posisi, a.aktif FROM ves_data.tb_user a left join ves_data.vip_teacher_name b on a.no = b.kd_user where usergroup = 'ACD' and a.aktif = 'Y' and posisi = 'SFT' order by nama_detail" ;
}
elseif($group_teacher =='Part Time')
{
$query = "SELECT a.no, nama_detail,kd_teacher, a.branch, posisi, a.aktif FROM ves_data.tb_user a left join ves_data.vip_teacher_name b on a.no = b.kd_user where usergroup = 'ACD' and a.aktif = 'Y' and posisi = 'PTT' order by nama_detail" ;
}
elseif($group_teacher =='Academic')
{
$query = "SELECT a.no, nama_detail,kd_teacher, a.branch, posisi, a.aktif FROM ves_data.tb_user a left join ves_data.vip_teacher_name b on a.no = b.kd_user where usergroup = 'ACD' and a.aktif = 'Y' and posisi = 'AS' order by nama_detail" ;
}
elseif($group_teacher =='All' or $group_teacher =='' )
{
$query = "SELECT a.no, nama_detail,kd_teacher, a.branch, posisi, a.aktif FROM ves_data.tb_user a left join ves_data.vip_teacher_name b on a.no = b.kd_user where usergroup = 'ACD'  order by nama_detail" ;
}

?>
              <table width="100%" class="table table-bordered table-striped" id="example1">
                <thead>
                  <tr>
                    <td width="27%" align=center class="style24">Teacher's Name</td>
                    <td width="12%" align=center class="style24">Branch</td>
                    <td width="8%" align=center class="style24">Group</td>
                    <td width="26%" align=center class="style24">Description</td>
                    <td width="8%" align=center class="style24">Active</td>
                    <td width="19%" align=center class="style24">Action</td>
                  </tr>
                </thead>
                <tbody>
<?php
$result = db_query($query);
if ($result)
	{
	while ($r = $result->fetch(PDO::FETCH_NUM))
		{
		?>
                  <tr>
                    <td align=left class="style24"><?php echo e($r[1]); ?> [<?php echo e($r[2]); ?>]</td>
                    <td align=left class="style24"><?php echo e($r[3]); ?></td>
                    <td align=left class="style24"><?php echo e($r[4]); ?></td>
                    <td align=center class="style24"></td>
                    <td align=center class="style24">
<?php if ($r[5] == 'Y') { ?>
                      <span class="badge-active">Active</span>
<?php } else { ?>
                      <span class="badge-inactive">Inactive</span>
<?php } ?>
                    </td>
                    <td align=center class="style24 action-btns">
                      <a href=""
                         target="popup"
                         onClick="window.open('teacher_master_upd.php?id=<?php echo e(u($r[0])) ?>','popup','width=800,height=850,left=700px'); return false;"
                         class="btn btn-info btn-sm" role="button">
                        <i class="glyphicon glyphicon-edit" aria-hidden="true"></i> Modify
                      </a>
<?php if ($nama_lengkap =='Savita Rachma Indrayani'){ // $r[9] tidak ada di query ini (versi lama juga kosong) ?>
                      <a href="vip_agendadel.php?id="
                         target="popup"
                         onClick="window.open('vip_agendadel.php?id=','popup','width=800,height=850,left=700px'); return false;"
                         class="btn btn-danger btn-sm" role="button">
                        <i class="glyphicon glyphicon-erase" aria-hidden="true"></i> Delete
                      </a>
<?php } ?>
                    </td>
                  </tr>
<?php
		}
	}
?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ===================== TEACHER SHIFT ===================== -->
        <div class="col-md-12">
          <div class="box panel-clean">
            <div class="box-header with-border">
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#todayact">Teacher Shift</a>
              </h4>
            </div>

            <div class="box-body">
<?php // (query $query_plan di sini tidak pernah dijalankan di versi lama, tidak dibawa) ?>
              <table width="100%" class="table table-bordered table-striped shift-table" id="example2">
                <thead>
                  <tr>
                    <td width="11%" class="style24">Teacher's Name</td>
                    <td width="12%" class="style24">Mon</td>
                    <td width="12%" class="style24">Tue</td>
                    <td width="12%" class="style24">Wed</td>
                    <td width="12%" class="style24">Thu</td>
                    <td width="12%" class="style24">Fri</td>
                    <td width="12%" class="style24">Sat</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="style24"><?php echo e($nm_teacher) ?></td>
                    <td class="style24">
                      <a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1"
                         target="popup"
                         onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_1) ?></a>
                    </td>
                    <td class="style24">
                      <a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1"
                         target="popup"
                         onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=2 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_2) ?></a>
                    </td>
                    <td class="style24">
                      <a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1"
                         target="popup"
                         onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=3 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_3) ?></a>
                    </td>
                    <td class="style24">
                      <a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1"
                         target="popup"
                         onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=4 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_4) ?></a>
                    </td>
                    <td class="style24">
                      <a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1"
                         target="popup"
                         onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=5 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_5) ?></a>
                    </td>
                    <td class="style24">
                      <a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1"
                         target="popup"
                         onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=6 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_6) ?></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
</div>
</body>
</html>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
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
<?php // Blok simpan "Submit" versi lama dihapus: tidak ada form yang memakainya dan rentan SQL injection lewat URL. ?>
