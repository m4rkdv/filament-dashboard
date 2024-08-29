<?php

namespace App\Filament\Personal\Pages;

use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.personal.pages.settings';

    public $count = 0;

    public function increment()
    {
        $this->count++;
    }
}
