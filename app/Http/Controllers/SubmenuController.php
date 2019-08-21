<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class SubmenuController extends Controller
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
            $submenu = DB::table('submenus')
                ->join('category_menus', 'submenus.category_menu_id', '=', 'category_menus.id')
                ->where('status', 'PUBLISH')
                ->where('submenus.deleted_at' , NULL)
                ->where('title', 'LIKE', "%$filterKeyword%")
                ->select('submenus.*', 'category_menus.name as menu')
                ->orderBy('title', 'asc')
                ->paginate(10);
        } else {
            $submenu = DB::table('submenus')
                ->join('category_menus', 'submenus.category_menu_id', '=', 'category_menus.id')
                ->where('status', 'PUBLISH')
                ->where('submenus.deleted_at' , NULL)
                ->select('submenus.*', 'category_menus.name as menu')
                ->orderBy('title', 'asc')
                ->paginate(10);
        }
        return view('submenu.index', ['submenu' => $submenu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\CategoryMenu::all();
        return view("submenu.create", ['categories' => $categories]);
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
            'title' => 'required|string|max:100',
            'category' => 'required',
            'content' => 'required'
        ]);

        $submenu = new \App\Submenu;
        $submenu->title = $request->get('title');
        $submenu->category_menu_id = $request->get('category');
        $submenu->content = $request->get('content');
        $submenu->status = $request->get('save_action');

        $submenu->slug = str_slug($request->get('title'));

        $submenu->created_by = \Auth::user()->id;

        $submenu->save();

        if($request->get('save_action') == 'PUBLISH'){
            return redirect()
                ->route('submenus.index')
                ->with('status', 'Sub menu berhasil disimpan dan dipublikasikan');
        } else {
            return redirect()
                ->route('submenus.index')
                ->with('status', 'Sub menu berhasil disimpan sebagai draft');
        }
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
        $submenu = \App\Submenu::findOrFail($id);
        $categories = \App\CategoryMenu::all();

        return view('submenu.edit', ['submenu' => $submenu, 'categories' => $categories]);
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
            'title' => 'required|string|max:100',
            'category' => 'required',
            'content' => 'required'
        ]);

        $submenu = \App\Submenu::findOrFail($id);
        $submenu->title = $request->get('title');
        $submenu->category_menu_id = $request->get('category');
        $submenu->content = $request->get('content');
        $submenu->status = $request->get('save_action');

        $submenu->slug = str_slug($request->get('title'));

        $submenu->updated_by = \Auth::user()->id;

        $submenu->save();

        if($request->get('save_action') == 'PUBLISH'){
            return redirect()
                ->route('submenus.index')
                ->with('status', 'Sub menu berhasil disimpan dan dipublikasikan');
        } else {
            return redirect()
                ->route('submenus.index')
                ->with('status', 'Sub menu berhasil disimpan sebagai draft');
        }
    }

    /**
     * Remove the specified resource to trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $submenu = \App\Submenu::findOrfail($id);
        $submenu->delete();
        return redirect()->route('submenus.index')->with('status', 'Sub menu dimasukkan ke tong sampah');
    }

    /**
     * Show the trash of sub menu profil
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(){
        $submenu = \App\Submenu::onlyTrashed()->paginate(10);
      
        return view('submenu.trash', ['submenu' => $submenu]);
    }

    /**
     * Restore the deleted sub menu profil
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id){
        $submenu = \App\Submenu::withTrashed()->findOrFail($id);
      
        if($submenu->trashed()){
          $submenu->restore();
          return redirect()->route('submenus.trash')->with('status', 'Sub menu berhasil dipulihkan');
        } else {
          return redirect()->route('submenus.trash')->with('status', 'Item tidak ada di tong sampah');
        }
    }

    /**
     * Delete Permanent the sub menu
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deletePermanent($id){
        $submenu = \App\Submenu::withTrashed()->findOrFail($id);
      
        if(!$submenu->trashed()){
            return redirect()->route('submenus.trash')->with('status', 'Tidak ada item di tong sampaj');
        } else {
            $submenu->forceDelete();
            return redirect()->route('submenus.trash')->with('status', 'Sub menu dihapus secara permanen!');
        }
    }
}
