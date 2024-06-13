@extends('layouts.admin')

@section('title', 'Create Airing')

@section('content')
    @if(!$cinemas->isEmpty() && !$showings->isEmpty() && !$rooms->isEmpty())
        <div class="min-w-[350px]">
            <form action="{{ route('airings.store') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <h3 class="text-2xl font-semibold">Create new airing</h3>
                <div class="max-w-[350px] text-wrap">
                    @if(session('error'))
                            <div>{{ session('error') }}</div>
                    @endif
                </div>
                <div class="flex flex-col gap-5">
                    {{-- Select cinema --}}
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="cinema_id" class="text-gray-600">Cinema</label>
                            <select name="cinema_id" id="cinema_id" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" required>
                                <option value="0">Select Cinema</option>
                                @foreach ($cinemas as $cinema)
                                    <option value="{{ $cinema->id }}">{{ $cinema->name . " - " . $cinema->location }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Select room --}}
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="room_id" class="text-gray-600">Room</label>
                            <select name="room_id" id="room_id" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" required>
                                <option value="0">Select Room</option>
                            </select>
                        </div>
                    </div>
                    {{-- Select active movie --}}
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="showing_id" class="text-gray-600">Movie</label>
                            <select name="showing_id" id="showing_id" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" required>
                                <option value="0">Select active showing movie name</option>
                                @foreach ($showings as $showing)
                                    <option value="{{ $showing->id }}">{{ $showing->movie->name. " - " .$showing->movie->duration . "h" }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="price" class="text-gray-600">Price</label>
                            {{-- Writers --}}
                            <input id="price" type="number" min="0" name="price"  placeholder="0" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" value="{{ old('price') }}" required/>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex flex-col gap-2 ">
                            <label for="time" class="text-gray-600">Time of Airing</label>
                            <div id="showing_period" class="py-2"></div>
                            {{-- Time --}}
                            <input id="time" type="datetime-local" name="time" placeholder="Time of airing" class="py-2 px-4 bg-gray-100 max-w-[350px] md:min-w-[350px] rounded" required/>
                            {{-- Termini koji su zauzeti u danu --}}
                            <div id="occupiedTimes" class="py-2"></div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end">
                    <button type="submit" class="py-2 px-4 min-w-[350px] bg-black/90 rounded max-w-[350px] font-semibold  text-xl hover:bg-black/80 transition-all text-white" >Create</button>
                </div>
            </form>
        </div>
    @elseif ($cinemas->isEmpty())
        <div class="relative w-full h-full flex justify-center items-center">
            <div class="text-xl">There are no cinemas in database! <a href="{{ route("cinemas.create") }}" class="text-red-500 underline underline-offset-2">Add cinema</a></div>
            <a href="{{ route('airings.index') }}" aria-label="All showings" class="absolute top-0 right-0 p-5">
                <x-lucide-undo-2 class="w-[36px] h-[36px] text-black"/>
            </a>
        </div>
    @elseif ($showings->isEmpty())
        <div class="relative w-full h-full flex justify-center items-center">
            <div class="text-xl">There are no showings in database! <a href="{{ route("showings.create") }}" class="text-red-500 underline underline-offset-2">Add showing</a></div>
            <a href="{{ route('airings.index') }}" aria-label="All showings" class="absolute top-0 right-0 p-5">
                <x-lucide-undo-2 class="w-[36px] h-[36px] text-black"/>
            </a>
        </div>
    @else
        <div class="relative w-full h-full flex justify-center items-center">
            <div class="text-xl">There are no rooms in database! <a href="{{ route("rooms.create") }}" class="text-red-500 underline underline-offset-2">Add room</a></div>
            <a href="{{ route('airings.index') }}" aria-label="All showings" class="absolute top-0 right-0 p-5">
                <x-lucide-undo-2 class="w-[36px] h-[36px] text-black"/>
            </a>
        </div>
    @endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('cinema_id').addEventListener('change', function() {
            var cinemaId = this.value;
            var roomSelect = document.getElementById('room_id');
            if (cinemaId == 0) {
                roomSelect.innerHTML = '<option value="0">Select Room</option>';
                return;
            }
            fetch('/rooms/' + cinemaId)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        roomSelect.innerHTML = '<option value="0">There are no rooms in this cinema</option>';
                        return;
                    }
                    roomSelect.innerHTML = '<option value="0">Select cinema room</option>';
                    data.forEach(room => {
                        var option = document.createElement('option');
                        option.value = room.id;
                        option.textContent = room.name;
                        roomSelect.appendChild(option);
                    });
            });
        });
        document.getElementById('showing_id').addEventListener('change', function() {
        var showingId = this.value;
        var showingPeriodDiv = document.getElementById('showing_period');

        if (showingId == 0) {
            showingPeriodDiv.innerHTML = '';
            return;
        }

        fetch('/showings/' + showingId)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    var fromDate = new Date(data.fromDate);
                    var toDate = new Date(data.toDate);

                    var fromDay = fromDate.getDate();
                    var fromMonth = fromDate.getMonth() + 1; // Month is 0-indexed
                    var toDay = toDate.getDate();
                    var toMonth = toDate.getMonth() + 1; // Month is 0-indexed

                    showingPeriodDiv.innerHTML = `Airing available from: ${fromDay}/${fromMonth} - ${toDay}/${toMonth}`;
                } else {
                    showingPeriodDiv.innerHTML = 'No showing period available.';
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Funkcija koja prikazuje zauzete termine za odabrani dan i sobu
        function showOccupiedTimes(date, roomId) {
            fetch(`/occupied-times?date=${date}&room_id=${roomId}`)
                .then(response => response.json())
                .then(data => {
                    const occupiedTimesDiv = document.getElementById('occupiedTimes');
                    if (data.length > 0) {
                        let html = '<p>Busy schedule:</p>';
                        data.forEach(airing => {
                            html += `<p class="pl-2 text-gray-500">${airing.startTime} - ${airing.endTime}</p>`;
                        });
                        occupiedTimesDiv.innerHTML = html;
                    } else {
                        occupiedTimesDiv.innerHTML = '<p>No scheduled showings</p>';
                    }
                });
        }

        // Event listener za promenu vrednosti polja "time"
        document.getElementById('time').addEventListener('change', function() {
            const dateTimeValue = this.value;
            const date = dateTimeValue.split('T')[0]; // Dobijamo datum iz datetime-local inputa
            const roomId = document.getElementById('room_id').value;

            if (!date || roomId === '0') {
                document.getElementById('occupiedTimes').innerHTML = '';
                return;
            }

            showOccupiedTimes(date, roomId);
        });

        // Event listener za promenu vrednosti polja "room_id"
        document.getElementById('room_id').addEventListener('change', function() {
            const dateTimeValue = document.getElementById('time').value;
            const date = dateTimeValue.split('T')[0]; // Dobijamo datum iz datetime-local inputa
            const roomId = this.value;

            if (!date || roomId === '0') {
                document.getElementById('occupiedTimes').innerHTML = '';
                return;
            }

            showOccupiedTimes(date, roomId);
        });

        // Event listener za promenu vrednosti polja "cinema_id"
        document.getElementById('cinema_id').addEventListener('change', function() {
            const cinemaId = this.value;
            const roomId = document.getElementById('room_id').value;
            const dateTimeValue = document.getElementById('time').value;
            const date = dateTimeValue.split('T')[0];

            if (cinemaId === '0' || roomId === '0' || !date) {
                document.getElementById('occupiedTimes').innerHTML = '';
                return;
            }

            fetch(`/rooms/${cinemaId}`)
                .then(response => response.json())
                .then(data => {
                    const roomSelect = document.getElementById('room_id');
                    roomSelect.innerHTML = '<option value="0">Select Room</option>';
                    data.forEach(room => {
                        const option = document.createElement('option');
                        option.value = room.id;
                        option.textContent = room.name;
                        roomSelect.appendChild(option);
                    });

                    // Automatski odabir prve sobe (ako ima)
                    if (data.length > 0) {
                        roomSelect.value = data[0].id;
                        showOccupiedTimes(date, data[0].id);
                    } else {
                        roomSelect.value = '0';
                        document.getElementById('occupiedTimes').innerHTML = '';
                    }
                });
        });
    });
</script>

@endsection
