<!doctype html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
<div>
    <header class="d-flex flex-wrap justify-content-center py-2 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <img style="padding-left: 100px" width="134" height="34" src="https://cdn-icons-png.flaticon.com/512/6646/6646438.png">
            <span class="fs-4" style="color:royalblue; padding-left: 10px;"> <b>"БАРС"</b></span>
        </a>
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/settings" class="nav-link"><b>Настройки</b></a></li>
            <li style="margin-right: 16px" class="nv-item"><a href="FAQs" class="nav-link"><b>Справка</b></a></li>
            <button type="button" class="btn btn-outline-primary me-2" onclick="window.location.href = 'http://127.0.0.1:8000/login'";>Вход</button>
            <button style="margin-right: 100px" type="button" class="btn btn-primary" onclick="window.location.href = 'http://127.0.0.1:8000/register'";>Регистрация</button>
    </header>
</div>
<div class="container">
    @yield('content')
</div>
</body>
</html>
