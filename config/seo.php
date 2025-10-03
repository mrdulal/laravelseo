<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SEO Features
    |--------------------------------------------------------------------------
    |
    | Enable or disable specific SEO features
    |
    */
    'features' => [
        'meta_tags' => true,
        'open_graph' => true,
        'twitter_cards' => true,
        'json_ld' => true,
        'canonical_urls' => true,
        'robots_meta' => true,
        'robots_txt' => true,
        'sitemap' => true,
        'audit_middleware' => true,
        'dashboard' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Meta Values
    |--------------------------------------------------------------------------
    |
    | Default values for meta tags when not explicitly set
    |
    */
    'defaults' => [
        'title' => 'Laravel Application',
        'description' => 'A Laravel application',
        'keywords' => 'laravel, php, web development',
        'author' => 'Laravel Developer',
        'robots' => 'index, follow',
        'viewport' => 'width=device-width, initial-scale=1.0',
    ],

    /*
    |--------------------------------------------------------------------------
    | Open Graph Defaults
    |--------------------------------------------------------------------------
    |
    | Default values for Open Graph meta tags
    |
    */
    'open_graph' => [
        'type' => 'website',
        'site_name' => 'Laravel Application',
        'locale' => 'en_US',
        'image_width' => 1200,
        'image_height' => 630,
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Card Defaults
    |--------------------------------------------------------------------------
    |
    | Default values for Twitter Card meta tags
    |
    */
    'twitter' => [
        'card' => 'summary_large_image',
        'site' => '@laravel',
        'creator' => '@laravel',
    ],

    /*
    |--------------------------------------------------------------------------
    | Robots.txt Rules
    |--------------------------------------------------------------------------
    |
    | Rules for generating robots.txt file
    |
    */
    'robots' => [
        'user_agent' => '*',
        'disallow' => [
            '/admin',
            '/api',
            '/storage',
            '/vendor',
        ],
        'allow' => [
            '/',
        ],
        'sitemap' => '/sitemap.xml',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for XML sitemap generation
    |
    */
    'sitemap' => [
        'models' => [
            // Add your models here for automatic sitemap generation
            // Example: \App\Models\Post::class,
        ],
        'urls' => [
            // Add static URLs here
            // Example: ['url' => '/about', 'lastmod' => '2024-01-01', 'priority' => '0.8'],
        ],
        'priority' => '0.8',
        'changefreq' => 'weekly',
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Audit Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for SEO audit middleware
    |
    */
    'audit' => [
        'enabled' => true,
        'check_title' => true,
        'check_description' => true,
        'check_keywords' => true,
        'check_og_tags' => true,
        'check_twitter_tags' => true,
        'check_canonical' => true,
        'min_title_length' => 30,
        'max_title_length' => 60,
        'min_description_length' => 120,
        'max_description_length' => 160,
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for SEO dashboard (if enabled)
    |
    */
    'dashboard' => [
        'enabled' => false,
        'route' => '/seo-dashboard',
        'middleware' => ['web', 'auth'],
    ],
];
