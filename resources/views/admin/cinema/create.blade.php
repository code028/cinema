@extends('layouts.admin')

@section('title', 'Create New Cinema')


@section('content')
    <div class="min-w-[350px]">
        <form action="{{ route('cinemas.store') }}" method="POST" class="flex flex-col gap-5">
            @csrf
            <h3 class="text-2xl font-semibold">Create new cinema</h3>
            @if(session('error'))
                    <div>{{ session('error') }}</div>
            @endif
            <div class="flex flex-col gap-5">
                <div class="flex flex-col gap-2 ">
                    <label for="name" class="text-gray-600">Name of cinema</label>
                    <input type="text" name="name" placeholder="Cinema name" class="py-2 px-4 bg-gray-100 max-w-[350px] rounded" />
                </div>
                <div class="flex flex-col gap-2 ">
                    <label for="location" class="text-gray-600">Location of cinema</label>
                    <input type="text" name="location" placeholder="Location of cinema" class="py-2 px-4 bg-gray-100 max-w-[350px] rounded" />
                </div>
            </div>
            <button type="submit" class="py-2 px-4 bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >Create</button>
        </form>
    </div>
@endsection()
