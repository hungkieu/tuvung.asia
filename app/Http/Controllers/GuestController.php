<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class GuestController extends Controller
{
  public function register(Request $request) {
    $user = User::findOrFail(Auth::user()->id);
    $user->fill($request->all());
    $user->role = 1;
    $user->password = bcrypt($request->password);
    $user->save();
    Auth::logout();
    return redirect()->route('login');
  }
}
