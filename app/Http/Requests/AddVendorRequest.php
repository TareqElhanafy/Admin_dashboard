<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddVendorRequest extends FormRequest
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
            'logo' => 'required_without:id|mimes:png,jpg,jpeg',
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'mobile' => 'required|string|max:100|unique:vendors,mobile,'.$this->id,
            'email' => 'required|email|unique:vendors,email,'.$this->id,
            'category_id' => 'required|exists:main_categories,id',
            'password' => 'required_without:id'
        ];
    }

    public function messages()
    {
        return
            [
                'required' => "هذا الحقل مطلوب",
                'email' => "لا بد من ادخال صيغة صحيحة للبريد الإلكترونى'",
                'max' => "لا يمكن ادخال أكثر من مائة أحرف",
                'string' => "لا بد من إدخال صيغة صحيحة للكلمات",
                'category_id.exists' => "هذا القسم غير موجود",
                "mimes" => "هذا الملف غير مدعوم",
                "min" => 'لا يمكن ادخال أقل من ثمانية أحرف',
                "mobile.unique"=> "هذا الرقم موجود لدينا بالفعل !",
                'email.unique' => "هذا الإيميل موجود لدينا بالفعل"
            ];
    }
}
