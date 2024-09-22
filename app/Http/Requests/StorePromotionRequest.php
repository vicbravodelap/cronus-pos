<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|max:255|unique:promotions',
            'type' => 'required|string|in:fixed,percentage',
            'value' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($this->input('type') === 'percentage' && ($value < 1 || $value > 100)) {
                        $fail('El valor debe estar entre 1 y 100 cuando el tipo es porcentaje.');
                    }
                },
            ],
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'applicable_models.*' => 'required|string|in:' . implode(',', array_keys(\App\Models\Promotion::$availableModels)),
        ];
    }
}
