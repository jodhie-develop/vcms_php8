<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login('json');
header("Content-Type: application/json; charset=UTF-8");
ini_set("memory_limit","512M");
include __DIR__ . "/conndb.php";
/*
 * Versi lama memanggil MYSQL_ASSOC($query_list) (bukan fungsi) sehingga endpoint ini selalu
 * fatal error. Diperbaiki sesuai maksudnya: jalankan query (read-only) dan kirim JSON.
 */
$query_list = "select kd_biodata, concat(nama, ' ', middle_name, ' ',family_name) as lengkap from tb_biodata where (vip_status = 'E' or ves_status = 'E') and dt_entry > '2017-01-01'";
$resource_list = db_query_soft($query_list)->fetchAll(PDO::FETCH_ASSOC);

$output = [];
foreach ($resource_list as $data) {
    $output['suggestions'][] = [
        'kdb' => $data['kd_biodata'],
        'nama'  => $data['lengkap']
    ];
}

if (! empty($output)) {
    // Encode ke format JSON.
    echo json_encode($output);
}
