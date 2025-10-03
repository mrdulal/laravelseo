<?php

namespace LaravelSeoPro\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class InstallSeoProCommand extends Command
{
    protected $signature = 'seo:install 
                            {--force : Force installation without prompts}
                            {--filament : Install with Filament integration}
                            {--livewire : Install with Livewire integration}
                            {--blade-only : Install with Blade components only}
                            {--no-examples : Skip creating example files}';

    protected $description = 'Install Laravel SEO Pro with your preferred integration method';

    protected $integrationType = 'blade-only';
    protected $installFilament = false;
    protected $installLivewire = false;

    public function handle()
    {
        $this->info('🚀 Welcome to Laravel SEO Pro Installation!');
        $this->newLine();

        if (!$this->option('force')) {
            $this->selectIntegrationMethod();
        } else {
            $this->determineIntegrationFromOptions();
        }

        $this->info("Installing Laravel SEO Pro with {$this->integrationType} integration...");
        $this->newLine();

        $this->publishConfiguration();
        $this->publishMigrations();
        $this->publishViews();
        $this->runMigrations();
        $this->installDependencies();
        
        if (!$this->option('no-examples')) {
            $this->createExampleFiles();
        }
        
        $this->displaySuccessMessage();

        return 0;
    }

    protected function selectIntegrationMethod()
    {
        $this->info('Please select your preferred integration method:');
        $this->newLine();

        $options = [
            'blade-only' => 'Blade Components Only (Lightweight, no additional dependencies)',
            'livewire' => 'Livewire Integration (Reactive components, real-time updates)',
            'filament' => 'Filament Integration (Admin panel, advanced management)',
            'full' => 'Full Integration (Livewire + Filament + Blade)',
        ];

        $choice = $this->choice(
            'Which integration would you like to install?',
            $options,
            'blade-only'
        );

        $this->integrationType = array_search($choice, $options);

        switch ($this->integrationType) {
            case 'livewire':
                $this->installLivewire = true;
                break;
            case 'filament':
                $this->installFilament = true;
                break;
            case 'full':
                $this->installLivewire = true;
                $this->installFilament = true;
                break;
        }
    }

    protected function determineIntegrationFromOptions()
    {
        if ($this->option('filament')) {
            $this->integrationType = 'filament';
            $this->installFilament = true;
        } elseif ($this->option('livewire')) {
            $this->integrationType = 'livewire';
            $this->installLivewire = true;
        } elseif ($this->option('blade-only')) {
            $this->integrationType = 'blade-only';
        } else {
            $this->integrationType = 'blade-only';
        }
    }

    protected function publishConfiguration()
    {
        $this->info('📝 Publishing configuration...');
        Artisan::call('vendor:publish', [
            '--provider' => 'LaravelSeoPro\SeoProServiceProvider',
            '--tag' => 'seo-config'
        ]);
        $this->line('   ✓ Configuration published to config/seo.php');
    }

    protected function publishMigrations()
    {
        $this->info('🗄️ Publishing migrations...');
        Artisan::call('vendor:publish', [
            '--provider' => 'LaravelSeoPro\SeoProServiceProvider',
            '--tag' => 'seo-migrations'
        ]);
        $this->line('   ✓ Migrations published');
    }

    protected function publishViews()
    {
        $this->info('🎨 Publishing views...');
        Artisan::call('vendor:publish', [
            '--provider' => 'LaravelSeoPro\SeoProServiceProvider',
            '--tag' => 'seo-views'
        ]);
        $this->line('   ✓ Views published');
    }

    protected function runMigrations()
    {
        $this->info('🏃 Running migrations...');
        Artisan::call('migrate');
        $this->line('   ✓ Database tables created');
    }

    protected function installDependencies()
    {
        if ($this->installLivewire || $this->installFilament) {
            $this->info('📦 Installing dependencies...');
            
            if ($this->installLivewire) {
                $this->installLivewireDependency();
            }
            
            if ($this->installFilament) {
                $this->installFilamentDependency();
            }
        }
    }

    protected function installLivewireDependency()
    {
        if (!$this->isPackageInstalled('livewire/livewire')) {
            $this->info('   Installing Livewire...');
            if ($this->runComposerCommand('require livewire/livewire')) {
                $this->line('   ✓ Livewire installed');
            } else {
                $this->warn('   ⚠️  Failed to install Livewire. Please run: composer require livewire/livewire');
            }
        } else {
            $this->line('   ✓ Livewire already installed');
        }
    }

