<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\SocialAccountService;
use Illuminate\Support\Facades\Log;
use Socialite;

class SocialAuthController extends Controller
{
  public function redirect($social)
  {
    return Socialite::driver($social)->redirect();
  }

  public function callback($social)
  {
    $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
    $user->last_login = date('Y-m-d H:i:s');
    $user->save();
    auth()->login($user);

    return redirect()->to('/');
  }
}
