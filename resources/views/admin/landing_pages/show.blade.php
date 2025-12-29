@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $landingPage->title }}</h1>
        <p class="mt-1 text-sm text-gray-600">
          Created on {{ $landingPage->created_at->format('F d, Y') }}
        </p>
      </div>
      <div class="flex gap-2">
        <x-ui.link href="{{ route('admin.landing-pages.edit', $landingPage) }}" variant="primary" size="md">
          Edit
        </x-ui.link>
        <x-ui.link href="{{ route('admin.landing-pages.index') }}" variant="outline" size="md">
          ← Back to List
        </x-ui.link>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
      <!-- Main Content -->
      <div class="space-y-6 lg:col-span-2">
        <!-- Hero Section Preview -->
        @if($landingPage->hero_image || $landingPage->hero_title)
          <x-card variant="elevated">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Hero Section</h3>
            @if($landingPage->hero_image)
              <img src="{{ Storage::url($landingPage->hero_image) }}" alt="Hero Image"
                   class="mb-4 w-full rounded-lg object-cover">
            @endif
            @if($landingPage->hero_title)
              <h2 class="text-2xl font-bold text-gray-900">{{ $landingPage->hero_title }}</h2>
            @endif
            @if($landingPage->hero_subtitle)
              <p class="mt-2 text-gray-600">{{ $landingPage->hero_subtitle }}</p>
            @endif
            @if($landingPage->hero_video)
              <div class="mt-4">
                @if($landingPage->hero_video_type === 'url')
                  <a href="{{ $landingPage->hero_video }}" target="_blank" class="text-primary-600 hover:text-primary-900">
                    View Video: {{ $landingPage->hero_video }}
                  </a>
                @else
                  <video controls class="w-full rounded-lg">
                    <source src="{{ Storage::url($landingPage->hero_video) }}" type="video/mp4">
                  </video>
                @endif
              </div>
            @endif
          </x-card>
        @endif

        <!-- Custom Description -->
        @if($landingPage->custom_description)
          <x-card variant="elevated">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Custom Description</h3>
            <div class="prose max-w-none">
              {!! $landingPage->custom_description !!}
            </div>
          </x-card>
        @endif

        <!-- Custom Images -->
        @if($landingPage->custom_images && count($landingPage->custom_images) > 0)
          <x-card variant="elevated">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Custom Images</h3>
            <div class="grid grid-cols-2 gap-4">
              @foreach($landingPage->custom_images as $image)
                <img src="{{ Storage::url($image) }}" alt="Custom Image" class="w-full rounded-lg object-cover">
              @endforeach
            </div>
          </x-card>
        @endif

        <!-- Custom Videos -->
        @if($landingPage->custom_videos && count($landingPage->custom_videos) > 0)
          <x-card variant="elevated">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Custom Videos</h3>
            <div class="space-y-4">
              @foreach($landingPage->custom_videos as $video)
                <div>
                  <a href="{{ $video }}" target="_blank" class="text-primary-600 hover:text-primary-900">
                    {{ $video }}
                  </a>
                </div>
              @endforeach
            </div>
          </x-card>
        @endif
      </div>

      <!-- Sidebar -->
      <div class="space-y-6">
        <!-- Product Information -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Product Information</h3>
          <dl class="space-y-3">
            <div>
              <dt class="text-sm font-medium text-gray-500">Product Type</dt>
              <dd class="mt-1">
                <x-ui.badge :variant="$landingPage->product_type === 'course' ? 'primary' : 'secondary'" size="sm">
                  {{ ucfirst($landingPage->product_type) }}
                </x-ui.badge>
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Product</dt>
              <dd class="mt-1 text-sm text-gray-900">
                @if ($landingPage->product_type === 'course' && $landingPage->course)
                  {{ $landingPage->course->title }}
                @elseif ($landingPage->product_type === 'book' && $landingPage->book)
                  {{ $landingPage->book->title }}
                @else
                  N/A
                @endif
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Status</dt>
              <dd class="mt-1">
                <x-ui.badge :variant="$landingPage->status ? 'success' : 'secondary'" size="sm">
                  {{ $landingPage->status ? 'Active' : 'Inactive' }}
                </x-ui.badge>
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Slug</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $landingPage->slug }}</dd>
            </div>
            @if($landingPage->status)
              <div>
                <dt class="text-sm font-medium text-gray-500">Public URL</dt>
                <dd class="mt-1">
                  <a href="{{ route('landing-page.show', $landingPage->slug) }}" target="_blank"
                     class="text-sm text-primary-600 hover:text-primary-900">
                    View Landing Page
                  </a>
                </dd>
              </div>
            @endif
          </dl>
        </x-card>

        <!-- CTA Information -->
        @if($landingPage->cta_text || $landingPage->cta_button_text)
          <x-card variant="elevated">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Call to Action</h3>
            <dl class="space-y-3">
              @if($landingPage->cta_text)
                <div>
                  <dt class="text-sm font-medium text-gray-500">CTA Text</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ $landingPage->cta_text }}</dd>
                </div>
              @endif
              @if($landingPage->cta_button_text)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Button Text</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ $landingPage->cta_button_text }}</dd>
                </div>
              @endif
            </dl>
          </x-card>
        @endif

        <!-- SEO Information -->
        @if($landingPage->meta_title || $landingPage->meta_description)
          <x-card variant="elevated">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">SEO Settings</h3>
            <dl class="space-y-3">
              @if($landingPage->meta_title)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Meta Title</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ $landingPage->meta_title }}</dd>
                </div>
              @endif
              @if($landingPage->meta_description)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Meta Description</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ $landingPage->meta_description }}</dd>
                </div>
              @endif
              @if($landingPage->meta_image)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Meta Image</dt>
                  <dd class="mt-1">
                    <img src="{{ Storage::url($landingPage->meta_image) }}" alt="Meta Image"
                         class="h-20 w-full rounded object-cover">
                  </dd>
                </div>
              @endif
            </dl>
          </x-card>
        @endif
      </div>
    </div>
  </div>
@endsection

