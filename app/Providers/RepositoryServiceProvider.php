<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EmployeeRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\LeaveRequestRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EmployeeRepository::class, function ($app) {
            return new EmployeeRepository();
        });

        $this->app->singleton(AttendanceRepository::class, function ($app) {
            return new AttendanceRepository();
        });

        $this->app->singleton(LeaveRequestRepository::class, function ($app) {
            return new LeaveRequestRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
