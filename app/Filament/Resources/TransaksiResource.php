<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Filament\Resources\TransaksiResource\RelationManagers\DettransaksisRelationManager;
use App\Models\Hasilpemeriksaan;
use App\Models\Pasien;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?int $navigationSort = 5;




    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pasien_id')
                ->label('Nama Pasien')
                ->options(Pasien::pluck('nama_pasien', 'id')->toArray())
                ->afterStateUpdated(function ($state, callable $set) {
                    $hasilPemeriksaan = Hasilpemeriksaan::find($state);
            
                    // Mengatur nilai diagnostik
                    $set('t_diagnosa', $hasilPemeriksaan?->diagnosa);
            
                    // Mengatur harga total
                    $set('harga_total', $hasilPemeriksaan?->harga_pemeriksaan);
                })
                ->reactive() 
                ->required(),

                TextInput::make('t_diagnosa')
                ->label('Diagnosa')
                ->readOnly()
                ->required(),

                DatePicker::make('tanggal_transaksi')
                ->label('Tanggal')
                ->required(),

                TextInput::make('harga_total')
                ->label('Harga Total')
                ->readOnly()
                ,
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
            TextColumn::make('t_diagnosa')
                ->label('Diagnosa'),
            TextColumn::make('tanggal_transaksi')
                ->label('Tanggal'),
            TextColumn::make('harga_total')
                ->label('Harga Total'),
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
            DettransaksisRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }

    public function getCreateModalHeading(): string
    {
        return 'Buat Detail Transaksi'; 
    }
}
