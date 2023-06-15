<?php

namespace App\Bookings\Filters;

use App\Bookings\Filter;
use App\Bookings\TimeSlotGenerator;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;

class UnavailabilityFilter implements Filter
{
    // protected $unavailabilities;
    public $unavailabilities;

    public function __construct(Collection $unavailabilities)
    {
        $this->unavailabilities = $unavailabilities;
        // dd($this->unavailabilities);

    }

    public function apply(TimeSlotGenerator $generator, CarbonPeriod $interval)
    {
        $interval->addFilter(function ($slot) use ($generator) {
            foreach ($this->unavailabilities as $unavailability) {
                if (
                    $slot->between(
                        $unavailability->schedule->date->setTimeFrom(
                            $unavailability->start_time->subMinutes(
                                $generator->service->duration - $generator::INCREMENT
                            )
                        ),
                        $unavailability->schedule->date->setTimeFrom(
                            $unavailability->end_time->subMinutes(
                                $generator::INCREMENT
                            )
                        )
                    )
                ) {
                    // dd($slot);
                    return false;
                }
            }

            return true;
        });
    }
}
