@extends('layouts.admin')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div x-data="{ activeSection: 'hero' }">
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                @foreach($contents as $section => $items)
                <button 
                    @click="activeSection = '{{ $section }}'"
                    :class="{ 'border-primary-500 text-primary-600': activeSection === '{{ $section }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeSection !== '{{ $section }}' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
                >
                    {{ ucfirst($section) }}
                </button>
                @endforeach
            </nav>
        </div>

        @foreach($contents as $section => $items)
        <div x-show="activeSection === '{{ $section }}'" class="space-y-6">
            @foreach($items as $item)
            <form action="{{ route('admin.frontend-content.update') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-4 rounded-lg">
                @csrf
                <input type="hidden" name="section" value="{{ $item->section }}">
                <input type="hidden" name="key" value="{{ $item->key }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ ucwords(str_replace('_', ' ', $item->key)) }}
                    </label>
                    <p class="text-xs text-gray-500">{{ $item->key }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- English -->
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">English</label>
                        @php $valEn = is_array($item->value) ? ($item->value['en'] ?? '') : $item->value; @endphp
                        
                        @if($item->type === 'image')
                            @if($valEn)
                            <div class="mb-2">
                                <img src="{{ $valEn }}" alt="En" class="h-24 object-cover rounded-lg border">
                            </div>
                            @endif
                            <input type="file" name="value[en]" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        @elseif($item->type === 'textarea')
                            <textarea name="value[en]" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $valEn }}</textarea>
                        @else
                            <input type="text" name="value[en]" value="{{ $valEn }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        @endif
                    </div>

                    <!-- Bengali -->
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Bengali</label>
                         @php $valBn = is_array($item->value) ? ($item->value['bn'] ?? '') : ''; @endphp

                        @if($item->type === 'image')
                             @if($valBn)
                            <div class="mb-2">
                                <img src="{{ $valBn }}" alt="Bn" class="h-24 object-cover rounded-lg border">
                            </div>
                            @endif
                            <input type="file" name="value[bn]" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        @elseif($item->type === 'textarea')
                            <textarea name="value[bn]" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $valBn }}</textarea>
                        @else
                            <input type="text" name="value[bn]" value="{{ $valBn }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        @endif
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-primary-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Save
                    </button>
                </div>
            </form>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
@endsection
