<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Filament\Resources\ExperienceResource\RelationManagers;
use App\Models\Experience;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'lucide-user-star';

    protected static ?string $navigationGroup = 'Resume';

    protected static ?string $navigationLabel = 'Pengalaman';


    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make()
                ->schema([
                    
                    Forms\Components\TextInput::make('company_name')
                        ->required(),
                    Forms\Components\TextInput::make('role')
                        ->label('Posisi / Jabatan')
                        ->required(),
                    Forms\Components\Select::make('type')
                        ->options([
                            'work' => 'Pekerjaan',
                            'education' => 'Pendidikan',
                        ])
                        ->required(),
                    
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\DatePicker::make('start_date')->required(),
                            Forms\Components\DatePicker::make('end_date')
                                ->label('Sampai Tanggal')
                                ->hidden(fn (Forms\Get $get) => $get('is_current')), // Sembunyikan jika "Masih Bekerja"
                        ]),
                    
                    Forms\Components\Toggle::make('is_current')
                        ->label('Masih bekerja/sekolah disini?')
                        ->live(), // Agar field end_date bisa bereaksi real-time
        
                    Forms\Components\Textarea::make('description')
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                ->label('Institusi / Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')

                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Sampai')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_current')
                    ->label('Sampai Saat Ini?')
                    ->boolean(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}
