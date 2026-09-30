<?php
/**
 * ============================================================================
 * HELPER SYSTEM & DATA MANAGEMENT (Tersinkronisasi)
 * ============================================================================
 * File ini menangani penyimpanan data terpusat (Session & JSON) serta
 * fungsi bantuan untuk tampilan UI/UX yang estetik dan dinamis.
 */

// 1. Inisialisasi Session Aman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Definisi Konstanta File Storage
if (!defined('DATA_FILE')) {
    define('DATA_FILE', __DIR__ . '/data/registrations.json');
}

/* ============================================================================
 *  FUNGSI UTAMA (VERSI AWAL - TETAP DIJAGA & TIDAK DIUBAH)
 * ============================================================================ */

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


/* ============================================================================
 *  FUNGSI TAMBAHAN (FITUR EKSTRA & VISUAL HELPER ESTETIK)
 * ============================================================================ */

/**
 * Format Angka menjadi Mata Uang Rupiah (Contoh: Rp 500.000)
 */
function formatRupiah($amount) {
    return 'Rp ' . number_format((float)$amount, 0, ',', '.');
}

/**
 * Format Tanggal menjadi Tampilan Ramah Pengguna (Contoh: 30 Sep 2026, 14:20 WIB)
 */
function formatNiceDate($datetimeStr) {
    if (empty($datetimeStr)) return '-';
    $time = strtotime($datetimeStr);
    if (!$time) return htmlspecialchars($datetimeStr);
    return date('d M Y, H:i', $time) . ' WIB';
}

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

/**
 * Render Badge Sumber Data (P5 vs P6)
 */
function renderSourceBadge($source) {
    if (stristr($source, 'P6') !== false) {
        return '<span style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 3px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700;">Form P6</span>';
    }
    return '<span style="background: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; padding: 3px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700;">Form P5</span>';
}

/**
 * Cari Data Pendaftaran berdasarkan ID Unik (Misal: REG-XXXXXX atau TRX-P6-XXXXXX)
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