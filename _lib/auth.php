<?php
/*
 * Auth & session: login, logout, cek login, cek role.
 *
 * Variabel session yang dipakai halaman-halaman lama tetap sama:
 *   kd_staff, nama_lengkap, nama_depan, branch, kd_branch, posisi, level_posisi,
 *   kelompok (= tb_user.usergroup), kode_area, area, hari_ini, jam_in_log,
 *   awal_periode, st_login, st_quiz, mbl.
 *
 * Contoh cek role di halaman:
 *   auth_require(auth_is('posisi', 'AM', 'ACCM') || auth_is('kelompok', 'ACD'));
 */
defined('VCMS') or exit;

/** IP klien untuk log login (header proxy hanya dipakai bila berisi IP valid). */
function client_ip(): string
{
    foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR'] as $h) {
        $ip = $_SERVER[$h] ?? '';
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }
    }
    return $_SERVER['REMOTE_ADDR'] ?? '';
}

/**
 * Filter cabang per area (logika lama dari login.php).
 * Mengembalikan [fragmen SQL, parameter], mis. [" and kd_branch IN (?,?)", ['1','2']].
 */
function area_filter(mixed $kdArea, mixed $kdBranch, string $col = 'kd_branch'): array
{
    if (!preg_match('/^[A-Za-z0-9_.]+$/', $col)) {
        throw new InvalidArgumentException('Nama kolom tidak valid');
    }
    $branches = match ((string) $kdArea) {
        '5'     => null,
        '42'    => ['4', '5', '6'],
        '41'    => ['1', '2', '3'],
        '31'    => ['1', '2'],
        '21'    => ['2', '8'],
        default => [(string) $kdBranch],
    };
    if ($branches === null) {
        return ['', []];
    }
    return [" and $col IN (" . db_in($branches) . ')', $branches];
}

/**
 * Login berhasil: ganti session id, isi variabel session seperti login.php lama,
 * catat ke tb_report_user_login dan tb_log_activities.
 * $row = baris tb_user (assoc) dengan kolom nama_login, nama_detail, branch,
 * kd_branch, no, posisi, kd_area, level_posisi, usergroup, st_quiz.
 */
function auth_login(array $row, string $awalPeriode, int $mbl): void
{
    session_regenerate_id(true);
    $_SESSION = [];
    csrf_rotate();

    $hari_ini = date('Y-m-d');
    $jamskrg  = date('h:i:s');

    $_SESSION['st_login']     = 1;
    $_SESSION['st_quiz']      = $row['st_quiz'] ?? null;
    $_SESSION['kd_staff']     = $row['no'];
    $_SESSION['posisi']       = $row['posisi'];
    $_SESSION['nama_lengkap'] = $row['nama_detail'];
    $_SESSION['nama_depan']   = $row['nama_login'];
    $_SESSION['awal_periode'] = $awalPeriode;
    $_SESSION['branch']       = $row['branch'];
    // The activity log requires a non-NULL branch; legacy accounts can have no branch code.
    $kdBranch = (string) ($row['kd_branch'] ?? '');
    $_SESSION['kd_branch'] = $kdBranch;
    $_SESSION['kode_area']    = $row['kd_area'];
    $_SESSION['level_posisi'] = $row['level_posisi'];
    $_SESSION['hari_ini']     = $hari_ini;
    $_SESSION['kelompok']     = $row['usergroup'];
    $_SESSION['mbl']          = $mbl;
    $_SESSION['jam_in_log']   = $jamskrg;

    // Kompatibilitas: beberapa halaman lama masih menempelkan $_SESSION['area']
    // langsung ke SQL. Nilainya dibangun di server (bukan dari input user),
    // sama persis dengan login.php lama ($kd_cbg di sana tidak terdefinisi -> '').
    // Halaman hasil konversi harus memakai area_filter().
    $_SESSION['area'] = match ((string) $row['kd_area']) {
        '5'     => '',
        '42'    => " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')",
        '41'    => " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')",
        '31'    => " and (kd_branch= '1' or kd_branch= '2')",
        '21'    => " and (kd_branch= '2'or kd_branch= '8')",
        default => " and kd_branch= ''",
    };

    db_exec(
        'insert into tb_report_user_login(id_user_log, login_name_log, tgl_in_log, jam_in_log, ip_log) values (?, ?, ?, ?, ?)',
        [$row['no'], $row['nama_detail'], $hari_ini, $jamskrg, client_ip()]
    );
    db_exec(
        "insert into tb_log_activities (kd_user, kd_branch, kegiatan, dt_entry, jm_entry, status) values (?, ?, 'Login', ?, ?, '0')",
        [$row['no'], $kdBranch, $hari_ini, $jamskrg]
    );
}

/** Kondisi "sudah login" sama dengan atas.php lama. */
function auth_check(): bool
{
    return !empty($_SESSION['kd_staff'])
        && (!empty($_SESSION['nama_lengkap']) || !empty($_SESSION['kd_branch']));
}

/**
 * Hentikan halaman bila belum login.
 * $mode 'popup' = perilaku atas.php lama (alert + buka loginpop.php),
 *       'json'  = untuk endpoint AJAX (HTTP 401).
 */
function auth_require_login(string $mode = 'popup'): void
{
    if (auth_check()) {
        return;
    }
    http_response_code(401);
    if ($mode === 'json') {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'not_logged_in']);
        exit;
    }
    // Halaman di subfolder (accnt/, printable/, ecert/) membuka loginpop.php di root.
    $dir = realpath(dirname($_SERVER['SCRIPT_FILENAME'] ?? '')) ?: VCMS_ROOT;
    $rel = trim(str_replace('\\', '/', substr($dir, strlen(VCMS_ROOT))), '/');
    $base = $rel === '' ? '' : str_repeat('../', substr_count($rel, '/') + 1);
    echo "<script type=\"text/javascript\">\n";
    echo "alert('Karena tidak ada aktifitas, Anda Harus Login Terlebih Dahulu');\n";
    echo 'window.open(' . js($base . 'loginpop.php') . ",'popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');\n";
    echo "</script>";
    exit;
}

/** True bila $_SESSION[$field] sama dengan salah satu $values. */
function auth_is(string $field, string ...$values): bool
{
    return isset($_SESSION[$field]) && in_array((string) $_SESSION[$field], $values, true);
}

/** Hentikan halaman dengan 403 bila $allowed false. */
function auth_require(bool $allowed): void
{
    if ($allowed) {
        return;
    }
    error_log(sprintf('Akses ditolak: user %s ke %s', $_SESSION['kd_staff'] ?? '-', $_SERVER['REQUEST_URI'] ?? ''));
    if (!headers_sent()) {
        http_response_code(403);
    }
    echo "<script type=\"text/javascript\">\n";
    echo "alert('Anda tidak memiliki hak akses ke halaman ini');\n";
    echo "history.back();\n";
    echo "</script>";
    exit;
}

/** Hapus session sepenuhnya (data, cookie, file session). */
function auth_logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires'  => time() - 42000,
            'path'     => $p['path'],
            'domain'   => $p['domain'],
            'secure'   => $p['secure'],
            'httponly' => $p['httponly'],
            'samesite' => $p['samesite'],
        ]);
    }
    session_destroy();
}
