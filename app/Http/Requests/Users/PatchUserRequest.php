<?php

namespace App\Http\Requests\Users;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PatchUserRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'username' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'sometimes|string|min:8',
            'current_password' => 'required_with:password|string|min:8',
            'address' => 'sometimes|json',
            'phone' => 'sometimes|string|max:255',
            'website' => 'nullable|url|min:0|max:255',
            'company' => 'sometimes|json',
            'status' => 'sometimes|string',
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
