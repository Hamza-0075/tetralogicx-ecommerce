<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at',"DESC")->paginate(10);
        return view('backend.categories.categories', compact('categories'));
    }

    public function store(request $request)
    {

        $request->validate([
            'name'=>'required',
        ]);

        $data=array(
         'name'=>$request->name,
         );

        $create=Category::create($data);
        return redirect()->route('categories')->with('success', 'Category created successfully.');

    }

    public function update(Request $request)
    {
        $category=Category::find($request->id);
        $request->validate([
            'name'=>'required',
        ]);

        $category->name = $request->name;

        $category->save();
        return redirect()->route('categories')->with('success', 'Category updated successfully.');
    }

    //Delete the category method

    public function destroy(Request $request)
    {
        $id=$request->id;
        $category=Category::find($id);

        if ($category === null) {
            $request->session()->flash('successs', 'Cateory not found.');
            return response()->json(['status' => false]);
        }

        $category->delete();

        $request->session()->flash('successs', 'Category deleted successfully.');
        return response()->json(['status' => true]);
    }
}
