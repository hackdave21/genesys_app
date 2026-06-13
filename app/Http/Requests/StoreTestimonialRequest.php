<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
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
            'company_role' => 'nullable|string|max:255',
            'content'      => 'required|string|max:5000',
            'status'       => 'required|in:published,draft',
        ];
    }
}
