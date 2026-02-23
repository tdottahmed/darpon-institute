@php
  // Get dynamic data from landing page
  $featuresTitle = $landingPage->features_list_title ?? 'বইটির অসাধারণ কিছু বৈশিষ্ট্য';
  $featuresDescription = $landingPage->features_list_description ?? '';
  $targetAudienceTitle = $landingPage->target_audience_list_title ?? 'বইটি মূলত কাদের জন্য?';
  $targetAudienceDescription = $landingPage->target_audience_list_description ?? '';
  $gameChangerTitle = $landingPage->game_changer_title ?? 'কেন এই বই একটি গেম চেঞ্জার';
  $gameChangerDescription = $landingPage->game_changer_description ?? '';
  $gameChangerConclusion = $landingPage->game_changer_conclusion ?? '';
@endphp

<section class="features-section section" style="background-color: #073050;">
  <div class="container-narrow">
    <div class="features-grid" style="display: grid; grid-template-columns: 1fr">

      <!-- Book Features Column -->
      @if(!empty($featuresDescription))
      <div class="feature-column">
        <h2 class="bengali-text feature-heading"
            style="color: white; margin: 0 0 30px; font-size: 1.8rem; font-weight: 700; padding-bottom: 10px; width: 100%; text-align: center; position: relative;">
          {{ $featuresTitle }}
          <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
        </h2>

        <div style="background: white; padding: 25px; border-radius: 8px; border: 2px solid var(--accent-color);">
          <div class="bengali-text" style="color: var(--dark-text); line-height: 1.8; font-size: 1.05rem;">
            {!! $featuresDescription !!}
          </div>
        </div>

        <div style="text-align: center; margin-top: 40px;">
          <x-cta-button :landingPage="$landingPage" />
        </div>
      </div>
      @endif

      <!-- Target Audience Column -->
      {{-- @if(!empty($targetAudienceList))
      @foreach($targetAudienceList as $audienceGroup)
      <div class="feature-column">
        <h2 class="bengali-text feature-heading"
            style="color: var(--primary-color); margin: 0 0 30px; font-size: 1.8rem; font-weight: 700; border-bottom: 2px solid var(--accent-color); padding-bottom: 10px; width: 100%;">
          {{ $audienceGroup['title'] ?? 'বইটি মূলত কাদের জন্য?' }}
        </h2>

        <ul style="list-style: none; padding: 0; margin: 0;">
          @foreach($audienceGroup['items'] ?? [] as $item)
            <li style="display: flex; align-items: flex-start; margin-bottom: 20px;">
              <span style="color: {{ $item['icon_color'] ?? 'var(--secondary-color)' }}; margin-right: 15px; flex-shrink: 0; font-size: 1.2rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"
                     fill="currentColor">
                  <path
                        d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z" />
                </svg>
              </span>
              <span class="bengali-text" style="color: var(--dark-text); line-height: 1.6; font-size: 1.05rem;">
                @if(isset($item['text']))
                  @php
                    $textParts = explode(':', $item['text'], 2);
                    $boldPart = $textParts[0] ?? '';
                    $descriptionPart = $textParts[1] ?? '';
                  @endphp
                  @if($descriptionPart)
                    {{ $boldPart }}: {{ $descriptionPart }}
                  @else
                    {{ $item['text'] }}
                  @endif
                @endif
              </span>
            </li>
          @endforeach
        </ul>

        <div style="text-align: center; margin-top: 40px;">
          <x-cta-button :landingPage="$landingPage" />
        </div>
      </div>
      @endforeach
      @endif --}}

      <!-- Why a Game Changer Column (Full Width below) -->
      @if(!empty($gameChangerDescription))
      <div class="game-changer-section"
           style="grid-column: 1 / -1; margin-top: 50px; padding-top: 50px;">
        <h2 class="bengali-text feature-heading"
            style="color: white; margin: 0 0 30px; font-size: 1.8rem; font-weight: 700; padding-bottom: 10px; width: 100%; text-align: center; position: relative;">
          {{ $gameChangerTitle }}
          <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
        </h2>

        <div
            style="padding: 30px; margin: 0; background-color: white; border-radius: 10px; border: 2px solid var(--accent-color);">
          <div class="bengali-text" style="font-size: 1.1rem; line-height: 1.8; color: var(--dark-text);">
            {!! $gameChangerDescription !!}
          </div>
          @if($gameChangerConclusion)
          <div class="bengali-text"
              style="font-size: 1.1rem; line-height: 1.8; color: var(--dark-text); font-weight: 600; margin-top: 15px;">
            {{ $gameChangerConclusion }}
          </div>
          @endif
        </div>

        <div style="text-align: center; margin-top: 30px;">
          <x-cta-button :landingPage="$landingPage" />
        </div>
      </div>
      @endif

    </div>
  </div>
</section>

<style>
  .features-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 40px;
    align-items: start;
  }

  .feature-column {
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .feature-heading {
    display: block;
    width: 100%;
  }

  .game-changer-section {
    grid-column: 1 / -1;
    margin-top: 50px;
    padding-top: 50px;
    /* border-top: 2px solid #e0e0e0; */
    width: 100%;
  }

  /* Tablet and larger devices - 2 columns */
  @media (min-width: 768px) {
    .features-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 40px;
    }
  }

  /* Medium devices - adjust spacing */
  @media (max-width: 968px) and (min-width: 768px) {
    .features-grid {
      gap: 30px;
    }

    .game-changer-section {
      margin-top: 40px;
      padding-top: 40px;
    }
  }

  /* Small devices - single column, full width */
  @media (max-width: 767px) {
    .features-section h2 {
      font-size: 1.5rem !important;
    }

    .features-grid {
      grid-template-columns: 1fr;
      gap: 30px;
    }

    .feature-column {
      width: 100%;
    }

    .game-changer-section {
      margin-top: 30px;
      padding-top: 30px;
      width: 100%;
    }
  }
</style>
