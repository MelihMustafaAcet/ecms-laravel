<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Sliders;
use Illuminate\Http\Request;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;


class DefaultController extends Controller
{
    public function index(){
        $data['blog']=Blogs::all()->sortBy('blog_must');
        $data['slider']=Sliders::all()->sortBy('slider_must');
        $client = new CoinGeckoClient();
        $data['bitco']= $client->simple()->getPrice('bitcoin', 'try');
        return view('frontend.default.index')->with('data',$data);
    }
    public function contact(){
        return view('frontend.default.contact');
    }
}
