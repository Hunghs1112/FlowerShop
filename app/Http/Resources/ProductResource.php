<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->display_name,
            'slug' => $this->display_slug,
            'price' => $this->price,
            'formatted_price' => number_format((float) $this->price, 0, ',', '.').'đ',
            'short_description' => $this->display_short_description,
            'image' => $this->getPrimaryImageUrl(),
            'url' => localized_route('products.show', $this->display_slug),
        ];
    }
}
