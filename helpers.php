<?php
/**
 * ============================================================================
 * HELPER SYSTEM & DATA MANAGEMENT (Fix & Safe Version)
 * ============================================================================
 * Menangani penyimpanan data terpusat (Session & JSON) serta
 * fungsi bantuan untuk kalkulasi katalog dan UI/UX.
 */

// Aktifkan error reporting sementara untuk mendeteksi lokasi error jika ada kesalahan lain
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Inisialisasi Session Aman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Definisi Konstanta File Storage
if (!defined('DATA_FILE')) {
    define('DATA_FILE', __DIR__ . '/data/registrations.json');
}

/* ============================================================================
 *  FUNGSI UTAMA MANAJEMEN DATA PENDAFTARAN (JSON & SESSION)
 * ============================================================================ */

if (!function_exists('getAllRegistrations')) {
    /**
     * Mengambil seluruh data pendaftaran dari JSON File & Session
     */
    function getAllRegistrations() {
        $data = [];

        // 1. Ambil dari file JSON jika ada
        if (file_exists(DATA_FILE)) {
            $jsonContent = file_get_contents(DATA_FILE);
            $data = json_decode($jsonContent, true) ?? [];
        }

        // 2. Gabungkan dengan data sementara di Session (jika ada)
        if (!empty($_SESSION['registrations'])) {
            $data = array_merge($_SESSION['registrations'], $data);
        }

        return $data;
    }
}

if (!function_exists('saveRegistration')) {
    /**
     * Menyimpan pendaftaran baru ke JSON File & Session
     */
    function saveRegistration($newRecord) {
        // Beri ID Unik & Timestamp jika belum ada
        if (empty($newRecord['id'])) {
            $newRecord['id'] = 'REG-' . strtoupper(substr(md5(uniqid()), 0, 6));
        }
        if (empty($newRecord['timestamp'])) {
            $newRecord['timestamp'] = date('Y-m-d H:i:s');
        }

        // 1. Simpan ke Session
        if (!isset($_SESSION['registrations'])) {
            $_SESSION['registrations'] = [];
        }
        array_unshift($_SESSION['registrations'], $newRecord);

        // 2. Simpan Permanen ke File JSON
        $dataDir = dirname(DATA_FILE);
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }

        $existingData = [];
        if (file_exists(DATA_FILE)) {
            $jsonContent = file_get_contents(DATA_FILE);
            $existingData = json_decode($jsonContent, true) ?? [];
        }

        array_unshift($existingData, $newRecord);
        file_put_contents(DATA_FILE, json_encode($existingData, JSON_PRETTY_PRINT));

        return $newRecord;
    }
}

/* ============================================================================
 *  FUNGSI KATALOG KURSUS & FORMATTER
 * ============================================================================ */

if (!function_exists('findCourse')) {
    /**
     * Mencari data kursus spesifik berdasarkan Kode Kursus (misal: 'PHP-01' atau 'WEB-01')
     * Mencakup data dari data.php maupun array katalog bawaan.
     */
    function findCourse(string $code, array $customCourses = []): ?array {
        $cleanCode = strtoupper(trim($code));

        // 1. Prioritaskan pencarian pada array kustom yang dikirim
        if (!empty($customCourses)) {
            foreach ($customCourses as $c) {
                if (isset($c['code']) && strtoupper(trim($c['code'])) === $cleanCode) {
                    return $c;
                }
            }
        }

        // 2. Jika ada file data.php, gunakan $coursesData dari data.php
        $dataFilePath = __DIR__ . '/data.php';
        if (file_exists($dataFilePath)) {
            include_once $dataFilePath;
            if (isset($coursesData) && isset($coursesData[$cleanCode])) {
                return array_merge(['code' => $cleanCode], $coursesData[$cleanCode]);
            }
        }

        // 3. Fallback ke Data Master Standar Proyek KursusKu
        $defaultCourses = [
            'WEB-01' => ['code' => 'WEB-01', 'name' => 'Web Dasar', 'fee' => 200000, 'quota' => 30, 'registered' => 12, 'start_date' => '2026-09-21'],
            'PHP-01' => ['code' => 'PHP-01', 'name' => 'PHP Dasar', 'fee' => 250000, 'quota' => 30, 'registered' => 18, 'start_date' => '2026-09-22'],
            'PHP-02' => ['code' => 'PHP-02', 'name' => 'PHP Lanjutan', 'fee' => 300000, 'quota' => 25, 'registered' => 24, 'start_date' => '2026-09-24'],
            'LAR-01' => ['code' => 'LAR-01', 'name' => 'Laravel Fundamental', 'fee' => 350000, 'quota' => 25, 'registered' => 25, 'start_date' => '2026-09-28'],
            'DB-01'  => ['code' => 'DB-01',  'name' => 'MySQL Dasar', 'fee' => 275000, 'quota' => 20, 'registered' => 0,  'start_date' => '2026-10-01'],
            'UI-01'  => ['code' => 'UI-01',  'name' => 'UI Web Dasar', 'fee' => 225000, 'quota' => 35, 'registered' => 9,  'start_date' => '2026-10-03'],
        ];

        return $defaultCourses[$cleanCode] ?? null;
    }
}

