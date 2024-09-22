<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePromotionAssignmentRequest extends FormRequest
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
        $rules = [
            'promotion_id' => 'required|exists:promotions,id',
        ];

        foreach ($this->input() as $key => $value) {
            if (str_ends_with($key, '_ids')) {
                $tableName = strtolower(str_replace('_ids', '', $key)) . 's';
                $rules[$key] = 'array';
                $rules["{$key}.*"] = [
                    'required',
                    function ($attribute, $value, $fail) use ($tableName) {
                        if ($value !== 'all' && !\DB::table($tableName)->where('id', $value)->exists()) {
                            $fail("The selected {$attribute} is invalid.");
                        }
                    },
                ];
            }
        }

        return $rules;
    }
}
