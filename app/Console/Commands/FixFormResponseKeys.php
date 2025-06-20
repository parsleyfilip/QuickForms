<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FormResponse;
use App\Models\Form;

class FixFormResponseKeys extends Command
{
    protected $signature = 'fix:form-response-keys';
    protected $description = 'Migrate FormResponse.responses to use field IDs as keys and normalize checkbox values.';

    public function handle()
    {
        $this->info('Starting migration of FormResponse keys...');
        $count = 0;
        foreach (FormResponse::with('form.fields')->cursor() as $response) {
            $form = $response->form;
            if (!$form) continue;
            $fields = $form->fields;
            $data = $response->responses;
            $newData = [];
            foreach ($fields as $field) {
                // Try both ID and label as key
                $value = $data[$field->id] ?? $data[$field->label] ?? null;
                // Normalize checkbox values
                if ($field->type === 'checkbox' && is_string($value)) {
                    $value = array_map('trim', explode(',', $value));
                }
                $newData[$field->id] = $value;
            }
            if ($response->responses !== $newData) {
                $response->responses = $newData;
                $response->save();
                $count++;
            }
        }
        $this->info("Migration complete. Updated $count responses.");
    }
} 