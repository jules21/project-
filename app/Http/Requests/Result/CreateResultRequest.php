<?php

namespace App\Http\Requests\Result;

use App\Http\Requests\Request;
use App\Result;

class CreateResultRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'regno' => 'required|exists:users,username|unique:results,regno,NULL,id,level,'.$this->level.',term,'.$this->term,
            'level' => 'required',
            'term' => 'required',
            'marks' => 'required|numeric|max:100',
        ];
    }

    public function messages()
    {
        return [
            'regno.exists' => 'Registration number does not match any student',
            'regno.unique' => 'Student results already exists',
        ];
    }
}
