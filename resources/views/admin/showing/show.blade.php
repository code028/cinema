@extends('layouts.admin')

@section('title', 'Show Showing')


@section('content')
<div class="min-w-[350px]">
    <form action="{{ route('showings.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf
        <h3 class="text-2xl font-semibold">Review of showing</h3>
        @if(session('success'))
                <div>{{ session('success') }}</div>
        @endif
        @if(session('error'))
                <div>{{ session('error') }}</div>
            @endif
        <div class="flex flex-col gap-5">
            <div class="flex flex-col md:flex-row gap-5">
                {{-- Name --}}
                <div class="flex flex-col gap-2 ">
                    <label for="name" class="text-gray-600">Showing name</label>
                    {{-- Showing name --}}
                    <input id="name" type="text" name="name" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $showing->name }}" disabled/>
                </div>
                {{-- Choosed movie --}}
                <div class="flex flex-col gap-2 ">
                    <label for="movie" class="text-gray-600">Movie name</label>
                    <input id="name" type="text" name="movie" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $showing->movie->name }}" disabled/>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-5">
                <div class="flex flex-col gap-2 ">
                    <label for="from_date" class="text-gray-600">From date</label>
                    {{-- from_date --}}
                    <input type="date" id="from_date" name="from_date" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $showing->from_date }}" disabled />
                </div>
                <div class="flex flex-col gap-2 ">
                    {{-- to_date --}}
                    <label for="to_date" class="text-gray-600">End date</label>
                    <input type="date" id="to_date" name="to_date" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $showing->to_date }}" disabled />
                </div>
            </div>
        </div>
        <div class="w-full flex justify-end">
            <a href="{{ route('showings.index') }}" class="py-2 px-4 min-w-[350px] bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >
                <div class="flex gap-3 justify-center ">
                    <x-lucide-chevron-left class="w-[36px] h-[36px] text-white" />
                </div>
            </a>
        </div>
    </form>
</div>

@endsection
