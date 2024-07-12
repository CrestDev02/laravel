<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:15|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'confirm_password' => 'required|same:password|min:8|max:15',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The username is required.',
            'email.required' => 'The email is required.',
            'password.required' => 'The password is required.',
            'confirm_password.required' => 'The confirm password is required.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number and one special character.'
        ];
    }

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }
    }
}
