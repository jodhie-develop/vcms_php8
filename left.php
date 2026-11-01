<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
auth_require_login();

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

if (!isset($date_end) || $date_end ==''){$jdate_end = $hari_ini;}
$nama_lengkap = $_SESSION['nama_lengkap'] ?? '';
$nama_depan = $_SESSION['nama_depan'] ?? '';
$mbl = $_SESSION['mbl'] ?? 0;
$posisi = $_SESSION['posisi'] ?? '';
$level_posisi = $_SESSION['level_posisi'] ?? '';
$kelompok = $_SESSION['kelompok'] ?? '';
$cabang = $_SESSION['branch'] ?? '';
// $kd_cbg sengaja TIDAK diisi di sini: versi lama memakai nilai milik halaman pemanggil
// (bisa kosong), dan halaman pemanggil memakai variabel yang sama untuk query sesudahnya.
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
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">


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
          <img src="pelem/vista.png" class="img-circle" alt="User Image">
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

<?php //=======sales======= 
if ($kelompok !='ACD' and $posisi !='Admin')
{
?>        <li class="active treeview">
      <?php if ($cabang !='CA'){?>
           <a href="workingcalendar.php">
			  <i class="fa fa-book"></i><span>Scheduler</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>  
          <a href="dashboard.php">
			  <i class="fa fa-book"></i><span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
<?php } ?>			
        </li>

        <?php  //============== ?>
                  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Leads</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                  <li><a href="newleads.php"><i class="fa fa-circle-o"></i>New Leads Input</a></li>
                   <li><a href="leads.php?q=3"><i class="fa fa-circle-o"></i>Leads</a></li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>Today Activities
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                    <li><a href="leads.php?q=0"><i class="fa fa-circle-o"></i>Non Appointment</a></li>
                    <li><a href="leads.php?q=1"><i class="fa fa-circle-o"></i>Appointment</a></li> 
                    <li><a href="leads.php?q=2"><i class="fa fa-circle-o"></i>Outstanding</a></li>
              </ul> 
                   <?php if ($kd_cbg==8){?>
                    <li><a href="ptschedule.php"><i class="fa fa-circle-o"></i>Malang Placement Test</a></li>  
                    <?php       }?>                                          
            </li>
          </ul>
        </li>        
        <?php  //============== ?>

        <li><a href="invoicebilllist.php"><i class="fa fa-book"></i> <span>Other Billing</span></a></li>
<?php if ( $nama_lengkap == 'Levinia Aldora Susmono' or $nama_lengkap == 'lanni susanti'){?>
<li><a href="csr_ves_pf.php"><i class="fa fa-book"></i> <span>CSR</span></a>	</li> 	  	  
<?php  }	?>	  
	  <?php if ( $posisi == 'ACCM'){?>
<li><a href="purchasinglist.php"><i class="fa fa-book"></i> <span>Purchasing</span></a>	</li> 	  	  
<?php  } else {?>	
<?php if ($mbl == 1)
{ ?>
<li><a href="mob_purchasinglist.php"><i class="fa fa-book"></i> <span>Purchasing</span></a>	</li> 
<?php } else { ?>
<li><a href="purchasinglist.php"><i class="fa fa-book"></i> <span>Purchasing</span></a>	</li> 	  
<?php } ?>	  
<?php } ?>	  
	  
	  
<!-- VPRO Only -->
<?php if ($nama_lengkap == 'Dola Restiana' or $nama_lengkap == 'irany citraningrum'  or $nama_lengkap == 'Maria Fransisca Kristina Dewi'  or ($nama_lengkap == 'jimmy' and $cabang !='CA'))	{?>  
                  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>VPRO</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">			  
                   <li><a href="vpro_leads.php"><i class="fa fa-book"></i> <span>Leads</span></a></li>
<li><a href="#"><i class="fa fa-book"></i> <span>Invoicing</span></a></li>                     
<li><a href="#"><i class="fa fa-book"></i> <span>Report</span></a></li>         
<li><a href="#"><i class="fa fa-book"></i> <span>Incentive</span></a></li>
                 
          </ul>
        </li> 	
<?php } ?>	  
	  
      <?php if ($cabang !='CA'){?>	
                  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>VOS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
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
  		<li><a href="admission_order_new.php"><i class="fa fa-book"></i> <span>Interview Order</span></a></li>			  
  		<li><a href="admission_progress.php"><i class="fa fa-book"></i> <span>Admission Progress</span></a></li>
  		<li><a href="monitoring_admission.php"><i class="fa fa-book"></i> <span>Weekly Student Progress</span></a></li>			  
  		<li><a href="institution_dtl_prblmbystu.php"><i class="fa fa-book"></i> <span>Admission Problem Student</span></a></li>                 
                    <li><a href="institution_leavingbystep.php"><i class="fa fa-circle-o"></i>By Country</a></li>
                    <li><a href="institution_dtl_leavingbystep.php"><i class="fa fa-circle-o"></i>By Institution</a></li>
                    <li><a href="institution_dtl_leavingbystu.php"><i class="fa fa-circle-o"></i>By Student</a></li>   
  		<li><a href="soastatlist.php"><i class="fa fa-book"></i> <span>Admission SOA</span></a></li>   
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i>Pemutakhiran Data
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="adm_sc_assign.php"><i class="fa fa-circle-o"></i>SC Handling Assignment</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Last Update & Status</a></li>
                  </ul>
                </li>   			  
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
<li><a href="carry_on_student.php"><i class="fa fa-book"></i> <span>VOS Carry On Student List</span></a></li>                     
<li><a href="institution.php"><i class="fa fa-book"></i> <span>Institution List</span></a></li>         
<li><a href="inc_lv.php"><i class="fa fa-book"></i> <span>Reward - Leaving</span></a></li>
<li><a href="ves_pf.php"><i class="fa fa-book"></i> <span>VES Receipt Summary</span></a></li>                   
          </ul>
        </li>        
        <?php } ?>
<?php  //============== VE ?>

<?php if ($nama_lengkap == 'Debora Mboeik') {?>
<li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>FELLOWS ACADEMY</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
	
  		<li><a href="vip_sales_center.php"><i class="fa fa-book"></i> <span>FA Enrolled Student</span></a></li>
                                   <li><a href="vip_teacher_free_all.php?tgl_awal=<?php echo e($hari_ini) ?>"><i class="fa fa-book"></i> <span>Teachers Availability</span></a></li> 					  <?php if($nama_lengkap =='sabrina marchella'){?>   		<li><a href="entryact.php"><i class="fa fa-book"></i> <span>Teacher Booking</span></a></li><?php }?>
  		<li><a href="vipolive_reg_list.php"><i class="fa fa-book"></i> <span>Olive Registration List</span></a></li>
	  		<li><a href="vip_pt_record.php"><i class="fa fa-book"></i> <span>FA PT Score</span></a></li> 		
	  		<li><a href="vip_pt_list.php"><i class="fa fa-book"></i> <span>FA PT Student List</span></a></li> 				    		
  		<li><a href="vip_order_list.php"><i class="fa fa-book"></i> <span>FA Meeting Order List</span></a></li> 
	  
  		<li><a href="vip_class_list.php"><i class="fa fa-book"></i> <span>FA Class List</span></a></li> 
  		<li><a href="vip_student_record.php"><i class="fa fa-book"></i> <span>FA Student Record</span></a></li> 	
	  
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>FA Open Class Detail</span></a></li>
<li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>FA Teaching Hour Summary</span></a></li>
<li><a href="vip_outstanding.php"><i class="fa fa-book"></i> <span>FA Outstanding Payment </span></a></li>	
			  
                  <li><a href="teachercalendar.php"><i class="fa fa-circle-o"></i>FA Calendar</a></li>                    
          </ul>
        </li>	  
<?php }else { ?>	  
 <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>CA</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
	
  		<li><a href="ca_invoicelist.php"><i class="fa fa-book"></i> <span>Invoice List</span></a></li>
                  <li><a href="accnt/ca_sales_center.php?kd_cbg=15"><i class="fa fa-circle-o"></i>SOA</a></li>  
<li><a href="vip_ca_outstanding.php"><i class="fa fa-book"></i> <span>CA-WSC Outstanding Payment </span></a></li>			  
                  <li><a href="ca_teachercalendar"><i class="fa fa-circle-o"></i>CA Calendar</a></li>                    
          </ul>
        </li>  	  
 <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>VIP</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
	
  		<li><a href="vip_sales_center.php"><i class="fa fa-book"></i> <span>VIP Enrolled Student</span></a></li>
                                   <li><a href="vip_teacher_free_all.php?tgl_awal=<?php echo e($hari_ini) ?>"><i class="fa fa-book"></i> <span>Teachers Availability</span></a></li> 					  <?php if($nama_lengkap =='sabrina marchella'){?>   		<li><a href="entryact.php"><i class="fa fa-book"></i> <span>Teacher Booking</span></a></li><?php }?>
  		<li><a href="vipolive_reg_list.php"><i class="fa fa-book"></i> <span>Olive Registration List</span></a></li>
	  		<li><a href="vip_pt_record.php"><i class="fa fa-book"></i> <span>VIP PT Score</span></a></li> 		
	  		<li><a href="vip_pt_list.php"><i class="fa fa-book"></i> <span>VIP PT Student List</span></a></li> 				  
  		<li><a href="vip_book_distrib.php"><i class="fa fa-book"></i> <span>VIP Book Distribution</span></a></li>
  		<li><a href="book_inventory_sc.php"><i class="fa fa-book"></i> <span>VIP Book Stock</span></a></li> 			  
  		<li><a href="vip_proposed_class.php"><i class="fa fa-book"></i> <span>VIP Class Proposed</span></a></li>    		
  		<li><a href="vip_order_list.php"><i class="fa fa-book"></i> <span>VIP Meeting Order List</span></a></li> 
	  
  		<li><a href="vip_class_list.php"><i class="fa fa-book"></i> <span>VIP Class List</span></a></li> 
  		<li><a href="vip_student_record.php"><i class="fa fa-book"></i> <span>VIP Student Record</span></a></li> 	
	  
			  
			  
     		<li><a href="vip_class_list_lc.php?kd_cbg=100&kelas_name=LCSTBY"><i class="fa fa-book"></i> <span>LC Standby Registration</span></a></li> 			 <li><a href="vip_lc_recomendation.php"><i class="fa fa-book"></i> <span>LC Recommendation List</span></a></li> 	  
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>VIP Open Class Detail</span></a></li>
<li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>VIP Teaching Hour Summary</span></a></li>
<li><a href="vip_outstanding.php"><i class="fa fa-book"></i> <span>VIP Outstanding Payment </span></a></li>	
			  
                  <li><a href="teachercalendar.php"><i class="fa fa-circle-o"></i>VIP Calendar</a></li>                    
          </ul>
        </li>    
<?php } ?>	  
<?php //=== ve ?>
	  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Incentive</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
	
  		<li><a href="ve_inc_list.php"><i class="fa fa-book"></i> <span>VE</span></a></li>
      <?php if ($cabang !='CA'){?>				  
  		<li><a href="vos_inc_list.php"><i class="fa fa-book"></i> <span>VOS Sales</span></a></li>
  		<li><a href="tbi_inc_list.php"><i class="fa fa-book"></i> <span>TBI Sales</span></a></li> 
<?php } ?>			  
<?php if ($nama_lengkap=='jimmy'){?>
  		<li><a href="liu_inc_approval.php"><i class="fa fa-book"></i> <span>Marketing Incentive</span></a></li>			  
<?php }?>			  
  		<li><a href="#"><i class="fa fa-book"></i> <span>VOS Leaving</span></a></li>
  		<li><a href="#"><i class="fa fa-book"></i> <span>VTalent</span></a></li>
<?php if ($posisi == 'CM' or $posisi == 'AM'){  ?>			
  		<li><a href="ve_inc_list_claim.php"><i class="fa fa-book"></i> <span>VE Approval</span></a></li>
  		<li><a href="vos_inc_list_claim.php"><i class="fa fa-book"></i> <span>VOS Approval</span></a></li>			
<?php } ?>			
          </ul>
        </li>          
      <?php if ($cabang !='CA'){?>	                
        <li><a href="centersummary.php"><i class="fa fa-book"></i> <span>Center Achievement</span></a></li>       <?php }?>	
                  <li class="treeview">

          <a href="#">
            <i class="fa fa-share"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
      <?php if ($cabang != 'CA') {?>						  
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
      <?php }?>						  
          <ul class="treeview-menu">
      <?php if ($cabang != 'CA') {?>			  
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>FELLOWS ACADEMY
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu"> 
<li><a href="vip_rpt_payment_detail.php?branch_filter=All&program_filter=Fellows+Academy" target="_blank"><i class="fa fa-book"></i> <span>FA Receipt</span></a></li>   
<li><a href="vip_rpt_open_class.php??branch_filter=All&program_filter=Fellows+Academy" target="_blank"><i class="fa fa-book"></i> <span>FA Open Class</span></a></li>   				  				  
    				  
<?php if ($posisi =='AM')
{?>
<li><a href="vip_sum_receipt.php"><i class="fa fa-book"></i> <span>VE Summary Income</span></a></li>
<?php } ?>
              </ul>               
                          
          </li><?php } ?>			  
      <?php if ($cabang != 'CA') {?>			  
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>VIP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
<li><a href="vip_data.php"><i class="fa fa-book"></i> <span>Report List</span></a></li>   
<li><a href="vip_rpt_payment_detail.php?branch_filter=All&program_filter=Fellows+Academy" target="_blank"><i class="fa fa-book"></i> <span>FA Receipt</span></a></li>   
<li><a href="vip_rpt_open_class.php??branch_filter=All&program_filter=Fellows+Academy" target="_blank"><i class="fa fa-book"></i> <span>FA Open Class</span></a></li>   				  
               <li><a href="vip_receipt.php"><i class="fa fa-book"></i> <span>VE Receipt Summar</span></a></li>
				<li><a href="vip_open_class_report_acc.php"><i class="fa fa-book"></i> <span>VE Detail Open Class List</span></a></li>					  
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>VE Open Class Detail</span></a></li> 
				<li><a href="vip_open_class_report_acc.php"><i class="fa fa-book"></i> <span>VE Open Class List</span></a></li>	
                                   <li><a href="vip_teacher_free_all.php?tgl_awal=<?php echo e($hari_ini) ?>"><i class="fa fa-book"></i> <span>Teachers Availability Calendar</span></a></li> 				  
    				  
<?php if ($posisi =='AM')
{?>
<li><a href="vip_sum_receipt.php"><i class="fa fa-book"></i> <span>VE Summary Income</span></a></li>
<?php } ?>
              </ul>               
                          
          </li><?php } ?>
      <?php if ($cabang == 'CA') {?>				  
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>CA
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">           
               <li><a href="ca_receipt.php"><i class="fa fa-book"></i> <span>CA Receipt Summar</span></a></li>
				<li><a href="vip_open_class_report_acccx.php"><i class="fa fa-book"></i> <span>CA Detail Open Class List</span></a></li>					  
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>CA Open Class Detail</span></a></li> 

                                   <li><a href="vip_teacher_free_all.php?tgl_awal=<?php echo e($hari_ini) ?>"><i class="fa fa-book"></i> <span>Teachers Availability Calendar</span></a></li> 		
              </ul>               
                          
            </li>	<?php }?>		  
          </ul>
      <?php if($cabang !='CA'){?>						  
          <ul class="treeview-menu">
            <li>
              <a href="aktifitas.php"><i class="fa fa-circle-o"></i>Activities
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
             
                          
            </li>
          </ul>
<?php } ?>					  
                </li>

<?php if ($posisi == 'ACCM')
{
if ($nama_lengkap == 'dewi tan')
	{
	$query_notif = "select po_status from purchase_order where po_status = 2 group by kode";
	}
elseif ($nama_lengkap == 'Kurnia')
	{
	$query_notif = "select po_status from purchase_order where po_status = 3 group by kode";
	}
elseif ($nama_lengkap == 'lanni susanti')
	{
	$query_notif = "select po_status from purchase_order where po_status = 4 group by kode";
	}	

// Hasil query notifikasi tidak pernah dipakai (perhitungan $angka_notif sudah
// dikomentari di versi lama), jadi query-nya tidak dijalankan lagi.
			  ?>
                  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Accounting & Finance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
					  
          <ul class="treeview-menu">
	<!-------  fa MENU START-->

			  
			              <li>
              <a href="#"><i class="fa fa-circle-o"></i>FELLOWS ACADEMY
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">           
  		<li><a href="fa_sales_center.php"><i class="fa fa-book"></i> <span>FA Enrolled Student</span></a></li>
                                   <li><a href="fa_receipt.php"><i class="fa fa-book"></i> <span>FA Receipt</span></a></li> 					 
	  		<li><a href="vip_pt_record.php"><i class="fa fa-book"></i> <span>FA PT Score</span></a></li> 		
	  		<li><a href="vip_pt_list.php"><i class="fa fa-book"></i> <span>FA PT Student List</span></a></li> 				    		
  		<li><a href="vip_order_list.php"><i class="fa fa-book"></i> <span>FA Meeting Order List</span></a></li> 
	  
  		<li><a href="vip_class_list.php"><i class="fa fa-book"></i> <span>FA Class List</span></a></li> 
  		<li><a href="vip_student_record.php"><i class="fa fa-book"></i> <span>FA Student Record</span></a></li> 	
	  
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>FA Open Class Detail</span></a></li>
<li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>FA Teaching Hour Summary</span></a></li>
<li><a href="vip_outstanding.php"><i class="fa fa-book"></i> <span>FA Outstanding Payment </span></a></li>	
			  
                  <li><a href="teachercalendar.php"><i class="fa fa-circle-o"></i>FA Calendar</a></li> 	
              </ul>               
                          
            </li>
<!-------  fa MENU END-->		  
<!-------  CA MENU START-->

			  
			              <li>
              <a href="#"><i class="fa fa-circle-o"></i>CA
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">           
               <li><a href="ca_receipt.php"><i class="fa fa-book"></i> <span>CA Receipt Summar</span></a></li>
               <li><a href="ca_oc_branch.php"><i class="fa fa-book"></i> <span>CA OC Income by Branch</span></a></li>
	              <li><a href="ca_monthly_report.php"><i class="fa fa-book"></i> <span>CA OC Monthly Income</span></a></li>			  
				<li><a href="vip_open_class_report_acc.php"><i class="fa fa-book"></i> <span>CA Detail Open Class List</span></a></li>					  
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>CA Open Class Detail</span></a></li> 
				<li><a href="vip_open_class_report_acc.php"><i class="fa fa-book"></i> <span>CA Open Class List</span></a></li>	
                                   <li><a href="vip_teacher_free_all.php?tgl_awal=<?php echo e($hari_ini) ?>"><i class="fa fa-book"></i> <span>Teachers Availability Calendar</span></a></li> 		
              </ul>               
                          
            </li>
<!-------  CA MENU END-->
			  
			  
				<li><a href="accnt/vip_sales_center.php"><i class="fa fa-circle-o"></i>VE Billing List</a></li>	
				<li><a href="vip_sales_center.php"><i class="fa fa-book"></i> <span>VE Payment</span></a></li> 			  
				<li><a href="accnt/vip_receipt.php"><i class="fa fa-circle-o"></i>VE Receipt List</a></li>
				<li><a href="accnt/ca_acc_receipt.php"><i class="fa fa-circle-o"></i>CA Receipt List</a></li>
				  
				<li><a href="vip_refund.php"><i class="fa fa-circle-o"></i>VE Refund</a></li>  		  
				<li><a href="ca_refund.php"><i class="fa fa-circle-o"></i>CA Refund</a></li>  		  
				<li><a href="fa_refund.php"><i class="fa fa-circle-o"></i>FA Refund</a></li> 			  
				<li><a href="vip_outstanding.php"><i class="fa fa-circle-o"></i>VE Outstanding Payment</a></li>         			  
				<li><a href="vip_receipt_report.php"><i class="fa fa-circle-o"></i>VE Inc Sum by Week</a></li>
					<li><a href="vip_openclass_report.php"><i class="fa fa-circle-o"></i>VIP Open Class by Week</a></li> 			  	  
				<li><a href="vip_open_class_report_accounting.php"><i class="fa fa-book"></i> <span>VE Sales Open Class Payment Detail</span></a></li> 		  
	  
				<li><a href="vossf_receipt_daily.php" target="_blank"><i class="fa fa-book"></i> <span>VOS Receipt Daily Report</span></a></li>
 
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i>Teacher Management
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="teacher_master.php"><i class="fa fa-circle-o"></i>Master Salary</a></li>
                    <li><a href="teacher_salary_report.php" target="_blank"><i class="fa fa-circle-o"></i>Salary List</a></li> 
                    <li><a href="status.php"><i class="fa fa-circle-o"></i>Report</a></li>                                      
                  </ul>
                </li>
            		  
				<li><a href="vip_open_class_report_acc.php"><i class="fa fa-book"></i> <span>VE Academic Open Class</span></a></li>			  
				<li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>VE Teaching Hour Summary</span></a></li>	
<li><a href="vip_certificate_acc.php"><i class="fa fa-book"></i> <span>VIP Certificate Approval</span></a></li>			  
					<li><a href="book_inventory.php"><i class="fa fa-circle-o"></i>Asset Management</a></li>				
				 <li><a href="accnt/ve_inc_list_accounting.php"><i class="fa fa-circle-o"></i>VE Incentive Claim</a></li> 	

              <small class="label pull-right bg-red"><?php echo isset($angka_notif) ? e($angka_notif) : '' ; ?></small>
          </ul>
        </li> 
<?php } ?>
<?php if($posisi =='HRD')
{?>	
                  <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i>Teacher Management
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>

                <ul class="treeview-menu">
                    <li><a href="teacher_master.php"><i class="fa fa-circle-o"></i>Master Salary</a></li>
                    <li><a href="teacher_salary_report.php" target="_blank"><i class="fa fa-circle-o"></i>Salary List</a></li> 
                    <li><a href="status.php"><i class="fa fa-circle-o"></i>Report</a></li>                                      
                  </ul>				    
			                                            
            </li> 			  
		  
<?php } ?>
<?php if ($kd_cbg==8){?>
<li><a href="ptschedule.php"><i class="fa fa-circle-o"></i>Malang Placement Test</a></li>  
                    <?php       }?>     



	
<?php  //===end sales === 
}?>
 <?php //=======Admin======= 
