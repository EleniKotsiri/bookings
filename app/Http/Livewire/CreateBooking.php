<?php
// Parent
namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\Component;

class CreateBooking extends Component
{
    public $employees;

    // initial state (part of the form)
    public $state = [
        'service' => '',
        'employee' => '',
        'time' => '', // timestamp
        'fullname' => '',
        'email' => '' 
    ];

    // initialize employees (as empty collection)
    public function mount()
    {
        $this->employees = collect();
    }

    protected $listeners = [
        'updated-booking-time' => 'setTime'
    ];

    protected function rules()
    {
        return [
            'state.service' => "required|exists:services,id", //needs to exist in services db table
            'state.employee' => "required|exists:employees,id",
            'state.time' => "required|numeric",
            'state.fullname' => "required|string",
            'state.email' => "required|email"
        ];
    }

    public function createBooking()
    {
        $this->validate();

        $bookingFields = [
            'date' => $this->timeObject->toDateString(),
            'start_time' => $this->timeObject->toTimeString(),
            'end_time' => $this->timeObject->clone()
                ->addMinutes($this->selectedService->duration)
                ->toTimeString(),
            'client_name' => $this->state['fullname'],
            'client_email' => $this->state['email']
        ];

        // dd($bookingFields);

        $appointment = Appointment::make($bookingFields);

        $appointment->service()->associate($this->selectedService); // service_id
        $appointment->employee()->associate($this->selectedEmployee);

        $appointment->save();
    }

    public function setTime($time)
    {
        $this->state['time'] = $time;
    }

    // updated() ->state.service
    // you can choose an employee when you have selected a service first
    public function updatedStateService($serviceId)
    {
        $this->state['employee'] = '';

        if(!$serviceId) {
            $this->employees = collect();
            return;
        }

        $this->clearTime();
        // grab the employees of that selected Service
        $this->employees = $this->selectedService->employees;
    }

    public function updatedStateEmployee()
    {
        $this->clearTime();
    }

    public function clearTime()
    {
        $this->state['time'] = '';
    }

    public function getSelectedServiceProperty()
    {
        if(!$this->state['service']) {
            return null;
        }

        return Service::find($this->state['service']);
    }

    public function getSelectedEmployeeProperty()
    {
        if(!$this->state['employee']) {
            return null;
        }

        return Employee::find($this->state['employee']);
    }

    public function getHasDetailsToBookProperty()
    {
        return $this->state['service'] && $this->state['employee'] && $this->state['time'];
    }

    public function getTimeObjectProperty()
    {
        return Carbon::createFromTimestamp($this->state['time']);   
    }

    public function render()
    {
        // grab services
        $services = Service::get();

        return view('livewire.create-booking', [
            'services' => $services
        ])
            ->layout('layouts.guest');
    }
}
