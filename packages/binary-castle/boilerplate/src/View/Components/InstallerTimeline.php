<?php

namespace BinaryCastle\Boilerplate\View\Components;

use BinaryCastle\Boilerplate\Services\Installer\Navigator;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class InstallerTimeline extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        $availableSteps = Navigator::activeSteps();
        $active = $this->getActiveStep($availableSteps->values());
        return view('boilerplate::installer.components.installer-timeline', [
            'steps' => $availableSteps->values(),
            'active' => $active
        ]);
    }

    private function getActiveStep($steps): int
    {
        $currentRoute = str_replace("installer/", "", Route::current()->uri());
        $stripUrls = collect($steps)->map(fn($item) => $item['url'])->toArray();
        return array_search($currentRoute, $stripUrls);
    }
}
