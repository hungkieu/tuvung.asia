<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vocabulary;
use App\User;
use Illuminate\Support\Facades\Auth;

class vocabulariesController extends Controller
{
  public function create(Request $request) {
    $vocab = new Vocabulary;
    $vocab->en = $request->en;
    $vocab->vi = $request->vi;
    $vocab->type = json_encode($request->type);

    if($request->hasFile('image'))
    {
      $vocab->image = '/storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
    }

    $vocab->user_id = Auth::user()->id;

    if($vocab->save())
    {
      return response('create success', 200);
    } else {
      return response('create failed', 400);
    }
  }
}
