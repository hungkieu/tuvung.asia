<?php

namespace App\Http\Controllers;

use App\HistoryScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryScoreController extends Controller
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
     * @param  \App\HistoryScore  $historyScore
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return HistoryScore::where('user_id', Auth::user()->id)
            ->orderBy('day', 'desc')
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HistoryScore  $historyScore
     * @return \Illuminate\Http\Response
     */
    public function edit(HistoryScore $historyScore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HistoryScore  $historyScore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HistoryScore $historyScore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HistoryScore  $historyScore
     * @return \Illuminate\Http\Response
     */
    public function destroy(HistoryScore $historyScore)
    {
        //
    }
}
