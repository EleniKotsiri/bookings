<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Livewire\Component;

class BookingCalendar extends Component
{
    public $date;

    public $calendarStartDate;

    public $employee;
    public $service;

    public $time;

    public function mount()
    {
        $this->calendarStartDate = now();

        $this->setDate(now()->timestamp);
    }

    // fired when booking time is updated
    public function updatedTime($time)
    {
        $this->emitUp('updated-booking-time', $time);
    }

    public function getEmployeeScheduleProperty()
    {
        return $this->employee->schedules()
            ->whereDate('date', $this->calendarSelectedDateObject)
            ->first();
    }

    public function getAvailableTimeSlotsProperty()
    {
        if (!$this->employee || !$this->employeeSchedule) {
            return collect();
        }
        // availableTimeSlots(arg1, arg2) from Employee.php model
        // $this->employeeSchedule we get from getEmployeeScheduleProperty() just above
        return $this->employee->availableTimeSlots($this->employeeSchedule, $this->service);
    }

    public function getCalendarSelectedDateObjectProperty()
    {
        return Carbon::createFromTimestamp($this->date);
    }

    public function setDate($timestamp)
    {
        $this->date = $timestamp;

        // dd($this->availableTimeSlots);
    }

    public function getCalendarWeekIntervalProperty()
    {
        return CarbonInterval::days(1)
            ->toPeriod(
                $this->calendarStartDate,
                $this->calendarStartDate->clone()->addWeek()
            );
    }
    // next btn shows next week 
    public function incrementCalendarWeek()
    {
        $this->calendarStartDate->addWeek()->addDay();
    }
    // prev btn shows prev week 
    public function decrementCalendarWeek()
    {
        $this->calendarStartDate->subWeek()->subDay();
    }
    // don't show prev week if week > currentweek
    public function getWeekIsGreaterThanCurrentProperty()
    {
        return $this->calendarStartDate->gt(now());
    }

    public function render()
    {
        return view('livewire.booking-calendar');
    }
}
