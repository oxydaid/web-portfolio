<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillResource\Pages;
use App\Filament\Resources\SkillResource\RelationManagers;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'lucide-lightbulb';
    protected static ?string $navigationGroup = 'Resume';
    protected static ?string $navigationLabel = 'Keampuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // Pilih Kategori
                Forms\Components\Select::make('category')
                    ->options([
                        'backend' => 'Backend',
                        'frontend' => 'Frontend',
                        'tools' => 'Tools & DevOps',
                        'mobile' => 'Mobile App',
                        'design' => 'Design',
                        'other' => 'Lainnya',
                    ])
                    ->required(),

                // Upload Icon (SVG/PNG)
                Forms\Components\FileUpload::make('icon')
                    ->image()
                    ->disk('public')
                    ->directory('skills') // folder di storage/app/public/skills
                    ->preserveFilenames(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge() // Tampilan badge warna-warni otomatis
                    ->sortable(),
            ])
            ->filters([
                // Tambahkan filter jika mau
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }
}
