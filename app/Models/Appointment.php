<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'client_name',
        'client_email',
        'cancelled_at'
    ];

    protected $casts = [
        'date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    // generate uuid automatically
    // booted() is called when the model is booted (first called)
    public static function booted() {
        static::creating( function ($model) {
            $model->uuid = Str::uuid();
            $model->token = Str::random(32);
        });
    }

    // return true if the booking is cancelled
    public function isCancelled() {
        return !is_null($this->cancelled_at);
    }

    public function scopeNotCancelled(Builder $builder) {
        $builder->whereNull('cancelled_at');
    }

    // An Appointment belongs to a Service
    public function service() {
        return $this->belongsTo(Service::class);
    }

    // An Appointment belongs to an Employee
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
