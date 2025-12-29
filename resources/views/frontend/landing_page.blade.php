<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $landingPage->meta_title ?? $landingPage->title }} - {{ config('app.name', 'Darpon') }}</title>

  @if ($landingPage->meta_description)
    <meta name="description" content="{{ $landingPage->meta_description }}">
  @endif

  @if ($landingPage->meta_image)
    <meta property="og:image" content="{{ Storage::url($landingPage->meta_image) }}">
  @endif

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/css/app.css'])
  <script src="{{ asset('js/alpine.min.js') }}" defer></script>
</head>

<body class="bg-white font-sans antialiased">
  <!-- Hero Section -->
  <section
           class="relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 text-white">
    @if ($landingPage->hero_image)
      <div class="absolute inset-0 z-0">
        <img src="{{ Storage::url($landingPage->hero_image) }}" alt="Hero"
             class="h-full w-full object-cover opacity-20">
      </div>
    @endif
    <div class="relative z-10 mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-32">
      <div class="mx-auto max-w-3xl text-center">
        @if ($landingPage->hero_title)
          <h1 class="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl lg:text-7xl">
            {{ $landingPage->hero_title }}
          </h1>
        @else
          <h1 class="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl lg:text-7xl">
            {{ $landingPage->title }}
          </h1>
        @endif
        @if ($landingPage->hero_subtitle)
          <p class="mt-6 text-lg leading-8 text-primary-100 sm:text-xl">
            {{ $landingPage->hero_subtitle }}
          </p>
        @endif
        @if ($landingPage->hero_video)
          <div class="mt-10">
            @if ($landingPage->hero_video_type === 'url')
              <div class="aspect-video w-full overflow-hidden rounded-lg shadow-2xl">
                <iframe src="{{ str_replace(['youtube.com/watch?v=', 'youtu.be/'], 'youtube.com/embed/', $landingPage->hero_video) }}"
                        class="h-full w-full" frameborder="0" allowfullscreen></iframe>
              </div>
            @else
              <video controls class="w-full rounded-lg shadow-2xl">
                <source src="{{ Storage::url($landingPage->hero_video) }}" type="video/mp4">
              </video>
            @endif
          </div>
        @endif
        @if ($landingPage->cta_text)
          <p class="mt-8 text-lg font-semibold text-primary-100">
            {{ $landingPage->cta_text }}
          </p>
        @endif
        <div class="mt-10 flex items-center justify-center gap-x-6">
          @if ($landingPage->product_type === 'course' && $landingPage->course)
            <a href="{{ route('courses.enroll', $landingPage->course->slug) }}"
               class="rounded-lg bg-white px-6 py-3 text-base font-semibold text-primary-600 shadow-lg transition-all hover:bg-gray-50 hover:shadow-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
              {{ $landingPage->cta_button_text ?? 'Enroll Now' }}
            </a>
          @elseif($landingPage->product_type === 'book' && $landingPage->book)
            <a href="{{ route('books.checkout', $landingPage->book->slug) }}"
               class="rounded-lg bg-white px-6 py-3 text-base font-semibold text-primary-600 shadow-lg transition-all hover:bg-gray-50 hover:shadow-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
              {{ $landingPage->cta_button_text ?? 'Buy Now' }}
            </a>
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- Product Information Section -->
  @if ($landingPage->product_type === 'course' && $landingPage->course)
    <section class="bg-white py-16">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
          <div>
            @if ($landingPage->course->thumbnail)
              <img src="{{ Storage::url($landingPage->course->thumbnail) }}" alt="{{ $landingPage->course->title }}"
                   class="w-full rounded-lg shadow-lg">
            @endif
          </div>
          <div>
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
              {{ $landingPage->course->title }}
            </h2>
            @if ($landingPage->course->short_description)
              <p class="mt-4 text-lg leading-8 text-gray-600">
                {!! $landingPage->course->short_description !!}
              </p>
            @endif
            @if ($landingPage->course->long_description)
              <p class="mt-4 text-lg leading-8 text-gray-600">
                {!! $landingPage->course->long_description !!}
              </p>
            @endif
            @php
              $price = $landingPage->course->discounted_price ?? ($landingPage->course->price ?? 0);
            @endphp
            @if ($price > 0)
              <p class="mt-6 text-3xl font-bold text-primary-600">
                BDT {{ number_format($price, 2) }}
              </p>
            @endif
            <a href="{{ route('courses.enroll', $landingPage->course->slug) }}"
               class="mt-8 inline-block rounded-lg bg-primary-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition-all hover:bg-primary-700 hover:shadow-xl">
              {{ $landingPage->cta_button_text ?? 'Enroll Now' }}
            </a>
          </div>
        </div>
      </div>
    </section>
  @elseif($landingPage->product_type === 'book' && $landingPage->book)
    <section class="bg-white py-16">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
          <div>
            @if ($landingPage->book->cover_image)
              <img src="{{ Storage::url($landingPage->book->cover_image) }}" alt="{{ $landingPage->book->title }}"
                   class="w-full rounded-lg shadow-lg">
            @endif
          </div>
          <div>
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
              {{ $landingPage->book->title }}
            </h2>
            @if ($landingPage->book->description)
              <p class="mt-4 text-lg leading-8 text-gray-600">
                {{ $landingPage->book->description }}
              </p>
            @endif
            @if ($landingPage->book->price > 0)
              <p class="mt-6 text-3xl font-bold text-primary-600">
                BDT {{ number_format($landingPage->book->price, 2) }}
              </p>
            @endif
            <a href="{{ route('books.checkout', $landingPage->book->slug) }}"
               class="mt-8 inline-block rounded-lg bg-primary-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition-all hover:bg-primary-700 hover:shadow-xl">
              {{ $landingPage->cta_button_text ?? 'Buy Now' }}
            </a>
          </div>
        </div>
      </div>
    </section>
  @endif

  <!-- Custom Description Section -->
  @if ($landingPage->custom_description)
    <section class="bg-gray-50 py-16">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg mx-auto max-w-none">
          {!! $landingPage->custom_description !!}
        </div>
      </div>
    </section>
  @endif

  <!-- Custom Images Gallery -->
  @if ($landingPage->custom_images && count($landingPage->custom_images) > 0)
    <section class="bg-white py-16">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="mb-8 text-center text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          Gallery
        </h2>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
          @foreach ($landingPage->custom_images as $image)
            <img src="{{ Storage::url($image) }}" alt="Gallery Image"
                 class="h-64 w-full rounded-lg object-cover shadow-lg transition-transform hover:scale-105">
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- Custom Videos Section -->
  @if ($landingPage->custom_videos && count($landingPage->custom_videos) > 0)
    <section class="bg-gray-50 py-16">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="mb-8 text-center text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          Videos
        </h2>
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
          @foreach ($landingPage->custom_videos as $video)
            <div class="aspect-video w-full overflow-hidden rounded-lg shadow-lg">
              <iframe src="{{ str_replace(['youtube.com/watch?v=', 'youtu.be/'], 'youtube.com/embed/', $video) }}"
                      class="h-full w-full" frameborder="0" allowfullscreen></iframe>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- Final CTA Section -->
  <section class="bg-primary-600 py-16">
    <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
        {{ $landingPage->cta_text ?? 'Ready to Get Started?' }}
      </h2>
      <div class="mt-10 flex items-center justify-center gap-x-6">
        @if ($landingPage->product_type === 'course' && $landingPage->course)
          <a href="{{ route('courses.enroll', $landingPage->course->slug) }}"
             class="rounded-lg bg-white px-6 py-3 text-base font-semibold text-primary-600 shadow-lg transition-all hover:bg-gray-50 hover:shadow-xl">
            {{ $landingPage->cta_button_text ?? 'Enroll Now' }}
          </a>
        @elseif($landingPage->product_type === 'book' && $landingPage->book)
          <a href="{{ route('books.checkout', $landingPage->book->slug) }}"
             class="rounded-lg bg-white px-6 py-3 text-base font-semibold text-primary-600 shadow-lg transition-all hover:bg-gray-50 hover:shadow-xl">
            {{ $landingPage->cta_button_text ?? 'Buy Now' }}
          </a>
        @endif
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 py-8 text-white">
    <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
      <p>&copy; {{ date('Y') }} {{ config('app.name', 'Darpon') }}. All rights reserved.</p>
    </div>
  </footer>
</body>

</html>
