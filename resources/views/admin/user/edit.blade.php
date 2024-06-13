@extends('layouts.admin')

@section('title', 'Edit User')


@section('content')
    <div class="min-w-fit">
        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" class="flex flex-col gap-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3 class="text-2xl font-semibold">Update User</h3>
            <div class="flex flex-col gap-5">
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="name" class="text-gray-600">User name</label>
                        {{-- Name --}}
                        <input id="name" type="text" name="name" placeholder="Name of movie" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $user->name }}" required/>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="username" class="text-gray-600">Username</label>
                        {{-- Username --}}
                        <input id="username" type="text" name="username" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $user->username }}" required/>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="email" class="text-gray-600">Email</label>
                        {{-- Email --}}
                        <input id="email" type="text" name="email" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $user->email }}" required/>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <label for="phone" class="text-gray-600">Phone</label>
                        {{-- Phone --}}
                        <input id="phone" type="text" name="phone" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ $user->phone }}" required/>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex flex-col gap-2 ">
                        <label for="birthday" class="text-gray-600">Birthday</label>
                        {{-- Birthday --}}
                        <input type="date" id="birthday" name="birthday" placeholder="Birthday date" class="py-2 px-4 bg-gray-100 rounded max-w-[350px] md:min-w-[350px]" value="{{ $user->birthday }}" required />
                    </div>
                    @if($user->role != 'admin')
                        <div class="flex flex-col gap-2 ">
                            <label for="role" class="text-gray-600">Role</label>
                            {{-- Role --}}
                            <select name="role" id="role" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded h-10">
                                <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                    @endif
            </div>
            <div class="w-full flex justify-end">
                <button type="submit" class="py-2 px-4 min-w-[350px] bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white">Save changes</button>
            </div>
        </form>
    </div>
@endsection()
