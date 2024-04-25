<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikeDislikeRequest extends FormRequest
{
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
            'liked_user_id' => 'required|exists:users,id,deleted_at,NULL',
            'status' => 'required|in:0,1'
        ];
    }
}
