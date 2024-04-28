<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|json',
            'phone' => 'required|string|max:255',
            'website' => 'required|url|max:255',
            'company' => 'required|json',
            'current_password' => 'required_with:password|string|min:8',
            'role' => 'sometimes|string|exists:roles,name',
        ];
    }
}
