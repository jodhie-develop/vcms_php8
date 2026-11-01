<?php
				$status_login = 0;
include __DIR__ . "/conndb.php";
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = in_str('name', 100, 'post');
	$OldPassword = in_str('OldPassword', 100, 'post');
	// tb_user.password = varchar(45): password lebih panjang akan terpotong diam-diam.
	$NewPassword = in_str('NewPassword', 45, 'post');
	$NewPasswordAgain = in_str('NewPasswordAgain', 45, 'post');
	 if ($name == '' || $OldPassword == '')
	 	{
        $msg = "You must enter all fields";
    	}
	else
		{
					$status_pwd = 0;
		// Skema password plaintext dipertahankan (keputusan migrasi).
		$row_login = db_row(
			"SELECT no FROM tb_user t WHERE nama_login = ? AND password = ? LIMIT 1",
			[$name, $OldPassword]
		);
		if ($row_login !== null)
			{
			$status_login = 1;
			$kd_staff = $row_login['no'];
			if ($NewPassword !== '' && $NewPassword === $NewPasswordAgain)
				{
				$status_pwd = 1;
				}
        if ($status_login==1 and $status_pwd ==1)
			{
				db_exec("update tb_user set password = ? where no = ?", [$NewPassword, $kd_staff]);
				js_alert('New Password Applied', 'login.php');
			}
			else
				{
			js_alert('New Password doesnt match');
				}
			}
		else
			{
			error_log('Ganti password gagal untuk user ' . $name . ' dari ' . client_ip());
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
  <title>V-CMS Change Password</title>
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
    <p class="login-box-msg">Change Password</p>

    <form name="frmregister"action="" method="post" ><?php echo csrf_field(); ?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="User Login" name="name" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="Password" class="form-control" placeholder="Current Password" name="OldPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="Password" class="form-control" placeholder="New Password" name="NewPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>		
      <div class="form-group has-feedback">
        <input type="Password" class="form-control" placeholder="Repeat New Password" name="NewPasswordAgain" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>		
      <div class="row"><!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
        <div class="col-xs-8">
          <div class="checkbox icheck"><a href="login.php">Login</a></div>
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
