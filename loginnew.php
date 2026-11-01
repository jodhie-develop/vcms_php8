<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();

date_default_timezone_set('Asia/Jakarta');

$awal_periode = '2020-01-01';
//$jamskrg= date('h:i:s', time());
//$jamskrg= date('h:i:s');
$jamskrg = date("h:i:sa");
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
$ip_local = getUserIP();

include __DIR__ . "/conndb.php";
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = in_val('name', 'post');
    $password = in_val('password', 'post');
	 if ($name == '' || $password == '') 
	 	{
        $msg = "You must enter all fields";
    	} 
	else 
		{
        $query_login = q_set($__p_query_login, "SELECT t.nama_login, t.nama_detail, t.password, t.branch, t.kd_branch, no, posisi, kd_area,level_posisi,usergroup FROM tb_user t WHERE nama_login = ? AND password = ? ", [(string) ($name), (string) ($password)]);
		$resource_login = db_query_or_die('errro_2', $query_login, $__p_query_login ?? []);
		$keluar_login= db_num_rows($resource_login);
		if(num(db_num_rows($resource_login)) > 0)
			{
			while ($row_login=  db_fetch($resource_login, PDO::FETCH_NUM))
				{
				$status_login = 1;
				$_SESSION['st_login']= 1;
				
				$nama_lengkap = $row_login[1];
				$nama_depan= $row_login[0];
				$kunci = $row_login[2];			
				$branch = $row_login[3];
				$kd_branch = $row_login[4];
				$kd_staff = $row_login[5];					
				$_SESSION['kd_staff']= $row_login[5]; 
				$_SESSION['posisi']= $row_login[6]; 
				$_SESSION['nama_lengkap']= $nama_lengkap; 
				$_SESSION['nama_depan']= $nama_depan; 
				$_SESSION['kunci']= $kunci; 
				$_SESSION['awal_periode']= $awal_periode; 
				$_SESSION['branch']= $branch; 
				$_SESSION['kd_branch']= $kd_branch; 
				$_SESSION['kode_area']= $row_login[7];
				$_SESSION['level_posisi']= $row_login[8];					
				$_SESSION['hari_ini']= $hari_ini;
				$_SESSION['kd_staff'] = $kd_staff;
				$_SESSION['kelompok'] = $row_login[9];					
				$hari_ini = $_SESSION['hari_ini'];	
				$kd_area = $_SESSION['kode_area'];
				if (num($kd_area) == 5){$area ="";}
				elseif(num($kd_area) == 42){$area = " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')";}
				elseif(num($kd_area) == 41){$area = " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')";}
				elseif(num($kd_area) == 31){$area = " and (kd_branch= '1' or kd_branch= '2')";}
				elseif(num($kd_area) == 21) {$area = " and (kd_branch= '2'or kd_branch= '8')";}
				elseif(num($kd_area) == 2){$area = " and kd_branch= '$kd_cbg'";}
				else {$area = " and kd_branch= '$kd_cbg'";}	
				$_SESSION['area']= $area;
				$jamskrg = date("h:i:s");
				$_SESSION['jam_in_log'] = $jamskrg;	
				$query_login_log = q_set($__p_query_login_log, "insert into tb_report_user_login(id_user_log, login_name_log, tgl_in_log, jam_in_log, ip_log) \r
\t\t\t\tvalues(? ,? ,? ,? ,? )", [(string) ($kd_staff), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($jamskrg), (string) ($ip_local)]);
				$resource_login_log = db_query_or_die('errro_1', $query_login_log, $__p_query_login_log ?? []);
//===log activities
				$kegiatan = 'Login';	
				$query_log_aktifitas = q_set($__p_query_log_aktifitas, "insert into tb_log_activities (kd_user, kd_branch, kegiatan, dt_entry, jm_entry,status)\r
\t\t\t\tvalues(? ,? ,? ,? ,? ,'0')", [(string) ($kd_staff), (string) ($kd_branch), (string) ($kegiatan), (string) ($hari_ini), (string) ($jamskrg)]);
				$resource_log_aktifitas = db_query_or_die('errro_log', $query_log_aktifitas, $__p_query_log_aktifitas ?? []);					
//===
				}
			}

        if (num($status_login)==1) 
			{
				if($kelompok == 'ACD'){
					$location_benar = "vip_activities.php";
				}
				elseif($kelompok == 'LIU'){
					$location_benar = "invoicebillist.php";
				} 			
				else
				{ 	$location_benar = "leaderboard.php"; }

				echo "<script type=\"text/javascript\">\n";
				echo "alert('User dan Password Dikenali');\n";
				echo "window.location = ('" . e($location_benar) . "');\n";				
				echo "</script>";	
			}
		else
			{
			echo "<script type=\"text/javascript\">\n";
			echo "alert('Invalid User and Password');\n";
			echo "</script>";					
			}
		}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>V-CMS Login Form</title>
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
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
</head>
<body class="hold-transition login-page" style="background-color:white;">
<div class="col-md-12">	
            <div class="box-header with-border">
              <h1>V-CMS Login Form</h1>
            </div>	
	</div>	
<div class="col-md-6" style="background:url("imgs/vista-logo.png")">
          <!-- general form elements -->


          <!-- /.box -->

          <!-- Form Element sizes -->
          <!-- /.box -->
          <!-- /.box -->

          <!-- Input addon -->
          <!-- /.box -->

        </div>
<div class="col-md-6">
          <!-- general form elements -->
  <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">LOGIN </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                    <form name="frmregister"action="<?php $_SERVER['PHP_SELF'] ?>" method="post" ><?php echo csrf_field(); ?>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="User Login" name="name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="Password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
    </form>
</div>
          <!-- /.box -->

          <!-- Form Element sizes -->
          <!-- /.box -->
          <!-- /.box -->

          <!-- Input addon -->
          <!-- /.box -->

        </div>
	
	<div class="login-box">
  <div class="login-logo"><b>V-CMS</b></div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>


   </div>
</div>

<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
