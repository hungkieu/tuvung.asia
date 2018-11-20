<?php

namespace App\Http\Controllers;

use App\SuggestImage;
use Illuminate\Http\Request;

class SuggestImageController extends Controller
{
    public function search($q) {
        if(isset($q) || $q != '') {
            $result = SuggestImage::where('q', 'like', '%'.$q.'%')->get();
            if(count($result) < 5) {
                include(app_path() . '/Http/HtmlDomParser.php');
                $url = 'https://www.bing.com/images/async?q='.$q.'&first=&count=35&relp=35&scenario=ImageBasic&datsrc=N_I&layout=RowBased&mmasync=1&dgState=x*0_y*0_h*0_c*4_i*106_r*21&IG=73D606F821F348A1A73B7D0AABEE00BC&SFX=4&iid=images.5653';
                $html = file_get_html($url);

                $arr = array();
                foreach($html->find('img') as $element) {
                    $arr[] = $element->src;
                }

                if(count($arr) < 5) {
                    $coll = Vocabulary::where('en', 'like', '%'.$en.'%')->where('image', '!=', null)->get();
                    $arr = $coll->toArray();
                    for($i = 0; $i < count($arr); $i++) {
                        $suggestImage = new SuggestImage;
                        $suggestImage->q = $arr[$i]['en'];
                        $suggestImage->url = $arr[$i]['image'];
                        $suggestImage->save();
                    }
                } else {
                    for($i = 0; $i < count($arr); $i++) {
                        $suggestImage = new SuggestImage;
                        $suggestImage->q = $q;
                        $suggestImage->url = $arr[$i];
                        $suggestImage->save();
                    }
                }
                $result = SuggestImage::where('q', 'like', '%'.$q.'%')->get();
            }
            return $result;
        } else {
            return SuggestImage::take(25)->get();
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SuggestImage::take(25)->get();
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
     * @param  \App\SuggestImage  $suggestImage
     * @return \Illuminate\Http\Response
     */
    public function show(SuggestImage $suggestImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SuggestImage  $suggestImage
     * @return \Illuminate\Http\Response
     */
    public function edit(SuggestImage $suggestImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SuggestImage  $suggestImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SuggestImage $suggestImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SuggestImage  $suggestImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuggestImage $suggestImage)
    {
        //
    }
}
