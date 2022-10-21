<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $recipes = Recipe::orderBy('created_at', 'asc')->get();
        return view('home', compact('recipes'));
    }

    public function postRecipe(Request $request)
    {
        //require validate fields ... (no time to add)

        $data = $request->dataPost ?? null;
        
        if($data !== null) $recipe = Recipe::updateOrCreate(
            ['id' => $data['id'] ?? null],
            ['recipe' => $data['recipe'], 'ingredients' => $data['ingredients'], 'directions' => $data['directions']]);

        return $recipe ?? 1;
    }

    public function deleteRecipe(Request $request)
    {
        //require validate fields ... other

        Recipe::where('id', $request->id)->delete();
        return 1;
    }
}
