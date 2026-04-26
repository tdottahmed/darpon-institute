@extends('layouts.admin')

@section('content')
  <div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Free Class Leads</h1>
        <p class="mt-1 text-sm text-gray-600">People who registered to join a free class</p>
      </div>
      <div class="flex items-center gap-3">
        <span class="rounded-full bg-primary-50 px-3 py-1 text-sm font-semibold text-primary-700">
          {{ $leads->total() }} total
        </span>
      </div>
    </div>

    {{-- Filters --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
      <form method="GET" action="{{ route('admin.free-class-leads.index') }}"
            class="flex flex-col gap-3 p-4 sm:flex-row sm:items-end">
        <div class="flex-1">
          <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Search</label>
          <input type="text" name="search" value="{{ request('search') }}"
                 placeholder="Name, phone or email…"
                 class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
        </div>
        <div class="w-40">
          <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Status</label>
          <select name="status"
                  class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
            <option value="">All statuses</option>
            @foreach (['new' => 'New', 'contacted' => 'Contacted', 'enrolled' => 'Enrolled', 'archived' => 'Archived'] as $val => $label)
              <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="flex gap-2">
          <button type="submit"
                  class="inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Search
          </button>
          @if (request('search') || request('status'))
            <a href="{{ route('admin.free-class-leads.index') }}"
               class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-600 shadow-sm hover:bg-gray-50">
              Clear
            </a>
          @endif
        </div>
      </form>
    </div>

    {{-- Table --}}
    @if ($leads->count() > 0)
      <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Name</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Phone</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Email</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Notes</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Registered</th>
                <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white" x-data="leadManager()">
              @foreach ($leads as $lead)
                <tr class="transition-colors hover:bg-gray-50/70" x-data="{ editingNotes: false }">
                  {{-- Name --}}
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 text-sm font-bold text-primary-700">
                        {{ strtoupper(substr($lead->name, 0, 1)) }}
                      </div>
                      <span class="font-medium text-gray-900">{{ $lead->name }}</span>
                    </div>
                  </td>

                  {{-- Phone --}}
                  <td class="px-5 py-4">
                    <a href="tel:{{ $lead->phone }}" class="text-sm font-mono text-gray-700 hover:text-primary-600">
                      {{ $lead->phone }}
                    </a>
                  </td>

                  {{-- Email --}}
                  <td class="px-5 py-4">
                    @if ($lead->email)
                      <a href="mailto:{{ $lead->email }}"
                         class="text-sm text-gray-600 hover:text-primary-600">{{ $lead->email }}</a>
                    @else
                      <span class="text-xs text-gray-400">—</span>
                    @endif
                  </td>

                  {{-- Status --}}
                  <td class="px-5 py-4">
                    <form method="POST" action="{{ route('admin.free-class-leads.status', $lead) }}">
                      @csrf
                      @method('PATCH')
                      <select name="status" onchange="this.form.submit()"
                              class="rounded-md border-0 py-1 pl-2 pr-7 text-xs font-semibold shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-primary-500
                                {{ match($lead->status) {
                                    'new'       => 'bg-blue-50 text-blue-700 ring-blue-200',
                                    'contacted' => 'bg-amber-50 text-amber-700 ring-amber-200',
                                    'enrolled'  => 'bg-green-50 text-green-700 ring-green-200',
                                    'archived'  => 'bg-gray-100 text-gray-500 ring-gray-200',
                                } }}">
                        <option value="new"       {{ $lead->status === 'new'       ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="enrolled"  {{ $lead->status === 'enrolled'  ? 'selected' : '' }}>Enrolled</option>
                        <option value="archived"  {{ $lead->status === 'archived'  ? 'selected' : '' }}>Archived</option>
                      </select>
                    </form>
                  </td>

                  {{-- Notes --}}
                  <td class="px-5 py-4">
                    <div x-show="!editingNotes" @click="editingNotes = true"
                         class="max-w-xs cursor-text truncate text-sm text-gray-500 hover:text-gray-700"
                         title="{{ $lead->notes }}">
                      {{ $lead->notes ?: '+ Add note' }}
                    </div>
                    <form x-show="editingNotes" method="POST"
                          action="{{ route('admin.free-class-leads.notes', $lead) }}"
                          class="flex items-center gap-2">
                      @csrf
                      @method('PATCH')
                      <input type="text" name="notes" value="{{ $lead->notes }}"
                             class="w-44 rounded border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500"
                             placeholder="Add a note…"
                             x-ref="notesInput"
                             x-init="$watch('editingNotes', v => { if(v) $nextTick(() => $refs.notesInput.focus()) })">
                      <button type="submit" class="text-xs font-semibold text-primary-600 hover:text-primary-700">Save</button>
                      <button type="button" @click="editingNotes = false"
                              class="text-xs text-gray-400 hover:text-gray-600">✕</button>
                    </form>
                  </td>

                  {{-- Date --}}
                  <td class="px-5 py-4">
                    <span class="text-xs text-gray-400" title="{{ $lead->created_at }}">
                      {{ $lead->created_at->diffForHumans() }}
                    </span>
                  </td>

                  {{-- Actions --}}
                  <td class="px-5 py-4 text-right">
                    <form method="POST" action="{{ route('admin.free-class-leads.destroy', $lead) }}"
                          onsubmit="return confirm('Delete this lead? This cannot be undone.')">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="rounded-lg p-1.5 text-gray-400 transition-colors hover:bg-red-50 hover:text-red-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if ($leads->hasPages())
          <div class="border-t border-gray-100 px-5 py-4">
            {{ $leads->links() }}
          </div>
        @endif
      </div>
    @else
      <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 bg-white py-16 text-center">
        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100">
          <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <p class="text-base font-semibold text-gray-700">No leads yet</p>
        <p class="mt-1 text-sm text-gray-400">Free class registrations will appear here.</p>
      </div>
    @endif

  </div>

  <script>
    function leadManager() {
      return {};
    }
  </script>
@endsection
