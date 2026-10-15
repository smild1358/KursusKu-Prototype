# 🎓 KursusKu Prototype — Platform Pendaftaran & Kalkulasi Biaya Kursus

<div align="center">

  <img src="https://img.shields.io/badge/KursusKu-Interactive_Learning_Platform-0f766e?style=for-the-badge&logo=graduation-cap&logoColor=white" alt="KursusKu Banner" />

  <br />

  [![GitHub Repository](https://img.shields.io/badge/Repository-smild1358%2FKursusKu--Prototype-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/smild1358/KursusKu-Prototype)
  [![PHP Version](https://img.shields.io/badge/PHP-8.x_Compatible-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
  [![Styling](https://img.shields.io/badge/Style-Teal_Glassmorphism-0f766e?style=for-the-badge&logo=css3&logoColor=white)](#)
  [![UTS Complete](https://img.shields.io/badge/UTS_Milestone-Week_08_Uploaded-6366F1?style=for-the-badge&logo=adobeacrobatreader&logoColor=white)](#-evidence--dokumentasi-portofolio)

  <p align="center">
    <b>Platform pendaftaran, simulasi diskon, dan kalkulasi biaya kursus pemrograman interaktif berbasis PHP Server-Side.</b>
    <br />
    Proyek ini merupakan portofolio dan prototype kumulatif untuk Mata Kuliah <b>Pemrograman Web III (PHP & MySQL)</b>.
  </p>

</div>

---

## 📑 Daftar Isi
- [✨ Ringkasan Proyek](#-ringkasan-proyek)
- [📁 Struktur Direktori Proyek](#-struktur-direktori-proyek)
- [🚀 Cara Menjalankan di Laragon / Local Server](#-cara-menjalankan-di-laragon--local-server)
- [🌐 Peta Halaman & Navigasi Sistem](#-peta-halaman--navigasi-sistem)
- [📚 Rincian Latihan Pertemuan (Milestone 2 - 8)](#-rincian-latihan-pertemuan-milestone-2---8)
- [🧪 AI Usage Log & Testing Matrix](#-ai-usage-log--testing-matrix)
- [📸 Evidence & Dokumentasi Portofolio](#-evidence--dokumentasi-portofolio)
- [👤 Identitas Pengembang](#-identitas-pengembang)

---

## ✨ Ringkasan Proyek

**KursusKu** dikembangkan secara modular dari Pertemuan 2 hingga Pertemuan 8 (UTS). Sistem ini memfasilitasi alur pendaftaran kursus *end-to-end* tanpa database (menggunakan kombinasi Array, Session, dan skema penyimapan JSON), dengan fitur utama meliputi:

1. **Dynamic Catalog & Fee Engine**: Perhitungan harga otomatis berdasarkan tipe peserta (Mahasiswa, Guru, Umum) dengan potongan diskon khusus.
2. **Flexible Learning Mode**: Pemetaan mode pembelajaran (`offline` $\rightarrow$ **Tatap Muka**, `online`, dan `hybrid`) menggunakan badge visual yang estetik.
3. **Data Persistency & Sync**: Sinkronisasi data historis pendaftaran (*Legacy Dummy Data*) dengan pendaftaran baru secara *real-time*.
4. **Interactive Laboratory Suite**: Halaman pengujian terisolasi untuk menguji operator PHP, fungsi string, manipulasi array, hingga pengujian tipe data secara presisi.

---

## 📁 Struktur Direktori Proyek

```text
KursusKu-Prototype/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── images/
│   │   ├── hero-kursus.jpg
│   │   └── image1.png
│   └── video/
│       └── intro-kursus.mp4
├── evidence/
│   ├── week-01/
│   ├── week-02/
│   │   ├── 01-desktop.png
│   │   ├── 02-mobile.png
│   │   ├── 03-media.png
│   │   └── 04-view-source.png
│   ├── week-03/
│   │   ├── kalkulator.png
│   │   ├── test-case.png
│   │   └── source-code.png
│   ├── week-04/
│   │   ├── katalog-6-kursus.png
│   │   ├── status-kursus.png
│   │   └── test-functions.png
│   ├── week-05/
│   ├── week-06/
│   └── week-08_UTS/
│       └── UTS_BP(III)_2026-2027_RAHMAD_ILLAHI_2524215.pdf  <-- Dokumen Lembar Jawaban & Bukti UTS
├── data.php                    # Master Array Data Kursus & Fasilitas
├── daftar-p6.php               # Form alternatif pendaftaran P6
├── date-test.php               # Modul uji fungsi Tanggal & Waktu PHP
├── fee-calculator.php          # Kalkulator estimasi biaya interaktif
├── fee-tests.php               # Test suite formula perhitungan biaya
├── form-p5.php                 # Form pendaftaran dasar Pertemuan 5
├── get-demo.php                # Demo penanganan parameter HTTP GET
├── hello.php                   # Skrip pengenalan sintaks PHP dasar
├── helpers.php                 # Core Helper (saveRegistration, getLearningModeLabel, dll.)
├── history.php                 # Tabel Riwayat Transaksi & Pendaftaran (Array $registrations)
├── index.php                   # Landing Page Utama
├── loop-lab.php                # Laboratorium Pengujian Looping (foreach/for/while)
├── operator-test.php           # Laboratorium Operator & Identitas Tipe Data ($fee === 350000)
├── procedure-test.php          # Laboratorium Prosedur & Function kustom
├── process.php                 # Backend Handler Form P6 (Validasi & Kalkulasi)
├── process-registration.php    # Backend Handler Pendaftaran P5
├── register.php                # Form Pendaftaran Utama (P6)
├── registration.php            # Form Pendaftaran Legacy
├── server-time.php             # Display Waktu Server Real-Time
├── string-test.php             # Modul Uji Fungsi String PHP
├── style.css                   # Stylesheet Tambahan / Custom Styling
├── test-functions.php          # Pengujian Fungsi Helper Kustom
├── test-matrix.php             # Matriks Pengujian Fitur & Sistem Validasi
├── test-mode.php               # Inspector Visual untuk Mode Pembelajaran (getLearningModeLabel)
├── type-data-test.php          # Modul Uji Evaluasi Tipe Data PHP
└── README.md                   # Dokumentasi Utama Proyek