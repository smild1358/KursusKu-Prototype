<?php
// Set timezone & variabel pendukung
date_default_timezone_set('Asia/Jakarta');
$siteName  = 'KursusKu';$pageTitle = 'Inspektur Tipe Data PHP';

/* ============================================================================
 * PENDEKLARASI SAMPEL TIPE DATA (SESUAI MATERI PERTEMUAN 3)
 * ============================================================================ */

// 1. String
$courseName = 'Laravel Fundamental';

// 2. Integer (Penyimpanan Rupiah/Angka Bulat)
$courseFee = 350000;

// 3. Float / Double (Bilangan Desimal)
$rating = 4.85;

// 4. Boolean (Kondisi True/False)
$isActive = true;

// 5. Array (Kumpulan Data Terstruktur)
$topics = ['Route', 'Controller', 'Blade View', 'Eloquent ORM', 'Migration'];

// 6. Null (Nilai Kosong / Belum Diset)
$discountCode = null;

/* ============================================================================
 * FUNGSI BANTU PENAMPIL INSPEKSI TIPE DATA
 * ============================================================================ */
function inspectVariable($var) {$type = gettype($var);$rawValue = '';

    switch ($type) {
        case 'boolean':
            $rawValue =$var ? 'true' : 'false';
            break;
        case 'array':
            $rawValue = json_encode($var, JSON_PRETTY_PRINT);
            break;
        case 'NULL':
            $rawValue = 'null';
            break;
        case 'string':
            $rawValue = '"' . htmlspecialchars($var) . '" (Panjang: ' . strlen($var) . ' byte)';
            break;
        default:
            $rawValue = (string)$var;
            break;
    }

    return [
        'type'  => $type,
        'value' => $rawValue
    ];
}

// Daftar variabel untuk diinspeksi
$sampleVariables = [
    'Nama Kursus ($courseName)'       =>$courseName,
    'Biaya Kursus ($courseFee)'       =>$courseFee,
    'Rating ($rating)'               =>$rating,
    'Status Aktif ($isActive)'        =>$isActive,
    'Modul Topik ($topics)'          =>$topics,
    'Kode Diskon ($discountCode)'    =>$discountCode,
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - <?= $siteName ?></title>

    <!-- Font & Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-main: #0b0f19;
            --surface: #111827;
            --card-bg: rgba(31, 41, 55, 0.7);
            --border: rgba(255, 255, 255, 0.1);
            --type-string: #38bdf8;
            --type-int: #34d399;
            --type-float: #fbbf24;
            --type-bool: #f43f5e;
            --type-array: #a78bfa;
            --type-null: #94a3b8;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-light);
            line-height: 1.6;
            padding: 30px 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #38bdf8 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* INSPECTION CARDS GRID */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }

        .type-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .type-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .var-label {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-light);
        }

        .type-pill {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            font-family: 'Fira Code', monospace;
        }

        .pill-string  { background: rgba(56, 189, 248, 0.15); color: var(--type-string); border: 1px solid var(--type-string); }
        .pill-integer { background: rgba(52, 211, 153, 0.15); color: var(--type-int);    border: 1px solid var(--type-int); }
        .pill-double  { background: rgba(251, 191, 36, 0.15);  color: var(--type-float);  border: 1px solid var(--type-float); }
        .pill-boolean { background: rgba(244, 63, 94, 0.15);   color: var(--type-bool);   border: 1px solid var(--type-bool); }
        .pill-array   { background: rgba(167, 139, 250, 0.15); color: var(--type-array);  border: 1px solid var(--type-array); }
        .pill-NULL    { background: rgba(148, 163, 184, 0.15); color: var(--type-null);   border: 1px solid var(--type-null); }

        .value-box {
            background: #090d16;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 12px 16px;
            font-family: 'Fira Code