@php
    $formAction = isset($landingPage)
        ? route('admin.landing-pages.update-partial', $landingPage)
        : route('admin.landing-pages.store-partial');
@endphp

<!-- Basic Information Tab -->
<div class="space-y-6">
    <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
            <h2 class="text-lg font-medium text-gray-900">Basic Information</h2>
            <p class="text-sm text-gray-500">Essential details for the landing page</p>
        </div>

        <form action="{{ $formAction }}" method="POST">
            @csrf
            @if (isset($landingPage))
                @method('PUT')
            @endif
            <input type="hidden" name="tab" value="basic">

            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <x-forms.input name="title" label="Title" :value="old('title', isset($landingPage) ? $landingPage->title : '')" required :error="$errors->first('title')"
                        id="landing-title" placeholder="Enter landing page title" />
                    <x-forms.input name="slug" label="Slug" :value="old('slug', isset($landingPage) ? $landingPage->slug : '')" required :error="$errors->first('slug')"
                        help="URL-friendly version (e.g., spoken-english-book)" id="landing-slug" />
                </div>

                <!-- Product Type Selection -->
                <div class="space-y-3">
                    <label class="text-sm font-medium text-gray-700">Product Type</label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="product_type" value="book"
                                {{ old('product_type', isset($landingPage) ? $landingPage->product_type : 'book') === 'book' ? 'checked' : '' }}
                                class="text-primary-600 focus:ring-primary-500 h-4 w-4 border-gray-300">
                            <span class="text-gray-700">Book</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="product_type" value="course"
                                {{ old('product_type', isset($landingPage) ? $landingPage->product_type : '') === 'course' ? 'checked' : '' }}
                                class="text-primary-600 focus:ring-primary-500 h-4 w-4 border-gray-300">
                            <span class="text-gray-700">Course</span>
                        </label>
                    </div>
                    @error('product_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Book Select -->
                <div id="book-select-container"
                    style="{{ old('product_type', isset($landingPage) ? $landingPage->product_type : 'book') === 'book' ? '' : 'display: none;' }}">
                    <x-forms.select name="product_id" label="Select Book" :options="$books" :value="old('product_id', isset($landingPage) && $landingPage->product_type === 'book' ? $landingPage->product_id : '')"
                        id="book-id" help="Select a book for this landing page" :disabled="old('product_type', isset($landingPage) ? $landingPage->product_type : 'book') !== 'book'" />
                </div>

                <!-- Course Select -->
                <div id="course-select-container"
                    style="{{ old('product_type', isset($landingPage) ? $landingPage->product_type : '') === 'course' ? '' : 'display: none;' }}">
                    <x-forms.select name="product_id" label="Select Course" :options="$courses ?? []" :value="old('product_id', isset($landingPage) && $landingPage->product_type === 'course' ? $landingPage->product_id : '')"
                        id="course-id" help="Select a course for this landing page" :disabled="old('product_type', isset($landingPage) ? $landingPage->product_type : '') !== 'course'" />
                </div>

                <!-- Section Visibility Toggles -->
                <div class="space-y-3">
                    <h3 class="text-sm font-medium text-gray-900">Section Visibility</h3>
                    <p class="text-xs text-gray-500 mb-3">Toggle which sections should be displayed on the frontend</p>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        <label class="flex items-center space-x-2">
                            <input type="hidden" name="show_hero" value="0">
                            <input type="checkbox" name="show_hero" value="1"
                                {{ old('show_hero', isset($landingPage) ? $landingPage->show_hero ?? true : true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-700">Hero Section</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="hidden" name="show_pdf_preview" value="0">
                            <input type="checkbox" name="show_pdf_preview" value="1"
                                {{ old('show_pdf_preview', isset($landingPage) ? $landingPage->show_pdf_preview ?? true : true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-700">PDF Preview</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="hidden" name="show_book_details" value="0">
                            <input type="checkbox" name="show_book_details" value="1"
                                {{ old('show_book_details', isset($landingPage) ? $landingPage->show_book_details ?? true : true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-700">Book Details</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="hidden" name="show_features" value="0">
                            <input type="checkbox" name="show_features" value="1"
                                {{ old('show_features', isset($landingPage) ? $landingPage->show_features ?? true : true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-700">Features</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="hidden" name="show_pricing" value="0">
                            <input type="checkbox" name="show_pricing" value="1"
                                {{ old('show_pricing', isset($landingPage) ? $landingPage->show_pricing ?? true : true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-700">Pricing</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="hidden" name="show_order" value="0">
                            <input type="checkbox" name="show_order" value="1"
                                {{ old('show_order', isset($landingPage) ? $landingPage->show_order ?? true : true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-700">Order Form</span>
                        </label>
                    </div>
                </div>

                <!-- CTA Button Text -->
                <x-forms.input name="cta_button_text" label="CTA Button Text" :value="old('cta_button_text', isset($landingPage) ? $landingPage->cta_button_text : 'অর্ডার করুন')" :error="$errors->first('cta_button_text')"
                    placeholder="অর্ডার করুন"
                    help="Text displayed on all CTA buttons throughout the landing page (e.g., 'অর্ডার করুন', 'রেজিস্ট্রেশন করুন')" />

                <div class='w-52'>
                    <!-- Header Background Color -->
                    <x-forms.input name="header_background_color" label="Header Background Color" type="color"
                        :value="old(
                            'header_background_color',
                            isset($landingPage) ? $landingPage->header_background_color ?? '#ffffff' : '#ffffff',
                        )" :error="$errors->first('header_background_color')"
                        help="Choose the background color for the landing page header" />
                </div>

                <!-- Status -->
                <div class="flex items-center space-x-3">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" id="status" value="1"
                        {{ old('status', isset($landingPage) ? $landingPage->status ?? 1 : 1) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
                    <span class="text-xs text-gray-500">Only active landing pages will be visible on the
                        frontend</span>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
                    <a href="{{ isset($landingPage) ? route('admin.landing-pages.edit', $landingPage) : route('admin.landing-pages.create') }}?tab=basic"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        Cancel
                    </a>
                    <x-button type="submit" variant="primary" size="md">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        {{ isset($landingPage) ? 'Update Basic Info' : 'Save Basic Info' }}
                    </x-button>
                </div>
            </div>
        </form>
    </x-card>
</div>
