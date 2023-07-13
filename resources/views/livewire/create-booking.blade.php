<div class="max-w-sm p-5 m-6 mx-auto bg-gray-200 rounded-lg">
    <form wire:submit.prevent="createBooking">
        {{-- {{ var_dump($state) }} --}}
        <div class="mb-6">
            <label for="service" class="inline-block mb-2 font-bold text-gray-700 ">Select Service</label>
            <select name="service" id="service" class="w-full h-10 bg-white border-none rounded-lg"
                wire:model="state.service">
                <option value="">Select a Service</option>
                @foreach ($services as $service)
                    <option value={{ $service->id }}>{{ $service->name }} ({{ $service->duration }} minutes)</option>
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

        @if ($this->hasDetailsToBook)
            <div class="mb-6">
                <div class="text-gray-700 font-bold mb-2">
                    You are ready to book
                </div>

                <div class="border-t border-b border-gray-300 py-2">
                    {{ $this->selectedService->name }} ({{ $this->selectedService->duration }} minutes) with {{ $this->selectedEmployee->name }}
                    on {{ $this->timeObject->format(' D jS M Y') }} at {{ $this->timeObject->format('g:i A') }}
                </div>
            </div>

            <div class="mb-6">
                <div class="mb-3">
                    <label for="fullname" class="inline-block mb-2 font-bold text-gray-700 ">Your fullname</label>
                    <input type="text" name="fullname" id="fullname" class="w-full h-10 bg-white border-none rounded-lg"
                    wire:model.defer="state.fullname">

                    @error('state.fullname')
                        <div class="font-semibold text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="inline-block mb-2 font-bold text-gray-700 ">Your email</label>
                    <input type="text" name="email" id="email" class="w-full h-10 bg-white border-none rounded-lg"
                    wire:model.defer="state.email">

                    @error('state.email')
                        <div class="font-semibold text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <button type="submit" class="bg-indigo-500 text-white h-11 px-4 text-center font-bold rounded-lg w-full">
                Book now
            </button>
        @endif
    </form>
</div>