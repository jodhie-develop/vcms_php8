<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$no = in_val('no', 'get');
$kd_branch = $_SESSION['kd_branch'];
$user = in_val('user', 'get');
$query = q_set($__p_query, "SELECT kd_branch,  buku FROM ves_data.vipbookin where no = ? ", [(string) ($no)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$kd = $row[0];
	if ($kd=='1') ($storage ='East Sby');
	elseif ($kd=='2')($storage ='West Sby');
	elseif ($kd=='3')($storage ='Denpasar');
	elseif ($kd=='8')($storage ='Malang');
	elseif ($kd=='4')($storage ='South Jkt');
	elseif ($kd=='5')($storage ='North Jkt');
	elseif ($kd=='6')($storage ='West Jkt');
	elseif ($kd=='7')($storage ='Bandung');
	elseif ($kd=='10')($storage ='HO');
		$buku = $row[1];
		}
	}
$query_jml_out = q_set($__p_query_jml_out, "SELECT sum(jml_out) FROM vipbookout where buku = ? and kd_branch = ? group by buku", [(string) ($buku), (string) ($kd)]);
$resource_jml_out = db_query_or_die('errro_7', $query_jml_out, $__p_query_jml_out ?? []);
while ($row_jml_out=  db_fetch($resource_jml_out, PDO::FETCH_NUM))
{
$total_out = $row_jml_out[0];
}
$query_jml_in = q_set($__p_query_jml_in, "SELECT sum(jml_in) FROM vipbookin where buku = ? and kd_branch = ? group by buku", [(string) ($buku), (string) ($kd)]);
$resource_jml_in = db_query_or_die('errro_7', $query_jml_in, $__p_query_jml_in ?? []);
while ($row_jml_in=  db_fetch($resource_jml_in, PDO::FETCH_NUM))
{
$total_in = $row_jml_in[0];
}
$stock = num($total_in) - num($total_out);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista Customer System Management</title>
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
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php //  include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->
  <form name="myform" id="myform">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3>VIP Book Management<br>
	</h3>
	<div class="col-md-8">
	  <div class="form-group">
	    <label>Center Storage</label>
	    <select class="form-control" name="storage" >
	      <option selected><?php echo e($storage) ?></option>
	      </select>
	    </div>
	  </div>
	<div class="col-md-10">
	  <div class="form-group">
	    <label>Book Name</label>
	    <select class="form-control" name="nm_book">

	      <option selected><?php echo  e($buku); ?></option>
	      </select>
	    </div>
	  </div>
	<h3>&nbsp; </h3>
    <div class="col-md-10">
      <div class="form-group">
        <label>Book Stock : <?php echo  e($stock) ?> </label>

      </div>
    </div>
</div>
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

<div class="col-md-12"><div class="box box-warning">		
<div class="box-body">
			  <div class="col-md-6"><label>Total Book IN : <?php echo e($total_in) ?></label>
			    <table width="100%" class="table table-bordered table-striped" id="example2">
			      <tbody>
          <tr>
            <td width="6%" height="14" align=center class="style24">No</td>
            <td width="55%" align=center class="style24">Source</td>
            <td width="39%" align=center class="style24">Date</td>
            <td width="39%" align=center class="style24">Count</td>
            <td width="39%" align=center class="style24">Delete</td>
            </tr>
        <?php
	$no_urut = 1;

