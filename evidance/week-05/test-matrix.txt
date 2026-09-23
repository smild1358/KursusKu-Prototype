======================================================================
MATRIKS PENGUJIAN - PERTEMUAN 5 (FORM PENDAFTARAN KURSUSKU)
======================================================================

No | Pengujian        | Langkah                                     | Hasil yang Diharapkan                   | Status
----------------------------------------------------------------------------------------------------------------------
1  | Load Form        | Buka registration.php                       | Form tampil tanpa error                 | Lulus
2  | Required         | Kirim form kosong                           | Browser menahan field wajib             | Lulus
3  | Email            | Isi email dengan "abc"                      | Browser meminta format email yang benar | Lulus
4  | Nama Pendek      | Isi nama 2 karakter                         | minlength mencegah submit               | Lulus
5  | Eksperimen GET   | Ubah method="GET", submit data              | Parameter terlihat di URL               | Lulus
6  | Method POST      | Ubah method="POST", submit data             | Query data tidak tampil di URL          | Lulus
7  | Control Radio    | Pilih "Mahasiswa"                           | Nilai muncul di ringkasan               | Lulus
8  | Control Checkbox | Pilih "UI/UX" dan "Backend"                 | Dua nilai muncul digabung dengan koma   | Lulus
9  | Control Textarea | Isi catatan singkat                         | Teks ditampilkan dengan safe-escaping   | Lulus
10 | Control Hidden   | Submit form                                 | Value source "week-05" diterima         | Lulus
11 | Mobile View      | Uji pada lebar ~360px di DevTools           | Layout 1 kolom, tidak overflow          | Lulus
12 | Navigasi Utama   | Klik Beranda -> Katalog -> Daftar           | Navigasi berpindah sesuai tautan        | Lulus