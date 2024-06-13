@extends('layouts.admin')

@section('title', 'Show Movie')

@php
$duration = explode(":", $movie->duration);
$hours = $duration[0];
$minutes = $duration[1];
@endphp

@section('content')
    <div class="min-w-[350px]">
        <div class="flex flex-col gap-5">
            <h3 class="text-2xl font-semibold">Review of movie</h3>
            <div class="flex flex-col gap-5">
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="name" class="text-gray-600">Movie name</label>
                        {{-- Name --}}
                        <input id="name" type="text" name="name" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $movie->name }}" disabled/>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="directors" class="text-gray-600">Directors</label>
                        {{-- Directors --}}
                        <input id="directors" type="text" name="directors" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $movie->directors }}" disabled/>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="writers" class="text-gray-600">Writers</label>
                        {{-- Writers --}}
                        <input id="writers" type="text" name="writers" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $movie->writers }}" disabled/>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="actors" class="text-gray-600">Actors</label>
                        {{-- Actors --}}
                        <input id="actors" type="text" name="actors" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $movie->actors }}" disabled/>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="name" class="text-gray-600">Duration of movie</label>
                        <div class="w-[350px] rounded flex gap-3">
                            {{-- Hours --}}
                            <input type="number" id="hours" name="hours" placeholder="Hours" class="py-2 px-4 bg-gray-100 rounded max-w-[169px]" value="{{ $hours }}" disabled />
                            {{-- Minutes --}}
                            <input type="number" id="minutes" name="minutes" placeholder="Minutes" class="py-2 px-4 bg-gray-100 rounded max-w-[169px]" value="{{ $minutes }}" disabled />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="name" class="text-gray-600">Image of movie</label>
                        <a href="{{ asset($movie->image) }}" target="_blank" class="cursor-pointer hover:outline-blue-400">
                            <button type="text" id="image" name="image" class="py-2 px-4 bg-gray-100 rounded w-[350px]">{{ "Click to see image" }}</button>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="released" class="text-gray-600">Realeased date</label>
                        {{-- Released --}}
                        <input type="date" id="released" name="released" placeholder="Released date" class="py-2 px-4 bg-gray-100 rounded max-w-[350px] md:min-w-[350px]" value="{{ $movie->released }}" disabled />
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="rating" class="text-gray-600">Rating of movie</label>
                        {{-- Rating --}}
                        <input type="number" step=".1" min="1" max="10" id="rating" name="rating" placeholder="Rating of movie" class="py-2 px-4 bg-gray-100 rounded max-w-[350px] md:min-w-[350px]" value="{{ $movie->rating }}" disabled />
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="imdb" class="text-gray-600">Movie imdb</label>
                        {{-- Imdb --}}
                        <input type="text" id="imdb" name="imdb" placeholder="Movie imdb" class="py-2 px-4 bg-gray-100 rounded max-w-[350px] md:min-w-[350px]" value="{{ $movie->imdb }}" disabled />
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="trailer" class="text-gray-600">Movie trailer</label>
                        {{-- Trailer --}}
                        <input type="text" id="trailer" name="trailer" placeholder="Movie trailer" class="py-2 px-4 bg-gray-100 rounded max-w-[350px] md:min-w-[350px]" value="{{ $movie->trailer }}" disabled />
                    </div>
                </div>
                <div class="flex flex-col gap-2 ">
                    <label for="description" class="text-gray-600">Description of movie</label>
                    {{-- Description --}}
                    <textarea id="description" name="description" placeholder="Description of movie" class="py-2 px-4 min-h-[100px] bg-gray-100 rounded max-w-[350px] md:min-w-[720px]" disabled >{{ $movie->description }}</textarea>
                    @if( $movieCategories->count() > 0)
                        <div class="w-full py-3">
                            <label for="categories">Categories of movie:</label>
                            <div class="grid grid-cols-4 gap-3 py-2 px-4">
                                @foreach($movieCategories as $category)
                                    <div class="form-check">
                                        <label class="form-check-label text-gray-500" for="category{{ $category->id }}">
                                            #{{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="w-full flex justify-end">
                <a href="{{ route('movies.index') }}" class="py-2 px-4 min-w-[350px] bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >
                    <div class="flex gap-3 justify-center ">
                        <x-lucide-chevron-left class="w-[36px] h-[36px] text-white" />
                    </div>
                </a>
            </div>
        </form>
    </div>
@endsection()
