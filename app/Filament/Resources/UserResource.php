<?php
namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use App\Models\User;
use Filament\Tables;
use App\Models\State;
use App\Models\Country;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel ="Employees";
    protected static ?string $navigationGroup = 'Employees Manangment';
    protected static ?int $navigationSort =1;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal info')
            ->description('Please fill in the following details to create your account. Ensure that all information is accurate and up-to-date.')
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('password')
                ->hiddenOn('edit')
                ->password()
                ->required()
                ->maxLength(255),
            ]),

            Section::make('Adress info')
            ->columns(3)
            ->schema([
                Forms\Components\Select::make('country_id')
                ->relationship(name:'country',titleAttribute:'name')
                ->searchable()
                ->preload()
                ->afterStateUpdated(function(Set $set){
                    $set('state_id',null);
                    $set('city_id',null);
                })
                ->live()
                ->required(),
                Forms\Components\Select::make('state_id')
                ->options(fn (Get $get): Collection => State::query()
                        ->where('country_id', $get('country_id'))
                        ->pluck('name','id'))
                ->afterStateUpdated(function(Set $set){
                    $set('city_id',null);
                })
                ->searchable()
                ->preload()
                ->live()
                ->required(),
                Forms\Components\Select::make('city_id')
                    ->options(fn (Get $get): Collection => City::query()
                        ->where('state_id', $get('state_id'))
                        ->pluck('name','id'))
                ->searchable()
                ->preload()
                ->live()
                ->required(),
                Forms\Components\TextInput::make('address')
                ->required(),
                Forms\Components\TextInput::make('postal_code')
                ->required(),
            ])
         ]);
               
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('address')
                    ->toggleable(isToggledHiddenByDefault:false)
                    ->searchable()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('postal_code')
                    ->toggleable(isToggledHiddenByDefault:false)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
