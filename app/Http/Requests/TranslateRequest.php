<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'max:10000'],
            'source' => ['required', 'in:vi,en'],
            'target' => ['required', 'in:vi,en', 'different:source'],
            'existing_translation' => ['nullable', 'string', 'max:10000'],
        ];
    }
}
