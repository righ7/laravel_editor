<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;


class CheckMainLogin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if(!Admin::user()) {

            $ticket = !empty($_COOKIE['ticket'])?$_COOKIE['ticket']:null;

            if(!empty($ticket)) {
                $client = new \GuzzleHttp\Client();

                $response = $client->get('http://baseinfo.youdnr.com/auth/getUser?' . http_build_query([
                        'ticket' => $ticket
                    ]));
                $result = json_decode((string)$response->getBody(), true);

                if (!empty($result['name'])) {
                    $user_name = $result['name']['name'];
                    $user = Administrator::where('user_login', $user_name)->where('user_status', 1)->first();

                    if (!empty($user)) {
                        $user_id = $user->id;
                        $this->guard()->loginUsingId($user_id);
//                        $this->guard()->login($user);
                    }
                } else {
                    return redirect('http://baseinfo.youdnr.com/login?url_type=4');
                }
            }
            else{
                return redirect('http://baseinfo.youdnr.com/login?url_type=4');
            }
        }
        return $next($request);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

}
