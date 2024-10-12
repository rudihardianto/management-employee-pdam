# Employee Management System (CRUD)

Proyek ini adalah aplikasi manajemen pegawai sederhana yang memungkinkan pengguna untuk melakukan operasi CRUD (Create, Read, Update, Delete) terhadap data pegawai. Aplikasi ini dibangun menggunakan HTML, PHP, CSS, JavaScript/jQuery, dan memanfaatkan MySQL sebagai database.

## Fitur

-   Tambah Pegawai: Pengguna dapat menambahkan data pegawai baru melalui form input yang disediakan.
-   Edit Pegawai: Pengguna dapat memperbarui informasi pegawai.
-   Hapus Pegawai: Pengguna dapat menghapus data pegawai dari tabel.
-   Tampilan Tabel Pegawai: Menampilkan daftar pegawai yang ada di sistem beserta informasi mereka.
-   Validasi Input: Form input dilengkapi dengan validasi seperti pemilihan tanggal dan ruangan.

## Teknologi yang Digunakan

-   Frontend: HTML, CSS (dengan Bootstrap), JavaScript.
-   Backend: PHP.
-   Database: MySQL.

## Persyaratan Sistem

-   PHP 8+
-   MySQL 8+
-   Web server (Apache/Nginx)

## Instalasi

1. Clone repositori:

    ```
    git clone https://github.com/rudihardianto/management-employee-pdam.git
    ```

2. Impor `pdam_pegawai.sql` ke MySQL

3. Konfigurasi `config.php`:

    ```php
    $host = 'localhost';
    $db   = 'pdam_pegawai';
    $user = 'root';
    $pass = '';
    ```

4. Akses: `http://management_employee_pdam.test` apabila menggunakan `valet laravel` atau `http://management_employee_pdam.test/index.php`, ubah pada folder `functions.php`

## Struktur Direktori

```
management_employee_pdam/
├── views/
├── config.php
├── functions.php
└── index.php
```

## Tampilan

-   Tabel Daftar Pegawai
    -   Menampilkan daftar pegawai lengkap dengan fitur Edit dan Hapus.
-   Form Input/Edit Pegawai
    -   Menyediakan form untuk menambah atau mengedit data pegawai.
    -   Field yang perlu diisi: Nama, Alamat, Tanggal Lahir, Ruangan.

## Catatan

Proyek ini masih menggunakan tampilan sederhana namun fungsional untuk pengelolaan data pegawai dengan CRUD. Cocok untuk aplikasi administrasi sederhana di perusahaan.

## Lisensi

[MIT License](LICENSE)

## Kontak

rud.hardianto@gmail.com
