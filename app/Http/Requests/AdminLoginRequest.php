<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return
            [
                'required' => "هذا الحقل مطلوب",
                'email' => "لا بد من ادخال صيغة صحيحة للبريد الإلكترونى",
                'min' => "لا يمكن ادخال أقل من ثمانية أحرف",
                'string' => "لا بد من إدخال صيغة صحيحة للكلمات"
            ];
    }
}
