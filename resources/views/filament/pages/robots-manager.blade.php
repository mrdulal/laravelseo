<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Robots.txt Configuration
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Manage your robots.txt file to control how search engines crawl your website.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Current Robots.txt</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Robots.txt URL:</span>
                            <a href="/seo/robots.txt" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                /seo/robots.txt
                            </a>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Last Generated:</span>
                            <span class="text-sm text-gray-900 dark:text-gray-100">{{ now()->format('M j, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Robots.txt Actions</h4>
                    <div class="space-y-3">
                        <button onclick="window.open('/seo/robots.txt', '_blank')" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview Robots.txt
                        </button>
                        
                        <button onclick="window.open('https://www.google.com/webmasters/tools/robots-testing-tool', '_blank')" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Test with Google
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Current Robots.txt Content
            </h3>
            <div class="bg-gray-900 text-gray-100 p-4 rounded-lg font-mono text-sm overflow-x-auto">
                <pre>{{ $this->getRobotsContent() }}</pre>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Robots.txt Information
            </h3>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-gray-600 dark:text-gray-400">
                    The robots.txt file tells search engines which pages they can and cannot crawl on your website.
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 mt-4">
                    <li><strong>User-agent:</strong> Specifies which search engine the rules apply to</li>
                    <li><strong>Disallow:</strong> Pages or directories that should not be crawled</li>
                    <li><strong>Allow:</strong> Pages or directories that should be crawled</li>
                    <li><strong>Sitemap:</strong> Location of your XML sitemap</li>
                </ul>
            </div>
        </div>
    </div>
</x-filament-panels::page>

@php
    public function getRobotsContent(): string
    {
        try {
            $seoService = app(\LaravelSeoPro\Services\SeoService::class);
            return $seoService->generateRobots();
        } catch (\Exception $e) {
            return "Error generating robots.txt content: " . $e->getMessage();
        }
    }
@endphp
