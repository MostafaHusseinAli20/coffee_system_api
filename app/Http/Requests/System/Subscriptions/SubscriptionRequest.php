<?php

namespace App\Http\Requests\System\Subscriptions;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
        if($this->isMethod('POST')) {
            return [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'duration' => 'required|numeric',
                'coffee_id' => 'required|exists:coffees,id',
                'enrollments_count' => 'required|numeric',
                'is_active' => 'required|boolean'
            ];
        } else if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return [
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string',
                'price' => 'sometimes|required|numeric', 
                'duration' => 'sometimes|required|numeric',
                'coffee_id' => 'sometimes|required|exists:coffees,id',
                'enrollments_count' => 'sometimes|required|numeric',
                'is_active' => 'sometimes|required|boolean'
            ];
        }
        return [];
    }
}
