<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLotRequest extends FormRequest
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
            'lot.name' => 'string|min:3|max:20',
            'lot.description' => 'string|min:3|max:200',
            'lot.startingPrice' => 'integer',
            'lot.timeLeft' => 'after:now',
        ];
    }

    public function messages()
    {
        return [
            'lot.name.min' => 'Поле названия лота должно одержать не менее 3 символов',
            'lot.name.max' => 'Поле названия лота должно одержать не более 20 символов',
            'lot.description.min' => 'Поле описания лота должно одержать не менее 3 символов',
            'lot.startingPrice.integer' => 'Начальная цена должна быть числом',
            'lot.timeLeft.after' => 'Дата должна быть не меньше сегодняшней даты',
            'lot.description.max' => 'Поле описания лота должно одержать не более 200 символов',
        ];
    }
}
