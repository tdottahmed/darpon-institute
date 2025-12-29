@php
  $toasts = [];
  if (session('status')) {
      $toasts[] = ['id' => uniqid(), 'type' => 'success', 'message' => session('status')];
  }
  if (session('success')) {
      $toasts[] = ['id' => uniqid(), 'type' => 'success', 'message' => session('success')];
  }
  if (session('error')) {
      $toasts[] = ['id' => uniqid(), 'type' => 'error', 'message' => session('error')];
  }
  if (session('warning')) {
      $toasts[] = ['id' => uniqid(), 'type' => 'warning', 'message' => session('warning')];
  }
  if (session('info')) {
      $toasts[] = ['id' => uniqid(), 'type' => 'info', 'message' => session('info')];
  }
@endphp

@if (count($toasts) > 0)
  <div aria-live="assertive" class="pointer-events-none fixed inset-0 z-50 flex items-end px-4 py-6 sm:items-start sm:p-6"
       x-data="{
           toasts: @js($toasts),
           removeToast(id) {
               this.toasts = this.toasts.filter(t => t.id !== id);
           }
       }" x-init="toasts.forEach((toast) => {
           setTimeout(() => {
               removeToast(toast.id);
           }, 5000);
       });">
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
      <template x-for="toast in toasts" :key="toast.id">
        <div x-show="true" x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
             class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg border shadow-lg ring-1 ring-black ring-opacity-5"
             :class="{
                 'bg-green-50 border-green-200': toast.type === 'success',
                 'bg-red-50 border-red-200': toast.type === 'error',
                 'bg-yellow-50 border-yellow-200': toast.type === 'warning',
                 'bg-blue-50 border-blue-200': toast.type === 'info'
             }">
          <!-- Progress Bar -->
          <div class="h-1 bg-gray-200">
            <div class="h-full transition-all duration-[5000ms] ease-linear"
                 :class="{
                     'bg-green-400': toast.type === 'success',
                     'bg-red-400': toast.type === 'error',
                     'bg-yellow-400': toast.type === 'warning',
                     'bg-blue-400': toast.type === 'info'
                 }"
                 x-init="setTimeout(() => {
                     $el.style.width = '0%';
                 }, 100);
                 $el.style.width = '100%';"></div>
          </div>
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <!-- Success Icon -->
                <svg x-show="toast.type === 'success'" class="h-6 w-6 text-green-400" fill="currentColor"
                     viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <!-- Error Icon -->
                <svg x-show="toast.type === 'error'" class="h-6 w-6 text-red-400" fill="currentColor"
                     viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <!-- Warning Icon -->
                <svg x-show="toast.type === 'warning'" class="h-6 w-6 text-yellow-400" fill="currentColor"
                     viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <!-- Info Icon -->
                <svg x-show="toast.type === 'info'" class="h-6 w-6 text-blue-400" fill="currentColor"
                     viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium"
                   :class="{
                       'text-green-800': toast.type === 'success',
                       'text-red-800': toast.type === 'error',
                       'text-yellow-800': toast.type === 'warning',
                       'text-blue-800': toast.type === 'info'
                   }"
                   x-text="toast.message"></p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button @click="removeToast(toast.id)"
                        class="inline-flex rounded-md transition-opacity hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        :class="{
                            'bg-green-50 text-green-800 focus:ring-green-500': toast.type === 'success',
                            'bg-red-50 text-red-800 focus:ring-red-500': toast.type === 'error',
                            'bg-yellow-50 text-yellow-800 focus:ring-yellow-500': toast.type === 'warning',
                            'bg-blue-50 text-blue-800 focus:ring-blue-500': toast.type === 'info'
                        }">
                  <span class="sr-only">Close</span>
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
@endif
