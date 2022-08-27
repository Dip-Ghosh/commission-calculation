<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required | mimes:csv,CSV | max:2048',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Attachment is required',
            'file.max'      => 'File size must not exceed 2048KB',
            'file.mimes'    => 'File must be CSV'
        ];
    }
}
