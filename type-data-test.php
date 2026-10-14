<?php
// Set timezone & variabel pendukung
date_default_timezone_set('Asia/Jakarta');
$siteName  = 'KursusKu';
$pageTitle = 'Inspektur Tipe Data PHP';

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
function inspectVariable($var) {
    $type = gettype($var);
    $rawValue = '';

    switch ($type) {
        case 'boolean':
            $rawValue = $var ? 'true' : 'false';
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
    'Nama Kursus ($courseName)'       => $courseName,
    'Biaya Kursus ($courseFee)'       => $courseFee,
    'Rating ($rating)'               => $rating,
    'Status Aktif ($isActive)'        => $isActive,
    'Modul Topik ($topics)'          => $topics,
    'Kode Diskon ($discountCode)'    => $discountCode,
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
            font-family: 'Fira Code', monospace;
            font-size: 0.88rem;
            color: #e2e8f0;
            white-space: pre-wrap;
            word-break: break-all;
            max-height: 140px;
            overflow-y: auto;
        }

        /* SUMMARY TABLE */
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
        }

        .table-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .summary-table th, .summary-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .summary-table th {
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        /* FOOTER NAV */
        .nav-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn-link {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-link:hover {
            color: #a78bfa;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- HEADER -->
        <header class="header">
            <h1><i class="fa-solid fa-vial"></i> <?= $pageTitle ?></h1>
            <p>Pengujian Variabel & Tipe Data PHP Dalam Lingkungan Server (Sub-CPMK2 Web III)</p>
        </header>

        <!-- GRID INSPEKSI VARIABEL -->
        <div class="cards-grid">
            <?php foreach ($sampleVariables as $label => $val): 
                $info = inspectVariable($val);
                $pillClass = 'pill-' . $info['type'];
            ?>
                <div class="type-card">
                    <div class="card-top">
                        <span class="var-label"><?= htmlspecialchars($label) ?></span>
                        <span class="type-pill <?= $pillClass ?>"><?= $info['type'] ?></span>
                    </div>
                    <div class="value-box"><?= $info['value'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- TABLE RINGKASAN TIPE DATA -->
        <div class="table-card">
            <div class="table-title">
                <i class="fa-solid fa-list-check" style="color: #38bdf8;"></i>
                Matriks Karakteristik Tipe Data PHP
            </div>
            <div style="overflow-x: auto;">
                <table class="summary-table">
                    <thead>
                        <tr>
                            <th>Tipe Data</th>
                            <th>Sintaks PHP</th>
                            <th>Contoh Penggunaan KursusKu</th>
                            <th>Sifat Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong style="color: var(--type-string);">String</strong></td>
                            <td><code style="color: var(--type-string);">'Text'</code></td>
                            <td>Nama Kursus, Tanggal ISO</td>
                            <td>Kumpulan karakter alfanumerik</td>
                        </tr>
                        <tr>
                            <td><strong style="color: var(--type-int);">Integer</strong></td>
                            <td><code style="color: var(--type-int);">350000</code></td>
                            <td>Biaya Rupiah, Jumlah Peserta</td>
                            <td>Bilangan bulat tanpa koma desimal</td>
                        </tr>
                        <tr>
                            <td><strong style="color: var(--type-float);">Float / Double</strong></td>
                            <td><code style="color: var(--type-float);">4.85</code></td>
                            <td>Rating Kelas, Diskon Persen Desimal</td>
                            <td>Bilangan pecahan/desimal</td>
                        </tr>
                        <tr>
                            <td><strong style="color: var(--type-bool);">Boolean</strong></td>
                            <td><code style="color: var(--type-bool);">true / false</code></td>
                            <td>Status Aktif, Status Penuh</td>
                            <td>Nilai kebenaran biner</td>
                        </tr>
                        <tr>
                            <td><strong style="color: var(--type-array);">Array</strong></td>
                            <td><code style="color: var(--type-array);">['A', 'B']</code></td>
                            <td>Daftar Topik, Katalog Kursus</td>
                            <td>Kumpulan banyak nilai dalam 1 variabel</td>
                        </tr>
                        <tr>
                            <td><strong style="color: var(--type-null);">NULL</strong></td>
                            <td><code style="color: var(--type-null);">null</code></td>
                            <td>Voucher Kosong, Data Belum Diisi</td>
                            <td>Variabel tanpa nilai/kosong</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FOOTER NAVIGASI -->
        <div class="nav-footer">
            <a href="index.php" class="btn-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda Proyek</a>
            <a href="fee-calculator.php" class="btn-link">Kalkulator Biaya (Aritmatika) <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>

</body>
</html>