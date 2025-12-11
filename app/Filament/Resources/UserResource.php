<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $label = 'Jogadores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_id')
                    ->label('ID da Conta')
                    ->disabled(),
                Forms\Components\TextInput::make('userid')
                    ->label('Login')
                    ->required()
                    ->unique(User::class, 'userid', ignorable: fn ($record) => $record ? $record : null),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required(),
                Forms\Components\DatePicker::make('birthdate')
                    ->label('Data de Nascimento')
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                Forms\Components\Toggle::make('has_partner')
                    ->label('Parceiro')
                    ->onColor('success')
                    ->offColor('danger'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('account_id')->label('ID da Conta')->searchable()->sortable(),
                TextColumn::make('userid')->label('Login')->searchable()->sortable(),
                TextColumn::make('group_id')->label('Level da Conta')->searchable()->sortable(),
                TextColumn::make('email')->label('E-mail')->searchable()->sortable(),
                TextColumn::make('has_partner')
                    ->label('Parceiro')
                    ->formatStateUsing(fn ($state) => $state ? 'Parceiro' : 'Não é parceiro')
                    ->sortable(),
                TextColumn::make('lastlogin')
                    ->label('Último Acesso')
                    ->since()
                    ->sortable()
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
            ])
            ->defaultSort('account_id', 'desc');
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
            'index' => Pages\ListUsers::route('/'),
//            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
