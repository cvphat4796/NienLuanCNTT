<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'user' => 'required',
            'pass' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'Vui lòng nhập tài khoản của bạn',
            'pass.required'  => 'Vui lòng nhập mật khẩu của bạn',
        ];
    }
}
