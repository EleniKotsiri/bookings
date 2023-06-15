<div class="max-w-sm p-5 m-6 mx-auto bg-gray-200 rounded-lg">
    <form>
        {{ var_dump($state) }}
        <div class="mb-6">
            <label for="service" class="inline-block mb-2 font-bold text-gray-700 ">Select Service</label>
            <select name="service" id="service" class="w-full h-10 bg-white border-none rounded-lg"
                wire:model="state.service">
                <option value="">Select a Service</option>
                @foreach ($services as $service)
                <option value={{ $service->id }}>{{ $service->name }}</option>

                @endforeach
            </select>
        </div>

        <div class="mb-6 {{ !$employees->count() ? 'opacity-25' : '' }}">
            <label for="employee" class="inline-block mb-2 font-bold text-gray-700 ">Select Employee</label>
            <select name="employee" id="employee" class="w-full h-10 bg-white border-none rounded-lg"
                wire:model="state.employee" {{ !$employees->count() ? 'disabled = "disabled"' : ''}}>
                <option value="">Select an Employee</option>
                @foreach ($employees as $employee)
                <option value={{ $employee->id }}>{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6 {{ (!$this->selectedService || !$this->selectedEmployee) ? 'opacity-25' : '' }}">
            <label for="employee" class="inline-block mb-2 font-bold text-gray-700 ">Select Appointment Time</label>
        
            <livewire:booking-calendar 
                :service="$this->selectedService" 
                :employee="$this->selectedEmployee"
                :key="optional($this->selectedEmployee)->id"
            />
        </div>
    </form>
</div>