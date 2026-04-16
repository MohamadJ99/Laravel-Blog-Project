<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function posts($slug)
    {
     $category=Category::where('slug',$slug)->firstOrFail();
     $posts=$category->posts()->with(['user','categories','tags'])->latest()->paginate(5);
     return response()->json($posts);
    }
}
