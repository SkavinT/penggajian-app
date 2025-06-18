<?php

namespace App\Providers;

use App\Models\Pegawai;
use App\Models\Gaji;
use App\Policies\PegawaiPolicy;
use App\Policies\GajiPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Pegawai::class => \App\Policies\PegawaiPolicy::class,
        Gaji::class => GajiPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
