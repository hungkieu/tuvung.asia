<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vocabulary;
use App\User;
use Illuminate\Support\Facades\Auth;

class VocabulariesController extends Controller
{
  public function create(Request $request) {
    $vocab = new Vocabulary;
    $vocab->en = $request->en;
    $vocab->vi = $request->vi;
    $vocab->type = json_encode($request->type);
    $vocab->parent_id = $request->parent_id;

    if($request->hasFile('image'))
    {
      $vocab->image = '/storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
    }

    $vocab->user_id = Auth::user()->id;

    if($vocab->save())
    {
      $user = User::find(Auth::user()->id);
      $user->score = $user->score + 10;
      $user->save();
      return response('create success', 200);
    } else {
      return response('create failed', 400);
    }
  }

  public function update(Request $request, $id) {
    $vocab = Vocabulary::find($id);
    $vocab->en = $request->en;
    $vocab->vi = $request->vi;
    $vocab->type = json_encode($request->type);
    $vocab->parent_id = $request->parent_id;

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

  public function destroy(Request $request,$id){
    $vocab = Vocabulary::find($id);
    if(Vocabulary::where('parent_id', '=', $id)->count() == 0) {
      $vocab->delete();
      return response('delete success', 200);
    } else {
      return response('Bạn không thể xóa từ đã có từ liên kết', 302);
    }
  }

}
