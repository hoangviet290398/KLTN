<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Category;
use Illuminate\Support\Facades\Auth;

class AddTopicRequest extends FormRequest
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
        $categories = Category::getStringId();
        return [

            'title' => 'required|max:100',
            'content' => 'required',
            'category' => "in:$categories"
        ];
    }

    public function messages() {
        
        return [
            'title.required' => 'Please enter a title.',
            'title.max' => 'The title is up to 100 characters.',
            'content.required' => 'Please enter a content.',
        ];
    }
}
