<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStockMovementRequest extends FormRequest
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
            'stock_id' => ['required', 'exists:stocks,id'],
            'date' => ['required', 'date'],
            'quantity' => ['required', 'integer', 'min:1'],
            'type' => ['required', 'in:in,out'],
            'reason' => ['nullable', 'string'],
        ];
    }
}
