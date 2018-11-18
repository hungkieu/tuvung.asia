<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\StructureSentences;
use App\User;

class StructureSentencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        include(app_path() . '\Http\HtmlDomParser.php');
        $url = 'https://efc.edu.vn/ngu-phap-tieng-anh';
        $html = file_get_html($url);
        // $get_html = file_get_html($url);
        //     $html = html_entity_decode($get_html);
        // if (function_exists('file_get_html')) {
        //     $get_html = file_get_html($url);
        //     $html = html_entity_decode($get_html);
        // } else {
        //     $html = "not get file_get_html";
        // }
        
        $e = '';
        foreach ($html->find('.td-block-span6') as $element) {
            $e = $e.$element;
        }
        return $e;
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function indexAdmin()
    {
        return StructureSentences::all();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $arr = $request->list;
        for ($i = 0; $i < count($arr); $i++) {
            $struc = new StructureSentences;
            $struc->structure = $arr[$i]["structure"];
            $struc->description = $arr[$i]["description"];
            // $struc->examples = $arr[$i]["examples"];
            // $struc->image = $arr[$i]["image"];
            $struc->category_id = $arr[$i]["category_id"];
            $struc->user_id = Auth::user()->id;
            $struc->save();
        };
        return $arr;
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
        //
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
        $struc = StructureSentences::find($id);
        $struc->structure = $request->structure;
        $struc->description = $request->description;
        $struc->category_id = $request->category_id;
        $struc->user_id = Auth::user()->id;
        $struc->save();
        return $struc;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gram = StructureSentences::find($id);
        $gram->delete();
    }
}
