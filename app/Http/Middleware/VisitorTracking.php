<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Support\Facades\Auth;
use Agent;
use Config;
use Route;
use Request;

class VisitorTracking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->ajax() || $request->wantsJson()) {
            return $next($request);
        }

        $_ip = $request->ip();
        if($_ip && is_string($_ip) && is_array(config('seo.exclude.ip')) && in_array($_ip, config('seo.exclude.ip'))) {
            return $next($request);
        }
        if(Auth::check()){
            $_name = auth()->user()->name;
            if($_name && is_array(config('seo.exclude.name')) && in_array($_name, config('seo.exclude.name'))) {
                return $next($request);
            }
        }else{

        }

        $_record = [
            'from_url'      => substr(\URL::previous(),0,255),
            'to_url'        => substr($request->fullUrl(),0,255),
            'session_id'    => \Session::getId(),
            'ip'            => $_ip,
            'device'        => Agent::device(),
            'os'            => Agent::platform(),
            'os_version'    => Agent::version( Agent::platform() ),
            'browser'       => Agent::browser(),
            'browser_version' => Agent::version( Agent::browser() ),
            'robot'         => null,
            'created_at'   =>date("Y-m-d H:i:s")
        ];
        // 设备类型
        if(Agent::isMobile()){
            $_record['device'] = Agent::device().'-Mobile';
        }else if(Agent::isTablet()){
            $_record['device'] = Agent::device().'-Tablet';
        }else if(Agent::isDesktop()){
            $_record['device'] = Agent::device().'-Desktop';
        }else{
            $_record['device'] = Agent::device();
        }
        if(Agent::isRobot()) {
            $_record['robot'] = Agent::robot();
        }

        if(DB::table('visitor_tracking')->where('session_id', $_record['session_id'])->first()) {
            // do nothing
        } else {
//            $_record['geoinfo'] = \json_encode(geoip_record_by_name($_SERVER['REMOTE_ADDR']));
//            $_record['geoinfo'] = '';
        }

        if(Auth::check()) {
            $_record['username'] = auth()->user()->name;
            $_record['email'] = auth()->user()->email;
        } else {
            $_record['username'] = '游客';
            $_record['email'] = '';
        }
        if(!$_record['robot']){
            DB::table('visitor_tracking')
                ->insert($_record);
        }


        return $next($request);
    }
}
