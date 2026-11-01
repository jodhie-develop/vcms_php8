<?php
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
auth_require_login();
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$nama_lengkap = $_SESSION['nama_lengkap'] ?? '';
$nama_depan = $_SESSION['nama_depan'] ?? '';

$posisi = $_SESSION['posisi'] ?? '';
$level_posisi = $_SESSION['level_posisi'] ?? '';
$kelompok = $_SESSION['kelompok'] ?? '';
// $kd_cbg tidak diisi di sini (sama seperti versi lama): nilainya milik halaman pemanggil.

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista Customer System Management</title>
  <?php echo csrf_script(); ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div> <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../pelem/vista.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo e($nama_lengkap); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="leads.php" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="cari" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
<?php if ($kelompok != 'LIU'){ ?>		
      <ul class="sidebar-menu">
        <li class="active treeview">

<?php //=======sales======= 
if ($kelompok !='ACD' and $posisi !='Admin')
{
?>
        </li>
        <li><a href="../invoicebilllist.php"><i class="fa fa-book"></i> <span>Other Billing</span></a></li>	  
<?php  //============== ves ?>
                  <li class="treeview">
                    <ul class="treeview-menu">			  
                   <li><a href="sales_center.php"><i class="fa fa-book"></i> <span>Enrolled Student</span></a></li>
                          <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Admission</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
  		<li><a href="admission_progress.php"><i class="fa fa-book"></i> <span>Admission Progress</span></a></li>
  		<li><a href="institution_dtl_prblmbystu.php"><i class="fa fa-book"></i> <span>Admission Problem Student</span></a></li>                 
                    <li><a href="institution_leavingbystep.php"><i class="fa fa-circle-o"></i>By Country</a></li>
                    <li><a href="institution_dtl_leavingbystep.php"><i class="fa fa-circle-o"></i>By Institution</a></li>
                    <li><a href="institution_dtl_leavingbystu.php"><i class="fa fa-circle-o"></i>By Student</a></li>   
  		<li><a href="soastatlist.php"><i class="fa fa-book"></i> <span>Admission SOA</span></a></li>                                     
          </ul>
        </li>   
        <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>VES
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i>Sales
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
				</li>
			</ul>
			</li>
			  </ul>
                  
<li><a href="institution.php"><i class="fa fa-book"></i> <span>Institution List</span></a></li>         
<li><a href="inc_lv.php"><i class="fa fa-book"></i> <span>Reward - Leaving</span></a></li>
<li><a href="ves_income.php"><i class="fa fa-book"></i> <span>VES Receipt Summary</span></a></li>                   
          </ul>
        </li>        
        <?php  //============== ?>
<?php  //============== VIP ?>
 <li class="treeview">
   <ul class="treeview-menu">
     
     <li><a href="vip_sales_center.php"><i class="fa fa-book"></i> <span>VE Enrolled Student</span></a></li>
  		<li><a href="vipolive_reg_list.php"><i class="fa fa-book"></i> <span>Olive Registration List</span></a></li>
			  
  		<li><a href="vip_book_distrib.php"><i class="fa fa-book"></i> <span>VE Book Distribution</span></a></li>  		
  		<li><a href="vip_proposed_class.php"><i class="fa fa-book"></i> <span>VE Class Proposed</span></a></li>    		
  		<li><a href="vip_order_list.php"><i class="fa fa-book"></i> <span>VE Meeting Order List</span></a></li>  			  
  		<li><a href="vip_class_list.php"><i class="fa fa-book"></i> <span>VE Class List</span></a></li> 
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>VE Open Class Detail</span></a></li>
<li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>VE Teaching Hour Summary</span></a></li>
<li><a href="vip_outstanding.php"><i class="fa fa-book"></i> <span>VE Outstanding Payment </span></a></li>			  
                  <li><a href="teachercalendar.php"><i class="fa fa-circle-o"></i>VIP Calendar</a></li>                    
        </ul>
        </li>        
        <?php  //============== ?>                     
        <li></li> 
                  <li class="treeview">
                    <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>VOS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i>Sales
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="sales_productivity_form.php"><i class="fa fa-circle-o"></i>By Consultant</a></li>
                    <li><a href="sales.php"><i class="fa fa-circle-o"></i>By Student</a></li> 
                    <li><a href="status.php"><i class="fa fa-circle-o"></i>By Progress</a></li>                                      
                  </ul>
                </li>
              </ul>
              <ul class="treeview-menu">
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i>Admission
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="institution_leavingbystep.php"><i class="fa fa-circle-o"></i>By Country</a></li>
                    <li><a href="institution_dtl_leavingbystep.php"><i class="fa fa-circle-o"></i>By Instituion</a></li> 
                     
                  </ul>
                </li>
              </ul>              
            <ul class="treeview-menu">
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i>Leaving
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="institution_leaving.php"><i class="fa fa-circle-o"></i>By Institution</a></li>
                    <li><a href="leaving.php"><i class="fa fa-circle-o"></i>By Student</a></li>  
                    <li><a href="#"><i class="fa fa-circle-o"></i>By Admission</a></li>                 
                    <li><a href="leavingarea.php"><i class="fa fa-circle-o"></i>By Area</a></li> 
                    <li><a href="institution_leavingbystep.php"><i class="fa fa-circle-o"></i>By Admission Step</a></li> 
                    <li><a href="institution_dtl_leavingbystaff.php"><i class="fa fa-circle-o"></i>By Admission</a></li>
                    <li><a href="institution_dtl_leavingbysc.php"><i class="fa fa-circle-o"></i>By Student Consultant</a></li>                                              
                        
<?php if ($posisi =='AM' or $posisi == 'ACCM')
{?>
<li><a href="institution_leavingbystep.php"><i class="fa fa-book"></i> <span>By Step</span></a></li>
<?php } ?>                                
                  </ul>
                </li>
              </ul>  
         <ul class="treeview-menu">
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i>Cancel
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i>By Consultant</a></li>
                    <li><a href="cancel.php"><i class="fa fa-circle-o"></i>By Student</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Center</a></li>                    
                  </ul>
                </li>
              </ul>              
                          
            </li>
          </ul>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>VE
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
<li><a href="vip_data.php"><i class="fa fa-book"></i> <span>Report List</span></a></li>              
               <li><a href="vip_receipt.php"><i class="fa fa-book"></i> <span>VIP Receipt Summar</span></a></li>
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>VIP Open Class Detail</span></a></li> 
    				  
<?php if ($posisi =='AM')
{?>
<li><a href="vip_sum_receipt.php"><i class="fa fa-book"></i> <span>VIP Summary Income</span></a></li>
<?php } ?>
              </ul>               
                          
            </li>
          </ul>
          <ul class="treeview-menu">
            <li>
              <a href="aktifitas.php"><i class="fa fa-circle-o"></i>Activities
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
             
                          
            </li>
          </ul>               
                </li>

<?php if ($posisi == 'ACCM')
{?>
                  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Accounting & Finance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                                     <li><a href="centersummary.php"><i class="fa fa-circle-o"></i>Center Achievement</a></li>                    
                   <li><a href="commmonitoring.php"><i class="fa fa-circle-o"></i>Commision List</a></li>                 
                  <li><a href="event_commision.php"><i class="fa fa-circle-o"></i>Marketing Invoice List</a></li>
                   <li><a href="inv_event.php"><i class="fa fa-circle-o"></i>Marketing Invoice Form</a></li>
					<li><a href="vip_sales_center.php"><i class="fa fa-circle-o"></i>VE Billing List</a></li>	
					<li><a href="vip_receipt.php"><i class="fa fa-circle-o"></i>VE Receipt List</a></li>
			              <li>
              <a href="#"><i class="fa fa-circle-o"></i>CA
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">           
               <li><a href="../ca_receipt.php"><i class="fa fa-book"></i> <span>CA Receipt Summar</span></a></li>
				<li><a href="../vip_open_class_report_acc.php"><i class="fa fa-book"></i> <span>CA Detail Open Class List</span></a></li>					  
<li><a href="../vip_open_class_report.php"><i class="fa fa-book"></i> <span>CA Open Class Detail</span></a></li> 
				<li><a href="../vip_open_class_report_acc.php"><i class="fa fa-book"></i> <span>CA Open Class List</span></a></li>	
                                   <li><a href="../vip_teacher_free_all.php?tgl_awal=<?php echo e($hari_ini) ?>"><i class="fa fa-book"></i> <span>Teachers Availability Calendar</span></a></li> 		
              </ul>               
                          
            </li>			  
				<li><a href="ca_acc_receipt.php"><i class="fa fa-circle-o"></i>CA Receipt List</a></li>			  
					<li><a href="acc_ves_pf.php"><i class="fa fa-circle-o"></i>VOS Receipt List</a></li>
					<li><a href="acc_vos_other_payment.php"><i class="fa fa-circle-o"></i>VOS Other Receipt List</a></li>			  
					<li><a href="vip_refund.php"><i class="fa fa-circle-o"></i>VE Refund</a></li>  
					<li><a href="ca_refund.php"><i class="fa fa-circle-o"></i>CA Refund</a></li>  
	<li><a href="fa_refund.php"><i class="fa fa-circle-o"></i>FA Refund</a></li>  		  
					<li><a href="vip_outstanding.php"><i class="fa fa-circle-o"></i>VE Outstanding Payment</a></li>         			  
					<li><a href="vip_sum_receipt.php"><i class="fa fa-circle-o"></i>VIP Inc Sum by Week</a></li> 
					<li><a href="../vip_openclass_report.php"><i class="fa fa-circle-o"></i>VIP Open Class by Week</a></li> 			  
				<li><a href="../vip_receipt_report_center.php"><i class="fa fa-circle-o"></i>VIP Report 23 / 24</a></li> 			  
				<li><a href="../vip_open_class_report_accounting.php"><i class="fa fa-book"></i> <span>VE Sales Open Class Payment Detail</span></a></li> 
				<li><a href="../vip_receipt_daily.php" target="_blank"><i class="fa fa-book"></i> <span>VIP Daily Report</span></a></li> 
				<li><a href="../tbi_receipt_daily.php" target="_blank"><i class="fa fa-book"></i> <span>TBI Daily Report</span></a></li> 
				<li><a href="../vossf_receipt_daily.php" target="_blank"><i class="fa fa-book"></i> <span>VOS Receipt Daily Report</span></a></li> 			  
			  
<li><a href="../vip_open_class_report_acc.php"><i class="fa fa-book"></i> <span>VE Academic Open Class</span></a></li>
<li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>VE Teaching Hour Summary</span></a></li>				 					
					<li><a href="ves_pf.php"><i class="fa fa-circle-o"></i>VOS Proff Fee Sum</a></li> 
					<li><a href="ves_deposit.php"><i class="fa fa-circle-o"></i>VOS Deposit Sum</a></li> 			  
					<li><a href="soastatlist.php"><i class="fa fa-circle-o"></i>Admission SOA</a></li>   
					<li><a href="invoicebilllistaccounting.php"><i class="fa fa-circle-o"></i>Other Payment List</a></li>  		
					<li><a href="../book_inventory.php"><i class="fa fa-circle-o"></i>Asset Management</a></li>	
				 <li><a href="ve_inc_list_accounting.php"><i class="fa fa-circle-o"></i>VE Incentive Claim</a></li>
				 <li><a href="vos_inc_list_accounting.php"><i class="fa fa-circle-o"></i>VOS Incentive Claim</a></li>	
				 <li><a href="liu_inc_list_view.php"><i class="fa fa-circle-o"></i>LIU Incentive List</a></li> 			  
				 <li><a href="purchasingorder.php"><i class="fa fa-circle-o"></i>Purchase Order Listedd</a></li>	
			  				            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
            </span>
			  
          </ul>
        </li> 
<?php } ?>
<?php if ($kd_cbg==8){?>
<li></li>  
                    <?php       }?>     



	
<?php  //===end sales === 
}?>
 <?php //=======Admin======= 
if ($posisi =='Admin' or $nama_lengkap == 'Ragel Suma Wijaya' or $nama_lengkap == 'laura natalia')
{?>
                  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Admin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
				<li><a href="invoicebilllist.php"><i class="fa fa-book"></i> <span>Other Billing List</span></a></li> 			  
				<li><a href="ves_sales_center.php"><i class="fa fa-book"></i> <span>VOS Payment</span></a></li> 
				<li><a href="invoicebill.php?asal=1"><i class="fa fa-book"></i> <span>VOS Bakat Minat</span></a></li> 
			  
				<li><a href="soastatlist.php"><i class="fa fa-book"></i> <span>SOA Form</span></a></li> 				
				<li><a href="vip_sales_center.php"><i class="fa fa-book"></i> <span>VE Payment</span></a></li> 
				<li><a href="vip_refund_admin.php"><i class="fa fa-book"></i> <span>VE Refund List</span></a></li> 			  
				<li><a href="#"><i class="fa fa-book"></i> <span>VPro Payment</span></a></li> 
				<li><a href="#"><i class="fa fa-book"></i> <span>Other Payment</span></a></li> 				  				    
					  </ul>                                             
            </li>
                  <li class="treeview">
          <a href="#">
   
            <i class="fa fa-share"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                                             
          </a>

          <ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-book"></i> <span>VES Income</span></a></li> 
				<li><a href="vip_outstanding.php"><i class="fa fa-book"></i> <span>VE Outstanding List</span></a></li>			  
				<li><a href="vip_receipt.php"><i class="fa fa-book"></i> <span>VIP Income</span></a></li>
				<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>VIP Sales Open Class Payment Detail</span></a></li> 
<li><a href="vip_open_class_report_acd.php"><i class="fa fa-book"></i> <span>VIP Academic Open Class</span></a></li> 				
				 
				<li><a href="#"><i class="fa fa-book"></i> <span>VPro Income</span></a></li> 
				<li><a href="#"><i class="fa fa-book"></i> <span>Other Income</span></a></li>
				<li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>Teaching Hour Summary</span></a></li> 			  			  				     	
				  			  				    
					  </ul>                                             
            </li>                	
                 <?php } ?>  
                  <li class="treeview">
          <a href="#">
   
            <i class="fa fa-share"></i> <span>Academic</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                                   <li><a href="dashboard.php"><i class="fa fa-book"></i> <span>Dashboard</span></a></li> 
                                   <li><a href="entryactteac.php"><i class="fa fa-book"></i> <span>My Agenda</span></a></li> 
                                   <li><a href="vip_activities.php"><i class="fa fa-book"></i> <span>My Activities</span></a></li>   
<?php if ($nama_lengkap =='Nicko Putra Witjatmoko') {?>          
		<li><a href="vpro_sales_center.php"><i class="fa fa-book"></i> <span>V-PRO Billing Statement</span></a></li> 
<?php } ?> 	                                                                    
                  <li><a href="vip_data.php"><i class="fa fa-book"></i> <span>Report List</span></a></li> 
                  <?php if (($_SESSION['kelompok'] =='ACD' and $_SESSION['kd_branch']== '0') or $_SESSION['posisi']== 'AS' or $_SESSION['posisi'] =='CM') {?>
                   <li><a href="entrydata.php"><i class="fa fa-circle-o"></i>Open Class Form</a></li>
                <?php } if (($_SESSION['kelompok'] =='ACD' and $_SESSION['kd_branch']== '0') or $_SESSION['posisi']== 'AS' or $_SESSION['posisi'] =='CM'  or $_SESSION['posisi'] =='FTT') {?>?>
                   <li><a href="inpuevent.php"><i class="fa fa-circle-o"></i>Teachers Detail Record</a></li> 
                     
  		<li><a href="vip_class_list.php"><i class="fa fa-book"></i> <span>VIP Class List</span></a></li> 
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>VIP Sales Class Detail</span></a></li>
<li><a href="vip_open_class_report_acd.php"><i class="fa fa-book"></i> <span>VIP Academic Open Class</span></a></li>     
<li><a href="vip_order_check.php"><i class="fa fa-book"></i> <span>VIP Order Management</span></a></li>
<li><a href="vipbook.php"><i class="fa fa-book"></i> <span>VIP Material Management</span></a></li>
                                   <li><a href="vip_mst_form.php"><i class="fa fa-book"></i> <span>Scope Sequence Upload</span></a></li>         				<li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>Teaching Hour Summary</span></a></li>                          
                               
       <?php } ?>
                  <li><a href="rulesmemo.php"><i class="fa fa-circle-o"></i>Rules and Interofice Memo</a></li> 			  
                  <li><a href="teachercalendar.php"><i class="fa fa-circle-o"></i>Calendar</a></li> 
<?php if (($_SESSION['kelompok'] =='ACD' and $_SESSION['kd_branch']== '0') or $_SESSION['posisi']== 'AS') {?>                    
<li><a href="vip_file_browser.php"><i class="fa fa-book"></i> <span>File</span></a></li>                           
                 <?php } ?>                                       
            </li>      
    
          </ul>
        </li>
<?php } else {?>
      <ul class="sidebar-menu">
                  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>LIU Leads </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                  <li><a href="newleads.php"><i class="fa fa-circle-o"></i>New LIU Leads Input</a></li>
                   <li><a href="leads.php?q=3"><i class="fa fa-circle-o"></i>LIU Leads</a></li>
            <li>
                                         
            </li>
          </ul>
        </li> 
        <li><a href="invoicebillliu.php?test=2"><i class="fa fa-book"></i> <span>Other Billing</span></a></li>			  
	</ul>		  
<?php } ?>	
<?php //===end of academic } ?>	  
<li><a href="logout.php"><i class="fa fa-book"></i> <span>Log Out</span></a></li>     
      </ul>
      
    </section>
    <!-- /.sidebar -->
  </aside>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jQueryUI/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="../plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
