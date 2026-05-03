<?php

namespace App\Filament\Resources\FlipCardResource\Pages;

use App\Filament\Resources\FlipCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlipCards extends ListRecords
{
    protected static string $resource = FlipCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
