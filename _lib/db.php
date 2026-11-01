<?php
/*
 * Lapisan database berbasis PDO, pengganti ext/mysql (mysql_*).
 *
 * Satu koneksi bersama untuk semua database (ves_data, ves_inc, data_absen,
 * dbsertifikat) karena host & kredensialnya sama. db_use() meniru
 * mysql_select_db(): conndb.php / conndbs.php memilih database default,
 * query lintas database tetap memakai prefix (ves_inc.tabel).
 *
 * Contoh:
 *   $rows = db_all('SELECT no, nama_detail FROM tb_user WHERE kd_branch = ?', [$kd_cbg]);
 *   $stmt = db_query('SELECT ... WHERE tgl BETWEEN ? AND ?', [$awal, $akhir]);
 *   while ($row = $stmt->fetch(PDO::FETCH_NUM)) { ... }      // = mysql_fetch_row
 *   while ($row = $stmt->fetch()) { ... }                     // = mysql_fetch_array
 *   $n = db_exec('UPDATE ... WHERE id = ?', [$id]);           // jumlah baris terpengaruh
 *   $ids = [1, 2, 3]; db_all('... WHERE id IN (' . db_in($ids) . ')', $ids);
 */
defined('VCMS') or exit;

/** Koneksi dibuka saat query pertama (lazy), lalu database pilihan db_use() diaktifkan. */
function db(): PDO
{
    static $pdo = null, $active = null;
    if ($pdo === null) {
        $c = vcms_config('db');
        $dsn = sprintf(
            'mysql:host=%s;port=%d;charset=%s',
            $c['host'], (int) ($c['port'] ?? 3306), $c['charset'] ?? 'latin1'
        );
        $pdo = new PDO($dsn, $c['user'], $c['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
            // false = prepared statement asli (2 round-trip per query). true = parameter di-escape oleh
            // driver memakai charset koneksi dari DSN (aman), 1 round-trip: jauh lebih cepat untuk laporan
            // lama yang menjalankan ribuan query per halaman. Atur lewat config db.emulate_prepares.
            PDO::ATTR_EMULATE_PREPARES   => (bool) ($c['emulate_prepares'] ?? false),
            // Nilai dikembalikan sebagai string seperti mysql_* lama.
            PDO::ATTR_STRINGIFY_FETCHES  => true,
            Pdo\Mysql::ATTR_MULTI_STATEMENTS => false,
        ]);
        if (!empty($c['sql_mode'])) {
            $pdo->prepare('SET SESSION sql_mode = ?')->execute([$c['sql_mode']]);
        }
    }
    $want = db_selected();
    if ($want !== null && $want !== $active) {
        $pdo->exec('USE `' . db_real_name($want) . '`');
        $active = $want;
    }
    return $pdo;
}

/**
 * Nama database di kode (ves_data, ves_inc, data_absen, dbsertifikat) -> nama sebenarnya di server.
 * Hosting yang memberi awalan akun (mis. akun_ves_data) cukup mengisi config 'db_names':
 *   'db_names' => ['ves_data' => 'akun_ves_data', 'ves_inc' => 'akun_ves_inc', ...]
 * Kosong / tidak diisi = nama sama dengan di kode.
 */
function db_name_map(): array
{
    static $map = null;
    if ($map === null) {
        $map = [];
        foreach ((array) (vcms_config('db_names') ?? []) as $from => $to) {
            $from = strtolower((string) $from);
            $to = (string) $to;
            if (!preg_match('/^[A-Za-z0-9_]+$/', $from) || !preg_match('/^[A-Za-z0-9_]+$/', $to)) {
                throw new InvalidArgumentException('config db_names tidak valid: ' . $from . ' => ' . $to);
            }
            if ($from !== strtolower($to) || $from !== $to) {
                $map[$from] = $to;
            }
        }
    }
    return $map;
}

function db_real_name(string $name): string
{
    return db_name_map()[strtolower($name)] ?? $name;
}

/**
 * Ganti awalan database di SQL (ves_data.tabel, `ves_data`.`tabel`) sesuai db_name_map().
 * Isi string '...' / "..." (data) dan komentar tidak disentuh.
 */
