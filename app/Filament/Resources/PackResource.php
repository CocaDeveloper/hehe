<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackResource\Pages;
use App\Filament\Resources\PackResource\RelationManagers;
use App\Models\Pack;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;

class PackResource extends Resource
{
    protected static ?string $model = Pack::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Pacotes';
    protected static ?string $pluralLabel = 'Pacotes';
    protected static ?string $modelLabel = 'Pacote';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do Pack')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('price')
                            ->label('Preço total')
                            ->numeric()
                            ->prefix('R$')
                            ->rule('nullable'),
                    ]),

                Forms\Components\Section::make('Itens do Pack')
                    ->description('Adicione os itens do pacote.')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label('Itens')
                            ->relationship('items')
                            ->defaultItems(0)
                            ->columns(3)
                            ->schema([
                                Select::make('item_id')
                                    ->label('Item')
                                    ->relationship(
                                        name: 'item',
                                        titleAttribute: 'name_english'
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->getOptionLabelFromRecordUsing(function ($record) {
                                        return "#{$record->id} - {$record->name_english}";
                                    })
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Qtd.')
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(1)
                                    ->required(),
                            ])
                            ->orderable()
                            ->collapsible()
                            ->addActionLabel('Adicionar item'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Qtd. de Itens')
                    ->counts('items'),

                Tables\Columns\TextColumn::make('items_summary')
                    ->label('Itens')
                    ->getStateUsing(function ($record) {
                        $record->loadMissing('items.item');

                        return $record->items
                            ->map(fn ($packItem) =>
                                "{$packItem->quantity}x " . optional($packItem->item)->name_english
                            )
                            ->join(', ');
                    })
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPacks::route('/'),
            'create' => Pages\CreatePack::route('/create'),
            'edit' => Pages\EditPack::route('/{record}/edit'),
            'view' => Pages\ViewPack::route('/{record}'),
        ];
    }
}
