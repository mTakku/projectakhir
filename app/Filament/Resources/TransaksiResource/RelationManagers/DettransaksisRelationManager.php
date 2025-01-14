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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('obat_id')->label('Nama Obat')->required()->options(
                    Obat::pluck('nama_obat','id')
                ),
                TextInput::make('jumlah')->label('Jumlah Obat'),
                TextInput::make('total')->label('Total')->readOnly()->nullable(),

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
}
