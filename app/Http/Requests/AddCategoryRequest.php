<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
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
            'photo'=>'required|mimes:png,jpg',
            'category'=>'required|array|min:1',
            'category.*.name'=>'required|string|max:100',
            'category.*.abbr'=>'required|max:10',
        ];
    }

    public function messages()
    {
        return [
            'required'=>'هذا الحقل مطلوب',
            'mimes'=>'الملف المرفق غير مدعوم',
            'category.*.name.max'=>'غير مسموح بأكثر من مائة حرف',
            'category.*.abbr.max'=>'غير مسموح بأكثر من عشرة حروف',
        ];
    }
}
