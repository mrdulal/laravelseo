<?php

/**
 * Laravel SEO Pro - Livewire & Filament Usage Examples
 * 
 * This file demonstrates how to use Laravel SEO Pro with Livewire and Filament.
 */

use LaravelSeoPro\Facades\Seo;
use LaravelSeoPro\Traits\HasSeo;

// Example 1: Basic Livewire Component with SEO
class PostComponent extends \Livewire\Component
{
    public $post;
    public $seoData = [];

    public function mount($postId)
    {
        $this->post = Post::find($postId);
        $this->loadSeoData();
    }

    public function loadSeoData()
    {
        if ($this->post) {
            Seo::loadFromModel($this->post);
            $this->seoData = Seo::getAllMeta();
        }
    }

    public function updateSeo($data)
    {
        $this->post->updateSeoMeta($data);
        $this->loadSeoData();
        
        $this->dispatch('seo-updated');
    }

    public function render()
    {
        return view('livewire.post-component');
    }
}

// Example 2: Livewire Blade Template
/*
<div>
    <h1>{{ $post->title }}</h1>
    
    <!-- Include SEO components with model -->
    <x-seo.meta :model="$post" />
    <x-seo.og :model="$post" />
    <x-seo.twitter :model="$post" />
    <x-seo.json-ld :model="$post" />
    
    <!-- Or use the full SEO manager -->
    <livewire:seo-manager :model="$post" />
    
    <!-- Or use simple SEO fields -->
    <livewire:seo-fields :model="$post" />
</div>
*/

// Example 3: Filament Resource with SEO
class PostResource extends \Filament\Resources\Resource
{
    protected static ?string $model = Post::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Regular form fields
                Forms\Components\TextInput::make('title')
                    ->required(),
                
                Forms\Components\Textarea::make('content')
                    ->required(),
                
                // SEO fields using the package
                Forms\Components\Section::make('SEO Settings')
                    ->schema([
                        Forms\Components\TextInput::make('seo.title')
                            ->label('SEO Title')
                            ->maxLength(60),
                        
                        Forms\Components\Textarea::make('seo.description')
                            ->label('SEO Description')
                            ->maxLength(160),
                        
                        Forms\Components\TextInput::make('seo.keywords')
                            ->label('Keywords'),
                        
                        Forms\Components\TextInput::make('seo.og_image')
                            ->label('Open Graph Image')
                            ->url(),
                    ])
                    ->collapsible(),
            ]);
    }
}

// Example 4: Livewire Form with SEO Fields
class PostForm extends \Livewire\Component
{
    public $post;
    public $title;
    public $content;
    public $seoTitle;
    public $seoDescription;
    public $seoKeywords;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'seoTitle' => 'nullable|string|max:60',
        'seoDescription' => 'nullable|string|max:160',
        'seoKeywords' => 'nullable|string|max:255',
    ];

    public function mount($postId = null)
    {
        if ($postId) {
            $this->post = Post::find($postId);
            $this->title = $this->post->title;
            $this->content = $this->post->content;
            
            // Load SEO data
            $seoMeta = $this->post->getSeoMeta();
            $this->seoTitle = $seoMeta->title;
            $this->seoDescription = $seoMeta->description;
            $this->seoKeywords = $seoMeta->keywords;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->post) {
            $this->post->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);
        } else {
            $this->post = Post::create([
                'title' => $this->title,
                'content' => $this->content,
            ]);
        }

        // Update SEO data
        $this->post->updateSeoMeta([
            'title' => $this->seoTitle,
            'description' => $this->seoDescription,
            'keywords' => $this->seoKeywords,
        ]);

        $this->dispatch('post-saved');
    }

    public function render()
    {
        return view('livewire.post-form');
    }
}

