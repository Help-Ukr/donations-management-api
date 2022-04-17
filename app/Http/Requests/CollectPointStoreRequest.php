<?php

namespace App\Http\Requests;

class CollectPointStoreRequest extends CollectPointRequest
{
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.unique' => 'Only one record allowed',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_id' => \Auth::user()->id]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(['user_id' => ['required', 'unique:App\Models\CollectPoint,user_id']], parent::rules());
    }
}