if ($posisi =='Admin' or $nama_lengkap == 'Ragel Suma Wijaya' or $nama_lengkap == 'laura natalia'  or $nama_lengkap == 'Indah Nur Atika Sari')
{?>
                  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Admin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
<?php if ($mbl == 1)
{ ?>
<li><a href="mob_purchasinglist.php"><i class="fa fa-book"></i> <span>Purchasing</span></a>	</li> 
<?php } else { ?>
<li><a href="purchasinglist.php"><i class="fa fa-book"></i> <span>Purchasing</span></a>	</li> 	  
<?php } ?>			  
				<li><a href="invoicebilllist.php"><i class="fa fa-book"></i> <span>Other Billing List</span></a></li> 			  
				<li><a href="ves_sales_center.php"><i class="fa fa-book"></i> <span>VOS Payment</span></a></li> 
				<li><a href="invoicebill.php?asal=1"><i class="fa fa-book"></i> <span>VOS Bakat Minat</span></a></li> 
			  
				<li><a href="soastatlist.php"><i class="fa fa-book"></i> <span>SOA Form</span></a></li> 	
				<li><a href="ves_pf.php"><i class="fa fa-book"></i> <span>VOS Service Fee List</span></a></li> 	
			  
				<li><a href="vip_sales_center.php"><i class="fa fa-book"></i> <span>VE Payment</span></a></li> 
				<li><a href="vip_refund_admin.php"><i class="fa fa-book"></i> <span>VE Refund List</span></a></li> 	
				<li><a href="ca_refund_admin.php"><i class="fa fa-book"></i> <span>CA Refund List</span></a></li> 	
			  
				<li><a href="#"><i class="fa fa-book"></i> <span>VPro Payment</span></a></li> 
				<li><a href="#"><i class="fa fa-book"></i> <span>Other Payment</span></a></li> 		
					<li><a href="book_inventory.php"><i class="fa fa-circle-o"></i>Asset Management</a></li>			  
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
				<li><a href="ves_pf.php"><i class="fa fa-book"></i> <span>VES Income</span></a></li> 
				<li><a href="vip_outstanding.php"><i class="fa fa-book"></i> <span>VE Outstanding List</span></a></li>			  
				<li><a href="vip_receipt.php"><i class="fa fa-book"></i> <span>VE Income</span></a></li>
				<li><a href="fa_receipt.php"><i class="fa fa-book"></i> <span>FA Income</span></a></li>			  
				<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>VE Sales Open Class Payment Detail</span></a></li> 
<li><a href="vip_open_class_report_acd.php"><i class="fa fa-book"></i> <span>VE Academic Open Class</span></a></li> 				
				 
				<li><a href="#"><i class="fa fa-book"></i> <span>VPro Income</span></a></li> 
				<li><a href="otherpaymentlist.php"><i class="fa fa-book"></i> <span>Other Income</span></a></li>
				<li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>Teaching Hour Summary</span></a></li> 			  			  				     	
				  			  				    
					  </ul>                                             
            </li>                	
                 <?php } ?>  
                  <li class="treeview">
					        <?php if($cabang != 'CA' or $cabang == 'CA'){?>	
          <a href="#">
   
            <i class="fa fa-share"></i> <span>Academic  </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
					        <?php }?>	
          <ul class="treeview-menu">
                                   <li><a href="dashboard.php"><i class="fa fa-book"></i> <span>Dashboard</span></a></li> 
