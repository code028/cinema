<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Powerful Conema website built in laravel 11">
    <title>@yield('title') | Conema</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="w-full h-screen flex flex-col">
        <div class="sticky top-0 left-0 z-50">
            <x-navbar />
        </div>
        <div class="flex flex-1">
            <div class="hidden xl:flex xl:h-full fixed bg-black">
                <div class="overflow-y-auto h-full pb-20">
                    <x-sidebar />
                </div>
            </div>
            <div class="flex w-full h-full p-5 xl:pl-[350px] items-center justify-center overflow-y-auto">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
