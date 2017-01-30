<?php

namespace Modules\Questions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionRequestByUser extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required', 
            'answer_1' => 'required', 
            'answer_2' => 'required', 
            'answer_3' => 'required', 
            'answer_4' => 'required', 
            'answer_5' => 'required', 
            'category_id' => 'required'
        ];
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
}
