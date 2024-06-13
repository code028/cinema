@php
    $activeRoutes = [
        'dashboard' => Route::is('dashboard') || Route::is('cinemas.create') || Route::is('cinemas.edit') || Route::is('cinemas.show'),
        'movies' => Route::is('movies.index') || Route::is('movies.create') || Route::is('movies.edit') || Route::is('movies.show'),
        'showings' => Route::is('showings.index') || Route::is('showings.create') || Route::is('showings.edit') || Route::is('showings.show'),
        'airings' => Route::is('airings.index') || Route::is('airings.create') || Route::is('airings.edit') || Route::is('airings.show'),
        'categories' => Route::is('categories.index') || Route::is('categories.create') || Route::is('categories.edit') || Route::is('categories.show'),
        'rooms' => Route::is('rooms.index') || Route::is('rooms.create') || Route::is('rooms.edit') || Route::is('rooms.show'),
        'users' => Route::is('users.index') || Route::is('users.create') || Route::is('users.edit') || Route::is('users.show')
    ];
@endphp

<div class="min-w-[350px] bg-black/95 font-semibold flex justify-center pt-5 h-fit">
    <div class='w-full my-5 flex flex-col gap-3 px-5 text-xl text-white'>
        <a class="flex justify-start items-center gap-5 py-2 px-4 rounded {{ $activeRoutes['dashboard'] ? 'bg-gray-200 text-black' : 'text-white' }}" href="{{ route('dashboard') }}">
            <div class="w-[40px] flex justify-center items-center">
                <x-lucide-tv-2 class="w-[28px] h-[28px]" />
            </div>
            <name>Cinemas</name>
        </a>
        <a class="flex justify-start items-center gap-5 py-2 px-4 rounded {{ $activeRoutes['movies'] ? 'bg-gray-200 text-black' : 'text-white' }}" href="{{ route('movies.index') }}">
            <div class="w-[40px] flex justify-center items-center">
                <x-lucide-film class="w-[28px] h-[28px]" />
            </div>
            <name>Movies</name>
        </a>
        <a class="flex justify-start items-center gap-5 py-2 px-4 rounded {{ $activeRoutes['showings'] ? 'bg-gray-200 text-black' : 'text-white' }}" href="{{ route('showings.index') }}">
            <div class="w-[40px] flex justify-center items-center">
                <x-lucide-calendar class="w-[28px] h-[28px]" />
            </div>
            <name>Showings</name>
        </a>
        <a class="flex justify-start items-center gap-5 py-2 px-4 rounded {{ $activeRoutes['airings'] ? 'bg-gray-200 text-black' : 'text-white' }}" href="{{ route('airings.index') }}">
            <div class="w-[40px] flex justify-center items-center">
                <x-lucide-clapperboard class="w-[28px] h-[28px]" />
            </div>
            <name>Airings</name>
        </a>
        <a class="flex justify-start items-center gap-5 py-2 px-4 rounded {{ $activeRoutes['categories'] ? 'bg-gray-200 text-black' : 'text-white' }}" href="{{ route('categories.index') }}">
            <div class="w-[40px] flex justify-center items-center">
                <x-lucide-list class="w-[28px] h-[28px]" />
            </div>
            <name>Categories</name>
        </a>
        <a class="flex justify-start items-center gap-5 py-2 px-4 rounded {{ $activeRoutes['rooms'] ? 'bg-gray-200 text-black' : 'text-white' }}" href="{{ route('rooms.index') }}">
            <div class="w-[40px] flex justify-center items-center">
                <x-lucide-projector class="w-[28px] h-[28px]" />
            </div>
            <name>Rooms</name>
        </a>
        <a class="flex justify-start items-center gap-5 py-2 px-4 rounded {{ $activeRoutes['users'] ? 'bg-gray-200 text-black' : 'text-white' }}" href="{{ route('users.index') }}">
            <div class="w-[40px] flex justify-center items-center">
                <x-lucide-users class="w-[28px] h-[28px]" />
            </div>
            <name>Users</name>
        </a>
    </div>
</div>
