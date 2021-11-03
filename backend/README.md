# Установка

1. `cp .env.example .env` и заполнить необходимыми данными
2. `composer install`
3. `php artisan migrate`
4. `php artisan db:seed`
5. `php artisan key:generate`
6. `php artisan jwt:secret`

# Панель администратора
http://домен/cp
логин admin
пароль 1234567


# Требования
- Apache2
- Redis
- MySQL >= 5.6 или MariaDB >= 10.2
- Composer
- URL rewrite enabled
- Cron
- PHP >= 7.4
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Mysqli PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Http PHP Extension
- Exif PHP Extension
- SOAP PHP Extension
- PCRE PHP Extension
- CURL PHP Extension
- Redis PHP Extension
- gmp PHP Extension
- Sockets PHP Extension

# Настройка крона

1. Очереди
 
/usr/bin/php /var/www/artisan queue:work --stop-when-empty >/dev/null 2>&1 * * * * *
2. Выполнение задач по расписанию

    2.1 проверка btc баланса 
    
    /usr/bin/php /var/www/artisan balance:btc >/dev/null 2>&1 */10 * * * *
    
    2.2 проверка eth баланса
    
    /usr/bin/php /var/www/artisan balance:eth >/dev/null 2>&1 */10 * * * *

