<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if($this->isMethod('post')){
            $rules = [
                'currency' => ['required', 'integer', 'exists:account_currencies,id'],
                'account_type' => ['required', 'integer',  'exists:account_types,id'],
            ];
        }
        return $rules;
    }
}
