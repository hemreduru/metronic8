<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Update Profile Request
 *
 * Validates profile update form data according to RC rules
 *
 * @property string $name User's full name
 * @property string $email User's email address
 */
class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // User can always update their own profile
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('fields.name')]),
            'name.min' => __('validation.min.string', ['attribute' => __('fields.name'), 'min' => 2]),
            'email.required' => __('validation.required', ['attribute' => __('fields.email')]),
            'email.email' => __('validation.email', ['attribute' => __('fields.email')]),
            'email.unique' => __('validation.unique', ['attribute' => __('fields.email')]),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => __('fields.name'),
            'email' => __('fields.email'),
        ];
    }
}
