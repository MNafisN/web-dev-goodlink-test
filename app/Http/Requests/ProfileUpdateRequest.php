<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:4','max:255'],
            'bio' => ['nullable', 'string', 'min:10'],
            'email' => ['required', 'email', 'string', 'max:255', Rule::unique('members')->ignore(Auth::user())],
            'password' => ['nullable', 'string', 'confirmed', 'min:6'],
        ];
    }

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->password == null) {
            $this->request->remove('password');
        }
    }
}