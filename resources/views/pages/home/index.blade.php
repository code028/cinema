@extends('layouts.main')

@section('title', 'Home')

@section('content')
    <div class="flex flex-col items-center relative">
        <div class="w-full group py-5 col-span-1 flex flex-col items-center">
            <form class="w-full flex flex-col sm:flex-row sm:justify-end sm:items-center gap-5 py-2">
                <select id="selected_cinema" name="selected_cinema" class="py-2 bg-transparent focus:outline-none text-white  sm:text-sm rounded-md">
                    <option value="all" class="bg-black/60  text-md" selected>All Cinemas</option>
                    @foreach($all_cinemas as $cinema)
                        <option class="bg-black/60 text-white text-md" value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                    @endforeach
                </select>
                <select id="selected_date" name="selected_date" class="py-2 bg-transparent focus:outline-none text-white sm:text-sm rounded-md">
                    @foreach($dates as $date)
                        <option class="bg-black/60 text-white text-md" value="{{ $date['value'] }}">{{ $date['label'] }}</option>
                    @endforeach
                </select>
                <button type="submit" class="py-2 px-4 border border-gray-500 bg-white/30 text-white text-md rounded-lg">Search</button>
            </form>
        </div>
        <div class="w-full md:w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($showings as $showing)
                <a href="{{ route('page.movie', $showing->movie_id) }}" class="w-full group py-5 col-span-1 flex flex-col items-center">
                    {{-- image --}}
                    <div class="overflow-hidden w-full max-w-[275px] rounded-md">
                        <img src="{{ $showing->movie->image }}" alt="{{ $showing->movie->name }}" class="h-[400px] hover:scale-110 transition duration-300">
                    </div>
                    {{-- name --}}
                    <div class="text-xl font-semibold w-full text-wrap py-3 text-white group-hover:text-gray-400 duration-200">
                        {{ $showing->movie->name }}
                    </div>
                    {{-- showing period --}}
                </a>
            @endforeach
        </div>
        <div class="absolute bottom-0 right-0 flex gap-x-5">
            {{ $showings->links() }}
        </div>
    </div>
@endsection
