<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ObatResource\Pages;
use App\Filament\Resources\ObatResource\RelationManagers;
use App\Models\Obat;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ObatResource extends Resource
{
    protected static ?string $model = Obat::class;

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_obat')->label('Nama Obat')->required(),
                TextInput::make('jenis_obat')->label('Jenis Obat')->required(),
                DatePicker::make('tanggal_kd')->label('Kadaluarsa')->required(),
                TextInput::make('stok')->label('Stock')->required(),
                TextInput::make('harga')->label('Harga')->required(),
                TextInput::make('tipe_obat')->label('Tipe Obat')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_obat')->label('Nama Obat'),
                TextColumn::make('jenis_obat')->label('Jenis Obat'),
                TextColumn::make('tanggal_kd')->label('Kadaluarsa'),
                TextColumn::make('stok')->label('Stock'),
                TextColumn::make('harga')->label('Harga'),
                TextColumn::make('tipe_obat')->label('Tipe Obat'),
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
            'index' => Pages\ListObats::route('/'),
            'create' => Pages\CreateObat::route('/create'),
            'edit' => Pages\EditObat::route('/{record}/edit'),
        ];
    }
}
