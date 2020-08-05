<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLotRequest extends FormRequest
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
            'lot.nameLot' => 'required|string|min:3',
            'lot.description' => 'required|string|min:3',
            'lot.startingPrice' => 'required|integer',
            'lot.timeLeft' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'lot.nameLot.required' => 'Заполните название лота',
            'lot.description.required' => 'Заполните описание лота',
            'lot.startingPrice.required' => 'Заполните начальную ставку',
            'lot.timeLeft.required' => 'Заполнить время выставления лота',
            'lot.nameLot.min' => 'Поле названия лота должно одержать не менее 3 символов',
            'lot.description.min' => 'Поле описания лота должно одержать не менее 3 символов',
            'lot.startingPrice.integer' => 'Начальная цена должна быть числом',
            'lot.timeLeft.integer' => 'Время должно быть числом',
        ];
    }
}
