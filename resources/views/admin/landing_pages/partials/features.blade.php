@php
  $formAction = isset($landingPage) 
    ? route('admin.landing-pages.update-partial', $landingPage)
    : route('admin.landing-pages.store-partial');
@endphp

<!-- Features Tab -->
<div class="space-y-6">
  <x-card variant="elevated">
    <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
      <h2 class="text-lg font-medium text-gray-900">Features Section</h2>
      <p class="text-sm text-gray-500">Book features, target audience, and game changer information</p>
    </div>

    <form action="{{ $formAction }}" method="POST">
      @csrf
      @if(isset($landingPage))
        @method('PUT')
      @endif
      <input type="hidden" name="tab" value="features">

      <div class="space-y-6">
      <div class="space-y-4">
        <label class="block text-sm font-medium text-gray-700">Features List (JSON Format)</label>
        <p class="text-xs text-gray-500 mb-2">List of book features. Each feature group has a title and items with text and icon_color.</p>
        <textarea name="features_list" rows="18"
                  class="block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  placeholder='[
  {
    "title": "বইটির অসাধারণ কিছু বৈশিষ্ট্য",
    "items": [
      {
        "text": "বাস্তবমুখী শেখা, শুধুই তত্ত্ব নয়",
        "icon_color": "#1a237e"
      },
      {
        "text": "এক বইয়ে সম্পূর্ণ শেখার উপকরণ",
        "icon_color": "#1a237e"
      }
    ]
  }
]'>{{ old('features_list', isset($landingPage) && $landingPage->features_list ? json_encode($landingPage->features_list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
        <x-forms.error :message="$errors->first('features_list')" />
      </div>

      <div class="space-y-4">
        <label class="block text-sm font-medium text-gray-700">Target Audience List (JSON Format)</label>
        <p class="text-xs text-gray-500 mb-2">List describing who the book is for. Structure is similar to features list.</p>
        <textarea name="target_audience_list" rows="18"
                  class="block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  placeholder='[
  {
    "title": "বইটি মূলত কাদের জন্য?",
    "items": [
      {
        "text": "যারা বাস্তব জীবনে সাবলীল ইংরেজিতে কথা বলতে চান",
        "icon_color": "#1565c0"
      },
      {
        "text": "স্কুল, কলেজ, ব্যবসা, অফিস, ভ্রমণ—সব পরিস্থিতিতে",
        "icon_color": "#1565c0"
      }
    ]
  }
]'>{{ old('target_audience_list', isset($landingPage) && $landingPage->target_audience_list ? json_encode($landingPage->target_audience_list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
        <x-forms.error :message="$errors->first('target_audience_list')" />
      </div>

      <div class="border-t border-gray-200 pt-6">
        <h3 class="mb-4 text-base font-medium text-gray-900">Game Changer Section</h3>
        
        <x-forms.input name="game_changer_title" label="Game Changer Title" 
                       :value="old('game_changer_title', isset($landingPage) ? $landingPage->game_changer_title : '')" 
                       :error="$errors->first('game_changer_title')"
                       placeholder="কেন এই বই একটি গেম চেঞ্জার" 
                       help="Title for the game changer section" />

        <div class="mt-4 space-y-4">
          <label class="block text-sm font-medium text-gray-700">Game Changer Points (JSON Array)</label>
          <p class="text-xs text-gray-500 mb-2">Simple array of key points that make this book a game changer.</p>
          <textarea name="game_changer_points" rows="8"
                    class="block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder='[
  "বাস্তব কথোপকথন",
  "ব্যবহারিক অভিব্যক্তি",
  "স্পষ্ট উদাহরণ",
  "ধাপে ধাপে শেখা"
]'>{{ old('game_changer_points', isset($landingPage) && $landingPage->game_changer_points ? json_encode($landingPage->game_changer_points, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
          <x-forms.error :message="$errors->first('game_changer_points')" />
        </div>

        <div class="mt-4">
          <x-forms.textarea name="game_changer_conclusion" label="Game Changer Conclusion" 
                            :value="old('game_changer_conclusion', isset($landingPage) ? $landingPage->game_changer_conclusion : '')"
                            rows="3" :error="$errors->first('game_changer_conclusion')"
                            placeholder="ধাপে ধাপে এটি আপনাকে বেসিক থেকে অ্যাডভান্স-এ নিয়ে যায়।"
                            help="Concluding text for the game changer section" />
        </div>
      </div>
    </div>
  </x-card>
</div>

