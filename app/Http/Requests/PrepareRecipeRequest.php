<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PrepareRecipeRequest extends Request {

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
			'recipe_title' => 'required',
			'category' => 'required',
			'ingredients' => 'required',
			'method' => 'required',
		];
	}

}
