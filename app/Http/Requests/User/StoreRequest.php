<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreRequest extends FormRequest
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
            'username' => ['required', 'string', Rule::unique('users', 'username')->whereNull('deleted_at')],
            'password' => ['required', 'min:8']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->password) {
            $this->merge([
                'password' => Hash::make($this->password)
            ]);
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'username harus diisi',
            'username.unique' => "{$this->username} tidak tersedia",
            'password.required' => 'password harus diisi',
            'password.min' => 'password harus memiliki minimal 8 karakter'
        ];
    }
}
