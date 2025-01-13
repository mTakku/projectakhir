<?php

namespace App\Filament\Resources\HasilPemeriksaanResource\Pages;

use App\Filament\Resources\HasilPemeriksaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHasilPemeriksaans extends ListRecords
{
    protected static string $resource = HasilPemeriksaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
