<?php

namespace App\Filament\Widgets;

use App\Models\Scam;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ScamStatsOverview extends BaseWidget
{
    // On peut changer l'ordre d'affichage (0 = tout en haut)
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        return [
            // Carte 1 : Les signalements à traiter (en Orange)
            Stat::make('En attente de modération', Scam::where('status', 'pending')->count())
                ->description('Signalements à vérifier')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            // Carte 2 : Les arnaques en ligne (en Vert)
            Stat::make('Arnaques validées', Scam::where('status', 'validated')->count())
                ->description('Visibles sur la plateforme')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            // Carte 3 : L'activité du mois (en Bleu)
            Stat::make('Signalements (Ce mois-ci)', Scam::whereMonth('created_at', now()->month)->count())
                ->description('Activité récente')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
        ];
    }
}
