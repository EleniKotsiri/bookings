<?php

namespace App\Http\Controllers;

use App\Bookings\Filters\AppointmentFilter;
use App\Bookings\Filters\SlotsPassedTodayFilter;
use App\Bookings\Filters\UnavailabilityFilter;
use App\Bookings\TimeSlotGenerator;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Service;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __invoke()
    {
        $schedule = Schedule::find(2);
        $service = Service::find(1);

        $employee = Employee::find(1);

        $slots = $employee->availableTimeSlots($schedule, $service);
        

        return view('bookings.create', [
            'slots' => $slots
        ]);
    }
}
