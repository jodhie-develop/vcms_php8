<?php
/*
 * Helper khusus aplikasi V-CMS yang dipakai beberapa halaman.
 */
defined('VCMS') or exit;

/**
 * Kolom harga per cabang di vip_mst_price (c1, c2, ..., c00).
 * Nama kolom tidak bisa dijadikan parameter prepared statement, jadi kode cabang
 * divalidasi (hanya angka) dan dikutip dengan backtick.
 */
function kol_harga(mixed $kdcbg): string
{
    if (!preg_match('/^\d{1,2}$/', (string) $kdcbg)) {
        throw new RuntimeException('Kode cabang tidak valid untuk kolom harga: ' . $kdcbg);
    }
    return '`c' . $kdcbg . '`';
}
