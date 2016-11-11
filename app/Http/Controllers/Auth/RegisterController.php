<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z-_]+$/u|max:16|min:3|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ],[
            'name.regex' => "Username can only contains letter,number or -,_",
        ]);

        if (mb_substr_count($request->get('name'), '_') > 1 || mb_substr_count($request->get('name'), '-') > 1) {
            return back()->withInput()->withErrors("name's '-' and '_' max count is 1.");
        }

        auth()->login($this->create($request->all()));

        $this->userRepository->clearCache();

        return redirect()->route('post.index');
    }


    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => config('app.avatar')
        ]);
    }
}
