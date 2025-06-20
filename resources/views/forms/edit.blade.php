@extends('layouts.app')

@section('title', 'Edit Form - QuickForms')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold">Edit Form</h2>
                        <p class="mt-1 text-sm text-gray-500">Customize your form and add fields.</p>
                    </div>
                    <div class="flex space-x-3">
                        @if($form->is_published)
                            <a href="{{ route('forms.show', $form->id) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Form
                            </a>
                            <form action="{{ route('forms.unpublish', $form) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Unpublish
                                </button>
                            </form>
                        @else
                            <form action="{{ route('forms.publish', $form) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Publish
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('forms.analytics', $form) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Analytics
                        </a>
                    </div>
                </div>

                <form action="{{ route('forms.update', $form) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Form Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $form->title) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $form->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="auto_unpublish_at" class="block text-sm font-medium text-gray-700">Auto Unpublish At (optional)</label>
                        <input type="datetime-local" name="auto_unpublish_at" id="auto_unpublish_at"
                            value="{{ old('auto_unpublish_at', $form->auto_unpublish_at ? $form->auto_unpublish_at->format('Y-m-d\TH:i') : '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Set a date and time to automatically unpublish this form. Leave blank to keep published indefinitely.</p>
                        @error('auto_unpublish_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="show_progress_bar" id="show_progress_bar" value="1"
                                {{ old('show_progress_bar', $form->show_progress_bar) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="show_progress_bar" class="ml-2 block text-sm text-gray-900">Show progress bar</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="allow_multiple_responses" id="allow_multiple_responses" value="1"
                                {{ old('allow_multiple_responses', $form->allow_multiple_responses) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="allow_multiple_responses" class="ml-2 block text-sm text-gray-900">Allow multiple responses</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="collect_email" id="collect_email" value="1"
                                {{ old('collect_email', $form->collect_email) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="collect_email" class="ml-2 block text-sm text-gray-900">Collect email addresses</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="require_email" id="require_email" value="1"
                                {{ old('require_email', $form->require_email) ? 'checked' : '' }}
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
                            Save Changes
                        </button>
                    </div>
                </form>

                <div class="mt-12">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Form Fields</h3>
                            <p class="mt-1 text-sm text-gray-500">Add and manage the fields that will appear in your form. You can add various types of fields like text, checkboxes, radio buttons, and more.</p>
                        </div>
                        <button type="button" id="add-field-button"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Add Field
                        </button>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Available Field Types:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><span class="font-medium">Text:</span> Single line text input</li>
                            <li><span class="font-medium">Text Area:</span> Multi-line text input</li>
                            <li><span class="font-medium">Select:</span> Dropdown menu with options</li>
                            <li><span class="font-medium">Radio:</span> Multiple choice with one selection</li>
                            <li><span class="font-medium">Checkbox:</span> Multiple choice with multiple selections</li>
                            <li><span class="font-medium">Email:</span> Email address input with validation</li>
                            <li><span class="font-medium">Number:</span> Numeric input with validation</li>
                            <li><span class="font-medium">Date:</span> Date picker</li>
                        </ul>
                    </div>

                    <div id="form-fields" class="space-y-4">
                        @foreach($form->fields as $field)
                            <div class="bg-white border rounded-lg p-4" data-field-id="{{ $field->id }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $field->label }}</h4>
                                        <p class="mt-1 text-sm text-gray-500">{{ ucfirst($field->type) }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="button" onclick="editField({{ $field->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <button type="button" onclick="deleteField({{ $field->id }})"
                                            class="text-red-600 hover:text-red-900">Delete</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Field Modal -->
<div id="field-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Add Field</h3>
                    <form id="field-form" class="mt-4 space-y-4">
                        <input type="hidden" id="field-id" name="id">
                        @csrf

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Field Type</label>
                            <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="text">Text</option>
                                <option value="textarea">Text Area</option>
                                <option value="select">Select</option>
                                <option value="radio">Radio</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="email">Email</option>
                                <option value="number">Number</option>
                                <option value="date">Date</option>
                            </select>
                        </div>

                        <div>
                            <label for="label" class="block text-sm font-medium text-gray-700">Label</label>
                            <input type="text" name="label" id="label" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="placeholder" class="block text-sm font-medium text-gray-700">Placeholder</label>
                            <input type="text" name="placeholder" id="placeholder" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div id="options-container" class="hidden">
                            <label for="options" class="block text-sm font-medium text-gray-700">Options</label>
                            <div id="options-list" class="mt-2 space-y-2">
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="options[]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-900">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addOption()" class="mt-2 inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Option
                            </button>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="required" id="required" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="required" class="ml-2 block text-sm text-gray-900">Required field</label>
                        </div>
                    </form>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                    <button type="button" onclick="saveField()" class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">
                        Save
                    </button>
                    <button type="button" onclick="closeFieldModal()" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Open modal
    function openAddFieldModal() {
        console.log('Opening modal...');
        const modal = document.getElementById('field-modal');
        if (!modal) {
            console.error('Modal element not found');
            return;
        }
        modal.classList.remove('hidden');
        document.getElementById('field-form').reset();
        document.getElementById('field-id').value = '';
        document.getElementById('modal-title').textContent = 'Add Field';
    }

    // Close modal
    function closeFieldModal() {
        const modal = document.getElementById('field-modal');
        modal.classList.add('hidden');
    }

    // Add option
    function addOption() {
        const optionsList = document.getElementById('options-list');
        const optionDiv = document.createElement('div');
        optionDiv.className = 'flex items-center space-x-2';
        optionDiv.innerHTML = `
            <input type="text" name="options[]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-900">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
        optionsList.appendChild(optionDiv);
    }

    // Remove option
    function removeOption(button) {
        button.closest('div').remove();
    }

    // Show/hide options based on field type
    document.getElementById('type').addEventListener('change', function() {
        const optionsContainer = document.getElementById('options-container');
        if (['select', 'radio', 'checkbox'].includes(this.value)) {
            optionsContainer.classList.remove('hidden');
        } else {
            optionsContainer.classList.add('hidden');
        }
    });

    // Save field
    function saveField() {
        const form = document.getElementById('field-form');
        const formData = new FormData(form);
        
        // Convert required checkbox to boolean
        const requiredCheckbox = form.querySelector('[name="required"]');
        formData.delete('required'); // Remove the old value
        formData.append('required', requiredCheckbox.checked ? '1' : '0'); // Add as string '1' or '0'
        
        // Set order to the current number of fields + 1
        const fieldId = document.getElementById('field-id').value;
        const url = fieldId ? `/forms/{{ $form->id }}/fields/${fieldId}` : `/forms/{{ $form->id }}/fields`;
        const method = fieldId ? 'PUT' : 'POST';

        if (!fieldId) {
            // Only set order for new fields
            const currentFields = document.querySelectorAll('#form-fields > div').length;
            formData.set('order', currentFields + 1);
        }

        // Handle options for select, radio, and checkbox fields
        const type = formData.get('type');
        if (['select', 'radio', 'checkbox'].includes(type)) {
            const options = [];
            formData.getAll('options[]').forEach(option => {
                if (option.trim()) {
                    options.push(option.trim());
                }
            });
            formData.delete('options[]');
            // Send options as an array
            options.forEach((option, index) => {
                formData.append(`options[${index}]`, option);
            });
        }

        fetch(url, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'An error occurred');
                });
            }
            return response.json();
        })
        .then(data => {
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'An error occurred while saving the field');
        });
    }

    // Edit field
    function editField(fieldId) {
        fetch(`/forms/{{ $form->id }}/fields/${fieldId}`)
            .then(response => response.json())
            .then(field => {
                const form = document.getElementById('field-form');
                form.querySelector('[name="type"]').value = field.type;
                form.querySelector('[name="label"]').value = field.label;
                form.querySelector('[name="placeholder"]').value = field.placeholder || '';
                form.querySelector('[name="required"]').checked = field.required;
                document.getElementById('field-id').value = field.id;
                document.getElementById('modal-title').textContent = 'Edit Field';

                // Handle options
                const optionsContainer = document.getElementById('options-container');
                const optionsList = document.getElementById('options-list');
                optionsList.innerHTML = '';
                if (['select', 'radio', 'checkbox'].includes(field.type)) {
                    optionsContainer.classList.remove('hidden');
                    if (field.options && field.options.length > 0) {
                        field.options.forEach(option => {
                            const optionDiv = document.createElement('div');
                            optionDiv.className = 'flex items-center space-x-2';
                            optionDiv.innerHTML = `
                                <input type="text" name="options[]" value="${option}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-900">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            `;
                            optionsList.appendChild(optionDiv);
                        });
                    } else {
                        addOption();
                    }
                } else {
                    optionsContainer.classList.add('hidden');
                }

                openAddFieldModal();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while loading the field');
            });
    }

    // Delete field
    function deleteField(fieldId) {
        if (!confirm('Are you sure you want to delete this field?')) {
            return;
        }

        fetch(`/forms/{{ $form->id }}/fields/${fieldId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete field');
            }
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the field');
        });
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded');
        const addFieldButton = document.getElementById('add-field-button');
        if (addFieldButton) {
            console.log('Add field button found');
            addFieldButton.addEventListener('click', function() {
                console.log('Add field button clicked');
                openAddFieldModal();
            });
        } else {
            console.error('Add field button not found');
        }
    });
</script>
@endpush
@endsection 