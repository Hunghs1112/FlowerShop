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
        'eyebrow_en',
        'route',
        'title',
        'title_en',
        'text',
        'text_en',
        'bullets',
        'bullets_en',
        'start_date',
        'end_date',
        'countdown',
        'countdown_label',
        'countdown_label_en',
        'image',
        'image_alt',
        'image_alt_en',
        'stamp',
        'stamp_sub',
        'stamp_sub_en',
        'cta_label',
        'cta_label_en',
        'cta_link',
        'cta2',
        'cta2_label',
        'cta2_label_en',
        'cta2_link',
        'note',
        'note_en',
        'teaser',
        'teaser_en',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'bullets' => 'array',
        'bullets_en' => 'array',
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
        $localized = fn (string $field) => app()->getLocale() === 'en' && filled($this->{$field.'_en'})
            ? $this->{$field.'_en'}
            : $this->{$field};
        $link = fn (?string $url) => app()->getLocale() === 'en' && str_starts_with((string) $url, '/') && ! str_starts_with((string) $url, '/en/')
            ? '/en'.$url
            : $url;

        return [
            'id' => $this->id_key,
            'active' => $this->is_active,
            'start' => $this->start_date->format('Y-m-d'),
            'end' => $this->end_date->format('Y-m-d'),
            'theme' => $this->theme,
            'eyebrow' => $localized('eyebrow'),
            'route' => $this->route,
            'title' => $localized('title'),
            'text' => $localized('text'),
            'bullets' => $localized('bullets') ?? [],
            'countdown' => $this->countdown?->format('Y-m-d\TH:i'),
            'countdownLabel' => $localized('countdown_label'),
            'image' => $this->image,
            'imageAlt' => $localized('image_alt'),
            'stamp' => $this->stamp,
            'stampSub' => $localized('stamp_sub'),
            'ctaLabel' => $localized('cta_label'),
            'ctaLink' => $link($this->cta_link),
            'cta2' => $this->cta2,
            'cta2Label' => $localized('cta2_label'),
            'cta2Link' => $link($this->cta2_link),
            'note' => $localized('note'),
            'teaser' => $localized('teaser'),
        ];
    }
}
