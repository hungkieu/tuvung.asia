<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vocabulary;
use App\User;
use App\HistoryScore;
use Illuminate\Support\Facades\Auth;

class VocabulariesController extends Controller
{
    public function create(Request $request)
    {
        if (Auth::check()) {
            $vocab = new Vocabulary;
            $vocab->en = ucfirst($request->en);
            $vocab->vi = ucfirst($request->vi);
            $vocab->type = implode(",", $request->type);
            $vocab->parent_id = $request->parent_id;

            if ($request->parent_id != 0) {
                $parent = Vocabulary::find($request->parent_id);
            } else {
                $parent = new Vocabulary;
            }
            $pedigree = explode(",", $parent->pedigree);
            array_push($pedigree, $vocab->parent_id);
            $vocab->pedigree = implode(",", $pedigree);

            if ($request->import_image == 'true') {
                $url = basename($request->import_image_url);
                if (file_exists(public_path($request->import_image_url))) {
                    copy(public_path($request->import_image_url), public_path('/storage/images/'.$url.'.jpeg'));
                    $vocab->image = '/storage/images/'.$url.'.jpeg';
                } else {
                    $vocab->image = $request->import_image_url;
                }
            } else {
                if ($request->hasFile('image')) {
                    $vocab->image = '/storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
                }
            }

            $vocab->user_id = Auth::user()->id;

            if ($vocab->save()) {
                $user = User::find(Auth::user()->id);
                $user->score = $user->score + 50;
                $user->vocabulary_total = $user->vocabulary_total + 1;
                $target_score = $user->target_score;
                $user->save();

                $hs = HistoryScore::where('day', date('Y-m-d'))->where('user_id', Auth::user()->id)->first();
                if (count($hs) == 0) {
                    $hs = new HistoryScore;
                }
                $hs->day = date('Y-m-d');
                $hs->user_id = Auth::user()->id;
                $hs->score += 50;
                if ($hs->score >= $target_score && $target_score > 0) {
                    $hs->streak = true;
                }
                $hs->save();
                return response($vocab, 200);
            } else {
                return response('create failed', 400);
            }
        } else {
            return response('Login failed', 422);
        }
    }

    public function update(Request $request, $id)
    {
        $vocab = Vocabulary::find($id);
        $vocab->en = $request->en;
        $vocab->vi = $request->vi;
        $vocab->type = implode(",", $request->type);
        $vocab->parent_id = $request->parent_id;

        if ($request->import_image == 'true') {
            $url = basename($request->import_image_url);
            if (file_exists(public_path($request->import_image_url))) {
                copy(public_path($request->import_image_url), public_path('/storage/images/'.$url.'.jpeg'));
                $vocab->image = '/storage/images/'.$url.'.jpeg';
            } else {
                $vocab->image = $request->import_image_url;
            }
        } else {
            if ($request->hasFile('image')) {
                $vocab->image = '/storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
            }
        }

        $vocab->user_id = Auth::user()->id;

        if ($vocab->save()) {
            return response('create success', 200);
        } else {
            return response('create failed', 400);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $vocab = Vocabulary::find($id);
        if (Vocabulary::where('parent_id', '=', $id)->count() == 0) {
            $vocab->delete();
            return response('Xóa thành công', 200);
        } else {
            return response('Bạn không thể xóa từ đã có từ liên kết', 400);
        }
    }

    public function practice(Request $request)
    {
        $vocab = Vocabulary::find($request->id);
        $vocab->last_practice = date("Y-m-d H:i:s");
        if ($vocab->save()) {
            return response('success', 200);
        } else {
            return response('error', 302);
        }
    }
}
