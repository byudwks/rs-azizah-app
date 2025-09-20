<?php

namespace App\Filament\Resources\Pasiens\Pages;

use App\Filament\Resources\Pasiens\PasiensResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPasiens extends ListRecords
{
    protected static string $resource = PasiensResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            
        ];
    }
}
