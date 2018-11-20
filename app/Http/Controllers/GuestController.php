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
    include(app_path() . '/Http/HtmlDomParser.php');
    $url = 'https://www.bing.com/images/async?q=dog&first=&count=35&relp=35&scenario=ImageBasic&datsrc=N_I&layout=RowBased&mmasync=1&dgState=x*0_y*0_h*0_c*4_i*106_r*21&IG=73D606F821F348A1A73B7D0AABEE00BC&SFX=4&iid=images.5653';
    $html = file_get_html($url);
    foreach($html->find('img') as $element) {
      // echo '<img src="'.$element->src.'" /><br>';
      echo $element->src.'<br>';
    }
  }
}
