@extends('layouts.admin')

@section('title', 'Edit Cinema')


@section('content')
<div class="min-w-[350px]">
    <form action="{{ route('cinemas.update', ['cinema' => $cinema]) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('PUT')
        <h3 class="text-2xl font-semibold">Update cinema</h3>
        <div class="flex flex-col gap-5">
            <div class="flex flex-col gap-2 ">
                <label for="name" class="text-gray-600">Name of cinema</label>
                <input required type="text" name="name" value="{{ $cinema->name }}" class="py-2 px-4 bg-gray-100 max-w-[350px] rounded" />
            </div>
            <div class="flex flex-col gap-2 ">
                <label for="location" class="text-gray-600">Location of cinema</label>
                <input required type="text" name="location" value="{{ $cinema->location }}" class="py-2 px-4 bg-gray-100 max-w-[350px] rounded" />
            </div>
        </div>
        <button type="submit" class="py-2 px-4 bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >Save changes</button>
    </form>
</div>
@endsection()
