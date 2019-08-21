<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
            $users = \App\User::where('name', 'LIKE', "%$filterKeyword%")->orderBy('name', 'asc')->paginate(10);
        } else {
            $users = \App\User::orderBy('name', 'asc')->paginate(10);
        }
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
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
            'name' => 'required|string|max:50',
            'email' => 'required|unique:users|email|max:100',
            'password' => 'required|min:8',
            'avatar' => 'required|image|max:2000'
        ]);

        $new_user = new \App\User;
        $new_user->name = $request->get('name');
        $new_user->email = $request->get('email');
        $new_user->password = \Hash::make($request->get('password'));

        if ($request->file('avatar')) {
            $file = $request->file('avatar')->store('avatars', 'public');
            $new_user->avatar = $file;
        }

        $new_user->save();

        return redirect()->route('users.create')->with('status', 'Akun berhasil dibuat');
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
        $user = \App\User::findOrFail($id);

        return view('users.edit', ['user' => $user]);
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
            'name' => 'required|string|max:50'
        ]);

        $user = \App\User::findOrFail($id);

        $user->name = $request->get('name');

        if ($request->get('password') != NULL) {
            $request->validate([
                'password' => 'required|min:8'
            ]);
            $user->password = \Hash::make($request->get('password'));
        }

        if ($request->file('avatar')) {
            $request->validate([
                'avatar' => 'required|image|max:2000'
            ]);

            if ($user->avatar && file_exists(storage_path('app/public/'.$user->avatar))) {
                \Storage::delete('public/'.$user->avatar);
            }
            $file = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $file;
        }
        
        $user->save();
        return redirect()->route('users.edit', ['id' => $id])->with('status', 'Akun '.$user->name.' sukses diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \App\User::findOrfail($id);
        \Storage::delete('public/'.$user->avatar);
        $user->delete();
        return redirect()->route('users.index')->with('status', 'User berhasil dihapus');
    }
}
