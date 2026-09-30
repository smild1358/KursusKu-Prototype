<?php
// Menangkap data GET dengan fungsi trim() dan operator null coalescing (??)
$name            = trim($_GET['name'] ?? '');
$course          = trim($_GET['course'] ?? '');
$participantType = trim($_GET['participant_type'] ?? 'mahasiswa');

// Mengambil Query String aktual dari URL
$queryString = $_SERVER['QUERY_STRING'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksperimen GET - KursusKu</title>
    <!-- Google Font & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0f766e;
            --primary-hover: #0d625b;
            --bg-body: #f0fdf4;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --code-bg: #f1f5f9;
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
            background-size: 20px 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 15px;
            color: var(--text-main);
        }

        .card-container {
            background: var(--card-bg);
            width: 100%;
            max-width: 580px;
            border-radius: 20px;
            padding: 35px 30px;
            box-shadow: 0 10px 30px rgba(15, 118, 110, 0.08), 0 4px 6px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(15, 118, 110, 0.1);
        }

        .subtitle {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--primary-color);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .title {
            font-size: 1.85rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .description {
            font-size: 0.92rem;
            color: var(--text-muted);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        /* Result Box - Modern Code Display */
        .result-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid var(--primary-color);
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 28px;
            font-size: 0.92rem;
        }

        .result-title {
            font-weight: 700;
            color: #334155;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .query-code {
            background: #e2e8f0;
            color: #0f172a;
            font-family: 'Courier New', Courier, monospace;
            padding: 6px 10px;
            border-radius: 6px;
            font-weight: 600;
            word-break: break-all;
            margin-bottom: 12px;
            display: block;
            font-size: 0.85rem;
        }

        .data-item {
            margin-top: 6px;
            color: #475569;
        }

        .data-item strong {
            color: #1e293b;
        }

        /* Form Fields */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 0.95rem;
            color: #0f172a;
            background-color: #ffffff;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
        }

        /* Radio Group Fieldset Frame */
        .radio-fieldset {
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 18px;
            position: relative;
        }

        .radio-legend {
            font-size: 0.88rem;
            font-weight: 700;
            color: #1e293b;
            padding: 0 6px;
            margin-left: -2px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.92rem;
            color: #334155;
        }

        .radio-option input[type="radio"] {
            accent-color: var(--primary-color);
            width: 17px;
            height: 17px;
            cursor: pointer;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            background-color: var(--primary-color);
            color: #ffffff;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 0.98rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        /* Bottom Note & Back Link */
        .footer-note {
            margin-top: 22px;
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary-color);
            font-weight: 800;
            text-decoration: none;
            margin-top: 6px;
            font-size: 0.92rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="card-container">
        <!-- Subtitle & Header -->
        <div class="subtitle">Milestone 5 &bull; GET vs POST</div>
        <h1 class="title">Eksperimen GET</h1>
        <p class="description">Berbeda dengan POST, parameter GET tampak pada query string URL.</p>

        <!-- Dynamic Output Box -->
        <div class="result-box">
            <div class="result-title">
                <i class="fa-solid fa-terminal"></i> Query string yang diterima:
            </div>
            
            <code class="query-code">
                ?<?= !empty($queryString) ? htmlspecialchars($queryString) : 'name=&course=&participant_type=' ?>
            </code>

            <div class="data-item">
                Nama: <strong><?= !empty($name) ? htmlspecialchars($name) : '-' ?></strong>
            </div>
            <div class="data-item">
                Kursus: <strong><?= !empty($course) ? htmlspecialchars($course) : '-' ?></strong>
            </div>
            <div class="data-item">
                Peserta: <strong><?= !empty($participantType) ? htmlspecialchars($participantType) : '-' ?></strong>
            </div>
        </div>

        <!-- GET Interactive Form -->
        <form method="GET" action="get-demo.php">
            
            <!-- Input Nama -->
            <div class="form-group">
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="Masukkan nama..." value="<?= htmlspecialchars($name) ?>">
            </div>

            <!-- Select Kursus -->
            <div class="form-group">
                <label for="course" class="form-label">Kursus</label>
                <select id="course" name="course" class="form-select">
                    <option value="PHP Dasar" <?= $course === 'PHP Dasar' ? 'selected' : '' ?>>PHP Dasar</option>
                    <option value="Web Dasar" <?= $course === 'Web Dasar' ? 'selected' : '' ?>>Web Dasar</option>
                    <option value="Laravel Fundamental" <?= $course === 'Laravel Fundamental' ? 'selected' : '' ?>>Laravel Fundamental</option>
                    <option value="MySQL Dasar" <?= $course === 'MySQL Dasar' ? 'selected' : '' ?>>MySQL Dasar</option>
                </select>
            </div>

            <!-- Radio Button Peserta -->
            <div class="form-group">
                <div class="radio-fieldset">
                    <span class="radio-legend">Peserta</span>
                    <label class="radio-option">
                        <input type="radio" name="participant_type" value="mahasiswa" <?= $participantType === 'mahasiswa' ? 'checked' : '' ?>>
                        Mahasiswa
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="participant_type" value="umum" <?= $participantType === 'umum' ? 'checked' : '' ?>>
                        Umum
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                Kirim dengan GET
            </button>
        </form>

        <!-- Footer / Redirect Text -->
        <div class="footer-note">
            Setelah eksperimen, form utama tetap memakai POST di registration.php.
            <br>
            <a href="registration.php" class="back-link">
                Kembali ke Form POST &rarr;
            </a>
        </div>
    </div>

</body>
</html>