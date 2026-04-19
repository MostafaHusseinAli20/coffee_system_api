<?php

namespace App\Http\Requests\Main\Shifts;

use Illuminate\Foundation\Http\FormRequest;

class ShiftsRequest extends FormRequest
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
        if($this->isMethod('post')) {
            if(auth()->user()->role == 'developer') {
                return [
                    'coffee_id' => 'required|exists:coffees,id',
                    'user_id' => 'required|exists:users,id',
                    'total_amount' => 'required|numeric',
                    'status' => 'required|in:fixed,open',
                    'from' => 'required|date',
                    'to' => 'nullable|date|after_or_equal:from',
                    'opened_by' => 'required|string|max:255',
                    'closed_by' => 'nullable|string|max:255',
                    'notes' => 'nullable|string',
                ];
            }else{
                return [
                    'coffee_id' => 'nullable|exists:coffees,id',
                    'user_id' => 'nullable|exists:users,id',
                    'total_amount' => 'required|numeric',
                    'status' => 'required|in:fixed,open',
                    'from' => 'required|date',
                    'to' => 'nullable|date|after_or_equal:from',
                    'opened_by' => 'nullable|string|max:255',
                    'closed_by' => 'nullable|string|max:255',
                    'notes' => 'nullable|string',
                ];
            }
        } elseif($this->isMethod('put') || $this->isMethod('patch')) {
            if(auth()->user()->role == 'developer') {
                return [
                    'coffee_id' => 'nullable|exists:coffees,id',
                    'user_id' => 'nullable|exists:users,id',
                    'total_amount' => 'nullable|numeric',
                    'status' => 'nullable|in:fixed,open',
                    'from' => 'nullable|date',
                    'to' => 'nullable|date|after_or_equal:from',
                    'opened_by' => 'nullable|string|max:255',
                    'closed_by' => 'nullable|string|max:255',
                    'notes' => 'nullable|string',
                ];
            }else{
                return [
                    'coffee_id' => 'nullable|exists:coffees,id',
                    'user_id' => 'nullable|exists:users,id',
                    'total_amount' => 'nullable|numeric',
                    'status' => 'nullable|in:fixed,open',
                    'from' => 'nullable|date',
                    'to' => 'nullable|date|after_or_equal:from',
                    'opened_by' => 'nullable|string|max:255',
                    'closed_by' => 'nullable|string|max:255',
                    'notes' => 'nullable|string',
                ];
            }
        }
        return [];
    }
}
