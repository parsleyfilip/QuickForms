<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class FormFieldController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Form $form)
    {
        $this->authorize('update', $form);

        $validated = $request->validate([
            'type' => 'required|string|in:text,textarea,select,radio,checkbox,email,number,date',
            'label' => 'required|string|max:255',
            'placeholder' => 'nullable|string|max:255',
            'options' => 'nullable|array',
            'required' => 'boolean',
            'validation_rules' => 'nullable|array',
            'order' => 'integer',
        ]);

        $field = $form->fields()->create($validated);

        return response()->json($field);
    }

    public function update(Request $request, Form $form, FormField $field)
    {
        $this->authorize('update', $form);

        $validated = $request->validate([
            'type' => 'required|string|in:text,textarea,select,radio,checkbox,email,number,date',
            'label' => 'required|string|max:255',
            'placeholder' => 'nullable|string|max:255',
            'options' => 'nullable|array',
            'required' => 'boolean',
            'validation_rules' => 'nullable|array',
            'order' => 'integer',
        ]);

        $field->update($validated);

        return response()->json($field);
    }

    public function destroy(Form $form, FormField $field)
    {
        $this->authorize('update', $form);
        $field->delete();

        return response()->json(['message' => 'Field deleted successfully']);
    }

    public function reorder(Request $request, Form $form)
    {
        $this->authorize('update', $form);

        $validated = $request->validate([
            'fields' => 'required|array',
            'fields.*.id' => 'required|exists:form_fields,id',
            'fields.*.order' => 'required|integer|min:0',
        ]);

        foreach ($validated['fields'] as $field) {
            FormField::where('id', $field['id'])
                ->where('form_id', $form->id)
                ->update(['order' => $field['order']]);
        }

        return response()->json(['message' => 'Fields reordered successfully']);
    }

    public function show(Form $form, FormField $field)
    {
        $this->authorize('update', $form);
        return response()->json($field);
    }
}
