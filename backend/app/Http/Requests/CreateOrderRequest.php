<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
        $floatPattern = "/^([0-9]{1,})(\.([0-9]{1,2}))?$/";
        return [
            '*.ArticleCode' => 'required|string',
            '*.ArticleName' => 'required|string',
            '*.UnitPrice'   => 'required|regex:'.$floatPattern,
            '*.Quantity'    => 'required|int',
        ];
    }
}
