<?php

namespace App\Http\Requests\System\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8',
                'role' => 'nullable|in:developer,user,owner,supervisor,cashier',
                'salary' => 'nullable|numeric|min:0',
                'is_cashier' => 'nullable|boolean',
                'his_job' => 'nullable|string|max:255',
                'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^(01[0125][0-9]{8}|\+201[0125][0-9]{8})$/'
                ],
                'address' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'active' => 'nullable|boolean',
                'coffee_id' => 'required_if:role,cashier,owner|exists:coffees,id',
            ];
        } else if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->route('user'),
                'password' => 'sometimes|required|string|min:6',
                'role' => 'sometimes|required|in:developer,user,owner,supervisor,cashier',
                'salary' => 'sometimes|required|numeric|min:0',
                'is_cashier' => 'sometimes|boolean',
                'his_job' => 'sometimes|string|max:255',
                'phone' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:20',
                    'regex:/^(01[0125][0-9]{8}|\+201[0125][0-9]{8})$/'
                ],
                'address' => 'sometimes|required|string|max:255',
                'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048',
                'active' => 'sometimes|boolean',
                'coffee_id' => 'sometimes|required|exists:coffees,id,' . $this->route('user'),
            ];
        }
        return [];
    }
}
