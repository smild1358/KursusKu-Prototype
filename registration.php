<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KursusKu — Formulir Pendaftaran</title>

    <!-- Font Modern (Inter & Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --focus-ring: rgba(79, 70, 229, 0.2);
            --radius-md: 12px;
            --radius-lg: 20px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Modern */
        .app-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-menu {
            display: flex;
            gap: 1.5rem;
            list-style: none;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color);
        }

        /* Main Container Layoute */
        .wrapper {
            max-width: 850px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        .hero-banner {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .badge-pill {
            display: inline-block;
            background-color: #e0e7ff;
            color: var(--primary-color);
            font-size: 0.85rem;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 0.75rem;
        }

        .hero-banner h1 {
            font-size: 2.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .hero-banner p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        /* Card Form */
        .registration-card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-xl);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }

        .form-group-full {
            grid-column: span 2;
        }

        .field-label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .field-label span {
            color: #ef4444;
        }

        .input-control, .select-control, .textarea-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-main);
            background-color: #fff;
            transition: all 0.2s ease;
        }

        .input-control:focus, .select-control:focus, .textarea-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px var(--focus-ring);
        }

        /* Options (Radio & Checkbox Cards) */
        .options-wrapper {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1rem 1.25rem;
            margin-top: 0.5rem;
        }

        .options-legend {
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0 6px;
            color: var(--text-main);
        }

        .options-grid {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .custom-option {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            color: var(--text-main);
        }

        .custom-option input[type="radio"],
        .custom-option input[type="checkbox"] {
            accent-color: var(--primary-color);
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .field-hint {
            display: block;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.4rem;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            background-color: var(--primary-color);
            color: #ffffff;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        /* Responsive Breakpoints */
        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group-full {
                grid-column: span 1;
            }

            .registration-card {
                padding: 1.5rem;
            }

            .hero-banner h1 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="app-header">
        <div class="header-container">
            <a href="index.php" class="brand-logo">
                ⚡ KursusKu
            </a>
            <nav aria-label="Navigasi Utama">
                <ul class="nav-menu">
                    <li><a href="index.php" class="nav-link">Beranda</a></li>
                    <li><a href="index.php#katalog" class="nav-link">Katalog</a></li>
                    <li><a href="registration.php" class="nav-link active">Daftar</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="wrapper">
        <section class="hero-banner">
            <span class="badge-pill">Formulir Pendaftaran</span>
            <h1>Bergabung Bersama KursusKu</h1>
            <p>Isi data diri Anda di bawah ini secara lengkap untuk memulai pembelajaran.</p>
        </section>

        <section class="registration-card">
            <form action="process-registration.php" method="POST">
                <input type="hidden" name="source" value="week-05">

                <div class="form-grid">
                    <!-- Field Nama -->
                    <div class="form-group">
                        <label for="name" class="field-label">Nama Lengkap <span>*</span></label>
                        <input id="name" name="name" type="text" class="input-control" placeholder="Masukkan nama lengkap" minlength="3" maxlength="100" autocomplete="name" required>
                    </div>

                    <!-- Field Email -->
                    <div class="form-group">
                        <label for="email" class="field-label">Email <span>*</span></label>
                        <input id="email" name="email" type="email" class="input-control" placeholder="nama@email.com" maxlength="120" autocomplete="email" required>
                    </div>

                    <!-- Field Nomor HP -->
                    <div class="form-group">
                        <label for="phone" class="field-label">Nomor WhatsApp / HP <span>*</span></label>
                        <input id="phone" name="phone" type="tel" class="input-control" maxlength="15" autocomplete="tel" placeholder="081234567890" required>
                    </div>

                    <!-- Field Program Studi -->
                    <div class="form-group">
                        <label for="study_program" class="field-label">Program Studi <span>*</span></label>
                        <input id="study_program" name="study_program" type="text" class="input-control" placeholder="Contoh: Teknik Informatika" maxlength="100" required>
                    </div>

                    <!-- Field Pilih Kursus -->
                    <div class="form-group form-group-full">
                        <label for="course" class="field-label">Pilih Program Kursus <span>*</span></label>
                        <select id="course" name="course" class="select-control" required>
                            <option value="" disabled selected>-- Pilih program kursus --</option>
                            <option value="web-dasar">Web Dasar (HTML, CSS, JS)</option>
                            <option value="php-dasar">PHP Dasar & MySQL</option>
                            <option value="laravel-fundamental">Laravel Fundamental</option>
                        </select>
                    </div>

                    <!-- Fieldset Jenis Peserta -->
                    <div class="form-group form-group-full">
                        <fieldset class="options-wrapper">
                            <legend class="options-legend">Jenis Peserta <span>*</span></legend>
                            <div class="options-grid">
                                <label class="custom-option">
                                    <input type="radio" name="participant_type" value="mahasiswa" required>
                                    <span>Mahasiswa</span>
                                </label>
                                <label class="custom-option">
                                    <input type="radio" name="participant_type" value="umum">
                                    <span>Umum / Profesional</span>
                                </label>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Fieldset Minat Tambahan -->
                    <div class="form-group form-group-full">
                        <fieldset class="options-wrapper">
                            <legend class="options-legend">Minat Tambahan (Opsional)</legend>
                            <div class="options-grid">
                                <label class="custom-option">
                                    <input type="checkbox" name="interests[]" value="ui-ux">
                                    <span>UI/UX Design</span>
                                </label>
                                <label class="custom-option">
                                    <input type="checkbox" name="interests[]" value="database">
                                    <span>Database Architecture</span>
                                </label>
                                <label class="custom-option">
                                    <input type="checkbox" name="interests[]" value="backend">
                                    <span>Backend Engineering</span>
                                </label>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Field Catatan -->
                    <div class="form-group form-group-full">
                        <label for="note" class="field-label">Catatan Tambahan</label>
                        <textarea id="note" name="note" rows="4" class="textarea-control" maxlength="300" placeholder="Tuliskan ekspektasi atau kebutuhan belajar Anda..."></textarea>
                        <small class="field-hint">Maksimal 300 karakter.</small>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group form-group-full">
                        <button class="btn-submit" type="submit">Konfirmasi & Kirim Pendaftaran</button>
                    </div>
                </div>
            </form>
        </section>
    </main>

</body>
</html>