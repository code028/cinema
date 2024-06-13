@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="w-full flex flex-col md:flex-row transition relative">
    <form method="POST" action="{{ route("login") }}" class="w-full md:w-1/2 xl:w-1/2 flex flex-col justify-center items-center order-2 md:order-1 px-4 md:px-0">
        @csrf
        <div class="text-2xl py-4 w-full md:w-1/2 font-semibold">Login to your account</div>
        <label for="creds" class="w-full md:w-1/2 py-2">Name</label>
        <input id="creds" name='login' type="text" placeholder="Username / Email" class="w-full md:w-1/2 px-2 py-2 border-0 bg-gray-100 rounded-md text-black" required>
        <label for="password" class="w-full md:w-1/2 py-2">Password</label>
        <input id="password" name='password' type="password" placeholder="********" class=" w-full md:w-1/2 px-2 py-2 border-0 bg-gray-100 rounded-md text-black" required>
        <button type="submit" class="w-full md:w-1/2 py-2 px-4 my-2 bg-gray-100 rounded-md hover:bg-gray-200 duration-200 font-semibold text-black" >Login</button>
    </form>
    <div class="w-full md:w-1/2 xl:w-1/2 flex md:flex-1 justify-center items-center order-1 md:order-2">
        <img src="{{ asset('images/login.png') }}" class="hover:scale-110 w-1/2 sm:w-1/3 md:w-2/3 xl:w-2/3 transition duration-200 md:animate-bounce" alt="Movie image">
    </div>
</div>
@endsection
