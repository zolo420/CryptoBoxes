<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>
        Приглашение регистрации в ROB & RUN
    </h1>
    <p>
        Вам отправлено приглашение зарегистрироваться в системе.<br>
        Для регистрации перейдите по ссылке ниже:
    </p>

     <a href="{{ \App\Helpers\SettingsHelpers::getSetting('frontend_url') }}/registration/referrer/{{ $token }}">ссылка</a>

</body>
</html>
