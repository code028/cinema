@extends('layouts.main')
@use(Carbon\Carbon)
@use(App\Models\Showing)

@section('title', 'All Movies')

@section('content')
    <div class="flex flex-col items-center relative">
        <form method="GET" action="" class="w-full flex justify-end items-center pt-5">
            <input name="search" class="bg-white/30 text-gray-400 px-4 py-2 rounded-l-md" placeholder="Search" />
            <button type="submit" class="bg-blue-100 text-black px-4 py-2 border-l-2 rounded-r-md border-white/10">Search</button>
        </form>
        <div class="w-full md:w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($movies as $movie)
                <a href="{{ route('page.movie', $movie->id) }}" class="w-full group py-5 col-span-1 flex flex-col items-center">
                    {{-- image --}}
                    {{-- max-w-[380px] --}}
                    <div class="overflow-hidden w-full max-w-[275px] rounded-md">
                        <img src="{{ $movie->image }}" alt="{{ $movie->name }}" class="h-[400px] hover:scale-110 transition duration-300">
                    </div>
                    {{-- name --}}
                    <div class="text-xl font-semibold w-full text-wrap py-3 text-white group-hover:text-gray-400 duration-200">
                        {{ $movie->name }}
                    </div>
                    @php
                        $showing = Showing::where('movie_id', $movie->id)->first();
                        if ($showing) {
                            $from_date = Carbon::parse($showing->from_date)->format('d/m/Y');
                        } else {
                            $from_date = 'Uskoro';
                        }
                        // $from_date = Carbon::parse($showing->from_date)->format('d/m/Y');
                    @endphp
                    <div class="w-full flex justify-start text-wrap text-gray-400 font-semibold">
                        Pocetak prikazivanja {{ $from_date }}
                    </div>
                    {{-- showing period --}}
                </a>
            @endforeach
        </div>
        <div class="absolute bottom-0 right-0 flex gap-x-5">
            {{ $movies->links() }}
        </div>
    </div>
@endsection
