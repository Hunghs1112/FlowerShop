<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    protected $fillable = [
        'id_key',
        'is_active',
        'theme',
        'eyebrow',
        'route',
        'title',
        'text',
        'bullets',
        'start_date',
        'end_date',
        'countdown',
        'countdown_label',
        'image',
        'image_alt',
        'stamp',
        'stamp_sub',
        'cta_label',
        'cta_link',
        'cta2',
        'cta2_label',
        'cta2_link',
        'note',
        'teaser',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'bullets' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'countdown' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        $now = now();
        return $query->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now->toDateString());
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function toLntConfig(): array
    {
        return [
            'id' => $this->id_key,
            'active' => $this->is_active,
            'start' => $this->start_date->format('Y-m-d'),
            'end' => $this->end_date->format('Y-m-d'),
            'theme' => $this->theme,
            'eyebrow' => $this->eyebrow,
            'route' => $this->route,
            'title' => $this->title,
            'text' => $this->text,
            'bullets' => $this->bullets ?? [],
            'countdown' => $this->countdown?->format('Y-m-d\TH:i'),
            'countdownLabel' => $this->countdown_label,
            'image' => $this->image,
            'imageAlt' => $this->image_alt,
            'stamp' => $this->stamp,
            'stampSub' => $this->stamp_sub,
            'ctaLabel' => $this->cta_label,
            'ctaLink' => $this->cta_link,
            'cta2' => $this->cta2,
            'cta2Label' => $this->cta2_label,
            'cta2Link' => $this->cta2_link,
            'note' => $this->note,
            'teaser' => $this->teaser,
        ];
    }
}
