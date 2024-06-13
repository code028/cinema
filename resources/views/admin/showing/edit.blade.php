@extends('layouts.admin')

@section('title', 'Edit Showing')


@section('content')
<div class="min-w-[350px]">
    <form action="{{ route('showings.update', ["showing" => $showing->id]) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('PUT')
        <h3 class="text-2xl font-semibold">Update showing</h3>
        @if(session('success'))
            <div>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div>{{ session('error') }}</div>
        @endif
        <div class="flex flex-col gap-5">
            <div class="flex flex-col md:flex-row gap-5">
                <div class="flex flex-col gap-2 ">
                    <div class="flex flex-col gap-2 ">
                        <label for="movie_id" class="text-gray-600">Editing movie with ID</label>
                        {{-- Movie_id --}}
                        <input type="number" id="movie_id" name="movie_id" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $showing->movie_id }}" disabled/>
                    </div>
                </div>
                {{-- Name --}}
                <div class="flex flex-col gap-2 ">
                    <label for="name" class="text-gray-600">Name</label>
                    <input id="name" type="text" name="name" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $showing->name }}" required/>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-5">
                <div class="flex flex-col gap-2 ">
                    <label for="from_date" class="text-gray-600">From date</label>
                    {{-- from_date --}}
                    <input type="date" id="from_date" name="from_date" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $showing->from_date }}" required />
                </div>
                <div class="flex flex-col gap-2 ">
                    {{-- to_date --}}
                    <label for="to_date" class="text-gray-600">End date</label>
                    <input type="date" id="to_date" name="to_date" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $showing->to_date }}" required />
                </div>
            </div>
        </div>
        <div class="w-full flex justify-end">
            <button type="submit" class="py-2 px-4 min-w-[350px] bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white">Save changes</button>
        </div>
    </form>
</div>

@endsection
