<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{


    public function index()
    {
        $categories = Category::orderBy('serial')->get();
        return view('categories.index', compact('categories'));
    }
    
   // CategoryController.php

// CategoryController.php

public function updateSerial(Request $request)
{
    try {
        $categoryId = $request->input('id');
        $serial = $request->input('serial');

        Category::where('id', $categoryId)->update(['serial' => $serial]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



}
