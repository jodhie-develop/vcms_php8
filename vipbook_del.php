<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();  
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$st = in_val('st', 'any'); 
$no = in_val('no', 'any'); 
if(num($st) ==1)
	{
	$query_list_book = q_set($__p_query_list_book, "SELECT source, dt_in, jml_in,buku, no FROM vipbookin where no = ? ", [(string) ($no)]);
	}
else
	{
	$query_list_book = q_set($__p_query_list_book, "SELECT pengguna, dt_out, jml_out,buku, no FROM vipbookout where no = ? ", [(string) ($no)]);
	}
/* echo $query_list_book (debug SQL versi lama) dihapus */
$resource_list_book = db_query_or_die('errro_7', $query_list_book, $__p_query_list_book ?? []);
while ($row_list_book=  db_fetch($resource_list_book, PDO::FETCH_NUM))
	{
		
	$source = $row_list_book[0];
	$datein = $row_list_book[1];
	$amount = $row_list_book[2];
	$buku = $row_list_book[3];
		
		
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
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>


  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Book  Delete</h1>
    </section>
    <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<p><?php echo e($buku) ?>
<div class="box-body">
  <p><?php 
	if (num($st)==1)
	{ ?>
   	Source : <?php echo e($source) ?>
   	<?php } else {?>
	User : <?php echo e($source) ?>
   <?php } ?><br>
    Date In : <?php echo e($datein) ?><br>
    Unit :<?php echo e($amount) ?>
  </p>
</div>
</p><div class="box box-warning">
  </p>
  <div class="box-body"></div>

<div class="box box-warning">
<div class="box-header with-border"><strong>Are you sure to delete </strong>
  <input type="text" name="no" id="textfield" value="<?php echo e($no) ?>" hidden="">
  <input type="text" name="st" id="textfield2" value="<?php echo e($st) ?>" hidden="">
  <input type="submit" name="Submit" value="YES" />
</div>
<div class="box-body"></div>
</form>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
include __DIR__ . "/conndb.php";
$no = in_val('no', 'any');
$st = in_val('st', 'any');
if(num($st) == 1)
{
$query_hapus = q_set($__p_query_hapus, "delete FROM ves_data.vipbookin where no = ? ", [(string) ($no)]); 
}
else
{
$query_hapus = q_set($__p_query_hapus, "delete FROM ves_data.vipbookout where no = ? ", [(string) ($no)]); 
}
	
$resource_simpan= db_query_or_die('errro_simpan1', $query_hapus, $__p_query_hapus ?? []);

echo "<script type=\"text/javascript\">\n";
echo "window.opener.location.reload(true);\n";
echo "window.close(); \n";	
echo "</script>";	
}


?>
