@php
  $pdfPreviews = $landingPage->pdf_previews ?? [];
@endphp

@if(count($pdfPreviews) > 0)
  <section class="section-sm" style="background-color: #fff1d0;">
    <div class="container">
      <!-- PDF Preview Carousel -->
      <div style="width: 100%; overflow: hidden;">
        <div style="display: flex; gap: 20px; overflow-x: auto; padding-bottom: 20px; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; justify-content: center;">
          
          @foreach($pdfPreviews as $preview)
            @php
              $image = $preview['image'] ?? '';
              $pdfUrl = $preview['pdf_url'] ?? '#';
              $title = $preview['title'] ?? 'Preview ' . $loop->iteration;
            @endphp
            @if($image && $pdfUrl)
              <a href="{{ $pdfUrl }}" target="_blank" style="display: block; position: relative; min-width: 250px; height: 350px; border-radius: 10px; overflow: hidden; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="background-image: url('{{ $image }}'); background-size: cover; background-position: center; width: 100%; height: 100%; transition: transform 0.3s;"></div>
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                  <span style="background-color: var(--accent-color); color: white; padding: 10px 20px; border-radius: 5px; font-weight: 600;">Read More</span>
                </div>
              </a>
            @endif
          @endforeach

        </div>
      </div>
    </div>
  </section>
@endif
