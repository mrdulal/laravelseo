@if(!empty($breadcrumbs))
<nav class="{{ $class }}" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm text-gray-500">
        @foreach($breadcrumbs as $index => $breadcrumb)
            <li class="flex items-center">
                @if($index > 0)
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
                
                @if($index === count($breadcrumbs) - 1)
                    <span class="text-gray-900 font-medium" aria-current="page">
                        {{ $breadcrumb['name'] }}
                    </span>
                @else
                    <a href="{{ $breadcrumb['url'] }}" 
                       class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        {{ $breadcrumb['name'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

@if($showJsonLd)
    {!! $getJsonLd() !!}
@endif
@endif
