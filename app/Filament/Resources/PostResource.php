<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Article de Blog')->schema([
                    TextInput::make('title')
                        ->label('Titre')
                        ->live(onBlur: true) // Dès qu'on sort du champ...
                        ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))) // ... on génère le slug
                        ->required(),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\FileUpload::make('image_path')
                        ->label('Image de couverture')
                        ->image()
                        ->directory('blog-images'),

                    Forms\Components\RichEditor::make('content') // Éditeur de texte riche (Gras, Italic, Listes...)
                        ->label('Contenu de l\'article')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Toggle::make('is_published')
                        ->label('Publier cet article')
                        ->default(true),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titre')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->sortable()->searchable(),
                Tables\Columns\ToggleColumn::make('is_published')->label('Publié')->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
            ])
            ->filters([
                //
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
