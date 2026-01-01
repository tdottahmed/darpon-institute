<!-- PDF Preview Tab -->
<div x-show="activeTab === 'pdf'" class="space-y-6">
  <x-card variant="elevated">
    <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
      <h2 class="text-lg font-medium text-gray-900">PDF Preview Section</h2>
      <p class="text-sm text-gray-500">PDF preview cards with images and links for book previews</p>
    </div>

    <div class="space-y-4">
      <label class="block text-sm font-medium text-gray-700">PDF Previews (JSON Format)</label>
      <textarea name="pdf_previews" rows="15"
                class="block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                placeholder='[
  {
    "image": "https://example.com/preview1.png",
    "pdf_url": "https://example.com/book1.pdf",
    "title": "Preview 1"
  },
  {
    "image": "https://example.com/preview2.png",
    "pdf_url": "https://example.com/book2.pdf",
    "title": "Preview 2"
  }
]'>{{ old('pdf_previews', isset($landingPage) && $landingPage->pdf_previews ? json_encode($landingPage->pdf_previews, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
      
      <div class="rounded-md bg-blue-50 p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">JSON Format Instructions</h3>
            <div class="mt-2 text-sm text-blue-700">
              <ul class="list-disc space-y-1 pl-5">
                <li><strong>image:</strong> URL to the preview image (required)</li>
                <li><strong>pdf_url:</strong> URL to the PDF file or link (required)</li>
                <li><strong>title:</strong> Display title for the preview (optional)</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      
      <x-forms.error :message="$errors->first('pdf_previews')" />
    </div>
  </x-card>
</div>