<?php if ($mbl == 1)
{ ?>
<li><a href="mob_purchasinglist.php"><i class="fa fa-book"></i> <span>Purchasing</span></a>	</li> 
<?php } else { ?>
<li><a href="purchasinglist.php"><i class="fa fa-book"></i> <span>Purchasing</span></a>	</li> 	  
<?php } ?>	 			  
				<?php if($nama_lengkap != 'Savita Rachma Indrayani'){?>									  
                                   <li><a href="entryactteac.php"><i class="fa fa-book"></i> <span>My Agenda</span></a></li> 
<?php } else {?>
                                   <li><a href="entryactteactemp.php"><i class="fa fa-book"></i> <span>My Agenda</span></a></li> 	
<?php } ?>			  
			  
                                   <li><a href="vip_activities.php"><i class="fa fa-book"></i> <span>My Activities</span></a></li>  
  		<li><a href="book_inventory.php"><i class="fa fa-book"></i> <span>VE Book Stock</span></a></li> 				  
                                   <li><a href="entryworking_hor.php"><i class="fa fa-book"></i> <span>Setting Monthly Working Time</span></a></li> 
                                   <li><a href="vip_teacher_free_all.php?tgl_awal=<?php echo e($hari_ini) ?>"><i class="fa fa-book"></i> <span>Teachers Availability Calendar</span></a></li>   			  
