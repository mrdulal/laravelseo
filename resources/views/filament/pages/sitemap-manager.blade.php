<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Sitemap Configuration
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Manage your XML sitemap settings and generate sitemaps for better search engine indexing.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Current Sitemap</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Sitemap URL:</span>
                            <a href="/seo/sitemap.xml" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                /seo/sitemap.xml
                            </a>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Last Generated:</span>
                            <span class="text-sm text-gray-900 dark:text-gray-100">{{ now()->format('M j, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Sitemap Actions</h4>
                    <div class="space-y-3">
                        <button onclick="window.open('/seo/sitemap.xml', '_blank')" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview Sitemap
                        </button>
                        
                        <button onclick="window.open('https://www.google.com/ping?sitemap=' + encodeURIComponent(window.location.origin + '/seo/sitemap.xml'), '_blank')" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            Submit to Google
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Sitemap Information
            </h3>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-gray-600 dark:text-gray-400">
                    Your XML sitemap helps search engines discover and index your website's pages. 
                    The sitemap is automatically generated based on your SEO meta records and configured models.
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 mt-4">
                    <li>Include all pages with SEO meta data</li>
                    <li>Update automatically when SEO records change</li>
                    <li>Follows XML sitemap protocol standards</li>
                    <li>Includes last modification dates and priorities</li>
                </ul>
            </div>
        </div>
    </div>
</x-filament-panels::page>
