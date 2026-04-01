<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestContacts extends BaseWidget
{
    protected static ?int $sort = 2; // Tampil di urutan kedua (bawah stats)

    // Agar tabel memenuhi lebar layar dashboard
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Ambil 5 pesan terbaru
                Contact::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->weight('bold')
                    ->label('Sender Name'),
                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(fn ($state) => $state),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Received')
                    ->sortable(),
            ])
            ->actions([
                // Anda bisa menambahkan aksi view/delete di sini jika mau
                // Tables\Actions\ViewAction::make(),
            ]);
    }
}
