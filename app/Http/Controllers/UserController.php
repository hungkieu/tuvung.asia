<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $u = new User;
        $u->name = $request->name;
        $u->email = $request->email;
        $u->phone = $request->phone;
        $u->role = $request->role;
        $u->password = $request->password;
        if ($u->save()) {
            return $u;
        } else {
            return response('create failed', 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = DB::table('users')
        ->leftJoin('user_grammars', 'users.id', '=', 'user_grammars.user_id')
        ->leftJoin('vocabularies', 'users.id', '=', 'vocabularies.user_id')
        ->select('users.*', 'user_grammars.*', 'vocabularies.*')
        ->get();
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = User::findOrFail($id);
        if ($request->hasFile('avatar')) {
            $user->avatar = '/storage/'.str_replace('public/', '', $request->file('avatar')->store('public/images'));
        }
        $user->fill($request->all());
        $user->save();
        if($user->avatar) {
            return $user->avatar;
        }
        if($user->save()){
        return response('create success', 200);
        } else {
        return response('create failed', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $u = User::find($id);
        $u->delete();
    }
}
