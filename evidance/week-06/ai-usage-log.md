# AI Usage Log - Pertemuan 6

| Tujuan | Saran AI | Keputusan | Hasil uji |
| --- | --- | --- | --- |
| Implementasi Tipe Peserta & Diskon | Gunakan radio `participant_type` dan terapkan persentase diskon via percabangan (`switch`/`match`) | Diterima | Diskon terhitung otomatis sesuai kategori Mahasiswa, Guru, atau Umum |
| Dynamic Dropdown Kursus | Generate daftar `<option>` dari array `courses` menggunakan *looping* `foreach` | Diterima | Pilihan kursus berhasil dirender dinamis tanpa *copy-paste* HTML manual |
| Penanganan Array Checkbox | Gunakan `interests[]` pada form dan periksa keberadaan data dengan `empty()` saat diproses | Diterima | Sistem tetap berjalan aman saat minat dipilih maupun dikosongkan |