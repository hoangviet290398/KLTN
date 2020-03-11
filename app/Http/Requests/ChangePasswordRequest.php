<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'curentpassword' => 'required',
            'newpassword' => 'required|min:5|max:30',
            'confirmpass' => 'required'
        ];
    }

    public function message() {

        return [
            'curentpassword.required' => 'Please enter curent password',
            'newpassword.required' => 'Please enter new password',
            'newpassword.min' => 'Password must be more than 5 characters',
            'newpassword.max' => 'Password must be less than 30 characters',
            'confirmpass.required' => 'Please confirm the password'
        ];
    }
}
