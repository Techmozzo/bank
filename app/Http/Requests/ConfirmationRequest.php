<?php

namespace App\Http\Requests;

use App\Rules\DistinctArrayElements;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmationRequest extends FormRequest
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
            'name' => 'required|string',
            'opening_period' => 'required|date',
            'closing_period' => 'sometimes|required|date|after_or_equal:opening_period',
            'account_name' => 'required|array',
            'account_name.*' => 'required|string',
            'account_number' =>  ['required', 'array', new DistinctArrayElements],
            'account_number.*' => 'required|string',
            'bank' => 'required|integer|exists:banks,id',
            'signatory_name' => 'required|array',
            'signatory_name.*' => 'required|string',
            'signatory_phone' =>  'required|array',
            'signatory_phone.*' => 'required|string',
            'signatory_email' =>  ['required', 'array', new DistinctArrayElements],
            'signatory_email.*' => 'required|email',
        ];
    }
}
