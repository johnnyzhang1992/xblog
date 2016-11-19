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

        $_record = [
            'from_url'      => \URL::previous(),
            'to_url'        => $request->fullUrl(),
            'session_id'    => \Session::getId(),
            'ip'            => $_ip,
            'device'        => Agent::device(),
            'os'            => Agent::platform(),
            'os_version'    => Agent::version( Agent::platform() ),
            'browser'       => Agent::browser(),
            'browser_version' => Agent::version( Agent::browser() ),
            'robot'         => null,
        ];

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

        DB::table('visitor_tracking')
            ->insert($_record);

        return $next($request);
    }
}
