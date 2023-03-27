<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'role' => ['exists:roles,name'],
            'name' => ['string', 'max:255'],
            'email' => ['email', 'string', 'max:255', 'unique:users,email,'.$this->user()->id],
            'username' => ['string', 'max:15', 'unique:users,username,'.$this->user()->id],
        ];
    }
}
