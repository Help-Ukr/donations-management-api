<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class CollectPointFilterRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {

        $validationFactory->extend(
            'bbox',
            function ($attribute, $value, $parameters) {
                if(count(explode(',', $value)) != 4){
                    return false;
                };
                return true;
            },
            'Sorry, please check bbox value!'
        );

        $validationFactory->extend(
            'itemsAvailable',
            function ($attribute, $value, $parameters) {
                if(count(explode(',', $value)) == 0){
                    return false;
                };
                return true;
            },
            'Sorry, please check itemsAvailable value!'
        );

    }

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
            'bbox' => ['string', 'bbox'],
            'itemsAvailable' => ['string', 'itemsAvailable'],
        ];
    }
}
