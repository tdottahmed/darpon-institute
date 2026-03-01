@php
  $pdfPreviews = $landingPage->pdf_previews ?? [];
@endphp

@if(count($pdfPreviews) > 0)
  <section class="section-sm" style="background-color: #073050;">
    <div class="container">
      <!-- PDF Preview Carousel -->
      <div style="width: 100%; overflow: hidden;">
        <div style="display: flex; gap: 20px; overflow: hidden; justify-content: center;">
          
          @foreach($pdfPreviews as $preview)
            @php
              $image = $preview['image'] ?? '';
              $pdfUrl = $preview['pdf_url'] ?? '#';
              $title = $preview['title'] ?? 'Preview ' . $loop->iteration;
              
              // Handle image URL - check if it's a storage path or full URL
              if ($image && strpos($image, 'storage/') === 0) {
                $image = asset('storage/' . str_replace('storage/', '', $image));
              } elseif ($image && strpos($image, 'http') !== 0) {
                $image = asset('storage/' . $image);
              }
              
              // Handle PDF URL - check if it's a storage path or full URL
              if ($pdfUrl && strpos($pdfUrl, 'storage/') === 0) {
                $pdfUrl = asset('storage/' . str_replace('storage/', '', $pdfUrl));
              } elseif ($pdfUrl && strpos($pdfUrl, 'http') !== 0 && $pdfUrl !== '#') {
                $pdfUrl = asset('storage/' . $pdfUrl);
              }
            @endphp
            @if($image && $pdfUrl)
              <a href="{{ $pdfUrl }}" target="_blank" style="display: block; position: relative; min-width: 250px; height: 350px; border-radius: 10px; overflow: hidden; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="background-image: url('{{ $image }}'); border: 1px solid #F47F16; background-size: cover; background-position: center; width: 100%; height: 100%; transition: transform 0.3s;"></div>
                <div style="position: absolute; inset: 0; border: 1px solid #F47F16; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                  <span style="background-color: var(--accent-color); color: white; padding: 10px 20px; border-radius: 5px; font-weight: 600;">Read More</span>
                </div>
                @if($title)
                  <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding: 15px; color: white; font-weight: 600;">
                    {{ $title }}
                  </div>
                @endif
              </a>
            @endif
          @endforeach

        </div>
      </div>
    </div>
  </section>
@endif