$query_list_book = q_set($__p_query_list_book, "SELECT source, dt_in, jml_in,no FROM vipbookin where buku = ? and kd_branch = ? order by dt_in desc", [(string) ($buku), (string) ($kd)]);
$resource_list_book = db_query_or_die('errro_7', $query_list_book, $__p_query_list_book ?? []);
while ($row_list_book=  db_fetch($resource_list_book, PDO::FETCH_NUM))
{ 
	if ($row_list_book[0]=='1') ($source ='East Sby');
	elseif ($row_list_book[0]=='2')($source ='West Sby');
	elseif ($row_list_book[0]=='3')($source ='Denpasar');
	elseif ($row_list_book[0]=='8')($source ='Malang');
	elseif ($row_list_book[0]=='4')($source ='South Jkt');
	elseif ($row_list_book[0]=='5')($source ='North Jkt');
	elseif ($row_list_book[0]=='6')($source ='West Jkt');
	elseif ($row_list_book[0]=='7')($source ='Bandung');
	elseif ($row_list_book[0]=='10')($source ='HO');		
?>
          <tr>
            <td height="14" align=center class="style24"><?php echo e($no_urut);  ?></td>
            <td align=left class="style24"><?php echo e($source)  ?></td>
            <td align=center class="style24"><?php echo e($row_list_book[1])  ?></td>
            <td align=center class="style24"><?php echo e($row_list_book[2])  ?></td>
            <td align=center class="style24"><a href="vipbook_del.php?no=<?php echo  e(u($row_list_book[3])); ?>&st=1" 
												target="_parent">Delete</a></td>
            </tr>
            <?php  $no_urut = num($no_urut) +1 ;} ?>

        <tfoot>
        </tfoot>
    </table>
<br>
      </div>

			  <div class="col-md-6"> <label>Total Book OUT : <?php echo e($total_out) ?></label>
			    <table width="100%" class="table table-bordered table-striped" id="example">
			      <tbody>
			        <tr>
			          <td width="6%" height="14" align=center class="style24">No</td>
			          <td width="55%" align=center class="style24">User</td>
			          <td width="39%" align=center class="style24">Date</td>
			          <td width="39%" align=center class="style24">Count</td>
			          <td width="39%" align=center class="style24">Delete</td>
		            </tr>
			        <?php
	$no_urut = 1;
					  
$query_list_book = q_set($__p_query_list_book, "SELECT pengguna, dt_out, jml_out,no FROM vipbookout where buku = ? and kd_branch = ? order by dt_out desc", [(string) ($buku), (string) ($kd)]);
$resource_list_book = db_query_or_die('errro_7', $query_list_book, $__p_query_list_book ?? []);
while ($row_list_book=  db_fetch($resource_list_book, PDO::FETCH_NUM))
{ 
	if ($row_list_book[0]=='1') ($pengguna ='East Sby');
	elseif ($row_list_book[0]=='2')($pengguna ='West Sby');
	elseif ($row_list_book[0]=='3')($pengguna ='Denpasar');
	elseif ($row_list_book[0]=='8')($pengguna ='Malang');
	elseif ($row_list_book[0]=='4')($pengguna ='South Jkt');
	elseif ($row_list_book[0]=='5')($pengguna ='North Jkt');
	elseif ($row_list_book[0]=='6')($pengguna ='West Jkt');
	elseif ($row_list_book[0]=='7')($pengguna ='Bandung');
	elseif ($row_list_book[0]=='10')($pengguna ='HO');	
	elseif ($row_list_book[0]=='Student')($pengguna ='Student');	
?>
			        <tr>
			          <td height="14" align=center class="style24"><?php echo e($no_urut);  ?></td>
			          <td align=left class="style24"><?php echo e($pengguna)  ?></td>
			          <td align=center class="style24"><?php echo e($row_list_book[1])  ?></td>
			          <td align=center class="style24"><?php echo e($row_list_book[2])  ?></td>
			          <td align=center class="style24"><a href="vipbook_del.php?no=<?php echo  e(u($row_list_book[3])); ?>&st=2" 
														  target="_parent">Delete</a></td>
		            </tr>
			        <?php  $no_urut = num($no_urut) +1 ;} ?>
		          <tfoot>
		          </tfoot>
		        </table>
			    <br>
      </div>
</div>
		</div>
</div>
<div class="box-body"></div>
<div class="box-body"></div>
</form>
</body>
</html>