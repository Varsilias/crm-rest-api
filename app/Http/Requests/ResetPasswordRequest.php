<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            "token" => "required|string|min:3|max:64",
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    function offsetExists($offset) {
        return true;
    }
    function offsetGet($offset) {}
    function offsetSet($offset, $value) {}
    function offsetUnset($offset) {}
}
