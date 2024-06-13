<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Conema</title>
    @vite('resources/css/app.css')
</head>
<body id="main_body">
    <div class="w-full h-screen flex flex-col items-center">
        <div class="w-full sticky top-0 left-0 z-50">
            <x-navbar />
        </div>
        <div class="w-full flex justify-center items-center flex-1">
            @yield('content')
        </div>
    </div>
</body>
</html>
