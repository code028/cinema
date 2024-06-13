@extends('layouts.admin')

@section('title', 'All Rooms')

@section('content')
<div class="relative w-full h-full flex justify-center items-center">
    <a href="{{ route('rooms.create') }}" aria-label="Add new Room" class="absolute top-0 right-0 p-5">
        <x-lucide-badge-plus class="w-[36px] h-[36px] text-black"/>
    </a>
    @if($rooms->count() > 0)
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
                            Room name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Cinema
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Capacity
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr class="bg-white border-b text-black">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $room->name }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $room->cinema->name }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $room->capacity }}
                            </th>
                            <td class="px-6 py-4 text-right flex gap-3">
                                {{-- <a href="{{ route('users.show',['user' => $user->id]) }}" aria-label="View" class="font-medium">
                                    <x-lucide-eye  class="w-[28px] h-[28px] text-black hover:rotate-12 transition"/>
                                </a> --}}
                                <a href="{{ route('rooms.edit', $room->id) }}" aria-label="Edit" class="font-medium">
                                    <x-lucide-pencil  class="w-[28px] h-[28px] text-black hover:rotate-12 transition"/>
                                </a>
                                <form method="POST" action="{{ route('rooms.destroy', $room->id) }}" class="font-medium">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Delete" >
                                        <x-lucide-trash-2  class="w-[28px] h-[28px] text-black hover:rotate-12 transition"/>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-xl">There are no room in cinema</div>
    @endif
</div>
@endsection
