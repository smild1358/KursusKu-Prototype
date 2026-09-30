======================================================================
PERBEDAAN LOCAL DEVELOPMENT VS HOSTING / PRODUCTION
======================================================================

Aspek          | Local Development               | Hosting / Production
----------------------------------------------------------------------
URL            | kursusku-prototype.test /       | domain.com / subdomain.com
               | localhost                       |
Lokasi File    | Laptop/Komputer Lokal           | Server Hosting Publik
Database       | MySQL Lokal (Laragon/XAMPP)     | Server Database Hosting
Environment    | Development                     | Production
HTTPS / SSL    | Opsional / HTTP                 | Wajib HTTPS (SSL Aktif)
Debug Error    | Boleh tampil detail (on)        | Disembunyikan (off)
Secret/Key     | Disimpan di file lokal          | Environment variables server
Document Root  | Folder www/htdocs               | public_html / public