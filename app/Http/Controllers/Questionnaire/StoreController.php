<?php

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\Controller;
use App\Http\Requests\Questionnaire\StoreRequest;
use App\Models\Questionnaire;
use Illuminate\Http\Request;

class StoreController extends Controller
{

	public function __invoke(StoreRequest $request)
	{
		$data = $request->validated();
		$data['options'] = json_encode($data['options']);
		if (str_contains($data['tel'], '+')) {
			$data['tel'] = str_replace('+', '', $data['tel']);
		}
		Questionnaire::create($data);
		return response()->json(['success' => 'Успех'], 201);
	}
}
