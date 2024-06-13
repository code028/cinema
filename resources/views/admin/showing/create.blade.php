@extends('layouts.admin')

@section('title', 'Create Showing')


@section('content')
    @if(!$movies->isEmpty())
        <div class="min-w-[350px]">
            <form action="{{ route('showings.store') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <h3 class="text-2xl font-semibold">Create new showing</h3>
                @if(session('success'))
                        <div>{{ session('success') }}</div>
                @endif
                @if(session('error'))
                        <div>{{ session('error') }}</div>
                    @endif
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="name" class="text-gray-600">Movie</label>
                            {{-- Movie_id --}}
                            <select name="movie_id" id="movie_id" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded h-10">
                                <option value="0">Select movie</option>
                                @foreach ($movies as $movie)
                                    <option value="{{ $movie->id }}">{{ $movie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Name --}}
                        <div class="flex flex-col gap-2 ">
                            <label for="name" class="text-gray-600">Name</label>
                            <input id="name" type="text" name="name" placeholder="Name of movie" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ old('name') }}" required/>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="from_date" class="text-gray-600">From date</label>
                            {{-- from_date --}}
                            <input type="date" id="from_date" name="from_date" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ old('from_date') }}" required />
                        </div>
                        <div class="flex flex-col gap-2 ">
                            {{-- to_date --}}
                            <label for="to_date" class="text-gray-600">End date</label>
                            <input type="date" id="to_date" name="to_date" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ old('to_date') }}" required />
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end">
                    <button type="submit" class="py-2 px-4 min-w-[350px] bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >Create</button>
                </div>
            </form>
        </div>
    @elseif($moviesCount == 0)
        <div class="relative w-full h-full flex justify-center items-center">
            <div class="text-xl">There are no movies in db <a href="{{ route("movies.create") }}" class="underline underline-offset-2 text-red-500">Add movie</a></div>
            <a href="{{ route('showings.index') }}" aria-label="All showings" class="absolute top-0 right-0 p-5">
                <x-lucide-undo-2 class="w-[36px] h-[36px] text-black"/>
            </a>
        </div>
    @elseif($movies->isEmpty())
        <div class="relative w-full h-full flex justify-center items-center">
            <div class="text-xl">All movies are currently in showings. <a href="{{ route("movies.create") }}" class="underline underline-offset-2 text-red-500">Add movie</a> if you want to add another showing</div>
            <a href="{{ route('showings.index') }}" aria-label="All showings" class="absolute top-0 right-0 p-5">
                <x-lucide-undo-2 class="w-[36px] h-[36px] text-black"/>
            </a>
        </div>
    @endif
@endsection
