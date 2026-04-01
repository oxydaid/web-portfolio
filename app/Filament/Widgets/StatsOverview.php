<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\Project;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Mengatur agar widget ini di-refresh otomatis setiap 15 detik (opsional)
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', Project::count())
                ->description('Portfolio items published')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Fake chart decor

            Stat::make('Active Services', Service::where('is_active', true)->count())
                ->description('Services currently offered')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('success'),

            Stat::make('New Messages', Contact::whereNull('read_at')->count())
                ->description('Unread messages')
                ->descriptionIcon('heroicon-m-envelope')
                ->color(Contact::whereNull('read_at')->count() > 0 ? 'danger' : 'gray'),
        ];
    }
}
