@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('schedules.index') }}" class="inline-flex items-center text-slate-500 hover:text-slate-800 mb-6 transition-colors gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to list
    </a>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Edit Schedule Details</h2>

        @if($errors->any())
            <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm">
                <ul class="list-disc pl-5 text-rose-700 text-sm font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Assign Bus</label>
                    <select name="bus_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                        @foreach($buses as $bus)
                            <option value="{{ $bus->id }}" {{ old('bus_id', $schedule->bus_id) == $bus->id ? 'selected' : '' }}>
                                {{ $bus->bus_number }} ({{ $bus->type }}, {{ $bus->capacity }} Seats)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Select Route</label>
                    <select name="route_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}" {{ old('route_id', $schedule->route_id) == $route->id ? 'selected' : '' }}>
                                Route {{ $route->route_number }}: {{ $route->start_point }} ➔ {{ $route->end_point }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Departure Date & Time</label>
                    <input type="datetime-local" name="departure_time" required value="{{ old('departure_time', date('Y-m-d\TH:i', strtotime($schedule->departure_time))) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Arrival Date & Time</label>
                    <input type="datetime-local" name="arrival_time" required value="{{ old('arrival_time', date('Y-m-d\TH:i', strtotime($schedule->arrival_time))) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ticket Fare (LKR)</label>
                    <input type="number" step="0.01" name="fare" required placeholder="e.g. 1250.00" value="{{ old('fare', $schedule->fare) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                        <option value="Scheduled" {{ old('status', $schedule->status) == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="Cancelled" {{ old('status', $schedule->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="Completed" {{ old('status', $schedule->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5">
                Update Schedule
            </button>
        </form>
    </div>
</div>
@endsection
