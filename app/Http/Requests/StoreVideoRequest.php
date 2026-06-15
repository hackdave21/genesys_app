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
        $rules = [
            'title'        => 'required|string|max:255',
            'category'     => 'required|in:Publicité,Événement,Reels,Corporate',
            'description'  => 'nullable|string|max:1000',
            'client'       => 'nullable|string|max:255',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status'       => 'required|in:visible,archive',
            'is_featured'  => 'nullable|boolean',
        ];

        if ($this->isMethod('POST')) {
            $rules['video_file'] = 'required|file|mimes:mp4,mov,ogg,qt,webm,avi|max:102400';
        } else {
            $rules['video_file'] = 'nullable|file|mimes:mp4,mov,ogg,qt,webm,avi|max:102400';
        }

        return $rules;
    }
}
