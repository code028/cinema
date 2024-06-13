@extends('layouts.admin')

@section('title', 'Edit Category')


@section('content')
<div class="min-w-[350px]">
    <form action="{{ route('categories.update', $category) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('PUT')
        <h3 class="text-2xl font-semibold">Update category</h3>
        <div class="flex flex-col gap-5">
            <div class="flex flex-col gap-2 ">
                <label for="name" class="text-gray-600">Name of category</label>
                <input type="text" name="name" class="py-2 px-4 bg-gray-100 max-w-[350px] rounded" value="{{ $category->name }}" />
            </div>
        </div>
        <button type="submit" class="py-2 px-4 bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >Save changes</button>
    </form>
</div>
@endsection()
