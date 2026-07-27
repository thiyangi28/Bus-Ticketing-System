<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Passengers/Users
        User::factory()->create([
            'name' => 'Thiyangi Intern',
            'email' => 'thiyangi@example.com',
        ]);

        $sinhalaNames = [
            ['name' => 'Nimal Silva', 'email' => 'nimal@example.com'],
            ['name' => 'Sunil Perera', 'email' => 'sunil@example.com'],
            ['name' => 'Kamal Fernando', 'email' => 'kamal@example.com'],
            ['name' => 'Thilini Jayawardena', 'email' => 'thilini@example.com'],
            ['name' => 'Priyanka Kahawita', 'email' => 'priyanka@example.com'],
            ['name' => 'Ruwan Kumara', 'email' => 'ruwan@example.com'],
            ['name' => 'Dilhani Wijesinghe', 'email' => 'dilhani@example.com'],
            ['name' => 'Saman Kumara', 'email' => 'saman@example.com'],
            ['name' => 'Chathura Senanayake', 'email' => 'chathura@example.com'],
            ['name' => 'Anura Bandara', 'email' => 'anura@example.com'],
        ];

        $users = collect();
        foreach ($sinhalaNames as $passenger) {
            $users->push(User::factory()->create($passenger));
        }

        // 2. Seed Buses
        $bus1 = Bus::create([
            'bus_number' => 'WP-ND 4521',
            'model' => 'Ashok Leyland Viking',
            'capacity' => 49,
            'type' => 'Non-AC',
            'status' => true,
        ]);

        $bus2 = Bus::create([
            'bus_number' => 'WP-ND 8872',
            'model' => 'Yutong ZK6122H',
            'capacity' => 45,
            'type' => 'AC',
            'status' => true,
        ]);

        $bus3 = Bus::create([
            'bus_number' => 'WP-NE 0122',
            'model' => 'Volvo B11R Luxury',
            'capacity' => 40,
            'type' => 'Luxury',
            'status' => true,
        ]);

        $bus4 = Bus::create([
            'bus_number' => 'WP-NC 5566',
            'model' => 'Mitsubishi Rosa',
            'capacity' => 26,
            'type' => 'AC',
            'status' => false, // Under Maintenance
        ]);

        // 3. Seed Routes
        $route1 = Route::create([
            'route_number' => 'EX 1-1',
            'start_point' => 'Colombo',
            'end_point' => 'Galle',
            'distance' => 125,
            'duration' => '1 hour 45 mins',
        ]);

        $route2 = Route::create([
            'route_number' => '01',
            'start_point' => 'Colombo',
            'end_point' => 'Kandy',
            'distance' => 115,
            'duration' => '3 hours 15 mins',
        ]);

        $route3 = Route::create([
            'route_number' => 'EX 2-1',
            'start_point' => 'Colombo',
            'end_point' => 'Matara',
            'distance' => 160,
            'duration' => '2 hours 15 mins',
        ]);

        // 4. Seed Schedules
        $schedule1 = Schedule::create([
            'bus_id' => $bus2->id,
            'route_id' => $route1->id,
            'departure_time' => now()->addDays(1)->setTime(8, 0, 0),
            'arrival_time' => now()->addDays(1)->setTime(9, 45, 0),
            'fare' => 950.00,
            'status' => 'Scheduled',
        ]);

        $schedule2 = Schedule::create([
            'bus_id' => $bus3->id,
            'route_id' => $route2->id,
            'departure_time' => now()->addDays(1)->setTime(14, 30, 0),
            'arrival_time' => now()->addDays(1)->setTime(17, 45, 0),
            'fare' => 1800.00,
            'status' => 'Scheduled',
        ]);

        $schedule3 = Schedule::create([
            'bus_id' => $bus1->id,
            'route_id' => $route3->id,
            'departure_time' => now()->addDays(2)->setTime(6, 15, 0),
            'arrival_time' => now()->addDays(2)->setTime(8, 30, 0),
            'fare' => 750.00,
            'status' => 'Scheduled',
        ]);

        // 5. Seed a few Bookings
        Booking::create([
            'user_id' => $users->first()->id,
            'schedule_id' => $schedule1->id,
            'seat_number' => 12,
            'total_fare' => $schedule1->fare,
            'status' => 'Booked',
            'payment_status' => 'Paid',
        ]);

        Booking::create([
            'user_id' => $users->skip(1)->first()->id,
            'schedule_id' => $schedule1->id,
            'seat_number' => 15,
            'total_fare' => $schedule1->fare,
            'status' => 'Booked',
            'payment_status' => 'Unpaid',
        ]);

        Booking::create([
            'user_id' => $users->skip(2)->first()->id,
            'schedule_id' => $schedule2->id,
            'seat_number' => 5,
            'total_fare' => $schedule2->fare,
            'status' => 'Booked',
            'payment_status' => 'Paid',
        ]);
    }
}
