<?php

namespace BinaryCastle\Boilerplate\View\Components;

use BinaryCastle\Boilerplate\Services\Installer\Navigator;
use Illuminate\Contracts\View\View;

class InstallerNavigationButtons extends \Illuminate\View\Component
{

    /**
     * @inheritDoc
     */
    public function render(): View
    {
        $next = Navigator::next();
        $previous = Navigator::previous();
        $can_skip = Navigator::canSkipCurrent();
        $finish_url = config('boilerplate.installation_finish_url');
        return view('boilerplate::installer.components.installer-navigation-buttons',
            compact('next', 'previous', 'can_skip', 'finish_url'));
    }
}
