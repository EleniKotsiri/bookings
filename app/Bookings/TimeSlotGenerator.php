<?php

namespace App\Bookings;

use App\Models\Schedule;
use App\Models\Service;
use Carbon\CarbonInterval;
use App\Bookings\Filter;

class TimeSlotGenerator
{
    public const INCREMENT = 15;

    public $schedule;
    public $service;

    protected $interval;

    public function __construct(Schedule $schedule, Service $service)
    {
        $this->schedule = $schedule;
        $this->service = $service;

        $this->interval = CarbonInterval::minutes(self::INCREMENT)
            ->toPeriod(
                $schedule->date->setTimeFrom($schedule->start_time),
                $schedule->date->setTimeFrom(
                    // subtract the duration of the service from end_time (can't book 2hr service, 1hr before schedule ends)
                    $schedule->end_time->subMinutes($service->duration)
                )
            );
    }

    // apply filters
    public function applyFilters(array $filters)
    {
        foreach($filters as $filter) {

            if(!$filter instanceof Filter) {
                continue;
            }
            // apply the filter to current timeSlotGenerator and apply current interval too
            $filter->apply($this, $this->interval);
        }

        return $this;
    }

    public function get()
    {
        return $this->interval;
    }
}
