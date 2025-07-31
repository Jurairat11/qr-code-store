<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Part;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PartResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PartResource\RelationManagers;

class PartResource extends Resource
{
    protected static ?string $model = Part::class;
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('store_id')
                ->relationship('store','store_name')
                ->label('Store')
                ->required(),

                TextInput::make('part_no')
                ->label('Part No.')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('store.store_name')
                ->label('Store'),
                TextColumn::make('part_no')
                ->label('Part No.')
            ])
            ->filters([
                SelectFilter::make('store_id')
                ->relationship('store', 'store_name')
                ->searchable()
                ->preload()
                ->indicator('Store')
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
            'index' => Pages\ListParts::route('/'),
            'create' => Pages\CreatePart::route('/create'),
            'edit' => Pages\EditPart::route('/{record}/edit'),
        ];
    }
}
