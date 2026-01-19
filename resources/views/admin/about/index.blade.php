@extends('layouts.admin')

@section('content')
<div class="rounded-lg bg-white p-6 shadow">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">About Us Page Management</h1>
        <p class="mt-1 text-sm text-gray-600">Update the content of your About Us page</p>
    </div>

    @if (session('success'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.about.update') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Page Title -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Page Title (English)</label>
                <input type="text" name="page_title[en]"
                    value="{{ old('page_title.en', $contents['page_title']->value['en'] ?? '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Page Title (Bengali)</label>
                <input type="text" name="page_title[bn]"
                    value="{{ old('page_title.bn', $contents['page_title']->value['bn'] ?? '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
        </div>

        <!-- Page Subtitle -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Page Subtitle (English)</label>
                <textarea name="page_subtitle[en]" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('page_subtitle.en', $contents['page_subtitle']->value['en'] ?? '') }}</textarea>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Page Subtitle (Bengali)</label>
                <textarea name="page_subtitle[bn]" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('page_subtitle.bn', $contents['page_subtitle']->value['bn'] ?? '') }}</textarea>
            </div>
        </div>

          <!-- Main Content (Already Existing) -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Main Content (English)</label>
                <div id="editor-en" class="h-72 rounded-md bg-white"></div>
                <input type="hidden" name="content[en]" id="content-en"
                    value="{{ old('content.en', $contents['content']->value['en'] ?? '') }}">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Main Content (Bengali)</label>
                <div id="editor-bn" class="h-72 rounded-md bg-white"></div>
                <input type="hidden" name="content[bn]" id="content-bn"
                    value="{{ old('content.bn', $contents['content']->value['bn'] ?? '') }}">
            </div>
        </div>


        <div class="border-t border-gray-200 pt-6 pb-10"></div>

        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-900">Sidebar Content</h2>
            <p class="mt-1 text-sm text-gray-600">Manage the "Join Our Community" sidebar section.</p>
        </div>

        <!-- Sidebar Title -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Sidebar Title (English)</label>
                <input type="text" name="sidebar_title[en]"
                    value="{{ old('sidebar_title.en', $contents['sidebar_title']->value['en'] ?? '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Sidebar Title (Bengali)</label>
                <input type="text" name="sidebar_title[bn]"
                    value="{{ old('sidebar_title.bn', $contents['sidebar_title']->value['bn'] ?? '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
        </div>

        <!-- Sidebar Item 1 -->
        <div class="rounded-lg bg-gray-50 p-4 border border-gray-200">
            <h3 class="mb-4 text-sm font-bold uppercase text-gray-500">Item 1</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title (English)</label>
                        <input type="text" name="sidebar_item_1_title[en]"
                            value="{{ old('sidebar_item_1_title.en', $contents['sidebar_item_1_title']->value['en'] ?? '') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description (English)</label>
                        <textarea name="sidebar_item_1_text[en]" rows="2"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('sidebar_item_1_text.en', $contents['sidebar_item_1_text']->value['en'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title (Bengali)</label>
                        <input type="text" name="sidebar_item_1_title[bn]"
                            value="{{ old('sidebar_item_1_title.bn', $contents['sidebar_item_1_title']->value['bn'] ?? '') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description (Bengali)</label>
                        <textarea name="sidebar_item_1_text[bn]" rows="2"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('sidebar_item_1_text.bn', $contents['sidebar_item_1_text']->value['bn'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Item 2 -->
        <div class="rounded-lg bg-gray-50 p-4 border border-gray-200">
            <h3 class="mb-4 text-sm font-bold uppercase text-gray-500">Item 2</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                 <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title (English)</label>
                        <input type="text" name="sidebar_item_2_title[en]"
                            value="{{ old('sidebar_item_2_title.en', $contents['sidebar_item_2_title']->value['en'] ?? '') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description (English)</label>
                        <textarea name="sidebar_item_2_text[en]" rows="2"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('sidebar_item_2_text.en', $contents['sidebar_item_2_text']->value['en'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title (Bengali)</label>
                        <input type="text" name="sidebar_item_2_title[bn]"
                            value="{{ old('sidebar_item_2_title.bn', $contents['sidebar_item_2_title']->value['bn'] ?? '') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description (Bengali)</label>
                        <textarea name="sidebar_item_2_text[bn]" rows="2"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('sidebar_item_2_text.bn', $contents['sidebar_item_2_text']->value['bn'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Item 3 -->
        <div class="rounded-lg bg-gray-50 p-4 border border-gray-200">
            <h3 class="mb-4 text-sm font-bold uppercase text-gray-500">Item 3</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                 <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title (English)</label>
                        <input type="text" name="sidebar_item_3_title[en]"
                            value="{{ old('sidebar_item_3_title.en', $contents['sidebar_item_3_title']->value['en'] ?? '') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description (English)</label>
                        <textarea name="sidebar_item_3_text[en]" rows="2"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('sidebar_item_3_text.en', $contents['sidebar_item_3_text']->value['en'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title (Bengali)</label>
                        <input type="text" name="sidebar_item_3_title[bn]"
                            value="{{ old('sidebar_item_3_title.bn', $contents['sidebar_item_3_title']->value['bn'] ?? '') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description (Bengali)</label>
                        <textarea name="sidebar_item_3_text[bn]" rows="2"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('sidebar_item_3_text.bn', $contents['sidebar_item_3_text']->value['bn'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

      

        <div class="flex justify-end pt-8 pb-10">
            <button type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 px-6 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Save Changes
            </button>
        </div>
    </form>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill for English
        const quillEn = new Quill('#editor-en', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });
        
        // Load initial content
        const contentEnInput = document.getElementById('content-en');
        if (contentEnInput.value) {
            quillEn.root.innerHTML = contentEnInput.value;
        }

        // Update hidden input on change
        quillEn.on('text-change', function() {
            contentEnInput.value = quillEn.root.innerHTML;
        });

        // Initialize Quill for Bengali
        const quillBn = new Quill('#editor-bn', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

         // Load initial content
        const contentBnInput = document.getElementById('content-bn');
        if (contentBnInput.value) {
            quillBn.root.innerHTML = contentBnInput.value;
        }

        // Update hidden input on change
        quillBn.on('text-change', function() {
            contentBnInput.value = quillBn.root.innerHTML;
        });
    });
</script>
@endpush
@endsection
