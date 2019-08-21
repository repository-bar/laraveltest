<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryMenuController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        if ($filterKeyword) {
            $categories = \App\CategoryMenu::where('name', 'LIKE', "%$filterKeyword%")->orderBy('name', 'asc')->paginate(10);
        } else {
            $categories = \App\CategoryMenu::orderBy('name', 'asc')->paginate(10);
        }
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25|unique:category_menus,name'
        ]);

        $name = $request->get('name');


        $new_category = new \App\CategoryMenu;
        $new_category->name = $name;

        $new_category->created_by = \Auth::user()->id;

        $new_category->save();

        return redirect()->route('categories.create')->with('status', 'Kategori menu berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = \App\CategoryMenu::findOrFail($id);

        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:25',
        ]);

        $name = $request->get('name');

        $category = \App\CategoryMenu::findOrFail($id);
        $category->name = $name;

        $category->updated_by = \Auth::user()->id;

        $category->save();

        return redirect()->route('categories.edit', ['id' => $id])->with('status', 'Kategori menu berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = \App\CategoryMenu::findOrfail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Kategori dimasukkan ke tong sampah');
    }

    /**
     * Show the trash of sub menu profil
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(){
        $categories = \App\CategoryMenu::onlyTrashed()->paginate(10);
      
        return view('categories.trash', ['categories' => $categories]);
    }

    /**
     * Restore the deleted sub menu profil
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id){
        $category = \App\CategoryMenu::withTrashed()->findOrFail($id);
      
        if($category->trashed()){
          $category->restore();
          return redirect()->route('categories.trash')->with('status', 'Kategori menu berhasil dipulihkan');
        } else {
          return redirect()->route('categories.trash')->with('status', 'Item tidak ada di tong sampah');
        }
    }

    /**
     * Delete Permanent the sub menu
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deletePermanent($id){
        $category = \App\CategoryMenu::withTrashed()->findOrFail($id);
        
        if(!$category->trashed()){
            return redirect()->route('categories.trash')->with('status', 'Tidak ada item di tong sampah');
        } else {
            if($category->image && file_exists(storage_path('app/public/' . $category->image))){
                \Storage::delete('public/' . $category->image);
            }
            $category->forceDelete();
            return redirect()->route('categories.trash')->with('status', 'Kategori menu dihapus secara permanen!');
        }
    }

}
