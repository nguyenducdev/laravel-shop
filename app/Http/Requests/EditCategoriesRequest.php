<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditCategoriesRequest extends Request
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
            'parent_id'         => 'required|numeric|max:11',
            'title'             => 'required',
            'description'       => 'required',
            'image'             => 'mimes:jpeg,bmp,png|max:' .config('app.file.max_upload_file_size')
        ];
    }

    public function messages() {
        return [
            'parent_id.required' => 'Please enter Parent ID.',
            'parent_id.max' => 'Parent ID too long.',
            'parent_id.numeric' => 'Please enter valid Parent ID.',
            'title.required' => 'Please enter Title.',
            'description.required' => 'Please enter Description',
            'image.max' => 'File Image max is 5MB'
        ];
    }
}
