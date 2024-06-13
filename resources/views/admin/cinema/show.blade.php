@extends('layouts.admin')

@section('title', 'Show Cinema')


@section('content')
    <div class="min-w-[350px]">
        <div class="flex flex-col gap-5">
            <h3 class="text-2xl font-semibold">Review of cinema</h3>
            <div class="flex flex-col gap-5">
                <div class="flex flex-col gap-2 ">
                    <label for="name" class="text-gray-600">Name of cinema</label>
                    <div id="name" class="py-2 px-4 bg-gray-100 max-w-[350px] rounded" >
                        {{ $cinema->name }}
                    </div>
                </div>
                <div class="flex flex-col gap-2 ">
                    <label for="location" class="text-gray-600">Location of cinema</label>
                        <div id="location" class="py-2 px-4 bg-gray-100 max-w-[350px] rounded" >
                        {{ $cinema->location }}
                    </div>
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="flex justify-center items-center py-2 px-4 bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >
                <div class="flex gap-3 items-center">
                    <x-lucide-chevron-left class="w-[36px] h-[36px] text-white" />
                </div>
            </a>
        </div>
    </div>
@endsection()
