@extends('layouts.app')

@section('title', $form->title . ' - QuickForms')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $form->title }}</h1>
                    @if($form->description)
                        <p class="mt-2 text-gray-600">{{ $form->description }}</p>
                    @endif
                </div>

                @if(session('success'))
                    <div class="mb-6 rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('forms.submit', $form) }}" method="POST" class="space-y-6">
                    @csrf

                    @if($form->show_progress_bar)
                        <div class="mb-8">
                            <div class="relative">
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                    <div class="w-0 shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-500" id="progress-bar"></div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($form->collect_email)
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                {{ $form->require_email ? 'required' : '' }}>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    @foreach($form->fields as $field)
                        <div>
                            <label for="field_{{ $field->id }}" class="block text-sm font-medium text-gray-700">
                                {{ $field->label }}
                                @if($field->required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>

                            @switch($field->type)
                                @case('text')
                                    <input type="text" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}"
                                        value="{{ old("fields.{$field->id}") }}"
                                        placeholder="{{ $field->placeholder }}"
                                        {{ $field->required ? 'required' : '' }}
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @break

                                @case('textarea')
                                    <textarea name="fields[{{ $field->id }}]" id="field_{{ $field->id }}"
                                        rows="3"
                                        placeholder="{{ $field->placeholder }}"
                                        {{ $field->required ? 'required' : '' }}
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old("fields.{$field->id}") }}</textarea>
                                    @break

                                @case('select')
                                    <select name="fields[{{ $field->id }}]" id="field_{{ $field->id }}"
                                        {{ $field->required ? 'required' : '' }}
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Select an option</option>
                                        @foreach($field->options as $option)
                                            <option value="{{ $option }}" {{ old("fields.{$field->id}") == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @break

                                @case('radio')
                                    <div class="mt-2 space-y-2">
                                        @foreach($field->options as $option)
                                            <div class="flex items-center">
                                                <input type="radio" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}_{{ $loop->index }}"
                                                    value="{{ $option }}"
                                                    {{ old("fields.{$field->id}") == $option ? 'checked' : '' }}
                                                    {{ $field->required ? 'required' : '' }}
                                                    class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label for="field_{{ $field->id }}_{{ $loop->index }}" class="ml-3 block text-sm text-gray-700">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @break

                                @case('checkbox')
                                    <div class="mt-2 space-y-2">
                                        @foreach($field->options as $option)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="fields[{{ $field->id }}][]" id="field_{{ $field->id }}_{{ $loop->index }}"
                                                    value="{{ $option }}"
                                                    {{ in_array($option, old("fields.{$field->id}", [])) ? 'checked' : '' }}
                                                    {{ $field->required ? 'required' : '' }}
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label for="field_{{ $field->id }}_{{ $loop->index }}" class="ml-3 block text-sm text-gray-700">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @break

                                @case('email')
                                    <input type="email" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}"
                                        value="{{ old("fields.{$field->id}") }}"
                                        placeholder="{{ $field->placeholder }}"
                                        {{ $field->required ? 'required' : '' }}
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @break

                                @case('number')
                                    <input type="number" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}"
                                        value="{{ old("fields.{$field->id}") }}"
                                        placeholder="{{ $field->placeholder }}"
                                        {{ $field->required ? 'required' : '' }}
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @break

                                @case('date')
                                    <input type="date" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}"
                                        value="{{ old("fields.{$field->id}") }}"
                                        {{ $field->required ? 'required' : '' }}
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @break
                            @endswitch

                            @error("fields.{$field->id}")
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($form->show_progress_bar)
    @push('scripts')
    <script>
        const form = document.querySelector('form');
        const progressBar = document.getElementById('progress-bar');
        const requiredFields = form.querySelectorAll('[required]');
        const totalFields = requiredFields.length;

        function updateProgress() {
            const filledFields = Array.from(requiredFields).filter(field => field.value.trim() !== '').length;
            const progress = (filledFields / totalFields) * 100;
            progressBar.style.width = `${progress}%`;
        }

        requiredFields.forEach(field => {
            field.addEventListener('input', updateProgress);
        });

        // Initial progress check
        updateProgress();
    </script>
    @endpush
@endif
@endsection 