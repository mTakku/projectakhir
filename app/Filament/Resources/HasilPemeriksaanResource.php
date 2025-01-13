<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HasilPemeriksaanResource\Pages;
use App\Filament\Resources\HasilPemeriksaanResource\RelationManagers;
use App\Models\Dokter;
use App\Models\HasilPemeriksaan;
use App\Models\Pasien;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HasilPemeriksaanResource extends Resource
{
    protected static ?string $model = HasilPemeriksaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pasien_id')
                ->label('Nama Pasien')
                ->options(Pasien::pluck('nama_pasien', 'id')->toArray())
                ->required(),



                TextInput::make('diagnosa')->label('Diagnosa'),
                TextInput::make('harga_pemeriksaan')->label('Harga Pemeriksaan'),
                Select::make('dokter_id')
                ->label('Nama Dokter')
                ->options(function () {
                    // Menampilkan dokter yang tersedia di jadwal_dokters (available = true)
                    return Dokter::whereHas('jadwaldokter', function ($query) {
                        $query->where('available', true); // Pastikan dokter memiliki jadwal yang tersedia
                    })
                    ->whereNotIn('id', HasilPemeriksaan::pluck('dokter_id')) // Pastikan dokter belum dipilih di pemeriksaan lain
                    ->pluck('nama_dokter', 'id') // Ambil nama dan ID dokter
                    ->toArray();
                })
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pasien.nama_pasien')
                ->label('Nama Pasien')
                ->sortable()
                ->searchable(),
            TextColumn::make('diagnosa')
                ->label('Diagnosa'),
            TextColumn::make('harga_pemeriksaan')
                ->label('Harga Pemeriksaan'),
            TextColumn::make('dokter.nama_dokter')
                ->label('Nama Dokter')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHasilPemeriksaans::route('/'),
            'create' => Pages\CreateHasilPemeriksaan::route('/create'),
            'edit' => Pages\EditHasilPemeriksaan::route('/{record}/edit'),
        ];
    }

    
}