if (!function_exists('rupiah')) {
    /**
     * Function Format Rupiah Sederhana (Menerima Integer/Float)
     */
    function rupiah($amount): string
    {
        return 'Rp ' . number_format((float)$amount, 0, ',', '.');
    }
}

if (!function_exists('formatRupiah')) {
    /**
     * Alias fungsi formatRupiah agar tidak crash saat dipanggil versi lain
     */
    function formatRupiah($amount): string
    {
        return rupiah($amount);
    }
}

if (!function_exists('statusKursus')) {
    /**
     * Function Penentuan Status Kursus (Penuh / Tersedia)
     */
    function statusKursus(int $quota, int $registered): string
    {
        return $registered >= $quota ? 'Penuh' : 'Tersedia';
    }
}

if (!function_exists('sisaKursi')) {
    /**
     * Function Menghitung Sisa Kursi
     */
    function sisaKursi(int $quota, int $registered): int
    {
        return max(0, $quota - $registered);
    }
}

if (!function_exists('formatTanggal')) {
    /**
     * Function Format Tanggal Standard (ISO ke DD-MM-YYYY)
     */
    function formatTanggal(string $date): string
    {
        if (empty($date)) return '-';
        try {
            $value = new DateTimeImmutable($date);
            return $value->format('d-m-Y');
        } catch (Exception $e) {
            return htmlspecialchars($date);
        }
    }
}

if (!function_exists('formatNiceDate')) {
    /**
     * Format Tanggal Tampilan Lengkap (Contoh: 30 Sep 2026, 14:20 WIB)
     */
    function formatNiceDate($datetimeStr) {
        if (empty($datetimeStr)) return '-';
        $time = strtotime($datetimeStr);
        if (!$time) return htmlspecialchars($datetimeStr);
        return date('d M Y, H:i', $time) . ' WIB';
    }
}

/* ============================================================================
 *  FUNGSI BADGE VISUAL & STATISTIK
 * ============================================================================ */

if (!function_exists('renderParticipantBadge')) {
    /**
     * Render Badge Kategori Peserta dengan Gaya Warna HTML Estetik
     */
    function renderParticipantBadge($type) {
        $normalized = strtolower(trim($type));
        switch ($normalized) {
            case 'mahasiswa':
                return '<span style="background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; padding: 4px 10px; border-radius: 30px; font-size: 0.75rem; font-weight: 700;"><i class="fa-solid fa-user-graduate"></i> Mahasiswa</span>';
            case 'guru':
                return '<span style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 4px 10px; border-radius: 30px; font-size: 0.75rem; font-weight: 700;"><i class="fa-solid fa-chalkboard-user"></i> Guru</span>';
            default:
                return '<span style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 4px 10px; border-radius: 30px; font-size: 0.75rem; font-weight: 700;"><i class="fa-solid fa-user"></i> Umum</span>';
        }
    }
}

if (!function_exists('renderSourceBadge')) {
    /**
     * Render Badge Sumber Data (P5 vs P6)
     */
    function renderSourceBadge($source) {
        if (stristr($source, 'P6') !== false) {
            return '<span style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 3px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700;">Form P6</span>';
        }
        return '<span style="background: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; padding: 3px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700;">Form P5</span>';
    }
}

if (!function_exists('findRegistrationById')) {
    /**
     * Cari Data Pendaftaran berdasarkan ID Unik
     */
    function findRegistrationById($id) {
        $all = getAllRegistrations();
        foreach ($all as $item) {
            if (isset($item['id']) && $item['id'] === $id) {
                return $item;
            }
        }
        return null;
    }
}

