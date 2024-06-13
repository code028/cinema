@extends('layouts.admin')

@section('title', 'All Users')


@section('content')
    <div class="relative w-full h-full flex justify-center items-center">
        @if($users->count() > 0)
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full mx-10">
                <div class="text-xl font-semibold w-full py-2 text-center">
                    @if(session('success'))
                        <div>{{ session('success') }}</div>
                    @endif
                </div>
                <table class="w-full text-sm text-left rounded overflow-hidden">
                    <thead class="text-xs uppercase bg-black/95 text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="bg-white border-b text-black">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ "@".$user->username }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $user->email }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $user->role }}
                                </td>
                                <td class="px-6 py-4 text-right flex gap-3">
                                    {{-- <a href="{{ route('users.show',['user' => $user->id]) }}" aria-label="View" class="font-medium">
                                        <x-lucide-eye  class="w-[28px] h-[28px] text-black hover:rotate-12 transition"/>
                                    </a> --}}
                                    <a href="{{ route('users.edit',['user' => $user->id]) }}" aria-label="Edit" class="font-medium">
                                        <x-lucide-pencil  class="w-[28px] h-[28px] text-black hover:rotate-12 transition"/>
                                    </a>
                                    @if($user->role != "admin")
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="font-medium">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" aria-label="Delete" >
                                                <x-lucide-trash-2  class="w-[28px] h-[28px] text-black hover:rotate-12 transition"/>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-xl">There is no users</div>
        @endif
    </div>
@endsection()
