<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectPointRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'phone' => ['string', 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'],
            'telegram' => ['string', 'regex:/.*\B@(?=\w{5,64}\b)[a-zA-Z0-9]+(?:_[a-zA-Z0-9]+)*.*/'],
            'image' => ['url'],
            
            'location' => ['array:address,latitude,longitude'],
            'location.address' => ['required', 'string'],
            'location.latitude' => ['required', 'numeric'],
            'location.longitude' => ['required', 'numeric'],
            
            'needed_items' => ['array'],
            'needed_items.*.item_category_id' => ['integer', 'required'],

            'available_items' => ['array'],
            'available_items.*.item_category_id' => ['integer', 'required'],
            'available_items.*.quantity' => ['integer', 'required'],
        ];
    }
}
