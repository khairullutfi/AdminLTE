<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KaryawanRequest extends FormRequest
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
            'companies_id' => 'required|exists:companies,id',
            'name' => 'required|max:255',
            'tanggal' => 'required|date',
            'pos_code' => 'required|integer',
            'pos_name' => 'required',
            'organisasi_code' => 'required|integer',
            'organisasi_name' => 'required',

        ];
    }
}