<?php if ($nama_lengkap =='Nicko Putra Witjatmoko') {?>          
		<li><a href="vpro_sales_center.php"><i class="fa fa-book"></i> <span>V-PRO Billing Statement</span></a></li> 
					<li><a href="book_inventory.php"><i class="fa fa-circle-o"></i>Asset Management</a></li>				  
<?php } ?> 	                                                                    
                  <li><a href="vip_data.php"><i class="fa fa-book"></i> <span>Report List</span></a></li>
                  <li><a href="vip_academic_review_list.php"><i class="fa fa-book"></i> <span>Academic Review</span></a></li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>BIM Data
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="bim_list.php"><i class="fa fa-circle-o"></i>Data List</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i>Report
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="bim_att.php"><i class="fa fa-circle-o"></i>Attendance</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Scoring</a></li>
                  </ul>
                </li>
              </ul>
            </li>	
			  <?php if ($nama_lengkap =='Arsyi Aisyah' or $nama_lengkap =='Nadillah Aatifah Rahim'){?>
				<li><a href="vip_sales_center.php"><i class="fa fa-book"></i> <span>VE Payment</span></a></li> 
				<li><a href="vip_refund_admin.php"><i class="fa fa-book"></i> <span>VE Refund List</span></a></li>			  
			          <li><a href="invoicebilllist.php"><i class="fa fa-book"></i> <span>Other Billing</span></a></li>
			  
			  <?php } ?>
			  
                  <?php if ($_SESSION['kelompok'] =='ACD' and ($_SESSION['posisi']== 'AS' or $_SESSION['posisi'] =='CM' or $_SESSION['posisi'] =='FTT')) {?>
                   <li><a href="entrydata.php"><i class="fa fa-circle-o"></i>Open Class Form</a></li>
                <?php } if (($_SESSION['kelompok'] =='ACD' and $_SESSION['kd_branch']== '0') or $_SESSION['posisi']== 'AS' or $_SESSION['posisi'] =='CM'  or $_SESSION['posisi'] =='FTT' or $_SESSION['posisi'] =='PTT' or $_SESSION['posisi'] =='HO'  or $nama_lengkap =='Nadillah Aatifah Rahim') {?>
                   <li><a href="inpuevent.php"><i class="fa fa-circle-o"></i>Teachers Detail Record</a></li> 
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>LC Data
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
			  
    		<li><a href="vip_lc_sturcd.php"><i class="fa fa-book"></i> <span>LC Student Record</span></a></li>					  
    		<li><a href="vip_lc_recomendation.php"><i class="fa fa-book"></i> <span>LC Recommendation List</span></a></li>				  
     		<li><a href="vip_lc_date_book.php"><i class="fa fa-book"></i> <span>LC Open Date List</span></a></li> 
     		<li><a href="vip_lc_booking.php"><i class="fa fa-book"></i> <span>LC Booking List</span></a></li>				  
     		<li><a href="vip_class_list_lc.php?kd_cbg=100&kelas_name=LCSTBY"><i class="fa fa-book"></i> <span>LC Standby Registration</span></a></li> 
     		<li><a href="teachercalendar.php?type_act=LC Standby&Display=Display"><i class="fa fa-book"></i> <span>LC Standby Calendar</span></a></li> 			  		  
 	
 
              </ul>
            </li>
       	
				  		<?php if($nama_lengkap == 'Savita Rachma Indrayani' or $nama_lengkap == 'Luqman Sakha Ghia'){?>		
    		<li><a href="entryactnonteach.php"><i class="fa fa-book"></i> <span>Teachers Booking Form </span></a></li>	
    		<li><a href="vip_certificate_app.php"><i class="fa fa-book"></i> <span>Certificate Approval</span></a></li>	
			  
<?php } ?>	
		  
			  <li><a href="vip_pt_record.php"><i class="fa fa-book"></i> <span>VE PT Score</span></a></li> 		
  		<li><a href="vip_class_list.php"><i class="fa fa-book"></i> <span>VE Class List</span></a></li> 
  		<li><a href="vip_student_record.php"><i class="fa fa-book"></i> <span>VE Student Record</span></a></li> 				  
<li><a href="vip_open_class_report.php"><i class="fa fa-book"></i> <span>VE Sales Class Detail</span></a></li>
<li><a href="vip_certificate.php"><i class="fa fa-book"></i> <span>VIP Certificate Generator</span></a></li>			  
<li><a href="vip_open_class_report_acd.php"><i class="fa fa-book"></i> <span>VE Academic Open Class</span></a></li>     
<li><a href="vip_order_check.php"><i class="fa fa-book"></i> <span>VE Order Management</span></a></li>
<li><a href="vipbook.php"><i class="fa fa-book"></i> <span>VE Material Management</span></a></li>
                                   <li><a href="vip_mst_form.php"><i class="fa fa-book"></i> <span>Scope Sequence Upload</span></a></li>         				
			  <li><a href="vip_tchhourrpt.php"><i class="fa fa-book"></i> <span>Teaching Hour Summary</span></a></li>                          
 			  <li><a href="vip_th.php"><i class="fa fa-book"></i> <span>TH by Teacher</span></a></li>    
				  		<?php if($nama_lengkap == 'Luqman Sakha Ghia'){?>		
    		<li><a href="fa_receipt.php"><i class="fa fa-book"></i> <span>FA Payment</span></a></li>	
			  
<?php } ?>				  
       <?php } ?>
                  <li><a href="rulesmemo.php"><i class="fa fa-circle-o"></i>Rules and Interofice Memo</a></li> 			  
                  <li><a href="teachercalendar.php"><i class="fa fa-circle-o"></i>Calendar</a></li> 
