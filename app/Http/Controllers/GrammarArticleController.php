<?php

namespace App\Http\Controllers;

// namespace Ammadeuss\LaravelHtmlDomParser;
// use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Http\Request;
use App\GrammarArticle;

// use App\Http\HtmlDomParser;

class GrammarArticleController extends Controller
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
        $html = '';
        if (function_exists('file_get_html')) {
            $get_html = file_get_html($url);
            $html = html_entity_decode($get_html);
        } else {
            $html = "not get file_get_html";
        }
        
        return dd($html);
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
}
