<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ob_start();
ini_set('memory_limit', '150M'); ?>
<?php 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');


$ed = in_val('ed', 'get');
$idsoa = in_val('ids', 'get');
$no = in_val('no', 'get');

$st = in_val('st', 'get');
$new = in_val('new', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$branch = $_SESSION['branch']; 
$asal = in_val('asal', 'get');
$query_adm = q_set($__p_query_adm, "SELECT kd_biodata, enroll_date, final_status,step,nama,ori_school,sc_name, adm_pic,dest_country,dest_school,group_school,p_np, program_clasifie,mp_ap,dest_program,major,h_nh, ar,agent_referal,tf_full_program,pasport,tf_fee_paid, tf_term_paid,tf_balance_fee,tgl_intake,program_duration,comm_date,\r
\tcomm_date_end,pdo_date,remark_problem,remark_solution,next_update, pic,kd_branch, dt_entry,kd_school,tf_balance_fee_due_date,date_format(tgl_intake, '%m'),date_format(tgl_intake, '%Y')  \r
\tFROM  adm_stu_progress a where kd_biodata = ? and enroll_date = ? and aktif = 1", [(string) ($kdb), (string) ($ed)]);
	
		
	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$kdb = $row_adm['0'];$enroll_date = $row_adm['1']; $adm_status = $row_adm['2'];$adm_step = $row_adm['3'];
			$student_name = $row_adm['4'];$ori_school = $row_adm['5'];$sc_pic = $row_adm['6']; $adm_pic = $row_adm['7'];
			$country_dest = $row_adm['8'];$school_dest = $row_adm['9'];$school_group = $row_adm['10'];$partner_status = $row_adm['11'];
			$program_clasifie = $row_adm['12'];$program_status = $row_adm['13'];$program_dest = $row_adm['14'];
			$major = $row_adm['15'];$major_group = $row_adm['16']; $refer_status = $row_adm['17'];
			$agent_referal = $row_adm['18'];$tf_full_program = $row_adm['19'];$pasport = $row_adm['20'];
			$tf_fee_paid = $row_adm['21']; $tf_term_paid = $row_adm['22'];$tf_balance_fee = $row_adm['23'];
			$tgl_intake = $row_adm['24'];$program_duration = $row_adm['25'];$comm_date = $row_adm['26'];
			$comm_date_end = $row_adm['27'];$pdo_date = $row_adm['28']; $remark_problem = $row_adm['29'];
			$remark_solution = $row_adm['30'];$next_fu_date = $row_adm['31'];$nama_lengkap = $row_adm['32']; $kdcbg = $row_adm['33']; $tgl_hari_ini = $row_adm['34'];$kode_sekolah = $row_adm['35'];$tf_balance_fee_due_date= $row_adm['36'];$intake_date_m = $row_adm['37'];$intake_date_y = $row_adm['38'];$st =0;
			}
		}
if (num($kdcbg) ==1){$cabang = 'East Sby';}
if (num($kdcbg) ==2){$cabang = 'West Sby';}
if (num($kdcbg) ==3){$cabang = 'Denpasar';}
if (num($kdcbg) ==4){$cabang = 'South Jkt';}
if (num($kdcbg) ==5){$cabang = 'North Jkt';}
if (num($kdcbg) ==6){$cabang = 'West Jkt';}
if (num($kdcbg) ==7){$cabang = 'Bandung';}
if (num($kdcbg) ==8){$cabang = 'Malang';}
?>
<!DOCTYPE html>
<html>
<style type="text/css">
<!--
.style24 {
	color: #030303;
	font-size:90%;	
	}
-->
.style32 {
	color:#000;
	font-size:70%;
	}
-->
	.style33 {
	color:#000;
	font-size:75%;
	}
-->
	.style34 {
	color:#000;
	font-size:80%;
	}
-->	
	    .tbl{
     width: 700pt;
     border: 1px solid #000;
    }
</style>
<head>


</style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <table width="800" id="">

	        <tbody>

	          <tr>
	            <td width="128" height="14" align=center  class="style34"><img src="imgs/ves.jpg" width="84" height="51" alt=""/></td>
	            <td height="14" colspan="2" align=center  class="style34"><strong>
	              <h5>Statement of Account<br>
                  </h5>
	            </strong>ID : <?php echo e($idsoa) ?></td>
	            <td width="103" height="14" align=center  class="style34">&nbsp;</td>
              </tr>
	          <tr>
	            <td height="14" colspan="4" align=left   class="style34" ><hr></td>
              </tr>
	          <tr>
	            <td height="14" colspan="2" align=left   class="style34" >Student Name :<br>
	              <strong><?php echo e($student_name); ?></strong><br>	              
                <br></td>
	            <td colspan="2" align=left   class="style34">School Destination :<br>
                  <strong><?php echo e($school_dest); ?> - <?php echo e($country_dest); ?> </strong><br>                
                <br></td>
              </tr>
	          <tr>
	            <td height="14" align=left   class="style34" >Center :<br>
                <strong><?php echo e($cabang); ?></strong> <br></td>
	            <td width="225" align=center   class="style34" >&nbsp;</td>
	            <td width="208" align=left   class="style34">Admission Name :<br>
                <strong><?php echo e($adm_pic); ?></strong></td>
	            <td align=center   class="style34">&nbsp;</td>
              </tr>
	          <tr>
	            <td height="14" align=left   class="style34" >&nbsp;</td>
	            <td align=center   class="style34" >&nbsp;</td>
	            <td align=left   class="style34">&nbsp;</td>
	            <td align=center   class="style34">&nbsp;</td>
              </tr>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
    <table width="800" id="table" border="0.5" cellpadding="0" cellspacing="0">
      <tbody>
