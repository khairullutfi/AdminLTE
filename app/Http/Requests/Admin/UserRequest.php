<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        'name'=> 'required|string|max:50',
        'username'=> 'required|string|max:50',
        'email' => ['required', 'string', 'email', 'max:255',
        Rule::unique('users')->ignore($this->user), ],
        'roles'=> 'nullable|string|in:ADMIN,USER',
        'nik' => 'integer',
        'companies_id' => 'required|exists:companies,id',
        ];
    }
}