// Example 5: Livewire Blade Template with SEO Fields
/*
<div>
    <form wire:submit.prevent="save">
        <!-- Regular fields -->
        <div>
            <label>Title</label>
            <input type="text" wire:model="title">
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Content</label>
            <textarea wire:model="content"></textarea>
            @error('content') <span class="error">{{ $message }}</span> @enderror
        </div>

        <!-- SEO fields -->
        <div class="seo-section">
            <h3>SEO Settings</h3>
            
            <div>
                <label>SEO Title</label>
                <input type="text" wire:model="seoTitle" maxlength="60">
                <small>{{ strlen($seoTitle) }}/60 characters</small>
                @error('seoTitle') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>SEO Description</label>
                <textarea wire:model="seoDescription" maxlength="160"></textarea>
                <small>{{ strlen($seoDescription) }}/160 characters</small>
                @error('seoDescription') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Keywords</label>
                <input type="text" wire:model="seoKeywords" placeholder="keyword1, keyword2, keyword3">
                @error('seoKeywords') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <button type="submit">Save Post</button>
    </form>
</div>
*/

// Example 6: Filament Custom Page with SEO
class SeoDashboard extends \Filament\Pages\Page
{
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static string $view = 'filament.pages.seo-dashboard';

    public function getTitle(): string
    {
        return 'SEO Dashboard';
    }

    public function getHeading(): string
    {
        return 'SEO Management Dashboard';
    }

    protected function getViewData(): array
    {
        return [
            'seoStats' => $this->getSeoStats(),
            'recentSeoUpdates' => $this->getRecentSeoUpdates(),
        ];
    }

    protected function getSeoStats(): array
    {
        return [
            'total_pages' => \LaravelSeoPro\Models\SeoMeta::count(),
            'pages_with_titles' => \LaravelSeoPro\Models\SeoMeta::whereNotNull('title')->count(),
            'pages_with_descriptions' => \LaravelSeoPro\Models\SeoMeta::whereNotNull('description')->count(),
            'pages_with_og_images' => \LaravelSeoPro\Models\SeoMeta::whereNotNull('og_image')->count(),
        ];
    }

    protected function getRecentSeoUpdates()
    {
        return \LaravelSeoPro\Models\SeoMeta::with('seoable')
            ->latest()
            ->limit(10)
            ->get();
    }
}

// Example 7: Livewire Component with Real-time SEO Preview
class SeoPreview extends \Livewire\Component
{
    public $post;
    public $seoData = [];
    public $previewData = [];

    public function mount($post)
    {
        $this->post = $post;
        $this->loadSeoData();
    }

    public function loadSeoData()
    {
        $seoMeta = $this->post->getSeoMeta();
        $this->seoData = [
            'title' => $seoMeta->title,
            'description' => $seoMeta->description,
            'keywords' => $seoMeta->keywords,
            'og_image' => $seoMeta->og_image,
        ];
        $this->updatePreview();
    }

    public function updatedSeoData($value, $key)
    {
        $this->updatePreview();
    }

    protected function updatePreview()
    {
        $this->previewData = [
            'title' => $this->seoData['title'] ?: $this->post->title,
            'description' => $this->seoData['description'] ?: 'No description provided',
            'url' => $this->post->getSeoUrl(),
            'image' => $this->seoData['og_image'] ?: '/default-image.jpg',
        ];
    }

    public function render()
    {
        return view('livewire.seo-preview');
    }
}

// Example 8: Livewire Blade Template with SEO Preview
/*
<div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- SEO Form -->
        <div>
            <h3>SEO Settings</h3>
            <form wire:submit.prevent="save">
                <div>
                    <label>Title</label>
                    <input type="text" wire:model="seoData.title" maxlength="60">
                    <small>{{ strlen($seoData['title']) }}/60 characters</small>
                </div>

                <div>
                    <label>Description</label>
                    <textarea wire:model="seoData.description" maxlength="160"></textarea>
                    <small>{{ strlen($seoData['description']) }}/160 characters</small>
                </div>

                <div>
                    <label>Keywords</label>
                    <input type="text" wire:model="seoData.keywords">
                </div>

                <div>
                    <label>Open Graph Image</label>
                    <input type="url" wire:model="seoData.og_image">
                </div>

                <button type="submit">Save SEO</button>
            </form>
        </div>

        <!-- Live Preview -->
        <div>
            <h3>Live Preview</h3>
            <div class="preview-card">
                <div class="preview-image">
                    <img src="{{ $previewData['image'] }}" alt="Preview">
                </div>
                <div class="preview-content">
                    <h4>{{ $previewData['title'] }}</h4>
                    <p>{{ $previewData['description'] }}</p>
                    <small>{{ $previewData['url'] }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
*/
