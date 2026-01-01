<!-- Tabs Navigation -->
<div class="border-b border-gray-200">
  <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
    <button type="button" @click="activeTab = 'basic'"
            :class="activeTab === 'basic' ? 'border-primary-500 text-primary-600' :
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
      Basic Info
    </button>
    <button type="button" @click="activeTab = 'hero'"
            :class="activeTab === 'hero' ? 'border-primary-500 text-primary-600' :
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
      Hero Section
    </button>
    <button type="button" @click="activeTab = 'pdf'"
            :class="activeTab === 'pdf' ? 'border-primary-500 text-primary-600' :
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
      PDF Preview
    </button>
    <button type="button" @click="activeTab = 'book-details'"
            :class="activeTab === 'book-details' ? 'border-primary-500 text-primary-600' :
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
      Book Details
    </button>
    <button type="button" @click="activeTab = 'features'"
            :class="activeTab === 'features' ? 'border-primary-500 text-primary-600' :
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
      Features
    </button>
    <button type="button" @click="activeTab = 'pricing'"
            :class="activeTab === 'pricing' ? 'border-primary-500 text-primary-600' :
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
      Pricing
    </button>
    <button type="button" @click="activeTab = 'order'"
            :class="activeTab === 'order' ? 'border-primary-500 text-primary-600' :
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
      Order Form
    </button>
    <button type="button" @click="activeTab = 'seo'"
            :class="activeTab === 'seo' ? 'border-primary-500 text-primary-600' :
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
      SEO & Settings
    </button>
  </nav>
</div>

