<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalDokterResource\Pages;
use App\Filament\Resources\JadwalDokterResource\RelationManagers;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalDokterResource extends Resource
{
    protected static ?string $model = JadwalDokter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('dokter_id')
                ->label('Nama Dokter')
                ->options(Dokter::pluck('nama_dokter', 'id')->toArray()),

                TimePicker::make('start_time')
                ->label('Waktu Mulai')
                ->default('12:00') 
                ->required(),

            // Waktu selesai
            TimePicker::make('end_time')
                ->label('Waktu Selesai')
                ->default('15:00') 
                ->required(),

            // Status ketersediaan
            Toggle::make('available')
                ->label('Dokter Tersedia')
                ->default(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dokter.nama_dokter')
                ->label('Nama Dokter')
                ->sortable()
                ->searchable(),
            TextColumn::make('start_time')
                ->label('On Duty'),
            TextColumn::make('end_time')
                ->label('Off Duty'),
            TextColumn::make('available')
                ->label('Tersedia')
                ->getStateUsing(fn ($record) => $record->available ? 'Ada' : 'Tidak Ada')
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
            'index' => Pages\ListJadwalDokters::route('/'),
            'create' => Pages\CreateJadwalDokter::route('/create'),
            'edit' => Pages\EditJadwalDokter::route('/{record}/edit'),
        ];
    }

    public static function boot()
{
    parent::boot();

    static::saving(function ($schedule) {
        // Validasi waktu mulai dan selesai
        $startTime = Carbon::parse($schedule->start_time);
        $endTime = Carbon::parse($schedule->end_time);

        // Pastikan waktu mulai dan selesai di antara jam 12:00 dan 15:00
        if ($startTime < Carbon::parse('12:00') || $startTime > Carbon::parse('15:00')) {
            throw new \Exception('Waktu mulai hanya dapat dipilih antara jam 12 siang hingga 3 sore.');
        }

        if ($endTime < Carbon::parse('12:00') || $endTime > Carbon::parse('15:00')) {
            throw new \Exception('Waktu selesai hanya dapat dipilih antara jam 12 siang hingga 3 sore.');
        }

        // Pastikan waktu selesai tidak lebih kecil dari waktu mulai
        if ($startTime >= $endTime) {
            throw new \Exception('Waktu mulai tidak boleh lebih besar atau sama dengan waktu selesai.');
        }
    });
}
}
