<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$thn = in_val('thn', 'get');
$idr = in_val('idr', 'get');
$kdcbg = in_val('kdcbg', 'get');

$query_enroll_student = q_set($__p_query_enroll_student, "select id_prof_bill,rp_mount, tgl_cetak,id_stu  from ves_inc.tb_prof_bill where tgl_cetak >= '2023-03-01' and branch=? ", [(string) ($kdcbg)]);
$resource_enroll_student= db_query_or_die('errro_visitor1', $query_enroll_student, $__p_query_enroll_student ?? []);
	if(num(db_num_rows($resource_enroll_student)) > 0)
		{
		while ($row_es =   db_fetch($resource_enroll_student, PDO::FETCH_NUM))
			{
			$id_receipt = $row_es[0];
			$rp_mount = $row_es[1];
			$tgl_cetak = $row_es[2];
			$kd_biodata = $row_es[3];
			
if(num($rp_mount) > 900000){$nominal_dibagi = 900000;}else {$nominal_dibagi = $rp_mount;}
$mkt_team = num($nominal_dibagi) * 0.1;
$mkt_tool = num($nominal_dibagi) * 0.2;
$csr = num($nominal_dibagi) * 0.05;
$cntrsaving = num($nominal_dibagi) * 0.1;
$cntrincome = num($nominal_dibagi) * 0.14;
$ppn = num($nominal_dibagi) * 0.11;
			
		
$simpan_kntrb = q_set($__p_simpan_kntrb, "insert into ves_data.vos_distribute_sf (id_prof_bill, rp_amount, center_income, center_saving,csr,mkt_team,mkt_tool,dt_entry,ppn,kd_biodata) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ) ", [(string) ($id_receipt), (string) ($rp_mount), (string) ($cntrincome), (string) ($cntrsaving), (string) ($csr), (string) ($mkt_team), (string) ($mkt_tool), (string) ($tgl_cetak), (string) ($ppn), (string) ($kd_biodata)]);/* echo $simpan_kntrb (debug SQL versi lama) dihapus */die;
$resource_kntrb_mkt_team  = db_query_or_die('errro_simpan_1111', $simpan_kntrb, $__p_simpan_kntrb ?? []);	

				}

$baris = 1;
			}
echo "selesai";die;
