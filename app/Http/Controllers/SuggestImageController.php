<?php

namespace App\Http\Controllers;

use App\SuggestImage;
use Illuminate\Http\Request;
use App\Vocabulary;

class SuggestImageController extends Controller
{
    public function search($q) {
        if(isset($q) || $q != '') {
            $result = SuggestImage::where('q', 'like', '%'.$q.'%')->limit(15)->get();
            if(count($result) < 5) {
                $ch = curl_init();
                $url = 'https://www.bing.com/images/async?q='.$q.'&first=2&count=15&relp=15&cw=1351&ch=150&scenario=ImageBasic&datsrc=N_I&layout=RowBased&mmasync=1&dgState=x*0_y*0_h*0_c*5_i*36_r*7&IG=32306E87D43A4486B5CE81DC981EC1E4&SFX=2&iid=images.5653';
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $html = curl_exec($ch);
                curl_close($ch);
                preg_match_all('/<img class="mimg"(.*?)src="(.*?)" ?(.*?)>/', $html, $matches);

                $arr = $matches[2];

                if(count($arr) < 5) {
                    $coll = Vocabulary::where('en', 'like', '%'.$q.'%')->where('image', '!=', null)->get();
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
                $result = SuggestImage::where('q', 'like', '%'.$q.'%')->limit(15)->get();
            }
            return $result;
        } else {
            return SuggestImage::take(15)->orderBy('created_at', 'desc')->get();
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SuggestImage::take(15)->orderBy('created_at', 'desc')->get();
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
