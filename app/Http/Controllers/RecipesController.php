<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Category;

class RecipesController extends Controller {

	public function  __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		
	}

	public function create()
	{
		$categories = Category::lists('name','id');
		// load a view to create a new recipe
		return view ('recipes.create', compact('categories'));
	}

	public function confirm(Requests\PrepareRecipeRequest $request)
	{
		$data = $request->all() + [
			'name' => \Auth::user()->name
		];
		$template  = view()->file(app_path('Http/Templates/recipe.blade.php'), $data);

		return view('recipes.confirm', compact('template'));
	
	}
}

