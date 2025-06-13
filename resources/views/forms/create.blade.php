@extends('layouts.app')

@section('title', 'Create Form - QuickForms')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold">Create New Form</h2>
                    <p class="mt-1 text-sm text-gray-500">Customize your form's appearance and behavior.</p>
                </div>

                <form action="{{ route('forms.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Form Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="theme_color" class="block text-sm font-medium text-gray-700">Theme Color</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="color" name="theme_color" id="theme_color" value="{{ old('theme_color', '#4F46E5') }}"
                                    class="h-10 w-20 rounded-l-md border-gray-300">
                                <input type="text" value="{{ old('theme_color', '#4F46E5') }}"
                                    class="flex-1 min-w-0 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    readonly>
                            </div>
                        </div>

                        <div>
                            <label for="background_color" class="block text-sm font-medium text-gray-700">Background Color</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="color" name="background_color" id="background_color" value="{{ old('background_color', '#FFFFFF') }}"
                                    class="h-10 w-20 rounded-l-md border-gray-300">
                                <input type="text" value="{{ old('background_color', '#FFFFFF') }}"
                                    class="flex-1 min-w-0 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    readonly>
                            </div>
                        </div>

                        <div>
                            <label for="button_color" class="block text-sm font-medium text-gray-700">Button Color</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="color" name="button_color" id="button_color" value="{{ old('button_color', '#4F46E5') }}"
                                    class="h-10 w-20 rounded-l-md border-gray-300">
                                <input type="text" value="{{ old('button_color', '#4F46E5') }}"
                                    class="flex-1 min-w-0 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    readonly>
                            </div>
                        </div>

                        <div>
                            <label for="button_text_color" class="block text-sm font-medium text-gray-700">Button Text Color</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="color" name="button_text_color" id="button_text_color" value="{{ old('button_text_color', '#FFFFFF') }}"
                                    class="h-10 w-20 rounded-l-md border-gray-300">
                                <input type="text" value="{{ old('button_text_color', '#FFFFFF') }}"
                                    class="flex-1 min-w-0 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="show_progress_bar" id="show_progress_bar" value="1"
                                {{ old('show_progress_bar', true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="show_progress_bar" class="ml-2 block text-sm text-gray-900">Show progress bar</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="allow_multiple_responses" id="allow_multiple_responses" value="1"
                                {{ old('allow_multiple_responses', true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="allow_multiple_responses" class="ml-2 block text-sm text-gray-900">Allow multiple responses</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="collect_email" id="collect_email" value="1"
                                {{ old('collect_email') ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="collect_email" class="ml-2 block text-sm text-gray-900">Collect email addresses</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="require_email" id="require_email" value="1"
                                {{ old('require_email') ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="require_email" class="ml-2 block text-sm text-gray-900">Require email address</label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('forms.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Create Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update text input when color input changes
    document.querySelectorAll('input[type="color"]').forEach(input => {
        input.addEventListener('input', function() {
            this.nextElementSibling.value = this.value;
        });
    });
</script>
@endpush
@endsection 