@php
    $activeRoutes = [
        'home' => Route::is('home'),
        'movies' => Route::is('movie.all'),
        'about' => Route::is('about'),
        'contact' => Route::is('contact')
    ];
@endphp

<div class="w-full bg-[#020202] h-fit py-5 text-white flex items-center transition-all duration-200">
    <a href="{{ route('home') }}" class="px-10 text-3xl pl-10  font-semibold text-stone-100">
        Conema
    </a>
    <div class="lg:hidden flex flex-1 justify-end gap-3 px-4">
        <x-lucide-menu  class="w-10 h-10"/>
    </div>
    <div class="hidden  lg:flex flex-1 justify-start gap-3 transition-all">
        <a href="{{ route('home') }}" class=" flex justify-center items-center gap-3 p-2 hover:bg-white/25 rounded {{ $activeRoutes['home'] ? 'bg-[#e4e4e4] text-black' : 'text-white' }}">
            <x-lucide-clapperboard class="w-6 h-6" />
            Home
        </a>
        <a href="{{ route('movie.all') }}" class=" flex justify-center items-center gap-3 p-2 hover:bg-white/25 rounded {{ $activeRoutes['movies'] ? 'bg-[#e4e4e4] text-black' : 'text-white' }}">
            <x-lucide-film class="w-6 h-6" />
            All Movies
        </a>
        <a href="{{ route('about') }}" class=" flex justify-center items-center gap-3 p-2 hover:bg-white/25 rounded duration-200 {{ $activeRoutes['about'] ? 'bg-[#e4e4e4] text-black' : 'text-white' }}">
            <x-lucide-users-round class="w-6 h-6" />
            About
        </a>
        <a href="{{ route('contact') }}" class=" flex justify-center items-center gap-3 p-2 hover:bg-white/25 rounded duration-200 {{ $activeRoutes['contact'] ? 'bg-[#e4e4e4] text-black' : 'text-white' }}">
            <x-lucide-heart-handshake class="w-6 h-6" />
            Contact
        </a>
    </div>
    <div class="hidden lg:flex justify-end gap-4 px-4 transition">
        @if(Auth::check())
            <a href="{{ route('profile') }}" class="py-2 px-4 shadow-md bg-[#e4e4e4] rounded-md font-semibold text-black hover:bg-white/75 duration-200 font-semi">
                <x-lucide-user-round class="w-6 h-6" />
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="py-2 px-4 shadow-md bg-[#e4e4e4] rounded-md font-semibold text-black hover:bg-white/75 duration-200">
                    <x-lucide-log-out class="w-6 h-6" />
                </button>
            </form>
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'moderator')
            <a href="{{ route('dashboard') }}" class="py-2 px-4 shadow-md bg-[#e4e4e4] rounded-md font-semibold text-black hover:bg-white/75 duration-200">
                <x-lucide-layout-dashboard class="w-6 h-6" />
            </a>
            @endif
        @endif
        @if(!Auth::check())
            <a href="{{ route('loginView') }}" class="py-2 px-4 shadow-md bg-[#e4e4e4] rounded-md font-semibold text-black hover:bg-white/75 duration-200 flex items-center justify-center gap-3">
                <x-lucide-log-in class="w-6 h-6" /> Login
            </a>
            <a href="{{ route('registerView') }}" class="py-2 px-4 shadow-md bg-[#e4e4e4] rounded-md font-semibold text-black hover:bg-white/75 duration-200 flex items-center justify-center gap-3">
                <x-lucide-chevron-right class="w-6 h-6" /> Register
            </a>
        @endif
    </div>
</div>
