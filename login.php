<?php
include __DIR__ . "/conndb.php";
include_once __DIR__ . "/user_agent.php";
$ua = new UserAgent();

//if site is accessed from mobile, then redirect to the mobile site.
if($ua->is_mobile()){
$mbl = 1;
}
else
{$mbl = 0;}
$awal_periode = '2023-01-01';
$msg = "";
$status_login = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = in_str('name', 100, 'post');
    $password = in_str('password', 100, 'post');
	 if ($name == '' || $password == '')
	 	{
        $msg = "You must enter all fields";
    	}
	else
		{
		// Skema password lama (plaintext) dipertahankan sesuai keputusan migrasi;
		// perbandingan tetap di SQL agar perilakunya sama dengan versi lama.
		$row_login = db_row(
			"SELECT t.nama_login, t.nama_detail, t.branch, t.kd_branch, no, posisi, kd_area, level_posisi, usergroup, st_quiz, aktif
			 FROM tb_user t WHERE nama_login = ? AND password = ? and (aktif = 'Y' or aktif = 'y') LIMIT 1",
			[$name, $password]
		);
		if ($row_login !== null)
			{
			$status_login = 1;
			auth_login($row_login, $awal_periode, $mbl);
			}

        if ($status_login==1)
			{
			if($_SESSION['kelompok'] == 'ACD')
				{
					$location_benar = "vip_activities.php";
				}
				else
				{
				$location_benar = "leaderboard.php"; }

				js_alert('User dan Password Dikenali', $location_benar);
			}
		else
			{
			error_log('Login gagal untuk user ' . $name . ' dari ' . client_ip());
			js_alert('Invalid User and Password');
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
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"><b>V-CMS</b></div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form name="frmregister"action="" method="post" ><?php echo csrf_field(); ?>
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
        <div class="col-xs-8">
          <div class="checkbox icheck"><a href="chgpwd.php">Change Password</a></div>
        </div>
      </div>
    </form>

     <!-- /.social-auth-links -->

   </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
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
