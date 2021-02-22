<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductFormRequest extends FormRequest
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
            'name'              =>  'required',
            'sku'               =>  'required',
            'branch_id'         =>  'required|not_in:0',
            'categories'        =>  'required|not_in:0',
            'price'             =>  'required|regex:/^\d+(\.\d{1,2})?$/',
            'sale_price'        =>  'regex:/^\d+(\.\d{1,2})?$/|lt:price',
            'quantity'          =>  'required|integer',
            'weight'            =>  'regex:/^\d+(\.\d{1,2})?$/',
            'width'             =>  'regex:/^\d+(\.\d{1,2})?$/',
            'length'            =>  'regex:/^\d+(\.\d{1,2})?$/',
            'height'            =>  'regex:/^\d+(\.\d{1,2})?$/',


        ];
    }
}
