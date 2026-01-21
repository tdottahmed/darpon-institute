@php
  $heroEnglishTitle = $landingPage->hero_english_title ?? ($landingPage->book->title ?? 'BOOK TITLE');
  $heroBengaliTitle = $landingPage->hero_bengali_title ?? 'বইটির বর্ণনা এখানে লিখুন';
  $heroMainImage = $landingPage->hero_main_image
      ? Storage::url($landingPage->hero_main_image)
      : ($landingPage->book->cover_image
          ? Storage::url($landingPage->book->cover_image)
          : asset('darponbdv.png'));
  $previewImages = $landingPage->hero_preview_images ?? [];
  // Combine main image with preview images for gallery
  $allImages = array_merge([$heroMainImage], array_map(fn($img) => Storage::url($img), $previewImages));
@endphp

<section class="hero-section section-sm" style="background-color: #353e4b; text-align: center;">
  <div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">

    <!-- Hero Image -->
    @if ($heroMainImage)
      <div style="margin-bottom: 20px;">
        <img decoding="async" src="{{ $heroMainImage }}" alt="{{ $heroEnglishTitle }}" id="heroMainImage"
             class="hero-main-image"
             style="max-width: 100%; height: auto; display: block; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
      </div>
    @endif

    <!-- English Heading -->
    @if ($heroEnglishTitle)
      <div style="margin-bottom: 15px;">
        <h2
            style="margin: 0; color: #ffffff; font-family: 'Times New Roman', serif; font-weight: 700; font-size: 2rem; text-transform: uppercase;">
          {{ strtoupper($heroEnglishTitle) }}
        </h2>
      </div>
    @endif

    <!-- Bengali Heading -->
    @if ($heroBengaliTitle)
      <div>
        <h2 class="bengali-text"
            style="margin: 0; color: #ffffff; font-weight: 600; font-size: 1.5rem; line-height: 1.4;">
          {!! nl2br(e($heroBengaliTitle)) !!}
        </h2>
      </div>
    @endif

    <!-- Book Preview Slider -->
    @if (count($previewImages) > 0)
      <div style="margin-top: 40px; width: 100%; max-width: 1200px;">
        <div class="preview-slider-container" style="position: relative;">
          <!-- Slider Wrapper -->
          <div class="preview-slider" id="previewSlider"
               style="display: flex; gap: 15px; overflow-x: auto; padding: 20px 50px; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; scrollbar-width: thin; scrollbar-color: #888 #f1f1f1;">
            @foreach ($previewImages as $index => $previewImage)
              <div class="preview-slide" data-image="{{ Storage::url($previewImage) }}" data-index="{{ $index + 1 }}"
                   style="flex: 0 0 auto; cursor: pointer; position: relative; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <img src="{{ Storage::url($previewImage) }}" alt="Page Preview {{ $loop->iteration }}"
                     class="preview-thumbnail"
                     style="height: 200px; width: auto; border: 3px solid #ddd; border-radius: 8px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div class="slide-overlay"
                     style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0); border-radius: 8px; transition: background 0.3s ease; pointer-events: none;">
                </div>
              </div>
            @endforeach
          </div>

          <!-- Navigation Arrows -->
          <button class="slider-nav slider-prev" id="sliderPrev"
                  style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.9); border: 2px solid #ddd; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #333; transition: all 0.3s ease; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            ‹
          </button>
          <button class="slider-nav slider-next" id="sliderNext"
                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.9); border: 2px solid #ddd; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #333; transition: all 0.3s ease; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            ›
          </button>
        </div>
      </div>
    @endif

  </div>

  <!-- Gallery Modal -->
  <div id="galleryModal" class="gallery-modal"
       style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 9999; overflow: hidden;">
    <div class="gallery-modal-content"
         style="position: relative; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
      <!-- Close Button -->
      <button id="closeGallery"
              style="position: absolute; top: 20px; right: 30px; background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.5); border-radius: 50%; width: 50px; height: 50px; color: white; font-size: 2rem; cursor: pointer; z-index: 10001; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center;">
        ×
      </button>

      <!-- Previous Button -->
      <button id="galleryPrev" class="gallery-nav"
              style="position: absolute; left: 30px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.5); border-radius: 50%; width: 60px; height: 60px; color: white; font-size: 2rem; cursor: pointer; z-index: 10001; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center;">
        ‹
      </button>

      <!-- Next Button -->
      <button id="galleryNext" class="gallery-nav"
              style="position: absolute; right: 30px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.5); border-radius: 50%; width: 60px; height: 60px; color: white; font-size: 2rem; cursor: pointer; z-index: 10001; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center;">
        ›
      </button>

      <!-- Image Container -->
      <div class="gallery-image-container"
           style="max-width: 90%; max-height: 90%; display: flex; align-items: center; justify-content: center; position: relative;">
        <img id="galleryImage" src="" alt="Gallery Image"
             style="max-width: 100%; max-height: 90vh; object-fit: contain; border-radius: 8px; box-shadow: 0 8px 32px rgba(0,0,0,0.5);">
      </div>

      <!-- Image Counter -->
      <div id="galleryCounter"
           style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.7); color: white; padding: 10px 20px; border-radius: 20px; font-size: 1rem; z-index: 10001;">
        <span id="currentIndex">1</span> / <span id="totalImages">{{ count($allImages) }}</span>
      </div>
    </div>
  </div>

  <style>
    /* Slider Styles */
    .preview-slider::-webkit-scrollbar {
      height: 8px;
    }

    .preview-slider::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .preview-slider::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 10px;
    }

    .preview-slider::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    .preview-slide:hover {
      transform: translateY(-5px);
    }

    .preview-slide:hover .preview-thumbnail {
      border-color: var(--accent-color, #ff9800);
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .preview-slide:hover .slide-overlay {
      background: rgba(0, 0, 0, 0.1);
    }

    .slider-nav:hover {
      background: rgba(255, 255, 255, 1) !important;
      border-color: var(--accent-color, #ff9800) !important;
      color: var(--accent-color, #ff9800) !important;
      transform: translateY(-50%) scale(1.1);
    }


    .gallery-nav:hover {
      background: rgba(255, 255, 255, 0.4) !important;
      transform: translateY(-50%) scale(1.1);
    }

    #closeGallery:hover {
      background: rgba(255, 255, 255, 0.3) !important;
      transform: scale(1.1);
    }

    /* Gallery Modal Animation */
    .gallery-modal {
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .gallery-image-container img {
      animation: zoomIn 0.3s ease;
    }

    @keyframes zoomIn {
      from {
        transform: scale(0.8);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    @media (max-width: 768px) {
      .hero-section h2 {
        font-size: 1.2rem !important;
      }

      .hero-section img {
        width: 200px !important;
      }

      .preview-thumbnail {
        height: 150px !important;
      }

      .slider-nav {
        width: 30px !important;
        height: 30px !important;
        font-size: 1.2rem !important;
      }

      .gallery-nav {
        width: 40px !important;
        height: 40px !important;
        font-size: 1.5rem !important;
      }

      #galleryImage {
        max-width: 95% !important;
        max-height: 80vh !important;
      }

      #closeGallery {
        width: 40px !important;
        height: 40px !important;
        font-size: 1.5rem !important;
        top: 10px !important;
        right: 10px !important;
      }
    }
  </style>

  <script>
    (function() {
      const allImages = @json($allImages);
      let currentGalleryIndex = 0;

      const previewSlider = document.getElementById('previewSlider');
      const sliderPrev = document.getElementById('sliderPrev');
      const sliderNext = document.getElementById('sliderNext');
      const galleryModal = document.getElementById('galleryModal');
      const galleryImage = document.getElementById('galleryImage');
      const closeGallery = document.getElementById('closeGallery');
      const galleryPrev = document.getElementById('galleryPrev');
      const galleryNext = document.getElementById('galleryNext');
      const currentIndexSpan = document.getElementById('currentIndex');
      const totalImagesSpan = document.getElementById('totalImages');
      const previewSlides = document.querySelectorAll('.preview-slide');

      // Initialize
      if (totalImagesSpan) {
        totalImagesSpan.textContent = allImages.length;
      }

      // Open gallery when preview is clicked
      previewSlides.forEach((slide, index) => {
        slide.addEventListener('click', function() {
          // Open gallery starting from this image (index + 1 because main image is at index 0)
          openGallery(index + 1);

          // Update active slide
          previewSlides.forEach(s => {
            s.classList.remove('active');
            s.querySelector('.preview-thumbnail').style.borderColor = '#ddd';
          });
          this.classList.add('active');
          this.querySelector('.preview-thumbnail').style.borderColor = 'var(--accent-color, #ff9800)';
        });
      });

      // Open gallery modal
      function openGallery(index) {
        currentGalleryIndex = index;
        updateGalleryImage();
        galleryModal.style.display = 'block';
        document.body.style.overflow = 'hidden';
      }

      // Close gallery modal
      function closeGalleryModal() {
        galleryModal.style.display = 'none';
        document.body.style.overflow = '';
      }

      // Update gallery image
      function updateGalleryImage() {
        if (allImages.length > 0 && currentGalleryIndex >= 0 && currentGalleryIndex < allImages.length) {
          galleryImage.src = allImages[currentGalleryIndex];
          if (currentIndexSpan) {
            currentIndexSpan.textContent = currentGalleryIndex + 1;
          }
        }
      }

      // Navigate gallery
      function nextImage() {
        currentGalleryIndex = (currentGalleryIndex + 1) % allImages.length;
        updateGalleryImage();
      }

      function prevImage() {
        currentGalleryIndex = (currentGalleryIndex - 1 + allImages.length) % allImages.length;
        updateGalleryImage();
      }

      // Event listeners - Gallery opens only from preview slider


      if (closeGallery) {
        closeGallery.addEventListener('click', closeGalleryModal);
      }

      if (galleryNext) {
        galleryNext.addEventListener('click', nextImage);
      }

      if (galleryPrev) {
        galleryPrev.addEventListener('click', prevImage);
      }

      // Keyboard navigation
      document.addEventListener('keydown', function(e) {
        if (galleryModal.style.display === 'block') {
          if (e.key === 'Escape') {
            closeGalleryModal();
          } else if (e.key === 'ArrowLeft') {
            prevImage();
          } else if (e.key === 'ArrowRight') {
            nextImage();
          }
        }
      });

      // Close on background click
      galleryModal.addEventListener('click', function(e) {
        if (e.target === galleryModal) {
          closeGalleryModal();
        }
      });

      // Slider navigation
      if (sliderPrev) {
        sliderPrev.addEventListener('click', () => {
          previewSlider.scrollBy({
            left: -300,
            behavior: 'smooth'
          });
        });
      }

      if (sliderNext) {
        sliderNext.addEventListener('click', () => {
          previewSlider.scrollBy({
            left: 300,
            behavior: 'smooth'
          });
        });
      }

      // Touch/swipe support for slider
      let isDown = false;
      let startX;
      let scrollLeft;

      if (previewSlider) {
        previewSlider.addEventListener('mousedown', (e) => {
          isDown = true;
          startX = e.pageX - previewSlider.offsetLeft;
          scrollLeft = previewSlider.scrollLeft;
        });

        previewSlider.addEventListener('mouseleave', () => {
          isDown = false;
        });

        previewSlider.addEventListener('mouseup', () => {
          isDown = false;
        });

        previewSlider.addEventListener('mousemove', (e) => {
          if (!isDown) return;
          e.preventDefault();
          const x = e.pageX - previewSlider.offsetLeft;
          const walk = (x - startX) * 2;
          previewSlider.scrollLeft = scrollLeft - walk;
        });
      }
    })();
  </script>
</section>
