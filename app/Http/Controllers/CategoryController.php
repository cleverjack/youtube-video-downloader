<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Videos;

class CategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageCategory()
    {
        $categories = Category::where('parent_id', '=', 0)->get();
        $allCategories = Category::pluck('title','id')->all();
        return view('home',compact('categories','allCategories'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCategory(Request $request)
    {
        $this->validate($request, [
        		'title' => 'required',
        	]);
        $input = $request->all();
        //$input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        $input['parent_id'] = 0;
        Category::create($input);
        return back()->with('success', 'New Category added successfully.');
    }

    public function removeCategory($id)
    {

      if($id == "null"){
        
        return back()->with('success', 'There is no category.');
      }else{

        Category::find($id)->delete();
        Videos::where('category_id', '=', $id)->delete();
        return back()->with('success', 'One Category removed successfully.');
        }
    }

}
