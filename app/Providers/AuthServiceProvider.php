<?php

namespace App\Providers;

use App\Models\House;
use App\Models\Booking;
use App\Models\Schedule;
use App\Policies\HousePolicy;
use App\Policies\BookingPolicy;
use App\Policies\SchedulePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Schedule::class => SchedulePolicy::class,
        House::class => HousePolicy::class,
        Booking::class => BookingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
