@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900">Bus Management</h1>
        <p class="text-slate-500">Monitor and manage all fleet vehicles in one place.</p>
    </div>
    <a href="{{ route('buses.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-md transition-all flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add New Bus
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
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Capacity</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Type</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($buses as $bus)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center font-bold">
                            {{ substr($bus->bus_number, 0, 2) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">{{ $bus->bus_number }}</div>
                            <div class="text-sm text-slate-500">{{ $bus->model ?? 'N/A' }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-center font-medium text-slate-700">
                    {{ $bus->capacity }} <span class="text-xs text-slate-400">Seats</span>
                </td>
                <td class="px-6 py-4 text-center">
                    @php 
                        $badgeClass = $bus->type == 'AC' ? 'bg-blue-100 text-blue-700' : ($bus->type == 'Luxury' ? 'bg-purple-100 text-purple-700' : 'bg-amber-100 text-amber-700');
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                        {{ $bus->type }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bus->status ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $bus->status ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                        {{ $bus->status ? 'Active' : 'Maintenance' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('buses.edit', $bus->id) }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <form action="{{ route('buses.destroy', $bus->id) }}" method="POST" onsubmit="return confirm('Delete this bus?');">
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
                <td colspan="5" class="px-6 py-12 text-center text-slate-400">No buses found. Add your first vehicle!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
