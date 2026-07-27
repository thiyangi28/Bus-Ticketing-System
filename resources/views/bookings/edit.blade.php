@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('bookings.index') }}" class="inline-flex items-center text-slate-500 hover:text-slate-800 mb-6 transition-colors gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to list
    </a>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Edit Reservation Details</h2>

        @if($errors->any())
            <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm">
                <ul class="list-disc pl-5 text-rose-700 text-sm font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Select Passenger</label>
                <select name="user_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $booking->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Select Schedule & Route</label>
                <select id="schedule_id" name="schedule_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->id }}" 
                            data-capacity="{{ $schedule->bus->capacity }}"
                            data-fare="{{ $schedule->fare }}"
                            {{ old('schedule_id', $booking->schedule_id) == $schedule->id ? 'selected' : '' }}>
                            Route {{ $schedule->route->route_number }}: {{ $schedule->route->start_point }} ➔ {{ $schedule->route->end_point }} 
                            ({{ \Carbon\Carbon::parse($schedule->departure_time)->format('M d, h:i A') }} - Bus: {{ $schedule->bus->bus_number }} [Max: {{ $schedule->bus->capacity }} seats])
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Seat Number</label>
                    <input type="number" min="1" name="seat_number" required placeholder="e.g. 12" value="{{ old('seat_number', $booking->seat_number) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                    <span id="capacity-help" class="text-xs text-slate-400 mt-1 block"></span>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Fare Details</label>
                    <div class="px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 font-bold text-indigo-600 h-[50px] flex items-center">
                        <span id="fare-display">LKR --</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Booking Status</label>
                    <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                        <option value="Booked" {{ old('status', $booking->status) == 'Booked' ? 'selected' : '' }}>Booked</option>
                        <option value="Cancelled" {{ old('status', $booking->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="Available" {{ old('status', $booking->status) == 'Available' ? 'selected' : '' }}>Available</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Payment Status</label>
                    <select name="payment_status" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                        <option value="Unpaid" {{ old('payment_status', $booking->payment_status) == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="Paid" {{ old('payment_status', $booking->payment_status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Refunded" {{ old('payment_status', $booking->payment_status) == 'Refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5">
                Update Reservation
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scheduleSelect = document.getElementById('schedule_id');
        const capacityHelp = document.getElementById('capacity-help');
        const fareDisplay = document.getElementById('fare-display');

        function updateDetails() {
            const selectedOption = scheduleSelect.options[scheduleSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const capacity = selectedOption.getAttribute('data-capacity');
                const fare = parseFloat(selectedOption.getAttribute('data-fare')).toFixed(2);
                capacityHelp.textContent = `Max capacity for this bus: ${capacity} seats`;
                fareDisplay.textContent = `LKR ${fare}`;
            } else {
                capacityHelp.textContent = '';
                fareDisplay.textContent = 'LKR --';
            }
        }

        scheduleSelect.addEventListener('change', updateDetails);
        updateDetails(); // Initial call
    });
</script>
@endsection
