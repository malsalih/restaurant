<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            //
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'phone'=>'string|starts_with:7,07,964,00964,+964|unique:users,phone',
            'address'=>'string',
            'user_type_id'=>'exists:user_types,id',
            'category_id'=>'exists:categories,id',
            'isActive'=>'in:0,1',
            
            'salary'=>'integer',
            
        ];
    }
}
