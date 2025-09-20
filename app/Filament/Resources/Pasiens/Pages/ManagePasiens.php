<?php

namespace App\Filament\Resources\Pasiens\Pages;

use App\Filament\Resources\Pasiens\PasiensResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;


class ManagePasiens extends ManageRecords
{
    protected static string $resource = PasiensResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
