@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('buses.index') }}" class="inline-flex items-center text-slate-500 hover:text-slate-800 mb-6 transition-colors gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to list
    </a>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Update Bus Details</h2>

        <form action="{{ route('buses.update', $bus->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Bus Registration Number</label>
                <input type="text" name="bus_number" value="{{ $bus->bus_number }}" required 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Manufacturer / Model</label>
                <input type="text" name="model" value="{{ $bus->model }}" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Passenger Capacity</label>
                    <input type="number" name="capacity" value="{{ $bus->capacity }}" required 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Bus Type</label>
                    <select name="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none appearance-none">
                        <option value="Non-AC" {{ $bus->type == 'Non-AC' ? 'selected' : '' }}>Standard Non-AC</option>
                        <option value="AC" {{ $bus->type == 'AC' ? 'selected' : '' }}>Air Conditioned</option>
                        <option value="Luxury" {{ $bus->type == 'Luxury' ? 'selected' : '' }}>Luxury Class</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none appearance-none">
                    <option value="1" {{ $bus->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$bus->status ? 'selected' : '' }}>In Maintenance</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5">
                Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
