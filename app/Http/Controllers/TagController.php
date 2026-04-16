<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
 
   public function index()
   {
    return response()->json(Tag::all());
   }


    public function posts($slug)
    {

    $tag=Tag::where('slug',$slug)->firstOrFail();
    $post=$tag->posts()->with(['user','categories','tags'])->latest()->paginate(5);

    return response()->json($post);
    }


}