<?php if (($_SESSION['kelompok'] =='ACD' and $_SESSION['kd_branch']== '0') or $_SESSION['posisi']== 'AS') {?>                    
<li><a href="vip_file_browser.php"><i class="fa fa-book"></i> <span>File</span></a></li>                           
                 <?php } ?>                                       
          </ul>
        </li>
<?php } else {?>
      <ul class="sidebar-menu">
                  <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>LIU MEDIA </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                  <li><a href="liu_inc_generator.php"><i class="fa fa-circle-o"></i>Incentive Generator</a></li>
                   <li><a href="leads.php?q=3"><i class="fa fa-circle-o"></i>Incentive Claim</a></li>
            <li>
                                         
            </li>
          </ul>
        </li> 
        <li><a href="invoicebillliu.php?test=2"><i class="fa fa-book"></i> <span>Other Billing</span></a></li>	
        <li><a href="purchasinglist.php"><i class="fa fa-book"></i> <span>Purchasing</span></a></li>			  
<?php } ?>	
<?php //===end of academic } ?>	
<?php if ($nama_depan =='jimmy'){?>
                  <li class="treeview">
          <a href="#">
   
            <i class="fa fa-share"></i> <span>Situation Room</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                                   <li><a href="leaderboard.php"><i class="fa fa-book"></i> <span>VIP Leaderboard</span></a></li> 
			                                     <li><a href="vip_sc_monthly.php" target="_blank"><i class="fa fa-book"></i> <span>SC Monthly Income </span></a></li> 

					  </ul>
	  </li>
<?php } ?>	
<li><a href="brg_list.php"><i class="fa fa-book"></i> <span>Barang</span></a></li>  	  
<li><a href="logout.php"><i class="fa fa-book"></i> <span>Log Out</span></a></li>     
      </ul>
      
    </section>
    <!-- /.sidebar -->
  </aside>

