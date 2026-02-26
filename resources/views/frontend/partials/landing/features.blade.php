@php
  // Get dynamic data from landing page
  $featuresTitle = $landingPage->features_list_title ?? 'বইটির অসাধারণ কিছু বৈশিষ্ট্য';
  $featuresDescription = $landingPage->features_list_description ?? '';
  $targetAudienceTitle = $landingPage->target_audience_list_title ?? 'বইটি মূলত কাদের জন্য?';
  $targetAudienceDescription = $landingPage->target_audience_list_description ?? '';
  $targetAudienceList = $landingPage->target_audience_list ?? [];
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
      @if(!empty($targetAudienceDescription))
      <div class="feature-column">
        <h2 class="bengali-text feature-heading"
            style="color: white; margin: 0 0 30px; font-size: 1.8rem; font-weight: 700; padding-bottom: 10px; width: 100%; text-align: center; position: relative;">
          {{ $targetAudienceTitle }}
          <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
        </h2>

        <div class="target-audience-card" style="background: white; padding: 25px; border-radius: 8px; border: 2px solid var(--accent-color);">
          <div class="bengali-text target-audience-text" style="color: var(--dark-text); line-height: 1.8; font-size: 1.05rem;">
            {!! $targetAudienceDescription !!}
          </div>
        </div>

        <div style="text-align: center; margin-top: 40px;">
          <x-cta-button :landingPage="$landingPage" />
        </div>
      </div>
      @endif

      <!-- Why a Game Changer Column (Full Width below) -->
      @if(!empty($gameChangerDescription))
      <div class="game-changer-section"
           style="grid-column: 1 / -1; margin-top: 50px; padding-top: 50px;">
        <h2 class="bengali-text feature-heading"
            style="color: white; margin: 0 0 30px; font-size: 1.8rem; font-weight: 700; padding-bottom: 10px; width: 100%; text-align: center; position: relative;">
          {{ $gameChangerTitle }}
          <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
        </h2>

        <div class="game-changer-card"
            style="padding: 30px; margin: 0; background-color: white; border-radius: 10px; border: 2px solid var(--accent-color);">
          <div class="bengali-text game-changer-text" style="font-size: 1.1rem; line-height: 1.8; color: var(--dark-text);">
            {!! $gameChangerDescription !!}
          </div>
          @if($gameChangerConclusion)
          <div class="bengali-text game-changer-text"
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

    .target-audience-card,
    .game-changer-card {
      padding: 20px !important;
    }

    .target-audience-text,
    .game-changer-text {
      font-size: 1rem !important;
    }
  }
</style>
