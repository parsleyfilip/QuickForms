<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'is_published',
        'theme_color',
        'background_color',
        'button_color',
        'button_text_color',
        'show_progress_bar',
        'allow_multiple_responses',
        'collect_email',
        'require_email',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_progress_bar' => 'boolean',
        'allow_multiple_responses' => 'boolean',
        'collect_email' => 'boolean',
        'require_email' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class)->orderBy('order');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(FormResponse::class);
    }

    public function getPublicUrlAttribute(): string
    {
        return route('forms.show', $this->slug);
    }

    public function getResponseCountAttribute(): int
    {
        return $this->responses()->count();
    }

    public function getFieldsCountAttribute(): int
    {
        return $this->fields()->count();
    }
}
