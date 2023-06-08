<?php

namespace App\Http\Requests\Questionnaire;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'surname' => 'string|required',
			'name' => 'string|required',
			'patronymic' => 'string|required',
			'date_birth' => 'date_format:Y-m-d|required',
			'gender' => 'string|required',
			'tel' => 'string|required',
			'city' => 'string|nullable',
			'email' => 'email|required',
			'star' => 'string|required',
			'options' => 'array|required',
			'comment' => 'string|nullable',

		];
	}
}
