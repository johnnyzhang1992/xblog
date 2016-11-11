<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    protected $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function bindGithub($currentUser, $githubData)
    {
        $currentUser->github_id = $githubData['github_id'];
        $currentUser->github_name = $githubData['name'];
        if (config('app.avatar') == $currentUser->avatar)
            $currentUser->avatar = $githubData['avatar'];

        $meta = $currentUser->meta;
        $meta['github'] = $githubData['url'];
        $currentUser->meta = $meta;

        $this->userRepository->clearAllCache();

        return $currentUser->save();
    }

    public function store(Request $request)
    {
        if (!session()->has('githubData')) {
            return redirect('login');
        }

        $name = $request->get('name');
        $email = $request->get('email');
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z-_]+$/u|max:16|min:3|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.regex' => "Username can only contains letter,number or -,_",
            'name.unique' => "Username  '$name'  has been registered,if it is you,then you can login to bind your github account",
            'email.unique' => "Email  '$email'  has been registered,if it is you,then you can login to bind your github account",
        ]);

        if (mb_substr_count($request->get('name'), '_') > 1 || mb_substr_count($request->get('name'), '-') > 1) {
            return back()->withInput()->withErrors("name's '-' and '_' max count is 1.");
        }

        $githubData = session('githubData');
        $user = new User();
        $user->name = $name;
        $user->email = $githubData['email'];
        $user->avatar = config('app.avatar');
        $user->register_from = 'github';
        $user->password = bcrypt($request->get('password'));
        if ($this->bindGithub($user, $githubData)) {
            auth()->loginUsingId($user->id);
            session()->forget('githubData');
            return redirect()->route('post.index')->with('success', '使用Github注册成功');
        } else {
            session()->forget('githubData');
            return redirect()->route('post.index')->with('success', '使用Github注册失败');
        }
    }

    public function registerFromGithub()
    {
        if (!session()->has('githubData')) {
            return redirect('login');
        }
        $githubData = array_merge(session('githubData'), request()->old());
        return view('auth.github_register', compact('githubData'));
    }


    public function handleGithubCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        $user = User::where('github_id', $githubUser->id)->first();

        /*用户已经登陆*/
        if (auth()->check()) {
            $currentUser = auth()->user();
            /*当前用户已经绑定了Github账号*/
            if ($currentUser->github_id) {
                /*绑定的Github账号和返回的Github账号一致，直接返回，不用理会*/
                if ($currentUser->github_id == $githubUser->id) {
                    return redirect()->route('post.index');
                } /*绑定的Github账号和返回的Github账号不一致，返回错误信息*/
                else {
                    return redirect()->route('post.index')->withErrors('Sorry,you have bind a different github account!');
                }
            } /*当前用户没有绑定Github账号，试图绑定*/
            else {
                /*返回的Github账号已经被绑定了，返回错误信息*/
                if ($user) {
                    return redirect()->route('post.index')->withErrors('Sorry,this github account has been bind to another account,is that you?');
                } /*返回的Github账号没有被绑定，正常绑定*/
                else {
                    if ($this->bindGithub($currentUser, $this->getDataFromGithubUser($githubUser))) {
                        return redirect()->route('post.index')->with('success', '绑定 Github 成功');
                    }
                    return redirect()->route('post.index')->withErrors('绑定 Github 失败');
                }
            }
        } /*用户没有登陆*/
        else {
            /*让绑定的用户直接登陆*/
            if ($user) {
                auth()->loginUsingId($user->id);
                return redirect()->route('post.index')->with('success', '登录成功');
            } /*一个全新的用户来了！！！尝试注册*/
            else {
                $githubData = $this->getDataFromGithubUser($githubUser);
                session()->put('githubData', $githubData);
                return redirect()->route('github.register');
            }
        }
    }

    private function getDataFromGithubUser($githubUser)
    {
        $githubData['github_id'] = $githubUser->id;
        $githubData['email'] = $githubUser->email;
        $githubData['avatar'] = $githubUser->avatar;
        $githubData['name'] = $githubUser->nickname;
        $githubData['url'] = $githubUser->user['html_url'];
        return $githubData;
    }
}