if (!function_exists('getRegistrationStats')) {
    /**
     * Menghitung Total Statistik Pendaftaran (Total Pendaftar & Total Pendapatan)
     */
    function getRegistrationStats() {
        $all = getAllRegistrations();
        $totalCount   = count($all);
        $totalRevenue = 0;

        foreach ($all as $item) {
            $totalRevenue += ($item['grand_total'] ?? $item['total_fee'] ?? $item['base_price'] ?? 0);
        }

        return [
            'total_count'   => $totalCount,
            'total_revenue' => $totalRevenue
        ];
    }
}

if (!function_exists('clearAllRegistrations')) {
    /**
     * Menghapus/Mereset Seluruh Riwayat Data (Termasuk File JSON & Session)
     */
    function clearAllRegistrations() {
        $_SESSION['registrations'] = [];
        if (file_exists(DATA_FILE)) {
            file_put_contents(DATA_FILE, json_encode([], JSON_PRETTY_PRINT));
        }
        return true;
    }
}

// ----------------------------------------------------------------------------
// AMAN UNTUK REQUIRE_ONCE
// Cegah render antarmuka HTML jika helpers.php di-include oleh file lain
// ----------------------------------------------------------------------------
if (basename($_SERVER['SCRIPT_FILENAME']) !== 'helpers.php') {
    return;
}

// Fitur Pengujian langsung findCourse() jika helpers.php dibuka secara independen
$searchCode = trim($_GET['code'] ?? 'PHP-01');
$searchResult = findCourse($searchCode);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpers System & Function Tester — KursusKu</title>
    
    <!-- Google Fonts & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #0d625b;
            --primary-light: #ccfbf1;
            --bg-body: #f0fdf4;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #cbd5e1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
            color: var(--text-dark);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header Navigation */
        .header-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px 30px;
            box-shadow: 0 10px 30px rgba(15, 118, 110, 0.08);
            border: 1px solid rgba(15, 118, 110, 0.1);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-title i {
            font-size: 1.8rem;
            color: var(--primary);
            background: var(--primary-light);
            padding: 12px;
            border-radius: 12px;
        }

        .header-title h1 {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .btn-back {
            text-decoration: none;
            color: var(--primary);
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--primary-light);
            border-radius: 10px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: var(--primary);
            color: white;
        }

        /* Form Search Card */
        .form-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            align-items: center;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 0.95rem;
            outline: none;
            font-family: 'JetBrains Mono', monospace;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 13px 22px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
        }

        /* Result Display Card */
        .result-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .code-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid var(--primary);
            border-radius: 12px;
            padding: 16px 20px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            color: #0f172a;
            white-space: pre-wrap;
            word-break: break-all;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER NAVIGATION -->
    <div class="header-card">
        <div class="header-title">
            <i class="fa-solid fa-gears"></i>
            <div>
                <h1>Helpers System Inspector</h1>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Pengujian Fungsi Helper & Pencarian Kursus Real-time findCourse()</p>
            </div>
        </div>
        <a href="index.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- CARI KURSUS TESTER -->
    <div class="form-card">
        <form method="GET" action="helpers.php">
            <label style="display:block; font-weight:700; margin-bottom:8px; font-size:0.9rem;">Uji Pencarian Kode Kursus (findCourse):</label>
            <div class="form-grid">
                <input type="text" name="code" class="form-control" placeholder="Masukkan kode misal: PHP-01, LAR-01, WEB-01..." value="<?= htmlspecialchars($searchCode) ?>">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Kursus
                </button>
            </div>
        </form>
    </div>

    <!-- HASIL OUTPUT FINDCOURSE -->
    <div class="result-card">
        <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-code" style="color: var(--primary);"></i> Output Hasil findCourse("<?= htmlspecialchars($searchCode) ?>")
        </h3>
        
        <?php if ($searchResult): ?>
            <div class="code-box"><?= print_r($searchResult, true) ?></div>
        <?php else: ?>
            <div class="code-box" style="border-left-color: #ef4444; color: #b91c1c;">
                Kursus dengan kode "<?= htmlspecialchars($searchCode) ?>" tidak ditemukan di sistem.
            </div>
        <?php endif; ?>
    </div>

</div>

</body>
</html>