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
            'lot.name' => 'required|string|min:3|max:15',
            'lot.description' => 'required|string|min:3|max:200',
            'lot.startingPrice' => 'required|integer',
            'lot.timeLeft' => 'required|after:now',
        ];
    }

    public function messages()//можно сделать перевод с помощью пакета
    {
        return [
            'lot.name.required' => 'Заполните название лота',
            'lot.description.required' => 'Заполните описание лота',
            'lot.startingPrice.required' => 'Заполните начальную ставку',
            'lot.timeLeft.required' => 'Заполнить время выставления лота',
            'lot.name.min' => 'Поле названия лота должно одержать не менее 3 символов',
            'lot.name.max' => 'Поле названия лота должно одержать не более 20 символов',
            'lot.description.min' => 'Поле описания лота должно одержать не менее 3 символов',
            'lot.description.max' => 'Поле описания лота должно одержать не более 200 символов',
            'lot.startingPrice.integer' => 'Начальная цена должна быть числом',
            'lot.timeLeft.after' => 'Дата должна быть не меньше сегодняшней даты',
        ];
    }
}
