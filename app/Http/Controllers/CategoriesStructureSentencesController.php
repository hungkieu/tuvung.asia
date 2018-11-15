<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CategoriesStructureSentences;

class CategoriesStructureSentencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoriesStructureSentences::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $cate = new CategoriesStructureSentences;
        $cate->name = $request->name;
        $cate->description = $request->description;
        $cate->parent_id = $request->parent_id;
        $cate->pedigree = $request->pedigree;
        $cate->user_id = Auth::user()->id;
        
        if ($cate->save()) {
            return response('create success', 200);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $cate = CategoriesStructureSentences::find($id);
        $cate->name = $request->name;
        $cate->description = $request->description;
        $cate->parent_id = $request->parent_id;
        $cate->pedigree = $request->pedigree;
        $cate->user_id = Auth::user()->id;
        $cate->save();
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
        $cate = CategoriesStructureSentences::find($id);
        $cate->delete();
    }
}
