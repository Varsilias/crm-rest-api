<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            "name" => "required|min:3|string"
        ];
    }

    function offsetExists($offset) {
        return true;
    }
    function offsetGet($offset) {}
    function offsetSet($offset, $value) {}
    function offsetUnset($offset) {}
}
