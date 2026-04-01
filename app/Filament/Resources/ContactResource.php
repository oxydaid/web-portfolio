<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Kontak';

    protected static ?string $label = 'Kontak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->readonly(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->readonly(),
                Forms\Components\Textarea::make('message')
                    ->columnSpanFull()
                    ->readonly(),
                Forms\Components\DateTimePicker::make('created_at')
                    ->label('Sent At')
                    ->readonly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->copyable() // Bisa klik copy email
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Date'),
            ])
            ->defaultSort('created_at', 'desc') // Pesan terbaru di atas
            ->actions([
                Tables\Actions\ViewAction::make(), // Hanya View
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        // jika tidak ada pesan tidak menampilkan badge / null
        if (static::getModel()::query()->count() > 0) {
            return static::getModel()::query()->count();
        }
        return null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContacts::route('/'),
        ];
    }
}
