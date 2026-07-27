# Aplikasi Manajemen Risiko PDSI BP Batam

Aplikasi Manajemen Risiko merupakan aplikasi berbasis web yang dirancang untuk membantu proses pengelolaan risiko pada Unit Pusat Data dan Sistem Informasi (PDSI) BP Batam.

Aplikasi ini mendukung proses pencatatan risiko, perhitungan level risiko, verifikasi, reviu, pemantauan penanganan, penyimpanan riwayat perubahan, serta pembuatan laporan risiko secara terintegrasi. Sistem memiliki tiga jenis pengguna, yaitu Unit Pemilik Risiko (UPR), Unit Manajemen Risiko (UMR), dan Unit Pengawas Intern (UPI).

## Fitur Utama

- Autentikasi pengguna.
- Hak akses berdasarkan peran pengguna.
- Pencatatan dan klasifikasi risiko.
- Perhitungan besaran dan level risiko secara otomatis.
- Matriks risiko.
- Pemantauan status penanganan risiko.
- Peringatan batas waktu penanganan.
- Verifikasi risiko oleh UMR.
- Reviu risiko oleh UPI.
- Catatan perbaikan data risiko.
- Riwayat perubahan data risiko.
- Pencarian dan filter data.
- Pengelolaan data pengguna.
- Pembuatan laporan risiko triwulan dalam format PDF.
- Mekanisme soft delete.

## Peran Pengguna

### Unit Pemilik Risiko (UPR)

UPR bertugas melakukan pencatatan dan pengelolaan data risiko pada Unit PDSI BP Batam.

Tugas UPR meliputi:

- Menambahkan data risiko.
- Mengisi identifikasi dan klasifikasi risiko.
- Mengisi nilai kemungkinan dan dampak.
- Melihat hasil perhitungan level risiko.
- Menentukan rencana penanganan risiko.
- Memperbarui status penanganan.
- Melakukan perbaikan data berdasarkan catatan UMR atau UPI.
- Melihat status verifikasi dan reviu.
- Melihat riwayat perubahan data risiko.
- Melihat dan mencetak laporan risiko.

### Unit Manajemen Risiko (UMR)

UMR bertugas melakukan pemeriksaan dan verifikasi terhadap data risiko yang telah dicatat oleh UPR.

Tugas UMR meliputi:

- Melihat data risiko yang diajukan.
- Memeriksa kelengkapan dan kesesuaian data.
- Melakukan verifikasi risiko.
- Memberikan catatan perbaikan.
- Mengubah status verifikasi.
- Memantau status penanganan risiko.
- Melihat riwayat perubahan.
- Melihat dan mencetak laporan risiko.

### Unit Pengawas Intern (UPI)

UPI bertugas melakukan reviu terhadap data risiko yang telah diverifikasi oleh UMR.

Tugas UPI meliputi:

- Melihat data risiko yang telah diverifikasi.
- Melakukan reviu risiko.
- Menyetujui hasil reviu.
- Mengembalikan data untuk diperbaiki.
- Memberikan catatan perbaikan.
- Memantau status dan riwayat perubahan risiko.
- Melihat dan mencetak laporan risiko.
- Mengelola data pengguna.

## Cara Penggunaan

1. Pengguna melakukan login menggunakan akun yang telah terdaftar.
2. Sistem menampilkan dashboard sesuai dengan peran pengguna.
3. UPR mencatat dan mengelola data risiko.
4. Sistem menghitung besaran dan level risiko secara otomatis berdasarkan nilai kemungkinan dan dampak.
5. UPR mengajukan data risiko untuk diverifikasi.
6. UMR memeriksa dan melakukan verifikasi terhadap data risiko.
7. Jika terdapat kekurangan, UMR memberikan catatan perbaikan kepada UPR.
8. Risiko yang telah diverifikasi diteruskan kepada UPI untuk dilakukan reviu.
9. UPI dapat menyetujui atau mengembalikan data untuk diperbaiki.
10. Data risiko yang telah disetujui dapat dipantau dan dimasukkan ke dalam laporan risiko triwulan.
11. Pengguna dapat melihat riwayat perubahan dan mencetak laporan dalam format PDF.

## Teknologi yang Digunakan

- Laravel
- PHP
- MySQL
- Blade Template
- Bootstrap
- JavaScript
- HTML
- CSS

## Pengembang

**Ratu Nabila Monica Sylva**  
Program Studi Teknologi Rekayasa Perangkat Lunak  
Politeknik Negeri Batam

## Judul Tugas Akhir

**Rancang Bangun Aplikasi Manajemen Risiko di Unit PDSI BP Batam**
