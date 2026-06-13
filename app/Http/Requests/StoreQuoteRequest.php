<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'client_name'  => 'required|string|max:255',
            'company'      => 'nullable|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:50',
            'project_type' => 'required|string|max:100',
            'budget'       => 'required|string|max:100',
            'description'  => 'nullable|string|max:5000',
        ];
    }
}
