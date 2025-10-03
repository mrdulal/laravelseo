<?php

namespace LaravelSeoPro\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use LaravelSeoPro\Models\SeoMeta;

class SeoMetaResource extends Resource
{
    protected static ?string $model = SeoMeta::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'SEO';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Meta Tags')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->maxLength(60)
                            ->helperText('Page title (max 60 characters)'),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText('Meta description (max 160 characters)'),
                        
                        Forms\Components\TextInput::make('keywords')
                            ->label('Keywords')
                            ->maxLength(255)
                            ->helperText('Comma-separated keywords'),
                        
                        Forms\Components\TextInput::make('author')
                            ->label('Author')
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('robots')
                            ->label('Robots')
                            ->options([
                                'index, follow' => 'Index, Follow',
                                'noindex, follow' => 'No Index, Follow',
                                'index, nofollow' => 'Index, No Follow',
                                'noindex, nofollow' => 'No Index, No Follow',
                            ])
                            ->default('index, follow'),
                        
                        Forms\Components\TextInput::make('canonical_url')
                            ->label('Canonical URL')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Open Graph')
                    ->schema([
                        Forms\Components\TextInput::make('og_title')
                            ->label('OG Title')
                            ->maxLength(60)
                            ->helperText('Open Graph title (max 60 characters)'),
                        
                        Forms\Components\Textarea::make('og_description')
                            ->label('OG Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText('Open Graph description (max 160 characters)'),
                        
                        Forms\Components\TextInput::make('og_image')
                            ->label('OG Image URL')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Open Graph image URL'),
                        
                        Forms\Components\Select::make('og_type')
                            ->label('OG Type')
                            ->options([
                                'website' => 'Website',
                                'article' => 'Article',
                                'product' => 'Product',
                                'profile' => 'Profile',
                            ])
                            ->default('website'),
                        
                        Forms\Components\TextInput::make('og_url')
                            ->label('OG URL')
                            ->url()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('og_site_name')
                            ->label('OG Site Name')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('og_locale')
                            ->label('OG Locale')
                            ->maxLength(10)
                            ->placeholder('en_US'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Twitter Cards')
                    ->schema([
                        Forms\Components\Select::make('twitter_card')
                            ->label('Twitter Card Type')
                            ->options([
                                'summary' => 'Summary',
                                'summary_large_image' => 'Summary Large Image',
                                'app' => 'App',
                                'player' => 'Player',
                            ])
                            ->default('summary_large_image'),
                        
                        Forms\Components\TextInput::make('twitter_site')
                            ->label('Twitter Site')
                            ->maxLength(100)
                            ->placeholder('@username'),
                        
                        Forms\Components\TextInput::make('twitter_creator')
                            ->label('Twitter Creator')
                            ->maxLength(100)
                            ->placeholder('@username'),
                        
                        Forms\Components\TextInput::make('twitter_title')
                            ->label('Twitter Title')
                            ->maxLength(60),
                        
                        Forms\Components\Textarea::make('twitter_description')
                            ->label('Twitter Description')
                            ->maxLength(160)
                            ->rows(3),
                        
                        Forms\Components\TextInput::make('twitter_image')
                            ->label('Twitter Image URL')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('JSON-LD Schema')
                    ->schema([
                        Forms\Components\KeyValue::make('json_ld')
                            ->label('JSON-LD Properties')
                            ->keyLabel('Property')
                            ->valueLabel('Value')
                            ->helperText('Add structured data properties'),
                    ]),
                
                Forms\Components\Section::make('Additional Meta Tags')
                    ->schema([
                        Forms\Components\KeyValue::make('additional_meta')
                            ->label('Additional Meta Tags')
                            ->keyLabel('Meta Name')
                            ->valueLabel('Meta Content')
                            ->helperText('Add custom meta tags'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('seoable_type')
                    ->label('Model Type')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('seoable_id')
                    ->label('Model ID')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('robots')
                    ->label('Robots')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'index, follow' => 'success',
                        'noindex, follow' => 'warning',
                        'index, nofollow' => 'warning',
                        'noindex, nofollow' => 'danger',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('seoable_type')
                    ->label('Model Type')
                    ->options(function () {
                        return SeoMeta::distinct('seoable_type')
                            ->pluck('seoable_type', 'seoable_type')
                            ->toArray();
                    }),
                
                Tables\Filters\SelectFilter::make('robots')
                    ->label('Robots')
                    ->options([
                        'index, follow' => 'Index, Follow',
                        'noindex, follow' => 'No Index, Follow',
                        'index, nofollow' => 'Index, No Follow',
                        'noindex, nofollow' => 'No Index, No Follow',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListSeoMetas::route('/'),
            'create' => Pages\CreateSeoMeta::route('/create'),
            'edit' => Pages\EditSeoMeta::route('/{record}/edit'),
        ];
    }
}
