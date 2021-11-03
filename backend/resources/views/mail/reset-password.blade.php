<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>
        Здравствуйте,
    </h1>
    <p>
        Запрошено восстановление доступа к Вашему аккаунту.<br>
        Пожалуйста, для смены пароля перейдите по ссылке ниже:
    </p>

     <a href="{{ \App\Helpers\SettingsHelpers::getSetting('frontend_url') }}/reset/{{ $token }}">ссылка</a>

</body>
</html>
