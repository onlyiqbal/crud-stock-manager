# Aplikasi Stock Manager

## Aplikasi CRUD Stock Manager Sederhana Menggunakan PHP Native

## Spesifikasi Aplikasi :

- Menggunakan konsep MVC
- Menggunakan Repository Pattern
- PHP Native
- Database MySQL
- Server : PHP Development Server

## Panduan Instalasi :

- Clone repository ini atau download file zip.
- Buat dua database, database "db_stock" dan "db_stock_test" (unit test).
- Import file sql script yang terdapat didalam projectnaya sesuai dengan nama databasenya.
- Buka folder projectnya menggunkan text editor, lalu buka terminal bawaan dari text editornya.
- Install dependency menggunakan composer dengan mengetikan "composer install".
- Setelah install dependency lalu masuk ke folder /public dan aktifkan php development server, ketik "php -S localhost:8080".
- Jika sudah aktif, akses url "localhost:8080" di browser maka aplikasi sudah bisa digunakan.

## Cara menjalankan unit test :

- Pastikan sudah menginstall composer php.
- Buka folder projectnya menggunkan text editor, lalu buka terminal bawaanya.
- Ketik diterminal "composer install" maka seluruh dependency akan terinstall.
- Setelah terinstall ketik diterminal "vendor/bin/phpunit tests" maka seluruh unit test akan berjalan.
