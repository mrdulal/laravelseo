<?php

namespace LaravelSeoPro\Filament\Components;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

class SeoFields
{
    public static function make(string $name = 'seo'): array
    {
        return [
            Section::make('SEO Settings')
                ->schema([
                    Tabs::make('SEO Tabs')
                        ->tabs([
                            Tab::make('Basic Meta')
                                ->schema([
                                    TextInput::make($name . '.title')
                                        ->label('Title')
                                        ->maxLength(60)
                                        ->helperText('Page title (max 60 characters)')
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set) use ($name) {
                                            // Auto-populate OG title if empty
                                            if (empty($state)) return;
                                            $set($name . '.og_title', $state);
                                            $set($name . '.twitter_title', $state);
                                        }),
                                    
                                    Textarea::make($name . '.description')
                                        ->label('Description')
                                        ->maxLength(160)
                                        ->rows(3)
                                        ->helperText('Meta description (max 160 characters)')
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set) use ($name) {
                                            // Auto-populate OG description if empty
                                            if (empty($state)) return;
                                            $set($name . '.og_description', $state);
                                            $set($name . '.twitter_description', $state);
                                        }),
                                    
                                    TextInput::make($name . '.keywords')
                                        ->label('Keywords')
                                        ->maxLength(255)
                                        ->helperText('Comma-separated keywords'),
                                    
                                    TextInput::make($name . '.author')
                                        ->label('Author')
                                        ->maxLength(255),
                                    
                                    Select::make($name . '.robots')
                                        ->label('Robots')
                                        ->options([
                                            'index, follow' => 'Index, Follow',
                                            'noindex, follow' => 'No Index, Follow',
                                            'index, nofollow' => 'Index, No Follow',
                                            'noindex, nofollow' => 'No Index, No Follow',
                                        ])
                                        ->default('index, follow'),
                                    
                                    TextInput::make($name . '.canonical_url')
                                        ->label('Canonical URL')
                                        ->url()
                                        ->maxLength(255),
                                ])
                                ->columns(2),
                            
                            Tab::make('Open Graph')
                                ->schema([
                                    TextInput::make($name . '.og_title')
                                        ->label('OG Title')
                                        ->maxLength(60)
                                        ->helperText('Open Graph title (max 60 characters)'),
                                    
                                    Textarea::make($name . '.og_description')
                                        ->label('OG Description')
                                        ->maxLength(160)
                                        ->rows(3)
                                        ->helperText('Open Graph description (max 160 characters)'),
                                    
                                    TextInput::make($name . '.og_image')
                                        ->label('OG Image URL')
                                        ->url()
                                        ->maxLength(255)
                                        ->helperText('Open Graph image URL'),
                                    
                                    Select::make($name . '.og_type')
                                        ->label('OG Type')
                                        ->options([
                                            'website' => 'Website',
                                            'article' => 'Article',
                                            'product' => 'Product',
                                            'profile' => 'Profile',
                                        ])
                                        ->default('website'),
                                    
                                    TextInput::make($name . '.og_url')
                                        ->label('OG URL')
                                        ->url()
                                        ->maxLength(255),
                                    
                                    TextInput::make($name . '.og_site_name')
                                        ->label('OG Site Name')
                                        ->maxLength(100),
                                    
                                    TextInput::make($name . '.og_locale')
                                        ->label('OG Locale')
                                        ->maxLength(10)
                                        ->placeholder('en_US'),
                                ])
                                ->columns(2),
                            
                            Tab::make('Twitter Cards')
                                ->schema([
                                    Select::make($name . '.twitter_card')
                                        ->label('Twitter Card Type')
                                        ->options([
                                            'summary' => 'Summary',
                                            'summary_large_image' => 'Summary Large Image',
                                            'app' => 'App',
                                            'player' => 'Player',
                                        ])
                                        ->default('summary_large_image'),
                                    
                                    TextInput::make($name . '.twitter_site')
                                        ->label('Twitter Site')
                                        ->maxLength(100)
                                        ->placeholder('@username'),
                                    
                                    TextInput::make($name . '.twitter_creator')
                                        ->label('Twitter Creator')
                                        ->maxLength(100)
                                        ->placeholder('@username'),
                                    
                                    TextInput::make($name . '.twitter_title')
                                        ->label('Twitter Title')
                                        ->maxLength(60),
                                    
                                    Textarea::make($name . '.twitter_description')
                                        ->label('Twitter Description')
                                        ->maxLength(160)
                                        ->rows(3),
                                    
                                    TextInput::make($name . '.twitter_image')
                                        ->label('Twitter Image URL')
                                        ->url()
                                        ->maxLength(255),
                                ])
                                ->columns(2),
                            
                            Tab::make('Advanced')
                                ->schema([
                                    KeyValue::make($name . '.json_ld')
                                        ->label('JSON-LD Properties')
                                        ->keyLabel('Property')
                                        ->valueLabel('Value')
                                        ->helperText('Add structured data properties'),
                                    
                                    KeyValue::make($name . '.additional_meta')
                                        ->label('Additional Meta Tags')
                                        ->keyLabel('Meta Name')
                                        ->valueLabel('Meta Content')
                                        ->helperText('Add custom meta tags'),
                                ]),
                        ])
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->collapsed(),
        ];
    }
}
