<?php

namespace App\Http\Requests\Users;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'password' => 'sometimes|string|min:8|confirmed',
            'address' => 'required|json',
            'phone' => 'required|string|max:255',
            'website' => 'required|url|min:0|max:255',
            'company' => 'required|json',
            'status' => 'sometimes|string',
            'current_password' => 'required_with:password|string|min:8',
            'role' => 'sometimes|string|exists:roles,name',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'data'    => $this->all(),
            'status'  => 'error',
            'errors'  => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
