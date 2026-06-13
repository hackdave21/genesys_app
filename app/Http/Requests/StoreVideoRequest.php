<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
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
            'title'        => 'required|string|max:255',
            'category'     => 'required|in:Publicité,Événement,Reels,Corporate',
            'description'  => 'nullable|string|max:1000',
            'video_url'    => 'required|string|url|max:255',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // custom file upload
            'status'       => 'required|in:visible,archive',
            'is_featured'  => 'nullable|boolean',
        ];
    }
}
