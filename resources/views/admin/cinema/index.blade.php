@extends('layouts.admin')

@section('title', 'All Cinemas')


@section('content')


<div class="relative w-full h-full flex justify-center items-center">
    <a href="{{ route('cinemas.create') }}" aria-label="Add new Cinema" class="absolute top-0 right-0 p-5">
        <x-lucide-badge-plus class="w-[36px] h-[36px] text-black"/>
    </a>
    @if($count > 0)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full mx-10">
            <div class="text-xl font-semibold w-full py-2 text-center">
                @if(session('success'))
                    <div>{{ session('success') }}</div>
                @endif
            </div>
            <table class="w-full text-sm text-left rounded overflow-hidden table-auto">
                <thead class="text-xs uppercase bg-black/95 text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Location
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cinemas as $cinema)
                        <tr class="bg-white border-b text-black">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $cinema->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $cinema->location }}
                            </td>
                            <td class="px-6 py-4 text-right flex gap-3">
                                <a href="{{ route('cinemas.show',['cinema' => $cinema->id]) }}" aria-label="View" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    <x-lucide-eye  class="w-[28px] h-[28px] text-black hover:rotate-12 transition"/>
                                </a>
                                <a href="{{ route('cinemas.edit',['cinema' => $cinema->id]) }}" aria-label="Edit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    <x-lucide-pencil  class="w-[28px] h-[28px] text-black hover:rotate-12 transition"/>
                                </a>
                                <form method="POST" action="{{ route('cinemas.destroy', $cinema->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
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
        <div class="text-xl">There is no cinemas in database</div>
    @endif
</div>


@endsection()
