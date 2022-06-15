<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
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
            'id_fitur' => 'nullable|integer',
            'ref_id' => 'nullable|integer',
            'filename' => 'required|max:255',
            'photo' => 'required|mimes:doc,docx,pdf,txt'
        ];
    }
}