<!-- ============================================================
     Toggle sidebar mandiri (vanilla JS, TANPA jQuery / app.min.js).
     Kenapa: sebelumnya klik menu bergantung pada app.min.js yang baru
     termuat setelah sederet script berat/CDN di bawah (jquery-ui,
     raphael, moment, dst). Kalau salah satu lambat, menu "mati" sampai
     semua selesai. Lebih parah: halaman yg memuat jQuery + app.min.js
     LAGI di bawahnya membuat handler treeview terpasang 2x -> satu klik
     = buka lalu langsung tutup. Handler capture di bawah ini jalan
     duluan dan menghentikan event, jadi handler AdminLTE (1x maupun 2x)
     tidak ikut menimpa. Link biasa (tanpa submenu) tidak disentuh.
     ============================================================ -->
<script>
(function () {
  function hasClass(el, c) { return el && (' ' + el.className + ' ').indexOf(' ' + c + ' ') > -1; }
  function addClass(el, c) { if (!hasClass(el, c)) { el.className = (el.className + ' ' + c).replace(/^\s+/, ''); } }
  function removeClass(el, c) { el.className = (' ' + el.className + ' ').replace(' ' + c + ' ', ' ').replace(/^\s+|\s+$/g, ''); }
  function closestLink(el) {
    while (el && el !== document) { if (el.tagName === 'A') { return el; } el = el.parentNode; }
    return null;
  }
  function inSidebarMenu(el) {
    while (el && el !== document) { if (hasClass(el, 'sidebar-menu')) { return true; } el = el.parentNode; }
    return false;
  }
  function submenuOf(a) {
    var n = a.nextSibling;
    while (n) {
      if (n.nodeType === 1) { return (n.tagName === 'UL' && hasClass(n, 'treeview-menu')) ? n : null; }
      n = n.nextSibling;
    }
    return null;
  }
  function isShown(ul) {
    var d = window.getComputedStyle ? window.getComputedStyle(ul, null).display : ul.style.display;
    return d !== 'none';
  }
  function childMenus(li) {
    var out = [], c = li.firstChild;
    while (c) { if (c.nodeType === 1 && c.tagName === 'UL' && hasClass(c, 'treeview-menu')) { out.push(c); } c = c.nextSibling; }
    return out;
  }
  function closeMenu(li) {
    var m = childMenus(li);
    for (var i = 0; i < m.length; i++) { m[i].style.display = 'none'; removeClass(m[i], 'menu-open'); }
    removeClass(li, 'active');
  }

  document.addEventListener('click', function (e) {
    var a = closestLink(e.target || e.srcElement);
    if (!a || !inSidebarMenu(a)) { return; }
    var ul = submenuOf(a);
    var href = a.getAttribute('href');
    if (!ul && href !== '#') { return; }          // link biasa -> navigasi normal
    e.preventDefault();
    e.stopPropagation();
    if (!ul) { return; }                           // href="#" tanpa submenu
    var li = a.parentNode;
    if (isShown(ul)) {
      closeMenu(li);
    } else {
      var sib = li.parentNode.firstChild;          // accordion: tutup menu sejajar
      while (sib) {
        if (sib.nodeType === 1 && sib !== li && sib.tagName === 'LI') { closeMenu(sib); }
        sib = sib.nextSibling;
      }
      ul.style.display = 'block';
      addClass(ul, 'menu-open');
      addClass(li, 'active');
    }
  }, true);
})();
</script>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
