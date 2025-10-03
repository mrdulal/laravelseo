<div class="seo-manager">
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-6">SEO Management</h3>
        
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
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" wire:model="title" id="title" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">{{ strlen($title) }}/60 characters</p>
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                        <input type="text" wire:model="author" id="author" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('author') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model="description" id="description" rows="3" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    <p class="mt-1 text-xs text-gray-500">{{ strlen($description) }}/160 characters</p>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <label for="keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
                    <input type="text" wire:model="keywords" id="keywords" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           placeholder="keyword1, keyword2, keyword3">
                    @error('keywords') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="robots" class="block text-sm font-medium text-gray-700">Robots</label>
                        <select wire:model="robots" id="robots" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="index, follow">Index, Follow</option>
                            <option value="noindex, follow">No Index, Follow</option>
                            <option value="index, nofollow">Index, No Follow</option>
                            <option value="noindex, nofollow">No Index, No Follow</option>
                        </select>
                        @error('robots') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="canonicalUrl" class="block text-sm font-medium text-gray-700">Canonical URL</label>
                        <input type="url" wire:model="canonicalUrl" id="canonicalUrl" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('canonicalUrl') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Open Graph -->
            <div class="border-b border-gray-200 pb-6">
                <h4 class="text-md font-medium text-gray-900 mb-4">Open Graph</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="ogTitle" class="block text-sm font-medium text-gray-700">OG Title</label>
                        <input type="text" wire:model="ogTitle" id="ogTitle" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('ogTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="ogImage" class="block text-sm font-medium text-gray-700">OG Image URL</label>
                        <input type="url" wire:model="ogImage" id="ogImage" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('ogImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="ogDescription" class="block text-sm font-medium text-gray-700">OG Description</label>
                    <textarea wire:model="ogDescription" id="ogDescription" rows="3" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    @error('ogDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="ogType" class="block text-sm font-medium text-gray-700">OG Type</label>
                        <select wire:model="ogType" id="ogType" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="website">Website</option>
                            <option value="article">Article</option>
                            <option value="product">Product</option>
                            <option value="profile">Profile</option>
                        </select>
                        @error('ogType') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="ogUrl" class="block text-sm font-medium text-gray-700">OG URL</label>
                        <input type="url" wire:model="ogUrl" id="ogUrl" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('ogUrl') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="ogLocale" class="block text-sm font-medium text-gray-700">OG Locale</label>
                        <input type="text" wire:model="ogLocale" id="ogLocale" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="en_US">
                        @error('ogLocale') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Twitter Cards -->
            <div class="border-b border-gray-200 pb-6">
                <h4 class="text-md font-medium text-gray-900 mb-4">Twitter Cards</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="twitterCard" class="block text-sm font-medium text-gray-700">Twitter Card Type</label>
                        <select wire:model="twitterCard" id="twitterCard" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="summary">Summary</option>
                            <option value="summary_large_image">Summary Large Image</option>
                            <option value="app">App</option>
                            <option value="player">Player</option>
                        </select>
                        @error('twitterCard') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="twitterImage" class="block text-sm font-medium text-gray-700">Twitter Image URL</label>
                        <input type="url" wire:model="twitterImage" id="twitterImage" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('twitterImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="twitterTitle" class="block text-sm font-medium text-gray-700">Twitter Title</label>
                        <input type="text" wire:model="twitterTitle" id="twitterTitle" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('twitterTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="twitterSite" class="block text-sm font-medium text-gray-700">Twitter Site</label>
                        <input type="text" wire:model="twitterSite" id="twitterSite" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="@username">
                        @error('twitterSite') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="twitterDescription" class="block text-sm font-medium text-gray-700">Twitter Description</label>
                    <textarea wire:model="twitterDescription" id="twitterDescription" rows="3" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    @error('twitterDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Additional Meta Tags -->
            <div class="border-b border-gray-200 pb-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-md font-medium text-gray-900">Additional Meta Tags</h4>
                    <button type="button" wire:click="addAdditionalMeta" 
                            class="bg-indigo-600 text-white px-3 py-1 rounded text-sm hover:bg-indigo-700">
                        Add Meta Tag
                    </button>
                </div>

                @foreach($additionalMeta as $index => $meta)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <input type="text" wire:model="additionalMeta.{{ $index }}.name" 
                                   placeholder="Meta name" 
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <input type="text" wire:model="additionalMeta.{{ $index }}.content" 
                                   placeholder="Meta content" 
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <button type="button" wire:click="removeAdditionalMeta({{ $index }})" 
                                    class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                Remove
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

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
