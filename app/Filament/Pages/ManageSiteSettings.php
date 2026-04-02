<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;

class ManageSiteSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'App Settings';

    protected static ?string $title = 'Pengaturan Situs & Profil';

    protected static string $view = 'filament.pages.manage-site-settings';

    // Property untuk menampung data form
    public ?array $data = [];

    // Mount data dari Settings Class ke Form
    public function mount(GeneralSettings $settings): void
    {
        $this->form->fill([
            'site_name' => $settings->site_name,
            'site_description' => $settings->site_description,
            'site_logo' => $settings->site_logo,
            'site_favicon' => $settings->site_favicon,
            'primary_color' => $settings->primary_color,
            'secondary_color' => $settings->secondary_color,
            'dev_name' => $settings->dev_name,
            'dev_title' => $settings->dev_title,
            'dev_bio' => $settings->dev_bio,
            'dev_avatar' => $settings->dev_avatar,
            'email' => $settings->email,
            'phone' => $settings->phone,
            'social_links' => $settings->social_links,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->schema([
                        // TAB 1: GENERAL & SEO
                        Forms\Components\Tabs\Tab::make('General & SEO')
                            ->icon('heroicon-m-globe-alt')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('site_description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('site_logo')
                                    ->preserveFilenames()
                                    ->image()
                                    ->directory('settings'),
                                Forms\Components\FileUpload::make('site_favicon')
                                    ->preserveFilenames()
                                    ->image()
                                    ->directory('settings'),
                            ])->columns(2),

                        // TAB 2: PERSONAL INFO
                        Forms\Components\Tabs\Tab::make('Personal Info')
                            ->icon('heroicon-m-user')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('dev_name')->required(),
                                        Forms\Components\TextInput::make('dev_title'),
                                    ]),
                                Forms\Components\FileUpload::make('dev_avatar')
                                    ->preserveFilenames()
                                    ->avatar()
                                    ->imageEditor()
                                    ->directory('settings'),
                                Forms\Components\RichEditor::make('dev_bio'),

                                Forms\Components\Section::make('Kontak & Sosmed')
                                    ->schema([
                                        Forms\Components\TextInput::make('email')->email(),
                                        Forms\Components\TextInput::make('phone'),

                                        // Repeater untuk Sosmed (Bisa tambah banyak)
                                        Forms\Components\Repeater::make('social_links')
                                            ->schema([
                                                Forms\Components\Select::make('platform')
                                                    ->options([
                                                        'github' => 'GitHub',
                                                        'linkedin' => 'LinkedIn',
                                                        'instagram' => 'Instagram',
                                                        'facebook' => 'Facebook',
                                                        'tiktok' => 'TikTok',
                                                        'twitter' => 'Twitter/X',
                                                        'youtube' => 'YouTube',
                                                        'website' => 'Website',
                                                        'telegram' => 'Telegram',
                                                        'discord' => 'Discord',
                                                        'whatsapp' => 'WhatsApp',
                                                        'others' => 'Lainnya',
                                                    ])->required(),
                                                Forms\Components\TextInput::make('url')
                                                    ->url()
                                                    ->required(),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),

                        // TAB 3: APPEARANCE
                        Forms\Components\Tabs\Tab::make('Tampilan')
                            ->icon('heroicon-m-paint-brush')
                            ->schema([
                                Forms\Components\Grid::make(2) // Bagi 2 kolom
                                    ->schema([
                                        Forms\Components\ColorPicker::make('primary_color')
                                            ->required()
                                            ->label('Primary Color (Gradient Start)')
                                            ->live(),

                                        Forms\Components\ColorPicker::make('secondary_color')
                                            ->required()
                                            ->label('Secondary Color (Gradient End)')
                                            ->live(),
                                    ]),

                                // Optional: Preview visual sederhana agar admin tau ini gradient
                                Forms\Components\Placeholder::make('preview')
                                    ->label('Preview Gradient')
                                    ->content(fn (Forms\Get $get) => new HtmlString('
                                    <div style="
                                        width: 100%; 
                                        height: 40px; 
                                        border-radius: 8px; 
                                        background: linear-gradient(to right, '.($get('primary_color') ?? '#ccc').', '.($get('secondary_color') ?? '#ccc').');
                                "></div>
                                ')),
                            ]),
                    ])->columnSpanFull(),
            ])
            ->statePath('data');
    }

    // Fungsi Save
    public function save(GeneralSettings $settings): void
    {
        $state = $this->form->getState();

        // Simpan ke class Settings
        $settings->site_name = $state['site_name'];
        $settings->site_description = $state['site_description'];
        $settings->site_logo = $state['site_logo'];
        $settings->site_favicon = $state['site_favicon'];
        $settings->primary_color = $state['primary_color'];
        $settings->secondary_color = $state['secondary_color'];
        $settings->dev_name = $state['dev_name'];
        $settings->dev_title = $state['dev_title'];
        $settings->dev_bio = $state['dev_bio'];
        $settings->dev_avatar = $state['dev_avatar'];
        $settings->email = $state['email'];
        $settings->phone = $state['phone'];
        $settings->social_links = $state['social_links'];

        $settings->save();

        Notification::make()
            ->title('Settings updated successfully.')
            ->success()
            ->send();
    }

    // Tombol Save di pojok kanan atas form
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
        ];
    }
}
