<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_pemohon = $_SESSION['nama_lengkap'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Nama File</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="js-lib/jquery.signature.css" />
        <link rel="stylesheet" href="js-lib/jquery-ui.css" />
        <link rel="stylesheet" href="js-lib/jquery.signature.css" />
        
        <script src="js-lib/jquery.min.js" type="text/javascript" ></script>
        <script src="js-lib/jquery-ui.min.js" type="text/javascript" > </script>
        <script src="js-lib/jquery.signature.js" type="text/javascript" ></script>
        <script src="js-lib/jquery.ui.touch-punch.min.js" type="text/javascript" ></script>
        <style>
            .kbw-signature{
                height: 200px;
                width: 300px;
            }
        </style>
        
        <script>
            $(function(){
                $('#tandatangan').signature({guideline: true});
                
                $('#hapus').click(function(){
                    $('#tandatangan').signature('clear');
                    $('#salinan').signature('clear');
                });
                
                $('#json').click(function(){
                    var pesan = $('#tandatangan').signature('toJSON');
                    alert(pesan);
                });
                
                $('#draw').click(function(){
                    var json = $('#tandatangan').signature('toJSON');
                    $('#salinan').signature('draw', json);
                });
                
                $('#salinan').signature({disabled: true, guideline: true}); 
                
            });
        </script>	
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php // include ('left.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        E-Sign Input</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row"><!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
				  <div class="col-md-12">
              <div class="form-group">
                <label for="exampleInputEmail2">Name</label>
                <input type="text" name="nama_pemohon" class="form-control" id="exampleInputEmail2" placeholder="Your Name" value="<?php echo e($nama_pemohon) ?>" disabled>
              </div>					  
				  </div>
			  <div class="col-md-12">				  
        <div id="tandatangan"></div>
        
        <p>
            <button id="hapus">Hapus</button>
            <button id="json">Format ke JSON</button>
        </p>
        <h3>Tampilan Tanda Tangan</h3>
        <p>
            <button id="draw">Tampil Tanda Tangan</button>
        </p>
        <div id="salinan"></div>
			</div>
			  <div class="col-md-12">
				            <button class="btn" name="simpan" id ="simpan">Simpan</button>
			    </div>

            </div>
              <!-- /.box-body -->

              
          
          </div>
          <!-- /.box -->

          <!-- Form Element sizes --><!-- /.box --><!-- /.box -->

          <!-- Input addon --><!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>	

	
</div>

</body>
</html>
<?php
if (isset($_POST['simpan'])) 
{
$ttd = in_val('salinan', 'post');
}
?>