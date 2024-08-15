<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'      => 'required',
            'username'  => [
                'required',
                'unique:users',
                'not_in:' . implode(',', config('restricted_words')),
            ],
            'email'     => [
                'required',
                'email',
                'unique:users',
            ],
            'password'  => [
                'required',
                'min:8',
                // 'confirmed',
                'same:password_confirmation',
            ],
            'password_confirmation' => [
                'required',
                'same:password',
            ],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'username'  => Str::slug($this->username),
        ]);
    }

    public function messages()
    {
        return [
            'same'  => 'Las contraseñas no coinciden',
        ];
    }

    public function attributes()
    {
        return [
            // 'name'  => 'NOMBREEEE'
        ];
    }
}
