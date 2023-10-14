# web-dev-goodlink-test
Pengerjaan test Web Developer dari Tim IT Koperasi KBRI oleh Mohammad Nafis Naufally

## Installation

### Pulling Repository

Untuk mendapatkan salinan repository ini saya sarankan dilakukan dengan 2 cara yaitu melalui:
- Pull repository ini pada folder lokal yang kosong dan jalankan command 
`` git clone https://github.com/MNafisN/web-dev-goodlink-test.git ``.
- Download arsip repository ini dan ekstrak ke direktori lokal.

### Requirements

- PHP versi 8.0 atau 8.1,
- Composer,
- Node js versi 18.x,
- NPM versi 9.x,
- AdminLTE versi 3.x

### Setting Environment

- Pastikan PHP terinstall dengan cara mengecek versinya dengan menjalankan command `` php -v ``.
- Pastikan Composer terinstall dengan cara mengecek versinya dengan menjalankan command `` composer ``.
- Pastikan Node js terinstall dengan cara mengecek versinya dengan menjalankan command `` node -v ``.
- Pastikan NPM terinstall dengan cara mengecek versinya dengan menjalankan command `` npm -v ``.

### Installing Project

Setting file .env project dengan cara menduplikat file .env.example atau .env.testing kemudian rename file tersebut menjadi .env dan tentukan nama aplikasi (GoodLink), database yang digunakan (MySQL), dan juga file system untuk menentukan lokasi penyimpanan file.

Daftar command di bawah ini disarankan untuk dijalankan secara berurutan agar aplikasi siap dijalankan maupun dikembangkan lagi.
- `` composer install ``
- `` php artisan key:generate --ansi ``
- `` php artisan route cache ``
- `` php artisan jwt:secret ``
- `` php artisan migrate ``
- `` php artisan db:seed ``
- `` npm install ``

### Running Project

Untuk menjalankan aplikasi tersebut, jalankan command berikut ini pada 2 terminal yang berbeda:
- `` php artisan serve ``
- `` npm run dev ``

## Application Testing

### Browser

Testing dapat dilakukan melalui browser dengan cara memasukkan URL localhost diikuti dengan port yang dijalankan dari command `` php artisan serve `` di atas. Contohnya jika port yang dipakai adalah 8000, maka URL yang diakses adalah `` localhost:8000 ``
