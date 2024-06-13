@extends('layouts.main')
@use(Carbon\Carbon)

@section('title', 'Show Movie')

@section('content')
    <div class="w-full h-full flex flex-col items-center text-white" style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('{{ asset($movie->image) }}'); background-size:cover; background-attachment:fixed;">
        <div class="w-full h-full flex flex-col items-center text-white backdrop-blur-lg p-5 px-4 md:px-0">
            <div class="w-full lg:w-3/4 flex justify-between p-3 rounded-md">
                <h1 class="flex-1 text-3xl font-semibold italic">{{ $movie->name }}</h1>
                <div class="flex justify-center items-center gap-5">
                    <x-lucide-star  class="w-8 h-8 text-yellow-400 stroke-yellow-400 stroke-2"/>
                    <div class="text-md font-semibold md:text-2xl">{{ $movie->rating }} / 10</div>
                </div>
            </div>
            <div class="w-full lg:w-3/4 flex flex-col items-center md:flex-row justify-center p-5 gap-3">
                <div class="overflow-hidden w-full max-w-[275px] rounded-md">
                    <img src="{{ $movie->image }}" alt="{{ $movie->name }}" class="h-[400px] min-h-[400px] hover:scale-110 transition duration-200">
                </div>
                <div href="{{ $movie->trailer }}" class="flex justify-center h-[400px] bg-transparent overflow-hidden rounded-lg" >
                    <video
                        id="my-video"
                        class="video-js object-fill"
                        controls
                        preload="auto"
                        width="640"
                        height="264"
                        poster="{{ $movie->coverImage }}"
                        data-setup="{}"
                    >
                        <source class="w-full h-full" src="{{ $movie->trailer }}" type="video/mp4" />
                    </video>
                </div>
            </div>
            @php
                $duration = explode(":", $movie->duration);
                $hours = ltrim($duration[0],0);
                $minutes = ltrim($duration[1],0);
                $released = Carbon::parse($movie->released)->format('d/m/Y')
            @endphp
            <div class="w-full lg:w-3/4 p-5 text-gray-300 font-semibold flex gap-x-10">
                <div class="px-6 py-3 flex rounded-md justify-center items-center gap-3" style="background: rgba(0,0,0,0.7)">
                    <div>
                        Duration: {{ $hours . "h " . $minutes . "m" }}
                    </div>
                    <div>
                        Released: {{ $released }}
                    </div>
                    @if(Auth::check())
                        @php
                            $user = Auth::user();
                        @endphp
                        @if ($user->movies()->where('movie_id', $movie->id)->exists())
                            <form action="{{ route('movie.favorite', $movie->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex justify-center items-center">
                                    <x-lucide-bookmark-check  class="w-8 h-8 text-yellow-400 stroke-yellow-400 stroke-2"/>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('movie.favorite', $movie->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex justify-center items-center">
                                    <x-lucide-bookmark  class="w-8 h-8 text-yellow-400 stroke-yellow-400 stroke-2"/>
                                </button>
                            </form>
                        @endif
                        {{-- Edit movie --}}
                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'moderator')
                            <a href="{{ route('movies.edit', $movie->id) }}">
                                <x-lucide-pencil class="w-7 h-7" />
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="w-full lg:w-3/4 p-5" >
                @if(!$groupedAirings->isEmpty())
                <form class="w-full flex flex-col sm:flex-row sm:justify-end sm:items-center gap-5 py-2">
                    <select id="selected_cinema" name="selected_cinema" class="py-2 bg-transparent focus:outline-none  sm:text-sm rounded-md">
                        <option value="all" class="bg-black/60 text-white text-md" selected>All Cinemas</option>
                        @foreach($all_cinemas as $cinema)
                            <option class="bg-black/60 text-white text-md" value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                        @endforeach
                    </select>
                    <select id="selected_date" name="selected_date" class="py-2 bg-transparent focus:outline-none  sm:text-sm rounded-md">
                        @foreach($dates as $date)
                            <option class="bg-black/60 text-white text-md" value="{{ $date['value'] }}">{{ $date['label'] }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="py-2 px-4 border border-gray-500 bg-black/60 text-md rounded-lg">Search</button>
                </form>
                {{-- All Airings listed here: --}}
                    @foreach ($groupedAirings as $cinemaId => $airings)
                        @php
                            $cinema = $airings->first()->cinema
                        @endphp
                        {{-- hangle ticket create --}}
                        <div class="w-full p-5 rounded text-gray-50 shadow-lg mb-2" style="background: rgba(0,0,0,0.7)">
                            <div class="text-2xl mb-5">{{ $cinema->name }}</div>
                            <div class="w-full flex gap-5 overflow-x-auto">
                                {{-- Airings in rooms --}}
                                @foreach ($airings as $airing)
                                    @php
                                        $airingStartTime = Carbon::parse($airing->day->format('Y-m-d') . ' ' . $airing->startTime->format('H:i'));
                                        $isPast = $airingStartTime->lt(Carbon::now());
                                        $availableSeats = true;
                                        if($airing->occupied == $airing->room->capacity){
                                            $availableSeats = false;
                                        }
                                    @endphp
                                    @if(!$isPast && $availableSeats)
                                        <a href="{{ route('ticket.overview', [$movie->id, $airing->id]) }}">
                                            <button type="submit" class="border border-gray-700 flex gap-5 rounded-md py-2 px-4 cursor-pointer">
                                                {{ $airing->room->name }} - {{ \Carbon\Carbon::parse($airing->startTime)->format('H:i A') }} {{ $airing->day->format("d/m") }}
                                            </button>
                                        </a>
                                    @else
                                        <button type="submit" class="border-2 border-red-700 flex gap-5 rounded-md py-2 px-4 cursor-pointer" disabled>
                                            {{ $airing->room->name }} - {{ \Carbon\Carbon::parse($airing->startTime)->format('H:i A') }} {{ $airing->day->format("d/m") }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="w-full p-5 rounded text-gray-50 shadow-lg border-2 border-red-700" style="background: rgba(0,0,0,0.7)">
                        There are no airings for this movie
                    </div>
                @endif
            </div>

            <div class="w-full lg:w-3/4 p-5" >
                <div class="w-full  rounded text-gray-50 shadow-lg p-8" style="background: rgba(0,0,0,0.7)">
                        {{ $movie->description }}
                </div>
            </div>
            <div class="w-full lg:w-3/4 p-5 flex items-center gap-x-2" >
                @if($movie->categories != null)
                    @foreach ($movie->categories as $category)
                        <div class="text-white/60">
                            #{{ $category->name }}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="w-full lg:w-3/4 p-5 text-[15px]">
                <div class="w-full px-5 py-2 flex gap-5 border-b">
                    <div class="w-[60px]">
                        Directors:
                    </div>
                    <div class="text-blue-400">
                        {{ $movie->directors }}
                    </div>
                </div>
                <div class="w-full px-5 py-2 flex gap-5 border-b">
                    <div class="w-[60px]">
                        Writers:
                    </div>
                    <div class="text-blue-400">
                        {{ $movie->writers }}
                    </div>
                </div>
                <div class="w-full px-5 py-2 flex gap-5 ">
                    <div class="w-[60px]">
                        Actors:
                    </div>
                    <div class="text-blue-400">
                        {{ $movie->actors }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
