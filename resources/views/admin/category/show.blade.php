@extends('layouts.admin')

@section('title', 'Show Category')


@section('content')
<div class="min-w-[350px]">
    <div class="flex flex-col gap-5">
        <h3 class="text-2xl font-semibold">Review of category</h3>
        <div class="flex flex-col gap-5">
            <div class="flex flex-col gap-2 ">
                <label for="name" class="text-gray-600">Name of category</label>
                <input type="text" name="name" class="py-2 px-4 bg-gray-100 max-w-[350px] rounded" value="{{ $category->name }}" disabled/>
            </div>
        </div>
        <a href="{{ route('categories.index') }}" class="flex justify-center items-center py-2 px-4 bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >
            <div class="flex gap-3 items-center">
                <x-lucide-chevron-left class="w-[36px] h-[36px] text-white" />
            </div>
        </a>
    </div>
</div>
@endsection()
