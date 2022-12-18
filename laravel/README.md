<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

### Sosyal Medya API'lerini Kullanarak Giriş Yapma İşlemleri

# Laravel 9.x - WebCMS Paneli

## Kurulum

### 1. Projeyi klonlayın

```bash
git clone https://github.com/erhanurgun/MIX10-login-with-api.git
```

### 2. .env dosyasını oluşturun

```bash
cp .env.example .env
```

### 3. .env dosyasını düzenleyin

```conf
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

GOOGLE_CLIENT_ID="google-client-id"
GOOGLE_CLIENT_SECRET="google-client-secret"

PASSPORT_PERSONAL_ACCESS_CLIENT_ID="personal-access-client-id"
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET="personal-access-client-secret"
```


### 4. Composer paketlerini yükleyin

```bash
composer install
```

### 5. NPM paketlerini yükleyin

```bash
npm install
```

### 6. Key oluşturun

```bash
php artisan key:generate
```

### 6. Veritabanı eklemelerini yapın

```bash
php artisan migrate
```

## Kullanım

### 1. Aşağıdaki komutları çalıştırınız

```bash
php artisan serve
```

### 2. Tarayıcıdan aşağıdaki adrese gidiniz

```bash
http://laravel:8000/api/documentation
```
###### Bu API'yi kullanarak işlemlerinizi gerçekleştirebilirsiniz.