    protected function installFilamentDependency()
    {
        if (!$this->isPackageInstalled('filament/filament')) {
            $this->info('   Installing Filament...');
            if ($this->runComposerCommand('require filament/filament')) {
                $this->line('   ✓ Filament installed');
            } else {
                $this->warn('   ⚠️  Failed to install Filament. Please run: composer require filament/filament');
            }
        } else {
            $this->line('   ✓ Filament already installed');
        }
    }

    protected function isPackageInstalled($package)
    {
        $composerLock = base_path('composer.lock');
        
        if (!File::exists($composerLock)) {
            return false;
        }

        $lockContent = File::get($composerLock);
        return str_contains($lockContent, $package);
    }

    protected function runComposerCommand($command)
    {
        try {
            $process = new Process(['composer', ...explode(' ', $command)]);
            $process->setTimeout(300); // 5 minutes timeout
            $process->run();

            if ($process->isSuccessful()) {
                return true;
            } else {
                $this->error('Composer command failed: ' . $process->getErrorOutput());
                return false;
            }
        } catch (\Exception $e) {
            $this->error('Failed to run composer command: ' . $e->getMessage());
            return false;
        }
    }

    protected function createExampleFiles()
    {
        $this->info('📄 Creating example files...');
        
        $this->createExampleController();
        $this->createExampleModel();
        $this->createExampleBladeTemplate();
        
        if ($this->installLivewire) {
            $this->createExampleLivewireComponent();
        }
        
        if ($this->installFilament) {
            $this->createExampleFilamentResource();
        }
        
        $this->line('   ✓ Example files created');
    }

    protected function createExampleController()
    {
        $controllerContent = $this->getExampleControllerContent();
        $controllerPath = app_path('Http/Controllers/ExampleSeoController.php');
        
        if (!File::exists($controllerPath)) {
            File::put($controllerPath, $controllerContent);
        }
    }

    protected function createExampleModel()
    {
        $modelContent = $this->getExampleModelContent();
        $modelPath = app_path('Models/ExamplePost.php');
        
        if (!File::exists($modelPath)) {
            File::put($modelPath, $modelContent);
        }
    }

    protected function createExampleBladeTemplate()
    {
        $templateContent = $this->getExampleBladeTemplateContent();
        $templatePath = resource_path('views/example-seo.blade.php');
        
        if (!File::exists($templatePath)) {
            File::put($templatePath, $templateContent);
        }
    }

    protected function createExampleLivewireComponent()
    {
        $componentContent = $this->getExampleLivewireComponentContent();
        $componentPath = app_path('Livewire/ExampleSeoComponent.php');
        
        if (!File::exists($componentPath)) {
            File::put($componentPath, $componentContent);
        }
        
        $viewContent = $this->getExampleLivewireViewContent();
        $viewPath = resource_path('views/livewire/example-seo-component.blade.php');
        
        if (!File::exists($viewPath)) {
            File::makeDirectory(dirname($viewPath), 0755, true);
            File::put($viewPath, $viewContent);
        }
    }

    protected function createExampleFilamentResource()
    {
        $resourceContent = $this->getExampleFilamentResourceContent();
        $resourcePath = app_path('Filament/Resources/ExamplePostResource.php');
        
        if (!File::exists($resourcePath)) {
            File::makeDirectory(dirname($resourcePath), 0755, true);
            File::put($resourcePath, $resourceContent);
        }
    }

    protected function getExampleControllerContent()
    {
        return '<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelSeoPro\Facades\Seo;
use App\Models\ExamplePost;

class ExampleSeoController extends Controller
{
    public function show(ExamplePost $post)
    {
        // Load SEO data from model
        Seo::loadFromModel($post);
        
        // Or set SEO data manually
        Seo::setTitle($post->title . " - My Blog")
           ->setDescription("Read about " . $post->title)
           ->setKeywords("blog, " . $post->title)
           ->setOpenGraph("og:image", $post->featured_image);

        return view("example-seo", compact("post"));
    }
}';
    }

    protected function getExampleModelContent()
    {
        return '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelSeoPro\Traits\HasSeo;

class ExamplePost extends Model
{
    use HasSeo;

    protected $fillable = [
        "title",
        "content",
        "featured_image",
    ];

    public function getSeoUrl()
    {
        return route("posts.show", $this);
    }

    public function getSeoTitle()
    {
        return $this->title . " - My Blog";
    }

    public function getSeoDescription()
    {
        return \Str::limit(strip_tags($this->content), 160);
    }
}';
    }

