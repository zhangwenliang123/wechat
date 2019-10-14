<?php

namespace  App\Http\Tool;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class Wechat{

 public function access_token(){

   	if (Cache::pull('access_token_key')) {
  		$access_token=Cache::push('access_token');
  		echo $access_token;
   	}else{
   		$access_toke=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET'));
   		$access_re=json_decode($access_toke,1);
   		$access_token=$access_re['access_token'];
   		$expires_in=$access_re['expires_in'];
   		Cache::put('access_token_key',$access_token,now()->addMinutes($expires_in));
   	}
   	return $access_token;
   	
   }
    /**
     * 获取用户列表
     */
    public function get_user_list(Request $request)
    {
        $app = app('wechat.official_account');
        $list = $app->user->list($nextOpenId = null);  // $nextOpenId 可选
        dd($list);
        $req = $request->all();
        $openid_info = DB::connection('mysql_cart')->table('wechat_openid')->get();
        return view('Wechat.userList',['info'=>$openid_info,'tagid'=>isset($req['tagid'])?$req['tagid']:'']);
    }

}