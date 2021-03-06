<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\UserGrammars;
use App\User;

class UserGrammarsController extends Controller
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
        $grammar = new UserGrammars;
        $grammar->name = $request->name;
        $grammar->description = $request->description;
        $grammar->category_id = $request->category_id;
        $grammar->structure_name = $request->structure_name;
        $grammar->structure_description = $request->structure_description;
        $grammar->user_id = Auth::user()->id;
        
        if ($grammar->save()) {
            $user = User::find(Auth::user()->id);
            $user->score = $user->score + 10;
            $user->grammar_total = $user->grammar_total + 1;
            $user->save();
            return response($grammar, 200);
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
    public function show($id)
    {
        return UserGrammars::where('user_id', '=', $id)->orderBy('updated_at', 'DESC')->get();
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
        $gram = UserGrammars::find($id);
        $gram->name = $request->name;
        $gram->structure_name = $request->structure_name;
        $gram->structure_description = $request->structure_description;
       
        $gram->user_id = Auth::user()->id;
    
        if ($gram->save()) {
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
        $gram = UserGrammars::find($id);
        $gram->delete();
    }
}