    protected function getExampleBladeTemplateContent()
    {
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Include SEO components -->
    <x-seo.meta :model="$post" />
    <x-seo.og :model="$post" />
    <x-seo.twitter :model="$post" />
    <x-seo.json-ld :model="$post" />
    
    <title>Example SEO Page</title>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <div>{{ $post->content }}</div>
    
    @if(config("seo.features.livewire"))
        <!-- Livewire SEO Manager -->
        <livewire:seo-manager :model="$post" />
    @endif
</body>
</html>';
    }

    protected function getExampleLivewireComponentContent()
    {
        return '<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExamplePost;
use LaravelSeoPro\Facades\Seo;

class ExampleSeoComponent extends Component
{
    public $post;
    public $seoData = [];

    public function mount(ExamplePost $post)
    {
        $this->post = $post;
        $this->loadSeoData();
    }

    public function loadSeoData()
    {
        Seo::loadFromModel($this->post);
        $this->seoData = Seo::getAllMeta();
    }

    public function updateSeo($data)
    {
        $this->post->updateSeoMeta($data);
        $this->loadSeoData();
        
        $this->dispatch("seo-updated");
        session()->flash("message", "SEO data updated successfully!");
    }

    public function render()
    {
        return view("livewire.example-seo-component");
    }
}';
    }

    protected function getExampleLivewireViewContent()
    {
        return '<div>
    <h2>SEO Management</h2>
    
    @if (session()->has("message"))
        <div class="alert alert-success">
            {{ session("message") }}
        </div>
    @endif

    <livewire:seo-fields :model="$post" />
</div>';
    }

    protected function getExampleFilamentResourceContent()
    {
        return '<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\ExamplePost;

class ExamplePostResource extends Resource
{
    protected static ?string $model = ExamplePost::class;

    protected static ?string $navigationIcon = "heroicon-o-document-text";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make("title")
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make("content")
                    ->required()
                    ->rows(10),
                
                Forms\Components\TextInput::make("featured_image")
                    ->url()
                    ->maxLength(255),
                
                // SEO Section
                Forms\Components\Section::make("SEO Settings")
                    ->schema([
                        Forms\Components\TextInput::make("seo.title")
                            ->label("SEO Title")
                            ->maxLength(60),
                        
                        Forms\Components\Textarea::make("seo.description")
                            ->label("SEO Description")
                            ->maxLength(160),
                        
                        Forms\Components\TextInput::make("seo.keywords")
                            ->label("Keywords"),
                        
                        Forms\Components\TextInput::make("seo.og_image")
                            ->label("Open Graph Image")
                            ->url(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title")
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable(),
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
}';
    }

    protected function displaySuccessMessage()
    {
        $this->newLine();
        $this->info('🎉 Laravel SEO Pro installed successfully!');
        $this->newLine();

        $this->info('Next steps:');
        $this->line('1. Add the HasSeo trait to your models:');
        $this->line('   use LaravelSeoPro\Traits\HasSeo;');
        $this->line('   class YourModel extends Model { use HasSeo; }');
        $this->newLine();

        $this->line('2. Include SEO components in your Blade templates:');
        $this->line('   <x-seo.meta :model="$yourModel" />');
        $this->line('   <x-seo.og :model="$yourModel" />');
        $this->line('   <x-seo.twitter :model="$yourModel" />');
        $this->line('   <x-seo.json-ld :model="$yourModel" />');
        $this->newLine();

        if ($this->installLivewire) {
            $this->line('3. Use Livewire components for dynamic SEO management:');
            $this->line('   <livewire:seo-manager :model="$yourModel" />');
            $this->line('   <livewire:seo-fields :model="$yourModel" />');
            $this->newLine();
        }

        if ($this->installFilament) {
            $this->line('4. Access Filament admin panel to manage SEO data:');
            $this->line('   Visit /admin and look for "SEO Meta" in the navigation');
            $this->newLine();
        }

        $this->line('5. Run the SEO audit command:');
        $this->line('   php artisan seo:audit');
        $this->newLine();

        $this->line('6. Generate robots.txt and sitemap:');
        $this->line('   php artisan seo:generate-robots');
        $this->line('   php artisan seo:generate-sitemap');
        $this->newLine();

        $this->info('📚 Check the example files created in your app directory for reference!');
        $this->info('🔧 Configuration is available at config/seo.php');
        
        if (!$this->option('no-examples')) {
            $this->newLine();
            $this->warn('💡 Example files have been created in your app directory. You can delete them after reviewing.');
        }
    }
}