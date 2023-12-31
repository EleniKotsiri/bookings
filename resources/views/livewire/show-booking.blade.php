<div class="max-w-sm p-5 m-6 mx-auto bg-gray-200 rounded-lg">
    <div class="text-gray-700 font-bold mb-2">
        {{ $appointment->client_name }} thanks for booking.
    </div>

    <div class="border-t border-b border-gray-300 py-2 mb-2">
        <div class="font-semibold">
            {{ $appointment->service->name }} ({{ $appointment->service->duration }} minutes ) with {{ $appointment->employee->name }}
        </div>

        <div class="text-gray-700">
            {{ $appointment->date->format('D jS M Y') }} at {{ $appointment->start_time->format('g:i A')}}
        </div>
    </div>

    @if(!$appointment->isCancelled())
    {{-- @this.call('cancelBooking') calls livewire functionality inside alpine.js --}}
        <button 
            type="button" 
            class="bg-pink-500 text-white h-11 px-4 text-center font-bold rounded-lg w-full"
            x-data="{
                confirmCancellation () {
                    if(window.confirm('Are you sure?')) {
                        @this.call('cancelBooking')
                    }
                }
            }"
            x-on:click="confirmCancellation"
        >
            Cancel booking
        </button>
    @endif

    @if($appointment->isCancelled())
        <p class="">Your booking has been cancelled.</p>
    @endif
</div>
