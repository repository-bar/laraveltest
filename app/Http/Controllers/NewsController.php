<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
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
            $news = DB::table('news')
            ->join('users', 'news.created_by', '=', 'users.id')
            ->where('title', 'LIKE', "%$filterKeyword%")
            ->where('deleted_at' , NULL)
            ->select('news.*', 'users.name')
            ->latest()
            ->paginate(10);
        } else {
            $news = DB::table('news')
            ->join('users', 'news.created_by', '=', 'users.id')
            ->where('deleted_at' , NULL)
            ->select('news.*', 'users.name')
            ->latest()
            ->paginate(10);
        }
        return view('news.index', ['news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
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
            'content' => 'required',
            'image' => 'required|image|max:2000'
        ]);

        $news = new \App\News;
        $news->title = $request->get('title');
        $news->content = $request->get('content');
        $news->status = $request->get('save_action');

        $news->slug = str_slug($request->get('title')."-".uniqid());

        $news->created_by = \Auth::user()->id;

        if ($request->file('image')) {
            $file = $request->file('image')->store('berita', 'public');
            $news->image = $file;
        }

        $news->save();

        if($request->get('save_action') == 'PUBLISH'){
            return redirect()
                ->route('news.index')
                ->with('status', 'Berita berhasil disimpan dan dipublikasikan');
        } else {
            return redirect()
                ->route('news.index')
                ->with('status', 'Berita berhasil disimpan sebagai draft');
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
        $news = \App\News::findOrFail($id);

        return view('news.edit', ['news' => $news]);
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
            'content' => 'required'
        ]);

        $news = \App\News::findOrFail($id);
        $news->title = $request->get('title');
        $news->content = $request->get('content');
        $news->status = $request->get('save_action');

        $news->slug = str_slug($request->get('title')."-".uniqid());

        $news->updated_by = \Auth::user()->id;

        if ($request->file('image')) {
            $request->validate([
                'image' => 'required|image|max:2000'
            ]);

            if ($news->image && file_exists(storage_path('app/public/'.$news->image))) {
                \Storage::delete('public/'.$news->image);
            }
            $file = $request->file('image')->store('berita', 'public');
            $news->image = $file;
        }

        $news->save();

        if($request->get('save_action') == 'PUBLISH'){
            return redirect()
                ->route('news.index')
                ->with('status', 'Berita berhasil disimpan dan dipublikasikan');
        } else {
            return redirect()
                ->route('news.index')
                ->with('status', 'Berita berhasil disimpan sebagai draft');
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
        $news = \App\News::findOrfail($id);
        $news->delete();
        return redirect()->route('news.index')->with('status', 'Berita dimasukkan ke tong sampah');
    }

    /**
     * Show the trash of sub menu profil
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(){
        $news = \App\news::onlyTrashed()->paginate(10);
      
        return view('news.trash', ['news' => $news]);
    }

    /**
     * Restore the deleted sub menu profil
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id){
        $news = \App\News::withTrashed()->findOrFail($id);
      
        if($news->trashed()){
          $news->restore();
          return redirect()->route('news.trash')->with('status', 'Berita berhasil dipulihkan');
        } else {
          return redirect()->route('news.trash')->with('status', 'Item tidak ada di tong sampah');
        }
    }

    /**
     * Delete Permanent the sub menu
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deletePermanent($id){
        $news = \App\News::withTrashed()->findOrFail($id);
      
        if(!$news->trashed()){
            return redirect()->route('news.trash')->with('status', 'Tidak ada item di tong sampah');
        } else {
            \Storage::delete('public/'.$news->image);
            $news->forceDelete();
            return redirect()->route('news.trash')->with('status', 'Berita dihapus secara permanen!');
        }
    }
}
