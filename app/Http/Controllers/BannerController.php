<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
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
            $banners = \App\Banner::where('title', 'LIKE', "%$filterKeyword%")->latest()->paginate(10);
        } else {
            $banners = \App\Banner::latest()->paginate(10);
        }
        return view('banner.index', ['banners' => $banners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banner.create');
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
            'desc' => 'required|string|max:200',
            'image' => 'required|image|max:2000'
        ]);

        $banner = new \App\Banner;
        $banner->title = $request->get('title');
        $banner->desc = $request->get('desc');
        $banner->status = $request->get('save_action');

        $banner->created_by = \Auth::user()->id;

        if ($request->file('image')) {
            $file = $request->file('image')->store('banner', 'public');
            $banner->image = $file;
        }

        $banner->save();

        if($request->get('save_action') == 'PUBLISH'){
            return redirect()
                ->route('banners.index')
                ->with('status', 'Banner berhasil disimpan dan dipublikasikan');
        } else {
            return redirect()
                ->route('banners.index')
                ->with('status', 'Banner berhasil disimpan sebagai draft');
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
        $banner = \App\Banner::findOrFail($id);

        return view('banner.edit', ['banner' => $banner]);
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
            'desc' => 'required|string|max:200'
        ]);

        $banner = \App\Banner::findOrFail($id);
        $banner->title = $request->get('title');
        $banner->desc = $request->get('desc');
        $banner->status = $request->get('save_action');
        $banner->updated_by = \Auth::user()->id;

        if ($request->file('image')) {
            $request->validate([
                'image' => 'required|image|max:2000'
            ]);

            if ($banner->image && file_exists(storage_path('app/public/'.$banner->image))) {
                \Storage::delete('public/'.$banner->image);
            }
            $file = $request->file('image')->store('banner', 'public');
            $banner->image = $file;
        }

        $banner->save();

        if($request->get('save_action') == 'PUBLISH'){
            return redirect()
                ->route('banners.index')
                ->with('status', 'Banner berhasil disimpan dan dipublikasikan');
        } else {
            return redirect()
                ->route('banners.index')
                ->with('status', 'Banner berhasil disimpan sebagai draft');
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
        $banner = \App\Banner::findOrfail($id);
        $banner->delete();
        return redirect()->route('banners.index')->with('status', 'Banner dimasukkan ke tong sampah');
    }

    /**
     * Show the trash of sub menu profil
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(){
        $banners = \App\Banner::onlyTrashed()->paginate(10);
      
        return view('banner.trash', ['banners' => $banners]);
    }

    /**
     * Restore the deleted sub menu profil
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id){
        $banner = \App\Banner::withTrashed()->findOrFail($id);
      
        if($banner->trashed()){
          $banner->restore();
          return redirect()->route('banners.trash')->with('status', 'Foto Banner berhasil dipulihkan');
        } else {
          return redirect()->route('banners.trash')->with('status', 'Item tidak ada di tong sampah');
        }
    }

    /**
     * Delete Permanent the sub menu
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deletePermanent($id){
        $banner = \App\Banner::withTrashed()->findOrFail($id);
      
        if(!$banner->trashed()){
            return redirect()->route('banners.trash')->with('status', 'Tidak ada item di tong sampah');
        } else {
            \Storage::delete('public/'.$banner->image);
            $banner->forceDelete();
            return redirect()->route('banners.trash')->with('status', 'Foto Banner dihapus secara permanen!');
        }
    }
}
