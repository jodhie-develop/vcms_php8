<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_val('kd_cbg', 'get');

if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
<?php //========================== left nav ?>
<?php // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=leaving.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>New Leads Entry</h1>
      <?php 
					if ($kd_cbg == '0' || $kd_cbg == '')
					{
					$query = q_set($__p_query, "SELECT  date_format(a.enroll_date,'%d/%m/%Y'),a.nama,a.dest_school, a.dest_program, a.dest_country,(case when a.h_nh = 'H' then 1 else 0 end) as H,(case when a.h_nh <> 'H' then 1 else 0 end) as NH,(case when a.p_np = 'P' then 1 else 0 end) as P,(case when a.p_np <> 'P' then 1 else 0 end) as NP, date_format(a.comm_date,'%d/%m/%Y'),b.grade,a.branch FROM adm_stu_progress a, tb_master_partner b where a.kd_school = b.kd_school and a.final_status = 'L' and comm_date between ? and ? order by\r
\t\t\t\t\tcase when dest_country like 'USA%' then 0\r
\t\t\t\t\twhen dest_country like 'CAN%' then 1\r
\t\t\t\t\twhen dest_country like 'SW%' then 2\r
\t\t\t\t\twhen dest_country like 'UK%' then 3\r
\t\t\t\t\twhen dest_country like 'SPA%' then 4\r
\t\t\t\t\twhen dest_country like 'IT%' then 5\r
\t\t\t\t\twhen dest_country like 'AUS%' then 6\r
\t\t\t\t\twhen dest_country like 'NEW%' then 7\r
\t\t\t\t\twhen dest_country like 'SIN%' then 8\r
\t\t\t\t\twhen dest_country like 'MAL%' then 9\r
\t\t\t\t\twhen dest_country like 'CHI%' then 10\r
\t\t\t\t\twhen dest_country like 'IN%' then 11\r
\t\t\t\t\tELSE 12 end, dest_country asc, comm_date", [(string) ($date_start), (string) ($date_end)]);
				  	}
				  else	
					{
					$query = q_set($__p_query, "SELECT  date_format(a.enroll_date,'%d/%m/%Y'),a.nama,a.dest_school, a.dest_program, a.dest_country,(case when a.h_nh = 'H' then 1 else 0 end) as H,(case when a.h_nh <> 'H' then 1 else 0 end) as NH,(case when a.p_np = 'P' then 1 else 0 end) as P,(case when a.p_np <> 'P' then 1 else 0 end) as NP, date_format(a.comm_date,'%d/%m/%Y'),b.grade,a.branch FROM adm_stu_progress a, tb_master_partner b where a.kd_school = b.kd_school and a.final_status = 'L' and comm_date between ? and ? and a.kd_branch = ? order by\r
\t\t\t\t\tcase when dest_country like 'USA%' then 0\r
\t\t\t\t\twhen dest_country like 'CAN%' then 1\r
\t\t\t\t\twhen dest_country like 'SW%' then 2\r
\t\t\t\t\twhen dest_country like 'UK%' then 3\r
\t\t\t\t\twhen dest_country like 'SPA%' then 4\r
\t\t\t\t\twhen dest_country like 'IT%' then 5\r
\t\t\t\t\twhen dest_country like 'AUS%' then 6\r
\t\t\t\t\twhen dest_country like 'NEW%' then 7\r
\t\t\t\t\twhen dest_country like 'SIN%' then 8\r
\t\t\t\t\twhen dest_country like 'MAL%' then 9\r
\t\t\t\t\twhen dest_country like 'CHI%' then 10\r
\t\t\t\t\twhen dest_country like 'IN%' then 11\r
\t\t\t\t\tELSE 12 end, dest_country asc, comm_date", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);						
					}
				  	$_SESSION['ngueri'] = $query; $_SESSION['ngueri__p'] = $__p_query ?? [];
					$no_urut = 1;
					$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
				  	$num_rows = db_num_rows($result);?>
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
 <form name="myform" id="myform">

  <table  align="center">
    <tr>
      <td width="120" height="114">&nbsp;</td>
      <td width="1073" valign="top"><table width="977">
        <tr>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-1' for='id_title'>Nama Lengkap</label>
            <div class='col-md-8'>
             <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' name='nama_depan' placeholder='Nama Depan' type='text'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' name='nama_tengah' placeholder='Nama Tengah' type='text'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' name='nama_belakang' placeholder='Nama Belakang' type='text'>
                </div>
              </div>
            </div>
          </div>
          <td><span class="style2">
            <br>
            <select name="gender" id="gender">
              <option>M</option>
              <option>F</option>
              <option selected="selected"> <?php echo e($gender);  ?> </option>
              </select>
            </span></td>
          <td>&nbsp;</td>
          </tr></div>
        <tr>
          <td><strong>Date Of Birth </strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="2"><span class="style2">
            <select name="dob_dd" id="dob_dd">
              <option>01</option>
              <option>02</option>
              <option>03</option>
              <option>04</option>
              <option>05</option>
              <option>06</option>
              <option>07</option>
              <option>08</option>
              <option>09</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
              <option>13</option>
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
              <option>21</option>
              <option>22</option>
              <option>23</option>
              <option>24</option>
              <option>25</option>
              <option>26</option>
              <option>27</option>
              <option>28</option>
              <option>29</option>
              <option>30</option>
              <option>31</option>
              <option selected="selected"> <?php echo e($dob_dd);  ?> </option>
              </select>
            <select name="dob_mm" id="dob_mm">
              <option>01</option>
              <option>02</option>
              <option>03</option>
              <option>04</option>
              <option>05</option>
              <option>06</option>
              <option>07</option>
              <option>08</option>
              <option>09</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
              <option selected="selected"> <?php echo e($dob_mm);  ?> </option>
              </select>
            <select name="dob_yy" id="dob_yy">
              <option>2010</option>
              <option>2009</option>
              <option>2008</option>
              <option>2007</option>
              <option>2006</option>
              <option>2005</option>
              <option>2004</option>
              <option>2003</option>
              <option>2002</option>
              <option>2001</option>
              <option>2000</option>
              <option>1999</option>
              <option>1998</option>
              <option>1997</option>
              <option>1996</option>
              <option>1995</option>
              <option>1994</option>
              <option>1993</option>
              <option>1992</option>
              <option>1991</option>
              <option>1990</option>
              <option>1989</option>
              <option>1988</option>
              <option>1987</option>
              <option>1986</option>
              <option>1985</option>
              <option>1984</option>
              <option>1983</option>
              <option>1982</option>
              <option>1981</option>
              <option>1980</option>
              <option>1979</option>
              <option>1978</option>
              <option>1977</option>
              <option>1976</option>
              <option>1975</option>
              <option>1974</option>
              <option selected="selected"> <?php echo e($dob_yy)  ?> </option>
              </select>
            </span></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><strong>Address *</strong></td>
          <td>&nbsp;</td>
          <td><strong>City * </strong></td>
          <td><strong>Area</strong></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="2"><input name="address" type="text" id="address" size="70" value="<?php echo e($address) ?>"></td>
          <td><span class="style2">
            <select name="student_city" id="student_city">
              <option value= >
                <?php echo e($list_city)?>
                <option selected="selected"> <?php 		   
				  if ($student_city !="") { echo e($student_city); }else { echo e($nm_city); }
  ?> </option>
              </select>
            </span></td>
          <td><span class="style2">
            <select name="area" id="area">
              <option>East</option>
              <option>West</option>
              <option>South</option>
              <option>North</option>
              <option>Central</option>
              <option selected="selected"> <?php echo e($area);  ?> </option>
              </select>
            </span></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><strong>Phone</strong></td>
          <td><strong>HP 1  *</strong></td>
          <td><strong>HP 2 </strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><input name="phone" type="text" id="phone" value="<?php echo e($phone) ?>"></td>
          <td><input name="hp1" type="text" id="hp1" value="<?php echo e($hp1) ?>"></td>
          <td><input name="hp2" type="text" id="hp2" value="<?php echo e($hp2) ?>"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><strong>E-Mail *</strong></td>
          <td><strong>Fb</strong></td>
          <td><strong>Twitter</strong></td>
          <td><strong>Instagram</strong></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><input name="e_mail" type="text" id="e_mail" value="<?php echo e($e_mail) ?>"></td>
          <td><input name="fb" type="text" id="fb" value="<?php echo e($fb) ?>"></td>
          <td><input name="twitter" type="text" id="twitter" value="<?php echo e($twitter) ?>"></td>
          <td><input name="instagram" type="text" id="instagram" value="<?php echo e($instagram) ?>"></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><strong>Path</strong></td>
          <td><strong>Line </strong></td>
          <td><strong>Wa</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><input name="path" type="text" id="path" value="<?php echo e($path) ?>"></td>
          <td><input name="line" type="text" id="line" value="<?php echo e($line) ?>"></td>
          <td><input name="wa" type="text" id="wa" value="<?php echo e($wa) ?>"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><strong>VES Remark</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="4"><input name="ves_remark" type="nextremark" id="ves_remark" value="<?php echo e($ves_remark) ?>" size="120"></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><strong>VIP Remark </strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="4"><input name="vip_remark" type="nextremark" id="vip_remark" value="<?php echo e($vip_remark) ?>" size="120"></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="5"><strong>School Info</strong></td>
          </tr>
        <tr>
          <td colspan="4"><table width="803" border="0">
            <tr>
              <td width="141"><strong>City *</strong></td>
              <td width="68"><strong>level</strong></td>
              <td width="480"><strong>School Name  *</strong></td>
              <td width="96"><strong>Grade *</strong></td>
              </tr>
            <tr>
              <td><span class="style2">
                <select name="school_city" id="school_city" onChange="this.form.submit()">
                  <option value= >
                    <?php echo e($list_city)?>
                    <option selected="selected"> <?php 		   
				  if ($school_city !="") { echo e($school_city); }
  ?>                    </select>
                </span></td>
              <td><span class="style2">
                <select name="school_level" id="school_level">
                  <option>SD</option>
                  <option>SMP</option>
                  <option>SMA</option>
                  <option>UNI</option>
                  <option>S1</option>
                  <option>S2</option>
                  <option>S3</option>
                  
                  <option selected="selected"> <?php echo e($school_level);  ?> </option>
                  </select>
                </span></td>
              <td><span class="style2">
                <select name="school_name" id="school_name"  onChange="this.form.submit()">
                  <option value= >
                    <?php echo e($list_ori_school)?>
                    <option selected="selected">
                      <?php 		   
				  if ($school_name !="") { echo e($school_name); }else { echo e($nm_ori_school); }
  ?>
                      </select>
                <input name="other_school" type="text" id="other_school" value="<?php echo e($other_school) ?>" size="35"   
					<?php 
					if ($school_city == 'Other' || $school_name== 'Other')
					{ 
					$st_other_ori = 1;
					echo ""; 
					}
					else
					{ 
					$st_other_ori = 0;

					echo "hidden='hidden'"; 
					}
					?>
					>
                </span></td>
              <td><span class="style2">
                <select name="school_grade" id="school_grade">
                  <option>O Level</option>
                  <option>IB</option>
                  <option>Yr 1</option>
                  <option>Yr 2</option>
                  <option>Yr 3</option>
                  <option>Yr 4</option>
                  <option>Yr 5</option>
                  <option>Yr 6</option>
                  <option>Yr 7</option>
                  <option>Yr 8</option>
                  <option>Yr 9</option>
                  <option>Yr 10</option>
                  <option>Yr 11</option>
                  <option>Yr 12</option>
                  <option>Sec 1</option>
                  <option>Sec 2</option>
                  <option>Sec 3</option>
                  <option>Sec 4</option>
                  <option>GRADUATE</option>						  
                  <option selected="selected"> <?php echo e($school_grade);  ?> </option>
                  </select>
                </span></td>
              </tr>
            </table></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><strong>Reference</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="5"><table width="880" border="0">
            <tr>
              <td width="107"><strong>VES</strong></td>
              <td width="452">&nbsp;</td>
              <td width="10">&nbsp;</td>
              <td colspan="2"><strong>VIP</strong></td>
              </tr>
            <tr>
              <td><strong>Choice 1 </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="85">&nbsp;</td>
              <td width="204">&nbsp;</td>
              </tr>
            <tr>
              <td><strong>Country</strong></td>
              <td><span style="color: #FFFFFF">
                <select name="flt_country1" id="flt_country1"onChange="this.form.submit()" >
                  <option value= "">
                    <?php echo e($list_country1)?>
                    </option>
                  <option selected="selected">
                    <?php  		   if ($flt_country1 !="") { echo e($flt_country1); }else { echo e($country_dest1); }

   ?>
                    </option>
                  </select>
                </span></td>
              <td>&nbsp;</td>
              <td><strong>Program</strong></td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><strong>School</strong></td>
              <td colspan="4"><span class="style92" style="color: #FFFFFF">
                <select name="flt_school1" id="flt_school1" onChange="this.form.submit()">
                  <option value= >
                    <?php echo e($list_school1)?>
                    <option selected="selected">
                      <?php  
		   if ($flt_school1 !="") { echo e($flt_school1); }else { echo e($school_dest1); }
   ?>
                      </option>
                  </select>
                </span></td>
              </tr>
            <tr>
              <td><strong>Program</strong></td>
              <td><span class="style92" style="color: #FFFFFF">
                <select name="flt_program1" id="flt_program1">
                  <option value= >
                    <?php echo e($list_program)?>
                    <option selected="selected">
                      <?php  if ($flt_program1 !="") { echo e($flt_program1); }else { echo e($program_dest1); }
   ?>
                      </option>
                  </select>
                </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><strong>Choice 2 </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><strong>Country</strong></td>
              <td><span style="color: #FFFFFF">
                <select name="flt_country2" id="flt_country2"onChange="this.form.submit()" >
                  <option value= "">
                    <?php echo e($list_country2)?>
                    </option>
                  <option selected="selected">
                    <?php  		   if ($flt_country2 !="") { echo e($flt_country2); }else { echo e($country_dest2); }

   ?>
                    </option>
                  </select>
                </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><strong>School</strong></td>
              <td colspan="4"><span class="style92" style="color: #FFFFFF">
                <select name="flt_school2" id="flt_school2" onChange="this.form.submit()">
                  <option value= >
                    <?php echo e($list_school2)?>
                    <option selected="selected">
                      <?php  
		   if ($flt_school2 !="") { echo e($flt_school2); }else { echo e($school_dest2); }
   ?>
                      </option>
                  </select>
                </span></td>
              </tr>
            <tr>
              <td><strong>Program</strong></td>
              <td><span class="style92" style="color: #FFFFFF">
                <select name="flt_program2" id="flt_program2">
                  <option value= >
                    <?php echo e($list_program)?>
                    <option selected="selected">
                      <?php  if ($flt_program2 !="") { echo e($flt_program2); }else { echo e($program_dest2); }
   ?>
                      </option>
                  </select>
                </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><strong>Choice 3 </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><strong>Country</strong></td>
              <td><span style="color: #FFFFFF">
                <select name="flt_country3" id="flt_country3"onChange="this.form.submit()" >
                  <option value= "">
                    <?php echo e($list_country3)?>
                    </option>
                  <option selected="selected">
                    <?php  		   if ($flt_country3 !="") { echo e($flt_country3); }else { echo e($country_dest3); }

   ?>
                    </option>
                  </select>
                </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><strong>School</strong></td>
              <td colspan="4"><span class="style92" style="color: #FFFFFF">
                <select name="flt_school3" id="flt_school3" onChange="this.form.submit()">
                  <option value= >
                    <?php echo e($list_school3)?>
                    <option selected="selected">
                      <?php  
		   if ($flt_school3 !="") { echo e($flt_school3); }else { echo e($school_dest3); }
   ?>
                      </option>
                  </select>
                </span></td>
              </tr>
            <tr>
              <td><strong>Program</strong></td>
              <td><span class="style92" style="color: #FFFFFF">
                <select name="flt_program3" id="flt_program3">
                  <option value= >
                    <?php echo e($list_program)?>
                    <option selected="selected">
                      <?php  if ($flt_program3 !="") { echo e($flt_program3); }else { echo e($program_dest3); }
   ?>
                      </option>
                  </select>
                </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="5"><strong>Parent Info </strong></td>
          </tr>
        <tr>
          <td colspan="5"><table width="913" border="0">
            <tr>
              <td width="194"><strong>Parent Name </strong></td>
              <td width="43">&nbsp;</td>
              <td width="551"><strong>Address</strong></td>
              <td width="22">&nbsp;</td>
              <td width="81"><strong>City</strong></td>
              </tr>
            <tr>
              <td><input name="parent_name" type="text" id="parent_name" value="<?php echo e($parent_name) ?>"></td>
              <td>&nbsp;</td>
              <td><input name="parent_address" type="text" id="parent_address" value="<?php echo e($parent_address) ?>"></td>
              <td>&nbsp;</td>
              <td><span class="style2">
                <select name="parent_city" id="parent_city">
                  <option value= >
                    <?php echo e($list_city)?>
                    <option selected="selected"> <?php 		   
				  if ($parent_city !="") { echo e($parent_city); }else { echo e($nm_city); }
  ?> </option>
                  </select>
                </span></td>
              </tr>
            <tr>
              <td><strong>Handphone</strong></td>
              <td>&nbsp;</td>
              <td><strong>E-Mail</strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><input name="parent_hp" type="text" id="parent_hp" value="<?php echo e($parent_hp) ?>"></td>
              <td>&nbsp;</td>
              <td><input name="parent_email" type="text" id="parent_email" value="<?php echo e($parent_email) ?>"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        <tr>
          <td><strong>Marketing Info </strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><strong>Source Type  *</strong></td>
          <td><strong>Detail  *</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><span class="style2">
            <select name="mkt_source_type" id="mkt_source_type" onChange="this.form.submit()" >
              <option>Call In</option>
              <option>Walk In</option>
              <option>Event</option>
              <option>Partnership</option>				  
              <option selected="selected"> <?php echo e($mkt_source_type);  ?> </option>
              </select>
            <select name="mkt_source_event" id="mkt_source_event">
              <option value= "">
                <?php echo e($list_source_type)?>
                </option>
              <option selected="selected">
                <?php  if ($mkt_source_event !="") { echo e($mkt_source_event); }

   ?>
                </select>
            </span></td>
          <td colspan="3"><input name="mkt_source_event_dtl" type="text" id="mkt_source_event_dtl" value="<?php echo e($mkt_source_event_dtl) ?>" size="50"></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><strong>Media Source  *</strong></td>
          <td><strong>Media Source </strong><strong>Detail *</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><span class="style2">
            <select name="media_source" id="media_source" >
              <option value= "">
                <?php echo e($list_media_source)?>
                </option>
              <option selected="selected">
                <?php  		   if ($media_source !="") { echo e($media_source); }else { echo e($media_source); }

   ?>
                </select>
            </span></td>
          <td colspan="3"><input name="media_source_dtl" type="text" id="media_source_dtl" value="<?php echo e($media_source_dtl) ?>" size="50"></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="4"><a href="studentprogress.php?kd_biodata=<?php echo e(u($kode_student))?>" target="_parent">
            <input type="submit" name="Submit" value="Submit" />
            </a></td>
          <td>&nbsp;</td>
          </tr>
        </table>
        <label></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="bootom"><hr width="1000" /></td>
    </tr>
  </table>
</form>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
    <!-- /.content -->
	</form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post"><?php echo csrf_field(); ?>

          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
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
</body>
</html>
