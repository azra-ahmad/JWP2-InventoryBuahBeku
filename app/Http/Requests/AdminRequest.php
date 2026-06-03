<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $admin = $this->route('admin');
        $passwordRule = $admin ? ['nullable', 'string', 'min:6'] : ['required', 'string', 'min:6'];

        return [
            'nama' => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('admin', 'username')->ignore($admin?->id),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('admin', 'email')->ignore($admin?->id),
            ],
            'password' => $passwordRule,
        ];
    }
}
