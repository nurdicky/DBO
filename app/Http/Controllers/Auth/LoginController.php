<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
                          ->scopes(config('google.scopes'))
                          ->with([
                              'access_type'     => config('google.access_type'),
                              'approval_prompt' => config('google.approval_prompt'),
                          ])
                          ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect()->route('home');
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where(['provider_id' => $user->id])->first();
        if ($authUser) {
          return $authUser;
        }

        return User::create([
          'name' => $user->name,
          'email' => $user->email,
          'provider' => strtoupper($provider),
          'provider_id' => $user->id,
          'access_token'  => $user->token,
          'refresh_token' => $user->refreshToken,
          'avatar' => $user->avatar,
        ]);
    }

}
