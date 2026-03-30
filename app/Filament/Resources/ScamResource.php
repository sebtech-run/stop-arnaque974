<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScamResource\Pages;
use App\Filament\Resources\ScamResource\RelationManagers;
use App\Models\Scam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Get;

class ScamResource extends Resource
{
    protected static ?string $model = Scam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // SECTION 1 : Détails de l'arnaque
                Forms\Components\Section::make('Détails du Signalement')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            // 1. TITRE (Modifié pour générer le slug)
                            Forms\Components\TextInput::make('title')
                                ->label('Titre du signalement')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true) // Déclenche l'action quand on quitte le champ
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                    // Si le slug est vide ou qu'on est en création, on le génère
                                    if (! $get('is_slug_changed_manually') && filled($state)) {
                                        $set('slug', Str::slug($state) . '-' . time());
                                    }
                                }),
                            // 2. SLUG (Le champ invisible mais vital)
                            Forms\Components\TextInput::make('slug')
                                ->label('Lien (Slug)')
                                ->disabled() // On empêche la modif manuelle pour éviter les erreurs
                                ->dehydrated() // Important : permet d'envoyer la valeur à la base de données même si désactivé
                                ->required()
                                ->unique(Scam::class, 'slug', ignoreRecord: true), // Doit être unique



                            Forms\Components\Select::make('type')
                                ->options([
                                    'phishing' => 'Phishing / Hameçonnage',
                                    'ransomware' => 'Ransomware',
                                    'sms_fraud' => 'Arnaque SMS / Colis',
                                    'fake_support' => 'Faux Support Technique',
                                    'leboncoin' => 'Arnaque Petite Annonce',
                                    'other' => 'Autre',
                                ])
                                ->required()
                                ->columnSpanFull(), // Prend toute la largeur
                        ]),

                        Forms\Components\Textarea::make('description')
                            ->rows(5)
                            ->required()
                            ->columnSpanFull(),
                    ]),

                // SECTION 2 : Les identifiants de l'arnaqueur (Pour ta recherche future)
                Forms\Components\Section::make('Identifiants de l\'arnaqueur')
                    ->description('Ces données permettront aux victimes de faire une recherche.')
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('scammer_phone')
                                ->label('Téléphone')
                                ->placeholder('Ex: 0692...'),
                            Forms\Components\TextInput::make('scammer_email')
                                ->label('Email')
                                ->email(),
                            Forms\Components\TextInput::make('scammer_url')
                                ->label('Site Web / URL')
                                ->url(),
                        ]),
                    ]),

                // SECTION 3 : Preuves et Modération
                Forms\Components\Section::make('Preuves & Statut')
                    ->schema([
                        // Upload multiple d'images
                        Forms\Components\FileUpload::make('evidence_paths')
                            ->label('Captures d\'écran')
                            ->multiple() // Autorise plusieurs images
                            ->directory('scams-evidence') // Dossier de stockage dans storage/app/public
                            ->image()
                            ->imageEditor(), // Permet de recadrer/flouter directement dans l'admin !

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('status')
                                ->options([
                                    'pending' => 'En attente',
                                    'validated' => 'Validé (Visible)',
                                    'rejected' => 'Rejeté',
                                ])
                                ->default('pending')
                                ->required(),

                            Forms\Components\TextInput::make('location')
                                ->default('974')
                                ->disabled(), // On le laisse à 974 par défaut pour l'instant
                        ]),

                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Raison du rejet (Interne)')
                            ->placeholder('Pourquoi ce signalement est refusé ?'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Date')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable() // Tu pourras chercher un titre
                    ->limit(30),

                Tables\Columns\TextColumn::make('type')
                    ->badge() // Affiche comme un petit badge coloré
                    ->color(fn(string $state): string => match ($state) {
                        'ransomware' => 'danger',
                        'sms_fraud' => 'warning',
                        'phishing' => 'info',
                        default => 'gray',
                    }),

                // C'est la colonne la plus importante pour toi : le Statut
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'validated' => 'success', // Vert
                        'rejected' => 'danger',   // Rouge
                        'pending' => 'warning',   // Jaune
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'En attente',
                        'validated' => 'Publié',
                        'rejected' => 'Rejeté',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('scammer_phone')
                    ->label('Tél. suspect')
                    ->searchable(), // Tu pourras chercher directement un numéro ici
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'En attente',
                    'validated' => 'Validé',
                    'rejected' => 'Rejeté',
                ]),
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
            'index' => Pages\ListScams::route('/'),
            'create' => Pages\CreateScam::route('/create'),
            'edit' => Pages\EditScam::route('/{record}/edit'),
        ];
    }
}
