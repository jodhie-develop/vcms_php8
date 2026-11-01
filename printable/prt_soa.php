<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$idsoa = in_val('idsoa', 'get');


$query_adm = q_set($__p_query_adm, "select nama, enroll_date, cabang, school, country, adm_pic,tgl_intake,pic,kd_biodata from tb_sales_report a left join tb_master_partner b on a.kd_school = b.kd_school where id_soa = ? ", [(string) ($idsoa)]);

	$resource_adm  = db_query_soft($query_adm, $__p_query_adm ?? []);
	$keluar_adm  = db_num_rows($resource_adm);
	if(num(db_num_rows($resource_adm)) > 0)
		{
		while ($row_adm   =  db_fetch($resource_adm, PDO::FETCH_NUM))
			{
			$nama= $row_adm [0];
			$enroll_date= $row_adm [1];
			$cabang= $row_adm [2];
			$school= $row_adm [3];
			$country= $row_adm [4];
			$adm_pic= $row_adm [5];		
			$tgl_intake= $row_adm [6];	
			$sc_name= $row_adm [7];	
			$kd_biodata= $row_adm [8];	
			
			
				
			}
		}
$query_nik = q_set($__p_query_nik, "select nik from tb_nik  where kd_biodata = ? ", [(string) ($kd_biodata)]);
$resource_nik  = db_query_soft($query_nik, $__p_query_nik ?? []);
while ($row_nik   =  db_fetch($resource_nik, PDO::FETCH_NUM))
	{
	$nik= $row_nik[0];
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>SOA - <?php echo e($nama) ?></title>
	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>
</head>
<body>
<div id="page-wrap">
  <textarea id="header">STATEMENT OF ACCOUNT</textarea>
		<div id="identity2">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
		    <tbody>
		      <tr>
		        <td width="50%"><strong>Student Name :<?php echo e($nama) ?></strong><br />		          
	            <strong>Nik : <?php echo e($nik) ?></strong></td>
		        <td align="right"><img src="../imgs/ve.png" width="84" height="55" alt=""/><br />
	            <strong><?php echo e($idsoa) ?></strong></td>
	          </tr>
	        </tbody>
	      </table>
		  <br />
		  <div id="logo2">
		    <div id="logohelp2"></div>
	      </div>
	  </div>
		
		<div style="clear:both"></div>
		<div id="customer">
		  <table id="meta">
              <tr>
                <td align="left" class="meta-head">Enroll Date</td>
                <td><?php echo e($enroll_date) ?></td>
                <td align="left" class="meta-head">School Destination</td>
                <td><?php echo e($school) ?> - <?php echo e($country) ?></td>				  
              </tr>
              <tr>
                <td align="left" class="meta-head">Center</td>
                <td><?php echo e($cabang) ?></td>
                <td align="left" class="meta-head">Intake Date</td>
                <td><?php echo e($tgl_intake) ?></td>				  
              </tr>
              <tr>
                    <td width="116" align="right" class="meta-head">Admission</td>
                    <td width="172"><?php echo e($adm_pic) ?></td>
				                      <td width="116" align="right" class="meta-head">Consultant</td>
                    <td width="172"><?php echo e($sc_name) ?></td>
            </tr>
          </table>
	  </div>
	  <table id="items">
		  <tr>
		      <th width="81">Date    </th>
		      <th width="230"> Description</th>
		      <th width="94">Ref</th>
		      <th width="146">Received</th>
		      <th width="138">Expenses</th>
		      <th width="83">Balance</th>
		  </tr>
	          <?php 
	$nomor = 1;
			$query_soa = q_set($__p_query_soa, "SELECT a.dt_entry, a.keterangan, no_ref,   a.rp_debet FROM ves_data.adm_soa a\r
where a.id_soa = ? and keterangan = 'Service Fee Paid'", [(string) ($idsoa)]);

			$resource_soa = db_query_or_die('errro_rr', $query_soa, $__p_query_soa ?? []);

			if(num(db_num_rows($resource_soa)) > 0)
				{
							$nomor_soa = 1; $last = db_num_rows($resource_soa);
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
					$no_ref= $row_soa[2];
					$deskripsi= $row_soa[11];						

						
						?>			  
		  <tr class="item-row">

	        <td class="item-name"><?php echo e($tgl_entry) ?></td>
	        <td colspan="2" class="item-name"><?php echo e($keterangan) ?><br />	          <em><?php echo e($no_ref) ?></em></td>
	        <td class="item-name" align="right">Rp.  <?php echo number_format(num((float)$rp_debet),0,".",".") ?></td>
	        <td class="item-name" align="right">Rp.  <?php echo number_format(num((float)$rp_kredit),0,".",".") ?></td>			  
	        <td class="item-name" align="right">Rp.  <?php echo number_format(num((float)$saldo),0,".",".") ?></td>

		  </tr><?php   } } ?>			  
	          <?php 
	$nomor = 1;
			$query_soa = q_set($__p_query_soa, "SELECT\r
a.dt_entry, a.keterangan, a.id_receipt, a.rp_debet,a.rp_kredit,@saldo:=@saldo+a.rp_debet-a.rp_kredit AS saldo , app_by, dt_app, ack_by,dt_ack,  no_ref,a.deskripsi  FROM ves_data.adm_soa a\r
JOIN (SELECT @saldo:=0) a where a.id_soa = ?   and keterangan <> 'Service Fee Paid' union select null,  null,  null,  null, '',@saldo, null,null,  null,  null,null,null ", [(string) ($idsoa)]);

			$resource_soa = db_query_or_die('errro_rr', $query_soa, $__p_query_soa ?? []);

			if(num(db_num_rows($resource_soa)) > 0)
				{
							$nomor_soa = 1; $last = db_num_rows($resource_soa);
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
		  <tr class="item-row">
	  <?php if ($nomor_soa < $last){ ?>
	        <td class="item-name"><?php echo e($tgl_entry) ?></td>
	        <td colspan="2" class="item-name"><?php echo e($keterangan) ?><br />	          <em><?php echo e($no_ref) ?></em></td>
	        <td class="item-name" align="right">Rp.  <?php echo number_format(num((float)$rp_debet),0,".",".") ?></td>
	        <td class="item-name" align="right">Rp.  <?php echo number_format(num((float)$rp_kredit),0,".",".") ?></td>			  
	        <td class="item-name" align="right">Rp.  <?php echo number_format(num((float)$saldo),0,".",".") ?></td>
		  <?php } ?>
		  </tr><?php  $nomor_soa = num($nomor_soa)+ 1; } } ?>	
		  <tr>
		      <td class="blank"> </td>
		      <td class="blank"></td>
		      <td class="blank"></td>
		      <td class="total-line balance"><strong>Saldo Akhir</strong></td>
		      <td colspan="2" class="total-line balance"><span class="price"><strong>Rp.  <?php echo number_format(num($saldo),0,".",".") ?></strong></span></td>
	      </tr>
		  <tr>
		    <td colspan="6" class="blank"></td>
	      </tr>
		  <tr>
		    <td colspan="6" class="blank"></td>
	      </tr>
		</table>
	  <br />
  <table width="100%"id="itemsa">
    <tbody>
	      <tr>
	        <td width="50%">Checked  By:<br/>
              <br/>
              <br/>
            <strong><?php echo e($nama_lengkap) ?></strong><br /></td>
	        <td width="50%" align="right">Approved By:<br/>
              <br/>
              <br/>
            <strong><?php echo e($nama_student) ?></strong><br /></td>
          </tr>
        </tbody>
  </table>
	  <h5 align="right"><br />
      </h5>
<br/><hr><br/>

</div>
</body>
</html>