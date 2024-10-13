<?php

namespace App\Providers;

use App\View\Components\ProfessorLayout;
use App\View\Components\ProgramHeadLayout;
use App\View\Components\RegistrarLayout;
use App\View\Components\StudentLayout;
use App\View\Components\TreasuryLayout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('registrar-layout', RegistrarLayout::class);
        Blade::component('professor-layout', ProfessorLayout::class);
        Blade::component('student-layout', StudentLayout::class);
        Blade::component('profHead-layout', ProgramHeadLayout::class);
        Blade::component('treasury-layout', TreasuryLayout::class);
    }
}
