<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use App\Category;
use App\Recipe;

class RecipesController extends Controller {

	public function  __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return \Auth::user()->recipes;
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

		session()->flash('recipe', $data); // temporarily add the data to a session so it can be grabbed by our Store method

		return view('recipes.confirm', compact('template'));
	
	}

	public function store(Request $request)
	{
		$recipe = $this->createRecipe($request);

		Mail::queue('emails.recipe', compact('recipe'), function($message){
			$message->from($recipe->getOwnerEmail())
					->to('webmaster@continuityshop.com')
					->subject('New recipe!');
		});


		return redirect('recipes');

		
	}

	private function createRecipe(Request $request)
	{
		$recipe = session()->get('recipe') + ['template' => $request->input('template')];

		$recipe = \Auth::user()->recipes()->create($recipe);

		return $recipe;
	}
}

