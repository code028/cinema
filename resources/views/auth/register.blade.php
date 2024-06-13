@extends('layouts.auth')


@section('title', 'Register')

@section('content')
    <div class="w-full flex flex-col md:flex-row transition relative">
        <form method="POST" action="{{ route('register') }}" class="w-full md:w-1/2 xl:w-1/2 flex flex-col justify-center items-center order-2 md:order-1 px-4 md:px-0">
            @csrf
            <div class="text-2xl py-4 w-full md:w-1/2 font-semibold">Register new account</div>
            <label for="name" class="w-full md:w-1/2 py-2">Name</label>
            <input name="name" id="name" type="text" placeholder="Franc Hopper" class="w-full md:w-1/2 px-2 py-2 border-0 bg-gray-100 rounded-md" required>
            <label for="username" class="w-full md:w-1/2 py-2">Username</label>
            <input name="username" id="username" type="text" placeholder="Hopper" class=" w-full md:w-1/2 px-2 py-2 border-0 bg-gray-100 rounded-md" required>
            <label for="email" class="w-full md:w-1/2 py-2">Email</label>
            <input name="email" id="email" type="email" placeholder="hopper@gmail.com" class=" w-full md:w-1/2 px-2 py-2 border-0 bg-gray-100 rounded-md" required>
            <label for="password" class="w-full md:w-1/2 py-2">Password</label>
            <input name="password" id="password" type="password" placeholder="********" class=" w-full md:w-1/2 px-2 py-2 border-0 bg-gray-100 rounded-md" required>
            <label for="phone" class="w-full md:w-1/2 py-2">Phone</label>
            <input name="phone" id="phone" type="text" placeholder="064 - 666 - 5578" class=" w-full md:w-1/2 px-2 py-2 border-0 bg-gray-100 rounded-md" required>
            <label for="birthday" class="w-full md:w-1/2 py-2">Birthday</label>
            <input name="birthday" id="birthday" type="date" class=" w-full text-black md:w-1/2 px-2 py-2 bg-gray-100 rounded-md border-b-2" required>
            <button type="submit" class="w-1/2 md:w-1/2 py-2 px-4 my-2 bg-gray-100 rounded-md hover:bg-gray-200 duration-200 text-black font-semibold">Create account</button>
        </form>
        <div class="w-full md:w-1/2 xl:w-1/2 flex md:flex-1 justify-center items-center order-1 md:order-2">
            <img src="{{ asset('images/movie_form_2.png') }}" class="hover:scale-110 w-1/2 sm:w-1/3 md:w-2/3 xl:w-2/3 transition duration-200" alt="Movie image">
        </div>
    </div>
@endsection
