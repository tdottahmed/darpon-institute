@php
  // Get active tab from query parameter, default to 'basic'
  $activeTab = request()->get('tab', 'basic');
  $tabs = [
    'basic' => 'Basic Info',
    'hero' => 'Hero Section',
    'pdf' => 'PDF Preview',
    'book-details' => 'Book Details',
    'features' => 'Features',
    'pricing' => 'Pricing',
    'order' => 'Order Form',
    'seo' => 'SEO & Settings',
  ];
  
  // Build URL for tab navigation
  $baseUrl = isset($landingPage) 
    ? route('admin.landing-pages.edit', $landingPage)
    : route('admin.landing-pages.create');
@endphp

<!-- Tabs Navigation -->
<div class="border-b border-gray-200">
  <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
    @foreach($tabs as $tabKey => $tabLabel)
      <a href="{{ $baseUrl }}?tab={{ $tabKey }}"
         class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition-colors {{ $activeTab === $tabKey ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        {{ $tabLabel }}
      </a>
    @endforeach
  </nav>
</div>

