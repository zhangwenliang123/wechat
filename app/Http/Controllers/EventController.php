<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tool\Wechat;
use Illuminate\Support\Facades\Cache;
use DB;
class EventController extends Controller
{
	public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }
	public function index(Request $request){
		$access_token=$this->wechat->access_token();
		// dd($access_token);
		$r=json_decode($access_token,1);
		// dd($r);
		$data=[
			'access_token'=>$access_token,
		];
		$re=DB::table('wechat')->insert($data);
		dd($re);
	}
  
}
