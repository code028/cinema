@extends('layouts.admin')

@section('title', 'Create New Category')


@section('content')
    <div class="min-w-[350px]">
        <form action="{{ route('categories.store') }}" method="POST" class="flex flex-col gap-5">
            @csrf
            <h3 class="text-2xl font-semibold">Create new category</h3>
            @if(session('error'))
                    <div>{{ session('error') }}</div>
            @endif
            <div class="flex flex-col gap-5">
                <input type="text" name="name" placeholder="Category name" class="py-2 px-4 bg-gray-100 max-w-[350px] rounded" />
            </div>
            <button type="submit" class="py-2 px-4 bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >Create</button>
        </form>
    </div>
@endsection()
