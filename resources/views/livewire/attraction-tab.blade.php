<div>
    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
        <ul class="space-x-8 flex flex-wrap -mb-px">
            <x-nav-link href="{{ route('attraction.entities') }}" class="py-2 px-4" :active="request()->routeIs('attraction.entities')">
                {{ __('Atrações') }}
            </x-nav-link>
        </ul>
    </div>
</div>
