<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title','title_bn','slug','description','description_bn','image',
        'event_date','end_date','time','start_time','end_time',
        'venue','venue_bn','age_limit','expected_guests',
        'organizer','organizer_bn','is_published',
    ];

    protected $casts = [
        'event_date'     => 'date',
        'end_date'       => 'date',
        'is_published'   => 'boolean',
    ];

    // Scopes (from events-hub pattern)
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString());
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Computed attributes (inspired by events-hub old_event/new_event)
    protected function isUpcoming(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->event_date?->isFuture() ?? false
        );
    }

    protected function isPast(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->event_date?->isPast() ?? false
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
