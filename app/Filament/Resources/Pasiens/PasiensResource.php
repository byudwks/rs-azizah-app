<?php

namespace App\Filament\Resources\Pasiens;

use App\Filament\Resources\Pasiens\Pages\ManagePasiens;
use App\Models\Pasiens;
use BackedEnum;
use Carbon\Carbon;
use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\Width;

class PasiensResource extends Resource
{
    protected static ?string $model = Pasiens::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Pasien';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                        TextInput::make('name')
                             ->label('Nama')
                             ->required()
                             ->columnSpanFull(),
                        TextInput::make('no_ktp')
                             ->label('NIK')
                             ->required()
                             ->minLength(16)
                             ->maxLength(16) 
                             ->unique(ignorable: fn ($record) => $record)
                             ->columnSpanFull(),
                        DatePicker::make('tanggal_lahir')
                             ->Seconds(false)
                             ->required()
                             ->reactive()
                             ->afterStateUpdated(fn (callable $set, $state, $record)
                                =>$set('age', Carbon::parse($state)->age))
                             ->label('Tanggal Lahir')
                             ->displayFormat('d/m/Y')
                             ->columnSpanFull(),
                        TextInput::make('age')
                             ->label('Umur')
                             ->suffix('Tahun')
                             ->readOnly()
                             ->numeric()
                             ->columnSpanFull(),
                        Textarea::make('address')
                             ->label('Alamat')
                             ->required()
                             ->columnSpanFull(),
                        TextInput::make('phone_number')
                             ->label('Nomor Hp')
                             ->required()
                             ->minLength(12)
                             ->maxLength(12) 
                             ->unique(ignorable: fn ($record) => $record)
                             ->columnSpanFull(),
                        Textarea::make('keluhan')
                             ->label('Keluhan')
                             ->required()
                             ->columnSpanFull(),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn () => Pasiens::query())
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('Pasiens')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pasien')
                    ->searchable(),
                TextColumn::make('no_ktp')
                    ->label('NIK')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('Nomor Hp')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('age')
                    ->label('Umur'),
                TextColumn::make('keluhan')
                    ->label('Keluhan')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('created_at')
                    ->dateTime('d-m-Y')
                    ->label('Dibuat')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePasiens::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'no_ktp', 'phone_number',];
    }
}
