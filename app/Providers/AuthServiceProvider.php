<?php

namespace App\Providers;


// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        'App\Filament\Pages\Images' => ImageViewerPolicy::class,
    ];

    
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
