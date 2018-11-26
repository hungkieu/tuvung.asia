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
  public function test() {
    // $ch = curl_init();
    // $url = 'https://www.bing.com/images/async?q=dog&first=1&count=5&relp=5&scenario=ImageBasic&datsrc=N_I&layout=RowBased&mmasync=1&dgState=x*0_y*0_h*0_c*4_i*106_r*21&IG=73D606F821F348A1A73B7D0AABEE00BC&SFX=4&iid=images.5653';
    // curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $html = curl_exec($ch);
    // curl_close($ch);
    // preg_match_all('/<img class="mimg"(.*?)src="(.*?)" ?(.*?)>/', $html, $matches);
    // foreach ($matches[2] as $key => $value) {
    //   echo $value.'</br>';
    // }

    $ch = curl_init();
    $url = 'https://fptshop.com.vn/may-tinh-xach-tay/dell-xps15-i7-8750h';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($ch);
    curl_close($ch);
    preg_match_all('/<ul class="fs-dttsktul"(.*?)>((.|\n)*?)<\/ul>/', $html, $matches);
    print_r($matches);
  }
}
