<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
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
    public function show($id)
    {
        $user = User::findOrFail($id);
        if($user->id == Auth::user()->id || Auth::user()->role == 1)
            return $user;
    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Request $request, $id)
    {

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
    public function destroy($id)
    {
        //
    }

    public function edit_target_score(Request $request) {
        $user = User::findOrFail($request->id);
        $user->target_score = $request->score;
        if($user->save()){
            return response($user, 200);
            } else {
            return response('create failed', 400);
            }
    }
}
