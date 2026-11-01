<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$asal = in_val('asal', 'get');
$browser = in_val('browser', 'get');

if ($browser !='')
	{
	if (num($asal) == 1)
	{
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('invoicebill.php?kdb=" . e(u($browser)) . "&asal=" . e(u($asal)) . "');\n";				
		echo "</script>";
	}
	else if (num($asal) == 9)
			{
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('invoicebillliu.php?kdb=" . e(u($browser)) . "&asal=" . e(u($asal)) . "');\n";				
		echo "</script>";
	}
	}
else
{
	$dpt_kode = in_val('kode_biodata', 'get');
}

//==============list student
$query_student = q_set($__p_query_student, "SELECT kd_biodata,concat_ws('',nama, middle_name, family_name) FROM ves_inc.tb_biodata where dt_entry > '2019-01-01' and kd_branch = ? order by nama", [(string) ($kdcbg)]);

$resource_student= db_query_or_die('errro_8', $query_student, $__p_query_student ?? []);
$keluar_student= db_num_rows($resource_student);
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
		{
		$kd_biodata= $row_student[0];				
		$nama= $row_student[2];		
		$enroll_date = $row_student[1];	
		$student_lengkap ="$nama";
		//$list_student.="<OPTION VALUE=\"$student_lengkap\">".$kd_biodata;
		$list_student.="<OPTION VALUE=\"" . e($kd_biodata) . "&ed=" . e(u($enroll_date)) . "\">".e($student_lengkap)." ".e($enroll_date);			
		}
	}

//====================

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

<body class="hold-transition skin-blue sidebar-mini">

<?php   //  include __DIR__ . "/left.php";	 ?>  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
      <h3>Student List</h3>
		 </div></div>
    </section>
 <form method=GET> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="get">


	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-body">
			  <div class="col-md-8">
					<div class="form-group">
					  <label>Student Name</label>
  <input type="hidden" name="asal" value="<?php echo e($asal) ?>">
					  (Press Enter after click the name choosen)
					  <input list="browsers" name="browser"  class="form-control" onchange="this.form.submit()" >
					
  						<datalist id="browsers">
     						<option value= ><?php echo $list_student ?>
  						</datalist>										  
					</div>				
				</div>
			  <div class="col-md-2">
			    <div class="form-group">
			      <label></label>
			      
			      <input name="Display" type="submit" id="Display"  class="form-control"  value="Next" />

		        </div>
		      </div>
			</div>
		</div>
	</div>
	  </form> 

</body>
</html>
<?php 
if (isset($_GET['Display'])) 
	{
		$kdb = in_val('browser', 'get');
		$asal = in_val('asal', 'get');	
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('invoicebill.php?kdb=" . e(u($kdb)) . "&asal=" . e(u($asal)) . "');\n";				
		echo "</script>";
	}
?>