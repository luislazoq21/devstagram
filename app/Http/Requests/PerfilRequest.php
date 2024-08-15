<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class PerfilRequest extends FormRequest
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
            'username'  => [
                'required',
                Rule::unique('users')->ignore(auth()->user()->id),
                Rule::notIn(config('restricted_words')),
            ],
            'email'     => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->user()->id),
            ],
            // 'password'  => [
            // ],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'username' => Str::slug($this->username),
            // 'password' => Hash::make($this->password),
        ]);
    }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $user = User::where('email', $this->email)->first();

    //         if (!$user || !Hash::check($this->password, $user->password)) {
    //             $validator->errors()->add('password', 'Las credenciales no coinciden con nuestros registros.');
    //         }
    //     });
    // }
}
