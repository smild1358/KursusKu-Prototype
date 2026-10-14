<?php
require_once __DIR__ . '/helpers.php';

// Ambil input nilai A dan B dari parameter GET (atau gunakan nilai default)
$valA = isset($_GET['a']) ? (float)$_GET['a'] : 10;
$valB = isset($_GET['b']) ? (float)$_GET['b'] : 3;

// 1. Operator Aritmatika
$add      = $valA +$valB;
$sub      = $valA -$valB;
$mul      = $valA * $valB;
$div      =$valB != 0 ? round($valA / $valB, 2) : 'Undefined (Div by 0)';
$mod      =$valB != 0 ? $valA \%$valB : 'Undefined';
$exp      =$valA ** $valB;

// 2. Operator Perbandingan
$eq       = ($valA ==$valB) ? 'true' : 'false';
$identical= ($valA === $valB) ? 'true' : 'false';$neq      = ($valA !=$valB) ? 'true' : 'false';
$gt       = ($valA > $valB) ? 'true' : 'false';$lt       = ($valA <$valB) ? 'true' : 'false';
$gte      = ($valA >= $valB) ? 'true' : 'false';$lte      = ($valA <=$valB) ? 'true' : 'false';

// 3. Operator Increment & Decrement
$incA =$valA; 
$incA++;
$decB =$valB; 
$decB--;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Test Laboratory — KursusKu</title>
    
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
            --accent: #f59e0b;
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
            max-width: 1000px;
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
            gap: 12px;
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

        /* Form Input */
        .form-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 16px;
            align-items: end;
        }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 1rem;
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
            padding: 13px 24px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: var(--