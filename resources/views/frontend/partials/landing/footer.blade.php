<footer class="section-sm" style="background-color: #073050; color: var(--light-text);">
  <div class="container" style="text-align: center;">
    <p style="margin: 0 0 15px; font-size: 0.9rem;">
      © 2024 bookdarponbd | Powered by Nix Software
    </p>

    <div style="margin: 15px 0;">
      <a href="#" style="color: var(--light-text); text-decoration: none; margin: 0 10px; font-size: 0.9rem; opacity: 0.9;">
        Privacy Policy
      </a>
      <a href="#" style="color: var(--light-text); text-decoration: none; margin: 0 10px; font-size: 0.9rem; opacity: 0.9;">
        Terms & Conditions
      </a>
      @php
        $rssFeedUrl = \App\Models\Setting::get('rss_feed_url');
      @endphp
      @if($rssFeedUrl)
        <a href="{{ $rssFeedUrl }}" target="_blank" rel="noopener" style="color: var(--light-text); text-decoration: none; margin: 0 10px; font-size: 0.9rem; opacity: 0.9;">
          RSS Feed
        </a>
      @endif
    </div>

    <div style="margin-top: 15px; font-size: 0.9rem;">
      <p style="margin: 5px 0;">Phone: 0123456789</p>
      <p style="margin: 5px 0;">Email: <a href="mailto:info@darpon.com" style="color: var(--light-text);">info@darpon.com</a></p>
    </div>
  </div>
</footer>