<tr>
            <td width="20" align=center class="style24"><strong>ID</strong></td>
            <td width="60" align=center class="style24"><strong>Date</strong></td>
            <td width="150" align=center class="style24"><strong>Description</strong></td>
            <td width="70" align=center class="style24"><strong>Number</strong></td>
            <td width="70" align=center class="style24"><strong>Amount <br>
            Received</strong></td>
            <td width="70" align=center class="style24"><strong>Amount <br>
            Expenses</strong></td>
            <td width="70" align=center class="style24"><strong>Balance</strong></td>
            <td width="70" align=center class="style24"><strong>App/Ack <br>
            By</strong></td>
            <td width="70" align=center class="style24"><strong>Reference<br>
No</strong></td>
            <td width="35" height="14" align=center class="style24"><strong>Sign</strong></td>
          </tr>
          <?php 
	$nomor = 1;
			$query_soa = q_set($__p_query_soa, "SELECT\r
a.dt_entry, a.keterangan, a.id_receipt, a.rp_debet,a.rp_kredit,@saldo:=@saldo+a.rp_debet-a.rp_kredit AS saldo , app_by, dt_app, ack_by,dt_ack,  no_ref,a.deskripsi  FROM ves_data.adm_soa a\r
JOIN (SELECT @saldo:=0) a where a.id_soa = ?   union select null,  null,  null,  null, 'SALDO AKHIR',@saldo, null,null,  null,  null,null,null", [(string) ($idsoa)]);

			$resource_soa = db_query_or_die('errro_rr', $query_soa, $__p_query_soa ?? []);
			if(num(db_num_rows($resource_soa)) > 0)
				{
				while ($row_soa=  db_fetch($resource_soa, PDO::FETCH_NUM))
					{
						$st_app = 0;
						$st_ack = 0;
					$tgl_entry= $row_soa[0];
					$keterangan= $row_soa[1];
					$id_receipt= $row_soa[2];
					$rp_debet= $row_soa[3];
					$rp_kredit= $row_soa[4];						
					$saldo= $row_soa[5];
					$app_by= $row_soa[6];
					$dt_app= $row_soa[7];
					$ack_by= $row_soa[8];
					$dt_ack= $row_soa[9];						
					$no_ref= $row_soa[10];
					$deskripsi= $row_soa[11];						

						
					?>          
          <tr>
            <td align=center class="style32"><?php echo e($nomor) ?></td>
            <td align=center class="style32"><?php echo e($tgl_entry) ?></td>
            <td align=left class="style32"><?php echo e($keterangan) ?><br>              <?php echo e($deskripsi) ?></td>
            <td align=center class="style32"><?php echo e($no_ref) ?></td>
            <td align=center class="style32"><?php echo number_format(num($rp_debet),0,".",".")?></td>
            <td align=center class="style32"><?php echo number_format(num($rp_kredit),0,".",".")?></td>
            <td align=center class="style32"><?php echo number_format(num($saldo),0,".",".")?></td>
            <td align=center class="style32"><?php echo e($app_by) ?><br>              <?php echo e($ack_by) ?></td>
            <td align=center class="style32"><?php echo e($no_ref) ?></td>
            <td height="14" align=center class="style32">&nbsp;</td>
          </tr><?php  $nomor = num($nomor) + 1;} } ?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
    <br>
    <table width="800" id="table3">
      <tbody>
        <tr>
          <td width="128" height="14" align=left   class="style34" >&nbsp;</td>
          <td width="225" align=center   class="style34" >&nbsp;</td>
          <td width="208" align=left   class="style34">Check By</td>
          <td width="103" align=center   class="style34">Approved By</td>
        </tr>
        <tr>
          <td height="14" align=left   class="style34" >&nbsp;</td>
          <td align=center   class="style34" >&nbsp;</td>
          <td align=left   class="style34">&nbsp;</td>
          <td align=center   class="style34">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" align=left   class="style34" >&nbsp;</td>
          <td align=center   class="style34" >&nbsp;</td>
          <td align=left   class="style34">&nbsp;</td>
          <td align=center   class="style34">&nbsp;</td>
        </tr>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<br>
<br>
       	 
   	  <br>
   	  <!-- /.box-body -->

</body>
</html>
<?php
    $content = ob_get_clean();
	$namafile = "ocp.$kode_student.pdf";
    // convert in PDF
    require_once VCMS_ROOT . '/_lib/html2pdf.php';   // spipu/html2pdf 5.x (pengganti html2pdf/ lama)
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
 		$html2pdf->setTestTdInOnePage(false);		
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($namafile);
    }
    catch(HTML2PDF_exception $e) {
        html2pdf_fail($e);
    }
?>
