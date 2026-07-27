<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusTicketing - Premium Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="antialiased text-slate-800">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-indigo-900 text-white px-8 py-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center gap-2">
            <span class="text-2xl font-bold tracking-tight">🚌 BusTicketing</span>
        </div>
        <div class="flex gap-6 font-medium">
            <a href="{{ route('buses.index') }}" class="{{ request()->routeIs('buses.*') ? 'text-indigo-200 font-bold border-b-2 border-indigo-200 pb-1' : 'hover:text-indigo-200 transition-colors' }}">Buses</a>
            <a href="{{ route('routes.index') }}" class="{{ request()->routeIs('routes.*') ? 'text-indigo-200 font-bold border-b-2 border-indigo-200 pb-1' : 'hover:text-indigo-200 transition-colors' }}">Routes</a>
            <a href="{{ route('schedules.index') }}" class="{{ request()->routeIs('schedules.*') ? 'text-indigo-200 font-bold border-b-2 border-indigo-200 pb-1' : 'hover:text-indigo-200 transition-colors' }}">Schedules</a>
            <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'text-indigo-200 font-bold border-b-2 border-indigo-200 pb-1' : 'hover:text-indigo-200 transition-colors' }}">Bookings</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </div>
</body>
</html>