function db_map_sql(string $sql): string
{
    static $re = null, $key = null;
    $map = db_name_map();
    if (!$map) {
        return $sql;
    }
    if ($key !== $map) {
        $names = implode('|', array_map('preg_quote', array_keys($map)));
        $re = '/\'(?:[^\'\\\\]|\\\\.|\'\')*\'|"(?:[^"\\\\]|\\\\.|"")*"|--(?=\s)[^\n]*|#[^\n]*|\/\*.*?\*\/'
            . '|(?<![A-Za-z0-9_$.`])(`?)(' . $names . ')\1(?=\s*\.)/is';
        $key = $map;
    }
    return preg_replace_callback($re, static function (array $m) use ($map): string {
        if (!isset($m[2]) || $m[2] === '') {
            return $m[0];   // string literal / komentar
        }
        return $m[1] . $map[strtolower($m[2])] . $m[1];
    }, $sql) ?? $sql;
}

function db_selected(?string $set = null): ?string
{
    static $name = null;
    if ($set !== null) {
        $name = $set;
    }
    return $name;
}

/** Pilih database default (pengganti mysql_select_db). */
function db_use(string $name): void
{
    if (!preg_match('/^[A-Za-z0-9_]+$/', $name)) {
        throw new InvalidArgumentException('Nama database tidak valid');
    }
    db_selected($name);
}

/**
 * Jalankan query dengan prepared statement; parameter posisi (?) atau nama (:x).
 * Query yang gagal melempar PDOException (halaman berhenti dengan pesan umum dari bootstrap).
 * Kode hasil konversi dari  mysql_query($q)  tanpa  or die  memakai db_query_soft().
 */
function db_query(?string $sql, array $params = []): PDOStatement
{
    // Kode lama kadang menjalankan variabel query yang belum diisi (cabang if tidak terpenuhi);
    // mysql_query(null) dulu hanya gagal diam-diam. Kembalikan hasil kosong yang sah.
    if ($sql === null || trim($sql) === '') {
        error_log('V-CMS db_query: SQL kosong [' . ($_SERVER['REQUEST_URI'] ?? 'cli') . ']');
        $sql = 'SELECT 1 FROM DUAL WHERE 1 = 0';
        $params = [];
    }
    return db_query_strict($sql, $params);
}

/**
 * Pengganti  mysql_query($q)  tanpa  or die : seperti dulu, query yang gagal tidak menghentikan
 * halaman. Error dicatat ke log (dan ditampilkan bila APP_ENV dev), lalu dikembalikan hasil kosong.
 * Banyak halaman lama punya query yang selalu gagal (alias salah, tabel tidak ada) tetapi sisa
 * halamannya tetap dipakai (mis. ve_monitoring.php).
 */
function db_query_soft(?string $sql, array $params = []): PDOStatement
{
    if ($sql === null || trim($sql) === '') {
        return db_query($sql);
    }
    try {
        return db_query_strict($sql, $params);
    } catch (PDOException $e) {
        error_log('V-CMS SQL gagal [' . ($_SERVER['REQUEST_URI'] ?? 'cli') . ']: ' . $e->getMessage()
            . ' | ' . preg_replace('/\s+/', ' ', mb_substr($sql, 0, 300)));
        if (APP_ENV === 'dev' && PHP_SAPI !== 'cli') {
            echo '<pre style="color:#b00">' . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</pre>';
        }
        // Koneksi/database tidak tersedia: tidak ada hasil kosong yang bisa dibuat, teruskan errornya.
        return db_query_strict('SELECT 1 FROM DUAL WHERE 1 = 0');
    }
}

/** Eksekusi prepared statement; PDOException diteruskan ke pemanggil. */
function db_query_strict(string $sql, array $params = []): PDOStatement
{
    $stmt = db()->prepare(db_map_sql($sql));
    foreach ($params as $key => $value) {
        $type = match (true) {
            is_int($value)  => PDO::PARAM_INT,
            is_bool($value) => PDO::PARAM_BOOL,
            $value === null => PDO::PARAM_NULL,
            default         => PDO::PARAM_STR,
        };
        $stmt->bindValue(is_int($key) ? $key + 1 : $key, $value, $type);
    }
    $stmt->execute();
    $GLOBALS['__db_last_stmt'] = $stmt;
    return $stmt;
}

