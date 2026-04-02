<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'lucide-folder';

    protected static ?string $navigationGroup = 'Resume';

    protected static ?string $navigationLabel = 'Proyek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Info Utama')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    // Auto generate slug dari title
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                Forms\Components\TextInput::make('demo_url')
                                    ->url()
                                    ->prefix('https://'),

                                Forms\Components\TextInput::make('github_url')
                                    ->url()
                                    ->prefix('https://'),
                            ])->columns(2),

                        Forms\Components\Section::make('Konten')
                            ->schema([
                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(2), // Bagian kiri (lebih lebar)

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Meta & Media')
                            ->schema([
                                Forms\Components\FileUpload::make('thumbnail')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes(['image/webp'])
                                    ->image()
                                    ->directory('projects')
                                    ->required(),

                                // Relasi Many-to-Many ke Skills
                                Forms\Components\Select::make('skills')
                                    ->relationship('skills', 'name')
                                    ->multiple() // Bisa pilih banyak
                                    ->preload()
                                    ->searchable(),

                                Forms\Components\DatePicker::make('published_at')
                                    ->default(now()),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Publish Project?')
                                    ->default(true),
                            ]),
                    ])->columnSpan(1), // Bagian kanan (sidebar)
            ])->columns(3); // Layout Grid 3 kolom
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->width(100),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // Menampilkan skill sebagai badge kecil
                Tables\Columns\TextColumn::make('skills.name')
                    ->badge()
                    ->limitList(3), // Tampilkan max 3, sisanya +1 more

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
