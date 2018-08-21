<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;

use Socialite;

use App\User;

class LoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
                        ->scopes(config('google.scopes'))
                        ->with([
                            'access_type'     => config('google.access_type'),
                            'approval_prompt' => config('google.approval_prompt'),
                        ])
                        ->redirect();
    }

    public function callback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect('/');
        }

        /**
         * @var \Laravel\Socialite\Two\User $user
         */
        $user = Socialite::driver('google')->user();

        // $dataUser = User::where('email', $user->email)->first();
        // if(@$dataUser->last_login == null){
        $last_login = auth()->user()->id;
        //     $loginUser = User::Create([
        //             'name'          => $user->name,
        //             'email'         => $user->email,
        //             'access_token'  => $user->token,
        //             'refresh_token' => $user->refreshToken,
        //             'last_login'    => $last_login,
        //         ]);

        // }
        // else{
        //     $loginUser = $dataUser;
        // }

        $loginUser = User::updateOrCreate(
            [
                'email' => $user->email,
            ],
            [
                'name'          => $user->name,
                'email'         => $user->email,
                'access_token'  => $user->token,
                'refresh_token' => $user->refreshToken,
                'last_login'    => $last_login,
            ]);

        auth()->login($loginUser, false);
        //$authUser = $this->findOrCreateUser($user);
        //Auth::login($authUser, true);

        return redirect('/sheets');
    }

    public function findOrCreateUser($user)
    {
        $authUser = User::where(['provider_id' => $user->id])->first();
        if ($authUser) {
            return $authUser;
        }

        return User::create([
          'name' => $user->name,
          'email' => $user->email,
          'provider_id' => $user->id,
          'access_token'  => $user->token,
          'refresh_token' => $user->refreshToken,
          'avatar' => $user->avatar,
        ]);
    }


    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }
}
