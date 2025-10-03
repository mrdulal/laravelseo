<div class="seo-fields">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-gray-900">SEO Fields</h3>
            <button type="button" wire:click="toggleAdvanced" 
                    class="text-sm text-indigo-600 hover:text-indigo-800">
                {{ $showAdvanced ? 'Hide Advanced' : 'Show Advanced' }}
            </button>
        </div>
        
        @if (session()->has('message'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Basic Meta Tags -->
            <div class="border-b border-gray-200 pb-6">
                <h4 class="text-md font-medium text-gray-900 mb-4">Basic Meta Tags</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="seoData.title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" wire:model="seoData.title" id="seoData.title" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">{{ strlen($seoData['title'] ?? '') }}/60 characters</p>
                        @error('seoData.title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="seoData.author" class="block text-sm font-medium text-gray-700">Author</label>
                        <input type="text" wire:model="seoData.author" id="seoData.author" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('seoData.author') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="seoData.description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model="seoData.description" id="seoData.description" rows="3" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    <p class="mt-1 text-xs text-gray-500">{{ strlen($seoData['description'] ?? '') }}/160 characters</p>
                    @error('seoData.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <label for="seoData.keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
                    <input type="text" wire:model="seoData.keywords" id="seoData.keywords" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           placeholder="keyword1, keyword2, keyword3">
                    @error('seoData.keywords') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="seoData.robots" class="block text-sm font-medium text-gray-700">Robots</label>
                        <select wire:model="seoData.robots" id="seoData.robots" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="index, follow">Index, Follow</option>
                            <option value="noindex, follow">No Index, Follow</option>
                            <option value="index, nofollow">Index, No Follow</option>
                            <option value="noindex, nofollow">No Index, No Follow</option>
                        </select>
                        @error('seoData.robots') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="seoData.canonical_url" class="block text-sm font-medium text-gray-700">Canonical URL</label>
                        <input type="url" wire:model="seoData.canonical_url" id="seoData.canonical_url" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('seoData.canonical_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            @if($showAdvanced)
                <!-- Open Graph -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Open Graph</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="seoData.og_title" class="block text-sm font-medium text-gray-700">OG Title</label>
                            <input type="text" wire:model="seoData.og_title" id="seoData.og_title" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('seoData.og_title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="seoData.og_image" class="block text-sm font-medium text-gray-700">OG Image URL</label>
                            <input type="url" wire:model="seoData.og_image" id="seoData.og_image" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('seoData.og_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="seoData.og_description" class="block text-sm font-medium text-gray-700">OG Description</label>
                        <textarea wire:model="seoData.og_description" id="seoData.og_description" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        @error('seoData.og_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label for="seoData.og_type" class="block text-sm font-medium text-gray-700">OG Type</label>
                            <select wire:model="seoData.og_type" id="seoData.og_type" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="website">Website</option>
                                <option value="article">Article</option>
                                <option value="product">Product</option>
                                <option value="profile">Profile</option>
                            </select>
                            @error('seoData.og_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="seoData.og_url" class="block text-sm font-medium text-gray-700">OG URL</label>
                            <input type="url" wire:model="seoData.og_url" id="seoData.og_url" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('seoData.og_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="seoData.og_locale" class="block text-sm font-medium text-gray-700">OG Locale</label>
                            <input type="text" wire:model="seoData.og_locale" id="seoData.og_locale" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="en_US">
                            @error('seoData.og_locale') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Twitter Cards -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Twitter Cards</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="seoData.twitter_card" class="block text-sm font-medium text-gray-700">Twitter Card Type</label>
                            <select wire:model="seoData.twitter_card" id="seoData.twitter_card" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="summary">Summary</option>
                                <option value="summary_large_image">Summary Large Image</option>
                                <option value="app">App</option>
                                <option value="player">Player</option>
                            </select>
                            @error('seoData.twitter_card') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="seoData.twitter_image" class="block text-sm font-medium text-gray-700">Twitter Image URL</label>
                            <input type="url" wire:model="seoData.twitter_image" id="seoData.twitter_image" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('seoData.twitter_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="seoData.twitter_title" class="block text-sm font-medium text-gray-700">Twitter Title</label>
                            <input type="text" wire:model="seoData.twitter_title" id="seoData.twitter_title" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('seoData.twitter_title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="seoData.twitter_site" class="block text-sm font-medium text-gray-700">Twitter Site</label>
                            <input type="text" wire:model="seoData.twitter_site" id="seoData.twitter_site" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="@username">
                            @error('seoData.twitter_site') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="seoData.twitter_description" class="block text-sm font-medium text-gray-700">Twitter Description</label>
                        <textarea wire:model="seoData.twitter_description" id="seoData.twitter_description" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        @error('seoData.twitter_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-indigo-600 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save SEO Data
                </button>
            </div>
        </form>
    </div>
</div>