<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountLimitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if ($this->isMethod('post')) {
            $rules =  [
                'account_id' => 'required|integer|exists:accounts,id,user_id,' . auth()->id(),
                'secret_answer' => 'required|string|exists:question_and_answers,answer,user_id,' . auth()->id(),
                'amount' => 'required|numeric'
            ];
        }
        return $rules;
    }
}
