<!DOCTYPE html>
<html lang="ru" id="extr-page">
<head>
    <meta charset="utf-8">
    <title> Авторизация</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- #CSS Links -->
    <!-- Basic Styles -->


    {!! Html::style('/admin/css/bootstrap.min.css') !!}

    {!! Html::style('/admin/css/font-awesome.min.css') !!}

    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    {!! Html::style('/admin/css/smartadmin-production-plugins.min.css') !!}

    {!! Html::style('/admin/css/smartadmin-production.min.css') !!}

    {!! Html::style('/admin/css/smartadmin-skins.min.css') !!}


    <!-- SmartAdmin RTL Support -->

    {!! Html::style('/admin/css/smartadmin-rtl.min.css') !!}

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <style>
        @media (min-width: 1200px) {
            .container {
                max-width: 900px;
            }
        }
    </style>
</head>

<body class="animated fadeInDown">

<header id="header">

    <div id="logo-group">
        <span id="logo"> <img src="{{ url('/admin/img/logo.png') }}" alt=""> </span>
    </div>

</header>

<div id="main" role="main">

    <!-- MAIN CONTENT -->
    <div id="content" class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="well no-padding">

                    {!! Form::open(['url' => URL::route('login'), 'method' => 'post', 'class' => 'smart-form client-form', 'id' => 'login-form']) !!}

                    @if ($errors->has('message'))
                        <p class="text-danger">{{ $errors->first('message') }}</p>
                    @endif

                    <header>
                        Панель администратора
                    </header>

                    <fieldset>

                        <section>

                            {!! Form::label('seed', 'Логин', ['class' => 'label']) !!}

                            <label class="input"> <i class="icon-append fa fa-user"></i>

                                {!! Form::text('login', old('login'), [ 'placeholder' => 'логин', 'class' => 'form-control']) !!}

                                @if ($errors->has('login'))
                                    <p class="text-danger">{{ $errors->first('login') }}</p>
                                @endif

                        </section>

                        <section>

                            {!! Form::label('password', 'Пароль', ['class' => 'label']) !!}

                            <label class="input"> <i class="icon-append fa fa-lock"></i>
                                {!! Form::password('password',['class' => 'form-control', 'placeholder' => 'пароль', 'type' => 'password']) !!}

                                @if ($errors->has('password'))
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </label>
                        </section>

                        <section>
                            <label class="checkbox">

                                {!! Form::checkbox('remember', 1, old('remember') ? true : false ) !!}

                                <i></i>Запомнить меня
                            </label>
                        </section>

                    </fieldset>

                    <footer>

                        {!! Form::submit('Войти', ['class' => 'btn btn-primary']) !!}

                    </footer>

                    {!! Form::close() !!}

                </div>

            </div>
        </div>
    </div>

</div>

</body>
</html>
