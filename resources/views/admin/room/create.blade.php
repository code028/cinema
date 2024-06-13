@extends('layouts.admin')

@section('title', 'Room Create')

@section('content')
    @if(!$cinemas->isEmpty())
        <div class="min-w-[350px]">
            <form action="{{ route('rooms.store') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <h3 class="text-2xl font-semibold">Create new room</h3>
                @if(session('error'))
                            <div>{{ session('error') }}</div>
                @endif
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="cinema_id" class="text-gray-600">Cinema</label>
                            <select name="cinema_id" id="cinema_id" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" required>
                            <option value="0">Select Cinema</option>
                                @foreach ($cinemas as $cinema)
                                    <option value="{{ $cinema->id }}">{{ $cinema->name . " - " . $cinema->location }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="name" class="text-gray-600">Room name</label>
                            {{-- Time --}}
                            <input id="name" type="text" name="name" placeholder="Name of room" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ old('name') }}" required/>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="capacity" class="text-gray-600">Capacity</label>
                            {{-- Time --}}
                            <input id="capacity" type="number" min="1" name="capacity" placeholder="Capacity of room" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ old('capacity') }}" required/>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end">
                    <button type="submit" class="py-2 px-4 min-w-[350px] bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >Create</button>
                </div>
            </form>
        </div>
    @else
    <div class="relative w-full h-full flex justify-center items-center">
        <div class="text-xl">There are no cinemas in database! <a href="{{ route("cinemas.create") }}" class="text-red-500 underline underline-offset-2">Add cinema</a></div>
        <a href="{{ route('rooms.index') }}" aria-label="All showings" class="absolute top-0 right-0 p-5">
            <x-lucide-undo-2 class="w-[36px] h-[36px] text-black"/>
        </a>
    </div>
    @endif

@endsection