/** Pengganti mysql_affected_rows(): jumlah baris terpengaruh query terakhir lewat db_query(). */
function db_affected_rows(): int
{
    return isset($GLOBALS['__db_last_stmt']) ? $GLOBALS['__db_last_stmt']->rowCount() : -1;
}

/**
 * Pengganti pola lama  mysql_query($sql) or die("pesan"):  SQL kosong atau gagal -> cetak pesan
 * yang sama lalu berhenti (detail error hanya ke log). Selain itu sama dengan db_query().
 */
function db_query_or_die(mixed $message, ?string $sql, array $params = []): PDOStatement
{
    if ($sql === null || trim($sql) === '') {
        error_log('V-CMS db_query_or_die: SQL kosong [' . ($_SERVER['REQUEST_URI'] ?? 'cli') . ']');
        exit((string) $message);
    }
    try {
        return db_query_strict($sql, $params);
    } catch (PDOException $e) {
        error_log('V-CMS SQL gagal [' . ($_SERVER['REQUEST_URI'] ?? 'cli') . ']: ' . $e->getMessage());
        if (APP_ENV === 'dev') {
            echo '<pre style="color:#b00">' . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</pre>';
        }
        exit((string) $message);
    }
}

/** Semua baris (default FETCH_ASSOC). */
function db_all(string $sql, array $params = [], int $mode = PDO::FETCH_ASSOC): array
{
    return db_query($sql, $params)->fetchAll($mode);
}

/** Satu baris atau null. */
function db_row(string $sql, array $params = [], int $mode = PDO::FETCH_ASSOC): ?array
{
    $row = db_query($sql, $params)->fetch($mode);
    return $row === false ? null : $row;
}

/** Kolom pertama baris pertama atau null. */
function db_value(string $sql, array $params = []): mixed
{
    $value = db_query($sql, $params)->fetchColumn();
    return $value === false ? null : $value;
}

/** INSERT/UPDATE/DELETE; mengembalikan jumlah baris terpengaruh. */
function db_exec(string $sql, array $params = []): int
{
    return db_query($sql, $params)->rowCount();
}

/**
 * Pengganti mysql_fetch_*() / mysql_num_rows() / mysql_num_fields() untuk kode hasil konversi
 * otomatis. Kode lama sering memanggilnya dengan variabel hasil query yang tidak terisi
 * (query di cabang if yang tidak jalan): PHP 5 hanya memberi warning dan mengembalikan
 * false/null, sedangkan $x->fetch() pada null adalah Error di PHP 8.
 */
function db_fetch(mixed $stmt, int $mode = PDO::FETCH_BOTH): mixed
{
    return $stmt instanceof PDOStatement ? $stmt->fetch($mode) : false;
}

function db_num_rows(mixed $stmt): ?int
{
    return $stmt instanceof PDOStatement ? $stmt->rowCount() : null;
}

function db_num_fields(mixed $stmt): ?int
{
    return $stmt instanceof PDOStatement ? $stmt->columnCount() : null;
}

/** Pengganti mysql_insert_id(). */
function db_insert_id(): string
{
    return db()->lastInsertId();
}

/**
 * Untuk query yang dirakit bertahap (termasuk di dalam if/else) pada kode hasil konversi
 * otomatis: q_set() mengisi ulang daftar parameter, q_add() menambahkannya, keduanya
 * mengembalikan potongan SQL. Contoh:
 *   $q = q_set($__p_q, "SELECT ... WHERE a = ?", [$a]);
 *   if ($b) { $q .= q_add($__p_q, " AND b = ?", [$b]); }
 *   db_query($q, $__p_q ?? []);
 */
function q_set(?array &$params, mixed $sql, array $p = []): string
{
    $params = $p;
    return (string) $sql;
}

function q_add(?array &$params, mixed $sql, array $p = []): string
{
    $params = array_merge($params ?? [], $p);
    return (string) $sql;
}

/** Placeholder untuk klausa IN: db_in([a,b,c]) -> "?,?,?" (array kosong -> "NULL"). */
function db_in(array $values): string
{
    return $values ? implode(',', array_fill(0, count($values), '?')) : 'NULL';
}
