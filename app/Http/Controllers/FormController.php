<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FormController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Auth::user()->forms()->latest()->get();
        return view('forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('forms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'show_progress_bar' => 'boolean',
            'allow_multiple_responses' => 'boolean',
            'collect_email' => 'boolean',
            'require_email' => 'boolean',
        ]);

        $form = Auth::user()->forms()->create([
            ...$validated,
            'slug' => Str::slug($validated['title']),
        ]);

        return redirect()->route('forms.edit', $form)
            ->with('success', 'Form created successfully. Now add some fields!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        if (!$form->is_published) {
            abort(404);
        }

        return view('forms.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        $this->authorize('update', $form);
        return view('forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        $this->authorize('update', $form);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'show_progress_bar' => 'boolean',
            'allow_multiple_responses' => 'boolean',
            'collect_email' => 'boolean',
            'require_email' => 'boolean',
        ]);

        $form->update([
            ...$validated,
            'slug' => Str::slug($validated['title']),
        ]);

        return redirect()->route('forms.edit', $form)
            ->with('success', 'Form updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $this->authorize('delete', $form);
        $form->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Form deleted successfully.');
    }

    public function publish(Form $form)
    {
        $this->authorize('update', $form);
        $form->update(['is_published' => true]);

        return redirect()->route('forms.edit', $form)
            ->with('success', 'Form published successfully.');
    }

    public function unpublish(Form $form)
    {
        $this->authorize('update', $form);
        $form->update(['is_published' => false]);

        return redirect()->route('forms.edit', $form)
            ->with('success', 'Form unpublished successfully.');
    }

    public function analytics(Form $form)
    {
        $this->authorize('view', $form);

        $totalResponses = $form->responses()->count();
        $responsesByDate = $form->responses()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('forms.analytics', compact('form', 'totalResponses', 'responsesByDate'));
    }

    /**
     * Handle form submission.
     */
    public function submit(Request $request, Form $form)
    {
        if (!$form->is_published) {
            abort(404);
        }

        // Validate email if required
        if ($form->collect_email && $form->require_email) {
            $request->validate([
                'email' => 'required|email',
            ]);
        }

        // Get all form fields
        $fields = $form->fields()->orderBy('order')->get();
        
        // Build validation rules
        $rules = [];
        foreach ($fields as $field) {
            $fieldRules = [];
            
            if ($field->required) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            switch ($field->type) {
                case 'email':
                    $fieldRules[] = 'email';
                    break;
                case 'number':
                    $fieldRules[] = 'numeric';
                    break;
                case 'date':
                    $fieldRules[] = 'date';
                    break;
            }

            $rules["fields.{$field->id}"] = $fieldRules;
        }

        // Validate the submission
        $validated = $request->validate($rules);

        // Transform the data to use field labels as keys
        $responseData = [];
        foreach ($fields as $field) {
            $value = $validated["fields.{$field->id}"] ?? null;
            if ($field->type === 'checkbox' && is_array($value)) {
                $value = implode(', ', $value);
            }
            $responseData[$field->label] = $value;
        }

        // Create the response
        $response = $form->responses()->create([
            'responses' => $responseData,
            'email' => $request->email ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('forms.show', $form)
            ->with('success', 'Form submitted successfully!');
    }
}
