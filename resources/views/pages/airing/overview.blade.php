@extends('layouts.main')

@section('title', "Ticket overview")


@section('content')

<div class="w-full h-full flex justify-center items-center" style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('{{ asset($airing->showing->movie->image) }}'); background-size:cover; background-attachment:fixed;">
    <form method="POST" action="{{ route("ticket.submit", [$airing->showing->movie->id, $airing->id]) }}" class="w-full lg:w-4/6 flex flex-col justify-center items-center md:flex-row md:justify-start md:items-center p-5 gap-3 text-white">
        @csrf
        <a href="{{ route("page.movie", $airing->showing->movie->id) }}" class="overflow-hidden w-full max-w-[275px] rounded-md">
            <img src="{{ $airing->showing->movie->image }}" alt="{{ $airing->showing->movie->name }}" class="h-[400px] min-h-[400px] hover:scale-110 transition duration-200">
        </a>
        <div class="flex flex-1 flex-col w-full h-full p-2"  style="background: rgba(0,0,0,0.8)">
            @if(session('error'))
                <div class="text-xs font-semibold py-1 px-3">{{ session('error') }}</div>
            @endif
            <div id="movie_name" name="movie_name" class="text-xl font-extrabold py-1 px-3 " >
                {{ $airing->showing->movie->name }}
            </div>
            <div id="cinema_name" name="cinema_name" class="text-lg font-extrabold text-red-500 py-1 px-3 " >
                {{ $airing->cinema->name }} - {{ $airing->cinema->location  }}
            </div>
            <div id="room_id" name="room_id" class="text-md font-semibold text-white/80 py-1 px-3" >
                {{ $airing->room->name }}
            </div>
            <div id="day" name="day" class="text-md font-semibold text-white/80 py-1 px-3" >
                {{ $airing->day->format('d/m/Y') }}
            </div>
            <div id="startTime" name="startTime" class="text-md font-semibold text-white/80 py-1 px-3" >
                {{ $airing->startTime->format('H:i A') }}
            </div>
            <div id="price" name="price" class="text-md font-semibold text-white/80 py-1 px-3" >
                {{ $airing->price }} $
            </div>
            <div id="available_seats" name="available_seats" class="text-md font-semibold text-white py-1 px-3" >
                Available seats: {{ $airing->room->capacity - $airing->occupied }}
            </div>
            <div class="text-md font-semibold text-white/80 py-1 px-3 flex flex-col">
                <label for="seats">Number of seats you want</label>
                <input id="seats" name="quantity" type="number" min="0" class="bg-transparent border-b border-b-gray-200 outline-none" placeholder="1" required>
            </div>

            <div class="w-full flex flex-1 justify-end items-center">
                <button type="submit" class="px-6 py-3 bg-gray-200 hover:bg-gray-400 m-1 rounded-sm font-semibold transition-all duration-200 text-black" >Buy ticket</button>
            </div>
        </div>
    </form>
</div>
@endsection
