<div class="max-w-sm p-5 m-6 mx-auto bg-gray-200 rounded-lg">
    <div class="text-gray-700 font-bold mb-2">
        {{ $appointment->client_name }} thanks for booking.
    </div>

    <div class="border-t border-b border-gray-300 py-2">
        <div class="font-semibold">
            {{ $appointment->service->name }} ({{ $appointment->service->duration }} minutes ) with {{ $appointment->employee->name }}
        </div>

        <div class="text-gray-700">
            {{ $appointment->date->format('D jS M Y') }} at {{ $appointment->start_time->format('g:i A')}}
        </div>
    </div>
</div>
