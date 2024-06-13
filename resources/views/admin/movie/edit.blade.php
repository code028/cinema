@extends('layouts.admin')

@section('title', 'Edit User')

@php
$duration = explode(":", $movie->duration);
$hours = ltrim($duration[0],0);
$minutes = ltrim($duration[1],0);
@endphp

@section('content')
    <div class="min-w-fit">
        <form action="{{ route('movies.update', ['movie' => $movie->id]) }}" method="POST" class="flex flex-col gap-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3 class="text-2xl font-semibold">Update movie</h3>
            <div class="flex flex-col gap-5">
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="name" class="text-gray-600">Movie name</label>
                        {{-- Name --}}
                        <input id="name" type="text" name="name" placeholder="Name of movie" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $movie->name }}" required/>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="directors" class="text-gray-600">Directors</label>
                        {{-- Directors --}}
                        <input id="directors" type="text" name="directors" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $movie->directors }}" required/>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="writers" class="text-gray-600">Writers</label>
                        {{-- Writers --}}
                        <input id="writers" type="text" name="writers" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $movie->writers }}" required/>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="actors" class="text-gray-600">Actors</label>
                        {{-- Actors --}}
                        <input id="actors" type="text" name="actors" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $movie->actors }}" required/>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="hours" class="text-gray-600">Duration of movie</label>
                        <div class="max-w-[350px] rounded flex gap-3">
                            {{-- Hours --}}
                            <input type="number" id="hours" name="hours" placeholder="Hours" class="py-2 px-4 bg-gray-100 rounded max-w-[169px]" value="{{ $hours }}" required />
                            {{-- Minutes --}}
                            <input type="number" id="minutes" name="minutes" placeholder="Minutes" class="py-2 px-4 bg-gray-100 rounded max-w-[169px]" value="{{ $minutes }}" required />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="image" class="text-gray-600">Image of movie</label>
                        {{-- File img --}}
                        <input id="image" type="file" name="image" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" />
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="released" class="text-gray-600">Released date</label>
                        {{-- Released --}}
                        <input type="date" id="released" name="released" placeholder="Released date" class="py-2 px-4 bg-gray-100 rounded max-w-[350px] md:min-w-[350px]" value="{{ $movie->released }}" required />
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="rating" class="text-gray-600">Rating of movie</label>
                        {{-- Rating --}}
                        <input type="number" step=".1" min="1" max="10" id="rating" name="rating" placeholder="Rating of movie" class="py-2 px-4 bg-gray-100 rounded max-w-[350px] md:min-w-[350px]" value="{{ $movie->rating }}" required />
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="imdb" class="text-gray-600">Movie imdb</label>
                        {{-- Imdb --}}
                        <input type="text" id="imdb" name="imdb" class="py-2 px-4 bg-gray-100 rounded max-w-[350px] md:min-w-[350px]" value="{{ $movie->imdb }}" required />
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="trailer" class="text-gray-600">Movie trailer</label>
                        {{-- Trailer --}}
                        <input type="text" id="trailer" name="trailer" class="py-2 px-4 bg-gray-100 rounded max-w-[350px] md:min-w-[350px]" value="{{ $movie->trailer }}" required />
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="description" class="text-gray-600">Description of movie</label>
                    {{-- Description --}}
                    <textarea id="description" name="description" class="py-2 px-4 min-h-[100px] bg-gray-100 rounded max-w-[350px] md:min-w-[720px]" required >{{ $movie->description }}</textarea>
                </div>
                @if( $categories->count() > 0 )
                    <div class="w-full py-3">
                        <label for="categories">Select categories for movie:</label>
                        <div class="grid grid-cols-4 gap-3 py-2 px-4">
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category{{ $category->id }}"
                                        {{ in_array($category->id, $movieCategories) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                <div class="py-3 max-w-[350px] md:min-w-[720px] pl-1">
                    There are no categories in db <br>Please add <a href="{{ route('categories.create') }}" class="text-red-500">category</a> if you want to add it to this movie
                </div>
                @endif
            </div>
            <div class="w-full flex justify-end">
                <button type="submit" class="py-2 px-4 min-w-[350px] bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white">Save changes</button>
            </div>
        </form>
    </div>
@endsection()
