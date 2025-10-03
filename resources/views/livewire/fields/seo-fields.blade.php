<div class="seo-fields">
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-medium text-gray-900">SEO Settings</h4>
            <button type="button" wire:click="toggleAdvanced" 
                    class="text-sm text-indigo-600 hover:text-indigo-500">
                {{ $showAdvanced ? 'Hide' : 'Show' }} Advanced
            </button>
        </div>

        <form wire:submit.prevent="save" class="space-y-4">
            <!-- Basic SEO Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" wire:model="seoData.title" id="title" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p class="mt-1 text-xs text-gray-500">{{ strlen($seoData['title']) }}/60 characters</p>
                    @error('seoData.title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                    <input type="text" wire:model="seoData.author" id="author" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('seoData.author') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="seoData.description" id="description" rows="3" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                <p class="mt-1 text-xs text-gray-500">{{ strlen($seoData['description']) }}/160 characters</p>
                @error('seoData.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
                    <input type="text" wire:model="seoData.keywords" id="keywords" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           placeholder="keyword1, keyword2, keyword3">
                    @error('seoData.keywords') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="robots" class="block text-sm font-medium text-gray-700">Robots</label>
                    <select wire:model="seoData.robots" id="robots" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="index, follow">Index, Follow</option>
                        <option value="noindex, follow">No Index, Follow</option>
                        <option value="index, nofollow">Index, No Follow</option>
                        <option value="noindex, nofollow">No Index, No Follow</option>
                    </select>
                    @error('seoData.robots') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="canonical_url" class="block text-sm font-medium text-gray-700">Canonical URL</label>
                <input type="url" wire:model="seoData.canonical_url" id="canonical_url" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('seoData.canonical_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Advanced SEO Fields -->
            @if($showAdvanced)
                <div class="border-t pt-4">
                    <h5 class="text-md font-medium text-gray-900 mb-4">Open Graph & Social Media</h5>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="og_title" class="block text-sm font-medium text-gray-700">OG Title</label>
                            <input type="text" wire:model="seoData.og_title" id="og_title" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="og_image" class="block text-sm font-medium text-gray-700">OG Image URL</label>
                            <input type="url" wire:model="seoData.og_image" id="og_image" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="og_description" class="block text-sm font-medium text-gray-700">OG Description</label>
                        <textarea wire:model="seoData.og_description" id="og_description" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="twitter_card" class="block text-sm font-medium text-gray-700">Twitter Card Type</label>
                            <select wire:model="seoData.twitter_card" id="twitter_card" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="summary">Summary</option>
                                <option value="summary_large_image">Summary Large Image</option>
                                <option value="app">App</option>
                                <option value="player">Player</option>
                            </select>
                        </div>

                        <div>
                            <label for="og_type" class="block text-sm font-medium text-gray-700">OG Type</label>
                            <select wire:model="seoData.og_type" id="og_type" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="website">Website</option>
                                <option value="article">Article</option>
                                <option value="product">Product</option>
                                <option value="profile">Profile</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="twitter_title" class="block text-sm font-medium text-gray-700">Twitter Title</label>
                            <input type="text" wire:model="seoData.twitter_title" id="twitter_title" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="twitter_image" class="block text-sm font-medium text-gray-700">Twitter Image URL</label>
                            <input type="url" wire:model="seoData.twitter_image" id="twitter_image" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="twitter_description" class="block text-sm font-medium text-gray-700">Twitter Description</label>
                        <textarea wire:model="seoData.twitter_description" id="twitter_description" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                </div>
            @endif

            <div class="flex justify-end pt-4">
                <button type="submit" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save SEO Settings
                </button>
            </div>
        </form>
    </div>
</div>
