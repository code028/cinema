@extends('layouts.admin')

@section('title', 'Room Edit')

@section('content')
    <div class="min-w-[350px]">
        <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="flex flex-col gap-5">
            @csrf
            @method('PUT')
            <h3 class="text-2xl font-semibold">Edit room</h3>
            @if(session('error'))
                        <div>{{ session('error') }}</div>
            @endif
            <div class="flex flex-col gap-5">
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="cinema_id" class="text-gray-600">Cinema name</label>
                        {{-- Time --}}
                        <input id="cinema_id" type="text" name="cinema_id" placeholder="Name of cinema" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $room->cinema->name }}" disabled/>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="name" class="text-gray-600">Room name</label>
                        {{-- Time --}}
                        <input id="name" type="text" name="name" placeholder="Name of room" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $room->name }}" required/>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="capacity" class="text-gray-600">Capacity</label>
                        {{-- Time --}}
                        <input id="capacity" type="number" min="1" name="capacity" placeholder="Capacity of room" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $room->capacity }}" required/>
                    </div>
                </div>
            </div>
            <div class="w-full flex justify-end">
                <button type="submit" class="py-2 px-4 min-w-[350px] bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >Save changes</button>
            </div>
        </form>
    </div>
@endsection
