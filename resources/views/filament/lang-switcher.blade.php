<div class="flex items-center gap-1 me-2">
    @php $locale = app()->getLocale(); @endphp
    <a href="{{ route('lang.switch', 'en') }}"
       class="px-2 py-1 rounded text-xs font-semibold transition-colors
              {{ $locale === 'en' ? 'bg-primary-600 text-white' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-200' }}">
        EN
    </a>
    <span class="text-gray-300 dark:text-gray-600 text-xs">|</span>
    <a href="{{ route('lang.switch', 'bn') }}"
       class="px-2 py-1 rounded text-xs font-semibold transition-colors
              {{ $locale === 'bn' ? 'bg-primary-600 text-white' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-200' }}">
        বাং
    </a>
</div>
