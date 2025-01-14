<?php

namespace App\Filament\Resources\TransaksiResource\RelationManagers;

use App\Models\Obat;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DettransaksisRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $title = 'Detail Transaksi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('obat_id')->label('Nama Obat')->required()
                ->options(
                    Obat::where('stok', '>', 0) // Tampilkan hanya obat dengan stok > 0
                        ->pluck('nama_obat', 'id')
                )
                ->reactive() 
                ->afterStateUpdated(function ($state, callable $set) {
                    $harga = Obat::find($state)?->harga; 
                    $set('harga_satuan', $harga); 
                }),

                TextInput::make('harga_satuan')
                ->label('Harga Satuan')
                ->readOnly() // Tidak dapat diedit
                ->numeric(),


                TextInput::make('jumlah')->label('Jumlah Obat')
                ->reactive() 
                ->numeric()
                ->required()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $hargaSatuan = $get('harga_satuan');
                    $set('total', $hargaSatuan * $state); 
                }),
                TextInput::make('total')->label('Total')->readOnly()->nullable()->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('obat.nama_obat')
                ->label('Nama Obat')
                ->sortable()
                ->searchable(),
                TextColumn::make('harga_satuan')
                ->label('Harga per')
                ->sortable()
                ->searchable(),
                TextColumn::make('jumlah')->label('Jumlah Obat'),
                TextColumn::make('total')->label('Total Harga'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

     public function getCreateModalHeading(): string
    {
        return 'Buat Detail Transaksi'; 
    }
}
