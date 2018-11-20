<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Vocabulary;
use App\User;

class vocabulariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return Vocabulary::where('user_id', '=', $id)->get();
    }

    public function all()
    {
        return DB::table('users')
            ->join('vocabularies', 'users.id', '=', 'vocabularies.user_id')
            ->select('vocabularies.*', 'users.name')
            ->get();
    }

    public function search($en)
    {
        if($en == 'all')
            return Vocabulary::where('image', '!=', null)->get();
        return Vocabulary::where('en', 'like', '%'.$en.'%')->where('image', '!=', null)->limit(10)->get();
    }

    public function pedigree($id)
    {
        $vocabularies = Vocabulary::where('pedigree', 'like', '%'.$id.'%')->get();
        $vocabulary = Vocabulary::find($id);
        return ["vocabulary" => $vocabulary, "vocabularies" => $vocabularies];
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
        return Vocabulary::find($id);
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
        //
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

    public function count($id)
    {
        return Vocabulary::where('user_id', '=', $id)->count();
    }
}
