<?php

namespace App\Models;

use App\Bookings\Filters\AppointmentFilter;
use App\Bookings\Filters\SlotsPassedTodayFilter;
use App\Bookings\Filters\UnavailabilityFilter;
use App\Bookings\TimeSlotGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\Schedule;

class Employee extends Model
{
    use HasFactory;

    public function availableTimeSlots(Schedule $schedule, Service $service)
    {
        return (new TimeSlotGenerator($schedule, $service))
            ->applyFilters([
                new SlotsPassedTodayFilter(),
                new UnavailabilityFilter($schedule->unavailabilities),
                new AppointmentFilter($this->appointmentsForDate($schedule->date))
            ])
            ->get();

    }

    public function appointmentsForDate(Carbon $date)
    {
        return $this->appointments()->whereDate('date', $date)->get();
    }

    /**
     * The services that belong to the Employee.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }


    /**
     * Get the schedules for the Employee.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
