<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body>
<h1>
    Подтверждение адреса электронной почты
</h1>

<p>Для подтверждения вашего адреса электронной почты, пройдите по ссылке:<br>

<a href="{{ \App\Helpers\SettingsHelpers::getSetting('frontend_url') }}/confirm/{{ $token }}">ссылка</a>

</p>
</body>
</html>
