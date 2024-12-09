<?php

namespace App\Http\Requests;

use App\Models\AttendanceToken;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreMemberAssistanceRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'token' => 'required|string|exists:attendance_tokens,token',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $attendanceToken = AttendanceToken::with('user.membership')->where('token', $this->input('token'))
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

                if (!$attendanceToken) {
                    $validator->errors()->add('token', 'El token no es válido o ha expirado');
                }

                if ($attendanceToken) {
                    $membership = $attendanceToken->user->membership;

                    if (!$membership || $membership->status != 'active' || $membership->end_at->lessThan(Carbon::now())) {
                        $validator->errors()->add('token', 'El usuario no tiene una membresía activa');
                    }
                }
            }
        ];
    }
}
