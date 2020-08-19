<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBetRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bet_on_lot' => [
                'required',
                'min:1',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($this->offer->bet_on_lot > $value) {
                        $fail('Ставка должна быть выше прежней. Пожалуйста обновите страницу!');
                    }
                }

            ]
        ];

    }

    public function messages()
    {
        return [
            'bet_on_lot.required' => 'Введите ставку!',
            'bet_on_lot.min' => 'Ставка должна быть выше 1 рубля',
        ];


    }
}
