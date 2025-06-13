<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FormResponseController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except(['store']);
    }

    public function store(Request $request, Form $form)
    {
        if (!$form->is_published) {
            abort(404);
        }

        $validationRules = [];
        foreach ($form->fields as $field) {
            $rules = ['required'];
            if ($field->validation_rules) {
                $rules = array_merge($rules, $field->validation_rules);
            }
            $validationRules[$field->id] = $rules;
        }

        if ($form->collect_email) {
            $validationRules['email'] = ['required', 'email'];
        }

        $validated = $request->validate($validationRules);

        $response = $form->responses()->create([
            'email' => $validated['email'] ?? null,
            'responses' => $validated,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('forms.show', $form)
            ->with('success', 'Thank you for your submission!');
    }

    public function index(Form $form)
    {
        $this->authorize('view', $form);
        $responses = $form->responses()->latest()->paginate(10);

        return view('forms.responses.index', compact('form', 'responses'));
    }

    public function show(Form $form, FormResponse $response)
    {
        $this->authorize('view', $form);
        return view('forms.responses.show', compact('form', 'response'));
    }

    public function destroy(Form $form, FormResponse $response)
    {
        $this->authorize('delete', $form);
        $response->delete();

        return redirect()->route('forms.responses.index', $form)
            ->with('success', 'Response deleted successfully.');
    }

    public function export(Form $form)
    {
        $this->authorize('view', $form);
        $responses = $form->responses()->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $form->title . ' - Responses.csv"',
        ];

        $callback = function() use ($form, $responses) {
            $file = fopen('php://output', 'w');

            // Add headers
            $headers = ['Submitted At'];
            if ($form->collect_email) {
                $headers[] = 'Email';
            }
            foreach ($form->fields as $field) {
                $headers[] = $field->label;
            }
            fputcsv($file, $headers);

            // Add data
            foreach ($responses as $response) {
                $row = [$response->created_at];
                if ($form->collect_email) {
                    $row[] = $response->email;
                }
                foreach ($form->fields as $field) {
                    $row[] = $response->responses[$field->id] ?? '';
                }
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
