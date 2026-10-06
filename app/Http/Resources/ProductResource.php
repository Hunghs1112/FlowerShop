<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 'name' => $this->name, 'slug' => $this->slug,
            'price' => $this->price, 'formatted_price' => number_format($this->price, 0, ',', '.') . 'đ',
            'short_description' => $this->short_description,
            'image' => $this->productImages->first()?->image_url ?? asset('storage/placeholder.jpg'),
            'secondary_image' => $this->productImages->count() > 1 ? $this->productImages[1]->image_url : null,
            'category' => $this->category?->name,
            'url' => route('products.show', $this->resource),
        ];
    }
}
