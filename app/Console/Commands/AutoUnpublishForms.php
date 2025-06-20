<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Form;
use Carbon\Carbon;

class AutoUnpublishForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forms:auto-unpublish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically unpublish forms whose auto_unpublish_at is in the past.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $forms = Form::where('is_published', true)
            ->whereNotNull('auto_unpublish_at')
            ->where('auto_unpublish_at', '<=', $now)
            ->get();

        foreach ($forms as $form) {
            $form->is_published = false;
            $form->save();
            $this->info("Form ID {$form->id} unpublished.");
        }

        $this->info('Auto-unpublish process completed.');
    }
} 