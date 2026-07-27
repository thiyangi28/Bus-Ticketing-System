@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900">Schedule Management</h1>
        <p class="text-slate-500">Plan and manage departure times, fares, and bus assignments.</p>
    </div>
    <a href="{{ route('schedules.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-md transition-all flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Create New Schedule
    </a>
</div>

@if(session('success'))
    <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm">
        <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-100">
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Bus Info</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Route Path</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Departure</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Arrival</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Fare</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($schedules as $schedule)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center font-bold">
                            🚌
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">{{ $schedule->bus->bus_number }}</div>
                            <div class="text-xs text-slate-500">{{ $schedule->bus->type }} ({{ $schedule->bus->capacity }} seats)</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div>
                        <div class="font-bold text-slate-900">Route #{{ $schedule->route->route_number }}</div>
                        <div class="text-sm text-slate-600 flex items-center gap-1">
                            <span>{{ $schedule->route->start_point }}</span>
                            <span class="text-slate-400">➔</span>
                            <span>{{ $schedule->route->end_point }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-center font-medium text-slate-700">
                    {{ \Carbon\Carbon::parse($schedule->departure_time)->format('M d, Y') }}
                    <div class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}</div>
                </td>
                <td class="px-6 py-4 text-center text-slate-500">
                    {{ \Carbon\Carbon::parse($schedule->arrival_time)->format('M d, Y') }}
                    <div class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($schedule->arrival_time)->format('h:i A') }}</div>
                </td>
                <td class="px-6 py-4 text-center font-bold text-indigo-600">
                    LKR {{ number_format($schedule->fare, 2) }}
                </td>
                <td class="px-6 py-4 text-center">
                    @php
                        $badgeClass = $schedule->status == 'Scheduled' ? 'bg-indigo-100 text-indigo-700' : ($schedule->status == 'Cancelled' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700');
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                        {{ $schedule->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Delete this schedule?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-slate-400 hover:text-rose-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-slate-400">No schedules found. Create your first schedule!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
